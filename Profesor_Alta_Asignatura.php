<!DOCTYPE html> 
<html> 
<head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Alta Asignatura</title> 
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
	<?php include "bbdd.php"?>
	
	<script type="text/javascript">
		function altaAsignatura(){
			var idProfesor = document.getElementById("id_profesor").value;
			var asignatura = document.getElementById("Asignatura").value;
			var nombre = document.getElementById("Nombre").value;
			var informacion = document.getElementById("Informacion").value;
			$(document).ready(function(){
				$("#resultado").load("AltaAsignatura.php",{GuardarAsignatura:"Si",idProfesor:idProfesor,asignatura:asignatura,nombre:nombre,informacion:informacion})
			})			
		}
	
	
	</script>
	
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
			Profesor - Alta Asignatura
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
		<input type="hidden" id="id_profesor" value="<?php echo $_SESSION['k_username'];?>" />
		<h1> Introduce los datos de la asignatura... </h1> 
		<div class="separador"></div>
			<table>
				<tr>
					<td><label>Asignatura: </label></td>
					<td><input type="text" id="Asignatura" name="Asignatura" style="width:220px"></input></td> 
				</tr>
				<tr>
					<td><label>Nombre: </label></td>
					<td><input type="text" id="Nombre" size='100' name="Nombre" style="width:220px"></input></td> 
				</tr>	
				<tr>
					<td><label style="vertical-align:top">Información: </label></td>
					<td><p></p><textarea id="Informacion" maxlength='600' name="Informacion" rows="10" cols="40"></textarea></td>
				</tr>
			</table>
			<div id="resultado"></div>
			<div class="separador"></div>
			<p class="center"><button id="alta_profesor" type="submit" onClick="altaAsignatura();">Crear asignatura</button></p>
	</div>
	<div class="Footer">
				©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>