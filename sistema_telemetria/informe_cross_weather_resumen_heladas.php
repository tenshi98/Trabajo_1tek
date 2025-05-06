<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_cross_weather_resumen_heladas.php";
$location = $original;
//Se agregan ubicaciones
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$location .= "?submit_filter=Filtrar";
if(isset($_GET['fecha'])&&$_GET['fecha']!=''){       $search .="&fecha=".$_GET['fecha'];}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){$search .="&idTelemetria=".$_GET['idTelemetria'];}
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
/**********************************************************/
//Seleccionar la tabla
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$x_table = 'telemetria_listado_aux_equipo';
}else{
	$x_table = 'telemetria_listado_aux';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = $x_table.".idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['fecha'])&&$_GET['fecha']!=''){

	//Se organizan los datos
	$Fecha     = $_GET['fecha'];
	$Hora      = '18:00:00';
	$FechaSig  = sumarDias($_GET['fecha'], 1);
	$HoraSig   = '09:00:00';

	//se crea query
	$SIS_where.= " AND (".$x_table.".TimeStamp BETWEEN '".$Fecha." ".$Hora ."' AND '".$FechaSig." ".$HoraSig."')";

}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$_GET['idTelemetria']."'";
}


/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 'Fecha, Hora, HeladaDia, HeladaHora, Temperatura, Helada, CrossTech_TempMin ,
Fecha_Anterior, Hora_Anterior, Tiempo_Helada';
$SIS_join  = '';
$SIS_order = 'idAuxiliar ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

/****************************************************************************/
$arrTemp   = array();
$arrEvento = array();
$nevento   = 0;
//Se busca la temperatura real							
foreach($arrHistorial as $hist2) {
	//verifico que exista fecha
	if(isset($hist2['Fecha'])&&$hist2['Fecha']!='0000-00-00'){
		//Se obtiene la fecha
		$y_dia = fecha2NdiaMes($hist2['Fecha']);
		$y_mes = fecha2NMes($hist2['Fecha']);
		//se obtiene la hora
		$y_time   = strtotime($hist2['Hora']);
		$y_hora   = date('H', $y_time);
		$y_minuto = date('i', $y_time);
		//se guardan los datos
		$arrTemp[$y_mes][$y_dia][$y_hora][$y_minuto] = $hist2['Temperatura'];
		//Se guarda evento
		if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<=$hist2['CrossTech_TempMin']){

				//se crean variables en caso de no existir
			if(!isset($arrEvento[$nevento]['TempMinima'])){  $arrEvento[$nevento]['TempMinima']  = 1000;}
			if(!isset($arrEvento[$nevento]['TempMaxima'])){  $arrEvento[$nevento]['TempMaxima']  = -1000;}
			if(!isset($arrEvento[$nevento]['TempSum'])){     $arrEvento[$nevento]['TempSum']  = 0;}
			if(!isset($arrEvento[$nevento]['TempCuenta'])){  $arrEvento[$nevento]['TempCuenta']  = 0;}
			if(!isset($arrEvento[$nevento]['Minutos'])){     $arrEvento[$nevento]['Minutos']  = 0;}
			if(!isset($arrEvento[$nevento]['FechaInicio'])){ $arrEvento[$nevento]['FechaInicio'] = $hist2['Fecha'];}
			if(!isset($arrEvento[$nevento]['HoraInicio'])){  $arrEvento[$nevento]['HoraInicio']  = $hist2['Hora'];}

			$arrEvento[$nevento]['FechaTermino'] = $hist2['Fecha'];
			$arrEvento[$nevento]['HoraTermino']  = $hist2['Hora'];
			$arrEvento[$nevento]['TempSum']      = $arrEvento[$nevento]['TempSum'] + $hist2['Temperatura'];
			$arrEvento[$nevento]['TempCuenta']   = $arrEvento[$nevento]['TempCuenta'] + 1;
			$arrEvento[$nevento]['TempProm']     = $arrEvento[$nevento]['TempSum']/$arrEvento[$nevento]['TempCuenta'];
			$arrEvento[$nevento]['Minutos']      = $arrEvento[$nevento]['Minutos'] + $hist2['Tiempo_Helada'];

			//Guardo la temperatura Minima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']<$arrEvento[$nevento]['TempMinima']){
				$arrEvento[$nevento]['TempMinima'] = $hist2['Temperatura'];
			}
			//Guardo la temperatura Maxima
			if(isset($hist2['Temperatura'])&&$hist2['Temperatura']>$arrEvento[$nevento]['TempMaxima']){
				$arrEvento[$nevento]['TempMaxima'] = $hist2['Temperatura'];
			}
			
			
		}else{
			$nevento++;
		}
	}
}

