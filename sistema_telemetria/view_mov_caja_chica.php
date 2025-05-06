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
// consulto los datos
$SIS_query = '
caja_chica_facturacion.idTipo,
caja_chica_listado.Nombre AS CajaNombre,
core_sistemas.Nombre AS CajaSistema,
usuarios_listado.Nombre AS Usuario,
caja_chica_facturacion_tipo.Nombre AS CajaTipo,
core_estado_caja.Nombre AS CajaEstado,
caja_chica_facturacion.fecha_auto,
caja_chica_facturacion.Creacion_fecha,
caja_chica_facturacion.Observaciones,
caja_chica_facturacion.Valor,

caja_chica_facturacion.idSolicitado,
caja_chica_facturacion.idRevisado,
caja_chica_facturacion.idAprobado,

trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_listado.Cargo AS TrabajadorCargo,
trabajadores_listado.Fono AS TrabajadorFono,
trabajadores_listado.Rut AS TrabajadorRut,
caja_chica_facturacion.idFacturacionRelacionada,

trab_rel.Nombre AS TrabRelNombre,
trab_rel.ApellidoPat AS TrabRelApellidoPat,
trab_rel.ApellidoMat AS TrabRelApellidoMat,
trab_rel.Cargo AS TrabRelCargo,
trab_rel.Fono AS TrabRelFono,
trab_rel.Rut AS TrabRelRut,
fact_rel.Valor AS RelValor,

trab_soli.Nombre AS SolicitadoNombre,
trab_soli.ApellidoPat AS SolicitadoApellidoPat,

trab_revi.Nombre AS RevisadoNombre,
trab_revi.ApellidoPat AS RevisadoApellidoPat,

trab_apro.Nombre AS AprobadoNombre,
trab_apro.ApellidoPat AS AprobadoApellidoPat';
$SIS_join  = '
LEFT JOIN `caja_chica_listado`                  ON caja_chica_listado.idCajaChica       = caja_chica_facturacion.idCajaChica
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema              = caja_chica_facturacion.idSistema
LEFT JOIN `usuarios_listado`                    ON usuarios_listado.idUsuario           = caja_chica_facturacion.idUsuario
LEFT JOIN `caja_chica_facturacion_tipo`         ON caja_chica_facturacion_tipo.idTipo   = caja_chica_facturacion.idTipo
LEFT JOIN `core_estado_caja`                    ON core_estado_caja.idEstado            = caja_chica_facturacion.idEstado
LEFT JOIN `trabajadores_listado`                ON trabajadores_listado.idTrabajador    = caja_chica_facturacion.idTrabajador
LEFT JOIN `caja_chica_facturacion`   fact_rel   ON fact_rel.idFacturacion               = caja_chica_facturacion.idFacturacionRelacionada
LEFT JOIN `trabajadores_listado`     trab_rel   ON trab_rel.idTrabajador                = fact_rel.idTrabajador
LEFT JOIN `trabajadores_listado`     trab_soli  ON trab_soli.idTrabajador               = caja_chica_facturacion.idSolicitado
LEFT JOIN `trabajadores_listado`     trab_revi  ON trab_revi.idTrabajador               = caja_chica_facturacion.idRevisado
LEFT JOIN `trabajadores_listado`     trab_apro  ON trab_apro.idTrabajador               = caja_chica_facturacion.idAprobado';
$SIS_where = 'caja_chica_facturacion.idFacturacion ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'caja_chica_facturacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = '
sistema_documentos_pago.Nombre,
caja_chica_facturacion_existencias.N_Doc,
caja_chica_facturacion_existencias.Valor';
$SIS_join  = 'LEFT JOIN `sistema_documentos_pago` ON sistema_documentos_pago.idDocPago = caja_chica_facturacion_existencias.idDocPago';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'sistema_documentos_pago.Nombre ASC';
$arrDocumentos = array();
$arrDocumentos = db_select_array (false, $SIS_query, 'caja_chica_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrDocumentos');

/*****************************************/
// Se trae un listado con todos los productos utilizados
$SIS_query = 'Item, Valor';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Item ASC';
$arrRendiciones = array();
$arrRendiciones = db_select_array (false, $SIS_query, 'caja_chica_facturacion_rendiciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrRendiciones');

/*****************************************/
// Se trae un listado con todos los archivos adjuntos
$SIS_query = 'Nombre';
$SIS_join  = '';
$SIS_where = 'idFacturacion ='.$X_Puntero;
$SIS_order = 'Nombre ASC';
$arrArchivo = array();
$arrArchivo = db_select_array (false, $SIS_query, 'caja_chica_facturacion_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArchivo');

