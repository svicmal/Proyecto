<?php
require '../../vendor/autoload.php';

try {
    // Dirección del servidor MongoDB (cambia <usuario>, <contraseña>, y <IP_del_servidor_MongoDB>)
    $mongoHost = 'mongodb://usuario:PassWord@10.0.137.230:27017';

    // Crear una instancia del cliente MongoDB
    $client = new MongoDB\Client($mongoHost);

    // Seleccionar la base de datos y la colección
    $database = $client->selectDatabase('test');
    $collection = $database->selectCollection('usuarios');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mail = $_POST['mail'];

    // Corregir el nombre de la colección
    $collection = $database->selectCollection('usuarios');

    $usuarioExistente = $collection->findOne(['nombre' => $username,'pwd' => $password]);
    $nombreExistente = $collection->findOne(['nombre' => $username]);
    if ($usuarioExistente === null && $nombreExistente === null ) {
        $result = $collection->insertOne([
            'nombre' => $username,
            'correo' => $mail,
            'pwd' => $password
        ]);
    }
    $userId = $usuarioExistente->_id;
} catch (Exception $e) {
    // Manejar errores aquí
    echo "Error: " . $e->getMessage();
}
?>