<html>
  <head>
	<link rel="shortcut icon" href="images/icono.png" >
    <title>Campus Lingüística Universidad de Zaragoza - Estadística Encuesta</title> 
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
			Administrador - Estadística Encuestas
		</p>
		 
	</div>
	<div id="menu">
		 <h1><a href="Administrador_Inicio.php">Menú</a></h1>
		 <ul>
		  <li><a href="Administrador_Alta_Profesor.php" >Alta profesor</a></li>
		  <li><a href="Administrador_modificar_profesor1.php" >Modificar/Eliminar Profesor</a></li>
		  <li><a href="Administrador_Generar_encuesta.php" >Generar Encuesta</a></li>
		  <li><a href="Administrador_Modificar_Encuesta.php" >Modificar/Eliminar Encuesta</a></li>
		  <li><a href="Administrador_Estadistica_Encuesta.php" >Estadística Encuesta</a></li>
		  <li><a href="Administrador_Usuario_Consulta.php" >Gestión Usuarios</a></li>
		 </ul>
	</div>
	<div class="Main"> 
		<div id="Principal">
			<h1> Selecciona una encuesta para visualizar la estadística de sus respuestas</h1> 
			<div class="separador"></div>
			<div id="select_encuestas">
				<?php 
					$listaActividades=consultaActividadesEncuesta();
					if (mysql_num_rows($listaActividades) == 0)
					{
						?>
							<script type="text/javascript">
								alert("No hay actividades disponibles con Encuesta");
							</script>
						<?php	
					}else
					{
						echo "<select id=\"tiposEncuestas\" name=\"tiposEncuestas\" onChange=\"drawItems(this.value,this.name)\">\n";
						echo "<option selected value=\"0\"> Seleccione un Item </option>\n";
						while($row = mysql_fetch_array($listaActividades))
						{
							echo "<option value=\"".$row['id_Actividad']."\" name=\"".$row['Nombre']."\" >".$row['Nombre']."</option>\n";
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