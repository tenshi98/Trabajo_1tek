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
$original = "informe_gerencial_18.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';			       
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
/*************************************************************/
//se traen los datos basicos de la licitacion
$query = "SELECT 
licitacion_listado.idEstado,
licitacion_listado.idSistema,
licitacion_listado.Codigo,
licitacion_listado.Nombre,
licitacion_listado.FechaInicio, 
licitacion_listado.FechaTermino, 
core_estado_aprobacion.Nombre AS Estado,
bodegas_productos_listado.Nombre AS BodegaProductos,
bodegas_insumos_listado.Nombre AS BodegaInsumos,
clientes_listado.Nombre AS Cliente,
licitacion_listado.idCliente,
core_sistemas.Nombre AS Sistema

FROM `licitacion_listado`
LEFT JOIN `core_estado_aprobacion`       ON core_estado_aprobacion.idEstado      = licitacion_listado.idAprobado
LEFT JOIN `bodegas_productos_listado`    ON bodegas_productos_listado.idBodega   = licitacion_listado.idBodegaProd
LEFT JOIN `bodegas_insumos_listado`      ON bodegas_insumos_listado.idBodega     = licitacion_listado.idBodegaIns
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente           = licitacion_listado.idCliente
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema              = licitacion_listado.idSistema

WHERE licitacion_listado.idLicitacion=".$_GET['idLicitacion'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

/*************************************************************/
//Se crean las variables
$nmax = 15;
$z = '';
$leftjoin = '';
$orderby = '';
for ($i = 1; $i <= $nmax; $i++) {
    //consulta
    $z .= ',licitacion_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
    $z .= ',licitacion_listado_level_'.$i.'.Codigo AS LVL_'.$i.'_Codigo';
    $z .= ',licitacion_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
    $z .= ',licitacion_listado_level_'.$i.'.Cantidad AS LVL_'.$i.'_Cantidad';
    $z .= ',licitacion_listado_level_'.$i.'.Valor AS LVL_'.$i.'_Valor';
    $z .= ',licitacion_listado_level_'.$i.'.ValorTotal AS LVL_'.$i.'_ValorTotal';
    $z .= ',licitacion_listado_level_'.$i.'.idFrecuencia AS LVL_'.$i.'_idFrecuencia';

    //Joins
    $xx = $i + 1;
    if($xx<=$nmax){
		$leftjoin .= ' LEFT JOIN `licitacion_listado_level_'.$xx.'`   ON licitacion_listado_level_'.$xx.'.idLevel_'.$i.'    = licitacion_listado_level_'.$i.'.idLevel_'.$i;
	}
    //ORDER BY
    $orderby .= ', licitacion_listado_level_'.$i.'.Codigo ASC';
}

//se hace la consulta
$arrLicitacion = array();
$query = "SELECT
licitacion_listado_level_1.idLevel_1 AS bla
".$z."
FROM `licitacion_listado_level_1`
".$leftjoin."
WHERE licitacion_listado_level_1.idLicitacion=".$_GET['idLicitacion']."
ORDER BY licitacion_listado_level_1.Codigo ASC ".$orderby."

";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrLicitacion,$row );
}





