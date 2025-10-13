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
$original = "informe_gerencial_23.php";
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
//Tablas
$table_1 = 'bodegas_arriendos_facturacion_existencias';
$table_2 = 'bodegas_insumos_facturacion_existencias';
$table_3 = 'bodegas_productos_facturacion_existencias';
$table_4 = 'bodegas_servicios_facturacion_existencias';

$sub_table_1 = 'bodegas_arriendos_facturacion';
$sub_table_2 = 'bodegas_insumos_facturacion';
$sub_table_3 = 'bodegas_productos_facturacion';
$sub_table_4 = 'bodegas_servicios_facturacion';

//Solo compras pagadas totalmente
$z1 = "(".$table_1.".idTipo=2 OR ".$table_1.".idTipo=12 OR ".$table_1.".idTipo=13 OR ".$table_1.".idTipo=1 OR ".$table_1.".idTipo=10 OR ".$table_1.".idTipo=11)";
$z2 = "(".$table_2.".idTipo=2 OR ".$table_2.".idTipo=12 OR ".$table_2.".idTipo=13 OR ".$table_2.".idTipo=1 OR ".$table_2.".idTipo=10 OR ".$table_2.".idTipo=11)";   
$z3 = "(".$table_3.".idTipo=2 OR ".$table_3.".idTipo=12 OR ".$table_3.".idTipo=13 OR ".$table_3.".idTipo=1 OR ".$table_3.".idTipo=10 OR ".$table_3.".idTipo=11)";
$z4 = "(".$table_4.".idTipo=2 OR ".$table_4.".idTipo=12 OR ".$table_4.".idTipo=13 OR ".$table_4.".idTipo=1 OR ".$table_4.".idTipo=10 OR ".$table_4.".idTipo=11)";
$z5 = "(idFacturacion!=0)";     //siempre pasa
$z6 = "(idFactTrab!=0)";        //siempre pasa
$z7 = "(idFacturacion!=0)";     //siempre pasa
$z8 = "(idFactFiscal!=0)";      //siempre pasa
$z9 = "(idFactSocial!=0)";      //siempre pasa
		
