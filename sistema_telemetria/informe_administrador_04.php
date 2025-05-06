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
$original = "informe_administrador_04.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
$location .= '?d=d';
if(isset($_GET['submit_filter']) && $_GET['submit_filter']!=''){ $location .= "&submit_filter=Filtrar";          $search .= "&submit_filter=Filtrar";}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){                 $location .= "&Fecha=".$_GET['Fecha'];          $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['usuario']) && $_GET['usuario']!=''){             $location .= "&usuario=".$_GET['usuario'];      $search .= "&usuario=".$_GET['usuario'];}
if(isset($_GET['email']) && $_GET['email']!=''){                 $location .= "&email=".$_GET['email'];          $search .= "&email=".$_GET['email'];}
if(isset($_GET['IP_Client']) && $_GET['IP_Client']!=''){         $location .= "&IP_Client=".$_GET['IP_Client'];  $search .= "&IP_Client=".$_GET['IP_Client'];}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del_4';
	require_once 'A1XRXS_sys/xrxs_form/z_bloqueos.php';
}
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
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'fecha_asc':     $SIS_order = 'Fecha ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':    $SIS_order = 'Fecha DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'usuario_asc':   $SIS_order = 'usuario ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
			case 'usuario_desc':  $SIS_order = 'usuario DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
			case 'email_asc':     $SIS_order = 'email ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Email Ascendente'; break;
			case 'email_desc':    $SIS_order = 'email DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Email Descendente';break;
			case 'ip_asc':        $SIS_order = 'IP_Client ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> IP Ascendente';break;
			case 'ip_desc':       $SIS_order = 'IP_Client DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> IP Descendente';break;

			default: $SIS_order = 'Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$SIS_order = 'Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'COUNT(idAcceso) AS Cuenta,Fecha, usuario, email, IP_Client';
	$SIS_join  = '';
	$SIS_where = 'idAcceso!=0';
	if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){           $SIS_where .= " AND Fecha='".$_GET['Fecha']."'";}
	if(isset($_GET['usuario']) && $_GET['usuario']!=''){       $SIS_where .= " AND usuario LIKE '%".EstandarizarInput($_GET['usuario'])."%'";}
	if(isset($_GET['email']) && $_GET['email']!=''){           $SIS_where .= " AND email LIKE '%".EstandarizarInput($_GET['email'])."%'";}
	if(isset($_GET['IP_Client']) && $_GET['IP_Client']!=''){   $SIS_where .= " AND IP_Client=".$_GET['IP_Client'];}
	$SIS_where .= ' GROUP BY Fecha, usuario, email, IP_Client';
	$arrCarga = array();
	$arrCarga = db_select_array (false, $SIS_query, 'usuarios_checkbrute', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCarga');

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Bloqueos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Usuario</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Email</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=email_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=email_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">IP</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=ip_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=ip_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">N° Intentos</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrCarga as $carga) { ?>

						<tr class="odd">
							<td><?php echo fecha_estandar($carga['Fecha']); ?></td>
							<td><?php echo $carga['usuario']; ?></td>
							<td><?php echo $carga['email']; ?></td>
							<td><?php echo $carga['IP_Client']; ?></td>
							<td><?php echo $carga['Cuenta']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=4){
										$xyz = '';
										if(isset($carga['Fecha']) && $carga['Fecha']!=''){  $xyz .= "&f_Fecha=".$carga['Fecha'];}
										if(isset($carga['usuario']) && $carga['usuario']!=''){     $xyz .= "&f_usuario=".$carga['usuario'];}
										if(isset($carga['email']) && $carga['email']!=''){  $xyz .= "&f_email=".$carga['email'];}
										if(isset($carga['IP_Client']) && $carga['IP_Client']!=''){ $xyz .= "&f_IP_Client=".$carga['IP_Client'];}
										//redireccion
										$ubicacion = $location.'&del=true'.$xyz;
										$dialogo   = '¿Realmente deseas eliminar el bloqueo?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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
					if(isset($Fecha)){       $x1  = $Fecha;       }else{$x1  = '';}
					if(isset($usuario)){     $x2  = $usuario;     }else{$x2  = '';}
					if(isset($email)){       $x3  = $email;       }else{$x3  = '';}
					if(isset($IP_Client)){   $x4  = $IP_Client;   }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha','Fecha', $x1, 1);
					$Form_Inputs->form_input_text('Usuario', 'usuario', $x2, 1);
					$Form_Inputs->form_input_text('Email', 'email', $x3, 1);
					$Form_Inputs->form_input_text('Dirección IP', 'IP_Client', $x4, 1);

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
