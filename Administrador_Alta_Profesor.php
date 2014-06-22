<!--*********************************************************************
*Proyecto: Web Unizar
*Autores: MarÌa Armero, Lorena Su·rez y Adri·n Sanchez
*DescripciÛn: P·gina principal para el alta de profesores por parte del 
administrador
************************************************************************-->
<html>
<head>
	<link rel="shortcut icon" href="images/icono.png" >
	<title>Campus Ling√ºistica Universidad de Zaragoza - Alta Profesor</title>
	<link rel="stylesheet" type="text/css" href="./Style.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<!--LibrerÌas JQuery-->
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	
	<script type="text/JavaScript">
	$(document).ready(function() { 
		$('#form_alta_profesor').ajaxForm(function() { 
			//Esta funciÛn hace que se envie el formulario por ajax cuando hacemos submit
		}); 
			
    });
	
	function registrar_profesor(){
		var Nombre = document.getElementById("Nombre").value;
		var Apellidos = document.getElementById("Apellidos").value;
		var Mail = document.getElementById("Mail").value;
		var dni = document.getElementById("dni").value;
		var id_profesor = document.getElementById("id_profesor").value;
		var password = document.getElementById("password").value;
		
		$(document).ready(function(){
				$("#resultado").load("Administrador_Alta_Profesor2.php",{alta_profesor:"si",Nombre:Nombre,Apellidos:Apellidos,Mail:Mail,dni:dni,id_profesor:id_profesor,password:password});
		})	
		//document.location.reload();
	}
	</script>
	
	<?php include "bbdd.php"?>
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
			<a href="<?php echo 'cerrarSesion.php'?>">Cerrar sesi√≥n</a>
		</div>
		<div class="UsuarioActual">
				Usuario: <?php echo $_SESSION["k_username"];?>
		</div>
		<p class="tipoUsuario" >
			Administrador - Alta Profesor
		</p>
	</div>
	<div id="menu">
		 <h1><a href="Administrador_Inicio.php">Men√∫</a></h1>
		 <ul>
		  <li><a href="Administrador_Alta_Profesor.php" >Alta profesor</a></li>
		  <li><a href="Administrador_modificar_profesor1.php" >Modificar/Eliminar Profesor</a></li>
		  <li><a href="Administrador_Generar_encuesta.php" >Generar Encuesta</a></li>
		  <li><a href="Administrador_Modificar_Encuesta.php" >Modificar/Eliminar Encuesta</a></li>
		  <li><a href="Administrador_Estadistica_Encuesta.php" >Estad√≠stica Encuesta</a></li>
		  <li><a href="Administrador_Usuario_Consulta.php" >Gesti√≥n Usuarios</a></li>
		 </ul>
	</div>
	<div class="Main">
		<h1> Introduce los datos del profesor... </h1>
		<div class="separador"></div>
		

		<form name="form_alta_profesor" id="form_alta_profesor" action="#" method="post" target="_self">
			<table>
				<tr>
					<td><label>Nombre: </label></td>
					<td><input type="text" id="Nombre" name="Nombre"></input></td>
				</tr>
				<tr>
					<td><label>Apellidos:</label></td>
					<td><input id="Apellidos" name="Apellidos"></input></td>
				</tr>
				<tr>
					<td><label>Mail:</label></td>
					<td><input id="Mail" name="Mail"></input></td>
				</tr>
				<tr>
					<td><label>DNI:</label></td>
					<td><input id="dni" name="dni"></input></td>
				</tr>
				<tr>
					<td><label>Usuario:</label></td>
					<td><input id="id_profesor" name="id_profesor"></input></td>
				</tr>
				<tr>
					<td><label>Password:</label></td>
					<td><input id="password" name="password"></input></td>
				</tr>
			</table>
			<div class="separador"></div>
			<p class='center'><button id="alta_profesor" type="submit" onClick='registrar_profesor()'>Registrar Profesor</button></p>
			<div id='resultado'></div>
		</form>
	</div>	
	<div class="Footer">
		¬©2013 Universidad de Zaragoza 
	</div>
	
</body>
</html>