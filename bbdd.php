<?php
// datos para la coneccion a mysql 
define('DB_SERVER','localhost'); 
define('DB_NAME','bbdd_unizar'); 
define('DB_USER','usuario_web'); 
define('DB_PASS','tfgfdi1314'); 

$link = mysql_connect(DB_SERVER,DB_USER,DB_PASS); 
mysql_select_db(DB_NAME,$link) OR DIE ("Error: No es posible establecer la conexión");
mysql_query("SET NAMES 'utf8';");

/*********************************************************************************************************************/
/**********************************************MARIA*****************************************************************/
/*********************************************************************************************************************/
/*
*NOMBRE: writeInLog
*DESCRIPCIÓN: Escribe en un fichero log+fecha de hoy lo que se pasa por parámetro
*RETURN: 
*/
function writeInLog($mensaje){
	$fp = fopen("Logs/log".date("Ymd").".txt", 'a');
	fwrite($fp, date("Ymd H:m ").$mensaje."\n");
	
	fclose($fp);
};
function consultaMailProfesor($profesor){
	$sql=mysql_query("SELECT password, mail FROM usuarios WHERE usuario='$profesor'");
	return $sql;
	
}
/*
*NOMBRE: quitar
*DESCRIPCIÓN: Elimina los caracteres no permitidos del mensaje que recibe
*RETURN: Devuelve el mensaje sin los caracteres no permitidos	
*/
function quitar($mensaje)
{
    $nopermitidos = array("'",'\\','<','>',"\"");
    $mensaje = str_replace($nopermitidos, "", $mensaje);
    return $mensaje;
};

/*
*NOMBRE: existeUsuario
*DESCRIPCIÓN: Comprueba si existe el usuario que se introduce por parámetro
*RETURN: Devuelve true si ya existe en la bbdd y falso si no existe
*/
function existeUsuario($usuario) 
{	
	if($existe=mysql_query('SELECT password, usuario, tipo_usuario FROM usuarios WHERE usuario=\''.$usuario.'\'')){
		if(mysql_num_rows($existe)==0) 
			return false;
		else 
			return true;
	}else
		return false;
};

/*
*NOMBRE: validaUsuario
*DESCRIPCIÓN: Comprueba si existe el usuario que se introduce por parámetro y lo devuelve
*RETURN: Devuelve el PASSWORD USUARIO Y TIPO DE USUARIO que se introduce por parámetro si existe en la bbdd
*/
function validaUsuario($usuario){
	$usuario=mysql_query('SELECT password, usuario, tipo_usuario FROM usuarios WHERE usuario=\''.$usuario.'\'');
	return $usuario;
}

/*
*NOMBRE: registrarProfesor
*DESCRIPCIÓN: Da de alta un profesor con los datos que se introducen por parámetro
*RETURN: devuelve true si se ha insertado correctamente y falso si no
*/
function registrarProfesor($nombre,$apellidos,$mail,$dni,$usuario,$password){
	$sql="INSERT INTO usuarios(usuario,nombre,apellidos,dni,mail,password,tipo_usuario) VALUES ('".$usuario."','".$nombre."','".$apellidos."','".$dni."','".$mail."','".$password."','Profesor')";
	if(mysql_query($sql))
		return true;
	else return false;
}

/*
*NOMBRE: consultaProfesores
*DESCRIPCIÓN: Consulta todos los profesores que hay en la bbdd
*RETURN: Devuelve un array con todos los profesores
*/
function consultaProfesores(){
	$sql="SELECT usuario, nombre, apellidos FROM usuarios WHERE tipo_usuario='Profesor'";
	$resultado=mysql_query($sql);
	return $resultado;
}

