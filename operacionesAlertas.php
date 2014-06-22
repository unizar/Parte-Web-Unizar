<?php
include 'bbdd.php';
if(isset($_POST['modifica_alerta'])){
	if(isset($_POST['id_alerta'])){
		$id_alerta = $_POST['id_alerta'];
		$id_profesor = $_POST['id_profesor'];
		$datosAlerta = consultarAlerta($id_alerta);
		$actividadesProfesor = consultarActividadesProfesor($id_profesor);
		$actividadActual = consultaActividadAlerta($id_alerta);
		if($row = mysql_fetch_array($datosAlerta)){
			if (mysql_num_rows($actividadesProfesor) > 0){
				echo "<table border='0' class='tabla'> ";
				echo "<tr><td><label>Nombre Alerta</label></td><td><input id='nombre_alerta' value='".$row['nombre']."'></input></td></tr>
					  <tr><td><label>Fecha Baja</label></td><td><input id='fecha_baja' type='date' value='".$row['FechaBaja']."'></input></td></tr>
					  <tr><td><label>Informaci&oacuten</label></td><td><textarea id='info_alerta' rows='3' cols='40'>".$row['Informacion']."</textarea></td></tr>";
				echo "<tr><td><label>Actividades Asociadas</label></td><td><select id='actividades_asociadas'>";
				while($row1 = mysql_fetch_array($actividadesProfesor)){
					if($row1['id_actividad'] == $actividadActual)
						echo "<option value='".$row1['id_actividad']."' selected>".$row1['nombre']."</option>";
					else
						echo "<option value='".$row1['id_actividad']."'>".$row1['nombre']."</option>";
				}
				echo "</select></td></tr>";
				echo "</table>";
				echo "<button id='modificar_datos_alerta' type='submit' class='center' onClick='modificarDatosAlerta()' action=''>Modificar Datos</button>";
			

			}else{
				?>
					<script type="text/javascript">
						alert("No tienes actividades asignadas, no puedes modificar la alerta");

					</script>
				<?php
			}
		}else{
		?>
			<script type="text/javascript">
				alert("Error al consultar la alerta");

			</script>
		<?php
		}
	}else{
	?>
		<script type="text/javascript">
			alert("Debes seleccionar una alerta");

		</script>
	<?php
	}
}
if(isset($_POST['modificar_datos'])){
	$id_alerta=$_POST['id_alerta'];
	$nombre_alerta=$_POST['nombre_alerta'];
	$fecha_baja=$_POST['fecha_baja'];
	$actividad_asociada=$_POST['actividad_asociada'];
	$informacion=$_POST['informacion'];
	if(($id_alerta!="")&&($nombre_alerta!="")&&($fecha_baja!="")&&($actividad_asociada!="")){
		$alertaModificada = modificarAlerta($id_alerta,$nombre_alerta,$fecha_baja,$informacion,$actividad_asociada);
		if($alertaModificada){
			?>
					<script type="text/javascript">
						alert("La alerta se ha modificado correctamente");
						location.href="Profesor_Alertas.php";
					</script>
				<?php
		}else{
			?>
				<script type="text/javascript">
					alert("Error!!!");
					location.href="Profesor_Alertas.php";
				</script>
			<?php
		}
	}else{
		?>
		<script type="text/javascript">
			alert("Debes rellenar todos los campos");
		
		</script>
		<?php
	}
	
}

if(isset($_POST['crear_alerta'])){
	$id_profesor=$_POST['id_profesor'];
	$actividadesProfesor = consultarActividadesProfesor($id_profesor);
	if (mysql_num_rows($actividadesProfesor) > 0){

		echo "<table border='0' class='tabla'> ";
		echo "<tr><td><label>Nombre Alerta</label></td><td><input id='nombre_alerta' ></input></td></tr>
			  <tr><td><label>Fecha Baja</label></td><td><input id='fecha_baja' type='date' ></input></td></tr>
			  <tr><td><label>Informaci&oacuten</label></td><td><textarea id='info_alerta' rows='3' cols='40'></textarea></td></tr>";
		echo "<tr><td><label>Actividades Asociadas</label></td><td><select id='actividades_asociadas'>";
		
		while($row1 = mysql_fetch_array($actividadesProfesor)){
			echo "<option value='".$row1['id_actividad']."'>".$row1['nombre']."</option>";
		}
		echo "</select></td></tr>";
		echo "</table>";
		echo "<button id='crear_alerta_nueva' class='center' type='submit' onClick='crearAlertaNueva()'>Crear</button>";

	}else{
		?>
			<script type="text/javascript">
				alert("No puede crear alertas porque no tiene actividades asociadas");

			</script>
		<?php
	}
}

if(isset($_POST['alta_alerta'])){
	$nombre_alerta=$_POST['nombre_alerta'];
	$fecha_baja=$_POST['fecha_baja'];
	$info_alerta=$_POST['info_alerta'];
	$actividad_asociada=$_POST['actividad_asociada'];
	$id_profesor = $_POST['id_profesor'];
	if(($nombre_alerta != "") && ($fecha_baja != "") &&
		($info_alerta != "") &&($actividad_asociada != "")){
		$alertaCreada = crearAlerta($nombre_alerta,$fecha_baja,$info_alerta,$actividad_asociada,$id_profesor);
		if($alertaCreada == true){
			?>
				<script type="text/javascript">
					alert("Alerta Guardada!!!");
					location.href="Profesor_Alertas.php";
				</script>
			<?php
		}else{
			?>
				<script type="text/javascript">
					alert("Error al guardar alerta!!!");
					location.href="Profesor_Alertas.php";
				</script>
			<?php
		}
	}else{
		?>
			<script type="text/javascript">
				alert("Debes Rellenar todos los campos!!!");
			</script>
		<?php
	}
}

if(isset($_POST['elimina_alerta'])){
	$id_alerta = $_POST['id_alerta'];
	$alertaEliminada = eliminaAlerta($id_alerta);
	if($alertaEliminada){
		?>
				<script type="text/javascript">
					alert("Alerta eliminada!!!");
					location.href="Profesor_Alertas.php";
				</script>
			<?php
	}else{
		?>
				<script type="text/javascript">
					alert("Error al eliminar alerta!!!");

				</script>
			<?php
	}
	
}
?>