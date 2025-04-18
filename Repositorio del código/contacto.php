<?php

session_start();

require_once 'config/config.php';

require_once 'config/db.php';

require_once 'config/Mailer.php'; // Ajusta la ruta según la ubicación de tu archivo Mailer.php



$db = new db();

$conexion = $db->conexion();



$proceso = isset($_GET['pago']) ? 'pago' : 'login';



$errors = [];

$mensajeExito = "";



if (!empty($_POST)) {

    $nombre = trim($_POST['name']);

    $email = trim($_POST['email']);

    $mensaje = trim($_POST['mensaje']);



    if (empty($nombre) || empty($email) || empty($mensaje)) {

        $errors[] = "Debe llenar todos los campos";

    }



    if (empty($errors)) {

        $asunto = "Nuevo mensaje de contacto";



        $cuerpo = "Nombre: $nombre\nCorreo Electrónico: $email\nMensaje: $mensaje";



        $mailer = new Mailer();

        if ($mailer->enviarEmail(MAIL_USER, $asunto, $cuerpo)) {

            $mensajeExito = "Mensaje enviado correctamente. Te responderemos a la brevedad.";

        } else {

            $errors[] = "Error al enviar el mensaje. Inténtalo de nuevo más tarde.";

        }

    }

}

?>



<!doctype html>

<html lang="es">



<head>

    <link rel="shortcut icon" type="image/x-icon" href="asset/img/favicon.ico" />

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Visenzzo</title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="asset/css/estilos.css">

    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="asset/css/carrito.css">

    <link rel="stylesheet" href="asset/css/estilos.css">

</head>



<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>



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

                <i class="fa-solid fa-xmark"></i>

            </button>

            <header class="d-flex">

                <?php if (isset($_SESSION['user_id'])) { ?>

                    <div class="dropdown">

                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" 

                        id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">

                            <i class="fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?>

                        </button>

                        <ul class="dropdown-menu" aria-labelledby="btn_session">

                            <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>

                            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>

                        </ul>

                    </div>

                <?php } else { ?>

                    <a href="login.php" class="btn btn-success"><i class="fa-solid fa-user"></i> Ingresar</a>

                <?php } ?>

                <a href="index.php">

                    <img class="logo" src="asset/img/logo.png" alt="">

                </a>

            </header>

            <nav>

                <ul class="menu">

                    <li>

                        <a href="index.php" class="boton-menu"><i class="fas fa-home"></i> Inicio</a>

                    </li>

                    <li>

                        <a href="productos.php" class="boton-menu "><i class="fas fa-cubes"></i> Productos</a>

                    </li>

                    <li>

                        <a href="contacto.php" class="boton-menu"><i class="fas fa-envelope"></i> Contacto</a>

                    </li>

                    <li>

                        <a class="boton-menu boton-carrito" href="carrito.php"><i class="fa-solid fa-cart-shopping"></i>Carrito <span id="numerito" class="numerito">0</span></a>

                    </li>

                </ul>

            </nav>

            <footer>

                <p class="texto-footer">© Todos los derechos de esta página son atribuidos a Visenzzo.</p>

            </footer>

        </aside>

        <main>

            <div class="company-description">

            </div>

            <div class="col-md-8 mx-auto d-block">

<form action="" method="POST" class="form-contacto">

        <h2>Contacto</h2>

        <div class="input-group">

            <label class="label " for="name">Nombre</label>

            <input class="input-tex col-md" type="text" name="name" id="name" placeholder="Nombre" required>



            <label class="label" for="email">Correo Electrónico:</label>

            <input class="input-tex" type="email" id="email" name="email" placeholder="Correo" required>



            <label class="label" for="mensaje">Mensaje:</label>

            <textarea class="input-tex" id="mensaje" name="mensaje" rows="5" placeholder="Mensaje" required></textarea>



            <div class="form-txt">

                <a href="#">Politica de privacidad</a>

                <a href="#">Terminos y condiciones</a>

            </div>

            <input class="btn" type="submit" value="Enviar">

        </div>

    </form>



    <?php

    if (!empty($errors)) {

        echo '<div class="alert alert-danger">';

        foreach ($errors as $error) {

            echo '<p>' . $error . '</p>';

        }

        echo '</div>';

    } elseif ($mensajeExito !== "") {

        echo '<div class="alert alert-success">' . $mensajeExito . '</div>';

    }

    ?>

            </div>

        </main>

    </div>



    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="asset/js/producto.js"></script>

    <script src="asset/js/menu.js"></script>

</body>



</html>

