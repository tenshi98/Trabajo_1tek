<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-248).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idOcompra']))          $idOcompra            = $_POST['idOcompra'];
	if (!empty($_POST['idSistema']))          $idSistema            = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))          $idUsuario            = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))           $idEstado             = $_POST['idEstado'];
	if (!empty($_POST['idProveedor']))        $idProveedor          = $_POST['idProveedor'];
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
	if (!empty($_POST['vUnitario']))          $vUnitario            = $_POST['vUnitario'];
	if (!empty($_POST['vTotal']))             $vTotal               = $_POST['vTotal'];

	if (!empty($_POST['idDocPago']))          $idDocPago            = $_POST['idDocPago'];
	if (!empty($_POST['NDocPago']))           $NDocPago             = $_POST['NDocPago'];
	if (!empty($_POST['Fpago']))              $Fpago                = $_POST['Fpago'];

	if (!empty($_POST['idExistencia']))       $idExistencia         = $_POST['idExistencia'];
	if (!empty($_POST['idDocumento']))        $idDocumento          = $_POST['idDocumento'];
	if (!empty($_POST['Creacion_semana']))    $Creacion_semana      = $_POST['Creacion_semana'];

	if (!empty($_POST['Observacion']))        $Observacion          = $_POST['Observacion'];
	if (!empty($_POST['idTipo']))             $idTipo               = $_POST['idTipo'];
	if (!empty($_POST['Creacion_hora']))      $Creacion_hora        = $_POST['Creacion_hora'];

	if (!empty($_POST['type']))               $type                 = $_POST['type'];
	if (!empty($_POST['CantComp']))           $CantComp             = $_POST['CantComp'];
	if ( isset($_POST['cant_ingresada']))      $cant_ingresada       = $_POST['cant_ingresada'];

	if (!empty($_POST['idTrabajador']))       $idTrabajador         = $_POST['idTrabajador'];
	if (!empty($_POST['N_Doc']))              $N_Doc                = $_POST['N_Doc'];
	if (!empty($_POST['Descripcion']))        $Descripcion          = $_POST['Descripcion'];
	if (!empty($_POST['Valor']))              $Valor                = $_POST['Valor'];

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
			case 'idOcompra':         if(empty($idOcompra)){        $error['idOcompra']       = 'error/No ha ingresado el id';}break;
			case 'idSistema':         if(empty($idSistema)){        $error['idSistema']       = 'error/No ha seleccionado el sistema';}break;
			case 'idUsuario':         if(empty($idUsuario)){        $error['idUsuario']       = 'error/No ha seleccionado el usuario';}break;
			case 'idEstado':          if(empty($idEstado)){         $error['idEstado']        = 'error/No ha ingresado el estado';}break;
			case 'idProveedor':       if(empty($idProveedor)){      $error['idProveedor']     = 'error/No ha seleccionado al proveedor';}break;
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
			case 'vUnitario':         if(empty($vUnitario)){        $error['vUnitario']       = 'error/No ha ingresado el Nombre';}break;
			case 'vTotal':            if(empty($vTotal)){           $error['vTotal']          = 'error/No ha ingresado el Nombre';}break;

			case 'idDocPago':         if(empty($idDocPago)){        $error['idDocPago']       = 'error/No ha seleccionado el documento';}break;
			case 'NDocPago':          if(empty($NDocPago)){         $error['NDocPago']        = 'error/No ha ingresado el numero de documento';}break;
			case 'Fpago':             if(empty($Fpago)){            $error['Fpago']           = 'error/No ha ingresado la fecha del documento';}break;

			case 'idExistencia':      if(empty($idExistencia)){     $error['idExistencia']    = 'error/No ha ingresado el id existencia';}break;
			case 'idDocumento':       if(empty($idDocumento)){      $error['idDocumento']     = 'error/No ha seleccionado el documento';}break;
			case 'Creacion_semana':   if(empty($Creacion_semana)){  $error['Creacion_semana'] = 'error/No ha ingresado la semana de creación';}break;

			case 'Observacion':       if(empty($Observacion)){      $error['Observacion']     = 'error/No ha ingresado la Observacion';}break;
			case 'idTipo':            if(empty($idTipo)){           $error['idTipo']          = 'error/No ha ingresado el Tipo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Nombre) && $Nombre!=''){              $Nombre        = EstandarizarInput($Nombre);}
	if(isset($Observacion) && $Observacion!=''){     $Observacion   = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){      $error['Observacion']   = 'error/Edita Observacion, contiene palabras no permitidas';}

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
		case 'new_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['ocompra_basicos']);
				unset($_SESSION['ocompra_arriendos']);
				unset($_SESSION['ocompra_insumos']);
				unset($_SESSION['ocompra_productos']);
				unset($_SESSION['ocompra_servicios']);
				unset($_SESSION['ocompra_temporal']);
				unset($_SESSION['ocompra_documentos']);
				unset($_SESSION['ocompra_otros']);
				unset($_SESSION['ocompra_boletas']);
				unset($_SESSION['ocompra_sol_rel']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['ocompra_archivos'])){
					foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
				unset($_SESSION['ocompra_archivos']);

				//Se buscan los datos
				$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor ='.$idProveedor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowUsuario   = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario ='.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){           $_SESSION['ocompra_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['ocompra_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){           $_SESSION['ocompra_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['ocompra_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){ $_SESSION['ocompra_basicos']['Creacion_fecha']  = $Creacion_fecha; }else{$_SESSION['ocompra_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){   $_SESSION['ocompra_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['ocompra_basicos']['Observaciones']   = '';}
				if(isset($idEstado)&&$idEstado!=''){             $_SESSION['ocompra_basicos']['idEstado']        = $idEstado;       }else{$_SESSION['ocompra_basicos']['idEstado']        = '';}
				if(isset($idProveedor)&&$idProveedor!=''){       $_SESSION['ocompra_basicos']['idProveedor']     = $idProveedor;    }else{$_SESSION['ocompra_basicos']['idProveedor']     = '';}
				$_SESSION['ocompra_basicos']['Solicitud']       = 2;
				$_SESSION['ocompra_basicos']['Proveedor']       = $rowProveedor['Nombre'];
				$_SESSION['ocompra_basicos']['Usuario']         = $rowUsuario['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_basicos']);
			unset($_SESSION['ocompra_arriendos']);
			unset($_SESSION['ocompra_insumos']);
			unset($_SESSION['ocompra_productos']);
			unset($_SESSION['ocompra_servicios']);
			unset($_SESSION['ocompra_temporal']);
			unset($_SESSION['ocompra_documentos']);
			unset($_SESSION['ocompra_otros']);
			unset($_SESSION['ocompra_boletas']);
			unset($_SESSION['ocompra_sol_rel']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['ocompra_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $producto){
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
			unset($_SESSION['ocompra_archivos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro todas las sesiones
				unset($_SESSION['insumos_ing_temporal']);

				//Se buscan los datos
				$rowProveedor = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor ='.$idProveedor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowUsuario   = db_select_data (false, 'Nombre', 'usuarios_listado', '', 'idUsuario ='.$idUsuario, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idSistema)&&$idSistema!=''){           $_SESSION['ocompra_basicos']['idSistema']       = $idSistema;      }else{$_SESSION['ocompra_basicos']['idSistema']       = '';}
				if(isset($idUsuario)&&$idUsuario!=''){           $_SESSION['ocompra_basicos']['idUsuario']       = $idUsuario;      }else{$_SESSION['ocompra_basicos']['idUsuario']       = '';}
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){ $_SESSION['ocompra_basicos']['Creacion_fecha']  = $Creacion_fecha; }else{$_SESSION['ocompra_basicos']['Creacion_fecha']  = '';}
				if(isset($Observaciones)&&$Observaciones!=''){   $_SESSION['ocompra_basicos']['Observaciones']   = $Observaciones;  }else{$_SESSION['ocompra_basicos']['Observaciones']   = '';}
				if(isset($idEstado)&&$idEstado!=''){             $_SESSION['ocompra_basicos']['idEstado']        = $idEstado;       }else{$_SESSION['ocompra_basicos']['idEstado']        = '';}
				if(isset($idProveedor)&&$idProveedor!=''){       $_SESSION['ocompra_basicos']['idProveedor']     = $idProveedor;    }else{$_SESSION['ocompra_basicos']['idProveedor']     = '';}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'new_prod_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ocompra_productos'][$idProducto])&&$_SESSION['ocompra_productos'][$idProducto]>0){
				$error['productos'] = 'error/El producto que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos del producto seleccionado
				$rowProducto = db_select_data (false, 'productos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_productos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['ocompra_productos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['ocompra_productos'][$idProducto]['vUnitario']   = $vUnitario;
				$_SESSION['ocompra_productos'][$idProducto]['vTotal']      = $vTotal;
				$_SESSION['ocompra_productos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['ocompra_productos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['ocompra_productos'][$oldidProducto]);

				//Se traen los datos del producto seleccionado
				$rowProducto = db_select_data (false, 'productos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_productos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['ocompra_productos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['ocompra_productos'][$idProducto]['vUnitario']   = $vUnitario;
				$_SESSION['ocompra_productos'][$idProducto]['vTotal']      = $vTotal;
				$_SESSION['ocompra_productos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['ocompra_productos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_ins_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ocompra_insumos'][$idProducto])&&$_SESSION['ocompra_insumos'][$idProducto]>0){
				$error['productos'] = 'error/El insumo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos del producto seleccionado
				$rowProducto = db_select_data (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_insumos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['ocompra_insumos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['ocompra_insumos'][$idProducto]['vUnitario']   = $vUnitario;
				$_SESSION['ocompra_insumos'][$idProducto]['vTotal']      = $vTotal;
				$_SESSION['ocompra_insumos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['ocompra_insumos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_ins_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['ocompra_insumos'][$oldidProducto]);

				//Se traen los datos del producto seleccionado
				$rowProducto = db_select_data (false, 'insumos_listado.idProducto, insumos_listado.Nombre,sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idProducto='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_insumos'][$idProducto]['idProducto']  = $idProducto;
				$_SESSION['ocompra_insumos'][$idProducto]['Cantidad']    = $Cantidad;
				$_SESSION['ocompra_insumos'][$idProducto]['vUnitario']   = $vUnitario;
				$_SESSION['ocompra_insumos'][$idProducto]['vTotal']      = $vTotal;
				$_SESSION['ocompra_insumos'][$idProducto]['Nombre']      = $rowProducto['Nombre'];
				$_SESSION['ocompra_insumos'][$idProducto]['Unimed']      = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_ins_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_insumos'][$_GET['del_ins']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_arriendo_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ocompra_arriendos'][$idEquipo])&&$_SESSION['ocompra_arriendos'][$idEquipo]>0){
				$error['productos'] = 'error/El arriendo que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos
				$rowEquipo     = db_select_data (false, 'Nombre', 'equipos_arriendo_listado', '', 'idEquipo='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_arriendos'][$idEquipo]['idEquipo']      = $idEquipo;
				$_SESSION['ocompra_arriendos'][$idEquipo]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_arriendos'][$idEquipo]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_arriendos'][$idEquipo]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_arriendos'][$idEquipo]['vTotal']        = $vTotal;
				$_SESSION['ocompra_arriendos'][$idEquipo]['Equipo']        = $rowEquipo['Nombre'];
				$_SESSION['ocompra_arriendos'][$idEquipo]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_arriendo_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['ocompra_arriendos'][$oldidProducto]);

				//Se traen los datos
				$rowEquipo     = db_select_data (false, 'Nombre', 'equipos_arriendo_listado', '', 'idEquipo='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_arriendos'][$idEquipo]['idEquipo']      = $idEquipo;
				$_SESSION['ocompra_arriendos'][$idEquipo]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_arriendos'][$idEquipo]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_arriendos'][$idEquipo]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_arriendos'][$idEquipo]['vTotal']        = $vTotal;
				$_SESSION['ocompra_arriendos'][$idEquipo]['Equipo']        = $rowEquipo['Nombre'];
				$_SESSION['ocompra_arriendos'][$idEquipo]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_arriendo_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_arriendos'][$_GET['del_arriendo']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_servicio_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ocompra_servicios'][$idServicio])&&$_SESSION['ocompra_servicios'][$idServicio]>0){
				$error['productos'] = 'error/El servicio que intenta agregar ya existe';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos
				$rowServicio   = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_servicios'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['ocompra_servicios'][$idServicio]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_servicios'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_servicios'][$idServicio]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_servicios'][$idServicio]['vTotal']        = $vTotal;
				$_SESSION['ocompra_servicios'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['ocompra_servicios'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Borro el producto
				unset($_SESSION['ocompra_servicios'][$oldidProducto]);

				//Se traen los datos
				$rowServicio   = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_servicios'][$idServicio]['idServicio']    = $idServicio;
				$_SESSION['ocompra_servicios'][$idServicio]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_servicios'][$idServicio]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_servicios'][$idServicio]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_servicios'][$idServicio]['vTotal']        = $vTotal;
				$_SESSION['ocompra_servicios'][$idServicio]['Servicio']      = $rowServicio['Nombre'];
				$_SESSION['ocompra_servicios'][$idServicio]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_servicio_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_servicios'][$_GET['del_servicio']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_otros_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['ocompra_otros'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['ocompra_otros'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la frecuencia
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_otros'][$idInterno]['idOtros']       = $idInterno;
				$_SESSION['ocompra_otros'][$idInterno]['Nombre']        = $Nombre;
				$_SESSION['ocompra_otros'][$idInterno]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_otros'][$idInterno]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_otros'][$idInterno]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_otros'][$idInterno]['vTotal']        = $vTotal;
				$_SESSION['ocompra_otros'][$idInterno]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la frecuencia
				$rowFrecuencia = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_otros'][$oldidProducto]['idOtros']       = $oldidProducto;
				$_SESSION['ocompra_otros'][$oldidProducto]['Nombre']        = $Nombre;
				$_SESSION['ocompra_otros'][$oldidProducto]['Cantidad']      = $Cantidad;
				$_SESSION['ocompra_otros'][$oldidProducto]['idFrecuencia']  = $idFrecuencia;
				$_SESSION['ocompra_otros'][$oldidProducto]['vUnitario']     = $vUnitario;
				$_SESSION['ocompra_otros'][$oldidProducto]['vTotal']        = $vTotal;
				$_SESSION['ocompra_otros'][$oldidProducto]['Frecuencia']    = $rowFrecuencia['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_otros_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_otros'][$_GET['del_otros']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_boleta_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['ocompra_boletas'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['ocompra_boletas'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la frecuencia
				$rowTrabajador = db_select_data (false, 'Rut, Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_boletas'][$idInterno]['idBoleta']      = $idInterno;
				$_SESSION['ocompra_boletas'][$idInterno]['idTrabajador']  = $idTrabajador;
				$_SESSION['ocompra_boletas'][$idInterno]['N_Doc']         = $N_Doc;
				$_SESSION['ocompra_boletas'][$idInterno]['Descripcion']   = $Descripcion;
				$_SESSION['ocompra_boletas'][$idInterno]['Valor']         = $Valor;
				$_SESSION['ocompra_boletas'][$idInterno]['trabajador']    = $rowTrabajador['Rut'].' - '.$rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_boleta_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se traen los datos de la frecuencia
				$rowTrabajador = db_select_data (false, 'Rut, Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_boletas'][$oldidProducto]['idBoleta']      = $oldidProducto;
				$_SESSION['ocompra_boletas'][$oldidProducto]['idTrabajador']  = $idTrabajador;
				$_SESSION['ocompra_boletas'][$oldidProducto]['N_Doc']         = $N_Doc;
				$_SESSION['ocompra_boletas'][$oldidProducto]['Descripcion']   = $Descripcion;
				$_SESSION['ocompra_boletas'][$oldidProducto]['Valor']         = $Valor;
				$_SESSION['ocompra_boletas'][$oldidProducto]['trabajador']    = $rowTrabajador['Rut'].' - '.$rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_boleta_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_boletas'][$_GET['del_boleta']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_boleta_emp_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['ocompra_boletasEmp'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['ocompra_boletasEmp'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_boletasEmp'][$idInterno]['idBoleta']      = $idInterno;
				$_SESSION['ocompra_boletasEmp'][$idInterno]['Descripcion']   = $Descripcion;
				$_SESSION['ocompra_boletasEmp'][$idInterno]['Valor']         = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_boleta_emp_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_boletasEmp'][$oldidProducto]['idBoleta']      = $oldidProducto;
				$_SESSION['ocompra_boletasEmp'][$oldidProducto]['Descripcion']   = $Descripcion;
				$_SESSION['ocompra_boletasEmp'][$oldidProducto]['Valor']         = $Valor;

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_boleta_emp_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_boletasEmp'][$_GET['del_boleta_emp']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_documentos_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si existe algun otro dato
			if(!isset($_SESSION['ocompra_documentos'])){
				$idInterno = 1;
			}else{
				$idInterno = 1;
				foreach ($_SESSION['ocompra_documentos'] as $key => $producto){
					$idInterno++;
				}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se trae un listado con todos los frecuencias
				$rowDocumentos = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_documentos'][$idInterno]['idDoc']       = $idInterno;
				$_SESSION['ocompra_documentos'][$idInterno]['idDocPago']   = $idDocPago;
				$_SESSION['ocompra_documentos'][$idInterno]['NDocPago']    = $NDocPago;
				$_SESSION['ocompra_documentos'][$idInterno]['Fpago']       = $Fpago;
				$_SESSION['ocompra_documentos'][$idInterno]['vTotal']      = $vTotal;
				$_SESSION['ocompra_documentos'][$idInterno]['DocPago']     = $rowDocumentos['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'edit_documentos_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// Se trae un listado con todos los frecuencias
				$rowDocumentos = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago='.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************************/
				//creo el producto
				$_SESSION['ocompra_documentos'][$oldidProducto]['idDoc']       = $oldidProducto;
				$_SESSION['ocompra_documentos'][$oldidProducto]['idDocPago']   = $idDocPago;
				$_SESSION['ocompra_documentos'][$oldidProducto]['NDocPago']    = $NDocPago;
				$_SESSION['ocompra_documentos'][$oldidProducto]['Fpago']       = $Fpago;
				$_SESSION['ocompra_documentos'][$oldidProducto]['vTotal']      = $vTotal;
				$_SESSION['ocompra_documentos'][$oldidProducto]['DocPago']     = $rowDocumentos['Nombre'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_documentos_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ocompra_documentos'][$_GET['del_documento']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;

/*******************************************************************************************************************/
		case 'new_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['ocompra_archivos'])){
				foreach ($_SESSION['ocompra_archivos'] as $key => $trabajos){
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
						$sufijo = 'ocompra_'.genera_password_unica().'_';

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
									$_SESSION['ocompra_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['ocompra_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

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
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['ocompra_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['ocompra_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['ocompra_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;

/*******************************************************************************************************************/
		case 'ing_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$valor       = 0;
			$count_zero  = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['ocompra_basicos'])){
				if(!isset($_SESSION['ocompra_basicos']['idSistema']) OR $_SESSION['ocompra_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['ocompra_basicos']['idUsuario']) OR $_SESSION['ocompra_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['ocompra_basicos']['Creacion_fecha']) OR $_SESSION['ocompra_basicos']['Creacion_fecha']=='' ){ $error['Creacion_fecha']   = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['ocompra_basicos']['Observaciones']) OR $_SESSION['ocompra_basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['ocompra_basicos']['idProveedor']) OR $_SESSION['ocompra_basicos']['idProveedor']=='' ){       $error['idProveedor']      = 'error/No ha seleccionado un proveedor';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la Orden de Compra';
			}
			/*********************************************/
			//Se verifican arriendos
			if (isset($_SESSION['ocompra_arriendos'])){
				foreach ($_SESSION['ocompra_arriendos'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['vUnitario'])&&$producto['vUnitario']==0){$count_zero++;}
					if(isset($producto['vTotal'])&&$producto['vTotal']==0){$count_zero++;}
				}
			}
			//Se verifican insumos
			if (isset($_SESSION['ocompra_insumos'])){
				foreach ($_SESSION['ocompra_insumos'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['vUnitario'])&&$producto['vUnitario']==0){$count_zero++;}
					if(isset($producto['vTotal'])&&$producto['vTotal']==0){$count_zero++;}
				}
			}
			//Se verifican productos
			if (isset($_SESSION['ocompra_productos'])){
				foreach ($_SESSION['ocompra_productos'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['vUnitario'])&&$producto['vUnitario']==0){$count_zero++;}
					if(isset($producto['vTotal'])&&$producto['vTotal']==0){$count_zero++;}
				}
			}
			//Se verifican servicios
			if (isset($_SESSION['ocompra_servicios'])){
				foreach ($_SESSION['ocompra_servicios'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['vUnitario'])&&$producto['vUnitario']==0){$count_zero++;}
					if(isset($producto['vTotal'])&&$producto['vTotal']==0){$count_zero++;}
				}
			}
			//Se verifican otros
			if (isset($_SESSION['ocompra_otros'])){
				foreach ($_SESSION['ocompra_otros'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['vUnitario'])&&$producto['vUnitario']==0){$count_zero++;}
					if(isset($producto['vTotal'])&&$producto['vTotal']==0){$count_zero++;}
				}
			}
			//Se verifican boletas trabajadores
			if (isset($_SESSION['ocompra_boletas'])){
				foreach ($_SESSION['ocompra_boletas'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['Valor'])&&$producto['Valor']==0){$count_zero++;}
				}
			}
			//Se verifican boletas empresas
			if (isset($_SESSION['ocompra_boletasEmp'])){
				foreach ($_SESSION['ocompra_boletasEmp'] as $key => $producto){
					$valor++;
					//Se verifican valores en 0
					if(isset($producto['Valor'])&&$producto['Valor']==0){$count_zero++;}
				}
			}
			/*********************************************/
			//Se verifica el minimo de trabajos
			if(isset($valor)&&$valor==0){
				$error['trabajos'] = 'error/No se ha asignado nada a solicitar';
			}
			/*********************************************/
			//Se verifica si hay alguna solicitud sin valor asignado
			if(isset($count_zero)&&$count_zero!=0){
				$error['count_zero'] = 'error/Existen Solicitudes con valor neto o total en 0, favor verificar';
			}
			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data  = "'".$_SESSION['ocompra_basicos']['idSistema']."'";     }else{$SIS_data  = "''";}
				if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['ocompra_basicos']['Observaciones']) && $_SESSION['ocompra_basicos']['Observaciones']!=''){ $SIS_data .= ",'".$_SESSION['ocompra_basicos']['Observaciones']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ocompra_basicos']['Solicitud']) && $_SESSION['ocompra_basicos']['Solicitud']!=''){         $SIS_data .= ",'".$_SESSION['ocompra_basicos']['Solicitud']."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUsuario,idEstado, idProveedor, Creacion_fecha, Creacion_mes,
				Creacion_ano, Observaciones, Solicitud';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Insumos
					if(isset($_SESSION['ocompra_insumos'])){
						foreach ($_SESSION['ocompra_insumos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){   $SIS_data .= ",'".$producto['idProducto']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){       $SIS_data .= ",'".$producto['Cantidad']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vUnitario']) && $producto['vUnitario']!=''){     $SIS_data .= ",'".$producto['vUnitario']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){           $SIS_data .= ",'".$producto['vTotal']."'";       }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, idProducto, Cantidad, vUnitario, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Productos
					if(isset($_SESSION['ocompra_productos'])){
						foreach ($_SESSION['ocompra_productos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idProducto']) && $producto['idProducto']!=''){   $SIS_data .= ",'".$producto['idProducto']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){       $SIS_data .= ",'".$producto['Cantidad']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vUnitario']) && $producto['vUnitario']!=''){     $SIS_data .= ",'".$producto['vUnitario']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){           $SIS_data .= ",'".$producto['vTotal']."'";       }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, idProducto, Cantidad, vUnitario, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Arriendos
					if(isset($_SESSION['ocompra_arriendos'])){
						foreach ($_SESSION['ocompra_arriendos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idEquipo']) && $producto['idEquipo']!=''){           $SIS_data .= ",'".$producto['idEquipo']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['vUnitario']) && $producto['vUnitario']!=''){         $SIS_data .= ",'".$producto['vUnitario']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){               $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, idEquipo, Cantidad, idFrecuencia, vUnitario, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_arriendos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Servicios
					if(isset($_SESSION['ocompra_servicios'])){
						foreach ($_SESSION['ocompra_servicios'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idServicio']) && $producto['idServicio']!=''){       $SIS_data .= ",'".$producto['idServicio']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['vUnitario']) && $producto['vUnitario']!=''){         $SIS_data .= ",'".$producto['vUnitario']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){               $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, idServicio, Cantidad, idFrecuencia, vUnitario, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Otros
					if(isset($_SESSION['ocompra_otros'])){
						foreach ($_SESSION['ocompra_otros'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){               $SIS_data .= ",'".$producto['Nombre']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['Cantidad']) && $producto['Cantidad']!=''){           $SIS_data .= ",'".$producto['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['idFrecuencia']) && $producto['idFrecuencia']!=''){   $SIS_data .= ",'".$producto['idFrecuencia']."'";  }else{$SIS_data .= ",''";}
							if(isset($producto['vUnitario']) && $producto['vUnitario']!=''){         $SIS_data .= ",'".$producto['vUnitario']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){               $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,
							Creacion_fecha, Creacion_mes, Creacion_ano, Nombre,Cantidad, idFrecuencia,
							vUnitario, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Boletas Trabajadores
					if(isset($_SESSION['ocompra_boletas'])){
						foreach ($_SESSION['ocompra_boletas'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idTrabajador']) && $producto['idTrabajador']!=''){  $SIS_data .= ",'".$producto['idTrabajador']."'";   }else{$SIS_data .= ",''";}
							if(isset($producto['N_Doc']) && $producto['N_Doc']!=''){                $SIS_data .= ",'".$producto['N_Doc']."'";          }else{$SIS_data .= ",''";}
							if(isset($producto['Descripcion']) && $producto['Descripcion']!=''){    $SIS_data .= ",'".$producto['Descripcion']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){                $SIS_data .= ",'".$producto['Valor']."'";          }else{$SIS_data .= ",''";}
							$SIS_data .= ",'1'"; //no utilizado

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano, idTrabajador, N_Doc, Descripcion, Valor, idUso';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_boletas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Boletas Empresas
					if(isset($_SESSION['ocompra_boletasEmp'])){
						foreach ($_SESSION['ocompra_boletasEmp'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Descripcion']) && $producto['Descripcion']!=''){    $SIS_data .= ",'".$producto['Descripcion']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Valor']) && $producto['Valor']!=''){                $SIS_data .= ",'".$producto['Valor']."'";          }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano, Descripcion, Valor';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Documentos
					if(isset($_SESSION['ocompra_documentos'])){
						foreach ($_SESSION['ocompra_documentos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['idDocPago']) && $producto['idDocPago']!=''){    $SIS_data .= ",'".$producto['idDocPago']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['NDocPago']) && $producto['NDocPago']!=''){      $SIS_data .= ",'".$producto['NDocPago']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['Fpago']) && $producto['Fpago']!=''){            $SIS_data .= ",'".$producto['Fpago']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['vTotal']) && $producto['vTotal']!=''){          $SIS_data .= ",'".$producto['vTotal']."'";        }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, Creacion_semana, idDocPago, NDocPago, Fpago, vTotal';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_documentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['ocompra_archivos'])){
						foreach ($_SESSION['ocompra_archivos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Nombre']) && $producto['Nombre']!=''){    $SIS_data .= ",'".$producto['Nombre']."'";     }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,Creacion_fecha,
							Creacion_mes, Creacion_ano, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Solicitudes Relacionadas
					if(isset($_SESSION['ocompra_sol_rel'])){
						foreach ($_SESSION['ocompra_sol_rel'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                    $SIS_data  = "'".$ultimo_id."'";                                    }else{$SIS_data  = "''";}
							if(isset($_SESSION['ocompra_basicos']['idSistema']) && $_SESSION['ocompra_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idSistema']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idUsuario']) && $_SESSION['ocompra_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idUsuario']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idEstado']) && $_SESSION['ocompra_basicos']['idEstado']!=''){        $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idEstado']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['idProveedor']) && $_SESSION['ocompra_basicos']['idProveedor']!=''){  $SIS_data .= ",'".$_SESSION['ocompra_basicos']['idProveedor']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['ocompra_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($producto['Type']) && $producto['Type']!=''){                  $SIS_data .= ",'".$producto['Type']."'";          }else{$SIS_data .= ",''";}
							if(isset($producto['idExistencia']) && $producto['idExistencia']!=''){  $SIS_data .= ",'".$producto['idExistencia']."'";  }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor,
							Creacion_fecha, Creacion_mes, Creacion_ano, Type, idExistencia';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_sol_rel', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/****************************************************************/
							//Dato a Actualizar
							$SIS_data = "idOcompra='".$ultimo_id."'";

							//Actualizar OC en las tablas de solicitudes
							switch ($producto['Type']) {
								/****************************************/
								//Productos
								case 1:
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_productos', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
								/****************************************/
								//Insumos
								case 2:
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_insumos', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
								/****************************************/
								//Arriendos
								case 3:
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_arriendos', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
								/****************************************/
								//Servicios
								case 4:
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_servicios', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
								/****************************************/
								//Otros
								case 5:
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_otros', 'idExistencia = "'.$producto['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									break;
							}

						}
					}
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['ocompra_basicos']['Creacion_fecha']) && $_SESSION['ocompra_basicos']['Creacion_fecha']!=''){
						$SIS_data .= ",'".$_SESSION['ocompra_basicos']['Creacion_fecha']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                                                            //Creacion Satisfactoria
					$SIS_data .= ",'Creacion de la Orden de Compra N°".n_doc($ultimo_id, 5).", queda en espera de aprobacion'";     //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";                                          //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['ocompra_basicos']);
					unset($_SESSION['ocompra_arriendos']);
					unset($_SESSION['ocompra_insumos']);
					unset($_SESSION['ocompra_productos']);
					unset($_SESSION['ocompra_servicios']);
					unset($_SESSION['ocompra_otros']);
					unset($_SESSION['ocompra_boletas']);
					unset($_SESSION['ocompra_temporal']);
					unset($_SESSION['ocompra_documentos']);
					unset($_SESSION['ocompra_sol_rel']);
					unset($_SESSION['ocompra_archivos']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Verifico el tipo
				switch ($_GET['del_sol_type']) {
					/****************************************/
					//Productos
					case 1:
						//realizo la resta
						$_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['Cantidad'] = $_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['Cantidad'] - $_GET['del_sol_cant'];

						//Elimino en caso de que quede en 0
						if($_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['Cantidad']==0){
							//Borro todas las sesiones
							unset($_SESSION['ocompra_productos'][$_GET['del_sol_prod']]);
						//Sino Actualizo valores
						}else{
							$Cantidad = $_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['Cantidad'];
							$vUnitario = $_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['vUnitario'];
							$_SESSION['ocompra_productos'][$_GET['del_sol_prod']]['vTotal'] = $Cantidad * $vUnitario;
						}
						break;
					/****************************************/
					//Insumos
					case 2:
						$_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['Cantidad'] = $_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['Cantidad'] - $_GET['del_sol_cant'];

						//Elimino en caso de que quede en 0
						if($_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['Cantidad']==0){
							//Borro todas las sesiones
							unset($_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]);
						//Sino Actualizo valores
						}else{
							$Cantidad = $_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['Cantidad'];
							$vUnitario = $_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['vUnitario'];
							$_SESSION['ocompra_insumos'][$_GET['del_sol_prod']]['vTotal'] = $Cantidad * $vUnitario;
						}
						break;
					/****************************************/
					//Arriendos
					case 3:
						$_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['Cantidad'] = $_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['Cantidad'] - $_GET['del_sol_cant'];

						//Elimino en caso de que quede en 0
						if($_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['Cantidad']==0){
							//Borro todas las sesiones
							unset($_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]);
						//Sino Actualizo valores
						}else{
							$Cantidad = $_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['Cantidad'];
							$vUnitario = $_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['vUnitario'];
							$_SESSION['ocompra_arriendos'][$_GET['del_sol_prod']]['vTotal'] = $Cantidad * $vUnitario;
						}
						break;
					/****************************************/
					//Servicios
					case 4:
						$_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['Cantidad'] = $_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['Cantidad'] - $_GET['del_sol_cant'];

						//Elimino en caso de que quede en 0
						if($_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['Cantidad']==0){
							//Borro todas las sesiones
							unset($_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]);
						//Sino Actualizo valores
						}else{
							$Cantidad = $_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['Cantidad'];
							$vUnitario = $_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['vUnitario'];
							$_SESSION['ocompra_servicios'][$_GET['del_sol_prod']]['vTotal'] = $Cantidad * $vUnitario;
						}
						break;
					/****************************************/
					//Otros
					case 5:
						unset($_SESSION['ocompra_otros'][$_GET['del_sol_prod']]);

						break;
				}

				//Borro todas las sesiones
				unset($_SESSION['ocompra_sol_rel'][$_GET['del_solicitud']]);

				//Redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;





/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                     MODIFICACION                                                */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'update_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'proveedor_listado.Nombre AS Proveedor, ocompra_listado.idProveedor, ocompra_listado.Creacion_fecha, ocompra_listado.Observaciones', 'ocompra_listado', 'LEFT JOIN `proveedor_listado` ON proveedor_listado.idProveedor = ocompra_listado.idProveedor', 'ocompra_listado.idOcompra ='.$idOcompra, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'Nombre', 'proveedor_listado', '', 'idProveedor ='.$idProveedor, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se realizan cambios en los datos basicos de la OC ';
				if(isset($idProveedor)&&isset($rowData_1['idProveedor'])&&$idProveedor!=$rowData_1['idProveedor']){               $cambios .= ",se cambia proveedor de ".$rowData_1['Proveedor']." a ".$rowData_2['Nombre'];}
				if(isset($Creacion_fecha)&&isset($rowData_1['Creacion_fecha'])&&$Creacion_fecha!=$rowData_1['Creacion_fecha']){   $cambios .= ",se cambia fecha de ".$rowData_1['Creacion_fecha']." a ".$Creacion_fecha;}
				if(isset($Observaciones)&&isset($rowData_1['Observaciones'])&&$Observaciones!=$rowData_1['Observaciones']){       $cambios .= ",se cambia observacion ";}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){      $SIS_data .= ",'".$Fecha."'";    }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idOcompra='".$idOcompra."'";
				if(isset($idSistema) && $idSistema!=''){        $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){        $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){          $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){    $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($Observaciones) && $Observaciones!=''){   $SIS_data .= ",Observaciones='".$Observaciones."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'edit_prod_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idProducto)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_productos', '', "idOcompra='".$idOcompra."' AND idProducto='".$idProducto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idProducto) && $idProducto!=''){            $SIS_data .= ",'".$idProducto."'";  }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";    }else{$SIS_data .= ",''";}
				if(isset($vUnitario) && $vUnitario!=''){              $SIS_data .= ",'".$vUnitario."'";   }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){                    $SIS_data .= ",'".$vTotal."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano,
				idProducto, Cantidad, vUnitario, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData = db_select_data (false, 'Nombre', 'productos_listado', '', 'idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
					$cambios .= "Se agrega producto ".$rowData['Nombre']." por una cantidad de ".$Cantidad." con valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_prod_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idProducto)&&isset($idExistencia)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_productos', '', "idOcompra='".$idOcompra."' AND idProducto='".$idProducto."' AND idExistencia!='".$idExistencia."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'productos_listado', '', 'idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'ocompra_listado_existencias_productos.Cantidad, ocompra_listado_existencias_productos.vTotal, productos_listado.Nombre AS Producto', 'ocompra_listado_existencias_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = ocompra_listado_existencias_productos.idProducto', 'ocompra_listado_existencias_productos.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_2['Producto'].' por una cantidad de '.Cantidades_decimales_justos($rowData_2['Cantidad']).' con un valor total de '.Valores($rowData_2['vTotal'], 0).'';
				$cambios.= '<br/>a '.$rowData_1['Nombre'].' por una cantidad de '.$Cantidad.' con un valor total de '.Valores($vTotal, 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){      $SIS_data .= ",'".$Fecha."'";    }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idProducto) && $idProducto!=''){   $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){       $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($vUnitario) && $vUnitario!=''){     $SIS_data .= ",vUnitario='".$vUnitario."'";}
				if(isset($vTotal) && $vTotal!=''){           $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_prod_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_prod']) OR !validaEntero($_GET['del_prod']))&&$_GET['del_prod']!=''){
				$indice = simpleDecode($_GET['del_prod'], fecha_actual());
			}else{
				$indice = $_GET['del_prod'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'ocompra_listado_existencias_productos.idOcompra, ocompra_listado_existencias_productos.Cantidad, ocompra_listado_existencias_productos.vTotal, productos_listado.Nombre AS Producto', 'ocompra_listado_existencias_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = ocompra_listado_existencias_productos.idProducto', 'ocompra_listado_existencias_productos.idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_2['Producto'].' por una cantidad de '.Cantidades_decimales_justos($rowData_2['Cantidad']).' con un valor total de '.Valores($rowData_2['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_2['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_productos', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_ins_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idProducto)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_insumos', '', "idOcompra='".$idOcompra."' AND idProducto='".$idProducto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idProducto) && $idProducto!=''){            $SIS_data .= ",'".$idProducto."'";  }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";    }else{$SIS_data .= ",''";}
				if(isset($vUnitario) && $vUnitario!=''){              $SIS_data .= ",'".$vUnitario."'";   }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){                    $SIS_data .= ",'".$vTotal."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano, 
				idProducto, Cantidad, vUnitario, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData = db_select_data (false, 'Nombre', 'insumos_listado', '', 'idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
					$cambios .= "Se agrega insumo ".$rowData['Nombre']." por una cantidad de ".$Cantidad." con valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){      $SIS_data .= ",'".$Fecha."'";    }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_ins_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idProducto)&&isset($idExistencia)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_insumos', '', "idOcompra='".$idOcompra."' AND idProducto='".$idProducto."' AND idExistencia!='".$idExistencia."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'insumos_listado', '', 'idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'ocompra_listado_existencias_insumos.Cantidad, ocompra_listado_existencias_insumos.vTotal, insumos_listado.Nombre AS Producto', 'ocompra_listado_existencias_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = ocompra_listado_existencias_insumos.idProducto', 'ocompra_listado_existencias_insumos.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_2['Producto'].' por una cantidad de '.Cantidades_decimales_justos($rowData_2['Cantidad']).' con un valor total de '.Valores($rowData_2['vTotal'], 0).'';
				$cambios.= '<br/>a '.$rowData_1['Nombre'].' por una cantidad de '.$Cantidad.' con un valor total de '.Valores($vTotal, 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idProducto) && $idProducto!=''){   $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){       $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($vUnitario) && $vUnitario!=''){     $SIS_data .= ",vUnitario='".$vUnitario."'";}
				if(isset($vTotal) && $vTotal!=''){           $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_ins_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_ins']) OR !validaEntero($_GET['del_ins']))&&$_GET['del_ins']!=''){
				$indice = simpleDecode($_GET['del_ins'], fecha_actual());
			}else{
				$indice = $_GET['del_ins'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'ocompra_listado_existencias_insumos.idOcompra, ocompra_listado_existencias_insumos.Cantidad, ocompra_listado_existencias_insumos.vTotal, insumos_listado.Nombre AS Producto', 'ocompra_listado_existencias_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = ocompra_listado_existencias_insumos.idProducto', 'ocompra_listado_existencias_insumos.idExistencia = '.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_2['Producto'].' por una cantidad de '.Cantidades_decimales_justos($rowData_2['Cantidad']).' con un valor total de '.Valores($rowData_2['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_2['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_arriendo_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idEquipo)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_arriendos', '', "idOcompra='".$idOcompra."' AND idEquipo='".$idEquipo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Arriendo ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idEquipo) && $idEquipo!=''){                $SIS_data .= ",'".$idEquipo."'";      }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";      }else{$SIS_data .= ",''";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){        $SIS_data .= ",'".$idFrecuencia."'";  }else{$SIS_data .= ",''";}
				if(isset($vUnitario) && $vUnitario!=''){              $SIS_data .= ",'".$vUnitario."'";     }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){                    $SIS_data .= ",'".$vTotal."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano, 
				idEquipo, Cantidad, idFrecuencia, vUnitario, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_arriendos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'equipos_arriendo_listado', '', 'idEquipo ='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData_1['Nombre'])&&$rowData_1['Nombre']!=''&&isset($rowData_2['Nombre'])&&$rowData_2['Nombre']!=''){
					$cambios .= "Se agrega arriendo ".$rowData_1['Nombre']." por ".$Cantidad." ".$rowData_2['Nombre']." con valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_arriendo_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idEquipo)&&isset($idExistencia)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_arriendos', '', "idOcompra='".$idOcompra."' AND idEquipo='".$idEquipo."' AND idExistencia!='".$idExistencia."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Arriendo ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'equipos_arriendo_listado', '', 'idEquipo ='.$idEquipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_arriendos.Cantidad, ocompra_listado_existencias_arriendos.vTotal, equipos_arriendo_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_arriendos', 'LEFT JOIN `equipos_arriendo_listado` ON equipos_arriendo_listado.idEquipo = ocompra_listado_existencias_arriendos.idEquipo LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_arriendos.idFrecuencia', 'ocompra_listado_existencias_arriendos.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_3['Producto'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';
				$cambios.= '<br/>a '.$rowData_1['Nombre'].' por '.$Cantidad.' '.$rowData_2['Nombre'].' con un valor total de '.Valores($vTotal, 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idEquipo) && $idEquipo!=''){             $SIS_data .= ",idEquipo='".$idEquipo."'";}
				if(isset($Cantidad) && $Cantidad!=''){             $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){     $SIS_data .= ",idFrecuencia='".$idFrecuencia."'";}
				if(isset($vUnitario) && $vUnitario!=''){           $SIS_data .= ",vUnitario='".$vUnitario."'";}
				if(isset($vTotal) && $vTotal!=''){                 $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_arriendo_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_arriendo']) OR !validaEntero($_GET['del_arriendo']))&&$_GET['del_arriendo']!=''){
				$indice = simpleDecode($_GET['del_arriendo'], fecha_actual());
			}else{
				$indice = $_GET['del_arriendo'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_arriendos.idOcompra, ocompra_listado_existencias_arriendos.Cantidad, ocompra_listado_existencias_arriendos.vTotal, equipos_arriendo_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_arriendos', 'LEFT JOIN `equipos_arriendo_listado` ON equipos_arriendo_listado.idEquipo = ocompra_listado_existencias_arriendos.idEquipo LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_arriendos.idFrecuencia', 'ocompra_listado_existencias_arriendos.idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_3['Producto'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_3['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_arriendos', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_servicio_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idServicio)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_servicios', '', "idOcompra='".$idOcompra."' AND idServicio='".$idServicio."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Servicio ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idServicio) && $idServicio!=''){            $SIS_data .= ",'".$idServicio."'";    }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";      }else{$SIS_data .= ",''";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){        $SIS_data .= ",'".$idFrecuencia."'";  }else{$SIS_data .= ",''";}
				if(isset($vUnitario) && $vUnitario!=''){              $SIS_data .= ",'".$vUnitario."'";     }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){                    $SIS_data .= ",'".$vTotal."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano, 
				idServicio, Cantidad, idFrecuencia, vUnitario, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_servicios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio ='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData_1['Nombre'])&&$rowData_1['Nombre']!=''&&isset($rowData_2['Nombre'])&&$rowData_2['Nombre']!=''){
					$cambios .= "Se agrega servicio ".$rowData_1['Nombre']." por ".$Cantidad." ".$rowData_2['Nombre']." con valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_servicio_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&isset($idServicio)&&isset($idExistencia)){
				$ndata_1 = db_select_nrows (false, 'idExistencia', 'ocompra_listado_existencias_servicios', '', "idOcompra='".$idOcompra."' AND idServicio='".$idServicio."' AND idExistencia!='".$idExistencia."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Servicio ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_1 = db_select_data (false, 'Nombre', 'servicios_listado', '', 'idServicio ='.$idServicio, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_servicios.idServicio, ocompra_listado_existencias_servicios.idFrecuencia, ocompra_listado_existencias_servicios.Cantidad, ocompra_listado_existencias_servicios.vTotal, servicios_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_servicios', 'LEFT JOIN `servicios_listado` ON servicios_listado.idServicio = ocompra_listado_existencias_servicios.idServicio LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_servicios.idFrecuencia', 'ocompra_listado_existencias_servicios.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_3['Producto'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';
				$cambios.= '<br/>a '.$rowData_1['Nombre'].' por '.$Cantidad.' '.$rowData_2['Nombre'].' con un valor total de '.Valores($vTotal, 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idServicio) && $idServicio!=''){         $SIS_data .= ",idServicio='".$idServicio."'";}
				if(isset($Cantidad) && $Cantidad!=''){             $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){     $SIS_data .= ",idFrecuencia='".$idFrecuencia."'";}
				if(isset($vUnitario) && $vUnitario!=''){           $SIS_data .= ",vUnitario='".$vUnitario."'";}
				if(isset($vTotal) && $vTotal!=''){                 $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_servicio_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_servicio']) OR !validaEntero($_GET['del_servicio']))&&$_GET['del_servicio']!=''){
				$indice = simpleDecode($_GET['del_servicio'], fecha_actual());
			}else{
				$indice = $_GET['del_servicio'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_servicios.idOcompra, ocompra_listado_existencias_servicios.Cantidad, ocompra_listado_existencias_servicios.vTotal, servicios_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_servicios', 'LEFT JOIN `servicios_listado` ON servicios_listado.idServicio = ocompra_listado_existencias_servicios.idServicio LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_servicios.idFrecuencia', 'ocompra_listado_existencias_servicios.idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_3['Producto'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha      = fecha_actual();
				$idOcompra  = $rowData_3['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_otros_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($Nombre) && $Nombre!=''){                    $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";      }else{$SIS_data .= ",''";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){        $SIS_data .= ",'".$idFrecuencia."'";  }else{$SIS_data .= ",''";}
				if(isset($vUnitario) && $vUnitario!=''){              $SIS_data .= ",'".$vUnitario."'";     }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){                    $SIS_data .= ",'".$vTotal."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano,
				Nombre,Cantidad, idFrecuencia, vUnitario, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_otros', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData_2['Nombre'])&&$rowData_2['Nombre']!=''){
					$cambios .= "Se agrega otro ".$Nombre." por ".$Cantidad." ".$rowData_2['Nombre']." con valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_otros_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre', 'core_tiempo_frecuencia', '', 'idFrecuencia ='.$idFrecuencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_otros.Cantidad, ocompra_listado_existencias_otros.vTotal, ocompra_listado_existencias_otros.Nombre,core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_otros', 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_otros.idFrecuencia', 'ocompra_listado_existencias_otros.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_3['Nombre'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';
				$cambios.= '<br/>a '.$Nombre.' por '.$Cantidad.' '.$rowData_2['Nombre'].' con un valor total de '.Valores($vTotal, 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($Nombre) && $Nombre!=''){                 $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Cantidad) && $Cantidad!=''){             $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){     $SIS_data .= ",idFrecuencia='".$idFrecuencia."'";}
				if(isset($vUnitario) && $vUnitario!=''){           $SIS_data .= ",vUnitario='".$vUnitario."'";}
				if(isset($vTotal) && $vTotal!=''){                 $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}

			}

		break;

/*******************************************************************************************************************/
		case 'edit_otros_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_otros']) OR !validaEntero($_GET['del_otros']))&&$_GET['del_otros']!=''){
				$indice = simpleDecode($_GET['del_otros'], fecha_actual());
			}else{
				$indice = $_GET['del_otros'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_otros.idOcompra, ocompra_listado_existencias_otros.Cantidad, ocompra_listado_existencias_otros.vTotal, ocompra_listado_existencias_otros.Nombre,core_tiempo_frecuencia.Nombre AS Frecuencia', 'ocompra_listado_existencias_otros', 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia  = ocompra_listado_existencias_otros.idFrecuencia', 'ocompra_listado_existencias_otros.idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_3['Nombre'].' por '.Cantidades_decimales_justos($rowData_3['Cantidad']).' '.$rowData_3['Frecuencia'].' con un valor total de '.Valores($rowData_3['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_3['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_otros', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_boleta_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idTrabajador) && $idTrabajador!=''){   $SIS_data .= ",'".$idTrabajador."'";  }else{$SIS_data .= ",''";}
				if(isset($N_Doc) && $N_Doc!=''){                 $SIS_data .= ",'".$N_Doc."'";         }else{$SIS_data .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){     $SIS_data .= ",'".$Descripcion."'";   }else{$SIS_data .= ",''";}
				if(isset($Valor) && $Valor!=''){                 $SIS_data .= ",'".$Valor."'";         }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'"; //no utilizado

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano, idTrabajador, N_Doc, Descripcion,
				Valor, idUso';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_boletas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData_2['Nombre'])&&$rowData_2['Nombre']!=''&&isset($rowData_2['ApellidoPat'])&&$rowData_2['ApellidoPat']!=''){
					$cambios .= "Se agrega boleta honorarios N° ".$N_Doc." del trabajador ".$rowData_2['Nombre']." ".$rowData_2['ApellidoPat']." con valor total de ".Valores($Valor, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_boleta_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = '.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_boletas.N_Doc, ocompra_listado_existencias_boletas.Valor, trabajadores_listado.Nombre AS TrabNombre,trabajadores_listado.ApellidoPat AS TrabApellidoPat', 'ocompra_listado_existencias_boletas', 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador   = ocompra_listado_existencias_boletas.idTrabajador', 'ocompra_listado_existencias_boletas.idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia la boleta de honorarios N° '.$rowData_3['N_Doc'].' del trabajador '.$rowData_3['TrabNombre'].' '.$rowData_3['TrabApellidoPat'].' con un valor total de '.Valores($rowData_3['Valor'], 0).'';
				$cambios.= '<br/>a boleta de honorarios N° '.$N_Doc.' del trabajador '.$rowData_2['Nombre'].' '.$rowData_2['ApellidoPat'].' con un valor total de '.Valores($Valor, 0).'.';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($idTrabajador) && $idTrabajador!=''){  $SIS_data .= ",idTrabajador='".$idTrabajador."'";}
				if(isset($N_Doc) && $N_Doc!=''){                $SIS_data .= ",N_Doc='".$N_Doc."'";}
				if(isset($Descripcion) && $Descripcion!=''){    $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($Valor) && $Valor!=''){                $SIS_data .= ",Valor='".$Valor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_boleta_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_boleta']) OR !validaEntero($_GET['del_boleta']))&&$_GET['del_boleta']!=''){
				$indice = simpleDecode($_GET['del_boleta'], fecha_actual());
			}else{
				$indice = $_GET['del_boleta'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'ocompra_listado_existencias_boletas.N_Doc, ocompra_listado_existencias_boletas.Valor, trabajadores_listado.Nombre AS TrabNombre,trabajadores_listado.ApellidoPat AS TrabApellidoPat', 'ocompra_listado_existencias_boletas', 'LEFT JOIN `trabajadores_listado`  ON trabajadores_listado.idTrabajador   = ocompra_listado_existencias_boletas.idTrabajador', 'ocompra_listado_existencias_boletas.idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina la boleta de honorarios N° '.$rowData_3['N_Doc'].' del trabajador '.$rowData_3['TrabNombre'].' '.$rowData_3['TrabApellidoPat'].' con un valor total de '.Valores($rowData_3['Valor'], 0).'.';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_3['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_boletas', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_boleta_insert_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($Descripcion) && $Descripcion!=''){     $SIS_data .= ",'".$Descripcion."'";   }else{$SIS_data .= ",''";}
				if(isset($Valor) && $Valor!=''){                 $SIS_data .= ",'".$Valor."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema,
				idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano, Descripcion,Valor';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se realizan comparacion
				$cambios = "Se agrega boleta honorarios de la empresa con valor total de ".Valores($Valor, 0)."." ;

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_boleta_update_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'Valor,Descripcion', 'ocompra_listado_existencias_boletas_empresas', '', 'idExistencia ='.$idExistencia, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia la boleta de honorarios de la empresa con la descripcion '.$rowData_3['Descripcion'].' con un valor total de '.Valores($rowData_3['Valor'], 0).'';
				$cambios.= '<br/>a boleta de honorarios con la descripcion '.$Descripcion.' con un valor total de '.Valores($Valor, 0).'.';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
				}
				if(isset($Descripcion) && $Descripcion!=''){    $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($Valor) && $Valor!=''){                $SIS_data .= ",Valor='".$Valor."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_boleta_del_emp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_boleta']) OR !validaEntero($_GET['del_boleta']))&&$_GET['del_boleta']!=''){
				$indice = simpleDecode($_GET['del_boleta'], fecha_actual());
			}else{
				$indice = $_GET['del_boleta'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'Valor,Descripcion', 'ocompra_listado_existencias_boletas_empresas', '', 'idExistencia ='.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina la boleta de honorarios con la descripcion '.$rowData_3['Descripcion'].' con un valor total de '.Valores($rowData_3['Valor'], 0).'.';

				/******************************************/
				//Se guarda en historial la accion
				$fecha     = fecha_actual();
				$idOcompra = $rowData_3['idOcompra'];
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_existencias_boletas_empresas', 'idExistencia = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_documento_insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",'".$Creacion_fecha."'";
					$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
					$SIS_data .= ",'".fecha2NSemana($Creacion_fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($idDocPago) && $idDocPago!=''){      $SIS_data .= ",'".$idDocPago."'";      }else{$SIS_data .= ",''";}
				if(isset($NDocPago) && $NDocPago!=''){        $SIS_data .= ",'".$NDocPago."'";       }else{$SIS_data .= ",''";}
				if(isset($Fpago) && $Fpago!=''){              $SIS_data .= ",'".$Fpago."'";          }else{$SIS_data .= ",''";}
				if(isset($vTotal) && $vTotal!=''){            $SIS_data .= ",'".$vTotal."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano,
				Creacion_semana, idDocPago, NDocPago, Fpago, vTotal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_documentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago = '.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = '';
				if(isset($rowData_2['Nombre'])&&$rowData_2['Nombre']!=''){
					$cambios .= "Se agrega documento de pago ".$rowData_2['Nombre']." N°".$NDocPago." con fecha de pago ".$Fpago." por valor total de ".Valores($vTotal, 0)."." ;
				}

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				header( 'Location: '.$location.'&created=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_documento_update':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_2 = db_select_data (false, 'Nombre', 'sistema_documentos_pago', '', 'idDocPago = '.$idDocPago, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowData_3 = db_select_data (false, 'sistema_documentos_pago.Nombre,ocompra_listado_documentos.NDocPago, ocompra_listado_documentos.Fpago, ocompra_listado_documentos.vTotal', 'ocompra_listado_documentos', 'LEFT JOIN `sistema_documentos_pago`   ON sistema_documentos_pago.idDocPago  = ocompra_listado_documentos.idDocPago', 'ocompra_listado_documentos.idDocumento'.$idDocumento, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se cambia de '.$rowData_3['Nombre'].' N°'.$rowData_3['NDocPago'].' con fecha de pago '.$rowData_3['Fpago'].' por un valor total de '.Valores($rowData_3['vTotal'], 0).'';
				$cambios.= '<br/>a '.$rowData_2['Nombre'].' N°'.$NDocPago.' con fecha de pago '.$Fpago.' por valor total de '.Valores($vTotal, 0).'.' ;

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/

				//Filtros
				$SIS_data = "idDocumento='".$idDocumento."'";
				if(isset($idOcompra) && $idOcompra!=''){       $SIS_data .= ",idOcompra='".$idOcompra."'";}
				if(isset($idSistema) && $idSistema!=''){       $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){       $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idProveedor) && $idProveedor!=''){   $SIS_data .= ",idProveedor='".$idProveedor."'";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){
					$SIS_data .= ",Creacion_fecha='".$Creacion_fecha."'";
					$SIS_data .= ",Creacion_mes='".fecha2NMes($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_ano='".fecha2Ano($Creacion_fecha)."'";
					$SIS_data .= ",Creacion_semana='".fecha2NSemana($Creacion_fecha)."'";
				}
				if(isset($idDocPago) && $idDocPago!=''){   $SIS_data .= ",idDocPago='".$idDocPago."'";}
				if(isset($NDocPago) && $NDocPago!=''){     $SIS_data .= ",NDocPago='".$NDocPago."'";}
				if(isset($Fpago) && $Fpago!=''){           $SIS_data .= ",Fpago='".$Fpago."'";}
				if(isset($vTotal) && $vTotal!=''){         $SIS_data .= ",vTotal='".$vTotal."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idDocumento = "'.$idDocumento.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'edit_documento_del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_documento']) OR !validaEntero($_GET['del_documento']))&&$_GET['del_documento']!=''){
				$indice = simpleDecode($_GET['del_documento'], fecha_actual());
			}else{
				$indice = $_GET['del_documento'];
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
				/*********************************************************************/
				/*********************************************************************/
				//Se toman los datos
				$rowData_3 = db_select_data (false, 'sistema_documentos_pago.Nombre,ocompra_listado_documentos.NDocPago, ocompra_listado_documentos.Fpago, ocompra_listado_documentos.vTotal', 'ocompra_listado_documentos', 'LEFT JOIN `sistema_documentos_pago`   ON sistema_documentos_pago.idDocPago  = ocompra_listado_documentos.idDocPago', 'ocompra_listado_documentos.idDocumento'.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina '.$rowData_3['Nombre'].' N°'.$rowData_3['NDocPago'].' con fecha de pago '.$rowData_3['Fpago'].' por un valor total de '.Valores($rowData_3['vTotal'], 0).'';

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_documentos', 'idDocumento = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
/*******************************************************************************************************************/
		case 'edit_file_insert':

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
						$sufijo = 'ocompra_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									//Creacion del nombre del archivo
									$Nombre = $sufijo.$_FILES['exFile']['name'];

									//filtros
									if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";     }else{$SIS_data  = "''";}
									if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";    }else{$SIS_data .= ",''";}
									if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";    }else{$SIS_data .= ",''";}
									if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
									if(isset($idProveedor) && $idProveedor!=''){          $SIS_data .= ",'".$idProveedor."'";  }else{$SIS_data .= ",''";}
									if(isset($Creacion_fecha) && $Creacion_fecha!=''){
										$SIS_data .= ",'".$Creacion_fecha."'";
										$SIS_data .= ",'".fecha2NMes($Creacion_fecha)."'";
										$SIS_data .= ",'".fecha2Ano($Creacion_fecha)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									if(isset($Nombre) && $Nombre!=''){     $SIS_data .= ",'".$Nombre."'";      }else{$SIS_data .=",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idOcompra, idSistema, idUsuario, idEstado, idProveedor, Creacion_fecha, Creacion_mes, Creacion_ano, Nombre';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									/*********************************************************************/
									/*********************************************************************/
									//Se realizan comparacion
									$cambios = "Se agrega sube archivo ".$Nombre." con fecha ".$Creacion_fecha."." ;

									/******************************************/
									//Se guarda en historial la accion
									$fecha = fecha_actual();
									if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
									if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
									$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
									$SIS_data .= ",'".$cambios."'";                                          //Observacion
									$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

									// inserto los datos de registro en la db
									$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
									$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									/*********************************************************************/
									/*********************************************************************/

									header( 'Location: '.$location.'&created=true' );
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
		case 'edit_file_del':

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
				$rowData = db_select_data (false, 'Nombre', 'ocompra_listado_archivos', '', 'idFile = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//Se realizan comparacion
				$cambios = 'Se elimina archivo '.$rowData['Nombre'];

				/******************************************/
				//Se guarda en historial la accion
				$fecha = fecha_actual();
				if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
				if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
				$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
				$SIS_data .= ",'".$cambios."'";                                          //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				/*********************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'ocompra_listado_archivos', 'idFile = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Nombre']);
								unset($_SESSION['ocompra_archivos'][$indice]);
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
/*******************************************************************************************************************/
		case 'edit_del_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//siempre pasa
			$errorn = 0;

			if($errorn==0){
				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					//Verifico el tipo
					switch ($_GET['del_sol_type']) {
						/****************************************/
						//Productos
						case 1:
							//Se trae los datos
							$rowData = db_select_data (false, 'ocompra_listado_existencias_productos.idExistencia, ocompra_listado_existencias_productos.Cantidad, ocompra_listado_existencias_productos.vUnitario, productos_listado.Nombre AS Producto, sistema_productos_uml.Nombre AS Medida', 'ocompra_listado_existencias_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = ocompra_listado_existencias_productos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'ocompra_listado_existencias_productos.idOcompra = '.$_GET['view'].' AND ocompra_listado_existencias_productos.idProducto= '.$_GET['del_sol_prod'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Se realizan comparacion
							$cambios = 'Se eliminan '.$rowData['Cantidad'].' '.$rowData['Medida'].' de '.$rowData['Producto'].' de la solicitud';
							/******************************************/
							//Se guarda en historial la accion
							$fecha = fecha_actual();
							if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
							if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
							$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
							$SIS_data .= ",'".$cambios."'";                                          //Observacion
							$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Verifico cantidades
							$Resta = $rowData['Cantidad'] - $_GET['del_sol_cant'];
							//Elimino en caso de que quede en 0
							if($Resta==0){
								//se borran los datos
								$resultado = db_delete_data (false, 'ocompra_listado_existencias_productos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_productos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Sino Actualizo valores
							}else{
								$nuevo = $Resta * $rowData['vUnitario'];
								//se actualizan los datos
								$SIS_data = "Cantidad=".$Resta.", vTotal=".$nuevo ;
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_productos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							break;
						/****************************************/
						//Insumos
						case 2:
							//Se trae los datos
							$rowData = db_select_data (false, 'ocompra_listado_existencias_insumos.idExistencia, ocompra_listado_existencias_insumos.Cantidad, ocompra_listado_existencias_insumos.vUnitario, insumos_listado.Nombre AS Producto, sistema_productos_uml.Nombre AS Medida', 'ocompra_listado_existencias_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = ocompra_listado_existencias_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'ocompra_listado_existencias_insumos.idOcompra = '.$_GET['view'].' AND ocompra_listado_existencias_insumos.idProducto= '.$_GET['del_sol_prod'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Se realizan comparacion
							$cambios = 'Se eliminan '.$rowData['Cantidad'].' '.$rowData['Medida'].' de '.$rowData['Producto'].' de la solicitud';
							/******************************************/
							//Se guarda en historial la accion
							$fecha = fecha_actual();
							if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
							if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
							$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
							$SIS_data .= ",'".$cambios."'";                                          //Observacion
							$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Verifico cantidades
							$Resta = $rowData['Cantidad'] - $_GET['del_sol_cant'];
							//Elimino en caso de que quede en 0
							if($Resta==0){
								//se borran los datos
								$resultado = db_delete_data (false, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_insumos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Sino Actualizo valores
							}else{
								$nuevo = $Resta * $rowData['vUnitario'];
								//se actualizan los datos
								$SIS_data = "Cantidad=".$Resta.", vTotal=".$nuevo ;
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_insumos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							break;
						/****************************************/
						//Arriendos
						case 3:
							//Se trae los datos
							$rowData = db_select_data (false, 'ocompra_listado_existencias_arriendos.idExistencia, ocompra_listado_existencias_arriendos.Cantidad, ocompra_listado_existencias_arriendos.vUnitario, equipos_arriendo_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Medida', 'ocompra_listado_existencias_arriendos', 'LEFT JOIN `equipos_arriendo_listado` ON equipos_arriendo_listado.idEquipo = ocompra_listado_existencias_arriendos.idEquipo LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_arriendos.idFrecuencia', 'ocompra_listado_existencias_arriendos.idOcompra = '.$_GET['view'].' AND ocompra_listado_existencias_arriendos.idEquipo= '.$_GET['del_sol_prod'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Se realizan comparacion
							$cambios = 'Se eliminan '.$rowData['Cantidad'].' '.$rowData['Medida'].' de '.$rowData['Producto'].' de la solicitud';
							/******************************************/
							//Se guarda en historial la accion
							$fecha = fecha_actual();
							if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
							if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
							$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
							$SIS_data .= ",'".$cambios."'";                                          //Observacion
							$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Verifico cantidades
							$Resta = $rowData['Cantidad'] - $_GET['del_sol_cant'];
							//Elimino en caso de que quede en 0
							if($Resta==0){
								//se borran los datos
								$resultado = db_delete_data (false, 'ocompra_listado_existencias_arriendos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_arriendos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Sino Actualizo valores
							}else{
								$nuevo = $Resta * $rowData['vUnitario'];
								//se actualizan los datos
								$SIS_data = "Cantidad=".$Resta.", vTotal=".$nuevo ;
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_arriendos', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							break;
						/****************************************/
						//Servicios
						case 4:
							//Se trae los datos
							$rowData = db_select_data (false, 'ocompra_listado_existencias_servicios.idExistencia, ocompra_listado_existencias_servicios.Cantidad, ocompra_listado_existencias_servicios.vUnitario, servicios_listado.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Medida', 'ocompra_listado_existencias_servicios', 'LEFT JOIN `servicios_listado` ON servicios_listado.idServicio  = ocompra_listado_existencias_servicios.idServicio LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_servicios.idFrecuencia', 'ocompra_listado_existencias_servicios.idOcompra = '.$_GET['view'].' AND ocompra_listado_existencias_servicios.idServicio= '.$_GET['del_sol_prod'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Se realizan comparacion
							$cambios = 'Se eliminan '.$rowData['Cantidad'].' '.$rowData['Medida'].' de '.$rowData['Producto'].' de la solicitud';
							/******************************************/
							//Se guarda en historial la accion
							$fecha = fecha_actual();
							if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
							if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
							$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
							$SIS_data .= ",'".$cambios."'";                                          //Observacion
							$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Verifico cantidades
							$Resta = $rowData['Cantidad'] - $_GET['del_sol_cant'];
							//Elimino en caso de que quede en 0
							if($Resta==0){
								//se borran los datos
								$resultado = db_delete_data (false, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_servicios', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Sino Actualizo valores
							}else{
								$nuevo = $Resta * $rowData['vUnitario'];
								//se actualizan los datos
								$SIS_data = "Cantidad=".$Resta.", vTotal=".$nuevo ;
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_servicios', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							break;
						/****************************************/
						//Otros
						case 5:
							//Se trae los datos
							$rowData = db_select_data (false, 'ocompra_listado_existencias_otros.idExistencia, ocompra_listado_existencias_otros.Cantidad, ocompra_listado_existencias_otros.vUnitario, ocompra_listado_existencias_otros.Nombre AS Producto, core_tiempo_frecuencia.Nombre AS Medida', 'ocompra_listado_existencias_otros', 'LEFT JOIN `core_tiempo_frecuencia` ON core_tiempo_frecuencia.idFrecuencia = ocompra_listado_existencias_otros.idFrecuencia', 'ocompra_listado_existencias_otros.idOcompra = '.$_GET['view'].' AND ocompra_listado_existencias_otros.Nombre= '.$_GET['del_sol_prod'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Se realizan comparacion
							$cambios = 'Se eliminan '.$rowData['Cantidad'].' '.$rowData['Medida'].' de '.$rowData['Producto'].' de la solicitud';
							/******************************************/
							//Se guarda en historial la accion
							$fecha = fecha_actual();
							if(isset($idOcompra) && $idOcompra!=''){ $SIS_data  = "'".$idOcompra."'";  }else{ $SIS_data  = "''";}
							if(isset($Fecha) && $Fecha!=''){         $SIS_data .= ",'".$Fecha."'";     }else{ $SIS_data .= ",''"; }
							$SIS_data .= ",'2'";                                                     //Creacion Satisfactoria
							$SIS_data .= ",'".$cambios."'";                                          //Observacion
							$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

							// inserto los datos de registro en la db
							$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*********************************************************************/
							/*********************************************************************/
							//Verifico cantidades
							$Resta = $rowData['Cantidad'] - $_GET['del_sol_cant'];
							//Elimino en caso de que quede en 0
							if($Resta==0){
								//se borran los datos
								$resultado = db_delete_data (false, 'ocompra_listado_existencias_otros', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_otros', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Sino Actualizo valores
							}else{
								$nuevo = $Resta * $rowData['vUnitario'];
								//se actualizan los datos
								$SIS_data = "Cantidad=".$Resta.", vTotal=".$nuevo ;
								$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idExistencia = "'.$rowData['idExistencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//se actualizan los datos
								$SIS_data = "idOcompra=0" ;
								$resultado = db_update_data (false, $SIS_data, 'solicitud_listado_existencias_otros', 'idExistencia = "'.$_GET['del_solicitud'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							break;
					}

					//se borran los datos
					$resultado = db_delete_data (false, 'ocompra_listado_sol_rel', 'idSolRel = "'.$_GET['del_sol_SolRel'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
/*******************************************************************************************************************/
		case 'edit_oc_ok':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstado='1'";
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$_GET['ing_ocompra'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Creo los datos en el historial
				$idOcompra        = $_GET['ing_ocompra'];
				$Creacion_fecha   = fecha_actual();
				$idTipo           = 2;
				$Observacion      = 'La Orden de Compra ha sido modificada, queda en espera de aprobacion';
				$idUsuario        = $_SESSION['usuario']['basic_data']['idUsuario'];

				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'rechazo_ocompra':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstado='3'";
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Creo los datos en el historial
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'nula_ocompra':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idEstado='4'";
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$idOcompra.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Creo los datos en el historial
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'aprob_ocompra':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idOcompra        = $_GET['compra_aprobar'];
			$Creacion_fecha   = fecha_actual();
			$Creacion_hora    = hora_actual();
			$idUsuario        = $_SESSION['usuario']['basic_data']['idUsuario'];

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idOcompra)&&$idOcompra!=''&&isset($idUsuario)&&$idUsuario!=''){
				$ndata_1 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_aprobaciones', '', "idOcompra='".$idOcompra."' AND idUsuario='".$idUsuario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La aprobacion ya fue realizada';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************************/
				//Creo los datos en el historial
				$idTipo           = 2;
				$Observacion      = 'La Orden de Compra ha sido aceptada por un aprobador';

				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Inserto la aprobacion en la tabla de aprobaciones
				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_aprobaciones', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************************/
				//Reviso si las aprobaciones igualan a los aprobadores
				$arrAprobado = array();
				$arrAprobado = db_select_array (false, 'sistema_aprobador_oc.idUsuario, ocompra_listado.idOcompra, (SELECT COUNT(idAprobaciones) FROM `ocompra_listado_aprobaciones` WHERE idOcompra=ocompra_listado.idOcompra AND idUsuario=sistema_aprobador_oc.idUsuario  LIMIT 1) AS C_apro', 'ocompra_listado', 'LEFT JOIN `sistema_aprobador_oc`  ON sistema_aprobador_oc.idSistema   = ocompra_listado.idSistema', 'ocompra_listado.idOcompra ='.$idOcompra, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//variables
				$napro_list = 0;
				$napro_true = 0;
				foreach ($arrAprobado as $apro) {
					$napro_list++;
					if(isset($apro['C_apro'])&&$apro['C_apro']==1){
						$napro_true++;
					}
				}

				//verifico cantidades
				if($napro_list==$napro_true){
					//Filtros
					$SIS_data = "idEstado='2'";
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Creo los datos en el historial
					$idTipo           = 1;
					$Observacion      = 'La Orden de Compra ha sido aprobada';

					if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
					if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
					if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
					if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
					if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'aprob_auto_ocompra':

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idEstado='2'";
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_archivos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_documentos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$_GET['compra_aprobar'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Creo los datos en el historial
				$idOcompra        = $_GET['compra_aprobar'];
				$Creacion_fecha   = fecha_actual();
				$Creacion_hora    = hora_actual();
				$idTipo           = 1;
				$Observacion      = 'La Orden de Compra ha sido aprobada';
				$idUsuario        = $_SESSION['usuario']['basic_data']['idUsuario'];

				if(isset($idOcompra) && $idOcompra!=''){              $SIS_data  = "'".$idOcompra."'";         }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){    $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($Creacion_hora) && $Creacion_hora!=''){      $SIS_data .= ",'".$Creacion_hora."'";    }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){          $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOcompra, Creacion_fecha, Creacion_hora, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'cerrar_incompleta':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Se verifica si el dato existe
			if(isset($cant_ingresada)&&isset($CantComp)){
				if($cant_ingresada!=$CantComp) {$error['ndata_1'] = 'error/Existen diferencias entre lo solicitado y lo recibido';}
			}

			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idExistencia='".$idExistencia."'";

				// inserto los datos de registro en la db
				switch ($_GET['type']) {
					/********************************************************/
					//Servicios
					case 1:
						//Variables
						if(isset($cant_ingresada) && $cant_ingresada!=''){  $SIS_data .= ",cant_ingresada='".$cant_ingresada."'";}
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_servicios', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
					/********************************************************/
					//Arriendo
					case 2:
						//Variables
						if(isset($cant_ingresada) && $cant_ingresada!=''){  $SIS_data .= ",cant_ingresada='".$cant_ingresada."'";}
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_arriendos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
					/********************************************************/
					//Insumo
					case 3:
						//Variables
						if(isset($cant_ingresada) && $cant_ingresada!=''){  $SIS_data .= ",cant_ingresada='".$cant_ingresada."'";}
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_insumos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
					/********************************************************/
					//Productos
					case 4:
						//Variables
						if(isset($cant_ingresada) && $cant_ingresada!=''){  $SIS_data .= ",cant_ingresada='".$cant_ingresada."'";}
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_productos', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
					/********************************************************/
					//Boletas Trabajadores
					case 5:
						//Variables
						$SIS_data .= ",idUso='2'";
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
					/********************************************************/
					//Boletas Empresas
					case 6:
						//Variables
						if(isset($cant_ingresada) && $cant_ingresada!=''){  $SIS_data .= ",Total_Ingresado='".$cant_ingresada."'";}
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'ocompra_listado_existencias_boletas_empresas', 'idExistencia = "'.$idExistencia.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						break;
				}

				header( 'Location: '.$location.'?submit_filter=+Filtrar&edited=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'eliminar_orden':

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
				/*******************************************************************/
				//variables
				$ndata_1 = 0;
				$ndata_2 = 0;
				$ndata_3 = 0;
				$ndata_4 = 0;
				$ndata_5 = 0;
				$ndata_6 = 0;
				$ndata_7 = 0;
				//Se verifica si el dato existe
				if(isset($_GET['del'])&&$_GET['del']!=''){
					$ndata_1 = db_select_nrows (false, 'idOcompra', 'ocompra_listado', '', "idOcompra='".$indice."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_2 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_arriendos', '', "idOcompra='".$indice."' AND cant_ingresada!=0", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_3 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_insumos', '', "idOcompra='".$indice."' AND cant_ingresada!=0", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_4 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_productos', '', "idOcompra='".$indice."' AND cant_ingresada!=0", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_5 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_servicios', '', "idOcompra='".$indice."' AND cant_ingresada!=0", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_6 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_boletas', '', "idOcompra='".$indice."' AND idUso=2", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$ndata_7 = db_select_nrows (false, 'idOcompra', 'ocompra_listado_existencias_boletas_empresas', '', "idOcompra='".$indice."' AND Total_Ingresado!=0", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				}else{
					$error['del'] = 'error/No existe OC a eliminar';
				}
				//generacion de errores
				if($ndata_1==0) {$error['ndata_1'] = 'error/No existe OC a eliminar';}
				if($ndata_2 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de arriendo facturadas';}
				if($ndata_3 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de insumos facturadas';}
				if($ndata_4 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de productos facturadas';}
				if($ndata_5 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de servicios facturadas';}
				if($ndata_6 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de boletas de honorarios facturadas';}
				if($ndata_7 > 0) {$error['ndata_2'] = 'error/Existen solicitudes de boletas de honorarios de empresas facturadas';}
				/*******************************************************************/

				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					/********************************************************/
					//Log oculto de la eliminacion de la OC
					$idOcompra   = $indice;
					$idSistema   = $_SESSION['usuario']['basic_data']['idSistema'];
					$idUsuario   = $_SESSION['usuario']['basic_data']['idUsuario'];
					$Fecha_elim  = fecha_actual();
					$Hora_elim   = hora_actual();

					//filtros
					$SIS_data = "'".$idOcompra."'";
					$SIS_data .= ",'".$idSistema."'";
					$SIS_data .= ",'".$idUsuario."'";
					$SIS_data .= ",'".$Fecha_elim."'";
					$SIS_data .= ",'".$Hora_elim."'";

					// inserto los datos de registro en la db
					$SIS_columns = 'idOcompra, idSistema, idUsuario, Fecha_elim, Hora_elim';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'ocompra_listado_log_eliminacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************/
					// Se trae un listado con todos los archivos relacionados
					$arrArchivos = array();
					$arrArchivos = db_select_array (false, 'Nombre', 'ocompra_listado_archivos', '', 'idOcompra ='.$indice, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/********************************************************/
					//se borran los datos
					$resultado_1  = db_delete_data (false, 'ocompra_listado', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2  = db_delete_data (false, 'ocompra_listado_aprobaciones', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3  = db_delete_data (false, 'ocompra_listado_archivos', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_4  = db_delete_data (false, 'ocompra_listado_documentos', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_5  = db_delete_data (false, 'ocompra_listado_existencias_arriendos', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_6  = db_delete_data (false, 'ocompra_listado_existencias_boletas', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_7  = db_delete_data (false, 'ocompra_listado_existencias_boletas_empresas', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_8  = db_delete_data (false, 'ocompra_listado_existencias_insumos', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_9  = db_delete_data (false, 'ocompra_listado_existencias_otros', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_10 = db_delete_data (false, 'ocompra_listado_existencias_productos', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_11 = db_delete_data (false, 'ocompra_listado_existencias_servicios', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_12 = db_delete_data (false, 'ocompra_listado_historial', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_13 = db_delete_data (false, 'ocompra_listado_sol_rel', 'idOcompra = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true OR $resultado_5==true OR $resultado_6==true OR $resultado_7==true OR $resultado_8==true OR $resultado_9==true OR $resultado_10==true OR $resultado_11==true OR $resultado_12==true OR $resultado_13==true){

						/********************************************************/
						//Se borran los archivos relacionados
						foreach ($arrArchivos as $archivo){
							try {
								if(!is_writable('upload/'.$archivo['Nombre'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivo['Nombre']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/

	}

?>
