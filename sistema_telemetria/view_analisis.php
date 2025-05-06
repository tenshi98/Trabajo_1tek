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
require_once 'core/Load.Utils.Views.php';
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
require_once 'core/Web.Header.Views.php';
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
//Preconsulta
$SIS_query = 'maquinas_listado_matriz.cantPuntos';
$SIS_join  = 'LEFT JOIN `maquinas_listado_matriz` ON maquinas_listado_matriz.idMatriz = analisis_listado.idMatriz';
$SIS_where = 'analisis_listado.idAnalisis ='.$X_Puntero;
$rowpre = db_select_data (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowpre');

/**********************************************************************/
//Costruyo cadena con los datos a filtrar
$consql = '';
for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
	$consql .= ',maquinas_listado_matriz.PuntoNombre_'.$i.' AS PuntoNombre_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoMedAceptable_'.$i.' AS PuntoMedAceptable_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoMedAlerta_'.$i.' AS PuntoMedAlerta_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoMedCondenatorio_'.$i.' AS PuntoMedCondenatorio_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoUniMed_'.$i.' AS PuntoUniMed_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoidTipo_'.$i.' AS PuntoidTipo_'.$i;
	$consql .= ',maquinas_listado_matriz.PuntoidGrupo_'.$i.' AS PuntoidGrupo_'.$i;
	$consql .= ',analisis_listado.Medida_'.$i.' AS Analisis_Medida_'.$i;
}
/**********************************************************************/
// consulto los datos
$SIS_query = '
maquinas_listado.Codigo AS MaquinaCodigo,
maquinas_listado.Nombre AS MaquinaNombre,
maquinas_listado.Modelo AS MaquinaModelo,
maquinas_listado.Serie AS MaquinaSerie,
maquinas_listado.Fabricante AS MaquinaFabricante,
ubicacion_listado.Nombre  AS MaquinaUbicacion,
ubicacion_listado_level_1.Nombre  AS MaquinaUbicacion_lvl_1,
ubicacion_listado_level_2.Nombre  AS MaquinaUbicacion_lvl_2,
ubicacion_listado_level_3.Nombre  AS MaquinaUbicacion_lvl_3,
ubicacion_listado_level_4.Nombre  AS MaquinaUbicacion_lvl_4,
ubicacion_listado_level_5.Nombre  AS MaquinaUbicacion_lvl_5,

core_analisis_estado.Nombre  AS Analisis_Estado,
core_sistemas.Nombre  AS Analisis_Sistema,
analisis_listado.idOT  AS Analisis_OT,
analisis_listado.f_muestreo  AS Analisis_f_muestreo,
analisis_listado.f_recibida  AS Analisis_f_recibida,
analisis_listado.f_reporte  AS Analisis_f_reporte,
analisis_listado.n_muestra  AS Analisis_n_muestra,
analisis_listado.obs_Diagnostico  AS Analisis_obs_Diagnostico,
analisis_listado.obs_Accion  AS Analisis_obs_Accion,

core_sistemas.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,

analisis_listado.idTipo,
laboratorio_listado.Nombre AS LaboratorioNombre,
lab_ciudad.Nombre AS LaboratorioCiudad,
lab_comuna.Nombre AS LaboratorioComuna,
laboratorio_listado.Direccion AS LaboratorioDireccion,
laboratorio_listado.Fono1 AS LaboratorioFono1,
laboratorio_listado.Fono2 AS LaboratorioFono2,
laboratorio_listado.email AS LaboratorioEmail,
laboratorio_listado.PersonaContacto AS LaboratorioContacto,
laboratorio_listado.Rut AS LaboratorioRut,

