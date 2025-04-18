<?php 
session_start();
require_once 'config/config.php';
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visenzzo</title>
    <link rel="shortcut icon" type="image/x-icon" href="/asset/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="/asset/css/estilos.css">
    <link rel="stylesheet" href="/asset/css/carrito.css">

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

                    <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" 
                        id="btn_session" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="boton-menu boton-carrito active" href="#">Realizar pago
                        </a>
                    </li>
                </ul>
            </nav>

            <footer>
                <p class="texto-footer">© Todos los derechos de esta pagina son atribuidos a Visenzzo.</p>
            </footer>

        </aside>
        <main class="container">
    <div class="row">
        <div class="col-md-6">
            <h4>Detalles de pago</h4>
            <div id="paypal-button-container"></div>
        </div>

        <div class="col-md-6">
            <div class="contenedor-carrito">
                <p id="carrito-vacio" class="carrito-vacio">Tu carrito está vacío. <i class="fa-solid fa-face-laugh-beam"></i></p>

                <div id="carrito-productos" class="carrito-productos disabled">
                    <!-- Esto se va a llenar con JS -->
                </div>

                <div id="carrito-acciones" class="carrito-acciones disabled">
                    <div class="carrito-acciones-derecha">
                        <div class="carrito-acciones-total">
                            <p>Total:</p>
                            <p id="total">$3000</p>
                        </div>
                    </div>
                </div>

                <p id="carrito-comprado" class="carrito-comprado disabled">Muchas Gracias por su compra<i class="bi bi-emoji-laughing"></i></p>
            </div>
        </div>
    </div>
</main>

    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/asset/js/carrito.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/d03d5fe35b.js" crossorigin="anonymous"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENTE_ID; ?>"></script>
  
    <script>

actualizarTotal();

var totalCalculado = obtenerTotalCalculado();

initPayPalButton();

function initPayPalButton() {
    paypal.Buttons({
        style: {
            color: "blue",
            shape: "pill",
            label: "pay"
        },
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: totalCalculado
                    }
                }]
            });
        },

        onApprove: function (data, actions) {
            let url = '/config/captura.php';
            actions.order.capture().then(function (detalles) {
                let productosEnCarrito = obtenerProductosEnCarrito();

                return fetch(url, {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        detalles: detalles,
                        productosEnCarrito: productosEnCarrito
                    })
                }).then(function(response){
                    window.location.href = 'completado.php?key=' + detalles['id'];
                })
            }).then(function () {
                // Limpiar el carrito y mostrar el mensaje de compra
                //pagarCarrito();
            }).catch(function (error) {
                console.error('Error al procesar la compra:', error);
            });
        },

        onCancel: function (data) {
            alert("Pago cancelado");
        }
    }).render("#paypal-button-container");
}

function obtenerProductosEnCarrito() {
    // Asegúrate de que productosEnCarrito esté definido y tiene datos válidos
    if (typeof productosEnCarrito !== 'undefined') {
        // Si ya es un objeto, devuélvelo tal cual
        if (typeof productosEnCarrito === 'object') {
            return productosEnCarrito;
        }

        // Intenta convertir a objeto si es una cadena JSON
        try {
            return JSON.parse(productosEnCarrito);
        } catch (error) {
            console.error('Error al parsear productosEnCarrito:', error);
        }
    }
    return [];
}

function obtenerTotalCalculado() {
    return productosEnCarrito.reduce((acc, producto) => {
        // Calcular el precio total del producto, considerando el descuento
        const precioConDescuento = producto.precio * (1 - producto.descuento / 100);

        // Asegurarse de que el precio no sea negativo
        const precioFinal = Math.max(precioConDescuento, 0);

        // Sumar el precio total del producto al acumulador
        return acc + (precioFinal * producto.cantidad);
    }, 0);
}

function pagarCarrito() {
    // Limpiar el carrito y mostrar el mensaje de compra
    productosEnCarrito.length = 0;
    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
    contenedorCarritoVacio.classList.add("disabled");
    contenedorCarritoProductos.classList.add("disabled");
    contenedorCarritoAcciones.classList.add("disabled");
    contenedorCarritoComprado.classList.remove("disabled");
}
</script>




</body>

</html>
