<?php
require '../vendor/autoload.php';

$mongoHost = 'mongodb://usuario:PassWord@10.0.137.230:27017';

    // Crear una instancia del cliente MongoDB
    $client = new MongoDB\Client($mongoHost);

    // Seleccionar la base de datos y la colección
   $database = $client->selectDatabase('test');
$collection = $database->selectCollection('paginas');

?>
<?php
// Como comprobar que un servidor está activo
function verificarPing($ip){
        $comando = $ip;
        $output = shell_exec("ping -c 1 $comando");
        if (strpos($output, 'time=') !== false){
                $salida = '<p>Estado: Activo</p>';
        $clase = 'active';
        } else {
        $salida = '<p>Estado: Inactivo</p>';
        $clase = 'inactive';
        }
        return array('salida' => $salida, 'clase' => $clase);
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Informática</title>
    </head>
<body>
    <header>
        <nav>
<?php if (isset($_GET['id'])){
        $id = "?id=" . $_GET['id'];
} else {
        $id = "";
}
?>
            <a href="inicio.php<?php echo $id;?>">Página Inicial</a>
            <a href="#home">Status</a>
            <a href="consultas.php<?php echo $id;?>">Mis Dominios</a>
        </nav>
    </header>
    <div class="container">
        <aside>
            <ul>
         <?php
    if (isset($_GET['id'])) {
    ?>
                <li><a href="dominio.php"><img src="https://s.tmimgcdn.com/scr/800x500/165100/abrir-la-plantilla-de-logotipo-de-diseno-de-logotipo-vectorial-de-puerta_165160-original.jpg" alt="Cerrar Sesión">Cerrar Sesión</a></li>
    <?php
    } else {
    ?>
            </ul>
            <section class="form-container">
                <h2>Formulario de Registro</h2>
                <form action="backend/check_dominio.php" method="POST">
                    <input type="text" name="username" placeholder="Nombre" required>
                    <input type="email" name="mail" placeholder="Correo Electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Registrarse</button>
                </form>
            </section>
<?php
    }
?>
        </aside>
        <main>
            <section class="status">
                <h2>Estado de los Servidores</h2>
                <div class="<?php $ping = verificarPing('8.8.8.8'); echo $ping['clase'];?>">
                    <h3>dns.google</h3>
                    <?php echo $ping['salida'];?>
                </div>
                <div class="<?php $ping = verificarPing('18.204.182.139'); echo $ping['clase'];?>">
                    <a href="https://web.sergio.publicvm.com"><h3>web.sergio.publicvm.com</h3></a>
                    <?php echo $ping['salida'];?>
                </div>
<?php
$results = $collection->find();
foreach ($results as $document) {
    $ping = verificarPing($document["IP"]);

    echo '<a href="http://'.$document["nombre"].'web.sergio.publicvm.com"><div class="' . $ping["clase"] . '">';
    echo '<h3>' . $document["nombre"] . '.sergio.publicvm.com</h3>';
    echo $ping["salida"];
            echo '</div></a>';
}
?>
            </section>
        </main>
    </div>
    <script>
        function search() {
            var input = document.getElementById("search-bar").value.toLowerCase();
            var articles = document.querySelectorAll(".news article");
            articles.forEach(article => {
                if (article.textContent.toLowerCase().includes(input)) {
                    article.style.display = "";
                } else {
                    article.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>