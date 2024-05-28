<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config_conexion.php";
require "validar_foto.php";

spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $nombre_actualizado = $_POST["nombre"];
    $apellido_actualizado = $_POST["apellido"];
    $email_actualizado = $_POST["email"];
    $saldo_actualizado = $_POST["saldo"];

    $foto_actualizada = validar_foto($id, true);
    
    $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $consulta = "UPDATE socios
                 SET nombre = ?,
                     apellido = ?,
                     email = ?, 
                     saldo = ?
                 WHERE id_socio = ?";

    $db->preparar($consulta);

    if ($db->prep() === false) {
        echo "Error al preparar la consulta: " ;
    }

    $db->prep()->bind_param(
        'sssii',
        $nombre_actualizado,
        $apellido_actualizado,
        $email_actualizado,
        $saldo_actualizado,
        $id
    );

    if ($db->prep()->errno) {
        echo "Error al asignar parámetros: " ;
    }

    if ($db->ejecutar()) {
        echo "¡Actualización exitosa!";
        header("Refresh:2; url=../pages/editar_socios.php");
    } else {
        echo "Error al ejecutar la consulta: ";
    }
    
    $db->despejar();
} else {
    echo "Error: ID no recibido.";
}
?>
