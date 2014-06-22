<!DOCTYPE html> 
<html> 
<head> 
    <link rel="shortcut icon" href="images/icono.png" > 
    <title>Campus Lingüística Universidad de Zaragoza - Alertas</title> 
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
	<script type="text/JavaScript">
	/******************FORMULARIO form_alertas*******************************/
	$(document).ready(function(){ 
		$('#form_alertas').ajaxForm(function() { 
			//Esta función hace que se envie el formulario por ajax cuando hacemos submit
		}); 
			
    });
	function modificarAlerta(){
		$(document).ready(function(){
				var id_profesor = document.getElementById("id_profesor").value;
				var id_alerta=$("input[name='op_modificar']:checked").val();
				$("#resultado").load("operacionesAlertas.php",{modifica_alerta:"si",id_alerta:id_alerta,id_profesor:id_profesor});
		})	
	}
	
	function eliminarAlerta(){
		$(document).ready(function(){
				var id_alerta = $("input[name='op_modificar']:checked").val();
				$("#resultado").load("operacionesAlertas.php",{elimina_alerta:"si",id_alerta:id_alerta});
		})	
	}
	
	function crearAlerta(){
		var id_profesor = document.getElementById("id_profesor").value;
		$(document).ready(function(){
				$("#resultado").load("operacionesAlertas.php",{crear_alerta:"si",id_profesor:id_profesor});
		})	
	}
	/******************************FORMULARIO datos_alerta******************************/
	$(document).ready(function() { 
		$('#datos_alerta').ajaxForm(function() { 
			//Esta función hace que se envie el formulario por ajax cuando hacemos submit
		}); 
			
    });
	function modificarDatosAlerta(){
		var id_alerta=$("input[name='op_modificar']:checked").val();
		var nombre_alerta=document.getElementById("nombre_alerta").value;
		var fecha_baja=document.getElementById("fecha_baja").value;
		var indice_select = document.getElementById('actividades_asociadas').options.selectedIndex;
		var actividad_asociada = document.getElementById('actividades_asociadas').options[indice_select].value;
		var informacion =document.getElementById("info_alerta").value;
		$(document).ready(function(){
			$("#resultado").load("operacionesAlertas.php",{modificar_datos:"si",id_alerta:id_alerta,informacion:informacion,nombre_alerta:nombre_alerta,fecha_baja:fecha_baja,actividad_asociada:actividad_asociada});
		});		
	}
	/**************************FORMULARIO NUEVA_ALERTA*********************************/
	$(document).ready(function() { 
		//Esta función hace que se envie el formulario por ajax cuando hacemos submit
		$('#nueva_alerta').ajaxForm(function() {});
	});
	
	function crearAlertaNueva(){
		var nombre_alerta = document.getElementById("nombre_alerta").value;
		var fecha_baja = document.getElementById("fecha_baja").value;
		var info_alerta = document.getElementById("info_alerta").value;
		var indice_select = document.getElementById('actividades_asociadas').options.selectedIndex;
		var actividad_asociada = document.getElementById('actividades_asociadas').options[indice_select].value;
		var id_profesor = document.getElementById("id_profesor").value;
		$(document).ready(function() { 
			$("#resultado").load("operacionesAlertas.php",{alta_alerta:"si",id_profesor:id_profesor,nombre_alerta:nombre_alerta,info_alerta:info_alerta,		fecha_baja:fecha_baja,actividad_asociada:actividad_asociada});
		}); 
	}
	</script>
</head> 
<body> 
	<?php 
	session_start();
		//Validar que el usuario este logueado y exista un UID
	if ( !($_SESSION['autenticado'] == 'SI' && isset($_SESSION["k_username"])) )
	{
		//En caso de que el usuario no este autenticado, crear un formulario y redireccionar a la 
		//pantalla de login, enviando un codigo de error
	?>
			<form name="formulario" method="get" action="index.html">
				<input type="hidden" name="msg_error" value="2">
			</form>
			<script type="text/javascript"> 
				document.formulario.submit();
			</script>
	<?php
	}
		include "bbdd.php";
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
			Profesor - Alertas
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
		<form id="form_alertas"> 
			<input id='id_profesor' value='<?php echo $_SESSION['k_username'];?>' hidden></input>
			<h1> ALERTAS </h1> 
			<div class="separador"></div>
			<table  class="tabla" > 
			<tr>
				<td class="cabecera_tabla"><label>Opción</label></td>
				<td class="cabecera_tabla"><label>Nombre de la Alerta</label></td>
				<td class="cabecera_tabla"><label>Actividad Asociada</label></td>
				<td class="cabecera_tabla"><label>Fecha Baja</label></td>
			</tr>
			<?php
			
			$profesor = $_SESSION['k_username'];
			$alertasProfesor = consultaAlertasProfesor($profesor);
			$iteracion=1;
			if (mysql_num_rows($alertasProfesor) > 0){
				while($row = mysql_fetch_array($alertasProfesor)){
					echo "<tr>";
					if ($iteracion == 1){
						echo "<td><input type='radio' name='op_modificar' class='radio' value='".$row['id_alerta']."' checked/></td>";
						$iteracion = $iteracion + 1;
					}else{
						echo "<td><input type='radio' name='op_modificar' class='radio' value='".$row['id_alerta']."' /></td>";
					}
					echo "<td><label>".$row['nombre_alerta']."</label></td>";
					echo "<td><label>".$row['nombre_actividad']."</label></td>";
					echo "<td><label>".$row['FechaBaja']."</label></td>";
					echo "</tr>";
						
				}
			}else
				echo "<p class='comentario'>No tiene alertas</p>";
			?>
			
			</table>
			
			<div class="separador"></div>
			<p class="center">
				<button id='Modificar_Alerta' type="submit" onClick='modificarAlerta()'>Modificar Alerta</button>
				<button id="Eliminar_Alerta" type="submit" onClick='eliminarAlerta()'>Eliminar Alerta</button>
				<button id="Crear_Alerta" type="submit" onClick='crearAlerta()'>Crear Alerta</button>
			</p>
		</form> 
		<div class="separador" width="100%"></div>
		<div id="resultado"></div>		
	</div>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>