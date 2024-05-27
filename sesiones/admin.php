<?php

session_start();

if (!$_SESSION['id_socio'] && !$_SESSION['nombre']) {
    header("Location: ../index.php");
    exit;
}

$nombre = $_SESSION['nombre'];
$imagen = $_SESSION['imagen'];

$fecha = getdate();
$dia_date = date("d");
$anyo = date("Y");
$meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
$dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
$dia = $dias[$fecha["wday"]];
$mes = $meses[$fecha["mon"]-1];


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Admin</title>
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
                <div class="fecha float-end">
                    <i class="bi bi-calendar3"></i>
                    <span><?php echo "$dia $dia_date $mes, $anyo"; ?></span>
                </div>
            </div>



            <div class="container-fluid " id="panel">
                <div class="row" id="paneles">
    
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="panel">
                            <div class="icono  i_red">
                            <i class="bi bi-people"></i>
                            </div>
                            <div class="valor">
                                <h1 class="cantidad_socios">152</h1>
                                <p>Socios</p>
                            </div>
                        </div>    
                    </div>
    
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="panel">
                            <div class="icono  i_blue">
                            <i class="bi bi-people"></i>
                            </div>
                            <div class="valor">
                                <h1 class="cantidad_socios">152</h1>
                                <p>Socios</p>
                            </div>
                        </div>    
                    </div>
    
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="panel">
                            <div class="icono  i_green">
                            <i class="bi bi-people"></i>
                            </div>
                            <div class="valor">
                                <h1 class="cantidad_socios">152</h1>
                                <p>Socios</p>
                            </div>
                        </div>    
                    </div>
    
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="panel">
                            <div class="icono  i_yellow">
                            <i class="bi bi-people"></i>
                            </div>
                            <div class="valor">
                                <h1 class="cantidad_socios">152</h1>
                                <p>Socios</p>
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="caja">
                                <div class="caja-cabecera"> 
                                    <h1>Últimos usuarios registrados</h1>
                                </div>
                                <div class="caja-cuerpo"></div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
   
   
   
   
    </div>




    <?php require '../inc/footer.inc'; ?>