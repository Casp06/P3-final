<?php
require_once 'config/config.php';
require_once 'config/db.php';
require_once 'config/cliente_funciones.php';
$db = new db();
$conexion = $db->conexion();

$errors = [];

if (!empty($_POST)) {

    $email = trim($_POST['email']);

    if (esNulo([$email])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!esEmail($email)) {
        $errors[] = "La direccion de correo no es valida";
    }

    if (count($errors) == 0) {
        if (emailExiste($email, $conexion)) {
            $sql = $conexion->prepare("SELECT usuarios.id, clientes.nombres
            FROM usuarios
            INNER JOIN clientes ON usuarios.id_cliente = clientes.id
            WHERE clientes.email LIKE ? LIMIT 1
            ");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $token = solicitaPassword($user_id, $conexion);

            if ($token !== null) {
                require_once 'config/Mailer.php';
                $mailer = new Mailer(); 

                $url = SITE_URL . '/reset_password.php?id='.$user_id . '&token='. $token;

                $asunto = "Recuperar password - Visenzzo";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de tu contraseña da clic en el 
                siguiente link <a href='$url'>$url</a>.";
                $cuerpo .= "<br>Si no hiciste esta solicitud puedes ingnorar este correo.";
    
                if ($mailer->enviarEmail($email, $asunto, $cuerpo)) {
                    echo "<p><b>Correo enviado</b></p>";
                    echo "<p>Hemos enviado un correo electronico a la direcion $email para restablecer la 
                    contraseña</p>";

                    exit;
                }
            }

        } else {
            $errors[] = "No existe una cuenta asociada a esta direccion de correo electronico";
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
            <i class="fa-solid fa-xmark"></i>
        </button>
        <header>
            <a href="index.php">
                <img class="logo" src="/asset/img/logo.png" alt="">
            </a>
        </header>

        <nav>
            <ul class="menu">
                <li>
                    <button id="todos" class="boton-menu boton-categoria active"><i class="fa-solid fa-hand-point-right"></i>Todos los
                        productos</button>
                </li>

                <li>
                    <a class="boton-menu boton-carrito" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>Carrito <span id="numerito" class="numerito">0</span></a>
                </li>
            </ul>
        </nav>

        <footer>
            <p class="texto-footer">© Todos los derechos de esta pagina son atribuidos a Visenzzo.</p>
        </footer>

    </aside>
    <main class="d-flex justify-content-center">
        <div class="form-login pt-4">
            <h3>Recuperar contraseña</h3>

            <?php mostrarMensajes($errors); ?>

            <form action="recupera.php" method="post" class="row g-3" autocomplete="off">

                <div class="form-floating">
                    <input class="form-control" type="email" name="email" id="email" placeholder=" Correo electronico" required>
                    <label for="email">Correo electronico</label>
                </div>

                <div class="d-grid gap-3 col-12">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </div>


                <div class="col-12">
                    ¿No tiene cuenta? <a href="registro.php">Registrate aqui</a>
                </div>
            </form>
        </div>


    </main>

</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="/asset/js/producto.js"></script>
<script src="/asset/js/menu.js"></script>

</body>

</html>