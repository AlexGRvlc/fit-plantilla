<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "lib/PasswordHash.php";

// Generando el hash/encriptación de la contraseña:

$password = "alex";

$hasher =  new PasswordHash(8,FALSE); // Obj instanciado

// representa al Obj hasher llamando a un método
$hash = $hasher->HashPassword($password); // pasamos la clave

echo "Hash -->$hash <br>";
echo "Contraseña -->$password <br>";

// Comprobando la contraseña
if ($hasher->CheckPassword("alex", $hash)){
    echo "clave correcta";
}else {
    echo "clave incorrecta";
}