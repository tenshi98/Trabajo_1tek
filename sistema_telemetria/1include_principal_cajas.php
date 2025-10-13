<?php
/**********************************************************/
//Variable con la ubicacion
$SIS_where="caja_chica_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idCajaChica']) && $_GET['idCajaChica']!=''){                     $SIS_where .= " AND caja_chica_facturacion.idCajaChica=".$_GET['idCajaChica'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){                   $SIS_where .= " AND caja_chica_facturacion.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){               $SIS_where .= " AND caja_chica_facturacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['idFacturacionRelacionada']) && $_GET['idFacturacionRelacionada']!=''){  $SIS_where .= " AND caja_chica_facturacion.idFacturacionRelacionada='".$_GET['idFacturacionRelacionada']."'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                               $SIS_where .= " AND caja_chica_facturacion.idTipo='".$_GET['idTipo']."'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                           $SIS_where .= " AND caja_chica_facturacion.idEstado='".$_GET['idEstado']."'";}
/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
caja_chica_facturacion.idFacturacion AS ID,
caja_chica_facturacion.idFacturacionRelacionada,
caja_chica_facturacion.Creacion_fecha,
caja_chica_listado.Nombre AS Caja,
core_sistemas.Nombre AS Sistema,
caja_chica_facturacion.Valor,
caja_chica_facturacion.idTipo,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
caja_chica_facturacion_tipo.Nombre AS TipoMov,
(SELECT SUM(Valor) FROM `caja_chica_facturacion_existencias` WHERE idFacturacion=ID LIMIT 1 )AS MovSum,
(SELECT SUM(Valor) FROM `caja_chica_facturacion_rendiciones` WHERE idFacturacion=ID LIMIT 1 )AS DevSum';
$SIS_join  = '
LEFT JOIN `caja_chica_listado`           ON caja_chica_listado.idCajaChica      = caja_chica_facturacion.idCajaChica
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema             = caja_chica_facturacion.idSistema
LEFT JOIN `trabajadores_listado`         ON trabajadores_listado.idTrabajador   = caja_chica_facturacion.idTrabajador
LEFT JOIN `caja_chica_facturacion_tipo`  ON caja_chica_facturacion_tipo.idTipo  = caja_chica_facturacion.idTipo';
$SIS_order = 'caja_chica_facturacion.Creacion_fecha DESC LIMIT 50';
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'caja_chica_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Movimientos de <?php echo $arrTipo[0]['Caja']?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Movimiento</th>
						<th>Fecha</th>
						<th>Trabajador</th>
						<th>Doc Relacionado</th>
						<th>Ingreso</th>
						<th>Egreso</th>
						<th>Rendicion</th>
						<th>Monto</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['TipoMov']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td><?php echo $tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat']; ?></td>
							<td><?php echo n_doc($tipo['idFacturacionRelacionada'], 8); ?></td>
							<?php
							//Reviso el tipo de movimiento
							switch ($tipo['idTipo']) {
								//Ingreso Caja Chica
								case 1:
									echo '<td align="right">'.Valores($tipo['MovSum'], 0).'</td>';
									echo '<td align="right"></td>';
									echo '<td align="right"></td>';
									break;
								//Egreso Caja Chica
								case 2:
									echo '<td align="right"></td>';
									echo '<td align="right">'.Valores($tipo['MovSum'], 0).'</td>';
									echo '<td align="right"></td>';
									break;
								//Rendicion Caja Chica
								case 3:
									echo '<td align="right">'.Valores($tipo['MovSum'], 0).'</td>';
									echo '<td align="right"></td>';
									echo '<td align="right">'.Valores($tipo['DevSum'], 0).'</td>';
									break;
							}
							
							?>
							<td align="right"><strong><?php echo Valores($tipo['Valor'], 0); ?></strong></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_mov_caja_chica.php?view='.simpleEncode($tipo['ID'], fecha_actual()).'&return=true'; ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<?php
									//solo si es rendicion
									if(isset($tipo['idTipo'])&&$tipo['idTipo']==3){
										echo '<a href="view_mov_caja_chica.php?view='.simpleEncode($tipo['idFacturacionRelacionada'], fecha_actual()).'&return=true" title="Ver Documento Relacionado" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';	
									}
									?>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
