<?php
function executeDeployScript($domain, $userId) {
    try {
        // Cargar la clave privada
        $key = PublicKeyLoader::loadPrivateKey(file_get_contents("/home/admin/dns.pem"));

        // Crear una instancia de SSH
        $ssh = new SSH2('10.0.8.112');

        // Autenticarse con la clave privada
        if (!$ssh->login('admin', $key)) {
            throw new Exception('Fallo al autenticar con SSH');
        }

        // Ejecutar el comando
        $output = $ssh->exec('bash deploy.sh ' . escapeshellarg($domain) . ' ' . escapeshellarg($userId));

        // Pausar la ejecución
        return "Comando ejecutado con éxito: " . htmlspecialchars($output);
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

require '../../vendor/autoload.php';

use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    include("check.php");
    if (!empty($userId)) {
        $collection = $database->selectCollection('paginas');

        $domain = $_POST['domain'];
        $optionSelect = $_POST['optionSelect'];

        // Comprobar si ya existe un documento con el mismo nombre
        if (!$collection->findOne(['nombre' => $domain])) {
            // Inicializar variables para el archivo y el mensaje
            $file = null;
            $message = null;

            if ($optionSelect === 'uploadFile' && isset($_FILES['file'])) {
                $file = $_FILES['file'];
                // Comprobar si hay errores
                if ($file['error'] === UPLOAD_ERR_OK) {
                    // Manejar la carga del archivo (e.g., mover a un directorio)
                    $uploadDir = 'uploads/';
                    $uploadFile = $uploadDir . basename($file['name']);

                    if (!(move_uploaded_file($file['tmp_name'], $uploadFile))) {
                        echo "Archivo no subido: " . $uploadFile;
                    }
                } else {
                    echo "Error en la subida del archivo: " . $file['error'];
                }
            } else {
                echo "Error en el archivo";
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
                    // Ejecutar el comando
                    $output = $ssh->exec('bash deploy.sh ' . escapeshellarg($domain) . ' ' . escapeshellarg($userId));
                    // Pausar la ejecución
                    echo "Comando ejecutado con éxito: " . htmlspecialchars($output);
               } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
        } else {
            echo "Ya existe un documento con el mismo nombre.";
        }
        header("Location: ../inicio.php?id=$userId");
    } else {
        header("Location: ../inicio.php");
    }
}
?>