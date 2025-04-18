<?php
require_once '../config/db.php';
require_once '../config/config.php';
require_once '../header.php';
require_once '../clases/cifrado.php';

$db = new db();
$conexion = $db->conexion();

$id = $_GET['id'];

// Obtener el ID de la carpeta de imágenes asociada al producto
$query = $conexion->prepare("SELECT id FROM productos WHERE id = ?");
$query->execute([$id]);
$product = $query->fetch(PDO::FETCH_ASSOC);

if ($product) {
    // Eliminar la carpeta de imágenes
    $productFolder = realpath(__DIR__ . "/../../asset/img/productos/{$product['id']}");
    if (file_exists($productFolder) && is_dir($productFolder)) {
        // Eliminar imágenes dentro del directorio antes de eliminar la carpeta
        $files = glob("$productFolder/*");
        foreach ($files as $file) {
            unlink($file);
        }
        rmdir($productFolder);
    }

    // Eliminar el registro de la base de datos
    $deleteQuery = $conexion->prepare("DELETE FROM productos WHERE id = ?");
    if ($deleteQuery->execute([$id])) {
        echo 'Registro eliminado y carpeta de imágenes eliminada';
    } else {
        echo 'Error al eliminar registro';
    }
} else {
    echo 'Producto no encontrado';
}

?>

<a class="btn btn-secondary col-3" href="index.php">Regresar</a>

<?php require_once '../footer.php'; ?>
