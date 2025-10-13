<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-082).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de idUsuarioes input a variables
	if (!empty($_POST['idReserva']))            $idReserva             = $_POST['idReserva'];
	if (!empty($_POST['idSistema']))            $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))            $idUsuario             = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))             $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['Fecha']))                $Fecha                 = $_POST['Fecha'];
	if (!empty($_POST['Dia']))                  $Dia                   = $_POST['Dia'];
	if (!empty($_POST['Mes']))                  $Mes                   = $_POST['Mes'];
	if (!empty($_POST['Ano']))                  $Ano                   = $_POST['Ano'];
	if (!empty($_POST['Hora_Inicio']))          $Hora_Inicio           = $_POST['Hora_Inicio'];
	if (!empty($_POST['Hora_Termino']))         $Hora_Termino          = $_POST['Hora_Termino'];
	if (!empty($_POST['Solicitante']))          $Solicitante           = $_POST['Solicitante'];
	if (!empty($_POST['Observaciones']))        $Observaciones         = $_POST['Observaciones'];
	if (!empty($_POST['idServicioCafeteria']))  $idServicioCafeteria   = $_POST['idServicioCafeteria'];
	if (!empty($_POST['CantidadAsistentes']))   $CantidadAsistentes    = $_POST['CantidadAsistentes'];
	if (!empty($_POST['idOficina']))            $idOficina             = $_POST['idOficina'];

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
			case 'idReserva':            if(empty($idReserva)){               $error['idReserva']            = 'error/No ha ingresado el id';}break;
			case 'idSistema':            if(empty($idSistema)){               $error['idSistema']            = 'error/No ha seleccionado el Sistema';}break;
			case 'idUsuario':            if(empty($idUsuario)){               $error['idUsuario']            = 'error/No ha seleccionado el Usuario';}break;
			case 'idEstado':             if(empty($idEstado)){                $error['idEstado']             = 'error/No ha seleccionado el estado';}break;
			case 'Fecha':                if(empty($Fecha)){                   $error['Fecha']                = 'error/No ha ingresado la fecha';}break;
			case 'Dia':                  if(empty($Dia)){                     $error['Dia']                  = 'error/No ha ingresado el dia';}break;
			case 'Mes':                  if(empty($Mes)){                     $error['Mes']                  = 'error/No ha ingresado el mes';}break;
			case 'Ano':                  if(empty($Ano)){                     $error['Ano']                  = 'error/No ha ingresado el año';}break;
			case 'Hora_Inicio':          if(empty($Hora_Inicio)){             $error['Hora_Inicio']          = 'error/No ha ingresado la Hora de Inicio';}break;
			case 'Hora_Termino':         if(empty($Hora_Termino)){            $error['Hora_Termino']         = 'error/No ha ingresado la Hora de Termino';}break;
			case 'Solicitante':          if(empty($Solicitante)){             $error['Solicitante']          = 'error/No ha ingresado el Solicitante';}break;
			case 'Observaciones':        if(empty($Observaciones)){           $error['Observaciones']        = 'error/No ha ingresado las Observaciones';}break;
			case 'idServicioCafeteria':  if(empty($idServicioCafeteria)){     $error['idServicioCafeteria']  = 'error/No ha seleccionado si usa servicio de cafeteria';}break;
			case 'CantidadAsistentes':   if(empty($CantidadAsistentes)){      $error['CantidadAsistentes']   = 'error/No ha ingresado la cantidad de personas asistente';}break;
			case 'idOficina':            if(empty($idOficina)){               $error['idOficina']            = 'error/No ha seleccionado la oficina a utilizar';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Solicitante) && $Solicitante!=''){     $Solicitante   = EstandarizarInput($Solicitante);}
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Solicitante)&&contar_palabras_censuradas($Solicitante)!=0){      $error['Solicitante']   = 'error/Edita Solicitante, contiene palabras no permitidas';}
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita la Observacion, contiene palabras no permitidas';}

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
			if(isset($idOficina)&&isset($Fecha)&&isset($idSistema)&&isset($Hora_Inicio)&&isset($Hora_Termino)){
				//se crea filtro
				$subfilter  = 'idOficina="'.$idOficina.'"';
				$subfilter .= ' AND Fecha="'.$Fecha.'"';
				$subfilter .= ' AND idSistema="'.$idSistema.'"';
				$subfilter .= ' AND (Hora_Inicio<"'.$Hora_Inicio.'" AND Hora_Termino>"'.$Hora_Termino.'")';
				$subfilter .= ' AND (Hora_Termino<"'.$Hora_Inicio.'" AND Hora_Termino>"'.$Hora_Termino.'")';
				$subfilter .= ' AND (Hora_Inicio>"'.$Hora_Inicio.'" AND Hora_Inicio>"'.$Hora_Termino.'")';
				//se buscan coincidencias
				$ndata_1 = db_select_nrows (false, 'idReserva', 'gestion_reserva_oficinas', '', $subfilter, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La reserva de la oficina ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){   $SIS_data  = "'".$idSistema."'";   }else{$SIS_data  ="''";}
				if(isset($idUsuario) && $idUsuario!=''){   $SIS_data .= ",'".$idUsuario."'";  }else{$SIS_data .=",''";}
				if(isset($idEstado) && $idEstado!=''){     $SIS_data .= ",'".$idEstado."'";   }else{$SIS_data .=",''";}
				if(isset($Fecha) && $Fecha!=''){
					$SIS_data .= ",'".$Fecha."'";
					$SIS_data .= ",'".fecha2NdiaMes($Fecha)."'";
					$SIS_data .= ",'".fecha2NMes($Fecha)."'";
					$SIS_data .= ",'".fecha2Ano($Fecha)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($Hora_Inicio) && $Hora_Inicio!=''){                  $SIS_data .= ",'".$Hora_Inicio."'";          }else{$SIS_data .= ",''";}
				if(isset($Hora_Termino) && $Hora_Termino!=''){                $SIS_data .= ",'".$Hora_Termino."'";         }else{$SIS_data .= ",''";}
				if(isset($Solicitante) && $Solicitante!=''){                  $SIS_data .= ",'".$Solicitante."'";          }else{$SIS_data .= ",''";}
				if(isset($Observaciones) && $Observaciones!=''){              $SIS_data .= ",'".$Observaciones."'";        }else{$SIS_data .= ",''";}
				if(isset($idServicioCafeteria) && $idServicioCafeteria!=''){  $SIS_data .= ",'".$idServicioCafeteria."'";  }else{$SIS_data .= ",''";}
				if(isset($CantidadAsistentes) && $CantidadAsistentes!=''){    $SIS_data .= ",'".$CantidadAsistentes."'";   }else{$SIS_data .= ",''";}
				if(isset($idOficina) && $idOficina!=''){                      $SIS_data .= ",'".$idOficina."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, idEstado, Fecha, Dia, Mes, Ano, Hora_Inicio, Hora_Termino, Solicitante, Observaciones, idServicioCafeteria, CantidadAsistentes, idOficina';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'gestion_reserva_oficinas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				$SIS_data = "idReserva='".$idReserva."'";
				if(isset($idSistema) && $idSistema!=''){  $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUsuario) && $idUsuario!=''){  $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){    $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Fecha) && $Fecha!=''){
					$SIS_data .= ",Fecha='".$Fecha."'";
					$SIS_data .= ",Dia='".fecha2NdiaMes($Fecha)."'";
					$SIS_data .= ",Mes='".fecha2NMes($Fecha)."'";
					$SIS_data .= ",Ano='".fecha2Ano($Fecha)."'";
				}
				if(isset($Hora_Inicio) && $Hora_Inicio!=''){                  $SIS_data .= ",Hora_Inicio='".$Hora_Inicio."'";}
				if(isset($Hora_Termino) && $Hora_Termino!=''){                $SIS_data .= ",Hora_Termino='".$Hora_Termino."'";}
				if(isset($Solicitante) && $Solicitante!=''){                  $SIS_data .= ",Solicitante='".$Solicitante."'";}
				if(isset($Observaciones) && $Observaciones!=''){              $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($idServicioCafeteria) && $idServicioCafeteria!=''){  $SIS_data .= ",idServicioCafeteria='".$idServicioCafeteria."'";}
				if(isset($CantidadAsistentes) && $CantidadAsistentes!=''){    $SIS_data .= ",CantidadAsistentes='".$CantidadAsistentes."'";}
				if(isset($idOficina) && $idOficina!=''){                      $SIS_data .= ",idOficina='".$idOficina."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'gestion_reserva_oficinas', 'idReserva = "'.$idReserva.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'gestion_reserva_oficinas', 'idReserva = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
