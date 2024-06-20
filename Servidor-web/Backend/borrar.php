<?php
require '../../vendor/autoload.php';

use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

         $domain = $_POST['domain'];
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
                $ssh->exec('bash destroy.sh ' . escapeshellarg($domain));
                // Pausar la ejecución
                echo "Comando ejecutado con éxito: " . htmlspecialchars($output);
                header("Location: ../inicio.php");
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
?>