/*
*NOMBRE: eliminarProfesores
*DESCRIPCIÓN: Elimina el profesor con el id q se indica, todas sus asignaturas, actividades  alertas
*RETURN: Devuelve true si se ha eliminado
*/
function eliminarProfesor($id_profesor){
	$sql="DELETE FROM alertas 
		WHERE id_profesor='".$id_profesor."'";
	if(mysql_query($sql)){
		$sql="DELETE FROM `usuariosactividades` WHERE `id_actividad` IN (SELECT `id_actividad` FROM `actividades` WHERE `id_Profesor`='$id_profesor')";
		if(mysql_query($sql)){
			$sql="DELETE FROM actividades 
				WHERE id_profesor='".$id_profesor."'";
			if(mysql_query($sql)){
				$sql="DELETE FROM `usuarioasignaturas` WHERE `idAsignatura` IN (SELECT `idAsignatura` FROM `asignaturas` WHERE `idProfesor`='$id_profesor')";
				if(mysql_query($sql)){
					$sql="DELETE FROM asignaturas 
					WHERE idProfesor='".$id_profesor."'";
					if(mysql_query($sql)){
						$sql="DELETE FROM usuarios 
						WHERE Usuario='".$id_profesor."'";
						if(mysql_query($sql))
							return true;
						else return false;
					}else
						return false;
				}else
					return false;
			}else
				return false;
		}else
			return false;
	}else
		return false;
}

/*
*NOMBRE: eliminarUsuario
*DESCRIPCIÓN: Elimina el usuario con el id q se indica
*RETURN: Devuelve true si se ha eliminado
*/
function eliminarUsuario($id_usuario){
	$sql="DELETE FROM usuarios WHERE tipo_usuario='Alumno' AND  usuario='".$id_usuario."'";
	if(mysql_query($sql)){
		mysql_query("DELETE FROM `ultimaconexionusuario` WHERE `id_usuario`='$id_usuario'");
		mysql_query("DELETE FROM `usuarioasignaturas` WHERE `Usuario` = '$id_usuario'");
		mysql_query("DELETE FROM `usuariosactividades` WHERE `Usuario`='$id_usuario'");
		return true;
	}else
		return false;
}

