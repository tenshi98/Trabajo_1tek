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
trabajadores_listado.FechaContrato AS Trabajador_FechaContrato,
core_sistemas.Nombre AS Empleador_Nombre,
core_sistemas.Rut AS Empleador_Rut,
core_sistemas.RepresentanteNombre AS Empleador_RepresentanteNombre,
core_sistemas.RepresentanteRut AS Empleador_RepresentanteRut,
emp_ciudad.Nombre AS Empleador_region,
emp_comuna.Nombre AS Empleador_comuna,
core_sistemas.Direccion AS Empleador_Direccion,
trabajadores_listado.Nombre AS Trabajador_Nombre,
trabajadores_listado.ApellidoPat AS Trabajador_ApellidoPat,
trabajadores_listado.ApellidoMat AS Trabajador_ApellidoMat,
trabajadores_listado.Rut AS Trabajador_Rut,
trabajadores_listado.FNacimiento AS Trabajador_FechaNacimiento,
core_estado_civil.Nombre AS Trabajador_EstadoCivil,
core_ubicacion_ciudad.Nombre AS Trabajador_Ciudad,
core_ubicacion_comunas.Nombre AS Trabajador_Comunas,
trabajadores_listado.Direccion AS Trabajador_Direccion,
trabajadores_listado.Cargo AS Trabajador_Cargo,
trabajadores_listado.SueldoLiquido AS Trabajador_Sueldo,
sistema_afp.Nombre AS Trabajador_AFP,
sistema_salud.Nombre AS Trabajador_Salud,
trabajadores_listado.F_Inicio_Contrato AS Trabajador_FechaIngreso,
trabajadores_listado.UbicacionTrabajo AS Trabajador_UbicacionTrabajo

