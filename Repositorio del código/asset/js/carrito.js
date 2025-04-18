let productosEnCarrito = localStorage.getItem("productos-en-carrito");
productosEnCarrito = JSON.parse(productosEnCarrito);

const contenedorCarritoVacio = document.querySelector("#carrito-vacio");
const contenedorCarritoProductos = document.querySelector("#carrito-productos");
const contenedorCarritoAcciones = document.querySelector("#carrito-acciones");
const contenedorCarritoComprado = document.querySelector("#carrito-comprado");
let botonesEliminar = document.querySelectorAll("#carrito-producto-eliminar");
const botonVaciar = document.querySelector("#carrito-acciones-vaciar");
const contenedorTotal = document.querySelector("#total");
const botonComprar = document.querySelector("#carrito-acciones-comprar");

function cargarProductosCarrito() {
    if (productosEnCarrito && productosEnCarrito.length > 0) {
        contenedorCarritoVacio.classList.add("disabled");
        contenedorCarritoProductos.classList.remove("disabled");
        contenedorCarritoAcciones.classList.remove("disabled");
        contenedorCarritoComprado.classList.add("disabled");

        contenedorCarritoProductos.innerHTML = "";

        productosEnCarrito.forEach(producto => {
            const div = document.createElement("div");
            div.classList.add("carrito-producto");

            let productoHtml = '';

            const precioConDescuento = producto.precio * (1 - producto.descuento / 100);

            if (window.location.pathname.includes("carrito.php")) {
                productoHtml += `
                <img class="carrito-producto-imagen" src="asset/img/productos/${producto.id}/principal.jpg" alt="${producto.titulo}">
                `;
            }

            productoHtml += `
                <div class="carrito-producto-titulo">
                    <small>Producto</small>
                    <h5>${producto.titulo}</h5>
                </div>
            `;

        if (window.location.pathname.includes("carrito.php")) {
            productoHtml += `
                    <div class="carrito-producto-cantidad">
                        <small>Cantidad</small>
                        <p>
                        <button class="btn btn-cantidad btn-cantidad-decrementar" data-id="${producto.id}">-</button>
                        <span>${producto.cantidad}</span>
                        <button class="btn btn-cantidad btn-cantidad-incrementar" data-id="${producto.id}">+</button>
                        </p>
                        </div>
                    <div class="carrito-producto-precio">
                        <small>Precio</small>
                        <p>$${precioConDescuento}</p>
                    </div>
                    <div class="carrito-producto-precio">
                        <small>Size</small>
                        <p>(${producto.size})</p>
                    </div>
            `;
        }
            

            productoHtml += `
                <div class="carrito-producto-subtotal">
                    <small>Subtotal</small>
                    <p id="subtotal-${producto.id}">$${(precioConDescuento * producto.cantidad).toFixed(2)}</p>
                </div>
            `;

            if (window.location.pathname.includes("carrito.php")) {
                productoHtml += `
                    <button class="carrito-producto-eliminar" id="${producto.id}"><i class="fa-solid fa-trash-can"></i></button>
                `;
            }

            div.innerHTML = productoHtml;
            contenedorCarritoProductos.appendChild(div);
        });
    } else {
        contenedorCarritoVacio.classList.remove("disabled");
        contenedorCarritoProductos.classList.add("disabled");
        contenedorCarritoAcciones.classList.add("disabled");
        contenedorCarritoComprado.classList.add("disabled");
    }

    actualizarBotonesEliminar();
    actualizarTotal();
}

function actualizarBotonesEliminar() {
    botonesEliminar = document.querySelectorAll(".carrito-producto-eliminar");
    const botonesIncrementar = document.querySelectorAll(".btn-cantidad-incrementar");
    const botonesDecrementar = document.querySelectorAll(".btn-cantidad-decrementar");

    botonesEliminar.forEach(boton => {
        boton.addEventListener("click", eliminarDelCarrito);
    });

    botonesIncrementar.forEach(boton => {
        boton.addEventListener("click", incrementarCantidad);
    });

    botonesDecrementar.forEach(boton => {
        boton.addEventListener("click", decrementarCantidad);
    });
}

function incrementarCantidad(e) {
    const idProducto = e.currentTarget.getAttribute("data-id");
    const producto = productosEnCarrito.find(p => p.id === parseInt(idProducto, 10));

    if (producto) {
        producto.cantidad++;
        cargarProductosCarrito();
        actualizarTotal();
        localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
    }
}

function decrementarCantidad(e) {
    const idProducto = e.currentTarget.getAttribute("data-id");
    const producto = productosEnCarrito.find(p => p.id === parseInt(idProducto, 10));

    if (producto && producto.cantidad > 1) {
        producto.cantidad--;
        cargarProductosCarrito();
        actualizarTotal();
        localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
    }
}


function eliminarDelCarrito(e) {
    Toastify({
        text: "Producto eliminado",
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        style: {
            background: "linear-gradient(to right, #fe5858, #f88989)",
            borderRadius: "2rem",
            textTransform: "uppercase",
            fontSize: ".75rem",
        },
        offset: {
            x: ".5rem",
            y: ".5rem"
        },
        onClick: function () { }
    }).showToast();

    const idBoton = e.currentTarget.id;
    const index = productosEnCarrito.findIndex(producto => producto.id === idBoton);

    productosEnCarrito.splice(index, 1);
    cargarProductosCarrito();

    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
}

if (botonVaciar) {
    botonVaciar.addEventListener("click", vaciarCarrito);
}

function vaciarCarrito() {
    Swal.fire({
        title: "¿Estás seguro?",
        icon: "question",
        html: `Se van a borrar ${productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0)} productos.`,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: `Si`,
        cancelButtonText: `No`
    }).then((result) => {
        if (result.isConfirmed) {
            productosEnCarrito.length = 0;
            localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
            cargarProductosCarrito();
        }
    });
}

if (botonComprar) {
    botonComprar.addEventListener("click", comprarCarrito);
}

function comprarCarrito() {
    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
    contenedorCarritoVacio.classList.add("disabled");
    contenedorCarritoProductos.classList.add("disabled");
    contenedorCarritoAcciones.classList.add("disabled");
    contenedorCarritoComprado.classList.remove("disabled");
}

function calcularCostoDeEnvio() {
    const cantidadProductos = productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0);

    if (cantidadProductos === 1) {
        return 350;
    } else if (cantidadProductos === 2) {
        return 300;
    } else {
        return 250;
    }
}

function actualizarTotal() {
    const totalCalculado = productosEnCarrito.reduce((acc, producto) => acc + (producto.precio * producto.cantidad), 0);
    const costoDeEnvio = calcularCostoDeEnvio();
    const totalConEnvio = totalCalculado + costoDeEnvio;
    contenedorTotal.innerText = `$${totalConEnvio.toFixed(2)} (Envío: $${costoDeEnvio.toFixed(2)})`;
}

function cambiarCantidadDesdeInput(e) {
    const idProducto = e.currentTarget.id.replace("cantidad-", "");
    const nuevaCantidad = parseInt(e.currentTarget.value, 10);

    const index = productosEnCarrito.findIndex(producto => producto.id === idProducto);
    if (index !== -1) {
        productosEnCarrito[index].cantidad = nuevaCantidad;

        const subtotal = productosEnCarrito[index].precio * nuevaCantidad;
        const subtotalElement = document.getElementById(`subtotal-${idProducto}`);
        if (subtotalElement) {
            subtotalElement.innerText = `$${subtotal.toFixed(2)}`;
        }

        localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
        actualizarTotal();
    }
}

cargarProductosCarrito();
console.log(productosEnCarrito)