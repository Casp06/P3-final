<?php 

require_once 'db.php';
require_once 'cliente_funciones.php';

$datos = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $db = new db();
    $conexion = $db->conexion();

    if ($action == 'existeUsuario') {
        $datos['ok'] = usuarioExiste($_POST['usuario'], $conexion);
    } elseif($action == 'existeEmail'){
        $datos['ok'] = emailExiste($_POST['email'], $conexion);
    }
}

echo json_encode($datos);

?>