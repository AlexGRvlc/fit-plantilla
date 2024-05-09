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
    <div class="row"  >
        <div class="col-sm-6 caja col-center rounded" >
            <form action="" method="POST" role="form" class="rounded">
                <legend class="text-center">Log In</legend>
                <div class="form-group mb-3">
                    <input type="text" class="form-control" id="" placeholder="usuario">
                </div>

                <div class="form-group mb-3">
                    <input type="password" class="form-control" id="" placeholder="contraseña">
                </div>
                <button type="submit" class="btn btn-primary rounded">Ingresar</button>
                <a class="float-end" href="registro.php">Registrarse</a>
            </form>
        </div>
    </div>

</div>

<?php require '../inc/footer.inc'; ?>