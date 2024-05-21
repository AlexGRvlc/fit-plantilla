<?php

session_start();

if ((isset($_SESSION['nombre']) && ($_SESSION['id_socio'])) || isset($_COOKIE['nombre'])) {

    if (isset($_COOKIE['nombre'])) {
        $_SESSION['id_socio'] = $_COOKIE['id'];
        $_SESSION['nombre'] = $_COOKIE['nombre'];
        $_SESSION['imagen'] = $_COOKIE['img'];
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

    <div class="container-fluid" id="fondo_login">
        <div class="row">
            <div class="col-sm-4 caja col-center rounded" id="login-form">
                <form action="../lib/validar_login.php" method="POST" role="form" class="rounded">
                    <legend class="text-center">Log In</legend>
                    <div class="form-group mb-3">
                        <input name="email" type="text" class="form-control" id="" placeholder="usuario">
                    </div>

                    <div class="form-group mb-3">
                        <input name="password" type="password" class="form-control" id="password" placeholder="contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary rounded me-3">Ingresar</button>
                    <a class="float-end" href="registro.php">Registrarse</a>
                    <label for="sesion_activa" class="checkbox-inline">
                        <input name="sesion_activa" type="checkbox" value="activo"> Mantener sesión iniciada
                    </label>
                </form>
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>