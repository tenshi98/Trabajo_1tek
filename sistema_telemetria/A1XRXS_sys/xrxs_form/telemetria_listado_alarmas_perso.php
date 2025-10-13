<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-170).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idAlarma']))         $idAlarma            = $_POST['idAlarma'];
	if (!empty($_POST['idTelemetria']))     $idTelemetria        = $_POST['idTelemetria'];
	if (!empty($_POST['Nombre']))           $Nombre              = $_POST['Nombre'];
	if (!empty($_POST['idTipo']))           $idTipo              = $_POST['idTipo'];
	if (!empty($_POST['idTipoAlerta']))     $idTipoAlerta        = $_POST['idTipoAlerta'];
	if (!empty($_POST['idUniMed']))         $idUniMed            = $_POST['idUniMed'];
	if (!empty($_POST['valor_error']))      $valor_error         = $_POST['valor_error'];
	if (!empty($_POST['valor_diferencia'])) $valor_diferencia    = $_POST['valor_diferencia'];
	if (!empty($_POST['Rango_ini']))        $Rango_ini           = $_POST['Rango_ini'];
	if (!empty($_POST['Rango_fin']))        $Rango_fin           = $_POST['Rango_fin'];
	if (!empty($_POST['NErroresMax']))      $NErroresMax         = $_POST['NErroresMax'];
	if (!empty($_POST['NErroresActual']))   $NErroresActual      = $_POST['NErroresActual'];
	if (!empty($_POST['idEstado']))         $idEstado            = $_POST['idEstado'];
	if (!empty($_POST['HoraInicio']))       $HoraInicio          = $_POST['HoraInicio'];
	if (!empty($_POST['HoraTermino']))      $HoraTermino         = $_POST['HoraTermino'];

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
			case 'idAlarma':          if(empty($idAlarma)){            $error['idAlarma']           = 'error/No ha ingresado el id';}break;
			case 'idTelemetria':      if(empty($idTelemetria)){        $error['idTelemetria']       = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'Nombre':            if(empty($Nombre)){              $error['Nombre']             = 'error/No ha ingresado el nombre';}break;
			case 'idTipo':            if(empty($idTipo)){              $error['idTipo']             = 'error/No ha seleccionado el tipo';}break;
			case 'idTipoAlerta':      if(empty($idTipoAlerta)){        $error['idTipoAlerta']       = 'error/No ha seleccionado la prioridad de la alerta';}break;
			case 'idUniMed':          if(empty($idUniMed)){            $error['idUniMed']           = 'error/No ha seleccionado la unidad de medida de la alerta';}break;
			case 'valor_error':       if(empty($valor_error)){         $error['valor_error']        = 'error/No ha ingresado el valor de error';}break;
			case 'valor_diferencia':  if(empty($valor_diferencia)){    $error['valor_diferencia']   = 'error/No ha ingresado el porcentaje de diferencia';}break;
			case 'Rango_ini':         if(empty($Rango_ini)){           $error['Rango_ini']          = 'error/No ha ingresado el rango de inicio';}break;
			case 'Rango_fin':         if(empty($Rango_fin)){           $error['Rango_fin']          = 'error/No ha ingresado el rango de termino';}break;
			case 'NErroresMax':       if(empty($NErroresMax)){         $error['NErroresMax']        = 'error/No ha ingresado el numero maximo de errores';}break;
			case 'NErroresActual':    if(empty($NErroresActual)){      $error['NErroresActual']     = 'error/No ha ingresado el numero actual de errores';}break;
			case 'idEstado':          if(empty($idEstado)){            $error['idEstado']           = 'error/No ha seleccionado el estado';}break;
			case 'HoraInicio':        if(empty($HoraInicio)){          $error['HoraInicio']         = 'error/No ha ingresado la hora de inicio';}break;
			case 'HoraTermino':       if(empty($HoraTermino)){         $error['HoraTermino']        = 'error/No ha ingresado la hora de termino';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){$Nombre = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Rango_ini,$Rango_fin)&&$Rango_ini==$Rango_fin){    $error['Rango']  = 'error/El Valor Mínimo y el Valor Máximo tienen el mismo valor, edita los valores correctamente';}
	if(isset($Rango_ini,$Rango_fin)&&$Rango_ini>=$Rango_fin){    $error['Rango']  = 'error/El Valor Mínimo es superior al Valor Máximo tienen el mismo valor, edita los valores correctamente';}

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
			if(isset($Nombre)&&isset($idTelemetria)&&isset($idTipoAlerta)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado_alarmas_perso', '', "Nombre='".$Nombre."' AND idTelemetria='".$idTelemetria."' AND idTipoAlerta='".$idTipoAlerta."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idTelemetria) && $idTelemetria!=''){          $SIS_data  = "'".$idTelemetria."'";      }else{$SIS_data  = "''";}
				if(isset($Nombre) && $Nombre!=''){                      $SIS_data .= ",'".$Nombre."'";           }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                      $SIS_data .= ",'".$idTipo."'";           }else{$SIS_data .= ",''";}
				if(isset($idTipoAlerta) && $idTipoAlerta!=''){          $SIS_data .= ",'".$idTipoAlerta."'";     }else{$SIS_data .= ",''";}
				if(isset($idUniMed) && $idUniMed!=''){                  $SIS_data .= ",'".$idUniMed."'";         }else{$SIS_data .= ",''";}
				if(isset($valor_error) && $valor_error!=''){            $SIS_data .= ",'".$valor_error."'";      }else{$SIS_data .= ",''";}
				if(isset($valor_diferencia) && $valor_diferencia!=''){  $SIS_data .= ",'".$valor_diferencia."'"; }else{$SIS_data .= ",''";}
				if(isset($Rango_ini) && $Rango_ini!=''){                $SIS_data .= ",'".$Rango_ini."'";        }else{$SIS_data .= ",''";}
				if(isset($Rango_fin) && $Rango_fin!=''){                $SIS_data .= ",'".$Rango_fin."'";        }else{$SIS_data .= ",''";}
				if(isset($NErroresMax) && $NErroresMax!=''){            $SIS_data .= ",'".$NErroresMax."'";      }else{$SIS_data .= ",''";}
				if(isset($NErroresActual) && $NErroresActual!=''){      $SIS_data .= ",'".$NErroresActual."'";   }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",'".$idEstado."'";         }else{$SIS_data .= ",''";}
				if(isset($HoraInicio) && $HoraInicio!=''){              $SIS_data .= ",'".$HoraInicio."'";       }else{$SIS_data .= ",''";}
				if(isset($HoraTermino) && $HoraTermino!=''){            $SIS_data .= ",'".$HoraTermino."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idTelemetria, Nombre,idTipo, idTipoAlerta, idUniMed, valor_error, valor_diferencia, Rango_ini,
				Rango_fin, NErroresMax, NErroresActual, idEstado, HoraInicio, HoraTermino';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($idTelemetria)&&isset($idTipoAlerta)&&isset($idAlarma)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'telemetria_listado_alarmas_perso', '', "Nombre='".$Nombre."' AND idTelemetria='".$idTelemetria."' AND idTipoAlerta='".$idTipoAlerta."' AND idAlarma!='".$idAlarma."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idAlarma='".$idAlarma."'";
				if(isset($idTelemetria) && $idTelemetria!=''){            $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idTipoAlerta) && $idTipoAlerta!=''){            $SIS_data .= ",idTipoAlerta='".$idTipoAlerta."'";}
				if(isset($idUniMed) && $idUniMed!=''){                    $SIS_data .= ",idUniMed='".$idUniMed."'";}
				if(isset($valor_error) && $valor_error!=''){              $SIS_data .= ",valor_error='".$valor_error."'";}
				if(isset($valor_diferencia) && $valor_diferencia!=''){    $SIS_data .= ",valor_diferencia='".$valor_diferencia."'";}
				if(isset($Rango_ini) && $Rango_ini!=''){                  $SIS_data .= ",Rango_ini='".$Rango_ini."'";}
				if(isset($Rango_fin) && $Rango_fin!=''){                  $SIS_data .= ",Rango_fin='".$Rango_fin."'";}
				if(isset($NErroresMax) && $NErroresMax!=''){              $SIS_data .= ",NErroresMax='".$NErroresMax."'";         }else{$SIS_data .= ",NErroresMax='0'";}
				if(isset($NErroresActual) && $NErroresActual!=''){        $SIS_data .= ",NErroresActual='".$NErroresActual."'";   }else{$SIS_data .= ",NErroresActual='0'";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($HoraInicio) && $HoraInicio!=''){                $SIS_data .= ",HoraInicio='".$HoraInicio."'";}
				if(isset($HoraTermino) && $HoraTermino!=''){              $SIS_data .= ",HoraTermino='".$HoraTermino."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_alarmas_perso', 'idAlarma = "'.$idAlarma.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
		case 'delAlarma':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['delAlarma']) OR !validaEntero($_GET['delAlarma']))&&$_GET['delAlarma']!=''){
				$indice = simpleDecode($_GET['delAlarma'], fecha_actual());
			}else{
				$indice = $_GET['delAlarma'];
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
				$resultado_1 = db_delete_data (false, 'telemetria_listado_alarmas_perso', 'idAlarma = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'telemetria_listado_alarmas_perso_items', 'idAlarma = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idTelemetria  = simpleDecode($_GET['view'], fecha_actual());
			$idAlarma      = simpleDecode($_GET['idAlarma'], fecha_actual());
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());
			$idUsuario     = $_SESSION['usuario']['basic_data']['idUsuario'];
			$Fecha         = fecha_actual();
			$Hora          = hora_actual();
			$TimeStamp     = fecha_actual().' '.hora_actual();

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado='".$idEstado."'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_alarmas_perso', 'idAlarma = "'.$idAlarma.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//actualizo historial
					//filtros
					if(isset($idTelemetria) && $idTelemetria!=''){    $SIS_data  = "'".$idTelemetria."'"; }else{$SIS_data  = "''";}
					if(isset($idAlarma) && $idAlarma!=''){            $SIS_data .= ",'".$idAlarma."'";    }else{$SIS_data .= ",''";}
					if(isset($idEstado) && $idEstado!=''){            $SIS_data .= ",'".$idEstado."'";    }else{$SIS_data .= ",''";}
					if(isset($idUsuario) && $idUsuario!=''){          $SIS_data .= ",'".$idUsuario."'";   }else{$SIS_data .= ",''";}
					if(isset($Fecha) && $Fecha!=''){                  $SIS_data .= ",'".$Fecha."'";       }else{$SIS_data .= ",''";}
					if(isset($Hora) && $Hora!=''){                    $SIS_data .= ",'".$Hora."'";        }else{$SIS_data .= ",''";}
					if(isset($TimeStamp) && $TimeStamp!=''){          $SIS_data .= ",'".$TimeStamp."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idTelemetria, idAlarma, idEstado, idUsuario, Fecha, Hora, TimeStamp';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&edited=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'estadoAll':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variables
			$idTelemetria  = simpleDecode($_GET['view'], fecha_actual());
			$idAlarma      = simpleDecode($_GET['idAlarma'], fecha_actual());
			$idEstado      = simpleDecode($_GET['estadoAll'], fecha_actual());
			$idUsuario     = $_SESSION['usuario']['basic_data']['idUsuario'];
			$Fecha         = fecha_actual();
			$Hora          = hora_actual();
			$TimeStamp     = fecha_actual().' '.hora_actual();

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//filtro inteligente
				$SIS_where = 'idTelemetria ='.$idTelemetria;
				if($idEstado==1){
					$SIS_where .= ' AND idEstado = 2';
				}elseif($idEstado==2){
					$SIS_where .= ' AND idEstado = 1';
				}

				/*******************************************************/
				//traigo un listado con los equipos que estan activos, inactivos
				$arrAlarmas = array();
				$arrAlarmas = db_select_array (false, 'idAlarma', 'telemetria_listado_alarmas_perso', '', $SIS_where, 'idAlarma ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrAlarmas');

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado='".$idEstado."'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_alarmas_perso', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//actualizo historial
					foreach ($arrAlarmas as $alarm) {
						//filtros
						if(isset($idTelemetria) && $idTelemetria!=''){            $SIS_data  = "'".$idTelemetria."'";          }else{$SIS_data  = "''";}
						if(isset($alarm['idAlarma']) && $alarm['idAlarma']!=''){  $SIS_data .= ",'".$alarm['idAlarma']."'";    }else{$SIS_data .= ",''";}
						if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";             }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";            }else{$SIS_data .= ",''";}
						if(isset($Fecha) && $Fecha!=''){                          $SIS_data .= ",'".$Fecha."'";                }else{$SIS_data .= ",''";}
						if(isset($Hora) && $Hora!=''){                            $SIS_data .= ",'".$Hora."'";                 }else{$SIS_data .= ",''";}
						if(isset($TimeStamp) && $TimeStamp!=''){                  $SIS_data .= ",'".$TimeStamp."'";            }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idTelemetria, idAlarma, idEstado, idUsuario, Fecha, Hora, TimeStamp';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'telemetria_listado_alarmas_perso_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
