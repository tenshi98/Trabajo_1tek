<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-242).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idConsolidacion']))        $idConsolidacion         = $_POST['idConsolidacion'];
	if (!empty($_POST['CTNNombreCompañia']))      $CTNNombreCompañia       = $_POST['CTNNombreCompañia'];
	if (!empty($_POST['NInforme']))               $NInforme                = $_POST['NInforme'];
	if (!empty($_POST['Creacion_fecha']))         $Creacion_fecha          = $_POST['Creacion_fecha'];
	if (!empty($_POST['FechaInicioEmbarque']))    $FechaInicioEmbarque     = $_POST['FechaInicioEmbarque'];
	if (!empty($_POST['HoraInicioCarga']))        $HoraInicioCarga         = $_POST['HoraInicioCarga'];
	if (!empty($_POST['FechaTerminoEmbarque']))   $FechaTerminoEmbarque    = $_POST['FechaTerminoEmbarque'];
	if (!empty($_POST['HoraTerminoCarga']))       $HoraTerminoCarga        = $_POST['HoraTerminoCarga'];
	if (!empty($_POST['idPlantaDespacho']))       $idPlantaDespacho        = $_POST['idPlantaDespacho'];
	if (!empty($_POST['idCategoria']))            $idCategoria             = $_POST['idCategoria'];
	if (!empty($_POST['idProducto']))             $idProducto              = $_POST['idProducto'];
	if (!empty($_POST['CantidadCajas']))          $CantidadCajas           = $_POST['CantidadCajas'];
	if (!empty($_POST['idInstructivo']))          $idInstructivo           = $_POST['idInstructivo'];
	if (!empty($_POST['idNaviera']))              $idNaviera               = $_POST['idNaviera'];
	if (!empty($_POST['idPuertoEmbarque']))       $idPuertoEmbarque        = $_POST['idPuertoEmbarque'];
	if (!empty($_POST['idPuertoDestino']))        $idPuertoDestino         = $_POST['idPuertoDestino'];
	if (!empty($_POST['idMercado']))              $idMercado               = $_POST['idMercado'];
	if (!empty($_POST['idPais']))                 $idPais                  = $_POST['idPais'];
	if (!empty($_POST['idRecibidor']))            $idRecibidor             = $_POST['idRecibidor'];
	if (!empty($_POST['idEmpresaTransporte']))    $idEmpresaTransporte     = $_POST['idEmpresaTransporte'];
	if (!empty($_POST['ChoferNombreRut']))        $ChoferNombreRut         = $_POST['ChoferNombreRut'];
	if (!empty($_POST['PatenteCamion']))          $PatenteCamion           = $_POST['PatenteCamion'];
	if (!empty($_POST['PatenteCarro']))           $PatenteCarro            = $_POST['PatenteCarro'];
	if (!empty($_POST['idCondicion']))            $idCondicion             = $_POST['idCondicion'];
	if (!empty($_POST['idSellado']))              $idSellado               = $_POST['idSellado'];
	if (!empty($_POST['TSetPoint']))              $TSetPoint               = $_POST['TSetPoint'];
	if (!empty($_POST['TVentilacion']))           $TVentilacion            = $_POST['TVentilacion'];
	if (!empty($_POST['TAmbiente']))              $TAmbiente               = $_POST['TAmbiente'];
	if (!empty($_POST['NumeroSello']))            $NumeroSello             = $_POST['NumeroSello'];
	if (!empty($_POST['idInspector']))            $idInspector             = $_POST['idInspector'];
	if (!empty($_POST['Observaciones']))          $Observaciones           = $_POST['Observaciones'];
	if (!empty($_POST['idSistema']))              $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))              $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))             $fecha_auto              = $_POST['fecha_auto'];
	if (!empty($_POST['randompass']))             $randompass              = $_POST['randompass'];

	if (!empty($_POST['idEstibaListado']))        $idEstibaListado         = $_POST['idEstibaListado'];
	if (!empty($_POST['idEstiba']))               $idEstiba                = $_POST['idEstiba'];
	if (!empty($_POST['idEstibaUbicacion']))      $idEstibaUbicacion       = $_POST['idEstibaUbicacion'];
	if (!empty($_POST['idPosicion']))             $idPosicion              = $_POST['idPosicion'];
	if (!empty($_POST['idEnvase']))               $idEnvase                = $_POST['idEnvase'];
	if (!empty($_POST['NPallet']))                $NPallet                 = $_POST['NPallet'];
	if (!empty($_POST['Temperatura']))            $Temperatura             = $_POST['Temperatura'];
	if (!empty($_POST['idTermografo']))           $idTermografo            = $_POST['idTermografo'];
	if (!empty($_POST['NSerieSensor']))           $NSerieSensor            = $_POST['NSerieSensor'];

	if (!empty($_POST['idArchivoTipo']))         $idArchivoTipo            = $_POST['idArchivoTipo'];

	if (!empty($_POST['oldidProducto']))         $oldidProducto            = $_POST['oldidProducto'];
	if (!empty($_POST['Observacion']))           $Observacion              = $_POST['Observacion'];
	if (!empty($_POST['Creacion_hora']))         $Creacion_hora            = $_POST['Creacion_hora'];
	if (!empty($_POST['cloneConsolidacion']))    $cloneConsolidacion       = $_POST['cloneConsolidacion'];

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
			case 'idConsolidacion':         if(empty($idConsolidacion)){        $error['idConsolidacion']         = 'error/No ha ingresado el id';}break;
			case 'CTNNombreCompañia':       if(empty($CTNNombreCompañia)){      $error['CTNNombreCompañia']       = 'error/No ha seleccionado';}break;
			case 'NInforme':                if(empty($NInforme)){               $error['NInforme']                = 'error/No ha seleccionado';}break;
			case 'Creacion_fecha':          if(empty($Creacion_fecha)){         $error['Creacion_fecha']          = 'error/No ha seleccionado';}break;
			case 'FechaInicioEmbarque':     if(empty($FechaInicioEmbarque)){    $error['FechaInicioEmbarque']     = 'error/No ha seleccionado';}break;
			case 'HoraInicioCarga':         if(empty($HoraInicioCarga)){        $error['HoraInicioCarga']         = 'error/No ha seleccionado';}break;
			case 'FechaTerminoEmbarque':    if(empty($FechaTerminoEmbarque)){   $error['FechaTerminoEmbarque']    = 'error/No ha seleccionado';}break;
			case 'HoraTerminoCarga':        if(empty($HoraTerminoCarga)){       $error['HoraTerminoCarga']        = 'error/No ha seleccionado';}break;
			case 'idPlantaDespacho':        if(empty($idPlantaDespacho)){       $error['idPlantaDespacho']        = 'error/No ha seleccionado';}break;
			case 'idCategoria':             if(empty($idCategoria)){            $error['idCategoria']             = 'error/No ha seleccionado';}break;
			case 'idProducto':              if(empty($idProducto)){             $error['idProducto']              = 'error/No ha seleccionado';}break;
			case 'CantidadCajas':           if(empty($CantidadCajas)){          $error['CantidadCajas']           = 'error/No ha seleccionado';}break;
			case 'idInstructivo':           if(empty($idInstructivo)){          $error['idInstructivo']           = 'error/No ha seleccionado';}break;
			case 'idNaviera':               if(empty($idNaviera)){              $error['idNaviera']               = 'error/No ha seleccionado';}break;
			case 'idPuertoEmbarque':        if(empty($idPuertoEmbarque)){       $error['idPuertoEmbarque']        = 'error/No ha seleccionado';}break;
			case 'idPuertoDestino':         if(empty($idPuertoDestino)){        $error['idPuertoDestino']         = 'error/No ha seleccionado';}break;
			case 'idMercado':               if(empty($idMercado)){              $error['idMercado']               = 'error/No ha seleccionado';}break;
			case 'idPais':                  if(empty($idPais)){                 $error['idPais']                  = 'error/No ha seleccionado';}break;
			case 'idRecibidor':             if(empty($idRecibidor)){            $error['idRecibidor']             = 'error/No ha seleccionado';}break;
			case 'idEmpresaTransporte':     if(empty($idEmpresaTransporte)){    $error['idEmpresaTransporte']     = 'error/No ha seleccionado';}break;
			case 'ChoferNombreRut':         if(empty($ChoferNombreRut)){        $error['ChoferNombreRut']         = 'error/No ha seleccionado';}break;
			case 'PatenteCamion':           if(empty($PatenteCamion)){          $error['PatenteCamion']           = 'error/No ha seleccionado';}break;
			case 'PatenteCarro':            if(empty($PatenteCarro)){           $error['PatenteCarro']            = 'error/No ha seleccionado';}break;
			case 'idCondicion':             if(empty($idCondicion)){            $error['idCondicion']             = 'error/No ha seleccionado';}break;
			case 'idSellado':               if(empty($idSellado)){              $error['idSellado']               = 'error/No ha seleccionado';}break;
			case 'TSetPoint':               if(empty($TSetPoint)){              $error['TSetPoint']               = 'error/No ha seleccionado';}break;
			case 'TVentilacion':            if(empty($TVentilacion)){           $error['TVentilacion']            = 'error/No ha seleccionado';}break;
			case 'TAmbiente':               if(empty($TAmbiente)){              $error['TAmbiente']               = 'error/No ha seleccionado';}break;
			case 'NumeroSello':             if(empty($NumeroSello)){            $error['NumeroSello']             = 'error/No ha seleccionado';}break;
			case 'idInspector':             if(empty($idInspector)){            $error['idInspector']             = 'error/No ha seleccionado';}break;
			case 'Observaciones':           if(empty($Observaciones)){          $error['Observaciones']           = 'error/No ha seleccionado';}break;
			case 'idSistema':               if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado';}break;
			case 'idUsuario':               if(empty($idUsuario)){              $error['idUsuario']               = 'error/No ha seleccionado';}break;
			case 'fecha_auto':              if(empty($fecha_auto)){             $error['fecha_auto']              = 'error/No ha seleccionado';}break;
			case 'randompass':              if(empty($randompass)){             $error['randompass']              = 'error/No ha seleccionado';}break;

			case 'idEstibaListado':         if(empty($idEstibaListado)){        $error['idEstibaListado']         = 'error/No ha seleccionado';}break;
			case 'idEstiba':                if(empty($idEstiba)){               $error['idEstiba']                = 'error/No ha seleccionado';}break;
			case 'idEstibaUbicacion':       if(empty($idEstibaUbicacion)){      $error['idEstibaUbicacion']       = 'error/No ha seleccionado';}break;
			case 'idPosicion':              if(empty($idPosicion)){             $error['idPosicion']              = 'error/No ha seleccionado';}break;
			case 'idEnvase':                if(empty($idEnvase)){               $error['idEnvase']                = 'error/No ha seleccionado';}break;
			case 'NPallet':                 if(empty($NPallet)){                $error['NPallet']                 = 'error/No ha seleccionado';}break;
			case 'Temperatura':             if(empty($Temperatura)){            $error['Temperatura']             = 'error/No ha seleccionado';}break;
			case 'idTermografo':            if(empty($idTermografo)){           $error['idTermografo']            = 'error/No ha seleccionado';}break;
			case 'NSerieSensor':            if(empty($NSerieSensor)){           $error['NSerieSensor']            = 'error/No ha seleccionado';}break;

			case 'idArchivoTipo':           if(empty($idArchivoTipo)){          $error['idArchivoTipo']           = 'error/No ha seleccionado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($CTNNombreCompañia) && $CTNNombreCompañia!=''){ $CTNNombreCompañia = EstandarizarInput($CTNNombreCompañia);}
	if(isset($ChoferNombreRut) && $ChoferNombreRut!=''){     $ChoferNombreRut   = EstandarizarInput($ChoferNombreRut);}
	if(isset($PatenteCamion) && $PatenteCamion!=''){         $PatenteCamion     = EstandarizarInput($PatenteCamion);}
	if(isset($PatenteCarro) && $PatenteCarro!=''){           $PatenteCarro      = EstandarizarInput($PatenteCarro);}
	if(isset($Observaciones) && $Observaciones!=''){         $Observaciones     = EstandarizarInput($Observaciones);}
	if(isset($NPallet) && $NPallet!=''){                     $NPallet           = EstandarizarInput($NPallet);}
	if(isset($NSerieSensor) && $NSerieSensor!=''){           $NSerieSensor      = EstandarizarInput($NSerieSensor);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($CTNNombreCompañia)&&contar_palabras_censuradas($CTNNombreCompañia)!=0){  $error['CTNNombreCompañia'] = 'error/Edita CTN Nombre Compañia, contiene palabras no permitidas';}
	if(isset($ChoferNombreRut)&&contar_palabras_censuradas($ChoferNombreRut)!=0){      $error['ChoferNombreRut']   = 'error/Edita Chofer Nombre Rut, contiene palabras no permitidas';}
	if(isset($PatenteCamion)&&contar_palabras_censuradas($PatenteCamion)!=0){          $error['PatenteCamion']     = 'error/Edita Patente Camion, contiene palabras no permitidas';}
	if(isset($PatenteCarro)&&contar_palabras_censuradas($PatenteCarro)!=0){            $error['PatenteCarro']      = 'error/Edita Patente Carro, contiene palabras no permitidas';}
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){          $error['Observaciones']     = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($NPallet)&&contar_palabras_censuradas($NPallet)!=0){                      $error['NPallet']           = 'error/Edita N Pallet, contiene palabras no permitidas';}
	if(isset($NSerieSensor)&&contar_palabras_censuradas($NSerieSensor)!=0){            $error['NSerieSensor']      = 'error/Edita N Serie Sensor, contiene palabras no permitidas';}

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

				/************************************************************/
				// Se trae la categoria del producto
				if(isset($idCategoria)&&$idCategoria!=''){
					$rowCategoria = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = "'.$idCategoria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				// Se trae la información del producto
				if(isset($idProducto)&&$idProducto!=''){
					$rowProd = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Condición CTN
				if(isset($idCondicion)&&$idCondicion!=''){
					$rowCondicionCTN = db_select_data (false, 'Nombre', 'core_cross_shipping_consolidacion_condicion', '', 'idCondicion = "'.$idCondicion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Sellado Piso
				if(isset($idSellado)&&$idSellado!=''){
					$rowSellado = db_select_data (false, 'Nombre', 'core_sistemas_opciones', '', 'idOpciones = "'.$idSellado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Inspector
				if(isset($idInspector)&&$idInspector!=''){
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = "'.$idInspector.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Planta Despacho
				if(isset($idPlantaDespacho)&&$idPlantaDespacho!=''){
					$rowPlantaDespacho = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_plantas', '', 'idPlantaDespacho = "'.$idPlantaDespacho.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Instructivo
				if(isset($idInstructivo)&&$idInstructivo!=''){
					$rowInstructivo = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_instructivo', '', 'idInstructivo = "'.$idInstructivo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Naviera
				if(isset($idNaviera)&&$idNaviera!=''){
					$rowNaviera = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_naviera', '', 'idNaviera = "'.$idNaviera.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//PuertoEmbarque
				if(isset($idPuertoEmbarque)&&$idPuertoEmbarque!=''){
					$rowPuertoEmbarque = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_puerto_embarque', '', 'idPuertoEmbarque = "'.$idPuertoEmbarque.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Mercado
				if(isset($idMercado)&&$idMercado!=''){
					$rowMercado = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_mercado', '', 'idMercado = "'.$idMercado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Pais
				if(isset($idPais)&&$idPais!=''){
					$rowPais = db_select_data (false, 'Nombre', 'core_paises', '', 'idPais = "'.$idPais.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//EmpresaTransporte
				if(isset($idEmpresaTransporte)&&$idEmpresaTransporte!=''){
					$rowEmpresaTransporte = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_empresa_transporte', '', 'idEmpresaTransporte = "'.$idEmpresaTransporte.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//PuertoDestino
				if(isset($idPuertoDestino)&&$idPuertoDestino!=''){
					$rowPuertoDestino = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_puerto_destino', '', 'idPuertoDestino = "'.$idPuertoDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Recibidor
				if(isset($idRecibidor)&&$idRecibidor!=''){
					$rowRecibidor = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_recibidores', '', 'idRecibidor = "'.$idRecibidor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/************************************************************/
				//Borro todas las sesiones
				unset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass])){
					foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$randompass] as $key => $productos){
						foreach ($productos as $producto) {
							if(isset($producto['idFile'])&&$producto['idFile']!=0){
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
					}
				}
				unset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass]);

				/************************************************************/
				//Datos desde las consultas
				if(isset($rowProd['Nombre'])&&$rowProd['Nombre']!=''){                           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra']        = $rowCategoria['Nombre'].' '.$rowProd['Nombre'];                        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra']        = 'Sin Datos';}
				if(isset($rowPlantaDespacho['Nombre'])&&$rowPlantaDespacho['Nombre']!=''){       $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PlantaDespacho']     = $rowPlantaDespacho['Codigo'].' - '.$rowPlantaDespacho['Nombre'];       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PlantaDespacho']     = 'Sin Datos';}
				if(isset($rowInstructivo['Nombre'])&&$rowInstructivo['Nombre']!=''){             $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Instructivo']        = $rowInstructivo['Codigo'].' - '.$rowInstructivo['Nombre'];             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Instructivo']        = 'Sin Datos';}
				if(isset($rowNaviera['Nombre'])&&$rowNaviera['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Naviera']            = $rowNaviera['Codigo'].' - '.$rowNaviera['Nombre'];                     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Naviera']            = 'Sin Datos';}
				if(isset($rowPuertoEmbarque['Nombre'])&&$rowPuertoEmbarque['Nombre']!=''){       $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoEmbarque']     = $rowPuertoEmbarque['Codigo'].' - '.$rowPuertoEmbarque['Nombre'];       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoEmbarque']     = 'Sin Datos';}
				if(isset($rowPuertoDestino['Nombre'])&&$rowPuertoDestino['Nombre']!=''){         $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoDestino']      = $rowPuertoDestino['Codigo'].' - '.$rowPuertoDestino['Nombre'];         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoDestino']      = 'Sin Datos';}
				if(isset($rowMercado['Nombre'])&&$rowMercado['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Mercado']            = $rowMercado['Codigo'].' - '.$rowMercado['Nombre'];                     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Mercado']            = 'Sin Datos';}
				if(isset($rowPais['Nombre'])&&$rowPais['Nombre']!=''){                           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Pais']               = $rowPais['Nombre'];                                                    }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Pais']               = 'Sin Datos';}
				if(isset($rowRecibidor['Nombre'])&&$rowRecibidor['Nombre']!=''){                 $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Recibidor']          = $rowRecibidor['Codigo'].' - '.$rowRecibidor['Nombre'];                 }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Recibidor']          = 'Sin Datos';}
				if(isset($rowEmpresaTransporte['Nombre'])&&$rowEmpresaTransporte['Nombre']!=''){ $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['EmpresaTransporte']  = $rowEmpresaTransporte['Codigo'].' - '.$rowEmpresaTransporte['Nombre']; }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['EmpresaTransporte']  = 'Sin Datos';}
				if(isset($rowCondicionCTN['Nombre'])&&$rowCondicionCTN['Nombre']!=''){           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CondicionCTN']       = $rowCondicionCTN['Nombre'];                                            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CondicionCTN']       = 'Sin Datos';}
				if(isset($rowSellado['Nombre'])&&$rowSellado['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Sellado']            = $rowSellado['Nombre'];                                                 }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Sellado']            = 'Sin Datos';}
				if(isset($rowTrabajador['Nombre'])&&$rowTrabajador['Nombre']!=''){               $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Trabajador']         = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'];            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Trabajador']         = 'Sin Datos';}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($randompass)&&$randompass!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['randompass']            = $randompass; }
				if(isset($CTNNombreCompañia)&&$CTNNombreCompañia!=''){        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']     = $CTNNombreCompañia;       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']     = 'Sin Datos';}
				if(isset($NInforme)&&$NInforme!=''){                          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']              = $NInforme;                }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']              = 'Sin Datos';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){              $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']        = $Creacion_fecha;          }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']        = '0000-00-00';}
				if(isset($FechaInicioEmbarque)&&$FechaInicioEmbarque!=''){    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']   = $FechaInicioEmbarque;     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']   = '0000-00-00';}
				if(isset($HoraInicioCarga)&&$HoraInicioCarga!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']       = $HoraInicioCarga;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']       = 'Sin Datos';}
				if(isset($FechaTerminoEmbarque)&&$FechaTerminoEmbarque!=''){  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']  = $FechaTerminoEmbarque;    }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']  = '0000-00-00';}
				if(isset($HoraTerminoCarga)&&$HoraTerminoCarga!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']      = $HoraTerminoCarga;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']      = 'Sin Datos';}
				if(isset($idPlantaDespacho)&&$idPlantaDespacho!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']      = $idPlantaDespacho;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']      = 'Sin Datos';}
				if(isset($idCategoria)&&$idCategoria!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']           = $idCategoria;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']           = 'Sin Datos';}
				if(isset($idProducto)&&$idProducto!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']            = $idProducto;              }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']            = 'Sin Datos';}
				if(isset($CantidadCajas)&&$CantidadCajas!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']         = $CantidadCajas;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']         = 'Sin Datos';}
				if(isset($idInstructivo)&&$idInstructivo!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']         = $idInstructivo;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']         = 'Sin Datos';}
				if(isset($idNaviera)&&$idNaviera!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']             = $idNaviera;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']             = 'Sin Datos';}
				if(isset($idPuertoEmbarque)&&$idPuertoEmbarque!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']      = $idPuertoEmbarque;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']      = 'Sin Datos';}
				if(isset($idPuertoDestino)&&$idPuertoDestino!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']       = $idPuertoDestino;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']       = 'Sin Datos';}
				if(isset($idMercado)&&$idMercado!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']             = $idMercado;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']             = 'Sin Datos';}
				if(isset($idPais)&&$idPais!=''){                              $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']                = $idPais;                  }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']                = 'Sin Datos';}
				if(isset($idRecibidor)&&$idRecibidor!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']           = $idRecibidor;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']           = 'Sin Datos';}
				if(isset($idEmpresaTransporte)&&$idEmpresaTransporte!=''){    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']   = $idEmpresaTransporte;     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']   = 'Sin Datos';}
				if(isset($ChoferNombreRut)&&$ChoferNombreRut!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']       = $ChoferNombreRut;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']       = 'Sin Datos';}
				if(isset($PatenteCamion)&&$PatenteCamion!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']         = $PatenteCamion;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']         = 'Sin Datos';}
				if(isset($PatenteCarro)&&$PatenteCarro!=''){                  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']          = $PatenteCarro;            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']          = 'Sin Datos';}
				if(isset($idCondicion)&&$idCondicion!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']           = $idCondicion;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']           = 'Sin Datos';}
				if(isset($idSellado)&&$idSellado!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']             = $idSellado;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']             = 'Sin Datos';}
				if(isset($TSetPoint)&&$TSetPoint!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']             = $TSetPoint;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']             = 'Sin Datos';}
				if(isset($TVentilacion)&&$TVentilacion!=''){                  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']          = $TVentilacion;            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']          = 'Sin Datos';}
				if(isset($TAmbiente)&&$TAmbiente!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']             = $TAmbiente;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']             = 'Sin Datos';}
				if(isset($NumeroSello)&&$NumeroSello!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']           = $NumeroSello;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']           = 'Sin Datos';}
				if(isset($idInspector)&&$idInspector!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']           = $idInspector;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']           = 'Sin Datos';}
				if(isset($Observaciones)&&$Observaciones!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']         = $Observaciones;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']         = 'Sin Datos';}
				if(isset($idSistema)&&$idSistema!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']             = $idSistema;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']             = 'Sin Datos';}
				if(isset($idUsuario)&&$idUsuario!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']             = $idUsuario;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']             = 'Sin Datos';}
				if(isset($fecha_auto)&&$fecha_auto!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']            = $fecha_auto;              }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']            = 'Sin Datos';}

				header( 'Location: '.$location.'&view='.$randompass );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//variable
			$randompass = $_GET['clear_all'];

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]);
			unset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass]);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass])){
				foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$randompass] as $key => $productos){
					foreach ($productos as $producto) {
						if(isset($producto['idFile'])&&$producto['idFile']!=0){
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
				}
			}
			unset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass]);

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

				//Borro todas las sesiones
				unset($_SESSION['cross_shipping_consolidacion_temporal'][$randompass]);
				//Borro todas las sesiones
				unset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]);

				/************************************************************/
				// Se trae la categoria del producto
				if(isset($idCategoria)&&$idCategoria!=''){
					$rowCategoria = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = "'.$idCategoria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				// Se trae la información del producto
				if(isset($idProducto)&&$idProducto!=''){
					$rowProd = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Condición CTN
				if(isset($idCondicion)&&$idCondicion!=''){
					$rowCondicionCTN = db_select_data (false, 'Nombre', 'core_cross_shipping_consolidacion_condicion', '', 'idCondicion = "'.$idCondicion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Sellado Piso
				if(isset($idSellado)&&$idSellado!=''){
					$rowSellado = db_select_data (false, 'Nombre', 'core_sistemas_opciones', '', 'idOpciones = "'.$idSellado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Inspector
				if(isset($idInspector)&&$idInspector!=''){
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Planta Despacho
				if(isset($idPlantaDespacho)&&$idPlantaDespacho!=''){
					$rowPlantaDespacho = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_plantas', '', 'idPlantaDespacho = "'.$idPlantaDespacho.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Instructivo
				if(isset($idInstructivo)&&$idInstructivo!=''){
					$rowInstructivo = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_instructivo', '', 'idInstructivo = "'.$idInstructivo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Naviera
				if(isset($idNaviera)&&$idNaviera!=''){
					$rowNaviera = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_naviera', '', 'idNaviera = "'.$idNaviera.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//PuertoEmbarque
				if(isset($idPuertoEmbarque)&&$idPuertoEmbarque!=''){
					$rowPuertoEmbarque = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_puerto_embarque', '', 'idPuertoEmbarque = "'.$idPuertoEmbarque.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Mercado
				if(isset($idMercado)&&$idMercado!=''){
					$rowMercado = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_mercado', '', 'idMercado = "'.$idMercado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Pais
				if(isset($idPais)&&$idPais!=''){
					$rowPais = db_select_data (false, 'Nombre', 'core_paises', '', 'idPais = "'.$idPais.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//EmpresaTransporte
				if(isset($idEmpresaTransporte)&&$idEmpresaTransporte!=''){
					$rowEmpresaTransporte = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_empresa_transporte', '', 'idEmpresaTransporte = "'.$idEmpresaTransporte.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//PuertoDestino
				if(isset($idPuertoDestino)&&$idPuertoDestino!=''){
					$rowPuertoDestino = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_puerto_destino', '', 'idPuertoDestino = "'.$idPuertoDestino.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/************************************************************/
				//Recibidor
				if(isset($idRecibidor)&&$idRecibidor!=''){
					$rowRecibidor = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_recibidores', '', 'idRecibidor = "'.$idRecibidor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/************************************************************/
				//Datos desde las consultas
				if(isset($rowProd['Nombre'])&&$rowProd['Nombre']!=''){                           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra']        = $rowCategoria['Nombre'].' '.$rowProd['Nombre'];                        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra']        = 'Sin Datos';}
				if(isset($rowPlantaDespacho['Nombre'])&&$rowPlantaDespacho['Nombre']!=''){       $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PlantaDespacho']     = $rowPlantaDespacho['Codigo'].' - '.$rowPlantaDespacho['Nombre'];       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PlantaDespacho']     = 'Sin Datos';}
				if(isset($rowInstructivo['Nombre'])&&$rowInstructivo['Nombre']!=''){             $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Instructivo']        = $rowInstructivo['Codigo'].' - '.$rowInstructivo['Nombre'];             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Instructivo']        = 'Sin Datos';}
				if(isset($rowNaviera['Nombre'])&&$rowNaviera['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Naviera']            = $rowNaviera['Codigo'].' - '.$rowNaviera['Nombre'];                     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Naviera']            = 'Sin Datos';}
				if(isset($rowPuertoEmbarque['Nombre'])&&$rowPuertoEmbarque['Nombre']!=''){       $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoEmbarque']     = $rowPuertoEmbarque['Codigo'].' - '.$rowPuertoEmbarque['Nombre'];       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoEmbarque']     = 'Sin Datos';}
				if(isset($rowPuertoDestino['Nombre'])&&$rowPuertoDestino['Nombre']!=''){         $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoDestino']      = $rowPuertoDestino['Codigo'].' - '.$rowPuertoDestino['Nombre'];         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PuertoDestino']      = 'Sin Datos';}
				if(isset($rowMercado['Nombre'])&&$rowMercado['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Mercado']            = $rowMercado['Codigo'].' - '.$rowMercado['Nombre'];                     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Mercado']            = 'Sin Datos';}
				if(isset($rowPais['Nombre'])&&$rowPais['Nombre']!=''){                           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Pais']               = $rowPais['Nombre'];                                                    }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Pais']               = 'Sin Datos';}
				if(isset($rowRecibidor['Nombre'])&&$rowRecibidor['Nombre']!=''){                 $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Recibidor']          = $rowRecibidor['Codigo'].' - '.$rowRecibidor['Nombre'];                 }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Recibidor']          = 'Sin Datos';}
				if(isset($rowEmpresaTransporte['Nombre'])&&$rowEmpresaTransporte['Nombre']!=''){ $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['EmpresaTransporte']  = $rowEmpresaTransporte['Codigo'].' - '.$rowEmpresaTransporte['Nombre']; }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['EmpresaTransporte']  = 'Sin Datos';}
				if(isset($rowCondicionCTN['Nombre'])&&$rowCondicionCTN['Nombre']!=''){           $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CondicionCTN']       = $rowCondicionCTN['Nombre'];                                            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CondicionCTN']       = 'Sin Datos';}
				if(isset($rowSellado['Nombre'])&&$rowSellado['Nombre']!=''){                     $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Sellado']            = $rowSellado['Nombre'];                                                 }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Sellado']            = 'Sin Datos';}
				if(isset($rowTrabajador['Nombre'])&&$rowTrabajador['Nombre']!=''){               $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Trabajador']         = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'];            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Trabajador']         = 'Sin Datos';}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($randompass)&&$randompass!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['randompass']            = $randompass; }
				if(isset($CTNNombreCompañia)&&$CTNNombreCompañia!=''){        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']     = $CTNNombreCompañia;       }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']     = 'Sin Datos';}
				if(isset($NInforme)&&$NInforme!=''){                          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']              = $NInforme;                }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']              = 'Sin Datos';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){              $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']        = $Creacion_fecha;          }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']        = '0000-00-00';}
				if(isset($FechaInicioEmbarque)&&$FechaInicioEmbarque!=''){    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']   = $FechaInicioEmbarque;     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']   = '0000-00-00';}
				if(isset($HoraInicioCarga)&&$HoraInicioCarga!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']       = $HoraInicioCarga;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']       = 'Sin Datos';}
				if(isset($FechaTerminoEmbarque)&&$FechaTerminoEmbarque!=''){  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']  = $FechaTerminoEmbarque;    }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']  = '0000-00-00';}
				if(isset($HoraTerminoCarga)&&$HoraTerminoCarga!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']      = $HoraTerminoCarga;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']      = 'Sin Datos';}
				if(isset($idPlantaDespacho)&&$idPlantaDespacho!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']      = $idPlantaDespacho;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']      = 'Sin Datos';}
				if(isset($idCategoria)&&$idCategoria!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']           = $idCategoria;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']           = 'Sin Datos';}
				if(isset($idProducto)&&$idProducto!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']            = $idProducto;              }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']            = 'Sin Datos';}
				if(isset($CantidadCajas)&&$CantidadCajas!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']         = $CantidadCajas;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']         = 'Sin Datos';}
				if(isset($idInstructivo)&&$idInstructivo!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']         = $idInstructivo;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']         = 'Sin Datos';}
				if(isset($idNaviera)&&$idNaviera!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']             = $idNaviera;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']             = 'Sin Datos';}
				if(isset($idPuertoEmbarque)&&$idPuertoEmbarque!=''){          $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']      = $idPuertoEmbarque;        }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']      = 'Sin Datos';}
				if(isset($idPuertoDestino)&&$idPuertoDestino!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']       = $idPuertoDestino;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']       = 'Sin Datos';}
				if(isset($idMercado)&&$idMercado!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']             = $idMercado;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']             = 'Sin Datos';}
				if(isset($idPais)&&$idPais!=''){                              $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']                = $idPais;                  }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']                = 'Sin Datos';}
				if(isset($idRecibidor)&&$idRecibidor!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']           = $idRecibidor;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']           = 'Sin Datos';}
				if(isset($idEmpresaTransporte)&&$idEmpresaTransporte!=''){    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']   = $idEmpresaTransporte;     }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']   = 'Sin Datos';}
				if(isset($ChoferNombreRut)&&$ChoferNombreRut!=''){            $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']       = $ChoferNombreRut;         }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']       = 'Sin Datos';}
				if(isset($PatenteCamion)&&$PatenteCamion!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']         = $PatenteCamion;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']         = 'Sin Datos';}
				if(isset($PatenteCarro)&&$PatenteCarro!=''){                  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']          = $PatenteCarro;            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']          = 'Sin Datos';}
				if(isset($idCondicion)&&$idCondicion!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']           = $idCondicion;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']           = 'Sin Datos';}
				if(isset($idSellado)&&$idSellado!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']             = $idSellado;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']             = 'Sin Datos';}
				if(isset($TSetPoint)&&$TSetPoint!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']             = $TSetPoint;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']             = 'Sin Datos';}
				if(isset($TVentilacion)&&$TVentilacion!=''){                  $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']          = $TVentilacion;            }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']          = 'Sin Datos';}
				if(isset($TAmbiente)&&$TAmbiente!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']             = $TAmbiente;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']             = 'Sin Datos';}
				if(isset($NumeroSello)&&$NumeroSello!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']           = $NumeroSello;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']           = 'Sin Datos';}
				if(isset($idInspector)&&$idInspector!=''){                    $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']           = $idInspector;             }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']           = 'Sin Datos';}
				if(isset($Observaciones)&&$Observaciones!=''){                $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']         = $Observaciones;           }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']         = 'Sin Datos';}
				if(isset($idSistema)&&$idSistema!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']             = $idSistema;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']             = 'Sin Datos';}
				if(isset($idUsuario)&&$idUsuario!=''){                        $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']             = $idUsuario;               }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']             = 'Sin Datos';}
				if(isset($fecha_auto)&&$fecha_auto!=''){                      $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']            = $fecha_auto;              }else{$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']            = 'Sin Datos';}

				header( 'Location: '.$location.'&view='.$randompass );
				die;
			}

		break;

