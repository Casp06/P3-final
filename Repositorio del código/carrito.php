<?php session_start(); ?>



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



</head>



<body>







    <div class="wrapper">

        <header class="header-mobile">

            <a href="index.php">

                <img class="logo" src="asset/img/logo.png" alt="">

            </a>

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

                            <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>

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

                <ul>

                    <li>

                        <a class="boton-menu boton-volver" href="productos.php">

                            <i class="bi bi-arrow-return-left"></i>Seguir comprando

                        </a>

                    </li>

                    <li>

                        <a class="boton-menu boton-carrito active" href="carrito.php">Carrito

                        </a>

                    </li>

                </ul>

            </nav>



            <footer>

                <p class="texto-footer">© Todos los derechos de esta pagina son atribuidos a Visenzzo.</p>

            </footer>



        </aside>

        <main>

            <h2 class="titulo-principal">Carrito</h2>

            <div class="contenedor-carrito">

                <p id="carrito-vacio" class="carrito-vacio ">Tu carrito está vacío. <i class="fa-solid fa-face-laugh-beam"></i></p>



                <div id="carrito-productos" class="carrito-productos disabled">

                    <!--Esto se va a llenar con js-->

                </div>



                <div id="carrito-acciones" class="carrito-acciones disabled">

                    <div class="carrito-acciones-izquierda">

                        <button id="carrito-acciones-vaciar" class="carrito-acciones-vaciar">Vaciar carrito</button>

                    </div>

                    <div class="carrito-acciones-derecha">

                        <div class="carrito-acciones-total">

                            <p>Total:</p>

                            <p id="total">$3000</p>

                        </div>

                        <?php if (isset($_SESSION['user_cliente'])) { ?>

                            <a href="pago1.php" id="carrito-acciones-comprar" class="carrito-acciones-comprar">Realizar pago</a>

                        <?php } else { ?>

                            <a href="login.php?pago" id="carrito-acciones-comprar" class="carrito-acciones-comprar">Realizar pago</a>

                        <?php } ?>

                    </div>

                </div>





                <p id="carrito-comprado" class="carrito-comprado disabled">Muchas Gracias por su compra<i class="bi bi-emoji-laughing"></i></p>



            </div>

        </main>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="asset/js/carrito.js"></script>

    <script src="asset/js/menu.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>

</body>



</html>