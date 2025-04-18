<?php

require_once '../config/db.php';
require_once '../config/config.php';
require_once '../header.php';
require_once '../clases/cifrado.php';

$db = new db();
$conexion = $db->conexion();

$activo = 1;

$sql = $conexion->prepare("SELECT id, titulo, descripcion, categoria_nombre, categoria_id, precio,
descuento FROM productos WHERE activo =:activo ORDER BY id ASC");
$sql->execute(['activo' => $activo]);
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<link rel="shortcut icon" type="image/x-icon" href="../asset/img/favicon.ico" />

<main class="container">
    <div class="row py-3">
        <div class="col">
            <h4>Productos
            <a href="nuevo.php" class="btn btn-primary float-right">Nuevo</a>
            </h4>
        </div>
    </div>

    <div class="row py-3">
        <div class="col">
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach($resultado AS $row){
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['titulo']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['categoria_nombre']; ?></td>
                        <td><?php echo $row['precio']; ?></td>
                        <td><?php echo $row['descuento']; ?></td>
                        <td><a href="editar.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a></td>
                        <td><a href="eliminar.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Eliminar</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</main>

<?php require_once '../footer.php'; ?>