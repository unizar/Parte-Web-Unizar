<?php
include 'bbdd.php';
if(isset($_POST['elimina'])){
	if(isset($_POST['id_profesor'])){
		$id_profesor=$_POST['id_profesor'];
		if (!empty($id_profesor)){
			if(eliminarProfesor($id_profesor)){
				?>
					<script type="text/javascript">
						alert("El profesor se ha eliminado correctamente");
					</script>
				<?php
			}else{
				?>
					<script type="text/javascript">
						alert("Error al eliminar");
					</script>
				<?php
			}
		}else{
			?>
				<script type="text/javascript">
					alert("Debe seleccionar un profesor");
				</script>
			<?php
		}
	}
}
if(isset($_POST['modifica'])){
	$idProfesor=$_POST['id_profesor'];
	$consulta = consultaUsuario($idProfesor);
	if($row = mysql_fetch_array($consulta)){
		echo "<form name='modifica_datos' method='post'>";
		echo "<div class='separador2'></div>";
		echo "<h2> Introduce los datos del profesor... </h2>";
		echo "<div class='separador'></div>";
		echo "<div id='datos_profesor' class='cuadro_texto'>";
		echo "<table class='center'>";
		echo "	<tr><td><label>Nombre: </label></td><td><input id='Nombre' name='Nombre' value='".$row['nombre']."'></input></td></tr>";
		echo "	<tr><td><label>Apellidos:</label></td><td><input id='Apellidos' value='".$row['apellidos']."'></input></td></tr> ";
		echo "	<tr><td><label>DNI:</label></td><td><input id='dni' value='".$row['dni']."'></input></td></tr>";
		echo "	<tr><td><label>e-mail:</label></td><td><input id='mail' value='".$row['mail']."'></input></td></tr>";
		echo "	<tr><td><label>Usuario:</label></td><td><input id='usuario' disabled='false' value='".$row['usuario']."'></input></td></tr>";
		echo "</table>";
		echo "<div class='separador'></div>
				<p class='center'><button id='modifica_profesor' type='submit' onClick='modificar_datos_profesor()' >Modificar Profesor</button> 
				</div> ";
		echo "</form>";
	}
}

if(isset($_POST['modifica_profesor'])){
	$nombre=$_POST['nombre'];
	$apellidos=$_POST['apellidos'];
	$dni=$_POST['dni'];
	$mail=$_POST['mail'];
	$usuario=$_POST['usuario'];
	
	if((isset($nombre) || isset($apellidos) || isset($mail) ||
		isset($dni) || isset($usuario))&&(($nombre != "") && ($apellidos != "") && ($mail != "")&& 
			($dni != "")&& ($usuario != "")) ){
		if(modificaDatosProfesor($nombre,$apellidos,$dni,$mail,$usuario)){
			?>
				<script type="text/javascript">
					alert("Datos Actualizados");
					location.href= "Administrador_modificar_profesor1.php";
				</script>
			<?php
		}else{
			?>
				<script type="text/javascript">
					alert("Error al modificar profesor");
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