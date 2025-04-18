<?php

require_once '../config/db.php';
require_once '../config/config.php';
require_once '../header.php';
require_once '../clases/cifrado.php';

$db = new db();
$conexion = $db->conexion();

$correcto = false;
$mensaje = ''; // Variable para almacenar mensajes

if (isset($_POST['id'])) {

    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria_nombre = $_POST['categoria_nombre'];
    $categoria_id = $_POST['categoria_id'];
    $precio = floatval($_POST['precio']);
    $descuento = isset($_POST['descuento']) ? floatval($_POST['descuento']) : null;
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

    $base_directory = "/storage/ssd3/661/21633661/public_html"; // Reemplaza con la ruta correcta
    $product_folder = "$base_directory/asset/img/productos/$id"; // Ruta del producto

    // Eliminar todas las carpetas de imágenes de muestra por color dentro de la ruta principal
    $color_folders = glob("$product_folder/color_*");
    foreach ($color_folders as $color_folder) {
        if (is_dir($color_folder)) {
            // Eliminar directorio (carpeta de imágenes de muestra por color)
            $files = glob("$color_folder/*");
            foreach ($files as $file) {
                // Eliminar archivos dentro de la carpeta de imágenes de muestra por color
                unlink($file);
            }
            // Eliminar la carpeta de imágenes de muestra por color
            rmdir($color_folder);
        }
    }

    // Insertar nuevas imágenes de muestra por color
    if (!empty($_FILES['imagenes_muestra']['name'][0])) {
        foreach ($_FILES['imagenes_muestra']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['imagenes_muestra']['name'][$key];
            $file_tmp = $_FILES['imagenes_muestra']['tmp_name'][$key];

            // Crear directorio para imágenes de muestra por color dentro del directorio principal
            $color_folder = "$product_folder/color_$key";
            if (!file_exists($color_folder)) {
                mkdir($color_folder, 0777, true);
                $mensaje .= "Se creó correctamente el directorio para el color $key: $color_folder <br>";
            }

            // Mover la imagen al directorio del color
            $destination = "$color_folder/$file_name";
            if (move_uploaded_file($file_tmp, $destination)) {
                $mensaje .= "Imagen de muestra para el color $key movida correctamente: $destination <br>";
            } else {
                $mensaje .= "Error al mover la imagen de muestra para el color $key: $file_name <br>";
            }
        }
    } else {
        $mensaje .= 'No se recibieron archivos en el campo "imagenes_muestra".<br>';
    }
    echo "Ruta del producto: $product_folder";

    $query = $conexion->prepare("UPDATE productos SET titulo=?, descripcion=?, categoria_nombre=?, categoria_id=?, precio=?, descuento=?, tipo=? WHERE id=?");
    $resultado = $query->execute([$titulo, $descripcion, $categoria_nombre, $categoria_id, $precio, $descuento, $tipo, $id]);

    if ($resultado) {
        $correcto = true;
    }
} else {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria_nombre = $_POST['categoria_nombre'];
    $categoria_id = $_POST['categoria_id'];
    $precio = floatval($_POST['precio']);
    $descuento = isset($_POST['descuento']) ? floatval($_POST['descuento']) : null;
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null;
    $tallas_seleccionadas = isset($_POST['tallas']) ? $_POST['tallas'] : [];

    $query = $conexion->prepare("INSERT INTO productos (titulo, descripcion, categoria_nombre, categoria_id, precio, descuento, activo, tipo) VALUES (?, ?, ?, ?, ?, ?, 1, ?)");
    $resultado = $query->execute([$titulo, $descripcion, $categoria_nombre, $categoria_id, $precio, $descuento, $tipo]);
            // Obtener el ID del producto recién insertado
        $product_id = $conexion->lastInsertId();
        
        foreach ($tallas_seleccionadas as $talla_id) {
        $query = $conexion->prepare("INSERT INTO productos_tallas_relacion (producto_id, talla_id) VALUES (?, ?)");
        $query->execute([$product_id, $talla_id]);
}

    if ($resultado) {
        $correcto = true;

        

        // Directorio actual del script
        $script_directory = realpath(__DIR__);

        // Subir dos niveles para llegar al directorio principal
        $base_directory = realpath("$script_directory/../../");

        // Crear carpeta para las imágenes del producto
        $product_folder = $base_directory . DIRECTORY_SEPARATOR . 'asset' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'productos' . DIRECTORY_SEPARATOR . $product_id;

        // Asegurarse de que el directorio padre exista antes de crear el directorio del producto
        if (!file_exists("$base_directory/asset/img/productos") || !file_exists($product_folder)) {
            mkdir($product_folder, 0777, true);
            $mensaje .= 'Se creó correctamente el directorio: ' . $product_folder . '<br>';
        } else {
            $mensaje .= 'El directorio ya existe: ' . $product_folder . '<br>';
        }

        if (!empty($_FILES['imagenes']['name'][0])) {
            $imagen_principal = null;
            $imagenes_correctas = 0;

            // Iterar sobre las imágenes
            foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['imagenes']['name'][$key];
                $file_tmp = $_FILES['imagenes']['tmp_name'][$key];

                // Renombrar la primera imagen como "principal.jpg"
                if ($imagen_principal === null) {
                    $imagen_principal = "principal.jpg";
                }

                // Mover la imagen al directorio del producto
                $destination = "$product_folder/$file_name";
                if (move_uploaded_file($file_tmp, $destination)) {
                    $imagenes_correctas++;
                    $mensaje .= 'Imagen movida correctamente: ' . $destination . '<br>';
                } else {
                    $mensaje .= 'Error al mover la imagen: ' . $file_name . '<br>';
                    $mensaje .= 'Error de carga: ' . $_FILES['imagenes']['error'][$key] . '<br>';
                }
            }

            // Renombrar la imagen principal si se encontró
            if ($imagen_principal !== null) {
                $principal_path = "$product_folder/$imagen_principal";
                if (rename($destination, $principal_path)) {
                } else {
                    $mensaje .= 'Error al renombrar la imagen principal <br>';
                }
            }

            // Comprobar si todas las imágenes se cargaron correctamente
            if ($imagenes_correctas === count($_FILES['imagenes']['name'])) {
                $mensaje .= '¡Todas las imágenes se cargaron correctamente!<br>';
            } else {
                $mensaje .= 'Algunas imágenes no se cargaron correctamente.<br>';
            }
        } else {
            $mensaje .= 'No se recibieron archivos en el campo "imagenes".<br>';
        }

        // Procesar y almacenar las imágenes de muestra por color
        if (!empty($_FILES['imagenes_muestra']['name'][0])) {
            foreach ($_FILES['imagenes_muestra']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['imagenes_muestra']['name'][$key];
                $file_tmp = $_FILES['imagenes_muestra']['tmp_name'][$key];

                // Crear directorio para imágenes de muestra por color dentro del directorio principal
                $color_folder = "$product_folder/color_$key";
                if (!file_exists($color_folder)) {
                    mkdir($color_folder, 0777, true);
                    $mensaje .= "Se creó correctamente el directorio para el color $key: $color_folder <br>";
                }

                // Mover la imagen al directorio del color
                $destination = "$color_folder/$file_name";
                if (move_uploaded_file($file_tmp, $destination)) {
                    $mensaje .= "Imagen de muestra para el color $key movida correctamente: $destination <br>";
                } else {
                    $mensaje .= "Error al mover la imagen de muestra para el color $key: $file_name <br>";
                }
            }
        } else {
            $mensaje .= 'No se recibieron archivos en el campo "imagenes_muestra".<br>';
        }
    }
}

?>

<main class="container py-3">
    <div class="row">
        <div class="col">
            <?php if ($correcto) { ?>
                <h3>Registro guardado</h3>
            <?php } else { ?>
                <h3>Error al guardar</h3>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <a href="index.php" class="btn btn-primary">Regresar</a>
        </div>
    </div>
</main>

<?php require_once '../footer.php'; ?>