maquinas_listado_matriz.Nombre  AS Analisis_Nombre'.$consql;
$SIS_join  = '
LEFT JOIN `maquinas_listado`                        ON maquinas_listado.idMaquina              = analisis_listado.idMaquina
LEFT JOIN `ubicacion_listado`                       ON ubicacion_listado.idUbicacion           = maquinas_listado.idUbicacion
LEFT JOIN `ubicacion_listado_level_1`               ON ubicacion_listado_level_1.idLevel_1     = maquinas_listado.idUbicacion_lvl_1
LEFT JOIN `ubicacion_listado_level_2`               ON ubicacion_listado_level_2.idLevel_2     = maquinas_listado.idUbicacion_lvl_2
LEFT JOIN `ubicacion_listado_level_3`               ON ubicacion_listado_level_3.idLevel_3     = maquinas_listado.idUbicacion_lvl_3
LEFT JOIN `ubicacion_listado_level_4`               ON ubicacion_listado_level_4.idLevel_4     = maquinas_listado.idUbicacion_lvl_4
LEFT JOIN `ubicacion_listado_level_5`               ON ubicacion_listado_level_5.idLevel_5     = maquinas_listado.idUbicacion_lvl_5
LEFT JOIN `maquinas_listado_matriz`                 ON maquinas_listado_matriz.idMatriz        = analisis_listado.idMatriz
LEFT JOIN `core_analisis_estado`                    ON core_analisis_estado.idEstado           = analisis_listado.idEstado
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                 = analisis_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                  = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                  = core_sistemas.idComuna
LEFT JOIN `laboratorio_listado`                     ON laboratorio_listado.idLaboratorio       = analisis_listado.idLaboratorio
LEFT JOIN `core_ubicacion_ciudad`   lab_ciudad      ON lab_ciudad.idCiudad                     = laboratorio_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`  lab_comuna      ON lab_comuna.idComuna                     = laboratorio_listado.idComuna';
$SIS_where = 'analisis_listado.idAnalisis ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/**********************************************************************/
//Se traen todas las unidades de medida
$SIS_query = 'idUml,Nombre,Abreviatura';
$SIS_join  = '';
$SIS_where = 'idUml!=0';
$SIS_order = 'idUml ASC';
$arrUnimed = array();
$arrUnimed = db_select_array (false, $SIS_query, 'sistema_analisis_uml', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

/**********************************************************************/
//Se consultan datos
$SIS_query = 'idGrupo, Nombre';
$SIS_join  = '';
$SIS_where = 'idGrupo!=0';
$SIS_order = 'idGrupo ASC';
$arrGrupo = array();
$arrGrupo = db_select_array (false, $SIS_query, 'maquinas_listado_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupo');

/**********************************************************************/
//Se traen todos los productos
$SIS_query = 'idProducto, Nombre';
$SIS_join  = '';
$SIS_where = 'idProducto!=0';
$SIS_order = 'Nombre ASC';
$arrProducto = array();
$arrProducto = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProducto');

/**********************************************************************/
//Se traen todos los productos
$SIS_query = 'idDispersancia, Nombre';
$SIS_join  = '';
$SIS_where = 'idDispersancia!=0';
$SIS_order = 'Nombre ASC';
$arrDispersancia = array();
$arrDispersancia = db_select_array (false, $SIS_query, 'core_analisis_dispersancia', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDispersancia');

/**********************************************************************/
//Se traen todos los productos
$SIS_query = 'idFlashPoint, Nombre';
$SIS_join  = '';
$SIS_where = 'idFlashPoint!=0';
$SIS_order = 'Nombre ASC';
$arrFlashpoint = array();
$arrFlashpoint = db_select_array (false, $SIS_query, 'core_analisis_flashpoint', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrFlashpoint');

/**********************************************************************/
//variables
$arrFinalUnimed       = array();
$arrFinalGrupo        = array();
$arrFinalProducto     = array();
$arrFinalDispersancia = array();
$arrFinalFlashpoint   = array();

//Se recorren los datos
foreach ($arrUnimed as $datos) {
	$arrFinalUnimed[$datos['idUml']]['Nombre']      = $datos['Nombre'];
	$arrFinalUnimed[$datos['idUml']]['Abreviatura'] = $datos['Abreviatura'];
}
foreach ($arrGrupo as $datos) {
	$arrFinalGrupo[$datos['idGrupo']]['Nombre'] = $datos['Nombre'];
}
foreach ($arrProducto as $datos) {
	$arrFinalProducto[$datos['idProducto']]['Nombre'] = $datos['Nombre'];
}
foreach ($arrDispersancia as $datos) {
	$arrFinalDispersancia[$datos['idDispersancia']]['Nombre'] = $datos['Nombre'];
}
foreach ($arrFlashpoint as $datos) {
	$arrFinalFlashpoint[$datos['idFlashPoint']]['Nombre'] = $datos['Nombre'];
}

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['Analisis_Nombre']?>.
				<small class="pull-right">Fecha Reporte: <?php echo Fecha_estandar($rowData['Analisis_f_reporte']); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php

				//Si es interno muestro los datos de la empresa
				if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
					echo '
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
						Laboratorio
						<address>
							<strong>'.$rowData['SistemaOrigen'].'</strong><br/>
							'.$rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna'].'<br/>
							'.$rowData['SistemaOrigenDireccion'].'<br/>
							Fono : '.formatPhone($rowData['SistemaOrigenFono']).'<br/>
							Rut: '.$rowData['SistemaOrigenRut'].'<br/>
							Email: '.$rowData['SistemaOrigenEmail'].'<br/>
						</address>
					</div>';
				//si es externo muestro los datos del laboratorio
				}else{
					echo '
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
						Laboratorio
						<address>
							<strong>'.$rowData['LaboratorioNombre'].'</strong><br/>
							'.$rowData['LaboratorioCiudad'].', '.$rowData['LaboratorioComuna'].'<br/>
							'.$rowData['LaboratorioDireccion'].'<br/>
							Fono 1 : '.formatPhone($rowData['LaboratorioFono1']).'<br/>
							Fono 2 : '.formatPhone($rowData['LaboratorioFono2']).'<br/>
							Rut: '.$rowData['LaboratorioRut'].'<br/>
							Email: '.$rowData['LaboratorioEmail'].'<br/>
							Persona Contacto: '.$rowData['LaboratorioContacto'].'<br/>
						</address>
					</div>';
				}

				echo '
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					Maquina
					<address>
						<strong>'.$rowData['MaquinaNombre'].'</strong><br/>
						Codigo: '.$rowData['MaquinaCodigo'].'<br/>
						Modelo: '.$rowData['MaquinaModelo'].'<br/>
						Serie: '.$rowData['MaquinaSerie'].'<br/>
						Fabricante: '.$rowData['MaquinaFabricante'].'<br/>
						Ubicación: '.$rowData['MaquinaUbicacion'];
						if(isset($rowData['MaquinaUbicacion_lvl_1'])&&$rowData['MaquinaUbicacion_lvl_1']!=''){
							echo ' - '.$rowData['MaquinaUbicacion_lvl_1'];
						}
						if(isset($rowData['MaquinaUbicacion_lvl_2'])&&$rowData['MaquinaUbicacion_lvl_2']!=''){
							echo ' - '.$rowData['MaquinaUbicacion_lvl_2'];
						}
						if(isset($rowData['MaquinaUbicacion_lvl_3'])&&$rowData['MaquinaUbicacion_lvl_3']!=''){
							echo ' - '.$rowData['MaquinaUbicacion_lvl_3'];
						}
						if(isset($rowData['MaquinaUbicacion_lvl_4'])&&$rowData['MaquinaUbicacion_lvl_4']!=''){
							echo ' - '.$rowData['MaquinaUbicacion_lvl_4'];
						}
						if(isset($rowData['MaquinaUbicacion_lvl_5'])&&$rowData['MaquinaUbicacion_lvl_5']!=''){
							echo ' - '.$rowData['MaquinaUbicacion_lvl_5'];
						}
					echo '
					</address>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
					<strong>Datos</strong><br/>
					<strong>Estado: </strong>'.$rowData['Analisis_Estado'].'<br/>
					<strong>Sistema: </strong>'.$rowData['Analisis_Sistema'].'<br/>';

					if(isset($rowData['Analisis_OT'])&&$rowData['Analisis_OT']!=''&&$rowData['Analisis_OT']!=0){
						echo '<strong>Orden Trabajo Relacionada: </strong>'.$rowData['Analisis_OT'].'<br/>';
					}
					if(isset($rowData['Analisis_f_muestreo'])&&$rowData['Analisis_f_muestreo']!=''&&$rowData['Analisis_f_muestreo']!='0000-00-00'){
						echo '<strong>Fecha Muestreo : </strong>'.Fecha_estandar($rowData['Analisis_f_muestreo']).'<br/>';
					}
					if(isset($rowData['Analisis_f_recibida'])&&$rowData['Analisis_f_recibida']!=''&&$rowData['Analisis_f_recibida']!='0000-00-00'){
						echo '<strong>Fecha Recepcion : </strong>'.Fecha_estandar($rowData['Analisis_f_recibida']).'<br/>';
					}
					if(isset($rowData['Analisis_f_reporte'])&&$rowData['Analisis_f_reporte']!=''&&$rowData['Analisis_f_reporte']!='0000-00-00'){
						echo '<strong>Fecha Reporte : </strong>'.Fecha_estandar($rowData['Analisis_f_reporte']).'<br/>';
					}
					if(isset($rowData['Analisis_n_muestra'])&&$rowData['Analisis_n_muestra']!=''){
						echo '<strong>Muestra N° : </strong>'.$rowData['Analisis_n_muestra'].'<br/>';
					}
				echo '</div>';
			?>

	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive"  style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<?php foreach ($arrGrupo as $grupo) {
				//Cuento si hay items dentro de la categoria
				$x_con = 0;
				for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
					if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
						$x_con++;
					}
				}

				//si hay items se muestra todo
				if($x_con!=0){

					echo '<table class="table table-striped">';
					echo '<tbody><tr class="active"><td colspan="5"><strong>'.$grupo['Nombre'].'</strong></td></tr>';
					if($grupo['idGrupo']==4 OR $grupo['idGrupo']==5){
						echo '
						<tr class="active">
							<td><strong>Dato Medido</strong></td>
							<td><strong>Medicion Actual</strong></td>
							<td><strong>Aceptable</strong></td>
							<td><strong>Alerta</strong></td>
							<td><strong>Condenatorio</strong></td>
						</tr>';
					}

					for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
						if($grupo['idGrupo']==$rowData['PuntoidGrupo_'.$i]){
							//obtengo la unidad de medida
							//Verifico la existencia de la abreviatura
							if(isset($arrFinalUnimed[$rowData['PuntoUniMed_'.$i]]['Abreviatura'])&&$arrFinalUnimed[$rowData['PuntoUniMed_'.$i]]['Abreviatura']!=''){
								$uniMed = $arrFinalUnimed[$rowData['PuntoUniMed_'.$i]]['Abreviatura'];
							}else{
								$uniMed = $arrFinalUnimed[$rowData['PuntoUniMed_'.$i]]['Nombre'];
							}
							//obtengo datos
							$Producto     = $arrFinalProducto[$rowData['Analisis_Medida_'.$i]]['Nombre'];
							$Dispersancia = $arrFinalDispersancia[$rowData['Analisis_Medida_'.$i]]['Nombre'];
							$Flashpoint   = $arrFinalFlashpoint[$rowData['Analisis_Medida_'.$i]]['Nombre'];

							//comparo el tipo de dato a mostrar
							switch ($rowData['PuntoidTipo_'.$i]) {
								//Medidas
								case 1:
									/***************************************************************/
									//variable vacia
									$alert_lvl = '';
									//verifico cual es mayor para proceder a la verificacion
									if($rowData['PuntoMedAceptable_'.$i]>$rowData['PuntoMedCondenatorio_'.$i]){
										//alerta amarilla
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]>$rowData['PuntoMedAlerta_'.$i]&&$rowData['Analisis_Medida_'.$i]<=$rowData['PuntoMedAceptable_'.$i]){
											//variables alerta amarilla
											$alert_lvl = 'color-green-dark'; //amarilla
										}
										//alerta naranja
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]>$rowData['PuntoMedCondenatorio_'.$i]&&$rowData['Analisis_Medida_'.$i]<=$rowData['PuntoMedAlerta_'.$i]){
											//variables alerta naranja
											$alert_lvl = 'color-yellow'; //naranja
										}
										//alerta roja
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]<=$rowData['PuntoMedCondenatorio_'.$i]){
											//variables alerta roja
											$alert_lvl = 'color-red-dark'; //roja
										}

									/***************************************************************/
									}elseif($rowData['PuntoMedAceptable_'.$i]<$rowData['PuntoMedCondenatorio_'.$i]){
										//alerta amarilla
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]<$rowData['PuntoMedAlerta_'.$i]&&$rowData['Analisis_Medida_'.$i]>=$rowData['PuntoMedAceptable_'.$i]){
											//variables alerta amarilla
											$alert_lvl = 'color-green-dark'; //amarilla
										}
										//alerta naranja
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]<$rowData['PuntoMedCondenatorio_'.$i]&&$rowData['Analisis_Medida_'.$i]>=$rowData['PuntoMedAlerta_'.$i]){
											//variables alerta naranja
											$alert_lvl = 'color-yellow'; //naranja
										}
										//alerta roja
										if(isset($rowData['Analisis_Medida_'.$i])&&$rowData['Analisis_Medida_'.$i]!=''&&$rowData['Analisis_Medida_'.$i]>=$rowData['PuntoMedCondenatorio_'.$i]){
											//variables alerta roja
											$alert_lvl = 'color-red-dark'; //roja
										}

									}

									/*******************************/
									echo '<tr>';
										echo '<td>'.$rowData['PuntoNombre_'.$i].'</td>';
										echo '<td><span class="'.$alert_lvl.'">'.Cantidades_decimales_justos($rowData['Analisis_Medida_'.$i]).' '.$uniMed.'</span></td>';
										echo '<td><span class="color-green-dark">'.Cantidades_decimales_justos($rowData['PuntoMedAceptable_'.$i]).' '.$uniMed.'</span></td>';
										echo '<td><span class="color-yellow">'.Cantidades_decimales_justos($rowData['PuntoMedAlerta_'.$i]).' '.$uniMed.'</span></td>';
										echo '<td><span class="color-red-dark">'.Cantidades_decimales_justos($rowData['PuntoMedCondenatorio_'.$i]).' '.$uniMed.'</span></td>';
									echo '</tr>';
									break;
								//Producto
								case 2:
									echo '<tr>';
										echo '<td width="200">Producto Utilizado</td>';
										echo '<td colspan="4">'.$Producto.'</td>';
									echo '</tr>';
									break;
								//Dispersancia
								case 3:
									echo '<tr>';
										echo '<td width="200">Dispersancia</td>';
										echo '<td colspan="4">'.$Dispersancia.'</td>';
									echo '</tr>';
									break;
								//Flashpoint
								case 4:
									echo '<tr>';
										echo '<td width="200">Flashpoint</td>';
										echo '<td colspan="4">'.$Flashpoint.'</td>';
									echo '</tr>';
									break;
							}
						}
					}
					echo '</tbody>';
					echo '</table>';

				}
			} ?>

		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Diagnostico:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Analisis_obs_Diagnostico']; ?></p>
		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Recomendaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Analisis_obs_Accion']; ?></p>
		</div>
	</div>

</section>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
