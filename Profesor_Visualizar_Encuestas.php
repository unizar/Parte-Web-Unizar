<!DOCTYPE html> 
<html> 
<head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Validar Encuestas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="./Style.css"/> 
	<?php include "bbdd.php" ?>
	
	<script type="text/JavaScript">
	
	//Evento para aplicar el filtro de busqueda de encuestas
	$(document).ready(function(){
		$( "#buscar" ).click(function( event ) {
			var titulo = document.getElementById("titulo").value;
			$("#resultado").load("auxEncuestas.php",{visualizar_listado_encuestas:"si",titulo:titulo});
			$("#datos_encuesta").empty();
			$("#mensaje").empty();
		});
	})
	//Evento para mostrar todos los encuestas de la BBDD
	$(document).ready(function(){
		$( "#mostrar_todas" ).click(function( event ){
			var titulo = '';
			$("#resultado").load("auxEncuestas.php",{visualizar_listado_encuestas:"si",titulo:titulo});
			$("#datos_encuesta").empty();
			$("#mensaje").empty();
		});
	})
	
	
	/********************FORMULARIO OPERACIONES_USUARIO**************************************/
	$(document).ready(function() { 
            // bind 'myForm' and provide a simple callback function 
            $('#operaciones_encuestas').ajaxForm(function() { 
                //Esta función hace que se envie el formulario por ajax cuando hacemos submit
            }); 
			
        }); 
	//funcion que muestra el formulario para posteriormente modificar
	function visualizarDatosEncuesta(){
		$(document).ready(function(){
				var id_encuesta=$("input[name='id_encuesta']:checked").val();
				$("#datos_encuesta").load("auxEncuestas.php",{visualizar_preguntas_encuesta:"si",id_encuesta:id_encuesta});
				$("#mensaje").empty();
		})	
	}

	/*************************FORMULARIO modificar_datos_encuesta************************************/
	$(document).ready(function() {
            $('#visualizar_datos_encuesta').ajaxForm(function() { 
                //Esta función hace que se envie el formulario por ajax cuando hacemos submit
            }); 
	}); 


	
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
			Profesor - Visualizar Encuestas
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
		<h1> Introduce título de encuesta... </h1>
		<div class="separador"></div>
		<table class="tabla">
			<tr>
				<td><label>T&iacutetulo: </label><input id="titulo" name="titulo" type="text" value=""></input></td>
				<td><button  class="boton" id="buscar" name="filtro" >Buscar Encuesta</button></td>
			</tr>
		</table>
		<p class="center"><button  class="boton" id="mostrar_todas" name="filtro" >Mostrar todas las encuestas</button></p>
		<form id="operaciones_encuestas">
			<div id="resultado"></div>
			<div id="operaciones"></div>
		</form>
		<form id='visualizar_datos_encuesta'>
			<div id="datos_encuesta"></div>
		</form>
		<div id="mensaje"></div>
		<div class="separador"></div>
	</div>
		
	<div class="Footer">
			©2013 Universidad de Zaragoza 
	</div>
	
  
</body>