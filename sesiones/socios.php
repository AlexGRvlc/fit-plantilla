<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // inicio de sesión

// Recursos de apoyo
require_once "../lib/config_conexion.php";
require_once "../lib/date.php";
require "../lib/validar_login.php";
spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

if (!$_SESSION['id_socio'] && !$_SESSION['nombre'] && !$_SESSION['rol']) {
    header("Location: ../index.php");
    exit;
}



$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME); // instanciando clase mysqli

$socio_id = $_SESSION["id_socio"]; // Sacar la id del usuario para parámetro consulta

// Se requiere el nombre de usuario y su imagen 
// para el panel/pantalla de registrad@
$db->setConsulta("SELECT 
                id_socio,
                CONCAT(nombre, ' ', apellido) AS nombre_completo,
                imagen
                FROM socios
                WHERE id_socio = ?");

$db->setParam()->bind_param('i', $socio_id); // agregando parámetro a la consulta
$db->ejecutar();                         // ejecutando la consulta a la bd
// Obteniendo variables
$resultado = $db->getResultado();
$sesion_id = $resultado['id_socio'];
$nombre_socio = $resultado['nombre_completo'];
$imagen_socio = $resultado['imagen'];
// Liberar la info almacenada en la llamada a BD
$db->despejar();

// Para sacar variables a mostrar en el panel de administrador/a
// de la info de los n últimos socios registrados
$db->setConsulta("SELECT 
                CONCAT (nombre, ' ', apellido)  AS nombre_completo, 
                email, 
                saldo, 
                fecha 
                FROM socios 
                ORDER BY fecha DESC LIMIT 10 ");
$db->ejecutar();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Zona Socio</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" id="fondo_nav">
        <div class="container-fluid nav_bar">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.webp" alt="logo" />
            </a>
            <div class="text-center">
                <a id="logout" class="nav-link active text-center" href="#">Cerrar Sesión<i class="bi bi-box-arrow-in-right"></i></a>

            </div>
        </div>
    </nav>


    <div class="container-fluid p-0">
        <div class="left">
            <div class="usuario">
                <img class='img__usuario rounded-circle' src='../pages/<?php echo $imagen_socio; ?>' alt='foto-perfil'>
            </div>
            <div class="nombre__usuario">
                <h4 class="text-center"><?php echo ucwords($nombre_socio); ?></h4>
            </div>
        </div>

        <div class="right">


    <div class="caja">
        <h1>Zona Socios</h1>
    </div>





                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>




    <?php require '../inc/footer.inc'; ?>