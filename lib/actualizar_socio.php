<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config_conexion.php";
require "validar_foto.php";
spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

$output = [];

if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $nombre_actualizado = $_POST["nombre"];
    $apellido_actualizado = $_POST["apellido"];
    $email_actualizado = $_POST["email"];
    $saldo_actualizado = $_POST["saldo"];
    $foto  = $_FILES["foto"];

    $foto_dir = "../pages/fotos/$nombre/"; 
    $path_foto = "{$foto_dir}profile.jpg"; 

    $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    $consulta = "UPDATE socios
                 SET nombre = ?,
                     apellido = ?,
                     email = ?, 
                     saldo = ?
                 WHERE id_socio = ?";

    $db->setConsulta($consulta);

    if ($db->setParam() === false) {
        $output = ["estado" => "fail", "msg" => "Error al preparar la consulta"];
        echo json_encode($output);
        exit;
    }

    $db->setParam()->bind_param(
        'sssii',
        $nombre_actualizado,
        $apellido_actualizado,
        $email_actualizado,
        $saldo_actualizado,
        $id
    );

    if ($foto["name"]) {
        if (validar_foto($nombre_actualizado, true)) {
            if ($db->setParam()->errno) {
                $output = ["estado" => "fail", "msg" => "Error al asignar parámetros"];
                echo json_encode($output);
                exit;
            }

            if ($db->ejecutar()) {
                $output = ["estado" => "ok", "msg" => "¡Actualización exitosa!"];
            } else {
                $output = ["estado" => "fail", "msg" => "Error al ejecutar la consulta"];
            }

            $db->despejar();
        }
    } else {
        if ($db->setParam()->errno) {
            $output = ["estado" => "fail", "msg" => "Error al asignar parámetros"];
            echo json_encode($output);
            exit;
        }

        if ($db->ejecutar()) {
            $output = ["estado" => "ok", "msg" => "¡Actualización exitosa!"];
        } else {
            $output = ["estado" => "fail", "msg" => "Error al ejecutar la consulta"];
        }

        $db->despejar();
        $db->cerrar();
    }

    echo json_encode($output);
    exit;
} else {
    $output = ["estado" => "fail", "msg" => "Error: ID no recibido", "path_foto" => $path_foto];
    echo json_encode($output);
    exit;
}

?>
