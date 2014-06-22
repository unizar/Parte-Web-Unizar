<?php
include "bbdd.php";
if(isset($_POST['altaEncuesta'])){
	define('numPreg', '5');
	define('numResp', '5');
	if(isset($_POST['titulo'])){
		if($_POST['titulo']!=""){
			$titulo=$_POST['titulo'];//titulo de la encuesta
			$preguntas = array();
			$preguntas = $_POST['preguntas'];
			$nombresPreg = array();
			$nombresPreg = $_POST['nombresPreg'];
			$existeEncuesta=existeEncuesta($titulo);
			if($existeEncuesta != NULL)
			{
				?>
						<script type="text/javascript">
							alert("La encuesta con título " + '<?php echo($titulo)?>' + " ya existe");
						</script>
				<?php
			
			}else{
				$todasPreguntas=true; //para saber si todas las preguntas tienen enunciado
				for ($i = 0; $i < numPreg; $i++) {//recorremos las preguntas
					if($preguntas[$i]==""){
						$todasPreguntas=false;
						break;
					}
				}
				$np=1; // numero de pregunta actual
				if($todasPreguntas){
					if(registrarEncuesta($titulo)){
						$np=0; // numero de pregunta actual
						while($np<numPreg){ //recorremos las preguntas y las respuestas para añadirlas a la tabla preguntas.
							$pregunta=$preguntas[$np];//enunciado de la pregunta actual
							if(!registrarPregunta($pregunta,$titulo)){
								?>
										<script type="text/javascript">
											alert("La pregunta " + '<?php echo($np+1)?>' + " no es válida");
										</script>
								<?php
								//echo "<p class='comentario'>La pregunta ".($np+1)." no es válida</p>";
								deshacerRegistroEncuesta($titulo);
								break;
							}
							$np++;
						}
						if($np==numPreg)
						{
							?>
								<script type="text/javascript">
									alert("La encuesta ha sido añadida a la bbdd");
									location.href= "Administrador_Generar_encuesta.php";
								</script>
							<?php
						}	
					}else
					{
						?>
							<script type="text/javascript">
								alert("Error al añadir la encuesta en la bbdd");
							</script>
						<?php
					}
				}else{
					?>
						<script type="text/javascript">
							alert("Debe introducier el enunciado de la pregunta " + '<?php echo($i+1)?>');
						</script>
					<?php
					
				}
			}
		}else
		{
			?>
				<script type="text/javascript">
					alert("Es necesario un título para la encuesta ");
				</script>
			<?php
		}
	}
}
?>