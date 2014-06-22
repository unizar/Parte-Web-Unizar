<?php
include "bbdd.php";
if(isset($_POST['mostrar_usuarios'])){
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$dni = $_POST['dni'];

	$listaProfesores=consultaUsuariosAplicacionFiltro($nombre,$apellidos,$dni);
	if($listaProfesores!=null){
		if($row=mysql_fetch_array($listaProfesores)){
			echo "<div style='OVERFLOW: auto; WIDTH: 540px; HEIGHT: 114px'>";
				echo "<table class='tabla'>"; 
				echo "	<tr>";
				echo "		<td class='cabecera_tabla'><b>Opcion</b></td>";
				echo "		<td class='cabecera_tabla'><b>USUARIO</b></td>";
				echo "		<td class='cabecera_tabla'><b>NOMBRE USUARIO</b></td>";
				echo "		<td class='cabecera_tabla'><b>DNI</b></td>";
				echo "		<td class='cabecera_tabla'><b>E-MAIL</b></td>";
				echo "	</tr>";
				//Variable que pondra siempre el primer elemento seleccionado
				$primerElemento = true;
				while($row){
					echo '<tr>';
					if($primerElemento)
						echo '<td><input type="radio" id="id_usuario" name="id_usuario" value="'.$row['usuario'].'" checked></td>';
					else
						echo '<td><input type="radio" id="id_usuario" name="id_usuario" value="'.$row['usuario'].'"></td>';
					$primerElemento = false;
					echo '<td>'.$row['usuario'].'</td>';
					echo '<td>'.$row['nombre'].' '.$row['apellidos'].'</td>';
					echo '<td>'.$row['dni'].'</td>';
					echo '<td>'.$row['mail'].'</td>';
					echo '</tr>';
					$row=mysql_fetch_array($listaProfesores);
				}
						
				echo "					</table>";
			echo "</div>";
			echo "<p class='center'>
						<button id='modifica_usuario' name='modifica_usuario' type='submit' onClick='mostrarDatosUsuario()'>Modificar Usuario</button>
						<button id='elimina_usuario' name='elimina_usuario' type='submit' onClick='eliminaUsuario()'>Eliminar Usuario</button>
					</p>";
		}else echo "<p class='comentario'>No hay usuarios</p>";
	}else echo "<p class='comentario'>Filtro no válido</p>";
}


if(isset($_POST['eliminar_usuario'])){
	if(isset($_POST['id_usuario'])){
		$id_usuario = $_POST['id_usuario'];
		$usuarioEliminado = false;
		
		$usuarioEliminado = eliminarUsuario($id_usuario);
		if($usuarioEliminado){
			?>
				<script type="text/javascript">
					alert("Usuario eliminado");
				</script>
			<?php
		}else{
			?>
				<script type="text/javascript">
					alert("El usuario no se ha podido eliminar");
				</script>
			<?php
		}
		
			
	}else echo "<p class='comentario'>Seleccione un usuario</p>";
	
}

if(isset($_POST['modifica_usuario'])){
	if(isset($_POST['id_usuario'])){
		$id_usuario = $_POST['id_usuario'];
		$datosUsuario=consultaUsuario($id_usuario);
		if($row = mysql_fetch_array($datosUsuario)){
			echo "	<table class='tabla'>";
			echo "		<tr><td><label>Nombre: </label></td><td><input id='Nombre_usuario' value='".$row['nombre']."'></input></td></tr>";
			echo "		<tr><td><label>Apellidos:</label></td><td><input id='Apellidos_usuario' value='".$row['apellidos']."'></input></td></tr> ";
			echo "		<tr><td><label>DNI:</label></td><td><input id='dni_usuario' value='".$row['dni']."'></input></td></tr>";
			echo "		<tr><td><label>e-mail:</label></td><td><input id='mail' value='".$row['mail']."'></input></td></tr>";
			echo "		<tr><td><label>Usuario:</label></td><td><input id='usuario_nuevo' value='".$row['usuario']."'></input></td></tr>";
			echo "	</table>";
			echo "	<div id='botones' class='center'><button class='boton' id='Modificar' name='Modificar' type='submit' onClick='modificarUsuario()'>Modificar</button></div>";
		}
	}
}
if(isset($_POST['modificar'])){
	if(isset($_POST['id_usuario'])){
		$id_usuario = $_POST['id_usuario'];
		$usuario = $_POST['usuario'];
		$nombre =$_POST['nombre'];
		$apellidos =$_POST['apellidos'];
		$dni =$_POST['dni'];
		$mail =$_POST['mail'];
		if(($usuario != "")&&($nombre != "")&&($apellidos != "")&&($dni != "")&&($mail != "")){
			$AlumnoModificado = modificaDatosAlumno($nombre,$apellidos,$dni,$mail,$usuario,$id_usuario);
			if($AlumnoModificado){
				?>
					<script type="text/javascript">
						alert("El usuario se ha modificado correctamente");
						location.href = "Administrador_Usuario_Consulta.php";
					</script>
				<?php
			}else{
				?>
					<script type="text/javascript">
						alert("El usuario No se ha modificado ");
						location.href = "Administrador_Usuario_Consulta.php";
					</script>
				<?php
			}
			
		}else{
			?>
				<script type="text/javascript">
					alert("Debes rellenar todos los campos para eliminar");
				</script>
			<?php
		}
	}
}

?>