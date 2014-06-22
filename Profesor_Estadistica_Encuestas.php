<html>
  <head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Estadística Encuestas</title> 
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script src="JQuery/jquery.min.js" type="text/javascript"></script>
	<script src="JQuery/jquery.form.js" type="text/javascript"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="Style.css"/> 
	<?php include "bbdd.php"?>
    
      <script type="text/javascript">

  // Load the Visualization API and the corechart
  google.load('visualization', '1', {'packages':['corechart']});

  function drawItems(id_Actividad) {

	var datos = $.ajax({
      url: "datosgrafica.php",
      data: {id_Actividad:id_Actividad},
      dataType:"json",
      async: false
    }).responseText;
	
	datos = JSON.parse(datos);


    var graphic = new google.visualization.arrayToDataTable(datos);

    var chart = new google.visualization.ColumnChart(document.getElementById('grafica'));

    chart.draw(graphic, {
	  title: 'RESULTADOS',
	  hAxis: {title: 'PREGUNTAS', titleTextStyle: {color: 'green'}},
	  vAxis: {title: 'RESPUESTAS', titleTextStyle: {color: '#FF0000'}},
	  backgroundColor:'#ffffcc',
	  legend:{position: 'right', textStyle: {color: 'blue', fontSize: 13}},
      width: 700,
      height: 550
    });
  }


  </script>
  </head>
  <body>
  <?php session_start();
	//Validar que el usuario este logueado y exista un UID
	if ( !($_SESSION['autenticado'] == 'SI' && isset($_SESSION["k_username"])) )
	{
		//En caso de que el usuario no este autenticado, crear un formulario y redireccionar a la 
		//pantalla de login, enviando un codigo de error
	?>
			<form name="formulario" method="post" action="index.html">
				<input type="hidden" name="msg_error" value="2">
			</form>
			<script type="text/javascript"> 
				document.formulario.submit();
			</script>
	<?php
	}
	?>
	<div class="cabecera">
		<div class="LogoContainer">
			<image id='LogoUniZar' class="Logo" src='images\logo_uz.png'>
		</div>
		
		<div class="cerrarSesion">		
			<a href="<?php echo 'cerrarSesion.php'?>">Cerrar sesión</a>
		</div>
		<div class="UsuarioActual">
				Usuario: <?php echo $_SESSION["k_username"];?>
		</div>
		<p class="tipoUsuario" >
			Profesor - Estadística Encuestas
		</p>
		 
	</div>
	<div id="menu">
		 <h1><a href="Profesor_Inicio.php">Menú</a></h1>
		 <ul>
		  <li><a href="Profesor_Alta_Asignatura.php" >Alta Asignatura</a></li>
		  <li><a href="Profesor_Modificar_Eliminar_Asignatura.php" >Modificar/Eliminar Asignatura</a></li>
		  <li><a href="Profesor_Alta_Actividad.php" >Alta Actividad </a></li>
		  <li><a href="Profesor_Modificar_Eliminar_Actividad.php" title="...">Modificar/Eliminar Actividad</a></li>
		  <li><a href="Profesor_Validar_Usuario.php" >Validar Alumnos</a></li>
		  <li><a href="Profesor_Baja_Usuario.php" >Baja Alumnos</a></li>
		  <li><a href="Profesor_Visualizar_Encuestas.php" >Visualizar Encuestas</a></li>
		  <li><a href="Profesor_Alertas.php" >Alertas</a></li>
		  <li><a href="Profesor_Estadistica_Encuestas.php" >Estadística Encuestas</a></li>
		 </ul>
	</div>
	<div class="Main"> 
		<input type="hidden" id="id_profesor" value="<?php echo $_SESSION['k_username'];?>" />
		<div id="Principal">
			<h1> Selecciona una actividad para visualizar sus estadísticas</h1> 
			<div class="separador"></div>
			<div id="select_encuestas">
				<?php 
					$listaEncuestas=consultaActividadesProfesorEncuesta($_SESSION['k_username']);
					if (mysql_num_rows($listaEncuestas) == 0)
					{
						?>
							<script type="text/javascript">
								alert("No hay encuestas disponibles");
							</script>
						<?php	
					}else
					{
						echo "<select id=\"tiposEncuestas\" name=\"tiposEncuestas\" onChange=\"drawItems(this.value)\">\n";
						echo "<option selected value=\"0\"> Seleccione un Item </option>\n";
						while($row = mysql_fetch_array($listaEncuestas))
						{
							echo "<option value=\"".$row['id_Actividad']."\">".$row['Nombre']."</option>\n";
						}
						echo "</select>\n\n";
					}	
				?>
			</div>
			<div class="separador"></div>
		</div>
		</br>
		</br>
		</br>
		</br>
		</br>
		</br>
		<div id="grafica"></div>	
	</div>
	<div class="Footer">
			©2013 Universidad de Zaragoza 
	</div>
  </body>
</html>