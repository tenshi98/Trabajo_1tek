<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridProspectoad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-104).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idProspecto']))             $idProspecto               = $_POST['idProspecto'];
	if (!empty($_POST['idSistema']))               $idSistema                 = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                $idEstado                  = $_POST['idEstado'];
	if (!empty($_POST['idTipo']))                  $idTipo                    = $_POST['idTipo'];
	if (!empty($_POST['idRubro']))                 $idRubro                   = $_POST['idRubro'];
	if (!empty($_POST['email']))                   $email                     = $_POST['email'];
	if (!empty($_POST['Nombre']))                  $Nombre 	                  = $_POST['Nombre'];
	if (!empty($_POST['RazonSocial']))             $RazonSocial 	          = $_POST['RazonSocial'];
	if (!empty($_POST['Rut']))                     $Rut 	                  = $_POST['Rut'];
	if (!empty($_POST['fNacimiento']))             $fNacimiento 	          = $_POST['fNacimiento'];
	if (!empty($_POST['Direccion']))               $Direccion 	              = $_POST['Direccion'];
	if (!empty($_POST['Fono1']))                   $Fono1 	                  = $_POST['Fono1'];
	if (!empty($_POST['Fono2']))                   $Fono2 	                  = $_POST['Fono2'];
	if (!empty($_POST['idCiudad']))                $idCiudad                  = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))                $idComuna                  = $_POST['idComuna'];
	if (!empty($_POST['Fax']))                     $Fax                       = $_POST['Fax'];
	if (!empty($_POST['PersonaContacto']))         $PersonaContacto           = $_POST['PersonaContacto'];
	if (!empty($_POST['PersonaContacto_Fono']))    $PersonaContacto_Fono      = $_POST['PersonaContacto_Fono'];
	if (!empty($_POST['PersonaContacto_email']))   $PersonaContacto_email     = $_POST['PersonaContacto_email'];
	if (!empty($_POST['PersonaContacto_Cargo']))   $PersonaContacto_Cargo     = $_POST['PersonaContacto_Cargo'];
	if (!empty($_POST['Web']))                     $Web                       = $_POST['Web'];
	if ( isset($_POST['Giro']))                    $Giro                      = $_POST['Giro'];
	if (!empty($_POST['F_Ingreso']))               $F_Ingreso                 = $_POST['F_Ingreso'];
	if (!empty($_POST['idUsuario']))               $idUsuario                 = $_POST['idUsuario'];
	if (!empty($_POST['idEstadoFidelizacion']))    $idEstadoFidelizacion      = $_POST['idEstadoFidelizacion'];
	if (!empty($_POST['idEtapa']))                 $idEtapa                   = $_POST['idEtapa'];
	if (!empty($_POST['FModificacion']))           $FModificacion             = $_POST['FModificacion'];
	if (!empty($_POST['HModificacion']))           $HModificacion             = $_POST['HModificacion'];
	if (!empty($_POST['idUsuarioMod']))            $idUsuarioMod              = $_POST['idUsuarioMod'];
	if (!empty($_POST['idTab_1']))                 $idTab_1                   = $_POST['idTab_1'];
	if (!empty($_POST['idTab_2']))                 $idTab_2                   = $_POST['idTab_2'];
	if (!empty($_POST['idTab_3']))                 $idTab_3                   = $_POST['idTab_3'];
	if (!empty($_POST['idTab_4']))                 $idTab_4                   = $_POST['idTab_4'];
	if (!empty($_POST['idTab_5']))                 $idTab_5                   = $_POST['idTab_5'];
	if (!empty($_POST['idTab_6']))                 $idTab_6                   = $_POST['idTab_6'];
	if (!empty($_POST['idTab_7']))                 $idTab_7                   = $_POST['idTab_7'];
	if (!empty($_POST['idTab_8']))                 $idTab_8                   = $_POST['idDia_8'];
	if (!empty($_POST['idTab_9']))                 $idTab_9                   = $_POST['idTab_9'];
	if (!empty($_POST['idTab_10']))                $idTab_10                  = $_POST['idTab_10'];
	if (!empty($_POST['idTab_11']))                $idTab_11                  = $_POST['idTab_11'];
	if (!empty($_POST['idTab_12']))                $idTab_12                  = $_POST['idTab_12'];
	if (!empty($_POST['idTab_13']))                $idTab_13                  = $_POST['idTab_13'];
	if (!empty($_POST['idTab_14']))                $idTab_14                  = $_POST['idTab_14'];
	if (!empty($_POST['idTab_15']))                $idTab_15                  = $_POST['idTab_15'];

	if (!empty($_POST['Contrato_Nombre']))         $Contrato_Nombre           = $_POST['Contrato_Nombre'];
	if (!empty($_POST['Contrato_Numero']))         $Contrato_Numero           = $_POST['Contrato_Numero'];
	if (!empty($_POST['Contrato_Fecha_Ini']))      $Contrato_Fecha_Ini        = $_POST['Contrato_Fecha_Ini'];
	if (!empty($_POST['Contrato_Fecha_Term']))     $Contrato_Fecha_Term       = $_POST['Contrato_Fecha_Term'];
	if (!empty($_POST['Contrato_Valor_Mensual']))  $Contrato_Valor_Mensual    = $_POST['Contrato_Valor_Mensual'];
	if (!empty($_POST['Contrato_Valor_Anual']))    $Contrato_Valor_Anual      = $_POST['Contrato_Valor_Anual'];
	if (!empty($_POST['Contrato_Obs']))            $Contrato_Obs              = $_POST['Contrato_Obs'];

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
			case 'idProspecto':              if(empty($idProspecto)){              $error['idProspecto']               = 'error/No ha ingresado el id';}break;
			case 'idSistema':                if(empty($idSistema)){                $error['idSistema']                 = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':                 if(empty($idEstado)){                 $error['idEstado']                  = 'error/No ha seleccionado el Estado';}break;
			case 'idTipo':                   if(empty($idTipo)){                   $error['idTipo']                    = 'error/No ha seleccionado el tipo de prospecto';}break;
			case 'idRubro':                  if(empty($idRubro)){                  $error['idRubro']                   = 'error/No ha seleccionado el rubro';}break;
			case 'email':                    if(empty($email)){                    $error['email']                     = 'error/No ha ingresado el email';}break;
			case 'Nombre':                   if(empty($Nombre)){                   $error['Nombre']                    = 'error/No ha ingresado el Nombre de Fantasia';}break;
			case 'RazonSocial':              if(empty($RazonSocial)){              $error['RazonSocial']               = 'error/No ha ingresado la Razón Social';}break;
			case 'Rut':                      if(empty($Rut)){                      $error['Rut']                       = 'error/No ha ingresado el Rut';}break;
			case 'fNacimiento':              if(empty($fNacimiento)){              $error['fNacimiento']               = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':                if(empty($Direccion)){                $error['Direccion']                 = 'error/No ha ingresado la dirección';}break;
			case 'Fono1':                    if(empty($Fono1)){                    $error['Fono1']                     = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                    if(empty($Fono2)){                    $error['Fono2']                     = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':                 if(empty($idCiudad)){                 $error['idCiudad']                  = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                 if(empty($idComuna)){                 $error['idComuna']                  = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                      if(empty($Fax)){                      $error['Fax']                       = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':          if(empty($PersonaContacto)){          $error['PersonaContacto']           = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':     if(empty($PersonaContacto_Fono)){     $error['PersonaContacto_Fono']      = 'error/No ha ingresado el Fono de la persona de contacto';}break;
			case 'PersonaContacto_email':    if(empty($PersonaContacto_email)){    $error['PersonaContacto_email']     = 'error/No ha ingresado el Email de la persona de contacto';}break;
			case 'PersonaContacto_Cargo':    if(empty($PersonaContacto_Cargo)){    $error['PersonaContacto_Cargo']     = 'error/No ha ingresado el Cargo de la persona de contacto';}break;
			case 'Web':                      if(empty($Web)){                      $error['Web']                       = 'error/No ha ingresado la pagina web';}break;
			case 'Giro':                     if(empty($Giro)){                     $error['Giro']                      = 'error/No ha ingresado el Giro de la empresa';}break;
			case 'F_Ingreso':                if(empty($F_Ingreso)){                $error['F_Ingreso']                 = 'error/No ha ingresado la fecha de ingreso';}break;
			case 'idUsuario':                if(empty($idUsuario)){                $error['idUsuario']                 = 'error/No ha seleccionado al usuario';}break;
			case 'idEstadoFidelizacion':     if(empty($idEstadoFidelizacion)){     $error['idEstadoFidelizacion']      = 'error/No ha seleccionado el estado de la fidelizacion';}break;
			case 'idEtapa':                  if(empty($idEtapa)){                  $error['idEtapa']                   = 'error/No ha seleccionado la etapa de la fidelizacion';}break;
			case 'FModificacion':            if(empty($FModificacion)){            $error['FModificacion']             = 'error/No ha ingresado la fecha de modificacion';}break;
			case 'HModificacion':            if(empty($HModificacion)){            $error['HModificacion']             = 'error/No ha ingresado la hora de modificacion';}break;
			case 'idUsuarioMod':             if(empty($idUsuarioMod)){             $error['idUsuarioMod']              = 'error/No ha ingresado el usuario de la modificacion';}break;
			case 'idTab_1':                  if(empty($idTab_1)){                  $error['idTab_1']                   = 'error/No ha seleccionado la Unidad de Negocio 1';}break;
			case 'idTab_2':                  if(empty($idTab_2)){                  $error['idTab_2']                   = 'error/No ha seleccionado la Unidad de Negocio 2';}break;
			case 'idTab_3':                  if(empty($idTab_3)){                  $error['idTab_3']                   = 'error/No ha seleccionado la Unidad de Negocio 3';}break;
			case 'idTab_4':                  if(empty($idTab_4)){                  $error['idTab_4']                   = 'error/No ha seleccionado la Unidad de Negocio 4';}break;
			case 'idTab_5':                  if(empty($idTab_5)){                  $error['idTab_5']                   = 'error/No ha seleccionado la Unidad de Negocio 5';}break;
			case 'idTab_6':                  if(empty($idTab_6)){                  $error['idTab_6']                   = 'error/No ha seleccionado la Unidad de Negocio 6';}break;
			case 'idTab_7':                  if(empty($idTab_7)){                  $error['idTab_7']                   = 'error/No ha seleccionado la Unidad de Negocio 7';}break;
			case 'idTab_8':                  if(empty($idTab_8)){                  $error['idTab_8']                   = 'error/No ha seleccionado la Unidad de Negocio 8';}break;
			case 'idTab_9':                  if(empty($idTab_9)){                  $error['idTab_9']                   = 'error/No ha seleccionado la unidad de negocio 9';}break;
			case 'idTab_10':                 if(empty($idTab_10)){                 $error['idTab_10']                  = 'error/No ha seleccionado la unidad de negocio 10';}break;
			case 'idTab_11':                 if(empty($idTab_11)){                 $error['idTab_11']                  = 'error/No ha seleccionado la unidad de negocio 11';}break;
			case 'idTab_12':                 if(empty($idTab_12)){                 $error['idTab_12']                  = 'error/No ha seleccionado la unidad de negocio 12';}break;
			case 'idTab_13':                 if(empty($idTab_13)){                 $error['idTab_13']                  = 'error/No ha seleccionado la unidad de negocio 13';}break;
			case 'idTab_14':                 if(empty($idTab_14)){                 $error['idTab_14']                  = 'error/No ha seleccionado la unidad de negocio 14';}break;
			case 'idTab_15':                 if(empty($idTab_15)){                 $error['idTab_15']                  = 'error/No ha seleccionado la unidad de negocio 15';}break;

			case 'Contrato_Nombre':          if(empty($Contrato_Nombre)){          $error['Contrato_Nombre']           = 'error/No ha ingresado el nombre del contrato';}break;
			case 'Contrato_Numero':          if(empty($Contrato_Numero)){          $error['Contrato_Numero']           = 'error/No ha ingresado el numero o codigo del contrato';}break;
			case 'Contrato_Fecha_Ini':       if(empty($Contrato_Fecha_Ini)){       $error['Contrato_Fecha_Ini']        = 'error/No ha ingresado la fecha de inicio del contrato';}break;
			case 'Contrato_Fecha_Term':      if(empty($Contrato_Fecha_Term)){      $error['Contrato_Fecha_Term']       = 'error/No ha ingresado la fecha de termino del contrato';}break;
			case 'Contrato_Valor_Mensual':   if(empty($Contrato_Valor_Mensual)){   $error['Contrato_Valor_Mensual']    = 'error/No ha ingresado el valor mensual del contrato';}break;
			case 'Contrato_Valor_Anual':     if(empty($Contrato_Valor_Anual)){     $error['Contrato_Valor_Anual']      = 'error/No ha ingresado el valor anual del contrato';}break;
			case 'Contrato_Obs':             if(empty($Contrato_Obs)){             $error['Contrato_Obs']              = 'error/No ha ingresado las observaciones del contrato';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	//if(isset($email) && $email!=''){                                 $email                 = EstandarizarInput($email);}
	if(isset($Nombre) && $Nombre!=''){                               $Nombre                = EstandarizarInput($Nombre);}
	if(isset($RazonSocial) && $RazonSocial!=''){                     $RazonSocial           = EstandarizarInput($RazonSocial);}
	if(isset($Direccion) && $Direccion!=''){                         $Direccion             = EstandarizarInput($Direccion);}
	if(isset($PersonaContacto) && $PersonaContacto!=''){             $PersonaContacto       = EstandarizarInput($PersonaContacto);}
	if(isset($PersonaContacto_email) && $PersonaContacto_email!=''){ $PersonaContacto_email = EstandarizarInput($PersonaContacto_email);}
	if(isset($PersonaContacto_Cargo) && $PersonaContacto_Cargo!=''){ $PersonaContacto_Cargo = EstandarizarInput($PersonaContacto_Cargo);}
	if(isset($Web) && $Web!=''){                                     $Web                   = EstandarizarInput($Web);}
	if(isset($Giro) && $Giro!=''){                                   $Giro                  = EstandarizarInput($Giro);}
	if(isset($Contrato_Nombre) && $Contrato_Nombre!=''){             $Contrato_Nombre       = EstandarizarInput($Contrato_Nombre);}
	if(isset($Contrato_Numero) && $Contrato_Numero!=''){             $Contrato_Numero       = EstandarizarInput($Contrato_Numero);}
	if(isset($Contrato_Obs) && $Contrato_Obs!=''){                   $Contrato_Obs          = EstandarizarInput($Contrato_Obs);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($email)&&contar_palabras_censuradas($email)!=0){                                  $error['email']                 = 'error/Edita email, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                                $error['Nombre']                = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($RazonSocial)&&contar_palabras_censuradas($RazonSocial)!=0){                      $error['RazonSocial']           = 'error/Edita la Razón Social, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){                          $error['Direccion']             = 'error/Edita la Direccion, contiene palabras no permitidas';}
	if(isset($PersonaContacto)&&contar_palabras_censuradas($PersonaContacto)!=0){              $error['PersonaContacto']       = 'error/Edita la Persona de Contacto, contiene palabras no permitidas';}
	if(isset($PersonaContacto_email)&&contar_palabras_censuradas($PersonaContacto_email)!=0){  $error['PersonaContacto_email'] = 'error/Edita la Persona de Contacto email, contiene palabras no permitidas';}
	if(isset($PersonaContacto_Cargo)&&contar_palabras_censuradas($PersonaContacto_Cargo)!=0){  $error['PersonaContacto_Cargo'] = 'error/Edita Persona de Contacto Cargo, contiene palabras no permitidas';}
	if(isset($Web)&&contar_palabras_censuradas($Web)!=0){                                      $error['Web']                   = 'error/Edita la Web, contiene palabras no permitidas';}
	if(isset($Giro)&&contar_palabras_censuradas($Giro)!=0){                                    $error['Giro']                  = 'error/Edita Giro, contiene palabras no permitidas';}
	if(isset($Contrato_Nombre)&&contar_palabras_censuradas($Contrato_Nombre)!=0){              $error['Contrato_Nombre']       = 'error/Edita el nombre del contrato, contiene palabras no permitidas';}
	if(isset($Contrato_Numero)&&contar_palabras_censuradas($Contrato_Numero)!=0){              $error['Contrato_Numero']       = 'error/Edita el numero de contrato, contiene palabras no permitidas';}
	if(isset($Contrato_Obs)&&contar_palabras_censuradas($Contrato_Obs)!=0){                    $error['Contrato_Obs']          = 'error/Edita la observacion del contrato, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){                                 $error['email']                  = 'error/El Email ingresado no es valido';}
	if(isset($Fono1)&&!validarNumero($Fono1)){                                $error['Fono1']                  = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono2)&&!validarNumero($Fono2)){                                $error['Fono2']                  = 'error/Ingrese un número telefónico válido';}
	if(isset($Rut)&&!validarRut($Rut)){                                       $error['Rut']                    = 'error/El Rut ingresado no es valido';}
	if(isset($PersonaContacto_email)&&!validarEmail($PersonaContacto_email)){ $error['email']                  = 'error/El Email ingresado no es valido';}
	if(isset($PersonaContacto_Fono)&&!validarNumero($PersonaContacto_Fono)){  $error['PersonaContacto_Fono']   = 'error/Ingrese un número telefónico válido';}

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
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'prospectos_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email, $idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'prospectos_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                           $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                             $SIS_data .= ",'".$idEstado."'";               }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                                 $SIS_data .= ",'".$idTipo."'";                 }else{$SIS_data .= ",''";}
				if(isset($idRubro) && $idRubro!=''){                               $SIS_data .= ",'".$idRubro."'";                }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                                   $SIS_data .= ",'".$email."'";                  }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                 $SIS_data .= ",'".$Nombre."'";                 }else{$SIS_data .= ",''";}
				if(isset($RazonSocial) && $RazonSocial!=''){                       $SIS_data .= ",'".$RazonSocial."'";            }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                                       $SIS_data .= ",'".$Rut."'";                    }else{$SIS_data .= ",''";}
				if(isset($fNacimiento) && $fNacimiento!=''){                       $SIS_data .= ",'".$fNacimiento."'";            }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                           $SIS_data .= ",'".$Direccion."'";              }else{$SIS_data .= ",''";}
				if(isset($Fono1) && $Fono1!=''){                                   $SIS_data .= ",'".$Fono1."'";                  }else{$SIS_data .= ",''";}
				if(isset($Fono2) && $Fono2!=''){                                   $SIS_data .= ",'".$Fono2."'";                  }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                             $SIS_data .= ",'".$idCiudad."'";               }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                             $SIS_data .= ",'".$idComuna."'";               }else{$SIS_data .= ",''";}
				if(isset($Fax) && $Fax!=''){                                       $SIS_data .= ",'".$Fax."'";                    }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto) && $PersonaContacto!=''){               $SIS_data .= ",'".$PersonaContacto."'";        }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!=''){     $SIS_data .= ",'".$PersonaContacto_Fono."'";   }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!=''){   $SIS_data .= ",'".$PersonaContacto_email."'";  }else{$SIS_data .= ",''";}
				if(isset($PersonaContacto_Cargo) && $PersonaContacto_Cargo!=''){   $SIS_data .= ",'".$PersonaContacto_Cargo."'";  }else{$SIS_data .= ",''";}
				if(isset($Web) && $Web!=''){                                       $SIS_data .= ",'".$Web."'";                    }else{$SIS_data .= ",''";}
				if(isset($Giro) && $Giro!=''){                                     $SIS_data .= ",'".$Giro."'";                   }else{$SIS_data .= ",''";}
				if(isset($F_Ingreso) && $F_Ingreso!=''){                           $SIS_data .= ",'".$F_Ingreso."'";              }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                           $SIS_data .= ",'".$idUsuario."'";              }else{$SIS_data .= ",''";}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion!=''){     $SIS_data .= ",'".$idEstadoFidelizacion."'";   }else{$SIS_data .= ",''";}
				if(isset($idEtapa) && $idEtapa!=''){                               $SIS_data .= ",'".$idEtapa."'";                }else{$SIS_data .= ",''";}
				if(isset($FModificacion) && $FModificacion!=''){                   $SIS_data .= ",'".$FModificacion."'";          }else{$SIS_data .= ",''";}
				if(isset($HModificacion) && $HModificacion!=''){                   $SIS_data .= ",'".$HModificacion."'";          }else{$SIS_data .= ",''";}
				if(isset($idUsuarioMod) && $idUsuarioMod!=''){                     $SIS_data .= ",'".$idUsuarioMod."'";           }else{$SIS_data .= ",''";}
				if(isset($idTab_1) && $idTab_1!=''){                               $SIS_data .= ",'".$idTab_1."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_2) && $idTab_2!=''){                               $SIS_data .= ",'".$idTab_2."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_3) && $idTab_3!=''){                               $SIS_data .= ",'".$idTab_3."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_4) && $idTab_4!=''){                               $SIS_data .= ",'".$idTab_4."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_5) && $idTab_5!=''){                               $SIS_data .= ",'".$idTab_5."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_6) && $idTab_6!=''){                               $SIS_data .= ",'".$idTab_6."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_7) && $idTab_7!=''){                               $SIS_data .= ",'".$idTab_7."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_8) && $idTab_8!=''){                               $SIS_data .= ",'".$idTab_8."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_9) && $idTab_9!=''){                               $SIS_data .= ",'".$idTab_9."'";                }else{$SIS_data .= ",''";}
				if(isset($idTab_10) && $idTab_10!=''){                             $SIS_data .= ",'".$idTab_10."'";               }else{$SIS_data .= ",''";}
				if(isset($idTab_11) && $idTab_11!=''){                             $SIS_data .= ",'".$idTab_11."'";               }else{$SIS_data .= ",''";}
				if(isset($idTab_12) && $idTab_12!=''){                             $SIS_data .= ",'".$idTab_12."'";               }else{$SIS_data .= ",''";}
				if(isset($idTab_13) && $idTab_13!=''){                             $SIS_data .= ",'".$idTab_13."'";               }else{$SIS_data .= ",''";}
				if(isset($idTab_14) && $idTab_14!=''){                             $SIS_data .= ",'".$idTab_14."'";               }else{$SIS_data .= ",''";}
				if(isset($idTab_15) && $idTab_15!=''){                             $SIS_data .= ",'".$idTab_15."'";               }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, idTipo, idRubro, email, Nombre,
				RazonSocial, Rut, fNacimiento, Direccion, Fono1, Fono2, idCiudad, idComuna, Fax, PersonaContacto,
				PersonaContacto_Fono, PersonaContacto_email, PersonaContacto_Cargo, Web, Giro, F_Ingreso, idUsuario,
				idEstadoFidelizacion, idEtapa, FModificacion, HModificacion, idUsuarioMod, idTab_1, idTab_2, idTab_3,
				idTab_4, idTab_5, idTab_6, idTab_7, idTab_8, idTab_9, idTab_10, idTab_11, idTab_12, idTab_13,
				idTab_14, idTab_15';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'prospectos_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'prospectos_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_3 = db_select_nrows (false, 'email', 'prospectos_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idProspecto='".$idProspecto."'";
				if(isset($idSistema) && $idSistema!=''){                             $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                               $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idTipo) && $idTipo!=''){                                   $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idRubro) && $idRubro!=''){                                 $SIS_data .= ",idRubro='".$idRubro."'";}
				if(isset($email) && $email!=''){                                     $SIS_data .= ",email='".$email."'";}
				if(isset($Nombre) && $Nombre!=''){                                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($RazonSocial) && $RazonSocial!=''){                         $SIS_data .= ",RazonSocial='".$RazonSocial."'";}
				if(isset($Rut) && $Rut!=''){                                         $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){                         $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($Direccion) && $Direccion!=''){                             $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Fono1) && $Fono1!=''){                                     $SIS_data .= ",Fono1='".$Fono1."'";}
				if(isset($Fono2) && $Fono2!=''){                                     $SIS_data .= ",Fono2='".$Fono2."'";}
				if(isset($idCiudad) && $idCiudad!= ''){                              $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!= ''){                              $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Fax) && $Fax!= ''){                                        $SIS_data .= ",Fax='".$Fax."'";}
				if(isset($PersonaContacto) && $PersonaContacto!= ''){                $SIS_data .= ",PersonaContacto='".$PersonaContacto."'";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!= ''){      $SIS_data .= ",PersonaContacto_Fono='".$PersonaContacto_Fono."'";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!= ''){    $SIS_data .= ",PersonaContacto_email='".$PersonaContacto_email."'";}
				if(isset($PersonaContacto_Cargo) && $PersonaContacto_Cargo!= ''){    $SIS_data .= ",PersonaContacto_Cargo='".$PersonaContacto_Cargo."'";}
				if(isset($Web) && $Web!= ''){                                        $SIS_data .= ",Web='".$Web."'";}
				if(isset($Giro) && $Giro!= ''){                                      $SIS_data .= ",Giro='".$Giro."'";}
				if(isset($F_Ingreso) && $F_Ingreso!= ''){                            $SIS_data .= ",F_Ingreso='".$F_Ingreso."'";}
				if(isset($idUsuario) && $idUsuario!= ''){                            $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion!= ''){      $SIS_data .= ",idEstadoFidelizacion='".$idEstadoFidelizacion."'";}
				if(isset($idEtapa) && $idEtapa!= ''){                                $SIS_data .= ",idEtapa='".$idEtapa."'";}
				if(isset($FModificacion) && $FModificacion!= ''){                    $SIS_data .= ",FModificacion='".$FModificacion."'";}
				if(isset($HModificacion) && $HModificacion!= ''){                    $SIS_data .= ",HModificacion='".$HModificacion."'";}
				if(isset($idUsuarioMod) && $idUsuarioMod!= ''){                      $SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";}
				if(isset($idTab_1) && $idTab_1!= ''){                                $SIS_data .= ",idTab_1='".$idTab_1."'";}
				if(isset($idTab_2) && $idTab_2!= ''){                                $SIS_data .= ",idTab_2='".$idTab_2."'";}
				if(isset($idTab_3) && $idTab_3!= ''){                                $SIS_data .= ",idTab_3='".$idTab_3."'";}
				if(isset($idTab_4) && $idTab_4!= ''){                                $SIS_data .= ",idTab_4='".$idTab_4."'";}
				if(isset($idTab_5) && $idTab_5!= ''){                                $SIS_data .= ",idTab_5='".$idTab_5."'";}
				if(isset($idTab_6) && $idTab_6!= ''){                                $SIS_data .= ",idTab_6='".$idTab_6."'";}
				if(isset($idTab_7) && $idTab_7!= ''){                                $SIS_data .= ",idTab_7='".$idTab_7."'";}
				if(isset($idTab_8) && $idTab_8!= ''){                                $SIS_data .= ",idTab_8='".$idTab_8."'";}
				if(isset($idTab_9) && $idTab_9!= ''){                                $SIS_data .= ",idTab_9='".$idTab_9."'";}
				if(isset($idTab_10) && $idTab_10!= ''){                              $SIS_data .= ",idTab_10='".$idTab_10."'";}
				if(isset($idTab_11) && $idTab_11!= ''){                              $SIS_data .= ",idTab_11='".$idTab_11."'";}
				if(isset($idTab_12) && $idTab_12!= ''){                              $SIS_data .= ",idTab_12='".$idTab_12."'";}
				if(isset($idTab_13) && $idTab_13!= ''){                              $SIS_data .= ",idTab_13='".$idTab_13."'";}
				if(isset($idTab_14) && $idTab_14!= ''){                              $SIS_data .= ",idTab_14='".$idTab_14."'";}
				if(isset($idTab_15) && $idTab_15!= ''){                              $SIS_data .= ",idTab_15='".$idTab_15."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'prospectos_listado', 'idProspecto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idProspecto    = $_GET['id'];
			$idEstado       = simpleDecode($_GET['estado'], fecha_actual());
			$FModificacion  = fecha_actual();
			$HModificacion  = hora_actual();
			$idUsuarioMod   = $_SESSION['usuario']['basic_data']['idUsuario'];

			/*******************************************************/
			//se actualizan los datos
			$SIS_data  = "idEstado='".$idEstado."'";
			$SIS_data .= ",FModificacion='".$FModificacion."'";
			$SIS_data .= ",HModificacion='".$HModificacion."'";
			$SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";
			$resultado = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'crear_cliente':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************/
			//Obtengo  los datos
			$squery = 'idEtapa';
			$rowEtapa = db_select_data (false, $squery, 'prospectos_etapa', '', 'idEtapa!=0 ORDER BY Nombre DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			$squery = 'idSistema,idTipo,idRubro,email,Nombre,RazonSocial,Rut,fNacimiento,Direccion,Fono1,Fono2,idCiudad,idComuna,Fax,PersonaContacto,PersonaContacto_Fono,PersonaContacto_email,PersonaContacto_Cargo,Web,Giro,idTab_1,idTab_2,idTab_3,idTab_4,idTab_5,idTab_6,idTab_7,idTab_8,idTab_9,idTab_10,idTab_11,idTab_12,idTab_13,idTab_14,idTab_15';
			$rowProspecto = db_select_data (false, $squery, 'prospectos_listado', '', 'idProspecto='.$idProspecto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//verifico si cliente existe
			$ndata_1 = 0;
			if(isset($rowProspecto['Rut'])&&isset($rowProspecto['idSistema'])){
				$ndata_1    = db_select_nrows (false, 'Rut', 'clientes_listado', '', "Rut='".$rowProspecto['Rut']."' AND idSistema='".$rowProspecto['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowCliente = db_select_data (false, 'idCliente', 'clientes_listado', '', "Rut='".$rowProspecto['Rut']."' AND idSistema='".$rowProspecto['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//Verifico que exista la etapa
				if(isset($rowEtapa['idEtapa']) && $rowEtapa['idEtapa']!=''){

					//variables
					$FModificacion  = fecha_actual();
					$HModificacion  = hora_actual();
					$idUsuarioMod   = $_SESSION['usuario']['basic_data']['idUsuario'];

					/*******************************************************/
					//Actualizo el prospecto
					$SIS_data  = "idProspecto='".$idProspecto."'";
					$SIS_data .= ",idEstado='2'";                         //Se desactiva prospecto
					$SIS_data .= ",idEtapa='".$rowEtapa['idEtapa']."'";   //se cambia a etapa de cierre
					$SIS_data .= ",FModificacion='".$FModificacion."'";   //se cambia la fecha de modificacion
					$SIS_data .= ",HModificacion='".$HModificacion."'";   //se cambia la hora de modificacion
					$SIS_data .= ",idUsuarioMod='".$idUsuarioMod."'";     //se cambia el usuario de modificacion

					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'prospectos_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*******************************************************/
					//verifico si existe el cliente
					/*******************************************/
					//variables
					$idEstado    = 1;
					$password    = 1234;
					$new_folder  = 1;
					$fNacimiento = fecha_actual();

					//se actualizaal cliente
					if($ndata_1!=0){
						//Filtros

						$SIS_data = "idCliente='".$rowCliente['idCliente']."'";
						if(isset($rowProspecto['idSistema']) && $rowProspecto['idSistema']!=''){                                 $SIS_data .= ",idSistema='".$rowProspecto['idSistema']."'";}
						if(isset($rowProspecto['idTipo']) && $rowProspecto['idTipo']!=''){                                       $SIS_data .= ",idTipo='".$rowProspecto['idTipo']."'";}
						if(isset($rowProspecto['idRubro']) && $rowProspecto['idRubro']!=''){                                     $SIS_data .= ",idRubro='".$rowProspecto['idRubro']."'";}
						if(isset($rowProspecto['email']) && $rowProspecto['email']!=''){                                         $SIS_data .= ",email='".$rowProspecto['email']."'";}
						if(isset($rowProspecto['Nombre']) && $rowProspecto['Nombre']!=''){                                       $SIS_data .= ",Nombre='".$rowProspecto['Nombre']."'";}
						if(isset($rowProspecto['RazonSocial']) && $rowProspecto['RazonSocial']!=''){                             $SIS_data .= ",RazonSocial='".$rowProspecto['RazonSocial']."'";}
						if(isset($rowProspecto['Rut']) && $rowProspecto['Rut']!=''){                                             $SIS_data .= ",Rut='".$rowProspecto['Rut']."'";}
						if(isset($fNacimiento) && $fNacimiento!=''){                                                             $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
						if(isset($rowProspecto['Direccion']) && $rowProspecto['Direccion']!=''){                                 $SIS_data .= ",Direccion='".$rowProspecto['Direccion']."'";}
						if(isset($rowProspecto['Fono1']) && $rowProspecto['Fono1']!=''){                                         $SIS_data .= ",Fono1='".$rowProspecto['Fono1']."'";}
						if(isset($rowProspecto['Fono2']) && $rowProspecto['Fono2']!=''){                                         $SIS_data .= ",Fono2='".$rowProspecto['Fono2']."'";}
						if(isset($rowProspecto['idCiudad']) && $rowProspecto['idCiudad']!= ''){                                  $SIS_data .= ",idCiudad='".$rowProspecto['idCiudad']."'";}
						if(isset($rowProspecto['idComuna']) && $rowProspecto['idComuna']!= ''){                                  $SIS_data .= ",idComuna='".$rowProspecto['idComuna']."'";}
						if(isset($rowProspecto['Fax']) && $rowProspecto['Fax']!= ''){                                            $SIS_data .= ",Fax='".$rowProspecto['Fax']."'";}
						if(isset($rowProspecto['PersonaContacto']) && $rowProspecto['PersonaContacto']!= ''){                    $SIS_data .= ",PersonaContacto='".$rowProspecto['PersonaContacto']."'";}
						if(isset($rowProspecto['PersonaContacto_Fono']) && $rowProspecto['PersonaContacto_Fono']!= ''){          $SIS_data .= ",PersonaContacto_Fono='".$rowProspecto['PersonaContacto_Fono']."'";}
						if(isset($rowProspecto['PersonaContacto_email']) && $rowProspecto['PersonaContacto_email']!= ''){        $SIS_data .= ",PersonaContacto_email='".$rowProspecto['PersonaContacto_email']."'";}
						if(isset($rowProspecto['PersonaContacto_Cargo']) && $rowProspecto['PersonaContacto_Cargo']!= ''){        $SIS_data .= ",PersonaContacto_Cargo='".$rowProspecto['PersonaContacto_Cargo']."'";}
						if(isset($rowProspecto['Web']) && $rowProspecto['Web']!= ''){                                            $SIS_data .= ",Web='".$rowProspecto['Web']."'";}
						if(isset($rowProspecto['Giro']) && $rowProspecto['Giro']!= ''){                                          $SIS_data .= ",Giro='".$rowProspecto['Giro']."'";}
						if(isset($rowProspecto['idTab_1']) && $rowProspecto['idTab_1']!= ''){                                    $SIS_data .= ",idTab_1='".$rowProspecto['idTab_1']."'";}
						if(isset($rowProspecto['idTab_2']) && $rowProspecto['idTab_2']!= ''){                                    $SIS_data .= ",idTab_2='".$rowProspecto['idTab_2']."'";}
						if(isset($rowProspecto['idTab_3']) && $rowProspecto['idTab_3']!= ''){                                    $SIS_data .= ",idTab_3='".$rowProspecto['idTab_3']."'";}
						if(isset($rowProspecto['idTab_4']) && $rowProspecto['idTab_4']!= ''){                                    $SIS_data .= ",idTab_4='".$rowProspecto['idTab_4']."'";}
						if(isset($rowProspecto['idTab_5']) && $rowProspecto['idTab_5']!= ''){                                    $SIS_data .= ",idTab_5='".$rowProspecto['idTab_5']."'";}
						if(isset($rowProspecto['idTab_6']) && $rowProspecto['idTab_6']!= ''){                                    $SIS_data .= ",idTab_6='".$rowProspecto['idTab_6']."'";}
						if(isset($rowProspecto['idTab_7']) && $rowProspecto['idTab_7']!= ''){                                    $SIS_data .= ",idTab_7='".$rowProspecto['idTab_7']."'";}
						if(isset($rowProspecto['idTab_8']) && $rowProspecto['idTab_8']!= ''){                                    $SIS_data .= ",idTab_8='".$rowProspecto['idTab_8']."'";}
						if(isset($rowProspecto['idTab_9']) && $rowProspecto['idTab_9']!= ''){                                    $SIS_data .= ",idTab_9='".$rowProspecto['idTab_9']."'";}
						if(isset($rowProspecto['idTab_10']) && $rowProspecto['idTab_10']!= ''){                                  $SIS_data .= ",idTab_10='".$rowProspecto['idTab_10']."'";}
						if(isset($rowProspecto['idTab_11']) && $rowProspecto['idTab_11']!= ''){                                  $SIS_data .= ",idTab_11='".$rowProspecto['idTab_11']."'";}
						if(isset($rowProspecto['idTab_12']) && $rowProspecto['idTab_12']!= ''){                                  $SIS_data .= ",idTab_12='".$rowProspecto['idTab_12']."'";}
						if(isset($rowProspecto['idTab_13']) && $rowProspecto['idTab_13']!= ''){                                  $SIS_data .= ",idTab_13='".$rowProspecto['idTab_13']."'";}
						if(isset($rowProspecto['idTab_14']) && $rowProspecto['idTab_14']!= ''){                                  $SIS_data .= ",idTab_14='".$rowProspecto['idTab_14']."'";}
						if(isset($rowProspecto['idTab_15']) && $rowProspecto['idTab_15']!= ''){                                  $SIS_data .= ",idTab_15='".$rowProspecto['idTab_15']."'";}

						if(isset($Contrato_Nombre) && $Contrato_Nombre!= ''){                                                    $SIS_data .= ",Contrato_Nombre='".$Contrato_Nombre."'";}
						if(isset($Contrato_Numero) && $Contrato_Numero!= ''){                                                    $SIS_data .= ",Contrato_Numero='".$Contrato_Numero."'";}
						if(isset($Contrato_Fecha_Ini) && $Contrato_Fecha_Ini!= ''){                                              $SIS_data .= ",Contrato_Fecha_Ini='".$Contrato_Fecha_Ini."'";}
						if(isset($Contrato_Fecha_Term) && $Contrato_Fecha_Term!= ''){                                            $SIS_data .= ",Contrato_Fecha_Term='".$Contrato_Fecha_Term."'";}
						if(isset($Contrato_Valor_Mensual) && $Contrato_Valor_Mensual!= ''){                                      $SIS_data .= ",Contrato_Valor_Mensual='".$Contrato_Valor_Mensual."'";}
						if(isset($Contrato_Valor_Anual) && $Contrato_Valor_Anual!= ''){                                          $SIS_data .= ",Contrato_Valor_Anual='".$Contrato_Valor_Anual."'";}
						if(isset($Contrato_Obs) && $Contrato_Obs!= ''){                                                          $SIS_data .= ",Contrato_Obs='".$Contrato_Obs."'";}
						$SIS_data .= ",idEstado='".$idEstado."'";
						$SIS_data .= ",password='".md5($password)."'";

						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'clientes_listado', 'idCliente = "'.$rowCliente['idCliente'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Si ejecuto correctamente la consulta
						if($resultado==true){

							//Se crea la carpeta del cliente
							if(isset($new_folder)&&$new_folder!=''&&$new_folder==1){
								//verifico que exista el rut
								if(isset($rowProspecto['Rut'])&&$rowProspecto['Rut']!=''){
									$Rut = $rowProspecto['Rut'];
									$Rut = str_replace(' ', '', $Rut);//elimino espacios
									$Rut = str_replace('-', '', $Rut);//elimino los guiones
									$Rut = str_replace('.', '', $Rut);//elimino los puntos
									$ruta = "ClientFiles/_public/Cliente_".$Rut;
									//si no existe la carpeta
									if (!file_exists($ruta)){
										try {
											$oldmask = umask(000);//it will set the new umask and returns the old one
											mkdir($ruta, 0777);
											umask($oldmask);//reset the old umask
											//redirijo
											header( 'Location: '.$location.'&id='.$rowCliente['idCliente'].'&created=true' );
											die;
										}catch (Exception $e) {
											//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
											$error['ndata_1'] = 'error/'.$e->getMessage();
										}
									//si existe carpeta se devuelve error
									}else{
										//$error['ndata_1'] = 'error/La carpeta del cliente ya existe';
									}
								//si no existe el rut
								}else{
									$error['ndata_1'] = 'error/El cliente debe tener un rut valido ingresado para poder crear la carpeta';
								}

							}else{
								//redirijo
								header( 'Location: '.$location.'&edited=true' );
								die;
							}

						}
					/*******************************************/
					//se crea uno nuevo	
					}else{

						//filtros
						if(isset($rowProspecto['idSistema']) && $rowProspecto['idSistema']!=''){                               $SIS_data  = "'".$rowProspecto['idSistema']."'";                 }else{$SIS_data  = "''";}
						if(isset($rowProspecto['idTipo']) && $rowProspecto['idTipo']!=''){                                     $SIS_data .= ",'".$rowProspecto['idTipo']."'";                   }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idRubro']) && $rowProspecto['idRubro']!=''){                                   $SIS_data .= ",'".$rowProspecto['idRubro']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['email']) && $rowProspecto['email']!=''){                                       $SIS_data .= ",'".$rowProspecto['email']."'";                    }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Nombre']) && $rowProspecto['Nombre']!=''){                                     $SIS_data .= ",'".$rowProspecto['Nombre']."'";                   }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['RazonSocial']) && $rowProspecto['RazonSocial']!=''){                           $SIS_data .= ",'".$rowProspecto['RazonSocial']."'";              }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Rut']) && $rowProspecto['Rut']!=''){                                           $SIS_data .= ",'".$rowProspecto['Rut']."'";                      }else{$SIS_data .= ",''";}
						if(isset($fNacimiento) && $fNacimiento!=''){                                                           $SIS_data .= ",'".$fNacimiento."'";                              }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Direccion']) && $rowProspecto['Direccion']!=''){                               $SIS_data .= ",'".$rowProspecto['Direccion']."'";                }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Fono1']) && $rowProspecto['Fono1']!=''){                                       $SIS_data .= ",'".$rowProspecto['Fono1']."'";                    }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Fono2']) && $rowProspecto['Fono2']!=''){                                       $SIS_data .= ",'".$rowProspecto['Fono2']."'";                    }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idCiudad']) && $rowProspecto['idCiudad']!=''){                                 $SIS_data .= ",'".$rowProspecto['idCiudad']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idComuna']) && $rowProspecto['idComuna']!=''){                                 $SIS_data .= ",'".$rowProspecto['idComuna']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Fax']) && $rowProspecto['Fax']!=''){                                           $SIS_data .= ",'".$rowProspecto['Fax']."'";                      }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['PersonaContacto']) && $rowProspecto['PersonaContacto']!=''){                   $SIS_data .= ",'".$rowProspecto['PersonaContacto']."'";          }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['PersonaContacto_Fono']) && $rowProspecto['PersonaContacto_Fono']!=''){         $SIS_data .= ",'".$rowProspecto['PersonaContacto_Fono']."'";     }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['PersonaContacto_email']) && $rowProspecto['PersonaContacto_email']!=''){       $SIS_data .= ",'".$rowProspecto['PersonaContacto_email']."'";    }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['PersonaContacto_Cargo']) && $rowProspecto['PersonaContacto_Cargo']!=''){       $SIS_data .= ",'".$rowProspecto['PersonaContacto_Cargo']."'";    }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Web']) && $rowProspecto['Web']!=''){                                           $SIS_data .= ",'".$rowProspecto['Web']."'";                      }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['Giro']) && $rowProspecto['Giro']!=''){                                         $SIS_data .= ",'".$rowProspecto['Giro']."'";                     }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_1']) && $rowProspecto['idTab_1']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_1']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_2']) && $rowProspecto['idTab_2']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_2']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_3']) && $rowProspecto['idTab_3']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_3']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_4']) && $rowProspecto['idTab_4']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_4']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_5']) && $rowProspecto['idTab_5']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_5']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_6']) && $rowProspecto['idTab_6']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_6']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_7']) && $rowProspecto['idTab_7']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_7']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_8']) && $rowProspecto['idTab_8']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_8']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_9']) && $rowProspecto['idTab_9']!= ''){                                  $SIS_data .= ",'".$rowProspecto['idTab_9']."'";                  }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_10']) && $rowProspecto['idTab_10']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_10']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_11']) && $rowProspecto['idTab_11']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_11']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_12']) && $rowProspecto['idTab_12']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_12']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_13']) && $rowProspecto['idTab_13']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_13']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_14']) && $rowProspecto['idTab_14']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_14']."'";                 }else{$SIS_data .= ",''";}
						if(isset($rowProspecto['idTab_15']) && $rowProspecto['idTab_15']!= ''){                                $SIS_data .= ",'".$rowProspecto['idTab_15']."'";                 }else{$SIS_data .= ",''";}
						if(isset($Contrato_Nombre) && $Contrato_Nombre!=''){                                                   $SIS_data .= ",'".$Contrato_Nombre."'";                          }else{$SIS_data .= ",''";}
						if(isset($Contrato_Numero) && $Contrato_Numero!=''){                                                   $SIS_data .= ",'".$Contrato_Numero."'";                          }else{$SIS_data .= ",''";}
						if(isset($Contrato_Fecha_Ini) && $Contrato_Fecha_Ini!=''){                                             $SIS_data .= ",'".$Contrato_Fecha_Ini."'";                       }else{$SIS_data .= ",''";}
						if(isset($Contrato_Fecha_Term) && $Contrato_Fecha_Term!=''){                                           $SIS_data .= ",'".$Contrato_Fecha_Term."'";                      }else{$SIS_data .= ",''";}
						if(isset($Contrato_Valor_Mensual) && $Contrato_Valor_Mensual!=''){                                     $SIS_data .= ",'".$Contrato_Valor_Mensual."'";                   }else{$SIS_data .= ",''";}
						if(isset($Contrato_Valor_Anual) && $Contrato_Valor_Anual!=''){                                         $SIS_data .= ",'".$Contrato_Valor_Anual."'";                     }else{$SIS_data .= ",''";}
						if(isset($Contrato_Obs) && $Contrato_Obs!=''){                                                         $SIS_data .= ",'".$Contrato_Obs."'";                             }else{$SIS_data .= ",''";}
						$SIS_data .= ",'".$idEstado."'";
						$SIS_data .= ",'".md5($password)."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idSistema,idTipo,idRubro,email,Nombre,RazonSocial,
						Rut,fNacimiento,Direccion,Fono1,Fono2,idCiudad,idComuna,Fax,PersonaContacto,PersonaContacto_Fono,
						PersonaContacto_email,PersonaContacto_Cargo,Web,Giro,idTab_1,idTab_2,idTab_3,idTab_4,idTab_5,
						idTab_6,idTab_7, idTab_8, idTab_9, idTab_10, idTab_11, idTab_12, idTab_13, idTab_14, idTab_15,
						Contrato_Nombre,Contrato_Numero, Contrato_Fecha_Ini, Contrato_Fecha_Term, Contrato_Valor_Mensual,
						Contrato_Valor_Anual, Contrato_Obs,idEstado,password';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'clientes_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Si ejecuto correctamente la consulta
						if($ultimo_id!=0){

							//Se verifica rut
							if(isset($rowProspecto['Rut'])&&$rowProspecto['Rut']!=''){
								//Se crea la carpeta del cliente
								if(isset($new_folder)&&$new_folder!=''&&$new_folder==1){

									$Rut = $rowProspecto['Rut'];
									$Rut = str_replace(' ', '', $Rut);//elimino espacios
									$Rut = str_replace('-', '', $Rut);//elimino los guiones
									$Rut = str_replace('.', '', $Rut);//elimino los puntos
									$ruta = "ClientFiles/_public/Cliente_".$Rut;
									//si no existe la carpeta
									if (!file_exists($ruta)){
										try {
											$oldmask = umask(000);//it will set the new umask and returns the old one
											mkdir($ruta, 0777);
											umask($oldmask);//reset the old umask
											//redirijo
											header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
											die;
										}catch (Exception $e) {
											//echo 'Excepción capturada: ',  $e->getMessage(), "\n";
											$error['ndata_1'] = 'error/'.$e->getMessage();
										}
									//si existe carpeta se devuelve error
									}else{
										//$error['ndata_1'] = 'error/La carpeta del cliente ya existe';
										header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
									}
								}else{
									//redirijo
									header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
									die;
								}
							//si no hay rut
							}else{
								//no se crean las carpetas y se redirige
								header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
							}
						}
					}

					/*******************************************************/

				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
