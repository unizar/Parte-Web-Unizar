<?php
include "bbdd.php";
if(isset($_POST['MostrarEncuesta']))
	{			
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
			echo "<select id=\"tiposEncuestas\" name=\"tiposEncuestas\" onChange=\"seleccionado()\">\n";
			echo "<option selected value=\"0\"> Seleccione un Item </option>\n";
			while($row = mysql_fetch_array($listaEncuestas))
			{
				echo "<option value=\"".$row['idEncuesta']."\" >".$row['titulo']."</option>\n";
			}
			echo "</select>\n\n";
		}	
	}
if(isset($_POST['EncuestaNoMarcada']))
{
	if(($_POST['nombre'] != "") && ($_POST['fecha'] != "") && ($_POST['hora'] != "") && 
		($_POST['lugar'] != "") && ($_POST['duracion'] != "") &&  ($_POST['enlaces'] != "") &&  ($_POST['idProfesor'] != "") &&  ($_POST['creditos'] != ""))
	{
		$nombre=$_POST['nombre'];
		$fecha=$_POST['fecha'];
		$hora=$_POST['hora'];
		$lugar = $_POST['lugar'];
		$duracion=$_POST['duracion'];
		$enlaces=$_POST['enlaces'];
		$idProfesor = $_POST['idProfesor'];
		$Creditos = $_POST['creditos'];
		$ActividadGuardada = registrarActividad($idProfesor,$nombre,$fecha,$hora,$lugar,$duracion,$enlaces,NULL,$Creditos);
		if($ActividadGuardada)
		{
			?>
				<script type="text/javascript">
					alert("Actividad Guardada Correctamente");
					location.href='Profesor_Inicio.php';
				</script>
			<?php
		}else
		{
			?>
				<script type="text/javascript">
					alert("La actividad no ha podido ser registrada");
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

if(isset($_POST['EncuestaMarcada']))
{
	if(($_POST['nombre'] != "") && ($_POST['fecha'] != "") && ($_POST['hora'] != "") && ($_POST['idEncuesta'] != "") && 
		($_POST['lugar'] != "") && ($_POST['duracion'] != "") &&  ($_POST['enlaces'] != "") &&  ($_POST['idProfesor'] != "") &&  ($_POST['creditos'] != ""))
	{
		if ($_POST['idEncuesta'] != "0")
		{
			$nombre=$_POST['nombre'];
			$fecha=$_POST['fecha'];
			$hora=$_POST['hora'];
			$lugar = $_POST['lugar'];
			$duracion=$_POST['duracion'];
			$enlaces=$_POST['enlaces'];
			$idProfesor = $_POST['idProfesor'];
			$idEncuesta = $_POST['idEncuesta'];
			$Creditos = $_POST['creditos'];
			$ActividadGuardada = registrarActividad($idProfesor,$nombre,$fecha,$hora,$lugar,$duracion,$enlaces,$idEncuesta,$Creditos);
			if($ActividadGuardada)
			{
				?>
					<script type="text/javascript">
						alert("Actividad Guardada Correctamente");
						location.href='Profesor_Inicio.php';
					</script>
				<?php
			}else
			{
				?>
					<script type="text/javascript">
						alert("La actividad no ha podido ser registrada");
					</script>
				<?php
			}
		}
		else
		{
			?>
				<script type="text/javascript">
					alert("Debe seleccionar una encuesta");
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

if(isset($_POST['muestraEncuestadiv']))
{
	if(isset($_POST['idEncuesta'])){
		$idEncuesta = $_POST['idEncuesta'];
		$tituloEncuesta=consultaEncuesta($idEncuesta);//consulta sobre el título de la encuesta
		$preguntas=consultaPreguntas($idEncuesta);//consulta sobre las preguntas asociadas a la encuesta
		if($rowTitulo = mysql_fetch_array($tituloEncuesta)){//si se a encontrado un título
			if ($rowPreg = mysql_fetch_array($preguntas)){//si se han encontrado preguntas
				echo "	<div class='separador3'></div>";
				echo "	<table>";
				echo "		<tr><td><h1>Encuesta Seleccionada: ".$rowTitulo['titulo']." </h1></td>";
				echo "	</table>";
				echo "	<div class='separador'></div>";
				echo "	<table>";
				$pregAct=1;//pregunta actual(para nombre del checkbox)
				while($rowPreg){
					echo "	<tr>";
					echo "		<td><label>&nbsp;&nbsp;&nbsp;&nbsp;".$pregAct."- ".$rowPreg['pregunta']." </label></td>";
					echo "	</tr>";
					$pregAct++;
					$rowPreg = mysql_fetch_array($preguntas);
				}
				echo "	</table>";
			}
		}
	}
	
}
?>