//variable
if(isset($_GET['Creacion_ano'])&&$_GET['Creacion_ano']!=''){
	//se crean cadenas
	$z1.=" AND ".$table_1.".Creacion_ano='".$_GET['Creacion_ano']."'";
	$z2.=" AND ".$table_2.".Creacion_ano='".$_GET['Creacion_ano']."'";
	$z3.=" AND ".$table_3.".Creacion_ano='".$_GET['Creacion_ano']."'";
	$z4.=" AND ".$table_4.".Creacion_ano='".$_GET['Creacion_ano']."'";
	$z5.=" AND Creacion_ano='".$_GET['Creacion_ano']."'";
	$z6.=" AND Creacion_ano='".$_GET['Creacion_ano']."'";
	$z7.=" AND Creacion_ano='".$_GET['Creacion_ano']."'";
	$z8.=" AND Pago_ano='".$_GET['Creacion_ano']."'";
	$z9.=" AND Pago_ano='".$_GET['Creacion_ano']."'";
}
//agrupaciones
$z1.=" GROUP BY ".$table_1.".idTipo, ".$table_1.".idEquipo, ".$table_1.".Creacion_mes, ".$sub_table_1.".idUsoIVA";
$z2.=" GROUP BY ".$table_2.".idTipo, ".$table_2.".idProducto, ".$table_2.".Creacion_mes, ".$sub_table_2.".idUsoIVA";
$z3.=" GROUP BY ".$table_3.".idTipo, ".$table_3.".idProducto, ".$table_3.".Creacion_mes, ".$sub_table_3.".idUsoIVA";
$z4.=" GROUP BY ".$table_4.".idTipo, ".$table_4.".idServicio, ".$table_4.".Creacion_mes, ".$sub_table_4.".idUsoIVA";
$z5.=" GROUP BY idTipo, Creacion_mes";
$z6.=" GROUP BY Creacion_mes";
$z7.=" GROUP BY Creacion_mes";
$z8.=" GROUP BY Pago_mes";
$z9.=" GROUP BY Pago_mes";						
/*************************************************************************************************/
//filtro
$SIS_query1 = ''.$table_1.'.idTipo, '.$table_1.'.idEquipo AS Ident,   '.$table_1.'.Creacion_mes, SUM('.$table_1.'.ValorTotal) AS ValorNeto, '.$sub_table_1.'.idUsoIVA';
$SIS_query2 = ''.$table_2.'.idTipo, '.$table_2.'.idProducto AS Ident, '.$table_2.'.Creacion_mes, SUM('.$table_2.'.ValorTotal) AS ValorNeto, '.$sub_table_2.'.idUsoIVA';
$SIS_query3 = ''.$table_3.'.idTipo, '.$table_3.'.idProducto AS Ident, '.$table_3.'.Creacion_mes, SUM('.$table_3.'.ValorTotal) AS ValorNeto, '.$sub_table_3.'.idUsoIVA';
$SIS_query4 = ''.$table_4.'.idTipo, '.$table_4.'.idServicio AS Ident, '.$table_4.'.Creacion_mes, SUM('.$table_4.'.ValorTotal) AS ValorNeto, '.$sub_table_4.'.idUsoIVA';
$SIS_query5 = 'idTipo, Creacion_mes, SUM(ValorNeto) AS ValorNeto';
$SIS_query6 = 'Creacion_mes, SUM(TotalAPagar) AS ValorNeto';
$SIS_query7 = 'Creacion_mes, SUM(Valor) AS ValorNeto';
$SIS_query8 = 'Pago_mes AS Creacion_mes, SUM(TotalGeneral) AS ValorNeto';
$SIS_query9 = 'Pago_mes AS Creacion_mes, SUM(TotalGeneral) AS ValorNeto';
//Bodega de Arriendos
$arrTemporal_1 = array();
$arrTemporal_1 = db_select_array (false, $SIS_query1, $table_1, 'LEFT JOIN '.$sub_table_1.' ON '.$sub_table_1.'.idFacturacion = '.$table_1.'.idFacturacion', $z1, ''.$table_1.'.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_1');
//Bodega de Insumos
$arrTemporal_2 = array();
$arrTemporal_2 = db_select_array (false, $SIS_query2, $table_2, 'LEFT JOIN '.$sub_table_2.' ON '.$sub_table_2.'.idFacturacion = '.$table_2.'.idFacturacion', $z2, ''.$table_2.'.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_2');
//Bodega de Productos
$arrTemporal_3 = array();
$arrTemporal_3 = db_select_array (false, $SIS_query3, $table_3, 'LEFT JOIN '.$sub_table_3.' ON '.$sub_table_3.'.idFacturacion = '.$table_3.'.idFacturacion', $z3, ''.$table_3.'.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_3');
//Bodega de Servicios
$arrTemporal_4 = array();
$arrTemporal_4 = db_select_array (false, $SIS_query4, $table_4, 'LEFT JOIN '.$sub_table_4.' ON '.$sub_table_4.'.idFacturacion = '.$table_4.'.idFacturacion', $z4, ''.$table_4.'.idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_4');
//Boleta de honorarios
$arrTemporal_5 = array();
$arrTemporal_5 = db_select_array (false, $SIS_query5, 'boleta_honorarios_facturacion', '', $z5, 'idTipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_5');
//Liquidaciones de sueldo
$arrTemporal_6 = array();
$arrTemporal_6 = db_select_array (false, $SIS_query6, 'rrhh_sueldos_facturacion_trabajadores', '', $z6, 'Creacion_mes ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_6');
//Rendiciones
$arrTemporal_7 = array();
$arrTemporal_7 = db_select_array (false, $SIS_query7, 'contab_caja_gastos', '', $z7, 'Creacion_mes ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_7');
//Formulario 29
$arrTemporal_8 = array();
$arrTemporal_8 = db_select_array (false, $SIS_query8, 'pagos_leyes_fiscales', '', $z8, 'Pago_mes ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8');
//Pago Previred
$arrTemporal_9 = array();
$arrTemporal_9 = db_select_array (false, $SIS_query9, 'pagos_leyes_sociales', '', $z9, 'Pago_mes ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTemporal_8');

