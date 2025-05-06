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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_sistema_seguridad_ip_list.php";
$location = $original;
/********************************************************************/
//Variables para filtro y paginacion
$search    ='&submit_filter=Filtrar';
$location .='?bla=bla';
$location .='&submit_filter=Filtrar';
if(isset($_GET['idSeguridad']) && $_GET['idSeguridad']!=''){     $location .= "&idSeguridad=".$_GET['idSeguridad'];     $search .= "&idSeguridad=".$_GET['idSeguridad'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){  $location .= "&idUsuario=".$_GET['idUsuario'];         $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){  $location .= "&idCliente=".$_GET['idCliente'];         $search .= "&idCliente=".$_GET['idCliente'];}
if(isset($_GET['idTransporte']) && $_GET['idTransporte']!=''){   $location .= "&idTransporte=".$_GET['idTransporte'];   $search .= "&idTransporte=".$_GET['idTransporte'];}
if(isset($_GET['idApoderado']) && $_GET['idApoderado']!=''){     $location .= "&idApoderado=".$_GET['idApoderado'];     $search .= "&idApoderado=".$_GET['idApoderado'];}
if(isset($_GET['pagina']) && $_GET['pagina']!=''){        $location .= "&pagina=".$_GET['pagina'];               $search .= "&pagina=".$_GET['pagina'];}
/**********************************************************************************************************************************/
/*                                               Ejecucion de los formularios                                                     */
/**********************************************************************************************************************************/
//se borra un dato
if (!empty($_GET['block_ip'])){
	//Llamamos al formulario
	$form_trabajo= 'block_ip';
	require_once 'A1XRXS_sys/xrxs_form/sistema_seguridad_bloqueo_ip.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){      $error['created']      = 'sucess/Bloqueo Creado correctamente';}
if (isset($_GET['not_created'])){  $error['not_created']  = 'sucess/Bloqueo Creado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	//tomo el numero de la pagina si es que este existe
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	//se selecciona la tabla
	switch ($_GET['idSeguridad']) {
		case 1: $xtabla = 'usuarios_listado_ip';    $yrelacion = 'del usuario ';     $SIS_join = 'LEFT JOIN `usuarios_listado`    relacion ON relacion.idUsuario    = '.$xtabla.'.idUsuario';      break;
	}
	//Inicia variable
	$SIS_where = $xtabla.".idIpUsuario!=0";
	//verifico si existen los parametros de fecha
	if(isset($_GET['idUsuario'])&&$_GET['idUsuario']!=''){$SIS_where.=' AND '.$xtabla.'.idUsuario='.$_GET['idUsuario'];}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, $xtabla.'.IP_Client', $xtabla, $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	'.$xtabla.'.IP_Client,
	'.$xtabla.'.IP_Client AS IPP,
	relacion.Nombre AS Relacion,
	(SELECT COUNT(idBloqueo) FROM `sistema_seguridad_bloqueo_ip` WHERE IP_Client=IPP) AS Count';
	$SIS_order = 'IP_Client ASC LIMIT '.$comienzo.', '.$cant_reg;
	$arrIpRelacionadas = array();
	$arrIpRelacionadas = db_select_array (false, $SIS_query, $xtabla, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrIpRelacionadas');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Relacion <?php echo $yrelacion; ?></h5>
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
							<th>Relacion</th>
							<th width="160">Dirección IP</th>
							<th width="100">Bloqueado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrIpRelacionadas as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Relacion']; ?></td>
								<td><?php echo $tipo['IP_Client']; ?></td>
								<td><?php if(isset($tipo['Count'])&&$tipo['Count']==1){echo 'SI';}else{echo 'No';} ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if(isset($tipo['Count'])&&$tipo['Count']!=1){ 
											$ubicacion = $location.'&block_ip='.simpleEncode($tipo['IP_Client'], fecha_actual());
											$ubicacion.='&Relacion='.simpleEncode($yrelacion.$tipo['Relacion'], fecha_actual());
											$dialogo   = '¿Realmente deseas bloquear la IP '.$tipo['IP_Client'].'?'; ?>
											<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Bloquear Dirección IP" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-ban" aria-hidden="true"></i></a>
										<?php } ?>
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
	//Verifico el tipo de usuario que esta ingresando
	$z = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].' AND idEstado=1';

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Buscar IP</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idSeguridad)){   $x0 = $idSeguridad;   }else{$x0 = '';}
					if(isset($idUsuario)){     $x1 = $idUsuario;     }else{$x1 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select('Tipo','idSeguridad', $x0, 2, 'idSeguridad', 'Nombre', 'core_seguridad_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select_join_filter('Usuario','idUsuario', $x1, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);

					$Form_Inputs->form_input_hidden('pagina', 1, 2);

					?>

					<script>
						document.getElementById('div_idUsuario').style.display = 'none';

						$("#idSeguridad").on("change", function(){ //se ejecuta al cambiar valor del select
							let idSeguridad = $(this).val(); //Asignamos el valor seleccionado

							//IP Relacionadas - Usuarios
							if(idSeguridad == 1){
								document.getElementById('div_idUsuario').style.display = '';

							//Para el resto
							} else {
								document.getElementById('div_idUsuario').style.display = 'none';

							}
						});

					</script>

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
