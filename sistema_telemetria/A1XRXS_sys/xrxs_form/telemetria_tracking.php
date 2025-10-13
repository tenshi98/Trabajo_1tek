<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-185).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTracking']))     $idTracking     = $_POST['idTracking'];
	if (!empty($_POST['idSistema']))      $idSistema      = $_POST['idSistema'];
	if (!empty($_POST['f_inicio']))       $f_inicio       = $_POST['f_inicio'];
	if (!empty($_POST['f_termino']))      $f_termino      = $_POST['f_termino'];
	if (!empty($_POST['h_inicio']))       $h_inicio       = $_POST['h_inicio'];
	if (!empty($_POST['h_termino']))      $h_termino      = $_POST['h_termino'];
	if (!empty($_POST['idTelemetria']))   $idTelemetria   = $_POST['idTelemetria'];
	if (!empty($_POST['idGrupo']))        $idGrupo        = $_POST['idGrupo'];
	if (!empty($_POST['idGrafico']))      $idGrafico      = $_POST['idGrafico'];
	if (!empty($_POST['idEstado']))       $idEstado       = $_POST['idEstado'];
	if (!empty($_POST['Observacion']))    $Observacion    = $_POST['Observacion'];

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
			case 'idTracking':     if(empty($idTracking)){     $error['idTracking']     = 'error/No ha ingresado el id';}break;
			case 'idSistema':      if(empty($idSistema)){      $error['idSistema']      = 'error/No ha seleccionado el sistema';}break;
			case 'f_inicio':       if(empty($f_inicio)){       $error['f_inicio']       = 'error/No ha ingresado la fecha de inicio';}break;
			case 'f_termino':      if(empty($f_termino)){      $error['f_termino']      = 'error/No ha ingresado la fecha de termino';}break;
			case 'h_inicio':       if(empty($h_inicio)){       $error['h_inicio']       = 'error/No ha ingresado la hora de inicio';}break;
			case 'h_termino':      if(empty($h_termino)){      $error['h_termino']      = 'error/No ha ingresado la hora de termino';}break;
			case 'idTelemetria':   if(empty($idTelemetria)){   $error['idTelemetria']   = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idGrupo':        if(empty($idGrupo)){        $error['idGrupo']        = 'error/No ha seleccionado el grupo';}break;
			case 'idGrafico':      if(empty($idGrafico)){      $error['idGrafico']      = 'error/No ha seleccionado la opción de graficos';}break;
			case 'idEstado':       if(empty($idEstado)){       $error['idEstado']       = 'error/No ha seleccionado el estado';}break;
			case 'Observacion':    if(empty($Observacion)){    $error['Observacion']    = 'error/No ha ingresado la observacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observacion) && $Observacion!=''){ $Observacion = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){  $error['Observacion'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){        $SIS_data  = "'".$idSistema."'";       }else{$SIS_data  = "''";}
				if(isset($f_inicio) && $f_inicio!=''){          $SIS_data .= ",'".$f_inicio."'";       }else{$SIS_data .= ",''";}
				if(isset($f_termino) && $f_termino!=''){        $SIS_data .= ",'".$f_termino."'";      }else{$SIS_data .= ",''";}
				if(isset($h_inicio) && $h_inicio!=''){          $SIS_data .= ",'".$h_inicio."'";       }else{$SIS_data .= ",''";}
				if(isset($h_termino) && $h_termino!=''){        $SIS_data .= ",'".$h_termino."'";      }else{$SIS_data .= ",''";}
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'";   }else{$SIS_data .= ",''";}
				if(isset($idGrupo) && $idGrupo!=''){            $SIS_data .= ",'".$idGrupo."'";        }else{$SIS_data .= ",''";}
				if(isset($idGrafico) && $idGrafico!=''){        $SIS_data .= ",'".$idGrafico."'";      }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){          $SIS_data .= ",'".$idEstado."'";       }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){    $SIS_data .= ",'".$Observacion."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, f_inicio, f_termino, h_inicio, h_termino, idTelemetria, idGrupo, idGrafico, idEstado, Observacion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_tracking', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idTracking='".$idTracking."'";
				if(isset($idSistema) && $idSistema!=''){        $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($f_inicio) && $f_inicio!=''){          $SIS_data .= ",f_inicio='".$f_inicio."'";}
				if(isset($f_termino) && $f_termino!=''){        $SIS_data .= ",f_termino='".$f_termino."'";}
				if(isset($h_inicio) && $h_inicio!=''){          $SIS_data .= ",h_inicio='".$h_inicio."'";}
				if(isset($h_termino) && $h_termino!=''){        $SIS_data .= ",h_termino='".$h_termino."'";}
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($idGrupo) && $idGrupo!=''){            $SIS_data .= ",idGrupo='".$idGrupo."'";}
				if(isset($idGrafico) && $idGrafico!=''){        $SIS_data .= ",idGrafico='".$idGrafico."'";}
				if(isset($idEstado) && $idEstado!=''){          $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Observacion) && $Observacion!=''){    $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_tracking', 'idTracking = "'.$idTracking.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'telemetria_tracking', 'idTracking = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
