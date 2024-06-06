<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// session_start();

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
if (!$_SESSION['id_socio'] && !$_SESSION['nombre'] && !$_SESSION['rol']) {
    header("Location: ../index.php");
    exit;
}

// En caso de entrar con rol de registrado la aplicación se redireccionará 
// al inicio, al index
if ($_SESSION["rol"] == "registrado") {
    header("Location: ../sesiones/socios.php");
    exit;
}

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT); // instanciación de Obj sql

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

$sesion_id = $_SESSION['id_socio'] ?? "";
$nombre_socio = $_SESSION['nombre'] ?? "";
$imagen_socio = $_SESSION['imagen'] ?? "";
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
            <a class="nav-link editar-nav" href="../sesiones/admin.php">
                <i class="bi bi-box-arrow-in-up-right">Administración</i>
            </a>
            <div class="text-center cerrar-nav">
                <a class="nav-link active text-center" href="../pages/logout.php">Cerrar Sesión<i class="bi bi-box-arrow-in-right"></i></a>
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



            <div class="row">
                <div class="col-sm-5">

                    <?php

                    // $id = $_GET["editar"];

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

                    <!-- Modal -->
                    <!-- <div id="fondo_oscuro"></div> -->
                    <div class="modal fade rounded " id="modal_editar" enctype="multipart/form-data" tabindex="-1" aria-labelledby="modal_editar_label" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div id="header_editar" class="modal-header">
                                    <h5 class="modal-title" id="modal_editar_label">Editar Socio</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="form_editar">
                                        <input type="hidden" id="edit_id" name="id">
                                        <div class="mb-3">
                                            <label for="edit_nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="edit_nombre" name="nombre">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_apellido" class="form-label">Apellido</label>
                                            <input type="text" class="form-control" id="edit_apellido" name="apellido">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="edit_email" name="email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_saldo" class="form-label">Saldo</label>
                                            <input type="number" class="form-control" id="edit_saldo" name="saldo">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" id="edit_foto" name="foto">
                                        </div>

                                        <div class='alerta alerta_error'>
                                            <div class='alerta_icon'>
                                                <i class="bi bi-x-circle"></i>
                                            </div>
                                            <div class='alerta_wrapper'>
                                            </div>
                                        </div>
                                        <div class='alerta alerta_success'>
                                            <div class='alerta_icon'>
                                                <i class="bi bi-x-circle"></i>
                                            </div>
                                            <div class='alerta_wrapper'>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary rounded btn_actualizar">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






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
                                        <button id="btn_buscar" class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                    <!-- <div class="reset">
                                        <button class="btn btn-outline-secondary" id="limpiarBusqueda">Limpiar Búsqueda</button>
                                    </div> -->
                                </form>
                            </div>


                        </div>
                        <div class="caja">
                            <table class="table table-cell">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th class='sm-hide'>Email</th>
                                        <th class='sm-hide'>Saldo</th>
                                        <th class='sm-hide'>Fecha</th>
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


                                    $porPagina = 5;           // socios_x_pagina 
                                    $pagina = (isset($_GET["pagina"])) ? (int)$_GET['pagina'] : 1;     // página actual
                                    $inicio = ($pagina - 1) * $porPagina; // indice de inicio xra consulta paginada



                                    if (isset($_GET["busqueda"])) {

                                        if (empty($_GET["busqueda"])) {
                                            echo "<h5>No has aplicado ningún patrón de búsqueda</h5>";
                                            exit;
                                        }

                                        // Consulta para mostrar la info del socio/s buscado/s
                                        $consulta = "SELECT 
                                            id_socio,
                                            CONCAT(nombre, ' ', apellido) AS nombre_completo, 
                                            email, 
                                            saldo, 
                                            fecha 
                                            FROM socios 
                                            WHERE 1=1";

                                        $busqueda = trim($_GET["busqueda"]); // Eliminar espacios en blanco


                                        $busqueda_nombres = explode(" ", $busqueda);

                                        $condiciones = [];
                                        foreach ($busqueda_nombres as $nombre) {
                                            $condiciones[] = "(nombre LIKE '%" . $nombre . "%' OR apellido LIKE '%" . $nombre . "%')";
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
                                            $condiciones[] = "(nombre LIKE '%" . $nombre . "%' OR apellido LIKE '%" . $nombre . "%')";
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
                                        $contador = intval($resultado_contador["contador"]); //-------------HERE---------------------------
                                        $consulta_busqueda .= " ORDER BY fecha LIMIT $inicio, $porPagina";

                                        $paginas = ceil($contador / $porPagina);             // nº total páginas
                                        // Ejecutar la consulta para obtener los resultados de búsqueda
                                        $db->setConsulta($consulta_busqueda);
                                        $db->ejecutar();

                                        // Mostrar los resultados
                                        while ($fila = $db->getResultado()) {
                                            // Procesar y mostrar cada fila de resultado aquí
                                            // Ejemplo: echo $fila["id_socio"], $fila["nombre_completo"], etc.
                                        }

                                        if ($contador > 1 || $contador == 0) {
                                            echo "<h4>$contador resultados encontrados</h4>";
                                        } else {
                                            echo "<h4>$contador resultado encontrado</h4>";
                                        }
                                    } else {

                                        $paginas = ceil($total_socios / $porPagina);             // nº total páginas

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


                                        // Separar el nombre y el apellido
                                        $nombre_completo = $row['nombre_completo'];
                                        $nombres = explode(' ', $nombre_completo);
                                        $nombre = $nombres[0]; // Primer nombre
                                        $apellido = end($nombres); // Último nombre (apellido)

                                        // Definir otras variables
                                        $id_socio = $row['id_socio'];
                                        $email = $row['email'];
                                        $saldo = $row['saldo'];


                                        $fechaFormateada = date('d - m - Y', $row['fecha']);
                                        echo "<tr data-id = {$row['id_socio']}>
                                                    <td>$contador</td>
                                                    <td>{$row['nombre_completo']}</td>
                                                    <td class='sm-hide'>{$row['email']}</td>
                                                    <td class='sm-hide'>{$row['saldo']}</td>                 
                                                    <td class='sm-hide'>$fechaFormateada</td>                 
                                                    <td>
                                                    <a href='#' 
                                                    class='btn btn-success acciones accion_editar' 
                                                    data-id='{$id_socio}' 
                                                    data-nombre='{$nombre}' 
                                                    data-apellido='{$apellido}' 
                                                    data-email='{$email}' 
                                                    data-saldo='{$saldo}'
                                                    data-bs-toggle='modal'
                                                    data-bs-target='#modal_editar' 
                                                    title='Editar'>
                                                    <i class='bi bi-box-arrow-in-up-right'></i>
                                                    </a>
                                                    <a href='#' 
                                                    class='btn btn-danger acciones accion_eliminar' data-toggle='tooltip' title='Eliminar'>
                                                    <i class='bi bi-x-circle'></i>
                                                    </a>
                                                    </td>                 
                                                </tr>";
                                    }
                                    // id='accion_eliminar' 
                                    $db->despejar();
                                    
                                    ?>



                                </tbody>
                            </table>

                            <div class="modal fade" id="caja_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Eliminar Socio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Seguro que deseas eliminarlo?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button id="no" type="button" class="btn btn-warning rounded" data-bs-dismiss="modal">Cancelar</button>
                                            <button id="si" type="button" class="btn btn-danger rounded">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php

                            $anterior = ($pagina - 1);
                            $siguiente = ($pagina + 1);

                            // variables para la paginación de la búsqueda/normal
                            if (isset($_GET["busqueda"])) {
                                $pag_anterior = "?pagina=$anterior&busqueda={$_GET['busqueda']}";
                                $pag_siguiente = "?pagina=$siguiente&busqueda={$_GET['busqueda']}";
                            } else {
                                $pag_anterior = "?pagina=$anterior";
                                $pag_siguiente = "?pagina=$siguiente";
                            }


                            ?>

                            <nav aria-label="nav">
                                <ul class="pagination justify-content-center"> <!-- Centra los elementos de la paginación -->

                                    <!-- 
                                        Opciones para mostrar o no los iconos de previo/posterior
                                        Op-2 -> se muetra o no el de previo 
                                        -->
                                    <?php

                                    if ($pagina > 1) : ?>
                                        <li class="page-item">
                                            <a class="page-link" href='<?php echo "?pagina=$anterior"; ?>' aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php

                                    if (isset($_GET["busqueda"])) {
                                        // Se muestra la página activa y el total de la búsqueda
                                        if ($paginas >= 1) {
                                            for ($x = 1; $x <= $paginas; $x++) {
                                                echo ($x == $pagina) ? "<li class='page-item active'><a class='page-link' href='?pagina=$x&busqueda={$_GET['busqueda']}'>$x</a></li>"
                                                    : "<li class='page-item'><a class='page-link' href='?pagina=$x&busqueda={$_GET['busqueda']}'>$x</a></li>";
                                            }
                                        }
                                    } else {

                                        // Se muestra la página activa y el total normal
                                        if ($paginas >= 1) {
                                            for ($x = 1; $x <= $paginas; $x++) {
                                                echo ($x == $pagina) ? "<li class='page-item active'><a class='page-link' href='?pagina=$x'>$x</a></li>"
                                                    : "<li class='page-item'><a class='page-link' href='?pagina=$x'>$x</a></li>";
                                            }
                                        }
                                    }


                                    ?>
                                    <!-- Op-2 -> se muestra o no el de anterior -->
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


    </div>

    </div>
    </div>

        <?php
    $db->cerrar();
    ?> 
    <?php require '../inc/footer.inc'; ?>