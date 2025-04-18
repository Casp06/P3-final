<?php 



$path = dirname(__FILE__);





require_once $path.'/db.php';    

require_once $path.'/../admin/clases/cifrado.php';



$db = new db();

$conexion = $db->conexion();



$sql = "SELECT nombre, valor FROM configuracion";

$resultado = $conexion->query($sql);

$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);



$config = [];



foreach($datos as $dato){

    $config[$dato['nombre']] = $dato['valor'];

}



// Configuracion del sistema

define("SITE_URL", "https://visenzzo.com/");

define("KEY_TOKEN", "AZK.wtx-706*");

define("MONEDA", "$ USD ");



// Configuracion para paypal

define("CLIENTE_ID", "AXJBLqG0lmlD_3j0UmFH2nSA1Yd4xefFjoRLswjYGRbWvKn6F_6cEmwAPJR9CSUDhfL2tx6txXh3YGVp");

define("CURRENCY", "DOP");



// Datos para envio de correo  electronico

define("MAIL_HOST", $config['correo_smtp']);

define("MAIL_USER", $config['correo_email']);

define("MAIL_PASS", descifrar($config['correo_password']));

define("MAIL_PORT", $config['correo_puerto']);

