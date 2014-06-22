<?php
include "bbdd.php";
if(isset($_POST['GuardarAsignatura']))
		{	
			if(($_POST['idProfesor'] != "") && ($_POST['asignatura'] != "") && ($_POST['nombre'] != "") && 
			($_POST['informacion'] != ""))
			{
				$nombre=$_POST['nombre'];
				$idProfesor=$_POST['idProfesor'];
				$asignatura=$_POST['asignatura'];
				$informacion = $_POST['informacion'];
				
				if(registrarAsignatura($asignatura,$nombre,$informacion,$idProfesor))
				{
					?>
						<script type="text/javascript">
							alert("La asignatura ha sido dada de alta en la base de datos.");
							location.href='Profesor_Inicio.php?id=tw_redireccion';
						</script>
					<?php	
				}else
				{
					?>
						<script type="text/javascript">
							alert("Error al dar de alta la asignatura");
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