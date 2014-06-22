<!DOCTYPE html> 
<?php
include("bbdd.php");
ini_set("SMTP","localhost"); 
ini_set("smtp_port","25"); 

if(isset($_POST['usuario'])){
	$profesor =$_POST['usuario'];
	$result = consultaMailProfesor($profesor);
	
	if($result != null){
		$row = mysql_fetch_array($result);
		mail($row['mail'],"Recordar Contraseña","Su contraseña es:".$result['password'].".");
		?>
			<script type="text/javascript">
					alert("Se le ha enviado un mail a su cuenta de correo.");
				</script>
		<?php
	}else{
		?>
			<script type="text/javascript">
					alert("El usuario no existe");
				</script>
		<?php
	}
}
?>
<html> 
<head>
	<?
	include("bbdd.php");
	require_once "bbdd.php";
	?>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüistica Universidad de Zaragoza - Administrador</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
</head> 
<body> 
	<div class="cabecera">
		<div class="LogoContainer">
			<image id='LogoUniZar' class="Logo" src='images\logo_uz.png'>
		</div>
		<p class="tipoUsuario">
			Recordar Contraseña
		</p>
	</div>
	<div class="Main">
		<h1>Datos del Usuario</h1>
		<div class="separador"></div>
		<form action="RecordarContrasena.php" method="post">
			<table class="center">  
				<tr><td><label><b>Introduce tu Usuario<b></label><input id='usuario' name='usuario' size="20" maxlength="20" type='text'></p> 
			</table>
			<div class="separador"></div>
			<p class="center">
				<input type="submit" value="Recordar Contraseña">
			</p>
		</form> 
		
		
	</div>
	
	<div class="Footer">
				©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>