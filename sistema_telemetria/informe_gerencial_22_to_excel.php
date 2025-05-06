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
if(isset($_GET['idCentroCosto'])&&$_GET['idCentroCosto']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado', '', 'idCentroCosto = "'.$_GET['idCentroCosto'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'submit_filter');
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
}
if(isset($_GET['idLevel_1'])&&$_GET['idLevel_1']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_1', '', 'idLevel_1 = "'.$_GET['idLevel_1'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'submit_filter');
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
}
if(isset($_GET['idLevel_2'])&&$_GET['idLevel_2']!=''){
	// Se trae el dato seleccionado
	$rowCentro = db_select_data (false, 'Nombre', 'centrocosto_listado_level_2', '', 'idLevel_2 = "'.$_GET['idLevel_2'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'submit_filter');
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
$arrTemporal_1 = db_select_array (false, return_query(1, $SIS_table_1), $SIS_table_1, return_join(1, $SIS_table_1), return_filter(1, $SIS_table_1, $z1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_1');
//Bodega de Insumos
$arrTemporal_2 = array();
$arrTemporal_2 = db_select_array (false, return_query(1, $SIS_table_2), $SIS_table_2, return_join(1, $SIS_table_2), return_filter(1, $SIS_table_2, $z2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_2');
//Bodega de Productos
$arrTemporal_3 = array();
$arrTemporal_3 = db_select_array (false, return_query(1, $SIS_table_3), $SIS_table_3, return_join(1, $SIS_table_3), return_filter(1, $SIS_table_3, $z3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_3');
//Bodega de Servicios
$arrTemporal_4 = array();
$arrTemporal_4 = db_select_array (false, return_query(1, $SIS_table_4), $SIS_table_4, return_join(1, $SIS_table_4), return_filter(1, $SIS_table_4, $z4), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');
//Boleta de honorarios
$arrTemporal_5 = array();
$arrTemporal_5 = db_select_array (false, return_query(2, $SIS_table_5), $SIS_table_5, return_join(2, $SIS_table_5), return_filter(2, $SIS_table_5, $z5), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_5');
//Liquidaciones de sueldo
$arrTemporal_6 = array();
$arrTemporal_6 = db_select_array (false, return_query(3, $SIS_table_6), $SIS_table_6, return_join(2, $SIS_table_6), return_filter(2, $SIS_table_6, $z6), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_6');
//Rendiciones
$arrTemporal_7 = array();
$arrTemporal_7 = db_select_array (false, return_query(4, $SIS_table_7), $SIS_table_7, return_join(2, $SIS_table_7), return_filter(2, $SIS_table_7, $z7), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_7');
//Formulario 29 IVA
$arrTemporal_8_1 = array();
$arrTemporal_8_1 = db_select_array (false, return_query(5, $SIS_table_8), $SIS_table_8, return_join(3, $SIS_table_8), return_filter(3, $SIS_table_8, $z8_1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_8_1');
//Formulario 29 PPM
$arrTemporal_8_2 = array();
$arrTemporal_8_2 = db_select_array (false, return_query(6, $SIS_table_8), $SIS_table_8, return_join(4, $SIS_table_8), return_filter(4, $SIS_table_8, $z8_2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_8_2');
//Formulario 29 Retenciones
$arrTemporal_8_3 = array();
$arrTemporal_8_3 = db_select_array (false, return_query(7, $SIS_table_8), $SIS_table_8, return_join(5, $SIS_table_8), return_filter(5, $SIS_table_8, $z8_3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_8_3');
//Formulario 29 Impuesto a la Renta
$arrTemporal_8_4 = array();
$arrTemporal_8_4 = db_select_array (false, return_query(8, $SIS_table_8), $SIS_table_8, return_join(6, $SIS_table_8), return_filter(6, $SIS_table_8, $z8_4), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_8_4');
//Previred AFP
$arrTemporal_9_1 = array();
$arrTemporal_9_1 = db_select_array (false, return_query(9, $SIS_table_9), $SIS_table_9, return_join(7, $SIS_table_9), return_filter(7, $SIS_table_9, $z9_1), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_9_1');
//Previred SALUD
$arrTemporal_9_2 = array();
$arrTemporal_9_2 = db_select_array (false, return_query(10, $SIS_table_9), $SIS_table_9, return_join(8, $SIS_table_9), return_filter(8, $SIS_table_9, $z9_2), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_9_2');
//Previred SEGURIDAD
$arrTemporal_9_3 = array();
$arrTemporal_9_3 = db_select_array (false, return_query(11, $SIS_table_9), $SIS_table_9, return_join(9, $SIS_table_9), return_filter(9, $SIS_table_9, $z9_3), 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_9_3');

//Centro Costo
$arrCentroCosto = array();
$arrCentroCosto = db_select_array (false, 'idCentroCosto, Nombre', 'centrocosto_listado', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');
//Centro Costo
$arrCentroCosto_lv1 = array();
$arrCentroCosto_lv1 = db_select_array (false, 'idLevel_1, Nombre', 'centrocosto_listado_level_1', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');
//Centro Costo
$arrCentroCosto_lv2 = array();
$arrCentroCosto_lv2 = db_select_array (false, 'idLevel_2, Nombre', 'centrocosto_listado_level_2', '', '', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTemporal_4');

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
foreach ($arrCentroCosto as $trab) {     $arrCC[$trab['idCentroCosto']] = $trab['Nombre'];}
foreach ($arrCentroCosto_lv1 as $trab) { $arrCC_lv1[$trab['idLevel_1']] = $trab['Nombre'];}
foreach ($arrCentroCosto_lv2 as $trab) { $arrCC_lv2[$trab['idLevel_2']] = $trab['Nombre'];}

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

//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('G1', 'INGRESOS')
            ->setCellValue('J1', 'EGRESOS')
            ->setCellValue('M1', 'COSTOS')
            ->setCellValue('A2', 'Tipo')
            ->setCellValue('B2', 'Año')
            ->setCellValue('C2', 'Mes')
            ->setCellValue('D2', 'Area')
            ->setCellValue('E2', 'Servicio')
            ->setCellValue('F2', 'Cliente')
            ->setCellValue('G2', 'Telemetría')
            ->setCellValue('H2', 'Instalación')
            ->setCellValue('I2', 'Servicio Técnico')
            ->setCellValue('J2', 'Telemetría')
            ->setCellValue('K2', 'Instalación')
            ->setCellValue('L2', 'Servicio Técnico')
            ->setCellValue('M2', 'Costos')
            ->setCellValue('N2', 'Margen pesos telemetría')
            ->setCellValue('O2', '%')
            ->setCellValue('P2', 'Margen pesos Instalación')
            ->setCellValue('Q2', '%')
            ->setCellValue('R2', 'Margen pesos Servicio técnico')
            ->setCellValue('S2', '%')
            ->setCellValue('T2', 'Total margen cliente')
            ->setCellValue('U2', '%');

$nn                         = 3;
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

/**********************************************************/
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
		//divisiones
		if(isset($trab['ING_Telemetria'])&&$trab['ING_Telemetria']!=0){           $prc_1 = porcentaje($margen_tel/$trab['ING_Telemetria']);        }else{$prc_1 = '0 %';}
		if(isset($trab['ING_Instalacion'])&&$trab['ING_Instalacion']!=0){         $prc_2 = porcentaje($margen_ins/$trab['ING_Instalacion']);       }else{$prc_2 = '0 %';}
		if(isset($trab['ING_ServicioTecnico'])&&$trab['ING_ServicioTecnico']!=0){ $prc_3 = porcentaje($margen_serv/$trab['ING_ServicioTecnico']);  }else{$prc_3 = '0 %';}
		if(isset($ing_total)&&$ing_total!=0){                                     $prc_4 = porcentaje($margen_total/$ing_total);                   }else{$prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Arriendos')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, $trab['ING_Telemetria'])
					->setCellValue('H'.$nn, $trab['ING_Instalacion'])
					->setCellValue('I'.$nn, $trab['ING_ServicioTecnico'])
					->setCellValue('J'.$nn, $trab['EG_Telemetria'])
					->setCellValue('K'.$nn, $trab['EG_Instalacion'])
					->setCellValue('L'.$nn, $trab['EG_ServicioTecnico'])
					->setCellValue('M'.$nn, '')
					->setCellValue('N'.$nn, $margen_tel)
					->setCellValue('O'.$nn, $prc_1)
					->setCellValue('P'.$nn, $margen_ins)
					->setCellValue('Q'.$nn, $prc_2)
					->setCellValue('R'.$nn, $margen_serv)
					->setCellValue('S'.$nn, $prc_3)
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
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
		//divisiones
		if(isset($trab['ING_Telemetria'])&&$trab['ING_Telemetria']!=0){           $prc_1 = porcentaje($margen_tel/$trab['ING_Telemetria']);        }else{$prc_1 = '0 %';}
		if(isset($trab['ING_Instalacion'])&&$trab['ING_Instalacion']!=0){         $prc_2 = porcentaje($margen_ins/$trab['ING_Instalacion']);       }else{$prc_2 = '0 %';}
		if(isset($trab['ING_ServicioTecnico'])&&$trab['ING_ServicioTecnico']!=0){ $prc_3 = porcentaje($margen_serv/$trab['ING_ServicioTecnico']);  }else{$prc_3 = '0 %';}
		if(isset($ing_total)&&$ing_total!=0){                                     $prc_4 = porcentaje($margen_total/$ing_total);                   }else{$prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Arriendos')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, $trab['ING_Telemetria'])
					->setCellValue('H'.$nn, $trab['ING_Instalacion'])
					->setCellValue('I'.$nn, $trab['ING_ServicioTecnico'])
					->setCellValue('J'.$nn, $trab['EG_Telemetria'])
					->setCellValue('K'.$nn, $trab['EG_Instalacion'])
					->setCellValue('L'.$nn, $trab['EG_ServicioTecnico'])
					->setCellValue('M'.$nn, '')
					->setCellValue('N'.$nn, $margen_tel)
					->setCellValue('O'.$nn, $prc_1)
					->setCellValue('P'.$nn, $margen_ins)
					->setCellValue('Q'.$nn, $prc_2)
					->setCellValue('R'.$nn, $margen_serv)
					->setCellValue('S'.$nn, $prc_3)
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
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
		//divisiones
		if(isset($trab['ING_Telemetria'])&&$trab['ING_Telemetria']!=0){           $prc_1 = porcentaje($margen_tel/$trab['ING_Telemetria']);        }else{$prc_1 = '0 %';}
		if(isset($trab['ING_Instalacion'])&&$trab['ING_Instalacion']!=0){         $prc_2 = porcentaje($margen_ins/$trab['ING_Instalacion']);       }else{$prc_2 = '0 %';}
		if(isset($trab['ING_ServicioTecnico'])&&$trab['ING_ServicioTecnico']!=0){ $prc_3 = porcentaje($margen_serv/$trab['ING_ServicioTecnico']);  }else{$prc_3 = '0 %';}
		if(isset($ing_total)&&$ing_total!=0){                                     $prc_4 = porcentaje($margen_total/$ing_total);                   }else{$prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Arriendos')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, $trab['ING_Telemetria'])
					->setCellValue('H'.$nn, $trab['ING_Instalacion'])
					->setCellValue('I'.$nn, $trab['ING_ServicioTecnico'])
					->setCellValue('J'.$nn, $trab['EG_Telemetria'])
					->setCellValue('K'.$nn, $trab['EG_Instalacion'])
					->setCellValue('L'.$nn, $trab['EG_ServicioTecnico'])
					->setCellValue('M'.$nn, '')
					->setCellValue('N'.$nn, $margen_tel)
					->setCellValue('O'.$nn, $prc_1)
					->setCellValue('P'.$nn, $margen_ins)
					->setCellValue('Q'.$nn, $prc_2)
					->setCellValue('R'.$nn, $margen_serv)
					->setCellValue('S'.$nn, $prc_3)
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
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
		//divisiones
		if(isset($trab['ING_Telemetria'])&&$trab['ING_Telemetria']!=0){           $prc_1 = porcentaje($margen_tel/$trab['ING_Telemetria']);        }else{$prc_1 = '0 %';}
		if(isset($trab['ING_Instalacion'])&&$trab['ING_Instalacion']!=0){         $prc_2 = porcentaje($margen_ins/$trab['ING_Instalacion']);       }else{$prc_2 = '0 %';}
		if(isset($trab['ING_ServicioTecnico'])&&$trab['ING_ServicioTecnico']!=0){ $prc_3 = porcentaje($margen_serv/$trab['ING_ServicioTecnico']);  }else{$prc_3 = '0 %';}
		if(isset($ing_total)&&$ing_total!=0){                                     $prc_4 = porcentaje($margen_total/$ing_total);                   }else{$prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Arriendos')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, $trab['ING_Telemetria'])
					->setCellValue('H'.$nn, $trab['ING_Instalacion'])
					->setCellValue('I'.$nn, $trab['ING_ServicioTecnico'])
					->setCellValue('J'.$nn, $trab['EG_Telemetria'])
					->setCellValue('K'.$nn, $trab['EG_Instalacion'])
					->setCellValue('L'.$nn, $trab['EG_ServicioTecnico'])
					->setCellValue('M'.$nn, '')
					->setCellValue('N'.$nn, $margen_tel)
					->setCellValue('O'.$nn, $prc_1)
					->setCellValue('P'.$nn, $margen_ins)
					->setCellValue('Q'.$nn, $prc_2)
					->setCellValue('R'.$nn, $margen_serv)
					->setCellValue('S'.$nn, $prc_3)
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[5]!=false && !empty($arrTemp[5]) && $arrTemp[5]!=''){
	foreach ($arrTemp[5] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[6]!=false && !empty($arrTemp[6]) && $arrTemp[6]!=''){
	foreach ($arrTemp[6] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[7]!=false && !empty($arrTemp[7]) && $arrTemp[7]!=''){
	foreach ($arrTemp[7] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[8]!=false && !empty($arrTemp[8]) && $arrTemp[8]!=''){
	foreach ($arrTemp[8] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[9]!=false && !empty($arrTemp[9]) && $arrTemp[9]!=''){
	foreach ($arrTemp[9] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[10]!=false && !empty($arrTemp[10]) && $arrTemp[10]!=''){
	foreach ($arrTemp[10] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[11]!=false && !empty($arrTemp[11]) && $arrTemp[11]!=''){
	foreach ($arrTemp[11] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[12]!=false && !empty($arrTemp[12]) && $arrTemp[12]!=''){
	foreach ($arrTemp[12] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[13]!=false && !empty($arrTemp[13]) && $arrTemp[13]!=''){
	foreach ($arrTemp[13] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}
/**********************************************************/
if($arrTemp[14]!=false && !empty($arrTemp[14]) && $arrTemp[14]!=''){
	foreach ($arrTemp[14] as $trab) {
		//calculos
		$margen_total   = $trab['Total']*-1;
		$ing_total      = $margen_total;
		//Totales
		$total_EG_Costos     = $total_EG_Costos + $trab['Total'];
		$total_margen_total  = $total_margen_total + $margen_total;
		$total_ing_total     = $total_ing_total + $ing_total;
		//divisiones
		if(isset($ing_total)&&$ing_total!=0){ $prc_4 = porcentaje($margen_total/$ing_total);}else{ $prc_4 = '0 %';}

		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, 'Servicios')
					->setCellValue('B'.$nn, $trab['Creacion_ano'])
					->setCellValue('C'.$nn, $trab['Creacion_mes'])
					->setCellValue('D'.$nn, DeSanitizar($trab['CentroCostoNombre']))
					->setCellValue('E'.$nn, DeSanitizar($trab['CentroCostoLVL_1']))
					->setCellValue('F'.$nn, DeSanitizar($trab['CentroCostoLVL_2']))
					->setCellValue('G'.$nn, '')
					->setCellValue('H'.$nn, '')
					->setCellValue('I'.$nn, '')
					->setCellValue('J'.$nn, '')
					->setCellValue('K'.$nn, '')
					->setCellValue('L'.$nn, '')
					->setCellValue('M'.$nn, $trab['Total'])
					->setCellValue('N'.$nn, '')
					->setCellValue('O'.$nn, '')
					->setCellValue('P'.$nn, '')
					->setCellValue('Q'.$nn, '')
					->setCellValue('R'.$nn, '')
					->setCellValue('S'.$nn, '')
					->setCellValue('T'.$nn, $margen_total)
					->setCellValue('U'.$nn, $prc_4);

		$nn++;
	}
}

if(isset($total_ING_Telemetria)&&$total_ING_Telemetria!=0){           $prc_1 = porcentaje($total_margen_tel/$total_ING_Telemetria);        }else{$prc_1 = '0 %';} 
if(isset($total_ING_Instalacion)&&$total_ING_Instalacion!=0){         $prc_2 = porcentaje($total_margen_ins/$total_ING_Instalacion);       }else{$prc_2 = '0 %';}
if(isset($total_ING_ServicioTecnico)&&$total_ING_ServicioTecnico!=0){ $prc_3 = porcentaje($total_margen_serv/$total_ING_ServicioTecnico);  }else{$prc_3 = '0 %';} 
if(isset($total_ing_total)&&$total_ing_total!=0){                     $prc_4 = porcentaje($total_margen_total/$total_ing_total);           }else{$prc_4 = '0 %';} 

//Totales
$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A'.$nn, 'Totales')
			->setCellValue('G'.$nn, $total_ING_Telemetria)
			->setCellValue('H'.$nn, $total_ING_Instalacion)
			->setCellValue('I'.$nn, $total_ING_ServicioTecnico)
			->setCellValue('J'.$nn, $total_EG_Telemetria)
			->setCellValue('K'.$nn, $total_EG_Instalacion)
			->setCellValue('L'.$nn, $total_EG_ServicioTecnico)
			->setCellValue('M'.$nn, $total_EG_Costos)
			->setCellValue('N'.$nn, $total_margen_tel)
			->setCellValue('O'.$nn, $prc_1)
			->setCellValue('P'.$nn, $total_margen_ins)
			->setCellValue('Q'.$nn, $prc_2)
			->setCellValue('R'.$nn, $total_margen_serv)
			->setCellValue('S'.$nn, $prc_3)
			->setCellValue('T'.$nn, $total_margen_total)
			->setCellValue('U'.$nn, $prc_4);

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Rentabilidad');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Informe de rentabilidad de negocio';
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
