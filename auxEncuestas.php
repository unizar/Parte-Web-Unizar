<?php
include "bbdd.php";
define('numPreg', '5');
define('numResp', '5');
if(isset($_POST['mostrar_encuestas'])){
	$titulo = $_POST['titulo'];

	$listaEncuestas=consultaEncuestasAplicacionFiltro($titulo);//consulta a la bbdd de las encuestas según título
	if ($listaEncuestas!=null){
		if($row=mysql_fetch_array($listaEncuestas)){
			echo "<div style='OVERFLOW: auto; WIDTH: 540px'>";
				echo "<table class='tabla'>"; 
				echo "	<tr>";
				echo "		<td class='cabecera_tabla'><b>Opcion</b></td>";
				echo "		<td class='cabecera_tabla'><b>ID ENCUESTA</b></td>";
				echo "		<td class='cabecera_tabla'><b>TÍTULO ENCUESTA</b></td>";
				echo "	</tr>";
				//Variable que pondra siempre el primer elemento seleccionado
				$primerElemento = true;
				while($row){//recorremos la consulta sobre las encuestas según el filtro
					echo '<tr>';
					if($primerElemento)
						echo '<td align="center"><input type="radio" id="id_encuesta" name="id_encuesta" value="'.$row['idEncuesta'].'" checked></td>';
					else
						echo '<td align="center"><input type="radio" id="id_encuesta" name="id_encuesta" value="'.$row['idEncuesta'].'"></td>';
					$primerElemento = false;
					echo '<td align="center">'.$row['idEncuesta'].'</td>';
					echo '<td align="center">'.$row['titulo'].'</td>';
					echo '</tr>';
					$row=mysql_fetch_array($listaEncuestas);
				}	
				echo "</table>";
			echo "</div>";
			echo "<p class='center'>
						<button id='modifica_encuesta' name='modifica_encuesta' type='submit' onClick='mostrarDatosEncuesta()'>Modificar Encuesta</button>
						<button id='elimina_encuesta' name='elimina_encuesta' type='submit' onClick='eliminaEncuesta()'>Eliminar Encuesta</button>
					</p>";
		}else{
			?>
				<script type="text/javascript">
					alert("No hay encuestas");
				</script>
			<?php
		}
	}else{
		?>
			<script type="text/javascript">
				alert("No hay encuestas");
			</script>
		<?php
	}
}

if(isset($_POST['eliminar_encuesta'])){
	if(isset($_POST['id_encuesta'])){
		$id_encuesta = $_POST['id_encuesta'];
		$encuestaEliminada = false;
		$encuestaEliminada = eliminarEncuesta($id_encuesta);//elimina la encuesta seleccionada (y las preguntas asociadas a ella
		//alerta de si la encuesta ha sido eliminada o no
		if($encuestaEliminada){
			?>
				<script type="text/javascript">
					alert("Encuesta eliminada");
					location.href= "Administrador_Modificar_Encuesta.php";
				</script>
			<?php
		}else{
			?>
				<script type="text/javascript">
					alert("La encuesta no se ha podido eliminar");
				</script>
			<?php
		}			
	}else {	
		?>
		<script type="text/javascript">
			alert("Seleccione una encuesta");
		</script>
		<?php
	}
	
}

