<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once "validar_foto.php";
require_once "config_conexion.php";
spl_autoload_register(function ($clase) {
    require_once "$clase.php";
});
global $form_ok;
$password_ok = false;

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener datos del formulario
    $nombre = strtolower($_POST['nombre'] ?? '');
    $apellido = strtolower($_POST['apellido'] ?? '');
    $email = $_POST['email'];
    $password = $_POST['contrasena'];
    $confirm_pass = $_POST['confirm-contrasena'];
    $saldo = $_POST['saldo'];
    $foto = $_FILES['foto'];

    if ($nombre && $apellido && $email && $password && $confirm_pass && $saldo) {
        $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $expreg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        if (preg_match($expreg, $email)) { // preg_match - comparación con expresión regular

            if (strlen($password) > 6) {

                $password_ok = true;
            } else {
                echo "La contraseña debe ser mayor a 6 caracteres";
            }
        } else {
            echo "email erróneo!";
        }
    } else {
        echo "<br>algo falla...";
    }
}

if ($password_ok) {
    if ($password === $confirm_pass) {

        $validar_email = $db->validarDatos('email', 'socios', $email);

        if ($validar_email === 0) {

            // Generando el hash/encriptación de la contraseña:
            $hasher =  new PasswordHash(8, FALSE);
            $hash = $hasher->HashPassword($password);

            $path_foto = validar_foto($nombre);
            if ($path_foto) {
                $fecha = time();
                $consulta = "INSERT INTO socios (nombre, apellido, contrasena, email, saldo, imagen, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)";
                if ($db->setConsulta($consulta)) {
                    $db->setParam()->bind_param('ssssisi', $nombre, $apellido, $hash, $email, $saldo, $path_foto, $fecha);
                    if ($db->ejecutar()) {
                        echo "Te has registrado con éxito!";
                        $form_ok = true;
                        $db->cerrar();
                    } else {
                        echo "Error al ejecutar la consulta.";
                    }
                } else {
                    echo "Error al preparar la consulta.";
                }
            } else {
                echo $error;
            }
        } else {
            echo "Ese email ya está registrado!";
        }
    } else {
        echo "Las contraseñas no coinciden!";
    }
}
