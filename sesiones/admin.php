<?php 

session_start();

if (!$_SESSION['id_socio'] && !$_SESSION['nombre']){
    header ("Location: ../pages/login.php");
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

    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="fondo_nav">
        <div class="container-fluid nav_bar">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.webp" alt="logo" />
            </a>
            <div class="text-center">
                <a class="nav-link active text-center" id="inicio" aria-current="page" href="../index.php">Inicio</a>
            </div>
    </nav>
    <?php require "../lib/validar_login.php" ?>
    <div class="container-fluid caja rounded" id="">
        <div class="row">
            <div class="col-sm-6 caja col-center text-center rounded">
                    <h1>Hola <?php echo ucwords($_SESSION["nombre"]); ?> Bienvenido a la Administración </h1>
                    <img class='img-fluid img-thumbnail' height='750px' width='500px' src='../pages/<?php echo $_SESSION['imagen']; ?>' alt='foto-perfil'>

            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>