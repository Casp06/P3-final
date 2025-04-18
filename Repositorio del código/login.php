<?php

session_start();

require_once 'config/config.php';

require_once 'config/db.php';

require_once 'config/cliente_funciones.php';

$db = new db();

$conexion = $db->conexion();



$proceso = isset($_GET['pago']) ? 'pago' : 'login';



$errors = [];



if (!empty($_POST)) {



    $usuario = trim($_POST['usuario']);

    $password = trim($_POST['password']);

    $proceso = $_POST['proceso'] ?? 'login';



    if (esNulo([$usuario,$password])) {

        $errors[] = "Debe llenar todos los campos";

    }



    if (count($errors) == 0) {

        $errors[] = login($usuario, $password, $conexion, $proceso);

    }



}











?>



<!doctype html>

<html lang="es">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Visenzzo</title>

    <link rel="shortcut icon" type="image/x-icon" href="asset/img/favicon.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="asset/css/estilos.css">

    <link rel="stylesheet" href="asset/css/carrito.css">

    <meta name="google-site-verification" content="uyordqPrX9FGsmvMj9bVNiE1Fg29oGwxdhhi_CXX3yo" />



</head>







    <div class="wrapper">

        <header class="header-mobile">

        <a href="index.php">

            <img class="logo" src="asset/img/logo.png" alt="">

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

                <img class="logo" src="asset/img/logo.png" alt="">

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

        <main class="d-flex justify-content-center ">

    <div class="form-login pt-4">

        <h2>Iniciar sesión</h2>



        <?php mostrarMensajes($errors); ?>



        <form class="row g-3" action="login.php" method="post" autocomplete="off">



        <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">



            <div class="form-floating">

                <input class="form-control" type="text" name="usuario" id="usuario" placeholder=" Usuario" required>

                <label for="usuario">Usuario</label>

            </div>



            <div class="form-floating">

                <input class="form-control" type="password" name="password" id="password" placeholder=" Contraseña" required>

                <label for="password">Contraseña</label>

            </div>



            <div class="col-12">

                <a href="recupera.php">¿Olvidaste tu contraseña?</a>

            </div>



            <div class="d-grid gap-3 col-12">

                <button type="submit" class="btn btn-primary">Ingresar</button>

            </div>



            <hr>



            <div class="col-12">

                ¿No tiene cuenta? <a href="registro.php">Registrate aqui</a>

            </div>



        </form>

    </div>

</main>





    </div>







    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="asset/js/producto.js"></script>

    <script src="asset/js/menu.js"></script>



</body>

</html>