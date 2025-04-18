<?php

session_start();



require_once('db.php');

require_once('Mailer.php');

require_once('config.php'); // Asegúrate de tener la ruta correcta al archivo Mailer.php

$db = new db();

$conexion = $db->conexion();



$json = file_get_contents('php://input');

$datos = json_decode($json, true);





if (is_array($datos)) {



    if (isset($_SESSION['user_cliente'])) {

        $id_cliente = $_SESSION['user_cliente'];

        // Resto del código...

    } else {

        echo "La variable \$_SESSION['user_cliente'] no está definida.";

    }



    $sql_insert = $conexion->prepare("SELECT email FROM clientes WHERE id=? AND estatus=1");

    $sql_insert->execute([$id_cliente]);

    $row_cliente = $sql_insert->fetch(PDO::FETCH_ASSOC);



    $id_transaccion = $datos['detalles']['id']; // Cambiado a 'detalles'

    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];

    $status = $datos['detalles']['status'];

    $fecha = $datos['detalles']['update_time'];

    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));

    $email = $row_cliente['email'];



    $sql = $conexion->prepare("INSERT INTO compra(id_transaccion, fecha, status, email, id_cliente, total) VALUES(?,?,?,?,?,?)");

    $sql->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);



    // Obtener el último ID insertado en la tabla compra

    $id_compra = $conexion->lastInsertId();



    // Obtener productos desde $datos

    if (isset($datos['productosEnCarrito']) && is_array($datos['productosEnCarrito'])) {



        foreach ($datos['productosEnCarrito'] as $producto) {

            $id_producto = $producto['categoria_id'];

            $cantidad = $producto['cantidad'];

            $titulo = $producto['titulo'];

            $precio = $producto['precio'];

            $descuento = $producto['descuento'];

            $precio_desc = $precio - (($precio * $descuento) / 100);

            $size = $producto['size'];

            $color = $producto['image'];



            if ($id_compra > 0) {

                $sql_insert = $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad, size,color) VALUES(?,?,?,?,?,?,?)");

                $sql_insert->execute([$id_compra, $id_producto, $titulo, $precio_desc, $cantidad, $size, $color]);

            }

        }



        // Datos del cliente

        $sql_cliente = $conexion->prepare("SELECT * FROM clientes WHERE id=? AND estatus=1");

        $sql_cliente->execute([$id_cliente]);

        $row_cliente = $sql_cliente->fetch(PDO::FETCH_ASSOC);



        $nombre_cliente = $row_cliente['nombres'] . ' ' . $row_cliente['apellidos'];

        $telefono_cliente = $row_cliente['telefono'];

        $direccion_cliente = $row_cliente['direccion'];

        $email_cliente = $row_cliente['email'];



        // Enviar correo al administrador

        $asuntoAdmin = "Nuevo pedido - Detalles";

        $cuerpoAdmin = "<h4>Detalles del nuevo pedido</h4>";

        $cuerpoAdmin .= "<p><b>ID de transacción:</b> $id_transaccion</p>";

        $cuerpoAdmin .= "<p><b>Cliente:</b> $nombre_cliente</p>";

        $cuerpoAdmin .= "<p><b>Teléfono:</b> $telefono_cliente</p>";

        $cuerpoAdmin .= "<p><b>Dirección:</b> $direccion_cliente</p>";

        $cuerpoAdmin .= "<p><b>Email:</b> $email_cliente</p>";



        // Iterar sobre los productos para incluirlos en el cuerpo del correo

        $cuerpoAdmin .= "<h4>Productos:</h4>";

        foreach ($datos['productosEnCarrito'] as $producto) {

            $titulo_producto = $producto['titulo'];

            $precio_producto = $producto['precio'];

            $descuento_producto = $producto['descuento'];

            $precio_desc_producto = $precio_producto - (($precio_producto * $descuento_producto) / 100);

            $cantidad_producto = $producto['cantidad'];

            $size_producto = $producto['size'];

            $color_producto = "<img src=\"{$producto['image']}\" alt=\"Color seleccionado\">";

            $imagen_producto = "<img src=\"asset/img/productos/{$producto['id']}/principal.jpg\" alt=\"$titulo_producto\">";





$cuerpoAdmin .= "

    <p>

        <b>$titulo_producto:</b> 

        Cantidad: $cantidad_producto, 

        Precio: $precio_desc_producto, 

        Size: $size_producto

    </p>

    Imagen del producto: $imagen_producto,

    Color seleccionado: $color_producto

";



}



        $mailerAdmin = new Mailer();

        $mailerAdmin->enviarEmail(MAIL_USER, $asuntoAdmin, $cuerpoAdmin);



        // Enviar correo al cliente

        $asuntoCliente = "Detalles de su pedido.";

        $cuerpoCliente = '<h4>Gracias por su compra</h4>';

        $cuerpoCliente .= '<p>El ID de su compra es <b>'. $id_transaccion .'</b></p>';



        $mailerCliente = new Mailer();

        $mailerCliente->enviarEmail($email, $asuntoCliente, $cuerpoCliente);

    }



    unset($datos['productosEnCarrito']);

    unset($_SESSION['productosEnCarrito']);

}

?>

