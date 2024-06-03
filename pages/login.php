<?php

session_start();
// Asegura el redireccionamiento si la sesión está iniciada
if ((isset($_SESSION['nombre']) && isset($_SESSION['id_socio']) && isset($_SESSION['rol'])) || isset($_COOKIE['nombre'])) {

    if (isset($_COOKIE['nombre'])) {
        $_SESSION['id_socio'] = $_COOKIE['id'];
        $_SESSION['nombre'] = $_COOKIE['nombre'];
        $_SESSION['rol'] = $_COOKIE['rol'];
    }

    header("Location: ../sesiones/admin.php");
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Log In</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary" id="fondo_nav">
        <div class="container-fluid nav_bar">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.webp" alt="logo" />
            </a>
            <div class="text-center">
                <a class="nav-link active text-center" id="inicio" aria-current="page" href="../index.php">Inicio</a>
            </div>
    </nav>

    <div class="container-fluid" id="fondo_login">
        <div class="row">

            <div class="col-sm-4 caja col-center rounded" id="login-form">
                <form id="formulario" method="POST" role="form" class="rounded">
                    <legend class="text-center">Log In</legend>
                    <div class='alerta alerta_error'>
                        <div class='alerta_icon'>
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class='alerta_wrapper'>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <input name="email" type="text" class="form-control" id="" placeholder="usuario">
                    </div>

                    <div class="form-group mb-3">
                        <input name="password" type="password" class="form-control" id="password" placeholder="contraseña">
                    </div>
                    <button type="button" id="btn_login" class="btn btn-primary rounded me-3">Ingresar</button>
                    <a class="float-end" href="registro.php">Registrarse</a>
                    <label for="sesion_activa" class="checkbox-inline">
                        <input name="sesion_activa" type="checkbox" value="activo"> Mantener sesión iniciada
                    </label>
                </form>
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>