/*******************************************************************************************************************/
		case 'add_obs_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$Observacion      = $_GET['val_select'];

			//valido que no esten vacios
			if(empty($Observacion)){  $error['Observacion']  = 'error/No ha ingresado una observacion';}

			if(empty($error)){
				//Datos a actualizar
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones'] = $Observacion;

				header( 'Location: '.$location.'&view='.$randompass.'#Ancla_obs' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_obs_ing':

			//variable
			$randompass = $_GET['view'];

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$_SESSION['cross_shipping_consolidacion_temporal'][$randompass] = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones'];
			$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones'] = '';

			header( 'Location: '.$location.'&view='.$randompass.'#Ancla_obs' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo])){
				foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo] as $key => $trabajos){
					if(isset($trabajos['idFile'])&&$trabajos['idFile']!=''){
						if($idInterno<$trabajos['idFile']){$idInterno = $trabajos['idFile'];}
					}
				}
			}

			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'cross_ship_conso_'.$CTNNombreCompañia.'_'.fecha_actual().'_'.$idArchivoTipo.'_';
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

			//Verifico errores en los archivos
			foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["exFile"]["error"][$key] > 0){
					$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
				}
				if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
					}
				} else {
					$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

			if(empty($error)){

				/***************************************************/
				// Se trae el tipo de archivo
				$rowTipoArchivo = db_select_data (false, 'Nombre', 'core_cross_shipping_archivos_tipos', '', 'idArchivoTipo = "'.$idArchivoTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Verifico errores en los archivos
				foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["exFile"]["error"][$key] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
					}
					if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"][$key], $ruta);
							if ($move_result){

								//se guarda en el indice siguiente
								$idInterno++;
								//Se guarda el trabajo asignado
								$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$idInterno]['idFile']         = $idInterno;
								$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$idInterno]['Nombre']         = $sufijo.$_FILES['exFile']['name'][$key];
								$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$idInterno]['idArchivoTipo']  = $idArchivoTipo;
								$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo]['ArchivoTipo']                = $rowTipoArchivo['Nombre'];
								$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo]['idArchivoTipo']              = $idArchivoTipo;

							} else {
								$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
							}
						}else{
							$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
						}
					} else {
						$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}

				header( 'Location: '.$location.'&view='.$randompass );
				die;

			}

		break;

