<?php
// Validación de entrada 'id'
$id = isset($_GET['id']) ;?>
<?php
// Validación de entrada 'id'
$id = isset($_GET['id']) ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="layout_pag/estilos_domain.css">
    <link rel="stylesheet" href="layout_pag/clases.css">
    <title>Origen</title>
</head>
<body>
    <div id="web-status">
        <div class="session">
            <div>
                <span class="titulo-dashboard">Origen</span>
            </div>
            <div>
                <ul>
                    <li><a href="pagina_inicial.php">DashBoard</a></li>
                    <li class="selected">My Domains</li>
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
<?php }
 
    # hacer ping a mi página web y a mi dns y a los servidores de los clientes
	$ip= '8.8.8.8';
	$comando = $ip;
	$output = shell_exec("ping -n 1 $comando");
	if ($output[-2] = 'ms'){
		$salida = 'OK';
        $clase = 'correct';
	} else {
        $salida = 'NOT OK';
        $clase = 'fail';
    }

?>

    <div class="parte-arriba-publi">
            <div class="titulo-publi">
                <h1>Estado de los servidores</h1>
            </div>
            
            <div class="centro-publi">
                <div>
                    <span>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error quas molestias dicta expedita, debitis soluta magni dolore ex deserunt repellat quis labore libero quod provident suscipit ea pariatur eaque harum?</span>
                </div>
                <div>
                    <span> Los servidores de google se encuentran <span class="<?php echo $clase?>"><?php echo $salida; ?></span></span>
                </div>
            </div>
        </div>
    <div>    
</body>
</html>