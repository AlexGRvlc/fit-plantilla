<?php
function validar_foto($nombre)
{
    $foto = $_FILES['foto'];

    global $path_foto;
    global $error;
    global $path_foto;

    $prueba  = "esto es una prueba";

    // Directorio donde se guardarán las fotos
    $foto_dir = "fotos/$nombre/";
    $foto = $_FILES['foto'];

    $nombre_foto = $foto['name'];
    $tmp_name = $foto['tmp_name'];
    $path_foto = "{$foto_dir}profile.jpg"; // ruta de guardado
    $exFile = preg_replace('/image\//', '', $foto['type']);
    $extension_archivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $extensiones_validas = ["jpeg", "jpg", "png", "webp"];

    // Validar la extensión del archivo
    if (in_array($extension_archivo, $extensiones_validas)) {
        // Mover la foto al directorio del usuario
        // Verificar y crear directorio si no existe
        if (!file_exists("fotos")) {
            mkdir("fotos", 0777, true);
        }
        if (!file_exists($foto_dir)) {
            mkdir($foto_dir, 0777, true);
        }
        if (move_uploaded_file($tmp_name, $path_foto)) {
            return true;
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
         echo "Tipo de archivo no válido. Se admiten archivos JPEG, PNG y WebP.";
    }

    // return $error;
}
