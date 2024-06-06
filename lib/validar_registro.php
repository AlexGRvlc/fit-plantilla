<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

ini_set('log_errors', "On");
ini_set('error_log', '/home/alex/Escritorio/debug.log');

error_log("Inicio del script validar_registro.php");

require_once "validar_foto.php";
require_once "config_conexion.php";
spl_autoload_register(function ($clase) {
    require_once "$clase.php";
});

global $form_ok;
$password_ok = false;
$output = [];
$path_foto = '';

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    error_log("Formulario enviado mediante POST");

    // Obtener datos del formulario
    $nombre = trim(strtolower($_POST['nombre'] ?? ''));
    $apellido = trim(strtolower($_POST['apellido'] ?? ''));
    $email = trim($_POST['email'] ?? "");
    $password = $_POST['contrasena'] ?? "";
    $confirm_pass = $_POST['confirm-contrasena'] ?? "";
    $saldo = $_POST['saldo'] ?? ""; // Convierte el saldo a tipo float floatval()
    $foto = $_FILES['foto'] ?? "";

    error_log("Datos recibidos: nombre=$nombre, apellido=$apellido, email=$email, saldo=$saldo");

    if ($nombre && $apellido && $email && $password && $confirm_pass && $saldo) {

        if (strlen($nombre) < 1 || strlen($nombre) > 20) {
            $output = ["error" => true, "tipo_error" => "El nombre debe tener entre 1 y 20 caracteres"];
            echo json_encode($output);
            exit;
        }

        if (!is_numeric($saldo) || $saldo <= 0) {
            $output = ["error" => true, "tipo_error" => "El saldo debe ser un número positivo"];
            echo json_encode($output);
            exit;
        }

        $expreg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        if (preg_match($expreg, $email)) {
            if (preg_match('/^(?=.*[A-Za-z])(?=.*\d).{6,}$/', $password)) {
                $password_ok = true;
            } else {
                $output = ["error" => true, "tipo_error" => "La contraseña debe tener al menos 6 caracteres y contener letras y números"];
                echo json_encode($output);
                exit;
            }
        } else {
            $output = ["error" => true, "tipo_error" => "Email erróneo, por favor, inténtalo de nuevo"];
            echo json_encode($output);
            exit;
        }
    } else {
        $output = ["error" => true, "tipo_error" => "Ninguno de los campos obligatorios puede quedar vacío"];
        echo json_encode($output);
        exit;
    }
}


if (isset($db)){


    // Verificar si el email ya está registrado
    $consulta_email = "SELECT COUNT(*) AS total FROM socios WHERE email = ?";
    $db->setConsulta($consulta_email);
    $db->setParam()->bind_param('s', $email);
    $db->ejecutar();
    $resultado_email = $db->getResultado();
    $total_registros = $resultado_email['total'];
    
    if ($total_registros > 0) {
        $output = ["error" => true, "tipo_error" => "Este email ya está registrado"];
        error_log("El email ya está registrado");
    } else {
        // Aquí puedes continuar con el proceso de inserción del nuevo usuario
        // Verificar si las contraseñas coinciden, validar la foto, etc.
    }

}








if ($password_ok) {
    if ($password === $confirm_pass) {
        error_log("Las contraseñas coinciden");

        $validar_email = $db->validarDatos('email', 'socios', $email);

        if ($validar_email === 0) {
            error_log("El email no está registrado");

            // Generando el hash/encriptación de la contraseña:
            $hasher = new PasswordHash(8, FALSE);
            $hash = $hasher->HashPassword($password);

            $path_foto = validar_foto($nombre);
            if ($path_foto) {
                error_log("Foto validada: $path_foto");




                








                $fecha = time();
                $consulta = "INSERT INTO socios (nombre, apellido, contrasena, email, saldo, imagen, fecha) VALUES (?, ?, ?, ?, ?, ?, ?)";
                if ($db->setConsulta($consulta)) {
                    $db->setParam()->bind_param('ssssisi', $nombre, $apellido, $hash, $email, $saldo, $path_foto, $fecha);
                    if ($db->ejecutar()) {
                        $output = ["error" => false, "tipo_error" => "", "path_foto" => $path_foto];
                        $form_ok = true;
                        $db->cerrar();
                        error_log("Registro insertado correctamente");
                    } else {
                        $output = ["error" => true, "tipo_error" => "Error al ejecutar la consulta."];
                        error_log("Error al ejecutar la consulta");
                    }
                } else {
                    $output = ["error" => true, "tipo_error" => "Error al preparar la consulta."];
                    error_log("Error al preparar la consulta");
                }               
            } else {
                $output = ["error" => true, "tipo_error" => "Ha ocurrido un error"];
                error_log("Error al validar la foto");
            }
        } else {
            $output = ["error" => true, "tipo_error" => "Este email ya está registrado"];
            error_log("El email ya está registrado");
        }
    } else {
        $output = ["error" => true, "tipo_error" => "Las contraseñas no coinciden"];
        error_log("Las contraseñas no coinciden");
    }
} else {
    error_log("Contraseña no válida o no se ha enviado el formulario");
}

// Modifica la salida JSON para incluir el path_foto
if ($form_ok) {
    $output = ["error" => false, "tipo_error" => "", "path_foto" => $path_foto];
} else {
    $output["path_foto"] = $path_foto; 
}
$db->cerrar();

$json = json_encode($output);
echo $json;
error_log("Fin del script validar_registro.php");

?>
