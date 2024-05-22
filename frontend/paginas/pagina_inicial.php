<?php
// Validación de entrada 'id'
$id = isset($_GET['id']) ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout_pag/estilos_inicio.css">
    <link rel="stylesheet" href="layout_pag/clases.css">
    <title>Origen</title>
</head>
<body>
    <div id="web-info">
        <div class="session">
            <div>
                <span class="titulo-dashboard">Origen</span>
            </div>
            <div>
                <ul>
                    <li class="selected">DashBoard</li>
                    <li><a href="dominio.php">My Domains</a></li>
                    <li><a href="consultas.php">My Webs</a></li>
                </ul>
            </div>
<?php
// Verifica si la sesión está iniciada y la variable de sesión específica existe
if  (isset($_SESSION[$id])) {
?>
            <div>
                <form action="pagina_inicial.php" method="POST">
                    <input type="text" name="username" required placeholder="Ingrese su nombre">
                    <input type="password" name="password" required placeholder="Ingrese su contraseña">
                    <input type="submit" value="Enviar">
                    <input type="reset" value="Restablecer">
                </form>
            </div>
        </div>
<?php } else { ?>
        </div>
<?php }?>
        <div class="parte-arriba-publi">
            <div class="titulo-publi">
                <h1>Menú inical</h1>
            </div>
            
            <div class="centro-publi">
                <div>
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error quas molestias dicta expedita, debitis soluta magni dolore ex deserunt repellat quis labore libero quod provident suscipit ea pariatur eaque harum?</span>
                </div>
                <div>
                <table>
                    <caption>Crea tu página web</caption>
                    <tr>
                        <td>Nuevo dominio</td>
                        <td>Crea tu nuevo dominio</td>
                        <td><a href=""><img src="" alt="Flecha"></a></td>
                    </tr>
                    <tr>
                        <td>Ver mis dominios</td>
                        <td>Mira como se encuentra tu dominio ahora mismo</td>
                        <td><a href=""><img src="" alt="Flecha"></a></td>
                    </tr>
                    <tr>
                        <td>Borrar tu dominio</td>
                        <td>Borra tu dominio web sin problemas y de coste 0</td>
                        <td><a href=""><img src="" alt="Flecha"></a></td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
    <div>    
</body>
</html>

