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
seguridad_accesos_nominas.FechaProgramada,
seguridad_accesos_nominas.HoraInicioProgramada,
seguridad_accesos_nominas.HoraTerminoProgramada,
core_sistemas.Nombre AS Sistema,
usuarios_listado.Nombre AS Usuario,
ubicacion_listado.Nombre AS Ubicacion,
ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
ubicacion_listado_level_5.Nombre AS UbicacionLVL_5,
seguridad_accesos_nominas.PersonaReunion,
core_estado_caja.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `usuarios_listado`            ON usuarios_listado.idUsuario            = seguridad_accesos_nominas.idUsuario
LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema               = seguridad_accesos_nominas.idSistema
LEFT JOIN `ubicacion_listado`           ON ubicacion_listado.idUbicacion         = seguridad_accesos_nominas.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`   ON ubicacion_listado_level_1.idLevel_1   = seguridad_accesos_nominas.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`   ON ubicacion_listado_level_2.idLevel_2   = seguridad_accesos_nominas.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`   ON ubicacion_listado_level_3.idLevel_3   = seguridad_accesos_nominas.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`   ON ubicacion_listado_level_4.idLevel_4   = seguridad_accesos_nominas.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`   ON ubicacion_listado_level_5.idLevel_5   = seguridad_accesos_nominas.idUbicacion_lvl_5
LEFT JOIN `core_estado_caja`            ON core_estado_caja.idEstado             = seguridad_accesos_nominas.idEstado';
$SIS_where = 'seguridad_accesos_nominas.idAcceso ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'seguridad_accesos_nominas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los otros
$SIS_query = '
seguridad_accesos_nominas_listado.Fecha, 
seguridad_accesos_nominas_listado.HoraEntrada, 
seguridad_accesos_nominas_listado.HoraSalida, 
seguridad_accesos_nominas_listado.Nombre,
seguridad_accesos_nominas_listado.Rut, 
seguridad_accesos_nominas_listado.NDocCedula,
core_estado_nomina_asistencia.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estado_nomina_asistencia` ON core_estado_nomina_asistencia.idEstado = seguridad_accesos_nominas_listado.idEstado';
$SIS_where = 'seguridad_accesos_nominas_listado.idAcceso ='.$X_Puntero;
$SIS_order = 'seguridad_accesos_nominas_listado.Fecha ASC';
$arrPersonas = array();
$arrPersonas = db_select_array (false, $SIS_query, 'seguridad_accesos_nominas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPersonas');

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html ='
<section class="invoice">
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Nomina de Control de Accesos.
				<small class="pull-right">Nomina N°: '.n_doc($_GET['view'], 8).'</small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos Básicos
			<address>
				<strong>Usuario:</strong> '.$rowData['Usuario'].'<br/>
				<strong>Sistema:</strong> '.$rowData['Sistema'].'<br/>
				<strong>Ubicación:</strong> ';
				$html .= $rowData['Ubicacion'];
				if(isset($rowData['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=''){$html .= ' - '.$rowData['UbicacionLVL_1'];}
				if(isset($rowData['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=''){$html .= ' - '.$rowData['UbicacionLVL_2'];}
				if(isset($rowData['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=''){$html .= ' - '.$rowData['UbicacionLVL_3'];}
				if(isset($rowData['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=''){$html .= ' - '.$rowData['UbicacionLVL_4'];}
				if(isset($rowData['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=''){$html .= ' - '.$rowData['UbicacionLVL_5'];}
				$html .='<br/>
				<strong>Persona Reunion:</strong> '.$rowData['PersonaReunion'].'<br/>
				<strong>Estado:</strong> '.$rowData['Estado'].'<br/>
			</address>
		</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Programacion
			<address>
				<strong>Fecha:</strong> '.Fecha_estandar($rowData['FechaProgramada']).'<br/>
				<strong>Hora Inicio:</strong> '.$rowData['HoraInicioProgramada'].'<br/>
				<strong>Hora Termino:</strong> '.$rowData['HoraTerminoProgramada'].'<br/>
			</address>
		</div>
	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th colspan="6">Detalle</th>
					</tr>
				</thead>
				<tbody>';
					//si existen guias
					if ($arrPersonas!=false && !empty($arrPersonas) && $arrPersonas!='') {
						foreach ($arrPersonas as $otro) {
							$html .= '<tr>
								<td style="vertical-align: top;">'.$otro['Nombre'].'</td>
								<td style="vertical-align: top;">'.$otro['Rut'].'</td>
								<td style="vertical-align: top;">'.$otro['NDocCedula'].'</td>
								<td style="vertical-align: top;">'.Fecha_estandar($otro['Fecha']).'</td>
								<td style="vertical-align: top;">'.$otro['HoraEntrada'].' - '.$otro['HoraSalida'].'</td>
								<td style="vertical-align: top;">'.$otro['Estado'].'</td>
							</tr>';
						}
					}
					
				$html .= '</tbody>
			</table>

		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">

		</div>
	</div>

</section>';

echo $html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
