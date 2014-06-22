<!DOCTYPE html> 
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Generar Encuesta</title> 
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="./Style.css"/> 
	<?php include "bbdd.php" ?>
	
	<script type="text/javascript">		
	
		$(document).ready(function() {
			$('#formMensaje').ajaxForm(function() { 
				//Esta función hace que se envie el formulario por ajax cuando hacemos submit
			}); 	
        }); 
		$(document).ready(function(){
			$( "#guardar_encuesta" ).click(function( event ) {
				var titulo = document.getElementById("titulo").value;
				var preguntas = new Array();
				var nomPreg = new Array();
				//función que recorre todos los textos de las preguntas
				$("[id*=Pregunta]").each(function() {
					preguntas.push($(this).val());//para guardar los valores de los checkbox marcados
					nomPreg.push($(this).attr('name'));//para guardar los nombres de los checkbox
				});
				$(document).ready(function(){
					$("#mensaje").load("auxAltaEncuesta.php",{altaEncuesta:"si",titulo:titulo,preguntas:preguntas,nombresPreg:nomPreg});
				});
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
			<form name="formulario" method="post" action="login.php">
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
			Administrador - Generar Encuesta
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
			<h1 class="center">Crear Encuesta</h1>
			<h2> Título: <input type="text" id="titulo" name="titulo"></input></h2>
			<div class="separador"></div>
			<h2> Introduce las preguntas... </h2> 
			<label>Seleccione las respuestas que desee mostrar con la pregunta</label>
			<p></p>
			
			<table name='generar_encuesta' class='tabla'>
			<tr>
				<td class='cabecera_tabla'><b>Preguntas</b></td>
			</tr>
			<?php
			$i=1;
			while($i<=5){//Para pintar los campos de texto de las preguntas y los checkbox de las opciones
				echo "<tr>";
				echo "	<td><b>Pregunta&nbsp;&nbsp;".$i.":<input id='Pregunta".$i."' name='Pregunta".$i."' size='50'></input></b></td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
			?>
			<div class="separador"></div>
			<p class="center"><button class="boton" id="guardar_encuesta" name="guardarEncuesta">Guardar Encuesta</button> </p>
		<form id="formMensaje">
			<div id="mensaje">
			</div>
		</form>
		
	</div>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 