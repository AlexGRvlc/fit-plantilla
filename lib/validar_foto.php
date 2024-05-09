<?php
function validar_foto($nombre)
{
    $foto = $_FILES['foto'];

    global $path_foto;


    // Directorio donde se guardarán las fotos
    $foto_dir = "fotos/$nombre/";

    // Verificar y crear directorio si no existe
    if (!file_exists("fotos")) {
        mkdir("fotos", 0777, true);
    }
    if (!file_exists($foto_dir)) {
        mkdir($foto_dir, 0777, true);
    }

    // Ruta donde se guardará la foto de perfil
    $path_foto = "{$foto_dir}profile.jpg";

    // Obtener la extensión del archivo
    $extension_archivo = pathinfo($foto["name"], PATHINFO_EXTENSION);

    // Validar la extensión del archivo
    $extensiones_validas = ["jpeg", "jpg", "png", "webp"];
    if (in_array($extension_archivo, $extensiones_validas)) {
        // Mover la foto al directorio del usuario
        if (move_uploaded_file($foto["tmp_name"], $path_foto)) {
            return true;
        } else {
            return trigger_error("Error al mover el archivo.", E_USER_WARNING);
        }
    } else {
        return trigger_error("Tipo de archivo no válido. Se admiten archivos JPEG, PNG y WebP.", E_USER_WARNING);
    }
}