/*****************************************/
// Se trae un listado con el historial
$SIS_query = '
caja_chica_facturacion_historial.Creacion_fecha, 
caja_chica_facturacion_historial.Observacion,
core_historial_tipos.FonAwesome,
usuarios_listado.Nombre AS Usuario';
$SIS_join  = '
LEFT JOIN `core_historial_tipos` ON core_historial_tipos.idTipo = caja_chica_facturacion_historial.idTipo
LEFT JOIN `usuarios_listado`     ON usuarios_listado.idUsuario  = caja_chica_facturacion_historial.idUsuario';
$SIS_where = 'caja_chica_facturacion_historial.idFacturacion ='.$X_Puntero;
$SIS_order = 'caja_chica_facturacion_historial.idHistorial ASC';
$arrHistorial = array();
$arrHistorial = db_select_array (false, $SIS_query, 'caja_chica_facturacion_historial', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrHistorial');

?>

<section class="invoice">

	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowData['CajaTipo']?>.
				<small class="pull-right">Numero Documento: <?php echo n_doc($X_Puntero, 8) ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">

		<?php
		//se verifica el tipo de movimiento
		switch ($rowData['idTipo']) {
			//Ingreso
			case 1:
				echo '
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					Datos del Movimiento
					<address>
						Caja: <strong>'.$rowData['CajaNombre'].'</strong><br/>
						Sistema: '.$rowData['CajaSistema'].'<br/>
						Usuario: '.$rowData['Usuario'].'<br/>
						Estado Ingreso: '.$rowData['CajaEstado'].'<br/>
						Fecha Real Ingreso: '.Fecha_estandar($rowData['fecha_auto']).'<br/>
						Fecha Ingreso: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					</address>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">

				</div>';

				break;

			//Egreso
			case 2:
				
				echo '
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					Datos del Movimiento
					<address>
						Caja: <strong>'.$rowData['CajaNombre'].'</strong><br/>
						Sistema: '.$rowData['CajaSistema'].'<br/>
						Usuario: '.$rowData['Usuario'].'<br/>
						Estado Egreso: '.$rowData['CajaEstado'].'<br/>
						Fecha Real Egreso: '.Fecha_estandar($rowData['fecha_auto']).'<br/>
						Fecha Egreso: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					</address>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					Trabajador
					<address>
						<strong>'.$rowData['TrabajadorNombre'].' '.$rowData['TrabajadorApellidoPat'].' '.$rowData['TrabajadorApellidoMat'].'</strong><br/>
						Rut: '.$rowData['TrabajadorRut'].'<br/>
						Cargo: '.$rowData['TrabajadorCargo'].'<br/>
						Fono: '.formatPhone($rowData['TrabajadorFono']).'<br/>
					</address>
				</div>';
				
				break;

			//Rendicion 
			case 3:
				
				echo '
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					Datos del Movimiento
					<address>
						Caja: <strong>'.$rowData['CajaNombre'].'</strong><br/>
						Sistema: '.$rowData['CajaSistema'].'<br/>
						Usuario: '.$rowData['Usuario'].'<br/>
						Estado Rendicion: '.$rowData['CajaEstado'].'<br/>
						Fecha Real Rendicion: '.Fecha_estandar($rowData['fecha_auto']).'<br/>
						Fecha Rendicion: '.Fecha_estandar($rowData['Creacion_fecha']).'<br/>
					</address>
				</div>

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
					Documento Relacionado
					<address>
						<strong>Doc N°'.$rowData['idFacturacionRelacionada'].'</strong><br/>
						Valor: '.Valores($rowData['RelValor'], 0).'<br/>
						Trabajador: '.$rowData['TrabRelNombre'].' '.$rowData['TrabRelApellidoPat'].' '.$rowData['TrabRelApellidoMat'].'<br/>
						Rut: '.$rowData['TrabRelRut'].'<br/>
						Cargo: '.$rowData['TrabRelCargo'].'<br/>
						Fono: '.formatPhone($rowData['TrabRelFono']).'<br/>
					</address>
				</div>';
				
				break;
		} ?>

	</div>

	<div class="">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Detalle</th>
						<th width="200">Valor Ingreso</th>
						<th width="200">Valor Egreso</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($arrRendiciones!=false && !empty($arrRendiciones) && $arrRendiciones!='') { ?>
						<tr class="active"><td colspan="3"><strong>Rendiciones</strong></td></tr>
						<?php foreach ($arrRendiciones as $prod) { ?>
							<tr>
								<td><?php echo $prod['Item']; ?></td>
								<?php 
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
									echo '<td align="right">'.Valores($prod['Valor'], 0).'</td>';
									echo '<td align="right"></td>';
								}else{
									echo '<td align="right"></td>';
									echo '<td align="right">'.Valores($prod['Valor'], 0).'</td>';
								} ?>
							</tr>
						<?php } ?>
					<?php } ?>

					<?php if ($arrDocumentos!=false && !empty($arrDocumentos) && $arrDocumentos!='') { ?>
						<tr class="active"><td colspan="3"><strong>Montos</strong></td></tr>
						<?php foreach ($arrDocumentos as $prod) { ?>
							<tr>
								<td>
									<?php 
									echo $prod['Nombre'];
									if(isset($prod['N_Doc'])&&$prod['N_Doc']!=''){
										echo ' N°'.$prod['N_Doc'];
									}
									?>
								</td>
								<?php 
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
									echo '<td align="right">'.Valores($prod['Valor'], 0).'</td>';
									echo '<td align="right"></td>';
								}else{
									echo '<td align="right"></td>';
									echo '<td align="right">'.Valores($prod['Valor'], 0).'</td>';
								} ?>
							</tr>
						<?php } ?>
					<?php } ?>

					<?php if(isset($rowData['Valor'])&&$rowData['Valor']!=0){ ?>
						<tr class="invoice-total" bgcolor="#f1f1f1">
							<td align="right"><strong>Total</strong></td>
							<?php
							if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){
								echo '<td align="right">'.Valores($rowData['Valor'], 0).'</td>';
								echo '<td align="right"></td>';
							}else{
								echo '<td align="right"></td>';
								echo '<td align="right">'.Valores($rowData['Valor'], 0).'</td>';
							} ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>

		</div>
	</div>

	<div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>

	<?php
	//Egreso
	if($rowData['idTipo']==2){ ?>
		<div class="row firma">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont"><p>Firma Emisor</p></div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 fcont" style="left:50%;"><p>Firma Trabajador</p></div>
		</div>
	<?php }
	//Si es una rendicion
	if($rowData['idTipo']==3&&isset($rowData['idSolicitado'])&&$rowData['idSolicitado']!=''&&isset($rowData['idRevisado'])&&$rowData['idRevisado']!=''&&isset($rowData['idAprobado'])&&$rowData['idAprobado']!=''){ ?>

		<div class="row firma">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 fcont"><p>Solicitado Por:<br/><?php echo $rowData['SolicitadoNombre'].' '.$rowData['SolicitadoApellidoPat']; ?><br/>Firma</p></div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 fcont"><p>Revisado Por:<br/><?php echo $rowData['RevisadoNombre'].' '.$rowData['RevisadoApellidoPat']; ?><br/>Firma</p></div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 fcont"><p>Aprobado Por:<br/><?php echo $rowData['AprobadoNombre'].' '.$rowData['AprobadoApellidoPat']; ?><br/>Firma</p></div> 
		</div>
	<?php } ?>

	<?php
	$zz  = '?idSistema='.simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual());
	$zz .= '&view='.$_GET['view'];
	?>
	<div class="row no-print">
		<div class="col-xs-12">
			<a target="new" href="view_mov_caja_chica_to_print.php<?php echo $zz ?>" class="btn btn-default">
				<i class="fa fa-print" aria-hidden="true"></i> Imprimir
			</a>

			<a target="new" href="view_mov_caja_chica_to_pdf.php<?php echo $zz ?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
			</a>
		</div>
	</div>
      
