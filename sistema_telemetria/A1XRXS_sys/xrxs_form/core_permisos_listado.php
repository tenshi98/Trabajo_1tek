<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-055).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAdmpm']))            $idAdmpm            = $_POST['idAdmpm'];
	if (!empty($_POST['id_pmcat']))           $id_pmcat           = $_POST['id_pmcat'];
	if (!empty($_POST['Direccionweb']))       $Direccionweb       = $_POST['Direccionweb'];
	if (!empty($_POST['Direccionbase']))      $Direccionbase      = $_POST['Direccionbase'];
	if (!empty($_POST['Nombre']))             $Nombre             = $_POST['Nombre'];
	if (!empty($_POST['visualizacion']))      $visualizacion      = $_POST['visualizacion'];
	if (!empty($_POST['Version']))            $Version            = $_POST['Version'];
	if (!empty($_POST['Descripcion']))        $Descripcion        = $_POST['Descripcion'];
	if (!empty($_POST['Level_Limit']))        $Level_Limit        = $_POST['Level_Limit'];
	if (!empty($_POST['fake_id_pmcat']))      $fake_id_pmcat      = $_POST['fake_id_pmcat'];
	if (!empty($_POST['fake_Nombre']))        $fake_Nombre        = $_POST['fake_Nombre'];
	if ( isset($_POST['Habilita']))           $Habilita           = $_POST['Habilita'];
	if ( isset($_POST['Principal']))          $Principal          = $_POST['Principal'];

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
			case 'idAdmpm':           if(empty($idAdmpm)){           $error['idAdmpm']            = 'error/No ha ingresado el id';}break;
			case 'id_pmcat':          if(empty($id_pmcat)){          $error['id_pmcat']           = 'error/No ha seleccionado la categoria';}break;
			case 'Direccionweb':      if(empty($Direccionweb)){      $error['Direccionweb']       = 'error/No ha ingresado la imagen';}break;
			case 'Direccionbase':     if(empty($Direccionbase)){     $error['Direccionbase']      = 'error/No ha ingresado la dirección web';}break;
			case 'Nombre':            if(empty($Nombre)){            $error['Nombre']             = 'error/No ha ingresado la dirección base';}break;
			case 'visualizacion':     if(empty($visualizacion)){     $error['visualizacion']      = 'error/No ha ingresado la visualizacion';}break;
			case 'Version':           if(empty($Version)){           $error['Version']            = 'error/No ha ingresado la version';}break;
			case 'Descripcion':       if(empty($Descripcion)){       $error['Descripcion']        = 'error/No ha ingresado una descripcion';}break;
			case 'Level_Limit':       if(empty($Level_Limit)){       $error['Level_Limit']        = 'error/No ha seleccionado el limite del nivel de permiso';}break;
			case 'Habilita':          if(!isset($Habilita)){         $error['Habilita']           = 'error/No ha ingresado los tabs que habilita';}break;
			case 'Principal':         if(!isset($Principal)){        $error['Principal']          = 'error/No ha ingresado los tabs que habilita en principal';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Direccionweb) && $Direccionweb!=''){   $Direccionweb  = EstandarizarInput($Direccionweb);}
	if(isset($Direccionbase) && $Direccionbase!=''){ $Direccionbase = EstandarizarInput($Direccionbase);}
	if(isset($Nombre) && $Nombre!=''){               $Nombre        = EstandarizarInput($Nombre);}
	if(isset($visualizacion) && $visualizacion!=''){ $visualizacion = EstandarizarInput($visualizacion);}
	if(isset($Version) && $Version!=''){             $Version       = EstandarizarInput($Version);}
	if(isset($Descripcion) && $Descripcion!=''){     $Descripcion   = EstandarizarInput($Descripcion);}
	if(isset($Habilita) && $Habilita!=''){           $Habilita      = EstandarizarInput($Habilita);}
	if(isset($Principal) && $Principal!=''){         $Principal     = EstandarizarInput($Principal);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Direccionweb)&&contar_palabras_censuradas($Direccionweb)!=0){    $error['Direccionweb']  = 'error/Edita la Dirección web, contiene palabras no permitidas';}
	if(isset($Direccionbase)&&contar_palabras_censuradas($Direccionbase)!=0){  $error['Direccionbase'] = 'error/Edita la Dirección base, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                $error['Nombre']        = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){      $error['Descripcion']   = 'error/Edita la Descripcion, contiene palabras no permitidas';}
	if(isset($Habilita)&&contar_palabras_censuradas($Habilita)!=0){            $error['Habilita']      = 'error/Edita Habilita, contiene palabras no permitidas';}
	if(isset($Principal)&&contar_palabras_censuradas($Principal)!=0){          $error['Principal']     = 'error/Edita Principal, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $id_pmcat)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_permisos_listado', '', "Nombre='".$Nombre."' AND id_pmcat='".$id_pmcat."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Permiso ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/************************************************************/
				//filtros
				if(isset($id_pmcat) && $id_pmcat!=''){             $SIS_data  = "'".$id_pmcat."'";         }else{$SIS_data  = "''";}
				if(isset($Direccionweb) && $Direccionweb!=''){     $SIS_data .= ",'".$Direccionweb."'";    }else{$SIS_data .= ",''";}
				if(isset($Direccionbase) && $Direccionbase!=''){   $SIS_data .= ",'".$Direccionbase."'";   }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                 $SIS_data .= ",'".$Nombre."'";          }else{$SIS_data .= ",''";}
				if(isset($visualizacion) && $visualizacion!=''){   $SIS_data .= ",'".$visualizacion."'";   }else{$SIS_data .= ",''";}
				if(isset($Version) && $Version!=''){               $SIS_data .= ",'".$Version."'";         }else{$SIS_data .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){       $SIS_data .= ",'".$Descripcion."'";     }else{$SIS_data .= ",''";}
				if(isset($Level_Limit) && $Level_Limit!=''){       $SIS_data .= ",'".$Level_Limit."'";     }else{$SIS_data .= ",''";}
				if(isset($Habilita) && $Habilita!=''){             $SIS_data .= ",'".$Habilita."'";        }else{$SIS_data .= ",''";}
				if(isset($Principal) && $Principal!=''){           $SIS_data .= ",'".$Principal."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'id_pmcat, Direccionweb, Direccionbase, Nombre,visualizacion, Version, Descripcion, Level_Limit, Habilita, Principal';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_permisos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					/************************************************************/
					//Ingreso modificacion al log de cambios
					$rowCat = db_select_data (false, 'Nombre', 'core_permisos_categorias', '', 'id_pmcat = "'.$id_pmcat.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					/****************************/
					$SIS_data = "'".fecha_actual()."'";
					if(isset($Nombre) && $Nombre!=''){
						$Descripcion = '[NUEVO] ->Se agrega la transaccion <strong>'.$rowCat['Nombre'].' - '.$Nombre.'</strong> al sistema';
						$SIS_data .= ",'".$Descripcion."'";
					}else{
						$SIS_data .= ",''";
					}

					// inserto los datos de registro en la db
					$SIS_columns = 'Fecha, Descripcion';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_log_cambios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
						die;

					}

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
			if(isset($Nombre, $id_pmcat, $idAdmpm)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'core_permisos_listado', '', "Nombre='".$Nombre."' AND id_pmcat='".$id_pmcat."' AND idAdmpm!='".$idAdmpm."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Permiso ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAdmpm='".$idAdmpm."'";
				if(isset($id_pmcat) && $id_pmcat!=''){            $SIS_data .= ",id_pmcat='".$id_pmcat."'";}
				if(isset($Direccionweb) && $Direccionweb!=''){    $SIS_data .= ",Direccionweb='".$Direccionweb."'";}
				if(isset($Direccionbase) && $Direccionbase!=''){  $SIS_data .= ",Direccionbase='".$Direccionbase."'";}
				if(isset($Nombre) && $Nombre!=''){                $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($visualizacion) && $visualizacion!=''){  $SIS_data .= ",visualizacion='".$visualizacion."'";}
				if(isset($Version) && $Version!=''){              $SIS_data .= ",Version='".$Version."'";}
				if(isset($Descripcion) && $Descripcion!=''){      $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($Level_Limit) && $Level_Limit!=''){      $SIS_data .= ",Level_Limit='".$Level_Limit."'";}
				if(isset($Habilita) && $Habilita!=''){            $SIS_data .= ",Habilita='".$Habilita."'";           }else{$SIS_data .= ",Habilita=''";}
				if(isset($Principal) && $Principal!=''){          $SIS_data .= ",Principal='".$Principal."'";         }else{$SIS_data .= ",Principal=''";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'core_permisos_listado', 'idAdmpm = "'.$idAdmpm.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/************************************************************/
					//Variable
					$Descripcion = '[MODIFICACION] ->';

					//Verificaciones
					/****************************************/
					//Si la categoria cambia
					if($id_pmcat!=$fake_id_pmcat){
						//Reviso la categoria antigua
						$rowCat_1 = db_select_data (false, 'Nombre', 'core_permisos_categorias', '', 'id_pmcat = "'.$fake_id_pmcat.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Reviso la categoria nueva
						$rowCat_2 = db_select_data (false, 'Nombre', 'core_permisos_categorias', '', 'id_pmcat = "'.$id_pmcat.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//concateno mensaje
						$Descripcion .= 'Se cambia la transaccion '.$Nombre.' de la categoria '.$rowCat_1['Nombre'].' a la categoria '.$rowCat_2['Nombre'].'. ';

					}
					//Si la categoria cambia
					if($Nombre!=$fake_Nombre){
						//concateno mensaje
						$Descripcion .= 'Se cambia el nombre de la transaccion '.$fake_Nombre.' a  <strong>'.$Nombre.'</strong>.';
					}
					//Verifico que existan cambios
					if($Descripcion!='[MODIFICACION] ->'){
						$SIS_data  = "'".fecha_actual()."'";
						$SIS_data .= ",'".$Descripcion."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'Fecha, Descripcion';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'core_log_cambios', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
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
				$resultado_1 = db_delete_data (false, 'core_permisos_listado', 'idAdmpm = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'usuarios_permisos', 'idAdmpm = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

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
	}

?>
