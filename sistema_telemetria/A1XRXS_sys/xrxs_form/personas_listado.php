<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-094).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idPersona']))         $idPersona          = $_POST['idPersona'];
	if (!empty($_POST['idSistema']))         $idSistema          = $_POST['idSistema'];
	if (!empty($_POST['Rut']))               $Rut                = $_POST['Rut'];
	if (!empty($_POST['Nombre']))            $Nombre             = $_POST['Nombre'];
	if (!empty($_POST['ApellidoPaterno']))   $ApellidoPaterno    = $_POST['ApellidoPaterno'];
	if (!empty($_POST['ApellidoMaterno']))   $ApellidoMaterno    = $_POST['ApellidoMaterno'];
	if (!empty($_POST['fNacimiento']))       $fNacimiento        = $_POST['fNacimiento'];
	if (!empty($_POST['idSexo']))            $idSexo             = $_POST['idSexo'];
	if (!empty($_POST['idCiudad']))          $idCiudad           = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))          $idComuna           = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))         $Direccion          = $_POST['Direccion'];
	if (!empty($_POST['Sueldo']))            $Sueldo             = $_POST['Sueldo'];
	if (!empty($_POST['idAFP']))             $idAFP              = $_POST['idAFP'];

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
			case 'idPersona':         if(empty($idPersona)){         $error['idPersona']        = 'error/No ha ingresado el id';}break;
			case 'idSistema':         if(empty($idSistema)){         $error['idSistema']        = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'Rut':               if(empty($Rut)){               $error['Rut']              = 'error/No ha ingresado el rut';}break;
			case 'Nombre':            if(empty($Nombre)){            $error['Nombre']           = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPaterno':   if(empty($ApellidoPaterno)){   $error['ApellidoPaterno']  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMaterno':   if(empty($ApellidoMaterno)){   $error['ApellidoMaterno']  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'fNacimiento':       if(empty($fNacimiento)){       $error['fNacimiento']      = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'idSexo':            if(empty($idSexo)){            $error['idSexo']           = 'error/No ha seleccionado el sexo';}break;
			case 'idCiudad':          if(empty($idCiudad)){          $error['idCiudad']         = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':          if(empty($idComuna)){          $error['idComuna']         = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':         if(empty($Direccion)){         $error['Direccion']        = 'error/No ha ingresado la dirección';}break;
			case 'Sueldo':            if(empty($Sueldo)){            $error['Sueldo']           = 'error/No ha ingresado el sueldo';}break;
			case 'idAFP':             if(empty($idAFP)){             $error['idAFP']            = 'error/No ha ingresado la AFP';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                        $Nombre            = EstandarizarInput($Nombre);}
	if(isset($ApellidoPaterno) && $ApellidoPaterno!=''){      $ApellidoPaterno   = EstandarizarInput($ApellidoPaterno);}
	if(isset($ApellidoMaterno) && $ApellidoMaterno!=''){      $ApellidoMaterno   = EstandarizarInput($ApellidoMaterno);}
	if(isset($Direccion) && $Direccion!=''){                  $Direccion         = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                        $error['Nombre']            = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($ApellidoPaterno)&&contar_palabras_censuradas($ApellidoPaterno)!=0){      $error['ApellidoPaterno']   = 'error/Edita Apellido Pat, contiene palabras no permitidas';}
	if(isset($ApellidoMaterno)&&contar_palabras_censuradas($ApellidoMaterno)!=0){      $error['ApellidoMaterno']   = 'error/Edita Apellido Mat, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){                  $error['Direccion']         = 'error/Edita la Direccion, contiene palabras no permitidas';}

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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPaterno)&&isset($ApellidoMaterno)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado', '', "Nombre='".$Nombre."' AND ApellidoPaterno='".$ApellidoPaterno."' AND ApellidoMaterno='".$ApellidoMaterno."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'personas_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La persona que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){              $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($Rut) && $Rut!=''){                          $SIS_data .= ",'".$Rut."'";               }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                    $SIS_data .= ",'".$Nombre."'";            }else{$SIS_data .= ",''";}
				if(isset($ApellidoPaterno) && $ApellidoPaterno!=''){  $SIS_data .= ",'".$ApellidoPaterno."'";   }else{$SIS_data .= ",''";}
				if(isset($ApellidoMaterno) && $ApellidoMaterno!=''){  $SIS_data .= ",'".$ApellidoMaterno."'";   }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){          $SIS_data .= ",'".$fNacimiento."'";       }else{$SIS_data .= ",''";}
				if(isset($idSexo) && $idSexo!=''){                    $SIS_data .= ",'".$idSexo."'";            }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                $SIS_data .= ",'".$idCiudad."'";          }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                $SIS_data .= ",'".$idComuna."'";          }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){              $SIS_data .= ",'".$Direccion."'";         }else{$SIS_data .= ",''";}
				if(isset($Sueldo) && $Sueldo!=''){                    $SIS_data .= ",'".$Sueldo."'";            }else{$SIS_data .= ",''";}
				if(isset($idAFP) && $idAFP!=''){                      $SIS_data .= ",'".$idAFP."'";             }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Rut, Nombre,ApellidoPaterno, ApellidoMaterno,fNacimiento,idSexo, idCiudad, idComuna, Direccion, Sueldo, idAFP';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'personas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPaterno)&&isset($ApellidoMaterno)&&isset($idSistema)&&isset($idPersona)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'personas_listado', '', "Nombre='".$Nombre."' AND ApellidoPaterno='".$ApellidoPaterno."' AND ApellidoMaterno='".$ApellidoMaterno."' AND idSistema='".$idSistema."' AND idPersona!='".$idPersona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idPersona)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'personas_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idPersona!='".$idPersona."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La persona que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idPersona='".$idPersona."'";
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Rut) && $Rut!=''){                              $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($ApellidoPaterno) && $ApellidoPaterno!=''){      $SIS_data .= ",ApellidoPaterno='".$ApellidoPaterno."'";}
				if(isset($ApellidoMaterno) && $ApellidoMaterno!=''){      $SIS_data .= ",ApellidoMaterno='".$ApellidoMaterno."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){              $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($idSexo) && $idSexo!=''){                        $SIS_data .= ",idSexo='".$idSexo."'";}
				if(isset($idCiudad) && $idCiudad!=''){                    $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){                    $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){                  $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Sueldo) && $Sueldo!=''){                        $SIS_data .= ",Sueldo='".$Sueldo."'";}
				if(isset($idAFP) && $idAFP!=''){                          $SIS_data .= ",idAFP='".$idAFP."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'personas_listado', 'idPersona = "'.$idPersona.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
				$resultado_1 = db_delete_data (false, 'personas_listado', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'personas_listado_email', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'personas_listado_fono', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_4 = db_delete_data (false, 'personas_listado_redes_sociales', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_5 = db_delete_data (false, 'personas_listado_relaciones', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_6 = db_delete_data (false, 'personas_listado_vehiculos', 'idPersona = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true OR $resultado_5==true OR $resultado_6==true){

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
