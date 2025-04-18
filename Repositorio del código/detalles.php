<?php
require_once 'config/config.php';
require_once('config/db.php');
$db = new db();
$conexion = $db->conexion();

$tamanos = array('S', 'M', 'L', 'XL');
$colores = array('Rojo', 'Azul', 'Verde', 'Negro');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';


if ($id == '' || $token == '') {
    echo 'Error al procesar la peticion';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_tmp) {

        $sql = $conexion->prepare("SELECT count(id) FROM productos WHERE id=?");
        $sql->execute([$id]);

        if ($sql->fetchColumn() > 0) {

            $sql = $conexion->prepare("SELECT titulo, descripcion, precio, descuento FROM productos WHERE id=? LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $dir_images = 'asset/img/productos/' . $id . '/';


            $rutaImg = $dir_images . 'principal.jpg';

            if (!file_exists($rutaImg)) {
                $rutaImg = '/login/asset/img/no-photo.jpg';
            }
            $imagenes = array();
            if (file_exists($dir_images)) {
                $dir = dir($dir_images);

                while (($archivo = $dir->read()) != false) {
                    if ($archivo != 'principal.jpg' && (strpos($archivo, 'jpg') || strpos($archivo, 'jpeg'))) {
                        $imagenes[] = $dir_images . $archivo;
                    }
                }
                $dir->close();
            }
        }
    } else {
        echo 'Error al procesar la peticion';
        exit;
    }
}




?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/login/asset/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/login/asset/css/estilos.css">
    <link rel="stylesheet" href="/login/asset/css/carrito.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>

</head>

<body>
    <script>
        // Pasar la clave de PHP a JavaScript
        var KEY_TOKEN = "<?php echo KEY_TOKEN; ?>";
    </script>



    <div class="wrapper">
        <header class="header-mobile">
            <a href="/login/view/head/header.php">
                <img class="logo" src="/login/asset/img/logo.png" alt="">
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
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesion</a></li>
                        </ul>
                    </div>

                <?php } else { ?>
                    <a href="login.php" class="btn btn-success"><i class="fa-solid fa-user"></i> Ingresar</a>
                <?php } ?>

                <a href="/login/view/head/header.php">
                    <img class="logo" src="/login/asset/img/logo.png" alt="">
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
                        <a class="boton-menu boton-carrito active" href="carrito.php">Detalles
                        </a>
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
            <h2 class="titulo-principal">Detalles</h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 order-md-1">

                        <div id="carouselImages" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="<?php echo $rutaImg; ?>" alt="" class="d-block w-100">
                                </div>

                                <?php foreach ($imagenes as $img) { ?>
                                    <div class="carousel-item">
                                        <img src="<?php echo $img; ?>" alt="" class="d-block w-100">
                                    </div>
                                <?php } ?>

                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 order-md-2">
                        <h2><?php echo $titulo; ?></h2>

                        <?php if ($descuento > 0) { ?>
                            <p><del><?php echo MONEDA . number_format($precio, 2, '.', '.'); ?></del></p>
                            <h2>
                                <?php echo MONEDA . number_format($precio_desc, 2, '.', '.'); ?>
                                <small class="text-success"><?php echo $descuento; ?> % de descuento</small>
                            </h2>
                        <?php } else { ?>

                            <h2><?php echo MONEDA . number_format($precio, 2, '.', '.'); ?></h2>
                        <?php } ?>
                        <p class="lead">
                            <?php echo $descripcion; ?>
                        </p>

                        <div class="d-grid gap-3 col-10 mx-auto">
                            <div id="contenedor-productos">
                                <!--Esto se va a llenar con js-->
                            </div>

                            <div class="form-group row">
                                <label for="size" class="col-sm-2 col-form-label">Tamaño:</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="size" name="size">
                                        <?php foreach ($tamanos as $tamano) { ?>
                                            <option value="<?php echo $tamano; ?>"><?php echo $tamano; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="color" class="col-sm-2 col-form-label">Color:</label>
                                <div class="col-sm-4">
                                    <select class="form-select" id="color" name="color">
                                        <?php foreach ($colores as $color) { ?>
                                            <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <a href="carrito.php" class="btn producto-agregar producto-comprar" id="<?php echo $id; ?>" type="button">Comprar ahora</a>
                            <button class="btn  producto-agregar" id="<?php echo $id; ?>" type="button">Agregar al carrito</button>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/login/asset/js/producto.js"></script>
    <script src="/login/asset/js/menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
</body>

</html>