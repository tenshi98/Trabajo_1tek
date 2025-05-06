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
$original = "seguridad_camaras_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                   $location .= "&Nombre=".$_GET['Nombre'];                          $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){               $location .= "&idEstado=".$_GET['idEstado'];                      $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idPais']) && $_GET['idPais']!=''){                   $location .= "&idPais=".$_GET['idPais'];                          $search .= "&idPais=".$_GET['idPais'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){               $location .= "&idCiudad=".$_GET['idCiudad'];                      $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){               $location .= "&idComuna=".$_GET['idComuna'];                      $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){             $location .= "&Direccion=".$_GET['Direccion'];                    $search .= "&Direccion=".$_GET['Direccion'];}
if(isset($_GET['N_Camaras']) && $_GET['N_Camaras']!=''){             $location .= "&N_Camaras=".$_GET['N_Camaras'];                    $search .= "&N_Camaras=".$_GET['N_Camaras'];}
if(isset($_GET['idSubconfiguracion']) && $_GET['idSubconfiguracion']!=''){  $location .= "&idSubconfiguracion=".$_GET['idSubconfiguracion'];  $search .= "&idSubconfiguracion=".$_GET['idSubconfiguracion'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'grupo_insert';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'grupo_del';
	require_once 'A1XRXS_sys/xrxs_form/z_seguridad_camaras_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Grupo Camaras Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Grupo Camaras Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Grupo Camaras Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$query = "SELECT 
seguridad_camaras_listado.idCamara,
seguridad_camaras_listado.Nombre,
seguridad_camaras_listado.idSubconfiguracion,
seguridad_camaras_listado.Direccion,
seguridad_camaras_listado.N_Camaras,
seguridad_camaras_listado.Config_usuario,
seguridad_camaras_listado.Config_Password,
seguridad_camaras_listado.Config_IP,
seguridad_camaras_listado.Config_Puerto,

core_sistemas.Nombre AS sistema,
core_estados.Nombre AS estado,
core_paises.Nombre AS Pais,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
core_sistemas_opciones.Nombre AS Subconfiguracion,
core_tipos_camara.Nombre AS TipoCamara

FROM `seguridad_camaras_listado`
LEFT JOIN `core_sistemas`              ON core_sistemas.idSistema             = seguridad_camaras_listado.idSistema
LEFT JOIN `core_estados`               ON core_estados.idEstado               = seguridad_camaras_listado.idEstado
LEFT JOIN `core_paises`                ON core_paises.idPais                  = seguridad_camaras_listado.idPais
LEFT JOIN `core_ubicacion_ciudad`      ON core_ubicacion_ciudad.idCiudad      = seguridad_camaras_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`     ON core_ubicacion_comunas.idComuna     = seguridad_camaras_listado.idComuna
LEFT JOIN `core_sistemas_opciones`     ON core_sistemas_opciones.idOpciones   = seguridad_camaras_listado.idSubconfiguracion
LEFT JOIN `core_tipos_camara`          ON core_tipos_camara.idTipoCamara      = seguridad_camaras_listado.idTipoCamara

WHERE seguridad_camaras_listado.idCamara = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

//Se traen las rutas
$arrCamaras = array();
$query = "SELECT 
seguridad_camaras_listado_canales.idCanal,
seguridad_camaras_listado_canales.idCamara,
seguridad_camaras_listado_canales.Nombre,
seguridad_camaras_listado_canales.Config_usuario,
seguridad_camaras_listado_canales.Config_Password,
seguridad_camaras_listado_canales.Config_IP,
core_estados.Nombre AS estado,
seguridad_camaras_listado_canales.idEstado

FROM `seguridad_camaras_listado_canales`
LEFT JOIN `core_estados`   ON core_estados.idEstado = seguridad_camaras_listado_canales.idEstado
WHERE seguridad_camaras_listado_canales.idCamara = ".$_GET['id']."
ORDER BY seguridad_camaras_listado_canales.idCanal ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCamaras,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Grupo Camaras', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'seguridad_camaras_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
				<li class=""><a href="<?php echo 'seguridad_camaras_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Editar Camaras</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Nombre del Grupo : </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Numero de Camaras: </strong><?php echo $rowData['N_Camaras']; ?><br/>
								<strong>Pais : </strong><?php echo $rowData['Pais']; ?><br/>
								<strong>Región : </strong><?php echo $rowData['Ciudad']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?><br/>
								<strong>Subconfiguracion : </strong><?php echo $rowData['Subconfiguracion']; ?>
							</p>

							<?php if(isset($rowData['idSubconfiguracion'])&&$rowData['idSubconfiguracion']==2){ ?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Subconfiguracion</h2>
								<p class="text-muted word_break">
									<strong>Tipo de Camara : </strong><?php echo $rowData['TipoCamara']; ?><br/>
									<strong>Usuario : </strong><?php echo $rowData['Config_usuario']; ?><br/>
									<strong>Password: </strong><?php echo $rowData['Config_Password']; ?><br/>
									<strong>IP : </strong><?php echo $rowData['Config_IP']; ?><br/>
									<strong>Puerto : </strong><?php echo $rowData['Config_Puerto']; ?><br/>
								</p>
							<?php } ?>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Listado Camaras</h2>
							<table  class="table table-bordered">
								<thead>
									<tr role="row">
										<th>Nombre</th>
										<?php if(isset($rowData['idSubconfiguracion'])&&$rowData['idSubconfiguracion']==1){ ?>
											<th>Usuario</th>
											<th>Password</th>
											<th>IP</th>
										<?php } ?>
										<th width="160">Estado</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php foreach ($arrCamaras as $zona) { ?>
										<tr class="odd">
											<td><?php echo $zona['Nombre']; ?></td>
											<?php if(isset($rowData['idSubconfiguracion'])&&$rowData['idSubconfiguracion']==1){ ?>
												<td><?php echo $zona['Config_usuario']; ?></td>
												<td><?php echo $zona['Config_Password']; ?></td>
												<td><?php echo $zona['Config_IP']; ?></td>
											<?php } ?>
											<td><label class="label <?php if(isset($zona['idEstado'])&&$zona['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $zona['estado']; ?></label></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>

							<br/>

						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se arma la dirección
							$direccion = "";
							if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){  $direccion .= $rowData["Direccion"];}
							if(isset($rowData["Ciudad"])&&$rowData["Ciudad"]!=''){        $direccion .= ', '.$rowData["Ciudad"];}
							if(isset($rowData["Comuna"])&&$rowData["Comuna"]!=''){        $direccion .= ', '.$rowData["Comuna"];}
							//se despliega mensaje en caso de no existir dirección
							if($direccion!=''){
								echo mapa_from_direccion($direccion, 0, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1);
							}else{
								$Alert_Text  = 'No tiene una dirección definida';
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
			<h5>Crear Grupo Camaras</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){          $x1  = $Nombre;           }else{$x1  = '';}
				if(isset($N_Camaras)){       $x2  = $N_Camaras;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idSubconfiguracion', 1, 2);

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
		case 'nombre_asc':    $order_by = 'seguridad_camaras_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':   $order_by = 'seguridad_camaras_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'estado_asc':    $order_by = 'core_estados.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':   $order_by = 'core_estados.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'ncamaras_asc':  $order_by = 'core_estados.N_Camaras ASC ';              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> N° Camaras Ascendente';break;
		case 'ncamaras_desc': $order_by = 'core_estados.N_Camaras DESC ';             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> N° Camaras Descendente';break;
		case 'subconf_asc':   $order_by = 'core_sistemas_opciones.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Subconfiguracion Ascendente';break;
		case 'subconf_desc':  $order_by = 'core_sistemas_opciones.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Subconfiguracion Descendente';break;

		default: $order_by = 'seguridad_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'seguridad_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "seguridad_camaras_listado.idCamara!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND seguridad_camaras_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                   $SIS_where .= " AND seguridad_camaras_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){               $SIS_where .= " AND seguridad_camaras_listado.idEstado=".$_GET['idPais'];}
if(isset($_GET['idPais']) && $_GET['idPais']!=''){                   $SIS_where .= " AND seguridad_camaras_listado.idPais=".$_GET['idPais'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad']!=''){               $SIS_where .= " AND seguridad_camaras_listado.idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna']!=''){               $SIS_where .= " AND seguridad_camaras_listado.idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion']!=''){             $SIS_where .= " AND seguridad_camaras_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
if(isset($_GET['N_Camaras']) && $_GET['N_Camaras']!=''){             $SIS_where .= " AND seguridad_camaras_listado.N_Camaras=".$_GET['N_Camaras'];}
if(isset($_GET['idSubconfiguracion']) && $_GET['idSubconfiguracion']!=''){  $SIS_where .= " AND seguridad_camaras_listado.idSubconfiguracion=".$_GET['idSubconfiguracion'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idCamara', 'seguridad_camaras_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
seguridad_camaras_listado.idCamara,
seguridad_camaras_listado.Nombre,
seguridad_camaras_listado.N_Camaras,
core_sistemas.Nombre AS sistema,
core_estados.Nombre AS estado,
seguridad_camaras_listado.idEstado,
core_sistemas_opciones.Nombre AS Subconfiguracion';
$SIS_join  = '
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema            = seguridad_camaras_listado.idSistema
LEFT JOIN `core_estados`            ON core_estados.idEstado              = seguridad_camaras_listado.idEstado
LEFT JOIN `core_sistemas_opciones`  ON core_sistemas_opciones.idOpciones  = seguridad_camaras_listado.idSubconfiguracion';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrCamaras = array();
$arrCamaras = db_select_array (false, $SIS_query, 'seguridad_camaras_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCamaras');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Grupo Camaras</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter" style="min-height:500px;">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){              $x1  = $Nombre;              }else{$x1  = '';}
				if(isset($N_Camaras)){           $x2  = $N_Camaras;           }else{$x2  = '';}
				if(isset($idEstado)){            $x3  = $idEstado;            }else{$x3  = '';}
				if(isset($idSubconfiguracion)){  $x4  = $idSubconfiguracion;  }else{$x4  = '';}
				if(isset($idPais)){              $x5  = $idPais;              }else{$x5  = '';}
				if(isset($idCiudad)){            $x6  = $idCiudad;            }else{$x6  = '';}
				if(isset($idComuna)){            $x7  = $idComuna;            }else{$x7  = '';}
				if(isset($Direccion)){           $x8  = $Direccion;           }else{$x8  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre del Grupo Camaras', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_number_spinner('N° Camaras','N_Camaras', $x2, 0, 500, 1, 0, 1);
				$Form_Inputs->form_select('Estado','idEstado', $x3, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
				$Form_Inputs->form_select('Subconfiguracion','idSubconfiguracion', $x4, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_select_country('Pais','idPais', $x5, 1, $dbConn);
				$Form_Inputs->form_select_depend1('Región','idCiudad', $x6, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
										'Comuna','idComuna', $x7, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x8, 1,'fa fa-map');

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Grupo Camaras</h5>
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
							<div class="pull-left">Grupo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">N° Camaras</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=ncamaras_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=ncamaras_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Subconfiguracion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=subconf_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=subconf_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
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
					<?php foreach ($arrCamaras as $usuarios) { ?>
					<tr class="odd">
						<td><?php echo $usuarios['Nombre']; ?></td>
						<td><?php echo $usuarios['N_Camaras']; ?></td>
						<td><?php echo $usuarios['Subconfiguracion']; ?></td>
						<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_camaras_listado.php?view='.simpleEncode($usuarios['idCamara'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idCamara']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									//se verifica que el usuario no sea uno mismo
									$ubicacion = $location.'&del='.simpleEncode($usuarios['idCamara'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el Predio '.$usuarios['Nombre'].'?'; ?>
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
