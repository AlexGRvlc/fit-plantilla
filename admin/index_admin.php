<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Admin</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    spl_autoload_register(function ($clase) {
        require_once "../lib/$clase.php";
    });


    if ($_POST) {
        $nombre = strtolower($_POST['nombre']);
        $apellido = strtolower($_POST['apellido']);
        $email = $_POST['email'];
        $password = $_POST['contrasena'];
        $confirm_pass = $_POST['confirm-contrasena'];
        $saldo = $_POST['saldo'];
        $foto = $_FILES['foto'];

        $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $validar_email = $db->validarDatos('email', 'socios', $email);
        $validar_pass = $db->validarDatos('contrasena', 'socios', $password);

        if (preg_match($expreg, $email)) {

            if ($validar_email == 0) {
            }
        }
    }

    ?>


    <nav class="navbar navbar-expand-lg bg-body-tertiary" id="fondo_nav">
        <div class="container-fluid nav_bar">
            <a class="navbar-brand" href="../index.php">
                <img src="../public/img/logo.webp" alt="logo" />
            </a>
            <div class="text-center">
                <a class="nav-link active text-center" id="inicio" aria-current="page" href="../index.php">Inicio</a>

            </div>
    </nav>

    <div class="container-fluid" id="">
        <div class="row">
            <div class="col-sm-6 caja col-center rounded">
                <form action="../admin/index_admin.php" method="POST" role="form" class="rounded">
                    <legend class="text-center">Admin</legend>
                    <div class="form-group mb-3">
                        <input name="email" type="text" class="form-control" id="" placeholder="usuario">
                    </div>

                    <div class="form-group mb-3">
                        <input name="contrasena" type="password" class="form-control" id="" placeholder="contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary rounded">Ingresar</button>
                    <a class="float-end" href="registro.php">Registrarse</a>
                </form>
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>