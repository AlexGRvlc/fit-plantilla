<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "borrar_foto.php";

function validar_foto($nombre, $update = false)
{
    $foto = $_FILES['foto'];
    global $foto_dir;
    global $path_foto;

    $foto_dir = "../pages/fotos/$nombre/"; // Directorio donde se guardarán las fotos
    $path_foto = "{$foto_dir}profile.jpg"; // Ruta de guardado
    $tmp_name = $foto['tmp_name'];
    $extension_archivo = pathinfo($foto["name"], PATHINFO_EXTENSION);
    $extensiones_validas = ["jpeg", "jpg", "png", "webp"];


    // En caso de que se requiera únicamente
    // borrar la foto (por eliminación socio)
    if ($update) {
        $dir = $foto_dir;
        borrarFoto($dir);
    }

    // Creación dir/archivo para foto de perfil
    if (in_array($extension_archivo, $extensiones_validas)) {

        if (!file_exists("../pages/fotos")) {
            mkdir("../pages/fotos", 0755, true);
            echo "Directorio ../pages/fotos creado.<br>";
        }
        if (!file_exists($foto_dir)) {
            mkdir($foto_dir, 0755, true);
            echo "Directorio $foto_dir creado.<br>";
        }
        if (move_uploaded_file($tmp_name, $path_foto)) {
            return $path_foto;
        } else {
            echo "Error al mover el archivo.<br>";
            return false;
        }
    } else {
        echo "Tipo de archivo no válido. Se admiten archivos JPEG, PNG y WebP.<br>";
        return false;
    }
}
