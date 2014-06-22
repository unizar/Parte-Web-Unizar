<!DOCTYPE html> 
<html> 
<head> 
    <link rel="shortcut icon" href="images/icono.png" > 
    <title>Campus Lingüística Universidad de Zaragoza - Modificar - Eliminar Actividad</title> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="./Style.css"/>
	
	<?php include "bbdd.php"?>
	<script type="text/javascript">
		
		//Funcion que devuelve el id de la asignatura seleccionada en el desplegable
		function seleccionado() {
			var idActividad = document.getElementById("Actividades_Modificar").value;
			return idActividad;
		}
		
		//Funcion que devuelve el id de la encuesta seleccionada
		function chkseleccionado() {
			var idEncuesta = document.getElementById("tiposEncuestas").value;
			return idEncuesta;
		}
		
		//Funcion que elimina la actividad de bd
		function EliminaActividad(){
			$(document).ready(function(){
				var idActividad=seleccionado();
				$("#resultado").load("ModificacionDatosActividades.php",{eliminarActividad:"si",idActividad:idActividad});
			})
		}	
		
		//funcion que muestra el formulario con los datos de la actividad para posteriormente modificar
		function MostrarActividad(){
		$(document).ready(function(){
				var idActividad=seleccionado();
				$("#datos_actividad").load("ModificacionDatosActividades.php",{MostrarDatos:"si",idActividad:idActividad});
			})	
		}	
		
		//funcion que muestra el desplegable de las encuestas o lo oculta
		function activarDes(e)
		{
			var div = document.getElementById("desplegableEncuesta");
			//Verifica el estatus original del elemento , para decidir si la acción es ocultar o mostrar
			if (e.checked){
				$("#desplegableEncuesta").load("ModificacionDatosActividades.php",{MostrarEncuesta:"Si"});
				div.style.display = "block";
			}else
			{
				//Si esta oculto de despliega
				div.style.display = "none";
			}
		}
	
		//Funcion que modifica la actividad en Base de datos	
		function ModificaActividad(){
			$(document).ready(function(){
			var idProfesor = document.getElementById("id_profesor").value;
			var chk = document.getElementById("Encuesta");
			var nombre = document.getElementById("Nombre").value;
			var fecha = document.getElementById("Fecha").value;
			var hora = document.getElementById("Hora").value;
			var lugar = document.getElementById("Lugar").value;
			var duracion = document.getElementById("Duracion").value;
			var enlaces = document.getElementById("Informacion").value;
			var creditos = document.getElementById("Creditos").value;
			var idActividad=seleccionado();
			if (chk.checked)
			{	
				var idEncuesta=chkseleccionado();
				$(document).ready(function(){
				$("#datos_actividad").load("ModificacionDatosActividades.php",{ModificarActividad:"Si",idProfesor:idProfesor,nombre:nombre,fecha:fecha,hora:hora,lugar:lugar,duracion:duracion,enlaces:enlaces,idEncuesta:idEncuesta,idActividad:idActividad,creditos:creditos});
				})
			}else
			{
				var idEncuesta="0"
				$(document).ready(function(){
					$("#datos_actividad").load("ModificacionDatosActividades.php",{ModificarActividad:"Si",idProfesor:idProfesor,nombre:nombre,fecha:fecha,hora:hora,lugar:lugar,duracion:duracion,enlaces:enlaces,idEncuesta:idEncuesta,idActividad:idActividad,creditos:creditos});
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
			Profesor - Modificar/Eliminar Actividad
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
		<div id="Principal">
		<input type="hidden" id="id_profesor" value="<?php echo $_SESSION['k_username'];?>" />
			<h1> Elige la actividad que vas a modificar o eliminar... </h1> 
			<div class="separador"></div>
				<div id="actividades">
						<?php
							$listaActividades= consultaActividadesProfesor($_SESSION['k_username']);
							echo "<select id=\"Actividades_Modificar\" name=\"Actividades_Modificar\" onChange=\"seleccionado()\">\n";
							echo "<option selected value=\"0\"> Seleccione un Item </option>\n";
							while($row=mysql_fetch_array($listaActividades))
							{
								echo "<option value=\"".$row['id_Actividad']."\" >".$row['Nombre']."</option>\n";
							}
							echo "</select>\n\n";
						?>
					
				</div>
			<p class="center">
				<button id="modifica_actividad" name="modifica_actividad" type="submit" onClick="MostrarActividad()">Modificar Actividad</button>
				<button id="elimina_actividad" name="elimina_actividad" type="submit" onClick="EliminaActividad()">Eliminar Actividad</button>
			</p>
			<div id="datos_actividad">
				<div id="divmostrarEncuesta" class="separador"></div>
			</div>
			<div id="resultado"></div>
			<div class="separador"></div>

		</div>
			
	</div>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>