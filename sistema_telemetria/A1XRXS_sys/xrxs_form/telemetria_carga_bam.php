<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-167).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCarga']))            $idCarga             = $_POST['idCarga'];
	if (!empty($_POST['idSistema']))          $idSistema           = $_POST['idSistema'];
	if (!empty($_POST['idTelemetria']))       $idTelemetria        = $_POST['idTelemetria'];
	if (!empty($_POST['idUsuario']))          $idUsuario           = $_POST['idUsuario'];
	if (!empty($_POST['FechaCarga']))         $FechaCarga          = $_POST['FechaCarga'];
	if (!empty($_POST['FechaVencimiento']))   $FechaVencimiento    = $_POST['FechaVencimiento'];
	if (!empty($_POST['idDocPago']))          $idDocPago           = $_POST['idDocPago'];
	if (!empty($_POST['N_DocPago']))          $N_DocPago           = $_POST['N_DocPago'];
	if (!empty($_POST['Monto']))              $Monto               = $_POST['Monto'];

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
			case 'idCarga':          if(empty($idCarga)){           $error['idCarga']           = 'error/No ha ingresado el id';}break;
			case 'idSistema':        if(empty($idSistema)){         $error['idSistema']         = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idTelemetria':     if(empty($idTelemetria)){      $error['idTelemetria']      = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'idUsuario':        if(empty($idUsuario)){         $error['idUsuario']         = 'error/No ha seleccionado el usuario';}break;
			case 'FechaCarga':       if(empty($FechaCarga)){        $error['FechaCarga']        = 'error/No ha ingresado la fecha de carga';}break;
			case 'FechaVencimiento': if(empty($FechaVencimiento)){  $error['FechaVencimiento']  = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'idDocPago':        if(empty($idDocPago)){         $error['idDocPago']         = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'N_DocPago':        if(empty($N_DocPago)){         $error['N_DocPago']         = 'error/No ha ingresado la fecha de vencimiento';}break;
			case 'Monto':            if(empty($Monto)){             $error['Monto']             = 'error/No ha ingresado el Monto';}break;

		}
	}

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

				//Numero de semana
				$Ano     = fecha2Ano($FechaVencimiento);
				$Mes     = fecha2NMes($FechaVencimiento);
				$Semana  = fecha2NSemana($FechaVencimiento);
				$Dia     = fecha2NDiaSemana($FechaVencimiento);

				//filtros
				if(isset($idSistema) && $idSistema!=''){                   $SIS_data  = "'".$idSistema."'";           }else{$SIS_data  = "''";}
				if(isset($idTelemetria) && $idTelemetria!=''){             $SIS_data .= ",'".$idTelemetria."'";       }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                   $SIS_data .= ",'".$idUsuario."'";          }else{$SIS_data .= ",''";}
				if(isset($FechaCarga) && $FechaCarga!=''){                 $SIS_data .= ",'".$FechaCarga."'";         }else{$SIS_data .= ",''";}
				if(isset($FechaVencimiento) && $FechaVencimiento!=''){     $SIS_data .= ",'".$FechaVencimiento."'";   }else{$SIS_data .= ",''";}
				if(isset($Ano) && $Ano!=''){                               $SIS_data .= ",'".$Ano."'";                }else{$SIS_data .= ",''";}
				if(isset($Mes) && $Mes!=''){                               $SIS_data .= ",'".$Mes."'";                }else{$SIS_data .= ",''";}
				if(isset($Semana) && $Semana!=''){                         $SIS_data .= ",'".$Semana."'";             }else{$SIS_data .= ",''";}
				if(isset($Dia) && $Dia!=''){                               $SIS_data .= ",'".$Dia."'";                }else{$SIS_data .= ",''";}
				if(isset($idDocPago) && $idDocPago!=''){                   $SIS_data .= ",'".$idDocPago."'";          }else{$SIS_data .= ",''";}
				if(isset($N_DocPago) && $N_DocPago!=''){                   $SIS_data .= ",'".$N_DocPago."'";          }else{$SIS_data .= ",''";}
				if(isset($Monto) && $Monto!=''){                           $SIS_data .= ",'".$Monto."'";              }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idTelemetria, idUsuario, FechaCarga, FechaVencimiento, Ano, Mes, Semana, Dia, idDocPago, N_DocPago, Monto';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_carga_bam', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
				//Numero de semana
				$Ano     = fecha2Ano($FechaVencimiento);
				$Mes     = fecha2NMes($FechaVencimiento);
				$Semana  = fecha2NSemana($FechaVencimiento);
				$Dia     = fecha2NDiaSemana($FechaVencimiento);

				//Filtros
				$SIS_data = "idCarga='".$idCarga."'";
				if(isset($idSistema) && $idSistema!=''){                   $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idTelemetria) && $idTelemetria!=''){             $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($idUsuario) && $idUsuario!=''){                   $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($FechaCarga) && $FechaCarga!=''){                 $SIS_data .= ",FechaCarga='".$FechaCarga."'";}
				if(isset($FechaVencimiento) && $FechaVencimiento!=''){     $SIS_data .= ",FechaVencimiento='".$FechaVencimiento."'";}
				if(isset($Ano) && $Ano!=''){                               $SIS_data .= ",Ano='".$Ano."'";}
				if(isset($Mes) && $Mes!=''){                               $SIS_data .= ",Mes='".$Mes."'";}
				if(isset($Semana) && $Semana!=''){                         $SIS_data .= ",Semana='".$Semana."'";}
				if(isset($Dia) && $Dia!=''){                               $SIS_data .= ",Dia='".$Dia."'";}
				if(isset($idDocPago) && $idDocPago!=''){                   $SIS_data .= ",idDocPago='".$idDocPago."'";}
				if(isset($N_DocPago) && $N_DocPago!=''){                   $SIS_data .= ",N_DocPago='".$N_DocPago."'";}
				if(isset($Monto) && $Monto!=''){                           $SIS_data .= ",Monto='".$Monto."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_carga_bam', 'idCarga = "'.$idCarga.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'telemetria_carga_bam', 'idCarga = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
