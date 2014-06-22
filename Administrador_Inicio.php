<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="images/icono.png" >
	<title>Campus Lingüística Universidad de Zaragoza - Administrador</title>
	<link rel="stylesheet" type="text/css" href="Style.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php session_start();
	//Validar que el usuario este logueado y exista un UID
	if ( !($_SESSION['autenticado'] == 'SI' && isset($_SESSION["k_username"])) )
	{
		//En caso de que el usuario no este autenticado, crear un formulario y redireccionar a la 
		//pantalla de login, enviando un codigo de error
	?>
			<form name="formulario" method="post" action="index.html">
				<input type="hidden" name="msg_error" value="2">
			</form>
			<script type="text/javascript"> 
				document.formulario.submit();
			</script>
	<?php
	}
	?>
	<div class="cabecera">
		<div class="LogoContainer">
			<image id='LogoUniZar' class="Logo" src='images\logo_uz.png'>
		</div>
		<div class="cerrarSesion">		
			<a href="<?php echo 'cerrarSesion.php'?>">Cerrar sesión</a>
		</div>
		<div class="UsuarioActual">
				Usuario: <?php echo $_SESSION["k_username"];?>
		</div>
		<p class="tipoUsuario" >
			Administrador
		</p>
		 
	</div>
	<?php if ( session_start()){?>
	<div id="menu">
		 <h1><a href="Administrador_Inicio.php">Menú</a></h1>
		 <ul>
		  <li><a href="Administrador_Alta_Profesor.php" >Alta profesor</a></li>
		  <li><a href="Administrador_modificar_profesor1.php" >Modificar/Eliminar Profesor</a></li>
		  <li><a href="Administrador_Generar_encuesta.php" >Generar Encuesta</a></li>
		  <li><a href="Administrador_Modificar_Encuesta.php" >Modificar/Eliminar Encuesta</a></li>
		  <li><a href="Administrador_Estadistica_Encuesta.php" >Estadística Encuesta</a></li>
		  <li><a href="Administrador_Usuario_Consulta.php" >Gestión Usuarios</a></li>
		 </ul>
	</div>
	<div class="Main">
		<table>
		<ul>
			<tr>
			<div class="separador"></div>
			<div id="divProfesores">
				<h1>Profesores</h1>
					<ul>
					<p><a href="Administrador_Alta_Profesor.php"> Alta Profesor</a></p>
					<p><a href="Administrador_modificar_profesor1.php"> Modificar/Eliminar Profesor</a></p>
					</ul>
				</tr>
			</div>	
			<div class="separador"></div>
			<div id="divEncuestas">	
				<h1>Encuestas</h1>
				<ul>
					<p><a href="Administrador_Generar_encuesta.php"> Generar Encuesta</a></p>
					<p><a href="Administrador_Modificar_Encuesta.php"> Modificar/Eliminar Encuesta</a></p>
					<p><a href="Administrador_Estadistica_Encuesta.php"> Estadística Encuesta</a></p>
				</ul>
			</div>
			<div class="separador"></div>
			<div id="divUsuarios">
				<h1>Usuarios</h1>
					<ul>
					<p><a href="Administrador_Usuario_Consulta.php"> Gestión Usuarios</a></p>
					</ul>
				</tr>
			</div>	
			<div class="separador"></div>
		</ul>
		</table>
	</div>
	<?php }else{ echo "Debe logearse!!!";}?>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body>
</html>