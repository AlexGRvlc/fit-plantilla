<?php
require_once "../lib/config_conexion.php";
require_once "../lib/borrar_foto.php";
spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

$output = [];
$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST["eliminar"])) {

    $eliminar = $_POST["eliminar"];

    $db->setConsulta("SELECT 
                        nombre
                    FROM socios
                    WHERE id_socio = ?");

    $db->setParam()->bind_param('i', $eliminar);
    $db->ejecutar();
    $resultado = $db->getResultado();
    $name = $resultado['nombre'];
    $db->despejar();


    $db->setConsulta("DELETE 
                      FROM socios 
                      WHERE id_socio = ?");

    $db->setParam()->bind_param('i', $eliminar);
    $db->ejecutar();

    if ($db->getFilasAfectadas() > 0) {
        borrarFoto("../pages/fotos/$name");
        $output = ["estado"  => "ok", "msg" => "Socio Eliminado"];
    } else {
        $output = ["estado" => "fail", "msg" => "Hubo un error inesperado"];
    }

    $json = json_encode($output);

    echo $json;

    $db->despejar();

    exit;
} else {
    error_log("No se recibió el parámetro 'eliminar'");
    $output = ["estado" => "fail", "msg" => "No se recibió el parámetro 'eliminar'"];
    echo json_encode($output);
    exit;
}

?>
    <?php require '../inc/footer.inc'; ?>
