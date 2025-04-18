<?php

require_once '../config/db.php';
require_once '../config/config.php';
require_once '../header.php';
require_once '../clases/cifrado.php';

$db = new db();
$conexion = $db->conexion();
?>

<main class="container py-3">
    <div class="row">
        <div class="col">
            <h4>Nuevos registro</h4>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form class="row g-3" action="guarda.php" method="post" autocomplete="off" enctype="multipart/form-data">


                <div class="col-md-4">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" required autofocus>
                </div>

                <div class="col-md-8">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="categoria_nombre" class="form-label">Nombre de Categoría</label>
                    <select name="categoria_nombre" id="categoria_nombre" class="form-control"
                    value="<?php echo $row['categoria_nombre']; ?>" required>
                    <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="Niños">Niños</option>
                        <option value="Articulos para el hogar">Articulos para el hogar</option>
                        <option value="Perfumeria">Perfumeria</option>
                        <option value="Zapatos">Zapatos</option>
                        <option value="Accesorios">Accesorios</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="categoria_id" class="form-label">ID de Categoría</label>
                    <select id="categoria_id" name="categoria_id" class="form-control"
                    value="<?php echo $row['categoria_id']; ?>" required>
                        <option value="hombre">hombre</option>
                        <option value="mujer">mujer</option>
                        <option value="niños">Niños</option>
                        <option value="articulos">Articulos para el hogar</option>
                        <option value="perfumeria">Perfumeria</option>
                        <option value="zapatos">Zapatos</option>
                        <option value="accesorios">Accesorios</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" id="precio" name="precio" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="descuento" class="form-label">Descuento</label>
                    <input type="number" id="descuento" name="descuento" class="form-control">
                </div>
                <div class="col-md-6">
    <label for="tipo" class="form-label">Tipo de Producto</label>
    <select id="tipo" name="tipo" class="form-control" required>
        <option value="normal">Normal</option>
        <option value="express">Express</option>
    </select>
</div>

                <div class="col-md-6">
                    <label for="imagenes" class="form-label">Imágenes (Puedes seleccionar varias) Tienen que ser .jpg:</label>
                    <input type="file" id="imagenes" name="imagenes[]" class="form-control" multiple accept="image/*" required>
                </div>
<div class="col-md-6">
    <label for="imagenes_muestra" class="form-label">Imágenes de Muestra por Color (Puedes seleccionar varias):</label>
    <input type="file" id="imagenes_muestra" name="imagenes_muestra[]" class="form-control" multiple accept="image/*">
</div>

<div class="col-md-6">
    <label for="tallas" class="form-label">Tallas Disponibles</label><br>
    <?php
    // Obtener tallas disponibles desde la base de datos
    $queryTallas = $conexion->query("SELECT * FROM productos_tallas");
    $tallasDisponibles = $queryTallas->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar checkboxes para seleccionar tallas
    foreach ($tallasDisponibles as $talla) {
        echo '<input type="checkbox" name="tallas[]" value="' . $talla['id'] . '"> ' . $talla['talla'] . '<br>';
    }
    ?>
</div>


                <div class="col-md-12">
                    <a class="btn btn-secondary" href="index.php">Regresar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>

            </form>
        </div>
    </div>
</main>

<?php require_once '../footer.php'; ?>