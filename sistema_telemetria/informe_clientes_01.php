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
$original = "informe_clientes_01.php";
$location = $original;
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
	/*******************************************************/
	//Variable de busqueda
	$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	//Filtros
	if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){             $search.= '&idTipo='.$_GET['idTipo'];}
	if(isset($_GET['Nombre'])&&$_GET['Nombre']!=''){             $search.= '&Nombre='.$_GET['Nombre'];}
	if(isset($_GET['Rut'])&&$_GET['Rut']!=''){                   $search.= '&Rut='.$_GET['Rut'];}
	if(isset($_GET['fNacimiento'])&&$_GET['fNacimiento']!=''){   $search.= '&fNacimiento='.$_GET['fNacimiento'];}
	if(isset($_GET['idCiudad'])&&$_GET['idCiudad']!=''){         $search.= '&idCiudad='.$_GET['idCiudad'];}
	if(isset($_GET['idComuna'])&&$_GET['idComuna']!=''){         $search.= '&idComuna='.$_GET['idComuna'];}
	if(isset($_GET['Direccion'])&&$_GET['Direccion']!=''){       $search.= '&Direccion='.$_GET['Direccion'];}
	if(isset($_GET['Giro'])&&$_GET['Giro']!=''){                 $search.= '&Giro='.$_GET['Giro'];}

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	clientes_listado.email,
	clientes_listado.Nombre,
	clientes_listado.Rut,
	clientes_listado.RazonSocial,
	clientes_listado.fNacimiento,
	clientes_listado.Direccion,
	clientes_listado.Fono1,
	clientes_listado.Fono2,
	clientes_listado.Fax,
	clientes_listado.PersonaContacto,
	clientes_listado.PersonaContacto_Fono,
	clientes_listado.PersonaContacto_email,
	clientes_listado.Web,
	clientes_listado.Giro,
	clientes_listado.idTipo,
	core_ubicacion_ciudad.Nombre AS nombre_region,
	core_ubicacion_comunas.Nombre AS nombre_comuna,
	core_estados.Nombre AS estado,
	core_sistemas.Nombre AS sistema,
	clientes_tipos.Nombre AS tipoCliente,
	core_rubros.Nombre AS Rubro';
	$SIS_join  = '
	LEFT JOIN `core_estados`            ON core_estados.idEstado             = clientes_listado.idEstado
	LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad    = clientes_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna   = clientes_listado.idComuna
	LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema           = clientes_listado.idSistema
	LEFT JOIN `clientes_tipos`          ON clientes_tipos.idTipo             = clientes_listado.idTipo
	LEFT JOIN `core_rubros`             ON core_rubros.idRubro               = clientes_listado.idRubro';
	$SIS_where = 'clientes_listado.idCliente!=0';
	if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){            $SIS_where.=" AND clientes_listado.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['Nombre'])&&$_GET['Nombre']!=''){            $SIS_where.=" AND clientes_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['Rut'])&&$_GET['Rut']!=''){                  $SIS_where.=" AND clientes_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
	if(isset($_GET['fNacimiento'])&&$_GET['fNacimiento']!=''){  $SIS_where.=" AND clientes_listado.fNacimiento='".$_GET['fNacimiento']."'";}
	if(isset($_GET['idCiudad'])&&$_GET['idCiudad']!=''){        $SIS_where.=" AND clientes_listado.idCiudad=".$_GET['idCiudad'];}
	if(isset($_GET['idComuna'])&&$_GET['idComuna']!=''){        $SIS_where.=" AND clientes_listado.idComuna=".$_GET['idComuna'];}
	if(isset($_GET['Direccion'])&&$_GET['Direccion']!=''){      $SIS_where.=" AND clientes_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
	if(isset($_GET['Giro'])&&$_GET['Giro']!=''){                $SIS_where.=" AND clientes_listado.Giro LIKE '%".EstandarizarInput($_GET['Giro'])."%'";}
	$SIS_order = 0;
	$arrClientes = array();
	$arrClientes = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrClientes');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
		<a target="new" href="<?php echo 'informe_clientes_01_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Clientes</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Tipo de Cliente</th>
							<th>Nombre</th>
							<th>Razón Social</th>
							<th>Rut</th>
							<th>Fecha de Ingreso Sistema</th>
							<th>Región</th>
							<th>Comuna</th>
							<th>Dirección</th>
							<th>Sistema Relacionado</th>
							<th>Estado</th>
							<th>Giro de la empresa</th>
							<th>Rubro</th>
							<th>Telefono Fijo</th>
							<th>Telefono Movil</th>
							<th>Fax</th>
							<th>Email</th>
							<th>Web</th>
							<th>Persona de Contacto</th>
							<th>Telefono de Contacto</th>
							<th>Email de Contacto</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrClientes as $cli) { ?>
							<tr class="odd">
								<td><?php echo $cli['tipoCliente']; ?></td>
								<td><?php echo $cli['Nombre']; ?></td>
								<td><?php echo $cli['RazonSocial']; ?></td>
								<td><?php echo $cli['Rut']; ?></td>
								<td><?php echo fecha_estandar($cli['fNacimiento']); ?></td>
								<td><?php echo $cli['nombre_region']; ?></td>
								<td><?php echo $cli['nombre_comuna']; ?></td>
								<td><?php echo $cli['Direccion']; ?></td>
								<td><?php echo $cli['sistema']; ?></td>
								<td><?php echo $cli['estado']; ?></td>
								<td><?php echo $cli['Giro']; ?></td>
								<td><?php echo $cli['Rubro']; ?></td>
								<td><?php echo formatPhone($cli['Fono1']); ?></td>
								<td><?php echo formatPhone($cli['Fono2']); ?></td>
								<td><?php echo $cli['Fax']; ?></td>
								<td><?php echo $cli['email']; ?></td>
								<td><?php echo $cli['Web']; ?></td>
								<td><?php echo $cli['PersonaContacto']; ?></td>
								<td><?php echo formatPhone($cli['PersonaContacto_Fono']); ?></td>
								<td><?php echo $cli['PersonaContacto_email']; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

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
					if(isset($idTipo)){           $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($Nombre)){           $x2  = $Nombre;            }else{$x2  = '';}
					if(isset($Rut)){              $x3  = $Rut;               }else{$x3  = '';}
					if(isset($fNacimiento)){      $x4  = $fNacimiento;       }else{$x4  = '';}
					if(isset($idCiudad)){         $x5  = $idCiudad;          }else{$x5  = '';}
					if(isset($idComuna)){         $x6  = $idComuna;          }else{$x6  = '';}
					if(isset($Direccion)){        $x7  = $Direccion;         }else{$x7  = '';}
					if(isset($Giro)){             $x9  = $Giro;              }else{$x9  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo de Cliente','idTipo', $x1, 1, 'idTipo', 'Nombre', 'clientes_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombres', 'Nombre', $x2, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x3, 1);
					$Form_Inputs->form_date('F Ingreso Sistema','fNacimiento', $x4, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x5, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x6, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x7, 1,'fa fa-map');
					$Form_Inputs->form_input_icon('Giro de la empresa', 'Giro', $x9, 1,'fa fa-industry');

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
