<?php 
session_start();
//define('u921649958_uniz', dirname(__FILE__).DIRECTORY_SEPARATOR);
include "bbdd.php";
 
if(trim($_POST["usuario"]) != "" && trim($_POST["password"]) != "")
{
    // Funcion para eliminar algun caracter en especifico
	$usuario=$_POST["usuario"];
    $usuario = strtolower(quitar($usuario));
   
    // o puedes convertir los a su entidad HTML aplicable con htmlentities
    $usuario = strtolower(htmlentities($_POST["usuario"], ENT_QUOTES));   
    $password = $_POST["password"];
    
 
    $result = validaUsuario($usuario);
     if($row = mysql_fetch_array($result)){
        if($row["password"] == $password){
            $_SESSION["k_username"] = $row['usuario'];
			//Crear una variable para indicar que se ha autenticado
			$_SESSION['autenticado']= 'SI';
			//Crear una variable para guardar el ID del usuario para tenerlo siempre disponible
			$_SESSION['uid']= $usuario;
			
		   //echo 'Has sido logueado correctamente '.$_SESSION['k_username'].' <p>';
		   if($row["tipo_usuario"]=="Profesor")
			header("Location: Profesor_Inicio.php");
		   elseif ($row["tipo_usuario"]=="Administrador")
			header("Location: Administrador_Inicio.php");
           else{
			?>
				<script type="text/javascript">
					alert("ERROR: Debe ser profesor o administrador");
					location.href= "index.html";
				</script>
			<?php
			}
 
        }else{
			?>
				<script type="text/javascript">
					alert("Password incorrecto");
					location.href= "index.html";
				</script>
			<?php
        }
    }else{
		?>
				<script type="text/javascript">
					alert("Usuario no existente en la base de datos");
					location.href= "index.html";
				</script>
			<?php
    }
    mysql_free_result($result);
}else{
	?>
		<script type="text/javascript">
			alert("Debe especificar un usuario y password");
			location.href= "index.html";
		</script>
	<?php
}

?>