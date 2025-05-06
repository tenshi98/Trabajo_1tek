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
require_once 'core/Load.Utils.Print.php';
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
require_once 'core/Web.Header.Print.php';
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
//Obtengo los datos principales
$SIS_query = '
ClienteNombre,ClienteDireccion,ClienteIdentificador,ClienteNombreComuna,ClienteFechaVencimiento,ClienteEstado,
							
DetalleCargoFijoValor,
DetalleConsumoCantidad,DetalleConsumoValor,
DetalleRecoleccionCantidad,DetalleRecoleccionValor,
DetalleVisitaCorte,
DetalleCorte1Fecha,DetalleCorte1Valor,
DetalleCorte2Fecha,DetalleCorte2Valor,
DetalleReposicion1Fecha,DetalleReposicion1Valor,
DetalleReposicion2Fecha,DetalleReposicion2Valor,
DetalleSubtotalServicio,
DetalleInteresDeuda,
DetalleSaldoFavor,
DetalleTotalVenta,
DetalleSaldoAnterior,
							
DetalleOtrosCargos1Texto,
DetalleOtrosCargos2Texto,
DetalleOtrosCargos3Texto,
DetalleOtrosCargos4Texto,
DetalleOtrosCargos5Texto,
DetalleOtrosCargos1Valor,
DetalleOtrosCargos2Valor,
DetalleOtrosCargos3Valor,
DetalleOtrosCargos4Valor,
DetalleOtrosCargos5Valor,
DetalleOtrosCargos1Fecha,
DetalleOtrosCargos2Fecha,
DetalleOtrosCargos3Fecha,
DetalleOtrosCargos4Fecha,
DetalleOtrosCargos5Fecha,
							
DetalleTotalAPagar,
							
GraficoMes1Valor,GraficoMes2Valor,GraficoMes3Valor,GraficoMes4Valor,GraficoMes5Valor,
GraficoMes6Valor,GraficoMes7Valor,GraficoMes8Valor,GraficoMes9Valor,GraficoMes10Valor,
GraficoMes11Valor,GraficoMes12Valor,
GraficoMes1Fecha,GraficoMes2Fecha,GraficoMes3Fecha,GraficoMes4Fecha,GraficoMes5Fecha,
GraficoMes6Fecha,GraficoMes7Fecha,GraficoMes8Fecha,GraficoMes9Fecha,GraficoMes10Fecha,
GraficoMes11Fecha,GraficoMes12Fecha,
							
DetConsMesAnteriorCantidad,DetConsMesAnteriorFecha,
DetConsMesActualCantidad,DetConsMesActualFecha,
DetConsMesDiferencia,
DetConsProrateo,
DetConsProrateoSigno,
DetConsMesTotalCantidad,
DetConsFechaProxLectura,
DetConsModalidad,
DetConsFonoEmergencias,
DetConsFonoConsultas,
							
AguasInfCargoFijo,
AguasInfMetroAgua,
AguasInfMetroRecolecion,
AguasInfVisitaCorte,
AguasInfCorte1,
AguasInfCorte2,
AguasInfReposicion1,
AguasInfReposicion2,
							
AguasInfFactorCobro,
AguasInfDifMedGeneral,
AguasInfProcProrrateo,
AguasInfTipoMedicion,
AguasInfPuntoDiametro,
AguasInfClaveFacturacion,
AguasInfClaveLectura,
AguasInfNumeroMedidor,
AguasInfFechaEmision,
AguasInfUltimoPagoFecha,AguasInfUltimoPagoMonto,
AguasInfMovimientosHasta,

core_sistemas.Nombre AS SistemaNombre,
core_sistemas.Rubro AS SistemaRubro,
core_sistemas.Rut AS SistemaRut,
core_sistemas.Direccion AS SistemaDireccion,
sis_or_ciudad.Nombre AS SistemaComuna,
sis_or_comuna.Nombre AS SistemaCiudad,
core_sistemas.Contacto_Fono1 AS SistemaFono,
aguas_datos_valores.NdiasPago,


SII_idFacturable,
NombreArchivo,
aguas_clientes_facturable.Nombre AS DocFacturable,
SII_NDoc,
core_sistemas.Rubro AS Rubro,
aguas_clientes_listado.Rut AS ClienteRut,
aguas_clientes_listado.Giro AS ClienteGiro,
aguas_clientes_listado.Fono1 AS ClienteFono1,
aguas_clientes_listado.Fono2 AS ClienteFono2,
core_ubicacion_comunas.Nombre AS ClienteComunaFact,
aguas_clientes_listado.DireccionFact AS ClienteDireccionFact,
aguas_clientes_listado.UnidadHabitacional AS ClienteUH,
aguas_clientes_listado.idRemarcadores AS ClienteRemarcador,

usuarios_listado.Nombre AS PagoUsuario,
idTipoPago,nDocPago,fechaPago,montoPago,idPago,
aguas_facturacion_listado_detalle.idEstado';
$SIS_join  = '
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                   = aguas_facturacion_listado_detalle.idSistema
LEFT JOIN `aguas_clientes_facturable`               ON aguas_clientes_facturable.idFacturable    = aguas_facturacion_listado_detalle.SII_idFacturable
LEFT JOIN `aguas_clientes_listado`                  ON aguas_clientes_listado.idCliente          = aguas_facturacion_listado_detalle.idCliente
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                = aguas_facturacion_listado_detalle.idUsuarioPago
LEFT JOIN `core_ubicacion_comunas`                  ON core_ubicacion_comunas.idComuna           = aguas_clientes_listado.idComunaFact
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                    = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                    = core_sistemas.idComuna
LEFT JOIN `aguas_datos_valores`                     ON aguas_datos_valores.idSistema             = aguas_facturacion_listado_detalle.idSistema';
$SIS_where = 'aguas_facturacion_listado_detalle.idFacturacionDetalle ='.$X_Puntero;
$rowDatos = db_select_data (false, $SIS_query, 'aguas_facturacion_listado_detalle', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowDatos');

//se verifica si existe
if(isset($rowDatos['SII_idFacturable'])&&$rowDatos['SII_idFacturable']!=''){
	switch ($rowDatos['SII_idFacturable']) {
		//Boleta Electronica
		case 1:
			include 'view_aguas_facturacion_to_print_1.php';
		break;
		//Factura Electronica
		case 2:
			include 'view_aguas_facturacion_to_print_2.php';
		break;
		//No Facturable
		case 3:
			//include 'view_aguas_facturacion_to_print_3.php';
		break;
		//Boleta Manual
		case 4:
			include 'view_aguas_facturacion_to_print_4.php';
		break;
		//Factura Manual
		case 5:
			include 'view_aguas_facturacion_to_print_5.php';
		break;
	}
}

/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
