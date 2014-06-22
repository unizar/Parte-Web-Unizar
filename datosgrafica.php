<?php
	
define('DB_SERVER','localhost'); 
define('DB_NAME','bbdd_unizar'); 
define('DB_USER','usuario_web'); 
define('DB_PASS','tfgfdi1314'); 

$link = mysql_connect(DB_SERVER,DB_USER,DB_PASS); 
mysql_select_db(DB_NAME,$link) OR DIE ("Error: No es posible establecer la conexión");
mysql_query("SET NAMES 'utf8';");
	
	$categorias = array('PREGUNTAS',"Punt. 1","Punt. 2","Punt. 3","Punt. 4","Punt. 5");
	$P1 = array();
	$P2 = array();
	$P3 = array();
	$P4 = array();
	$P5 = array();
	
	$id_Actividad=$_GET['id_Actividad'];
	$existe=mysql_query("SELECT Encuesta as id_Encuesta FROM actividades WHERE id_actividad=".$id_Actividad."");
	$row=mysql_fetch_array($existe);
	$id_Encuesta = $row[0];
	$consulta = "SELECT pregunta FROM preguntas_encuesta WHERE idEncuesta=".$id_Encuesta." ORDER BY pregunta";
	$result1 = mysql_query($consulta);
	$i=0;
	while($fila = mysql_fetch_assoc($result1)){
		switch ($i) {
		case 0:
			{
			$P1[] = $fila['pregunta'];
			break;
			}	
		case 1:
			{
			$P2[] = $fila['pregunta'];
			break;
			}		
		case 2:
			{
			$P3[] = $fila['pregunta'];
			break;
			}
		case 3:
			{
			$P4[] = $fila['pregunta'];
			break;
			}
		case 4:
			{
			$P5[] = $fila['pregunta'];
			break;
			}
		}	
		$i=$i+1;
	}

	$id_Actividad = $_GET['id_Actividad'];
	$consulta = "SELECT resp1,resp2,resp3,resp4,resp5 FROM actividad_encuesta ae INNER JOIN actividades a ON ae.id_actividad=a.id_actividad WHERE a.id_actividad=".$id_Actividad." ORDER BY idPregunta";
	$result = mysql_query($consulta);
	$i=0;
	while($fila = mysql_fetch_assoc($result)){
	
		switch ($i) {
		case 0:
			{
			$P1[] = (int)$fila['resp1'];
			$P1[] = (int)$fila['resp2'];
			$P1[] = (int)$fila['resp3'];
			$P1[] = (int)$fila['resp4'];
			$P1[] = (int)$fila['resp5'];
			break;
			}
			
		case 1:
			{
			$P2[] = (int)$fila['resp1'];
			$P2[] = (int)$fila['resp2'];
			$P2[] = (int)$fila['resp3'];
			$P2[] = (int)$fila['resp4'];
			$P2[] = (int)$fila['resp5'];
			break;
			}
			
		case 2:
			{
			$P3[] = (int)$fila['resp1'];
			$P3[] = (int)$fila['resp2'];
			$P3[] = (int)$fila['resp3'];
			$P3[] = (int)$fila['resp4'];
			$P3[] = (int)$fila['resp5'];
			break;
			}
		case 3:
			{
			$P4[] = (int)$fila['resp1'];
			$P4[] = (int)$fila['resp2'];
			$P4[] = (int)$fila['resp3'];
			$P4[] = (int)$fila['resp4'];
			$P4[] = (int)$fila['resp5'];
			break;
			}
		case 4:
			{
			$P5[] = (int)$fila['resp1'];
			$P5[] = (int)$fila['resp2'];
			$P5[] = (int)$fila['resp3'];
			$P5[] = (int)$fila['resp4'];
			$P5[] = (int)$fila['resp5'];
			break;
			}
		}	
		$i=$i+1;
	}
	echo json_encode( array($categorias,$P1,$P2,$P3,$P4,$P5) );
?>