//Selecciono los equipos en arriendo
$arrArriendos = array();
$arrArriendos = db_select_array (false, 'idEquipo AS Ident, Nombre', 'equipos_arriendo_listado', '', 'idEstado=1', 'idEquipo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrArriendos');
//Selecciono los insumos
$arrInsumos = array();
$arrInsumos = db_select_array (false, 'idProducto AS Ident, Nombre', 'insumos_listado', '', 'idEstado=1', 'idProducto ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrInsumos');
//Selecciono los productos
$arrProductos = array();
$arrProductos = db_select_array (false, 'idProducto AS Ident, Nombre', 'productos_listado', '', 'idEstado=1', 'idProducto ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');
//Selecciono los servicios
$arrServicios = array();
$arrServicios = db_select_array (false, 'idServicio AS Ident, Nombre', 'servicios_listado', '', 'idEstado=1', 'idServicio ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrServicios');

/*************************************************************************************************/
//Creo los datos
$arrTemp_1 = array();//arriendos
$arrTemp_2 = array();//insumos
$arrTemp_3 = array();//productos
$arrTemp_4 = array();//servicios
$arrTemp_5 = array();//boletas de honorarios
$arrTemp_6 = array();//liquidaciones de sueldo
$arrTemp_7 = array();//Rendiciones
$arrTemp_8 = array();//Formulario 29
$arrTemp_9 = array();//Pago Previred
/********************************************/
//recorro los arriendos
foreach ($arrTemporal_1 as $trab) {
	//se busca el tipo
	switch ($trab['idTipo']) {
		case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Venta
		case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Cliente
		case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Cliente
		case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Compra
		case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Proveedor
		case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Proveedor
	}
	//se guardan los datos
	if(isset($trab['idUsoIVA'])&&$trab['idUsoIVA']==2){
		if(isset($arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'])){
			$arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] + $ValorNeto;
		}else{
			$arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $ValorNeto;
		}
	}else{
		if(isset($arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'])){
			$arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] + $ValorNeto;
		}else{
			$arrTemp_1[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $ValorNeto;
		}
	}
}
/********************************************/
//recorro los insumos
foreach ($arrTemporal_2 as $trab) {
	//se busca el tipo
	switch ($trab['idTipo']) {
		case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Venta
		case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Cliente
		case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Cliente
		case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Compra
		case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Proveedor
		case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Proveedor
	}
	//se guardan los datos
	if(isset($trab['idUsoIVA'])&&$trab['idUsoIVA']==2){
		if(isset($arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'])){
			$arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] + $ValorNeto;
		}else{
			$arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $ValorNeto;
		}
	}else{
		if(isset($arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'])){
			$arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] + $ValorNeto;
		}else{
			$arrTemp_2[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $ValorNeto;
		}
	}
}
/********************************************/
//recorro los productos
foreach ($arrTemporal_3 as $trab) {
	//se busca el tipo
	switch ($trab['idTipo']) {
		case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Venta
		case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Cliente
		case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Cliente
		case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Compra
		case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Proveedor
		case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Proveedor
	}
	//se guardan los datos
	if(isset($trab['idUsoIVA'])&&$trab['idUsoIVA']==2){
		if(isset($arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'])){
			$arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] + $ValorNeto;
		}else{
			$arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $ValorNeto;
		}
	}else{
		if(isset($arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'])){
			$arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] + $ValorNeto;
		}else{
			$arrTemp_3[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $ValorNeto;
		}
	}
}
/********************************************/
//recorro los servicios
foreach ($arrTemporal_4 as $trab) {
	//se busca el tipo
	switch ($trab['idTipo']) {
		case 2:  $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Venta
		case 12: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Cliente
		case 13: $x_idTipo = 2; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Cliente
		case 1:  $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Compra
		case 10: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto'];     break; //Nota Debito Proveedor
		case 11: $x_idTipo = 1; $ValorNeto = $trab['ValorNeto']*-1;  break; //Nota Credito Proveedor
	}
	//se guardan los datos
	if(isset($trab['idUsoIVA'])&&$trab['idUsoIVA']==2){
		if(isset($arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'])){
			$arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] + $ValorNeto;
		}else{
			$arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['ConIVA'] = $ValorNeto;
		}
	}else{
		if(isset($arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'])){
			$arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] + $ValorNeto;
		}else{
			$arrTemp_4[$x_idTipo][$trab['Ident']][$trab['Creacion_mes']]['SinIVA'] = $ValorNeto;
		}
	}
}

/********************************************/
//recorro los boletas de honorarios
foreach ($arrTemporal_5 as $trab) {
	if(isset($arrTemp_5[$trab['idTipo']][$trab['Creacion_mes']])){
		$arrTemp_5[$trab['idTipo']][$trab['Creacion_mes']] = $arrTemp_5[$trab['idTipo']][$trab['Creacion_mes']] + $trab['ValorNeto'];
	}else{
		$arrTemp_5[$trab['idTipo']][$trab['Creacion_mes']] = $trab['ValorNeto'];
	}
}
/********************************************/
//recorro los liquidaciones de sueldo
foreach ($arrTemporal_6 as $trab) {
	if(isset($arrTemp_6[$trab['Creacion_mes']])){
		$arrTemp_6[$trab['Creacion_mes']] = $arrTemp_6[$trab['Creacion_mes']] + $trab['ValorNeto'];
	}else{
		$arrTemp_6[$trab['Creacion_mes']] = $trab['ValorNeto'];
	}
}
/********************************************/
//recorro las Rendiciones
foreach ($arrTemporal_7 as $trab) {
	if(isset($arrTemp_7[$trab['Creacion_mes']])){
		$arrTemp_7[$trab['Creacion_mes']] = $arrTemp_7[$trab['Creacion_mes']] + $trab['ValorNeto'];
	}else{
		$arrTemp_7[$trab['Creacion_mes']] = $trab['ValorNeto'];
	}
}
/********************************************/
//recorro los Formulario 29
foreach ($arrTemporal_8 as $trab) {
	if(isset($arrTemp_8[$trab['Creacion_mes']])){
		$arrTemp_8[$trab['Creacion_mes']] = $arrTemp_8[$trab['Creacion_mes']] + $trab['ValorNeto'];
	}else{
		$arrTemp_8[$trab['Creacion_mes']] = $trab['ValorNeto'];
	}
}
/********************************************/
//recorro los Pago Previred
foreach ($arrTemporal_9 as $trab) {
	if(isset($arrTemp_9[$trab['Creacion_mes']])){
		$arrTemp_9[$trab['Creacion_mes']] = $arrTemp_9[$trab['Creacion_mes']] + $trab['ValorNeto'];
	}else{
		$arrTemp_9[$trab['Creacion_mes']] = $trab['ValorNeto'];
	}
}



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Informe de rentabilidad de negocio</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">			  
				<tbody role="alert" aria-live="polite" aria-relevant="all">

					<tr class="odd" style="background-color: #d2d2d2;">
						<td></td>
						<td><strong>Enero</strong></td>
						<td><strong>Febrero</strong></td>
						<td><strong>Marzo</strong></td>
						<td><strong>Abril</strong></td>
						<td><strong>Mayo</strong></td>
						<td><strong>Junio</strong></td>
						<td><strong>Julio</strong></td>
						<td><strong>Agosto</strong></td>
						<td><strong>Septiembre</strong></td>
						<td><strong>Octubre</strong></td>
						<td><strong>Noviembre</strong></td>
						<td><strong>diciembre</strong></td>
						<td><strong>Total</strong></td>
					</tr>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//Variable
					$arrTotColIngCIVA  = array();  //Ingresos con Iva
					$arrTotColIngSIVA  = array();  //Ingresos sin Iva
					$arrTotColIngGEN   = array();  //Totales con IVA sumado
					$arrTotColEgCIVA   = array();  //Egresos con Iva
					$arrTotColEgSIVA   = array();  //Egresos sin Iva
					$arrTotColEgGEN    = array();  //Totales con IVA sumado
					$arrTotalCIVA      = array();  //Totales con Iva
					$arrTotalSIVA      = array();  //Totales sin Iva
					$arrTotColIVA      = array();  //Totales de Iva
					$PRCIVA            = 0.19;     //Porcentaje del IVA
					$arrTotColGastos   = array();  //Gastos
					$arrTotGastos      = array();  //Gastos
					$arrTotalGeneral   = array();  //Total general
					//creo variables en 0
					for ($i = 1; $i <= 12; $i++) {
						$arrTotColIngCIVA[$i] = 0;
						$arrTotColIngSIVA[$i] = 0;
						$arrTotColEgCIVA[$i]  = 0;
						$arrTotColEgSIVA[$i]  = 0;
						$arrTotColGastos[$i]  = 0;
					}
					?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #d2d2d2;">
						<td><strong>Ingresos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Arriendos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrArriendos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_1[2][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_1[2][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_1[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_1[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotColIngCIVA[$i] = $arrTotColIngCIVA[$i]  + $arrTemp_1[2][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_1[2][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_1[2][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_1[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_1[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotColIngSIVA[$i] = $arrTotColIngSIVA[$i]  + $arrTemp_1[2][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Insumos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrInsumos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_2[2][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_2[2][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_2[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_2[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotColIngCIVA[$i] = $arrTotColIngCIVA[$i]  + $arrTemp_2[2][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_2[2][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_2[2][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_2[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_2[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotColIngSIVA[$i] = $arrTotColIngSIVA[$i]  + $arrTemp_2[2][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Productos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrProductos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_3[2][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_3[2][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_3[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_3[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotColIngCIVA[$i] = $arrTotColIngCIVA[$i]  + $arrTemp_3[2][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_3[2][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_3[2][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_3[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_3[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotColIngSIVA[$i] = $arrTotColIngSIVA[$i]  + $arrTemp_3[2][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Servicios</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrServicios as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_4[2][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_4[2][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_4[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_4[2][$trab['Ident']][$i]['ConIVA'];
								$arrTotColIngCIVA[$i] = $arrTotColIngCIVA[$i]  + $arrTemp_4[2][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_4[2][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_4[2][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_4[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_4[2][$trab['Ident']][$i]['SinIVA'];
								$arrTotColIngSIVA[$i] = $arrTotColIngSIVA[$i]  + $arrTemp_4[2][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					$Sub_IVA    = 0;
					$Sub_GEN    = 0;
					$Total_acu  = 0;
					//Calculo del IVA
					for ($i = 1; $i <= 12; $i++) {
						$arrTotColIVA[$i] = $arrTotColIngCIVA[$i] * $PRCIVA;
						$Sub_IVA          = $arrTotColIngCIVA[$i] + $Sub_IVA;
					}
					$arrTotColIVA[13] = $Sub_IVA * $PRCIVA;
					//Calculo de los totales
					for ($i = 1; $i <= 12; $i++) {
						$arrTotColIngGEN[$i] = $arrTotColIVA[$i] + $arrTotColIngCIVA[$i] + $arrTotColIngSIVA[$i];
						$Sub_GEN             = $arrTotColIngGEN[$i] + $Sub_GEN;
					}
					$arrTotColIngGEN[13] = $Sub_GEN;

					//Total Afecto al IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Afecto al IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColIngCIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Afecto al IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total No Afecto al IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColIngSIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Mes
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Mes</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColIngGEN[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Acumulado
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Acumulado</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							$Total_acu = $Total_acu + $arrTotColIngGEN[$i];
							echo '<td align="right">'.valores($Total_acu, 0).'</td>';
						}
					echo '</tr>';
					
					?>
					<tr class="odd" style="background-color: #ffffff;">
						<td colspan="14"></td>
					</tr>

					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #d2d2d2;">
						<td><strong>Egresos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Arriendos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrArriendos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_1[1][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_1[1][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_1[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_1[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotColEgCIVA[$i]  = $arrTotColEgCIVA[$i] + $arrTemp_1[1][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_1[1][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_1[1][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_1[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_1[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotColEgSIVA[$i]  = $arrTotColEgSIVA[$i] + $arrTemp_1[1][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Insumos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrInsumos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_2[1][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_2[1][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_2[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_2[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotColEgCIVA[$i]  = $arrTotColEgCIVA[$i] + $arrTemp_2[1][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_2[1][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_2[1][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_2[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_2[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotColEgSIVA[$i]  = $arrTotColEgSIVA[$i] + $arrTemp_2[1][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Productos</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrProductos as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_3[1][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_3[1][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_3[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_3[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotColEgCIVA[$i]  = $arrTotColEgCIVA[$i] + $arrTemp_3[1][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_3[1][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_3[1][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_3[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_3[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotColEgSIVA[$i]  = $arrTotColEgSIVA[$i] + $arrTemp_3[1][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #e4e4e4;">
						<td><strong>Servicios</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php
					//recorro
					foreach ($arrServicios as $trab) {
						//creo variables en 0
						for ($i = 1; $i <= 13; $i++) {
							$arrTotalCIVA[$i] = 0;
							$arrTotalSIVA[$i] = 0;
						}
						for ($i = 1; $i <= 12; $i++) {
							if(isset($arrTemp_4[1][$trab['Ident']][$i]['ConIVA'])&&$arrTemp_4[1][$trab['Ident']][$i]['ConIVA']!=''){
								$arrTotalCIVA[$i]     = $arrTotalCIVA[$i] + $arrTemp_4[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotalCIVA[13]     = $arrTotalCIVA[13] + $arrTemp_4[1][$trab['Ident']][$i]['ConIVA'];
								$arrTotColEgCIVA[$i]  = $arrTotColEgCIVA[$i] + $arrTemp_4[1][$trab['Ident']][$i]['ConIVA'];
							} 
							if(isset($arrTemp_4[1][$trab['Ident']][$i]['SinIVA'])&&$arrTemp_4[1][$trab['Ident']][$i]['SinIVA']!=''){
								$arrTotalSIVA[$i]     = $arrTotalSIVA[$i] + $arrTemp_4[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotalSIVA[13]     = $arrTotalSIVA[13] + $arrTemp_4[1][$trab['Ident']][$i]['SinIVA'];
								$arrTotColEgSIVA[$i]  = $arrTotColEgSIVA[$i] + $arrTemp_4[1][$trab['Ident']][$i]['SinIVA'];
							}
						}
						//Recorro los que tienen IVA
						if($arrTotalCIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>Afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalCIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						} 			
						//Recorro los que no tienen IVA
						if($arrTotalSIVA[13]!=0){
							echo '<tr class="odd">';
								echo '<td><strong>No afecto a IVA:</strong> '.$trab['Nombre'].'</td>';
								for ($i = 1; $i <= 13; $i++) {
									echo '<td align="right">'.valores($arrTotalSIVA[$i], 0).'</td>';
								}
							echo '</tr>';
						}
						?>
					<?php } ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					$Sub_IVA    = 0;
					$Sub_GEN    = 0;
					$Total_acu  = 0;
					//Calculo del IVA
					for ($i = 1; $i <= 12; $i++) {
						$arrTotColIVA[$i] = $arrTotColEgCIVA[$i] * $PRCIVA;
						$Sub_IVA          = $arrTotColEgCIVA[$i] + $Sub_IVA;
					}
					$arrTotColIVA[13] = $Sub_IVA * $PRCIVA;
					//Calculo de los totales
					for ($i = 1; $i <= 12; $i++) {
						$arrTotColEgGEN[$i] = $arrTotColIVA[$i] + $arrTotColEgCIVA[$i] + $arrTotColEgSIVA[$i];
						$Sub_GEN            = $arrTotColEgGEN[$i] + $Sub_GEN;
					}
					$arrTotColEgGEN[13] = $Sub_GEN;

					//Total Afecto al IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Afecto al IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColEgCIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Afecto al IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total No Afecto al IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColEgSIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//IVA
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>IVA</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColIVA[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Mes
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Mes</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColEgGEN[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Acumulado
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Acumulado</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							$Total_acu = $Total_acu + $arrTotColEgGEN[$i];
							echo '<td align="right">'.valores($Total_acu, 0).'</td>';
						}
					echo '</tr>';
					
					?>
					<tr class="odd" style="background-color: #ffffff;">
						<td colspan="14"></td>
					</tr>

					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<tr class="odd" style="background-color: #d2d2d2;">
						<td><strong>Gastos Generales</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					for ($i = 1; $i <= 13; $i++) {
						$arrTotGastos[$i] = 0;
					}
					for ($i = 1; $i <= 12; $i++) {
						if(isset($arrTemp_5[1][$i])&&$arrTemp_5[1][$i]!=''){   
							$arrTotGastos[$i]    = $arrTotGastos[$i] + $arrTemp_5[1][$i];
							$arrTotGastos[13]    = $arrTotGastos[13] + $arrTemp_5[1][$i];
							$arrTotColGastos[$i] = $arrTotColGastos[$i]  + $arrTemp_5[1][$i];
						}
					}
					//Recorro los que tienen IVA
					if($arrTotGastos[13]!=0){
						echo '<tr class="odd">';
							echo '<td>Boletas de Honorarios</td>';
							for ($i = 1; $i <= 13; $i++) {
								echo '<td align="right">'.valores($arrTotGastos[$i], 0).'</td>';
							}
						echo '</tr>';
					} ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					for ($i = 1; $i <= 13; $i++) {
						$arrTotGastos[$i] = 0;
					}
					for ($i = 1; $i <= 12; $i++) {
						if(isset($arrTemp_6[$i])&&$arrTemp_6[$i]!=''){   
							$arrTotGastos[$i]    = $arrTotGastos[$i] + $arrTemp_6[$i];
							$arrTotGastos[13]    = $arrTotGastos[13] + $arrTemp_6[$i];
							$arrTotColGastos[$i] = $arrTotColGastos[$i]  + $arrTemp_6[$i];
						}
					}
					//Recorro los que tienen IVA
					if($arrTotGastos[13]!=0){
						echo '<tr class="odd">';
							echo '<td>Liquidaciones de sueldo</td>';
							for ($i = 1; $i <= 13; $i++) {
								echo '<td align="right">'.valores($arrTotGastos[$i], 0).'</td>';
							}
						echo '</tr>';
					} ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					for ($i = 1; $i <= 13; $i++) {
						$arrTotGastos[$i] = 0;
					}
					for ($i = 1; $i <= 12; $i++) {
						if(isset($arrTemp_7[$i])&&$arrTemp_7[$i]!=''){   
							$arrTotGastos[$i]    = $arrTotGastos[$i] + $arrTemp_7[$i];
							$arrTotGastos[13]    = $arrTotGastos[13] + $arrTemp_7[$i];
							$arrTotColGastos[$i] = $arrTotColGastos[$i]  + $arrTemp_7[$i];
						}
					}
					//Recorro los que tienen IVA
					if($arrTotGastos[13]!=0){
						echo '<tr class="odd">';
							echo '<td>Rendiciones</td>';
							for ($i = 1; $i <= 13; $i++) {
								echo '<td align="right">'.valores($arrTotGastos[$i], 0).'</td>';
							}
						echo '</tr>';
					} ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					for ($i = 1; $i <= 13; $i++) {
						$arrTotGastos[$i] = 0;
					}
					for ($i = 1; $i <= 12; $i++) {
						if(isset($arrTemp_8[$i])&&$arrTemp_8[$i]!=''){   
							$arrTotGastos[$i]    = $arrTotGastos[$i] + $arrTemp_8[$i];
							$arrTotGastos[13]    = $arrTotGastos[13] + $arrTemp_8[$i];
							$arrTotColGastos[$i] = $arrTotColGastos[$i]  + $arrTemp_8[$i];
						}
					}
					//Recorro los que tienen IVA
					if($arrTotGastos[13]!=0){
						echo '<tr class="odd">';
							echo '<td>Formulario 29</td>';
							for ($i = 1; $i <= 13; $i++) {
								echo '<td align="right">'.valores($arrTotGastos[$i], 0).'</td>';
							}
						echo '</tr>';
					} ?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					for ($i = 1; $i <= 13; $i++) {
						$arrTotGastos[$i] = 0;
					}
					for ($i = 1; $i <= 12; $i++) {
						if(isset($arrTemp_9[$i])&&$arrTemp_9[$i]!=''){   
							$arrTotGastos[$i]    = $arrTotGastos[$i] + $arrTemp_9[$i];
							$arrTotGastos[13]    = $arrTotGastos[13] + $arrTemp_9[$i];
							$arrTotColGastos[$i] = $arrTotColGastos[$i]  + $arrTemp_9[$i];
						}
					}
					//Recorro los que tienen IVA
					if($arrTotGastos[13]!=0){
						echo '<tr class="odd">';
							echo '<td>Previred</td>';
							for ($i = 1; $i <= 13; $i++) {
								echo '<td align="right">'.valores($arrTotGastos[$i], 0).'</td>';
							}
						echo '</tr>';
					} 
					?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					$Total_acu  = 0;
					//Total Mes
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Mes</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotColGastos[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Acumulado
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Acumulado</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							$Total_acu = $Total_acu + $arrTotColGastos[$i];
							echo '<td align="right">'.valores($Total_acu, 0).'</td>';
						}
					echo '</tr>';
					
					?>
					<tr class="odd" style="background-color: #ffffff;">
						<td colspan="14"></td>
					</tr>

					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php ///////////////////////////////////////////////////////////////////?>
					<?php
					//creo variables en 0
					$Total_acu  = 0;
					for ($i = 1; $i <= 13; $i++) {
						$arrTotalGeneral[$i] =  $arrTotColIngGEN[$i] - ($arrTotColEgGEN[$i] + $arrTotColGastos[$i]);
					}
					//Total Mes
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Mes</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							echo '<td align="right">'.valores($arrTotalGeneral[$i], 0).'</td>';
						}
					echo '</tr>';
					//Total Acumulado
					echo '<tr class="odd" style="background-color: #d2d2d2;">';
						echo '<td><strong>Total Acumulado</strong></td>';
						for ($i = 1; $i <= 13; $i++) {
							$Total_acu = $Total_acu + $arrTotalGeneral[$i];
							echo '<td align="right">'.valores($Total_acu, 0).'</td>';
						}
					echo '</tr>';
					?>
					



						                   
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
				if(isset($Creacion_ano)){ $x1  = $Creacion_ano;  }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_n_auto('Año','Creacion_ano', $x1, 2, 2016, ano_actual());

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
