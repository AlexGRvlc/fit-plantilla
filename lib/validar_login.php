<!-- <?php session_start(); ?>  -->

<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
            // $fecha = time();
            $db->setConsulta("SELECT id_socio, CONCAT (nombre, ' ', apellido)  AS nombre_completo, contrasena, email, rol, fecha FROM socios WHERE email = ?");
            $db->setParam()->bind_param('s', $email);
            $db->ejecutar();
            $resultado = $db->getResultado();

            $db_id_socio = $resultado["id_socio"];
            $db_nombre_completo = $resultado["nombre_completo"];
            $db_contrasena = $resultado["contrasena"];
            $db_email = $resultado["email"];
            $db_path_foto = $resultado["imagen"];
            $db_rol = $resultado["rol"];

            if ($email === $db_email) {

                if ($password === $db_contrasena) { 

                    $_SESSION['id_socio'] = $db_id_socio;
                    $_SESSION['nombre'] = $db_nombre_completo;
                    $_SESSION['rol'] = $db_rol;

                    $caduca = time()+365*24*60*60;

                    if ( $_POST['sesion_activa'] === 'activo' ){
                        setcookie('id', $_SESSION['id_socio'], $caduca, "/");
                        setcookie('nombre', $_SESSION['nombre'], $caduca, "/");
                        setcookie('rol', $_SESSION['rol'], $caduca, "/");
                    }

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
