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
            <a href="#home">Página Inicial</a>
            <a href="dominio.php<?php echo $id;?>">Status</a>
            <a href="consultas.php<?php echo $id;?>">Mis Dominios</a>
        </nav>
        <div class="search-container">
            <input type="text" id="search-bar" class="search-bar" placeholder="Buscar...">
            <button onclick="search()">Buscar</button>
        </div>
    </header>
    <div class="container">
        <aside>
            <ul>
         <?php
    if (isset($_GET['id'])) {
    ?>
                <li><a href="inicio.php"><img src="https://s.tmimgcdn.com/scr/800x500/165100/abrir-la-plantilla-de-logotipo-de-diseno-de-logotipo-vectorial-de-puerta_165160-original.jpg" alt="Cerrar Sesión">Cerrar Sesión</a></li>
    <?php
    } else {
    ?>
            </ul>
            <section class="form-container">
                <h2>Formulario de Registro</h2>
                <form action="backend/check_inicial.php" method="POST">
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
            <section class="news">
                <h2>Noticias</h2>
                <article>
                    <img src="https://miro.medium.com/v2/resize:fit:1200/1*LyZcwuLWv2FArOumCxobpA.png" alt="Noticia 1">
                    <h3>Nuevo framework de JavaScript lanzado</h3>
                    <p>Descubre las características y ventajas de este nuevo framework que promete revolucionar el desarrollo web.</p>
                </article>
                <article>
                    <img src="https://formacion.camarabilbao.com/wp-content/uploads/sites/4/2024/01/ciberseguridad-aumento.jpg" alt="Noticia 2">
                    <h3>Ciberseguridad: Consejos para proteger tu negocio</h3>
                    <p>Aprende las mejores prácticas para mantener tus sistemas seguros y evitar ataques cibernéticos.</p>
                </article>
                <article>
                    <img src="https://mediatek-marketing.transforms.svdcdn.com/production/posts/MediaTek-IA-2023.jpg?w=2048&h=1075&q=80&auto=format&fit=crop&dm=1688130337&s=3b56535c28f441a34db9455d64444cb7" alt="Noticia 3">
                    <h3>La inteligencia artificial en el desarrollo de software</h3>
                    <p>Explora cómo la IA está transformando la forma en que desarrollamos y mantenemos software hoy en día.</p>
                </article>
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