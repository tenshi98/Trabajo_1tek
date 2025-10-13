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
$SIS_query = 'AguasInfFechaEmision, ClienteIdentificador, ClienteDireccion, DetalleTotalAPagar, DetalleSaldoAnterior';
$SIS_join  = '';
$SIS_where = 'idFacturacionDetalle ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'aguas_facturacion_listado_detalle', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

//Operaciones
$dia = fecha2NdiaMes($rowData['AguasInfFechaEmision']);
$dia = $dia + 17;
$output = 'Carta de Corte cliente '.$rowData['ClienteIdentificador'].' fecha '.Fecha_estandar($rowData['AguasInfFechaEmision']);

//se crea una fecha
$mes_ant = numero_mes((fecha2NMes($rowData['AguasInfFechaEmision']))- 1);
$ano     = fecha2Ano($rowData['AguasInfFechaEmision']);
//se realizan correcciones
if($mes_ant==0){
	$mes_ant = 12;
	$ano = $ano - 1;
}

$fecha_mesanterior = $ano.'-'.$mes_ant.'-10';

?>


    <button onclick="generate()">Generar Archivo</button>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.17.9/docxtemplater.js"></script>
    <script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
    <script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils.js"></script>
    <!--
    Mandatory in IE 6, 7, 8 and 9.
    -->
    <!--[if IE]>
        <script type="text/javascript" src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils-ie.js"></script>
    <![endif]-->
    <script>
		//se ejecuta al cargar la página (OBLIGATORIO)
		$(document).ready(function(){
			generate();
		});
		function loadFile(url,callback){
			PizZipUtils.getBinaryContent(url,callback);
		}
		function generate() {
			loadFile("templates/notificacion_corte_agua.docx",function(error,content){
				if (error) { throw error };

				// The error object contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
				function replaceErrors(key, value) {
					if (value instanceof Error) {
						return Object.getOwnPropertyNames(value).reduce(function(error, key) {
							error[key] = value[key];
							return error;
						}, {});
					}
					return value;
				}

				function errorHandler(error) {
					console.log(JSON.stringify({error: error}, replaceErrors));

					if (error.properties && error.properties.errors instanceof Array) {
						const errorMessages = error.properties.errors.map(function (error) {
							return error.properties.explanation;
						}).join("\n");
						console.log('errorMessages', errorMessages);
						// errorMessages is a humanly readable message looking like this :
						// 'The tag beginning with "foobar" is unopened'
					}
					throw error;
				}

				var zip = new PizZip(content);
				var doc;
				try {
					doc=new window.docxtemplater(zip);
				} catch(error) {
					// Catch compilation errors (errors caused by the compilation of the template : misplaced tags)
					errorHandler(error);
				}

				doc.setData({
					fecha_aviso: '<?php echo Fecha_completa_alt($rowData['AguasInfFechaEmision']); ?>',
					mes_anterior: '<?php echo Fecha_completa_alt($fecha_mesanterior); ?>',
					id_cliente: '<?php echo $rowData['ClienteIdentificador']; ?>',
					dirección: '<?php echo $rowData['ClienteDireccion']; ?>',
					monto: '<?php echo Valores($rowData['DetalleSaldoAnterior'], 0); ?>',
					fecha_corte: '<?php echo $dia." de ".fecha2NombreMes($rowData['AguasInfFechaEmision']); ?>'
				});

				try {
					// render the document (replace all occurences of {first_name} by John, {last_name} by Doe, ...)
					doc.render();
				}
				catch (error) {
					// Catch rendering errors (errors relating to the rendering of the template : angularParser throws an error)
					errorHandler(error);
				}

				var out=doc.getZip().generate({
					type:"blob",
					mimeType: "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				}) //Output the document using Data-URI
				saveAs(out,"<?php echo $output; ?>.docx")
			})
		}
    </script>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
