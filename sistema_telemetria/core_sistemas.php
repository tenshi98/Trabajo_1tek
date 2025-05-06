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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_sistemas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
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
// consulto los datos
$SIS_query = '
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
core_sistemas.Contacto_Email,
core_sistemas.email_principal,
core_sistemas.Config_IDGoogle,
core_sistemas.Config_Google_apiKey,
core_sistemas.Config_FCM_apiKey,
core_sistemas.Config_FCM_Main_apiKey,
core_theme_colors.Nombre AS Tema,
core_sistemas.Config_CorreoRespaldo,
core_sistemas.Config_Gmail_Usuario,
core_sistemas.Config_Gmail_Password,
core_sistemas.Config_WhatsappToken,
core_sistemas.Config_WhatsappInstanceId,
opc1.Nombre AS OpcionesGen_1,
opc2.Nombre AS OpcionesGen_2,
opc3.Nombre AS OpcionesGen_3,
opc4.Nombre AS OpcionesGen_4,
core_pdf_motores.Nombre AS OpcionesGen_5,
opc7.Nombre AS OpcionesGen_7,
opc8.Nombre AS OpcionesGen_8,
opc9.Nombre AS OpcionesGen_9,
opc10.Nombre AS OpcionesGen_10,
core_sistemas.idOpcionesGen_6,
core_sistemas.Rubro,
core_sistemas_opciones_telemetria.Nombre AS OpcionTelemetria,
core_config_ram.Nombre AS ConfigRam,
core_config_time.Nombre AS ConfigTime,
socialUso.Nombre AS SocialUso,
core_sistemas.Social_idUso,
core_sistemas.Social_facebook,
core_sistemas.Social_twitter,
core_sistemas.Social_instagram,
core_sistemas.Social_linkedin,
core_sistemas.Social_rss,
core_sistemas.Social_youtube,
core_sistemas.Social_tumblr';
$SIS_join  = '
LEFT JOIN `core_ubicacion_ciudad`              ON core_ubicacion_ciudad.idCiudad                   = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`             ON core_ubicacion_comunas.idComuna                  = core_sistemas.idComuna
LEFT JOIN `core_theme_colors`                  ON core_theme_colors.idTheme                        = core_sistemas.Config_idTheme
LEFT JOIN `core_sistemas_opciones`   opc1      ON opc1.idOpciones                                  = core_sistemas.idOpcionesGen_1
LEFT JOIN `core_sistemas_opciones`   opc2      ON opc2.idOpciones                                  = core_sistemas.idOpcionesGen_2
LEFT JOIN `core_sistemas_opciones`   opc3      ON opc3.idOpciones                                  = core_sistemas.idOpcionesGen_3
LEFT JOIN `core_sistemas_opciones`   opc4      ON opc4.idOpciones                                  = core_sistemas.idOpcionesGen_4
LEFT JOIN `core_pdf_motores`                   ON core_pdf_motores.idPDF                           = core_sistemas.idOpcionesGen_5
LEFT JOIN `core_interfaces`          opc7      ON opc7.idInterfaz                                  = core_sistemas.idOpcionesGen_7
LEFT JOIN `core_sistemas_opciones`   opc8      ON opc8.idOpciones                                  = core_sistemas.idOpcionesGen_8
LEFT JOIN `core_sistemas_opciones`   opc9      ON opc9.idOpciones                                  = core_sistemas.idOpcionesGen_9
LEFT JOIN `core_sistemas_opciones`   opc10     ON opc10.idOpciones                                 = core_sistemas.idOpcionesGen_10
LEFT JOIN `core_sistemas_opciones_telemetria`  ON core_sistemas_opciones_telemetria.idOpcionesTel  = core_sistemas.idOpcionesTel
LEFT JOIN `core_config_ram`                    ON core_config_ram.idConfigRam                      = core_sistemas.idConfigRam
LEFT JOIN `core_config_time`                   ON core_config_time.idConfigTime                    = core_sistemas.idConfigTime
LEFT JOIN `core_sistemas_opciones`  socialUso  ON socialUso.idOpciones                             = core_sistemas.Social_idUso';
$SIS_where = 'core_sistemas.idSistema ='.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Sistema', $rowData['Nombre'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'core_sistemas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'core_sistemas_datos_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'core_sistemas_datos_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_opciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-code" aria-hidden="true"></i> APIS</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Logo</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crosstech.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >1Tek</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_crossenergy.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Power-Energy</a></li>
						<li class=""><a href="<?php echo 'core_sistemas_datos_social.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Social</a></li>

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
								<strong>Email : </strong><?php echo $rowData['Contacto_Email']; ?>
							</p>

							<h2 class="text-primary">Configuracion</h2>
							<h3 class="text-muted" style="font-size: 16px!important;color: #337ab7;">Visualizacion General</h3>
							<p class="text-muted word_break">
								<strong>Tema : </strong><?php echo $rowData['Tema']; ?><br/>
							</p>

							<h3 class="text-muted" style="font-size: 16px!important;color: #337ab7;">Visualizacion Pagina Inicio</h3>
							<p class="text-muted word_break">
								<strong>Interfaz : </strong><?php echo $rowData['OpcionesGen_7']; ?><br/>
								<strong>Tipo Resumen Telemetria : </strong><?php echo $rowData['OpcionTelemetria']; ?><br/>
								<strong>Refresh Pagina Principal : </strong><?php echo $rowData['OpcionesGen_4'].' ('.$rowData['idOpcionesGen_6'].' segundos)'; ?><br/>
								<strong>Widget Comunes : </strong><?php echo $rowData['OpcionesGen_1']; ?><br/>
								<strong>Widget de acceso directo : </strong><?php echo $rowData['OpcionesGen_2']; ?><br/>
								<strong>Valores promedios de las mediciones : </strong><?php echo $rowData['OpcionesGen_3']; ?><br/>
								<strong>Nuevo Widget 1tek C : </strong><?php echo $rowData['OpcionesGen_10']; ?><br/>
							</p>

							<h3 class="text-muted" style="font-size: 16px!important;color: #337ab7;">Configuracion Sistema</h3>
							<p class="text-muted word_break">
								<strong>Memoria Ram Maxima : </strong><?php if(isset($rowData['ConfigRam'])&&$rowData['ConfigRam']!=0){echo $rowData['ConfigRam'].' MB';}else{ echo '4096 MB';} ?><br/>
								<strong>Tiempo Maximo de espera : </strong><?php if(isset($rowData['ConfigTime'])&&$rowData['ConfigTime']!=0){echo $rowData['ConfigTime'].' Minutos';}else{ echo '40 Minutos';} ?><br/>
								<strong>Motor PDF : </strong><?php echo $rowData['OpcionesGen_5']; ?><br/>
								<strong>Correo Envio Notificaciones : </strong><?php echo $rowData['email_principal']; ?><br/>
							</p>

							<h2 class="text-primary">APIS</h2>
							<p class="text-muted word_break">
								<strong>ID Google (Mapas) : </strong><?php echo $rowData['Config_IDGoogle']; ?><br/>
								<strong>Whatsapp Token : </strong><?php echo $rowData['Config_WhatsappToken']; ?><br/>
								<strong>Whatsapp Instance Id : </strong><?php echo $rowData['Config_WhatsappInstanceId']; ?><br/>
							</p>

							<h2 class="text-primary">Social</h2>
							<p class="text-muted word_break">
								<strong>Uso de widget Sociales : </strong><?php echo $rowData['SocialUso']; ?><br/>
								<?php if(isset($rowData['Social_idUso'])&&$rowData['Social_idUso']==1){ ?>
									<strong>Facebook : </strong><?php echo $rowData['Social_facebook']; ?><br/>
									<strong>Twitter : </strong><?php echo $rowData['Social_twitter']; ?><br/>
									<strong>Instagram : </strong><?php echo $rowData['Social_instagram']; ?><br/>
									<strong>Linkedin : </strong><?php echo $rowData['Social_linkedin']; ?><br/>
									<strong>Rss : </strong><?php echo $rowData['Social_rss']; ?><br/>
									<strong>Youtube : </strong><?php echo $rowData['Social_youtube']; ?><br/>
									<strong>Tumblr : </strong><?php echo $rowData['Social_tumblr']; ?><br/>
								<?php } ?>
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
}elseif(!empty($_GET['new'])){ ?>

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
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x2, 2);
				$Form_Inputs->form_select_depend1('Región','idCiudad', $x3, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
										 'Comuna','idComuna', $x4, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_icon('Dirección', 'Direccion', $x5, 2,'fa fa-map');

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
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
//Creo la variable con la ubicacion
$SIS_where = "core_sistemas.idSistema!=0 ";
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'core_sistemas.idSistema', 'core_sistemas','LEFT JOIN `core_estados`  ON core_estados.idEstado  = core_sistemas.idEstado', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
core_sistemas.idSistema,
core_sistemas.Nombre,
core_sistemas.Rut,
core_sistemas.idEstado,
core_estados.Nombre AS estado';
$SIS_join  = 'LEFT JOIN `core_estados`  ON core_estados.idEstado  = core_sistemas.idEstado';
$SIS_order = 'core_estados.Nombre ASC, core_sistemas.Nombre ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrSistemas = array();
$arrSistemas = db_select_array (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSistemas');
/**********************************************************/
//paginacion
$search='';

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Sistema</a>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Sistemas</h5>
			<div class="toolbar">
				<?php
				//paginacion
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre</th>
						<th>Rut</th>
						<th>Estado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
								 
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrSistemas as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['Nombre']; ?></td>
						<td><?php echo $tipo['Rut']; ?></td>
						<td><label class="label <?php if(isset($tipo['idEstado'])&&$tipo['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $tipo['estado']; ?></label></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_sistema.php?view='.simpleEncode($tipo['idSistema'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&id='.$tipo['idSistema']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del='.simpleEncode($tipo['idSistema'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar el sistema '.$tipo['Nombre'].'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//paginacion
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
