<?php
session_start();

// Verificar si se recibieron datos del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productosEnCarrito'])) {
    // Actualizar la sesión con los datos del carrito
    $_SESSION['productos_en_carrito'] = json_encode($_POST['productosEnCarrito']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Datos no válidos']);
}
?>
