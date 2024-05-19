<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Registro</title>
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

    <div class="container-fluid" id="fondo_registro">
        <div class="row">
            <div class="col-sm-6 caja col-center rounded">


                <?php

                error_reporting(E_ALL);
                ini_set('display_errors', 1);


                require_once "../lib/validar_foto.php";
                require_once "../lib/config_conexion.php";
                spl_autoload_register(function ($clase) {
                    require_once "../lib/$clase.php";
                });
                global $ok;
                
                // Verificar si se ha enviado el formulario
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // Obtener datos del formulario
                    $nombre = strtolower($_POST['nombre']);
                    $apellido = strtolower($_POST['apellido']);
                    $email = $_POST['email'];
                    $password = $_POST['contrasena'];
                    $confirm_pass = $_POST['confirm-contrasena'];
                    $saldo = $_POST['saldo'];
                    $foto = $_FILES['foto'];
                
                    $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                    if ($nombre && $apellido && $email && $password && $confirm_pass && $saldo) {
                
                        $expreg = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
                
                        if (preg_match($expreg, $email)) {
                
                            if (strlen($password) > 6) {
                
                                if ($password == $confirm_pass) {
                
                                    $validar_email = $db->validarDatos('email', 'socios', $email);
                
                                    if ($validar_email == 0) {
                
                                        if (validar_foto($nombre)) {
                                            $consulta = "INSERT INTO socios (nombre, apellido, contrasena, email, saldo) VALUES (?, ?, ?, ?, ?)";
                                            if ($db->preparar($consulta)) {
                                                $db->prep()->bind_param('ssssd', $nombre, $apellido, $password, $email, $saldo);
                                                if ($db->ejecutar()) {
                                                    echo "Te has registrado con éxito!";
                                                    $ok = true;
                                                } else {
                                                    echo "Error al ejecutar la consulta.";
                                                }
                                            } else {
                                                echo "Error al preparar la consulta.";
                                            }
                                        } else {
                                            echo $error;
                                        }
                                    } else {
                                        echo "Ese email ya está registrado!";
                                    }
                                } else {
                                    echo "Las contraseñas no coinciden!";
                                }
                            } else {
                                echo "La contraseña debe ser mayor a 6 caracteres";
                            }
                        } else {
                            echo "email erróneo!";
                        }
                    } else {
                        echo "<br>algo falla...";
                    }
                }
                ?>

                <?php if ( $ok ) : ?>

                    <h2>Saludos <?php echo $nombre ?></h2>
                    <img class="img-fluid text-center" src="<?php echo $path_foto ?>" alt="foto-perfil">
                    <p>Te has registrado con éxito, haz click en el botón para bloguearte!</p>

                    <?php else : ?>

                <form action="" enctype="multipart/form-data" method="POST" role="form" class="rounded">
                    <legend class="text-center">Registro</legend>

                    <div class="form-group mb-3">
                        <input name="nombre" id="nombre" type="text" class="form-control" id="" placeholder="Nombre" require>
                    </div>

                    <div class="form-group mb-3">
                        <input name="apellido" type="text" class="form-control" id="" placeholder="Apellido" require>
                    </div>

                    <div class="form-group mb-3">
                        <input name="email" type="mail" class="form-control" id="" placeholder="e-mail" require>
                    </div>

                    <div class="form-group mb-3">
                        <input name="contrasena" type="text" class="form-control" id="" placeholder="Contraseña" require>
                    </div>

                    <div class="form-group mb-3">
                        <input name="confirm-contrasena" type="text" class="form-control" id="" placeholder="Confirmar Contraseña" require>
                    </div>

                    <div class="form-group mb-3">
                        <input name="saldo" type="number" min="50" class="form-control" id="" placeholder="Ingresar Saldo" require>
                    </div>

                    <div class="input-group mb-3">
                        <p>Selecciona tu imagen de perfil (opcional)</p>
                        <input name="foto" type="file" class="form-control" id="foto">
                    </div>
                    <button type="submit" class="btn btn-primary rounded">Aceptar</button>
                    <a class="float-end" href="login.php">Ya estoy registrado</a>
                </form>

                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>