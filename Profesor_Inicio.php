<!DOCTYPE html> 
<html> 
<head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Profesor</title> 
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php include "bbdd.php" ?>
	<style>
	
	</style>
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
			Profesor - Inicio
		</p>
		 
	</div>
	<div id="menu">
		 <h1><a href="Profesor_Inicio.php">Menú</a></h1>
		 <ul>
		  <li><a href="Profesor_Alta_Asignatura.php" >Alta Asignatura</a></li>
		  <li><a href="Profesor_Modificar_Eliminar_Asignatura.php" >Modificar/Eliminar Asignatura</a></li>
		  <li><a href="Profesor_Alta_Actividad.php" >Alta Actividad </a></li>
		  <li><a href="Profesor_Modificar_Eliminar_Actividad.php" title="...">Modificar/Eliminar Actividad</a></li>
		  <li><a href="Profesor_Validar_Usuario.php" >Validar Alumnos</a></li>
		  <li><a href="Profesor_Baja_Usuario.php" >Baja Alumnos</a></li>
		  <li><a href="Profesor_Visualizar_Encuestas.php" >Visualizar Encuestas</a></li>
		  <li><a href="Profesor_Alertas.php" >Alertas</a></li>
		  <li><a href="Profesor_Estadistica_Encuestas.php" >Estadística Encuestas</a></li>
		 </ul>
	</div>
	<div class="Main">
	<br>
		<div class="separador"></div>
		<div id="divProfesores">
			<h1>Asignaturas</h1>
				<ul>
				<p><a href="Profesor_Alta_Asignatura.php"> Alta asignatura </a></p>
				<p><a href="Profesor_Modificar_Eliminar_Asignatura.php"> Modificar/Eliminar asignatura  </a></p>
				</ul>
			</tr>
		</div>	
		<div class="separador"></div>
		<div id="divEncuestas">	
			<h1>Actividades</h1>
			<ul>
				<p><a href="Profesor_Alta_Actividad.php"> Alta Actividad</a></p>
				<p><a href="Profesor_Modificar_Eliminar_Actividad.php"> Modificar/Eliminar Actividad</a></p>
			</ul>
		</div>
		<div class="separador"></div>
		<!--<div id="divEncuestas">	
			<h1>Encuestas</h1>
			<ul>
				<p><a href="Profesor_Encuestas.php"> Publicar encuestas</a></p>
			</ul>
		</div>-->
		<div class="separador"></div>
		<div id="divAlumnos">	
			<h1>Alumnos</h1>
			<ul>
				<p><a href="Profesor_Validar_Usuario.php"> Validar Alumnos</a></p>
				<p><a href="Profesor_Baja_Usuario.php"> Baja Alumnos</a></p>
			</ul>
		</div>
		<div class="separador"></div>
		<div id="divAlertas">	
			<h1>Alertas</h1>
			<ul>
				<p><a href="Profesor_Alertas.php"> Crear/Modificar/Eliminar alertas</a></p>
			</ul>
		</div>
		<div class="separador"></div>
		<div id="divEncuestas">	
			<h1>Encuestas</h1>
			<ul>
				<p><a href="Profesor_Visualizar_Encuestas.php" >Visualizar Encuestas</a></p>
				<p><a href="Profesor_Estadistica_Encuestas.php" >Estadística Encuestas</a></p>
			</ul>
		</div>
		<div class="separador"></div>
	</div>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>