<?php
require_once 'config/config.php';
require_once 'config/db.php';
require_once 'config/cliente_funciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if ($user_id == '' || $token == '') {
    header("Location: productos.php");
    exit;
}

$db = new db();
$conexion = $db->conexion();

$errors = [];


if (!verificaTokenRequest($user_id,$token, $conexion)) {
    
    echo $token;
    echo " No se pudo verificar la informacion ";
    echo $user_id;
    exit;
}

if (!empty($_POST)) {

    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if (esNulo([$user_id,$token,$password,$repassword])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!validaPassword($password, $repassword)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (count($errors) == 0) {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        if (actualizaPassword($user_id,$pass_hash, $conexion)) {
            echo "Contraseña modificada.<br><a href='login.php'>Iniciar sesion</a>";
            exit;
        } else {
            $errors[] = "Error al modificar contraseña.<br> Intentelo nuevamente";
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
            <h3>Cambiar contraseña</h3>

            <?php mostrarMensajes($errors); ?>

            <form action="reset_password.php" method="post" class="row g-3" autocomplete="off">
                

            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id ?>" />
            <input type="hidden" name="token" id="token" value="<?php echo $token ?>" />


                <div class="form-floating">
                    <input class="form-control" type="password" name="password" id="password"
                     placeholder="Nueva Contraseña" required>
                    <label for="password">Nueva Contraseña</label>
                </div>

                <div class="form-floating">
                    <input class="form-control" type="password" name="repassword" id="repassword"
                     placeholder="Confirmar Contraseña" required>
                    <label for="repassword">Confirmar Contraseña</label>
                </div>

                <div class="d-grid gap-3 col-12">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </div>


                <div class="col-12">
                    <a href="login.php">Iniciar sesion</a>
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