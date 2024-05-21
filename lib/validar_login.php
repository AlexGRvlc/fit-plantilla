<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config_conexion.php";
require_once "recoge.php";

spl_autoload_register(function ($clase) {
    require_once "$clase.php";
});

$true_password = false;


if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if ($email && $password) {
        $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $validar_email = $db->validarDatos('email', 'socios', $email);

        if ($validar_email !== 0) {
            $db->preparar("SELECT nombre, apellido, contrasena, email, imagen FROM socios WHERE email = '$email'");
            $db->ejecutar();
            $resultado = $db->resultado();

            $db_nombre = $resultado["nombre"];
            $db_apellido = $resultado["apellido"];
            $db_contrasena = $resultado["contrasena"];
            $db_email = $resultado["email"];
            $db_path_foto = $resultado["imagen"];

            if ($email === $db_email) {

                if ($password === $db_contrasena) { // no necesario, para más seguridad
                    $true_password = true;
                    echo  "<h1>Hola " . ucfirst($db_nombre) .  ucfirst($db_apellido) . " Bienbenid@ a la Administración</h1>";
                    echo "<img class='img-fluid img-thumbnail' height='500px' width='250px' src='../pages/" . $db_path_foto . "' alt='foto-perfil'>";
                    $db->cerrar();
                } else {
                    echo "Esta contraseña no coincide con la del usuario registrado.";
                }
            }
        } else {
            echo "este email no existe, por favor ingresa uno válido o registrate.";
        }
    } else {
        echo "Falta algo si o si...";
    }
}
