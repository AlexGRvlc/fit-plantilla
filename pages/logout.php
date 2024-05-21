<?php

session_start();
session_unset();
session_destroy();

$caduca = time() - 95365;

if (isset($_COOKIE['nombre'])) {
    setcookie('id', $_SESSION['id_socio'], $caduca, "/");
    setcookie('nombre', $_SESSION['nombre'], $caduca, "/");
    setcookie('img', $_SESSION['imagen'], $caduca, "/");
}

header("Refresh:2; url=../index.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Log Out</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <a href="../"></a>
    <div class="container-fluid caja rounded" id="">
        <div class="row">
            <div class="col-sm-6 caja col-center text-center rounded">

                <h4>Has cerrado tu sesión.</h4>
            </div>
        </div>

    </div>