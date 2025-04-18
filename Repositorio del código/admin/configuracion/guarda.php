<?php  

require_once '../config/db.php';
require_once '../config/config.php';
include '../header.php';
require_once '../clases/cifrado.php';

$db = new db();
$conexion = $db->conexion();

$smtp = $_POST['smtp'];
$puerto = $_POST['puerto'];
$email = $_POST['email'];
$password = cifrar($_POST['password']);
$cliente_id = $_POST['cliente_id'];

$sql = $conexion->prepare("UPDATE configuracion SET valor = ? WHERE nombre = ? ");
$sql->execute([$smtp, 'correo_smtp']);
$sql->execute([$puerto, 'correo_puerto']);
$sql->execute([$email, 'correo_email']);
$sql->execute([$password, 'correo_password']);
$sql->execute([$cliente_id, 'cliente_id']);

?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Configuracion actualizada</h1>
        
        <a href="index.php" class="btn btn-secondary">Regresar</a>
    </div>
</main>

<?php include '../footer.php' ?>