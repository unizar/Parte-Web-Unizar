<!DOCTYPE html> 
<html> 
<head> 
    <link rel="shortcut icon" href="images/icono.png" > 
    <title>Campus Lingüística Universidad de Zaragoza - Modificar-Eliminar Asignatura</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="Style.css"/> 
	<?php include "bbdd.php" ?>
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
			Profesor - Modificar/Eliminar Asignatura
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
		<form id="modificar_asignatura" method="post"> 
			<h1> Elige la Asignatura que vas a modificar o eliminar... </h1> 
			<div class="separador"></div>
			<div id="datos_asignaturas" class="cuadro_texto"> 
				<p></p> 
				<form name="modificar_eliminar_asignatura" action="#" method="post">
					<table class="tabla"> 
						<tr> 
							<td class="cabecera_tabla">Opción</td> 
							<td class="cabecera_tabla"><b>ASIGNATURA</b></td> 
							<td class="cabecera_tabla"><b>Nombre Asignatura</b></td> 
						</tr> 
						<?php
							$listaAsignaturas=consultaAsignaturas();
							while($row = mysql_fetch_array($listaAsignaturas)){
								echo '<tr>';
								echo '<td><input type="radio" name="id_asignatura" value="'.$row['idAsignatura'].'"></td>';
								echo '<td>'.$row['Asignatura'].'</td>';
								echo '<td>'.$row['Nombre'].'</td>';
								echo '</tr>';
							}
						?>
					</table> 
					<div class="separador"></div>
					<p class="center">
						<button name="modificar" value="modifica_asignatura" type="submit" >Modificar Asignatura</button>
						<button name="eliminar" value="elimina_asignatura" type="submit" >Eliminar Asignatura</button>
					</p>
				</form>
				<p></p>
			</div>
			<div>
				<?php
				if(isset($_POST['eliminar'])){
					if(isset($_POST['id_asignatura'])){
						$id_asignatura=$_POST['id_asignatura'];
						if(eliminarAsignatura($id_asignatura) && eliminarUsuariosAsignatura($id_asignatura))
						{
							?>
								<script type="text/javascript">
									alert("La asignatura se ha eliminado correctamente");
									location.href='Profesor_Modificar_Eliminar_Asignatura.php?id=tw_redireccion';
								</script>
							<?php		
						}
						else
						{
							echo "<p class='comentario'>El profesor no se ha eliminado correctamente</p>";
							?>
								<script type="text/javascript">
										alert("La asignatura se ha eliminado correctamente");
										location.href='Profesor_Modificar_Eliminar_Asignatura.php?id=tw_redireccion';
								</script>
							<?php
						}
					}
				}
				if(isset($_POST['modificar']))
				{
					$idAsignatura=$_POST['id_asignatura'];
					$consulta = consultaAsignatura($idAsignatura);
					if($row = mysql_fetch_array($consulta)){
						echo "<form name='modifica_datos' method='post'>";
						echo "<div class='separador2'></div>";
						echo "<h2> Introduce los datos de la asignatura... </h2>";
						echo "<div class='separador'></div>";
						echo "<div id='datos_profesor' class='cuadro_texto'>";
						echo "<table class='center'>";
						echo "<tr><td><label>Asignatura:</label></td><td><input name='Asignatura' value='".$row['Asignatura']."'></input></td></tr>";
						echo "<tr><td><label>Nombre:</label></td><td><input name='Nombre' size='50' value='".$row['Nombre']."'></input></td></tr>";
						
						echo "<tr><td><label style='vertical-align:top'>Informaci&oacuten: </label></td>";
						echo "<td><textarea id='Informacion' name='Informacion' maxlength='600' rows='10' cols='40'>".$row['Informacion']."</textarea></td></tr>";
						echo "</table>";
						echo "<div class='separador'></div>
								<p class='center'><button name='modifica_asignatura' value='".$idAsignatura."' >Modificar Asignatura</button> 
								</div> ";
						echo "</form>";
					}
				}
				if(isset($_POST['modifica_asignatura'])){
					if(($_POST['Asignatura'] != "") && ($_POST['Nombre'] != "") && ($_POST['Informacion'] != "") && 
					($_POST['modifica_asignatura'] != ""))
					{
						$asignatura=$_POST['Asignatura'];
						$nombre=$_POST['Nombre'];
						$informacion=$_POST['Informacion'];
						$idAsignatura=$_POST['modifica_asignatura'];
						
						if(modificaDatosAsignatura($idAsignatura,$asignatura,$nombre,$informacion))
						{
							$self = $_SERVER['PHP_SELF']; //Obtenemos la p�gina en la que nos encontramos
							header("refresh:1; url=$self"); //Refrescamos cada segundo
							//echo "<p class='comentario'>Datos Actualizados</p>";
							?>
								<script type="text/javascript">
									alert("Datos Actualizados");
									location.href='Profesor_Modificar_Eliminar_Asignatura.php?id=tw_redireccion';
								</script>
							<?php
						}
					}else{
						?>
						<script type="text/javascript">
							alert("Todos los campos son obligatorios");
						</script>
						<?php
					}	
				}	
				?>
			</div>
		</form>
	</div>
	<div class="Footer">
		©2013 Universidad de Zaragoza 
	</div>
</body> 
</html>