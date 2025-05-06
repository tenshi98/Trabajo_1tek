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
$original = "informe_cross_checking_05.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){ $location .= "&idSolicitud=".$_GET['idSolicitud'];        $search .= "&idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $location .= "&NSolicitud=".$_GET['NSolicitud'];          $search .= "&NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $location .= "&idZona=".$_GET['idZona'];                  $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $location .= "&idTemporada=".$_GET['idTemporada'];        $search .= "&idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $location .= "&idEstadoFen=".$_GET['idEstadoFen'];        $search .= "&idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $location .= "&idCategoria=".$_GET['idCategoria'];        $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $location .= "&idProducto=".$_GET['idProducto'];          $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $location .= "&idUsuario=".$_GET['idUsuario'];            $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $location .= "&idEstado=".$_GET['idEstado'];              $search .= "&idEstado=".$_GET['idEstado'];}

if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$search .="&f_programacion_desde=".$_GET['f_programacion_desde'];
	$search .="&f_programacion_hasta=".$_GET['f_programacion_hasta'];
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$search .="&f_ejecucion_desde=".$_GET['f_ejecucion_desde'];
	$search .="&f_ejecucion_hasta=".$_GET['f_ejecucion_hasta'];
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$search .="&f_termino_desde=".$_GET['f_termino_desde'];
	$search .="&f_termino_hasta=".$_GET['f_termino_hasta'];
}     
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
if(!empty($_GET['submit_filter'])){
/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}

if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_ejecucion_fin,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_solicitud_aplicacion_listado.idEstado,

core_estado_solicitud.Nombre AS Estado,

cross_solicitud_aplicacion_listado.idSolicitud AS ID,
(SELECT COUNT(idEstado) FROM cross_solicitud_aplicacion_listado_cuarteles WHERE idSolicitud=ID) AS N_Cuarteles,
(SELECT COUNT(idEstado) FROM cross_solicitud_aplicacion_listado_cuarteles WHERE idSolicitud=ID AND idEstado = 2) AS N_Cuarteles_Cerrados,

cross_solicitud_aplicacion_listado.idSolicitud AS IDD,
(SELECT SUM(cross_predios_listado_zonas.Hectareas) 
FROM `cross_solicitud_aplicacion_listado_cuarteles` 
LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona   = cross_solicitud_aplicacion_listado_cuarteles.idZona
WHERE cross_solicitud_aplicacion_listado_cuarteles.idSolicitud=IDD ) AS N_Hectareas,
(SELECT SUM(Diferencia) FROM `cross_solicitud_aplicacion_listado_tractores` WHERE idSolicitud=IDD ) AS Litros';
$SIS_join  = 'LEFT JOIN `core_estado_solicitud`   ON core_estado_solicitud.idEstado   = cross_solicitud_aplicacion_listado.idEstado';
$SIS_order = 'cross_solicitud_aplicacion_listado.f_termino ASC';
$arrSolicitudes = array();
$arrSolicitudes = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSolicitudes');

									
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen de Solicitudes de Aplicacion</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#data_main" data-toggle="tab"><i class="fa fa-bars" aria-hidden="true"></i> Resumen Solicitudes</a></li>

			</ul>

		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="data_main">
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>N° Solicitud</th>
								<th>Estado</th>
								<th>N° Cuarteles<br/>Programados</th>
								<th>N° Cuarteles<br/>Cerrados</th>
								<th>Avance %</th>
								<th>Rango Fechas<br/>Aplicación</th>
								<th>Rango fechas<br/>Reales</th>
								<th>Litros Aplicados</th>
								<th>Litros x Hectarea</th>
								<th>Alertas</th>

								<th width="10">Acciones</th>

							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrSolicitudes as $ot) { ?>
								<tr class="odd">
									<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
									<td><?php echo $ot['Estado']; ?></td>
									<td><?php echo $ot['N_Cuarteles']; ?></td>
									<td><?php echo $ot['N_Cuarteles_Cerrados']; ?></td>
									<td><?php echo porcentaje($ot['N_Cuarteles_Cerrados']/$ot['N_Cuarteles']); ?></td>
									<td><?php echo Fecha_estandar($ot['f_ejecucion']).' / '.Fecha_estandar($ot['f_ejecucion_fin']); ?></td>
									<td><?php echo Fecha_estandar($ot['f_termino']).' / '.Fecha_estandar($ot['f_termino_fin']); ?></td>
									<td><?php echo cantidades($ot['Litros'], 0); ?></td>
									<td><?php if(isset($ot['N_Hectareas'])&&$ot['N_Hectareas']!=0){echo cantidades(($ot['Litros']/$ot['N_Hectareas']), 0);}else{echo '0';} ?></td>
									<td></td>
									<td>
										<div class="btn-group" style="width: 140px;" >
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
											<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion_detalle.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Detalle Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-keyboard-o" aria-hidden="true"></i></a><?php } ?>
											<?php if ($ot['idEstado']==3){ ?>
												<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_cross_checking_02.php?idSolicitud='.$ot['idSolicitud'].'&submit_filter=Filtrar'; ?>" title="Ver Monitor de Dispositivos" class="btn btn-primary btn-sm tooltip"><i class="fa fa-industry" aria-hidden="true"></i></a><?php } ?>
												<?php if ($rowlevel['level']>=1){ ?><a target="_blank" rel="noopener noreferrer" href="<?php echo 'informe_cross_checking_04.php?idSolicitud='.$ot['idSolicitud'].'&submit_filter=Filtrar'; ?>" title="Ver Trazabilidad de la aplicacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a><?php } ?>
											<?php } ?>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>



		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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
				if(isset($NSolicitud)){             $x1  = $NSolicitud;             }else{$x1  = '';}
				if(isset($idPredio)){               $x2  = $idPredio;               }else{$x2  = '';}
				if(isset($idZona)){                 $x3  = $idZona;                 }else{$x3  = '';}
				if(isset($idCategoria)){            $x4  = $idCategoria;            }else{$x4  = '';}
				if(isset($idProducto)){             $x5  = $idProducto;             }else{$x5  = '';}
				if(isset($idEstado)){               $x6  = $idEstado;               }else{$x6  = '';}
				
				
				if(isset($idTemporada)){            $x7  = $idTemporada;            }else{$x7  = '';}
				if(isset($idEstadoFen)){            $x8  = $idEstadoFen;            }else{$x8  = '';}
				if(isset($f_programacion_desde)){   $x9  = $f_programacion_desde;   }else{$x9  = '';}
				if(isset($f_programacion_hasta)){   $x10 = $f_programacion_hasta;   }else{$x10 = '';}
				if(isset($f_ejecucion_desde)){      $x11 = $f_ejecucion_desde;      }else{$x11 = '';}
				if(isset($f_ejecucion_hasta)){      $x12 = $f_ejecucion_hasta;      }else{$x12 = '';}
				if(isset($f_termino_desde)){        $x13 = $f_termino_desde;        }else{$x13 = '';}
				if(isset($f_termino_hasta)){        $x14 = $f_termino_hasta;        }else{$x14 = '';}
				if(isset($idUsuario)){              $x15 = $idUsuario;              }else{$x15 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 1);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x4, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x5, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);
		
		
		
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x7, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x8, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x9, 1);
				$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x10, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x11, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x12, 1);
				$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x13, 1);
				$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x14, 1);
				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x15, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

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
