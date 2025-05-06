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
require_once 'core/Load.Utils.PDF.php';
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
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
	//Consulta
	$rowEmpresa = db_select_data (false, 'Config_imgLogo, idOpcionesGen_5', 'core_sistemas','', 'idSistema ='.simpleDecode($_GET['idSistema'], fecha_actual()), $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');
}
/**************************************************************/
// consulto los datos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.idEstado,
cross_solicitud_aplicacion_listado.f_creacion,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_programacion_fin,
cross_solicitud_aplicacion_listado.f_ejecucion_fin,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_solicitud_aplicacion_listado.horaProg,
cross_solicitud_aplicacion_listado.horaEjecucion,
cross_solicitud_aplicacion_listado.horaTermino,
cross_solicitud_aplicacion_listado.horaProg_fin,
cross_solicitud_aplicacion_listado.horaEjecucion_fin,
cross_solicitud_aplicacion_listado.horaTermino_fin,
cross_solicitud_aplicacion_listado.Mojamiento,
cross_solicitud_aplicacion_listado.VelTractor,
cross_solicitud_aplicacion_listado.VelViento,
cross_solicitud_aplicacion_listado.TempMin,
cross_solicitud_aplicacion_listado.TempMax,
cross_solicitud_aplicacion_listado.HumTempMax,

usuarios_listado.Nombre AS NombreUsuario,

sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

cross_predios_listado.Nombre AS NombrePredio,
core_estado_solicitud.Nombre AS Estado,
cross_checking_temporada.Codigo AS TemporadaCodigo,
cross_checking_temporada.Nombre AS TemporadaNombre,
cross_checking_estado_fenologico.Codigo AS EstadoFenCodigo,
cross_checking_estado_fenologico.Nombre AS EstadoFenNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,

core_cross_prioridad.Nombre AS NombrePrioridad,
cross_solicitud_aplicacion_listado.idDosificador,
trabajadores_listado.Rut AS TrabajadorRut,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                     = cross_solicitud_aplicacion_listado.idUsuario
LEFT JOIN `core_sistemas`   sistema_origen          ON sistema_origen.idSistema                       = cross_solicitud_aplicacion_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                         = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                         = sistema_origen.idComuna
LEFT JOIN `cross_predios_listado`                   ON cross_predios_listado.idPredio                 = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `core_estado_solicitud`                   ON core_estado_solicitud.idEstado                 = cross_solicitud_aplicacion_listado.idEstado
LEFT JOIN `cross_checking_temporada`                ON cross_checking_temporada.idTemporada           = cross_solicitud_aplicacion_listado.idTemporada
LEFT JOIN `cross_checking_estado_fenologico`        ON cross_checking_estado_fenologico.idEstadoFen   = cross_solicitud_aplicacion_listado.idEstadoFen
LEFT JOIN `sistema_variedades_categorias`           ON sistema_variedades_categorias.idCategoria      = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                      ON variedades_listado.idProducto                  = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `core_cross_prioridad`                    ON core_cross_prioridad.idPrioridad               = cross_solicitud_aplicacion_listado.idPrioridad
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador              = cross_solicitud_aplicacion_listado.idDosificador';
$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
//Cuarteles
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
sistema_variedades_categorias.Nombre AS EspecieNombre,
variedades_listado.Nombre AS VariedadNombre,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_solicitud_aplicacion_listado_cuarteles.idEstado,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
cross_solicitud_aplicacion_listado_cuarteles.idZona,
cross_solicitud_aplicacion_listado.Mojamiento,
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_solicitud_aplicacion_listado_cuarteles.idEjecucion AS CuartelidEjecucion,
cross_solicitud_aplicacion_listado_cuarteles.LitrosAplicados AS CuartelLitrosAplicados,
cross_solicitud_aplicacion_listado_cuarteles.VelPromedio AS CuartelVelPromedio,

