<?php
include 'bbdd.php';

if(isset($_POST['alta_profesor'])){
	if(isset($_POST['Nombre']) || isset($_POST['Apellidos']) || isset($_POST['Mail']) ||
		isset($_POST['dni']) || isset($_POST['id_profesor']) || isset($_POST['password'])){
		if(($_POST['Nombre'] != "") && ($_POST['Apellidos'] != "") && ($_POST['Mail'] != "")&& 
			($_POST['dni'] != "")&& ($_POST['id_profesor'] != "")&& ($_POST['password'] != "")){
			 $usuario=$_POST['id_profesor'];
			 $existeUsuario=existeUsuario($usuario);
			 if($existeUsuario != NULL){
				?>
					<script type="text/javascript">
						alert("El usuario ya está siendo utilizado.Elija otro usuario");
						
					</script>
				<?php
			 }else{
				$nombre=$_POST['Nombre'];
				$apellidos=$_POST['Apellidos'];
				$mail=$_POST['Mail'];
				$dni=$_POST['dni'];
				$password=$_POST['password'];
				if(registrarProfesor($nombre,$apellidos,$mail,$dni,$usuario,$password)){
					?>
						<script type="text/javascript">
							alert("El profesor se ha dado de alta correctamente");
							location.href= "Administrador_Alta_Profesor.php";
						</script>
					<?php
				}else{
					?>
						<script type="text/javascript">
							alert("Error al añadir el profesor a la bbdd");
						</script>
					<?php
				}
			 }
		}else{
			?>
				<script type="text/javascript">
					alert("Todos los campos son obligatorios");
				</script>
			<?php
		}
	}
}
?>