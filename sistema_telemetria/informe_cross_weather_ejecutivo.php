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
$original = "informe_cross_weather_ejecutivo.php";
$location = $original;
//Se agregan ubicaciones
$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$location .= "?submit_filter=Filtrar";
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$search .="&fecha_desde=".$_GET['fecha_desde'];
	$search .="&fecha_hasta=".$_GET['fecha_hasta'];
}
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
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.= " AND ".$x_table.".Fecha BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND ".$x_table.".idTelemetria='".$_GET['idTelemetria']."'";
}
/**********************************************************/
// Se trae un listado con todos los datos
$SIS_query = 
$x_table.'.Fecha,
'.$x_table.'.Hora,
'.$x_table.'.TimeStamp,
'.$x_table.'.Temperatura,
'.$x_table.'.PuntoRocio,
'.$x_table.'.PresionAtmos,
'.$x_table.'.HorasBajoGrados,
'.$x_table.'.Tiempo_Helada,
'.$x_table.'.Dias_acumulado,
'.$x_table.'.UnidadesFrio';
$SIS_join  = '';
$SIS_order = $x_table.'.Fecha ASC';
$arrMediciones = array();
$arrMediciones = db_select_array (false, $SIS_query, $x_table, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

//Variables
$arrMed   = array();
$counter  = 0;
$Temp_1   = '';
$arrData  = array();

//recorro los datos
foreach ($arrMediciones as $med) {
	//verifico que exista fecha
	if(isset($med['Fecha'])&&$med['Fecha']!='0000-00-00'){

		//Se obtiene la fecha
		$Temp_1 .= "'".Fecha_estandar($med['Fecha'])." - ".$med['Hora']."',";

		if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$med['Temperatura'];    }else{ $arrData[1]['Value'] = $med['Temperatura'];}
		if(isset($arrData[2]['Value'])&&$arrData[2]['Value']!=''){$arrData[2]['Value'] .= ", ".$med['PuntoRocio'];     }else{ $arrData[2]['Value'] = $med['PuntoRocio'];}
		if(isset($arrData[3]['Value'])&&$arrData[3]['Value']!=''){$arrData[3]['Value'] .= ", ".$med['PresionAtmos'];   }else{ $arrData[3]['Value'] = $med['PresionAtmos'];}
		if(isset($arrData[4]['Value'])&&$arrData[4]['Value']!=''){$arrData[4]['Value'] .= ", ".$med['UnidadesFrio'];   }else{ $arrData[4]['Value'] = $med['UnidadesFrio'];}
		if(isset($arrData[5]['Value'])&&$arrData[5]['Value']!=''){$arrData[5]['Value'] .= ", ".$med['Dias_acumulado'];}else{ $arrData[5]['Value'] = $med['Dias_acumulado'];}

		//verifico cambio de dia
		if((isset($arrMed[$counter]['Fecha'])&&$arrMed[$counter]['Fecha']!=$med['Fecha']) OR $counter==0){
			$counter++;
		}

		//creo las variables si estas no existen
		if(!isset($arrMed[$counter]['Tiempo_Helada'])){  $arrMed[$counter]['Tiempo_Helada']  = 0;}
		if(!isset($arrMed[$counter]['Temp_Min'])){       $arrMed[$counter]['Temp_Min']       = 1000;}
		if(!isset($arrMed[$counter]['Temp_Max'])){       $arrMed[$counter]['Temp_Max']       = -1000;}

		//Guardo los datos
		$arrMed[$counter]['Fecha']        = $med['Fecha'];
		$arrMed[$counter]['UnidadesFrio'] = $med['UnidadesFrio'];
		$arrMed[$counter]['DiasAcum']     = $med['Dias_acumulado'];

		//verifico si hubo helada
		if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=''&&$med['Tiempo_Helada']!=0){
			//guardo el tiempo de helada
			$arrMed[$counter]['Tiempo_Helada'] = $arrMed[$counter]['Tiempo_Helada'] + $med['Tiempo_Helada']; 
		}
		//Guardo la temperatura Minima
		if(isset($med['Temperatura'])&&$med['Temperatura']<$arrMed[$counter]['Temp_Min']){
			$arrMed[$counter]['Temp_Min'] = $med['Temperatura'];
		}
		//Guardo la temperatura Maxima
		if(isset($med['Temperatura'])&&$med['Temperatura']>$arrMed[$counter]['Temp_Max']){
			$arrMed[$counter]['Temp_Max'] = $med['Temperatura'];
		}
	}
}

