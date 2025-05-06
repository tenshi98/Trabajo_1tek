<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-241).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idAnalisis']))         $idAnalisis          = $_POST['idAnalisis'];
	if (!empty($_POST['idSistema']))          $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))          $idUsuario           = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))         $fecha_auto          = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))     $Creacion_fecha      = $_POST['Creacion_fecha'];
	if (!empty($_POST['idTipo']))             $idTipo              = $_POST['idTipo'];
	if (!empty($_POST['Temporada']))          $Temporada           = $_POST['Temporada'];
	if (!empty($_POST['idCategoria']))        $idCategoria         = $_POST['idCategoria'];
	if (!empty($_POST['idProducto']))         $idProducto          = $_POST['idProducto'];
	if (!empty($_POST['idUbicacion']))        $idUbicacion         = $_POST['idUbicacion'];
	if (!empty($_POST['idUbicacion_lvl_1']))  $idUbicacion_lvl_1   = $_POST['idUbicacion_lvl_1'];
	if (!empty($_POST['idUbicacion_lvl_2']))  $idUbicacion_lvl_2   = $_POST['idUbicacion_lvl_2'];
	if (!empty($_POST['idUbicacion_lvl_3']))  $idUbicacion_lvl_3   = $_POST['idUbicacion_lvl_3'];
	if (!empty($_POST['idUbicacion_lvl_4']))  $idUbicacion_lvl_4   = $_POST['idUbicacion_lvl_4'];
	if (!empty($_POST['idUbicacion_lvl_5']))  $idUbicacion_lvl_5   = $_POST['idUbicacion_lvl_5'];
	if (!empty($_POST['Observaciones']))      $Observaciones       = $_POST['Observaciones'];

	if (!empty($_POST['idTrabajador']))      $idTrabajador         = $_POST['idTrabajador'];
	if (!empty($_POST['idMaquina']))         $idMaquina            = $_POST['idMaquina'];

	if (!empty($_POST['idProductor']))       $idProductor          = $_POST['idProductor'];
	if (!empty($_POST['n_folio_pallet']))    $n_folio_pallet       = $_POST['n_folio_pallet'];
	if (!empty($_POST['lote']))              $lote                 = $_POST['lote'];
	if (!empty($_POST['f_embalaje']))        $f_embalaje           = $_POST['f_embalaje'];
	if (!empty($_POST['f_cosecha']))         $f_cosecha            = $_POST['f_cosecha'];
	if (!empty($_POST['H_inspeccion']))      $H_inspeccion         = $_POST['H_inspeccion'];
	if (!empty($_POST['cantidad']))          $cantidad             = $_POST['cantidad'];
	if (!empty($_POST['peso']))              $peso                 = $_POST['peso'];
	if (!empty($_POST['Resolucion_1']))      $Resolucion_1         = $_POST['Resolucion_1'];
	if (!empty($_POST['Resolucion_2']))      $Resolucion_2         = $_POST['Resolucion_2'];
	if (!empty($_POST['Resolucion_3']))      $Resolucion_3         = $_POST['Resolucion_3'];
	if (!empty($_POST['rev_Resolucion_1']))  $rev_Resolucion_1     = $_POST['rev_Resolucion_1'];
	if (!empty($_POST['rev_Resolucion_2']))  $rev_Resolucion_2     = $_POST['rev_Resolucion_2'];
	if (!empty($_POST['rev_Resolucion_3']))  $rev_Resolucion_3     = $_POST['rev_Resolucion_3'];

	for ($i = 1; $i <= 100; $i++) {
		if (!empty($_POST['Medida_'.$i]))         $Medida[$i]          = $_POST['Medida_'.$i];
		if (!empty($_POST['rev_Medida_'.$i]))     $Revision[$i]        = $_POST['rev_Medida_'.$i];
	}

	if (!empty($_POST['oldidProducto']))         $oldidProducto         = $_POST['oldidProducto'];

	if (!empty($_POST['idMuestras']))          $idMuestras           = $_POST['idMuestras'];
	if (!empty($_POST['idArchivo']))           $idArchivo            = $_POST['idArchivo'];
	if (!empty($_POST['idMaquinas']))          $idMaquinas           = $_POST['idMaquinas'];
	if (!empty($_POST['idTrabajadores']))      $idTrabajadores       = $_POST['idTrabajadores'];

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
			case 'idAnalisis':         if(empty($idAnalisis)){         $error['idAnalisis']         = 'error/No ha ingresado el id';}break;
			case 'idSistema':          if(empty($idSistema)){          $error['idSistema']          = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':          if(empty($idUsuario)){          $error['idUsuario']          = 'error/No ha seleccionado a un usuario';}break;
			case 'fecha_auto':         if(empty($fecha_auto)){         $error['fecha_auto']         = 'error/No ha ingresado la fecha de creación';}break;
			case 'Creacion_fecha':     if(empty($Creacion_fecha)){     $error['Creacion_fecha']     = 'error/No ha ingresado la fecha de creación';}break;
			case 'idTipo':             if(empty($idTipo)){             $error['idTipo']             = 'error/No ha seleccionado un tipo';}break;
			case 'Temporada':          if(empty($Temporada)){          $error['Temporada']          = 'error/No ha seleccionado la temporada';}break;
			case 'idCategoria':        if(empty($idCategoria)){        $error['idCategoria']        = 'error/No ha seleccionado la categoria';}break;
			case 'idProducto':         if(empty($idProducto)){         $error['idProducto']         = 'error/No ha seleccionado el producto';}break;
			case 'idUbicacion':        if(empty($idUbicacion)){        $error['idUbicacion']        = 'error/No ha seleccionado la ubicacion';}break;
			case 'idUbicacion_lvl_1':  if(empty($idUbicacion_lvl_1)){  $error['idUbicacion_lvl_1']  = 'error/No ha seleccionado la ubicacion del nivel 1';}break;
			case 'idUbicacion_lvl_2':  if(empty($idUbicacion_lvl_2)){  $error['idUbicacion_lvl_2']  = 'error/No ha seleccionado la ubicacion del nivel 2';}break;
			case 'idUbicacion_lvl_3':  if(empty($idUbicacion_lvl_3)){  $error['idUbicacion_lvl_3']  = 'error/No ha seleccionado la ubicacion del nivel 3';}break;
			case 'idUbicacion_lvl_4':  if(empty($idUbicacion_lvl_4)){  $error['idUbicacion_lvl_4']  = 'error/No ha seleccionado la ubicacion del nivel 4';}break;
			case 'idUbicacion_lvl_5':  if(empty($idUbicacion_lvl_5)){  $error['idUbicacion_lvl_5']  = 'error/No ha seleccionado la ubicacion del nivel 5';}break;
			case 'Observaciones':      if(empty($Observaciones)){      $error['Observaciones']      = 'error/No ha ingresado la observacion';}break;

			case 'idTrabajador':       if(empty($idTrabajador)){       $error['idTrabajador']       = 'error/No ha seleccionado el trabajador';}break;
			case 'idMaquina':          if(empty($idMaquina)){          $error['idMaquina']          = 'error/No ha seleccionado el instrumento';}break;

			case 'idProductor':        if(empty($idProductor)){        $error['idProductor']        = 'error/No ha seleccionado el Productor';}break;
			case 'n_folio_pallet':     if(empty($n_folio_pallet)){     $error['n_folio_pallet']     = 'error/No ha ingresado el numero de folio o pallet';}break;
			case 'lote':               if(empty($lote)){               $error['lote']               = 'error/No ha ingresado el lote';}break;
			case 'f_embalaje':         if(empty($f_embalaje)){         $error['f_embalaje']         = 'error/No ha ingresado la fecha de embalaje';}break;
			case 'f_cosecha':          if(empty($f_cosecha)){          $error['f_cosecha']          = 'error/No ha ingresado la fecha de la cosecha';}break;
			case 'H_inspeccion':       if(empty($H_inspeccion)){       $error['H_inspeccion']       = 'error/No ha ingresado la hora de inspeccion';}break;
			case 'cantidad':           if(empty($cantidad)){           $error['cantidad']           = 'error/No ha ingresado la cantidad';}break;
			case 'peso':               if(empty($peso)){               $error['peso']               = 'error/No ha ingresado el peso';}break;
			case 'Resolucion_1':       if(empty($Resolucion_1)){       $error['Resolucion_1']       = 'error/No ha ingresado la resolucion 1';}break;
			case 'Resolucion_2':       if(empty($Resolucion_2)){       $error['Resolucion_2']       = 'error/No ha ingresado la resolucion 2';}break;
			case 'Resolucion_3':       if(empty($Resolucion_3)){       $error['Resolucion_3']       = 'error/No ha ingresado la resolucion 3';}break;

			case 'idMuestras':         if(empty($idMuestras)){         $error['idMuestras']         = 'error/No ha ingresado el ID';}break;
			case 'idArchivo':          if(empty($idArchivo)){          $error['idArchivo']          = 'error/No ha ingresado el ID';}break;
			case 'idMaquinas':         if(empty($idMaquinas)){         $error['idMaquinas']         = 'error/No ha ingresado el ID';}break;
			case 'idTrabajadores':     if(empty($idTrabajadores)){     $error['idTrabajadores']     = 'error/No ha ingresado el ID';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Resolucion_1) && $Resolucion_1!=''){   $Resolucion_1  = EstandarizarInput($Resolucion_1);}
	if(isset($Resolucion_2) && $Resolucion_2!=''){   $Resolucion_2  = EstandarizarInput($Resolucion_2);}
	if(isset($Resolucion_3) && $Resolucion_3!=''){   $Resolucion_3  = EstandarizarInput($Resolucion_3);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones']  = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Resolucion_1)&&contar_palabras_censuradas($Resolucion_1)!=0){    $error['Resolucion_1']   = 'error/Edita Resolucion 1, contiene palabras no permitidas';}
	if(isset($Resolucion_2)&&contar_palabras_censuradas($Resolucion_2)!=0){    $error['Resolucion_2']   = 'error/Edita Resolucion 2, contiene palabras no permitidas';}
	if(isset($Resolucion_3)&&contar_palabras_censuradas($Resolucion_3)!=0){    $error['Resolucion_3']   = 'error/Edita Resolucion 3, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                       INGRESOS                                                  */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'new_ingreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			/*$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['cross_quality_reg_insp_basicos']);
				unset($_SESSION['cross_quality_reg_insp_muestras']);
				unset($_SESSION['cross_quality_reg_insp_maquinas']);
				unset($_SESSION['cross_quality_reg_insp_trabajadores']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['cross_quality_reg_insp_archivos'])){
					foreach ($_SESSION['cross_quality_reg_insp_archivos'] as $key => $producto){
						try {
							if(!is_writable('upload/'.$producto['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$producto['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
				unset($_SESSION['cross_quality_reg_insp_archivos']);

				/*********************************************/
				// Se trae el tipo de planilla
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoPlanilla = db_select_data (false, 'Nombre', 'core_cross_quality_analisis_calidad', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la categoria del producto
				if(isset($idCategoria)&&$idCategoria!=''){
					$rowCategoria = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = '.$idCategoria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información del producto
				if(isset($idProducto)&&$idProducto!=''){
					$rowProducto = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion
				if(isset($idUbicacion)&&$idUbicacion!=''){
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){
					$rowUbicacionLVL_1 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_1', '', 'idLevel_1 = '.$idUbicacion_lvl_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){
					$rowUbicacionLVL_2 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_2', '', 'idLevel_2 = '.$idUbicacion_lvl_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){
					$rowUbicacionLVL_3 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_3', '', 'idLevel_3 = '.$idUbicacion_lvl_3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){
					$rowUbicacionLVL_4 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_4', '', 'idLevel_4 = '.$idUbicacion_lvl_4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){
					$rowUbicacionLVL_5 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_5', '', 'idLevel_5 = '.$idUbicacion_lvl_5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información del producto
				if(isset($idCategoria)&&$idCategoria!=''&&isset($idTipo)&&$idTipo!=''&&isset($idSistema)&&$idSistema!=''){
					$rowMatrizCali = db_select_data (false, 'cross_quality_calidad_matriz.cantPuntos, sistema_variedades_categorias_matriz_calidad.idMatriz', 'sistema_variedades_categorias_matriz_calidad', 'LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz', 'sistema_variedades_categorias_matriz_calidad.idCategoria = '.$idCategoria.' AND sistema_variedades_categorias_matriz_calidad.idProceso = '.$idTipo.' AND sistema_variedades_categorias_matriz_calidad.idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*********************************************/
				//se guardan los datos consultados
				if(isset($rowProducto['Nombre'])&&$rowProducto['Nombre']!=''){             $_SESSION['cross_quality_reg_insp_basicos']['Producto']          = $rowCategoria['Nombre'].' '.$rowProducto['Nombre'];  }else{$_SESSION['cross_quality_reg_insp_basicos']['Producto']          = 'Sin Datos';}
				if(isset($rowUbicacion['Nombre'])&&$rowUbicacion['Nombre']!=''){           $_SESSION['cross_quality_reg_insp_basicos']['Ubicacion']         = $rowUbicacion['Nombre'];                             }else{$_SESSION['cross_quality_reg_insp_basicos']['Ubicacion']         = 'Sin Datos';}
				if(isset($rowUbicacionLVL_1['Nombre'])&&$rowUbicacionLVL_1['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_1']    = ' - '.$rowUbicacionLVL_1['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_1']    = '';}
				if(isset($rowUbicacionLVL_2['Nombre'])&&$rowUbicacionLVL_2['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_2']    = ' - '.$rowUbicacionLVL_2['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_2']    = '';}
				if(isset($rowUbicacionLVL_3['Nombre'])&&$rowUbicacionLVL_3['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_3']    = ' - '.$rowUbicacionLVL_3['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_3']    = '';}
				if(isset($rowUbicacionLVL_4['Nombre'])&&$rowUbicacionLVL_4['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_4']    = ' - '.$rowUbicacionLVL_4['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_4']    = '';}
				if(isset($rowUbicacionLVL_5['Nombre'])&&$rowUbicacionLVL_5['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_5']    = ' - '.$rowUbicacionLVL_5['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_5']    = '';}
				if(isset($rowMatrizCali['idMatriz'])&&$rowMatrizCali['idMatriz']!=''){     $_SESSION['cross_quality_reg_insp_basicos']['idMatriz']          = $rowMatrizCali['idMatriz'];                          }else{$_SESSION['cross_quality_reg_insp_basicos']['idMatriz']          = '';}
				if(isset($rowMatrizCali['cantPuntos'])&&$rowMatrizCali['cantPuntos']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['cantPuntos']        = $rowMatrizCali['cantPuntos'];                        }else{$_SESSION['cross_quality_reg_insp_basicos']['cantPuntos']        = '';}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['cross_quality_reg_insp_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['cross_quality_reg_insp_basicos']['idTipo']          = '';}
				if(isset($Temporada)&&$Temporada!=''){            $_SESSION['cross_quality_reg_insp_basicos']['Temporada']       = $Temporada;       }else{$_SESSION['cross_quality_reg_insp_basicos']['Temporada']       = '';}
				if(isset($idCategoria)&&$idCategoria!=''){        $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']     = $idCategoria;     }else{$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']     = '';}
				if(isset($idProducto)&&$idProducto!=''){          $_SESSION['cross_quality_reg_insp_basicos']['idProducto']      = $idProducto;      }else{$_SESSION['cross_quality_reg_insp_basicos']['idProducto']      = '';}
				if(isset($idUbicacion)&&$idUbicacion!=''){        $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']     = $idUbicacion;     }else{$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']     = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['cross_quality_reg_insp_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['cross_quality_reg_insp_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['cross_quality_reg_insp_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']      = '';}

				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']    = $idUbicacion_lvl_1;}
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']    = $idUbicacion_lvl_2;}
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']    = $idUbicacion_lvl_3;}
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']    = $idUbicacion_lvl_4;}
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']    = $idUbicacion_lvl_5;}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['cross_quality_reg_insp_basicos']);
			unset($_SESSION['cross_quality_reg_insp_muestras']);
			unset($_SESSION['cross_quality_reg_insp_maquinas']);
			unset($_SESSION['cross_quality_reg_insp_trabajadores']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['cross_quality_reg_insp_archivos'])){
				foreach ($_SESSION['cross_quality_reg_insp_archivos'] as $key => $producto){
					try {
						if(!is_writable('upload/'.$producto['Nombre'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$producto['Nombre']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}
			}
			unset($_SESSION['cross_quality_reg_insp_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			/*$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['cross_quality_reg_insp_temporal']);
				//Borro todas las sesiones
				unset($_SESSION['cross_quality_reg_insp_basicos']);

				/*********************************************/
				// Se trae el tipo de planilla
				if(isset($idTipo)&&$idTipo!=''){
					$rowTipoPlanilla = db_select_data (false, 'Nombre', 'core_cross_quality_analisis_calidad', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la categoria del producto
				if(isset($idCategoria)&&$idCategoria!=''){
					$rowCategoria = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = '.$idCategoria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información del producto
				if(isset($idProducto)&&$idProducto!=''){
					$rowProducto = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion
				if(isset($idUbicacion)&&$idUbicacion!=''){
					$rowUbicacion = db_select_data (false, 'Nombre', 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){
					$rowUbicacionLVL_1 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_1', '', 'idLevel_1 = '.$idUbicacion_lvl_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){
					$rowUbicacionLVL_2 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_2', '', 'idLevel_2 = '.$idUbicacion_lvl_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){
					$rowUbicacionLVL_3 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_3', '', 'idLevel_3 = '.$idUbicacion_lvl_3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){
					$rowUbicacionLVL_4 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_4', '', 'idLevel_4 = '.$idUbicacion_lvl_4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información de la ubicacion lvl 1
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){
					$rowUbicacionLVL_5 = db_select_data (false, 'Nombre', 'ubicacion_listado_level_5', '', 'idLevel_5 = '.$idUbicacion_lvl_5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*********************************************/
				// Se trae la información del producto
				if(isset($idCategoria)&&$idCategoria!=''&&isset($idTipo)&&$idTipo!=''&&isset($idSistema)&&$idSistema!=''){
					$rowMatrizCali = db_select_data (false, 'cross_quality_calidad_matriz.cantPuntos, sistema_variedades_categorias_matriz_calidad.idMatriz', 'sistema_variedades_categorias_matriz_calidad', 'LEFT JOIN `cross_quality_calidad_matriz` ON cross_quality_calidad_matriz.idMatriz = sistema_variedades_categorias_matriz_calidad.idMatriz', 'sistema_variedades_categorias_matriz_calidad.idCategoria = '.$idCategoria.' AND sistema_variedades_categorias_matriz_calidad.idProceso = '.$idTipo.' AND sistema_variedades_categorias_matriz_calidad.idSistema = '.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/*********************************************/
				//se guardan los datos consultados
				if(isset($rowTipoPlanilla['Nombre'])&&$rowTipoPlanilla['Nombre']!=''){     $_SESSION['cross_quality_reg_insp_basicos']['TipoPlanilla']      = $rowTipoPlanilla['Nombre'];                          }else{$_SESSION['cross_quality_reg_insp_basicos']['TipoPlanilla']      = 'Sin Datos';}
				if(isset($rowProducto['Nombre'])&&$rowProducto['Nombre']!=''){             $_SESSION['cross_quality_reg_insp_basicos']['Producto']          = $rowCategoria['Nombre'].' '.$rowProducto['Nombre'];  }else{$_SESSION['cross_quality_reg_insp_basicos']['Producto']          = 'Sin Datos';}
				if(isset($rowUbicacion['Nombre'])&&$rowUbicacion['Nombre']!=''){           $_SESSION['cross_quality_reg_insp_basicos']['Ubicacion']         = $rowUbicacion['Nombre'];                             }else{$_SESSION['cross_quality_reg_insp_basicos']['Ubicacion']         = 'Sin Datos';}
				if(isset($rowUbicacionLVL_1['Nombre'])&&$rowUbicacionLVL_1['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_1']    = ' - '.$rowUbicacionLVL_1['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_1']    = '';}
				if(isset($rowUbicacionLVL_2['Nombre'])&&$rowUbicacionLVL_2['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_2']    = ' - '.$rowUbicacionLVL_2['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_2']    = '';}
				if(isset($rowUbicacionLVL_3['Nombre'])&&$rowUbicacionLVL_3['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_3']    = ' - '.$rowUbicacionLVL_3['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_3']    = '';}
				if(isset($rowUbicacionLVL_4['Nombre'])&&$rowUbicacionLVL_4['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_4']    = ' - '.$rowUbicacionLVL_4['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_4']    = '';}
				if(isset($rowUbicacionLVL_5['Nombre'])&&$rowUbicacionLVL_5['Nombre']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_5']    = ' - '.$rowUbicacionLVL_5['Nombre'];                  }else{$_SESSION['cross_quality_reg_insp_basicos']['UbicacionLVL_5']    = '';}
				if(isset($rowMatrizCali['idMatriz'])&&$rowMatrizCali['idMatriz']!=''){     $_SESSION['cross_quality_reg_insp_basicos']['idMatriz']          = $rowMatrizCali['idMatriz'];                          }else{$_SESSION['cross_quality_reg_insp_basicos']['idMatriz']          = '';}
				if(isset($rowMatrizCali['cantPuntos'])&&$rowMatrizCali['cantPuntos']!=''){ $_SESSION['cross_quality_reg_insp_basicos']['cantPuntos']        = $rowMatrizCali['cantPuntos'];                        }else{$_SESSION['cross_quality_reg_insp_basicos']['cantPuntos']        = '';}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']  = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['cross_quality_reg_insp_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['cross_quality_reg_insp_basicos']['idTipo']          = '';}
				if(isset($Temporada)&&$Temporada!=''){            $_SESSION['cross_quality_reg_insp_basicos']['Temporada']       = $Temporada;       }else{$_SESSION['cross_quality_reg_insp_basicos']['Temporada']       = '';}
				if(isset($idCategoria)&&$idCategoria!=''){        $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']     = $idCategoria;     }else{$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']     = '';}
				if(isset($idProducto)&&$idProducto!=''){          $_SESSION['cross_quality_reg_insp_basicos']['idProducto']      = $idProducto;      }else{$_SESSION['cross_quality_reg_insp_basicos']['idProducto']      = '';}
				if(isset($idUbicacion)&&$idUbicacion!=''){        $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']     = $idUbicacion;     }else{$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']     = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['cross_quality_reg_insp_basicos']['Observaciones']   = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['cross_quality_reg_insp_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['cross_quality_reg_insp_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']       = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){          $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']      = $fecha_auto;      }else{$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']      = '';}

				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']    = $idUbicacion_lvl_1;}
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']    = $idUbicacion_lvl_2;}
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']    = $idUbicacion_lvl_3;}
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']    = $idUbicacion_lvl_4;}
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']    = $idUbicacion_lvl_5;}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'addTrab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se trae un listado con todos los trabajadores
			$rowTrabajadores = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se guarda el trabajador asignado
			$_SESSION['cross_quality_reg_insp_trabajadores'][$idTrabajador]['idTrabajador']  = $idTrabajador;
			$_SESSION['cross_quality_reg_insp_trabajadores'][$idTrabajador]['Nombre']        = $rowTrabajadores['Nombre'].' '.$rowTrabajadores['ApellidoPat'].' '.$rowTrabajadores['ApellidoMat'];
			$_SESSION['cross_quality_reg_insp_trabajadores'][$idTrabajador]['Cargo']         = $rowTrabajadores['Cargo'];
			$_SESSION['cross_quality_reg_insp_trabajadores'][$idTrabajador]['Rut']           = $rowTrabajadores['Rut'];

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'del_trab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['cross_quality_reg_insp_trabajadores'][$_GET['del_trab']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addMaq':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se trae un listado con todos los trabajadores
			$rowMaquina = db_select_data (false, 'Codigo, Nombre', 'maquinas_listado', '', 'idMaquina ='.$idMaquina, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se guarda el trabajador asignado
			$_SESSION['cross_quality_reg_insp_maquinas'][$idMaquina]['idMaquina']     = $idMaquina;
			$_SESSION['cross_quality_reg_insp_maquinas'][$idMaquina]['Nombre']        = $rowMaquina['Codigo'].' - '.$rowMaquina['Nombre'];

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'del_maq':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['cross_quality_reg_insp_maquinas'][$_GET['del_maq']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['cross_quality_reg_insp_archivos'])){
				foreach ($_SESSION['cross_quality_reg_insp_archivos'] as $key => $trabajos){
					if($idInterno<$trabajos['idFile']){$idInterno = $trabajos['idFile'];}
				}
			}

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"image/jpg",
											"image/jpeg",
											"image/gif",
											"image/png"

											);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'cross_qua_cali_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									//se guarda en el indice siguiente
									$idInterno = $idInterno+1;
									//Se guarda el trabajo asignado
									$_SESSION['cross_quality_reg_insp_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['cross_quality_reg_insp_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

									header( 'Location: '.$location.'&view=true' );
									die;

								}else {
									$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'].' ya existe';
							}
						} else {
							$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['cross_quality_reg_insp_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['cross_quality_reg_insp_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['cross_quality_reg_insp_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'new_muestra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['cross_quality_reg_insp_muestras'])){
				foreach ($_SESSION['cross_quality_reg_insp_muestras'] as $key => $trabajos){
					if($idInterno<$trabajos['idMuestra']){$idInterno = $trabajos['idMuestra'];}
				}
			}

			//Se revisa si existe la revision
			for ($i = 1; $i <= 100; $i++) {
				if(isset($Medida[$i])&&isset($Revision[$i])){
					//Variable
					$sxcount = 0;
					//divido la variable
					$obligatorios = str_replace(' ', '', $Revision[$i]);
					$piezas = explode(",", $obligatorios);
					//recorro los elementos
					foreach ($piezas as $sdfval) {
						if(isset($sdfval)&&$sdfval==$Medida[$i]){
							$sxcount++;
						}
					}
					//envio mensaje de error
					if($sxcount==0){
						$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles';
					}

				}
			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_1)&&isset($rev_Resolucion_1)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_1);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_1){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Nota Calidad';
				}

			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_2)&&isset($rev_Resolucion_2)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_2);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_2){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Nota Condición';
				}

			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_3)&&isset($rev_Resolucion_3)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_3);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_3){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Calificacion';
				}

			}

			if(empty($error)){

				// consulto los datos
				$rowProductor = db_select_data (false, 'Nombre', 'productores_listado', '', 'idProductor ='.$idProductor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$idInterno = $idInterno+1;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['idMuestra']       = $idInterno;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['idProductor']     = $idProductor;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['ProductorNombre'] = $rowProductor['Nombre'];
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['n_folio_pallet']  = $n_folio_pallet;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['idTipo']          = $idTipo;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['lote']            = $lote;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['f_embalaje']      = $f_embalaje;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['f_cosecha']       = $f_cosecha;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['H_inspeccion']    = $H_inspeccion;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['cantidad']        = $cantidad;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['peso']            = $peso;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['Resolucion_1']    = $Resolucion_1;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['Resolucion_2']    = $Resolucion_2;
				$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['Resolucion_3']    = $Resolucion_3;

				for ($i = 1; $i <= 100; $i++) {
					if(isset($Medida[$i])){
						$_SESSION['cross_quality_reg_insp_muestras'][$idInterno]['Medida_'.$i]   = $Medida[$i];
					}
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_muestra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se revisa si existe la revision
			for ($i = 1; $i <= 100; $i++) {
				if(isset($Medida[$i])&&isset($Revision[$i])){
					//Variable
					$sxcount = 0;
					//divido la variable
					$obligatorios = str_replace(' ', '', $Revision[$i]);
					$piezas = explode(",", $obligatorios);
					//recorro los elementos
					foreach ($piezas as $sdfval) {
						if(isset($sdfval)&&$sdfval==$Medida[$i]){
							$sxcount++;
						}
					}
					//envio mensaje de error
					if($sxcount==0){
						$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles';
					}

				}
			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_1)&&isset($rev_Resolucion_1)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_1);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_1){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Nota Calidad';
				}

			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_2)&&isset($rev_Resolucion_2)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_2);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_2){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Nota Condición';
				}

			}

			/*********************************************************/
			//Se revisan los datos de validacion
			if(isset($Resolucion_3)&&isset($rev_Resolucion_3)){
				//Variable
				$sxcount = 0;
				//divido la variable
				$obligatorios = str_replace(' ', '', $rev_Resolucion_3);
				$piezas = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $sdfval) {
					if(isset($sdfval)&&$sdfval==$Resolucion_3){
						$sxcount++;
					}
				}
				//envio mensaje de error
				if($sxcount==0){
					$error['sxcount']     = 'error/El valor ingresado no corresponde a las validaciones disponibles en Calificacion';
				}

			}

			if(empty($error)){

				// consulto los datos
				$rowProductor = db_select_data (false, 'Nombre', 'productores_listado', '', 'idProductor ='.$idProductor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['idMuestra']         = $oldidProducto;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['idProductor']       = $idProductor;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['ProductorNombre']   = $rowProductor['Nombre'];
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['n_folio_pallet']    = $n_folio_pallet;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['idTipo']            = $idTipo;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['lote']              = $lote;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['f_embalaje']        = $f_embalaje;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['f_cosecha']         = $f_cosecha;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['H_inspeccion']      = $H_inspeccion;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['cantidad']          = $cantidad;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['peso']              = $peso;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['Resolucion_1']      = $Resolucion_1;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['Resolucion_2']      = $Resolucion_2;
				$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['Resolucion_3']      = $Resolucion_3;

				for ($i = 1; $i <= 100; $i++) {
					if(isset($Medida[$i])){
						$_SESSION['cross_quality_reg_insp_muestras'][$oldidProducto]['Medida_'.$i]   = $Medida[$i];
					}
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_muestra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			unset($_SESSION['cross_quality_reg_insp_muestras'][$_GET['del_muestra']]);

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_Doc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;
			$n_data3 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['cross_quality_reg_insp_basicos'])){
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) OR $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) OR $_SESSION['cross_quality_reg_insp_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) OR $_SESSION['cross_quality_reg_insp_basicos']['Temporada']=='' ){           $error['Temporada']        = 'error/No ha seleccionado la Temporada';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) OR $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']=='' ){       $error['idCategoria']      = 'error/No ha seleccionado la categoria del producto';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) OR $_SESSION['cross_quality_reg_insp_basicos']['idProducto']=='' ){         $error['idProducto']       = 'error/No ha seleccionado el producto';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) OR $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']=='' ){       $error['idUbicacion']      = 'error/No ha seleccionado la ubicacion';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Observaciones']) OR $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) OR $_SESSION['cross_quality_reg_insp_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) OR $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) OR $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha de creación';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de datos';
			}

			/******************************************/
			//Se verifican trabajadores
			if (isset($_SESSION['cross_quality_reg_insp_trabajadores'])){
				foreach ($_SESSION['cross_quality_reg_insp_trabajadores'] as $key => $producto){
					$n_data1++;
				}
			}
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos1'] = 'error/No se han asignado trabajadores';
			}
			/******************************************/
			//Se verifican maquinas
			if (isset($_SESSION['cross_quality_reg_insp_maquinas'])){
				foreach ($_SESSION['cross_quality_reg_insp_maquinas'] as $key => $producto){
					$n_data2++;
				}
			}
			if(isset($n_data2)&&$n_data2==0){
				$error['trabajos2'] = 'error/No se han asignado maquinas';
			}
			/******************************************/
			//Se verifican maquinas
			if (isset($_SESSION['cross_quality_reg_insp_muestras'])){
				foreach ($_SESSION['cross_quality_reg_insp_muestras'] as $key => $producto){
					$n_data3++;
				}
			}
			if(isset($n_data3)&&$n_data3==0){
				$error['trabajos3'] = 'error/No se han asignado muestras';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data  = "'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Observaciones']) && $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']!=''){            $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Observaciones']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto,
				Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo, Temporada, idCategoria,
				idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3,
				idUbicacion_lvl_4, idUbicacion_lvl_5, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['cross_quality_reg_insp_trabajadores'])){
						foreach ($_SESSION['cross_quality_reg_insp_trabajadores'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idTrabajador']) && $producto['idTrabajador']!=''){                                                                                  $SIS_data .= ",'".$producto['idTrabajador']."'";                                         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idTrabajador';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_trabajador', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guardan los datos de las maquinas
					if(isset($_SESSION['cross_quality_reg_insp_maquinas'])){
						foreach ($_SESSION['cross_quality_reg_insp_maquinas'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idMaquina']) && $producto['idMaquina']!=''){                                                                                        $SIS_data .= ",'".$producto['idMaquina']."'";                                            }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idMaquina';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_maquina', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guardan los datos de las muestras
					if(isset($_SESSION['cross_quality_reg_insp_muestras'])){
						foreach ($_SESSION['cross_quality_reg_insp_muestras'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                     $SIS_data  = "'".$ultimo_id."'";                      }else{$SIS_data  = "''";}
							if(isset($producto['idProductor']) && $producto['idProductor']!=''){         $SIS_data .= ",'".$producto['idProductor']."'";       }else{$SIS_data .= ",''";}
							if(isset($producto['n_folio_pallet']) && $producto['n_folio_pallet']!=''){   $SIS_data .= ",'".$producto['n_folio_pallet']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['idTipo']) && $producto['idTipo']!=''){                   $SIS_data .= ",'".$producto['idTipo']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['lote']) && $producto['lote']!=''){                       $SIS_data .= ",'".$producto['lote']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['f_embalaje']) && $producto['f_embalaje']!=''){           $SIS_data .= ",'".$producto['f_embalaje']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['f_cosecha']) && $producto['f_cosecha']!=''){             $SIS_data .= ",'".$producto['f_cosecha']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['H_inspeccion']) && $producto['H_inspeccion']!=''){       $SIS_data .= ",'".$producto['H_inspeccion']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['cantidad']) && $producto['cantidad']!=''){               $SIS_data .= ",'".$producto['cantidad']."'";          }else{$SIS_data .= ",''";}
							if(isset($producto['peso']) && $producto['peso']!=''){                       $SIS_data .= ",'".$producto['peso']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['Resolucion_1']) && $producto['Resolucion_1']!=''){       $SIS_data .= ",'".$producto['Resolucion_1']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Resolucion_2']) && $producto['Resolucion_2']!=''){       $SIS_data .= ",'".$producto['Resolucion_2']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Resolucion_3']) && $producto['Resolucion_3']!=''){       $SIS_data .= ",'".$producto['Resolucion_3']."'";      }else{$SIS_data .= ",''";}

							$zz='';
							for ($i = 1; $i <= 100; $i++) {
								if(isset($producto['Medida_'.$i])&&$producto['Medida_'.$i]!= ''){   $SIS_data .= ",'".$producto['Medida_'.$i]."'";   }else{$SIS_data .= ",''";}
								$zz.=',Medida_'.$i;
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis,idProductor, n_folio_pallet, idTipo, lote, f_embalaje, f_cosecha, H_inspeccion, cantidad, peso, Resolucion_1, Resolucion_2, Resolucion_3 '.$zz;
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_muestras', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['cross_quality_reg_insp_archivos'])){
						foreach ($_SESSION['cross_quality_reg_insp_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){                                                                                              $SIS_data .= ",'".$producto['Nombre']."'";                                               }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_archivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['cross_quality_reg_insp_basicos']);
					unset($_SESSION['cross_quality_reg_insp_muestras']);
					unset($_SESSION['cross_quality_reg_insp_maquinas']);
					unset($_SESSION['cross_quality_reg_insp_trabajadores']);
					unset($_SESSION['cross_quality_reg_insp_archivos']);
					unset($_SESSION['cross_quality_reg_insp_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
		case 'modBase_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			/*$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProveedor, $idDocumentos, $N_Doc)){
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', "idProveedor='".$idProveedor."' AND idDocumentos='".$idDocumentos."' AND N_Doc='".$N_Doc."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Documento que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idAnalisis='".$idAnalisis."'";
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_Semana='".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idTipo) && $idTipo!=''){                            $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($Temporada) && $Temporada!=''){                      $SIS_data .= ",Temporada='".$Temporada."'";}
				if(isset($idCategoria) && $idCategoria!=''){                  $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idProducto) && $idProducto!=''){                    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){                  $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){      $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){      $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){      $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){      $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){      $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
				if(isset($Observaciones) && $Observaciones!=''){              $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($idSistema) && $idSistema!=''){                      $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){                      $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($fecha_auto) && $fecha_auto!=''){                    $SIS_data .= ",fecha_auto='".$fecha_auto."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_quality_registrar_inspecciones', 'idAnalisis = "'.$idAnalisis.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'addTrab_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idAnalisis)&&isset($idTrabajador)){
				$ndata_1 = db_select_nrows (false, 'idTrabajador', 'cross_quality_registrar_inspecciones_trabajador', '', "idAnalisis='".$idAnalisis."' AND idTrabajador='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Trabajador que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
			//filtros
				if(isset($idAnalisis) && $idAnalisis!=''){          $SIS_data  = "'".$idAnalisis."'";   }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",'".$idSistema."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";   }else{$SIS_data .= ",''";}
				if(isset($fecha_auto) && $fecha_auto!=''){          $SIS_data .= ",'".$fecha_auto."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idTipo) && $idTipo!=''){                            $SIS_data .= ",'".$idTipo."'";             }else{$SIS_data .= ",''";}
				if(isset($Temporada) && $Temporada!=''){                      $SIS_data .= ",'".$Temporada."'";          }else{$SIS_data .= ",''";}
				if(isset($idCategoria) && $idCategoria!=''){                  $SIS_data .= ",'".$idCategoria."'";        }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){                    $SIS_data .= ",'".$idProducto."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){                  $SIS_data .= ",'".$idUbicacion."'";        }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){      $SIS_data .= ",'".$idUbicacion_lvl_1."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){      $SIS_data .= ",'".$idUbicacion_lvl_2."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){      $SIS_data .= ",'".$idUbicacion_lvl_3."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){      $SIS_data .= ",'".$idUbicacion_lvl_4."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){      $SIS_data .= ",'".$idUbicacion_lvl_5."'";  }else{$SIS_data .= ",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){                $SIS_data .= ",'".$idTrabajador."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idAnalisis, idSistema,
				idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
				Temporada, idCategoria, idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
				idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idTrabajador';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_trabajador', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_trab_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_trab']) OR !validaEntero($_GET['del_trab']))&&$_GET['del_trab']!=''){
				$indice = simpleDecode($_GET['del_trab'], fecha_actual());
			}else{
				$indice = $_GET['del_trab'];
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
				$resultado = db_delete_data (false, 'cross_quality_registrar_inspecciones_trabajador', 'idTrabajadores = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
		case 'addMaq_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idAnalisis)&&isset($idMaquina)){
				$ndata_1 = db_select_nrows (false, 'idMaquina', 'cross_quality_registrar_inspecciones_maquina', '', "idAnalisis='".$idAnalisis."' AND idMaquina='".$idMaquina."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La Maquina que esta tratando de ingresar ya fue ingresado';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//filtros
				if(isset($idAnalisis) && $idAnalisis!=''){          $SIS_data  = "'".$idAnalisis."'";   }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",'".$idSistema."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";   }else{$SIS_data .= ",''";}
				if(isset($fecha_auto) && $fecha_auto!=''){          $SIS_data .= ",'".$fecha_auto."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idTipo) && $idTipo!=''){                            $SIS_data .= ",'".$idTipo."'";             }else{$SIS_data .= ",''";}
				if(isset($Temporada) && $Temporada!=''){                      $SIS_data .= ",'".$Temporada."'";          }else{$SIS_data .= ",''";}
				if(isset($idCategoria) && $idCategoria!=''){                  $SIS_data .= ",'".$idCategoria."'";        }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){                    $SIS_data .= ",'".$idProducto."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){                  $SIS_data .= ",'".$idUbicacion."'";        }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){      $SIS_data .= ",'".$idUbicacion_lvl_1."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){      $SIS_data .= ",'".$idUbicacion_lvl_2."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){      $SIS_data .= ",'".$idUbicacion_lvl_3."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){      $SIS_data .= ",'".$idUbicacion_lvl_4."'";  }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){      $SIS_data .= ",'".$idUbicacion_lvl_5."'";  }else{$SIS_data .= ",''";}
				if(isset($idMaquina) && $idMaquina!=''){                      $SIS_data .= ",'".$idMaquina."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idAnalisis, idSistema,
				idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
				Temporada, idCategoria, idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
				idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idMaquina';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_maquina', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_maq_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_maq']) OR !validaEntero($_GET['del_maq']))&&$_GET['del_maq']!=''){
				$indice = simpleDecode($_GET['del_maq'], fecha_actual());
			}else{
				$indice = $_GET['del_maq'];
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
				$resultado = db_delete_data (false, 'cross_quality_registrar_inspecciones_maquina', 'idMaquinas = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
		case 'new_file_ing_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"image/jpg",
											"image/jpeg",
											"image/gif",
											"image/png"

											);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'cross_qua_cali_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									if(isset($idAnalisis) && $idAnalisis!=''){          $SIS_data  = "'".$idAnalisis."'";   }else{$SIS_data  = "''";}
									if(isset($idSistema) && $idSistema!=''){            $SIS_data .= ",'".$idSistema."'";   }else{$SIS_data .= ",''";}
									if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",'".$idUsuario."'";   }else{$SIS_data .= ",''";}
									if(isset($fecha_auto) && $fecha_auto!=''){          $SIS_data .= ",'".$fecha_auto."'";  }else{$SIS_data .= ",''";}
									if(isset($Creacion_fecha) && $Creacion_fecha!=''){
										$SIS_data .= ",'".$Creacion_fecha."'";
										$SIS_data .= ",'".fecha2NSemana($Creacion_fecha)."'";
										$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
										$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($idTipo) && $idTipo!=''){                            $SIS_data .= ",'".$idTipo."'";             }else{$SIS_data .= ",''";}
									if(isset($Temporada) && $Temporada!=''){                      $SIS_data .= ",'".$Temporada."'";          }else{$SIS_data .= ",''";}
									if(isset($idCategoria) && $idCategoria!=''){                  $SIS_data .= ",'".$idCategoria."'";        }else{$SIS_data .= ",''";}
									if(isset($idProducto) && $idProducto!=''){                    $SIS_data .= ",'".$idProducto."'";         }else{$SIS_data .= ",''";}
									if(isset($idUbicacion) && $idUbicacion!=''){                  $SIS_data .= ",'".$idUbicacion."'";        }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){      $SIS_data .= ",'".$idUbicacion_lvl_1."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){      $SIS_data .= ",'".$idUbicacion_lvl_2."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){      $SIS_data .= ",'".$idUbicacion_lvl_3."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){      $SIS_data .= ",'".$idUbicacion_lvl_4."'";  }else{$SIS_data .= ",''";}
									if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){      $SIS_data .= ",'".$idUbicacion_lvl_5."'";  }else{$SIS_data .= ",''";}
									$SIS_data .= ",'".$sufijo.$_FILES['exFile']['name']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis, idSistema,
									idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
									Temporada, idCategoria, idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
									idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, Nombre';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_archivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Si ejecuto correctamente la consulta
									if($ultimo_id!=0){
										//redirijo
										header( 'Location: '.$location );
										die;
									}
								}else {
									$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'].' ya existe';
							}
						} else {
							$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_file_ing_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_file']) OR !validaEntero($_GET['del_file']))&&$_GET['del_file']!=''){
				$indice = simpleDecode($_GET['del_file'], fecha_actual());
			}else{
				$indice = $_GET['del_file'];
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
				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Nombre', 'cross_quality_registrar_inspecciones_archivo', '', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'cross_quality_registrar_inspecciones_archivo', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}

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
		case 'new_muestra_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idAnalisis) && $idAnalisis!=''){          $SIS_data  = "'".$idAnalisis."'";         }else{$SIS_data  = "''";}
				if(isset($idProductor) && $idProductor!=''){        $SIS_data .= ",'".$idProductor."'";       }else{$SIS_data .= ",''";}
				if(isset($n_folio_pallet) && $n_folio_pallet!=''){  $SIS_data .= ",'".$n_folio_pallet."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                  $SIS_data .= ",'".$idTipo."'";            }else{$SIS_data .= ",''";}
				if(isset($lote) && $lote!=''){                      $SIS_data .= ",'".$lote."'";              }else{$SIS_data .= ",''";}
				if(isset($f_embalaje) && $f_embalaje!=''){          $SIS_data .= ",'".$f_embalaje."'";        }else{$SIS_data .= ",''";}
				if(isset($f_cosecha) && $f_cosecha!=''){            $SIS_data .= ",'".$f_cosecha."'";         }else{$SIS_data .= ",''";}
				if(isset($H_inspeccion) && $H_inspeccion!=''){      $SIS_data .= ",'".$H_inspeccion."'";      }else{$SIS_data .= ",''";}
				if(isset($cantidad) && $cantidad!=''){              $SIS_data .= ",'".$cantidad."'";          }else{$SIS_data .= ",''";}
				if(isset($peso) && $peso!=''){                      $SIS_data .= ",'".$peso."'";              }else{$SIS_data .= ",''";}
				if(isset($Resolucion_1) && $Resolucion_1!=''){      $SIS_data .= ",'".$Resolucion_1."'";      }else{$SIS_data .= ",''";}
				if(isset($Resolucion_2) && $Resolucion_2!=''){      $SIS_data .= ",'".$Resolucion_2."'";      }else{$SIS_data .= ",''";}
				if(isset($Resolucion_3) && $Resolucion_3!=''){      $SIS_data .= ",'".$Resolucion_3."'";      }else{$SIS_data .= ",''";}

				$zz='';
				for ($i = 1; $i <= 100; $i++) {
					if(isset($Medida[$i])&&$Medida[$i]!= ''){   $SIS_data .= ",'".$Medida[$i]."'";   }else{$SIS_data .= ",''";}
					$zz.=',Medida_'.$i;
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idAnalisis,idProductor, n_folio_pallet, idTipo, lote, f_embalaje, f_cosecha, H_inspeccion, cantidad, peso,Resolucion_1, Resolucion_2, Resolucion_3 '.$zz;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_muestras', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'edit_muestra_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$SIS_data = "idMuestras='".$idMuestras."'";
				if(isset($idAnalisis) && $idAnalisis!=''){          $SIS_data .= ",idAnalisis='".$idAnalisis."'";}
				if(isset($idProductor) && $idProductor!=''){        $SIS_data .= ",idProductor='".$idProductor."'";}
				if(isset($n_folio_pallet) && $n_folio_pallet!=''){  $SIS_data .= ",n_folio_pallet='".$n_folio_pallet."'";}
				if(isset($idTipo) && $idTipo!=''){                  $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($lote) && $lote!=''){                      $SIS_data .= ",lote='".$lote."'";}
				if(isset($f_embalaje) && $f_embalaje!=''){          $SIS_data .= ",f_embalaje='".$f_embalaje."'";}
				if(isset($f_cosecha) && $f_cosecha!=''){            $SIS_data .= ",f_cosecha='".$f_cosecha."'";}
				if(isset($H_inspeccion) && $H_inspeccion!=''){      $SIS_data .= ",H_inspeccion='".$H_inspeccion."'";}
				if(isset($cantidad) && $cantidad!=''){              $SIS_data .= ",cantidad='".$cantidad."'";}
				if(isset($peso) && $peso!=''){                      $SIS_data .= ",peso='".$peso."'";}
				if(isset($Resolucion_1) && $Resolucion_1!=''){      $SIS_data .= ",Resolucion_1='".$Resolucion_1."'";}
				if(isset($Resolucion_2) && $Resolucion_2!=''){      $SIS_data .= ",Resolucion_2='".$Resolucion_2."'";}
				if(isset($Resolucion_3) && $Resolucion_3!=''){      $SIS_data .= ",Resolucion_3='".$Resolucion_3."'";}

				for ($i = 1; $i <= 100; $i++) {
					if(isset($Medida[$i])&&$Medida[$i]!= ''){   $SIS_data .= ",Medida_".$i."='".$Medida[$i]."'";   }
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_quality_registrar_inspecciones_muestras', 'idMuestras = "'.$idMuestras.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_muestra_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_muestra']) OR !validaEntero($_GET['del_muestra']))&&$_GET['del_muestra']!=''){
				$indice = simpleDecode($_GET['del_muestra'], fecha_actual());
			}else{
				$indice = $_GET['del_muestra'];
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
				$resultado = db_delete_data (false, 'cross_quality_registrar_inspecciones_muestras', 'idMuestras = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
		case 'ing_Doc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;
			$n_data3 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['cross_quality_reg_insp_basicos'])){
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) OR $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) OR $_SESSION['cross_quality_reg_insp_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) OR $_SESSION['cross_quality_reg_insp_basicos']['Temporada']=='' ){           $error['Temporada']        = 'error/No ha seleccionado la Temporada';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) OR $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']=='' ){       $error['idCategoria']      = 'error/No ha seleccionado la categoria del producto';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) OR $_SESSION['cross_quality_reg_insp_basicos']['idProducto']=='' ){         $error['idProducto']       = 'error/No ha seleccionado el producto';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) OR $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']=='' ){       $error['idUbicacion']      = 'error/No ha seleccionado la ubicacion';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['Observaciones']) OR $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) OR $_SESSION['cross_quality_reg_insp_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) OR $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) OR $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']=='' ){         $error['fecha_auto']       = 'error/No ha ingresado la fecha de creación';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de datos';
			}

			/******************************************/
			//Se verifican trabajadores
			if (isset($_SESSION['cross_quality_reg_insp_trabajadores'])){
				foreach ($_SESSION['cross_quality_reg_insp_trabajadores'] as $key => $producto){
					$n_data1++;
				}
			}
			if(isset($n_data1)&&$n_data1==0){
				$error['trabajos1'] = 'error/No se han asignado trabajadores';
			}
			/******************************************/
			//Se verifican maquinas
			if (isset($_SESSION['cross_quality_reg_insp_maquinas'])){
				foreach ($_SESSION['cross_quality_reg_insp_maquinas'] as $key => $producto){
					$n_data2++;
				}
			}
			if(isset($n_data2)&&$n_data2==0){
				$error['trabajos2'] = 'error/No se han asignado maquinas';
			}
			/******************************************/
			//Se verifican maquinas
			if (isset($_SESSION['cross_quality_reg_insp_muestras'])){
				foreach ($_SESSION['cross_quality_reg_insp_muestras'] as $key => $producto){
					$n_data3++;
				}
			}
			if(isset($n_data3)&&$n_data3==0){
				$error['trabajos3'] = 'error/No se han asignado muestras';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data  = "'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_quality_reg_insp_basicos']['Observaciones']) && $_SESSION['cross_quality_reg_insp_basicos']['Observaciones']!=''){            $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Observaciones']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto,
				Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo, Temporada, idCategoria,
				idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3,
				idUbicacion_lvl_4, idUbicacion_lvl_5, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de los trabajadores
					if(isset($_SESSION['cross_quality_reg_insp_trabajadores'])){
						foreach ($_SESSION['cross_quality_reg_insp_trabajadores'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idTrabajador']) && $producto['idTrabajador']!=''){                                                                                  $SIS_data .= ",'".$producto['idTrabajador']."'";                                         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idTrabajador';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_trabajador', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guardan los datos de las maquinas
					if(isset($_SESSION['cross_quality_reg_insp_maquinas'])){
						foreach ($_SESSION['cross_quality_reg_insp_maquinas'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idMaquina']) && $producto['idMaquina']!=''){                                                                                        $SIS_data .= ",'".$producto['idMaquina']."'";                                            }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idMaquina';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_maquina', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Se guardan los datos de las muestras
					if(isset($_SESSION['cross_quality_reg_insp_muestras'])){
						foreach ($_SESSION['cross_quality_reg_insp_muestras'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                     $SIS_data  = "'".$ultimo_id."'";                      }else{$SIS_data  = "''";}
							if(isset($producto['idProductor']) && $producto['idProductor']!=''){         $SIS_data .= ",'".$producto['idProductor']."'";       }else{$SIS_data .= ",''";}
							if(isset($producto['n_folio_pallet']) && $producto['n_folio_pallet']!=''){   $SIS_data .= ",'".$producto['n_folio_pallet']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['idTipo']) && $producto['idTipo']!=''){                   $SIS_data .= ",'".$producto['idTipo']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['lote']) && $producto['lote']!=''){                       $SIS_data .= ",'".$producto['lote']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['f_embalaje']) && $producto['f_embalaje']!=''){           $SIS_data .= ",'".$producto['f_embalaje']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['f_cosecha']) && $producto['f_cosecha']!=''){             $SIS_data .= ",'".$producto['f_cosecha']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['H_inspeccion']) && $producto['H_inspeccion']!=''){       $SIS_data .= ",'".$producto['H_inspeccion']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['cantidad']) && $producto['cantidad']!=''){               $SIS_data .= ",'".$producto['cantidad']."'";          }else{$SIS_data .= ",''";}
							if(isset($producto['peso']) && $producto['peso']!=''){                       $SIS_data .= ",'".$producto['peso']."'";              }else{$SIS_data .= ",''";}

							$zz='';
							for ($i = 1; $i <= 100; $i++) {
								if(isset($producto['Medida_'.$i])&&$producto['Medida_'.$i]!= ''){   $SIS_data .= ",'".$producto['Medida_'.$i]."'";   }else{$SIS_data .= ",''";}
								$zz.=',Medida_'.$i;
							}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis,idProductor,n_folio_pallet, idTipo, lote, f_embalaje, f_cosecha, H_inspeccion, cantidad, peso'.$zz;
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_muestras', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['cross_quality_reg_insp_archivos'])){
						foreach ($_SESSION['cross_quality_reg_insp_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                                                  $SIS_data  = "'".$ultimo_id."'";                                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idSistema']) && $_SESSION['cross_quality_reg_insp_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idSistema']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUsuario']) && $_SESSION['cross_quality_reg_insp_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUsuario']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']) && $_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['fecha_auto']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']) && $_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['cross_quality_reg_insp_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idTipo']) && $_SESSION['cross_quality_reg_insp_basicos']['idTipo']!=''){                          $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idTipo']."'";             }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['Temporada']) && $_SESSION['cross_quality_reg_insp_basicos']['Temporada']!=''){                    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['Temporada']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idCategoria']) && $_SESSION['cross_quality_reg_insp_basicos']['idCategoria']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idCategoria']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idProducto']) && $_SESSION['cross_quality_reg_insp_basicos']['idProducto']!=''){                  $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idProducto']."'";         }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']!=''){                $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_1']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_2']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_3']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_4']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']) && $_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']!=''){    $SIS_data .= ",'".$_SESSION['cross_quality_reg_insp_basicos']['idUbicacion_lvl_5']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){                                                                                              $SIS_data .= ",'".$producto['Nombre']."'";                                               }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idAnalisis, idSistema,
							idUsuario, fecha_auto,Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, idTipo,
							Temporada, idCategoria,idProducto, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
							idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_quality_registrar_inspecciones_archivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['cross_quality_reg_insp_basicos']);
					unset($_SESSION['cross_quality_reg_insp_muestras']);
					unset($_SESSION['cross_quality_reg_insp_maquinas']);
					unset($_SESSION['cross_quality_reg_insp_trabajadores']);
					unset($_SESSION['cross_quality_reg_insp_archivos']);
					unset($_SESSION['cross_quality_reg_insp_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
