<?php session_start(); ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "config_conexion.php";
require_once "recoge.php";

spl_autoload_register(function ($clase) {
    require_once "$clase.php";
});

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    if ($email && $password) {
        $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $validar_email = $db->validarDatos('email', 'socios', $email);

        if ($validar_email !== 0) {
            $db->preparar("SELECT id_socio, CONCAT (nombre, ' ', apellido)  AS nombre_completo, contrasena, email, imagen FROM socios WHERE email = '$email'");
            $db->ejecutar();
            $resultado = $db->resultado();

            $db_id_socio = $resultado["id_socio"];
            $db_nombre_completo = $resultado["nombre_completo"];
            $db_contrasena = $resultado["contrasena"];
            $db_email = $resultado["email"];
            $db_path_foto = $resultado["imagen"];

            if ($email === $db_email) {

                if ($password === $db_contrasena) { 

                    $_SESSION['id_socio'] = $db_id_socio;
                    $_SESSION['nombre'] = $db_nombre_completo;
                    $_SESSION['imagen'] = $db_path_foto;

                    $db->cerrar();
                    header ("Location: ../sesiones/admin.php");
                    
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
