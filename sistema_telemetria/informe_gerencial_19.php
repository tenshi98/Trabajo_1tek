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
$original = "informe_gerencial_19.php";
$location = $original;  
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
//traigo un listado con todas las empresas
$arrSistemas = array();
$query = "SELECT 
core_sistemas.idSistema,
core_sistemas.Nombre
FROM `core_sistemas`
ORDER BY core_sistemas.Nombre ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrSistemas,$row );
}

//se verifica el tipo de usuario
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$x2 = "idUsuario>=0";
}else{
	$x2 = "idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Variables
$join_1  = "INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion_existencias.idBodega";
$join_2  = "INNER JOIN usuarios_bodegas_insumos ON usuarios_bodegas_insumos.idBodega = bodegas_insumos_facturacion_existencias.idBodega";
$join_3  = "INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion_existencias.idBodega";
$where_1 = " AND usuarios_bodegas_productos.".$x2;
$where_2 = " AND usuarios_bodegas_insumos.".$x2;
$where_3 = " AND usuarios_bodegas_arriendos.".$x2;
/**********************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT idSistema, Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_productos_facturacion_existencias`
".$join_1."
".$z."
".$where_1."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}
	

$mes_prod = array();
foreach ($arrExistencias as $existencias) {
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = 0;}
	if(!isset($mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'])){ $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = 0;}
	switch ($existencias['idTipo']) {
		//Compra de Productos a bodega
		case 1:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			break;
		//Venta de Productos de bodega
		case 2:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
			break;
		//Gasto de Productos
		case 3:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] + $existencias['Valor'];
			break;
		//Traspaso de Productos entre bodegas
		case 4:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] + $existencias['Valor'];
			break;
		//Transformacion de Productos
		case 5:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] + $existencias['Valor'];
			break;
		//Traspaso de Productos a otra Empresa
		case 6:
			if($existencias['Cantidad_ing']!=0){
				$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			}else{
				$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] + $existencias['Valor'];
			}
			break;
		//Gasto de Productos en una Orden de Trabajo
		case 7:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] + $existencias['Valor'];
			break;
		//Traspaso Manual de Productos a otra Empresa
		case 8:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] + $existencias['Valor'];
			break;
		//Ingreso Manual
		case 9:
			$mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = $mes_prod[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] + $existencias['Valor'];
			break;
	}
}
								
$xmes = mes_actual();
$xaño = ano_actual();
$grafico_prod = array();
foreach ($arrSistemas as $sistema) { 
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {
										
		if($xmes>0){
			$grafico_prod[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_prod[$sistema['idSistema']][$xcontador]['año'] = $xaño;
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo3'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo3'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo3'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo3'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo4'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo4'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo4'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo4'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo5'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo5'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo5'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo5'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo6'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo6'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo6'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo6'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo7'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo7'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo7'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo7'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo8'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo8'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo8'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo8'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo9'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo9'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo9'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo9'] = 0;};
										
		}else{
			$xmes = 12;
			$xaño = $xaño-1;
			$grafico_prod[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_prod[$sistema['idSistema']][$xcontador]['año'] = $xaño;

			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo3'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo3'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo3'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo3'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo4'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo4'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo4'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo4'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo5'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo5'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo5'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo5'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo6'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo6'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo6'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo6'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo7'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo7'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo7'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo7'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo8'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo8'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo8'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo8'] = 0;};
			if(isset($mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo9'])){ $grafico_prod[$sistema['idSistema']][$xcontador]['tipo9'] = $mes_prod[$sistema['idSistema']][$xaño][$xmes]['tipo9'];}else{$grafico_prod[$sistema['idSistema']][$xcontador]['tipo9'] = 0;};

		}
		$xmes = $xmes-1;
	}
}

//Configuro lo que quiero ver
$s_prod_Ventas              = 'true';
$s_prod_Gastos              = 'true';
$s_prod_Traspasos           = 'true';
$s_prod_Transformacion      = 'true';
$s_prod_Traspaso_empresa    = 'true';
$s_prod_Gasto_OT            = 'true';
$s_prod_Traspaso_Manual     = 'true';
$s_prod_Ingreso_Manual      = 'true';
//Se crea la cadena para generar los graficos
$s_prod_data = 'tipo1';
if($s_prod_Ventas=='true'){            $s_prod_data .= ',tipo2';}
if($s_prod_Gastos=='true'){            $s_prod_data .= ',tipo3';}
if($s_prod_Traspasos=='true'){         $s_prod_data .= ',tipo4';}
if($s_prod_Transformacion=='true'){    $s_prod_data .= ',tipo5';}
if($s_prod_Traspaso_empresa=='true'){  $s_prod_data .= ',tipo6';}
if($s_prod_Gasto_OT=='true'){          $s_prod_data .= ',tipo7';}
if($s_prod_Traspaso_Manual=='true'){   $s_prod_data .= ',tipo8';}
if($s_prod_Ingreso_Manual=='true'){    $s_prod_data .= ',tipo9';}
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT idSistema, Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_insumos_facturacion_existencias`
".$join_2."
".$z."
".$where_2."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}


$mes_ins = array();
foreach ($arrExistencias as $existencias) {
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = 0;}
	if(!isset($mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'])){ $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = 0;}
	switch ($existencias['idTipo']) {
		//Compra de Productos a bodega
		case 1:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			break;
		//Venta de Productos de bodega
		case 2:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
			break;
		//Gasto de Productos
		case 3:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] + $existencias['Valor'];
			break;
		//Traspaso de Productos entre bodegas
		case 4:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] + $existencias['Valor'];
			break;
		//Transformacion de Productos
		case 5:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] + $existencias['Valor'];
			break;
		//Traspaso de Productos a otra Empresa
		case 6:
			if($existencias['Cantidad_ing']!=0){
				$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			}else{
				$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] + $existencias['Valor'];
			}
			break;
		//Gasto de Productos en una Orden de Trabajo
		case 7:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] + $existencias['Valor'];
			break;
		//Traspaso Manual de Productos a otra Empresa
		case 8:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] + $existencias['Valor'];
			break;
		//Ingreso Manual
		case 9:
			$mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = $mes_ins[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] + $existencias['Valor'];
			break;
	}
}
								
$xmes = mes_actual();
$xaño = ano_actual();
$grafico_ins = array();
foreach ($arrSistemas as $sistema) { 
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {
										
		if($xmes>0){
			$grafico_ins[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_ins[$sistema['idSistema']][$xcontador]['año'] = $xaño;
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo3'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo3'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo3'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo3'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo4'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo4'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo4'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo4'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo5'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo5'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo5'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo5'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo6'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo6'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo6'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo6'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo7'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo7'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo7'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo7'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo8'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo8'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo8'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo8'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo9'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo9'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo9'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo9'] = 0;};
										
		}else{
			$xmes = 12;
			$xaño = $xaño-1;
			$grafico_ins[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_ins[$sistema['idSistema']][$xcontador]['año'] = $xaño;

			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo3'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo3'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo3'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo3'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo4'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo4'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo4'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo4'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo5'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo5'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo5'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo5'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo6'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo6'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo6'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo6'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo7'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo7'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo7'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo7'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo8'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo8'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo8'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo8'] = 0;};
			if(isset($mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo9'])){ $grafico_ins[$sistema['idSistema']][$xcontador]['tipo9'] = $mes_ins[$sistema['idSistema']][$xaño][$xmes]['tipo9'];}else{$grafico_ins[$sistema['idSistema']][$xcontador]['tipo9'] = 0;};

		}
		$xmes = $xmes-1;
	}
}

//Configuro lo que quiero ver
$s_ins_Ventas              = 'true';
$s_ins_Gastos              = 'true';
$s_ins_Traspasos           = 'true';
$s_ins_Transformacion      = 'false';
$s_ins_Traspaso_empresa    = 'true';
$s_ins_Gasto_OT            = 'true';
$s_ins_Traspaso_Manual     = 'true';
$s_ins_Ingreso_Manual      = 'true';
//Se crea la cadena para generar los graficos
$s_ins_data = 'tipo1';
if($s_ins_Ventas=='true'){            $s_ins_data .= ',tipo2';}
if($s_ins_Gastos=='true'){            $s_ins_data .= ',tipo3';}
if($s_ins_Traspasos=='true'){         $s_ins_data .= ',tipo4';}
if($s_ins_Transformacion=='true'){    $s_ins_data .= ',tipo5';}
if($s_ins_Traspaso_empresa=='true'){  $s_ins_data .= ',tipo6';}
if($s_ins_Gasto_OT=='true'){          $s_ins_data .= ',tipo7';}
if($s_ins_Traspaso_Manual=='true'){   $s_ins_data .= ',tipo8';}
if($s_ins_Ingreso_Manual=='true'){    $s_ins_data .= ',tipo9';}

/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
/*******************************************************************************************************/
// Se trae un listado con los valores de las existencias actuales
$ano_pasado = ano_actual()-1;
$z = "WHERE Creacion_ano >= ".$ano_pasado;
//se consulta
$arrExistencias = array();
$query = "SELECT idSistema, Creacion_ano,Creacion_mes,Cantidad_ing,Cantidad_eg,idTipo,SUM(ValorTotal) AS Valor
FROM `bodegas_arriendos_facturacion_existencias`
".$join_3."
".$z."
".$where_3."
GROUP BY Creacion_ano,Creacion_mes,idTipo
ORDER BY Creacion_ano ASC, Creacion_mes ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrExistencias,$row );
}