cross_solicitud_aplicacion_listado_cuarteles.idCuarteles AS ID_1,
(SELECT AVG(NULLIF(IF(GeoVelocidadProm!=0,GeoVelocidadProm,0),0)) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS VelPromedio,
(SELECT SUM(Diferencia)                                           FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idCuarteles=ID_1 LIMIT 1 ) AS LitrosAplicados';
$SIS_join  = '
LEFT JOIN `cross_predios_listado_zonas`        ON cross_predios_listado_zonas.idZona              = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `sistema_variedades_categorias`      ON sistema_variedades_categorias.idCategoria       = cross_solicitud_aplicacion_listado_cuarteles.idCategoria
LEFT JOIN `variedades_listado`                 ON variedades_listado.idProducto                   = cross_solicitud_aplicacion_listado_cuarteles.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado` ON cross_solicitud_aplicacion_listado.idSolicitud  = cross_solicitud_aplicacion_listado_cuarteles.idSolicitud';
$SIS_where = 'cross_solicitud_aplicacion_listado_cuarteles.idSolicitud ='.$X_Puntero;
$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
$arrCuarteles = array();
$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrCuarteles');

/*****************************************/
//Tractores
$SIS_query = '
telemetria_listado.Nombre AS TelemetriaNombre,
telemetria_listado.Capacidad AS TelemetriaCapacidad,
vehiculos_listado.Nombre AS VehiculoNombre,
trabajadores_listado.Rut,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
contratista_listado.Nombre AS Contratista,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia,
AVG(cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm) AS GeoVelocidadProm,
SEC_TO_TIME( SUM( TIME_TO_SEC(cross_solicitud_aplicacion_listado_tractores.T_Aplicacion))) AS T_Aplicacion';
$SIS_join  = '
LEFT JOIN `telemetria_listado`    ON telemetria_listado.idTelemetria      = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo         = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador    = cross_solicitud_aplicacion_listado_tractores.idTrabajador
LEFT JOIN `contratista_listado`   ON contratista_listado.idContratista    = trabajadores_listado.idContratista';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud ='.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrTractores = array();
$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTractores');

/*****************************************/
//tractores por cuartel
$SIS_query = '
cross_solicitud_aplicacion_listado_cuarteles.idZona,
telemetria_listado.Nombre AS TelemetriaNombre,
vehiculos_listado.Nombre AS VehiculoNombre,
SUM(cross_solicitud_aplicacion_listado_tractores.Diferencia) AS Diferencia';
$SIS_join  = '
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                           = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                              = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles  = cross_solicitud_aplicacion_listado_tractores.idCuarteles';
$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud = '.$X_Puntero.' AND Diferencia!=0 GROUP BY cross_solicitud_aplicacion_listado_cuarteles.idZona, cross_solicitud_aplicacion_listado_tractores.idTelemetria, cross_solicitud_aplicacion_listado_tractores.idVehiculo';
$SIS_order = 'cross_solicitud_aplicacion_listado_cuarteles.idZona ASC, telemetria_listado.Nombre ASC';
$arrTracxCuartel = array();
$arrTracxCuartel = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTracxCuartel');

/*****************************************/
//Se trae un listado con los productos
$SIS_query = '
cross_solicitud_aplicacion_listado_productos.idProdQuim,
cross_solicitud_aplicacion_listado_productos.idCuarteles,
cross_solicitud_aplicacion_listado_productos.DosisRecomendada,
cross_solicitud_aplicacion_listado_productos.DosisAplicar,
cross_solicitud_aplicacion_listado_productos.Objetivo,
productos_listado.Nombre AS ProductoNombre,
productos_listado.IngredienteActivo AS ProductoIngrediente,
productos_listado.Carencia AS ProductoCarencia,
productos_listado.EfectoResidual AS ProductoResidual,
productos_listado.EfectoRetroactivo AS ProductoRetroactivo,
productos_listado.CarenciaExportador AS ProductoExportador,
sistema_productos_uml.Nombre AS Unimed';
$SIS_join  = '
LEFT JOIN `productos_listado`       ON productos_listado.idProducto   = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml    = cross_solicitud_aplicacion_listado_productos.idUml';
$SIS_where = 'cross_solicitud_aplicacion_listado_productos.idSolicitud = '.$X_Puntero.' GROUP BY cross_solicitud_aplicacion_listado_productos.idProducto';
$SIS_order = 'productos_listado.Nombre ASC';
$arrProductos = array();
$arrProductos = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

/*****************************************/
//Se trae un listado con los materiales
$SIS_query = '
cross_checking_materiales_seguridad.Nombre,
cross_checking_materiales_seguridad.Codigo';
$SIS_join  = 'LEFT JOIN `cross_checking_materiales_seguridad`   ON cross_checking_materiales_seguridad.idMatSeguridad   = cross_solicitud_aplicacion_listado_materiales.idMatSeguridad';
$SIS_where = 'cross_solicitud_aplicacion_listado_materiales.idSolicitud = '.$X_Puntero;
$SIS_order = 'cross_checking_materiales_seguridad.Nombre ASC';
$arrMateriales = array();
$arrMateriales = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_materiales', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMateriales');

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
table {border-collapse: collapse;border-spacing: 0;}
tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
</style>';

$html .= '
<table style="border: 1px solid #f4f4f4;margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td>
				<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="vertical-align: top;">Solicitud de Aplicacion</td>
							<td style="vertical-align: top;">Fecha Creacion: '.Fecha_estandar($rowData['f_creacion']).'</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:33%;">
								<strong>Datos Empresa</strong><br/>
								Rut: '.$rowData['SistemaOrigenRut'].'<br/>
								Empresa: '.$rowData['SistemaOrigen'].'<br/>
								Ciudad-Comuna: '.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
								Dirección: '.$rowData['SistemaOrigenDireccion'].'<br/>
								Fono: '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
								Email: '.$rowData['SistemaOrigenEmail'].'
							</td>
							<td style="vertical-align: top;width:33%;">
								<strong>Identificación</strong><br/>
								Predio: '.$rowData['NombrePredio'].'<br/>
								Estado: '.$rowData['Estado'].'<br/>
								Temporada: '.$rowData['TemporadaCodigo'].' '.$rowData['TemporadaNombre'].'<br/>
								Estado Fenologico: '.$rowData['EstadoFenCodigo'].' '.$rowData['EstadoFenNombre'].'<br/>';
								if(isset($rowData['VariedadCat'])&&$rowData['VariedadCat']!=''){      $html .= 'Especie: '.$rowData['VariedadCat'].'<br/>';     }else{$html .= 'Especie: Todas las Especies<br/>';}
								if(isset($rowData['VariedadNombre'])&&$rowData['VariedadNombre']!=''){$html .= 'Variedad: '.$rowData['VariedadNombre'].'<br/>';}else{$html .= 'Variedad: Todas las Variedades<br/>';}
							$html .= '
							</td>
							<td style="vertical-align: top;width:33%;">
								<strong>Datos de Solicitud</strong><br/>
								Prioridad: '.$rowData['NombrePrioridad'].'<br/>
								N° Solicitud: '.n_doc($rowData['NSolicitud'], 5).'<br/>
								Fecha inicio requerido: '.fecha_estandar($rowData['f_programacion']).' '.$rowData['horaProg'].'<br/>
								Fecha termino requerido: '.fecha_estandar($rowData['f_programacion_fin']).' '.$rowData['horaProg_fin'].'<br/>';
								if(isset($rowData['f_ejecucion'])&&$rowData['f_ejecucion']!='0000-00-00'){         $html .= 'Fecha inicio programación: '.fecha_estandar($rowData['f_ejecucion']).' '.$rowData['horaEjecucion'].'<br/>';}
								if(isset($rowData['f_ejecucion_fin'])&&$rowData['f_ejecucion_fin']!='0000-00-00'){ $html .= 'Fecha termino programación: '.fecha_estandar($rowData['f_ejecucion_fin']).' '.$rowData['horaEjecucion_fin'].'<br/>';}
								if(isset($rowData['f_termino'])&&$rowData['f_termino']!='0000-00-00'){             $html .= 'Fecha inicio ejecución: '.fecha_estandar($rowData['f_termino']).' '.$rowData['horaTermino'].'<br/>';}
								if(isset($rowData['f_termino_fin'])&&$rowData['f_termino_fin']!='0000-00-00'){     $html .= 'Terminado: '.fecha_estandar($rowData['f_termino_fin']).' '.$rowData['horaTermino_fin'].'<br/>';}
								$html .= 'Agrónomo: '.$rowData['NombreUsuario'];
								if(isset($rowData['idDosificador'])&&$rowData['idDosificador']!=0){$html .= 'Dosificador: '.$rowData['TrabajadorRut'].' '.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].'<br/>';}
								$html .= '
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top; width:33%;">
								<strong>Parámetros de Aplicación</strong><br/>
								Mojamiento: '.Cantidades_decimales_justos($rowData['Mojamiento']).' L/ha<br/>
								Velocidad Tractor: '.Cantidades_decimales_justos($rowData['VelTractor']).' Km/hr<br/>
								Velocidad Viento: '.Cantidades_decimales_justos($rowData['VelViento']).' Km/hr<br/>
								Temperatura Min: '.Cantidades_decimales_justos($rowData['TempMin']).' °<br/>
								Temperatura Max: '.Cantidades_decimales_justos($rowData['TempMax']).' °<br/>
								Humedad: '.Cantidades_decimales_justos($rowData['HumTempMax']).' %<br/>
							</td>
							<td style="vertical-align: top;width:33%;"></td>
							<td style="vertical-align: top;width:33%;"></td>
						</tr>
					</tbody>
				</table>

				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Especie - Variedad</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Numero de<br/>solicitud</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Cuarteles</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Veloc.<br/>Promedio</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Mojamiento<br/>solicitado</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>lts. Aplicados</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>Mojamiento<br/>Real</strong></th>';
							$html .= '<th style="vertical-align: top; width:10%;"><strong>% Mojamiento</strong></th>';
							$html .= '<th style="vertical-align: top; width:20%;"><strong>Vehiculos<br/>involucrados</strong></th>';

							$html .= '
						</tr>
					</thead>
					<tbody>';
					//Variables
					$TotalNPlantas          = 0;
					$TotalCuartelHectareas  = 0;
					$TotalCuartelHileras    = 0;
					$TotalPlantasAplicadas  = 0;
                    $TotalLitrosAplicados   = 0;
                    $TotalMojamiento        = 0;
                    $TotLitrosApliXhect     = 0;

					//recorro el lsiatdo entregado por la base de datos
					if ($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!='') {
						foreach ($arrCuarteles as $cuartel) {
							//Verifico el tipo de cierre
							if(isset($cuartel['CuartelidEjecucion'])&&$cuartel['CuartelidEjecucion']==1){
								$S_LitrosAplicados  = $cuartel['CuartelLitrosAplicados'];
								$S_VelPromedio      = $cuartel['CuartelVelPromedio'];
							}else{
								$S_LitrosAplicados  = $cuartel['LitrosAplicados'];
								$S_VelPromedio      = $cuartel['VelPromedio'];
							}

							//calculo
							if(isset($cuartel['CuartelHectareas'])&&$cuartel['CuartelHectareas']!=0){
								$LitrosApliXhect = $S_LitrosAplicados/$cuartel['CuartelHectareas'];
							}else{
								$LitrosApliXhect = 0;
							}

							//se muestra el estado de cierre
							if(isset($cuartel['idEstado'])&&$cuartel['idEstado']==2){ $cierre = ' (Cerrado el '.fecha_estandar($cuartel['f_cierre']).')';}else{$cierre = '';}

							//defino el icono y su color
							switch ($cuartel['CuartelidEjecucion']) {
								case 0:
									$s_Icon = '';
									break;
								case 1:
									$s_Icon = '<span style="color: #dd4b39;"><i class="fa fa-rss" aria-hidden="true"></i></span>';
									break;
								case 2:
									$s_Icon = '<span style="color: #5cb85c;"><i class="fa fa-rss" aria-hidden="true"></i></span>';
									break;
							}

							//Sumo Variables
							$TotalMojamiento       = $TotalMojamiento + $cuartel['Mojamiento'];
							$TotalLitrosAplicados  = $TotalLitrosAplicados + $S_LitrosAplicados;
							$TotLitrosApliXhect    = $TotLitrosApliXhect + $LitrosApliXhect;

							if($LitrosApliXhect!=0){$ndatax1 = porcentaje($LitrosApliXhect/$cuartel['Mojamiento']);}else{ $ndatax1 = '0 %';}

							$html .= '<tr>';
								$html .= '<td>'.$cuartel['EspecieNombre'].' - '.$cuartel['VariedadNombre'].'</td>';
								$html .= '<td>'.$cuartel['NSolicitud'].'</td>';
								$html .= '<td>'.$s_Icon.' '.$cuartel['CuartelNombre'].$cierre.'</td>';
								$html .= '<td>'.Cantidades($S_VelPromedio,1).'</td>';
								$html .= '<td>'.Cantidades($cuartel['Mojamiento'],0).'</td>';
								$html .= '<td>'.Cantidades($S_LitrosAplicados,1).'</td>';
								$html .= '<td>'.Cantidades($LitrosApliXhect,1).'</td>';
								$html .= '<td>'.$ndatax1.'</td>'; 
								$html .= '<td>';
									if ($arrTracxCuartel!=false && !empty($arrTracxCuartel) && $arrTracxCuartel!='') {
										foreach ($arrTracxCuartel as $tract) {
											if($cuartel['idZona']==$tract['idZona']){
												$html .= '<i class="fa fa-truck" aria-hidden="true"></i> '.$tract['VehiculoNombre'].' '.$tract['TelemetriaNombre'].'<br/>';
											}
										}
									}
								$html .= '</td>';

							$html .= '</tr>';
						}

						if($TotLitrosApliXhect!=0){$ndatax1 = porcentaje($TotLitrosApliXhect/$TotalMojamiento);}else{ $ndatax1 = '0 %';}

						$html .= '<tr>';
							$html .= '<td><strong>Totales</strong></td>';
							$html .= '<td></td>';
							$html .= '<td></td>';
							$html .= '<td></td>';
							$html .= '<td>'.Cantidades($TotalMojamiento, 0).'</td>';
							$html .= '<td>'.Cantidades($TotalLitrosAplicados, 1).'</td>';
							$html .= '<td>'.Cantidades($TotLitrosApliXhect, 1).'</td>';
							$html .= '<td>'.$ndatax1.'</td>';
							$html .= '<td></td>';
						$html .= '</tr>';

					}else{
						$html .= '<tr><td colspan="10">No hay cuarteles asignados</td></tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:30%;"><strong>Objetivo</strong></th>
							<th style="vertical-align: top; width:12%;"><strong>Producto<br/>Químico</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Ingrediente<br/>Activo</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Dosis<br/>Recomendada</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Dosis a<br/>Aplicar</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Carencia<br/>Etiqueta</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Carencia<br/>ASOEX</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Carencia<br/>ESCO</strong></th>
							<th style="vertical-align: top; width:8%;"><strong>Tiempo<br/>Re-Ingreso</strong></th>
						</tr>
					</thead>
					<tbody>';
					//Variable
					$NProd = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
						foreach ($arrProductos as $prod) {
							$NProd++;
							$html .= '
							<tr>
								<td>'.$prod['Objetivo'].'</td>
								<td><i class="fa fa-flask" aria-hidden="true"></i> '.$prod['ProductoNombre'].'</td>
								<td>'.$prod['ProductoIngrediente'].'</td>
								<td>'.Cantidades_decimales_justos($prod['DosisRecomendada']).' '.$prod['Unimed'].'</td>
								<td>'.Cantidades_decimales_justos($prod['DosisAplicar']).' '.$prod['Unimed'].'</td>
								<td>'.Cantidades_decimales_justos($prod['ProductoExportador']).'</td>
								<td>'.Cantidades_decimales_justos($prod['ProductoCarencia']).'</td>
								<td>'.Cantidades_decimales_justos($prod['ProductoResidual']).'</td>
								<td>'.Cantidades_decimales_justos($prod['ProductoRetroactivo']).'</td>
							</tr>';
						}
					}else{
						$html .= '<tr><td colspan="9">No hay Productos Quimicos asignados</td></tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:20%;"><strong>Tractor</strong></th>
							<th style="vertical-align: top; width:20%;"><strong>Equipo Aplicación</strong></th>
							<th style="vertical-align: top; width:25%;"><strong>Trabajador</strong></th>
							<th style="vertical-align: top; width:25%;"><strong>Contratista</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Capacidad</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Litros Aplicados</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Velocidad Promedio</strong></th>
							<th style="vertical-align: top; width:10%;"><strong>Tiempo Aplicando</strong></th>
						</tr>
					</thead>
					<tbody>';
					//Variables
					$Capacidad  = 0;
					$NTract     = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrTractores!=false && !empty($arrTractores) && $arrTractores!='') {
						foreach ($arrTractores as $tract) {
							//Se suman cantidades
							$Capacidad = $Capacidad + $tract['TelemetriaCapacidad'];
							$NTract++;
							$html .= '
							<tr>
								<td><i class="fa fa-truck" aria-hidden="true"></i> '.$tract['VehiculoNombre'].'</td>
								<td>'.$tract['TelemetriaNombre'].'</td>
								<td>'.$tract['Rut'].' '.$tract['Nombre'].' '.$tract['ApellidoPat'].'</td>
								<td>'.$tract['Contratista'].'</td>
								<td>'.Cantidades_decimales_justos($tract['TelemetriaCapacidad']).'</td>
								<td>'.Cantidades($tract['Diferencia'], 0).'</td>
								<td>'.Cantidades($tract['GeoVelocidadProm'],2).'</td>
								<td>'.$tract['T_Aplicacion'].'</td>
							</tr>';
						}
					}else{
						$html .= '<tr><td colspan="5">No hay Tractores asignados</td></tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:15%;"><strong>Capacidad Total Equipos<br/>de Aplicación</strong></th>
							<th style="vertical-align: top; width:15%;"><strong>Promedio de Capacidad<br/>por Equipo</strong></th>
							<th style="vertical-align: top; width:15%;"><strong>Maquinadas<br/>estimadas</strong></th>
							<th style="vertical-align: top; width:35%;"><strong>Producto<br/>Quimico</strong></th>
							<th style="vertical-align: top; width:20%;"><strong>Total Producto<br/>Quimico</strong></th>
						</tr>
					</thead>
					<tbody>';
					//Variable
					$nmb = 0;
					//recorro el lsiatdo entregado por la base de datos
					if ($arrProductos!=false && !empty($arrProductos) && $arrProductos!='') {
						foreach ($arrProductos as $prod) {
							$PromedioCapacidad = $Capacidad/$NTract;
							if($PromedioCapacidad!=0){$s_valor = Cantidades(($rowData['Mojamiento']*$TotalCuartelHectareas)/$PromedioCapacidad, 2);}else{$s_valor = 0;}

							$html .= '<tr>';
							if($nmb==0){$html .= '<td rowspan="'.$NProd.'">'.Cantidades_decimales_justos($Capacidad).'</td>';}
							if($nmb==0){$html .= '<td rowspan="'.$NProd.'">'.Cantidades_decimales_justos($PromedioCapacidad).'</td>';}
							if($nmb==0){$html .= '<td rowspan="'.$NProd.'">'.$s_valor.'</td>';}

							$html .= '
								<td><i class="fa fa-flask" aria-hidden="true"></i> '.$prod['ProductoNombre'].'</td>
								<td>'.Cantidades((($rowData['Mojamiento']*$TotalCuartelHectareas)/100)*$prod['DosisAplicar'], 2).' '.$prod['Unimed'].'</td>
							</tr>';
							//se suma 1
							$nmb++;
						}
					}else{
						$html .= '<tr><td colspan="5">No hay Productos Quimicos Asignados</td></tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>

				<table class="zebra tableline" style="text-align: left; width: 100%;" cellpadding="0" cellspacing="0" >
					<thead>
						<tr style="background-color: #f9f9f9;">
							<th style="vertical-align: top; width:100%;"><strong>Materiales de Seguridad</strong></th>
						</tr>
					</thead>
					<tbody>';
					//recorro el lsiatdo entregado por la base de datos
					if ($arrMateriales!=false && !empty($arrMateriales) && $arrMateriales!='') {
						foreach ($arrMateriales as $prod) {
							$html .= '
							<tr>
								<td><i class="fa fa-eyedropper" aria-hidden="true"></i> '.$prod['Codigo'].' - '.$prod['Nombre'].'</td>
							</tr>';
						}
					}else{
						$html .= '<tr><td>No hay Materiales de Seguridad Asignados</td></tr>';
					}
				$html .= '
					</tbody>
				</table>
				<br/>
				<br/>';

			$html .= '</td>
		</tr>
	</tbody>
</table>';

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Solicitud Aplicacion N°'.n_doc($rowData['NSolicitud'], 5);
$pdf_subtitulo  = '';
$pdf_file       = 'Solicitud Aplicacion '.n_doc($rowData['NSolicitud'], 5).'.pdf';
$OpcDom         = "'A4', 'landscape'";
$OpcTcpOrt      = "L";  //P->PORTRAIT - L->LANDSCAPE
$OpcTcpPg       = "A4"; //Tipo de Hoja


/********************************************************************************/
//Se verifica que este configurado el motor de pdf
if(isset($rowEmpresa['idOpcionesGen_5'])&&$rowEmpresa['idOpcionesGen_5']!=0){
	switch ($rowEmpresa['idOpcionesGen_5']) {
		/************************************************************************/
		//TCPDF
		case 1:

			require_once('../LIBS_php/tcpdf/tcpdf.php');

			// create new PDF document
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

			// set document information
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor('Victor Reyes');
			$pdf->SetTitle('');
			$pdf->SetSubject('');
			$pdf->SetKeywords('');

			// set default header data
			if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&simpleDecode($_GET['idSistema'], fecha_actual())!=0){
				if(isset($rowEmpresa['Config_imgLogo'])&&$rowEmpresa['Config_imgLogo']!=''){
					$logo = '../../../../'.DB_SITE_MAIN_PATH.'/upload/'.$rowEmpresa['Config_imgLogo'];
				}else{
					$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
				}
			}else{
				$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
			}
			$pdf->SetHeaderData($logo, 40, $pdf_titulo, $pdf_subtitulo);

			// set header and footer fonts
			$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
			$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

			// set default monospaced font
			$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

			// set margins
			$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
			$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
			$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

			// set auto page breaks
			$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

			// set image scale factor
			$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

			// set some language-dependent strings (optional)
			if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
				require_once(dirname(__FILE__).'/lang/eng.php');
				$pdf->setLanguageArray($l);
			}

			//Se crea el archivo
			$pdf->SetFont('helvetica', '', 10);
			$pdf->AddPage($OpcTcpOrt, $OpcTcpPg);
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
			$pdf->Output(DeSanitizar($pdf_file), 'I');

			break;
		/************************************************************************/
		//DomPDF (Solo compatible con PHP 5.x)
		case 2:
			require_once '../LIBS_php/dompdf/autoload.inc.php';
			// reference the Dompdf namespace
			//use Dompdf\Dompdf;
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper($OpcDom);
			$dompdf->render();
			$dompdf->stream(DeSanitizar($pdf_file));
			break;

	}
}



?>