/****************************************************************************/
$Temp_1   = '';
$arrData  = array();
foreach($arrHistorial as $hist) {
	//verifico que exista fecha
	if(isset($hist['HeladaDia'])&&$hist['HeladaDia']!='0000-00-00'){
		//variables
		$temp_predic = $hist['Helada'];

		//Se obtiene la fecha
		$x_dia = fecha2NdiaMes($hist['HeladaDia']);
		$x_mes = fecha2NMes($hist['HeladaDia']);
		$x_ano = fecha2Ano($hist['HeladaDia']);
		//se obtiene la hora
		$x_time     = strtotime($hist['HeladaHora']);
		$x_hora     = date('H', $x_time);
		$x_minuto   = date('i', $x_time);

		//limito
		//echo intval($x_hora).'<br/>';
		if(intval($x_hora)!=9 && intval($x_hora)!=10){
		
			if(isset($arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto])&&$arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto]!=''){							
				$temp_real = $arrTemp[$x_mes][$x_dia][$x_hora][$x_minuto];
			}else{
				$temp_real = 0;
			}

			//se arma cadena	
			$Temp_1 .= "'".Fecha_estandar($hist['HeladaDia'])." - ".$hist['HeladaHora']."',";
			if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$temp_real;    }else{ $arrData[1]['Value'] = $temp_real; }
			if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){$arrData[2]['Value'] .= ", ".$temp_predic;  }else{ $arrData[2]['Value'] = $temp_predic; }
		
		}
	}
}
$arrData[1]['Name'] = "'Temperatura Real'";
$arrData[2]['Name'] = "'Temperatura Proyectada'";
/***********************************************************/
$arrResumen = array();
$arrResumen['Tiempo']     = 0;
$arrResumen['TempMinima'] = 0;
foreach ($arrEvento as $key => $eve){
	//comparo temperaturas
	if($arrResumen['TempMinima']>$eve['TempMinima']){                               
		$arrResumen['TempMinima'] = $eve['TempMinima'];
		//guardo los otros datos
		if(!isset($arrResumen['Duracion'])OR $arrResumen['Duracion']==''){              $arrResumen['Duracion']        = $eve['Minutos'];}
		if(!isset($arrResumen['HoraTempMinima'])OR $arrResumen['HoraTempMinima']==''){  $arrResumen['HoraTempMinima']  = $eve['HoraInicio'];}
	
	}
	//tiempo total de la helada
	$arrResumen['Tiempo'] = $arrResumen['Tiempo'] + $eve['Minutos'];
}
	
									
?>
<style>
#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
</style>
<div id="loading"></div>
<script>
//oculto el loader
document.getElementById("loading").style.display = "none";
</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Resumen Heladas', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Del dia '.Fecha_completa($_GET['fecha'])); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
		<a target="new" href="<?php echo 'informe_cross_weather_resumen_heladas_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>

		<?php if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>
			<input class="btn btn-sm btn-metis-3 pull-right margin_width fa-input" type="button" onclick="Export()" value="&#xf1c1; Exportar a PDF"/>
		<?php }else{ ?>
			<a target="new" href="<?php echo 'informe_cross_weather_resumen_heladas_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
		<?php } ?>

	</div>
</div>
<div class="clearfix"></div>

