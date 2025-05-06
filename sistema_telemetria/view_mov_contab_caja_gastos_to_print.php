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
/*                                                          Consultas                                                             */
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
// consulto los datos
$SIS_query = '
core_sistemas.Nombre AS CajaSistema,
usuarios_listado.Nombre AS Usuario,
contab_caja_gastos.fecha_auto,
contab_caja_gastos.Creacion_fecha,
contab_caja_gastos.Observaciones,
contab_caja_gastos.Valor,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Cargo AS TrabajadorCargo,
trabajadores_listado.Fono AS TrabajadorFono,
trabajadores_listado.Rut AS TrabajadorRut';
$SIS_join  = '
LEFT JOIN `core_sistemas`         ON core_sistemas.idSistema              = contab_caja_gastos.idSistema
LEFT JOIN `usuarios_listado`      ON usuarios_listado.idUsuario           = contab_caja_gastos.idUsuario
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = contab_caja_gastos.idTrabajador';
$SIS_where = 'contab_caja_gastos.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'contab_caja_gastos', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
sistema_documentos_pago.Nombre,
contab_caja_gastos_existencias.Descripcion,
contab_caja_gastos_existencias.N_Doc,
contab_caja_gastos_existencias.Valor,
contab_caja_gastos_existencias.CentroCosto';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = contab_caja_gastos_existencias.idDocPago';
$SIS_where = 'contab_caja_gastos_existencias.idFacturacion ='.$X_Puntero;
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'contab_caja_gastos_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocumentos');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html = '
<section class="invoice">
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Rendiciones
			</h2>
		</div>
	</div>

	<div class="row invoice-info">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos basicos
			<address>
				<strong>Trabajador: </strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'].'<br/>
				<strong>Rut: </strong>'.$rowData['TrabajadorRut'].'<br/>
				<strong>Cargo: </strong>'.$rowData['TrabajadorCargo'].'<br/>
				<strong>Fono: </strong>'.formatPhone($rowData['TrabajadorFono']).'<br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Detalle
			<address>
				<strong>Fecha Creacion: </strong>'.fecha_estandar($rowData['Creacion_fecha']).'<br/>
				<strong>Fecha Ingreso: </strong>'.fecha_estandar($rowData['fecha_auto']).'<br/>
				<strong>Usuario: </strong>'.$rowData['Usuario'].'<br/>
				<strong>Sistema: </strong>'.$rowData['CajaSistema'].'<br/>
			</address>
		</div>
	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="4">Detalle</th>
					</tr>
				</thead>
				<tbody>';
					//si existen productos
					if ($arrDocumentos!=false && !empty($arrDocumentos) && $arrDocumentos!='') {
						foreach ($arrDocumentos as $prod) {
							$html .= '<tr>';
								$html .= '<td align="left">'.$prod['Descripcion'].'</td>';
								$html .= '<td>';
									$html .= $prod['Nombre'];
									if(isset($prod['N_Doc'])&&$prod['N_Doc']!=''){
										$html .= ' N°'.$prod['N_Doc'];
									}
								$html .= '</td>';
								$html .= '<td align="left">'.$prod['CentroCosto'].'</td>';
								$html .= '<td align="right">'.Valores($prod['Valor'], 0).'</td>';
							$html .= '</tr>';
						}
					}

					if(isset($rowData['Valor'])&&$rowData['Valor']!=0){
						$html .= '
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right" colspan="3"><strong>Total</strong></td>
							<td align="right">'.Valores($rowData['Valor'], 0).'</td>
						</tr>';
					}
					
			$html .= '</table>

		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" >'.$rowData['Observaciones'].'</p>
		</div>
	</div>
</section>';

echo $html;

/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
