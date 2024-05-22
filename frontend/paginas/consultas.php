<?php
// Validación de entrada 'id'
$id = isset($_GET['id']) ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout_pag/estilos.css">
    <link rel="stylesheet" href="layout_pag/clases.css">
    <title>Origen</title>
</head>
<body>
    <div id="web-check">
        <div class="session">
            <div>
                <span class="titulo-dashboard">Origen</span>
            </div>
            <div>
                <ul>
                    <li><a href="pagina_inicial.php">DashBoard</a></li>
                    <li><a href="dominio.php">My Domains</a></li>
                    <li class="selected">My Webs</li>
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