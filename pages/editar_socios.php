<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once "../lib/config_conexion.php";
require_once "../lib/date.php";

spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

if (!$_SESSION['id_socio'] && !$_SESSION['nombre']) {
    header("Location: ../index.php");
    exit;
}

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$socio_id = $_SESSION["id_socio"];

$db->preparar("SELECT 
                id_socio,
                CONCAT(nombre, ' ', apellido) AS nombre_completo,
                imagen
                FROM socios
                WHERE id_socio = ?");

$db->prep()->bind_param('i', $socio_id);
$db->ejecutar();

$resultado = $db->resultado();

$sesion_id = $resultado['id_socio'];
$nombre_socio = $resultado['nombre_completo'];
$imagen_socio = $resultado['imagen'];
$db->despejar();



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FitGim | Editar</title>
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
            <a href="editar_socios.php">
                <i class="bi bi-box-arrow-in-up-right">Editar</i>
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
                <img class='img__usuario rounded-circle' src='../pages/<?php echo $imagen_socio; ?>' alt='foto-perfil'>
            </div>
            <div class="nombre__usuario">
                <h4 class="text-center"><?php echo ucwords($nombre_socio); ?></h4>
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

            <?php if (isset($_GET["editar"])) : ?>

                <div class="row">
                    <div class="col-sm-5">


                        <?php

                        $id = $_GET["editar"];
                        
                        if (isset($_GET["editar"])) {
                            $id = $_GET["editar"];
                        
                            // Obtener los datos del socio a editar
                            $datos_socio = $db->getSocioPorId($id);
                        
                            // Vincular los datos obtenidos al formulario
                            $editar_nombre = $datos_socio['nombre'];
                            $editar_apellido = $datos_socio['apellido'];
                            $editar_email = $datos_socio['email'];
                            $editar_saldo = $datos_socio['saldo'];
                            $editar_imagen = $datos_socio['imagen'];
                        }
                        



                        // $db->despejar();


                        ?>

                        <form action="../lib/actualizar_socio.php" enctype="multipart/form-data" method="POST" role="form" class="rounded" id="registro_form">
                            <legend class="text-center">Editar Socio</legend>

                            <div class="form-group mb-3">
                                <input name="id" id="id" type="hidden" class="form-control" value="<?php echo $id; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <input name="nombre" id="nombre" type="text" class="form-control" value="<?php echo $editar_nombre; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <input name="apellido" type="text" class="form-control" id="" value="<?php echo $editar_apellido; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <input name="email" type="mail" class="form-control" id="" value="<?php echo $editar_email; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <input name="saldo" type="number" min="50" class="form-control" id="" placeholder="saldo" value="<?php echo $editar_saldo; ?>">
                            </div>

                            <div class="input-group mb-3">
                                <p>Selecciona tu imagen de perfil (opcional)</p>
                                <input name="foto" type="file" class="form-control rounded" id="foto">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary rounded">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>


            <?php else : ?>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="caja">
                            <div class="caja-cabecera">
                                <h1><i class="bi bi-people"></i>Edita o elimina algún socio</h1>
                            </div>
                            <div class="caja-cuerpo">
                                <table class="table table-cell">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Saldo</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php


                                        $db->preparar("SELECT 
                                            id_socio,
                                            CONCAT (nombre, ' ', apellido)  AS nombre_completo, 
                                            email, 
                                            saldo, 
                                            fecha 
                                            FROM socios 
                                            ORDER BY fecha");
                                        $db->ejecutar();
                                        $resultado = $db->resultado();


                                        $contador = 0;
                                        while ($row = $db->resultado()) {
                                            $contador++;
                                            $fechaFormateada = date('d - m - Y', $row['fecha']);
                                            echo "<tr>
                                                <td>$contador</td>
                                                <td>{$row['nombre_completo']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['saldo']}</td>                 
                                                <td>$fechaFormateada</td>                 
                                                <td>
                                                <a href='editar_socios.php?editar={$row['id_socio']}' class='btn btn-success'>Editar</a>
                                                <a href='editar_socios.php?eliminar={$row['id_socio']}' class='btn btn-warning'>Eliminar</a>
                                                </td>                 
                                            </tr>";
                                        }

                                        $db->despejar();

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    <?php endif; ?>

    </div>

    </div>
    </div>
    <?php require '../inc/footer.inc'; ?>