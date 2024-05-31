<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Requerimientos de apoyo
require_once "../lib/config_conexion.php";
require_once "../lib/date.php";
require_once "../lib/validar_foto.php";
require "../lib/validar_login.php";
require_once "../lib/borrar_foto.php";
spl_autoload_register(function ($clase) {
    require_once "../lib/$clase.php";
});

// Comprobación de que el usuario existe y tiene una 
// sesión abierta
if (!$_SESSION['id_socio'] && !$_SESSION['nombre']) {
    header("Location: ../index.php");
    exit;
}

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME); // instanciación de Obj sql

$socio_id = $_SESSION["id_socio"];

// Como en admin necesitamos la info de la BD
// para el nombre y foto del usuario en el panel
$db->setConsulta("SELECT 
                id_socio,
                CONCAT(nombre, ' ', apellido) AS nombre_completo,
                imagen
                FROM socios
                WHERE id_socio = ?");

$db->setParam()->bind_param('i', $socio_id);
$db->ejecutar();

$resultado = $db->getResultado();

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
            <a href="../sesiones/admin.php">
                <i class="bi bi-box-arrow-in-up-right">Administración</i>
            </a>
            <div class="text-center">
                <!-- <a class="nav-link active text-center" id="inicio" aria-current="page" href="../index.php">Inicio</a> -->
                <a class="nav-link active text-center" href="../pages/logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

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

            <!-- 
            4 Opciones:
                1 - Editar socio > formulario 
                2 - Confirmar eliminar
                3 - Eliminar
                4 - Mostrar los socios con las opciones 
            -->
            <!-- 1 -->
            <?php if (isset($_GET["editar"])) : ?>

                <div class="row">
                    <div class="col-sm-5">

                        <?php

                        $id = $_GET["editar"];

                        if (isset($_GET["editar"])) {
                            $id = $_GET["editar"];  // Redundante!

                            // Obtener los datos del socio a editar
                            $datos_socio = $db->getSocioPorId($id);

                            // Vincular los datos obtenidos al formulario
                            $editar_nombre = $datos_socio['nombre'];
                            $editar_apellido = $datos_socio['apellido'];
                            $editar_email = $datos_socio['email'];
                            $editar_saldo = $datos_socio['saldo'];
                            $editar_imagen = $datos_socio['imagen'];
                        }
                        $db->despejar();

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
                                <a href="editar_socios.php" class="btn btn-warning rounded">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 2 -->
            <?php elseif (isset($_GET["confir_eliminar"])) : ?>

                <div class="row justify-content-center">
                    <div class="col-sm-5">
                        <div class="caja text-center ">
                            <h2>¿Seguro deseas eliminarlo?</h2>
                            <a class="btn btn-danger" href='<?php echo "editar_socios.php?eliminar={$_GET['confir_eliminar']}"; ?>'>Sí</a>
                            <a class="btn btn-warning" href="editar_socios.php">No</a>
                        </div>
                    </div>
                </div>

                <!-- 3 -->
            <?php elseif (isset($_GET["eliminar"])) : ?>

                <div class="row justify-content-center">
                    <div class="col-sm-5">
                        <div class="caja text-center ">

                            <?php

                            $eliminar_id_socio = $_GET["eliminar"];

                            $db->setConsulta("SELECT 
                                                nombre
                                                FROM socios
                                                WHERE id_socio = ?");

                            $db->setParam()->bind_param('i', $eliminar_id_socio);
                            $db->ejecutar();
                            $resultado = $db->getResultado();
                            $name = $resultado['nombre'];
                            $db->despejar();


                            $db->setConsulta("DELETE 
                                                FROM socios 
                                                WHERE id_socio = ?");

                            $db->setParam()->bind_param('i', $eliminar_id_socio);
                            $db->ejecutar();

                            if ($db->getFilasAfectadas() > 0) {
                                echo "Socio eliminado";

                                header("Refresh:2; url=editar_socios.php");
                                borrarFoto("../pages/fotos/$name");
                            }

                            $db->despejar();

                            ?>


                        </div>
                    </div>
                </div>


                <!-- 4 -->
            <?php else : ?>


                <div class="row">
                    <div class="col-sm-12">
                        <div class="caja">
                            <div class="caja-cabecera">
                                <h1><i class="bi bi-people"></i>Edita o elimina algún socio</h1>

                                <!-- MODIFICAR -->
                                <div class="col-sm-4 float-end">
                                    <form action="" id="busqueda" method="GET">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="busqueda" placeholder="Ingrese su búsqueda">
                                            <!-- <input type="text" placeholder="Ingrese su búsqueda"> -->
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Button</button>
                                        </div>
                                    </form>
                                </div>


                            </div>
                            <div class="caja">
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

                                        // consulta para contar el número total de socios
                                        // para la paginación
                                        $db->setConsulta("SELECT
                                            COUNT(id_socio) AS total_socios
                                            FROM socios");
                                        $db->ejecutar();
                                        $resultado = $db->getResultado();
                                        $total_socios = $resultado["total_socios"];
                                        $db->despejar();




                                        if (isset($_GET["busqueda"])) {

                                            if (empty($_GET["busqueda"])) {
                                                echo "Error";
                                                exit;
                                            }

                                            $porPagina = 5;           // socios_x_pagina 
                                            $paginas = ceil($total_socios / $porPagina);             // nº total páginas
                                            $pagina = (isset($_GET["pagina"])) ? (int)$_GET['pagina'] : 1;     // página actual
                                            $inicio = ($pagina - 1) * $porPagina; // indice de inicio xra consulta paginada


                                            $consulta = "SELECT 
                                            id_socio,
                                            CONCAT(nombre, ' ', apellido) AS nombre_completo, 
                                            email, 
                                            saldo, 
                                            fecha 
                                            FROM socios 
                                            WHERE 1=1";

                                            $busqueda_nombres = explode(" ", $_GET["busqueda"]);

                                            $condiciones = [];
                                            foreach ($busqueda_nombres as $nombre) {
                                                $condiciones[] = "nombre LIKE '%" . $nombre . "%'";
                                            }

                                            if (count($condiciones) > 0) {
                                                $consulta .= " AND (" . implode(" OR ", $condiciones) . ")";
                                            }

                                            $consulta .= " ORDER BY fecha LIMIT $inicio, $porPagina";
                                            $db->setConsulta($consulta);



                                            // paginación búsqueda
                                            $consulta_busqueda = "SELECT 
                                                                      id_socio,
                                                                      CONCAT(nombre, ' ', apellido) AS nombre_completo, 
                                                                      email, 
                                                                      saldo, 
                                                                      fecha 
                                                                  FROM socios 
                                                                  WHERE ";

                                            $condiciones = [];
                                            foreach ($busqueda_nombres as $nombre) {
                                                $condiciones[] = "nombre LIKE '%" . $nombre . "%'";
                                            }

                                            if (count($condiciones) > 0) {
                                                $consulta_busqueda .= implode(" OR ", $condiciones);
                                            } else {
                                                // Si no hay condiciones, seleccionar todos los socios
                                                $consulta_busqueda .= "1";
                                            }

                                            // Consulta de conteo
                                            $consulta_contador = "SELECT COUNT(id_socio) AS contador FROM socios WHERE ";

                                            if (count($condiciones) > 0) {
                                                $consulta_contador .= implode(" OR ", $condiciones);
                                            } else {
                                                // Si no hay condiciones, contar todos los socios
                                                $consulta_contador .= "1";
                                            }

                                            // Ejecutar la consulta de conteo
                                            $db->setConsulta($consulta_contador);
                                            $db->ejecutar();
                                            $resultado_contador = $db->getResultado();

                                            // Obtener el valor del conteo
                                            $contador = intval($resultado_contador["contador"]);

                                            $consulta_busqueda .= " ORDER BY fecha LIMIT $inicio, $porPagina";

                                            // Ejecutar la consulta para obtener los resultados de búsqueda
                                            $db->setConsulta($consulta_busqueda);
                                            $db->ejecutar();

                                            // Mostrar los resultados
                                            while ($fila = $db->getResultado()) {
                                                // Procesar y mostrar cada fila de resultado aquí
                                                // Ejemplo: echo $fila["id_socio"], $fila["nombre_completo"], etc.
                                            }

                                            echo "Total de resultados: " . $contador;
                                        } else {

                                            $porPagina = 5;           // socios_x_pagina 
                                            $paginas = ceil($total_socios / $porPagina);             // nº total páginas
                                            $pagina = (isset($_GET["pagina"])) ? (int)$_GET['pagina'] : 1;     // página actual
                                            $inicio = ($pagina - 1) * $porPagina; // indice de inicio xra consulta paginada

                                            // Datos necesarios para paginar las salidas de socios
                                            // por pantalla. 
                                            $consulta = "SELECT 
                                            id_socio,
                                            CONCAT (nombre, ' ', apellido)  AS nombre_completo, 
                                            email, 
                                            saldo, 
                                            fecha 
                                            FROM socios 
                                            ORDER BY fecha
                                            LIMIT $inicio, $porPagina";
                                            $db->setConsulta($consulta);
                                        }





                                        $db->ejecutar();
                                        $contador = $inicio;

                                        // Creación de la tabla con los resultados de BD
                                        while ($row = $db->getResultado()) {
                                            $contador++;
                                            $fechaFormateada = date('d - m - Y', $row['fecha']);
                                            echo "<tr>
                                                <td>$contador</td>
                                                <td>{$row['nombre_completo']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['saldo']}</td>                 
                                                <td>$fechaFormateada</td>                 
                                                <td>
                                                <a href='editar_socios.php?editar={$row['id_socio']}' class='btn btn-success acciones'>
                                                <i class='bi bi-box-arrow-in-up-right'></i>
                                                </a>
                                                <a href='editar_socios.php?confir_eliminar={$row['id_socio']}' class='btn btn-danger acciones'>
                                                <i class='bi bi-x-circle'></i>
                                                </a>
                                                </td>                 
                                            </tr>";
                                        }

                                        $db->despejar();

                                        ?>
                                    </tbody>
                                </table>
                                <?php

                                $anterior = ($pagina - 1);
                                $siguiente = ($pagina + 1);



                                ?>

                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center"> <!-- Centra los elementos de la paginación -->

                                        <!-- 
                                        Opciones para mostrar o no los iconos de previo/posterior
                                        Op-2 -> se muetra o no el de previo 
                                        -->
                                        <?php if ($pagina > 1) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href='<?php echo "?pagina=$anterior"; ?>' aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>

                                        <?php
                                        // Se muestra la página activa y el total
                                        if ($paginas >= 1) {
                                            for ($x = 1; $x <= $paginas; $x++) {
                                                echo ($x == $pagina) ? "<li class='page-item active'><a class='page-link' href='?pagina=$x'>$x</a></li>"
                                                    : "<li class='page-item'><a class='page-link' href='?pagina=$x'>$x</a></li>";
                                            }
                                        }
                                        ?>
                                        <!-- Op-2 -> se muetra o no el de anterior -->
                                        <?php if ($pagina < $paginas) : ?>
                                            <li class="page-item">
                                                <a class="page-link" href='<?php echo "?pagina=$siguiente"; ?>' aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
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