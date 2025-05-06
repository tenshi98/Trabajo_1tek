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
$original = "informe_telemetria_cargabam_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search ='&submit_filter=Filtrar';
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){   $location .= "&idTelemetria=".$_GET['idTelemetria'];           $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['FechaCarga']) && $_GET['FechaCarga']!=''){       $location .= "&FechaCarga=".$_GET['FechaCarga'];               $search .= "&FechaCarga=".$_GET['FechaCarga'];}
if(isset($_GET['FechaVencimiento']) && $_GET['FechaVencimiento']!=''){  $location .= "&FechaVencimiento=".$_GET['FechaVencimiento'];   $search .= "&FechaVencimiento=".$_GET['FechaVencimiento'];}
if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){         $location .= "&idDocPago=".$_GET['idDocPago'];                 $search .= "&idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){         $location .= "&N_DocPago=".$_GET['N_DocPago'];                 $search .= "&N_DocPago=".$_GET['N_DocPago'];}
if(isset($_GET['Monto']) && $_GET['Monto']!=''){                 $location .= "&Monto=".$_GET['Monto'];                         $search .= "&Monto=".$_GET['Monto'];}
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
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'equipo_asc':      $order_by = 'telemetria_listado.Nombre ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Equipo Ascendente'; break;
		case 'equipo_desc':     $order_by = 'telemetria_listado.Nombre DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Equipo Descendente';break;
		case 'usuario_asc':     $order_by = 'usuarios_listado.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
		case 'usuario_desc':    $order_by = 'usuarios_listado.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
		case 'fechacarga_asc':  $order_by = 'telemetria_carga_bam.FechaCarga ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Carga Ascendente'; break;
		case 'fechacarga_desc': $order_by = 'telemetria_carga_bam.FechaCarga DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Carga Descendente';break;
		case 'fechavenc_asc':   $order_by = 'telemetria_carga_bam.FechaVencimiento ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Vencimiento Ascendente';break;
		case 'fechavenc_desc':  $order_by = 'telemetria_carga_bam.FechaVencimiento DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Vencimiento Descendente';break;
		case 'monto_asc':       $order_by = 'telemetria_carga_bam.Monto ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Monto Ascendente';break;
		case 'monto_desc':      $order_by = 'telemetria_carga_bam.Monto DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Monto Descendente';break;

		default: $order_by = 'telemetria_carga_bam.FechaVencimiento DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Vencimiento Descendente';
	}
}else{
	$order_by = 'telemetria_carga_bam.FechaVencimiento DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Vencimiento Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_carga_bam.idCarga!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){   $SIS_where .= " AND telemetria_carga_bam.idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['FechaCarga']) && $_GET['FechaCarga']!=''){       $SIS_where .= " AND telemetria_carga_bam.FechaCarga='".$_GET['FechaCarga']."'";}
if(isset($_GET['FechaVencimiento']) && $_GET['FechaVencimiento']!=''){  $SIS_where .= " AND telemetria_carga_bam.FechaVencimiento='".$_GET['FechaVencimiento']."'";}
if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){         $SIS_where .= " AND telemetria_carga_bam.idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){         $SIS_where .= " AND telemetria_carga_bam.N_DocPago LIKE '%".EstandarizarInput($_GET['N_DocPago'])."%'";}
if(isset($_GET['Monto']) && $_GET['Monto']!=''){                 $SIS_where .= " AND telemetria_carga_bam.Monto LIKE '%".EstandarizarInput($_GET['Monto'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idCarga', 'telemetria_carga_bam', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_carga_bam.idCarga,
telemetria_listado.Nombre AS EquipoTel,
usuarios_listado.Nombre AS Usuario,
telemetria_carga_bam.FechaCarga,
telemetria_carga_bam.FechaVencimiento,
telemetria_carga_bam.Monto';
$SIS_join  = '
LEFT JOIN `telemetria_listado`   ON telemetria_listado.idTelemetria  = telemetria_carga_bam.idTelemetria
LEFT JOIN `usuarios_listado`     ON usuarios_listado.idUsuario       = telemetria_carga_bam.idUsuario';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrCarga = array();
$arrCarga = db_select_array (false, $SIS_query, 'telemetria_carga_bam', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCarga');

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Cargas</h5>
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
						<th>
							<div class="pull-left">Equipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=equipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=equipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Usuario Carga</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Carga</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechacarga_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechacarga_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Vencimiento</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechavenc_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechavenc_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Monto</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=monto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=monto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrCarga as $carga) { ?>

					<tr class="odd">
						<td><?php echo $carga['EquipoTel']; ?></td>
						<td><?php echo $carga['Usuario']; ?></td>
						<td><?php echo fecha_estandar($carga['FechaCarga']); ?></td>
						<td><?php echo fecha_estandar($carga['FechaVencimiento']); ?></td>
						<td align="right"><?php echo valores($carga['Monto'], 0); ?></td>
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
$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
				if(isset($idTelemetria)){     $x1  = $idTelemetria;      }else{$x1  = '';}
				if(isset($FechaCarga)){       $x2  = $FechaCarga;        }else{$x2  = '';}
				if(isset($FechaVencimiento)){ $x3  = $FechaVencimiento;  }else{$x3  = '';}
				if(isset($idDocPago)){        $x4  = $idDocPago;         }else{$x4  = '';}
				if(isset($N_DocPago)){        $x5  = $N_DocPago;         }else{$x5  = '';}
				if(isset($Monto)){            $x6  = $Monto;             }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				}
				$Form_Inputs->form_date('Fecha Carga','FechaCarga', $x2, 1);
				$Form_Inputs->form_date('Fecha Vencimiento','FechaVencimiento', $x3, 1);
				$Form_Inputs->form_select('Documento de Pago','idDocPago', $x4, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x5, 1);
				$Form_Inputs->form_values('Monto', 'Monto', $x6, 1);

				$Form_Inputs->form_input_hidden('pagina', 1, 2);

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
