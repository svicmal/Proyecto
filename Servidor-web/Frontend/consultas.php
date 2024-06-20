<?php
require '../vendor/autoload.php';
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

$mongoHost = 'mongodb://usuario:PassWord@10.0.137.230:27017';

// Crear una instancia del cliente MongoDB
$client = new MongoDB\Client($mongoHost);

// Seleccionar la base de datos y la colección
$database = $client->selectDatabase('test');
$collection = $database->selectCollection('usuarios');
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
            <a href="dominio.php<?php echo $id;?>">Status</a>
            <a href="consultas.php<?php echo $id;?>">Mis Dominios</a>
        </nav>
    </header>
    <div class="container">
        <aside>
            <ul>
                <?php if (isset($_GET['id'])) { ?>
                    <li><a href="consultas.php"><img src="https://s.tmimgcdn.com/scr/800x500/165100/abrir-la-plantilla-de-logotipo-de-diseno-de-logotipo-vectorial-de-puerta_165160-original.jpg" alt="Cerrar Sesión">Cerrar Sesión</a></li>
                <?php } else { ?>
            </ul>
            <section class="form-container">
                <h2>Formulario de Registro</h2>
                <form action="backend/check_consultas.php" method="POST">
                    <input type="text" name="username" placeholder="Nombre" required>
                    <input type="email" name="mail" placeholder="Correo Electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Registrarse</button>
                </form>
            </section>
            <?php } ?>
        </aside>
        <main>
            <h2>Dominios</h2>
            <section class="create-domain">
                <h2>Crea un Nuevo Dominio</h2>
                <?php if (isset($_GET['id'])) {
                    $pag = "formulario_crear_web.html";
                } else {
                    $pag = "formulario_usuario.html";
                } ?>
                <a href="<?php echo $pag?>"><button id="create-domain-btn">Crear</button></a>
            </section>
            <section class="server-list">
                <h2>Servidores Creados</h2>
                <ul>
                    <?php
                    $collection = $database->selectCollection('paginas');
                    $results = $collection->find(['id' => $_GET['id']]);
                    foreach ($results as $document) {
                        echo '<li>';
                        echo '<form onsubmit="return confirmDeletion()" action="backend/borrar.php" method="POST">';
                        echo 'Nombre: ' . htmlspecialchars($document['nombre']) . '<br>';
                        echo 'IP: ' . htmlspecialchars($document['IP']). '<br>';
                        echo '<input type="hidden" name="domain" value="' . htmlspecialchars($document['nombre']) . '">';
                        echo '<button type="submit">Borrar</button>';
                        echo '</form>';
                        echo '<button onclick="openUploadModal(\'' . htmlspecialchars($document['nombre']) . '\')">Subir Archivo</button>';
                        echo '<form action="backend/certificar.php" method="POST" onsubmit="return confirmCertification()">';
                        echo '<input type="hidden" name="domain" value="' . htmlspecialchars($document['nombre']) . '">';
                        echo '<button type="submit">Certificar</button>';
                        echo '</form>';
                        echo '</li>';
                        echo '<hr>';
                    }
                    ?>
                </ul>
            </section>
        </main>
    </div>

    <!-- Modal de subida de archivos -->
    <div id="uploadModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
        <div style="background:#fff; padding:20px; border-radius:5px; width:300px; text-align:center;">
            <h2>Subir Archivo</h2>
            <form id="uploadForm" action="backend/upload.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="domainName" name="domain" value="">
                <input type="file" name="file" required>
                <button type="submit">Subir</button>
                <button type="button" onclick="closeUploadModal()">Cancelar</button>
            </form>
        </div>
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

        function confirmDeletion() {
            return confirm('¿Estás seguro de que quieres borrar este dominio?');
        }

        function confirmCertification() {
            return confirm('¿Estás seguro de que quieres certificar este dominio?');
        }

        function openUploadModal(domainName) {
            document.getElementById('domainName').value = domainName;
            document.getElementById('uploadModal').style.display = 'flex';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').style.display = 'none';
        }
    </script>
</body>
</html>