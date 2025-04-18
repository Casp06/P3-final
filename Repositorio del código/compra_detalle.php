<?php
session_start();
require_once 'config/config.php';
require_once 'config/db.php';
require_once 'config/cliente_funciones.php';

$token_session = $_SESSION['token'];
$orden = $_GET['orden'] ?? null ;
$token = $_GET['token'] ?? null ;

if ($orden == null || $token == null || $token != $token_session) {
    header("Location: compras.php");
    exit;
}

$db = new db();
$conexion = $db->conexion();

$sqlCompra = $conexion->prepare("SELECT id, id_transaccion, fecha, total FROM compra WHERE id_transaccion =? LIMIT 1"); 
$sqlCompra->execute([$orden]);
$rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
$idCompra = $rowCompra['id'];

$fecha = new DateTime($rowCompra['fecha']);
$fecha = $fecha->format('d/m/Y H:i');

$sqlDetalle = $conexion->prepare("SELECT id, nombre, precio, cantidad FROM detalle_compra WHERE id_compra =?");
$sqlDetalle->execute([$idCompra]);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico" />
    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/asset/css/estilos.css">
    <link rel="stylesheet" href="/asset/css/carrito.css">
</head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<body>


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
                    <img class="logo" src="/asset/img/logo.png" alt="">
                </a>

            </header>

        <nav>
            <ul>
                <li>
                    <a class="boton-menu boton-volver active" href="productos.php">
                        <i class="bi bi-arrow-return-left"></i>Seguir comprando
                    </a>
                </li>
            </ul>
        </nav>

        <footer>
            <p class="texto-footer">© Todos los derechos de esta pagina son atribuidos a Visenzzo.</p>
        </footer>
    </aside>

    <main>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <strong>Detalle de la compra</strong>
                        </div>
                        <div class="card-body">
                            <p><strong>Fecha: </strong> <?php echo $fecha;?></p>
                            <p><strong>Orden: </strong> <?php echo $rowCompra['id_transaccion'];?></p>
                            <p><strong>Total: </strong> <?php echo MONEDA .' '. number_format($rowCompra['total'], 2, '.',
                        ',');?></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                while($row = $sqlDetalle->fetch(PDO::FETCH_ASSOC)){ 
                                $precio = $row ['precio'];
                                $cantidad = $row ['cantidad'];
                                $subtotal = $precio * $cantidad;
                                    ?>
                                    <tr>
                                        <td> <?php echo $row['nombre']; ?></td>
                                        <td> <?php echo MONEDA .' '. number_format($precio, 2, '.',',') ?></td>
                                        <td> <?php echo $cantidad; ?></td>
                                        <td> <?php echo MONEDA .' '. number_format($subtotal, 2, '.',','); ?></td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="/asset/js/producto.js"></script>
<script src="/asset/js/carrito.js"></script>
<script src="/asset/js/menu.js"></script>

</body>

</html>
