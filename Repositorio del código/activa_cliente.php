<?php

require_once 'config/config.php';
require_once 'config/db.php';
require_once 'config/cliente_funciones.php';

$db = new db();
$conexion = $db->conexion();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    header("Location: productos.php");
    exit;
}

echo validaToken($id, $token, $conexion);
?>