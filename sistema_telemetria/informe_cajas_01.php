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
$original = "informe_cajas_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search ='&submit_filter=Filtrar';
if(isset($_GET['idCajaChica']) && $_GET['idCajaChica']!=''){                     $location .= "&idCajaChica=".$_GET['idCajaChica'];                            $search .= "&idCajaChica=".$_GET['idCajaChica'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){                   $location .= "&idTrabajador=".$_GET['idTrabajador'];                          $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){               $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];                      $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idFacturacionRelacionada']) && $_GET['idFacturacionRelacionada']!=''){  $location .= "&idFacturacionRelacionada=".$_GET['idFacturacionRelacionada'];  $search .= "&idFacturacionRelacionada=".$_GET['idFacturacionRelacionada'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                               $location .= "&idTipo=".$_GET['idTipo'];                                      $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                           $location .= "&idEstado=".$_GET['idEstado'];                                  $search .= "&idEstado=".$_GET['idEstado'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
$order_by = 'caja_chica_facturacion.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "caja_chica_facturacion.idTipo!=0";//Solo egresos
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND caja_chica_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idCajaChica']) && $_GET['idCajaChica']!=''){                     $SIS_where .= " AND caja_chica_facturacion.idCajaChica=".$_GET['idCajaChica'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){                   $SIS_where .= " AND caja_chica_facturacion.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){               $SIS_where .= " AND caja_chica_facturacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['idFacturacionRelacionada']) && $_GET['idFacturacionRelacionada']!=''){  $SIS_where .= " AND caja_chica_facturacion.idFacturacionRelacionada='".$_GET['idFacturacionRelacionada']."'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                               $SIS_where .= " AND caja_chica_facturacion.idTipo='".$_GET['idTipo']."'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                           $SIS_where .= " AND caja_chica_facturacion.idEstado='".$_GET['idEstado']."'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'caja_chica_facturacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
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
$SIS_order = 'caja_chica_facturacion.Creacion_fecha ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'caja_chica_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
	</ul>

</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Cotizaciones</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Movimiento</th>
						<th>Fecha</th>
						<th>Trabajador</th>
						<th>Doc Rendicion Relacionado</th>
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
							<td><?php if(isset($tipo['idTipo'])&&$tipo['idTipo']==3){ echo n_doc($tipo['idFacturacionRelacionada'], 8);} ?></td>
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
									<a href="<?php echo 'view_mov_caja_chica.php?view='.simpleEncode($tipo['ID'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<?php
									//solo si es rendicion
									if(isset($tipo['idTipo'])&&$tipo['idTipo']==3){
										echo '<a href="view_mov_caja_chica.php?view='.simpleEncode($tipo['idFacturacionRelacionada'], fecha_actual()).'" title="Ver Documento Relacionado" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';	
									}
									?>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
$z = "caja_chica_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_cajas_chicas.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}

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
				if(isset($idCajaChica)){                $x1  = $idCajaChica;               }else{$x1  = '';}
				if(isset($idTrabajador)){               $x2  = $idTrabajador;              }else{$x2  = '';}
				if(isset($Creacion_fecha)){             $x3  = $Creacion_fecha;            }else{$x3  = '';}
				if(isset($idFacturacionRelacionada)){   $x4  = $idFacturacionRelacionada;  }else{$x4  = '';}
				if(isset($idTipo)){                     $x5  = $idTipo;                    }else{$x5  = '';}
				if(isset($idEstado)){                   $x6  = $idEstado;                  }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_join_filter('Caja','idCajaChica', $x1, 2, 'idCajaChica', 'Nombre', 'caja_chica_listado', 'usuarios_cajas_chicas', $z, $dbConn);
				$Form_Inputs->form_select_filter('Trabajador Asignado','idTrabajador', $x2, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha de Creacion','Creacion_fecha', $x3, 1);
				$Form_Inputs->form_input_number('N° Doc Relacionado', 'idFacturacionRelacionada', $x4, 1);
				$Form_Inputs->form_select('Tipo Movimiento','idTipo', $x5, 1, 'idTipo', 'Nombre', 'caja_chica_facturacion_tipo', 0, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estado_caja', 0, '', $dbConn);

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
