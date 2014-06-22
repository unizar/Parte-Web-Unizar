<?php
include "bbdd.php";

if(isset($_POST['mostrar_alumnos'])){
	if(($_POST['idAsignatura'] != "")){
		$idAsignatura=$_POST['idAsignatura'];
		$listaUsuarios=consultarPosibleUsuarioValidacion($idAsignatura);
		if (mysql_num_rows($listaUsuarios) == 0)
		{
			?>
				<script type="text/javascript">
					alert("No hay usuarios sin validar");
				</script>
			<?php	
		}else
		{
			/*echo "<form id='users' method='post' action=''>";*/
			echo "	<table class='tabla'>";
			echo "	<p>Selecciona un usuario a validar</p>";
			while($row = mysql_fetch_array($listaUsuarios))
			{	
				echo '<tr>';
				echo '<td><input type="checkbox" id="checkbox" name="checkbox" value="'.$row['Usuario'].'" onclick="validar(this)"></td>';
				echo '<td>'.$row['Usuario'].'</td>';
				echo '<td>'.$row['Nombre'].' '.$row['apellidos'].'</td>';
				echo '<td>'.$row['dni'].'</td>';
				echo '</tr>';
			}	
			echo "	</table>";
			
		}
	}
	else
	{
		?>
		<script type="text/javascript">
			alert("Error al mostrar alumnos!!");
		</script>
		<?php
	}
}

	
if(isset($_POST['validacion']))
{
	if(($_POST['idAsignatura'] != "") && ($_POST['alumno'] != ""))
	{
		$idAsignatura = $_POST['idAsignatura'];
		$idUsuario = $_POST['alumno'];
		$ActividadGuardada = registrarUsuarioAsignatura($idAsignatura,$idUsuario);
		if($ActividadGuardada)
		{
			?>
				<script type="text/javascript">
					alert("Usuario Validado Correctamente");
					$(document).ready(function(){
						$("#alumnosAValidar").load("validacionAlumnos.php",{mostrar_alumnos:"si",idAsignatura:<?php echo $idAsignatura;?>});
					})	
				</script>
			<?php
		}else
		{
			?>
				<script type="text/javascript">
					alert("El usuario no ha podido ser validado");
				</script>
			<?php
		}
	
	}
	
	
}


if(isset($_POST['mostrar_alumnos_inscritos'])){
	if(($_POST['idAsignatura'] != "")){
		$idAsignatura=$_POST['idAsignatura'];
		$listaUsuarios=consultarUsuariosInscritos($idAsignatura);
		if (mysql_num_rows($listaUsuarios) == 0)
		{
			?>
				<script type="text/javascript">
					alert("No hay usuarios inscritos en la asignatura");
				</script>
			<?php	
		}else{
			/*echo "<form id='users' method='post' action=''>";*/
			echo "	<table class='tabla'>";
			echo "	<p>Selecciona el usuario que quiera dar de baja</p>";
			while($row = mysql_fetch_array($listaUsuarios))
			{	
				echo '<tr>';
				echo '<td><input type="checkbox" id="checkbox" name="checkbox" value="'.$row['Usuario'].'" onclick="DarDeBaja(this)"></td>';
				echo '<td>'.$row['Usuario'].'</td>';
				echo '<td>'.$row['Nombre'].' '.$row['apellidos'].'</td>';
				echo '<td>'.$row['dni'].'</td>';
				if($row['inscrito']==0){
					echo '<td style="text-align: right; font-style: bold; color: red;">Solicita inscripci&oacuten</td>';
				}elseif ($row['inscrito']==1){
					echo '<td style="text-align: right; font-style: bold; color: green;">Alumno Inscrito</td>';
				}
				echo '</tr>';
			}	
			echo "	</table>";
			
		}
	}else{
		?>
		<script type="text/javascript">
			alert("Error al mostrar alumnos!!");
		</script>
		<?php
	}
}

if(isset($_POST['baja']))
{
	if(($_POST['idAsignatura'] != "") && ($_POST['alumno'] != ""))
	{
		$idAsignatura = $_POST['idAsignatura'];
		$idUsuario = $_POST['alumno'];
		$BajaUsuario = BajaUsuarioAsignatura($idAsignatura,$idUsuario);
		if($BajaUsuario)
		{
			?>
				<script type="text/javascript">
				alert("El alumno se ha dado de baja correctamente");
				
				
				$(document).ready(function(){
						$("#alumnosAAnular").load("validacionAlumnos.php",{mostrar_alumnos_inscritos:"si",idAsignatura:<?php echo $idAsignatura;?>});
				})	
				</script>
			<?php
		}else
		{
			?>
				<script type="text/javascript">
					alert("¡¡Error!! al dar de baja al alumno.");
				</script>
			<?php
		}
	
	}
	
	
}
?>