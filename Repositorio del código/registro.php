<?php
require_once 'config/config.php';
require_once 'config/db.php';
require_once 'config/cliente_funciones.php';
$db = new db();
$conexion = $db->conexion();

$errors = [];

if (!empty($_POST)) {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);
    $direccion = trim($_POST['direccion']);

    if (esNulo([$nombres, $apellidos, $email, $telefono,$direccion, $usuario, $password, $repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (usuarioExiste($usuario, $conexion)) {
        $errors[] = "El nombre de $usuario ya existe";
    }

    if (emailExiste($email, $conexion)) {
        $errors[] = "El correo electronico $email ya existe";
    }

    if (count($errors) == 0) {
        $id = registraCliente([$nombres, $apellidos, $email, $telefono, $direccion], $conexion);

        if ($id > 0) {

            require 'config/Mailer.php';
            $mailer = new Mailer();
            $token = generarToken();
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);

            $idUsuario = registraUsuario([$usuario, $pass_hash, $token, $id], $conexion);
            if ($idUsuario > 0) {

                $url = SITE_URL . '/activa_cliente.php?id=' . $idUsuario . '&token=' . $token;
                $asunto = "Activar Cuenta - Visenzzo";
                $cuerpo = " Estimado $nombres: <br> Para continuar con el proceso de registro es indispensable de click
            en la siguiente liga <a href='$url'>Activar cuenta</a> ";


                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "Para terminar el proceso de registro siga  las intruciones que le hemos enviado a la
                    direcion de correo electronico $email";

                    exit;
                }
            } else {
                $errors[] = "Error al registrar cliente";
            }
        } else {
            $errors[] = "Error al registrar cliente";
        }
    }
}

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/asset/css/estilos.css">
    <link rel="stylesheet" href="/asset/css/carrito.css">

</head>



<div class="wrapper">
        <header class="header-mobile">
        <a href="index.php">
            <img class="logo" src="/asset/img/logo.png" alt="">
        </a>
        
                                <a class="boton-menu boton-menu-mobile" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i></span></a>

            <button class="open-menu" id="open-menu">
                <i class="fa-solid fa-bars"></i>
            </button>

        </header>
    <aside>
        <button class="close-menu" id="close-menu">
            <i class="fas fa-times"></i>
        </button>
        <header>
            <a href="index.php">
                <img class="logo" src="/asset/img/logo.png" alt="">
            </a>
        </header>

        <nav>
            <ul class="menu ">
                <li>
                    <a href="index.php" class="boton-menu  active"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li>
                    <a href="productos.php" class="boton-menu "><i class="fas fa-cubes"></i> Productos</a>
                </li>
                <li>
                    <a href="contacto.php" class="boton-menu"><i class="fas fa-envelope"></i> Contacto</a>
                </li>
                <li>
                    <a href="carrito.php" class="boton-menu"><i class="fas fa-shopping-cart"></i> Carrito <span id="numerito" class="numerito">0</span></a>
                </li>
                <!-- Sección para manejar el estado de inicio de sesión -->
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <li>
                        <div class="dropdown">
                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btn_session">
                                <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </li>
                <?php } else { ?>
                    <li>
                        <a href="login.php" class="btn btn-success"><i class="fas fa-user"></i> Ingresar</a>
                    </li>
                <?php } ?>
                <!-- Fin de la sección de inicio de sesión -->
            </ul>
        </nav>

        <footer>
            <p class="texto-footer">© Todos los derechos de esta página son atribuidos a Visenzzo.</p>
        </footer>
    </aside>
    <main>
        <div class="container">
            <h2>Datos del cliente</h2>

            <?php mostrarMensajes($errors); ?>

            <form class="row g-3" action="registro.php" method="post" autocomplete="off">
                <div class="col-md-6">
                    <label for="nombres"><span class="text-danger">*</span> Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos"><span class="text-danger">*</span> Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="email"><span class="text-danger">*</span> Correo electronico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <span id="validaEmail" class="text-danger"></span>
                </div>
                <div class="col-md-6">
                    <label for="telefono"><span class="text-danger">*</span> Telefono</label>
                    <input type="tel" name="telefono" id="telefono" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="usuario"><span class="text-danger">*</span> Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                    <span id="validaUsuario" class="text-danger"></span>
                </div>

                <div class="col-md-6">
                    <label for="password"><span class="text-danger">*</span> Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="repassword"><span class="text-danger">*</span> Repetir contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>


            <div class="col-md-6">
                <label for="direccion"><span class="text-danger">*</span>Dirección Completa</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
            </div>

                <i><b>Nota: </b> Los campos con asteriscos son obligatorios</i>
                <i><b>Nota: </b>La dirección que ponga es donde le llegara los envios posteriormente</i>

                <div class="col-md-12">
                    <button type="submit" class="btn ">Registrar</button>
                </div>
            </form>
        </div>


    </main>

</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="/asset/js/producto.js"></script>
<script src="/asset/js/menu.js"></script>

<script>
    let txtUsuario = document.getElementById('usuario')
    txtUsuario.addEventListener("blur", function() {
        existeUsuario(txtUsuario.value)
    }, false)

    let txtEmail = document.getElementById('email')
    txtEmail.addEventListener("blur", function() {
        existeEmail(txtEmail.value)
    }, false)

    function existeUsuario(email) {

        let url = "config/clienteAjax.php"
        let formData = new FormData()
        formData.append("action", "existeEmail")
        formData.append("email", email)

        fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {

                if (data.ok) {
                    document.getElementById('email').value = ''
                    document.getElementById('validaEmail').innerHTML = 'Email no disponible'
                } else {
                    document.getElementById('validaEmail').innerHTML = ''
                }

            })
    }

    function existeUsuario(usuario) {

        let url = "config/clienteAjax.php"
        let formData = new FormData()
        formData.append("action", "existeUsuario")
        formData.append("usuario", usuario)

        fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {

                if (data.ok) {
                    document.getElementById('usuario').value = ''
                    document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible'
                } else {
                    document.getElementById('validaUsuario').innerHTML = ''
                }

            })
    }
</script>



</script>

</body>

</html>