<?php 

require_once '../config/db.php';

require_once '../config/config.php';

require_once '../header.php';

require_once '../clases/cifrado.php';



$db = new db();

$conexion = $db->conexion();



$sql = "SELECT nombre, valor FROM configuracion";

$resultado = $conexion->query($sql);

$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);



$config = [];



foreach($datos as $dato){

    $config[$dato['nombre']] = $dato['valor'];

}

?>



<main>

    <div class="container-fluid px-4">

        <h1 class="mt-4">Configuración</h1>



        <form action="guarda.php" method="post">

            <div class="row">

                <div class="col-6">

                    <label for="smtp">SMTP</label>

                    <input class="form-control" type="text" name="smtp" id="smtp" value="<?php echo $config['correo_smtp']; ?>">

                </div>



                <div class="col-6">

                    <label for="puerto">Puerto</label>

                    <input class="form-control" type="text" name="puerto" id="puerto" value="<?php echo $config['correo_puerto']; ?>">

                </div>

            </div>



            <div class="row">

                <div class="col-6">

                    <label for="email">Correo electrónico</label>

                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $config['correo_email']; ?>">

                </div>



                <div class="col-6">

                    <label for="password">Contraseña</label>

                    <input class="form-control" type="password" name="password" id="password" value="<?php echo $config['correo_password']; ?>">

                </div>

            </div>



            <div class="row">

                <div class="col-6">

                    <label for="cliente_id">Cliente ID</label>

                    <input class="form-control" type="text" name="cliente_id" id="cliente_id" value="<?php echo $config['cliente_id']; ?>">

                </div>

            </div>



            <div class="row mt-4">

                <div class="col-12">

                    <button type="submit" class="btn btn-primary">Guardar</button>

                </div>

            </div>

        </form>

    </div>

</main>



<?php require_once '../footer.php';?>

