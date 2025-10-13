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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
$X_Type        = simpleDecode($_GET['Type'], fecha_actual());
$idTelemetria  = simpleDecode($_GET['idTelemetria'], fecha_actual());
/**************************************************************/
//Se definen las variables de tiempo
$HoraActual   = hora_actual();
$FechaActual  = fecha_actual();

$HoraAnterior   = $HoraActual;
$FechaAnterior  = restarDias($FechaActual,1); //Se obtienen los datos de 7 dias atras

/*****************************************/
switch ($X_Type) {
    case 1: $selected = ', Temperatura AS Valor';   $Tittle = 'Temperatura'; break;
    case 2: $selected = ', Humedad AS Valor';       $Tittle = 'Humedad'; break;
    case 3: $selected = ', PuntoRocio AS Valor';    $Tittle = 'Punto Rocio'; break;
    case 4: $selected = ', PresionAtmos AS Valor';  $Tittle = 'Presion Atmos'; break;
    
}

// Se trae un listado con el historial
$SIS_query = 'Fecha, Hora, TimeStamp'.$selected;
$SIS_join  = '';
$SIS_where = '(TimeStamp BETWEEN "'.$FechaAnterior.' '.$HoraAnterior .'" AND "'.$FechaActual.' '.$HoraActual.'") AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' AND idTelemetria = '.$idTelemetria;
$SIS_order = 'idAuxiliar ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'telemetria_listado_aux_equipo', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

$Temp_1   = '';
$arrData  = array();
foreach($arrHistorial as $hist) {
	//Se obtiene la fecha
	$Temp_1 .= "'".Fecha_estandar($hist['Fecha'])." - ".$hist['Hora']."',";
	//valores	
	if(isset($arrData[1]['Value'])&&$arrData[1]['Value']!=''){$arrData[1]['Value'] .= ", ".$hist['Valor'];    }else{ $arrData[1]['Value'] = $hist['Valor'];}
}
$arrData[1]['Name'] = "'".$Tittle."'";

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Historico <?php echo $Tittle; ?></h5>
		</header>
		<div class="tab-content">
			<?php
			/*******************************************************************************/
			//las fechas
			$Graphics_xData      ='var xData = [['.$Temp_1.'],];';
			//los valores
			$Graphics_yData      ='var yData = [['.$arrData[1]['Value'].'],];';
			//los nombres
			$Graphics_names      = 'var names = ['.$arrData[1]['Name'].',];';
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

			$gr_tittle = 'Grafico '.$Tittle;
			$gr_unimed = $Tittle;
			echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); 
			
			?>
		</div>
	</div>
</div>	


	
<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
