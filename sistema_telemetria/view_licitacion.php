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
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
//se traen los datos basicos de la licitacion
$SIS_query = '
licitacion_listado.Codigo, 
licitacion_listado.Nombre,
licitacion_listado.FechaInicio, 
licitacion_listado.FechaTermino, 
licitacion_listado.Presupuesto,
licitacion_listado.ValorMensual,
licitacion_listado.idCliente,
licitacion_listado.idTipoLicitacion,
licitacion_listado.idOpcionItem,
core_estado_aprobacion.Nombre AS Aprobacion,
core_estados.Nombre AS Estado,
bodegas_productos_listado.Nombre AS BodegaProductos,
bodegas_insumos_listado.Nombre AS BodegaInsumos,
clientes_listado.Nombre AS Cliente,
core_sistemas.Nombre AS Sistema,
core_licitacion_tipos.Nombre AS TipoLicitacion,
core_sistemas_opciones.Nombre AS OpcionItem';
$SIS_join  = '
LEFT JOIN `core_estado_aprobacion`       ON core_estado_aprobacion.idEstado          = licitacion_listado.idAprobado
LEFT JOIN `core_estados`                 ON core_estados.idEstado                    = licitacion_listado.idEstado
LEFT JOIN `bodegas_productos_listado`    ON bodegas_productos_listado.idBodega       = licitacion_listado.idBodegaProd
LEFT JOIN `bodegas_insumos_listado`      ON bodegas_insumos_listado.idBodega         = licitacion_listado.idBodegaIns
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente               = licitacion_listado.idCliente
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                  = licitacion_listado.idSistema
LEFT JOIN `core_licitacion_tipos`        ON core_licitacion_tipos.idTipoLicitacion   = licitacion_listado.idTipoLicitacion
LEFT JOIN `core_sistemas_opciones`       ON core_sistemas_opciones.idOpciones        = licitacion_listado.idOpcionItem';
$SIS_where = 'licitacion_listado.idLicitacion='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con el historial
$SIS_query = '
licitacion_listado_historial.Creacion_fecha, 
licitacion_listado_historial.Observacion,
core_historial_tipos.Nombre,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos`     ON core_historial_tipos.idTipo   = licitacion_listado_historial.idTipo
LEFT JOIN `usuarios_listado`         ON usuarios_listado.idUsuario    = licitacion_listado_historial.idUsuario';
$SIS_where = 'licitacion_listado_historial.idLicitacion ='.$X_Puntero;
$SIS_order = 'licitacion_listado_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'licitacion_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

/***********************************************************************************/
//Se verifica que se utilice el itemizado
if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){
	//Se crean las variables
	$nmax      = 15;
	$SIS_query = 'licitacion_listado_level_1.idLevel_1 AS bla';
	$SIS_join  = '';
	$SIS_order = 'licitacion_listado_level_1.Codigo ASC';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$SIS_query .= ',licitacion_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$SIS_query .= ',licitacion_listado_level_'.$i.'.Codigo AS LVL_'.$i.'_Codigo';
		$SIS_query .= ',licitacion_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$SIS_join .= ' LEFT JOIN `licitacion_listado_level_'.$xx.'`   ON licitacion_listado_level_'.$xx.'.idLevel_'.$i.'    = licitacion_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$SIS_order .= ', licitacion_listado_level_'.$i.'.Codigo ASC';
	}

	//se hace la consulta
	$SIS_where = 'licitacion_listado_level_1.idLicitacion='.$X_Puntero;
	$arrLicitacion = array();
	$arrLicitacion = db_select_array (false, $SIS_query, 'licitacion_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrLicitacion');

	$array3d = array();
	foreach($arrLicitacion as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {
			$d[$i]  = $key['LVL_'.$i.'_id'];   
			$n[$i]  = $key['LVL_'.$i.'_Nombre'];   
			$c[$i]  = $key['LVL_'.$i.'_Codigo'];
		}
		
		
		if( $d['1']!=''){
			$array3d[$d['1']]['id']     = $d['1'];
			$array3d[$d['1']]['Nombre'] = $n['1'];
			$array3d[$d['1']]['Codigo'] = $c['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']     = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre'] = $n['2'];
			$array3d[$d['1']][$d['2']]['Codigo'] = $c['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']     = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre'] = $n['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Codigo'] = $c['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']     = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre'] = $n['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Codigo'] = $c['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']     = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre'] = $n['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Codigo'] = $c['5'];
		}
		if( $d['6']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']     = $d['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre'] = $n['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Codigo'] = $c['6'];
		}
		if( $d['7']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']     = $d['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre'] = $n['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Codigo'] = $c['7'];
		}
		if( $d['8']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']     = $d['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre'] = $n['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Codigo'] = $c['8'];
		}
		if( $d['9']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']     = $d['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre'] = $n['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Codigo'] = $c['9'];
		}
		if( $d['10']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']     = $d['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre'] = $n['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Codigo'] = $c['10'];
		}
		if( $d['11']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']     = $d['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre'] = $n['11'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Codigo'] = $c['11'];
		}
		if( $d['12']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']     = $d['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre'] = $n['12'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Codigo'] = $c['12'];
		}
		if( $d['13']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']     = $d['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre'] = $n['13'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Codigo'] = $c['13'];
		}
		if( $d['14']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']     = $d['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre'] = $n['14'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Codigo'] = $c['14'];
		}
		if( $d['15']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']     = $d['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre'] = $n['15'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Codigo'] = $c['15'];
		}
		/*if( $d['16']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['id']     = $d['16'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Nombre'] = $n['16'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']]['Codigo'] = $c['16'];
		}
		if( $d['17']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['id']     = $d['17'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Nombre'] = $n['17'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']]['Codigo'] = $c['17'];
		}
		if( $d['18']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['id']     = $d['18'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Nombre'] = $n['18'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']]['Codigo'] = $c['18'];
		}
		if( $d['19']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['id']     = $d['19'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Nombre'] = $n['19'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']]['Codigo'] = $c['19'];
		}
		if( $d['20']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['id']     = $d['20'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Nombre'] = $n['20'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']]['Codigo'] = $c['20'];
		}
		if( $d['21']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['id']     = $d['21'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Nombre'] = $n['21'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']]['Codigo'] = $c['21'];
		}
		if( $d['22']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['id']     = $d['22'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Nombre'] = $n['22'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']]['Codigo'] = $c['22'];
		}
		if( $d['23']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['id']     = $d['23'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Nombre'] = $n['23'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']]['Codigo'] = $c['23'];
		}
		if( $d['24']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['id']     = $d['24'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Nombre'] = $n['24'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']]['Codigo'] = $c['24'];
		}
		if( $d['25']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['id']     = $d['25'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Nombre'] = $n['25'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']][$d['16']][$d['17']][$d['18']][$d['19']][$d['20']][$d['21']][$d['22']][$d['23']][$d['24']][$d['25']]['Codigo'] = $c['25'];
		}*/

	}

	function arrayToUL(array $array, $lv, $nmax){
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}
		foreach ($array as $key => $value){
			
			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
				echo '<div class="pull-left">'.$value['Codigo'].' - '.$value['Nombre'].'</div>';
				echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){

				echo arrayToUL($value, $lv, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos del Contrato</h5>
		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					<table id="dataTable" class="table table-bordered table-condensed dataTable">

						<tbody role="alert" aria-live="polite" aria-relevant="all">
		
							<tr class="odd">
								<td width="200">Codigo Contrato</td>
								<td><?php echo $rowData['Codigo']; ?></td>
							</tr>
							<tr class="odd">
								<td>Nombre Contrato</td>
								<td><?php echo $rowData['Nombre']; ?></td>
							</tr>
							<tr class="odd">
								<td>Sistema</td>
								<td><?php echo $rowData['Sistema']; ?></td>
							</tr>
							<?php if(isset($rowData['idCliente'])&&$rowData['idCliente']!=''){ ?>
								<tr class="odd">
									<td>Cliente</td>
									<td><?php echo $rowData['Cliente']; ?></td>
								</tr>
							<?php } ?>
							<tr class="odd">
								<td>Duracion</td>
								<td><?php echo 'Del '.Fecha_estandar($rowData['FechaInicio']).' al '.Fecha_estandar($rowData['FechaTermino']); ?></td>
							</tr>
							<tr class="odd">
								<td>Tipo de Contrato</td>
								<td><?php echo $rowData['TipoLicitacion']; ?></td>
							</tr>
							<?php if(isset($rowData['idTipoLicitacion'])&&$rowData['idTipoLicitacion']==1){ ?>
								<tr class="odd">
									<td>Valor Mensual</td>
									<td align="right"><?php echo Valores($rowData['ValorMensual'], 0); ?></td>
								</tr>
							<?php } ?>
							<?php if(isset($rowData['idTipoLicitacion'])&&$rowData['idTipoLicitacion']==2){ ?>
								<tr class="odd">
									<td>Presupuesto</td>
									<td align="right"><?php echo Valores($rowData['Presupuesto'], 0); ?></td>
								</tr>
							<?php } ?>
							<tr class="odd">
								<td>Estado</td>
								<td><?php echo $rowData['Estado']; ?></td>
							</tr>
							<tr class="odd">
								<td>Estado Aprobacion</td>
								<td><?php echo $rowData['Aprobacion']; ?></td>
							</tr>
							<tr class="odd">
								<td>Bodega Productos Utilizada</td>
								<td><?php echo $rowData['BodegaProductos']; ?></td>
							</tr>
							<tr class="odd">
								<td>Bodega Insumos Utilizada</td>
								<td><?php echo $rowData['BodegaInsumos']; ?></td>
							</tr>
							<?php if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){ ?>
								<tr>
									<td colspan="2" style="background-color: #ccc;">Itemizado</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="clearfix"></div>
										<?php //Se imprime el arbol
										echo arrayToUL($array3d, 0, $nmax);
										?>
									</td>
								</tr>
							<?php } ?>
							<?php if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==2){ ?>
								<tr>
									<td colspan="2" style="background-color: #ccc;">Itemizado</td>
								</tr>
								<tr class="odd">
									<td colspan="2">No utiliza Itemizado</td>
								</tr>
							<?php } ?>
				   
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

<?php } ?>
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
