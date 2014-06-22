<!DOCTYPE html> 
<html> 
<head> 
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Alta Actividad</title> 
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Style.css"/> 
	<?php include "bbdd.php"?>
	
	<script type="text/javascript">
		//función para activar radiobutton de tipo de encuesta
		function activarDes(e)
		{
			var div = document.getElementById("desplegableEncuesta");
			var nombre = document.getElementById("Nombre").value;
			var fecha = document.getElementById("Fecha").value;
			var hora = document.getElementById("Hora").value;
			var lugar = document.getElementById("Lugar").value;
			var duracion = document.getElementById("Duracion").value;
			var enlaces = document.getElementById("Enlaces").value;
			var creditos = document.getElementById("Creditos").value;
			//Verifica el estatus original del elemento , para decidir si la acción es ocultar o mostrar
			
			if(div.style.display==='block'){
				//si esta visible se modifica a ocultar
				div.style.display = "none";
				}else
				{
					$(document).ready(function(){
						//Si esta oculto de despliega
						div.style.display = "block";
						$("#desplegableEncuesta").load("desplegableEncuestas.php",{MostrarEncuesta:"Si"});
					});
				}
		}
		function seleccionado() {
			var idEncuesta = document.getElementById("tiposEncuestas").value;
			$("#divmostrarEncuesta").load("desplegableEncuestas.php",{muestraEncuestadiv:"Si",idEncuesta:idEncuesta});
			return idEncuesta;
		}
		
		
		$(document).ready(function() {
			$('#resultados_actividad').ajaxForm(function() { 
				//Esta función hace que se envie el formulario por ajax cuando hacemos submit
			}); 	
        }); 
		
		function altaActividad(){
			$(document).ready(function(){
			var idProfesor = document.getElementById("id_profesor").value;
			var chk = document.getElementById("Encuesta");
			var nombre = document.getElementById("Nombre").value;
			var fecha = document.getElementById("Fecha").value;
			var hora = document.getElementById("Hora").value;
			var lugar = document.getElementById("Lugar").value;
			var duracion = document.getElementById("Duracion").value;
			var creditos = document.getElementById("Creditos").value;
			var enlaces = document.getElementById("Enlaces").value;	
			if (chk.checked)
			{	
				var idEncuesta=seleccionado();
				$(document).ready(function(){
					$("#resultadoAltaActividad").load("desplegableEncuestas.php",{EncuestaMarcada:"Si",idProfesor:idProfesor,nombre:nombre,fecha:fecha,hora:hora,lugar:lugar,duracion:duracion,enlaces:enlaces,idEncuesta:idEncuesta,creditos:creditos})
				})
			}else
			{
				$(document).ready(function(){
					$("#resultadoAltaActividad").load("desplegableEncuestas.php",{EncuestaNoMarcada:"Si",idProfesor:idProfesor,nombre:nombre,fecha:fecha,hora:hora,lugar:lugar,duracion:duracion,enlaces:enlaces,creditos:creditos})
				})
			}
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
			Profesor - Alta Actividad
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
		<div id="Principal">
		<h1> Introduce los datos de la actividad... </h1> 
		<div class="separador"></div>
			<table>
				<tr>
					<td><label>Nombre: </label></td>
					<td colspan=2><input id="Nombre" name="Nombre"></input></td>
				</tr>
				<tr>
					<td><label>Fecha: </label></td>
					<td colspan=2><input type="date" id="Fecha" name="Fecha"></input></td>
				</tr>
				<tr>
					<td><label>Hora: </label></td>
					<td colspan=2><input type="time" id="Hora" name="Hora"></input></td>
				</tr>
				<tr>
					<td><label>Lugar: </label></td>
					<td colspan=2><input id="Lugar" name="Lugar"></input></td>
				</tr> 
				<tr>
					<td><label>Duración: </label></td>
					<td colspan=2><input id="Duracion" size="2" name="Duracion"></input> horas</td>
				</tr> 
				<tr>
					<td><label>Créditos: </label></td>
					<td colspan=2><input id="Creditos" size="2" name="Creditos"></input> créditos</td>
				</tr> 
				<tr>
					<td><label style="vertical-align:top">Información: </label></td>
					<td colspan=2><textarea id="Enlaces" maxlength='600' name="Enlaces" rows="10" cols="40" placeholder="Inserte aqui los enlaces relacionados"></textarea></td>
				</tr>
				<tr>
					<td><label>Añadir encuesta: </label></td>
					<td><input type="checkbox" id="Encuesta" name="Encuesta" onclick="activarDes(this);"></input></td>
					<td align="left">
						<div id="desplegableEncuesta" style="display:none">
						</div>
					</td>
				</tr> 
			</table>
			<div class="separador"></div>
			<p class="center"><button id="alta_profesor" type="submit" onClick="altaActividad()">Crear Actividad</button></p>				
			<div id="resultadoAltaActividad">
			</div>
			</div>
			<div id="divmostrarEncuesta" class="separador"></div>
	</div>
	<div class="Footer">
			©2013 Universidad de Zaragoza 
	</div>
	
</body> 
</html>