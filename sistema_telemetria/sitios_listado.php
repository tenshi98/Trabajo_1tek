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
$original = "sitios_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){      $location .= "&Nombre=".$_GET['Nombre'];            $search .= "&Nombre=".$_GET['Nombre'];}

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
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_plant'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_plant';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/sitios_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Sitio Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Sitio Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Sitio Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);

// consulto los datos
$SIS_query = '
sitios_listado.idEstado,
sitios_listado.Nombre,
sitios_listado.Domain,
sitios_listado.Whatsapp_number_1,
sitios_listado.Whatsapp_number_2,
sitios_listado.Whatsapp_tittle,
sitios_listado.Header_Titulo,
sitios_listado.Header_Texto,
sitios_listado.Header_LinkNombre,
sitios_listado.Header_LinkURL,
sitios_listado.Contact_Tittle,
sitios_listado.Contact_Tittle_body,
sitios_listado.Contact_Address_tittle,
sitios_listado.Contact_Address_body,
sitios_listado.Contact_Email_tittle,
sitios_listado.Contact_Email_body,
sitios_listado.Contact_Phone_tittle,
sitios_listado.Contact_Phone_body,
sitios_listado.Contact_Recep_asunto,
sitios_listado.Contact_Recep_mail,
sitios_listado.Contact_Recep_name,
sitios_listado.Social_Tittle,
sitios_listado.Social_Twitter,
sitios_listado.Social_Facebook,
sitios_listado.Social_Instagram,
sitios_listado.Social_Googleplus,
sitios_listado.Social_Linkedin,
sitios_listado.Nosotros_Titulo,
sitios_listado.Nosotros_Subtitulo,
sitios_listado.Nosotros_Texto,
sitios_listado.Nosotros_Link,

sitios_listado.Config_Logo_Nombre,
sitios_listado.Config_Logo_Archivo,
sitios_listado.Config_Root_Folder,
sitios_listado.Config_SMTP_mailUsername,
sitios_listado.Config_SMTP_mailPassword,
sitios_listado.Config_SMTP_Host,
sitios_listado.Config_SMTP_Port,
sitios_listado.Config_SMTP_Secure,
sitios_listado.Config_Menu,
sitios_listado.Config_MenuOtros,
sitios_listado.Config_Carousel,
sitios_listado.Config_Links_Rel,

menu_opc1.Nombre AS Menu,
menu_opc2.Nombre AS MenuOtros,
menu_opc3.Nombre AS LinksRelacionados,
menu_opc4.Nombre AS Carousel,
menu_opc5.Nombre AS TopBar,
menu_opc6.Nombre AS Footer_Links,
menu_opc7.Nombre AS Footer_Services,
menu_opc8.Nombre AS Footer_Letters,

core_estados.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `core_sistemas_opciones` menu_opc1   ON menu_opc1.idOpciones    = sitios_listado.Config_Menu
LEFT JOIN `core_sistemas_opciones` menu_opc2   ON menu_opc2.idOpciones    = sitios_listado.Config_MenuOtros
LEFT JOIN `core_sistemas_opciones` menu_opc3   ON menu_opc3.idOpciones    = sitios_listado.Config_Links_Rel
LEFT JOIN `core_sistemas_opciones` menu_opc4   ON menu_opc4.idOpciones    = sitios_listado.Config_Carousel
LEFT JOIN `core_sistemas_opciones` menu_opc5   ON menu_opc5.idOpciones    = sitios_listado.Config_Top_Bar
LEFT JOIN `core_sistemas_opciones` menu_opc6   ON menu_opc6.idOpciones    = sitios_listado.Config_Footer_Links
LEFT JOIN `core_sistemas_opciones` menu_opc7   ON menu_opc7.idOpciones    = sitios_listado.Config_Footer_Services
LEFT JOIN `core_sistemas_opciones` menu_opc8   ON menu_opc8.idOpciones    = sitios_listado.Config_Footer_Letters
LEFT JOIN `core_estados`                       ON core_estados.idEstado   = sitios_listado.idEstado';
$SIS_where = 'sitios_listado.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$rowData = db_select_data (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

