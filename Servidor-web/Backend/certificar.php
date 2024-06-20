<?php
require '../../vendor/autoload.php';

use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

$ssh = new SSH2('10.0.9.3');
$key = PublicKeyLoader::load(file_get_contents('/home/admin/mail.pem'));

if (!$ssh->login('admin', $key)) {
    exit('Login Failed');
}

// Obtener el dominio desde el formulario POST
$domain = $_POST["domain"];

// Preparar el comando con el dominio recibido
$command = 'echo " El dominio ' . $domain . ' hay que cerificarlo" | sudo sendmail admin@sergio.publicvm.com &>/dev/null';

// Ejecutar el comando en el servidor remoto
$output = $ssh->exec($command);
echo $output;