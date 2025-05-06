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
$X_idTab = simpleDecode($_GET['idTab'], fecha_actual());
/**************************************************************/
// consulto los datos
$SIS_query = '
clientes_listado.idCliente,
clientes_listado.Contrato_Fecha_Ini,
clientes_listado.Contrato_Representante_Legal,
clientes_listado.Contrato_Representante_Rut,
clientes_listado.RazonSocial AS Nombre,
clientes_listado.Giro,
clientes_listado.Rut, 
clientes_listado.Direccion,
core_ubicacion_comunas.Nombre AS Comuna,
clientes_listado.Contrato_UF_Instalacion ,
clientes_listado.Contrato_UF_Mensual,
clientes_listado.Contrato_N_Meses,
core_cross_cliente.Nombre AS Contrato_Periodo';
$SIS_join  = '
LEFT JOIN `core_ubicacion_comunas` ON core_ubicacion_comunas.idComuna = clientes_listado.idComuna
LEFT JOIN `core_cross_cliente`     ON core_cross_cliente.idPeriodo    = clientes_listado.Contrato_idPeriodo';
$SIS_where = 'clientes_listado.idCliente ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*******************************************/
//Listado con los tabs
$arrTabs = array();
$arrTabs = db_select_array (false, 'idTab, Nombre', 'core_telemetria_tabs', '', '', 'idTab ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTabs');

//recorro
$arrTabsSorter = array();
foreach ($arrTabs as $tab) {
	$arrTabsSorter[$tab['idTab']] = $tab['Nombre'];
}

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
			loadFile("templates/planilla_contrato_clientes.docx",function(error,content){
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

				<?php
				//no son necesarios validar
				$N_Documento    = N_doc($rowData['idCliente'], 5).'-'.N_doc($X_idTab, 2);
				$UnidadNegocio  = $arrTabsSorter[$X_idTab];

				//se deben validar
				if(isset($rowData['Contrato_Fecha_Ini'])&&$rowData['Contrato_Fecha_Ini']!=''){               $FechaInicioContrato        = fecha_estandar($rowData['Contrato_Fecha_Ini']);                               }else{$FechaInicioContrato        = 'Sin datos';}
				if(isset($rowData['Contrato_Representante_Legal'])&&$rowData['Contrato_Representante_Legal']!=''){  $RepresentanteNombre        = $rowData['Contrato_Representante_Legal'];                                     }else{$RepresentanteNombre        = 'Sin datos';}
				if(isset($rowData['Contrato_Representante_Rut'])&&$rowData['Contrato_Representante_Rut']!=''){      $RepresentanteRut           = $rowData['Contrato_Representante_Rut'];                                       }else{$RepresentanteRut           = 'Sin datos';}
				if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){                                       $ClienteNombre              = $rowData['Nombre'];                                                           }else{$ClienteNombre              = 'Sin datos';}
				if(isset($rowData['Giro'])&&$rowData['Giro']!=''){                                           $ClienteGiro                = $rowData['Giro'];                                                             }else{$ClienteGiro                = 'Sin datos';}
				if(isset($rowData['Rut'])&&$rowData['Rut']!=''){                                             $ClienteRut                 = $rowData['Rut'];                                                              }else{$ClienteRut                 = 'Sin datos';}
				if(isset($rowData['Direccion'])&&$rowData['Direccion']!=''){                                 $ClienteDireccion           = $rowData['Direccion'];                                                        }else{$ClienteDireccion           = 'Sin datos';}
				if(isset($rowData['Comuna'])&&$rowData['Comuna']!=''){                                       $ClienteComuna              = $rowData['Comuna'];                                                           }else{$ClienteComuna              = 'Sin datos';}
				if(isset($rowData['Contrato_UF_Instalacion'])&&$rowData['Contrato_UF_Instalacion']!=''){     $ValorUFInstalacion         = Cantidades_decimales_justos($rowData['Contrato_UF_Instalacion']);             }else{$ValorUFInstalacion         = 'Sin datos';}
				if(isset($rowData['Contrato_UF_Instalacion'])&&$rowData['Contrato_UF_Instalacion']!=''){     $ValorUFInstalacionPalabra  = str_replace('PESOS', 'UF',numtoletras($rowData['Contrato_UF_Instalacion']));  }else{$ValorUFInstalacionPalabra  = 'Sin datos';}
				if(isset($rowData['Contrato_UF_Mensual'])&&$rowData['Contrato_UF_Mensual']!=''){             $ValorUFMensualidad         = Cantidades_decimales_justos($rowData['Contrato_UF_Mensual']);                 }else{$ValorUFMensualidad         = 'Sin datos';}
				if(isset($rowData['Contrato_UF_Mensual'])&&$rowData['Contrato_UF_Mensual']!=''){             $ValorUFMensualidadPalabra  = str_replace('PESOS', 'UF',numtoletras($rowData['Contrato_UF_Mensual']));      }else{$ValorUFMensualidadPalabra  = 'Sin datos';}
				if(isset($rowData['Contrato_N_Meses'])&&$rowData['Contrato_N_Meses']!=''){                   $NMeses                     = Cantidades_decimales_justos($rowData['Contrato_N_Meses']);                    }else{$NMeses                     = 'Sin datos';}
				if(isset($rowData['Contrato_Periodo'])&&$rowData['Contrato_Periodo']!=''){                   $Periodo                    = $rowData['Contrato_Periodo'];                                                 }else{$Periodo                    = 'Sin datos';}

				?>
				
				doc.setData({
					N_Documento: '<?php echo $N_Documento; ?>',
					UnidadNegocio: '<?php echo $UnidadNegocio; ?>',
					FechaInicioContrato: '<?php echo $FechaInicioContrato; ?>',
					RepresentanteNombre: '<?php echo $RepresentanteNombre; ?>',
					RepresentanteRut: '<?php echo $RepresentanteRut; ?>',
					ClienteNombre: '<?php echo $ClienteNombre; ?>',
					ClienteGiro: '<?php echo $ClienteGiro; ?>',
					ClienteRut: '<?php echo $ClienteRut; ?>',
					ClienteDireccion: '<?php echo $ClienteDireccion; ?>',
					ClienteComuna: '<?php echo $ClienteComuna; ?>',
					ValorUFInstalacion: '<?php echo $ValorUFInstalacion; ?>',
					ValorUFInstalacionPalabra: '<?php echo $ValorUFInstalacionPalabra; ?>',
					ValorUFMensualidad: '<?php echo $ValorUFMensualidad; ?>',
					ValorUFMensualidadPalabra: '<?php echo $ValorUFMensualidadPalabra; ?>',
					NMeses: '<?php echo $NMeses; ?>',
					Periodo: '<?php echo $Periodo; ?>'
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
				saveAs(out,"<?php echo 'Contrato '.$rowData['Nombre'].' N°'.N_doc($rowData['idCliente'], 5).'-'.N_doc($X_idTab, 2); ?>.docx")
			})
		}
    </script>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