';
$SIS_join  = '
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema                  = trabajadores_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`  emp_ciudad   ON emp_ciudad.idCiudad                      = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas` emp_comuna   ON emp_comuna.idComuna                      = core_sistemas.idComuna
LEFT JOIN `core_ubicacion_ciudad`               ON core_ubicacion_ciudad.idCiudad           = trabajadores_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`              ON core_ubicacion_comunas.idComuna          = trabajadores_listado.idComuna
LEFT JOIN `core_estado_civil`                   ON core_estado_civil.idEstadoCivil          = trabajadores_listado.idEstadoCivil
LEFT JOIN `sistema_afp`                         ON sistema_afp.idAFP                        = trabajadores_listado.idAFP
LEFT JOIN `sistema_salud`                       ON sistema_salud.idSalud                    = trabajadores_listado.idSalud
';
$SIS_where = 'trabajadores_listado.idTrabajador ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

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
			loadFile("templates/planilla_contrato_trabajador.docx",function(error,content){
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
				//se deben validar
				if(isset($rowData['Trabajador_FechaContrato'])&&$rowData['Trabajador_FechaContrato']!=''){   $Trabajador_FechaContrato       = Fecha_estandar($rowData['Trabajador_FechaContrato']);        }else{$Trabajador_FechaContrato       = 'Sin datos';}
				if(isset($rowData['Empleador_Nombre'])&&$rowData['Empleador_Nombre']!=''){                   $Empleador_Nombre               = $rowData['Empleador_Nombre'];                                }else{$Empleador_Nombre               = 'Sin datos';}
				if(isset($rowData['Empleador_Rut'])&&$rowData['Empleador_Rut']!=''){                         $Empleador_Rut                  = $rowData['Empleador_Rut'];                                   }else{$Empleador_Rut                  = 'Sin datos';}
				if(isset($rowData['Empleador_RepresentanteNombre'])&&$rowData['Empleador_RepresentanteNombre']!=''){$Empleador_RepresentanteNombre  = $rowData['Empleador_RepresentanteNombre'];                   }else{$Empleador_RepresentanteNombre  = 'Sin datos';}
				if(isset($rowData['Empleador_RepresentanteRut'])&&$rowData['Empleador_RepresentanteRut']!=''){      $Empleador_RepresentanteRut     = $rowData['Empleador_RepresentanteRut'];                      }else{$Empleador_RepresentanteRut     = 'Sin datos';}
				if(isset($rowData['Empleador_Direccion'])&&$rowData['Empleador_Direccion']!=''){             $Empleador_Direccion            = $rowData['Empleador_Direccion'];                             }else{$Empleador_Direccion            = 'Sin datos';}
				if(isset($rowData['Empleador_comuna'])&&$rowData['Empleador_comuna']!=''){                   $Empleador_Direccion           .= ', '.$rowData['Empleador_comuna'];                           }
				if(isset($rowData['Empleador_region'])&&$rowData['Empleador_region']!=''){                   $Empleador_Direccion           .= ', '.$rowData['Empleador_region'];                           }
				if(isset($rowData['Trabajador_Nombre'])&&$rowData['Trabajador_Nombre']!=''){                 $Trabajador_Nombre              = $rowData['Trabajador_Nombre'];                               }else{$Trabajador_Nombre              = 'Sin datos';}
				if(isset($rowData['Trabajador_ApellidoPat'])&&$rowData['Trabajador_ApellidoPat']!=''){       $Trabajador_Nombre             .= ' '.$rowData['Trabajador_ApellidoPat'];                      }
				if(isset($rowData['Trabajador_ApellidoMat'])&&$rowData['Trabajador_ApellidoMat']!=''){       $Trabajador_Nombre             .= ' '.$rowData['Trabajador_ApellidoMat'];                      }
				if(isset($rowData['Trabajador_Rut'])&&$rowData['Trabajador_Rut']!=''){                       $Trabajador_Rut                 = $rowData['Trabajador_Rut'];                                  }else{$Trabajador_Rut                 = 'Sin datos';}
				if(isset($rowData['Trabajador_FechaNacimiento'])&&$rowData['Trabajador_FechaNacimiento']!=''){      $Trabajador_FechaNacimiento     = Fecha_estandar($rowData['Trabajador_FechaNacimiento']);      }else{$Trabajador_FechaNacimiento     = 'Sin datos';}
				if(isset($rowData['Trabajador_EstadoCivil'])&&$rowData['Trabajador_EstadoCivil']!=''){       $Trabajador_EstadoCivil         = $rowData['Trabajador_EstadoCivil'];                          }else{$Trabajador_EstadoCivil         = 'Sin datos';}
				if(isset($rowData['Trabajador_Direccion'])&&$rowData['Trabajador_Direccion']!=''){           $Trabajador_Direccion           = $rowData['Trabajador_Direccion'];                            }else{$Trabajador_Direccion           = 'Sin datos';}
				if(isset($rowData['Trabajador_Comunas'])&&$rowData['Trabajador_Comunas']!=''){               $Trabajador_Direccion          .= ', '.$rowData['Trabajador_Comunas'];                         }
				if(isset($rowData['Trabajador_Ciudad'])&&$rowData['Trabajador_Ciudad']!=''){                 $Trabajador_Direccion          .= ', '.$rowData['Trabajador_Ciudad'];                          }
				if(isset($rowData['Trabajador_Cargo'])&&$rowData['Trabajador_Cargo']!=''){                   $Trabajador_Cargo               = $rowData['Trabajador_Cargo'];                                }else{$Trabajador_Cargo               = 'Sin datos';}
				if(isset($rowData['Trabajador_Sueldo'])&&$rowData['Trabajador_Sueldo']!=''){                 $Trabajador_Sueldo              = valores($rowData['Trabajador_Sueldo'], 0);                   }else{$Trabajador_Sueldo              = 'Sin datos';}
				if(isset($rowData['Trabajador_Sueldo'])&&$rowData['Trabajador_Sueldo']!=''){                 $Trabajador_SueldoPalabras      = numtoletras($rowData['Trabajador_Sueldo']);                  }else{$Trabajador_SueldoPalabras      = 'Sin datos';}
				if(isset($rowData['Trabajador_AFP'])&&$rowData['Trabajador_AFP']!=''){                       $Trabajador_AFP                 = $rowData['Trabajador_AFP'];                                  }else{$Trabajador_AFP                 = 'Sin datos';}
				if(isset($rowData['Trabajador_Salud'])&&$rowData['Trabajador_Salud']!=''){                   $Trabajador_Salud               = $rowData['Trabajador_Salud'];                                }else{$Trabajador_Salud               = 'Sin datos';}
				if(isset($rowData['Trabajador_FechaIngreso'])&&$rowData['Trabajador_FechaIngreso']!=''){     $Trabajador_FechaIngreso        = Fecha_estandar($rowData['Trabajador_FechaIngreso']);         }else{$Trabajador_FechaIngreso        = 'Sin datos';}
				if(isset($rowData['Trabajador_UbicacionTrabajo'])&&$rowData['Trabajador_UbicacionTrabajo']!=''){    $Trabajador_UbicacionTrabajo    = $rowData['Trabajador_UbicacionTrabajo'];                     }else{$Trabajador_UbicacionTrabajo    = 'Sin datos';}

				?>
				
				doc.setData({
					FechaContrato: '<?php echo $Trabajador_FechaContrato; ?>',
					Empleador_Nombre: '<?php echo $Empleador_Nombre; ?>',
					Empleador_Rut: '<?php echo $Empleador_Rut; ?>',
					Empleador_RepresentanteNombre: '<?php echo $Empleador_RepresentanteNombre; ?>',
					Empleador_RepresentanteRut: '<?php echo $Empleador_RepresentanteRut; ?>',
					Empleador_Direccion: '<?php echo $Empleador_Direccion; ?>',
					Trabajador_Nombre: '<?php echo $Trabajador_Nombre; ?>',
					Trabajador_Rut: '<?php echo $Trabajador_Rut; ?>',
					Trabajador_FechaNacimiento: '<?php echo $Trabajador_FechaNacimiento; ?>',
					Trabajador_EstadoCivil: '<?php echo $Trabajador_EstadoCivil; ?>',
					Trabajador_Direccion: '<?php echo $Trabajador_Direccion; ?>',
					Trabajador_Cargo: '<?php echo $Trabajador_Cargo; ?>',
					Trabajador_Sueldo: '<?php echo $Trabajador_Sueldo; ?>',
					Trabajador_SueldoPalabras: '<?php echo $Trabajador_SueldoPalabras; ?>',
					Trabajador_AFP: '<?php echo $Trabajador_AFP; ?>',
					Trabajador_Salud: '<?php echo $Trabajador_Salud; ?>',
					Trabajador_FechaIngreso: '<?php echo $Trabajador_FechaIngreso; ?>',
					Trabajador_UbicacionTrabajo: '<?php echo $Trabajador_UbicacionTrabajo; ?>',
					
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
				saveAs(out,"<?php echo 'Contrato Trabajador '.$Trabajador_Nombre; ?>.docx")
			})
		}
    </script>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
