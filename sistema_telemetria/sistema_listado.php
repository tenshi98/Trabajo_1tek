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
$original = "sistema_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){     $location .= "&Nombre=".$_GET['Nombre'];             $search .= "&Nombre=".$_GET['Nombre'];}
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
	require_once 'A1XRXS_sys/xrxs_form/core_sistemas.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/core_sistemas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sistema Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sistema Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sistema Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$query = "SELECT
core_sistemas.Nombre,
core_sistemas.Rut,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
core_sistemas.Direccion,
core_sistemas.Contacto_Nombre,
core_sistemas.Contacto_Fono1,
core_sistemas.Contacto_Fono2,
core_sistemas.Contacto_Fax,
core_sistemas.Contacto_Web,
core_sistemas.email_principal, 
core_sistemas.Contrato_Nombre,
core_sistemas.Contrato_Numero, 
core_sistemas.Contrato_Fecha, 
core_sistemas.Contrato_Duracion,
core_sistemas.Config_IDGoogle,
core_theme_colors.Nombre AS Tema,
core_sistemas.Rubro

FROM `core_sistemas`
LEFT JOIN `core_theme_colors`              ON core_theme_colors.idTheme            = core_sistemas.Config_idTheme
LEFT JOIN `core_ubicacion_ciudad`          ON core_ubicacion_ciudad.idCiudad       = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`         ON core_ubicacion_comunas.idComuna      = core_sistemas.idComuna

WHERE core_sistemas.idSistema =".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

/******************************************************/
//Accesos a bodegas de productos
$trans_1 = "bodegas_productos_egreso.php";
$trans_2 = "bodegas_productos_ingreso.php";
$trans_3 = "bodegas_productos_simple_stock.php";
$trans_4 = "bodegas_productos_stock.php";
$trans_5 = "productores_listado.php";

//Accesos a bodegas de insumos
$trans_11 = "bodegas_insumos_egreso.php";
$trans_12 = "bodegas_insumos_ingreso.php";
$trans_13 = "bodegas_insumos_simple_stock.php";
$trans_14 = "bodegas_insumos_stock.php";
$trans_15 = "insumos_listado.php";

//Accesos a Ordenes de Trabajo
$trans_21 = "orden_trabajo_crear.php";
$trans_22 = "orden_trabajo_terminar.php";

//Accesos a Ordenes de Compra
$trans_26 = "ocompra_generacion.php";
$trans_27 = "ocompra_listado_sin_aprobar.php";

//Accesos al sistema 1tek
$trans_31 = "sistema_variedades_categorias.php";
$trans_32 = "sistema_variedades_tipo.php";
$trans_33 = "variedades_listado.php";
$trans_34 = "cross_quality_registrar_inspecciones.php";
$trans_35 = "cross_shipping_consolidacion.php";
$trans_36 = "cross_shipping_consolidacion_aprobar.php";
$trans_37 = "cross_shipping_consolidacion_aprobar_auto.php";



//realizo la consulta
$query = "SELECT

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_1."'  AND visualizacion!=9999 LIMIT 1) AS tran_1,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_2."'  AND visualizacion!=9999 LIMIT 1) AS tran_2,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_3."'  AND visualizacion!=9999 LIMIT 1) AS tran_3,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_4."'  AND visualizacion!=9999 LIMIT 1) AS tran_4,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_5."'  AND visualizacion!=9999 LIMIT 1) AS tran_5,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_11."'  AND visualizacion!=9999 LIMIT 1) AS tran_11,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_12."'  AND visualizacion!=9999 LIMIT 1) AS tran_12,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_13."'  AND visualizacion!=9999 LIMIT 1) AS tran_13,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_14."'  AND visualizacion!=9999 LIMIT 1) AS tran_14,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_15."'  AND visualizacion!=9999 LIMIT 1) AS tran_15,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_21."'  AND visualizacion!=9999 LIMIT 1) AS tran_21,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_22."'  AND visualizacion!=9999 LIMIT 1) AS tran_22,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_26."'  AND visualizacion!=9999 LIMIT 1) AS tran_26,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_27."'  AND visualizacion!=9999 LIMIT 1) AS tran_27,

(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_31."'  AND visualizacion!=9999 LIMIT 1) AS tran_31,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_32."'  AND visualizacion!=9999 LIMIT 1) AS tran_32,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_33."'  AND visualizacion!=9999 LIMIT 1) AS tran_33,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_34."'  AND visualizacion!=9999 LIMIT 1) AS tran_34,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_35."'  AND visualizacion!=9999 LIMIT 1) AS tran_35,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_36."'  AND visualizacion!=9999 LIMIT 1) AS tran_36,
(SELECT COUNT(idAdmpm) FROM core_permisos_listado WHERE Direccionbase ='".$trans_37."'  AND visualizacion!=9999 LIMIT 1) AS tran_37,

idUsuario

FROM usuarios_listado
WHERE usuarios_listado.idUsuario='1' ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData_x = mysqli_fetch_assoc ($resultado);

//verifico que sea un administrador
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	//Totales de los permisos que se pueden acceder
	$Count_productos    = 1;
	$Count_insumos      = 1;
	$Count_OT           = 1;
	$Count_OC           = 1;
	$Count_Variedades   = 1;
	$Count_Shipping     = 1;
}else{
	//Totales de los permisos que se pueden acceder
	$Count_productos    = $rowData_x['tran_1'] + $rowData_x['tran_2'] + $rowData_x['tran_3'] + $rowData_x['tran_4'] + $rowData_x['tran_5'];
	$Count_insumos      = $rowData_x['tran_11'] + $rowData_x['tran_12'] + $rowData_x['tran_13'] + $rowData_x['tran_14'] + $rowData_x['tran_15'];
	$Count_OT           = $rowData_x['tran_21'] + $rowData_x['tran_22'];
	$Count_OC           = $rowData_x['tran_26'] + $rowData_x['tran_27'];
	$Count_Variedades   = $rowData_x['tran_31'] + $rowData_x['tran_32'] + $rowData_x['tran_33'] + $rowData_x['tran_34'];
	$Count_Shipping     = $rowData_x['tran_35'] + $rowData_x['tran_36'] + $rowData_x['tran_37'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'sistema_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'sistema_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'sistema_listado_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'sistema_listado_datos_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-briefcase" aria-hidden="true"></i> Datos Contrato</a></li>
						<li class=""><a href="<?php echo 'sistema_listado_datos_temas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-tags" aria-hidden="true"></i> Temas</a></li>
						<li class=""><a href="<?php echo 'sistema_listado_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<?php if(isset($Count_OT)&&$Count_OT!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_ot.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-cogs" aria-hidden="true"></i> OT</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'sistema_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<?php if(isset($Count_OC)&&$Count_OC!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_oc.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador OC</a></li>
						<?php } ?>
						<?php if(isset($Count_productos)&&$Count_productos!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_productos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Productos Usados</a></li>
						<?php } ?>
						<?php if(isset($Count_insumos)&&$Count_insumos!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_insumos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Insumos Usados</a></li>
						<?php } ?>
						<?php if(isset($Count_Variedades)&&$Count_Variedades!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_variedades_especies.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-recycle" aria-hidden="true"></i> Especies</a></li>
							<li class=""><a href="<?php echo 'sistema_listado_datos_variedades_nombres.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-recycle" aria-hidden="true"></i> Variedades</a></li>
						<?php } ?>
						<?php if(isset($Count_Shipping)&&$Count_Shipping!=0){ ?>
							<li class=""><a href="<?php echo 'sistema_listado_datos_cross.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Aprobador CrossShipping</a></li>
							<li class=""><a href="<?php echo 'sistema_listado_datos_cross_aprobadas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-wrench" aria-hidden="true"></i> 1tek Shipping Correos Aprobados</a></li>
						<?php } ?>
					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary">Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
								<strong>Ciudad : </strong><?php echo $rowData['Ciudad']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Rubro : </strong><?php echo $rowData['Rubro']; ?>
							</p>

							<h2 class="text-primary">Datos de contacto</h2>
							<p class="text-muted word_break">
								<strong>Nombre Contacto : </strong><?php echo $rowData['Contacto_Nombre']; ?><br/>
								<strong>Fono 1: </strong><?php echo formatPhone($rowData['Contacto_Fono1']); ?><br/>
								<strong>Fono 2: </strong><?php echo formatPhone($rowData['Contacto_Fono2']); ?><br/>
								<strong>Fax : </strong><?php echo $rowData['Contacto_Fax']; ?><br/>
								<strong>Web : </strong><?php echo $rowData['Contacto_Web']; ?><br/>
								<strong>Email : </strong><?php echo $rowData['email_principal']; ?>
							</p>

							<h2 class="text-primary">Contrato</h2>
							<p class="text-muted word_break">
								<strong>Nombre Contrato : </strong><?php echo $rowData['Contrato_Nombre']; ?><br/>
								<strong>Numero de Contrato : </strong><?php echo $rowData['Contrato_Numero']; ?><br/>
								<strong>Fecha inicio Contrato : </strong><?php echo $rowData['Contrato_Fecha']; ?><br/>
								<strong>Duracion Contrato(Meses) : </strong><?php echo $rowData['Contrato_Duracion']; ?>
							</p>

							<h2 class="text-primary">Configuracion</h2>
							<p class="text-muted word_break">
								<strong>Tema : </strong><?php echo $rowData['Tema']; ?><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se arma la dirección
							$direccion = "";
							if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){  $direccion .= $rowData["Direccion"];}
							if(isset($rowData["Comuna"])&&$rowData["Comuna"]!=''){        $direccion .= ', '.$rowData["Comuna"];}
							if(isset($rowData["Ciudad"])&&$rowData["Ciudad"]!=''){        $direccion .= ', '.$rowData["Ciudad"];}
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
			<h5>Crear Sistema</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}
				if(isset($Rut)){              $x2  = $Rut;              }else{$x2  = '';}
				if(isset($idCiudad)){         $x3  = $idCiudad;         }else{$x3  = '';}
				if(isset($idComuna)){         $x4  = $idComuna;         }else{$x4  = '';}
				if(isset($Direccion)){        $x5  = $Direccion;        }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_input_text('Nombres', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x2, 1);
				$Form_Inputs->form_select_depend1('Región','idCiudad', $x3, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
										 'Comuna','idComuna', $x4, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x5, 1,'fa fa-map');

				$Form_Inputs->form_input_hidden('Config_idTheme', 1, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_1', 1, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_2', 1, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_3', 2, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_4', 2, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_5', 1, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_6', 0, 1);
				$Form_Inputs->form_input_hidden('idOpcionesGen_7', 3, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_8', 2, 2);
				$Form_Inputs->form_input_hidden('idOpcionesGen_9', 2, 2);
				$Form_Inputs->form_input_hidden('idOpcionesTel', 4, 2);
				$Form_Inputs->form_input_hidden('idConfigRam', 9, 2);
				$Form_Inputs->form_input_hidden('idConfigTime', 13, 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);

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
		case 'rut_asc':      $order_by = 'core_sistemas.Rut ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
		case 'rut_desc':     $order_by = 'core_sistemas.Rut DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;
		case 'nombre_asc':   $order_by = 'core_sistemas.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
		case 'nombre_desc':  $order_by = 'core_sistemas.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'estado_asc':   $order_by = 'core_estados.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':  $order_by = 'core_estados.Nombre DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'core_sistemas.idEstado ASC, core_sistemas.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'core_sistemas.idEstado ASC, core_sistemas.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "core_sistemas.idSistema!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){  $SIS_where .= " AND core_sistemas.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){ $SIS_where .= " AND core_sistemas.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idSistema', 'core_sistemas','', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
core_sistemas.idSistema,
core_sistemas.Nombre,
core_sistemas.Rut,
core_sistemas.idEstado,
core_estados.Nombre AS estado';
$SIS_join  = 'LEFT JOIN `core_estados`  ON core_estados.idEstado = core_sistemas.idEstado';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrUsers = array();
$arrUsers = db_select_array (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>
	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Sistema</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){           $x1  = $Nombre;            }else{$x1  = '';}
				if(isset($Rut)){              $x2  = $Rut;               }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombres', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x2, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Sistemas</h5>
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
							<div class="pull-left">Nombre</div>
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
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
					<tr class="odd">
						<td><?php echo $usuarios['Rut']; ?></td>
						<td><?php echo $usuarios['Nombre']; ?></td>
						<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['estado']; ?></label></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_sistema.php?view='.simpleEncode($usuarios['idSistema'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idSistema']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($usuarios['idSistema'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar al cliente '.$usuarios['Nombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
