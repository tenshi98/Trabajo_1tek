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
$original = "informe_cross_checking_02.php";
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
//paginador de resultados
if(isset($_GET["pagina"])){
	$num_pag = $_GET["pagina"];
} else {$num_pag = 1;
}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'id_asc':        $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Solicitud Ascendente'; break;
		case 'id_desc':       $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';break;
		case 'fprog_asc':     $order_by = 'cross_solicitud_aplicacion_listado.f_programacion ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Programacion Ascendente';break;
		case 'fprog_desc':    $order_by = 'cross_solicitud_aplicacion_listado.f_programacion DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Programacion Descendente';break;
		case 'predio_asc':    $order_by = 'cross_predios_listado.Nombre ASC ';                       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Predio Ascendente'; break;
		case 'predio_desc':   $order_by = 'cross_predios_listado.Nombre DESC ';                      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Predio Descendente';break;

		default: $order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';
	}
}else{
	$order_by = 'cross_solicitud_aplicacion_listado.NSolicitud DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Solicitud Descendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idEstado=3";//solo terminadas
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idSolicitud']) && $_GET['idSolicitud']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idSolicitud=".$_GET['idSolicitud'];}
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
$SIS_join  = 'LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud';
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'cross_solicitud_aplicacion_listado.idSolicitud', 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_termino,

cross_predios_listado.Nombre AS PredioNombre,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.Plantas AS CuartelCantPlantas,

telemetria_listado.Nombre AS TractorNombre,
telemetria_listado_sensores_nombre.SensoresNombre_1 AS TractorSensorNombre_1,
telemetria_listado_sensores_nombre.SensoresNombre_2 AS TractorSensorNombre_2,
telemetria_listado_sensores_nombre.SensoresNombre_3 AS TractorSensorNombre_3,
telemetria_listado_sensores_nombre.SensoresNombre_4 AS TractorSensorNombre_4,
cross_solicitud_aplicacion_listado_tractores.idTractores,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_3_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_4_Prom,

cross_solicitud_aplicacion_listado_cuarteles.VelTractor';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `telemetria_listado_sensores_nombre`             ON telemetria_listado_sensores_nombre.idTelemetria            = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
	</ul>

</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Solicitudes de Aplicacion</h5>
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
						<th colspan="7" style="text-align: center;">Identificación</th>
						<th colspan="4" style="text-align: center;">Velocidad Tractores (Km/hr)</th>
						<th colspan="4" style="text-align: center;">Sensores</th>
						<th width="10"></th>
					</tr>
					<tr role="row">
						<th>Fecha Termino</th>
						<th>N° Solicitud</th>
						<th>Predio</th>
						<th>Especie</th>
						<th>Variedad</th>
						<th>Cuartel</th>
						<th>Tractor</th>
						<th>Minima</th>
						<th>Maxima</th>
						<th>Promedio</th>
						<th>Programada</th>
						<th><?php if(isset($arrOTS[0]['TractorSensorNombre_1'])){echo $arrOTS[0]['TractorSensorNombre_1'];} ?></th>
						<th><?php if(isset($arrOTS[0]['TractorSensorNombre_2'])){echo $arrOTS[0]['TractorSensorNombre_2'];} ?></th>
						<th><?php if(isset($arrOTS[0]['TractorSensorNombre_3'])){echo $arrOTS[0]['TractorSensorNombre_3'];} ?></th>
						<th><?php if(isset($arrOTS[0]['TractorSensorNombre_4'])){echo $arrOTS[0]['TractorSensorNombre_4'];} ?></th>

						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) { ?>
						<tr class="odd">
							<td><?php echo Fecha_estandar($ot['f_termino']); ?></td>
							<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
							<td><?php echo $ot['PredioNombre']; ?></td>
							<td><?php if(isset($ot['VariedadCat'])&&$ot['VariedadCat']!=''){echo $ot['VariedadCat'];    }else{echo 'Todas las Especies';} ?></td>
							<td><?php if(isset($ot['VariedadNombre'])&&$ot['VariedadNombre']!=''){ echo $ot['VariedadNombre'];}else{echo 'Todas las Variedades';} ?></td>
							<td><?php echo $ot['CuartelNombre']; ?></td>
							<td><?php echo $ot['TractorNombre']; ?></td>
							<td><?php echo Cantidades($ot['GeoVelocidadMin'], 2); ?></td>
							<td><?php echo Cantidades($ot['GeoVelocidadMax'], 2); ?></td>
							<td><?php echo Cantidades($ot['GeoVelocidadProm'], 2); ?></td>
							<td><?php echo Cantidades($ot['VelTractor'], 2); ?></td>
							<td><?php echo Cantidades($ot['Sensor_1_Prom'], 2); ?></td>
							<td><?php echo Cantidades($ot['Sensor_2_Prom'], 2); ?></td>
							<td><?php echo Cantidades($ot['Sensor_3_Prom'], 2); ?></td>
							<td><?php echo Cantidades($ot['Sensor_4_Prom'], 2); ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion.php?view='.simpleEncode($ot['idSolicitud'], fecha_actual()); ?>" title="Ver Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_solicitud_aplicacion_detalles.php?view='.simpleEncode($ot['idTractores'], fecha_actual()); ?>" title="Ver Detalles Solicitud" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
				if(isset($idTemporada)){            $x4  = $idTemporada;            }else{$x4  = '';}
				if(isset($idEstadoFen)){            $x5  = $idEstadoFen;            }else{$x5  = '';}
				if(isset($idCategoria)){            $x6  = $idCategoria;            }else{$x6  = '';}
				if(isset($idProducto)){             $x7  = $idProducto;             }else{$x7  = '';}
				if(isset($f_programacion_desde)){   $x8  = $f_programacion_desde;   }else{$x8  = '';}
				if(isset($f_programacion_hasta)){   $x9  = $f_programacion_hasta;   }else{$x9  = '';}
				if(isset($f_ejecucion_desde)){      $x10 = $f_ejecucion_desde;      }else{$x10 = '';}
				if(isset($f_ejecucion_hasta)){      $x11 = $f_ejecucion_hasta;      }else{$x11 = '';}
				if(isset($f_termino_desde)){        $x12 = $f_termino_desde;        }else{$x12 = '';}
				if(isset($f_termino_hasta)){        $x13 = $f_termino_hasta;        }else{$x13 = '';}
				if(isset($idUsuario)){              $x14 = $idUsuario;              }else{$x14 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 1);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x8, 1);
				$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x9, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x10, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x11, 1);
				$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x12, 1);
				$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x13, 1);
				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x14, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

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
