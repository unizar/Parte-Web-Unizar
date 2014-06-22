<!DOCTYPE html> 
<html> 
<head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Modificar Encuesta</title> 
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./Style.css"/> 
	<?php include "bbdd.php" ?>
	
	<script type="text/JavaScript">
	
	//Evento para aplicar el filtro
	$(document).ready(function(){
		$( "#buscar" ).click(function( event ) {
			var titulo = document.getElementById("titulo").value;
			$("#resultado").load("auxEncuestas.php",{mostrar_encuestas:"si",titulo:titulo});
			$("#datos_encuesta").empty();
			$("#mensaje").empty();
		});
	})
	//Evento para mostrar todos los encuestas de la BBDD
	$(document).ready(function(){
		$( "#mostrar_todas" ).click(function( event ){
			var titulo = '';
			$("#resultado").load("auxEncuestas.php",{mostrar_encuestas:"si",titulo:titulo});
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
	function mostrarDatosEncuesta(){
		$(document).ready(function(){
				var id_encuesta=$("input[name='id_encuesta']:checked").val();
				$("#datos_encuesta").load("auxEncuestas.php",{modifica_encuesta:"si",id_encuesta:id_encuesta});
				$("#mensaje").empty();
		})	
	}
	//funcion que elimina un encuesta
	function eliminaEncuesta(){
		$(document).ready(function(){
				var id_encuesta=$("input[name='id_encuesta']:checked").val();
				$("#resultado").load("auxEncuestas.php",{eliminar_encuesta:"si",id_encuesta:id_encuesta});
				$("#datos_encuesta").empty();
				$("#mensaje").empty();
		})
	}
	/*************************FORMULARIO modificar_datos_encuesta************************************/
	$(document).ready(function() {
            $('#modificar_datos_encuesta').ajaxForm(function() { 
                //Esta función hace que se envie el formulario por ajax cuando hacemos submit
            }); 
	}); 

	function modificarEncuesta(){
		var id_encuesta=$("input[name='id_encuesta']:checked").val();
		var titulo = document.getElementById("tituloAct").value;
		var preguntas = new Array();
		var nomPreg = new Array();
		//función que recorre todos los checkbox marcados
        // $("input[type='checkbox']:checked").each(function() {
            // opciones.push($(this).val());//para guardar los valores de los checkbox marcados
			// nomOp.push($(this).attr('name').substr(-2));//para guardar los nombres de los checkbox
        // });
		//función que recorre todos los textos de las preguntas
		$("[id*=Pregunta]").each(function() {
            preguntas.push($(this).val());//para guardar los valores de los checkbox marcados
			nomPreg.push($(this).attr('name'));//para guardar los nombres de los checkbox
        });
		$(document).ready(function(){
			$("#mensaje").load("auxEncuestas.php",{modificar:"si",id_encuesta:id_encuesta,titulo:titulo,preguntas:preguntas,nombresPreg:nomPreg});
		});
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
			Administrador - Modificar Encuesta
		</p>
		 
	</div>
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
		<form id='modificar_datos_encuesta'>
			<div id="datos_encuesta"></div>
		</form>
		<div id="mensaje"></div>
		<div class="separador"></div>
	</div>
		
	<div class="Footer">
			©2013 Universidad de Zaragoza 
	</div>
	
  
</body>