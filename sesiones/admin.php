<?php

session_start();

if (!$_SESSION['id_socio'] && !$_SESSION['nombre']) {
    header("Location: ../index.php");
    exit;
}

$nombre = $_SESSION['nombre'];
$imagen = $_SESSION['imagen'];

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top" id="fondo_nav">
        <div class="container-fluid nav_bar">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.webp" alt="logo" />
            </a>
            <div class="text-center">
                <!-- <a class="nav-link active text-center" id="inicio" aria-current="page" href="../index.php">Inicio</a> -->
                <a class="nav-link active text-center" href="../pages/logout.php">Cerrar Sesión</a>

            </div>
        </div>
    </nav>
    <?php require "../lib/validar_login.php" ?>

    <div class="container-fluid p-0">






        <div class="left">
            <div class="usuario">
                <img class='img__usuario rounded-circle' src='../pages/<?php echo $_SESSION['imagen']; ?>' alt='foto-perfil'>
            </div>
            <div class="nombre__usuario">
                <h4 class="text-center"><?php echo ucwords($_SESSION["nombre"]); ?></h4>
            </div>
        </div>
    
        <div class="right">
            <div class="cabecera">
                <div class="titulo">
                    <h1>Administración</h1>
                    <small>Bienvenido a la administración de usuarios</small>
                </div>
            </div>
        </div>
   
   
   
   
    </div>



    <div class="container-fluid caja rounded" id="">
        <div class="row">
            <div class="col-sm-6 caja col-center text-center rounded">

            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>