/**********************************/
//Permisos a sistemas
$SIS_query = '
sitios_listado_menu.idMenu,
sitios_listado_menu.Nombre,
sitios_listado_menu.Link,
sitios_listado_menu.idEstado,
sitios_listado_menu.idPosicion,
core_estados.Nombre AS Estado,
menu_opc1.Nombre AS NewTab,
menu_opc2.Nombre AS Popup';
$SIS_join  = '
LEFT JOIN `core_estados`                       ON core_estados.idEstado   = sitios_listado_menu.idEstado
LEFT JOIN `core_sistemas_opciones` menu_opc1   ON menu_opc1.idOpciones    = sitios_listado_menu.idNewTab
LEFT JOIN `core_sistemas_opciones` menu_opc2   ON menu_opc2.idOpciones    = sitios_listado_menu.idPopup';
$SIS_where = 'sitios_listado_menu.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'sitios_listado_menu.idPosicion ASC';
$arrMenu = array();
$arrMenu = db_select_array (false, $SIS_query, 'sitios_listado_menu', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMenu');

/**********************************/
//Permisos a sistemas
$SIS_query = '
sitios_listado_menu_otros.idMenuOtros,
sitios_listado_menu_otros.Nombre,
sitios_listado_menu_otros.Link,
sitios_listado_menu_otros.idEstado,
sitios_listado_menu_otros.idPosicion,
core_estados.Nombre AS Estado,
menu_opc1.Nombre AS NewTab,
menu_opc2.Nombre AS Popup';
$SIS_join  = '
LEFT JOIN `core_estados`                       ON core_estados.idEstado   = sitios_listado_menu_otros.idEstado
LEFT JOIN `core_sistemas_opciones` menu_opc1   ON menu_opc1.idOpciones    = sitios_listado_menu_otros.idNewTab
LEFT JOIN `core_sistemas_opciones` menu_opc2   ON menu_opc2.idOpciones    = sitios_listado_menu_otros.idPopup';
$SIS_where = 'sitios_listado_menu_otros.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'sitios_listado_menu_otros.idPosicion ASC';
$arrMenuDesplegable = array();
$arrMenuDesplegable = db_select_array (false, $SIS_query, 'sitios_listado_menu_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMenuDesplegable');

/**********************************/
//Permisos a sistemas
$SIS_query = '
sitios_listado_carousel.idCarousel,
sitios_listado_carousel.Imagen,
sitios_listado_carousel.Titulo,
sitios_listado_carousel.idEstado,
sitios_listado_carousel.idPosicion,
core_estados.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = sitios_listado_carousel.idEstado';
$SIS_where = 'sitios_listado_carousel.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'sitios_listado_carousel.idPosicion ASC';
$arrCarousel = array();
$arrCarousel = db_select_array (false, $SIS_query, 'sitios_listado_carousel', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCarousel');

/**********************************/
//listado de bodys
$SIS_query = '
sitios_listado_body.idBody,
sitios_listado_body.idTipo,
sitios_listado_body.idPosicion,
sitios_listado_body.Titulo,
core_sitios_tipos_body.Nombre AS Tipo,
sitios_listado_body.idEstado,
core_estados.Nombre AS Estado';
$SIS_join  = '
LEFT JOIN `core_sitios_tipos_body` ON core_sitios_tipos_body.idTipo = sitios_listado_body.idTipo
LEFT JOIN `core_estados`           ON core_estados.idEstado         = sitios_listado_body.idEstado';
$SIS_where = 'sitios_listado_body.idSitio = '.simpleDecode($_GET['id'], fecha_actual());
$SIS_order = 'core_sitios_tipos_body.Nombre ASC, sitios_listado_body.idPosicion ASC';
$arrBody = array();
$arrBody = db_select_array (false, $SIS_query, 'sitios_listado_body', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBody');

?>

<style>
.text-muted {white-space: initial;}
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sitio', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'sitios_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'sitios_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'sitios_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<?php if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){ ?>            <li class=""><a href="<?php echo 'sitios_listado_menu.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu</a></li><?php } ?>
						<?php if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_menu_otros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list" aria-hidden="true"></i> Menu Otros</a></li><?php } ?>
						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>    <li class=""><a href="<?php echo 'sitios_listado_carousel.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Carousel</a></li><?php } ?>
						<?php if(isset($rowData['Config_Links_Rel'])&&$rowData['Config_Links_Rel']==1){ ?>  <li class=""><a href="<?php echo 'sitios_listado_links.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-link" aria-hidden="true"></i> Links Relacionados</a></li><?php } ?>

						<li class=""><a href="<?php echo 'sitios_listado_body.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Body</a></li>
					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<?php if (isset($rowData['Config_Logo_Archivo'])&&$rowData['Config_Logo_Archivo']!='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO.'/'.$rowData['Config_Root_Folder'].'/upload/'.$rowData['Config_Logo_Archivo'] ?>">
						<?php } ?>

						<p class="text-muted">
							<strong>Estado : </strong><label class="label <?php if(isset($rowData['idEstado'])&&$rowData['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $rowData['Estado']; ?></label><br/>
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Dominio : </strong><?php echo $rowData['Domain']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Whatsapp</h2>
						<p class="text-muted">
							<strong>Titulo : </strong><?php echo $rowData['Whatsapp_tittle']; ?><br/>
							<strong>Numero Whatsapp 1 : </strong><?php echo $rowData['Whatsapp_number_1']; ?><br/>
							<strong>Numero Whatsapp 2 : </strong><?php echo $rowData['Whatsapp_number_2']; ?><br/>
						</p>

						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==2){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Header</h2>
							<p class="text-muted">
								<strong>Titulo : </strong><?php echo $rowData['Header_Titulo']; ?><br/>
								<strong>Texto : </strong><?php echo $rowData['Header_Texto']; ?><br/>
								<strong>Link Nombre : </strong><?php echo $rowData['Header_LinkNombre']; ?><br/>
								<strong>Link URL : </strong><?php echo $rowData['Header_LinkURL']; ?><br/>
							</p>
						<?php } ?>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Contacto</h2>
						<p class="text-muted">
							<strong>Contacto - Titulo : </strong><?php echo $rowData['Contact_Tittle']; ?><br/>
							<strong>Contacto - Cuerpo : </strong><?php echo $rowData['Contact_Tittle_body']; ?><br/>
							<strong>Dirección - Titulo : </strong><?php echo $rowData['Contact_Address_tittle']; ?><br/>
							<strong>Dirección - Cuerpo : </strong><?php echo $rowData['Contact_Address_body']; ?><br/>
							<strong>Email - Titulo : </strong><?php echo $rowData['Contact_Email_tittle']; ?><br/>
							<strong>Email - Cuerpo : </strong><?php echo $rowData['Contact_Email_body']; ?><br/>
							<strong>Fono - Titulo : </strong><?php echo $rowData['Contact_Phone_tittle']; ?><br/>
							<strong>Fono - Cuerpo : </strong><?php echo $rowData['Contact_Phone_body']; ?><br/>
							<strong>Receptor - Asunto : </strong><?php echo $rowData['Contact_Recep_asunto']; ?><br/>
							<strong>Receptor - Email : </strong><?php echo $rowData['Contact_Recep_mail']; ?><br/>
							<strong>Receptor - Nombre : </strong><?php echo $rowData['Contact_Recep_name']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Social</h2>
						<p class="text-muted">
							<strong>Titulo : </strong><?php echo $rowData['Social_Tittle']; ?><br/>
							<strong>Twitter : </strong><?php echo $rowData['Social_Twitter']; ?><br/>
							<strong>Facebook : </strong><?php echo $rowData['Social_Facebook']; ?><br/>
							<strong>Instagram : </strong><?php echo $rowData['Social_Instagram']; ?><br/>
							<strong>Googleplus : </strong><?php echo $rowData['Social_Googleplus']; ?><br/>
							<strong>Linkedin : </strong><?php echo $rowData['Social_Linkedin']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Nosotros</h2>
						<p class="text-muted">
							<strong>Titulo : </strong><?php echo $rowData['Nosotros_Titulo']; ?><br/>
							<strong>Subtitulo : </strong><?php echo $rowData['Nosotros_Subtitulo']; ?><br/>
							<strong>Texto : </strong><?php echo $rowData['Nosotros_Texto']; ?><br/>
							<strong>Link Video : </strong><?php echo $rowData['Nosotros_Link']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Configuracion</h2>
						<p class="text-muted">
							<strong>Uso Menu : </strong><?php echo $rowData['Menu']; ?><br/>
							<strong>Uso Menu Otros : </strong><?php echo $rowData['MenuOtros']; ?><br/>
							<strong>Uso Carousel : </strong><?php echo $rowData['Carousel']; ?><br/>
							<strong>Uso Links Relacionados : </strong><?php echo $rowData['LinksRelacionados']; ?><br/>
							<strong>Mostrar TopBar : </strong><?php echo $rowData['TopBar']; ?><br/>
							<strong>Mostrar enlaces en el Footer : </strong><?php echo $rowData['Footer_Links']; ?><br/>
							<strong>Mostrar servicios en el Footer : </strong><?php echo $rowData['Footer_Services']; ?><br/>
							<strong>Mostrar suscripcion en el Footer : </strong><?php echo $rowData['Footer_Letters']; ?><br/>

							<strong>Usuario SMTP : </strong><?php echo $rowData['Config_SMTP_mailUsername']; ?><br/>
							<strong>Contraseña del usuario SMTP : </strong><?php echo $rowData['Config_SMTP_mailPassword']; ?><br/>
							<strong>Host del correo SMTP : </strong><?php echo $rowData['Config_SMTP_Host']; ?><br/>
							<strong>Puerto del correo SMTP : </strong><?php echo $rowData['Config_SMTP_Port']; ?><br/>
							<strong>Protocolo de seguridad del correo SMTP : </strong><?php echo $rowData['Config_SMTP_Secure']; ?><br/>

						</p>

					</div>

					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

						<?php if(isset($rowData['Config_Menu'])&&$rowData['Config_Menu']==1){ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h2 class="text-primary">Menu</h2>
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th width="10">Posicion</th>
											<th>Nombre</th>
											<th>Enlace</th>
											<th>Estado</th>
											<th>NewTab</th>
											<th>Popup</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<?php foreach ($arrMenu as $menu) { ?>
											<tr class="odd">
												<td><?php echo $menu['idPosicion']; ?></td>
												<td><?php echo $menu['Nombre']; ?></td>
												<td><?php echo $menu['Link']; ?></td>
												<td><label class="label <?php if(isset($menu['idEstado'])&&$menu['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $menu['Estado']; ?></label></td>
												<td><?php echo $menu['NewTab']; ?></td>
												<td><?php echo $menu['Popup']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						<?php } ?>

						<?php if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h2 class="text-primary">Menu Desplegable</h2>
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th width="10">Posicion</th>
											<th>Nombre</th>
											<th>Enlace</th>
											<th>Estado</th>
											<th>NewTab</th>
											<th>Popup</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<?php foreach ($arrMenuDesplegable as $menu) { ?>
											<tr class="odd">
												<td><?php echo $menu['idPosicion']; ?></td>
												<td><?php echo $menu['Nombre']; ?></td>
												<td><?php echo $menu['Link']; ?></td>
												<td><label class="label <?php if(isset($menu['idEstado'])&&$menu['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $menu['Estado']; ?></label></td>
												<td><?php echo $menu['NewTab']; ?></td>
												<td><?php echo $menu['Popup']; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						<?php } ?>

						<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h2 class="text-primary">Carousel</h2>
								<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
									<thead>
										<tr role="row">
											<th>Imagen</th>
											<th>Titulo</th>
											<th>Estado</th>
										</tr>
									</thead>
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<?php foreach ($arrCarousel as $menu) { ?>
											<tr class="odd">
												<td><?php echo $menu['idPosicion']; ?></td>
												<td><?php echo $menu['Imagen']; ?></td>
												<td><?php echo $menu['Titulo']; ?></td>
												<td><label class="label <?php if(isset($menu['idEstado'])&&$menu['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $menu['Estado']; ?></label></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						<?php } ?>

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary">Datos Cuerpo</h2>
							<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
								<thead>
									<tr role="row">
										<th width="10">Posicion</th>
										<th>Titulo</th>
										<th width="10">Estado</th>
									</tr>
								</thead>
								<tbody role="alert" aria-live="polite" aria-relevant="all">
									<?php 
									filtrar($arrBody, 'idTipo');
									foreach($arrBody as $Tipo=>$TipoBody){
										echo '<tr class="odd" >
											<td style="background-color:#DDD" colspan="3"><strong>'.$TipoBody[0]['Tipo'].'</strong></td>
										</tr>';
										foreach ($TipoBody as $tipos) { ?>
											<tr class="odd">
												<td><?php echo $tipos['idPosicion']; ?></td>
												<td><?php echo $tipos['Titulo']; ?></td>
												<td><label class="label <?php if(isset($tipos['idEstado'])&&$tipos['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipos['Estado']; ?></label></td>
											</tr>
										<?php } ?>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
					<div class="clearfix"></div>

				</div>
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
			<h5>Crear Sitio</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){        $x1 = $Nombre;       }else{$x1 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('Config_Menu', 2, 2);
				$Form_Inputs->form_input_hidden('Config_MenuOtros', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Carousel', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Links_Rel', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Top_Bar', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Footer_Links', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Footer_Services', 2, 2);
				$Form_Inputs->form_input_hidden('Config_Footer_Letters', 2, 2);
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
		case 'nombre_asc':   $order_by = 'sitios_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':  $order_by = 'sitios_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;

		default: $order_by = 'sitios_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'sitios_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "sitios_listado.idSitio!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND sitios_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){     $SIS_where .= " AND sitios_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idSitio', 'sitios_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
sitios_listado.idSitio,
sitios_listado.Nombre,
core_sistemas.Nombre AS RazonSocial';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = sitios_listado.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrSitio = array();
$arrSitio = db_select_array (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSitio');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Sitio</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){              $x1  = $Nombre;               }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Sitios</h5>
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
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrSitio as $trab) { ?>
					<tr class="odd">
						<td><?php echo $trab['Nombre']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $trab['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_sitio.php?view='.simpleEncode($trab['idSitio'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.simpleEncode($trab['idSitio'], fecha_actual()); ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($trab['idSitio'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el sitio '.$trab['Nombre'].'?'; ?>
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