/*
*NOMBRE: consultaUsuario
*DESCRIPCIÓN: Consulta el profesor que se introduce por parámetro
*RETURN: Devuelve USUARIO,NOMBRE,APELLIDOS,DNI Y MAIL del profesor que se está consultando
*/
function consultaUsuario($idUsuario){
	$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE usuario='".$idUsuario."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: modificaDatosProfesor
*DESCRIPCIÓN: Modifica los datos del profesro con usuario= idprofesor
*RETURN:devuelve true si se han modificado correctamente.
*/
function modificaDatosProfesor($nombre,$apellidos,$dni,$mail,$usuario){
	$sql="UPDATE usuarios SET nombre='".$nombre."', apellidos='".$apellidos."', dni='".$dni."',
				mail='".$mail."' WHERE usuario='".$usuario."' AND tipo_usuario='Profesor' ";
	if(mysql_query($sql)) return true;
	else return false;
}

/*
*NOMBRE: modificaDatosAlumnno
*DESCRIPCIÓN: Modifica los datos del Alumno con usuario= idAlumno
*RETURN:devuelve true si se han modificado correctamente.
*/
function modificaDatosAlumno($nombre,$apellidos,$dni,$mail,$usuario_nuevo,$id_Alumno){
	$sql="UPDATE usuarios 
		SET nombre='".$nombre."', apellidos='".$apellidos."', dni='".$dni."',mail='".$mail."', usuario='".$usuario_nuevo."' 
		WHERE usuario='".$id_Alumno."' AND tipo_usuario='Alumno' ";
	if(mysql_query($sql)) return true;
	else return false;
}

/*
*NOMBRE: consultaUsuariosAplicacion
*DESCRIPCIÓN: Devuelve todos los usuarios de la aplicación (tipo=Alumno)
*RETURN: Todos los alumnos
*/
function consultaUsuariosAplicacion(){
	$sql="SELECT usuario,nombre,apellidos,dni,mail 
			FROM usuarios 
			WHERE tipo_usuario='Alumno' 
			ORDER BY nombre";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: consultaUsuariosAplicacion
*DESCRIPCIÓN: Devuelve todos los usuarios de la aplicación (tipo=Alumno) que coincidan con los parámetros del filtro
*RETURN: Todos los alumnos que coindicen con el filtro
*/
function consultaUsuariosAplicacionFiltro($nombre,$apellidos,$dni){
	if($nombre!="" && $apellidos!="" && $dni!="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno'AND Nombre LIKE '%".$nombre."%'AND
				apellidos LIKE '%".$apellidos."%' AND dni LIKE '%".$dni."%' ORDER BY nombre";
	elseif ($nombre!="" && $apellidos!="" && $dni=="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno'AND Nombre LIKE '%".$nombre."%'AND
				apellidos LIKE '%".$apellidos."%' ORDER BY nombre";
	elseif ($nombre!="" && $apellidos=="" && $dni!="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno'AND Nombre LIKE '%".$nombre."%'AND
				dni LIKE '%".$dni."%' ORDER BY nombre";
	elseif ($nombre=="" && $apellidos!="" && $dni!="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno' AND apellidos LIKE '%".$apellidos."%'AND
				dni LIKE '%".$dni."%' ORDER BY nombre";
	elseif ($nombre=="" && $apellidos=="" && $dni!="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno' AND dni LIKE '%".$dni."%' ORDER BY nombre";
	elseif ($nombre=="" && $apellidos!="" && $dni=="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno' AND apellidos LIKE '%".$apellidos."%' ORDER BY nombre";
	elseif ($nombre!="" && $apellidos=="" && $dni=="")
		$sql="SELECT usuario,nombre,apellidos,dni,mail FROM usuarios WHERE tipo_usuario='Alumno' AND Nombre LIKE '%".$nombre."%' ORDER BY nombre";
	else
		$sql="SELECT usuario,nombre,apellidos,dni,mail 
				FROM usuarios 
				WHERE tipo_usuario='Alumno' 
				ORDER BY nombre";
	
	if($resultado = mysql_query($sql))
		return $resultado;
	else
		return null;
}

/*
*NOMBRE: consultaAlertasProfesor
*DESCRIPCIÓN: Consulta todas las alertas asociadas al profesor que se pasa por parámetro
*RETURN: Devuelve todas las alertas asociadas
*/
function consultaAlertasProfesor($profesor){
	$sql="SELECT a.id_alerta, a.nombre as nombre_alerta,ac.nombre as nombre_actividad,a.FechaBaja 
		FROM alertas a, actividades ac, usuarios u 
		WHERE u.tipo_usuario='Profesor' 	AND
		u.usuario = ac.id_Profesor AND ac.id_Profesor='".$profesor."' AND a.id_actividad=ac.id_actividad
		GROUP BY a.id_alerta";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: consultarAlerta
*DESCRIPCIÓN: Consulta los datos de la alerta que se introduce por parámetro
*RETURN: Devuelve los datos de la alerta
*/
function consultarAlerta($id_alerta){
	$sql="SELECT nombre, FechaBaja, Informacion, id_actividad 
		  FROM alertas 
		  WHERE id_alerta='".$id_alerta."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: consultarActividadesProfesor
*DESCRIPCIÓN: Consulta nombre de activididad y el id de las actividades asociadas al profesor
*RETURN: Devuelve todas las actividades asociadas al profesor
*/
function consultarActividadesProfesor($id_profesor){
	$sql="SELECT ac.nombre, ac.id_actividad
		  FROM actividades ac, usuarios u 
		  WHERE ac.id_profesor = u.usuario AND u.tipo_usuario = 'Profesor' AND ac.id_profesor = '".$id_profesor."'
		  GROUP BY ac.id_actividad";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: modificarAlerta
*DESCRIPCIÓN: Modifica el registo de la tabla alertas indicado por $id_alerta
*RETURN: Devuelve true si la consulta se ha hecho correctamente y falso si no.
*/
function modificarAlerta($id_alerta,$nombre_alerta,$fecha_baja,$informacion,$actividad_asociada){
	$fecha=getdate();
	$fecha_alta= $fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
	$sql="UPDATE alertas 
		SET nombre='".$nombre_alerta."', FechaAlta='".$fecha_alta."', FechaBaja='".$fecha_baja."',Informacion='".$informacion."',id_actividad='".$actividad_asociada."' 
		WHERE id_alerta='".$id_alerta."'";
	if(mysql_query($sql)) return true;
	else return false;
}

/*
*NOMBRE: eliminaAlerta
*DESCRIPCIÓN: Borra el registro de la tabla alertas indiciado por $id_alerta
*RETURN: Devuelve true si la consulta se ha hecho correctamente y falso si no.
*/
function eliminaAlerta($id_alerta){
	$sql="DELETE FROM alertas WHERE id_alerta=".$id_alerta."";
	if(mysql_query($sql)) return true;
	else return false;
}

/*
*NOMBRE: crearAlerta
*DESCRIPCIÓN: Crea una alerta con los datos que se le pasan por parámetro
*RETURN: Devuelve true si la consulta se ha hecho correctamente y falso si no.
*/
function crearAlerta($nombre_alerta,$fecha_baja,$info_alerta,$actividad_asociada,$id_profesor){
    $fecha=getdate();
	$fecha_alta= $fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
	$sql="INSERT INTO alertas(id_actividad,id_profesor,nombre,FechaAlta,FechaBaja,Informacion) 
		 VALUES ('".$actividad_asociada."','".$id_profesor."','".$nombre_alerta."','".$fecha_alta."','".$fecha_baja."','".$info_alerta."')";
	if(mysql_query($sql))
		return true;
	else return false;
}

/*
*NOMBRE: consultaActividadAlerta
*DESCRIPCIÓN: Consula el identificador de la actividad asociada a la alerta que se le ha pasado por parámetro
*RETURN: Identificador de la actividad asociada
*/
function consultaActividadAlerta($id_alerta){
	$sql="SELECT id_actividad
		  FROM alertas 
		  WHERE id_alerta = '".$id_alerta."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}


function comprobarUsuario($usuario_nuevo){
	$sql="SELECT Usuario
		  FROM usuarios 
		  WHERE Usuario = '".$usuario_nuevo."' AND tipo_usuario='profesor'";
	$resultado = mysql_query($sql);	
	if (mysql_num_rows ($resultado) > 0)
		return true;
	else return false;
}

/*
*NOMBRE: modificaDatosActividad
*DESCRIPCIÓN: Modifica una Actividad con los nuevos datos tniendo en cuenta las encuestas
*RETURN:Devuelve true si se realizan las sentecias sql y false si alguna falla
*/
function modificaDatosActividad($id_Actividad,$idProfesor,$nombre,$fecha,$hora,$lugar,$duracion,$enlaces,$encuesta,$creditos){
	$Encuesta=mysql_query("SELECT Encuesta from actividades where id_actividad='$id_Actividad'");
	$row=mysql_fetch_array($Encuesta);
	if(($row['0'] == 0) && ($encuesta != '0')){
	//Insertamos la relación en la tabla actividad_encuesta
		$sql="UPDATE actividades 
			  SET id_Profesor='".$idProfesor."', Nombre='".$nombre."', Fecha='".$fecha."',
				Hora='".$hora."', Lugar='".$lugar."', Duracion='".$duracion."', Informacion='".$enlaces."', 
				Encuesta='".$encuesta."', Creditos='".$creditos."' WHERE id_Actividad=".$id_Actividad."";
		$sql1="INSERT INTO actividad_encuesta(idEncuesta,id_actividad,idPregunta) SELECT '$encuesta','$id_Actividad',idPregunta FROM preguntas_encuesta WHERE idEncuesta=".$encuesta."";
	
		if(mysql_query($sql) && mysql_query($sql1)) return true;
		else return false;
		
	}else if (($row['0'] != 0) && ($encuesta == '0')){
	//Si el id de la encuesta es 0 directamente hacemos DELETE de actividad encuesta de todos los registros que tengan esta actividad
	// De esta forma si ha cambiado de 1 a 0 nos aseguramos de que se borre,y si anteriormente ya era 0 estos deletes no afectaran.
		$sql="UPDATE actividades 
			  SET id_Profesor='".$idProfesor."', Nombre='".$nombre."', Fecha='".$fecha."',
				Hora='".$hora."', Lugar='".$lugar."', Duracion='".$duracion."', Informacion='".$enlaces."', 
				Encuesta='".$encuesta."', Creditos='".$creditos."' WHERE id_Actividad=".$id_Actividad."";
		$sql1="DELETE FROM actividad_encuesta WHERE id_actividad = '$id_Actividad'";
		
		$sql2="UPDATE usuariosactividades 
			  SET encuestaRealizada='0'
			  WHERE id_actividad='$id_Actividad'";
		
		if(mysql_query($sql) && mysql_query($sql1) && mysql_query($sql2)) return true;
		else return false;
		
	}else if (($row['0'] != 0) && ($encuesta != '0') && ($row['0']!=$encuesta)){
		//Si antes de la modificacion tenia una encuesta asignada y ahora tiene otra diferente entonces hay que
		// modificar la informacion en actividad, borrar lo que habia en la tabla actividad_encuesta y volver a 
		//asignar la tabla con valores a 0
		$sql="UPDATE actividades 
			  SET id_Profesor='".$idProfesor."', Nombre='".$nombre."', Fecha='".$fecha."',
				Hora='".$hora."', Lugar='".$lugar."', Duracion='".$duracion."', Informacion='".$enlaces."', 
				Encuesta='".$encuesta."', Creditos='".$creditos."' WHERE id_Actividad=".$id_Actividad."";
		$sql1="DELETE FROM actividad_encuesta WHERE id_actividad = '$id_Actividad'";
		$sql2="INSERT INTO actividad_encuesta(idEncuesta,id_actividad,idPregunta) SELECT '$encuesta','$id_Actividad',idPregunta FROM preguntas_encuesta WHERE idEncuesta=".$encuesta."";
		$sql3="UPDATE usuariosactividades 
			  SET encuestaRealizada='0'
			  WHERE id_actividad='$id_Actividad'";
		if(mysql_query($sql) && mysql_query($sql1) && mysql_query($sql2) && mysql_query($sql3)) return true;
		else return false;
		
	}
	else{
		//Si en encuestas no ha habido ningun cmbio lo dejamos como está
		$sql="UPDATE actividades 
			  SET id_Profesor='".$idProfesor."', Nombre='".$nombre."', Fecha='".$fecha."',
				Hora='".$hora."', Lugar='".$lugar."', Duracion='".$duracion."', Informacion='".$enlaces."', 
				Creditos='".$creditos."' WHERE id_Actividad=".$id_Actividad."";
		if(mysql_query($sql)) return true;
		else return false;
	}
	
}
/*********************************************************************************************************************/
/**********************************************LORENA*****************************************************************/
/*********************************************************************************************************************/
function consultaActividadesProfesorEncuesta($idProfesor){
	$sql="SELECT id_Actividad, Nombre FROM actividades WHERE id_Profesor='".$idProfesor."' AND Encuesta != 0";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function consultaActividadesEncuesta(){
	$sql="SELECT id_Actividad, Nombre FROM actividades WHERE Encuesta != 0";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}
/*
*NOMBRE: registrarAsignatura
*DESCRIPCIÓN: Da de alta una asignatura con los datos introducidos
*RETURN: Devuelve true or false dependiendo de si se ha registrado correctamente o no
*/
function registrarAsignatura($asignatura,$nombre,$informacion,$idProfesor){
	$sql="INSERT INTO asignaturas(Asignatura,Nombre,Informacion,idProfesor) VALUES ('".$asignatura."','".$nombre."','".$informacion."','".$idProfesor."')";
	if(mysql_query($sql))
		return true;
	else return false;
}

/*
*NOMBRE: consultaAsignaturas
*DESCRIPCIÓN: Consulta todas las asignaturas de la bbdd
*RETURN: Devuelve una tabla con las asignaturas existentes
*/
function consultaAsignaturas(){
	$sql="SELECT idAsignatura, Asignatura, Nombre, Informacion FROM asignaturas";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;

}

function eliminarAsignatura($id_asignatura){
	$sql="DELETE FROM `usuarioasignaturas` WHERE `idAsignatura` = '$id_asignatura'";
	if(mysql_query($sql)){
		$sql="DELETE FROM asignaturas WHERE idAsignatura=".$id_asignatura."";
		if(mysql_query($sql))
			return true;
		else
			return false;
	}else
		return false;
}

function eliminarUsuariosAsignatura($id_asignatura){
	$sql="DELETE FROM usuarioasignaturas WHERE idAsignatura=".$id_asignatura."";
	if(mysql_query($sql))
		return true;
	else
		return false;
}

function modificaDatosAsignatura($id_asignatura,$asignatura,$nombre,$informacion){
	$sql="UPDATE asignaturas SET Asignatura='".$asignatura."', Nombre='".$nombre."',
				Informacion='".$informacion."' WHERE idAsignatura=".$id_asignatura."";
	if(mysql_query($sql)) return true;
	else return false;
}

function consultaAsignatura($id_asignatura){
	$sql="SELECT Asignatura, Nombre,Informacion FROM asignaturas WHERE idAsignatura=".$id_asignatura."";
	$resultado=mysql_query($sql);
	
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function consultarEncuestas()
{
	$sql="SELECT idEncuesta, titulo FROM encuestas";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}


function registrarActividad($idProfesor,$nombre,$fecha,$hora,$lugar,$duracion,$enlaces,$encuesta,$creditos)
{
	$sql="INSERT INTO actividades(id_Profesor,Nombre,Fecha,Hora,Lugar,Duracion,Informacion,Encuesta,Creditos) VALUES ('".$idProfesor."','".$nombre."','".$fecha."','".$hora."','".$lugar."','".$duracion."','".$enlaces."','".$encuesta."','".$creditos."')";
	if(mysql_query($sql)){
		$existe=mysql_query("SELECT id_Actividad FROM actividades WHERE Nombre='".$nombre."'");
		$row=mysql_fetch_array($existe);
		$id_Actividad = $row[0];
		mysql_query("INSERT INTO actividad_encuesta(idEncuesta,id_actividad,idPregunta) SELECT ".$encuesta.",".$id_Actividad.",idPregunta FROM preguntas_encuesta WHERE idEncuesta=".$encuesta."");
		return true;
	}
	else return false;
}
function consultaActividades(){
	$sql="SELECT id_Actividad, Nombre FROM actividades";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function eliminarActividad($id_Actividad){
	$sql="DELETE FROM `usuariosactividades` WHERE `id_actividad` = '$id_Actividad'";
	if(mysql_query($sql)){
		$sql="DELETE FROM `actividad_encuesta` WHERE `id_actividad` = '$id_Actividad'";
		if(mysql_query($sql))
		{
			$sql="DELETE FROM actividades WHERE id_Actividad=".$id_Actividad."";
			if(mysql_query($sql))
				return true;
			else
				return false;
		}
		else
			return false;
	}else
		return false;
}
function consultaActividad($id_Actividad){
	$sql="SELECT * FROM actividades WHERE id_Actividad=".$id_Actividad."";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function consultaActividadesProfesor($idProfesor){
	$sql="SELECT id_Actividad, Nombre FROM actividades WHERE id_Profesor='".$idProfesor."'";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}



function consultarAsignaturasProfesor($idProfesor){
	$sql="SELECT idAsignatura,Nombre FROM asignaturas WHERE idProfesor='".$idProfesor."'";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function consultarPosibleUsuarioValidacion($idAsignatura){
	/*$sql="SELECT Usuario,Nombre, apellidos,dni FROM usuarios WHERE tipo_usuario='Alumno' and 
	Usuario not in (Select usuario from usuarioasignaturas WHERE idAsignatura=".$idAsignatura.")";*/
	$sql="SELECT usuarios.Usuario,Nombre, apellidos,dni FROM usuarios,usuarioasignaturas WHERE usuarios.Usuario = usuarioasignaturas.Usuario and usuarioasignaturas.idAsignatura='$idAsignatura' and inscrito=0";
	$resultado=mysql_query($sql);
		if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}

function registrarUsuarioAsignatura($idAsignatura,$idUsuario)
{
	/*$sql="INSERT INTO usuarioasignaturas(Usuario,idAsignatura) VALUES ('".$idUsuario."','".$idAsignatura."')";*/
	$sql = "UPDATE usuarioasignaturas
			SET inscrito=1
			WHERE Usuario='$idUsuario' and idAsignatura='$idAsignatura'";
	if(mysql_query($sql))
		return true;
	else return false;
}

/*********************************************************************************************************************/
/**********************************************ADRIÁN*****************************************************************/
/*********************************************************************************************************************/
/*
*NOMBRE: existeEncuesta
*DESCRIPCIÓN: Comprueba si ya existe la encuesta con el título pasado como parámetro
*RETURN: Devuelve true or false dependiendo de si existe o no
*/
function existeEncuesta($titulo) 
{	
	if($existe=mysql_query('SELECT idEncuesta FROM encuestas WHERE titulo=\''.$titulo.'\''))
		if(mysql_num_rows($existe)==0) 
			return false;
		else 
			return true;
	return true;
};

/*
*NOMBRE: registrarEncuesta
*DESCRIPCIÓN: Añade una nueva encuesta con los datos que se introducen por parámetro
*RETURN: devuelve true si se ha añadido correctamente, si no devuelve falso
*/
function registrarEncuesta($titulo){
	$sql="INSERT INTO encuestas(titulo) VALUES ('$titulo')";
	if(mysql_query($sql))
		return true;
	else return false;
}
/*
*NOMBRE: registrarPregunta
*DESCRIPCIÓN: Añade una nueva pregunta asignandola a la encuesta  con los datos que se introducen por parámetro
*RETURN: devuelve true si se ha añadido correctamente, si no devuelve falso
*/
function registrarPregunta($pregunta,$titulo){
	$existe=mysql_query('SELECT idEncuesta FROM encuestas WHERE titulo=\''.$titulo.'\'');
	$row=mysql_fetch_array($existe);
	$idEncuesta = $row[0];
	$sql="INSERT INTO preguntas_encuesta(idEncuesta,pregunta) VALUES ('".$idEncuesta."','".$pregunta."')";
	if(mysql_query($sql))
		return true;
	else return false;
}
/*
*NOMBRE: consultaEncuestasAplicacion
*DESCRIPCIÓN: Devuelve las encuestas de la aplicación que coincidan con el título pasado por parámetro
*RETURN: Encuestas que coindicen con el filtro
*/
function consultaEncuestasAplicacionFiltro($titulo){
	if($titulo!="")
		$sql="SELECT idEncuesta,titulo FROM encuestas WHERE titulo LIKE '%".$titulo."%'";
	else
		$sql="SELECT idEncuesta,titulo FROM encuestas";
	if($resultado = mysql_query($sql))
		return $resultado;
	else
		return null;
}

/*
*NOMBRE: consultaEncuestasAplicacion
*DESCRIPCIÓN: Devuelve todas las encuestas guardadas en la aplicación
*RETURN: Todas las encuestas
*/
function consultaEncuestasAplicacion(){
	$sql="SELECT usuario,nombre,apellidos,dni,mail 
			FROM usuarios 
			WHERE tipo_usuario='Alumno' 
			ORDER BY nombre";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: eliminarEncuesta
*DESCRIPCIÓN: Elimina la encuesta con el id q se indica
*RETURN: Devuelve true si se ha eliminado
*/
function eliminarEncuesta($id_encuesta){
	$sqlPreg="DELETE FROM preguntas_encuesta WHERE idEncuesta='".$id_encuesta."'";
	if(mysql_query($sqlPreg)){

		$sqlEnc="DELETE FROM encuestas WHERE idEncuesta='".$id_encuesta."'";
		if(mysql_query($sqlEnc)){
			mysql_query("UPDATE `usuariosactividades` SET `encuestaRealizada`='0' WHERE `id_actividad` IN (SELECT `id_actividad` FROM `actividades` WHERE `Encuesta`='$id_encuesta')");
			mysql_query("UPDATE `actividades` SET `Encuesta`='0' WHERE `Encuesta`= '$id_encuesta'");
			mysql_query("DELETE FROM  `preguntas_encuesta` WHERE  `idEncuesta` =  '$id_encuesta'");
			mysql_query("DELETE FROM  `actividad_encuesta` WHERE  `idEncuesta` =  '$id_encuesta'");
			return true;
		}
		else
			return false;
	}else{
		return false;
	}
}

/*
*NOMBRE: deshacerRegistroEncuesta
*DESCRIPCIÓN: Elimina la encuesta con el id q se indica
*RETURN: Devuelve true si se ha eliminado
*/
function deshacerRegistroEncuesta($titulo){
	$sqlIDenc="SELECT idEncuesta FROM encuestas WHERE titulo='$titulo'";
	if($idEnc=mysql_query($sqlIDenc)){
		$row=mysql_fetch_array($idEnc);
		$id_encuesta = $row[0];
		mysql_query("DELETE FROM preguntas_encuesta WHERE idEncuesta='$id_encuesta'");
		mysql_query("DELETE FROM encuestas WHERE idEncuesta='$id_encuesta'");
		return true;
	}
	else
		return false;
}

/*
*NOMBRE: consultaEncuesta
*DESCRIPCIÓN: Consulta la encuesta pasada por parámetro
*RETURN: Devuelve titulo de la encuesta consultada
*/
function consultaEncuesta($id_encuesta){
	$sql="SELECT titulo FROM encuestas WHERE idEncuesta='".$id_encuesta."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}

/*
*NOMBRE: consultaPreguntas
*DESCRIPCIÓN: Consulta las preguntas sobre la encuesta pasada como parámetro
*RETURN: Devuelve las preguntas de la encuesta consultada
*/
function consultaPreguntas($id_encuesta){
	$sql="SELECT * FROM preguntas_encuesta WHERE idEncuesta='".$id_encuesta."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}
/*
*NOMBRE: consultaIdEncuesta
*DESCRIPCIÓN: Consulta el ID sobre la encuesta pasada como parámetro
*RETURN: Devuelve el ID de la encuesta consultada
*/
function consultaIdEncuesta($titulo){
	$sql="SELECT idEncuesta FROM encuestas WHERE titulo='".$titulo."'";
	if($resultado = mysql_query($sql))
		return $resultado;
	else
		return null;
}
/*
*NOMBRE: idsPreguntas
*DESCRIPCIÓN: Consulta el ID de las preguntas asociadas a la encuesta pasada como parámetro
*RETURN: Devuelve el ID de las preguntas asociadas a la encuesta
*/
function idsPreguntas($id_encuesta){
	$sql="SELECT idPregunta FROM preguntas_encuesta WHERE idEncuesta='".$id_encuesta."'";
	$resultado = mysql_query($sql);	
	return $resultado;
}
/*
*NOMBRE: modificarEncuesta
*DESCRIPCIÓN: Modifica los datos de la encuesta "id_encuesta"
*RETURN:devuelve true si se han modificado correctamente.
*/
function modificarEncuesta($id_encuesta,$titulo){
	$sql="UPDATE encuestas 
		SET titulo='".$titulo."' WHERE idEncuesta='".$id_encuesta."'";
	if(mysql_query($sql)) return true;
	else return false;
}
/*
*NOMBRE: modificarPregunta
*DESCRIPCIÓN: Modifica los datos de la pregunta "id_pregunta"
*RETURN:devuelve true si se han modificado correctamente.
*/
function modificarPregunta($id_pregunta,$pregunta){
	$sql="UPDATE preguntas_encuesta 
		SET pregunta='".$pregunta."' WHERE idPregunta='".$id_pregunta."'";
	if(mysql_query($sql)) return true;
	else return false;
}
/*
*NOMBRE: consultarUsuariosInscritos
*DESCRIPCIÓN: Consulta los usuarios inscritos en una asignatura, es decir los usuarios que fueron validados por el profesor y tienen acceso a estas asignaturas.
*RETURN:devuelve la lista de usuarios inscritos a esa asignatura.
*/
function consultarUsuariosInscritos($idAsignatura){
	$sql="SELECT usuarios.Usuario,Nombre, apellidos,dni, inscrito
		  FROM usuarios,usuarioasignaturas 
		  WHERE usuarios.Usuario = usuarioasignaturas.Usuario and usuarioasignaturas.idAsignatura='$idAsignatura'";
	$resultado=mysql_query($sql);
	if (false === $resultado) 
        echo mysql_error();
	return $resultado;
}
/*
*NOMBRE: BajaUsuarioAsignatura
*DESCRIPCIÓN: Elimina de la tabla UsuarioAsignaturas la fila del usuario, ya sea una solicitud de inscripción o esté inscrito.
*RETURN:devuelve true si la eliminación fue correcta o false si no lo fue.
*/
function BajaUsuarioAsignatura($idAsignatura,$idUsuario){
	$sql = "DELETE FROM usuarioasignaturas
			WHERE Usuario='$idUsuario' and idAsignatura='$idAsignatura'";
	if(mysql_query($sql))
		return true;
	else return false;
}
?>
