<?php
require_once(__DIR__ . '/db.php');

header('Content-Type: application/json');

try {
    $db = new db();
    $conexion = $db->conexion();

    if ($conexion instanceof PDO) {
        $sql = "SELECT * FROM productos";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados);
    } else {
        echo json_encode(["error" => "Error de conexión a la base de datos"]);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error al procesar la solicitud: " . $e->getMessage()]);
} finally {
    $conexion = null; // Cierra la conexión
}
?>

