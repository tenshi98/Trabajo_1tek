<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridOficinaad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-091).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idOficina']))    $idOficina     = $_POST['idOficina'];
	if (!empty($_POST['idSistema']))    $idSistema     = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))     $idEstado      = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))       $Nombre        = $_POST['Nombre'];
	if (!empty($_POST['Ubicacion']))    $Ubicacion     = $_POST['Ubicacion'];
	if (!empty($_POST['Capacidad']))    $Capacidad     = $_POST['Capacidad'];

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
			case 'idOficina':   if(empty($idOficina)){    $error['idOficina']   = 'error/No ha ingresado el id';}break;
			case 'idSistema':   if(empty($idSistema)){    $error['idSistema']   = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':    if(empty($idEstado)){     $error['idEstado']    = 'error/No ha seleccionado el Estado';}break;
			case 'Nombre':      if(empty($Nombre)){       $error['Nombre']      = 'error/No ha ingresado el nombre de la oficina';}break;
			case 'Ubicacion':   if(empty($Ubicacion)){    $error['Ubicacion']   = 'error/No ha ingresado la ubicacion';}break;
			case 'Capacidad':   if(empty($Capacidad)){    $error['Capacidad']   = 'error/No ha ingresado la Capacidad';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){       $Nombre    = EstandarizarInput($Nombre);}
	if(isset($Ubicacion) && $Ubicacion!=''){ $Ubicacion = EstandarizarInput($Ubicacion);}
	if(isset($Capacidad) && $Capacidad!=''){ $Capacidad = EstandarizarInput($Capacidad);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){        $error['Nombre']    = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Ubicacion)&&contar_palabras_censuradas($Ubicacion)!=0){  $error['Ubicacion'] = 'error/Edita la Ubicación, contiene palabras no permitidas';}
	if(isset($Capacidad)&&contar_palabras_censuradas($Capacidad)!=0){  $error['Capacidad'] = 'error/Edita la Capacidad, contiene palabras no permitidas';}

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
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'oficinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la oficina ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){    $SIS_data  = "'".$idSistema."'";     }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){      $SIS_data .= ",'".$idEstado."'";     }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){          $SIS_data .= ",'".$Nombre."'";       }else{$SIS_data .= ",''";}
				if(isset($Ubicacion) && $Ubicacion!=''){    $SIS_data .= ",'".$Ubicacion."'";    }else{$SIS_data .= ",''";}
				if(isset($Capacidad) && $Capacidad!=''){    $SIS_data .= ",'".$Capacidad."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Nombre,Ubicacion, Capacidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'oficinas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
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
			if(isset($Nombre)&&isset($idSistema)&&isset($idOficina)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'oficinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idOficina!='".$idOficina."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idOficina='".$idOficina."'";
				if(isset($idSistema) && $idSistema!=''){     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){       $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){           $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Ubicacion) && $Ubicacion!=''){     $SIS_data .= ",Ubicacion='".$Ubicacion."'";}
				if(isset($Capacidad) && $Capacidad!=''){     $SIS_data .= ",Capacidad='".$Capacidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'oficinas_listado', 'idOficina = "'.$idOficina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'oficinas_listado', 'idOficina = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
	}

?>
