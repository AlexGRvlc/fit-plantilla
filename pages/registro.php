<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Registro</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<?php require_once "../lib/validar_registro.php" ?>

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


                <?php if ($form_ok) : ?>

                    <div class="caja text-center">
                        <h2>Saludos <?php echo $nombre ?></h2>
                        <img class="img-fluid text-center" height="200px" width="150px" src="<?php echo $path_foto ?>" alt="foto-perfil">
                        <p>Te has registrado con éxito, haz click en el botón para loguearte!</p>
                        <a href="login.php" class="btn btn-primary rounded">Ingresa como soci@!</a>
                    </div>


                <?php else : ?>

                    <form action="" enctype="multipart/form-data" method="POST" role="form" class="rounded" id="registro_form">
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
                            <input name="foto" type="file" class="form-control rounded" id="foto">
                        </div>
                        <button type="submit" class="btn btn-primary rounded">Aceptar</button>
                        <a class="float-end" href="login.php">Ya estoy registrado</a>
                    </form>

                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>