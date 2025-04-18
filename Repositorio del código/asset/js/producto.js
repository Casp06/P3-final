let productos = [];

fetch("/login/config/obtener_productos.php")
    .then(response => response.json())
    .then(data => {
        productos = data;
        cargarProductos(productos);
    })
    .catch(error => console.error("Error al obtener productos:", error));

const contenedorProductos = document.querySelector("#contenedor-productos");
const botonesCategorias = document.querySelectorAll(".boton-categoria");
const tituloPrincipal = document.querySelector("#titulo-principal");
let botonesAgregar = document.querySelectorAll(".producto-agregar");
const numerito = document.querySelector ("#numerito");




function cargarProductos(productosElegidos) {
    contenedorProductos.innerHTML = "";

    productosElegidos.forEach(producto => {
        let token;  // Declara la variable token fuera del bloque try


        try {
            token = CryptoJS.HmacSHA1(producto.id.toString(), KEY_TOKEN).toString();

            const div = document.createElement("div");
            div.classList.add("producto");
            if (window.location.pathname.includes("productos.php")) {
                div.innerHTML = `
                <div class="col-md-12 col-sm-6 col-md-3">
                <div class="single-product">
                  <div class="product-img">
                    <a href="detalles.php?id=${encodeURIComponent(producto.id)}&token=${encodeURIComponent(token)}">
                    <img src="asset/img/productos/${producto.id}/principal.jpg" alt="${producto.titulo}">
                    <div class="actions-btn">
                    </div>
                  </div>
                  <div class="product-dsc">
                    <p>${producto.titulo}</p>
                    <span>${producto.precio}</span>
                  </div>
                </div>
              </div>
                `;

                contenedorProductos.append(div);
            }
        } catch (error) {
            console.error('Error al procesar producto:', producto, error);
        }
    });

    actualizarBotonesAgregar();
}






botonesCategorias.forEach(boton =>{
    boton.addEventListener("click", (e) =>{

        botonesCategorias.forEach(boton => boton.classList.remove("active"));
        e.currentTarget.classList.add("active");

        if (e.currentTarget.id != "todos") {
            const productoCategoria = productos.find(producto => producto.categoria_id === e.currentTarget.id);
            tituloPrincipal.innerText = productoCategoria.categoria_nombre;
            
            const productosBoton = productos.filter(producto => producto.categoria_id === e.currentTarget.id);
            cargarProductos(productosBoton);
        } else {
            tituloPrincipal.innerText = "Todos los productos";
            cargarProductos(productos);
        }
        

    })
})

function actualizarBotonesAgregar(){
    botonesAgregar = document.querySelectorAll(".producto-agregar");

    botonesAgregar.forEach(boton => {
        boton.addEventListener("click", agregarAlCarrito);
    });
}
let productosEnCarrito;

let productosEnCarritoLS = localStorage.getItem("productos-en-carrito");

if(productosEnCarritoLS){
    productosEnCarrito = JSON.parse(productosEnCarritoLS);
    actualizarNumerito();
}else{
    productosEnCarrito = [];
}


function agregarAlCarrito(e) {
    Toastify({
        text: "Producto agregado",
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
        onClick: function () {}
    }).showToast();

    const idBoton = parseInt(e.currentTarget.id, 10);
    const productoAgregado = productos.find(producto => producto.id === idBoton);

    // Obtener el tamaño y el color seleccionados
    const selectedSize = document.getElementById('size').value;
    const selectedColor = document.getElementById('color').value;

    // Agregar el tamaño y el color al objeto del producto
    productoAgregado.size = selectedSize;
    productoAgregado.color = selectedColor;

    if (productosEnCarrito.some(producto => producto.id === idBoton)) {
        const index = productosEnCarrito.findIndex(producto => producto.id === idBoton);
        productosEnCarrito[index].cantidad++;
    } else {
        productoAgregado.cantidad = 1;
        productosEnCarrito.push(productoAgregado);
    }

    actualizarNumerito();

    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));

    // Actualizar la sesión
    productosEnCarrito = obtenerProductosEnCarrito();
    fetch("/login/productos.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                productosEnCarrito: productosEnCarrito
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            console.log("Sesión actualizada");
        })
        .catch(error => console.error("Error al actualizar la sesión:", error));
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

function actualizarNumerito() {
    let nuevoNumerito = productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0);
    numerito.innerText = nuevoNumerito;
}
