<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridCalendarioad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-099).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idCalendario']))   $idCalendario    = $_POST['idCalendario'];
	if (!empty($_POST['idSistema']))      $idSistema       = $_POST['idSistema'];
	if (!empty($_POST['Ano']))            $Ano             = $_POST['Ano'];
	if (!empty($_POST['Mes']))            $Mes             = $_POST['Mes'];
	if (!empty($_POST['Dia']))            $Dia             = $_POST['Dia'];
	if (!empty($_POST['N_Semana']))       $N_Semana 	   = $_POST['N_Semana'];
	if (!empty($_POST['Fecha']))          $Fecha 	       = $_POST['Fecha'];
	if (!empty($_POST['Titulo']))         $Titulo 	       = $_POST['Titulo'];
	if (!empty($_POST['Cuerpo']))         $Cuerpo 	       = $_POST['Cuerpo'];
	if (!empty($_POST['idUsuario']))      $idUsuario 	   = $_POST['idUsuario'];
	if (!empty($_POST['idUsuario9999']))  $idUsuario9999   = $_POST['idUsuario9999'];
	if (!empty($_POST['idOpciones']))     $idOpciones 	   = $_POST['idOpciones'];

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
			case 'idCalendario':  if(empty($idCalendario)){   $error['idCalendario']   = 'error/No ha ingresado el id';}break;
			case 'idSistema':     if(empty($idSistema)){      $error['idSistema']      = 'error/No ha seleccionado el sistema';}break;
			case 'Ano':           if(empty($Ano)){            $error['Ano']            = 'error/No ha ingresado el año';}break;
			case 'Mes':           if(empty($Mes)){            $error['Mes']            = 'error/No ha ingresado el mes';}break;
			case 'Dia':           if(empty($Dia)){            $error['Dia']            = 'error/No ha ingresado el Dia';}break;
			case 'N_Semana':      if(empty($N_Semana)){       $error['N_Semana']       = 'error/No ha ingresado el Numero de Semana';}break;
			case 'Fecha':         if(empty($Fecha)){          $error['Fecha']          = 'error/No ha ingresado la Fecha';}break;
			case 'Titulo':        if(empty($Titulo)){         $error['Titulo']         = 'error/No ha ingresado el titulo';}break;
			case 'Cuerpo':        if(empty($Cuerpo)){         $error['Cuerpo']         = 'error/No ha ingresado el cuerpo del evento';}break;
			case 'idUsuario':     if(empty($idUsuario)){      $error['idUsuario']      = 'error/No ha ingresado el usuario';}break;
			case 'idUsuario9999': if(empty($idUsuario9999)){  $error['idUsuario9999']  = 'error/No ha ingresado el usuario';}break;
			case 'idOpciones':    if(empty($idOpciones)){     $error['idOpciones']     = 'error/No ha seleccionado la opción de publico o privado';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Titulo) && $Titulo!=''){ $Titulo = EstandarizarInput($Titulo);}
	if(isset($Cuerpo) && $Cuerpo!=''){ $Cuerpo = EstandarizarInput($Cuerpo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Titulo)&&contar_palabras_censuradas($Titulo)!=0){  $error['Titulo'] = 'error/Edita Titulo, contiene palabras no permitidas';}
	if(isset($Cuerpo)&&contar_palabras_censuradas($Cuerpo)!=0){  $error['Cuerpo'] = 'error/Edita Cuerpo, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($Fecha) && $Fecha!=''){
				$Ano       = fecha2Ano($Fecha);
				$Mes       = fecha2NMes($Fecha);
				$Dia       = fecha2NdiaMes($Fecha);
				$N_Semana  = fecha2NSemana($Fecha);

			}else{
				$error['Fecha']       = 'error/No ha ingresado la fecha';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){     $SIS_data  = "'".$idSistema."'";   }else{$SIS_data  = "''";}
				if(isset($Ano) && $Ano!=''){                 $SIS_data .= ",'".$Ano."'";        }else{$SIS_data .= ",''";}
				if(isset($Mes) && $Mes!=''){                 $SIS_data .= ",'".$Mes."'";        }else{$SIS_data .= ",''";}
				if(isset($Dia) && $Dia!=''){                 $SIS_data .= ",'".$Dia."'";        }else{$SIS_data .= ",''";}
				if(isset($N_Semana) && $N_Semana!=''){       $SIS_data .= ",'".$N_Semana."'";   }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",'".$Fecha."'";      }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){           $SIS_data .= ",'".$Titulo."'";     }else{$SIS_data .= ",''";}
				if(isset($Cuerpo) && $Cuerpo!=''){           $SIS_data .= ",'".$Cuerpo."'";     }else{$SIS_data .= ",''";}
				if(isset($idOpciones) && $idOpciones!=''){   $SIS_data .= ",'".$idOpciones."'"; }else{$SIS_data .= ",''";}
				//si es un evento publico
				if(isset($idOpciones) && $idOpciones ==1){
					if(isset($idUsuario9999) && $idUsuario9999!=''){     $SIS_data .= ",'".$idUsuario9999."'";  }else{$SIS_data .= ",''";}
				//si es un evento privado
				}elseif(isset($idOpciones) && $idOpciones ==2){
					if(isset($idUsuario) && $idUsuario!=''){    $SIS_data .= ",'".$idUsuario."'";  }else{$SIS_data .= ",''";}
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Ano, Mes, Dia, N_Semana, Fecha, Titulo, Cuerpo, idOpciones,idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_calendario_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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

			if(isset($Fecha) && $Fecha!=''){
				$Ano       = fecha2Ano($Fecha);
				$Mes       = fecha2NMes($Fecha);
				$Dia       = fecha2NdiaMes($Fecha);
				$N_Semana  = fecha2NSemana($Fecha);

			}else{
				$error['Fecha']       = 'error/No ha ingresado la fecha';
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCalendario='".$idCalendario."'";
				if(isset($idSistema) && $idSistema!=''){     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Ano) && $Ano!=''){                 $SIS_data .= ",Ano='".$Ano."'";}
				if(isset($Mes) && $Mes!=''){                 $SIS_data .= ",Mes='".$Mes."'";}
				if(isset($Dia) && $Dia!=''){                 $SIS_data .= ",Dia='".$Dia."'";}
				if(isset($N_Semana) && $N_Semana!=''){       $SIS_data .= ",N_Semana='".$N_Semana."'";}
				if(isset($Fecha) && $Fecha!=''){             $SIS_data .= ",Fecha='".$Fecha."'";}
				if(isset($Titulo) && $Titulo!=''){           $SIS_data .= ",Titulo='".$Titulo."'";}
				if(isset($Cuerpo) && $Cuerpo!=''){           $SIS_data .= ",Cuerpo='".$Cuerpo."'";}
				if(isset($idOpciones) && $idOpciones!=''){   $SIS_data .= ",idOpciones='".$idOpciones."'";}

				//si es un evento publico
				if(isset($idOpciones) && $idOpciones ==1){
					if(isset($idUsuario9999) && $idUsuario9999!=''){   $SIS_data .= ",idUsuario='".$idUsuario9999."'";}
				//si es un evento privado
				}elseif(isset($idOpciones) && $idOpciones ==2){
					if(isset($idUsuario) && $idUsuario!=''){  $SIS_data .= ",idUsuario='".$idUsuario."'";}
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'principal_calendario_listado', 'idCalendario = "'.$idCalendario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'principal_calendario_listado', 'idCalendario = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
