<!DOCTYPE html>
<html> 
<head> 
    <link rel="shortcut icon" href="images/icono.png" > 
    <title>Campus Lingüística Universidad de Zaragoza - Validar Usuario</title> 
    <script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Style.css"/>
	<?php include "bbdd.php"?>

	<script type="text/javascript">
	
		function seleccionado() {
			var idAsignatura = document.getElementById("AsignaturasProfesor").value;
			if (idAsignatura != 0){	
				$(document).ready(function(){
						$("#alumnosAValidar").load("validacionAlumnos.php",{mostrar_alumnos:"si",idAsignatura:idAsignatura});
				})	
			}
			else
			{
				alert("Debe seleccionar una Asignatura");
			}
		}
			
		function validar(e) {
			if(e.checked==true)
			{
				var idAsignatura = document.getElementById("AsignaturasProfesor").value;
				var alumno = e.value;
				$(document).ready(function(){
						$("#alumnosAValidar").load("validacionAlumnos.php",{validacion:"si",alumno:alumno,idAsignatura:idAsignatura});
				})
			}
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
		<p class="tipoUsuario">
			Profesor - Validar Usuario
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
		<div class="separador"></div>
		<h1>Seleccione la asignatura: </h1>
			 
			<div id="asignaturas_profesor">
					<?php
						$listaAsignaturas=consultarAsignaturasProfesor($_SESSION['k_username']);
						if (mysql_num_rows($listaAsignaturas) == 0)
						{
							?>
								<script type="text/javascript">
									alert("No hay asignatuas disponibles");
								</script>
							<?php	
						}else
						{	
							echo "<select id=\"AsignaturasProfesor\" name=\"AsignaturasProfesor\" onChange=\"seleccionado()\">\n";
							echo "<option selected value=\"0\"> Seleccione un Item </option>\n";
							while($row = mysql_fetch_array($listaAsignaturas))
							{
								echo "<option value=\"".$row['idAsignatura']."\" >".$row['Nombre']."</option>\n";
							}
							echo "</select>\n\n";
							
							echo "</p>";
						}
					?>
					<div id="alumnosAValidar"></div>
					<div id="resultado"></div>
			</div>
			
	</div> 
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>