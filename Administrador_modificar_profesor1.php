<!DOCTYPE html> 
<html> 
<head>
	<link rel="shortcut icon" href="images/icono.png" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Campus Lingüística Universidad de Zaragoza - Modificar Profesor</title> 
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
	
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	
	<script type="text/javascript"> 
	$(document).ready(function() { 
		$('#form_modificar_eliminar_profesor').ajaxForm(function() { 
			//Esta función hace que se envie el formulario por ajax cuando hacemos submit
		}); 
			
	});
	
		$(document).ready(function() { 
		$('#modifica_datos').ajaxForm(function() { 
			//Esta función hace que se envie el formulario por ajax cuando hacemos submit
		}); 
			
	});
	
	function modificarProfesor(){
		var id_profesor=$("input[name='id_profesor']:checked").val();
		
		$(document).ready(function(){
			$("#resultado").load("Administrador_Modificar_Eliminar_Profesor2.php",{modifica:"si",id_profesor:id_profesor});
		})	
	}
	
	function modificar_datos_profesor(){
		var id_profesor = $("input[name='id_profesor']:checked").val();
		var nombre = document.getElementById("Nombre").value;
		var apellidos = document.getElementById("Apellidos").value;
		var dni = document.getElementById("dni").value;
		var mail = document.getElementById("mail").value;
		var usuario= document.getElementById("usuario").value;

		$(document).ready(function(){
			$("#resultado").load("Administrador_Modificar_Eliminar_Profesor2.php",{modifica_profesor:"si",nombre:nombre,
								apellidos:apellidos,dni:dni,mail:mail,usuario:usuario});
		})
	}
	
	function eliminaProfesor(){
		var id_profesor = $("input[name='id_profesor']:checked").val();
		$(document).ready(function(){
			$("#resultado").load("Administrador_Modificar_Eliminar_Profesor2.php",{elimina:"si",id_profesor:id_profesor});
		})	
		setTimeout("location.href='Administrador_modificar_profesor1.php'", 100);
	}
	</script>

</head> 
<body> 
	<?php 
	include "bbdd.php";
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
			Administrador - Modificar Profesor
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
		<form id="form_modificar_eliminar_profesor" method="post" > 
			<h1> Elige el profesor que vas a modificar... </h1> 
			<div class="separador"></div>
			<div id="datos_profesores" class="cuadro_texto"> 
				<p></p> 
					<table class="tabla"> 
						<tr> 
							<td class="cabecera_tabla"><b>Opción</b></td> 
							<td class="cabecera_tabla"><b>USUARIO</b></td> 
							<td class="cabecera_tabla"><b>NOMBRE PROFESOR</b></td> 
						</tr>
						<?php
							$listaProfesores=consultaProfesores();
							while($row = mysql_fetch_array($listaProfesores)){
								echo '<tr>';
								echo '<td><input type="radio" name="id_profesor" value="'.$row['usuario'].'"></td>';
								echo '<td>'.$row['usuario'].'</td>';
								echo '<td>'.$row['nombre'].' '.$row['apellidos'].'</td>';
								echo '</tr>';
							}
						?>
					</table>
					<div class="separador"></div>
					<p class="center">
						<button name="modifica" onClick="modificarProfesor()" type="submit" >Modificar Profesor</button>
						<button name="elimina" onClick="eliminaProfesor()" type="submit" >Eliminar Profesor</button>
					</p> 
				<p></p> 
			</div> 
			<div id='resultado'></div>
		</form> 
	</div>
	<div class="Footer">
				©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>