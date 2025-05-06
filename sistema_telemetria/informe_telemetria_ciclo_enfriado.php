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
$original = "informe_telemetria_ciclo_enfriado.php";
$location = $original;
/********************************************************************/
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
$SIS_where = "telemetria_ciclo_enfriado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){       $SIS_where .= " AND telemetria_ciclo_enfriado.f_inicio='".$_GET['f_inicio']."'";}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){     $SIS_where .= " AND telemetria_ciclo_enfriado.f_termino='".$_GET['f_termino']."'";}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){       $SIS_where .= " AND telemetria_ciclo_enfriado.h_inicio='".$_GET['h_inicio']."'";}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){     $SIS_where .= " AND telemetria_ciclo_enfriado.h_termino='".$_GET['h_termino']."'";}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){      $SIS_where .= " AND telemetria_ciclo_enfriado.idTelemetria='".$_GET['idTelemetria']."'";}
if(isset($_GET['idGrupo']) && $_GET['idGrupo']!=''){         $SIS_where .= " AND telemetria_ciclo_enfriado.idGrupo='".$_GET['idGrupo']."'";}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND telemetria_ciclo_enfriado.idCategoria='".$_GET['idCategoria']."'";}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND telemetria_ciclo_enfriado.idProducto='".$_GET['idProducto']."'";}
if(isset($_GET['CantidadPallet']) && $_GET['CantidadPallet']!=''){  $SIS_where .= " AND telemetria_ciclo_enfriado.CantidadPallet LIKE '%".EstandarizarInput($_GET['CantidadPallet'])."%'";}

/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_ciclo_enfriado.idCiclo,
telemetria_ciclo_enfriado.f_inicio,
telemetria_ciclo_enfriado.f_termino,
telemetria_ciclo_enfriado.h_inicio,
telemetria_ciclo_enfriado.h_termino,
telemetria_ciclo_enfriado.CantidadPallet,
telemetria_ciclo_enfriado.Duracion,

telemetria_listado.Nombre AS Equipo,
telemetria_listado_grupos.Nombre AS Grupo,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre,
core_sistemas.Nombre AS RazonSocial';
$SIS_join  = '
LEFT JOIN `telemetria_listado`             ON telemetria_listado.idTelemetria            = telemetria_ciclo_enfriado.idTelemetria
LEFT JOIN `telemetria_listado_grupos`      ON telemetria_listado_grupos.idGrupo          = telemetria_ciclo_enfriado.idGrupo
LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema                    = telemetria_ciclo_enfriado.idSistema
LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = telemetria_ciclo_enfriado.idCategoria
LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = telemetria_ciclo_enfriado.idProducto';
$SIS_order = 'telemetria_ciclo_enfriado.f_inicio DESC';
$arrCategorias = array();
$arrCategorias = db_select_array (false, $SIS_query, 'telemetria_ciclo_enfriado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Ciclos de Enfriado</h5>
		</header>
        <div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Equipo</th>
						<th>Grupo</th>
						<th>Desde</th>
						<th>Hasta</th>
						<th>Duracion</th>
						<th>Categoria</th>
						<th>Producto</th>
						<th>Cantidad Pallet</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCategorias as $cat) { ?>
						<tr class="odd">
							<td><?php echo $cat['Equipo']; ?></td>
							<td><?php echo $cat['Grupo']; ?></td>
							<td><?php echo $cat['h_inicio'].' - '.fecha_estandar($cat['f_inicio']); ?></td>
							<td><?php echo $cat['h_termino'].' - '.fecha_estandar($cat['f_termino']); ?></td>
							<td><?php echo Cantidades($cat['Duracion'], 1); ?></td>
							<td><?php echo $cat['ProductoCategoria']; ?></td>
							<td><?php echo $cat['ProductoNombre']; ?></td>
							<td><?php echo $cat['CantidadPallet']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $cat['RazonSocial']; ?></td><?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=2";//1Tek C
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
				if(isset($idTelemetria)){    $x1 = $idTelemetria;   }else{$x1 = '';}
				if(isset($f_inicio)){        $x2 = $f_inicio;       }else{$x2 = '';}
				if(isset($h_inicio)){        $x3 = $h_inicio;       }else{$x3 = '';}
				if(isset($f_termino)){       $x4 = $f_termino;      }else{$x4 = '';}
				if(isset($h_termino)){       $x5 = $h_termino;      }else{$x5 = '';}
				if(isset($idCategoria)){     $x6 = $idCategoria;    }else{$x6 = '';}
				if(isset($idProducto)){      $x7 = $idProducto;     }else{$x7 = '';}
				if(isset($CantidadPallet)){  $x8 = $CantidadPallet; }else{$x8 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
				$Form_Inputs->form_select_tel_group('Grupos','idGrupo', 'idTelemetria', 'form1', 1, $dbConn);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x2, 1);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 1);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x5, 1, 1);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_text('CantidadPallet', 'CantidadPallet', $x8, 1);

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
