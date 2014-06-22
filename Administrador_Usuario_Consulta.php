<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="images/icono.png" >
	
	<title>Campus Lingüística Universidad de Zaragoza - Consulta Usuario</title>
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="./Style.css"/>
	<?php include "bbdd.php" ?>
	
	<script type="text/JavaScript">
	
	//Evento para aplicar el filtro
	$(document).ready(function(){
		$( "#ApFiltro" ).click(function( event ) {
			var nombre = document.getElementById("Nombre").value;
			var apellidos = document.getElementById("Apellidos").value;
			var dni = document.getElementById("Dni").value;
			$("#resultado").load("filtroUsuarios.php",{mostrar_usuarios:"si",nombre:nombre,apellidos:apellidos,dni:dni});
		});
		
	})
	//Evento para mostrar todos los usuarios de la BBDD
	$(document).ready(function(){
		$( "#mostrar_todos" ).click(function( event ) {
			var nombre = '';
			var apellidos = '';
			var dni = '';
			$("#resultado").load("filtroUsuarios.php",{mostrar_usuarios:"si",nombre:nombre,apellidos:apellidos,dni:dni});
		});
		
	})
	
	
	/********************FORMULARIO OPERACIONES_USUARIO**************************************/
	$(document).ready(function() { 
            // bind 'myForm' and provide a simple callback function 
            $('#operaciones_usuarios').ajaxForm(function() { 
                //Esta funci�n hace que se envie el formulario por ajax cuando hacemos submit
            }); 
			
        }); 
	//funcion que muestra el formulario para posteriormente modificar
	function mostrarDatosUsuario(){
		$(document).ready(function(){
				var id_usuario=$("input[name='id_usuario']:checked").val();
				$("#datos_usuario").load("filtroUsuarios.php",{modifica_usuario:"si",id_usuario:id_usuario});
		})	
	}
	//funcion que elimina un usuario
	function eliminaUsuario(){
		$(document).ready(function(){
				var id_usuario=$("input[name='id_usuario']:checked").val();
				alert(id_usuario);
				$("#resultado").load("filtroUsuarios.php",{eliminar_usuario:"si",id_usuario:id_usuario});
		})
	}
	/*************************FORMULARIO modificar_datos_usuario************************************/
	$(document).ready(function() {
            $('#modificar_datos_usuario').ajaxForm(function() { 
                //Esta funci�n hace que se envie el formulario por ajax cuando hacemos submit
            }); 
			
			
        }); 
	
		function modificarUsuario(){
			var id_usuario=$("input[name='id_usuario']:checked").val();
			var usuario = document.getElementById("usuario_nuevo").value;
			var nombre = document.getElementById("Nombre_usuario").value;
			var apellidos = document.getElementById("Apellidos_usuario").value;
			var dni = document.getElementById("dni_usuario").value;
			var mail = document.getElementById("mail").value;
			$(document).ready(function(){
				$("#datos_usuario").load("filtroUsuarios.php",{modificar:"si",id_usuario:id_usuario,usuario:usuario,nombre:nombre,apellidos:apellidos,dni:dni,mail:mail});
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
			Administrador - Gestión Usuarios
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
		<h1> Introduce los datos del usuario... </h1>
		<div class="separador"></div>
		<table class="tabla">
			
			<tr>
				<td><label>Nombre: </label><input id="Nombre" name="Nombre" type="text" value=""></input></td>
				<td><label>Apellidos:</label><input id="Apellidos" name="Apellidos" value="" type="text"></input></td>
				<td><label>DNI:</label><input id="Dni" name="dni" type="text" value=""></input></td>
				<td><button  class="boton" id="ApFiltro" name="filtro" >Aplicar Filtro</button></td>
			</tr>
				
			
		</table>
		<p class="center"><button  class="boton" id="mostrar_todos" name="filtro" >Mostrar Todos los Usuarios</button></p>
		<form id="operaciones_usuarios">
			<div id="resultado"></div>
			<div id="operaciones">
				
			</div>
		</form>
		<form id='modificar_datos_usuario'>
			<div id="datos_usuario"></div>
		</form>
		<div class="separador"></div>
		
		</div>
	</div>	
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body>

</html>