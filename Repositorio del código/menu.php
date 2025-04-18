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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/asset/css/estilos.css">
    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/asset/css/carrito.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
    <script> var KEY_TOKEN = "<?php echo KEY_TOKEN; ?>";</script>
<body>
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
            <header class="d-flex">
                <?php if (isset($_SESSION['user_id'])) { ?>
                    <a href="#" class="btn btn-success"><i class="fa-solid fa-user"></i> <?php echo $_SESSION['user_name']; ?></a>
                    <?php } else { ?>
                        <a href="login.php" class="btn btn-success"><i class="fa-solid fa-user"></i> Ingresar</a>
                        <?php } ?>
            
                <a href="/view/head/header.php">
                    <img class="logo" src="/asset/img/logo.png" alt="">
                </a>
                
            </header>


        <!-- Mostrar el nombre del usuario -->
       

            <nav>
                <ul class="menu">
                    <li>
                        <button id="todos" class="boton-menu boton-categoria active"><i class="fa-solid fa-hand-point-right"></i>Todos los
                            productos</button>
                    </li>
                    <li>
                        <button id="hombre" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Hombres</button>
                    </li>
                    <li>
                        <button id="mujer" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Mujeres</button>
                    </li>
                    <li>
                        <button id="niño" class="boton-menu boton-categoria"><i class="fa-solid fa-hand-point-right"></i>Niños</button>
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



        </main>

    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="/asset/js/producto.js"></script>
    <script src="/asset/js/menu.js"></script>

</script>

</body>

</html>