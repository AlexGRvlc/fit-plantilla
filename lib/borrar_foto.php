<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// function borrarFoto($dir_foto)
// {
//     if (is_dir($dir_foto)) {
//         $gestor = opendir($dir_foto);
//         if ($gestor) {

//             while (false !== ($archivo = readdir($gestor))) {
//                 if ($archivo != "." && $archivo != ".." && $archivo != "Thumbs.db") {
//                     unlink("$dir_foto/$archivo");
//                 }
//             }
//             closedir($gestor);
//             rmdir($dir_foto);
//             sleep(1);
//         } else {
//             echo "No se pudo abrir el directorio para eliminar archivos.<br>";
//             return false;
//         }
//     } else {
//         echo "El directorio no existe. Creándolo...<br>";
//         mkdir($dir_foto, 0755, true);
//         echo "Directorio creado: $dir_foto<br>";
//     }
// }