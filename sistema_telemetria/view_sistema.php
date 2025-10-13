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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
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
opc3.Nombre AS OpcionesGen_4,
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
$SIS_where = 'core_sistemas.idSistema ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ver Datos de la empresa</h5>
		</header>
		<div class="tab-content">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="row" style="border-right: 1px solid #333;">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted word_break">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Ciudad : </strong><?php echo $rowData['Ciudad']; ?><br/>
							<strong>Comuna : </strong><?php echo $rowData['Comuna']; ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
							<strong>Rubro : </strong><?php echo $rowData['Rubro']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de contacto</h2>
						<p class="text-muted word_break">
							<strong>Nombre Contacto : </strong><?php echo $rowData['Contacto_Nombre']; ?><br/>
							<strong>Fono 1: </strong><?php echo formatPhone($rowData['Contacto_Fono1']); ?><br/>
							<strong>Fono 2: </strong><?php echo formatPhone($rowData['Contacto_Fono2']); ?><br/>
							<strong>Fax : </strong><?php echo $rowData['Contacto_Fax']; ?><br/>
							<strong>Web : </strong><?php echo $rowData['Contacto_Web']; ?><br/>
							<strong>Email : </strong><?php echo $rowData['email_principal']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Configuracion</h2>
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
								<strong>Nuevo Widget 1Tek C : </strong><?php echo $rowData['OpcionesGen_10']; ?><br/>
							</p>

							<h3 class="text-muted" style="font-size: 16px!important;color: #337ab7;">Configuracion Sistema</h3>
							<p class="text-muted word_break">
								<strong>Memoria Ram Maxima : </strong><?php if(isset($rowData['ConfigRam'])&&$rowData['ConfigRam']!=0){echo $rowData['ConfigRam'].' MB';}else{ echo '4096 MB';} ?><br/>
								<strong>Tiempo Maximo de espera : </strong><?php if(isset($rowData['ConfigTime'])&&$rowData['ConfigTime']!=0){echo $rowData['ConfigTime'].' Minutos';}else{ echo '40 Minutos';} ?><br/>
								<strong>Motor PDF : </strong><?php echo $rowData['OpcionesGen_5']; ?><br/>
								<strong>Correo Envio Notificaciones : </strong><?php echo $rowData['email_principal']; ?><br/>
							</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> APIS</h2>
						<p class="text-muted word_break">
							<strong>ID Google (Mapas) : </strong><?php echo $rowData['Config_IDGoogle']; ?><br/>
							<strong>Whatsapp Token : </strong><?php echo $rowData['Config_WhatsappToken']; ?><br/>
							<strong>Whatsapp Instance Id : </strong><?php echo $rowData['Config_WhatsappInstanceId']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Social</h2>
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
						//Se arma la dirección
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


 
          

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
