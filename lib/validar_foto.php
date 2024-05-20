<?php
function validar_foto($nombre)
{
    $foto = $_FILES['foto'];

    // global $path_foto;
    // global $error;

    
    $foto_dir = "fotos/$nombre/"; // Directorio donde se guardarán las fotos
    $nombre_foto = $foto['name'];
    $tmp_name = $foto['tmp_name'];
    $path_foto = "{$foto_dir}profile.jpg"; // ruta de guardado
    $exFile = preg_replace('/image\//', '', $foto['type']);
    $extension_archivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $extensiones_validas = ["jpeg", "jpg", "png", "webp"];

    if (in_array($extension_archivo, $extensiones_validas)) {
        // Mover la foto al directorio del usuario
        // Verificar y crear directorio si no existe
        if (!file_exists("../fotos")) {
            mkdir("../fotos", 0755, true);
        }
        if (!file_exists($foto_dir)) {
            mkdir($foto_dir, 0755, true);
        }
        if (move_uploaded_file($tmp_name, $path_foto)) {
            return true;
        } else {
            echo "Error al mover el archivo.";
        }
    } else {
         echo "Tipo de archivo no válido. Se admiten archivos JPEG, PNG y WebP.";
    }
    echo $path_foto ."desde validar foto<br>";
}
