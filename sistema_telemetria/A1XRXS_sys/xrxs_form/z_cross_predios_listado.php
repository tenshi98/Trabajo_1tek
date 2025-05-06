<?php
//Llamamos a la libreria para importar datos en excel
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-237).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idPredio']))    $idPredio    = $_POST['idPredio'];
	if (!empty($_POST['idSistema']))   $idSistema   = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))    $idEstado    = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))      $Nombre      = $_POST['Nombre'];
	if (!empty($_POST['idPais']))      $idPais      = $_POST['idPais'];
	if (!empty($_POST['idCiudad']))    $idCiudad    = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))    $idComuna    = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))   $Direccion   = $_POST['Direccion'];

/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idPredio':   if(empty($idPredio)){   $error['idPredio']    = 'error/No ha ingresado el id';}break;
			case 'idSistema':  if(empty($idSistema)){  $error['idSistema']   = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':   if(empty($idEstado)){   $error['idEstado']    = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':     if(empty($Nombre)){     $error['Nombre']      = 'error/No ha ingresado el nombre';}break;
			case 'idPais':     if(empty($idPais)){     $error['idPais']      = 'error/No ha seleccionado el Pais';}break;
			case 'idCiudad':   if(empty($idCiudad)){   $error['idCiudad']    = 'error/No ha seleccionado la Ciudad';}break;
			case 'idComuna':   if(empty($idComuna)){   $error['idComuna']    = 'error/No ha seleccionado la Comuna';}break;
			case 'Direccion':  if(empty($Direccion)){  $error['Direccion']   = 'error/No ha seleccionado la Dirección';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){       $Nombre    = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){ $Direccion = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){        $error['Nombre']    = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){  $error['Direccion'] = 'error/Edita Direccion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert_plant':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['FilePredio']['name'])){

					if ($_FILES['FilePredio']["error"] > 0){
						$error['FilePredio'] = 'error/'.uploadPHPError($_FILES["FilePredio"]["error"]);

					} else {

						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
										);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;

						if (in_array($_FILES['FilePredio']['type'], $permitidos) && $_FILES['FilePredio']['size'] <= $limite_kb * 1024){

							/*******************************************************************/
							//variables
							$ndata_1  = 0;
							$nPredios = 0;
							//Cargo el archivo
							$spreadsheet = IOFactory::load($_FILES['FilePredio']['tmp_name']);
							//Obtengo los nombres de las hojas
							$loadedSheetNames = $spreadsheet->getSheetNames();
							//recorro las hojas
							foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
								//seteo la hoja
								$spreadsheet->setActiveSheetIndex($sheetIndex);
								//selecciono la hoja
								$worksheet = $spreadsheet->getActiveSheet();
								//obtengo el total de datos
								$highestRow = $worksheet->getHighestRow();
								//si es una hoja en especifico
								if ($loadedSheetName == "Predio"){
									//recorro
									for ($row=2; $row<=$highestRow; $row++){

										$Predio_Nombre    = $worksheet->getCellByColumnAndRow(1,  $row)->getValue();
										$Predio_Pais      = $worksheet->getCellByColumnAndRow(2,  $row)->getValue();
										$Predio_Ciudad    = $worksheet->getCellByColumnAndRow(3,  $row)->getValue();
										$Predio_Comuna    = $worksheet->getCellByColumnAndRow(4,  $row)->getValue();
										$Predio_Direccion = $worksheet->getCellByColumnAndRow(5,  $row)->getValue();

										//si la celda no esta vacia
										if($Predio_Nombre!=''){
											//verifico si el predio ingresado en el excel existe
											$SIS_query = 'Nombre';
											$SIS_join  = '';
											$SIS_where = 'idSistema='.$idSistema.' AND Nombre="'.$Predio_Nombre.'"';
											$nRows = db_select_nrows (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'nRows');

											//Si existe se marca error
											if(isset($nRows)&&$nRows!=0){
												$ndata_1++;
											}

											//conteo de predios
											$nPredios++;
										}
									}
								}
							}

							/*******************************************************************/
							//generacion de errores
							if($ndata_1 > 0) {  $error['ndata_1']  = 'error/El predio ingresado ya existe en el sistema';}
							if($nPredios > 1) { $error['nPredios'] = 'error/Esta tratando de ingresar mas de un predio';}

							/*******************************************************************/
							//Si no hay errores ejecuto el codigo
							if(empty($error)){

								//Obtengo los id
								$rowPais   = db_select_data (false, 'idPais', 'core_paises', '', 'Nombre="'.$Predio_Pais.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$rowCiudad = db_select_data (false, 'idCiudad', 'core_ubicacion_ciudad', '', 'Nombre="'.$Predio_Ciudad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$rowComuna = db_select_data (false, 'idComuna', 'core_ubicacion_comunas', '', 'Nombre="'.$Predio_Comuna.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Asigno valores
								$idPais    = $rowPais['idPais'];
								$idCiudad  = $rowCiudad['idCiudad'];
								$idComuna  = $rowComuna['idComuna'];

								//filtros
								if(isset($idSistema) && $idSistema!=''){                $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
								if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
								if(isset($Predio_Nombre) && $Predio_Nombre!=''){        $SIS_data .= ",'".$Predio_Nombre."'";     }else{$SIS_data .= ",''";}
								if(isset($idPais) && $idPais!=''){                      $SIS_data .= ",'".$idPais."'";            }else{$SIS_data .= ",''";}
								if(isset($idCiudad) && $idCiudad!=''){                  $SIS_data .= ",'".$idCiudad."'";          }else{$SIS_data .= ",''";}
								if(isset($idComuna) && $idComuna!=''){                  $SIS_data .= ",'".$idComuna."'";          }else{$SIS_data .= ",''";}
								if(isset($Predio_Direccion) && $Predio_Direccion!=''){  $SIS_data .= ",'".$Predio_Direccion."'";  }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSistema, idEstado, Nombre,idPais, idCiudad, idComuna, Direccion';
								$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_predios_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Si ejecuto correctamente la consulta
								if($ultimo_id!=0){
									/*******************************************************************/
									//Cargo a todos los clientes del sistema
									$arrEspecies   = array();
									$arrVariedades = array();
									$arrEstadoProd = array();
									$arrEstado     = array();

									$arrEspecies   = db_select_array (false, 'idCategoria,Nombre', 'sistema_variedades_categorias', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									$arrVariedades = db_select_array (false, 'idProducto,Nombre', 'variedades_listado', '', 'idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									$arrEstadoProd = db_select_array (false, 'idEstadoProd,Nombre', 'core_cross_estados_productivos', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									$arrEstado     = db_select_array (false, 'idEstado,Nombre', 'core_estados', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//recorro los datos
									$arrEspeciesMod   = array();
									$arrVariedadesMod = array();
									$arrEstadoProdMod = array();
									$arrEstadoMod     = array();
									foreach ($arrEspecies as $data) {   $arrEspeciesMod[$data['Nombre']]['idCategoria']    = $data['idCategoria'];}
									foreach ($arrVariedades as $data) { $arrVariedadesMod[$data['Nombre']]['idProducto']   = $data['idProducto'];}
									foreach ($arrEstadoProd as $data) { $arrEstadoProdMod[$data['Nombre']]['idEstadoProd'] = $data['idEstadoProd'];}
									foreach ($arrEstado as $data) {     $arrEstadoMod[$data['Nombre']]['idEstado']         = $data['idEstado'];}

									//Cargo el archivo
									$spreadsheet = IOFactory::load($_FILES['FilePredio']['tmp_name']);
									//Obtengo los nombres de las hojas
									$loadedSheetNames = $spreadsheet->getSheetNames();
									//recorro las hojas
									foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
										//seteo la hoja
										$spreadsheet->setActiveSheetIndex($sheetIndex);
										//selecciono la hoja
										$worksheet = $spreadsheet->getActiveSheet();
										//obtengo el total de datos
										$highestRow = $worksheet->getHighestRow();
										//si es una hoja en especifico
										if ($loadedSheetName == "Cuarteles"){
											//recorro
											for ($row=2; $row<=$highestRow; $row++){

												$ID                  = $worksheet->getCellByColumnAndRow(1,   $row)->getValue();
												$NombreCuartel       = $worksheet->getCellByColumnAndRow(2,   $row)->getValue();
												$CodigoCuartel       = $worksheet->getCellByColumnAndRow(3,   $row)->getValue();
												$Especie             = $worksheet->getCellByColumnAndRow(4,   $row)->getValue();
												$Variedad            = $worksheet->getCellByColumnAndRow(5,   $row)->getValue();
												$AnoPlantacion       = $worksheet->getCellByColumnAndRow(6,   $row)->getValue();
												$N_Hectareas         = $worksheet->getCellByColumnAndRow(7,   $row)->getValue();
												$N_Hileras           = $worksheet->getCellByColumnAndRow(8,   $row)->getValue();
												$N_Plantas           = $worksheet->getCellByColumnAndRow(9,   $row)->getValue();
												$EstadoProductivo    = $worksheet->getCellByColumnAndRow(10,  $row)->getValue();
												$DistanciaPlantacion = $worksheet->getCellByColumnAndRow(11,  $row)->getValue();
												$DistanciaHileras    = $worksheet->getCellByColumnAndRow(12,  $row)->getValue();
												$Estado              = $worksheet->getCellByColumnAndRow(13,  $row)->getValue();

												//Mientras exista dato ejecuta
												if(isset($ID)&&$ID!=''){
													//Se cambian comas por puntos
													$ID_AnoPlantacion       = str_replace(',', '.', $AnoPlantacion);
													$ID_N_Hectareas         = str_replace(',', '.', $N_Hectareas);
													$ID_N_Hileras           = str_replace(',', '.', $N_Hileras);
													$ID_N_Plantas           = str_replace(',', '.', $N_Plantas);
													$ID_DistanciaPlantacion = str_replace(',', '.', $DistanciaPlantacion);
													$ID_DistanciaHileras    = str_replace(',', '.', $DistanciaHileras);

													//verifico si existen los datos
													if(isset($Especie)&&isset($arrEspeciesMod[$Especie]['idCategoria'])){                       $ID_idCategoria  = $arrEspeciesMod[$Especie]['idCategoria'];}
													if(isset($Variedad)&&isset($arrVariedadesMod[$Variedad]['idProducto'])){                    $ID_idProducto   = $arrVariedadesMod[$Variedad]['idProducto'];}
													if(isset($EstadoProductivo)&&isset($arrEstadoProdMod[$EstadoProductivo]['idEstadoProd'])){  $ID_idEstadoProd = $arrEstadoProdMod[$EstadoProductivo]['idEstadoProd'];}
													if(isset($Estado)&&isset($arrEstadoMod[$Estado]['idEstado'])){                              $ID_idEstado     = $arrEstadoMod[$Estado]['idEstado'];}

													//filtros
													if(isset($ultimo_id) && $ultimo_id!=''){                            $SIS_data  = "'".$ultimo_id."'";                }else{$SIS_data  = "''";}
													if(isset($NombreCuartel) && $NombreCuartel!=''){                    $SIS_data .= ",'".$NombreCuartel."'";           }else{$SIS_data .= ",''";}
													if(isset($ID_idEstado) && $ID_idEstado!=''){                        $SIS_data .= ",'".$ID_idEstado."'";             }else{$SIS_data .= ",''";}
													if(isset($CodigoCuartel) && $CodigoCuartel!=''){                    $SIS_data .= ",'".$CodigoCuartel."'";           }else{$SIS_data .= ",''";}
													if(isset($ID_idCategoria) && $ID_idCategoria!=''){                  $SIS_data .= ",'".$ID_idCategoria."'";          }else{$SIS_data .= ",''";}
													if(isset($ID_idProducto) && $ID_idProducto!=''){                    $SIS_data .= ",'".$ID_idProducto."'";           }else{$SIS_data .= ",''";}
													if(isset($ID_AnoPlantacion) && $ID_AnoPlantacion!=''){              $SIS_data .= ",'".$ID_AnoPlantacion."'";        }else{$SIS_data .= ",''";}
													if(isset($ID_N_Hectareas) && $ID_N_Hectareas!=''){                  $SIS_data .= ",'".$ID_N_Hectareas."'";          }else{$SIS_data .= ",''";}
													if(isset($ID_N_Hileras) && $ID_N_Hileras!=''){                      $SIS_data .= ",'".$ID_N_Hileras."'";            }else{$SIS_data .= ",''";}
													if(isset($ID_N_Plantas) && $ID_N_Plantas!=''){                      $SIS_data .= ",'".$ID_N_Plantas."'";            }else{$SIS_data .= ",''";}
													if(isset($ID_idEstadoProd) && $ID_idEstadoProd!=''){                $SIS_data .= ",'".$ID_idEstadoProd."'";         }else{$SIS_data .= ",''";}
													if(isset($ID_DistanciaPlantacion) && $ID_DistanciaPlantacion!=''){  $SIS_data .= ",'".$ID_DistanciaPlantacion."'";  }else{$SIS_data .= ",''";}
													if(isset($ID_DistanciaHileras) && $ID_DistanciaHileras!=''){        $SIS_data .= ",'".$ID_DistanciaHileras."'";     }else{$SIS_data .= ",''";}

													// inserto los datos de registro en la db
													$SIS_columns = 'idPredio, Nombre,idEstado, Codigo, idCategoria,
													idProducto, AnoPlantacion, Hectareas, Hileras, Plantas, idEstadoProd,
													DistanciaPlant, DistanciaHileras';
													$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_predios_listado_zonas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

												}
											}
										}
									}

									//redirijo
									header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
									die;

								}
							}

						} else {
							$error['FilePredio']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{
					//se devuelve error
					$error['FilePredio'] = 'error/No ha seleccionado un archivo';
				}

			}

		break;
/*******************************************************************************************************************/
		case 'update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idPredio)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'cross_predios_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idPredio!='".$idPredio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idPredio='".$idPredio."'";
				if(isset($idSistema) && $idSistema!=''){    $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){      $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){          $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idPais) && $idPais!=''){          $SIS_data .= ",idPais='".$idPais."'";}
				if(isset($idCiudad) && $idCiudad!=''){      $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){      $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){    $SIS_data .= ",Direccion='".$Direccion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del']) OR !validaEntero($_GET['del']))&&$_GET['del']!=''){
				$indice = simpleDecode($_GET['del'], fecha_actual());
			}else{
				$indice = $_GET['del'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'cross_predios_listado', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'cross_predios_listado_zonas', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'cross_predios_listado_zonas_ubicaciones', 'idPredio = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idPredio   = $_GET['id'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'cross_predios_listado', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
	}

?>