$mes_arrie = array();
foreach ($arrExistencias as $existencias) {
	if(!isset($mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){ $mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = 0;}
	if(!isset($mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){ $mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = 0;}
	switch ($existencias['idTipo']) {
		//Compra de Productos a bodega
		case 1:
			$mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
			break;
		//Venta de Productos de bodega
		case 2:
			$mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes_arrie[$existencias['idSistema']][$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
			break;
	}
}
								
$xmes = mes_actual();
$xaño = ano_actual();
$grafico_arrie = array();
foreach ($arrSistemas as $sistema) { 
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {
										
		if($xmes>0){
			$grafico_arrie[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_arrie[$sistema['idSistema']][$xcontador]['año'] = $xaño;
			if(isset($mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_arrie[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_arrie[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_arrie[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_arrie[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};
										
		}else{
			$xmes = 12;
			$xaño = $xaño-1;
			$grafico_arrie[$sistema['idSistema']][$xcontador]['mes'] = $xmes;
			$grafico_arrie[$sistema['idSistema']][$xcontador]['año'] = $xaño;

			if(isset($mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo1'])){ $grafico_arrie[$sistema['idSistema']][$xcontador]['tipo1'] = $mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo1'];}else{$grafico_arrie[$sistema['idSistema']][$xcontador]['tipo1'] = 0;};
			if(isset($mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo2'])){ $grafico_arrie[$sistema['idSistema']][$xcontador]['tipo2'] = $mes_arrie[$sistema['idSistema']][$xaño][$xmes]['tipo2'];}else{$grafico_arrie[$sistema['idSistema']][$xcontador]['tipo2'] = 0;};

		}
		$xmes = $xmes-1;
	}
}

//Configuro lo que quiero ver
$s_arri_Ventas              = 'true';
//Se crea la cadena para generar los graficos
$s_arri_data = 'tipo1';
if($s_arri_Ventas=='true'){            $s_arri_data .= ',tipo2';}

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Sistemas</h5>
			<ul class="nav nav-tabs pull-right">
				<?php
				//variable
				$sis_count = 1;
				//arreglo
				foreach ($arrSistemas as $sistema) { 
					
					if($sis_count==1){
						echo '<li class="active"><a href="#tab_sis_'.$sis_count.'" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> '.$sistema['Nombre'].'</a></li>';
					}else{
						if($sis_count==4){
							echo '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';
						}
						echo '<li class=""><a href="#tab_sis_'.$sis_count.'" data-toggle="tab"><i class="fa fa-cog" aria-hidden="true"></i> '.$sistema['Nombre'].'</a></li>';
					}
					$sis_count++;
				} 
				if($sis_count>=4){
					echo '</ul></li>';
				}
				?>  
			</ul>
		</header>
        <div class="tab-content">

			<?php
			//variable
			$sis_count = 1;
			//arreglo
			foreach ($arrSistemas as $sistema) {
				$sis_act = '';
				if($sis_count==1){$sis_act = 'active in';}else{$sis_act = '';} ?>
				<div class="tab-pane fade <?php echo $sis_act; ?>" id="tab_sis_<?php echo $sis_count; ?>">

					<h3 class="supertittle text-primary">Productos</h3>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="box">
							<header>
								<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
								<h5>Bodega de Productos</h5>
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#tab_prod_1_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
									<li class=""><a href="#tab_prod_2_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
									<li class="dropdown">
										<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<?php if($s_prod_Ventas=='true'){ ?>            <li class=""><a href="#tab_prod_3_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
											<?php if($s_prod_Gastos=='true'){ ?>            <li class=""><a href="#tab_prod_4_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gastos</a></li><?php } ?>
											<?php if($s_prod_Traspasos=='true'){ ?>         <li class=""><a href="#tab_prod_5_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspasos</a></li><?php } ?>
											<?php if($s_prod_Transformacion=='true'){ ?>    <li class=""><a href="#tab_prod_6_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Transformacion</a></li><?php } ?>
											<?php if($s_prod_Traspaso_empresa=='true'){ ?>  <li class=""><a href="#tab_prod_7_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso otra empresa</a></li><?php } ?>
											<?php if($s_prod_Gasto_OT=='true'){ ?>          <li class=""><a href="#tab_prod_8_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gasto OT</a></li><?php } ?>
											<?php if($s_prod_Traspaso_Manual=='true'){ ?>   <li class=""><a href="#tab_prod_9_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso manual otra empresa</a></li><?php } ?>
											<?php if($s_prod_Ingreso_Manual=='true'){ ?>    <li class=""><a href="#tab_prod_10_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ingreso Manual</a></li><?php } ?>
											
										</ul>
									</li>
								</ul>
							</header>
							<div class="tab-content">

								<div class="tab-pane fade active in" id="tab_prod_1_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
												<?php
												$trans_1='';				     
												echo widget_bodega('Bodega de Productos',
																   'bodegas_productos_listado', 'bodegas_productos_facturacion_existencias', 'bodegas_productos_facturacion_tipo', 
																   'productos_listado', 'sistema_productos_uml', $s_prod_data,'prod_'.$sis_count,
																   $trans_1,$dbConn, 'usuarios_bodegas_productos', $sistema['idSistema']);	
											   ?>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tab_prod_2_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
														
											<script>
												
												google.charts.setOnLoadCallback(drawChart_prod_1_<?php echo $sis_count; ?>);

												function drawChart_prod_1_<?php echo $sis_count; ?>() {
													var data_prod_1_<?php echo $sis_count; ?> = new google.visualization.DataTable();
													data_prod_1_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
													data_prod_1_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
													data_prod_1_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

													data_prod_1_<?php echo $sis_count; ?>.addRows([
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo1']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo1']) ?>']
								
													]);

													var options = {
														title: 'Grafico <?php echo widget_nombre('tipo1'); ?>',
														hAxis: {title: 'Fechas'},
														vAxis: { title: 'Valor' },
														width: $(window).width()*0.75,
														height: 500,
														curveType: 'function',
														series: {0: {pointsVisible: true},},
														annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
														colors: ['#FFB347']
													};
													var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_1_<?php echo $sis_count; ?>'));
													chart1_<?php echo $sis_count; ?>.draw(data_prod_1_<?php echo $sis_count; ?>, options);
												}
											</script>
											<div id="chart_prod_1_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
										</div>
									</div>
								</div>

								<?php if($s_prod_Ventas=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_3_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_2_<?php echo $sis_count; ?>);

													function drawChart_prod_2_<?php echo $sis_count; ?>() {
														var data_prod_2_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_2_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_2_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_2_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_2_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo2']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo2']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo2'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_2_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_2_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_2_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Gastos=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_4_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_3_<?php echo $sis_count; ?>);

													function drawChart_prod_3_<?php echo $sis_count; ?>() {
														var data_prod_3_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_3_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_3_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_3_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_3_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo3']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo3']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo3'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_3_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_3_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_3_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Traspasos=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_5_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_4_<?php echo $sis_count; ?>);

													function drawChart_prod_4_<?php echo $sis_count; ?>() {
														var data_prod_4_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_4_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_4_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_4_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_4_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo4']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo4']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo4'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_4_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_4_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_4_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Transformacion=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_6_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_5_<?php echo $sis_count; ?>);

													function drawChart_prod_5_<?php echo $sis_count; ?>() {
														var data_prod_5_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_5_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_5_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_5_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_5_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo5']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo5']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo5'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_5_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_5_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_5_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Traspaso_empresa=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_7_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_6_<?php echo $sis_count; ?>);

													function drawChart_prod_6_<?php echo $sis_count; ?>() {
														var data_prod_6_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_6_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_6_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_6_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_6_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo6']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo6']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo6'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_6_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_6_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_6_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Gasto_OT=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_8_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_7_<?php echo $sis_count; ?>);

													function drawChart_prod_7_<?php echo $sis_count; ?>() {
														var data_prod_7_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_7_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_7_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_7_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_7_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo7']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo7']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo7'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_7_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_7_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_7_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Traspaso_Manual=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_9_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_8_<?php echo $sis_count; ?>);

													function drawChart_prod_8_<?php echo $sis_count; ?>() {
														var data_prod_8_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_8_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_8_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_8_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_8_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo8']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo8']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo8'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_8_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_8_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_8_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_prod_Ingreso_Manual=='true'){ ?>
									<div class="tab-pane fade" id="tab_prod_10_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_prod_9_<?php echo $sis_count; ?>);

													function drawChart_prod_9_<?php echo $sis_count; ?>() {
														var data_prod_9_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_prod_9_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_prod_9_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_prod_9_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_prod_9_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][1]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][2]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][3]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][4]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][5]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][6]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][7]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][8]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][9]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][10]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][11]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_prod[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo9']) ?>, '<?php echo valores_enteros($grafico_prod[$sistema['idSistema']][12]['tipo9']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo9'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_prod_9_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_prod_9_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_prod_9_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>

								
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<h3 class="supertittle text-primary">Insumos</h3>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="box">
							<header>
								<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
								<h5>Bodega de Insumos</h5>
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#tab_ins_1_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
									<li class=""><a href="#tab_ins_2_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
									<li class="dropdown">
										<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<?php if($s_ins_Ventas=='true'){ ?>            <li class=""><a href="#tab_ins_3_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
											<?php if($s_ins_Gastos=='true'){ ?>            <li class=""><a href="#tab_ins_4_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gastos</a></li><?php } ?>
											<?php if($s_ins_Traspasos=='true'){ ?>         <li class=""><a href="#tab_ins_5_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspasos</a></li><?php } ?>
											<?php if($s_ins_Transformacion=='true'){ ?>    <li class=""><a href="#tab_ins_6_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Transformacion</a></li><?php } ?>
											<?php if($s_ins_Traspaso_empresa=='true'){ ?>  <li class=""><a href="#tab_ins_7_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso otra empresa</a></li><?php } ?>
											<?php if($s_ins_Gasto_OT=='true'){ ?>          <li class=""><a href="#tab_ins_8_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Gasto OT</a></li><?php } ?>
											<?php if($s_ins_Traspaso_Manual=='true'){ ?>   <li class=""><a href="#tab_ins_9_<?php echo $sis_count; ?>"  data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Traspaso manual otra empresa</a></li><?php } ?>
											<?php if($s_ins_Ingreso_Manual=='true'){ ?>    <li class=""><a href="#tab_ins_10_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ingreso Manual</a></li><?php } ?>
											
										</ul>
									</li>
								</ul>
							</header>
							<div class="tab-content">

								<div class="tab-pane fade active in" id="tab_ins_1_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
												<?php
												//Se dibujan los graficos, los widget y las tablas
												$trans_1='';				     
												echo widget_bodega('Bodega de Insumos',
																   'bodegas_insumos_listado', 'bodegas_insumos_facturacion_existencias', 'bodegas_insumos_facturacion_tipo', 
																   'insumos_listado', 'sistema_productos_uml', $s_ins_data,'ins_'.$sis_count,
																   $trans_1,$dbConn, 'usuarios_bodegas_insumos', $sistema['idSistema']);
											   ?>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tab_ins_2_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
														
											<script>
												
												google.charts.setOnLoadCallback(drawChart_ins_1_<?php echo $sis_count; ?>);

												function drawChart_ins_1_<?php echo $sis_count; ?>() {
													var data_ins_1_<?php echo $sis_count; ?> = new google.visualization.DataTable();
													data_ins_1_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
													data_ins_1_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
													data_ins_1_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

													data_ins_1_<?php echo $sis_count; ?>.addRows([
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo1']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo1']) ?>']
								
													]);

													var options = {
														title: 'Grafico <?php echo widget_nombre('tipo1'); ?>',
														hAxis: {title: 'Fechas'},
														vAxis: { title: 'Valor' },
														width: $(window).width()*0.75,
														height: 500,
														curveType: 'function',
														series: {0: {pointsVisible: true},},
														annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
														colors: ['#FFB347']
													};
													var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_1_<?php echo $sis_count; ?>'));
													chart1_<?php echo $sis_count; ?>.draw(data_ins_1_<?php echo $sis_count; ?>, options);
												}
											</script>
											<div id="chart_ins_1_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
										</div>
									</div>
								</div>

								<?php if($s_ins_Ventas=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_3_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_2_<?php echo $sis_count; ?>);

													function drawChart_ins_2_<?php echo $sis_count; ?>() {
														var data_ins_2_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_2_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_2_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_2_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_2_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo2']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo2']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo2'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_2_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_2_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_2_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Gastos=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_4_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_3_<?php echo $sis_count; ?>);

													function drawChart_ins_3_<?php echo $sis_count; ?>() {
														var data_ins_3_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_3_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_3_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_3_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_3_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo3']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo3']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo3']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo3'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_3_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_3_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_3_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Traspasos=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_5_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_4_<?php echo $sis_count; ?>);

													function drawChart_ins_4_<?php echo $sis_count; ?>() {
														var data_ins_4_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_4_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_4_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_4_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_4.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo4']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo4']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo4']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo4'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_4_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_4_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_4_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Transformacion=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_6_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_5_<?php echo $sis_count; ?>);

													function drawChart_ins_5_<?php echo $sis_count; ?>() {
														var data_ins_5_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_5_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_5_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_5_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_5_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo5']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo5']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo5']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo5'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_5_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_5_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_5_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Traspaso_empresa=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_7_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_6_<?php echo $sis_count; ?>);

													function drawChart_ins_6_<?php echo $sis_count; ?>() {
														var data_ins_6_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_6_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_6_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_6_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_6_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo6']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo6']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo6']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo6'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_6_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_6_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_6_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Gasto_OT=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_8_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_7_<?php echo $sis_count; ?>);

													function drawChart_ins_7_<?php echo $sis_count; ?>() {
														var data_ins_7_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_7_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_7_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_7_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_7_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo7']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo7']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo7']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo7'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_7_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_7_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_7_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Traspaso_Manual=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_9_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_8_<?php echo $sis_count; ?>);

													function drawChart_ins_8_<?php echo $sis_count; ?>() {
														var data_ins_8_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_8_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_8_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_8_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_8_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo8']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo8']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo8']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo8'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_8_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_8_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_8_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
								<?php if($s_ins_Ingreso_Manual=='true'){ ?>
									<div class="tab-pane fade" id="tab_ins_10_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_ins_9_<?php echo $sis_count; ?>);

													function drawChart_ins_9_<?php echo $sis_count; ?>() {
														var data_ins_9_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_ins_9_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_ins_9_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_ins_9_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_ins_9_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][1]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][2]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][3]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][4]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][5]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][6]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][7]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][8]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][9]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][10]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][11]['tipo9']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_ins[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo9']) ?>, '<?php echo valores_enteros($grafico_ins[$sistema['idSistema']][12]['tipo9']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo9'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_ins_9_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_ins_9_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_ins_9_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>
						
								
							</div>
						</div>
					</div>

					<div class="clearfix"></div>
					<h3 class="supertittle text-primary">Arriendos</h3>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="box">
							<header>
								<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
								<h5>Bodega de Arriendos</h5>
								<ul class="nav nav-tabs pull-right">
									<li class="active"><a href="#tab_arr_1_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
									<li class=""><a href="#tab_arr_2_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Compras</a></li>
									<li class="dropdown">
										<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
										<ul class="dropdown-menu" role="menu">
											<?php if($s_arri_Ventas=='true'){ ?>            <li class=""><a href="#tab_arr_3_<?php echo $sis_count; ?>" data-toggle="tab"><i class="fa fa-cc-visa" aria-hidden="true"></i> Ventas</a></li><?php } ?>
										</ul>
									</li>
								</ul>
							</header>
							<div class="tab-content">

								<div class="tab-pane fade active in" id="tab_arr_1_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:5px;">
												<?php
												//Se dibujan los graficos, los widget y las tablas
												$trans_1='';				     
												echo widget_bodega('Bodega de Arriendos',
																	'bodegas_arriendos_listado', 'bodegas_arriendos_facturacion_existencias', 'bodegas_arriendos_facturacion_tipo', 
																	'equipos_arriendo_listado', 0, $s_arri_data,'arri_'.$sis_count,
																	$trans_1,$dbConn, 'usuarios_bodegas_arriendos', $sistema['idSistema']);
											   ?>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tab_arr_2_<?php echo $sis_count; ?>">
									<div class="wmd-panel">
										<div class="table-responsive">
														
											<script>
												
												google.charts.setOnLoadCallback(drawChart_arr_1_<?php echo $sis_count; ?>);

												function drawChart_arr_1_<?php echo $sis_count; ?>() {
													var data_arr_1_<?php echo $sis_count; ?> = new google.visualization.DataTable();
													data_arr_1_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
													data_arr_1_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
													data_arr_1_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

													data_arr_1_<?php echo $sis_count; ?>.addRows([
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][1]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][1]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][2]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][2]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][3]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][3]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][4]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][4]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][5]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][5]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][6]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][6]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][7]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][7]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][8]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][8]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][9]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][9]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][10]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][10]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][11]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][11]['tipo1']) ?>'],
														["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][12]['tipo1']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][12]['tipo1']) ?>']
								
													]);

													var options = {
														title: 'Grafico <?php echo widget_nombre('tipo1'); ?>',
														hAxis: {title: 'Fechas'},
														vAxis: { title: 'Valor' },
														width: $(window).width()*0.75,
														height: 500,
														curveType: 'function',
														series: {0: {pointsVisible: true},},
														annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
														colors: ['#FFB347']
													};
													var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_arr_1_<?php echo $sis_count; ?>'));
													chart1_<?php echo $sis_count; ?>.draw(data_arr_1_<?php echo $sis_count; ?>, options);
												}
											</script>
											<div id="chart_arr_1_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
										</div>
									</div>
								</div>

								<?php if($s_arri_Ventas=='true'){ ?>
									<div class="tab-pane fade" id="tab_arr_3_<?php echo $sis_count; ?>">
										<div class="wmd-panel">
											<div class="table-responsive">
												
															
												<script>
													
													google.charts.setOnLoadCallback(drawChart_arr_2_<?php echo $sis_count; ?>);

													function drawChart_arr_2_<?php echo $sis_count; ?>() {
														var data_arr_2_<?php echo $sis_count; ?> = new google.visualization.DataTable();
														data_arr_2_<?php echo $sis_count; ?>.addColumn('string', 'Fecha'); 
														data_arr_2_<?php echo $sis_count; ?>.addColumn('number', 'Valor');
														data_arr_2_<?php echo $sis_count; ?>.addColumn({type: 'string', role: 'annotation'});

														data_arr_2_<?php echo $sis_count; ?>.addRows([
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][1]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][1]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][1]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][2]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][2]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][2]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][3]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][3]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][3]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][4]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][4]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][4]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][5]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][5]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][5]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][6]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][6]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][6]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][7]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][7]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][7]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][8]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][8]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][8]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][9]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][9]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][9]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][10]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][10]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][10]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][11]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][11]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][11]['tipo2']) ?>'],
															["<?php echo numero_a_mes_corto($grafico_arrie[$sistema['idSistema']][12]['mes']); ?>", <?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][12]['tipo2']) ?>, '<?php echo valores_enteros($grafico_arrie[$sistema['idSistema']][12]['tipo2']) ?>']
									
														]);

														var options = {
															title: 'Grafico <?php echo widget_nombre('tipo2'); ?>',
															hAxis: {title: 'Fechas'},
															vAxis: { title: 'Valor' },
															width: $(window).width()*0.75,
															height: 500,
															curveType: 'function',
															series: {0: {pointsVisible: true},},
															annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: '#000',auraColor: 'none'}},
															colors: ['#FFB347']
														};
														var chart1_<?php echo $sis_count; ?> = new google.visualization.LineChart(document.getElementById('chart_arr_2_<?php echo $sis_count; ?>'));
														chart1_<?php echo $sis_count; ?>.draw(data_arr_2_<?php echo $sis_count; ?>, options);
													}
												</script>
												<div id="chart_arr_2_<?php echo $sis_count; ?>" style="height: 500px; width: 100%;"></div>
												
												
											</div>
										</div>
									</div>
								<?php } ?>

							</div>
						</div>
					</div>
	
	
					
				</div>
			<?php
			$sis_count++;
			} ?>
			
        </div>
	</div>
</div>






        


<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
