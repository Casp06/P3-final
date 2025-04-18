<?php

session_start();

require_once 'config/config.php';

require_once 'config/db.php';

require_once 'config/cliente_funciones.php';

$db = new db();

$conexion = $db->conexion();



$json = file_get_contents('php://input');

$datos = json_decode($json, true);

// Verifica si se recibieron datos JSON válidos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($datos['productosEnCarrito'])) {

    // Actualizar la sesión con los datos del carrito

    $_SESSION['productos_en_carrito'] = json_encode($datos['productosEnCarrito']);

    echo json_encode(['success' => true]);

}

// session_destroy();

?>

    <script>

        const KEY_TOKEN = "<?php echo KEY_TOKEN; ?>";

    </script>



<!doctype html>

<html lang="es">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Visenzzo</title>

    <link rel="shortcut icon" type="image/x-icon" href="asset/img/favicon.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

   <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="asset/css/carrito.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>

</head>



<body>









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





            <!-- Mostrar el nombre del usuario -->

   <style>

        .dropdown .btn.text-light:hover,

        .dropdown .btn.text-light:focus {

            background-color: #fe5858 !important; 

            color: #ececec;

        }

        .dropdown-menu .boton-menu {

            color: #fe5858 !important; /* Texto blanco */

        }

    </style>



            <nav>

                <ul class="menu">

                <li>

                    <a href="index.php" class="boton-menu"><i class="fas fa-home"></i> Inicio</a>

                </li>

                <li>

                    <a href="productos-express.php" class="boton-menu "><i class="fas fa-cubes"></i> Productos express</a>

                </li>

                <li>

                    <a href="contacto.php" class="boton-menu"><i class="fas fa-envelope"></i> Contacto</a>

                </li>

                                <div class="dropdown">

      <button class="btn text-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

        Filtro

      </button>

      <ul class="dropdown-menu" style="">

          <li>

              <button id="hombre" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Hombres</button>

          </li>

          <li>

              <button id="mujer" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Mujeres</button>

          </li>

          <li>

              <button id="niños" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Niños</button>

          </li>

          <li>

              <button id="articulos" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Articulos de hogar</button>

          </li>

          <li>

              <button id="perfumeria" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Perfumería</button>

          </li>

          <li>

              <button id="zapatos" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Zapatos</button>

          </li>

          <li>

              <button id="accesorios" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Accesorios</button>

          </li>

      </ul>

    </div>

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

        <main>
            <h2 class="titulo-principal" id="titulo-principal">Todos los productos</h2>
            <div id="contenedor-productos" class="contenedor-productos">
                <!--Esto se va a llenar con js-->
            </div>
                    


        </main>



    </div>



    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="asset/js/producto.js"></script>

    <script src="asset/js/menu.js"></script>







</body>



</html>