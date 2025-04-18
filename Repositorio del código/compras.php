<?php

session_start();

require_once 'config/config.php';

require_once 'config/db.php';

require_once 'config/cliente_funciones.php';



$db = new db();

$conexion = $db->conexion();



$token = generarToken();

$_SESSION['token'] = $token;





$idCliente = $_SESSION['user_cliente'];



$sql = $conexion->prepare("SELECT id_transaccion, fecha, status, total FROM compra WHERE id_cliente = ? ORDER BY DATE(fecha) DESC");

$sql->execute([$idCliente]);

?>



<!DOCTYPE html>

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

                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">

                        <i class="fa-solid fa-user"></i> &nbsp; <?php echo $_SESSION['user_name']; ?>

                    </button>

                    <ul class="dropdown-menu" aria-labelledby="btn_session">

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

                    <a class="boton-menu boton-carrito active" href="#">Realizar pago</a>

                </li>

            </ul>

        </nav>



        <footer>

            <p class="texto-footer">© Todos los derechos de esta pagina son atribuidos a Visenzzo.</p>

        </footer>

    </aside>



    <main>

        <h4>Mis compras</h4>

        <hr>



        <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="card mb-3 border-black">

                <div class="card-header">

                    <?php echo $row['fecha']; ?>

                </div>

                <div class="card-body">

                    <h5 class="card-title">Folio: <?php echo $row['id_transaccion']; ?></h5>

                    <p class="card-text">Total: <?php echo $row['total']; ?></p>

                    <!-- Agrega aquí cualquier otra información que quieras mostrar -->

                    <a href="compra_detalle.php?orden=<?php echo $row['id_transaccion']; ?>&token=<?php echo 

                    $token; ?>" class="btn btn-primary">Ver compra</a>

                </div>

            </div>

        <?php } ?>

    </main>

</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="asset/js/producto.js"></script>

<script src="asset/js/carrito.js"></script>

<script src="asset/js/menu.js"></script>



</body>



</html>

