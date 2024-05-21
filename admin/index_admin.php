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

    <div class="container-fluid caja rounded" id="">
        <div class="row">
            <div class="col-sm-6 caja col-center text-center rounded">
            <?php require_once "../lib/validar_login.php"; ?>
            <?php if ($true_password) : ?>
                   
                
                </div>
            <?php else :
            endif; ?>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>