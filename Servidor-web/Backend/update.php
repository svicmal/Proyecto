<?php
require '../../vendor/autoload.php';

use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

// Verifica si la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asegúrate de tener la instancia adecuada de $database (no proporcionada en el código)
    // $collection = $database->selectCollection('paginas'); // Esto necesita la instancia de $database

    // Obtén datos del formulario
    $domain = $_POST['domain'] ?? '';
    $optionSelect = $_POST['optionSelect'] ?? '';
    $file = $_FILES['file'] ?? [];

    // Verifica si se subió correctamente el archivo
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($file['name']);

        // Verifica si el archivo ya existe y decide si sobrescribirlo o no
        if (file_exists($uploadFile)) {
            unlink($uploadFile); // Elimina el archivo existente para sobrescribirlo
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
            echo "Archivo no subido: " . $uploadFile;
            exit;
        }
    } else {
        echo "Error en la subida del archivo: " . $file['error'];
        exit;
    }

    try {
        // Cargar la clave privada
        $key = PublicKeyLoader::loadPrivateKey(file_get_contents("/home/admin/dns.pem"));

        // Crear una instancia de SSH
        $ssh = new SSH2('10.0.8.112');

        // Autenticarse con la clave privada
        if (!$ssh->login('admin', $key)) {
            throw new Exception('Fallo al autenticar con SSH');
        }

        // Ejecutar el comando SSH
        // Asegúrate de que $userId esté definido y correctamente obtenido antes de usarlo aquí
        $userId = ''; // Define adecuadamente $userId según tu lógica

        $output = $ssh->exec('bash update.sh ' . escapeshellarg($domain) . ' ' . escapeshellarg($userId));

        echo "Comando ejecutado con éxito: " . htmlspecialchars($output);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    // Redirigir después de completar el proceso
    header("Location: ../inicio.php");
    exit;
}
?>