$arrData[1]['Name'] = "'Temperatura'";
$arrData[2]['Name'] = "'Punto de Rocio'";
$arrData[3]['Name'] = "'Presion Atmosferica'";
$arrData[4]['Name'] = "'Unidades de Frio'";
$arrData[5]['Name'] = "'Acumulado Dias Grado'";


							
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
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Informe Ejecutivo', $_SESSION['usuario']['basic_data']['RazonSocial'], 'De '.Fecha_completa($_GET['fecha_desde']).' a '.Fecha_completa($_GET['fecha_hasta'])); ?>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
		<a target="new" href="<?php echo 'informe_cross_weather_ejecutivo_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>

		<?php if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>
			<input class="btn btn-sm btn-metis-3 pull-right margin_width fa-input" type="button" onclick="Export()" value="&#xf1c1; Exportar a PDF"/>
		<?php }else{ ?>
			<a target="new" href="<?php echo 'informe_cross_weather_ejecutivo_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
		<?php } ?>

	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Mes</th>
						<th>Dia</th>
						<th>Helada</th>
						<th>Temperatura<br/>Minima</th>
						<th>Temperatura<br/>Maxima</th>
						<th>Duracion<br/>Helada</th>
						<th>Unidades<br/>Frio</th>
						<th>Unidades Frio<br/>Acumuladas</th>
						<th>Dias<br/>Grado</th>
						<th>Dias Grado<br/>Acumuladas</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					$unifrio  = 0;
					$diasAcum = 0;
					foreach ($arrMed as $key => $med){
						//verifico helada
						if(isset($med['Tiempo_Helada'])&&$med['Tiempo_Helada']!=0){$helada = 'Si';}else{$helada = 'No';}
						if($unifrio==0){
							$unfrio  = $med['UnidadesFrio'];
							$unifrio = $med['UnidadesFrio'];
						}else{
							$unfrio  = $med['UnidadesFrio']-$unifrio;
							$unifrio = $med['UnidadesFrio'];
						}
						if($diasAcum==0){
							$diaAcum  = $med['DiasAcum'];
							$diasAcum = $med['DiasAcum'];
						}else{
							$diaAcum  = $med['DiasAcum']-$diasAcum;
							$diasAcum = $med['DiasAcum'];
						}
						
						?>
						<tr class="odd">
							<td><?php echo numero_a_mes(fecha2NMes($med['Fecha'])); ?></td>
							<td><?php echo fecha2NdiaMes($med['Fecha']); ?></td>
							<td><?php echo $helada; ?></td>
							<td><?php echo $med['Temp_Min']; ?></td>
							<td><?php echo $med['Temp_Max']; ?></td>
							<td><?php echo minutos2horas($med['Tiempo_Helada']*60); ?></td>
							<td><?php echo cantidades($unfrio, 0); ?></td>
							<td><?php echo cantidades($med['UnidadesFrio'], 0); ?></td>
							<td><?php echo cantidades($diaAcum, 0); ?></td>
							<td><?php echo cantidades($med['DiasAcum'], 0); ?></td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
//Se verifica si se pidieron los graficos
if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Graficos</h5>
			</header>
			<div class="table-responsive">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="grf">
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

					$gr_tittle = 'Temperatura y Punto de Rocio';
					$gr_unimed = '(°C)';
					echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
					/*******************************************************************************/
					//las fechas
					$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
					//los valores
					$Graphics_yData      ='var yData = [['.$arrData[3]['Value'].'],];';
					//los nombres
					$Graphics_names      = 'var names = ['.$arrData[3]['Name'].',];';
					//los tipos
					$Graphics_types      = "var types = ['',];";
					//si lleva texto en las burbujas
					$Graphics_texts      = "var texts = [[],];";
					//los colores de linea
					$Graphics_lineColors = "var lineColors = ['',];";
					//los tipos de linea
					$Graphics_lineDash   = "var lineDash = ['',];";
					//los anchos de la linea
					$Graphics_lineWidth  = "var lineWidth = ['',];";	

					$gr_tittle = 'Presion Atmosferica';
					$gr_unimed = '(hPa)';
					echo GraphLinear_1('graphLinear_2', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
					/*******************************************************************************/
					//las fechas
					$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
					//los valores
					$Graphics_yData      ='var yData = [['.$arrData[4]['Value'].'],];';
					//los nombres
					$Graphics_names      = 'var names = ['.$arrData[4]['Name'].',];';
					//los tipos
					$Graphics_types      = "var types = ['',];";
					//si lleva texto en las burbujas
					$Graphics_texts      = "var texts = [[],];";
					//los colores de linea
					$Graphics_lineColors = "var lineColors = ['',];";
					//los tipos de linea
					$Graphics_lineDash   = "var lineDash = ['',];";
					//los anchos de la linea
					$Graphics_lineWidth  = "var lineWidth = ['',];";	

					$gr_tittle = 'Unidades de Frio';
					$gr_unimed = 'Unidades Frio';
					echo GraphLinear_1('graphLinear_3', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
					/*******************************************************************************/
					//las fechas
					$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
					//los valores
					$Graphics_yData      ='var yData = [['.$arrData[5]['Value'].'],];';
					//los nombres
					$Graphics_names      = 'var names = ['.$arrData[5]['Name'].',];';
					//los tipos
					$Graphics_types      = "var types = ['',];";
					//si lleva texto en las burbujas
					$Graphics_texts      = "var texts = [[],];";
					//los colores de linea
					$Graphics_lineColors = "var lineColors = ['',];";
					//los tipos de linea
					$Graphics_lineDash   = "var lineDash = ['',];";
					//los anchos de la linea
					$Graphics_lineWidth  = "var lineWidth = ['',];";	

					$gr_tittle = 'Acumulado Dias Grado';
					$gr_unimed = 'Acumulado Dias Grado';
					echo GraphLinear_1('graphLinear_4', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
					
					?>
				</div>
						
						
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">

					<form method="post" id="make_pdf" action="informe_cross_weather_ejecutivo_to_pdf.php">
						<input type="hidden" name="img_adj" id="img_adj" />

						<input type="hidden" name="idSistema"     id="idSistema"    value="<?php echo $_SESSION['usuario']['basic_data']['idSistema']; ?>" />
						<input type="hidden" name="fecha_desde"   id="fecha_desde"  value="<?php echo $_GET['fecha_desde']; ?>" />
						<input type="hidden" name="fecha_hasta"   id="fecha_hasta"  value="<?php echo $_GET['fecha_hasta']; ?>" />
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
			</div>
		</div>
	</div>

<?php } ?>



  
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
				if(isset($fecha_desde)){    $x1  = $fecha_desde;    }else{$x1  = '';}
				if(isset($fecha_hasta)){    $x2  = $fecha_hasta;    }else{$x2  = '';}
				if(isset($idGrafico)){      $x3  = $idGrafico;      }else{$x3  = '';}
				if(isset($idTelemetria)){   $x4  = $idTelemetria;   }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Desde','fecha_desde', $x1, 2);
				$Form_Inputs->form_date('Fecha Hasta','fecha_hasta', $x2, 2);
				$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x3, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x4, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x4, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
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