if(isset($_POST['modifica_encuesta'])){
	if(isset($_POST['id_encuesta'])){
		$id_encuesta = $_POST['id_encuesta'];
		$tituloEncuesta=consultaEncuesta($id_encuesta);//consulta sobre el título de la encuesta
		$preguntas=consultaPreguntas($id_encuesta);//consulta sobre las preguntas asociadas a la encuesta
		if($rowTitulo = mysql_fetch_array($tituloEncuesta)){//si se a encontrado un título
			if ($rowPreg = mysql_fetch_array($preguntas)){//si se han encontrado preguntas
				echo "	<table class='tabla'>";
				echo "		<tr><td><label>Título: </label></td><td><input id='tituloAct' value='".$rowTitulo['titulo']."'></input></td></tr>";
				echo "	</table>";
				echo "	<table class='tabla'>";
				$pregAct=1;//pregunta actual(para nombre del checkbox)
				while($rowPreg){
					echo "	<tr>";
					echo "		<td><label>Pregunta ".$pregAct.":</label></td><td><input id='Pregunta".$pregAct."' name='Pregunta".$pregAct."' value='".$rowPreg['pregunta']."' size='50'></input></td>";
					echo "	</tr>";
					$pregAct++;
					$rowPreg = mysql_fetch_array($preguntas);
				}
				echo "	</table>";
				echo "	<p class='center'>
							<button class='boton' id='Modificar' name='Modificar' type='submit' onClick='modificarEncuesta()'>Modificar</button>
						</p>";
			}
		}
	}
}

if(isset($_POST['modificar'])){
	if(isset($_POST['id_encuesta'])){
		if($titulo = $_POST['titulo']){
			$id_encuesta = $_POST['id_encuesta'];
			
			$preguntas = array();
			$nombresPreg = array();
			$preguntas = $_POST['preguntas'];
			$nombresPreg = $_POST['nombresPreg'];
			$titulo=$_POST['titulo'];//titulo de la encuesta
			//Para comprobar que si existe alguna encuesta con ese título sea la que estamos modificando
			$resulId=consultaIdEncuesta($titulo);
			if($resulId!=null){
				if(!($idTitulo=mysql_fetch_array($resulId)))//si no devuelve ID le asignamos un -1 que nunca va a coincidir
					$idAntigua=-1;
				else
					$idAntigua=$idTitulo['idEncuesta'];
				if(existeEncuesta($titulo) && ($id_encuesta!=$idAntigua))
				{
					?>
						<script type="text/javascript">
							alert("La encuesta con título " + '<?php echo($titulo)?>' + " ya existe");
						</script>
					<?php
				}
				else{
					$todasPreguntas=true; //para saber si todas las preguntas tienen enunciado
					for ($i = 0; $i < numPreg; $i++) {//recorremos las preguntas
						if($preguntas[$i]==""){
							$todasPreguntas=false;
							break;
						}
					}
					if($todasPreguntas){
						if(modificarEncuesta($id_encuesta,$titulo)){
							$resulIds=idsPreguntas($id_encuesta);//IDs de las preguntas asociadas a la encuesta
							while($id = mysql_fetch_array($resulIds)){
								$idsPreg[]=$id['idPregunta'];
							}
							$np=0; // numero de pregunta actual
							while($np<numPreg){ //recorremos las preguntas y las respuestas para añadirlas a la tabla preguntas.
								$pregunta=$preguntas[$np];//enunciado de la pregunta actual
								if(!modificarPregunta($idsPreg[$np],$pregunta))
								{
								
									?>
										<script type="text/javascript">
											alert("La pregunta " + '<?php echo($np)?>' + " no ha podido modificarse en la base de datos");
										</script>
									<?php
								}
								$np++;
							}
							?>
								<script type="text/javascript">
								alert("La encuesta ha sido modificada en la bbdd");
								location.href= "Administrador_Modificar_Encuesta.php";
								</script>
							<?php
						}else
							{
							?>
								<script type="text/javascript">
								alert("Error al modificar la encuesta en la bbdd");
								</script>
							<?php
						
					}
					}else{
						if ($todasPreguntas) //si todas las preguntas tienen enunciado -> hay pregunta sin respuestas
						{
							//si todas las preguntas tienen enunciado -> hay pregunta sin respuestas
							?>
							<script type="text/javascript">
								alert("Debe seleccionar al menos una respuesta para la pregunta " + '<?php echo($i+1)?>');
							</script>
							<?php
						}
						else //sino hay pregunta sin enunciado
						{
							//echo "<p class='comentario'>Debe introducir el enunciado de la pregunta ".($i+1)."</p>";
							?>
							<script type="text/javascript">
								alert("Debe introducir el enunciado de la pregunta " + '<?php echo($i+1)?>');
							</script>
							<?php
						}
					}
				}
			}else
				{
				?>
					<script type="text/javascript">
						alert("El titulo  " + '<?php echo($titulo)?>' + " no es valido");
					</script>
				<?php
			}
		}else
		{
			
			?>
			<script type="text/javascript">
				alert("Es necesario un título para la encuesta");
			</script>
			<?php
		}
	}
}

