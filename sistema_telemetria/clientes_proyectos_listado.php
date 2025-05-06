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
$original = "clientes_proyectos_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){            $location .= "&idTipo=".$_GET['idTipo'];              $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){            $location .= "&Nombre=".$_GET['Nombre'];              $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){                  $location .= "&Rut=".$_GET['Rut'];                    $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){  $location .= "&fNacimiento=".$_GET['fNacimiento'];    $search .= "&fNacimiento=".$_GET['fNacimiento'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){        $location .= "&idCiudad=".$_GET['idCiudad'];          $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){        $location .= "&idComuna=".$_GET['idComuna'];          $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){      $location .= "&Direccion=".$_GET['Direccion'];        $search .= "&Direccion=".$_GET['Direccion'];}
if(isset($_GET['Giro']) && $_GET['Giro']!=''){                $location .= "&Giro=".$_GET['Giro'];                  $search .= "&Giro=".$_GET['Giro'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/clientes_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Proyecto Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Proyecto Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Proyecto Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
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
	clientes_listado.PersonaContacto_Cargo,
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
	LEFT JOIN `core_estados`              ON core_estados.idEstado                    = clientes_listado.idEstado
	LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad           = clientes_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna          = clientes_listado.idComuna
	LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema                  = clientes_listado.idSistema
	LEFT JOIN `clientes_tipos`            ON clientes_tipos.idTipo                    = clientes_listado.idTipo
	LEFT JOIN `core_rubros`               ON core_rubros.idRubro                      = clientes_listado.idRubro';
	$SIS_where = 'clientes_listado.idCliente = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Proyecto', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'clientes_proyectos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_persona_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
							<?php if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
								<li class=""><a href="<?php echo 'clientes_proyectos_listado_datos_comerciales.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_contratos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Contratos</a></li>
							<li class=""><a href="<?php echo 'clientes_proyectos_listado_ubicaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicaciones</a></li>
						</ul>
					</li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row" style="border-right: 1px solid #333;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
								<p class="text-muted word_break">
									<strong>Tipo de Proyecto : </strong><?php echo $rowData['tipoCliente']; ?><br/>
									<?php
									//Si el cliente es una empresa
									if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
										<strong>Nombre Fantasia: </strong><?php echo $rowData['Nombre']; ?><br/>
									<?php
									//si es una persona
									}else{ ?>
										<strong>Nombre: </strong><?php echo $rowData['Nombre']; ?><br/>
										<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
									<?php } ?>
									<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
									<strong>Región : </strong><?php echo $rowData['nombre_region']; ?><br/>
									<strong>Comuna : </strong><?php echo $rowData['nombre_comuna']; ?><br/>
									<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
									<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
									<strong>Estado : </strong><?php echo $rowData['estado']; ?>
								</p>

								<?php
								//Si el cliente es una empresa
								if(isset($rowData['idTipo'])&&$rowData['idTipo']==1){ ?>
									<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
									<p class="text-muted word_break">
										<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
										<strong>Razón Social : </strong><?php echo $rowData['RazonSocial']; ?><br/>
										<strong>Giro de la empresa: </strong><?php echo $rowData['Giro']; ?><br/>
										<strong>Rubro : </strong><?php echo $rowData['Rubro']; ?><br/>
									</p>
								<?php } ?>

								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
								<p class="text-muted word_break">
									<strong>Telefono Fijo : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
									<strong>Telefono Movil : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
									<strong>Fax : </strong><?php echo $rowData['Fax']; ?><br/>
									<strong>Email : </strong><a href="mailto:<?php echo $rowData['email']; ?>"><?php echo $rowData['email']; ?></a><br/>
									<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowData['Web']; ?>"><?php echo $rowData['Web']; ?></a>
								</p>

								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
								<p class="text-muted word_break">
									<strong>Persona de Contacto : </strong><?php echo $rowData['PersonaContacto']; ?><br/>
									<strong>Cargo Persona de Contacto : </strong><?php echo $rowData['PersonaContacto_Cargo']; ?><br/>
									<strong>Telefono : </strong><?php echo formatPhone($rowData['PersonaContacto_Fono']); ?><br/>
									<strong>Email : </strong><a href="mailto:<?php echo $rowData['PersonaContacto_email']; ?>"><?php echo $rowData['PersonaContacto_email']; ?></a><br/>
								</p>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="row">
							<?php
								//se arma la dirección
								$direccion = "";
								if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){           $direccion .= $rowData["Direccion"];}
								if(isset($rowData["nombre_comuna"])&&$rowData["nombre_comuna"]!=''){   $direccion .= ', '.$rowData["nombre_comuna"];}
								if(isset($rowData["nombre_region"])&&$rowData["nombre_region"]!=''){   $direccion .= ', '.$rowData["nombre_region"];}
								//se despliega mensaje en caso de no existir dirección
								if($direccion!=''){
									echo mapa_from_direccion($direccion, 0, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1) ;
								}else{
									$Alert_Text = 'No tiene una dirección definida';
									alert_post_data(4,2,2,0, $Alert_Text);
								}
							?>
						</div>
					</div>
					<div class="clearfix"></div>

				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Proyecto</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($idTipo)){           $x1  = $idTipo;            }else{$x1  = '';}
					if(isset($Nombre)){           $x2  = $Nombre;            }else{$x2  = '';}
					if(isset($Rut)){              $x3  = $Rut;               }else{$x3  = '';}
					if(isset($fNacimiento)){      $x4  = $fNacimiento;       }else{$x4  = '';}
					if(isset($idCiudad)){         $x5  = $idCiudad;          }else{$x5  = '';}
					if(isset($idComuna)){         $x6  = $idComuna;          }else{$x6  = '';}
					if(isset($Direccion)){        $x7  = $Direccion;         }else{$x7  = '';}
					if(isset($Giro)){             $x8  = $Giro;              }else{$x8  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					$Form_Inputs->form_select('Tipo de Proyecto','idTipo', $x1, 2, 'idTipo', 'Nombre', 'clientes_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombres', 'Nombre', $x2, 2);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x3, 1);
					$Form_Inputs->form_date('F Ingreso Sistema','fNacimiento', $x4, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x5, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x6, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x7, 1,'fa fa-map');
					$Form_Inputs->form_input_icon('Giro de la empresa', 'Giro', $x8, 1,'fa fa-industry');

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('password', 1234, 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>

			</div>
		</div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
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
			case 'rut_asc':       $order_by = 'clientes_listado.Rut ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
			case 'rut_desc':      $order_by = 'clientes_listado.Rut DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;
			case 'nombre_asc':    $order_by = 'clientes_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':   $order_by = 'clientes_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'estado_asc':    $order_by = 'clientes_listado.idEstado ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':   $order_by = 'clientes_listado.idEstado DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'clientes_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'clientes_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "clientes_listado.idCliente!=0";
	$SIS_where.= " AND clientes_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//verifico que sea un administrador

	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){             $SIS_where .= " AND clientes_listado.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){             $SIS_where .= " AND clientes_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['Rut']) && $_GET['Rut']!=''){                   $SIS_where .= " AND clientes_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
	if(isset($_GET['fNacimiento']) && $_GET['fNacimiento']!=''){   $SIS_where .= " AND clientes_listado.fNacimiento='".$_GET['fNacimiento']."'";}
	if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){         $SIS_where .= " AND clientes_listado.idCiudad=".$_GET['idCiudad'];}
	if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){         $SIS_where .= " AND clientes_listado.idComuna=".$_GET['idComuna'];}
	if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){       $SIS_where .= " AND clientes_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
	if(isset($_GET['Giro']) && $_GET['Giro']!=''){                 $SIS_where .= " AND clientes_listado.Giro LIKE '%".EstandarizarInput($_GET['Giro'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'clientes_listado.idCliente', 'clientes_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	clientes_listado.idCliente,
	clientes_listado.Rut,
	clientes_listado.Nombre,
	core_estados.Nombre AS estado,
	core_sistemas.Nombre AS sistema,
	clientes_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_estados`   ON core_estados.idEstado       = clientes_listado.idEstado
	LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema     = clientes_listado.idSistema';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Proyecto</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
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
					$Form_Inputs->form_select('Tipo de Proyecto','idTipo', $x1, 1, 'idTipo', 'Nombre', 'clientes_tipos', 0, '', $dbConn);
					$Form_Inputs->form_input_text('Nombres', 'Nombre', $x2, 1);
					$Form_Inputs->form_input_rut('Rut', 'Rut', $x3, 1);
					$Form_Inputs->form_date('F Ingreso Sistema','fNacimiento', $x4, 1);
					$Form_Inputs->form_select_depend1('Región','idCiudad', $x5, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
											'Comuna','idComuna', $x6, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
											$dbConn, 'form1');
					$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x7, 1,'fa fa-map');
					$Form_Inputs->form_input_icon('Giro de la empresa', 'Giro', $x9, 1,'fa fa-industry');

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Proyectos</h5>
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
								<div class="pull-left">Rut</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=rut_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=rut_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre del Proyecto</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="120">
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo $usuarios['Rut']; ?></td>
							<td><?php echo $usuarios['Nombre']; ?></td>
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cliente.php?view='.simpleEncode($usuarios['idCliente'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idCliente']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($usuarios['idCliente'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar al cliente '.$usuarios['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
