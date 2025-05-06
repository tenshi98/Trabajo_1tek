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
$original = "informe_gerencial_22.php";
$location = $original;
//Se agregan ubicaciones
$location .='?submit_filter=Filtrar';			
       
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
//Solo compras pagadas totalmente
$z1   = "(idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
$z2   = "(idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";   
$z3   = "(idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
$z4   = "(idTipo=2 OR idTipo=12 OR idTipo=13 OR idTipo=1 OR idTipo=10 OR idTipo=11)";
$z5   = "(idFacturacion!=0)";     //siempre pasa
$z6   = "(idFactTrab!=0)";        //siempre pasa
$z7   = "(idFacturacion!=0)";     //siempre pasa
$z8_1 = "(idFactFiscal!=0)";      //siempre pasa
$z8_2 = "(idFactFiscal!=0)";      //siempre pasa
$z8_3 = "(idFactFiscal!=0)";      //siempre pasa
$z8_4 = "(idFactFiscal!=0)";      //siempre pasa
$z9_1 = "(idFactSocial!=0)";      //siempre pasa
$z9_2 = "(idFactSocial!=0)";      //siempre pasa
$z9_3 = "(idFactSocial!=0)";      //siempre pasa

//variable
$search = '?bla=bla';
if(isset($_GET['idCentroCosto'])&&$_GET['idCentroCosto']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$_GET['idCentroCosto'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');
	//se crean cadenas
	$z1.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z2.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z3.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z4.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z5.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z6.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z7.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z8_1.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z8_2.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z8_3.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z8_4.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z9_1.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z9_2.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$z9_3.=" AND centrocosto_listado.Nombre='".$rowCentro['Nombre']."'";
	$search .="&idCentroCosto=".$rowCentro['Nombre'];
}
if(isset($_GET['idLevel_1'])&&$_GET['idLevel_1']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$_GET['idLevel_1'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');
	//se crean cadenas
	$z1.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z2.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z3.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z4.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z5.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z6.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z7.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z8_1.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z8_2.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z8_3.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z8_4.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z9_1.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z9_2.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$z9_3.=" AND centrocosto_listado_level_1.Nombre='".$rowCentro['Nombre']."'";
	$search .="&idLevel_1=".$rowCentro['Nombre'];
}
if(isset($_GET['idLevel_2'])&&$_GET['idLevel_2']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$_GET['idLevel_2'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'submit_filter');
	//se crean cadenas
	$z1.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z2.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z3.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z4.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z5.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z6.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z7.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z8_1.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z8_2.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z8_3.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z8_4.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z9_1.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z9_2.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$z9_3.=" AND centrocosto_listado_level_2.Nombre='".$rowCentro['Nombre']."'";
	$search .="&idLevel_2=".$rowCentro['Nombre'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z5.=" AND boleta_honorarios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z6.=" AND rrhh_sueldos_facturacion_trabajadores.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z7.=" AND contab_caja_gastos_existencias.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z8_1.=" AND pagos_leyes_fiscales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z8_2.=" AND pagos_leyes_fiscales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z8_3.=" AND pagos_leyes_fiscales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z8_4.=" AND pagos_leyes_fiscales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z9_1.=" AND pagos_leyes_sociales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z9_2.=" AND pagos_leyes_sociales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z9_3.=" AND pagos_leyes_sociales.Pago_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];

}
/*************************************************************************************************/
function return_query($type, $table){
	
	switch ($type) {
		case 1:
			$data = '
			'.$table.'.idTipo,
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2,
			'.$table.'.idLevel_3,
			centrocosto_listado_level_3.Nombre AS Servicio,
			SUM('.$table.'.ValorTotal) AS Total';
			break;
		case 2:
			$data = '
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2,
			'.$table.'.idLevel_3,
			SUM('.$table.'.ValorTotal) AS Total';
			break;
		case 3:
			$data = '
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2,
			'.$table.'.idLevel_3,
			SUM('.$table.'.TotalAPagar) AS Total';
			break;
		case 4:
			$data = '
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2,
			'.$table.'.idLevel_3,
			SUM('.$table.'.Valor) AS Total';
			break;
		case 5:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.IVA_idCentroCosto AS idCentroCosto,
			'.$table.'.IVA_idLevel_1 AS idLevel_1,
			'.$table.'.IVA_idLevel_2 AS idLevel_2,
			'.$table.'.IVA_idLevel_3 AS idLevel_3,
			SUM('.$table.'.IVA_TotalSaldo) AS Total';
			break;
		case 6:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.PPM_idCentroCosto AS idCentroCosto,
			'.$table.'.PPM_idLevel_1 AS idLevel_1,
			'.$table.'.PPM_idLevel_2 AS idLevel_2,
			'.$table.'.PPM_idLevel_3 AS idLevel_3,
			SUM('.$table.'.PPM_Saldo) AS Total';
			break;
		case 7:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.RET_idCentroCosto AS idCentroCosto,
			'.$table.'.RET_idLevel_1 AS idLevel_1,
			'.$table.'.RET_idLevel_2 AS idLevel_2,
			'.$table.'.RET_idLevel_3 AS idLevel_3,
			SUM('.$table.'.Retencion) AS Total';
			break;
		case 8:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.IMPRENT_idCentroCosto AS idCentroCosto,
			'.$table.'.IMPRENT_idLevel_1 AS idLevel_1,
			'.$table.'.IMPRENT_idLevel_2 AS idLevel_2,
			'.$table.'.IMPRENT_idLevel_3 AS idLevel_3,
			SUM('.$table.'.ImpuestoRenta) AS Total';
			break;
		case 9:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.AFP_idCentroCosto AS idCentroCosto,
			'.$table.'.AFP_idLevel_1 AS idLevel_1,
			'.$table.'.AFP_idLevel_2 AS idLevel_2,
			'.$table.'.AFP_idLevel_3 AS idLevel_3,
			SUM('.$table.'.AFP_MontoPago) AS Total';
			break;
		case 10:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.SALUD_idCentroCosto AS idCentroCosto,
			'.$table.'.SALUD_idLevel_1 AS idLevel_1,
			'.$table.'.SALUD_idLevel_2 AS idLevel_2,
			'.$table.'.SALUD_idLevel_3 AS idLevel_3,
			SUM('.$table.'.SALUD_MontoPago) AS Total';
			break;
		case 11:
			$data = '
			'.$table.'.Pago_ano AS Creacion_ano,
			'.$table.'.Pago_mes AS Creacion_mes,
			'.$table.'.SEGURIDAD_idCentroCosto AS idCentroCosto,
			'.$table.'.SEGURIDAD_idLevel_1 AS idLevel_1,
			'.$table.'.SEGURIDAD_idLevel_2 AS idLevel_2,
			'.$table.'.SEGURIDAD_idLevel_3 AS idLevel_3,
			SUM('.$table.'.SEGURIDAD_MontoPago) AS Total';
			break;
	}

	return $data;
}	
function return_join($type, $table){
	switch ($type) {
		case 1:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.idLevel_2
			LEFT JOIN `centrocosto_listado_level_3` ON centrocosto_listado_level_3.idLevel_3  = '.$table.'.idLevel_3
			';
			break;
		case 2:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.idLevel_2
			';
			break;
		case 3:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.IVA_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.IVA_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.IVA_idLevel_2
			';
			break;
		case 4:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.PPM_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.PPM_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.PPM_idLevel_2
			';
			break;
		case 5:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.RET_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.RET_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.RET_idLevel_2
			';
			break;
		case 6:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.IMPRENT_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.IMPRENT_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.IMPRENT_idLevel_2
			';
			break;
		case 7:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.AFP_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.AFP_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.AFP_idLevel_2
			';
			break;
		case 8:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.SALUD_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.SALUD_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.SALUD_idLevel_2
			';
			break;
		case 9:
			$data = '
			LEFT JOIN `centrocosto_listado`         ON centrocosto_listado.idCentroCosto      = '.$table.'.SEGURIDAD_idCentroCosto
			LEFT JOIN `centrocosto_listado_level_1` ON centrocosto_listado_level_1.idLevel_1  = '.$table.'.SEGURIDAD_idLevel_1
			LEFT JOIN `centrocosto_listado_level_2` ON centrocosto_listado_level_2.idLevel_2  = '.$table.'.SEGURIDAD_idLevel_2
			';
			break;
	}

	return $data;
}
function return_filter($type, $table, $filter){
	switch ($type) {
		case 1:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2,
			'.$table.'.idTipo,
			'.$table.'.idLevel_3';
			break;
		case 2:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Creacion_ano,
			'.$table.'.Creacion_mes,
			'.$table.'.idCentroCosto,
			'.$table.'.idLevel_1,
			'.$table.'.idLevel_2';
			break;
		case 3:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.IVA_idCentroCosto,
			'.$table.'.IVA_idLevel_1,
			'.$table.'.IVA_idLevel_2';
			break;
		case 4:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.PPM_idCentroCosto,
			'.$table.'.PPM_idLevel_1,
			'.$table.'.PPM_idLevel_2';
			break;
		case 5:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.RET_idCentroCosto,
			'.$table.'.RET_idLevel_1,
			'.$table.'.RET_idLevel_2';
			break;
		case 6:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.IMPRENT_idCentroCosto,
			'.$table.'.IMPRENT_idLevel_1,
			'.$table.'.IMPRENT_idLevel_2';
			break;
		case 7:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.AFP_idCentroCosto,
			'.$table.'.AFP_idLevel_1,
			'.$table.'.AFP_idLevel_2';
			break;
		case 8:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.SALUD_idCentroCosto,
			'.$table.'.SALUD_idLevel_1,
			'.$table.'.SALUD_idLevel_2';
			break;
		case 9:
			$data = $filter.'
			GROUP BY 
			'.$table.'.Pago_ano,
			'.$table.'.Pago_mes,
			'.$table.'.SEGURIDAD_idCentroCosto,
			'.$table.'.SEGURIDAD_idLevel_1,
			'.$table.'.SEGURIDAD_idLevel_2';
			break;

	}

	return $data;
}
/*************************************************************************************************/
$SIS_table_1 = 'bodegas_arriendos_facturacion';
$SIS_table_2 = 'bodegas_insumos_facturacion';
$SIS_table_3 = 'bodegas_productos_facturacion';
$SIS_table_4 = 'bodegas_servicios_facturacion';
$SIS_table_5 = 'boleta_honorarios_facturacion';
$SIS_table_6 = 'rrhh_sueldos_facturacion_trabajadores';
$SIS_table_7 = 'contab_caja_gastos_existencias';
$SIS_table_8 = 'pagos_leyes_fiscales';
$SIS_table_9 = 'pagos_leyes_sociales';

//Bodega de Arriendos
$arrTemporal_1 = array();
$arrTemporal_1 = db_select_array (false, return_query(1, $SIS_table_1), $SIS_table_1, return_join(1, $SIS_table_1), return_filter(1, $SIS_table_1, $z1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_1');
//Bodega de Insumos
$arrTemporal_2 = array();
$arrTemporal_2 = db_select_array (false, return_query(1, $SIS_table_2), $SIS_table_2, return_join(1, $SIS_table_2), return_filter(1, $SIS_table_2, $z2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_2');
//Bodega de Productos
$arrTemporal_3 = array();
$arrTemporal_3 = db_select_array (false, return_query(1, $SIS_table_3), $SIS_table_3, return_join(1, $SIS_table_3), return_filter(1, $SIS_table_3, $z3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_3');
//Bodega de Servicios
$arrTemporal_4 = array();
$arrTemporal_4 = db_select_array (false, return_query(1, $SIS_table_4), $SIS_table_4, return_join(1, $SIS_table_4), return_filter(1, $SIS_table_4, $z4), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
//Boleta de honorarios
$arrTemporal_5 = array();
$arrTemporal_5 = db_select_array (false, return_query(2, $SIS_table_5), $SIS_table_5, return_join(2, $SIS_table_5), return_filter(2, $SIS_table_5, $z5), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_5');
//Liquidaciones de sueldo
$arrTemporal_6 = array();
$arrTemporal_6 = db_select_array (false, return_query(3, $SIS_table_6), $SIS_table_6, return_join(2, $SIS_table_6), return_filter(2, $SIS_table_6, $z6), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');
//Rendiciones
$arrTemporal_7 = array();
$arrTemporal_7 = db_select_array (false, return_query(4, $SIS_table_7), $SIS_table_7, return_join(2, $SIS_table_7), return_filter(2, $SIS_table_7, $z7), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_7');
//Formulario 29 IVA
$arrTemporal_8_1 = array();
$arrTemporal_8_1 = db_select_array (false, return_query(5, $SIS_table_8), $SIS_table_8, return_join(3, $SIS_table_8), return_filter(3, $SIS_table_8, $z8_1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8_1');
//Formulario 29 PPM
$arrTemporal_8_2 = array();
$arrTemporal_8_2 = db_select_array (false, return_query(6, $SIS_table_8), $SIS_table_8, return_join(4, $SIS_table_8), return_filter(4, $SIS_table_8, $z8_2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8_2');
//Formulario 29 Retenciones
$arrTemporal_8_3 = array();
$arrTemporal_8_3 = db_select_array (false, return_query(7, $SIS_table_8), $SIS_table_8, return_join(5, $SIS_table_8), return_filter(5, $SIS_table_8, $z8_3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8_3');
//Formulario 29 Impuesto a la Renta
$arrTemporal_8_4 = array();
$arrTemporal_8_4 = db_select_array (false, return_query(8, $SIS_table_8), $SIS_table_8, return_join(6, $SIS_table_8), return_filter(6, $SIS_table_8, $z8_4), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8_4');
//Previred AFP
$arrTemporal_9_1 = array();
$arrTemporal_9_1 = db_select_array (false, return_query(9, $SIS_table_9), $SIS_table_9, return_join(7, $SIS_table_9), return_filter(7, $SIS_table_9, $z9_1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_9_1');
//Previred SALUD
$arrTemporal_9_2 = array();
$arrTemporal_9_2 = db_select_array (false, return_query(10, $SIS_table_9), $SIS_table_9, return_join(8, $SIS_table_9), return_filter(8, $SIS_table_9, $z9_2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_9_2');
//Previred SEGURIDAD
$arrTemporal_9_3 = array();
$arrTemporal_9_3 = db_select_array (false, return_query(11, $SIS_table_9), $SIS_table_9, return_join(9, $SIS_table_9), return_filter(9, $SIS_table_9, $z9_3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_9_3');

//Centro Costo
$arrCentroCosto = array();
$arrCentroCosto = db_select_array (false, 'idCentroCosto, Nombre', 'centrocosto_listado', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
//Centro Costo
$arrCentroCosto_lv1 = array();
$arrCentroCosto_lv1 = db_select_array (false, 'idLevel_1, Nombre', 'centrocosto_listado_level_1', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
//Centro Costo
$arrCentroCosto_lv2 = array();
$arrCentroCosto_lv2 = db_select_array (false, 'idLevel_2, Nombre', 'centrocosto_listado_level_2', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');

/**************************************************************************/
$arrTemp = array();
/***********************/
$inc = 0;
foreach($arrTemporal_1 as $temp) {

	//contador de cambios
	$count_change = 0;
	$valor_1      = 0;
	$valor_2      = 0;
	$valor_3      = 0;
	$valor_4      = 0;
	$valor_5      = 0;
	$valor_6      = 0;

	//verificacion de cambios
	if($inc==0 OR $arrTemp[1][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[1][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[1][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[1][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[1][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[1][$inc]['Tipo']           = 'Arriendos';
		$arrTemp[1][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[1][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[1][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[1][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[1][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[1][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[1][$inc]['Total_1'] = 0;
		$arrTemp[1][$inc]['Total_2'] = 0;
		$arrTemp[1][$inc]['Total_3'] = 0;
		$arrTemp[1][$inc]['Total_4'] = 0;
		$arrTemp[1][$inc]['Total_5'] = 0;
		$arrTemp[1][$inc]['Total_6'] = 0;
	}
		

	//se busca el tipo
	switch ($temp['idTipo']) {
		case 2:  $valor_1 = $temp['Total'];     break; //Venta
		case 12: $valor_2 = $temp['Total'];     break; //Nota Debito Cliente
		case 13: $valor_3 = $temp['Total']*-1;  break; //Nota Credito Cliente
		case 1:  $valor_4 = $temp['Total'];     break; //Compra
		case 10: $valor_5 = $temp['Total'];     break; //Nota Debito Proveedor
		case 11: $valor_6 = $temp['Total']*-1;  break; //Nota Credito Proveedor
	}
		
	switch ($temp['Servicio']) {
		case 'Telemetría':
			$arrTemp[1][$inc]['Total_1'] = $arrTemp[1][$inc]['Total_1'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[1][$inc]['Total_2'] = $arrTemp[1][$inc]['Total_2'] + 0;
			$arrTemp[1][$inc]['Total_3'] = $arrTemp[1][$inc]['Total_3'] + 0;
			$arrTemp[1][$inc]['Total_4'] = $arrTemp[1][$inc]['Total_4'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[1][$inc]['Total_5'] = $arrTemp[1][$inc]['Total_5'] + 0;
			$arrTemp[1][$inc]['Total_6'] = $arrTemp[1][$inc]['Total_6'] + 0;
			break;
		case 'Instalación':
			$arrTemp[1][$inc]['Total_1'] = $arrTemp[1][$inc]['Total_1'] + 0;
			$arrTemp[1][$inc]['Total_2'] = $arrTemp[1][$inc]['Total_2'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[1][$inc]['Total_3'] = $arrTemp[1][$inc]['Total_3'] + 0;
			$arrTemp[1][$inc]['Total_4'] = $arrTemp[1][$inc]['Total_4'] + 0;
			$arrTemp[1][$inc]['Total_5'] = $arrTemp[1][$inc]['Total_5'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[1][$inc]['Total_6'] = $arrTemp[1][$inc]['Total_6'] + 0;
			break;
		case 'Servicio Técnico':
			$arrTemp[1][$inc]['Total_1'] = $arrTemp[1][$inc]['Total_1'] + 0;
			$arrTemp[1][$inc]['Total_2'] = $arrTemp[1][$inc]['Total_2'] + 0;
			$arrTemp[1][$inc]['Total_3'] = $arrTemp[1][$inc]['Total_3'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[1][$inc]['Total_4'] = $arrTemp[1][$inc]['Total_4'] + 0;
			$arrTemp[1][$inc]['Total_5'] = $arrTemp[1][$inc]['Total_5'] + 0;
			$arrTemp[1][$inc]['Total_6'] = $arrTemp[1][$inc]['Total_6'] + $valor_4 + $valor_5 + $valor_6;
			break;
			
	}
}
/***********************/
$inc = 0;
foreach($arrTemporal_2 as $temp) {

	//contador de cambios
	$count_change = 0;
	$valor_1      = 0;
	$valor_2      = 0;
	$valor_3      = 0;
	$valor_4      = 0;
	$valor_5      = 0;
	$valor_6      = 0;

	//verificacion de cambios
	if($inc==0 OR $arrTemp[2][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[2][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[2][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[2][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[2][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[2][$inc]['Tipo']           = 'Insumos';
		$arrTemp[2][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[2][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[2][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[2][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[2][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[2][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[2][$inc]['Total_1'] = 0;
		$arrTemp[2][$inc]['Total_2'] = 0;
		$arrTemp[2][$inc]['Total_3'] = 0;
		$arrTemp[2][$inc]['Total_4'] = 0;
		$arrTemp[2][$inc]['Total_5'] = 0;
		$arrTemp[2][$inc]['Total_6'] = 0;
	}
		

	//se busca el tipo
	switch ($temp['idTipo']) {
		case 2:  $valor_1 = $temp['Total'];     break; //Venta
		case 12: $valor_2 = $temp['Total'];     break; //Nota Debito Cliente
		case 13: $valor_3 = $temp['Total']*-1;  break; //Nota Credito Cliente
		case 1:  $valor_4 = $temp['Total'];     break; //Compra
		case 10: $valor_5 = $temp['Total'];     break; //Nota Debito Proveedor
		case 11: $valor_6 = $temp['Total']*-1;  break; //Nota Credito Proveedor
	}
		
	switch ($temp['Servicio']) {
		case 'Telemetría':
			$arrTemp[2][$inc]['Total_1'] = $arrTemp[2][$inc]['Total_1'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[2][$inc]['Total_2'] = $arrTemp[2][$inc]['Total_2'] + 0;
			$arrTemp[2][$inc]['Total_3'] = $arrTemp[2][$inc]['Total_3'] + 0;
			$arrTemp[2][$inc]['Total_4'] = $arrTemp[2][$inc]['Total_4'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[2][$inc]['Total_5'] = $arrTemp[2][$inc]['Total_5'] + 0;
			$arrTemp[2][$inc]['Total_6'] = $arrTemp[2][$inc]['Total_6'] + 0;
			break;
		case 'Instalación':
			$arrTemp[2][$inc]['Total_1'] = $arrTemp[2][$inc]['Total_1'] + 0;
			$arrTemp[2][$inc]['Total_2'] = $arrTemp[2][$inc]['Total_2'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[2][$inc]['Total_3'] = $arrTemp[2][$inc]['Total_3'] + 0;
			$arrTemp[2][$inc]['Total_4'] = $arrTemp[2][$inc]['Total_4'] + 0;
			$arrTemp[2][$inc]['Total_5'] = $arrTemp[2][$inc]['Total_5'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[2][$inc]['Total_6'] = $arrTemp[2][$inc]['Total_6'] + 0;
			break;
		case 'Servicio Técnico':
			$arrTemp[2][$inc]['Total_1'] = $arrTemp[2][$inc]['Total_1'] + 0;
			$arrTemp[2][$inc]['Total_2'] = $arrTemp[2][$inc]['Total_2'] + 0;
			$arrTemp[2][$inc]['Total_3'] = $arrTemp[2][$inc]['Total_3'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[2][$inc]['Total_4'] = $arrTemp[2][$inc]['Total_4'] + 0;
			$arrTemp[2][$inc]['Total_5'] = $arrTemp[2][$inc]['Total_5'] + 0;
			$arrTemp[2][$inc]['Total_6'] = $arrTemp[2][$inc]['Total_6'] + $valor_4 + $valor_5 + $valor_6;
			break;
			
	}
}
/***********************/
$inc = 0;
foreach($arrTemporal_3 as $temp) {

	//contador de cambios
	$count_change = 0;
	$valor_1      = 0;
	$valor_2      = 0;
	$valor_3      = 0;
	$valor_4      = 0;
	$valor_5      = 0;
	$valor_6      = 0;

	//verificacion de cambios
	if($inc==0 OR $arrTemp[3][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[3][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[3][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[3][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[3][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[3][$inc]['Tipo']           = 'Productos';
		$arrTemp[3][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[3][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[3][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[3][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[3][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[3][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[3][$inc]['Total_1'] = 0;
		$arrTemp[3][$inc]['Total_2'] = 0;
		$arrTemp[3][$inc]['Total_3'] = 0;
		$arrTemp[3][$inc]['Total_4'] = 0;
		$arrTemp[3][$inc]['Total_5'] = 0;
		$arrTemp[3][$inc]['Total_6'] = 0;
	}
		

	//se busca el tipo
	switch ($temp['idTipo']) {
		case 2:  $valor_1 = $temp['Total'];     break; //Venta
		case 12: $valor_2 = $temp['Total'];     break; //Nota Debito Cliente
		case 13: $valor_3 = $temp['Total']*-1;  break; //Nota Credito Cliente
		case 1:  $valor_4 = $temp['Total'];     break; //Compra
		case 10: $valor_5 = $temp['Total'];     break; //Nota Debito Proveedor
		case 11: $valor_6 = $temp['Total']*-1;  break; //Nota Credito Proveedor
	}
		
	switch ($temp['Servicio']) {
		case 'Telemetría':
			$arrTemp[3][$inc]['Total_1'] = $arrTemp[3][$inc]['Total_1'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[3][$inc]['Total_2'] = $arrTemp[3][$inc]['Total_2'] + 0;
			$arrTemp[3][$inc]['Total_3'] = $arrTemp[3][$inc]['Total_3'] + 0;
			$arrTemp[3][$inc]['Total_4'] = $arrTemp[3][$inc]['Total_4'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[3][$inc]['Total_5'] = $arrTemp[3][$inc]['Total_5'] + 0;
			$arrTemp[3][$inc]['Total_6'] = $arrTemp[3][$inc]['Total_6'] + 0;
			break;
		case 'Instalación':
			$arrTemp[3][$inc]['Total_1'] = $arrTemp[3][$inc]['Total_1'] + 0;
			$arrTemp[3][$inc]['Total_2'] = $arrTemp[3][$inc]['Total_2'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[3][$inc]['Total_3'] = $arrTemp[3][$inc]['Total_3'] + 0;
			$arrTemp[3][$inc]['Total_4'] = $arrTemp[3][$inc]['Total_4'] + 0;
			$arrTemp[3][$inc]['Total_5'] = $arrTemp[3][$inc]['Total_5'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[3][$inc]['Total_6'] = $arrTemp[3][$inc]['Total_6'] + 0;
			break;
		case 'Servicio Técnico':
			$arrTemp[3][$inc]['Total_1'] = $arrTemp[3][$inc]['Total_1'] + 0;
			$arrTemp[3][$inc]['Total_2'] = $arrTemp[3][$inc]['Total_2'] + 0;
			$arrTemp[3][$inc]['Total_3'] = $arrTemp[3][$inc]['Total_3'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[3][$inc]['Total_4'] = $arrTemp[3][$inc]['Total_4'] + 0;
			$arrTemp[3][$inc]['Total_5'] = $arrTemp[3][$inc]['Total_5'] + 0;
			$arrTemp[3][$inc]['Total_6'] = $arrTemp[3][$inc]['Total_6'] + $valor_4 + $valor_5 + $valor_6;
			break;
			
	}
}
/***********************/
$inc = 0;
foreach($arrTemporal_4 as $temp) {

	//contador de cambios
	$count_change = 0;
	$valor_1      = 0;
	$valor_2      = 0;
	$valor_3      = 0;
	$valor_4      = 0;
	$valor_5      = 0;
	$valor_6      = 0;

	//verificacion de cambios
	if($inc==0 OR $arrTemp[4][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[4][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[4][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[4][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[4][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[4][$inc]['Tipo']           = 'Servicios';
		$arrTemp[4][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[4][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[4][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[4][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[4][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[4][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[4][$inc]['Total_1'] = 0;
		$arrTemp[4][$inc]['Total_2'] = 0;
		$arrTemp[4][$inc]['Total_3'] = 0;
		$arrTemp[4][$inc]['Total_4'] = 0;
		$arrTemp[4][$inc]['Total_5'] = 0;
		$arrTemp[4][$inc]['Total_6'] = 0;
	}
		

	//se busca el tipo
	switch ($temp['idTipo']) {
		case 2:  $valor_1 = $temp['Total'];     break; //Venta
		case 12: $valor_2 = $temp['Total'];     break; //Nota Debito Cliente
		case 13: $valor_3 = $temp['Total']*-1;  break; //Nota Credito Cliente
		case 1:  $valor_4 = $temp['Total'];     break; //Compra
		case 10: $valor_5 = $temp['Total'];     break; //Nota Debito Proveedor
		case 11: $valor_6 = $temp['Total']*-1;  break; //Nota Credito Proveedor
	}
		
	switch ($temp['Servicio']) {
		case 'Telemetría':
			$arrTemp[4][$inc]['Total_1'] = $arrTemp[4][$inc]['Total_1'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[4][$inc]['Total_2'] = $arrTemp[4][$inc]['Total_2'] + 0;
			$arrTemp[4][$inc]['Total_3'] = $arrTemp[4][$inc]['Total_3'] + 0;
			$arrTemp[4][$inc]['Total_4'] = $arrTemp[4][$inc]['Total_4'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[4][$inc]['Total_5'] = $arrTemp[4][$inc]['Total_5'] + 0;
			$arrTemp[4][$inc]['Total_6'] = $arrTemp[4][$inc]['Total_6'] + 0;
			break;
		case 'Instalación':
			$arrTemp[4][$inc]['Total_1'] = $arrTemp[4][$inc]['Total_1'] + 0;
			$arrTemp[4][$inc]['Total_2'] = $arrTemp[4][$inc]['Total_2'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[4][$inc]['Total_3'] = $arrTemp[4][$inc]['Total_3'] + 0;
			$arrTemp[4][$inc]['Total_4'] = $arrTemp[4][$inc]['Total_4'] + 0;
			$arrTemp[4][$inc]['Total_5'] = $arrTemp[4][$inc]['Total_5'] + $valor_4 + $valor_5 + $valor_6;
			$arrTemp[4][$inc]['Total_6'] = $arrTemp[4][$inc]['Total_6'] + 0;
			break;
		case 'Servicio Técnico':
			$arrTemp[4][$inc]['Total_1'] = $arrTemp[4][$inc]['Total_1'] + 0;
			$arrTemp[4][$inc]['Total_2'] = $arrTemp[4][$inc]['Total_2'] + 0;
			$arrTemp[4][$inc]['Total_3'] = $arrTemp[4][$inc]['Total_3'] + $valor_1 + $valor_2 + $valor_3;
			$arrTemp[4][$inc]['Total_4'] = $arrTemp[4][$inc]['Total_4'] + 0;
			$arrTemp[4][$inc]['Total_5'] = $arrTemp[4][$inc]['Total_5'] + 0;
			$arrTemp[4][$inc]['Total_6'] = $arrTemp[4][$inc]['Total_6'] + $valor_4 + $valor_5 + $valor_6;
			break;
			
	}
}
/***********************/
$inc = 0;
foreach($arrTemporal_5 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[5][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[5][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[5][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[5][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[5][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[5][$inc]['Tipo']           = 'Boletas Honorarios';
		$arrTemp[5][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[5][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[5][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[5][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[5][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[5][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[5][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[5][$inc]['Total'] = $arrTemp[5][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_6 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[6][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[6][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[6][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[6][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[6][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[6][$inc]['Tipo']           = 'Liquidacion Sueldo';
		$arrTemp[6][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[6][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[6][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[6][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[6][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[6][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[6][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[6][$inc]['Total'] = $arrTemp[6][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_7 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[7][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[7][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[7][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[7][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[7][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[7][$inc]['Tipo']           = 'Rendiciones';
		$arrTemp[7][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[7][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[7][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[7][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[7][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[7][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[7][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[7][$inc]['Total'] = $arrTemp[7][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_8_1 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[8][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[8][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[8][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[8][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[8][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[8][$inc]['Tipo']           = 'Formulario 29 IVA';
		$arrTemp[8][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[8][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[8][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[8][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[8][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[8][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[8][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[8][$inc]['Total'] = $arrTemp[8][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_8_2 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[9][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[9][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[9][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[9][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[9][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[9][$inc]['Tipo']           = 'Formulario 29 PPM';
		$arrTemp[9][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[9][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[9][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[9][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[9][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[9][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[9][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[9][$inc]['Total'] = $arrTemp[9][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_8_3 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[10][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[10][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[10][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[10][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[10][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[10][$inc]['Tipo']           = 'Formulario 29 Retenciones';
		$arrTemp[10][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[10][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[10][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[10][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[10][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[10][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[10][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[10][$inc]['Total'] = $arrTemp[10][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_8_4 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[11][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[11][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[11][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[11][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[11][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[11][$inc]['Tipo']           = 'Formulario 29 Impuesto a la Renta';
		$arrTemp[11][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[11][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[11][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[11][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[11][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[11][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[11][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[11][$inc]['Total'] = $arrTemp[11][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_9_1 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[12][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[12][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[12][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[12][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[12][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[12][$inc]['Tipo']           = 'Previred AFP';
		$arrTemp[12][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[12][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[12][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[12][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[12][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[12][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[12][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[12][$inc]['Total'] = $arrTemp[12][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_9_2 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[13][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[13][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[13][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[13][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[13][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[13][$inc]['Tipo']           = 'Previred Salud';
		$arrTemp[13][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[13][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[13][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[13][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[13][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[13][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[13][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[13][$inc]['Total'] = $arrTemp[13][$inc]['Total'] + $temp['Total'];

}
/***********************/
$inc = 0;
foreach($arrTemporal_9_3 as $temp) {

	//contador de cambios
	$count_change = 0;
	//verificacion de cambios
	if($inc==0 OR $arrTemp[14][$inc]['Ano']!=$temp['Creacion_ano']){             $count_change++;}//se verifica cambio de año
	if($inc==0 OR $arrTemp[14][$inc]['Mes']!=$temp['Creacion_mes']){             $count_change++;}//se verifica cambio de mes
	if($inc==0 OR $arrTemp[14][$inc]['idCentroCosto']!=$temp['idCentroCosto']){  $count_change++;}//se verifica cambio de area
	if($inc==0 OR $arrTemp[14][$inc]['idLevel_1']!=$temp['idLevel_1']){          $count_change++;}//se verifica cambio de servicio
	if($inc==0 OR $arrTemp[14][$inc]['idLevel_2']!=$temp['idLevel_2']){          $count_change++;}//se verifica cambio de cliente
	//validacion
	if($count_change!=0){
		//si cambia se suma 1 al indice y se crean variables vacias	
		$inc++;
		//se crean las variables
		$arrTemp[14][$inc]['Tipo']           = 'Previred Seguridad';
		$arrTemp[14][$inc]['Ano']            = $temp['Creacion_ano'];
		$arrTemp[14][$inc]['Mes']            = $temp['Creacion_mes'];
		$arrTemp[14][$inc]['idCentroCosto']  = $temp['idCentroCosto'];
		$arrTemp[14][$inc]['idLevel_1']      = $temp['idLevel_1'];
		$arrTemp[14][$inc]['idLevel_2']      = $temp['idLevel_2'];
		$arrTemp[14][$inc]['idLevel_3']      = $temp['idLevel_3'];
		$arrTemp[14][$inc]['Total']          = 0;
	}
	//se suma
	$arrTemp[14][$inc]['Total'] = $arrTemp[14][$inc]['Total'] + $temp['Total'];

}

/************************************************/
$arrCC     = array();
$arrCC_lv1 = array();
$arrCC_lv2 = array();
foreach ($arrCentroCosto as $trab) {
	$arrCC[$trab['idCentroCosto']] = $trab['Nombre'];
}
foreach ($arrCentroCosto_lv1 as $trab) {
	$arrCC_lv1[$trab['idLevel_1']] = $trab['Nombre'];
}
foreach ($arrCentroCosto_lv2 as $trab) {
	$arrCC_lv2[$trab['idLevel_2']] = $trab['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<a target="new" href="<?php echo 'informe_gerencial_22_to_excel.php'.$search?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Informe de rentabilidad de negocio</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th colspan="6"></th>
						<th colspan="3" class="text-center">INGRESOS</th>
						<th colspan="3" class="text-center">EGRESOS</th>
						<th colspan="1" class="text-center">COSTOS</th>
						<th colspan="8" class="text-center"></th>
					</tr>
					<tr role="row">
						<th>Tipo</th>
						<th>Año</th>
						<th>Mes</th>
						<th>Area</th>
						<th>Servicio</th>
						<th>Cliente</th>

						<th>Telemetría</th>
						<th>Instalación</th>
						<th>Servicio Técnico</th>

						<th>Telemetría</th>
						<th>Instalación</th>
						<th>Servicio Técnico</th>

						<th>Costos</th>

						<th>Margen pesos telemetría</th>
						<th>%</th>
						<th>Margen pesos Instalación</th>
						<th>%</th>
						<th>Margen pesos Servicio técnico</th>
						<th>%</th>
						<th>Total margen cliente</th>
						<th>%</th>

					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					$total_ING_Telemetria       = 0;
					$total_ING_Instalacion      = 0;
					$total_ING_ServicioTecnico  = 0;
					$total_EG_Telemetria        = 0;
					$total_EG_Instalacion       = 0;
					$total_EG_ServicioTecnico   = 0;
					$total_EG_Costos            = 0;
					$total_margen_tel           = 0;
					$total_margen_ins           = 0;
					$total_margen_serv          = 0;
					$total_margen_total         = 0;
					$total_ing_total            = 0;

					/*****************************************************/
					if($arrTemp[1]!=false && !empty($arrTemp[1]) && $arrTemp[1]!=''){
						foreach ($arrTemp[1] as $trab) {
							//calculos
							$margen_tel   = $trab['Total_1']-$trab['Total_4'];
							$margen_ins   = $trab['Total_2']-$trab['Total_5'];
							$margen_serv  = $trab['Total_3']-$trab['Total_6'];
							$margen_total = $margen_tel+$margen_ins+$margen_serv;
							$ing_total    = $trab['Total_1']+$trab['Total_2']+$trab['Total_3'];
							//Totales
							$total_ING_Telemetria       = $total_ING_Telemetria + $trab['Total_1'];
							$total_ING_Instalacion      = $total_ING_Instalacion + $trab['Total_2'];
							$total_ING_ServicioTecnico  = $total_ING_ServicioTecnico + $trab['Total_3'];
							$total_EG_Telemetria        = $total_EG_Telemetria + $trab['Total_4'];
							$total_EG_Instalacion       = $total_EG_Instalacion + $trab['Total_5'];
							$total_EG_ServicioTecnico   = $total_EG_ServicioTecnico + $trab['Total_6'];
							$total_margen_tel           = $total_margen_tel + $margen_tel;
							$total_margen_ins           = $total_margen_ins + $margen_ins;
							$total_margen_serv          = $total_margen_serv + $margen_serv;
							$total_margen_total         = $total_margen_total + $margen_total;
							$total_ing_total            = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores($trab['Total_1'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_2'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_3'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_4'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_5'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_6'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><span <?php if($margen_tel<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_tel, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_1'])&&$trab['Total_1']!=0){echo porcentaje($margen_tel/$trab['Total_1']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_ins<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_ins, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_2'])&&$trab['Total_2']!=0){echo porcentaje($margen_ins/$trab['Total_2']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_serv<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_serv, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_3'])&&$trab['Total_3']!=0){echo porcentaje($margen_serv/$trab['Total_3']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[2]!=false && !empty($arrTemp[2]) && $arrTemp[2]!=''){
						foreach ($arrTemp[2] as $trab) {
							//calculos
							$margen_tel   = $trab['Total_1']-$trab['Total_4'];
							$margen_ins   = $trab['Total_2']-$trab['Total_5'];
							$margen_serv  = $trab['Total_3']-$trab['Total_6'];
							$margen_total = $margen_tel+$margen_ins+$margen_serv;
							$ing_total    = $trab['Total_1']+$trab['Total_2']+$trab['Total_3'];
							//Totales
							$total_ING_Telemetria       = $total_ING_Telemetria + $trab['Total_1'];
							$total_ING_Instalacion      = $total_ING_Instalacion + $trab['Total_2'];
							$total_ING_ServicioTecnico  = $total_ING_ServicioTecnico + $trab['Total_3'];
							$total_EG_Telemetria        = $total_EG_Telemetria + $trab['Total_4'];
							$total_EG_Instalacion       = $total_EG_Instalacion + $trab['Total_5'];
							$total_EG_ServicioTecnico   = $total_EG_ServicioTecnico + $trab['Total_6'];
							$total_margen_tel           = $total_margen_tel + $margen_tel;
							$total_margen_ins           = $total_margen_ins + $margen_ins;
							$total_margen_serv          = $total_margen_serv + $margen_serv;
							$total_margen_total         = $total_margen_total + $margen_total;
							$total_ing_total            = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores($trab['Total_1'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_2'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_3'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_4'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_5'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_6'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><span <?php if($margen_tel<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_tel, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_1'])&&$trab['Total_1']!=0){echo porcentaje($margen_tel/$trab['Total_1']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_ins<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_ins, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_2'])&&$trab['Total_2']!=0){echo porcentaje($margen_ins/$trab['Total_2']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_serv<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_serv, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_3'])&&$trab['Total_3']!=0){echo porcentaje($margen_serv/$trab['Total_3']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[3]!=false && !empty($arrTemp[3]) && $arrTemp[3]!=''){
						foreach ($arrTemp[3] as $trab) {
							//calculos
							$margen_tel   = $trab['Total_1']-$trab['Total_4'];
							$margen_ins   = $trab['Total_2']-$trab['Total_5'];
							$margen_serv  = $trab['Total_3']-$trab['Total_6'];
							$margen_total = $margen_tel+$margen_ins+$margen_serv;
							$ing_total    = $trab['Total_1']+$trab['Total_2']+$trab['Total_3'];
							//Totales
							$total_ING_Telemetria       = $total_ING_Telemetria + $trab['Total_1'];
							$total_ING_Instalacion      = $total_ING_Instalacion + $trab['Total_2'];
							$total_ING_ServicioTecnico  = $total_ING_ServicioTecnico + $trab['Total_3'];
							$total_EG_Telemetria        = $total_EG_Telemetria + $trab['Total_4'];
							$total_EG_Instalacion       = $total_EG_Instalacion + $trab['Total_5'];
							$total_EG_ServicioTecnico   = $total_EG_ServicioTecnico + $trab['Total_6'];
							$total_margen_tel           = $total_margen_tel + $margen_tel;
							$total_margen_ins           = $total_margen_ins + $margen_ins;
							$total_margen_serv          = $total_margen_serv + $margen_serv;
							$total_margen_total         = $total_margen_total + $margen_total;
							$total_ing_total            = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores($trab['Total_1'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_2'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_3'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_4'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_5'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_6'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><span <?php if($margen_tel<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_tel, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_1'])&&$trab['Total_1']!=0){echo porcentaje($margen_tel/$trab['Total_1']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_ins<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_ins, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_2'])&&$trab['Total_2']!=0){echo porcentaje($margen_ins/$trab['Total_2']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_serv<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_serv, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_3'])&&$trab['Total_3']!=0){echo porcentaje($margen_serv/$trab['Total_3']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[4]!=false && !empty($arrTemp[4]) && $arrTemp[4]!=''){
						foreach ($arrTemp[4] as $trab) {
							//calculos
							$margen_tel   = $trab['Total_1']-$trab['Total_4'];
							$margen_ins   = $trab['Total_2']-$trab['Total_5'];
							$margen_serv  = $trab['Total_3']-$trab['Total_6'];
							$margen_total = $margen_tel+$margen_ins+$margen_serv;
							$ing_total    = $trab['Total_1']+$trab['Total_2']+$trab['Total_3'];
							//Totales
							$total_ING_Telemetria       = $total_ING_Telemetria + $trab['Total_1'];
							$total_ING_Instalacion      = $total_ING_Instalacion + $trab['Total_2'];
							$total_ING_ServicioTecnico  = $total_ING_ServicioTecnico + $trab['Total_3'];
							$total_EG_Telemetria        = $total_EG_Telemetria + $trab['Total_4'];
							$total_EG_Instalacion       = $total_EG_Instalacion + $trab['Total_5'];
							$total_EG_ServicioTecnico   = $total_EG_ServicioTecnico + $trab['Total_6'];
							$total_margen_tel           = $total_margen_tel + $margen_tel;
							$total_margen_ins           = $total_margen_ins + $margen_ins;
							$total_margen_serv          = $total_margen_serv + $margen_serv;
							$total_margen_total         = $total_margen_total + $margen_total;
							$total_ing_total            = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores($trab['Total_1'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_2'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_3'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_4'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_5'], 0); ?></td>
								<td align="right"><?php echo valores($trab['Total_6'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><span <?php if($margen_tel<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_tel, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_1'])&&$trab['Total_1']!=0){echo porcentaje($margen_tel/$trab['Total_1']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_ins<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_ins, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_2'])&&$trab['Total_2']!=0){echo porcentaje($margen_ins/$trab['Total_2']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_serv<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_serv, 0); ?></span></td>
								<td align="right"><?php if(isset($trab['Total_3'])&&$trab['Total_3']!=0){echo porcentaje($margen_serv/$trab['Total_3']);}else{echo '0 %';} ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					} 
					/*****************************************************/
					if($arrTemp[5]!=false && !empty($arrTemp[5]) && $arrTemp[5]!=''){
						foreach ($arrTemp[5] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					} 
					/*****************************************************/
					if($arrTemp[6]!=false && !empty($arrTemp[6]) && $arrTemp[6]!=''){
						foreach ($arrTemp[6] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[7]!=false && !empty($arrTemp[7]) && $arrTemp[7]!=''){
						foreach ($arrTemp[7] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[8]!=false && !empty($arrTemp[8]) && $arrTemp[8]!=''){
						foreach ($arrTemp[8] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[9]!=false && !empty($arrTemp[9]) && $arrTemp[9]!=''){
						foreach ($arrTemp[9] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[10]!=false && !empty($arrTemp[10]) && $arrTemp[10]!=''){
						foreach ($arrTemp[10] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[11]!=false && !empty($arrTemp[11]) && $arrTemp[11]!=''){
						foreach ($arrTemp[11] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[12]!=false && !empty($arrTemp[12]) && $arrTemp[12]!=''){
						foreach ($arrTemp[12] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[13]!=false && !empty($arrTemp[13]) && $arrTemp[13]!=''){
						foreach ($arrTemp[13] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					}
					/*****************************************************/
					if($arrTemp[14]!=false && !empty($arrTemp[14]) && $arrTemp[14]!=''){
						foreach ($arrTemp[14] as $trab) {
							//calculos
							$margen_total   = $trab['Total']*-1;
							$ing_total      = $margen_total;

							//Totales
							$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
							$total_margen_total  = $total_margen_total + $margen_total;
							$total_ing_total     = $total_ing_total + $ing_total;
							?>
							<tr class="odd">
								<td><?php echo $trab['Tipo']; ?></td>
								<td><?php echo $trab['Ano']; ?></td>
								<td><?php echo $trab['Mes']; ?></td>
								<td><?php if(isset($arrCC[$trab['idCentroCosto']])){echo $arrCC[$trab['idCentroCosto']];} ?></td>
								<td><?php if(isset($arrCC_lv1[$trab['idLevel_1']])){echo $arrCC_lv1[$trab['idLevel_1']];} ?></td>
								<td><?php if(isset($arrCC_lv2[$trab['idLevel_2']])){echo $arrCC_lv2[$trab['idLevel_2']];} ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right" style="color:#ce4844;"><?php echo valores($trab['Total'], 0); ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><?php echo valores(0, 0); ?></td>
								<td align="right"><?php echo '0 %'; ?></td>
								<td align="right"><span <?php if($margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($margen_total, 0); ?></span></td>
								<td align="right"><?php if(isset($ing_total)&&$ing_total!=0){echo porcentaje($margen_total/$ing_total);}else{echo '0 %';} ?></td>
							</tr>
						<?php }
					} ?>   
	
	
					<tr class="odd">
						<td colspan="6"><strong>Totales</strong></td>
						<td align="right"><strong><?php echo valores($total_ING_Telemetria, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_ING_Instalacion, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_ING_ServicioTecnico, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_EG_Telemetria, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_EG_Instalacion, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_EG_ServicioTecnico, 0); ?></strong></td>
						<td align="right"><strong><?php echo valores($total_EG_Costos, 0); ?></strong></td>
						<td align="right"><strong><span <?php if($total_margen_tel<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($total_margen_tel, 0); ?></strong></span></td>
						<td align="right"><strong><?php if(isset($total_ING_Telemetria)&&$total_ING_Telemetria!=0){echo porcentaje($total_margen_tel/$total_ING_Telemetria);}else{echo '0 %';} ?></strong></td>
						<td align="right"><strong><span <?php if($total_margen_ins<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($total_margen_ins, 0); ?></strong></span></td>
						<td align="right"><strong><?php if(isset($total_ING_Instalacion)&&$total_ING_Instalacion!=0){echo porcentaje($total_margen_ins/$total_ING_Instalacion);}else{echo '0 %';} ?></strong></td>
						<td align="right"><strong><span <?php if($total_margen_serv<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($total_margen_serv, 0); ?></strong></span></td>
						<td align="right"><strong><?php if(isset($total_ING_ServicioTecnico)&&$total_ING_ServicioTecnico!=0){echo porcentaje($total_margen_serv/$total_ING_ServicioTecnico);}else{echo '0 %';} ?></strong></td>
						<td align="right"><strong><span <?php if($total_margen_total<0){echo 'style="color:#ce4844;"';} ?>><?php echo valores($total_margen_total, 0); ?></strong></span></td>
						<td align="right"><strong><?php if(isset($total_ing_total)&&$total_ing_total!=0){echo porcentaje($total_margen_total/$total_ing_total);}else{echo '0 %';} ?></strong></td>
					</tr>
					
						                   
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
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
				if(isset($f_inicio)){       $x1  = $f_inicio;       }else{$x1  = '';}
				if(isset($f_termino)){      $x2  = $f_termino;      }else{$x2  = '';}
				if(isset($idCentroCosto)){  $x3  = $idCentroCosto;  }else{$x3  = '';}
				if(isset($idLevel_1)){      $x4  = $idLevel_1;      }else{$x4  = '';}
				if(isset($idLevel_2)){      $x5  = $idLevel_2;      }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 1);
				$Form_Inputs->form_select_depend2('Area', 'idCentroCosto',  $x3,  1,  'idCentroCosto',  'Nombre',  'centrocosto_listado',  0,   0,
												  'Servicio', 'idLevel_1',  $x4,  1,  'idLevel_1',  'Nombre',  'centrocosto_listado_level_1',  0,   0, 
												  'Cliente', 'idLevel_2',  $x5,  1,  'idLevel_2',  'Nombre',  'centrocosto_listado_level_2',  0,   0,
												  $dbConn, 'form1');
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