if(isset($_POST['visualizar_preguntas_encuesta'])){
	if(isset($_POST['id_encuesta'])){
		$id_encuesta = $_POST['id_encuesta'];
		$tituloEncuesta=consultaEncuesta($id_encuesta);//consulta sobre el título de la encuesta
		$preguntas=consultaPreguntas($id_encuesta);//consulta sobre las preguntas asociadas a la encuesta
		if($rowTitulo = mysql_fetch_array($tituloEncuesta)){//si se a encontrado un título
			if ($rowPreg = mysql_fetch_array($preguntas)){//si se han encontrado preguntas
				echo "	<table class='tabla'>";
				echo "	<tr>";
				echo "		<td class='cabecera_tabla'><b>Título: ".$rowTitulo['titulo']."</b></td>";
				echo "	</tr>";
				echo "	</table>";
				echo "<div style='OVERFLOW: auto; WIDTH: 540px'>";
				echo "	<table class='tabla'>";
				echo "	<tr>";
				echo "		<td class='cabecera_tabla'><b>NUMERO</b></td>";
				echo "		<td class='cabecera_tabla'><b>PREGUNTA</b></td>";
				echo "	</tr>";
				
				
				$pregAct=1;//pregunta actual(para nombre del checkbox)
				while($rowPreg){
					echo "	<tr>";
					echo '<td align="center">'.$pregAct.'</td>';
					echo '<td align="center">'.$rowPreg['pregunta'].'</td>';
					echo "	</tr>";
					$pregAct++;
					$rowPreg = mysql_fetch_array($preguntas);
				}
				
				echo "	</table>";
			}
		}
	}
}

if(isset($_POST['visualizar_listado_encuestas'])){
	$titulo = $_POST['titulo'];

	$listaEncuestas=consultaEncuestasAplicacionFiltro($titulo);//consulta a la bbdd de las encuestas según título
	if($row=mysql_fetch_array($listaEncuestas)){
		echo "<div style='OVERFLOW: auto; WIDTH: 540px'>";
			echo "<table class='tabla'>"; 
			echo "	<tr>";
			echo "		<td class='cabecera_tabla'><b>Opcion</b></td>";
			echo "		<td class='cabecera_tabla'><b>ID ENCUESTA</b></td>";
			echo "		<td class='cabecera_tabla'><b>TÍTULO ENCUESTA</b></td>";
			echo "	</tr>";
			//Variable que pondra siempre el primer elemento seleccionado
			$primerElemento = true;
			while($row){//recorremos la consulta sobre las encuestas según el filtro
				echo '<tr>';
				if($primerElemento)
					echo '<td align="center"><input type="radio" id="id_encuesta" name="id_encuesta" value="'.$row['idEncuesta'].'" checked></td>';
				else
					echo '<td align="center"><input type="radio" id="id_encuesta" name="id_encuesta" value="'.$row['idEncuesta'].'"></td>';
				$primerElemento = false;
				echo '<td align="center">'.$row['idEncuesta'].'</td>';
				echo '<td align="center">'.$row['titulo'].'</td>';
				echo '</tr>';
				$row=mysql_fetch_array($listaEncuestas);
			}
			echo "</table>";			
			echo "<p class='center'>
					<button id='visualiza_encuesta' name='visualiza_encuesta' type='submit' onClick='visualizarDatosEncuesta()'>Ver Encuesta</button>
				</p>";
			
		echo "</div>";
		
	}else{
		?>
			<script type="text/javascript">
				alert("No hay encuestas");
			</script>
		<?php
	}
}
?>