$array3d = array();
foreach($arrLicitacion as $key) {

	//Creo Variables para la rejilla
	for ($i = 1; $i <= $nmax; $i++) {
		$d[$i]  = $key['LVL_'.$i.'_id'];
		$n[$i]  = $key['LVL_'.$i.'_Nombre'];
		$c[$i]  = $key['LVL_'.$i.'_Codigo'];
		$x[$i]  = $key['LVL_'.$i.'_Cantidad'];
		$s[$i]  = $key['LVL_'.$i.'_Valor'];
		$v[$i]  = $key['LVL_'.$i.'_ValorTotal'];
		$u[$i]  = $key['LVL_'.$i.'_idFrecuencia'];
	}

    if( $d['1']!=''){
		$array3d[$d['1']]['lvl']          = 1;
		$array3d[$d['1']]['id']           = $d['1'];
		$array3d[$d['1']]['Nombre']       = $n['1'];
		$array3d[$d['1']]['Codigo']       = $c['1'];
		$array3d[$d['1']]['Cantidad']     = $x['1'];
		$array3d[$d['1']]['Valor']        = $s['1'];
		$array3d[$d['1']]['ValorTotal']   = $v['1'];
		$array3d[$d['1']]['idFrecuencia'] = $u['1'];
	}
	if( $d['2']!=''){
		$array3d[$d['1']][$d['2']]['lvl']          = 2;
		$array3d[$d['1']][$d['2']]['id']           = $d['2'];
		$array3d[$d['1']][$d['2']]['Nombre']       = $n['2'];
		$array3d[$d['1']][$d['2']]['Codigo']       = $c['2'];
		$array3d[$d['1']][$d['2']]['Cantidad']     = $x['2'];
		$array3d[$d['1']][$d['2']]['Valor']        = $s['2'];
		$array3d[$d['1']][$d['2']]['ValorTotal']   = $v['2'];
		$array3d[$d['1']][$d['2']]['idFrecuencia'] = $u['2'];
	}
	if( $d['3']!=''){
		$array3d[$d['1']][$d['2']][$d['3']]['lvl']          = 3;
		$array3d[$d['1']][$d['2']][$d['3']]['id']           = $d['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Nombre']       = $n['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Codigo']       = $c['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Cantidad']     = $x['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['Valor']        = $s['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['ValorTotal']   = $v['3'];
		$array3d[$d['1']][$d['2']][$d['3']]['idFrecuencia'] = $u['3'];
	}
	if( $d['4']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['lvl']          = 4;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']           = $d['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre']       = $n['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Codigo']       = $c['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Cantidad']     = $x['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Valor']        = $s['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['ValorTotal']   = $v['4'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['idFrecuencia'] = $u['4'];
	}
	if( $d['5']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['lvl']          = 5;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']           = $d['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre']       = $n['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Codigo']       = $c['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Cantidad']     = $x['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Valor']        = $s['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['ValorTotal']   = $v['5'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['idFrecuencia'] = $u['5'];
	}
	if( $d['6']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['lvl']          = 6;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']           = $d['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre']       = $n['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Codigo']       = $c['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Cantidad']     = $x['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Valor']        = $s['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['ValorTotal']   = $v['6'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['idFrecuencia'] = $u['6'];
	}
	if( $d['7']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['lvl']          = 7;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']           = $d['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre']       = $n['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Codigo']       = $c['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Cantidad']     = $x['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Valor']        = $s['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['ValorTotal']   = $v['7'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['idFrecuencia'] = $u['7'];
	}
	if( $d['8']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['lvl']          = 8;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']           = $d['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre']       = $n['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Codigo']       = $c['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Cantidad']     = $x['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Valor']        = $s['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['ValorTotal']   = $v['8'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['idFrecuencia'] = $u['8'];
	}
	if( $d['9']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['lvl']          = 9;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']           = $d['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre']       = $n['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Codigo']       = $c['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Cantidad']     = $x['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Valor']        = $s['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['ValorTotal']   = $v['9'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['idFrecuencia'] = $u['9'];
	}
	if( $d['10']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['lvl']          = 10;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']           = $d['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre']       = $n['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Codigo']       = $c['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Cantidad']     = $x['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Valor']        = $s['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['ValorTotal']   = $v['10'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['idFrecuencia'] = $u['10'];
	}
	if( $d['11']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['lvl']          = 11;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['id']           = $d['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Nombre']       = $n['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Codigo']       = $c['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Cantidad']     = $x['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['Valor']        = $s['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['ValorTotal']   = $v['11'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']]['idFrecuencia'] = $u['11'];
	}
	if( $d['12']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['lvl']          = 12;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['id']           = $d['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Nombre']       = $n['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Codigo']       = $c['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Cantidad']     = $x['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['Valor']        = $s['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['ValorTotal']   = $v['12'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']]['idFrecuencia'] = $u['12'];
	}
	if( $d['13']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['lvl']          = 13;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['id']           = $d['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Nombre']       = $n['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Codigo']       = $c['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Cantidad']     = $x['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['Valor']        = $s['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['ValorTotal']   = $v['13'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']]['idFrecuencia'] = $u['13'];
	}
	if( $d['14']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['lvl']          = 14;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['id']           = $d['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Nombre']       = $n['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Codigo']       = $c['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Cantidad']     = $x['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['Valor']        = $s['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['ValorTotal']   = $v['14'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']]['idFrecuencia'] = $u['14'];
	}
	if( $d['15']!=''){
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['lvl']          = 15;
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['id']           = $d['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Nombre']       = $n['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Codigo']       = $c['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Cantidad']     = $x['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['Valor']        = $s['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['ValorTotal']   = $v['15'];
		$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']][$d['11']][$d['12']][$d['13']][$d['14']][$d['15']]['idFrecuencia'] = $u['15'];
	}
	
	
	
}

/*************************************************************/
//se consulta
$arrUML = array();
$query = "SELECT idFrecuencia, Nombre
FROM `core_tiempo_frecuencia`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrUML,$row );
}
$UML = array();
foreach ($arrUML as $unidad){
	$UML[$unidad['idFrecuencia']]['Nombre'] = $unidad['Nombre'];
}



/*************************************************************/
//se consulta
$arrOTRealizadas = array();
$query = "SELECT 
COUNT(idTrabajoOT) AS Cuenta, 
item_tabla, 
item_tabla_id

FROM `orden_trabajo_listado_trabajos`
WHERE orden_trabajo_listado_trabajos.idLicitacion=".$_GET['idLicitacion']." 
GROUP BY item_tabla,item_tabla_id
ORDER BY item_tabla ASC, item_tabla_id ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOTRealizadas,$row );
}	
$OTRealizadas = array();
foreach ($arrOTRealizadas as $ot){
	$OTRealizadas[$ot['item_tabla']][$ot['item_tabla_id']]['Cuenta']   = $ot['Cuenta'];
}

/*************************************************************/
//se consulta
$arrFlujo = array();
$query = "SELECT 
COUNT(orden_trabajo_listado_trabajos.idTrabajoOT) AS Cuenta, 
orden_trabajo_listado_trabajos.item_tabla, 
orden_trabajo_listado_trabajos.item_tabla_id,
orden_trabajo_listado.terMes AS MesTermino,
orden_trabajo_listado.terAno AS AnoTermino

FROM `orden_trabajo_listado_trabajos`
LEFT JOIN `orden_trabajo_listado` ON orden_trabajo_listado.idOT = orden_trabajo_listado_trabajos.idOT
WHERE orden_trabajo_listado_trabajos.idLicitacion=".$_GET['idLicitacion']." 
GROUP BY orden_trabajo_listado.terAno,
orden_trabajo_listado.terMes,
orden_trabajo_listado_trabajos.item_tabla,
orden_trabajo_listado_trabajos.item_tabla_id

ORDER BY orden_trabajo_listado.terAno ASC,
orden_trabajo_listado.terMes ASC,
orden_trabajo_listado_trabajos.item_tabla ASC, 
orden_trabajo_listado_trabajos.item_tabla_id ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrFlujo,$row );
}
//otras variables
$ano_min = ano_actual();
$ano_max = ano_actual();
$mes_min = mes_actual();
$mes_max = mes_actual();

//arreglo	
$FlujoMensual = array();
foreach ($arrFlujo as $ot){
	$FlujoMensual[$ot['item_tabla']][$ot['item_tabla_id']][$ot['AnoTermino']][$ot['MesTermino']]['Cuenta']   = $ot['Cuenta'];	
	//valido mes y año minimo
	if(isset($ot['AnoTermino'])&&$ot['AnoTermino']!=0&&$ot['AnoTermino']<$ano_min){$ano_min = $ot['AnoTermino'];}
	if(isset($ot['MesTermino'])&&$ot['MesTermino']!=0&&$ot['MesTermino']<$mes_min){$mes_min = $ot['MesTermino'];}
}
/*************************************************************/
//se consulta
$arrCompProd = array();
$query = "SELECT 
productos_listado.Nombre AS Producto,
bodegas_productos_facturacion_existencias.idProducto,
bodegas_productos_facturacion_existencias.Creacion_ano,
bodegas_productos_facturacion_existencias.Creacion_mes,
SUM(bodegas_productos_facturacion_existencias.ValorTotal) AS Total

FROM `bodegas_productos_facturacion_existencias` 
LEFT JOIN `productos_listado`     ON productos_listado.idProducto  = bodegas_productos_facturacion_existencias.idProducto 
LEFT JOIN `orden_trabajo_listado` ON orden_trabajo_listado.idOT    = bodegas_productos_facturacion_existencias.idOT 

WHERE orden_trabajo_listado.idLicitacion=".$_GET['idLicitacion']." 

GROUP BY bodegas_productos_facturacion_existencias.Creacion_ano,
bodegas_productos_facturacion_existencias.Creacion_mes,
bodegas_productos_facturacion_existencias.idProducto

ORDER BY bodegas_productos_facturacion_existencias.Creacion_ano ASC,
bodegas_productos_facturacion_existencias.Creacion_mes ASC
";

//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCompProd,$row );
}
//arreglo	
$CompProd = array();
foreach ($arrCompProd as $ot){
	$CompProd[$ot['idProducto']]['Nombre']                                            = $ot['Producto'];
	$CompProd[$ot['idProducto']][$ot['Creacion_ano']][$ot['Creacion_mes']]['Total']   = $ot['Total'];		

}
/*************************************************************/
//se consulta
$arrCompIns = array();
$query = "SELECT 
insumos_listado.Nombre AS Producto,
bodegas_insumos_facturacion_existencias.idProducto,
bodegas_insumos_facturacion_existencias.Creacion_ano,
bodegas_insumos_facturacion_existencias.Creacion_mes,
SUM(bodegas_insumos_facturacion_existencias.ValorTotal) AS Total

FROM `bodegas_insumos_facturacion_existencias` 
LEFT JOIN `insumos_listado`       ON insumos_listado.idProducto    = bodegas_insumos_facturacion_existencias.idProducto  
LEFT JOIN `orden_trabajo_listado` ON orden_trabajo_listado.idOT    = bodegas_insumos_facturacion_existencias.idOT 

WHERE orden_trabajo_listado.idLicitacion=".$_GET['idLicitacion']." 

GROUP BY bodegas_insumos_facturacion_existencias.Creacion_ano,
bodegas_insumos_facturacion_existencias.Creacion_mes,
bodegas_insumos_facturacion_existencias.idProducto

ORDER BY bodegas_insumos_facturacion_existencias.Creacion_ano ASC,
bodegas_insumos_facturacion_existencias.Creacion_mes ASC
";

//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCompIns,$row );
}
//arreglo	
$CompIns = array();
foreach ($arrCompIns as $ot){
	$CompIns[$ot['idProducto']]['Nombre']                                            = $ot['Producto'];
	$CompIns[$ot['idProducto']][$ot['Creacion_ano']][$ot['Creacion_mes']]['Total']   = $ot['Total'];		
}

/*************************************************************/
//variable
$CompCliente = array();
//se consulta solo si esta configurado el cliente
if(isset($rowData['idCliente'])&&$rowData['idCliente']!=''&&$rowData['idCliente']!=0){
	$arrFacCliente = array();
	$query = "SELECT 
	sistema_documentos_pago.Nombre AS Documento,
	pagos_facturas_clientes.idDocPago ,
	bodegas_servicios_facturacion.Creacion_ano,
	bodegas_servicios_facturacion.Creacion_mes,
	SUM(pagos_facturas_clientes.MontoPagado) AS Total

	FROM `bodegas_servicios_facturacion` 
	LEFT JOIN `pagos_facturas_clientes` ON pagos_facturas_clientes.idFacturacion  = bodegas_servicios_facturacion.idFacturacion 
	LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago      = pagos_facturas_clientes.idDocPago 
	
	WHERE bodegas_servicios_facturacion.idTipo=2 
	AND pagos_facturas_clientes.idTipo=3 
	AND bodegas_servicios_facturacion.idCliente=".$rowData['idCliente']." 
	AND bodegas_servicios_facturacion.Creacion_ano BETWEEN '".$ano_min."' AND '".$ano_max."'

	GROUP BY bodegas_servicios_facturacion.Creacion_ano,
	bodegas_servicios_facturacion.Creacion_mes,
	pagos_facturas_clientes.idDocPago

	ORDER BY bodegas_servicios_facturacion.Creacion_ano ASC,
	bodegas_servicios_facturacion.Creacion_mes ASC,
	pagos_facturas_clientes.idDocPago ASC
	";

	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrFacCliente,$row );
	}
	//arreglo	
	foreach ($arrFacCliente as $ot){
		$CompCliente[$ot['idDocPago']]['Nombre']                                            = $ot['Documento'];
		$CompCliente[$ot['idDocPago']][$ot['Creacion_ano']][$ot['Creacion_mes']]['Total']   = $ot['Total'];
	}
}




/*************************************************************************************************/
function arrayToUL(array $array, array $OTRealizadas, array $UML, $nmax){

    foreach ($array as $key => $value){
		
	
        if (isset($value['Nombre'])){
			echo '<tr>';
				//agrego los espacios a la izquierda
				for ($zxi = 1; $zxi < $value['lvl']; $zxi++) {
					echo '<td></td>';
				}
				$cols = $nmax-$zxi+1;
				echo '<td colspan="'.$cols.'">'.$value['Codigo'].' - '.$value['Nombre'].'</td>';
				if($value['Cantidad']!=0){echo '<td align="right">'.$value['Cantidad'].'</td>';               }else{echo '<td></td>';}
				if($value['Valor']!=0){  echo '<td align="right">'.valores($value['Valor'], 0).'</td>';      }else{echo '<td></td>';}
				if($value['ValorTotal']!=0){echo '<td align="right">'.valores($value['ValorTotal'], 0).'</td>';}else{echo '<td></td>';}

				if(isset($OTRealizadas[$value['lvl']][$value['id']]['Cuenta'])&&$OTRealizadas[$value['lvl']][$value['id']]['Cuenta']!=0){
					echo '<td align="right">'.$OTRealizadas[$value['lvl']][$value['id']]['Cuenta'].'</td>';
					if($value['Valor']!=0){
						//Se hacen calculos
						$total = $value['Valor']*$OTRealizadas[$value['lvl']][$value['id']]['Cuenta'];
						$porcentaje = ($total*100)/$value['ValorTotal'];
						//Se escriben los resultados
						echo '<td align="right">'.valores($value['Valor'], 0).'</td>'; 
						echo '<td align="right">'.valores($total, 0).'</td>'; 
						echo '<td align="right">'.Cantidades($porcentaje, 2).' %</td>';     
					}else{
						echo '<td></td>';
						echo '<td></td>';
						echo '<td></td>';
					}

				}else{
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
					echo '<td></td>';
				}
				
			echo '</tr>';
		
		

			
		
		}
        if (!empty($value) && is_array($value)){	
            echo arrayToUL($value, $OTRealizadas, $UML, $nmax);
		}
        
    }

}	


function arrayFlujo(array $array, array $FlujoMensual, array $UML, $nmax, $ano_min, $ano_max, $mes_min, $mes_max){

    foreach ($array as $key => $value){
		
	
        if (isset($value['Nombre'])){
			echo '<tr>';
				//agrego los espacios a la izquierda
				for ($zxi = 1; $zxi < $value['lvl']; $zxi++) {
					echo '<td></td>';
				}
				$cols = $nmax-$zxi+1;
				echo '<td colspan="'.$cols.'">'.$value['Codigo'].' - '.$value['Nombre'].'</td>';

				//Recorro los años
				$interruptor_mes = 0;

				for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
					$suma_real       = 0;

					//recorro los meses
					if($interruptor_mes==0){
						for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
							if(isset($FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta'])&&$FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta']!=0){
					
								if($value['Valor']!=0){  
									//Se hacen calculos
									$total = $value['Valor']*$FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta'];
									$suma_real = $suma_real + $total;

									//Se escriben los resultados
									echo '<td align="right">'.valores($total, 0).'</td>'; 
								
								}else{
									echo '<td></td>';
								}
							
							}else{
								echo '<td></td>';

							}
						}
					}else{
						for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
							if(isset($FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta'])&&$FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta']!=0){
					
								if($value['Valor']!=0){  
									//Se hacen calculos
									$total = $value['Valor']*$FlujoMensual[$value['lvl']][$value['id']][$z_ano][$z_mes]['Cuenta'];
									$suma_real = $suma_real + $total;

									//Se escriben los resultados
									echo '<td align="right">'.valores($total, 0).'</td>'; 
								
								}else{
									echo '<td></td>';
								}
							
							}else{
								echo '<td></td>';

							}
						}
					}

					//Total Programado
					if($value['ValorTotal']!=0){echo '<td align="right">'.valores($value['ValorTotal'], 0).'</td>';}else{echo '<td></td>';}

					//Total real
					echo '<td align="right">'.valores($suma_real, 0).'</td>';

					//porcentaje cumplimiento
					if($value['ValorTotal']!=0){

						$porcentaje = 0;
						if(isset($suma_real)&&$suma_real!=0){
							$porcentaje = ($total*100)/$value['ValorTotal'];
						}
						echo '<td align="right">'.Cantidades($porcentaje, 2).' %</td>';
					}else{
						echo '<td></td>';
					}

					//sumo 1 al interruptor
					$interruptor_mes++;
				}
				
			echo '</tr>';
		
		
		}
        if (!empty($value) && is_array($value)){	
            echo arrayFlujo($value, $FlujoMensual, $UML, $nmax, $ano_min, $ano_max, $mes_min, $mes_max);
		}
        
    }

}	



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Cumplimiento del Contrato</h5>
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
								<td>Estado</td>
								<td><?php echo $rowData['Estado']; ?></td>
							</tr>
							<tr class="odd">
								<td>Bodega Productos Utilizada</td>
								<td><?php echo $rowData['BodegaProductos']; ?></td>
							</tr>
							<tr class="odd">
								<td>Bodega Insumos Utilizada</td>
								<td><?php echo $rowData['BodegaInsumos']; ?></td>
							</tr>

						</tbody>
					</table>
						
						
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed dataTable">

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr>
									<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;"></td>
									<td colspan="3" align="center" style="background-color: #ccc;">Presupuestado</td>
									<td colspan="3" align="center" style="background-color: #ccc;">Real</td>
									<td colspan="1" align="center" style="background-color: #ccc;">Cumplimiento</td>
								</tr>
								<tr>
									<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Itemizado</td>
									<td align="center" style="background-color: #ccc;">Cantidad</td>
									<td align="center" style="background-color: #ccc;">Valor Unitario</td>
									<td align="center" style="background-color: #ccc;">Valor Total</td>
									<td align="center" style="background-color: #ccc;">Cantidad</td>
									<td align="center" style="background-color: #ccc;">Valor Unitario</td>
									<td align="center" style="background-color: #ccc;">Valor Total</td>
									<td align="center" style="background-color: #ccc;">%</td>
								</tr>

									<?php //Se imprime el arbol
										
									echo arrayToUL($array3d, $OTRealizadas, $UML, $nmax);
										
									?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Flujo Mensual Cumplimiento del Contrato</h5>
		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed dataTable">

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr>
									<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;"></td>

									<?php
									//Recorro los años
									$interruptor_mes = 0;
									for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
										//recorro los meses
										if($interruptor_mes==0){
											for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
												echo '<td align="center" style="background-color: #ccc;">'.numero_a_mes($z_mes).'<br/>'.$z_ano.'</td>';
											}
										}else{
											for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
												echo '<td align="center" style="background-color: #ccc;">'.numero_a_mes($z_mes).'<br/>'.$z_ano.'</td>';
											}
										}

										//sumo 1 al interruptor
										$interruptor_mes++;
									}
									?>

									<td colspan="1" align="center" style="background-color: #ccc;"></td>
									<td colspan="1" align="center" style="background-color: #ccc;"></td>
									<td colspan="1" align="center" style="background-color: #ccc;"></td>
								</tr>
								<tr>
									<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Itemizado</td>

									<?php
									//Recorro los años
									$interruptor_mes = 0;
									for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
										//recorro los meses
										if($interruptor_mes==0){
											for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
												echo '<td align="center" style="background-color: #ccc;"></td>';
											}
										}else{
											for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
												echo '<td align="center" style="background-color: #ccc;"></td>';
											}
										}

										//sumo 1 al interruptor
										$interruptor_mes++;
									}
									?>

									<td colspan="1" align="center" style="background-color: #ccc;">Total<br/>Programado</td>
									<td colspan="1" align="center" style="background-color: #ccc;">Total<br/>Real</td>
									<td colspan="1" align="center" style="background-color: #ccc;">%<br/>Cumplimiento</td>
								</tr>

									<?php //Se imprime el arbol
										
										echo arrayFlujo($array3d, $FlujoMensual, $UML, $nmax, $ano_min, $ano_max, $mes_min, $mes_max);
										
									?>
								<?php 
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompProd){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Productos Utilizados</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompProd as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php }
								}
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompIns){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Insumos Utilizados</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompIns as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php }
								}
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompCliente){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Pagos Clientes</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompCliente as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php } ?>
								<?php } ?>
								
								
					  
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Gasto Materiales</h5>
		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed dataTable">

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php 
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompProd){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Productos Utilizados</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompProd as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php }
								}
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompIns){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Insumos Utilizados</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompIns as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php }
								} ?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Pagos del Cliente</h5>
		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed dataTable">

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php 
								/******************************************************************************/
								//Verifico si hay resultados
								if($CompCliente){ ?>
									<tr>
										<td colspan="<?php echo $nmax; ?>" style="background-color: #ccc;">Pagos Clientes</td>
										<?php
										//Recorro los años
										$interruptor_mes = 0;
										for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
											//recorro los meses
											if($interruptor_mes==0){
												for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}else{
												for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
													echo '<td align="center" style="background-color: #ccc;"></td>';
												}
											}
											//sumo 1 al interruptor
											$interruptor_mes++;
										}
										?>

										<td colspan="1" align="center" style="background-color: #ccc;"></td>
										<td colspan="1" align="center" style="background-color: #ccc;">Total</td>
										<td colspan="1" align="center" style="background-color: #ccc;"></td>
									</tr>

									<?php foreach ($CompCliente as $prod) { ?>
										<tr>
											<td colspan="<?php echo $nmax; ?>" ><?php echo $prod['Nombre']; ?></td>
											
											<?php
											//Recorro los años
											$interruptor_mes = 0;
											$Total = 0;
											for ($z_ano = $ano_min; $z_ano <= $ano_max; $z_ano++) {
												//recorro los meses
												if($interruptor_mes==0){
													for ($z_mes = $mes_min; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}else{
													for ($z_mes = 1; $z_mes <= 12; $z_mes++) {
														if(isset($prod[$z_ano][$z_mes]['Total'])&&$prod[$z_ano][$z_mes]['Total']!=''){
															echo '<td align="center">'.valores($prod[$z_ano][$z_mes]['Total'], 0).'</td>';
															$Total = $Total + $prod[$z_ano][$z_mes]['Total'];
														}else{
															echo '<td align="center"></td>';
														}
													}
												}

												//sumo 1 al interruptor
												$interruptor_mes++;
											}
											?>
											
											<td colspan="1" align="center"></td>
											<td colspan="1" align="center"><?php echo valores($Total, 0); ?></td>
											<td colspan="1" align="center"></td>
										</tr>
									<?php } ?>
								<?php } ?>
								
								
					  
							</tbody>
						</table>
					</div>

				</div>
			</div>
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
//sistema
$y = "licitacion_listado.idEstado=1 AND licitacion_listado.idAprobado=2 ";
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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
				if(isset($idCliente)){       $x0  = $idCliente;     }else{$x0  = '';}
				if(isset($idLicitacion)){    $x1  = $idLicitacion;  }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idSistema']==11){
					$Form_Inputs->form_select_depend1('Cliente','idCliente', $x0, 2, 'idCliente', 'Nombre', 'clientes_listado', $w, 0,
											 'Contrato','idLicitacion', $x1, 2, 'idLicitacion', 'Nombre', 'licitacion_listado', $w, 0, 
										      $dbConn, 'form1');
				}else{
					$Form_Inputs->form_select_filter('Contrato','idLicitacion', $x1, 2, 'idLicitacion', 'Nombre', 'licitacion_listado', $y, '', $dbConn);
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