<?php
//Se verifica si se pidieron los graficos
if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5> Graficos</h5>
			</header>
			<div class="table-responsive" id="grf">
				<?php
					/*******************************************************************************/
					//las fechas
					$Graphics_xData      ='var xData = [['.$Temp_1.'],['.$Temp_1.'],];';
					//los valores
					$Graphics_yData      ='var yData = [['.$arrData[1]['Value'].'],['.$arrData[2]['Value'].'],];';
					//los nombres
					$Graphics_names      = 'var names = ['.$arrData[1]['Name'].','.$arrData[2]['Name'].',];';
					//los tipos
					$Graphics_types      = "var types = ['','',];";
					//si lleva texto en las burbujas
					$Graphics_texts      = "var texts = [[],[],];";
					//los colores de linea
					$Graphics_lineColors = "var lineColors = ['','',];";
					//los tipos de linea
					$Graphics_lineDash   = "var lineDash = ['','',];";
					//los anchos de la linea
					$Graphics_lineWidth  = "var lineWidth = ['','',];";	

					$gr_tittle = 'Temperaturas';
					$gr_unimed = '(°C)';
					echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
				?>			
			</div>
		</div>
	</div>
			
			
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">

		<form method="post" id="make_pdf" action="informe_cross_weather_resumen_heladas_to_pdf.php">
			<input type="hidden" name="img_adj" id="img_adj" />

			<input type="hidden" name="idSistema"     id="idSistema"    value="<?php echo $_SESSION['usuario']['basic_data']['idSistema']; ?>" />
			<input type="hidden" name="fecha"         id="fecha"        value="<?php echo $_GET['fecha']; ?>" />
			<?php if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){ ?>
				<input type="hidden" name="idTelemetria"   id="idTelemetria"  value="<?php echo $_GET['idTelemetria']; ?>" />
			<?php } ?>

			<button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Hacer PDF</button>

		</form>

		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/dom-to-image.min.js"></script>
		<script>
			var node = document.getElementById('grf');
					
			function sendDatatoSRV(img) {
				$('#img_adj').val(img);
				//$('#img_adj').val($('#img-out').html());
				$('#make_pdf').submit();
				//oculto el loader
				document.getElementById("loading").style.display = "none";
			}
			function Export() {
				//muestro el loader
				document.getElementById("loading").style.display = "block";
				//Exporto
				setTimeout(
					function(){
						domtoimage.toPng(node)
						.then(function (dataUrl) {
							var img = new Image();
							img.src = dataUrl;
							//document.getElementById('img-out').appendChild(img);
							//alert(img.src);
							sendDatatoSRV(img.src);
						})
						.catch(function (error) {
							console.error('oops, something went wrong!', error);
							Swal.fire({icon: 'error',title: 'Oops...',text: 'No se puede exportar!'});
							document.getElementById("loading").style.display = "none";
						});
					}
				, 3000);
			}
		</script>
	</div>
<?php } ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="row">

		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Temperatura Minima</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-thermometer-half" aria-hidden="true"></i></span>
						<span><?php echo $arrResumen['TempMinima']; ?></span>
						°C
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Duracion Temp Min</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo $arrResumen['Duracion']; ?></span>
						Horas
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">Hora Temp Minima</h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo $arrResumen['HoraTempMinima']; ?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<div class="box box-blue box-solid">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo 'Tiempo bajo '.$arrHistorial[0]['CrossTech_TempMin'].'°C'; ?></h3>
				</div>
				<div class="box-body">
					<div class="value">
						<span><i class="fa fa-clock-o" aria-hidden="true"></i></span>
						<span><?php echo Cantidades($arrResumen['Tiempo'], 2); ?></span>
						Horas
					</div>
				</div>
			</div>
		</div>
		
		
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo 'Tiempo bajo '.$arrHistorial[0]['CrossTech_TempMin'].'°C'; ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Inicio</th>
						<th>Termino</th>
						<th>Temperatura Minima</th>
						<th>Temperatura Maxima</th>
						<th>Temperatura Promedio</th>
						<th>Duracion</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrEvento as $key => $eve){ ?>
						<tr class="odd">
							<td><?php echo $eve['HoraInicio'].' - '.fecha_estandar($eve['FechaInicio']); ?></td>
							<td><?php echo $eve['HoraTermino'].' - '.fecha_estandar($eve['FechaTermino']); ?></td>
							<td><?php echo Cantidades($eve['TempMinima'], 2).'°C'; ?></td>
							<td><?php echo Cantidades($eve['TempMaxima'], 2).'°C'; ?></td>
							<td><?php echo Cantidades($eve['TempProm'], 2).'°C'; ?></td>
							<td><?php echo $eve['Minutos'].' horas'; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=4";//Agro-Weather
}	 
 ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){ $x1  = $fecha;           }else{$x1  = '';}
				if(isset($idGrafico)){       $x2  = $idGrafico;       }else{$x2  = '';}
				if(isset($idTelemetria)){    $x3  = $idTelemetria;    }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha','fecha', $x1, 2);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x2, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
