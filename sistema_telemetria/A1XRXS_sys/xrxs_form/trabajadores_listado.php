<?php
//Llamamos a la libreria para importar datos en excel
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-196).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTrabajador']))                $idTrabajador                 = $_POST['idTrabajador'];
	if (!empty($_POST['idSistema']))                   $idSistema                    = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))                    $idEstado                     = $_POST['idEstado'];
	if (!empty($_POST['Nombre']))                      $Nombre                       = $_POST['Nombre'];
	if (!empty($_POST['ApellidoPat']))                 $ApellidoPat                  = $_POST['ApellidoPat'];
	if (!empty($_POST['ApellidoMat']))                 $ApellidoMat                  = $_POST['ApellidoMat'];
	if (!empty($_POST['idTipo']))                      $idTipo                       = $_POST['idTipo'];
	if (!empty($_POST['Cargo']))                       $Cargo                        = $_POST['Cargo'];
	if (!empty($_POST['Fono']))                        $Fono                         = $_POST['Fono'];
	if (!empty($_POST['Rut']))                         $Rut                          = $_POST['Rut'];
	if (!empty($_POST['N_Documento']))                 $N_Documento                  = $_POST['N_Documento'];
	if (!empty($_POST['idCiudad']))                    $idCiudad                     = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))                    $idComuna                     = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))                   $Direccion                    = $_POST['Direccion'];
	if (!empty($_POST['Observaciones']))               $Observaciones                = $_POST['Observaciones'];
	if (!empty($_POST['idLicitacion']))                $idLicitacion                 = $_POST['idLicitacion'];
	if (!empty($_POST['FechaContrato']))               $FechaContrato                = $_POST['FechaContrato'];
	if (!empty($_POST['F_Inicio_Contrato']))           $F_Inicio_Contrato            = $_POST['F_Inicio_Contrato'];
	if (!empty($_POST['F_Termino_Contrato']))          $F_Termino_Contrato           = $_POST['F_Termino_Contrato'];
	if (!empty($_POST['idAFP']))                       $idAFP                        = $_POST['idAFP'];
	if (!empty($_POST['idSalud']))                     $idSalud                      = $_POST['idSalud'];
	if (!empty($_POST['idTipoContrato']))              $idTipoContrato               = $_POST['idTipoContrato'];
	if (!empty($_POST['idTipoLicencia']))              $idTipoLicencia               = $_POST['idTipoLicencia'];
	if (!empty($_POST['CA_Licencia']))                 $CA_Licencia                  = $_POST['CA_Licencia'];
	if (!empty($_POST['LicenciaFechaControl']))        $LicenciaFechaControl         = $_POST['LicenciaFechaControl'];
	if (!empty($_POST['LicenciaFechaControlUltimo']))  $LicenciaFechaControlUltimo   = $_POST['LicenciaFechaControlUltimo'];
	if (!empty($_POST['ContactoPersona']))             $ContactoPersona              = $_POST['ContactoPersona'];
	if (!empty($_POST['ContactoFono']))                $ContactoFono                 = $_POST['ContactoFono'];
	if (!empty($_POST['idSexo']))                      $idSexo                       = $_POST['idSexo'];
	if (!empty($_POST['FNacimiento']))                 $FNacimiento                  = $_POST['FNacimiento'];
	if (!empty($_POST['idEstadoCivil']))               $idEstadoCivil                = $_POST['idEstadoCivil'];
	if (!empty($_POST['SueldoLiquido']))               $SueldoLiquido                = $_POST['SueldoLiquido'];
	if (!empty($_POST['SueldoDia']))                   $SueldoDia                    = $_POST['SueldoDia'];
	if (!empty($_POST['SueldoHora']))                  $SueldoHora                   = $_POST['SueldoHora'];
	if (!empty($_POST['email']))                       $email                        = $_POST['email'];
	if (!empty($_POST['idTransporte']))                $idTransporte                 = $_POST['idTransporte'];
	if (!empty($_POST['idTipoContratoTrab']))          $idTipoContratoTrab           = $_POST['idTipoContratoTrab'];
	if (!empty($_POST['horas_pactadas']))              $horas_pactadas               = $_POST['horas_pactadas'];
	if (!empty($_POST['Gratificacion']))               $Gratificacion                = $_POST['Gratificacion'];
	if (!empty($_POST['idTipoTrabajador']))            $idTipoTrabajador             = $_POST['idTipoTrabajador'];
	if (!empty($_POST['idContratista']))               $idContratista                = $_POST['idContratista'];
	if (!empty($_POST['File_RHTM_Fecha']))             $File_RHTM_Fecha              = $_POST['File_RHTM_Fecha'];
	if (!empty($_POST['idCentroCosto']))               $idCentroCosto                = $_POST['idCentroCosto'];
	if (!empty($_POST['idLevel_1']))                   $idLevel_1                    = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))                   $idLevel_2                    = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))                   $idLevel_3                    = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))                   $idLevel_4                    = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))                   $idLevel_5                    = $_POST['idLevel_5'];
	if (!empty($_POST['idTipoTrabajo']))               $idTipoTrabajo                = $_POST['idTipoTrabajo'];
	if (!empty($_POST['PorcentajeTrabajoPesado']))     $PorcentajeTrabajoPesado      = $_POST['PorcentajeTrabajoPesado'];
	if (!empty($_POST['idMutual']))                    $idMutual                     = $_POST['idMutual'];
	if (!empty($_POST['idCotizacionSaludExtra']))      $idCotizacionSaludExtra       = $_POST['idCotizacionSaludExtra'];
	if (!empty($_POST['PorcCotSaludExtra']))           $PorcCotSaludExtra            = $_POST['PorcCotSaludExtra'];
	if (!empty($_POST['MontoCotSaludExtra']))          $MontoCotSaludExtra           = $_POST['MontoCotSaludExtra'];
	if (!empty($_POST['idBanco']))                     $idBanco                      = $_POST['idBanco'];
	if (!empty($_POST['idTipoCuenta']))                $idTipoCuenta                 = $_POST['idTipoCuenta'];
	if (!empty($_POST['N_Cuenta']))                    $N_Cuenta                     = $_POST['N_Cuenta'];
	if (!empty($_POST['UbicacionTrabajo']))            $UbicacionTrabajo             = $_POST['UbicacionTrabajo'];

	if (!empty($_POST['idOpciones']))                  $idOpciones                   = $_POST['idOpciones'];

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
			case 'idTrabajador':                if(empty($idTrabajador)){                 $error['idTrabajador']                 = 'error/No ha ingresado el id';}break;
			case 'idSistema':                   if(empty($idSistema)){                    $error['idSistema']                    = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                    if(empty($idEstado)){                     $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                      if(empty($Nombre)){                       $error['Nombre']                       = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPat':                 if(empty($ApellidoPat)){                  $error['ApellidoPat']                  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMat':                 if(empty($ApellidoMat)){                  $error['ApellidoMat']                  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'idTipo':                      if(empty($idTipo)){                       $error['idTipo']                       = 'error/No ha seleccionado el tipo de trabajador';}break;
			case 'Cargo':                       if(empty($Cargo)){                        $error['Cargo']                        = 'error/No ha ingresado el cargo a desempeñar';}break;
			case 'Fono':                        if(empty($Fono)){                         $error['Fono']                         = 'error/No ha ingresado el fono';}break;
			case 'Rut':                         if(empty($Rut)){                          $error['Rut']                          = 'error/No ha ingresado el rut';}break;
			case 'N_Documento':                 if(empty($N_Documento)){                  $error['N_Documento']                  = 'error/No ha ingresado el numero de documento';}break;
			case 'idCiudad':                    if(empty($idCiudad)){                     $error['idCiudad']                     = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                    if(empty($idComuna)){                     $error['idComuna']                     = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                   if(empty($Direccion)){                    $error['Direccion']                    = 'error/No ha ingresado la dirección';}break;
			case 'Observaciones':               if(empty($Observaciones)){                $error['Observaciones']                = 'error/No ha ingresado la observacion';}break;
			case 'idLicitacion':                if(empty($idLicitacion)){                 $error['idLicitacion']                 = 'error/No ha seleccionado el proyecto';}break;
			case 'FechaContrato':               if(empty($FechaContrato)){                $error['FechaContrato']                = 'error/No ha ingresado la fecha de Contrato';}break;
			case 'F_Inicio_Contrato':           if(empty($F_Inicio_Contrato)){            $error['F_Inicio_Contrato']            = 'error/No ha ingresado la fecha de inicio Contrato';}break;
			case 'F_Termino_Contrato':          if(empty($F_Termino_Contrato)){           $error['F_Termino_Contrato']           = 'error/No ha ingresado la fecha de termino Contrato';}break;
			case 'idAFP':                       if(empty($idAFP)){                        $error['idAFP']                        = 'error/No ha seleccionado la AFP';}break;
			case 'idSalud':                     if(empty($idSalud)){                      $error['idSalud']                      = 'error/No ha seleccionado el Siste de salud';}break;
			case 'idTipoContrato':              if(empty($idTipoContrato)){               $error['idTipoContrato']               = 'error/No ha Seleccionado el tipo de contrato';}break;
			case 'idTipoLicencia':              if(empty($idTipoLicencia)){               $error['idTipoLicencia']               = 'error/No ha Seleccionado el tipo de licencia';}break;
			case 'CA_Licencia':                 if(empty($CA_Licencia)){                  $error['CA_Licencia']                  = 'error/No ha ingresado el Numero CA de la licencia';}break;
			case 'LicenciaFechaControl':        if(empty($LicenciaFechaControl)){         $error['LicenciaFechaControl']         = 'error/No ha ingresado la fecha de control';}break;
			case 'LicenciaFechaControlUltimo':  if(empty($LicenciaFechaControlUltimo)){   $error['LicenciaFechaControlUltimo']   = 'error/No ha ingresado la ultima fecha de control';}break;
			case 'ContactoPersona':             if(empty($ContactoPersona)){              $error['ContactoPersona']              = 'error/No ha ingresado la persona de contacto';}break;
			case 'ContactoFono':                if(empty($ContactoFono)){                 $error['ContactoFono']                 = 'error/No ha ingresado el fono de la persona de contacto';}break;
			case 'idSexo':                      if(empty($idSexo)){                       $error['idSexo']                       = 'error/No ha seleccionado el sexo';}break;
			case 'FNacimiento':                 if(empty($FNacimiento)){                  $error['FNacimiento']                  = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'idEstadoCivil':               if(empty($idEstadoCivil)){                $error['idEstadoCivil']                = 'error/No ha seleccionado estado civil';}break;
			case 'SueldoLiquido':               if(empty($SueldoLiquido)){                $error['SueldoLiquido']                = 'error/No ha ingresado el sueldo liquido a pago';}break;
			case 'SueldoDia':                   if(empty($SueldoDia)){                    $error['SueldoDia']                    = 'error/No ha ingresado el sueldo liquido a pago por dia';}break;
			case 'SueldoHora':                  if(empty($SueldoHora)){                   $error['SueldoHora']                   = 'error/No ha ingresado el sueldo liquido a pago por hora';}break;
			case 'email':                       if(empty($email)){                        $error['email']                        = 'error/No ha ingresado el email del trabajador';}break;
			case 'idTransporte':                if(empty($idTransporte)){                 $error['idTransporte']                 = 'error/No ha seleccionado el transporte';}break;
			case 'idTipoContratoTrab':          if(empty($idTipoContratoTrab)){           $error['idTipoContratoTrab']           = 'error/No ha seleccionado el tipo de contrato';}break;
			case 'horas_pactadas':              if(empty($horas_pactadas)){               $error['horas_pactadas']               = 'error/No ha ingresado las horas de trabajo pactadas';}break;
			case 'Gratificacion':               if(empty($Gratificacion)){                $error['Gratificacion']                = 'error/No ha ingresado el monto de gratificacion';}break;
			case 'idTipoTrabajador':            if(empty($idTipoTrabajador)){             $error['idTipoTrabajador']             = 'error/No ha seleccionado el tipo de trabajador';}break;
			case 'idContratista':               if(empty($idContratista)){                $error['idContratista']                = 'error/No ha seleccionado el Contratista';}break;
			case 'File_RHTM_Fecha':             if(empty($File_RHTM_Fecha)){              $error['File_RHTM_Fecha']              = 'error/No ha ingresado una fecha de termino de RHTM';}break;
			case 'idCentroCosto':               if(empty($idCentroCosto)){                $error['idCentroCosto']                = 'error/No ha seleccionado un centro de costo';}break;
			case 'idLevel_1':                   if(empty($idLevel_1)){                    $error['idLevel_1']                    = 'error/No ha seleccionado un centro de costo nivel 1';}break;
			case 'idLevel_2':                   if(empty($idLevel_2)){                    $error['idLevel_2']                    = 'error/No ha seleccionado un centro de costo nivel 2';}break;
			case 'idLevel_3':                   if(empty($idLevel_3)){                    $error['idLevel_3']                    = 'error/No ha seleccionado un centro de costo nivel 3';}break;
			case 'idLevel_4':                   if(empty($idLevel_4)){                    $error['idLevel_4']                    = 'error/No ha seleccionado un centro de costo nivel 4';}break;
			case 'idLevel_5':                   if(empty($idLevel_5)){                    $error['idLevel_5']                    = 'error/No ha seleccionado un centro de costo nivel 5';}break;
			case 'idTipoTrabajo':               if(empty($idTipoTrabajo)){                $error['idTipoTrabajo']                = 'error/No ha seleccionado el tipo de trabajo';}break;
			case 'PorcentajeTrabajoPesado':     if(empty($PorcentajeTrabajoPesado)){      $error['PorcentajeTrabajoPesado']      = 'error/No ha ingresado el porcentaje de trabajo pesado';}break;
			case 'idMutual':                    if(empty($idMutual)){                     $error['idMutual']                     = 'error/No ha seleccionado la mutual de seguridad';}break;
			case 'idCotizacionSaludExtra':      if(empty($idCotizacionSaludExtra)){       $error['idCotizacionSaludExtra']       = 'error/No ha seleccionado la opción de cotizacion extra';}break;
			case 'PorcCotSaludExtra':           if(empty($PorcCotSaludExtra)){            $error['PorcCotSaludExtra']            = 'error/No ha ingresado el porcentaje de cotizacion extra';}break;
			case 'MontoCotSaludExtra':          if(empty($MontoCotSaludExtra)){           $error['MontoCotSaludExtra']           = 'error/No ha ingresado el porcentaje de cotizacion extra';}break;
			case 'idBanco':                     if(empty($idBanco)){                      $error['idBanco']                      = 'error/No ha seleccionado el banco';}break;
			case 'idTipoCuenta':                if(empty($idTipoCuenta)){                 $error['idTipoCuenta']                 = 'error/No ha seleccionado el tipo de cuenta';}break;
			case 'N_Cuenta':                    if(empty($N_Cuenta)){                     $error['N_Cuenta']                     = 'error/No ha ingresado el numero de cuenta';}break;
			case 'UbicacionTrabajo':            if(empty($UbicacionTrabajo)){             $error['UbicacionTrabajo']             = 'error/No ha ingresado la ubicacion del trabajo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                   $Nombre          = EstandarizarInput($Nombre);}
	if(isset($ApellidoPat) && $ApellidoPat!=''){         $ApellidoPat     = EstandarizarInput($ApellidoPat);}
	if(isset($ApellidoMat) && $ApellidoMat!=''){         $ApellidoMat     = EstandarizarInput($ApellidoMat);}
	if(isset($Cargo) && $Cargo!=''){                     $Cargo           = EstandarizarInput($Cargo);}
	if(isset($Direccion) && $Direccion!=''){             $Direccion       = EstandarizarInput($Direccion);}
	if(isset($Observaciones) && $Observaciones!=''){     $Observaciones   = EstandarizarInput($Observaciones);}
	if(isset($ContactoPersona) && $ContactoPersona!=''){ $ContactoPersona = EstandarizarInput($ContactoPersona);}
	if(isset($ContactoFono) && $ContactoFono!=''){       $ContactoFono    = EstandarizarInput($ContactoFono);}
	//if(isset($email) && $email!=''){                     $email           = EstandarizarInput($email);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                    $error['Nombre']          = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($ApellidoPat)&&contar_palabras_censuradas($ApellidoPat)!=0){          $error['ApellidoPat']     = 'error/Edita Apellido Pat, contiene palabras no permitidas';}
	if(isset($ApellidoMat)&&contar_palabras_censuradas($ApellidoMat)!=0){          $error['ApellidoMat']     = 'error/Edita Apellido Mat, contiene palabras no permitidas';}
	if(isset($Cargo)&&contar_palabras_censuradas($Cargo)!=0){                      $error['Cargo']           = 'error/Edita Cargo, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){              $error['Direccion']       = 'error/Edita la Direccion, contiene palabras no permitidas';}
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){      $error['Observaciones']   = 'error/Edita la Observacion, contiene palabras no permitidas';}
	if(isset($ContactoPersona)&&contar_palabras_censuradas($ContactoPersona)!=0){  $error['ContactoPersona'] = 'error/Edita Contacto Persona, contiene palabras no permitidas';}
	if(isset($ContactoFono)&&contar_palabras_censuradas($ContactoFono)!=0){        $error['ContactoFono']    = 'error/Edita Contacto Fono, contiene palabras no permitidas';}
	if(isset($email)&&contar_palabras_censuradas($email)!=0){                      $error['email']           = 'error/Edita email, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($Fono)&&!validarNumero($Fono)){       $error['Fono']    = 'error/Ingrese un número telefónico válido';}
	if(isset($Fono)&&palabra_corto($Fono, 9)!=1){  $error['Fono']    = 'error/'.palabra_corto($Fono, 9);}
	if(isset($Rut)&&!validarRut($Rut)){            $error['Rut']     = 'error/El Rut ingresado no es valido';}
	if(isset($email)&&!validarEmail($email)){      $error['email']   = 'error/El Email ingresado no es valido';}

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
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut, $idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'trabajadores_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                                      $SIS_data  = "'".$idSistema."'";                     }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                                        $SIS_data .= ",'".$idEstado."'";                     }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                            $SIS_data .= ",'".$Nombre."'";                       }else{$SIS_data .= ",''";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){                                  $SIS_data .= ",'".$ApellidoPat."'";                  }else{$SIS_data .= ",''";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){                                  $SIS_data .= ",'".$ApellidoMat."'";                  }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                                            $SIS_data .= ",'".$idTipo."'";                       }else{$SIS_data .= ",''";}
				if(isset($Cargo) && $Cargo!=''){                                              $SIS_data .= ",'".$Cargo."'";                        }else{$SIS_data .= ",''";}
				if(isset($Fono) && $Fono!=''){                                                $SIS_data .= ",'".$Fono."'";                         }else{$SIS_data .= ",''";}
				if(isset($Rut) && $Rut!=''){                                                  $SIS_data .= ",'".$Rut."'";                          }else{$SIS_data .= ",''";}
				if(isset($N_Documento) && $N_Documento!=''){                                  $SIS_data .= ",'".$N_Documento."'";                  }else{$SIS_data .= ",''";}
				if(isset($idCiudad) && $idCiudad!=''){                                        $SIS_data .= ",'".$idCiudad."'";                     }else{$SIS_data .= ",''";}
				if(isset($idComuna) && $idComuna!=''){                                        $SIS_data .= ",'".$idComuna."'";                     }else{$SIS_data .= ",''";}
				if(isset($Direccion) && $Direccion!=''){                                      $SIS_data .= ",'".$Direccion."'";                    }else{$SIS_data .= ",''";}
				if(isset($Observaciones) && $Observaciones!=''){                              $SIS_data .= ",'".$Observaciones."'";                }else{$SIS_data .= ",''";}
				if(isset($idLicitacion) && $idLicitacion!=''){                                $SIS_data .= ",'".$idLicitacion."'";                 }else{$SIS_data .= ",''";}
				if(isset($FechaContrato) && $FechaContrato!=''){                              $SIS_data .= ",'".$FechaContrato."'";                }else{$SIS_data .= ",''";}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato!=''){                      $SIS_data .= ",'".$F_Inicio_Contrato."'";            }else{$SIS_data .= ",''";}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato!=''){                    $SIS_data .= ",'".$F_Termino_Contrato."'";           }else{$SIS_data .= ",''";}
				if(isset($idAFP) && $idAFP!=''){                                              $SIS_data .= ",'".$idAFP."'";                        }else{$SIS_data .= ",''";}
				if(isset($idSalud) && $idSalud!=''){                                          $SIS_data .= ",'".$idSalud."'";                      }else{$SIS_data .= ",''";}
				if(isset($idTipoContrato) && $idTipoContrato!=''){                            $SIS_data .= ",'".$idTipoContrato."'";               }else{$SIS_data .= ",''";}
				if(isset($idTipoLicencia) && $idTipoLicencia!=''){                            $SIS_data .= ",'".$idTipoLicencia."'";               }else{$SIS_data .= ",''";}
				if(isset($CA_Licencia) && $CA_Licencia!=''){                                  $SIS_data .= ",'".$CA_Licencia."'";                  }else{$SIS_data .= ",''";}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl!=''){                $SIS_data .= ",'".$LicenciaFechaControl."'";         }else{$SIS_data .= ",''";}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo!=''){    $SIS_data .= ",'".$LicenciaFechaControlUltimo."'";   }else{$SIS_data .= ",''";}
				if(isset($ContactoPersona) && $ContactoPersona!=''){                          $SIS_data .= ",'".$ContactoPersona."'";              }else{$SIS_data .= ",''";}
				if(isset($ContactoFono) && $ContactoFono!=''){                                $SIS_data .= ",'".$ContactoFono."'";                 }else{$SIS_data .= ",''";}
				if(isset($idSexo) && $idSexo!=''){                                            $SIS_data .= ",'".$idSexo."'";                       }else{$SIS_data .= ",''";}
				if(isset($FNacimiento) && $FNacimiento!=''){                                  $SIS_data .= ",'".$FNacimiento."'";                  }else{$SIS_data .= ",''";}
				if(isset($idEstadoCivil) && $idEstadoCivil!=''){                              $SIS_data .= ",'".$idEstadoCivil."'";                }else{$SIS_data .= ",''";}
				if(isset($SueldoLiquido) && $SueldoLiquido!=''){                              $SIS_data .= ",'".$SueldoLiquido."'";                }else{$SIS_data .= ",''";}
				if(isset($SueldoDia) && $SueldoDia!=''){                                      $SIS_data .= ",'".$SueldoDia."'";                    }else{$SIS_data .= ",''";}
				if(isset($SueldoHora) && $SueldoHora!=''){                                    $SIS_data .= ",'".$SueldoHora."'";                   }else{$SIS_data .= ",''";}
				if(isset($email) && $email!=''){                                              $SIS_data .= ",'".$email."'";                        }else{$SIS_data .= ",''";}
				if(isset($idTransporte) && $idTransporte!=''){                                $SIS_data .= ",'".$idTransporte."'";                 }else{$SIS_data .= ",''";}
				if(isset($idTipoContratoTrab) && $idTipoContratoTrab!=''){                    $SIS_data .= ",'".$idTipoContratoTrab."'";           }else{$SIS_data .= ",''";}
				if(isset($horas_pactadas) && $horas_pactadas!=''){                            $SIS_data .= ",'".$horas_pactadas."'";               }else{$SIS_data .= ",''";}
				if(isset($Gratificacion) && $Gratificacion!=''){                              $SIS_data .= ",'".$Gratificacion."'";                }else{$SIS_data .= ",''";}
				if(isset($idTipoTrabajador) && $idTipoTrabajador!=''){                        $SIS_data .= ",'".$idTipoTrabajador."'";             }else{$SIS_data .= ",''";}
				if(isset($idContratista) && $idContratista!=''){                              $SIS_data .= ",'".$idContratista."'";                }else{$SIS_data .= ",''";}
				if(isset($idCentroCosto) && $idCentroCosto!=''){                              $SIS_data .= ",'".$idCentroCosto."'";                }else{$SIS_data .= ",''";}
				if(isset($idLevel_1) && $idLevel_1!=''){                                      $SIS_data .= ",'".$idLevel_1."'";                    }else{$SIS_data .= ",''";}
				if(isset($idLevel_2) && $idLevel_2!=''){                                      $SIS_data .= ",'".$idLevel_2."'";                    }else{$SIS_data .= ",''";}
				if(isset($idLevel_3) && $idLevel_3!=''){                                      $SIS_data .= ",'".$idLevel_3."'";                    }else{$SIS_data .= ",''";}
				if(isset($idLevel_4) && $idLevel_4!=''){                                      $SIS_data .= ",'".$idLevel_4."'";                    }else{$SIS_data .= ",''";}
				if(isset($idLevel_5) && $idLevel_5!=''){                                      $SIS_data .= ",'".$idLevel_5."'";                    }else{$SIS_data .= ",''";}
				if(isset($idTipoTrabajo) && $idTipoTrabajo!=''){                              $SIS_data .= ",'".$idTipoTrabajo."'";                }else{$SIS_data .= ",''";}
				if(isset($PorcentajeTrabajoPesado) && $PorcentajeTrabajoPesado!=''){          $SIS_data .= ",'".$PorcentajeTrabajoPesado."'";      }else{$SIS_data .= ",''";}
				if(isset($idMutual) && $idMutual!=''){                                        $SIS_data .= ",'".$idMutual."'";                     }else{$SIS_data .= ",''";}
				if(isset($idCotizacionSaludExtra) && $idCotizacionSaludExtra!=''){            $SIS_data .= ",'".$idCotizacionSaludExtra."'";       }else{$SIS_data .= ",''";}
				if(isset($PorcCotSaludExtra) && $PorcCotSaludExtra!=''){                      $SIS_data .= ",'".$PorcCotSaludExtra."'";            }else{$SIS_data .= ",''";}
				if(isset($MontoCotSaludExtra) && $MontoCotSaludExtra!=''){                    $SIS_data .= ",'".$MontoCotSaludExtra."'";           }else{$SIS_data .= ",''";}
				if(isset($idBanco) && $idBanco!=''){                                          $SIS_data .= ",'".$idBanco."'";                      }else{$SIS_data .= ",''";}
				if(isset($idTipoCuenta) && $idTipoCuenta!=''){                                $SIS_data .= ",'".$idTipoCuenta."'";                 }else{$SIS_data .= ",''";}
				if(isset($N_Cuenta) && $N_Cuenta!=''){                                        $SIS_data .= ",'".$N_Cuenta."'";                     }else{$SIS_data .= ",''";}
				if(isset($UbicacionTrabajo) && $UbicacionTrabajo!=''){                        $SIS_data .= ",'".$UbicacionTrabajo."'";             }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Nombre,ApellidoPat,
				ApellidoMat, idTipo, Cargo, Fono, Rut, N_Documento, idCiudad, idComuna, Direccion, Observaciones,
				idLicitacion, FechaContrato, F_Inicio_Contrato, F_Termino_Contrato, idAFP, idSalud, idTipoContrato,
				idTipoLicencia,CA_Licencia,LicenciaFechaControl,LicenciaFechaControlUltimo,ContactoPersona,
				ContactoFono, idSexo, FNacimiento, idEstadoCivil, SueldoLiquido, SueldoDia, SueldoHora,email,
				idTransporte, idTipoContratoTrab, horas_pactadas, Gratificacion, idTipoTrabajador,
				idContratista, idCentroCosto, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5,
				idTipoTrabajo, PorcentajeTrabajoPesado, idMutual, idCotizacionSaludExtra, PorcCotSaludExtra,
				MontoCotSaludExtra, idBanco, idTipoCuenta, N_Cuenta, UbicacionTrabajo';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idTrabajador)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idTrabajador!='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idTrabajador)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'trabajadores_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idTrabajador!='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idTrabajador='".$idTrabajador."'";
				if(isset($idSistema) && $idSistema!=''){                                      $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                                        $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($Nombre) && $Nombre!=''){                                            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($ApellidoPat) && $ApellidoPat!=''){                                  $SIS_data .= ",ApellidoPat='".$ApellidoPat."'";}
				if(isset($ApellidoMat) && $ApellidoMat!=''){                                  $SIS_data .= ",ApellidoMat='".$ApellidoMat."'";}
				if(isset($idTipo) && $idTipo!=''){                                            $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($Cargo) && $Cargo!=''){                                              $SIS_data .= ",Cargo='".$Cargo."'";}
				if(isset($Fono) && $Fono!=''){                                                $SIS_data .= ",Fono='".$Fono."'";}
				if(isset($Rut) && $Rut!=''){                                                  $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($N_Documento) && $N_Documento!=''){                                  $SIS_data .= ",N_Documento='".$N_Documento."'";}
				if(isset($idCiudad) && $idCiudad!=''){                                        $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!=''){                                        $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Direccion) && $Direccion!=''){                                      $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Observaciones) && $Observaciones!=''){                              $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($idLicitacion) && $idLicitacion!=''){                                $SIS_data .= ",idLicitacion='".$idLicitacion."'";}
				if(isset($FechaContrato) && $FechaContrato!=''){                              $SIS_data .= ",FechaContrato='".$FechaContrato."'";}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato!=''){                      $SIS_data .= ",F_Inicio_Contrato='".$F_Inicio_Contrato."'";}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato!=''){                    $SIS_data .= ",F_Termino_Contrato='".$F_Termino_Contrato."'";}
				if(isset($idAFP) && $idAFP!=''){                                              $SIS_data .= ",idAFP='".$idAFP."'";}
				if(isset($idSalud) && $idSalud!=''){                                          $SIS_data .= ",idSalud='".$idSalud."'";}
				if(isset($idTipoContrato) && $idTipoContrato!=''){                            $SIS_data .= ",idTipoContrato='".$idTipoContrato."'";}
				if(isset($idTipoLicencia) && $idTipoLicencia!=''){                            $SIS_data .= ",idTipoLicencia='".$idTipoLicencia."'";}
				if(isset($CA_Licencia) && $CA_Licencia!=''){                                  $SIS_data .= ",CA_Licencia='".$CA_Licencia."'";}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl!=''){                $SIS_data .= ",LicenciaFechaControl='".$LicenciaFechaControl."'";}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo!=''){    $SIS_data .= ",LicenciaFechaControlUltimo='".$LicenciaFechaControlUltimo."'";}
				if(isset($ContactoPersona) && $ContactoPersona!=''){                          $SIS_data .= ",ContactoPersona='".$ContactoPersona."'";}
				if(isset($ContactoFono) && $ContactoFono!=''){                                $SIS_data .= ",ContactoFono='".$ContactoFono."'";}
				if(isset($idSexo) && $idSexo!=''){                                            $SIS_data .= ",idSexo='".$idSexo."'";}
				if(isset($FNacimiento) && $FNacimiento!=''){                                  $SIS_data .= ",FNacimiento='".$FNacimiento."'";}
				if(isset($idEstadoCivil) && $idEstadoCivil!=''){                              $SIS_data .= ",idEstadoCivil='".$idEstadoCivil."'";}
				if(isset($SueldoLiquido) && $SueldoLiquido!=''){                              $SIS_data .= ",SueldoLiquido='".$SueldoLiquido."'";}
				if(isset($SueldoDia) && $SueldoDia!=''){                                      $SIS_data .= ",SueldoDia='".$SueldoDia."'";}
				if(isset($SueldoHora) && $SueldoHora!=''){                                    $SIS_data .= ",SueldoHora='".$SueldoHora."'";}
				if(isset($email) && $email!=''){                                              $SIS_data .= ",email='".$email."'";}
				if(isset($idTransporte) && $idTransporte!=''){                                $SIS_data .= ",idTransporte='".$idTransporte."'";}
				if(isset($idTipoContratoTrab) && $idTipoContratoTrab!=''){                    $SIS_data .= ",idTipoContratoTrab='".$idTipoContratoTrab."'";}
				if(isset($horas_pactadas) && $horas_pactadas!=''){                            $SIS_data .= ",horas_pactadas='".$horas_pactadas."'";}
				if(isset($Gratificacion) && $Gratificacion!=''){                              $SIS_data .= ",Gratificacion='".$Gratificacion."'";}
				if(isset($idTipoTrabajador) && $idTipoTrabajador!=''){                        $SIS_data .= ",idTipoTrabajador='".$idTipoTrabajador."'";}
				if(isset($idContratista) && $idContratista!=''){                              $SIS_data .= ",idContratista='".$idContratista."'";}
				if(isset($idCentroCosto) && $idCentroCosto!=''){                              $SIS_data .= ",idCentroCosto='".$idCentroCosto."'";}
				if(isset($idLevel_1) && $idLevel_1!=''){                                      $SIS_data .= ",idLevel_1='".$idLevel_1."'";}
				if(isset($idLevel_2) && $idLevel_2!=''){                                      $SIS_data .= ",idLevel_2='".$idLevel_2."'";}
				if(isset($idLevel_3) && $idLevel_3!=''){                                      $SIS_data .= ",idLevel_3='".$idLevel_3."'";}
				if(isset($idLevel_4) && $idLevel_4!=''){                                      $SIS_data .= ",idLevel_4='".$idLevel_4."'";}
				if(isset($idLevel_5) && $idLevel_5!=''){                                      $SIS_data .= ",idLevel_5='".$idLevel_5."'";}
				if(isset($idTipoTrabajo) && $idTipoTrabajo!=''){                              $SIS_data .= ",idTipoTrabajo='".$idTipoTrabajo."'";}
				if(isset($PorcentajeTrabajoPesado) && $PorcentajeTrabajoPesado!=''){          $SIS_data .= ",PorcentajeTrabajoPesado='".$PorcentajeTrabajoPesado."'";}
				if(isset($idMutual) && $idMutual!=''){                                        $SIS_data .= ",idMutual='".$idMutual."'";}
				if(isset($idCotizacionSaludExtra) && $idCotizacionSaludExtra!=''){            $SIS_data .= ",idCotizacionSaludExtra='".$idCotizacionSaludExtra."'";}
				if(isset($PorcCotSaludExtra) && $PorcCotSaludExtra!=''){                      $SIS_data .= ",PorcCotSaludExtra='".$PorcCotSaludExtra."'";}
				if(isset($MontoCotSaludExtra) && $MontoCotSaludExtra!=''){                    $SIS_data .= ",MontoCotSaludExtra='".$MontoCotSaludExtra."'";}
				if(isset($idBanco) && $idBanco!=''){                                          $SIS_data .= ",idBanco='".$idBanco."'";}
				if(isset($idTipoCuenta) && $idTipoCuenta!=''){                                $SIS_data .= ",idTipoCuenta='".$idTipoCuenta."'";}
				if(isset($N_Cuenta) && $N_Cuenta!=''){                                        $SIS_data .= ",N_Cuenta='".$N_Cuenta."'";}
				if(isset($UbicacionTrabajo) && $UbicacionTrabajo!=''){                        $SIS_data .= ",UbicacionTrabajo='".$UbicacionTrabajo."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Direccion_img, File_Curriculum, File_Antecedentes, File_Carnet, File_Contrato, File_Licencia, File_RHTM', 'trabajadores_listado', '', 'idTrabajador = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'trabajadores_listado', 'idTrabajador = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina la foto
					if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){
						try {
							if(!is_writable('upload/'.$rowData['Direccion_img'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['Direccion_img']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el curriculum
					if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Curriculum'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Curriculum']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina los antecedentes
					if(isset($rowData['File_Antecedentes'])&&$rowData['File_Antecedentes']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Antecedentes'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Antecedentes']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el carnet de identidad
					if(isset($rowData['File_Carnet'])&&$rowData['File_Carnet']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Carnet'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Carnet']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el contrato
					if(isset($rowData['File_Contrato'])&&$rowData['File_Contrato']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Contrato'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Contrato']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el contrato
					if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_Licencia'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_Licencia']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
					//se elimina el contrato
					if(isset($rowData['File_RHTM'])&&$rowData['File_RHTM']!=''){
						try {
							if(!is_writable('upload/'.$rowData['File_RHTM'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['File_RHTM']);
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
		//Cambio el estado de activo a inactivo
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idTrabajador  = $_GET['id'];
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["Direccion_img"]["error"] > 0){
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg","image/jpeg","image/gif","image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'trab_img_'.$idTrabajador.'_';

				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						//Muevo el archivo
						$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], "upload/xxxsxx_".$_FILES['Direccion_img']['name']);
						if ($move_result){
							//se selecciona la imagen
							switch ($_FILES['Direccion_img']['type']) {
								case 'image/jpg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/jpeg':
									$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/gif':
									$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
								case 'image/png':
									$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
									break;
							}

							//se reescala la imagen en caso de ser necesario
							$imgBase_width = imagesx( $imgBase );
							$imgBase_height = imagesy( $imgBase );

							//Se establece el tamaño maximo
							$max_width  = 640;
							$max_height = 640;

							if ($imgBase_width > $imgBase_height) {
								if($imgBase_width < $max_width){
									$newwidth = $imgBase_width;
								}else{
									$newwidth = $max_width;
								}
								$divisor = $imgBase_width / $newwidth;
								$newheight = floor( $imgBase_height / $divisor);
							}else {
								if($imgBase_height < $max_height){
									$newheight = $imgBase_height;
								}else{
									$newheight =  $max_height;
								}
								$divisor = $imgBase_height / $newheight;
								$newwidth = floor( $imgBase_width / $divisor );
							}

							$imgBase = imagescale($imgBase, $newwidth, $newheight);

							//se establece la calidad del archivo
							$quality = 75;

							//se crea la imagen
							imagejpeg($imgBase, $ruta, $quality);

							//se elimina la imagen base
							try {
								if(!is_writable('upload/xxxsxx_'.$_FILES['Direccion_img']['name'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
							//se eliminan las imagenes de la memoria
							imagedestroy($imgBase);

							//Filtro para idSistema
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Direccion_img', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['Direccion_img'])&&$rowData['Direccion_img']!=''){
					try {
						if(!is_writable('upload/'.$rowData['Direccion_img'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['Direccion_img']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_curriculum':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_Curriculum"]["error"] > 0){
				$error['File_Curriculum'] = 'error/'.uploadPHPError($_FILES["File_Curriculum"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
				$sufijo = 'trab_curriculum_'.$idTrabajador.'_';

				if (in_array($_FILES['File_Curriculum']['type'], $permitidos) && $_FILES['File_Curriculum']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_Curriculum']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_Curriculum"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_Curriculum='".$sufijo.$_FILES['File_Curriculum']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['File_Curriculum']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_Curriculum']     = 'error/El archivo '.$_FILES['File_Curriculum']['name'].' ya existe';
					}
				} else {
					$error['File_Curriculum']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_Curriculum':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Curriculum', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Curriculum=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Curriculum'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Curriculum']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_antecedentes':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_Antecedentes"]["error"] > 0){
				$error['File_Antecedentes'] = 'error/'.uploadPHPError($_FILES["File_Antecedentes"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
				$sufijo = 'trab_antecedentes_'.$idTrabajador.'_';

				if (in_array($_FILES['File_Antecedentes']['type'], $permitidos) && $_FILES['File_Antecedentes']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_Antecedentes']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_Antecedentes"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_Antecedentes='".$sufijo.$_FILES['File_Antecedentes']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['File_Antecedentes']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_Antecedentes']     = 'error/El archivo '.$_FILES['File_Antecedentes']['name'].' ya existe';
					}
				} else {
					$error['File_Antecedentes']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_Antecedentes':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Antecedentes', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Antecedentes'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Antecedentes=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Antecedentes'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Antecedentes'])&&$rowData['File_Antecedentes']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Antecedentes'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Antecedentes']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_carnet':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_Carnet"]["error"] > 0){
				$error['File_Carnet'] = 'error/'.uploadPHPError($_FILES["File_Carnet"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
				$sufijo = 'trab_carnet_'.$idTrabajador.'_';

				if (in_array($_FILES['File_Carnet']['type'], $permitidos) && $_FILES['File_Carnet']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_Carnet']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_Carnet"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_Carnet='".$sufijo.$_FILES['File_Carnet']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['File_Carnet']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_Carnet']     = 'error/El archivo '.$_FILES['File_Carnet']['name'].' ya existe';
					}
				} else {
					$error['File_Carnet']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_Carnet':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Carnet', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Carnet'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Carnet=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Carnet'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Carnet'])&&$rowData['File_Carnet']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Carnet'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Carnet']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_contrato':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_Contrato"]["error"] > 0){
				$error['File_Contrato'] = 'error/'.uploadPHPError($_FILES["File_Contrato"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
				$sufijo = 'trab_contrato_'.$idTrabajador.'_';

				if (in_array($_FILES['File_Contrato']['type'], $permitidos) && $_FILES['File_Contrato']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_Contrato']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
					//Se mueve el archivo a la carpeta previamente configurada
					$move_result = @move_uploaded_file($_FILES["File_Contrato"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_Contrato='".$sufijo.$_FILES['File_Contrato']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['File_Contrato']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_Contrato']     = 'error/El archivo '.$_FILES['File_Contrato']['name'].' ya existe';
					}
				} else {
					$error['File_Contrato']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_Contrato':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Contrato', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Contrato'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Contrato=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Contrato'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Contrato'])&&$rowData['File_Contrato']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Contrato'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Contrato']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_File_Licencia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idTrabajador='".$idTrabajador."'";
				if(isset($idTipoLicencia) && $idTipoLicencia!=''){                            $SIS_data .= ",idTipoLicencia='".$idTipoLicencia."'";}
				if(isset($CA_Licencia) && $CA_Licencia!=''){                                  $SIS_data .= ",CA_Licencia='".$CA_Licencia."'";}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl!=''){                $SIS_data .= ",LicenciaFechaControl='".$LicenciaFechaControl."'";}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo!=''){    $SIS_data .= ",LicenciaFechaControlUltimo='".$LicenciaFechaControlUltimo."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				if ($_FILES["File_Licencia"]["error"] > 0){
					$error['File_Licencia'] = 'error/'.uploadPHPError($_FILES["File_Licencia"]["error"]);
				} else {
					//Se verifican las extensiones de los archivos
					$permitidos = array("application/msword",
										"application/vnd.ms-word",
										"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
					$sufijo = 'trab_licencia_'.$idTrabajador.'_';

					if (in_array($_FILES['File_Licencia']['type'], $permitidos) && $_FILES['File_Licencia']['size'] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['File_Licencia']['name'];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["File_Licencia"]["tmp_name"], $ruta);
							if ($move_result){

								//Filtro para idSistema
								$SIS_data = "File_Licencia='".$sufijo.$_FILES['File_Licencia']['name']."'";

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//Si ejecuto correctamente la consulta
								if($resultado==true){

									header( 'Location: '.$location );
									die;

								}

							} else {
								$error['File_Licencia']     = 'error/Ocurrio un error al mover el archivo';
							}
						} else {
							$error['File_Licencia']     = 'error/El archivo '.$_FILES['File_Licencia']['name'].' ya existe';
						}
					} else {
						$error['File_Licencia']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_Licencia':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_Licencia', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Licencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_Licencia=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Licencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_Licencia'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_Licencia']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_rhtm':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["File_RHTM"]["error"] > 0){
				$error['File_RHTM'] = 'error/'.uploadPHPError($_FILES["File_RHTM"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

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
				$sufijo = 'trab_rhtm_'.$idTrabajador.'_';

				if (in_array($_FILES['File_RHTM']['type'], $permitidos) && $_FILES['File_RHTM']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['File_RHTM']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_RHTM"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "File_RHTM='".$sufijo.$_FILES['File_RHTM']['name']."'";
							if(isset($File_RHTM_Fecha) && $File_RHTM_Fecha!=''){   $SIS_data .= ",File_RHTM_Fecha='".$File_RHTM_Fecha."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['File_RHTM']     = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['File_RHTM']     = 'error/El archivo '.$_FILES['File_RHTM']['name'].' ya existe';
					}
				} else {
					$error['File_RHTM']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}


		break;
/*******************************************************************************************************************/
		case 'del_File_RHTM':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'File_RHTM', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_RHTM'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "File_RHTM='', File_RHTM_Fecha=''";
			$resultado = db_update_data (false, $SIS_data, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_RHTM'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['File_RHTM'])&&$rowData['File_RHTM']!=''){
					try {
						if(!is_writable('upload/'.$rowData['File_RHTM'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['File_RHTM']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location.'&id_img=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'insert_plant':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se verifica si la imagen existe
				if (!empty($_FILES['FileTrabajador']['name'])){

					if ($_FILES['FileTrabajador']["error"] > 0){
						$error['FileTrabajador'] = 'error/'.uploadPHPError($_FILES["FileTrabajador"]["error"]);

					} else {

						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
										);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;

						if (in_array($_FILES['FileTrabajador']['type'], $permitidos) && $_FILES['FileTrabajador']['size'] <= $limite_kb * 1024){

							/*******************************************************************/
							//variables
							$ndata_1  = 0;
							$ndata_2  = 0;
							$ndata_3  = 0;
							$ndata_4  = 0;
							$ndata_5  = 0;
							//Cargo el archivo
							$spreadsheet = IOFactory::load($_FILES['FileTrabajador']['tmp_name']);
							//Obtengo los nombres de las hojas
							$loadedSheetNames = $spreadsheet->getSheetNames();
							//recorro las hojas
							foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
								//seteo la hoja
								$spreadsheet->setActiveSheetIndex($sheetIndex);
								//selecciono la hoja
								$worksheet = $spreadsheet->getActiveSheet();
								//obtengo el total de datos
								$highestRow = $worksheet->getHighestRow();
								//si es una hoja en especifico
								if ($loadedSheetName == "Trabajadores"){
									//recorro
									for ($row=2; $row<=$highestRow; $row++){

										$Post_Nombre   = $worksheet->getCellByColumnAndRow(1,  $row)->getValue();
										$Post_Rut      = $worksheet->getCellByColumnAndRow(4,   $row)->getValue();
										$Post_Email    = $worksheet->getCellByColumnAndRow(10,  $row)->getValue();
										$Post_Fono     = $worksheet->getCellByColumnAndRow(6,   $row)->getValue();
										$Post_Sueldo   = $worksheet->getCellByColumnAndRow(16,  $row)->getValue();

										//si la celda no esta vacia
										if($Post_Nombre!=''){
											//si existe el rut
											if(!isset($Post_Rut) OR $Post_Rut==''){
												$ndata_1++;
											}
											//verifico si el rut ingresado en el excel existe
											if(isset($Post_Rut)&&$Post_Rut!=''){
												$SIS_query = 'Rut';
												$SIS_join  = '';
												$SIS_where = 'idSistema='.$idSistema.' AND Rut="'.$Post_Rut.'"';
												$nRows = db_select_nrows (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'nRows');

												//Si existe se marca error
												if(isset($nRows)&&$nRows!=0){
													$ndata_2++;
												}
											}
											//Verifico la existencia de un email
											if(isset($Post_Email)&&$Post_Email!=''&&!validarEmail($Post_Email)){
												$ndata_3++;
											}
											//Verifico la existencia de un email
											if(isset($Post_Fono)&&$Post_Fono!=''&&!validarNumero($Post_Fono)){
												$ndata_4++;
											}
											//Verifico la existencia de un email
											if(isset($Post_Sueldo)&&$Post_Sueldo!=''&&!validarNumero($Post_Sueldo)){
												$ndata_5++;
											}
										}
									}
								}
							}

							/*******************************************************************/
							//generacion de errores
							if($ndata_1 > 0) {  $error['ndata_1']  = 'error/Revisar los trabajadores, uno no tiene rut';}
							if($ndata_2 > 0) {  $error['ndata_2']  = 'error/Revisar los trabajadores, uno ya existe en el sistema';}
							if($ndata_3 > 0) {  $error['ndata_3']  = 'error/Revisar los trabajadores, uno de los Email ingresado no es valido';}
							if($ndata_4 > 0) {  $error['ndata_3']  = 'error/Revisar los trabajadores, uno de los Telefonos ingresado no es valido';}
							if($ndata_5 > 0) {  $error['ndata_3']  = 'error/Revisar los trabajadores, uno de los sueldos ingresado no es valido';}

							/*******************************************************************/
							//Si no hay errores ejecuto el codigo
							if(empty($error)){

								/*******************************************************************/
								//Cargo a todos los clientes del sistema
								$arrSexo           = array();
								$arrCiudad         = array();
								$arrComuna         = array();
								$arrEstadoCivil    = array();
								$arrTipoTrabajador = array();
								$arrTipoContrato   = array();
								$arrAFP            = array();
								$arrSalud          = array();

								$arrSexo           = db_select_array (false, 'idSexo,Nombre', 'core_sexo', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrCiudad         = db_select_array (false, 'idCiudad,Nombre', 'core_ubicacion_ciudad', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrComuna         = db_select_array (false, 'idComuna,Nombre', 'core_ubicacion_comunas', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrEstadoCivil    = db_select_array (false, 'idEstadoCivil,Nombre', 'core_estado_civil', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrTipoTrabajador = db_select_array (false, 'idTipoTrabajador,Nombre', 'core_tipos_trabajadores', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrTipoContrato   = db_select_array (false, 'idTipoContrato,Nombre', 'core_tipos_contrato', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrAFP            = db_select_array (false, 'idAFP,Nombre', 'sistema_afp', '', 'idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								$arrSalud          = db_select_array (false, 'idSalud,Nombre', 'sistema_salud', '', 'idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//recorro los datos
								$arrSexoMod           = array();
								$arrCiudadMod         = array();
								$arrComunaMod         = array();
								$arrEstadoCivilMod    = array();
								$arrTipoTrabajadorMod = array();
								$arrTipoContratoMod   = array();
								$arrAFPMod            = array();
								$arrSaludMod          = array();
								foreach ($arrSexo as $data) {           $arrSexoMod[$data['Nombre']]['ID']           = $data['idSexo'];}
								foreach ($arrCiudad as $data) {         $arrCiudadMod[$data['Nombre']]['ID']         = $data['idCiudad'];}
								foreach ($arrComuna as $data) {         $arrComunaMod[$data['Nombre']]['ID']         = $data['idComuna'];}
								foreach ($arrEstadoCivil as $data) {    $arrEstadoCivilMod[$data['Nombre']]['ID']    = $data['idEstadoCivil'];}
								foreach ($arrTipoTrabajador as $data) { $arrTipoTrabajadorMod[$data['Nombre']]['ID'] = $data['idTipoTrabajador'];}
								foreach ($arrTipoContrato as $data) {   $arrTipoContratoMod[$data['Nombre']]['ID']   = $data['idTipoContrato'];}
								foreach ($arrAFP as $data) {            $arrAFPMod[$data['Nombre']]['ID']            = $data['idAFP'];}
								foreach ($arrSalud as $data) {          $arrSaludMod[$data['Nombre']]['ID']          = $data['idSalud'];}

								/*******************************************************************/
								//Cargo el archivo
								$spreadsheet = IOFactory::load($_FILES['FileTrabajador']['tmp_name']);
								//Obtengo los nombres de las hojas
								$loadedSheetNames = $spreadsheet->getSheetNames();
								//recorro las hojas
								foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
									//seteo la hoja
									$spreadsheet->setActiveSheetIndex($sheetIndex);
									//selecciono la hoja
									$worksheet = $spreadsheet->getActiveSheet();
									//obtengo el total de datos
									$highestRow = $worksheet->getHighestRow();
									//si es una hoja en especifico
									if ($loadedSheetName == "Trabajadores"){
										//recorro
										for ($row=2; $row<=$highestRow; $row++){

											$Post_Nombre           = $worksheet->getCellByColumnAndRow(1,   $row)->getValue();
											$Post_Ape_Pat          = $worksheet->getCellByColumnAndRow(2,   $row)->getValue();
											$Post_Ape_Mat          = $worksheet->getCellByColumnAndRow(3,   $row)->getValue();
											$Post_Rut              = $worksheet->getCellByColumnAndRow(4,   $row)->getValue();
											$Post_Sexo             = $worksheet->getCellByColumnAndRow(5,   $row)->getValue();
											$Post_Fono             = $worksheet->getCellByColumnAndRow(6,   $row)->getValue();
											$Post_Ciudad           = $worksheet->getCellByColumnAndRow(7,   $row)->getValue();
											$Post_Comuna           = $worksheet->getCellByColumnAndRow(8,   $row)->getValue();
											$Post_Direccion        = $worksheet->getCellByColumnAndRow(9,   $row)->getValue();
											$Post_Email            = $worksheet->getCellByColumnAndRow(10,  $row)->getValue();
											$Post_EstadoCivil      = $worksheet->getCellByColumnAndRow(11,  $row)->getValue();
											$Post_TipoTrabajador   = $worksheet->getCellByColumnAndRow(12,  $row)->getValue();
											$Post_TipoContrato     = $worksheet->getCellByColumnAndRow(13,  $row)->getValue();
											$Post_AFP              = $worksheet->getCellByColumnAndRow(14,  $row)->getValue();
											$Post_Salud            = $worksheet->getCellByColumnAndRow(15,  $row)->getValue();
											$Post_Sueldo           = $worksheet->getCellByColumnAndRow(16,  $row)->getValue();

											//Mientras exista dato ejecuta
											if(isset($Post_Nombre)&&$Post_Nombre!=''&&isset($Post_Rut)&&$Post_Rut!=''){

												//verifico si existen los datos
												if(isset($Post_Sexo)&&isset($arrSexoMod[$Post_Sexo]['ID'])){                                $ID_Sexo            = $arrSexoMod[$Post_Sexo]['ID'];}
												if(isset($Post_Ciudad)&&isset($arrCiudadMod[$Post_Ciudad]['ID'])){                          $ID_Ciudad          = $arrCiudadMod[$Post_Ciudad]['ID'];}
												if(isset($Post_Comuna)&&isset($arrComunaMod[$Post_Comuna]['ID'])){                          $ID_Comuna          = $arrComunaMod[$Post_Comuna]['ID'];}
												if(isset($Post_EstadoCivil)&&isset($arrEstadoCivilMod[$Post_EstadoCivil]['ID'])){           $ID_EstadoCivil     = $arrEstadoCivilMod[$Post_EstadoCivil]['ID'];}
												if(isset($Post_TipoTrabajador)&&isset($arrTipoTrabajadorMod[$Post_TipoTrabajador]['ID'])){  $ID_TipoTrabajador  = $arrTipoTrabajadorMod[$Post_TipoTrabajador]['ID'];}
												if(isset($Post_TipoContrato)&&isset($arrTipoContratoMod[$Post_TipoContrato]['ID'])){        $ID_TipoContrato    = $arrTipoContratoMod[$Post_TipoContrato]['ID'];}
												if(isset($Post_AFP)&&isset($arrAFPMod[$Post_AFP]['ID'])){                                   $ID_AFP             = $arrAFPMod[$Post_AFP]['ID'];}
												if(isset($Post_Salud)&&isset($arrSaludMod[$Post_Salud]['ID'])){                             $ID_Salud           = $arrSaludMod[$Post_Salud]['ID'];}

												/****************************************************/
												//filtros
												if(isset($idSistema) && $idSistema!=''){                  $SIS_data  = "'".$idSistema."'";           }else{$SIS_data  = "''";}
												if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";           }else{$SIS_data .= ",''";}
												if(isset($Post_Nombre) && $Post_Nombre!=''){              $SIS_data .= ",'".$Post_Nombre."'";        }else{$SIS_data .= ",''";}
												if(isset($Post_Ape_Pat) && $Post_Ape_Pat!=''){            $SIS_data .= ",'".$Post_Ape_Pat."'";       }else{$SIS_data .= ",''";}
												if(isset($Post_Ape_Mat) && $Post_Ape_Mat!=''){            $SIS_data .= ",'".$Post_Ape_Mat."'";       }else{$SIS_data .= ",''";}
												if(isset($Post_Rut) && $Post_Rut!=''){                    $SIS_data .= ",'".$Post_Rut."'";           }else{$SIS_data .= ",''";}
												if(isset($ID_Sexo) && $ID_Sexo!=''){                      $SIS_data .= ",'".$ID_Sexo."'";            }else{$SIS_data .= ",''";}
												if(isset($Post_Fono) && $Post_Fono!=''){                  $SIS_data .= ",'".$Post_Fono."'";          }else{$SIS_data .= ",''";}
												if(isset($ID_Ciudad) && $ID_Ciudad!=''){                  $SIS_data .= ",'".$ID_Ciudad."'";          }else{$SIS_data .= ",''";}
												if(isset($ID_Comuna) && $ID_Comuna!=''){                  $SIS_data .= ",'".$ID_Comuna."'";          }else{$SIS_data .= ",''";}
												if(isset($Post_Direccion) && $Post_Direccion!=''){        $SIS_data .= ",'".$Post_Direccion."'";     }else{$SIS_data .= ",''";}
												if(isset($Post_Email) && $Post_Email!=''){                $SIS_data .= ",'".$Post_Email."'";         }else{$SIS_data .= ",''";}
												if(isset($ID_EstadoCivil) && $ID_EstadoCivil!=''){        $SIS_data .= ",'".$ID_EstadoCivil."'";     }else{$SIS_data .= ",''";}
												if(isset($ID_TipoTrabajador) && $ID_TipoTrabajador!=''){  $SIS_data .= ",'".$ID_TipoTrabajador."'";  }else{$SIS_data .= ",''";}
												if(isset($ID_TipoContrato) && $ID_TipoContrato!=''){      $SIS_data .= ",'".$ID_TipoContrato."'";    }else{$SIS_data .= ",''";}
												if(isset($ID_AFP) && $ID_AFP!=''){                        $SIS_data .= ",'".$ID_AFP."'";             }else{$SIS_data .= ",''";}
												if(isset($ID_Salud) && $ID_Salud!=''){                    $SIS_data .= ",'".$ID_Salud."'";           }else{$SIS_data .= ",''";}
												if(isset($Post_Sueldo) && $Post_Sueldo!=''){              $SIS_data .= ",'".$Post_Sueldo."'";        }else{$SIS_data .= ",''";}

												// inserto los datos de registro en la db
												$SIS_columns = 'idSistema,idEstado,Nombre,ApellidoPat,ApellidoMat, Rut,idSexo,Fono,idCiudad,idComuna,Direccion,email,idEstadoCivil,idTipoTrabajador, idTipoContrato,idAFP,idSalud,SueldoLiquido';
												$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'trabajadores_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

												//Si ejecuto correctamente la consulta
												if($ultimo_id!=0){
													/****************************************************/
													//Verifico la existencia de un email y si se desea enviar correos
													if(isset($Post_Email)&&$Post_Email!=''&&isset($idOpciones)&&$idOpciones==1){

														//variables
														$login_logo  = DB_SITE_MAIN.'/img/login_logo.png';
														$Link        = DB_SITE_MAIN;
														$Nombre      = '';
														if(isset($Post_Nombre) && $Post_Nombre!=''){    $Nombre .= $Post_Nombre;}
														if(isset($Post_Ape_Pat) && $Post_Ape_Pat!=''){  $Nombre .= " ".$Post_Ape_Pat;}
														if(isset($Post_Ape_Mat) && $Post_Ape_Mat!=''){  $Nombre .= " ".$Post_Ape_Mat;}

														//envio de correo
														try {

															//se consulta el correo
															$rowusr = db_select_data (false, 'Nombre,email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

															//Se crea el cuerpo
															$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
															$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
															$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
															$BodyMail .= '¡Hola <strong>'.$Nombre.'</strong>!<br/>';
															$BodyMail .= 'Bienvenido/a a <strong>'.$rowusr['Nombre'].'</strong>';
															$BodyMail .= '</h3>';
															$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
															$BodyMail .= '';
															$BodyMail .= '</p>';
															$BodyMail .= '<a href="'.$Link.'" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Empezar &#8594;</strong></a>';
															$BodyMail .= '</div>';

															$rmail = tareas_envio_correo($rowusr['email_principal'], '1Tek',
																						 $Post_Email, $Nombre,
																						 '', '',
																						 'Registro de Usuario',
																						 $BodyMail,'',
																						 '',
																						 1,
																						 $rowusr['Gmail_Usuario'],
																						 $rowusr['Gmail_Password']);
															//se guarda el log
															log_response(1, $rmail, $Post_Email.' (Asunto:Registro de Usuario)');

														}catch (Exception $e) {
															php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'error de registro:'.$e->getMessage(), '' );
														}
													}
												}
											}
										}
									}
								}

								//redirijo
								header( 'Location: '.$location.'&created=true' );
								die;

							}

						} else {
							$error['FileTrabajador']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}else{
					//se devuelve error
					$error['FileTrabajador'] = 'error/No ha seleccionado un archivo';
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