</section>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:15px;">

	<?php if ($arrHistorial!=false && !empty($arrHistorial) && $arrHistorial!=''){ ?>
		<table id="items">
			<tbody>
				<tr>
					<th colspan="3">Historial</th>
				</tr>
				<tr>
					<th width="160">Fecha</th>
					<th>Usuario</th>
					<th>Observacion</th>
				</tr>
				<?php foreach ($arrHistorial as $doc){ ?>
					<tr class="item-row">
						<td><?php echo fecha_estandar($doc['Creacion_fecha']); ?></td>
						<td><?php echo $doc['Usuario']; ?></td>
						<td><?php echo '<i class="'.$doc['FonAwesome'].'" aria-hidden="true"></i> '.$doc['Observacion']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	<?php } ?>

	<?php if ($arrArchivo!=false && !empty($arrArchivo) && $arrArchivo!=''){ ?>
		<table id="items" style="margin-bottom: 20px;">
			<tbody>
				<tr>
					<th colspan="6">Archivos Adjuntos</th>
				</tr>
				<?php foreach ($arrArchivo as $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $producto['Nombre']; ?></td>
						<td width="160">
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php"); ?>" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<a href="1download.php?dir=<?php echo simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip" ><i class="fa fa-download" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
    <?php } ?>
    
</div>

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
