<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-276).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idSolicitud']))        $idSolicitud          = $_POST['idSolicitud'];
	if (!empty($_POST['idSistema']))          $idSistema            = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))          $idUsuario            = $_POST['idUsuario'];
	if (!empty($_POST['Creacion_fecha']))     $Creacion_fecha       = $_POST['Creacion_fecha'];
	if (!empty($_POST['Creacion_mes']))       $Creacion_mes         = $_POST['Creacion_mes'];
	if (!empty($_POST['Creacion_ano']))       $Creacion_ano         = $_POST['Creacion_ano'];
	if (!empty($_POST['Observaciones']))      $Observaciones        = $_POST['Observaciones'];

	if (!empty($_POST['idProducto']))         $idProducto           = $_POST['idProducto'];
	if (!empty($_POST['Cantidad']))           $Cantidad             = $_POST['Cantidad'];
	if (!empty($_POST['oldidProducto']))      $oldidProducto        = $_POST['oldidProducto'];
	if (!empty($_POST['idEquipo']))           $idEquipo             = $_POST['idEquipo'];
	if (!empty($_POST['idFrecuencia']))       $idFrecuencia         = $_POST['idFrecuencia'];
	if (!empty($_POST['idServicio']))         $idServicio           = $_POST['idServicio'];
	if (!empty($_POST['Nombre']))             $Nombre               = $_POST['Nombre'];

	if (!empty($_POST['idProveedor']))        $idProveedor          = $_POST['idProveedor'];
	if (!empty($_POST['idExistencia']))       $idExistencia         = $_POST['idExistencia'];

	if (!empty($_POST['idEstado']))           $idEstado             = $_POST['idEstado'];

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
			case 'idSolicitud':       if(empty($idSolicitud)){      $error['idSolicitud']     = 'error/No ha ingresado el id';}break;
			case 'idSistema':         if(empty($idSistema)){        $error['idSistema']       = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':         if(empty($idUsuario)){        $error['idUsuario']       = 'error/No ha seleccionado el usuario';}break;
			case 'Creacion_fecha':    if(empty($Creacion_fecha)){   $error['Creacion_fecha']  = 'error/No ha ingresado la fecha de creación';}break;
			case 'Creacion_mes':      if(empty($Creacion_mes)){     $error['Creacion_mes']    = 'error/No ha ingresado el mes de creación';}break;
			case 'Creacion_ano':      if(empty($Creacion_ano)){     $error['Creacion_ano']    = 'error/No ha ingresado el año de creación';}break;
			case 'Observaciones':     if(empty($Observaciones)){    $error['Observaciones']   = 'error/No ha ingresado la observacion';}break;

			case 'idProducto':        if(empty($idProducto)){       $error['idProducto']      = 'error/No ha seleccionado el producto';}break;
			case 'Cantidad':          if(empty($Cantidad)){         $error['Cantidad']        = 'error/No ha ingresado la cantidad';}break;
			case 'oldidProducto':     if(empty($oldidProducto)){    $error['oldidProducto']   = 'error/No ha ingresado el producto';}break;
			case 'idEquipo':          if(empty($idEquipo)){         $error['idEquipo']        = 'error/No ha seleccionado el equipo';}break;
			case 'idFrecuencia':      if(empty($idFrecuencia)){     $error['idFrecuencia']    = 'error/No ha seleccionado la frecuencia';}break;
			case 'idServicio':        if(empty($idServicio)){       $error['idServicio']      = 'error/No ha seleccionado el servicio';}break;
			case 'Nombre':            if(empty($Nombre)){           $error['Nombre']          = 'error/No ha ingresado el Nombre';}break;

			case 'idProveedor':       if(empty($idProveedor)){      $error['idProveedor']     = 'error/No ha seleccionado el Proveedor';}break;
			case 'idExistencia':      if(empty($idExistencia)){     $error['idExistencia']    = 'error/No ha seleccionado la Existencia';}break;

			case 'idEstado':          if(empty($idEstado)){         $error['idEstado']        = 'error/No ha seleccionado el Estado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Nombre) && $Nombre!=''){               $Nombre        = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}

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
		case 'new_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['solicitud_basicos']);
				unset($_SESSION['solicitud_arriendos']);
				unset($_SESSION['solicitud_insumos']);
				unset($_SESSION['solicitud_otros']);
				unset($_SESSION['solicitud_productos']);
				unset($_SESSION['solicitud_servicios']);
				unset($_SESSION['solicitud_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['solicitud_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['solicitud_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['solicitud_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['solicitud_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['solicitud_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['solicitud_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['solicitud_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['solicitud_basicos']['Observaciones']   = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['solicitud_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['solicitud_basicos']['Usuario'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_basicos']);
			unset($_SESSION['solicitud_arriendos']);
			unset($_SESSION['solicitud_insumos']);
			unset($_SESSION['solicitud_otros']);
			unset($_SESSION['solicitud_productos']);
			unset($_SESSION['solicitud_servicios']);
			unset($_SESSION['solicitud_temporal']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['solicitud_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['solicitud_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['solicitud_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['solicitud_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['solicitud_basicos']['Creacion_fecha']  = $Creacion_fecha;  }else{$_SESSION['solicitud_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['solicitud_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['solicitud_basicos']['Observaciones']   = '';}

				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowUsuario = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = '.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['solicitud_basicos']['Usuario'] = $rowUsuario['Nombre'];
				}else{
					$_SESSION['solicitud_basicos']['Usuario'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['solicitud_productos'][$idProducto])&&$_SESSION['solicitud_productos'][$idProducto]>0){
				$error['productos'] = 'error/El producto que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'productos_listado.Nombre,productos_listado.idProveedor, sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				$_SESSION['solicitud_productos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['solicitud_productos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['solicitud_productos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['solicitud_productos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];
				$_SESSION['solicitud_productos'][$idProducto]['idProveedor'] = $rowProducto['idProveedor'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'productos_listado.Nombre,productos_listado.idProveedor, sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				//Borro el producto
				unset($_SESSION['solicitud_productos'][$oldidProducto]);

				//creo el producto
				$_SESSION['solicitud_productos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['solicitud_productos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['solicitud_productos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['solicitud_productos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];
				$_SESSION['solicitud_productos'][$idProducto]['idProveedor'] = $rowProducto['idProveedor'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_ins_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['solicitud_insumos'][$idProducto])&&$_SESSION['solicitud_insumos'][$idProducto]>0){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,insumos_listado.idProveedor, sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				$_SESSION['solicitud_insumos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['solicitud_insumos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['solicitud_insumos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['solicitud_insumos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];
				$_SESSION['solicitud_insumos'][$idProducto]['idProveedor'] = $rowProducto['idProveedor'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_ins_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre,insumos_listado.idProveedor, sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				//Borro el producto
				unset($_SESSION['solicitud_insumos'][$oldidProducto]);

				//creo el producto
				$_SESSION['solicitud_insumos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['solicitud_insumos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['solicitud_insumos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['solicitud_insumos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];
				$_SESSION['solicitud_insumos'][$idProducto]['idProveedor'] = $rowProducto['idProveedor'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_ins_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_insumos'][$_GET['del_ins']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_arriendo_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['solicitud_arriendos'][$idEquipo])&&$_SESSION['solicitud_arriendos'][$idEquipo]>0){
				$error['productos'] = 'error/El arriendo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto   = db_select_data (false, 'Nombre,idProveedor', 'equipos_arriendo_listado', '', 'idEquipo='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				$_SESSION['solicitud_arriendos'][$idEquipo]['idEquipo']      = $idEquipo;
				$_SESSION['solicitud_arriendos'][$idEquipo]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_arriendos'][$idEquipo]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_arriendos'][$idEquipo]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['solicitud_arriendos'][$idEquipo]['idProveedor']   = $rowProducto['idProveedor'];
				$_SESSION['solicitud_arriendos'][$idEquipo]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_arriendo_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto   = db_select_data (false, 'Nombre,idProveedor', 'equipos_arriendo_listado', '', 'idEquipo='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				//Borro el producto
				unset($_SESSION['solicitud_arriendos'][$oldidProducto]);

				//creo el producto
				$_SESSION['solicitud_arriendos'][$idEquipo]['idEquipo']      = $idEquipo;
				$_SESSION['solicitud_arriendos'][$idEquipo]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_arriendos'][$idEquipo]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_arriendos'][$idEquipo]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['solicitud_arriendos'][$idEquipo]['idProveedor']   = $rowProducto['idProveedor'];
				$_SESSION['solicitud_arriendos'][$idEquipo]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_arriendo_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_arriendos'][$_GET['del_arriendo']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_servicio_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['solicitud_servicios'][$idServicio])&&$_SESSION['solicitud_servicios'][$idServicio]>0){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto   = db_select_data (false, 'Nombre,idProveedor', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				$_SESSION['solicitud_servicios'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['solicitud_servicios'][$idServicio]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_servicios'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_servicios'][$idServicio]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['solicitud_servicios'][$idServicio]['idProveedor']   = $rowProducto['idProveedor'];
				$_SESSION['solicitud_servicios'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se traen los datos del producto
				$rowProducto   = db_select_data (false, 'Nombre,idProveedor', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				//Borro el producto
				unset($_SESSION['solicitud_servicios'][$oldidProducto]);

				//creo el producto
				$_SESSION['solicitud_servicios'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['solicitud_servicios'][$idServicio]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_servicios'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_servicios'][$idServicio]['Nombre']        = $rowProducto['Nombre'];
				$_SESSION['solicitud_servicios'][$idServicio]['idProveedor']   = $rowProducto['idProveedor'];
				$_SESSION['solicitud_servicios'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_servicio_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_servicios'][$_GET['del_servicio']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['solicitud_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['solicitud_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***************************************/
				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				$_SESSION['solicitud_otros'][$idInterno]['idOtros']       = $idInterno;
				$_SESSION['solicitud_otros'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['solicitud_otros'][$idInterno]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_otros'][$idInterno]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_otros'][$idInterno]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***************************************/
				// Se traen los datos del producto
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************************************/
				//creo el producto
				$_SESSION['solicitud_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['solicitud_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['solicitud_otros'][$oldidProducto]['Cantidad']      = $Cantidad;
				$_SESSION['solicitud_otros'][$oldidProducto]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['solicitud_otros'][$oldidProducto]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['solicitud_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'ing_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$valor = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['solicitud_basicos'])){
				if(!isset($_SESSION['solicitud_basicos']['idSistema']) OR $_SESSION['solicitud_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['solicitud_basicos']['idUsuario']) OR $_SESSION['solicitud_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['solicitud_basicos']['Creacion_fecha']) OR $_SESSION['solicitud_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['solicitud_basicos']['Observaciones']) OR $_SESSION['solicitud_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la solicitud';
			}
			/*********************************************/
			//Se verifican arriendos
			if (isset($_SESSION['solicitud_arriendos'])){
				foreach ($_SESSION['solicitud_arriendos'] as $key => $producto){
					$valor++;
				}
			}
			//Se verifican insumos
			if (isset($_SESSION['solicitud_insumos'])){
				foreach ($_SESSION['solicitud_insumos'] as $key => $producto){
					$valor++;
				}
			}
			//Se verifican otros
			if (isset($_SESSION['solicitud_otros'])){
				foreach ($_SESSION['solicitud_otros'] as $key => $producto){
					$valor++;
				}
			}
			//Se verifican productos
			if (isset($_SESSION['solicitud_productos'])){
				foreach ($_SESSION['solicitud_productos'] as $key => $producto){
					$valor++;
				}
			}
			//Se verifican servicios
			if (isset($_SESSION['solicitud_servicios'])){
				foreach ($_SESSION['solicitud_servicios'] as $key => $producto){
					$valor++;
				}
			}

			/*********************************************/
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos'] = 'error/No se ha asignado nada a solicitar';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){      $SIS_data  = "'".$_SESSION['solicitud_basicos']['idSistema']."'";   }else{$SIS_data  ="''";}
				if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['solicitud_basicos']['Observaciones']) && $_SESSION['solicitud_basicos']['Observaciones']!=''){ $SIS_data .= ",'".$_SESSION['solicitud_basicos']['Observaciones']."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUsuario,Creacion_fecha, Creacion_mes, Creacion_ano, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Insumos
					if(isset($_SESSION['solicitud_insumos'])){
						foreach ($_SESSION['solicitud_insumos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){   $SIS_data .= ",'".$producto['idProducto']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){       $SIS_data .= ",'".$producto['Cantidad']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['idProveedor']) && $producto['idProveedor']!=''){ $SIS_data .= ",'".$producto['idProveedor']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idProducto, Cantidad, idProveedor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado_existencias_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Productos
					if(isset($_SESSION['solicitud_productos'])){
						foreach ($_SESSION['solicitud_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){   $SIS_data .= ",'".$producto['idProducto']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){       $SIS_data .= ",'".$producto['Cantidad']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['idProveedor']) && $producto['idProveedor']!=''){ $SIS_data .= ",'".$producto['idProveedor']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idProducto, Cantidad, idProveedor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado_existencias_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Arriendos
					if(isset($_SESSION['solicitud_arriendos'])){
						foreach ($_SESSION['solicitud_arriendos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idEquipo']) && $producto['idEquipo']!=''){           $SIS_data .= ",'".$producto['idEquipo']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idProveedor']) && $producto['idProveedor']!=''){     $SIS_data .= ",'".$producto['idProveedor']."'";   }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idEquipo, Cantidad, idFrecuencia, idProveedor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado_existencias_arriendos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Servicios
					if(isset($_SESSION['solicitud_servicios'])){
						foreach ($_SESSION['solicitud_servicios'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){       $SIS_data .= ",'".$producto['idServicio']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['idProveedor']) && $producto['idProveedor']!=''){     $SIS_data .= ",'".$producto['idProveedor']."'";   }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, idServicio, Cantidad, idFrecuencia, idProveedor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado_existencias_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Otros
					if(isset($_SESSION['solicitud_otros'])){
						foreach ($_SESSION['solicitud_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                       $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['solicitud_basicos']['idSistema']) && $_SESSION['solicitud_basicos']['idSistema']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idSistema']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['idUsuario']) && $_SESSION['solicitud_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['solicitud_basicos']['idUsuario']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['solicitud_basicos']['Creacion_fecha']) && $_SESSION['solicitud_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['solicitud_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['solicitud_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){               $SIS_data .= ",'".$producto['Nombre']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, idSistema, idUsuario, Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre,Cantidad, idFrecuencia';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'solicitud_listado_existencias_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['solicitud_basicos']);
					unset($_SESSION['solicitud_arriendos']);
					unset($_SESSION['solicitud_insumos']);
					unset($_SESSION['solicitud_otros']);
					unset($_SESSION['solicitud_productos']);
					unset($_SESSION['solicitud_servicios']);
					unset($_SESSION['solicitud_temporal']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'edit_Productos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idProducto='".$idProducto."'";
				if(isset($idProveedor) && $idProveedor!=''){  $SIS_data .= ",idProveedor='".$idProveedor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_productos', 'idOcompra=0 AND idProducto="'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_Insumos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idProducto='".$idProducto."'";
				if(isset($idProveedor) && $idProveedor!=''){  $SIS_data .= ",idProveedor='".$idProveedor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_insumos', 'idOcompra=0 AND idProducto="'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_Arriendos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idEquipo='".$idEquipo."'";
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_arriendos', 'idOcompra=0 AND idEquipo="'.$idEquipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_Servicios':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idServicio='".$idServicio."'";
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_servicios', 'idOcompra=0 AND idServicio="'.$idServicio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}
		break;
/*******************************************************************************************************************/
		case 'edit_Otros':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_otros', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}
		break;
/*******************************************************************************************************************/
		case 'crear_oc':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**************************************************************/
				//Borro todas las sesiones
				unset($_SESSION['ocompra_basicos']);
				unset($_SESSION['ocompra_arriendos']);
				unset($_SESSION['ocompra_insumos']);
				unset($_SESSION['ocompra_productos']);
				unset($_SESSION['ocompra_servicios']);
				unset($_SESSION['ocompra_temporal']);
				unset($_SESSION['ocompra_documentos']);
				unset($_SESSION['ocompra_archivos']);
				unset($_SESSION['ocompra_otros']);
				unset($_SESSION['ocompra_sol_rel']);

				/**************************************************************/
				// Se trae un listado con todos los productos
				$SIS_query = '
				solicitud_listado_existencias_productos.idExistencia,
				solicitud_listado_existencias_productos.idSolicitud,
				solicitud_listado_existencias_productos.idProducto,
				solicitud_listado_existencias_productos.Cantidad,
				productos_listado.Nombre AS NombreProd,
				productos_listado.ValorIngreso AS Valor,
				core_sistemas.Nombre AS Sistema,
				sistema_productos_uml.Nombre AS Medida,
				solicitud_listado_existencias_productos.idProducto AS idProdSol';
				$SIS_join  = '
				LEFT JOIN `productos_listado`      ON productos_listado.idProducto   = solicitud_listado_existencias_productos.idProducto
				LEFT JOIN `core_sistemas`          ON core_sistemas.idSistema        = solicitud_listado_existencias_productos.idSistema
				LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml    = productos_listado.idUml';
				$SIS_where = 'solicitud_listado_existencias_productos.idOcompra=0 AND solicitud_listado_existencias_productos.idProveedor='.$idProveedor;
				$SIS_order = 'solicitud_listado_existencias_productos.idExistencia ASC';
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************/
				// Se trae un listado con todos los insumos
				$SIS_query = '
				solicitud_listado_existencias_insumos.idExistencia,
				solicitud_listado_existencias_insumos.idSolicitud,
				solicitud_listado_existencias_insumos.idProducto,
				solicitud_listado_existencias_insumos.Cantidad,
				insumos_listado.Nombre AS NombreProd,
				insumos_listado.ValorIngreso AS Valor,
				core_sistemas.Nombre AS Sistema,
				sistema_productos_uml.Nombre AS Medida,
				solicitud_listado_existencias_insumos.idProducto AS idProdSol';
				$SIS_join  = '
				LEFT JOIN `insumos_listado`        ON insumos_listado.idProducto    = solicitud_listado_existencias_insumos.idProducto
				LEFT JOIN `core_sistemas`          ON core_sistemas.idSistema       = solicitud_listado_existencias_insumos.idSistema
				LEFT JOIN `sistema_productos_uml`  ON sistema_productos_uml.idUml   = insumos_listado.idUml';
				$SIS_where = 'solicitud_listado_existencias_insumos.idOcompra=0 AND solicitud_listado_existencias_insumos.idProveedor='.$idProveedor;
				$SIS_order = 'solicitud_listado_existencias_insumos.idExistencia ASC';
				$arrInsumos = array();
				$arrInsumos = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************/
				// Se trae un listado con todos los maquinas arriendo
				$SIS_query = '
				solicitud_listado_existencias_arriendos.idExistencia,
				solicitud_listado_existencias_arriendos.idSolicitud,
				solicitud_listado_existencias_arriendos.idEquipo,
				solicitud_listado_existencias_arriendos.Cantidad,
				solicitud_listado_existencias_arriendos.idFrecuencia,
				equipos_arriendo_listado.Nombre AS NombreProd,
				equipos_arriendo_listado.ValorIngreso AS Valor,
				core_sistemas.Nombre AS Sistema,
				core_tiempo_frecuencia.Nombre AS Medida,
				solicitud_listado_existencias_arriendos.idEquipo AS idProdSol';
				$SIS_join  = '
				LEFT JOIN `equipos_arriendo_listado`  ON equipos_arriendo_listado.idEquipo     = solicitud_listado_existencias_arriendos.idEquipo
				LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema               = solicitud_listado_existencias_arriendos.idSistema
				LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_arriendos.idFrecuencia';
				$SIS_where = 'solicitud_listado_existencias_arriendos.idOcompra=0 AND solicitud_listado_existencias_arriendos.idProveedor='.$idProveedor;
				$SIS_order = 'solicitud_listado_existencias_arriendos.idExistencia ASC';
				$arrMaquinasArriendo = array();
				$arrMaquinasArriendo = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_arriendos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************/
				// Se trae un listado con todos los servicios
				$SIS_query = '
				solicitud_listado_existencias_servicios.idExistencia,
				solicitud_listado_existencias_servicios.idSolicitud,
				solicitud_listado_existencias_servicios.idServicio,
				solicitud_listado_existencias_servicios.Cantidad,
				solicitud_listado_existencias_servicios.idFrecuencia,
				servicios_listado.Nombre AS NombreProd,
				servicios_listado.ValorIngreso AS Valor,
				core_sistemas.Nombre AS Sistema,
				core_tiempo_frecuencia.Nombre AS Medida,
				solicitud_listado_existencias_servicios.idServicio AS idProdSol';
				$SIS_join  = '
				LEFT JOIN `servicios_listado`         ON servicios_listado.idServicio           = solicitud_listado_existencias_servicios.idServicio
				LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema                = solicitud_listado_existencias_servicios.idSistema
				LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia    = solicitud_listado_existencias_servicios.idFrecuencia';
				$SIS_where = 'solicitud_listado_existencias_servicios.idOcompra=0
				AND solicitud_listado_existencias_servicios.idProveedor='.$idProveedor;
				$SIS_order = 'solicitud_listado_existencias_servicios.idExistencia ASC';
				$arrServicios = array();
				$arrServicios = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_servicios', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************/
				// Se trae un listado con todos los otros
				$SIS_query = '
				solicitud_listado_existencias_otros.idExistencia,
				solicitud_listado_existencias_otros.idSolicitud,
				solicitud_listado_existencias_otros.Cantidad,
				solicitud_listado_existencias_otros.Nombre AS NombreProd,
				solicitud_listado_existencias_otros.idFrecuencia,
				core_tiempo_frecuencia.Nombre AS Medida,
				core_sistemas.Nombre AS Sistema';
				$SIS_join  = '
				LEFT JOIN `core_tiempo_frecuencia`    ON core_tiempo_frecuencia.idFrecuencia   = solicitud_listado_existencias_otros.idFrecuencia
				LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema               = solicitud_listado_existencias_otros.idSistema';
				$SIS_where = 'solicitud_listado_existencias_otros.idOcompra=0
				AND solicitud_listado_existencias_otros.idProveedor='.$idProveedor;
				$SIS_order = 'solicitud_listado_existencias_otros.idExistencia ASC';
				$arrOtros = array();
				$arrOtros = db_select_array (false, $SIS_query, 'solicitud_listado_existencias_otros', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**************************************************************/
				if(isset($idProveedor) && $idProveedor!=''){
					// consulto los datos
					$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor = "'.$idProveedor.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['ocompra_basicos']['Proveedor'] = $rowProveedor['Nombre'];
				}else{
					$_SESSION['ocompra_basicos']['Proveedor'] = '';
				}
				/********************************************************************************/
				if(isset($idUsuario) && $idUsuario!=''){
					// consulto los datos
					$rowData = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario = "'.$idUsuario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se guarda dato
					$_SESSION['ocompra_basicos']['Usuario'] = $rowData['Nombre'];
				}else{
					$_SESSION['ocompra_basicos']['Usuario'] = '';
				}

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="OC Generada a partir de Solicitudes";}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['ocompra_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['ocompra_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['ocompra_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['ocompra_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){  $_SESSION['ocompra_basicos']['Creacion_fecha']  = $Creacion_fecha; }else{$_SESSION['ocompra_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['ocompra_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['ocompra_basicos']['Observaciones']   = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['ocompra_basicos']['idEstado']        = $idEstado;       }else{$_SESSION['ocompra_basicos']['idEstado']        = '';}
				if(isset($idProveedor)&&$idProveedor!=''){        $_SESSION['ocompra_basicos']['idProveedor']     = $idProveedor;    }else{$_SESSION['ocompra_basicos']['idProveedor']     = '';}
				$_SESSION['ocompra_basicos']['Solicitud']       = 1;

				/*************************************************************/
				//Productos
				foreach ($arrProductos as $prod) {
					//Guardo los datos en variables
					$_SESSION['ocompra_productos'][$prod['idProducto']]['idProducto']  = $prod['idProducto'];
					$_SESSION['ocompra_productos'][$prod['idProducto']]['Nombre']      = $prod['NombreProd'];
					$_SESSION['ocompra_productos'][$prod['idProducto']]['vUnitario']   = $prod['Valor'];
					$_SESSION['ocompra_productos'][$prod['idProducto']]['Frecuencia']  = $prod['Medida'];

					//cantidad y valor total
					if(isset($_SESSION['ocompra_productos'][$prod['idProducto']]['Cantidad'])){
						$_SESSION['ocompra_productos'][$prod['idProducto']]['Cantidad'] = $_SESSION['ocompra_productos'][$prod['idProducto']]['Cantidad'] + $prod['Cantidad'];
						$xcant = $_SESSION['ocompra_productos'][$prod['idProducto']]['Cantidad'] + $prod['Cantidad'];
					}else{
						$_SESSION['ocompra_productos'][$prod['idProducto']]['Cantidad'] = $prod['Cantidad'];
						$xcant = $prod['Cantidad'];
					}
					$_SESSION['ocompra_productos'][$prod['idProducto']]['vTotal']      = $prod['Valor']*$xcant;
				}

				/*************************************************************/
				//Insumos
				foreach ($arrInsumos as $prod) {
					//Guardo los datos en variables
					$_SESSION['ocompra_insumos'][$prod['idProducto']]['idProducto']  = $prod['idProducto'];
					$_SESSION['ocompra_insumos'][$prod['idProducto']]['Nombre']      = $prod['NombreProd'];
					$_SESSION['ocompra_insumos'][$prod['idProducto']]['vUnitario']   = $prod['Valor'];
					$_SESSION['ocompra_insumos'][$prod['idProducto']]['Frecuencia']  = $prod['Medida'];

					//cantidad y valor total
					if(isset($_SESSION['ocompra_insumos'][$prod['idProducto']]['Cantidad'])){
						$_SESSION['ocompra_insumos'][$prod['idProducto']]['Cantidad'] = $_SESSION['ocompra_insumos'][$prod['idProducto']]['Cantidad'] + $prod['Cantidad'];
						$xcant = $_SESSION['ocompra_insumos'][$prod['idProducto']]['Cantidad'] + $prod['Cantidad'];
					}else{
						$_SESSION['ocompra_insumos'][$prod['idProducto']]['Cantidad'] = $prod['Cantidad'];
						$xcant = $prod['Cantidad'];
					}
					$_SESSION['ocompra_insumos'][$prod['idProducto']]['vTotal']      = $prod['Valor']*$xcant;
				}
				/*************************************************************/
				//Arriendos
				foreach ($arrMaquinasArriendo as $prod) {
					//Guardo los datos en variables
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['idEquipo']      = $prod['idEquipo'];
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Equipo']        = $prod['NombreProd'];
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['idFrecuencia']  = $prod['idFrecuencia'];
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['vUnitario']     = $prod['Valor'];
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Frecuencia']    = $prod['Medida'];

					//cantidad y valor total
					if(isset($_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Cantidad'])){
						$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Cantidad'] = $_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Cantidad'] + $prod['Cantidad'];
						$xcant = $_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Cantidad'] + $prod['Cantidad'];
					}else{
						$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['Cantidad'] = $prod['Cantidad'];
						$xcant = $prod['Cantidad'];
					}
					$_SESSION['ocompra_arriendos'][$prod['idEquipo']]['vTotal']        = $prod['Valor']*$xcant;
				}
				/*************************************************************/
				//Servicios
				foreach ($arrServicios as $prod) {
					//Guardo los datos en variables
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['idServicio']    = $prod['idServicio'];
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['Servicio']      = $prod['NombreProd'];
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['idFrecuencia']  = $prod['idFrecuencia'];
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['vUnitario']     = $prod['Valor'];
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['Frecuencia']    = $prod['Medida'];

					//cantidad y valor total
					if(isset($_SESSION['ocompra_servicios'][$prod['idServicio']]['Cantidad'])){
						$_SESSION['ocompra_servicios'][$prod['idServicio']]['Cantidad'] = $_SESSION['ocompra_servicios'][$prod['idServicio']]['Cantidad'] + $prod['Cantidad'];
						$xcant = $_SESSION['ocompra_servicios'][$prod['idServicio']]['Cantidad'] + $prod['Cantidad'];
					}else{
						$_SESSION['ocompra_servicios'][$prod['idServicio']]['Cantidad'] = $prod['Cantidad'];
						$xcant = $prod['Cantidad'];
					}
					$_SESSION['ocompra_servicios'][$prod['idServicio']]['vTotal']        = $prod['Valor']*$xcant;
				}
				/*************************************************************/
				//Otros
				$cantidad_x = 1;
				foreach ($arrOtros as $prod) {
					//Guardo los datos en variables
					$_SESSION['ocompra_otros'][$cantidad_x]['idOtros']       = $cantidad_x;
					$_SESSION['ocompra_otros'][$cantidad_x]['Nombre']        = $prod['NombreProd'];
					$_SESSION['ocompra_otros'][$cantidad_x]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_otros'][$cantidad_x]['idFrecuencia']  = $prod['idFrecuencia'];
					$_SESSION['ocompra_otros'][$cantidad_x]['Frecuencia']    = $prod['Medida'];
					$_SESSION['ocompra_otros'][$cantidad_x]['vUnitario']     = 0;
					$_SESSION['ocompra_otros'][$cantidad_x]['vTotal']        = 0;

					$cantidad_x++;
				}
				/*************************************************************/
				//Guardo en un arreglo las solicitudes relacionadas
				$idInterno = 1;
				/************************************/
				//Productos
				foreach ($arrProductos as $prod) {
					$_SESSION['ocompra_sol_rel'][$idInterno]['Type']          = 1;
					$_SESSION['ocompra_sol_rel'][$idInterno]['idExistencia']  = $prod['idExistencia'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Sistema']       = $prod['Sistema'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idSolicitud']   = $prod['idSolicitud'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['NombreProd']    = $prod['NombreProd'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Medida']        = $prod['Medida'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idProdSol']     = $prod['idProdSol'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['bvar']          = $idInterno;

					$idInterno++;
				}
				/************************************/
				//Insumos
				foreach ($arrInsumos as $prod) {
					$_SESSION['ocompra_sol_rel'][$idInterno]['Type']          = 2;
					$_SESSION['ocompra_sol_rel'][$idInterno]['idExistencia']  = $prod['idExistencia'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Sistema']       = $prod['Sistema'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idSolicitud']   = $prod['idSolicitud'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['NombreProd']    = $prod['NombreProd'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Medida']        = $prod['Medida'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idProdSol']     = $prod['idProdSol'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['bvar']          = $idInterno;

					$idInterno++;
				}
				/************************************/
				//Arriendos
				foreach ($arrMaquinasArriendo as $prod) {
					$_SESSION['ocompra_sol_rel'][$idInterno]['Type']          = 3;
					$_SESSION['ocompra_sol_rel'][$idInterno]['idExistencia']  = $prod['idExistencia'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Sistema']       = $prod['Sistema'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idSolicitud']   = $prod['idSolicitud'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['NombreProd']    = $prod['NombreProd'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Medida']        = $prod['Medida'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idProdSol']     = $prod['idProdSol'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['bvar']          = $idInterno;

					$idInterno++;
				}
				/************************************/
				//Servicios
				foreach ($arrServicios as $prod) {
					$_SESSION['ocompra_sol_rel'][$idInterno]['Type']          = 4;
					$_SESSION['ocompra_sol_rel'][$idInterno]['idExistencia']  = $prod['idExistencia'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Sistema']       = $prod['Sistema'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idSolicitud']   = $prod['idSolicitud'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['NombreProd']    = $prod['NombreProd'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Medida']        = $prod['Medida'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idProdSol']     = $prod['idProdSol'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['bvar']          = $idInterno;

					$idInterno++;
				}
				/************************************/
				//Otros
				$cantidad_x = 1;
				foreach ($arrOtros as $prod) {
					$_SESSION['ocompra_sol_rel'][$idInterno]['Type']          = 5;
					$_SESSION['ocompra_sol_rel'][$idInterno]['idExistencia']  = $prod['idExistencia'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Sistema']       = $prod['Sistema'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idSolicitud']   = $prod['idSolicitud'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['NombreProd']    = $prod['NombreProd'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Cantidad']      = $prod['Cantidad'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['Medida']        = $prod['Medida'];
					$_SESSION['ocompra_sol_rel'][$idInterno]['idProdSol']     = $cantidad_x;
					$_SESSION['ocompra_sol_rel'][$idInterno]['bvar']          = $idInterno;

					$idInterno++;
					$cantidad_x++;
				}

				//Redirijo a la pagina de las ordenes de compra
				header( 'Location: ocompra_listado.php?pagina=1&view=true&soli=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