/*******************************************************************************************************************/
		case 'del_file_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$randompass     = $_GET['view'];
			$idArchivoTipo  = $_GET['idArchivoTipo'];

			try {
				if(!is_writable('upload/'.$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$_GET['del_file']]['Nombre']);
					unset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass][$idArchivoTipo][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view='.$randompass );
			die;


		break;
/*******************************************************************************************************************/
		case 'new_estiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass])){
				foreach ($_SESSION['cross_shipping_consolidacion_estibas'][$randompass] as $key => $trabajos){
					if($idInterno<$trabajos['idInterno']){$idInterno = $trabajos['idInterno'];}
					if($trabajos['idEstibaUbicacion']==$idEstibaUbicacion){
						$error['idEstibaUbicacion'] = 'error/La ubicacion ya esta siendo utilizada';
					}
				}
			}

			if(empty($error)){

				/*************************************/
				// tomo los datos de la Estiba
				if(isset($idEstiba)&&$idEstiba!=''){
					$rowEstiba = db_select_data (false, 'Nombre', 'core_estibas', '', 'idEstiba = "'.$idEstiba.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de la Estiba Ubicación
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){
					$rowEstibaUbicacion = db_select_data (false, 'Nombre', 'core_estibas_ubicacion', '', 'idEstibaUbicacion = "'.$idEstibaUbicacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de la posicion
				if(isset($idPosicion)&&$idPosicion!=''){
					$rowPosicion = db_select_data (false, 'Nombre', 'core_cross_shipping_consolidacion_posicion', '', 'idPosicion = "'.$idPosicion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de Envase
				if(isset($idEnvase)&&$idEnvase!=''){
					$rowEnvase = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_envase', '', 'idEnvase = "'.$idEnvase.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de Termografo
				if(isset($idTermografo)&&$idTermografo!=''){
					$rowTermografo = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_termografo', '', 'idTermografo = "'.$idTermografo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				$idInterno = $idInterno+1;
				if(isset($idInterno)&&$idInterno!=''){                  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idInterno']           = $idInterno;          }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idInterno']          = '';}
				if(isset($idEstiba)&&$idEstiba!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEstiba']            = $idEstiba;           }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEstiba']           = '';}
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEstibaUbicacion']   = $idEstibaUbicacion;  }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEstibaUbicacion']  = '';}
				if(isset($idPosicion)&&$idPosicion!=''){                $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idPosicion']          = $idPosicion;         }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idPosicion']         = '';}
				if(isset($idEnvase)&&$idEnvase!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEnvase']            = $idEnvase;           }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idEnvase']           = '';}
				if(isset($NPallet)&&$NPallet!=''){                      $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['NPallet']             = $NPallet;            }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['NPallet']            = '';}
				if(isset($Temperatura)&&$Temperatura!=''){              $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Temperatura']         = $Temperatura;        }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Temperatura']        = '';}
				if(isset($idTermografo)&&$idTermografo!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idTermografo']        = $idTermografo;       }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['idTermografo']       = '';}
				if(isset($NSerieSensor)&&$NSerieSensor!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['NSerieSensor']        = $NSerieSensor;       }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['NSerieSensor']       = '';}

				if(isset($idEstiba)&&$idEstiba!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Estiba']              = $rowEstiba['Nombre'];                                     }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Estiba']           = '';}
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['EstibaUbicacion']     = $rowEstibaUbicacion['Nombre'];                            }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['EstibaUbicacion']  = '';}
				if(isset($idPosicion)&&$idPosicion!=''){                $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Posicion']            = $rowPosicion['Nombre'];                                   }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Posicion']         = '';}
				if(isset($idEnvase)&&$idEnvase!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Envase']              = $rowEnvase['Codigo'].' - '.$rowEnvase['Nombre'];          }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Envase']           = '';}
				if(isset($idTermografo)&&$idTermografo!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Termografo']          = $rowTermografo['Codigo'].' - '.$rowTermografo['Nombre'];  }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$idInterno]['Termografo']       = '';}

				//redirijo
				header( 'Location: '.$location.'&view='.$randompass );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_estiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar la cantidad de trabajos
			if(isset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass])){
				foreach ($_SESSION['cross_shipping_consolidacion_estibas'][$randompass] as $key => $trabajos){
					if($trabajos['idEstibaUbicacion']==$idEstibaUbicacion&&$oldidProducto!=$trabajos['idInterno']){
						$error['idEstibaUbicacion'] = 'error/La ubicacion ya esta siendo utilizada';
					}
				}
			}

			if(empty($error)){

				/*************************************/
				// tomo los datos de la Estiba
				if(isset($idEstiba)&&$idEstiba!=''){
					$rowEstiba = db_select_data (false, 'Nombre', 'core_estibas', '', 'idEstiba = "'.$idEstiba.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de la Estiba Ubicación
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){
					$rowEstibaUbicacion = db_select_data (false, 'Nombre', 'core_estibas_ubicacion', '', 'idEstibaUbicacion = "'.$idEstibaUbicacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de la posicion
				if(isset($idPosicion)&&$idPosicion!=''){
					$rowPosicion = db_select_data (false, 'Nombre', 'core_cross_shipping_consolidacion_posicion', '', 'idPosicion = "'.$idPosicion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de Envase
				if(isset($idEnvase)&&$idEnvase!=''){
					$rowEnvase = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_envase', '', 'idEnvase = "'.$idEnvase.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				/*************************************/
				// tomo los datos de Termografo
				if(isset($idTermografo)&&$idTermografo!=''){
					$rowTermografo = db_select_data (false, 'Codigo, Nombre', 'cross_shipping_termografo', '', 'idTermografo = "'.$idTermografo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				//if(isset($idInterno)&&$idInterno!=''){                  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idInterno']           = $oldidProducto;      }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idInterno']          = '';}
				if(isset($idEstiba)&&$idEstiba!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEstiba']            = $idEstiba;           }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEstiba']           = '';}
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEstibaUbicacion']   = $idEstibaUbicacion;  }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEstibaUbicacion']  = '';}
				if(isset($idPosicion)&&$idPosicion!=''){                $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idPosicion']          = $idPosicion;         }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idPosicion']         = '';}
				if(isset($idEnvase)&&$idEnvase!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEnvase']            = $idEnvase;           }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idEnvase']           = '';}
				if(isset($NPallet)&&$NPallet!=''){                      $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['NPallet']             = $NPallet;            }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['NPallet']            = '';}
				if(isset($Temperatura)&&$Temperatura!=''){              $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Temperatura']         = $Temperatura;        }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Temperatura']        = '';}
				if(isset($idTermografo)&&$idTermografo!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idTermografo']        = $idTermografo;       }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['idTermografo']       = '';}
				if(isset($NSerieSensor)&&$NSerieSensor!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['NSerieSensor']        = $NSerieSensor;       }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['NSerieSensor']       = '';}

				if(isset($idEstiba)&&$idEstiba!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Estiba']              = $rowEstiba['Nombre'];                                     }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Estiba']           = '';}
				if(isset($idEstibaUbicacion)&&$idEstibaUbicacion!=''){  $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['EstibaUbicacion']     = $rowEstibaUbicacion['Nombre'];                            }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['EstibaUbicacion']  = '';}
				if(isset($idPosicion)&&$idPosicion!=''){                $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Posicion']            = $rowPosicion['Nombre'];                                   }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Posicion']         = '';}
				if(isset($idEnvase)&&$idEnvase!=''){                    $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Envase']              = $rowEnvase['Codigo'].' - '.$rowEnvase['Nombre'];          }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Envase']           = '';}
				if(isset($idTermografo)&&$idTermografo!=''){            $_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Termografo']          = $rowTermografo['Codigo'].' - '.$rowTermografo['Nombre'];  }else{$_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$oldidProducto]['Termografo']       = '';}

				//redirijo
				header( 'Location: '.$location.'&view='.$randompass );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_estiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$randompass = $_GET['view'];

			unset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass][$_GET['del_estiba']]);

			//redirijo
			header( 'Location: '.$location.'&view='.$randompass );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_Doc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$randompass = $_GET['view'];

			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass])){

				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']=='Sin Datos' ){         $error['CTNNombreCompañia']      = 'error/No ha ingresado el Contenedor Nro.';}
				//if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']=='Sin Datos' ){                         $error['NInforme']               = 'error/No ha ingresado el Nro. Del Informe';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']=='0000-00-00' ){              $error['Creacion_fecha']         = 'error/No ha ingresado la Fecha del informe';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']=='0000-00-00' ){    $error['FechaInicioEmbarque']    = 'error/No ha ingresado la Fecha Inicio del Embarque';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']=='Sin Datos' ){             $error['HoraInicioCarga']        = 'error/No ha ingresado la Hora Inicio Carga';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']=='0000-00-00' ){  $error['FechaTerminoEmbarque']   = 'error/No ha ingresado la Fecha Termino del Embarque';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']=='Sin Datos' ){           $error['HoraTerminoCarga']       = 'error/No ha ingresado la Hora Termino Carga';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']=='Sin Datos' ){           $error['idPlantaDespacho']       = 'error/No ha seleccionado el Planta Despachadora';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']=='Sin Datos' ){                     $error['idCategoria']            = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']=='Sin Datos' ){                       $error['idProducto']             = 'error/No ha seleccionado el tipo';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']=='Sin Datos' ){                 $error['CantidadCajas']          = 'error/No ha ingresado la Cantidad de Cajas';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']=='Sin Datos' ){                 $error['idInstructivo']          = 'error/No ha seleccionado el N° Instructivo';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']=='Sin Datos' ){                         $error['idNaviera']              = 'error/No ha seleccionado la Naviera';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']=='Sin Datos' ){           $error['idPuertoEmbarque']       = 'error/No ha seleccionado el Puerto Embarque';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']=='Sin Datos' ){             $error['idPuertoDestino']        = 'error/No ha seleccionado el Puerto Destino';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']=='Sin Datos' ){                         $error['idMercado']              = 'error/No ha seleccionado el Mercado';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']=='Sin Datos' ){     $error['idEmpresaTransporte']    = 'error/No ha seleccionado la Empresa Transporte';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']=='Sin Datos' ){             $error['ChoferNombreRut']        = 'error/No ha ingresado el Conductor';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']=='Sin Datos' ){                 $error['PatenteCamion']          = 'error/No ha ingresado la Patente Camion';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']=='Sin Datos' ){                   $error['PatenteCarro']           = 'error/No ha ingresado la Patente Carro';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']=='Sin Datos' ){                     $error['idCondicion']            = 'error/No ha seleccionado la Condición CTN';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']=='Sin Datos' ){                         $error['idSellado']              = 'error/No ha seleccionado el Sellado Piso';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']=='Sin Datos' ){                         $error['TSetPoint']              = 'error/No ha ingresado la T° Set Point';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']=='Sin Datos' ){                         $error['TAmbiente']              = 'error/No ha ingresado la T° Ambiente';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']=='Sin Datos' ){                     $error['NumeroSello']            = 'error/No ha ingresado el Numero de sello';}
				if(!isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']) OR $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']=='Sin Datos' ){                     $error['idInspector']            = 'error/No ha seleccionado el Inspector';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de datos';
			}

			/******************************************/
			//Se verifican las estibas
			if (isset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass])){
				foreach ($_SESSION['cross_shipping_consolidacion_estibas'][$randompass] as $key => $producto){
					$n_data1++;
				}
			}
			if(isset($n_data1)&&$n_data1==0){
				$error['estibas'] = 'error/No se han asignado estibas';
			}
			/******************************************/
			//Se verifican los archivos
			if (isset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass])){
				foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$randompass] as $key => $producto){
					$n_data2++;
				}
			}
			if(isset($n_data2)&&$n_data2==0){
				$error['estibas'] = 'error/No se han asignado archivos';
			}
			/******************************************/
			//Consulto el ultimo NInforme
			$rowNInforme = db_select_data (false, 'NInforme', 'cross_shipping_consolidacion', '', 'idSistema = '.$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema'].' ORDER BY NInforme DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Verifico la existencia
			if(isset($rowNInforme['NInforme'])&&$rowNInforme['NInforme']!=''){
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme'] = $rowNInforme['NInforme'] + 1;
			}else{
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme'] = 1;
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']!=''){      $SIS_data  = "'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']."'";    }else{$SIS_data  = "''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']!=''){   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']!=''){                     $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']!=''){      $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']!=''){       $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']!=''){    $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']!=''){     $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']!=''){     $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']!=''){               $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']!=''){                 $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']!=''){           $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']!=''){           $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']!=''){                   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']!=''){     $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']!=''){       $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']!=''){                   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']!=''){                         $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']."'";                }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']!=''){               $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']!=''){      $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']!=''){       $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']!=''){           $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']!=''){             $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']!=''){               $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']!=''){                   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']!=''){                   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']!=''){             $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']!=''){                   $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']."'";             }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']!=''){               $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']!=''){               $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']."'";           }else{$SIS_data .= ",''";}
				if(isset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']) && $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']!=''){           $SIS_data .= ",'".$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']."'";         }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'";

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto,
				Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano,CTNNombreCompañia, NInforme,
				FechaInicioEmbarque, HoraInicioCarga, FechaTerminoEmbarque, HoraTerminoCarga, idPlantaDespacho,
				idCategoria, idProducto, CantidadCajas, idInstructivo, idNaviera, idPuertoEmbarque, idPuertoDestino,
				idMercado,idPais, idRecibidor, idEmpresaTransporte, ChoferNombreRut, PatenteCamion, PatenteCarro, idCondicion,
				idSellado,TSetPoint, TVentilacion, TAmbiente, NumeroSello, idInspector, Observaciones, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guardan los datos de las estibas
					if(isset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass])){
						foreach ($_SESSION['cross_shipping_consolidacion_estibas'][$randompass] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                           $SIS_data  = "'".$ultimo_id."'";                          }else{$SIS_data  = "''";}
							if(isset($producto['idEstiba']) && $producto['idEstiba']!=''){                     $SIS_data .= ",'".$producto['idEstiba']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['idEstibaUbicacion']) && $producto['idEstibaUbicacion']!=''){   $SIS_data .= ",'".$producto['idEstibaUbicacion']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['idPosicion']) && $producto['idPosicion']!=''){                 $SIS_data .= ",'".$producto['idPosicion']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['idEnvase']) && $producto['idEnvase']!=''){                     $SIS_data .= ",'".$producto['idEnvase']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['NPallet']) && $producto['NPallet']!=''){                       $SIS_data .= ",'".$producto['NPallet']."'";               }else{$SIS_data .= ",''";}
							if(isset($producto['Temperatura']) && $producto['Temperatura']!=''){               $SIS_data .= ",'".$producto['Temperatura']."'";           }else{$SIS_data .= ",''";}
							if(isset($producto['idTermografo']) && $producto['idTermografo']!=''){             $SIS_data .= ",'".$producto['idTermografo']."'";          }else{$SIS_data .= ",''";}
							if(isset($producto['NSerieSensor']) && $producto['NSerieSensor']!=''){             $SIS_data .= ",'".$producto['NSerieSensor']."'";          }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idConsolidacion,idEstiba, idEstibaUbicacion, idPosicion, idEnvase, NPallet, Temperatura, idTermografo, NSerieSensor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion_estibas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass])){
						foreach ($_SESSION['cross_shipping_consolidacion_archivos'][$randompass] as $key => $productos){
							foreach ($productos as $producto) {
								if(isset($producto['idFile'])&&$producto['idFile']!=0){
									//filtros
									if(isset($ultimo_id) && $ultimo_id!=''){                                  $SIS_data  = "'".$ultimo_id."'";                   }else{$SIS_data  = "''";}
									if(isset($producto['idArchivoTipo']) && $producto['idArchivoTipo']!=''){  $SIS_data .= ",'".$producto['idArchivoTipo']."'";  }else{$SIS_data .= ",''";}
									if(isset($producto['Nombre']) && $producto['Nombre']!=''){                $SIS_data .= ",'".$producto['Nombre']."'";         }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idConsolidacion, idArchivoTipo,Nombre';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion_archivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
						}
					}
					/***********************************************************************************************/
					/***********************************************************************************************/
					//envio correos
					$arrCorreos = array();
					$arrCorreos = db_select_array (false, 'usuarios_listado.usuario AS UsuarioNick, usuarios_listado.email AS UsuarioEmail, usuarios_listado.Nombre AS UsuarioNombre,core_sistemas.Nombre AS SistemaNombre,core_sistemas.Contacto_Email AS SistemaEmail, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'sistema_aprobador_cross', 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = sistema_aprobador_cross.idUsuario LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = sistema_aprobador_cross.idSistema', 'sistema_aprobador_cross.idSistema='.$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema'], 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Declaracion de variables
					$ProdMuestra         = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra'];
					$Instructivo         = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Instructivo'];
					$Pais                = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Pais'];
					$Mercado             = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Mercado'];
					$Naviera             = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Naviera'];
					$PlantaDespacho      = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PlantaDespacho'];
					$Creacion_fecha      = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha'];
					$NInforme            = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme'];
					$CTNNombreCompañia   = $_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia'];

					foreach ($arrCorreos as $correo) {
						/*******************/
						//Mensaje
						$xbody = '
						<h3>Notificación creación de Consolidacion</h3>
						<p>Una nueva consolidacion ha sido creada, esta queda en espera de aprobacion</p>
						<p><strong>Planta Consolidacion :</strong>'.$PlantaDespacho.'</p>
						<p><strong>Fecha del informe :</strong>'.fecha_estandar($Creacion_fecha).'</p>
						<p><strong>Numero del Informe :</strong>'.$NInforme.'</p>
						<p><strong>Contenedor Nro. :</strong>'.$CTNNombreCompañia.'</p>
						<p><strong>Naviera :</strong>'.$Naviera.'</p>
						<p><strong>Instructivo :</strong>'.$Instructivo.'</p>
						<p><strong>Mercado :</strong>'.$Mercado.'</p>
						<p><strong>Pais :</strong>'.$Pais.'</p>
						<p><strong>Especie/Variedad :</strong>'.$ProdMuestra.'</p>
						<a href="'.DB_SITE_MAIN.'/view_cross_shipping_consolidacion.php?view='.simpleEncode($ultimo_id, fecha_actual()).'">Ver Aqui</a>
						';

						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], $correo['SistemaNombre'],
													 $correo['UsuarioEmail'], $correo['UsuarioNombre'],
													 '', '',
													 'Notificación creación de Consolidacion',
													 $xbody,'',
													 '',
													 1,
													 $correo['Gmail_Usuario'],
													 $correo['Gmail_Password']);
						//se guarda el log
						log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Notificación creación de Consolidacion)');
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['cross_shipping_consolidacion_basicos'][$randompass]);
					unset($_SESSION['cross_shipping_consolidacion_estibas'][$randompass]);
					unset($_SESSION['cross_shipping_consolidacion_archivos'][$randompass]);
					unset($_SESSION['cross_shipping_consolidacion_temporal'][$randompass]);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
		case 'rechazo_consolidacion':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstado='3'";
				if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",Observacion='".$Observacion."'"; }
				if(isset($idUsuario) && $idUsuario!=''){            $SIS_data .= ",idAprobador='".$idUsuario."'";   }
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",Aprobacion_Fecha='".$Creacion_fecha."'";   }
				if(isset($Creacion_hora) && $Creacion_hora!=''){    $SIS_data .= ",Aprobacion_Hora='".$Creacion_hora."'";   }

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$idConsolidacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion_archivos', 'idConsolidacion = "'.$idConsolidacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'nula_consolidacion':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstado='4'";
				if(isset($Observacion) && $Observacion!=''){        $SIS_data .= ",Observacion='".$Observacion."'"; }
				if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",idAprobador='".$idUsuario."'";   }
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){  $SIS_data .= ",Aprobacion_Fecha='".$Creacion_fecha."'";   }
				if(isset($Creacion_hora) && $Creacion_hora!=''){    $SIS_data .= ",Aprobacion_Hora='".$Creacion_hora."'";   }

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$idConsolidacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'aprob_consolidacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idConsolidacion  = $_GET['consolidacion_aprobar'];
			$Creacion_fecha   = fecha_actual();
			$Creacion_hora    = hora_actual();
			$idUsuario        = $_SESSION['usuario']['basic_data']['idUsuario'];

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idConsolidacion)&&$idConsolidacion!=''&&isset($idUsuario)&&$idUsuario!=''){
				$ndata_1 = db_select_nrows (false, 'idConsolidacion', 'cross_shipping_consolidacion_aprobaciones', '', "idConsolidacion='".$idConsolidacion."' AND idUsuario='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La aprobacion ya fue realizada';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************************/
				//Inserto la aprobacion en la tabla de aprobaciones
				if(isset($idConsolidacion) && $idConsolidacion!=''){  $SIS_data  = "'".$idConsolidacion."'";   }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idConsolidacion, Creacion_fecha, Creacion_hora, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion_aprobaciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Reviso si las aprobaciones igualan a los aprobadores
				$arrAprobado = array();
				$arrAprobado = db_select_array (false, 'sistema_aprobador_cross.idUsuario, cross_shipping_consolidacion.idConsolidacion, (SELECT COUNT(idAprobaciones) FROM `cross_shipping_consolidacion_aprobaciones` WHERE idConsolidacion=cross_shipping_consolidacion.idConsolidacion AND idUsuario=sistema_aprobador_cross.idUsuario  LIMIT 1) AS C_apro', 'cross_shipping_consolidacion', 'LEFT JOIN `sistema_aprobador_cross`  ON sistema_aprobador_cross.idSistema   = cross_shipping_consolidacion.idSistema', 'cross_shipping_consolidacion.idConsolidacion = '.$idConsolidacion, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//variables
				$napro_list = 0;
				$napro_true = 0;
				foreach ($arrAprobado as $apro) {
					$napro_list++;
					if(isset($apro['C_apro'])&&$apro['C_apro']==1){
						$napro_true++;
					}
				}

				//Si por lo menos hay una aprobacion
				if($napro_true>=1){
					//Filtros
					$SIS_data = "idEstado='2'";
					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$_GET['consolidacion_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					/*********************************************************************/
					//envio correos
					$arrCorreos = array();
					$arrCorreos = db_select_array (false, 'sistema_cross_email_aprobados.email AS Email, core_sistemas.Nombre AS SistemaNombre,core_sistemas.Contacto_Email AS SistemaEmail, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'sistema_cross_email_aprobados', 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = sistema_cross_email_aprobados.idSistema', 'sistema_cross_email_aprobados.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'], 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/************************************************************/
					// Se trae la información del producto
					$SIS_query = '
					cross_shipping_plantas.Nombre AS PlantaNombre,
					cross_shipping_plantas.Codigo AS PlantaCodigo,
					cross_shipping_consolidacion.Creacion_fecha,
					cross_shipping_consolidacion.CTNNombreCompañia,
					cross_shipping_consolidacion.NInforme,
					cross_shipping_naviera.Nombre AS NavieraNombre,
					cross_shipping_naviera.Codigo AS NavieraCodigo,
					cross_shipping_mercado.Nombre AS MercadoNombre,
					cross_shipping_mercado.Codigo AS MercadoCodigo,
					cross_shipping_instructivo.Nombre AS InstructivoNombre,
					cross_shipping_instructivo.Codigo AS InstructivoCodigo,
					core_paises.Nombre AS PaisesNombre,
					sistema_variedades_categorias.Nombre AS Especie,
					variedades_listado.Nombre AS Variedad';
					$SIS_join  = '
					LEFT JOIN `cross_shipping_plantas`          ON cross_shipping_plantas.idPlantaDespacho      = cross_shipping_consolidacion.idPlantaDespacho
					LEFT JOIN `cross_shipping_naviera`          ON cross_shipping_naviera.idNaviera             = cross_shipping_consolidacion.idNaviera
					LEFT JOIN `cross_shipping_mercado`          ON cross_shipping_mercado.idMercado             = cross_shipping_consolidacion.idMercado
					LEFT JOIN `core_paises`                     ON core_paises.idPais                           = cross_shipping_consolidacion.idPais
					LEFT JOIN `sistema_variedades_categorias`   ON sistema_variedades_categorias.idCategoria    = cross_shipping_consolidacion.idCategoria
					LEFT JOIN `variedades_listado`              ON variedades_listado.idProducto                = cross_shipping_consolidacion.idProducto
					LEFT JOIN `cross_shipping_instructivo`      ON cross_shipping_instructivo.idInstructivo     = cross_shipping_consolidacion.idInstructivo
					';
					$SIS_where = 'cross_shipping_consolidacion.idConsolidacion ='.$idConsolidacion;
					$rowConso = db_select_data (false, $SIS_query, 'cross_shipping_consolidacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					foreach ($arrCorreos as $correo) {
						/*******************/
						//Mensaje
						$xbody = '
						<h3>Notificación aprobación de Consolidacion</h3>
						<p>Una nueva consolidacion ha sido aprobada</p>
						<p><strong>Planta Consolidacion :</strong>'.$rowConso['PlantaCodigo'].' - '.$rowConso['PlantaNombre'].'</p>
						<p><strong>Fecha del informe :</strong>'.fecha_estandar($rowConso['Creacion_fecha']).'</p>
						<p><strong>Numero del Informe :</strong>'.$rowConso['NInforme'].'</p>
						<p><strong>Contenedor Nro. :</strong>'.$rowConso['CTNNombreCompañia'].'</p>
						<p><strong>Naviera :</strong>'.$rowConso['NavieraCodigo'].' - '.$rowConso['NavieraNombre'].'</p>
						<p><strong>Instructivo :</strong>'.$rowConso['InstructivoCodigo'].' - '.$rowConso['InstructivoNombre'].'</p>
						<p><strong>Mercado :</strong>'.$rowConso['MercadoCodigo'].' - '.$rowConso['MercadoNombre'].'</p>
						<p><strong>Pais :</strong>'.$rowConso['PaisesNombre'].'</p>
						<p><strong>Especie/Variedad :</strong>'.$rowConso['Especie'].' - '.$rowConso['Variedad'].'</p>
						<a href="'.DB_SITE_MAIN.'/view_cross_shipping_consolidacion.php?view='.simpleEncode($idConsolidacion, fecha_actual()).'">Ver Aqui</a> 
						';
						/*******************/
						//Envio de correo
						$rmail = tareas_envio_correo($correo['SistemaEmail'], $correo['SistemaNombre'],
													 $correo['Email'], $correo['Email'],
													 '', '',
													 'Notificación aprobación de Consolidacion',
													 $xbody,'',
													 '',
													 1,
													 $correo['Gmail_Usuario'],
													 $correo['Gmail_Password']);
                        //se guarda el log
						log_response(1, $rmail, $correo['Email'].' (Asunto:Notificación aprobación de Consolidacion)');

                        //Envio del mensaje
						if ($rmail!=1) {
							//echo "Mailer Error: " . $rmail;
						} else {
							//echo "Message sent!";
						}
					}

				}

				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'aprob_auto_consolidacion':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idEstado='2'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$_GET['consolidacion_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clona_ingreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos del formulario recien llenado
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['randompass']             = $randompass;
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ProdMuestra']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['ProdMuestra'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CTNNombreCompañia']      = $CTNNombreCompañia;
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NInforme']               = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['NInforme'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Creacion_fecha']         = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['Creacion_fecha'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaInicioEmbarque']    = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['FechaInicioEmbarque'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraInicioCarga']        = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['HoraInicioCarga'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['FechaTerminoEmbarque']   = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['FechaTerminoEmbarque'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['HoraTerminoCarga']       = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['HoraTerminoCarga'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPlantaDespacho']       = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idPlantaDespacho'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCategoria']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idCategoria'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idProducto']             = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idProducto'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['CantidadCajas']          = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['CantidadCajas'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInstructivo']          = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idInstructivo'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idNaviera']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idNaviera'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoEmbarque']       = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idPuertoEmbarque'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPuertoDestino']        = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idPuertoDestino'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idMercado']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idMercado'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idPais']                 = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idPais'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idRecibidor']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idRecibidor'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idEmpresaTransporte']    = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idEmpresaTransporte'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['ChoferNombreRut']        = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['ChoferNombreRut'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCamion']          = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['PatenteCamion'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['PatenteCarro']           = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['PatenteCarro'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idCondicion']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idCondicion'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSellado']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idSellado'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TSetPoint']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['TSetPoint'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TVentilacion']           = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['TVentilacion'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['TAmbiente']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['TAmbiente'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['NumeroSello']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['NumeroSello'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idInspector']            = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idInspector'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['Observaciones']          = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['Observaciones'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idSistema']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idSistema'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['idUsuario']              = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['idUsuario'];
				$_SESSION['cross_shipping_consolidacion_basicos'][$randompass]['fecha_auto']             = $_SESSION['cross_shipping_consolidacion_basicos'][$cloneConsolidacion]['fecha_auto'];

				header( 'Location: '.$location.'&view='.$randompass );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'updateConsolidacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idConsolidacion='".$idConsolidacion."'";
				if(isset($idSistema) && $idSistema!=''){     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){     $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($fecha_auto) && $fecha_auto!=''){   $SIS_data .= ",fecha_auto='".$fecha_auto."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_Semana='".fecha2NSemana($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";

				}
				if(isset($CTNNombreCompañia) && $CTNNombreCompañia!=''){            $SIS_data .= ",CTNNombreCompañia='".$CTNNombreCompañia."'";}
				if(isset($NInforme) && $NInforme!=''){                              $SIS_data .= ",NInforme='".$NInforme."'";}
				if(isset($FechaInicioEmbarque) && $FechaInicioEmbarque!=''){        $SIS_data .= ",FechaInicioEmbarque='".$FechaInicioEmbarque."'";}
				if(isset($HoraInicioCarga) && $HoraInicioCarga!=''){                $SIS_data .= ",HoraInicioCarga='".$HoraInicioCarga."'";}
				if(isset($FechaTerminoEmbarque) && $FechaTerminoEmbarque!=''){      $SIS_data .= ",FechaTerminoEmbarque='".$FechaTerminoEmbarque."'";}
				if(isset($HoraTerminoCarga) && $HoraTerminoCarga!=''){              $SIS_data .= ",HoraTerminoCarga='".$HoraTerminoCarga."'";}
				if(isset($idPlantaDespacho) && $idPlantaDespacho!=''){              $SIS_data .= ",idPlantaDespacho='".$idPlantaDespacho."'";}
				if(isset($idCategoria) && $idCategoria!=''){                        $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idProducto) && $idProducto!=''){                          $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($CantidadCajas) && $CantidadCajas!=''){                    $SIS_data .= ",CantidadCajas='".$CantidadCajas."'";}
				if(isset($idInstructivo) && $idInstructivo!=''){                    $SIS_data .= ",idInstructivo='".$idInstructivo."'";}
				if(isset($idNaviera) && $idNaviera!=''){                            $SIS_data .= ",idNaviera='".$idNaviera."'";}
				if(isset($idPuertoEmbarque) && $idPuertoEmbarque!=''){              $SIS_data .= ",idPuertoEmbarque='".$idPuertoEmbarque."'";}
				if(isset($idPuertoDestino) && $idPuertoDestino!=''){                $SIS_data .= ",idPuertoDestino='".$idPuertoDestino."'";}
				if(isset($idMercado) && $idMercado!=''){                            $SIS_data .= ",idMercado='".$idMercado."'";}
				if(isset($idPais) && $idPais!=''){                                  $SIS_data .= ",idPais='".$idPais."'";}
				if(isset($idRecibidor) && $idRecibidor!=''){                        $SIS_data .= ",idRecibidor='".$idRecibidor."'";}
				if(isset($idEmpresaTransporte) && $idEmpresaTransporte!=''){        $SIS_data .= ",idEmpresaTransporte='".$idEmpresaTransporte."'";}
				if(isset($ChoferNombreRut) && $ChoferNombreRut!=''){                $SIS_data .= ",ChoferNombreRut='".$ChoferNombreRut."'";}
				if(isset($PatenteCamion) && $PatenteCamion!=''){                    $SIS_data .= ",PatenteCamion='".$PatenteCamion."'";}
				if(isset($PatenteCarro) && $PatenteCarro!=''){                      $SIS_data .= ",PatenteCarro='".$PatenteCarro."'";}
				if(isset($idCondicion) && $idCondicion!=''){                        $SIS_data .= ",idCondicion='".$idCondicion."'";}
				if(isset($idSellado) && $idSellado!=''){                            $SIS_data .= ",idSellado='".$idSellado."'";}
				if(isset($TSetPoint) && $TSetPoint!=''){                            $SIS_data .= ",TSetPoint='".$TSetPoint."'";}
				if(isset($TVentilacion) && $TVentilacion!=''){                      $SIS_data .= ",TVentilacion='".$TVentilacion."'";}
				if(isset($TAmbiente) && $TAmbiente!=''){                            $SIS_data .= ",TAmbiente='".$TAmbiente."'";}
				if(isset($NumeroSello) && $NumeroSello!=''){                        $SIS_data .= ",NumeroSello='".$NumeroSello."'";}
				if(isset($idInspector) && $idInspector!=''){                        $SIS_data .= ",idInspector='".$idInspector."'";}
				if(isset($Observaciones) && $Observaciones!=''){                    $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($idEstado) && $idEstado!=''){                              $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Observacion) && $Observacion!=''){                        $SIS_data .= ",Observacion='".$Observacion."'";}
				if(isset($idAprobador) && $idAprobador!=''){                        $SIS_data .= ",idAprobador='".$idAprobador."'";}
				if(isset($Aprobacion_Fecha) && $Aprobacion_Fecha!=''){              $SIS_data .= ",Aprobacion_Fecha='".$Aprobacion_Fecha."'";}
				if(isset($Aprobacion_Hora) && $Aprobacion_Hora!=''){                $SIS_data .= ",Aprobacion_Hora='".$Aprobacion_Hora."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$idConsolidacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'insertEstiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idConsolidacion) && $idConsolidacion!=''){          $SIS_data  = "'".$idConsolidacion."'";       }else{$SIS_data  = "''";}
				if(isset($idEstiba) && $idEstiba!=''){                        $SIS_data .= ",'".$idEstiba."'";             }else{$SIS_data .= ",''";}
				if(isset($idEstibaUbicacion) && $idEstibaUbicacion!=''){      $SIS_data .= ",'".$idEstibaUbicacion."'";    }else{$SIS_data .= ",''";}
				if(isset($idPosicion) && $idPosicion!=''){                    $SIS_data .= ",'".$idPosicion."'";           }else{$SIS_data .= ",''";}
				if(isset($idEnvase) && $idEnvase!=''){                        $SIS_data .= ",'".$idEnvase."'";             }else{$SIS_data .= ",''";}
				if(isset($NPallet) && $NPallet!=''){                          $SIS_data .= ",'".$NPallet."'";              }else{$SIS_data .= ",''";}
				if(isset($Temperatura) && $Temperatura!=''){                  $SIS_data .= ",'".$Temperatura."'";          }else{$SIS_data .= ",''";}
				if(isset($idTermografo) && $idTermografo!=''){                $SIS_data .= ",'".$idTermografo."'";         }else{$SIS_data .= ",''";}
				if(isset($NSerieSensor) && $NSerieSensor!=''){                $SIS_data .= ",'".$NSerieSensor."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idConsolidacion, idEstiba, idEstibaUbicacion,
				idPosicion, idEnvase, NPallet, Temperatura, idTermografo, NSerieSensor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion_estibas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'updateEstiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstibaListado='".$idEstibaListado."'";
				if(isset($idConsolidacion) && $idConsolidacion!=''){       $SIS_data .= ",idConsolidacion='".$idConsolidacion."'";}
				if(isset($idEstiba) && $idEstiba!=''){                     $SIS_data .= ",idEstiba='".$idEstiba."'";}
				if(isset($idEstibaUbicacion) && $idEstibaUbicacion!=''){   $SIS_data .= ",idEstibaUbicacion='".$idEstibaUbicacion."'";}
				if(isset($idPosicion) && $idPosicion!=''){                 $SIS_data .= ",idPosicion='".$idPosicion."'";}
				if(isset($idEnvase) && $idEnvase!=''){                     $SIS_data .= ",idEnvase='".$idEnvase."'";}
				if(isset($NPallet) && $NPallet!=''){                       $SIS_data .= ",NPallet='".$NPallet."'";}
				if(isset($Temperatura) && $Temperatura!=''){               $SIS_data .= ",Temperatura='".$Temperatura."'";}
				if(isset($idTermografo) && $idTermografo!=''){             $SIS_data .= ",idTermografo='".$idTermografo."'";}
				if(isset($NSerieSensor) && $NSerieSensor!=''){             $SIS_data .= ",NSerieSensor='".$NSerieSensor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion_estibas', 'idEstibaListado = "'.$idEstibaListado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'delEstiba':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_estiba']) OR !validaEntero($_GET['del_estiba']))&&$_GET['del_estiba']!=''){
				$indice = simpleDecode($_GET['del_estiba'], fecha_actual());
			}else{
				$indice = $_GET['del_estiba'];
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
				$resultado = db_delete_data (false, 'cross_shipping_consolidacion_estibas', 'idEstibaListado = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		//Cambia el nivel del permiso
		case 'insert_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'cross_ship_conso_'.$CTNNombreCompañia.'_'.fecha_actual().'_'.$idArchivoTipo.'_';
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

			//Verifico errores en los archivos
			foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["exFile"]["error"][$key] > 0){
					$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
				}
				if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
					}
				} else {
					$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

			if(empty($error)){

				//Verifico errores en los archivos
				foreach($_FILES["exFile"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["exFile"]["error"][$key] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"][$key]);
					}
					if (in_array($_FILES['exFile']['type'][$key], $permitidos) && $_FILES['exFile']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['exFile']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"][$key], $ruta);
							if ($move_result){

								//renombro archivo
								$Nombre = $sufijo.$_FILES['exFile']['name'][$key];
								//filtros
								if(isset($idConsolidacion) && $idConsolidacion!=''){  $SIS_data  = "'".$idConsolidacion."'";   }else{$SIS_data  = "''";}
								if(isset($idArchivoTipo) && $idArchivoTipo!=''){      $SIS_data .= ",'".$idArchivoTipo."'";    }else{$SIS_data .= ",''";}
								if(isset($Nombre) && $Nombre!=''){                    $SIS_data .= ",'".$Nombre."'";           }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idConsolidacion, idArchivoTipo, Nombre';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_shipping_consolidacion_archivo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							} else {
								$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
							}
						}else{
							$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'][$key].' ya existe';
						}
					} else {
						$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_file':

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
				$rowData = db_select_data (false, 'Nombre', 'cross_shipping_consolidacion_archivo', '', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'cross_shipping_consolidacion_archivo', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'modEdit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado=1" ;
			$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$_GET['edit'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'reversar':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['reversar']) OR !validaEntero($_GET['reversar']))&&$_GET['reversar']!=''){
				$indice = simpleDecode($_GET['reversar'], fecha_actual());
			}else{
				$indice = $_GET['reversar'];
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
				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado=1" ;
				$resultado = db_update_data (false, $SIS_data, 'cross_shipping_consolidacion', 'idConsolidacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'cross_shipping_consolidacion_aprobaciones', 'idConsolidacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
	}

?>
