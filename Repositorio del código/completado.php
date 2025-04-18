<?php
session_start();


    
require_once('./config/db.php');
require_once './config/config.php';
$db = new db();
$conexion = $db->conexion();

$id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';



$error = '';
if ($id_transaccion == '' || $id_transaccion == '0') {
    $error = 'Error al procesar la petición';
} else {
    $sql = $conexion->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
    $sql->execute([$id_transaccion, 'COMPLETED']);
    if ($sql->fetchColumn() > 0) {
        $sql = $conexion->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND status=? LIMIT 1");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        $idCompra = $row['id'];
        $total = $row['total'];
        $fecha = $row['fecha'];

        $sqlDet = $conexion->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra =?");
        $sqlDet->execute([$idCompra]);

    } 
    else {
        $error = 'Error al comprobar la compra';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/asset/css/estilos.css">
   <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/asset/css/carrito.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
</head>
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

<div class="dropdown ">
    <button class="btn text-light boton-menu dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="btn_session">
        <li><a class="dropdown-item" href="compras.php">Mis compras</a></li>
        <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
    </ul>
</div>

<?php } else { ?>
<a href="login.php" class="btn btn-light boton-menu"><i class="fa-solid fa-user"></i> Ingresar</a></li>
<?php } ?>

                <a href="index.php">
                    <img class="logo" src="/asset/img/logo.png" alt="">
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
        
        <div class="container">
            <?php if (strlen($error) > 0)  { ?>
                <div class="row">
                    <div class="col">
                        <h3><?php echo $error; ?></h3>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col">
                        <b>Folio de la compra: </b><?php echo $id_transaccion; ?><br>
                        <b>Fecha de compra: </b><?php echo $fecha; ?><br>
                        <b>Total: </b><?php echo MONEDA .number_format($total, 2, '.', ','); ?><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                
                                
                                while ($row_det = $sqlDet->fetch(PDO::FETCH_ASSOC)) {
                                    $importe = $row_det['precio'] * $row_det['cantidad']; 
                                ?>
                                    <tr>
                                        <td><?php echo $row_det['cantidad']; ?></td>
                                        <td><?php echo $row_det['nombre']; ?></td>
                                        <td><?php echo $importe; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
    </div>
</body>
<script src="/asset/js/menu.js"></script>

</html>



