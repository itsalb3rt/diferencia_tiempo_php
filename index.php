<?php
/**
*
**/
require('php/class.Control_horario_laboral.php');

//Verificando si se ha hecho un submit
if(isset($_GET['submit'])){

	/**
	* los dias de fiesta deben ser especificados manualmente
	* ej: array('2018-05-30','2018-07-20')
	**/
	$dias_fiesta = array (0);
	$fecha_inicio = $_GET['fecha_inicio'];
	$fecha_final = $_GET['fecha_final'];
	//Instancia de la clase
	$diferencia_fechas = new Control_horario_laboral();
	//Pasando los parametros
	$resultados = $diferencia_fechas->tiempo_transcurrido_fechas( $fecha_inicio, $fecha_final,$dias_fiesta );
	
	$tiempo_segundos =  $resultados['tiempo_total_segundos'];
	$tiempo_minutos = (($resultados['tiempo_total_segundos'] / 60)) ;
	$tiempo_horas = ($resultados['tiempo_total_segundos'] / 60) / 60 ;
	
	$resultados = null;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="js/jquery-latest.js" type="text/javascript"></script>
<script src="js/jquery-ui.js" type="text/javascript"></script>
<script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/datepicker.css">
<link rel="stylesheet" href="css/cuerpo.css">
	<script>
		$(document).ready(function(){
			$('.fecha_inicio,.fecha_final').datetimepicker({ dateFormat: 'yy-mm-dd' }); 
		});
	</script>
<title>Awesome - Date</title>
</head>

<body>
	<div class="contenedor">
		<div class="contenedor_formulario">
			<h1>Selecione 2 fechas</h1>
			<div>
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="GET" class="formulario_datos">
					<div>
						<input type="text" name="fecha_inicio" class="fecha_inicio" placeholder="Fecha Inicio" autocomplete="off" required>
					</div>
					<div>
						<input type="text" name="fecha_final" class="fecha_final" placeholder="Fecha Final" autocomplete="off" required>
					</div>
					<div>
						<input type="submit" name="submit" class="boton_generico bg_azul_suave l_content" value="Resultado">
					</div>
				</form>
			</div>
			<p>Obtén la diferencia entre 2 fechas tomando en cuenta los días laborables, sábados y domingos.</p>
		</div>
		
		<?php if(isset($_GET['submit'])): ?>
			<div class="resultado_comparacion centrar_contenido">
				<div class="meta_data">
					<h4>Resultado</h4>
					<div><span>Fecha inicial:</span>&Tab;<?= $fecha_inicio ?>&Tab;<span>Fecha final:</span>&Tab;<?= $fecha_final ?></div>
					<div><span>Tiempo en segundos:</span>&Tab;<?=$tiempo_segundos?></div>
					<div><span>Tiempo en minutos:</span>&Tab;<?=$tiempo_minutos?></div>
					<div><span>Tiempo en horas:</span>&Tab;<?=$tiempo_horas?></div>
				</div>
			</div>
		<?php endif; ?>
		
	</div>
	
	<div class="creditos">
		<span>Albert E. Hidalgo Taveras</span>&Tab;-&Tab;<a href="https://github.com/itsalb3rt">GitHub</a>, <a href="https://twitter.com/itsHivat">Twitter</a>
	</div>
</body>
</html>