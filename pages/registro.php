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
                spl_autoload_register(function($clase){
                    require_once "../lib/$clase.php";
                });

                // Verificar si se ha enviado el formulario
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // Obtener datos del formulario
                    $nombre = strtolower($_POST['nombre']);
                    $apellidos = strtolower($_POST['apellidos']);
                    $email = $_POST['email'];
                    $password = $_POST['contrasena'];
                    $confirm_pass = $_POST['confirm-contrasena'];
                    $saldo = $_POST['saldo'];

                    // Llamada a función dentro de lib
                    // validar_foto($nombre);                    
                }

                // echo $nombre;
                // echo "<br>";
                // echo $apellidos;
                // echo "<br>";
                // echo $email;
                // echo "<br>";
                // echo $password;
                // echo "<br>";
                // echo $confirm_pass;
                // echo "<br>";
                // echo $saldo;






                // $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_CHARSET);

                // $array_socios = $db->getSocios();

                // $db->preparar("SELECT nombre, apellidos, saldo FROM socios");
                // $db->ejecutar();
                // $db->prep()->bind_result( $nombre, $apellidos, $dni);

                // echo "<table class= 'table table-cell'>
                
                //         <thead>
                //             <tr>
                //                 <td>ID-Socio</td>
                //                 <td>Nombre</td>
                //                 <td>Apellidos</td>
                //                 <td>Contraseña</td>
                //                 <td>E-mail</td>
                //                 <td>DNI</td>
                //                 <td>Saldo</td>
                //             </tr>
                //         <tbody>";

                        // foreach($array_socios as $value){
                        //     echo "<tr>";
                        //     foreach($value as $out_value){
                        //         echo "<td>$out_value</td>";
                        //     }
                        //     echo "</tr>";
                        // }

                        // while( $db->resultado()){
                        //     echo "<tr>
                        //             <td>$nombre</td>
                        //             <td>$apellidos</td>
                        //             <td>$dni</td>                 
                        //     </tr>";
                        // }
                        
                        
                        // echo "</tbody>
                        // </thead>
                        // </table>
                        // ";
                
                        // echo $db->validarDatos('nombre', 'socios', 'simon');
                
                ?>


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
            </div>
        </div>

    </div>

    <?php require '../inc/footer.inc'; ?>