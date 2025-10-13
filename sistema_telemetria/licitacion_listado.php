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
$original = "licitacion_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){ $location .= "&idCliente=".$_GET['idCliente'];       $search .= "&idCliente=".$_GET['idCliente'];}
if(isset($_GET['Codigo']) && $_GET['Codigo']!=''){       $location .= "&Codigo=".$_GET['Codigo'];             $search .= "&Codigo=".$_GET['Codigo'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){       $location .= "&Nombre=".$_GET['Nombre'];             $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['FechaInicio']) && $_GET['FechaInicio']!=''){    $location .= "&FechaInicio=".$_GET['FechaInicio'];   $search .= "&FechaInicio=".$_GET['FechaInicio'];}
if(isset($_GET['FechaTermino']) && $_GET['FechaTermino']!=''){  $location .= "&FechaTermino=".$_GET['FechaTermino']; $search .= "&FechaTermino=".$_GET['FechaTermino'];}
if(isset($_GET['Presupuesto']) && $_GET['Presupuesto']!=''){    $location .= "&Presupuesto=".$_GET['Presupuesto'];   $search .= "&Presupuesto=".$_GET['Presupuesto'];}
if(isset($_GET['idBodegaProd']) && $_GET['idBodegaProd']!=''){  $location .= "&idBodegaProd=".$_GET['idBodegaProd']; $search .= "&idBodegaProd=".$_GET['idBodegaProd'];}
if(isset($_GET['idBodegaIns']) && $_GET['idBodegaIns']!=''){    $location .= "&idBodegaIns=".$_GET['idBodegaIns'];   $search .= "&idBodegaIns=".$_GET['idBodegaIns'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){   $location .= "&idEstado=".$_GET['idEstado'];         $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idAprobado']) && $_GET['idAprobado']!=''){      $location .= "&idAprobado=".$_GET['idAprobado'];     $search .= "&idAprobado=".$_GET['idAprobado'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/

//------------------------------------- Licitacion -------------------------------------//
//formulario para crear
if (!empty($_POST['submit_Licitacion'])){
	//Llamamos al formulario
	$form_trabajo= 'createBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'delBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_licitacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Contrato Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Contrato Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Contrato Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/*******************************************/
	//se traen los datos basicos de la licitacion
	$SIS_query = '
	licitacion_listado.Codigo,
	licitacion_listado.Nombre,
	licitacion_listado.FechaInicio,
	licitacion_listado.FechaTermino,
	licitacion_listado.Presupuesto,
	licitacion_listado.ValorMensual,
	licitacion_listado.idTipoLicitacion,
	licitacion_listado.idOpcionItem,
	licitacion_listado.idCliente,
	core_estado_aprobacion.Nombre AS EstadoAprobacion,
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
	$SIS_where = 'licitacion_listado.idLicitacion='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'licitacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

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
	$SIS_where = 'licitacion_listado_historial.idLicitacion ='.$_GET['id'];
	$SIS_order = 'licitacion_listado_historial.idHistorial ASC';
	$arrHistorial = array();
	$arrHistorial = db_select_array (false, $SIS_query, 'licitacion_listado_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrHistorial');

	/***********************************************************************************/
	//Se verifica que se utilice el itemizado
	if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){
		//Se crean las variables
		$nmax = 15;
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
		$SIS_where = 'licitacion_listado_level_1.idLicitacion='.$_GET['id'];
		$arrLicitacion = array();
		$arrLicitacion = db_select_array (false, $SIS_query, 'licitacion_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrLicitacion');


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

		function arrayToUL(array $array, $lv, $rowlevel,$location, $nmax){
			$lv++;
			if($lv==1){
				echo '<ul class="tree">';
			}else{
				echo '<ul style="padding-left: 20px;">';
			}

			foreach ($array as $key => $value){
				//Rearmo la ubicacion de acuerdo a la profundidad
				if (isset($value['id'])){
					$loc = $location.'&lv_'.$lv.'='.$value['id'];
				}else{
					$loc = $location;
				}

				if (isset($value['Nombre'])){
					echo '<li><div class="blum">';
					echo '<div class="pull-left">'.$value['Codigo'].' - '.$value['Nombre'].'</div>';
					echo '<div class="clearfix"></div>';
					echo '</div>';
				}
				if (!empty($value) && is_array($value)){

					echo arrayToUL($value, $lv, $rowlevel,$loc, $nmax);
				}
				echo '</li>';
			}
			echo '</ul>';
		}

	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Contrato', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'licitacion_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'licitacion_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'licitacion_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<?php if(isset($rowData['idOpcionItem'])&&$rowData['idOpcionItem']==1){ ?>
								<li class=""><a href="<?php echo 'licitacion_listado_itemizado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sitemap" aria-hidden="true"></i> Itemizado</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'licitacion_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'licitacion_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>
						</ul>
					</li>
				</ul>
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
									<td><?php echo $rowData['EstadoAprobacion']; ?></td>
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
											echo arrayToUL($array3d, 0, $rowlevel['level'],$location, $nmax);
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

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
	//se crea filtro
	//verifico que sea un administrador
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
	$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Contrato</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){             $x1  = $idCliente;           }else{$x1  = '';}
					if(isset($Codigo)){                $x2  = $Codigo;              }else{$x2  = '';}
					if(isset($Nombre)){                $x3  = $Nombre;              }else{$x3  = '';}
					if(isset($FechaInicio)){           $x4  = $FechaInicio;         }else{$x4  = '';}
					if(isset($FechaTermino)){          $x5  = $FechaTermino;        }else{$x5  = '';}
					if(isset($idTipoLicitacion)){      $x6  = $idTipoLicitacion;    }else{$x6  = '';}
					if(isset($ValorMensual)){          $x7  = $ValorMensual;        }else{$x7  = '';}
					if(isset($Presupuesto)){           $x8  = $Presupuesto;         }else{$x8  = '';}
					if(isset($idBodegaProd)){          $x9  = $idBodegaProd;        }else{$x9  = '';}
					if(isset($idBodegaIns)){           $x10 = $idBodegaIns;         }else{$x10 = '';}
					if(isset($idOpcionItem)){          $x11 = $idOpcionItem;        }else{$x11 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x3, 2);
					$Form_Inputs->form_date('Fecha de Inicio Contrato','FechaInicio', $x4, 1);
					$Form_Inputs->form_date('Fecha de Termino Contrato','FechaTermino', $x5, 1);
					$Form_Inputs->form_select('Tipo Contrato','idTipoLicitacion', $x6, 2, 'idTipoLicitacion', 'Nombre', 'core_licitacion_tipos', 0, '', $dbConn);
					$Form_Inputs->form_values('Valor Fijo Mensual', 'ValorMensual', $x7, 1);
					$Form_Inputs->form_values('Presupuesto', 'Presupuesto', $x8, 1);
					$Form_Inputs->form_select('Bodega Productos','idBodegaProd', $x9, 2, 'idBodega', 'Nombre', 'bodegas_productos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Bodega Insumos','idBodegaIns', $x10, 2, 'idBodega', 'Nombre', 'bodegas_insumos_listado', $z, '', $dbConn);
					$Form_Inputs->form_select('Utilizar Itemizado','idOpcionItem', $x11, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idAprobado', 2, 2);

					?>

					<script>
						document.getElementById('div_ValorMensual').style.display = 'none';
						document.getElementById('div_Presupuesto').style.display = 'none';

						$("#idTipoLicitacion").on("change", function(){ //se ejecuta al cambiar valor del select
							let modelSelected1 = $(this).val(); //Asignamos el valor seleccionado

							//si es A suma Alzada
							if(modelSelected1 == 1){
								document.getElementById('div_ValorMensual').style.display = '';
								document.getElementById('div_Presupuesto').style.display = 'none';
								//Reseteo los valores a 0
								document.querySelector('input[name="Presupuesto"]').value = '0';

							//si es Por Itemizado
							} else if(modelSelected1 == 2){
								document.getElementById('div_ValorMensual').style.display = 'none';
								document.getElementById('div_Presupuesto').style.display = '';
								//Reseteo los valores a 0
								document.querySelector('input[name="ValorMensual"]').value = '0;

							}
						});

					</script>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_Licitacion">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>

			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'cliente_asc':   $order_by = 'clientes_listado.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente Ascendente'; break;
			case 'cliente_desc':  $order_by = 'clientes_listado.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Cliente Descendente';break;
			case 'codigo_asc':    $order_by = 'licitacion_listado.Codigo ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Codigo Ascendente'; break;
			case 'codigo_desc':   $order_by = 'licitacion_listado.Codigo DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Codigo Descendente';break;
			case 'nombre_asc':    $order_by = 'licitacion_listado.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':   $order_by = 'licitacion_listado.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
			case 'aprobado_asc':  $order_by = 'core_estado_aprobacion.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Aprobacion Ascendente';break;
			case 'aprobado_desc': $order_by = 'core_estado_aprobacion.Nombre DESC ';$bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Aprobacion Descendente';break;

			default: $order_by = 'clientes_listado.Nombre ASC, licitacion_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente, Contrato Ascendente';
		}
	}else{
		$order_by = 'clientes_listado.Nombre ASC, licitacion_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente, Contrato Ascendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where = "licitacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){       $SIS_where .= " AND licitacion_listado.idCliente=".$_GET['idCliente'];}
	if(isset($_GET['Codigo']) && $_GET['Codigo']!=''){             $SIS_where .= " AND licitacion_listado.Codigo LIKE '%".EstandarizarInput($_GET['Codigo'])."%'";}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){             $SIS_where .= " AND licitacion_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['FechaInicio']) && $_GET['FechaInicio']!=''){   $SIS_where .= " AND licitacion_listado.FechaInicio='".$_GET['FechaInicio']."'";}
	if(isset($_GET['FechaTermino']) && $_GET['FechaTermino']!=''){ $SIS_where .= " AND licitacion_listado.FechaTermino='".$_GET['FechaTermino']."'";}
	if(isset($_GET['Presupuesto']) && $_GET['Presupuesto']!=''){   $SIS_where .= " AND licitacion_listado.Presupuesto LIKE '%".EstandarizarInput($_GET['Presupuesto'])."%'";}
	if(isset($_GET['idBodegaProd']) && $_GET['idBodegaProd']!=''){ $SIS_where .= " AND licitacion_listado.idBodegaProd=".$_GET['idBodegaProd'];}
	if(isset($_GET['idBodegaIns']) && $_GET['idBodegaIns']!=''){   $SIS_where .= " AND licitacion_listado.idBodegaIns=".$_GET['idBodegaIns'];}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){         $SIS_where .= " AND licitacion_listado.idEstado=".$_GET['idEstado'];}
	if(isset($_GET['idAprobado']) && $_GET['idAprobado']!=''){     $SIS_where .= " AND licitacion_listado.idAprobado=".$_GET['idAprobado'];}
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idLicitacion', 'licitacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	licitacion_listado.idLicitacion,
	licitacion_listado.Codigo,
	licitacion_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	licitacion_listado.idSistema,
	core_estados.Nombre AS Estado,
	core_estado_aprobacion.Nombre AS EstadoAprobacion,
	clientes_listado.Nombre AS Cliente,
	licitacion_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema          = licitacion_listado.idSistema
	LEFT JOIN `clientes_listado`        ON clientes_listado.idCliente       = licitacion_listado.idCliente
	LEFT JOIN `core_estados`            ON core_estados.idEstado            = licitacion_listado.idEstado
	LEFT JOIN `core_estado_aprobacion`  ON core_estado_aprobacion.idEstado  = licitacion_listado.idAprobado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrArea = array();
	$arrArea = db_select_array (false, $SIS_query, 'licitacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArea');

	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Contrato</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($idCliente)){             $x0  = $idCliente;           }else{$x0  = '';}
					if(isset($Codigo)){                $x1  = $Codigo;              }else{$x1  = '';}
					if(isset($Nombre)){                $x2  = $Nombre;              }else{$x2  = '';}
					if(isset($FechaInicio)){           $x3  = $FechaInicio;         }else{$x3  = '';}
					if(isset($FechaTermino)){          $x4  = $FechaTermino;        }else{$x4  = '';}
					if(isset($Presupuesto)){           $x5  = $Presupuesto;         }else{$x5  = '';}
					if(isset($idBodegaProd)){          $x6  = $idBodegaProd;        }else{$x6  = '';}
					if(isset($idBodegaIns)){           $x7  = $idBodegaIns;         }else{$x7  = '';}
					if(isset($idEstado)){              $x8  = $idEstado;            }else{$x8  = '';}
					if(isset($idAprobado)){            $x9  = $idAprobado;          }else{$x9  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x0, 1, 'idCliente', 'Nombre', 'clientes_listado', $w, '', $dbConn);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x1, 1);
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x2, 1);
					$Form_Inputs->form_date('Fecha de Inicio Contrato','FechaInicio', $x3, 1);
					$Form_Inputs->form_date('Fecha de Termino Contrato','FechaTermino', $x4, 1);
					$Form_Inputs->form_values('Presupuesto', 'Presupuesto', $x5, 1);
					$Form_Inputs->form_select('Bodega Productos','idBodegaProd', $x6, 1, 'idBodega', 'Nombre', 'bodegas_productos_listado', $w, '', $dbConn);
					$Form_Inputs->form_select('Bodega Insumos','idBodegaIns', $x7, 1, 'idBodega', 'Nombre', 'bodegas_insumos_listado', $w, '', $dbConn);
					$Form_Inputs->form_select('Estado','idEstado', $x8, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado Aprobacion','idAprobado', $x9, 1, 'idEstado', 'Nombre', 'core_estado_aprobacion', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Contratos</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Cliente</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=cliente_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=cliente_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="160">
								<div class="pull-left">Codigo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=codigo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=codigo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado Aprobacion</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=aprobado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=aprobado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrArea as $area) { ?>
						<tr class="odd">
							<td><?php echo $area['Cliente']; ?></td>
							<td><?php echo $area['Codigo']; ?></td>
							<td><?php echo $area['Nombre']; ?></td>
							<td><label class="label <?php if(isset($area['idEstado'])&&$area['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $area['Estado']; ?></label></td>
							<td><?php echo $area['EstadoAprobacion']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $area['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_licitacion.php?view='.simpleEncode($area['idLicitacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$area['idLicitacion']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($area['idLicitacion'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro '.$area['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
