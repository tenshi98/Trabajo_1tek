<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                                     Se llama la libreria                                                       */
/**********************************************************************************************************************************/
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Excel.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
/**********************************************************************************************************************************/
//variables
$xx = 1;
$arrData = array();
$arrData[$xx] = "C";$xx++;
$arrData[$xx] = "D";$xx++;
$arrData[$xx] = "E";$xx++;
$arrData[$xx] = "F";$xx++;
$arrData[$xx] = "G";$xx++;
$arrData[$xx] = "H";$xx++;
$arrData[$xx] = "I";$xx++;
$arrData[$xx] = "J";$xx++;
$arrData[$xx] = "K";$xx++;
$arrData[$xx] = "L";$xx++;
$arrData[$xx] = "M";$xx++;
$arrData[$xx] = "N";$xx++;
$arrData[$xx] = "O";$xx++;
$arrData[$xx] = "P";$xx++;
$arrData[$xx] = "Q";$xx++;
$arrData[$xx] = "R";$xx++;
$arrData[$xx] = "S";$xx++;
$arrData[$xx] = "T";$xx++;
$arrData[$xx] = "U";$xx++;
$arrData[$xx] = "V";$xx++;
$arrData[$xx] = "W";$xx++;
$arrData[$xx] = "X";$xx++;
$arrData[$xx] = "Y";$xx++;
$arrData[$xx] = "Z";$xx++;
$arrData[$xx] = "AA";$xx++;
$arrData[$xx] = "AB";$xx++;
$arrData[$xx] = "AC";$xx++;
$arrData[$xx] = "AD";$xx++;
$arrData[$xx] = "AE";$xx++;
$arrData[$xx] = "AF";$xx++;
$arrData[$xx] = "AG";$xx++;
$arrData[$xx] = "AH";$xx++;
$arrData[$xx] = "AI";$xx++;
$arrData[$xx] = "AJ";$xx++;
$arrData[$xx] = "AK";$xx++;
$arrData[$xx] = "AL";$xx++;
$arrData[$xx] = "AM";$xx++;
$arrData[$xx] = "AN";$xx++;
$arrData[$xx] = "AO";$xx++;
$arrData[$xx] = "AP";$xx++;
$arrData[$xx] = "AQ";$xx++;
$arrData[$xx] = "AR";$xx++;
$arrData[$xx] = "AS";$xx++;
$arrData[$xx] = "AT";$xx++;
$arrData[$xx] = "AU";$xx++;
$arrData[$xx] = "AV";$xx++;
$arrData[$xx] = "AW";$xx++;
$arrData[$xx] = "AX";$xx++;
$arrData[$xx] = "AY";$xx++;
$arrData[$xx] = "AZ";$xx++;
$arrData[$xx] = "BA";$xx++;
$arrData[$xx] = "BB";$xx++;
$arrData[$xx] = "BC";$xx++;
$arrData[$xx] = "BD";$xx++;
$arrData[$xx] = "BE";$xx++;
$arrData[$xx] = "BF";$xx++;
$arrData[$xx] = "BG";$xx++;
$arrData[$xx] = "BH";$xx++;
$arrData[$xx] = "BI";$xx++;
$arrData[$xx] = "BJ";$xx++;
$arrData[$xx] = "BK";$xx++;
$arrData[$xx] = "BL";$xx++;
$arrData[$xx] = "BM";$xx++;
$arrData[$xx] = "BN";$xx++;
$arrData[$xx] = "BO";$xx++;
$arrData[$xx] = "BP";$xx++;
$arrData[$xx] = "BQ";$xx++;
$arrData[$xx] = "BR";$xx++;
$arrData[$xx] = "BS";$xx++;
$arrData[$xx] = "BT";$xx++;
$arrData[$xx] = "BU";$xx++;
$arrData[$xx] = "BV";$xx++;
$arrData[$xx] = "BW";$xx++;
$arrData[$xx] = "BX";$xx++;
$arrData[$xx] = "BY";$xx++;
$arrData[$xx] = "BZ";$xx++;
$arrData[$xx] = "CA";$xx++;
$arrData[$xx] = "CB";$xx++;
$arrData[$xx] = "CC";$xx++;
$arrData[$xx] = "CD";$xx++;
$arrData[$xx] = "CE";$xx++;
$arrData[$xx] = "CF";$xx++;
$arrData[$xx] = "CG";$xx++;
$arrData[$xx] = "CH";$xx++;
$arrData[$xx] = "CI";$xx++;
$arrData[$xx] = "CJ";$xx++;
$arrData[$xx] = "CK";$xx++;
$arrData[$xx] = "CL";$xx++;
$arrData[$xx] = "CM";$xx++;
$arrData[$xx] = "CN";$xx++;
$arrData[$xx] = "CO";$xx++;
$arrData[$xx] = "CP";$xx++;
$arrData[$xx] = "CQ";$xx++;
$arrData[$xx] = "CR";$xx++;
$arrData[$xx] = "CS";$xx++;
$arrData[$xx] = "CT";$xx++;
$arrData[$xx] = "CU";$xx++;
$arrData[$xx] = "CV";$xx++;
$arrData[$xx] = "CW";$xx++;
$arrData[$xx] = "CX";$xx++;
/**********************************************************************/
//se verifica si se ingreso la hora, es un dato optativo
$subf='';
//Datos opcionales
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$subf.=" AND (TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$subf.=" AND (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
/**********************************************************************/
//Se traen todos los grupos
$arrGrupo = array();
$arrGrupo = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//guardo los grupos
$Grupo = array();
foreach ($arrGrupo as $sen) {
	$Grupo[$sen['idGrupo']] = ' '.$sen['Nombre'];
}

/**********************************************************************/
//Funcion para escribir datos
function crear_data($cantsens, $filtro, $idTelemetria, $f_inicio, $f_termino, $desde, $hasta, $dbConn ) {

	$consql = '';
	$subfiltro = '';
	for ($i = 1; $i <= $cantsens; $i++) {
		//$subfiltro .= ' AND telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.' != 999';
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i.' AS SensorNombre_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;

		//desde y hasta activo
		if(isset($desde)&&$desde!=''&&isset($hasta)&&$hasta!=''){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0),0)) AS MedDesStan_'.$i;
		//solo desde
		}elseif(isset($desde)&&$desde!=''&&(!isset($hasta) OR $hasta=='')){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'>='.$desde.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//solo hasta
		}elseif(isset($hasta)&&$hasta!=''&&(!isset($desde) OR $desde=='')){
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<='.$hasta.',IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0),0)) AS MedDesStan_'.$i;
		//ninguno
		}else{
			$consql .= ',MIN(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMin_'.$i;
			$consql .= ',MAX(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedMax_'.$i;
			$consql .= ',AVG(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedProm_'.$i;
			$consql .= ',STDDEV(NULLIF(IF(telemetria_listado_sensores_activo.SensoresActivo_'.$i.'=1,IF(telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.'<99900,telemetria_listado_tablarelacionada_'.$idTelemetria.'.Sensor_'.$i.',0),0),0)) AS MedDesStan_'.$i;
		}
	}

	/*******************************************************/
	//Se traen todos los registros
	$SIS_query = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado_sensores_nombre`  ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado_tablarelacionada_'.$idTelemetria.'.idTelemetria';
	$SIS_where = 'idTabla!=0 '.$filtro.$subfiltro.' GROUP BY telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema';
	$SIS_order = 'telemetria_listado_tablarelacionada_'.$idTelemetria.'.FechaSistema ASC';
	$arrTemp = array();
	$arrTemp = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemp');

	return $arrTemp;

}

/**********************************************************************************************************************************/
/*                                                          Ejecucion                                                             */
/**********************************************************************************************************************************/
// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();

// Set document properties
$spreadsheet->getProperties()->setCreator("Office 2007")
							 ->setLastModifiedBy("Office 2007")
							 ->setTitle("Office 2007")
							 ->setSubject("Office 2007")
							 ->setDescription("Document for Office 2007")
							 ->setKeywords("office 2007")
							 ->setCategory("office 2007 result file");

/*******************************************************/
//Inicia variable
$SIS_where  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$SIS_where .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
$SIS_where .= " AND telemetria_listado.id_Sensores=1";                                           //sensores activos
//Solo para plataforma 1Tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$SIS_where .= " AND telemetria_listado.idTab=3";//CrossTrack
}
//Verifico si se selecciono el equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where.= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
}
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$SIS_join = "";
}else{
	$SIS_join   = " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
	$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
}

/*******************************************************/
//se trae un listado con los equipos
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.Nombre AS NombreEquipo,
telemetria_listado.cantSensores';
$SIS_order = 'telemetria_listado.idTelemetria ASC';
$arrEquipos = array();
$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipos');

/*********************************************/
$sheet = 0;
foreach ($arrEquipos as $equipo) {
	//Variable temporal
	$arrTemporal = array();
	//Se crea nueva hoja
	$spreadsheet->createSheet();
	//Llamo a la funcion
	$arrTemporal = crear_data($equipo['cantSensores'], $subf, $equipo['idTelemetria'], $_GET['f_inicio'], $_GET['f_termino'], $_GET['desde'], $_GET['hasta'] , $dbConn);

	/***********************************************************/
	//Grupos de los sensores
	$yy = 1;
	for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
		$grupo = '';
		foreach ($arrGrupo as $sen) {
			if($arrTemporal[0]['SensoresGrupo_'.$i]==$sen['idGrupo']){
				$grupo = $sen['Nombre'];
			}
		}
		if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
			if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
				//Si se ven detalles
				if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
					$spreadsheet->setActiveSheetIndex($sheet)
								->setCellValue($arrData[$yy].'1', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($grupo).')');
								$yy++;
								$yy++;
								$yy++;
								$yy++;
				//Si no se ven detalles
				}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
					$spreadsheet->setActiveSheetIndex($sheet)
								->setCellValue($arrData[$yy].'1', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($grupo).')');
								$yy++;
				}
			}
		}else{
			//Si se ven detalles
			if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
				$spreadsheet->setActiveSheetIndex($sheet)
							->setCellValue($arrData[$yy].'1', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($grupo).')');
							$yy++;
							$yy++;
							$yy++;
							$yy++;
			//Si no se ven detalles
			}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
				$spreadsheet->setActiveSheetIndex($sheet)
							->setCellValue($arrData[$yy].'1', DeSanitizar($arrTemporal[0]['SensorNombre_'.$i]).' ('.DeSanitizar($grupo).')');
							$yy++;
			}
		}
	}

	/***********************************************************/
	//Titulo columnas
	$spreadsheet->setActiveSheetIndex($sheet)
				->setCellValue('A2', 'Equipo')
				->setCellValue('B2', 'Fecha');

	$yy = 1;
	for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
		if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
			if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
				//Si se ven detalles
				if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
					$yy1 = $yy;
					$yy2 = $yy + 1;
					$yy3 = $yy + 2;
					$yy4 = $yy + 3;
					$spreadsheet->setActiveSheetIndex($sheet)
								->setCellValue($arrData[$yy1].'2', 'Promedio' )
								->setCellValue($arrData[$yy2].'2', 'Maximo' )
								->setCellValue($arrData[$yy3].'2', 'Minimo' )
								->setCellValue($arrData[$yy4].'2', 'Dev. Std.' );
								$yy++;
								$yy++;
								$yy++;
								$yy++;
				//Si no se ven detalles
				}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
					$spreadsheet->setActiveSheetIndex($sheet)
								->setCellValue($arrData[$yy].'2', 'Promedio');
								$yy++;
				}
			}
		}else{
			//Si se ven detalles
			if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
				$yy1 = $yy;
				$yy2 = $yy + 1;
				$yy3 = $yy + 2;
				$yy4 = $yy + 3;
				$spreadsheet->setActiveSheetIndex($sheet)
							->setCellValue($arrData[$yy1].'2', 'Promedio' )
							->setCellValue($arrData[$yy2].'2', 'Maximo' )
							->setCellValue($arrData[$yy3].'2', 'Minimo' )
							->setCellValue($arrData[$yy4].'2', 'Dev. Std.' );
							$yy++;
							$yy++;
							$yy++;
							$yy++;
			//Si no se ven detalles
			}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
				$spreadsheet->setActiveSheetIndex($sheet)
							->setCellValue($arrData[$yy].'2', 'Promedio');
							$yy++;
			}
		}
	}

	/***********************************************************/
	//Datos
	$nn=3;
	foreach ($arrTemporal as $rutas) {
		//Verifico la existencia de datos
		$cuenta_xx = 0;
		/*for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
			if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
				if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
					if(isset($rutas['MedMax_'.$i])&&$rutas['MedMax_'.$i]<99900){
						//nada
					}else{
						$cuenta_xx++;
					}
				}
			}
		}	*/
		//Si no existen datos imprimo
		if($cuenta_xx==0){

			$spreadsheet->setActiveSheetIndex($sheet)
						->setCellValue('A'.$nn, DeSanitizar($equipo['NombreEquipo']))
						->setCellValue('B'.$nn, fecha_estandar($rutas['FechaSistema']));
			$yy = 1;
			for ($i = 1; $i <= $equipo['cantSensores']; $i++) {
				if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){
					if($arrTemporal[0]['SensoresGrupo_'.$i]==$_GET['idGrupo']){
						//Si se ven detalles
						if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
							$yy1 = $yy;
							$yy2 = $yy + 1;
							$yy3 = $yy + 2;
							$yy4 = $yy + 3;
							$spreadsheet->setActiveSheetIndex($sheet)
										->setCellValue($arrData[$yy1].$nn, Cantidades($rutas['MedProm_'.$i], 2) )
										->setCellValue($arrData[$yy2].$nn, Cantidades($rutas['MedMax_'.$i], 2) )
										->setCellValue($arrData[$yy3].$nn, Cantidades($rutas['MedMin_'.$i], 2) )
										->setCellValue($arrData[$yy4].$nn, Cantidades($rutas['MedDesStan_'.$i], 2) );
										$yy++;
										$yy++;
										$yy++;
										$yy++;

						//Si no se ven detalles
						}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
							$spreadsheet->setActiveSheetIndex($sheet)
										->setCellValue($arrData[$yy].$nn, Cantidades($rutas['MedProm_'.$i], 2));
										$yy++;
						}
					}
				}else{
					//Si se ven detalles
					if(isset($_GET['idDetalle'])&&$_GET['idDetalle']==1){
						$yy1 = $yy;
						$yy2 = $yy + 1;
						$yy3 = $yy + 2;
						$yy4 = $yy + 3;
						$spreadsheet->setActiveSheetIndex($sheet)
									->setCellValue($arrData[$yy1].$nn, Cantidades($rutas['MedProm_'.$i], 2) )
									->setCellValue($arrData[$yy2].$nn, Cantidades($rutas['MedMax_'.$i], 2) )
									->setCellValue($arrData[$yy3].$nn, Cantidades($rutas['MedMin_'.$i], 2) )
									->setCellValue($arrData[$yy4].$nn, Cantidades($rutas['MedDesStan_'.$i], 2) );
									$yy++;
									$yy++;
									$yy++;
									$yy++;
					//Si no se ven detalles
					}elseif(isset($_GET['idDetalle'])&&$_GET['idDetalle']==2){
						$spreadsheet->setActiveSheetIndex($sheet)
									->setCellValue($arrData[$yy].$nn, Cantidades($rutas['MedProm_'.$i], 2));
									$yy++;
					}
				}
			}
		}

		$nn++;

	}

	/***********************************************************/
	// Rename worksheet
	$super_titulo = 'Hoja 1';
	if(isset($equipo['NombreEquipo'])&&$equipo['NombreEquipo']!=''){
		$super_titulo = cortar(DeSanitizar($equipo['NombreEquipo']), 25);
	}
	$spreadsheet->getActiveSheet($sheet)->setTitle($super_titulo);

	$sheet++;
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Max - Min Camara';
// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.DeSanitizar($filename).'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
exit;
