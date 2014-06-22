<?php
include "bbdd.php";

if(isset($_POST['eliminarActividad'])){
	if(isset($_POST['idActividad'])){
		$idActividad = $_POST['idActividad'];
		$ActividadEliminada = false;
		$ActividadEliminada = eliminarActividad($idActividad);
		if($ActividadEliminada)
		{
			?>
				<script type="text/javascript">
					alert("La actividad ha sido eliminada");
					location.href='Profesor_Modificar_Eliminar_Actividad.php?id=tw_redireccion';
				</script>
			<?php
		}else
		{
			?>
				<script type="text/javascript">
					alert("La Actividad no se ha podido eliminar");
				</script>
			<?php
		}
	}else
	{
		?>
			<script type="text/javascript">
				alert("Seleccione una Actividad");
			</script>
		<?php
	}	
}

if(isset($_POST['MostrarDatos'])){
	if(isset($_POST['idActividad']))
	{
		$idActividad = $_POST['idActividad'];
		$datosActividad=consultaActividad($idActividad);
		if($row = mysql_fetch_array($datosActividad)){
			echo "	<table class='tabla'>";
			echo "		<tr><td><label>Nombre: </label></td><td><input id='Nombre' size='40' type='text' value='".$row['nombre']."'></input></td></tr>";
			echo "		<tr><td><label>Fecha: </label></td><td><input id='Fecha' type='date' value='".$row['fecha']."'></input></td></tr> ";
			echo "		<tr><td><label>Hora: </label></td><td><input id='Hora' type='time' value='".$row['hora']."'></input></td></tr>";
			echo "		<tr><td><label>Lugar: </label></td><td><input id='Lugar' size='40' type='text' value='".$row['Lugar']."'></input></td></tr>";
			echo "		<tr><td><label>Duraci&oacuten: </label></td><td><input id='Duracion' value='".$row['Duracion']."'></input></td></tr>";
			echo "		<tr><td><label>Creditos: </label></td><td><input id='Creditos' value='".$row['Creditos']."'></input></td></tr>";
			echo "		<tr><td><label>Informaci&oacuten: </label></td><td><textarea id='Informacion' maxlength='600'>".$row['Informacion']."</textarea></td></tr>";
			
			if ($row['Encuesta'] != 0)
			{
				echo "<tr>";
				echo "<td><label>Encuesta: </label></td><td><input type='checkbox' id='Encuesta' name='Encuesta' onclick='activarDes(this);' checked></input>";
				
				
				$encuestaSeleccionada = $row['Encuesta'];
				$listaEncuestas=consultarEncuestas();
				if (mysql_num_rows($listaEncuestas) == 0)
				{
					echo "<div id='desplegableEncuesta'></div>"
					?>
						<script type="text/javascript">
							alert("No hay encuestas disponibles");
						</script>
					<?php	
				}else
				{
					echo "<div id='desplegableEncuesta'>";
					echo "<select id='tiposEncuestas' name='tiposEncuestas' onChange='chkSeleccionado()'>";
					echo "<option  value='0'> Seleccione un Item </option>";
					while($row = mysql_fetch_array($listaEncuestas))
					{  	
						if ($encuestaSeleccionada == $row['idEncuesta'])
						{
							echo "<option selected value='".$row['idEncuesta']."' >".$row['titulo']."</option>";
						}
						else
						{
							echo "<option value='".$row['idEncuesta']."' >".$row['titulo']."</option>";
						}
					}
					echo "</select>";
					echo "</div>";
					
				}
				echo "</td>";
				echo "</tr>";
			}
				else
			{	
				echo "<tr>";
				echo "<td><label>Encuesta: </label></td><td><input type='checkbox' id='Encuesta' name='Encuesta' onclick='activarDes(this);'></input>";
				echo "<div id='desplegableEncuesta'></div>";
				echo "</td>";
				echo "</tr>";
			}
			
			echo "	</table>";
			echo "	<div id='botones' class='center'><button class='boton' id='ModificarActividad' name='ModificarActividad' type='submit' onClick='ModificaActividad();'>Modificar</button></div>";
		}	
	}
	else
	{
		?>
			<script type="text/javascript">
				alert("No idActividad");
			</script>
		<?php
	}
}

if(isset($_POST['MostrarEncuesta'])){
		$listaEncuestas=consultarEncuestas();
		if (mysql_num_rows($listaEncuestas) == 0)
		{
			?>
				<script type="text/javascript">
					alert("No hay encuestas disponibles");
				</script>
			<?php	
		}else
		{
			echo "<select id='tiposEncuestas' name='tiposEncuestas' onChange='chkSeleccionado()'>";
			echo "<option selected value='0'> Seleccione un Item </option>";
			while($row = mysql_fetch_array($listaEncuestas))
			{
				echo "<option value='".$row['idEncuesta']."' >".$row['titulo']."</option>";
			}
			echo "</select>";
		}
}
	
if(isset($_POST['ModificarActividad']))
{
	if(($_POST['nombre'] != "") && ($_POST['fecha'] != "") && ($_POST['hora'] != "") && ($_POST['idEncuesta'] != "") && 
		($_POST['lugar'] != "") && ($_POST['duracion'] != "") &&  ($_POST['enlaces'] != "") &&  ($_POST['idProfesor'] != "")&&  ($_POST['creditos'] != ""))
	{
		$nombre=$_POST['nombre'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		$lugar = $_POST['lugar'];
		$duracion=$_POST['duracion'];
		$enlaces=$_POST['enlaces'];
		$idProfesor = $_POST['idProfesor'];
		$idEncuesta = $_POST['idEncuesta'];
		$idActividad = $_POST['idActividad'];
		$creditos = $_POST['creditos'];
		$ActividadGuardada = modificaDatosActividad($idActividad,$idProfesor,$nombre,$fecha,$hora,$lugar,$duracion,$enlaces,$idEncuesta,$creditos);
		if($ActividadGuardada)
		{
			?>
				<script type="text/javascript">
					alert("La Actividad ha sido Modificada Correctamente");
				</script>
			<?php
		}else
		{
			?>
				<script type="text/javascript">
					alert("La actividad no ha podido ser modificada");
				</script>
			<?php
		}
	}else
	{
		?>
			<script type="text/javascript">
				alert("Todos los campos son obligatorios");
			</script>
		<?php
	}
}

?>