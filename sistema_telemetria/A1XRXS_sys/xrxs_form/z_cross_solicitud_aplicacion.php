<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-243).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idSolicitud']))          $idSolicitud             = $_POST['idSolicitud'];
	if (!empty($_POST['idSistema']))            $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idPredio']))             $idPredio                = $_POST['idPredio'];
	if (!empty($_POST['idUsuario']))            $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))             $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idTemporada']))          $idTemporada             = $_POST['idTemporada'];
	if (!empty($_POST['idEstadoFen']))          $idEstadoFen             = $_POST['idEstadoFen'];
	if (!empty($_POST['idCategoria']))          $idCategoria             = $_POST['idCategoria'];
	if (!empty($_POST['idProducto']))           $idProducto              = $_POST['idProducto'];
	if (!empty($_POST['f_creacion']))           $f_creacion 	         = $_POST['f_creacion'];
	if (!empty($_POST['f_programacion']))       $f_programacion          = $_POST['f_programacion'];
	if (!empty($_POST['f_programacion_fin']))   $f_programacion_fin      = $_POST['f_programacion_fin'];
	if (!empty($_POST['f_ejecucion']))          $f_ejecucion             = $_POST['f_ejecucion'];
	if (!empty($_POST['f_ejecucion_fin']))      $f_ejecucion_fin         = $_POST['f_ejecucion_fin'];
	if (!empty($_POST['f_termino']))            $f_termino 	             = $_POST['f_termino'];
	if (!empty($_POST['f_termino_fin']))        $f_termino_fin 	         = $_POST['f_termino_fin'];
	if (!empty($_POST['Observaciones']))        $Observaciones           = $_POST['Observaciones'];
	if (!empty($_POST['progDia']))              $progDia                 = $_POST['progDia'];
	if (!empty($_POST['progSemana']))           $progSemana              = $_POST['progSemana'];
	if (!empty($_POST['progMes']))              $progMes                 = $_POST['progMes'];
	if (!empty($_POST['progAno']))              $progAno                 = $_POST['progAno'];
	if (!empty($_POST['ejeDia']))               $ejeDia                  = $_POST['ejeDia'];
	if (!empty($_POST['ejeSemana']))            $ejeSemana               = $_POST['ejeSemana'];
	if (!empty($_POST['ejeMes']))               $ejeMes                  = $_POST['ejeMes'];
	if (!empty($_POST['ejeAno']))               $ejeAno                  = $_POST['ejeAno'];
	if (!empty($_POST['terDia']))               $terDia                  = $_POST['terDia'];
	if (!empty($_POST['terSemana']))            $terSemana               = $_POST['terSemana'];
	if (!empty($_POST['terMes']))               $terMes                  = $_POST['terMes'];
	if (!empty($_POST['terAno']))               $terAno                  = $_POST['terAno'];
	if (!empty($_POST['horaProg']))             $horaProg                = $_POST['horaProg'];
	if (!empty($_POST['horaProg_fin']))         $horaProg_fin            = $_POST['horaProg_fin'];
	if (!empty($_POST['horaEjecucion']))        $horaEjecucion           = $_POST['horaEjecucion'];
	if (!empty($_POST['horaEjecucion_fin']))    $horaEjecucion_fin       = $_POST['horaEjecucion_fin'];
	if (!empty($_POST['horaTermino']))          $horaTermino             = $_POST['horaTermino'];
	if (!empty($_POST['horaTermino_fin']))      $horaTermino_fin         = $_POST['horaTermino_fin'];
	if ( isset($_POST['Mojamiento']))           $Mojamiento              = $_POST['Mojamiento'];
	if ( isset($_POST['VelTractor']))           $VelTractor              = $_POST['VelTractor'];
	if ( isset($_POST['VelViento']))            $VelViento               = $_POST['VelViento'];
	if ( isset($_POST['TempMin']))              $TempMin                 = $_POST['TempMin'];
	if ( isset($_POST['TempMax']))              $TempMax                 = $_POST['TempMax'];
	if ( isset($_POST['HumTempMax']))           $HumTempMax              = $_POST['HumTempMax'];
	if (!empty($_POST['idPrioridad']))          $idPrioridad             = $_POST['idPrioridad'];
	if (!empty($_POST['Observacion']))          $Observacion             = $_POST['Observacion'];
	if (!empty($_POST['Creacion_fecha']))       $Creacion_fecha          = $_POST['Creacion_fecha'];
	if (!empty($_POST['idDosificador']))        $idDosificador           = $_POST['idDosificador'];
	if (!empty($_POST['idEjecucion']))          $idEjecucion             = $_POST['idEjecucion'];
	if (!empty($_POST['Nombre_cuartel']))       $Nombre_cuartel          = $_POST['Nombre_cuartel'];
	if (!empty($_POST['ID_cuartel']))           $ID_cuartel              = $_POST['ID_cuartel'];
	if (!empty($_POST['NSolicitud']))           $NSolicitud              = $_POST['NSolicitud'];
	if (!empty($_POST['NSolicitudOld']))        $NSolicitudOld           = $_POST['NSolicitudOld'];

	//otros datos
	if (!empty($_POST['idZona']))               $idZona                  = $_POST['idZona'];
	if (!empty($_POST['idTelemetria']))         $idTelemetria            = $_POST['idTelemetria'];
	if (!empty($_POST['idProducto']))           $idProducto              = $_POST['idProducto'];
	if ( isset($_POST['DosisAplicar']))         $DosisAplicar            = $_POST['DosisAplicar'];
	if (!empty($_POST['Objetivo']))             $Objetivo                = $_POST['Objetivo'];

	if ( isset($_POST['idInterno']))            $idInterno               = $_POST['idInterno'];
	if ( isset($_POST['idInterno2']))           $idInterno2              = $_POST['idInterno2'];
	if ( isset($_POST['idInterno3']))           $idInterno3              = $_POST['idInterno3'];

	if (!empty($_POST['idCuarteles']))          $idCuarteles             = $_POST['idCuarteles'];
	if (!empty($_POST['idTractores']))          $idTractores             = $_POST['idTractores'];
	if (!empty($_POST['idProdQuim']))           $idProdQuim              = $_POST['idProdQuim'];
	if (!empty($_POST['f_cierre']))             $f_cierre                = $_POST['f_cierre'];
	if (!empty($_POST['idEstadoActual']))       $idEstadoActual          = $_POST['idEstadoActual'];
	if (!empty($_POST['idVehiculo']))           $idVehiculo              = $_POST['idVehiculo'];
	if (!empty($_POST['idTrabajador']))         $idTrabajador            = $_POST['idTrabajador'];

	if (!empty($_POST['idMatSeguridad']))       $idMatSeguridad          = $_POST['idMatSeguridad'];

	if (!empty($_POST['GeoDistance']))          $GeoDistance             = $_POST['GeoDistance'];
	if (!empty($_POST['VelPromedio']))          $VelPromedio             = $_POST['VelPromedio'];
	if (!empty($_POST['LitrosAplicados']))      $LitrosAplicados         = $_POST['LitrosAplicados'];
	if (!empty($_POST['T_Aplicacion']))         $T_Aplicacion            = $_POST['T_Aplicacion'];

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
			case 'idSolicitud':           if(empty($idSolicitud)){            $error['idSolicitud']             = 'error/No ha ingresado el id del sistema';}break;
			case 'idSistema':             if(empty($idSistema)){              $error['idSistema']               = 'error/No ha ingresado el idSistema del sistema';}break;
			case 'idPredio':              if(empty($idPredio)){               $error['idPredio']                = 'error/No ha ingresado la maquina';}break;
			case 'idUsuario':             if(empty($idUsuario)){              $error['idUsuario']               = 'error/No ha ingresado el usuario';}break;
			case 'idEstado':              if(empty($idEstado)){               $error['idEstado']                = 'error/No ha ingresado el estado';}break;
			case 'idTemporada':           if(empty($idTemporada)){            $error['idTemporada']             = 'error/No ha ingresado la prioridad';}break;
			case 'idEstadoFen':           if(empty($idEstadoFen)){            $error['idEstadoFen']             = 'error/No ha ingresado el tipo';}break;
			case 'idCategoria':           if(empty($idCategoria)){            $error['idCategoria']             = 'error/No ha seleccionado la Especie';}break;
			case 'idProducto':            if(empty($idProducto)){             $error['idProducto']              = 'error/No ha seleccionado la variedad';}break;
			case 'f_creacion':            if(empty($f_creacion)){             $error['f_creacion']              = 'error/No ha ingresado la fecha de creación';}break;
			case 'f_programacion':        if(empty($f_programacion)){         $error['f_programacion']          = 'error/No ha ingresado la fecha de programacion';}break;
			case 'f_programacion_fin':    if(empty($f_programacion_fin)){     $error['f_programacion_fin']      = 'error/No ha ingresado la fecha de termino de programacion';}break;
			case 'f_ejecucion':           if(empty($f_ejecucion)){            $error['f_ejecucion']             = 'error/No ha ingresado la fecha de ejecucion';}break;
			case 'f_ejecucion_fin':       if(empty($f_ejecucion_fin)){        $error['f_ejecucion_fin']         = 'error/No ha ingresado la fecha de termino de ejecucion';}break;
			case 'f_termino':             if(empty($f_termino)){              $error['f_termino']               = 'error/No ha ingresado la fecha de termino';}break;
			case 'f_termino_fin':         if(empty($f_termino_fin)){          $error['f_termino_fin']           = 'error/No ha ingresado la fecha de termino de termino';}break;
			case 'Observaciones':         if(empty($Observaciones)){          $error['Observaciones']           = 'error/No ha ingresado la observacion';}break;
			case 'progDia':               if(empty($progDia)){                $error['progDia']                 = 'error/No ha ingresado el dia de programacion';}break;
			case 'progSemana':            if(empty($progSemana)){             $error['progSemana']              = 'error/No ha ingresado la semana de programacion';}break;
			case 'progMes':               if(empty($progMes)){                $error['progMes']                 = 'error/No ha ingresado el mes de programacion';}break;
			case 'progAno':               if(empty($progAno)){                $error['progAno']                 = 'error/No ha ingresado el año de programacion';}break;
			case 'ejeDia':                if(empty($ejeDia)){                 $error['ejeDia']                  = 'error/No ha ingresado el dia de ejecucion';}break;
			case 'ejeSemana':             if(empty($ejeSemana)){              $error['ejeSemana']               = 'error/No ha ingresado la semana de ejecucion';}break;
			case 'ejeMes':                if(empty($ejeMes)){                 $error['ejeMes']                  = 'error/No ha ingresado el mes de ejecucion';}break;
			case 'ejeAno':                if(empty($ejeAno)){                 $error['ejeAno']                  = 'error/No ha ingresado el año de ejecucion';}break;
			case 'terDia':                if(empty($terDia)){                 $error['terDia']                  = 'error/No ha ingresado el dia de termino';}break;
			case 'terSemana':             if(empty($terSemana)){              $error['terSemana']               = 'error/No ha ingresado la semana de termino';}break;
			case 'terMes':                if(empty($terMes)){                 $error['terMes']                  = 'error/No ha ingresado el mes de termino';}break;
			case 'terAno':                if(empty($terAno)){                 $error['terAno']                  = 'error/No ha ingresado el año de termino';}break;
			case 'horaProg':              if(empty($horaProg)){               $error['horaProg']                = 'error/No ha ingresado la hora programada';}break;
			case 'horaProg_fin':          if(empty($horaProg_fin)){           $error['horaProg_fin']            = 'error/No ha ingresado la hora de termino programada';}break;
			case 'horaEjecucion':         if(empty($horaEjecucion)){          $error['horaEjecucion']           = 'error/No ha ingresado la hora de inicio';}break;
			case 'horaEjecucion_fin':     if(empty($horaEjecucion_fin)){      $error['horaEjecucion_fin']       = 'error/No ha ingresado la hora de termino de inicio';}break;
			case 'horaTermino':           if(empty($horaTermino)){            $error['horaTermino']             = 'error/No ha ingresado la hora de termino';}break;
			case 'horaTermino_fin':       if(empty($horaTermino_fin)){        $error['horaTermino_fin']         = 'error/No ha ingresado la hora de termino de termino';}break;
			case 'Mojamiento':            if(!isset($Mojamiento)){            $error['Mojamiento']              = 'error/No ha ingresado el parametro de mojamiento';}break;
			case 'VelTractor':            if(!isset($VelTractor)){            $error['VelTractor']              = 'error/No ha ingresado el parametro de velocidad de tractor';}break;
			case 'VelViento':             if(!isset($VelViento)){             $error['VelViento']               = 'error/No ha ingresado el parametro de velocidad de viento';}break;
			case 'TempMin':               if(!isset($TempMin)){               $error['TempMin']                 = 'error/No ha ingresado el parametro de temperatura minima';}break;
			case 'TempMax':               if(!isset($TempMax)){               $error['TempMax']                 = 'error/No ha ingresado el parametro de temperatura maxima';}break;
			case 'HumTempMax':            if(!isset($HumTempMax)){            $error['HumTempMax']              = 'error/No ha ingresado el parametro de humedad bajo temperatura maxima';}break;
			case 'idPrioridad':           if(empty($idPrioridad)){            $error['idPrioridad']             = 'error/No ha seleccionado la prioridad';}break;
			case 'Observacion':           if(empty($Observacion)){            $error['Observacion']             = 'error/No ha ingresado la observacion';}break;
			case 'Creacion_fecha':        if(empty($Creacion_fecha)){         $error['Creacion_fecha']          = 'error/No ha ingresado la fecha de creación';}break;
			case 'idDosificador':         if(empty($idDosificador)){          $error['idDosificador']           = 'error/No ha seleccionado al dosificador';}break;
			case 'NSolicitud':            if(empty($NSolicitud)){             $error['NSolicitud']              = 'error/No ha ingresado el numero de solicitud';}break;
			case 'NSolicitudOld':         if(empty($NSolicitudOld)){          $error['NSolicitudOld']           = 'error/No ha ingresado el numero de solicitud';}break;

			case 'idZona':                if(empty($idZona)){                 $error['idZona']                  = 'error/No ha seleccionado el cuartel';}break;
			case 'idTelemetria':          if(empty($idTelemetria)){           $error['idTelemetria']            = 'error/No ha seleccionado el Equipo Aplicación';}break;
			case 'idProducto':            if(empty($idProducto)){             $error['idProducto']              = 'error/No ha seleccionado el producto';}break;
			case 'DosisAplicar':          if(!isset($DosisAplicar)){          $error['DosisAplicar']            = 'error/No ha ingresado el parametro de dosis a aplicar';}break;
			case 'Objetivo':              if(empty($Objetivo)){               $error['Objetivo']                = 'error/No ha ingresado el parametro de objetivo';}break;

			case 'idInterno':             if(!isset($idInterno)){             $error['idInterno']               = 'error/No ha ingresado el id interno';}break;
			case 'idInterno2':            if(!isset($idInterno2)){            $error['idInterno2']              = 'error/No ha ingresado el id interno';}break;
			case 'idInterno3':            if(!isset($idInterno3)){            $error['idInterno3']              = 'error/No ha ingresado el id interno';}break;

			case 'idCuarteles':           if(empty($idCuarteles)){            $error['idCuarteles']             = 'error/No ha seleccionado el cuartel';}break;
			case 'idTractores':           if(empty($idTractores)){            $error['idTractores']             = 'error/No ha seleccionado el tractor';}break;
			case 'idProdQuim':            if(empty($idProdQuim)){             $error['idProdQuim']              = 'error/No ha seleccionado el producto quimico';}break;
			case 'f_cierre':              if(empty($f_cierre)){               $error['f_cierre']                = 'error/No ha ingresado la fecha de cierre';}break;
			case 'idEstadoActual':        if(empty($idEstadoActual)){         $error['idEstadoActual']          = 'error/No ha ingresado el estado actual';}break;
			case 'idVehiculo':            if(empty($idVehiculo)){             $error['idVehiculo']              = 'error/No ha seleccionado el tractor';}break;
			case 'idTrabajador':          if(empty($idTrabajador)){           $error['idTrabajador']            = 'error/No ha seleccionado el trabajador';}break;

			case 'idMatSeguridad':        if(empty($idMatSeguridad)){         $error['idMatSeguridad']          = 'error/No ha seleccionado el material de seguridad';}break;

			case 'GeoDistance':           if(empty($GeoDistance)){            $error['GeoDistance']             = 'error/No ha ingresado la distancia';}break;
			case 'VelPromedio':           if(empty($VelPromedio)){            $error['VelPromedio']             = 'error/No ha ingresado la velocidad promedio';}break;
			case 'LitrosAplicados':       if(empty($LitrosAplicados)){        $error['LitrosAplicados']         = 'error/No ha ingresado los litros aplicados';}break;
			case 'T_Aplicacion':          if(empty($T_Aplicacion)){           $error['T_Aplicacion']            = 'error/No ha ingresado el tiempo de aplicacion';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Observacion) && $Observacion!=''){     $Observacion   = EstandarizarInput($Observacion);}
	//if(isset($Objetivo) && $Objetivo!=''){           $Objetivo      = EstandarizarInput($Objetivo);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){      $error['Observacion']   = 'error/Edita Observacion, contiene palabras no permitidas';}
	//if(isset($Objetivo)&&contar_palabras_censuradas($Objetivo)!=0){            $error['Objetivo']      = 'error/Edita Objetivo, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'creacion_1':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Borro todas las sesiones
				unset($_SESSION['sol_apli_basicos']);
				unset($_SESSION['sol_apli_cuarteles']);
				unset($_SESSION['sol_apli_tractores']);
				unset($_SESSION['sol_apli_productos']);
				unset($_SESSION['sol_apli_materiales']);

				//Consultas a la base de datos
				/**********************************************/
				// Se traen todos los datos del predio
				$rowPredio = db_select_data (false, 'Nombre AS Predio', 'cross_predios_listado', '', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de las temporadas
				$rowTemporada = db_select_data (false, 'Codigo, Nombre', 'cross_checking_temporada', '', 'idTemporada = "'.$idTemporada.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de los estados fenologicos
				$rowEstadoFen = db_select_data (false, 'Codigo, Nombre', 'cross_checking_estado_fenologico', '', 'idEstadoFen = "'.$idEstadoFen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de las prioridades
				$rowPrioridad = db_select_data (false, 'Nombre', 'core_cross_prioridad', '', 'idPrioridad = "'.$idPrioridad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//se traen las Especie de las variedades
				if(isset($idCategoria)&&$idCategoria!=''){  $rowEspecie = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = "'.$idCategoria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}

				/**********************************************/
				// Se traen todos las variedades
				if(isset($idProducto)&&$idProducto!=''){    $rowVariedad = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idPredio)&&$idPredio!=''){                       $_SESSION['sol_apli_basicos']['idPredio']            = $idPredio;           }else{$_SESSION['sol_apli_basicos']['idPredio']            = '';}
				if(isset($idTemporada)&&$idTemporada!=''){                 $_SESSION['sol_apli_basicos']['idTemporada']         = $idTemporada;        }else{$_SESSION['sol_apli_basicos']['idTemporada']         = '';}
				if(isset($idEstadoFen)&&$idEstadoFen!=''){                 $_SESSION['sol_apli_basicos']['idEstadoFen']         = $idEstadoFen;        }else{$_SESSION['sol_apli_basicos']['idEstadoFen']         = '';}
				if(isset($idCategoria)&&$idCategoria!=''){                 $_SESSION['sol_apli_basicos']['idCategoria']         = $idCategoria;        }else{$_SESSION['sol_apli_basicos']['idCategoria']         = '';}
				if(isset($idProducto)&&$idProducto!=''){                   $_SESSION['sol_apli_basicos']['idProducto']          = $idProducto;         }else{$_SESSION['sol_apli_basicos']['idProducto']          = '';}
				if(isset($f_programacion)&&$f_programacion!=''){           $_SESSION['sol_apli_basicos']['f_programacion']      = $f_programacion;     }else{$_SESSION['sol_apli_basicos']['f_programacion']      = '';}
				if(isset($horaProg)&&$horaProg!=''){                       $_SESSION['sol_apli_basicos']['horaProg']            = $horaProg;           }else{$_SESSION['sol_apli_basicos']['horaProg']            = '';}
				if(isset($f_programacion_fin)&&$f_programacion_fin!=''){   $_SESSION['sol_apli_basicos']['f_programacion_fin']  = $f_programacion_fin; }else{$_SESSION['sol_apli_basicos']['f_programacion_fin']  = '';}
				if(isset($horaProg_fin)&&$horaProg_fin!=''){               $_SESSION['sol_apli_basicos']['horaProg_fin']        = $horaProg_fin;       }else{$_SESSION['sol_apli_basicos']['horaProg_fin']        = '';}
				if(isset($idSistema)&&$idSistema!=''){                     $_SESSION['sol_apli_basicos']['idSistema']           = $idSistema;          }else{$_SESSION['sol_apli_basicos']['idSistema']           = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                     $_SESSION['sol_apli_basicos']['idUsuario']           = $idUsuario;          }else{$_SESSION['sol_apli_basicos']['idUsuario']           = '';}
				if(isset($idEstado)&&$idEstado!=''){                       $_SESSION['sol_apli_basicos']['idEstado']            = $idEstado;           }else{$_SESSION['sol_apli_basicos']['idEstado']            = '';}
				if(isset($f_creacion)&&$f_creacion!=''){                   $_SESSION['sol_apli_basicos']['f_creacion']          = $f_creacion;         }else{$_SESSION['sol_apli_basicos']['f_creacion']          = '';}
				if(isset($Observaciones)&&$Observaciones!=''){             $_SESSION['sol_apli_basicos']['Observaciones']       = $Observaciones;      }else{$_SESSION['sol_apli_basicos']['Observaciones']       = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){                 $_SESSION['sol_apli_basicos']['idPrioridad']         = $idPrioridad;        }else{$_SESSION['sol_apli_basicos']['idPrioridad']         = '';}
				if(isset($NSolicitud)&&$NSolicitud!=''){                   $_SESSION['sol_apli_basicos']['NSolicitud']          = $NSolicitud;         }else{$_SESSION['sol_apli_basicos']['NSolicitud']          = '';}
				//datos en blanco
				$_SESSION['sol_apli_basicos']['Mojamiento']          = 0;
				$_SESSION['sol_apli_basicos']['VelTractor']          = 0;
				$_SESSION['sol_apli_basicos']['VelViento']           = 0;
				$_SESSION['sol_apli_basicos']['TempMin']             = 0;
				$_SESSION['sol_apli_basicos']['TempMax']             = 0;
				$_SESSION['sol_apli_basicos']['HumTempMax']          = 0;
				$_SESSION['sol_apli_basicos']['Carencias']           = '';

				//Datos guardados
				$_SESSION['sol_apli_basicos']['Predio']              = $rowPredio['Predio'];
				$_SESSION['sol_apli_basicos']['Temporada']           = $rowTemporada['Codigo'].' '.$rowTemporada['Nombre'];
				$_SESSION['sol_apli_basicos']['EstadoFen']           = $rowEstadoFen['Codigo'].' '.$rowEstadoFen['Nombre'];
				$_SESSION['sol_apli_basicos']['Prioridad']           = $rowPrioridad['Nombre'];
				$_SESSION['sol_apli_basicos']['EspecieVariedad']     = '';
				if(isset($idCategoria)&&$idCategoria!=''){
					$_SESSION['sol_apli_basicos']['EspecieVariedad'] .= $rowEspecie['Nombre'];
				}
				if(isset($idProducto)&&$idProducto!=''){
					$_SESSION['sol_apli_basicos']['EspecieVariedad'] .= ' - '.$rowVariedad['Nombre'];
				}

				header( 'Location: '.$location.'&new_2=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'creacion_2':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se actualizan datos de aplicacion
				$_SESSION['sol_apli_basicos']['Mojamiento']   = Cantidades_decimales_justos($Mojamiento);
				$_SESSION['sol_apli_basicos']['VelTractor']   = Cantidades_decimales_justos($VelTractor);
				$_SESSION['sol_apli_basicos']['VelViento']    = Cantidades_decimales_justos($VelViento);
				$_SESSION['sol_apli_basicos']['TempMin']      = Cantidades_decimales_justos($TempMin);
				$_SESSION['sol_apli_basicos']['TempMax']      = Cantidades_decimales_justos($TempMax);
				$_SESSION['sol_apli_basicos']['HumTempMax']   = Cantidades_decimales_justos($HumTempMax);

				//si existen cuarteles se actualizan sus datos internos
				if(isset($_SESSION['sol_apli_cuarteles'])&&$_SESSION['sol_apli_cuarteles']!=''){
					foreach ($_SESSION['sol_apli_cuarteles'] as $key => $cuartel){

						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['Mojamiento']  = $Mojamiento;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['VelTractor']  = $VelTractor;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['VelViento']   = $VelViento;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['TempMin']     = $TempMin;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['TempMax']     = $TempMax;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['HumTempMax']  = $HumTempMax;

					}
				}

				header( 'Location: '.$location.'&new_3=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'creacion_3':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idZona)){          $ndata_1 = count($idZona);          }else{$ndata_1 = 0;}
			if(isset($idVehiculo)){      $ndata_2 = count($idVehiculo);      }else{$ndata_2 = 0;}
			if(isset($idProducto)){      $ndata_3 = count($idProducto);      }else{$ndata_3 = 0;}
			if(isset($idMatSeguridad)){  $ndata_4 = count($idMatSeguridad);  }else{$ndata_4 = 0;}
			//generacion de errores
			if(count(array_filter($idZona))==0) {          $error['ndata_1'] = 'error/No hay cuarteles agregados';}
			if(count(array_filter($idVehiculo))==0) {      $error['ndata_2'] = 'error/No hay tractores agregados';}
			if(count(array_filter($idProducto))==0) {      $error['ndata_3'] = 'error/No hay productos quimicos agregados';}
			if(count(array_filter($idMatSeguridad))==0) {  $error['ndata_4'] = 'error/No hay materiales de seguridad agregados';}
			/*******************************************************************/
			//Consulto
			/**********************************************/
			//Se trae un listado con los cuarteles
			if(count(array_filter($idZona))!=0) {
				$SIS_query = 'cross_predios_listado_zonas.idZona,
				cross_predios_listado_zonas.idCategoria,
				cross_predios_listado_zonas.idProducto,
				cross_predios_listado_zonas.Nombre AS Cuartel,
				sistema_variedades_categorias.Nombre AS Especie,
				variedades_listado.Nombre AS Variedad';
				$SIS_join  = '
				LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_predios_listado_zonas.idCategoria
				LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_predios_listado_zonas.idProducto';
				$SIS_where = 'cross_predios_listado_zonas.idPredio = '.$_SESSION['sol_apli_basicos']['idPredio'];
				$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
				$arrCuarteles = array();
				$arrCuarteles = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			if(count(array_filter($idVehiculo))!=0) {
				//Se trae un listado con los vehiculos
				$arrVehiculos = array();
				$arrVehiculos = db_select_array (false, 'idVehiculo, Nombre', 'vehiculos_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los equipos de telemetria
				$arrTelemetria = array();
				$arrTelemetria = db_select_array (false, 'idTelemetria, Nombre', 'telemetria_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los trabajadores
				$arrTrabajadores = array();
				$arrTrabajadores = db_select_array (false, 'idTrabajador, Rut,Nombre,ApellidoPat', 'trabajadores_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			//Se trae un listado con los productos
			if(count(array_filter($idProducto))!=0) {
				$SIS_query = 'productos_listado.idProducto,
				productos_listado.Nombre AS NombreProducto,
				productos_listado.DosisRecomendada,
				productos_listado.idUml,
				sistema_productos_uml.Nombre AS Unimed';
				$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
				$SIS_where = 'productos_listado.idEstado=1';
				$SIS_order = 'sistema_productos_uml.Nombre ASC';
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			//Se trae un listado con los materiales
			if(count(array_filter($idMatSeguridad))!=0) {
				$arrMateriales = array();
				$arrMateriales = db_select_array (false, 'idMatSeguridad, Nombre,Codigo', 'cross_checking_materiales_seguridad', '', 'idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/*******************************************************************/
			//verifico que no existan repetidos
			//Recorro los tractores
			$arrVehTemp = array();
			$arrTelTemp = array();
			//se recorren los tractores
			for($j2 = 0; $j2 < $ndata_2; $j2++){
				if(isset($arrVehTemp[$idVehiculo[$j2]]['idVehiculo'])&&$arrVehTemp[$idVehiculo[$j2]]['idVehiculo']==$idVehiculo[$j2]){
					$error['Vehiculos_'.$idVehiculo[$j2]] = 'error/Vehiculo repetido, seleccione otro';
				}else{
					$arrVehTemp[$idVehiculo[$j2]]['idVehiculo']  = $idVehiculo[$j2];
				}
				if(isset($arrTelTemp[$idTelemetria[$j2]]['idTelemetria'])&&$arrTelTemp[$idTelemetria[$j2]]['idTelemetria']==$idTelemetria[$j2]){
					$error['Telemetria_'.$idTelemetria[$j2]] = 'error/Equipo nebulizador repetido, seleccione otro';
				}else{
					$arrTelTemp[$idTelemetria[$j2]]['idTelemetria']  = $idTelemetria[$j2];
				}
			}

			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				/**********************************************/
				//Obtengo la ultima solicitud del predio
				$rowSolicitud = db_select_data (false, 'idSolicitud', 'cross_solicitud_aplicacion_listado', '', 'idEstado = 3 AND idPredio = '.$_SESSION['sol_apli_basicos']['idPredio'].' ORDER BY f_termino_fin DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Verifico si existe
				if(isset($rowSolicitud['idSolicitud'])&&$rowSolicitud['idSolicitud']!=''){
					//Consulto en base a esta
					$SIS_query = '
					cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
					cross_solicitud_aplicacion_listado_cuarteles.idZona,
					cross_solicitud_aplicacion_listado_productos.idProducto,
					cross_predios_listado_zonas.Nombre AS Cuartel,
					productos_listado.EfectoRetroactivo,
					productos_listado.Nombre';
					$SIS_join  = '
					LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud  = cross_solicitud_aplicacion_listado.idSolicitud
					LEFT JOIN `cross_solicitud_aplicacion_listado_productos`   ON cross_solicitud_aplicacion_listado_productos.idCuarteles  = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
					LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                        = cross_solicitud_aplicacion_listado_cuarteles.idZona
					LEFT JOIN `productos_listado`                              ON productos_listado.idProducto                              = cross_solicitud_aplicacion_listado_productos.idProducto';
					$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud='.$rowSolicitud['idSolicitud'].'
					AND productos_listado.EfectoRetroactivo!=0
					AND cross_solicitud_aplicacion_listado_cuarteles.f_cierre!="0000-00-00"
					AND cross_solicitud_aplicacion_listado_cuarteles.idEstado=2';
					$SIS_order = 0;
					$arrCarencias = array();
					$arrCarencias = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					$arrFinalCarencia = array();
					foreach ($arrCarencias as $prod) {
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Nombre']   = $prod['Nombre'];
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Cuartel']  = $prod['Cuartel'];
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Fecha']    = sumarDias($prod['f_cierre'],cantidades($prod['EfectoRetroactivo'], 0));
					}
				}else{
					$arrFinalCarencia = array();
				}

				/**********************************************/
				//se listan los cuarteles
				$arrCuart = array();
				foreach ($arrCuarteles as $prod) {
					$arrCuart[$prod['idZona']]['Nombre']       = $prod['Cuartel'];
					$arrCuart[$prod['idZona']]['Especie']      = $prod['Especie'];
					$arrCuart[$prod['idZona']]['Variedad']     = $prod['Variedad'];
					$arrCuart[$prod['idZona']]['idCategoria']  = $prod['idCategoria'];
					$arrCuart[$prod['idZona']]['idProducto']   = $prod['idProducto'];
				}

				//se listan los vehiculos
				$arrVeh = array();
				foreach ($arrVehiculos as $prod) {
					$arrVeh[$prod['idVehiculo']]['Nombre']  = $prod['Nombre'];
				}

				//se listan los equipos de telemetria
				$arrTel = array();
				foreach ($arrTelemetria as $prod) {
					$arrTel[$prod['idTelemetria']]['Nombre']  = $prod['Nombre'];
				}

				//se listan los trabajadores
				$arrTrab = array();
				foreach ($arrTrabajadores as $prod) {
					$arrTrab[$prod['idTrabajador']]['Nombre']  = $prod['Rut'].' - '.$prod['Nombre'].' '.$prod['ApellidoPat'];
				}

				//se listan los productos quimicos
				$arrProd = array();
				foreach ($arrProductos as $prod) {
					$arrProd[$prod['idProducto']]['Nombre']            = $prod['NombreProducto'];
					$arrProd[$prod['idProducto']]['Unimed']            = $prod['Unimed'];
					$arrProd[$prod['idProducto']]['idUml']             = $prod['idUml'];
					$arrProd[$prod['idProducto']]['DosisRecomendada']  = $prod['DosisRecomendada'];
				}

				//se listan los materiales
				$arrMat = array();
				foreach ($arrMateriales as $prod) {
					$arrMat[$prod['idMatSeguridad']]['Nombre']            = $prod['Nombre'];
					$arrMat[$prod['idMatSeguridad']]['Codigo']            = $prod['Codigo'];
				}

				/*******************************************************************************/
				//se borran todos los cuarteles
				unset($_SESSION['sol_apli_cuarteles']);
				unset($_SESSION['sol_apli_productos']);
				unset($_SESSION['sol_apli_materiales']);
				unset($_SESSION['sol_apli_tractores']);
				unset($_SESSION['sol_apli_materiales']);

				//Guardo los datos de Parámetros de Aplicación
				/*$_SESSION['sol_apli_basicos']['Mojamiento']  = Cantidades_decimales_justos($Mojamiento);
				$_SESSION['sol_apli_basicos']['VelTractor']  = Cantidades_decimales_justos($VelTractor);
				$_SESSION['sol_apli_basicos']['VelViento']   = Cantidades_decimales_justos($VelViento);
				$_SESSION['sol_apli_basicos']['TempMin']     = Cantidades_decimales_justos($TempMin);
				$_SESSION['sol_apli_basicos']['TempMax']     = Cantidades_decimales_justos($TempMax);
				$_SESSION['sol_apli_basicos']['HumTempMax']  = Cantidades_decimales_justos($HumTempMax);*/

				//Recorro los cuarteles
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//variable interna
					$nmc1 = $j1 + 1;
					//Para mostrar en la creación
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idZona']          = $idZona[$j1];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['Mojamiento']      = Cantidades_decimales_justos($Mojamiento);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['VelTractor']      = Cantidades_decimales_justos($VelTractor);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['VelViento']       = Cantidades_decimales_justos($VelViento);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['TempMin']         = Cantidades_decimales_justos($TempMin);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['TempMax']         = Cantidades_decimales_justos($TempMax);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['HumTempMax']      = Cantidades_decimales_justos($HumTempMax);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['valor_id']        = $nmc1;
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelNombre']   = $arrCuart[$idZona[$j1]]['Nombre'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelEspecie']  = $arrCuart[$idZona[$j1]]['Especie'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelVariedad'] = $arrCuart[$idZona[$j1]]['Variedad'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idCategoria']     = $arrCuart[$idZona[$j1]]['idCategoria'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idProducto']      = $arrCuart[$idZona[$j1]]['idProducto'];

					//Recorro los tractores
					for($j2 = 0; $j2 < $ndata_2; $j2++){
						//variable interna
						$nmc2 = $j2 + 1;
						//Para mostrar en la creación
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idVehiculo']    = $idVehiculo[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idTelemetria']  = $idTelemetria[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idTrabajador']  = $idTrabajador[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['valor_id']      = $nmc2;
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Vehiculo']      = $arrVeh[$idVehiculo[$j2]]['Nombre'];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Telemetria']    = $arrTel[$idTelemetria[$j2]]['Nombre'];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Trabajador']    = $arrTrab[$idTrabajador[$j2]]['Nombre'];

					}

					//Recorro los productos
					for($j3 = 0; $j3 < $ndata_3; $j3++){
						//variable interna
						$nmc3 = $j3 + 1;
						//Para mostrar en la creación
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['idProducto']        = $idProducto[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['DosisAplicar']      = $DosisAplicar[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Objetivo']          = $Objetivo[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['valor_id']          = $nmc3;
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Producto']          = $arrProd[$idProducto[$j3]]['Nombre'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['DosisRecomendada']  = $arrProd[$idProducto[$j3]]['DosisRecomendada'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Unimed']            = $arrProd[$idProducto[$j3]]['Unimed'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['idUml']             = $arrProd[$idProducto[$j3]]['idUml'];

						/***********************************************/
						//Comparo los productos y las fechas
						if(isset($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Nombre'])){
							if($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Fecha']>$_SESSION['sol_apli_basicos']['f_programacion']){
								$_SESSION['sol_apli_basicos']['Carencias'] .= 'El Producto '.$arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Nombre'].' del cuartel '.$arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Cuartel'].' aun tiene un tiempo de reingreso por cumplir, este expira el '.fecha_estandar($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Fecha']).'.<br/>';
							}
						}
					}
				}
				//Recorro los materiales
				for($j4 = 0; $j4 < $ndata_4; $j4++){
					//variable interna
					$nmc4 = $j4 + 1;
					//Para mostrar en la creación
					$_SESSION['sol_apli_materiales'][$nmc4]['idMatSeguridad']  = $idMatSeguridad[$j4];
					$_SESSION['sol_apli_materiales'][$nmc4]['Nombre']          = $arrMat[$idMatSeguridad[$j4]]['Nombre'];
					$_SESSION['sol_apli_materiales'][$nmc4]['Codigo']          = $arrMat[$idMatSeguridad[$j4]]['Codigo'];
					$_SESSION['sol_apli_materiales'][$nmc4]['valor_id']        = $nmc4;
				}

				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clear_all':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['sol_apli_basicos']);
			unset($_SESSION['sol_apli_cuarteles']);
			unset($_SESSION['sol_apli_tractores']);
			unset($_SESSION['sol_apli_productos']);
			unset($_SESSION['sol_apli_materiales']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//si cambia la variedad se resetea todo
				if(isset($_SESSION['sol_apli_basicos']['idProducto'], $idProducto)&&$_SESSION['sol_apli_basicos']['idProducto']!=$idProducto){
					//Borro todas las sesiones
					unset($_SESSION['sol_apli_cuarteles']);
					unset($_SESSION['sol_apli_tractores']);
					unset($_SESSION['sol_apli_productos']);
					unset($_SESSION['sol_apli_materiales']);
				}

				//Consultas a la base de datos
				/**********************************************/
				// Se traen todos los datos del predio
				$rowPredio = db_select_data (false, 'Nombre AS Predio', 'cross_predios_listado', '', 'idPredio = "'.$idPredio.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de las temporadas
				$rowTemporada = db_select_data (false, 'Codigo, Nombre', 'cross_checking_temporada', '', 'idTemporada = "'.$idTemporada.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de los estados fenologicos
				$rowEstadoFen = db_select_data (false, 'Codigo, Nombre', 'cross_checking_estado_fenologico', '', 'idEstadoFen = "'.$idEstadoFen.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				// Se traen todos los datos de las prioridades
				$rowPrioridad = db_select_data (false, 'Nombre', 'core_cross_prioridad', '', 'idPrioridad = "'.$idPrioridad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//se traen las Especie de las variedades
				if(isset($idCategoria)&&$idCategoria!=''){  $rowEspecie = db_select_data (false, 'Nombre', 'sistema_variedades_categorias', '', 'idCategoria = "'.$idCategoria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}

				/**********************************************/
				// Se traen todos las variedades
				if(isset($idProducto)&&$idProducto!=''){    $rowVariedad = db_select_data (false, 'Nombre', 'variedades_listado', '', 'idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);}

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idPredio)&&$idPredio!=''){                       $_SESSION['sol_apli_basicos']['idPredio']            = $idPredio;           }else{$_SESSION['sol_apli_basicos']['idPredio']            = '';}
				if(isset($idTemporada)&&$idTemporada!=''){                 $_SESSION['sol_apli_basicos']['idTemporada']         = $idTemporada;        }else{$_SESSION['sol_apli_basicos']['idTemporada']         = '';}
				if(isset($idEstadoFen)&&$idEstadoFen!=''){                 $_SESSION['sol_apli_basicos']['idEstadoFen']         = $idEstadoFen;        }else{$_SESSION['sol_apli_basicos']['idEstadoFen']         = '';}
				if(isset($idCategoria)&&$idCategoria!=''){                 $_SESSION['sol_apli_basicos']['idCategoria']         = $idCategoria;        }else{$_SESSION['sol_apli_basicos']['idCategoria']         = '';}
				if(isset($idProducto)&&$idProducto!=''){                   $_SESSION['sol_apli_basicos']['idProducto']          = $idProducto;         }else{$_SESSION['sol_apli_basicos']['idProducto']          = '';}
				if(isset($f_programacion)&&$f_programacion!=''){           $_SESSION['sol_apli_basicos']['f_programacion']      = $f_programacion;     }else{$_SESSION['sol_apli_basicos']['f_programacion']      = '';}
				if(isset($horaProg)&&$horaProg!=''){                       $_SESSION['sol_apli_basicos']['horaProg']            = $horaProg;           }else{$_SESSION['sol_apli_basicos']['horaProg']            = '';}
				if(isset($f_programacion_fin)&&$f_programacion_fin!=''){   $_SESSION['sol_apli_basicos']['f_programacion_fin']  = $f_programacion_fin; }else{$_SESSION['sol_apli_basicos']['f_programacion_fin']  = '';}
				if(isset($horaProg_fin)&&$horaProg_fin!=''){               $_SESSION['sol_apli_basicos']['horaProg_fin']        = $horaProg_fin;       }else{$_SESSION['sol_apli_basicos']['horaProg_fin']        = '';}
				if(isset($idSistema)&&$idSistema!=''){                     $_SESSION['sol_apli_basicos']['idSistema']           = $idSistema;          }else{$_SESSION['sol_apli_basicos']['idSistema']           = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                     $_SESSION['sol_apli_basicos']['idUsuario']           = $idUsuario;          }else{$_SESSION['sol_apli_basicos']['idUsuario']           = '';}
				if(isset($idEstado)&&$idEstado!=''){                       $_SESSION['sol_apli_basicos']['idEstado']            = $idEstado;           }else{$_SESSION['sol_apli_basicos']['idEstado']            = '';}
				if(isset($f_creacion)&&$f_creacion!=''){                   $_SESSION['sol_apli_basicos']['f_creacion']          = $f_creacion;         }else{$_SESSION['sol_apli_basicos']['f_creacion']          = '';}
				if(isset($Observaciones)&&$Observaciones!=''){             $_SESSION['sol_apli_basicos']['Observaciones']       = $Observaciones;      }else{$_SESSION['sol_apli_basicos']['Observaciones']       = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){                 $_SESSION['sol_apli_basicos']['idPrioridad']         = $idPrioridad;        }else{$_SESSION['sol_apli_basicos']['idPrioridad']         = '';}
				if(isset($NSolicitud)&&$NSolicitud!=''){                   $_SESSION['sol_apli_basicos']['NSolicitud']          = $NSolicitud;         }else{$_SESSION['sol_apli_basicos']['NSolicitud']          = '';}

				//datos en blanco
				/*$_SESSION['sol_apli_basicos']['Mojamiento']          = 0;
				$_SESSION['sol_apli_basicos']['VelTractor']          = 0;
				$_SESSION['sol_apli_basicos']['VelViento']           = 0;
				$_SESSION['sol_apli_basicos']['TempMin']             = 0;
				$_SESSION['sol_apli_basicos']['TempMax']             = 0;
				$_SESSION['sol_apli_basicos']['HumTempMax']          = 0;
				$_SESSION['sol_apli_basicos']['Carencias']           = '';*/

				//Datos guardados
				$_SESSION['sol_apli_basicos']['Predio']              = $rowPredio['Predio'];
				$_SESSION['sol_apli_basicos']['Temporada']           = $rowTemporada['Codigo'].' '.$rowTemporada['Nombre'];
				$_SESSION['sol_apli_basicos']['EstadoFen']           = $rowEstadoFen['Codigo'].' '.$rowEstadoFen['Nombre'];
				$_SESSION['sol_apli_basicos']['Prioridad']           = $rowPrioridad['Nombre'];
				$_SESSION['sol_apli_basicos']['EspecieVariedad']     = '';
				if(isset($idCategoria)&&$idCategoria!=''){
					$_SESSION['sol_apli_basicos']['EspecieVariedad'] .= $rowEspecie['Nombre'];
				}
				if(isset($idProducto)&&$idProducto!=''){
					$_SESSION['sol_apli_basicos']['EspecieVariedad'] .= ' - '.$rowVariedad['Nombre'];
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'mod_base_tract':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//se actualizan datos de aplicacion
				$_SESSION['sol_apli_basicos']['Mojamiento']   = Cantidades_decimales_justos($Mojamiento);
				$_SESSION['sol_apli_basicos']['VelTractor']   = Cantidades_decimales_justos($VelTractor);
				$_SESSION['sol_apli_basicos']['VelViento']    = Cantidades_decimales_justos($VelViento);
				$_SESSION['sol_apli_basicos']['TempMin']      = Cantidades_decimales_justos($TempMin);
				$_SESSION['sol_apli_basicos']['TempMax']      = Cantidades_decimales_justos($TempMax);
				$_SESSION['sol_apli_basicos']['HumTempMax']   = Cantidades_decimales_justos($HumTempMax);

				//si existen cuarteles se actualizan sus datos internos
				if(isset($_SESSION['sol_apli_cuarteles'])&&$_SESSION['sol_apli_cuarteles']!=''){
					foreach ($_SESSION['sol_apli_cuarteles'] as $key => $cuartel){

						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['Mojamiento']  = $Mojamiento;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['VelTractor']  = $VelTractor;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['VelViento']   = $VelViento;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['TempMin']     = $TempMin;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['TempMax']     = $TempMax;
						$_SESSION['sol_apli_cuarteles'][$cuartel['valor_id']]['HumTempMax']  = $HumTempMax;

					}
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'addCuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			if(isset($idZona)){          $ndata_1 = count($idZona);          }else{$ndata_1 = 0;}
			if(isset($idVehiculo)){      $ndata_2 = count($idVehiculo);      }else{$ndata_2 = 0;}
			if(isset($idProducto)){      $ndata_3 = count($idProducto);      }else{$ndata_3 = 0;}
			if(isset($idMatSeguridad)){  $ndata_4 = count($idMatSeguridad);  }else{$ndata_4 = 0;}
			//generacion de errores
			if($ndata_1==0) {$error['ndata_1'] = 'error/No hay cuarteles agregados';}
			if($ndata_2==0) {$error['ndata_2'] = 'error/No hay tractores agregados';}
			if($ndata_3==0) {$error['ndata_3'] = 'error/No hay productos quimicos agregados';}
			if($ndata_4==0) {$error['ndata_4'] = 'error/No hay materiales de seguridad agregados';}
			/*******************************************************************/
			//Consulto
			/**********************************************/
			//Se trae un listado con los cuarteles
			if($ndata_1!=0) {
				$SIS_query = 'cross_predios_listado_zonas.idZona,
				cross_predios_listado_zonas.idCategoria,
				cross_predios_listado_zonas.idProducto,
				cross_predios_listado_zonas.Nombre AS Cuartel,
				sistema_variedades_categorias.Nombre AS Especie,
				variedades_listado.Nombre AS Variedad';
				$SIS_join  = '
				LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_predios_listado_zonas.idCategoria
				LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_predios_listado_zonas.idProducto';
				$SIS_where = 'cross_predios_listado_zonas.idPredio = '.$_SESSION['sol_apli_basicos']['idPredio'];
				$SIS_order = 'cross_predios_listado_zonas.Nombre ASC';
				$arrCuarteles = array();
				$arrCuarteles = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			if($ndata_2!=0) {
				//Se trae un listado con los vehiculos
				$arrVehiculos = array();
				$arrVehiculos = db_select_array (false, 'idVehiculo, Nombre', 'vehiculos_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los equipos de telemetria
				$arrTelemetria = array();
				$arrTelemetria = db_select_array (false, 'idTelemetria, Nombre', 'telemetria_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los trabajadores
				$arrTrabajadores = array();
				$arrTrabajadores = db_select_array (false, 'idTrabajador, Rut,Nombre,ApellidoPat', 'trabajadores_listado', '', 'idSistema ='.$_SESSION['sol_apli_basicos']['idSistema'].' AND idEstado=1', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			//Se trae un listado con los productos
			if($ndata_3!=0) {
				$SIS_query = 'productos_listado.idProducto,
				productos_listado.Nombre AS NombreProducto,
				productos_listado.DosisRecomendada,
				productos_listado.idUml,
				sistema_productos_uml.Nombre AS Unimed';
				$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml';
				$SIS_where = 'productos_listado.idEstado=1';
				$SIS_order = 'sistema_productos_uml.Nombre ASC';
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/**********************************************/
			//Se trae un listado con los materiales
			if($ndata_4!=0) {
				$arrMateriales = array();
				$arrMateriales = db_select_array (false, 'idMatSeguridad, Nombre,Codigo', 'cross_checking_materiales_seguridad', '', 'idEstado=1', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}
			/*******************************************************************/
			//verifico que no existan repetidos
			//Recorro los tractores
			$arrVehTemp = array();
			$arrTelTemp = array();
			//se recorren los tractores
			for($j2 = 0; $j2 < $ndata_2; $j2++){
				if(isset($arrVehTemp[$idVehiculo[$j2]]['idVehiculo'])&&$arrVehTemp[$idVehiculo[$j2]]['idVehiculo']==$idVehiculo[$j2]){
					$error['Vehiculos_'.$idVehiculo[$j2]] = 'error/Vehiculo repetido, seleccione otro';
				}else{
					$arrVehTemp[$idVehiculo[$j2]]['idVehiculo']  = $idVehiculo[$j2];
				}
				if(isset($arrTelTemp[$idTelemetria[$j2]]['idTelemetria'])&&$arrTelTemp[$idTelemetria[$j2]]['idTelemetria']==$idTelemetria[$j2]){
					$error['Telemetria_'.$idTelemetria[$j2]] = 'error/Equipo nebulizador repetido, seleccione otro';
				}else{
					$arrTelTemp[$idTelemetria[$j2]]['idTelemetria']  = $idTelemetria[$j2];
				}
			}

			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				/**********************************************/
				//Obtengo la ultima solicitud del predio
				$rowSolicitud = db_select_data (false, 'idSolicitud', 'cross_solicitud_aplicacion_listado', '', 'idEstado = 3 AND idPredio = '.$_SESSION['sol_apli_basicos']['idPredio'].' ORDER BY f_termino_fin DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//verifico si existe
				if(isset($rowSolicitud['idSolicitud'])&&$rowSolicitud['idSolicitud']!=''){
					//Consulto en base a esta
					$SIS_query = '
					cross_solicitud_aplicacion_listado_cuarteles.f_cierre,
					cross_solicitud_aplicacion_listado_cuarteles.idZona,
					cross_solicitud_aplicacion_listado_productos.idProducto,
					cross_predios_listado_zonas.Nombre AS Cuartel,
					productos_listado.EfectoRetroactivo,
					productos_listado.Nombre';
					$SIS_join  = '
					LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud  = cross_solicitud_aplicacion_listado.idSolicitud
					LEFT JOIN `cross_solicitud_aplicacion_listado_productos`   ON cross_solicitud_aplicacion_listado_productos.idCuarteles  = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
					LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                        = cross_solicitud_aplicacion_listado_cuarteles.idZona
					LEFT JOIN `productos_listado`                              ON productos_listado.idProducto                              = cross_solicitud_aplicacion_listado_productos.idProducto';
					$SIS_where = 'cross_solicitud_aplicacion_listado.idSolicitud='.$rowSolicitud['idSolicitud'].'
					AND productos_listado.EfectoRetroactivo!=0
					AND cross_solicitud_aplicacion_listado_cuarteles.f_cierre!="0000-00-00"
					AND cross_solicitud_aplicacion_listado_cuarteles.idEstado=2';
					$SIS_order = 0;
					$arrCarencias = array();
					$arrCarencias = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					$arrFinalCarencia = array();
					foreach ($arrCarencias as $prod) {
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Nombre']   = $prod['Nombre'];
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Cuartel']  = $prod['Cuartel'];
						$arrFinalCarencia[$prod['idZona']][$prod['idProducto']]['Fecha']    = sumarDias($prod['f_cierre'],cantidades($prod['EfectoRetroactivo'], 0));
					}
				}else{
					$arrFinalCarencia = array();
				}

				/**********************************************/
				//se listan los cuarteles
				$arrCuart = array();
				foreach ($arrCuarteles as $prod) {
					$arrCuart[$prod['idZona']]['Nombre']       = $prod['Cuartel'];
					$arrCuart[$prod['idZona']]['Especie']      = $prod['Especie'];
					$arrCuart[$prod['idZona']]['Variedad']     = $prod['Variedad'];
					$arrCuart[$prod['idZona']]['idCategoria']  = $prod['idCategoria'];
					$arrCuart[$prod['idZona']]['idProducto']   = $prod['idProducto'];
				}

				//se listan los vehiculos
				$arrVeh = array();
				foreach ($arrVehiculos as $prod) {
					$arrVeh[$prod['idVehiculo']]['Nombre']  = $prod['Nombre'];
				}

				//se listan los equipos de telemetria
				$arrTel = array();
				foreach ($arrTelemetria as $prod) {
					$arrTel[$prod['idTelemetria']]['Nombre']  = $prod['Nombre'];
				}

				//se listan los trabajadores
				$arrTrab = array();
				foreach ($arrTrabajadores as $prod) {
					$arrTrab[$prod['idTrabajador']]['Nombre']  = $prod['Rut'].' - '.$prod['Nombre'].' '.$prod['ApellidoPat'];
				}

				//se listan los productos quimicos
				$arrProd = array();
				foreach ($arrProductos as $prod) {
					$arrProd[$prod['idProducto']]['Nombre']            = $prod['NombreProducto'];
					$arrProd[$prod['idProducto']]['Unimed']            = $prod['Unimed'];
					$arrProd[$prod['idProducto']]['idUml']             = $prod['idUml'];
					$arrProd[$prod['idProducto']]['DosisRecomendada']  = $prod['DosisRecomendada'];
				}

				//se listan los materiales
				$arrMat = array();
				foreach ($arrMateriales as $prod) {
					$arrMat[$prod['idMatSeguridad']]['Nombre']            = $prod['Nombre'];
					$arrMat[$prod['idMatSeguridad']]['Codigo']            = $prod['Codigo'];
				}

				/*******************************************************************************/
				//se borran todos los cuarteles
				unset($_SESSION['sol_apli_cuarteles']);
				unset($_SESSION['sol_apli_productos']);
				unset($_SESSION['sol_apli_materiales']);
				unset($_SESSION['sol_apli_tractores']);
				unset($_SESSION['sol_apli_materiales']);

				//Guardo los datos de Parámetros de Aplicación
				$_SESSION['sol_apli_basicos']['Mojamiento']  = Cantidades_decimales_justos($Mojamiento);
				$_SESSION['sol_apli_basicos']['VelTractor']  = Cantidades_decimales_justos($VelTractor);
				$_SESSION['sol_apli_basicos']['VelViento']   = Cantidades_decimales_justos($VelViento);
				$_SESSION['sol_apli_basicos']['TempMin']     = Cantidades_decimales_justos($TempMin);
				$_SESSION['sol_apli_basicos']['TempMax']     = Cantidades_decimales_justos($TempMax);
				$_SESSION['sol_apli_basicos']['HumTempMax']  = Cantidades_decimales_justos($HumTempMax);

				//Recorro los cuarteles
				for($j1 = 0; $j1 < $ndata_1; $j1++){
					//variable interna
					$nmc1 = $j1 + 1;
					//Para mostrar en la creación
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idZona']          = $idZona[$j1];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['Mojamiento']      = Cantidades_decimales_justos($Mojamiento);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['VelTractor']      = Cantidades_decimales_justos($VelTractor);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['VelViento']       = Cantidades_decimales_justos($VelViento);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['TempMin']         = Cantidades_decimales_justos($TempMin);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['TempMax']         = Cantidades_decimales_justos($TempMax);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['HumTempMax']      = Cantidades_decimales_justos($HumTempMax);
					$_SESSION['sol_apli_cuarteles'][$nmc1]['valor_id']        = $nmc1;
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelNombre']   = $arrCuart[$idZona[$j1]]['Nombre'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelEspecie']  = $arrCuart[$idZona[$j1]]['Especie'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['CuartelVariedad'] = $arrCuart[$idZona[$j1]]['Variedad'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idCategoria']     = $arrCuart[$idZona[$j1]]['idCategoria'];
					$_SESSION['sol_apli_cuarteles'][$nmc1]['idProducto']      = $arrCuart[$idZona[$j1]]['idProducto'];

					//Recorro los tractores
					for($j2 = 0; $j2 < $ndata_2; $j2++){
						//variable interna
						$nmc2 = $j2 + 1;
						//Para mostrar en la creación
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idVehiculo']    = $idVehiculo[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idTelemetria']  = $idTelemetria[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['idTrabajador']  = $idTrabajador[$j2];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['valor_id']      = $nmc2;
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Vehiculo']      = $arrVeh[$idVehiculo[$j2]]['Nombre'];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Telemetria']    = $arrTel[$idTelemetria[$j2]]['Nombre'];
						$_SESSION['sol_apli_tractores'][$nmc1][$nmc2]['Trabajador']    = $arrTrab[$idTrabajador[$j2]]['Nombre'];

					}

					//Recorro los productos
					for($j3 = 0; $j3 < $ndata_3; $j3++){
						//variable interna
						$nmc3 = $j3 + 1;
						//Para mostrar en la creación
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['idProducto']        = $idProducto[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['DosisAplicar']      = $DosisAplicar[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Objetivo']          = $Objetivo[$j3];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['valor_id']          = $nmc3;
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Producto']          = $arrProd[$idProducto[$j3]]['Nombre'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['DosisRecomendada']  = $arrProd[$idProducto[$j3]]['DosisRecomendada'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['Unimed']            = $arrProd[$idProducto[$j3]]['Unimed'];
						$_SESSION['sol_apli_productos'][$nmc1][$nmc3]['idUml']             = $arrProd[$idProducto[$j3]]['idUml'];

						/***********************************************/
						//Comparo los productos y las fechas
						if(isset($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Nombre'])){
							if($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Fecha']>$_SESSION['sol_apli_basicos']['f_programacion']){
								$_SESSION['sol_apli_basicos']['Carencias'] .= 'El Producto '.$arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Nombre'].' del cuartel '.$arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Cuartel'].' aun tiene un tiempo de reingreso por cumplir, este expira el '.fecha_estandar($arrFinalCarencia[$idZona[$j1]][$idProducto[$j3]]['Fecha']).'.<br/>';
							}
						}

					}
				}
				//Recorro los materiales
				for($j4 = 0; $j4 < $ndata_4; $j4++){
					//variable interna
					$nmc4 = $j4 + 1;
					//Para mostrar en la creación
					$_SESSION['sol_apli_materiales'][$nmc4]['idMatSeguridad']  = $idMatSeguridad[$j4];
					$_SESSION['sol_apli_materiales'][$nmc4]['Nombre']          = $arrMat[$idMatSeguridad[$j4]]['Nombre'];
					$_SESSION['sol_apli_materiales'][$nmc4]['Codigo']          = $arrMat[$idMatSeguridad[$j4]]['Codigo'];
					$_SESSION['sol_apli_materiales'][$nmc4]['valor_id']        = $nmc4;
				}

				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'editCuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/**********************************************/
				//Se traen los datos de la zona
				$SIS_query = '
				cross_predios_listado_zonas.idZona,
				cross_predios_listado_zonas.idCategoria,
				cross_predios_listado_zonas.idProducto,
				cross_predios_listado_zonas.Nombre AS Cuartel,
				sistema_variedades_categorias.Nombre AS Especie,
				variedades_listado.Nombre AS Variedad
				';
				$SIS_join = '
				LEFT JOIN `sistema_variedades_categorias`  ON sistema_variedades_categorias.idCategoria  = cross_predios_listado_zonas.idCategoria
				LEFT JOIN `variedades_listado`             ON variedades_listado.idProducto              = cross_predios_listado_zonas.idProducto
				';
				//Se traen los datos de la zona
				$rowCuart = db_select_data (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, 'cross_predios_listado_zonas.idZona = "'.$idZona.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/***************************************************/
				//Para mostrar en la creación
				$_SESSION['sol_apli_cuarteles'][$idInterno]['idZona']           = $idZona;
				$_SESSION['sol_apli_cuarteles'][$idInterno]['CuartelNombre']    = $rowCuart['Cuartel'];
				$_SESSION['sol_apli_cuarteles'][$idInterno]['CuartelEspecie']   = $rowCuart['Especie'];
				$_SESSION['sol_apli_cuarteles'][$idInterno]['CuartelVariedad']  = $rowCuart['Variedad'];
				$_SESSION['sol_apli_cuarteles'][$idInterno]['idCategoria']      = $rowCuart['idCategoria'];
				$_SESSION['sol_apli_cuarteles'][$idInterno]['idProducto']       = $rowCuart['idProducto'];

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_Cuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['sol_apli_cuarteles'][$_GET['del_Cuartel']]);
			unset($_SESSION['sol_apli_tractores'][$_GET['del_Cuartel']]);
			unset($_SESSION['sol_apli_productos'][$_GET['del_Cuartel']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addmaterial':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/************************************************************/
			//se establece variable inicial
			$idInterno = 0;

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['sol_apli_materiales'])){
				foreach ($_SESSION['sol_apli_materiales'] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''){
						$idInterno = $trabajos['valor_id'] + 1;
						//verifico si tractor existe
						if($trabajos['idMatSeguridad']==$idMatSeguridad){
							$error['ndata_1'] = 'error/El Material que esta agregando ya ha sido agregado';
						}
					}
				}
			}

			if(empty($error)){

				/**********************************************/
				//Se traen los datos de la zona
				$rowMaterial = db_select_data (false, 'Nombre,Codigo', 'cross_checking_materiales_seguridad', '', 'idMatSeguridad = "'.$idMatSeguridad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Para mostrar en la creación
				$_SESSION['sol_apli_materiales'][$idInterno]['idMatSeguridad']  = $idMatSeguridad;
				$_SESSION['sol_apli_materiales'][$idInterno]['Nombre']          = $rowMaterial['Nombre'];
				$_SESSION['sol_apli_materiales'][$idInterno]['Codigo']          = $rowMaterial['Codigo'];
				$_SESSION['sol_apli_materiales'][$idInterno]['valor_id']        = $idInterno;

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_material':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['sol_apli_materiales'][$_GET['del_material']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addtractor':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/************************************************************/
			//se establece variable inicial
			$idInterno2 = 0;

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['sol_apli_tractores'][$idInterno])){
				foreach ($_SESSION['sol_apli_tractores'][$idInterno] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''){
						$idInterno2 = $trabajos['valor_id'];
						//verifico si tractor existe
						if($trabajos['idVehiculo']==$idVehiculo){
							$error['ndata_1'] = 'error/El tractor que esta agregando ya ha sido agregado';
						}
						if($trabajos['idTelemetria']==$idTelemetria){
							$error['ndata_1'] = 'error/El equipo de aplicacion que esta agregando ya ha sido agregado';
						}
					}
				}
			}

			if(empty($error)){

				/**********************************************/
				//Se trae un listado con los productos
				$rowVehiculos = db_select_data (false, 'Nombre', 'vehiculos_listado', '', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los productos
				$rowTelemetria = db_select_data (false, 'Nombre', 'telemetria_listado', '', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los productos
				$rowTrabajadores = db_select_data (false, 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				$idInterno2 = $idInterno2+1;
				//Para mostrar en la creación
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idVehiculo']    = $idVehiculo;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idTelemetria']  = $idTelemetria;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idTrabajador']  = $idTrabajador;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['valor_id']      = $idInterno2;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Vehiculo']      = $rowVehiculos['Nombre'];
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Telemetria']    = $rowTelemetria['Nombre'];
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Trabajador']    = $rowTrabajadores['Rut'].' - '.$rowTrabajadores['Nombre'].' '.$rowTrabajadores['ApellidoPat'];

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edittractor':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el dato ya existe
			if(isset($_SESSION['sol_apli_tractores'][$idInterno])){
				foreach ($_SESSION['sol_apli_tractores'][$idInterno] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''&&$trabajos['valor_id']!=$idInterno2){
						//verifico si tractor existe
						if($trabajos['idVehiculo']==$idVehiculo){
							$error['ndata_1'] = 'error/El tractor que esta agregando ya ha sido agregado';
						}
						if($trabajos['idTelemetria']==$idTelemetria){
							$error['ndata_1'] = 'error/El equipo de aplicacion que esta agregando ya ha sido agregado';
						}
					}
				}
			}

			if(empty($error)){

				/**********************************************/
				//Se trae un listado con los productos
				$rowVehiculos = db_select_data (false, 'Nombre', 'vehiculos_listado', '', 'idVehiculo = "'.$idVehiculo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los productos
				$rowTelemetria = db_select_data (false, 'Nombre', 'telemetria_listado', '', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Se trae un listado con los productos
				$rowTrabajadores = db_select_data (false, 'Rut,Nombre,ApellidoPat', 'trabajadores_listado', '', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Para mostrar en la creación
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idVehiculo']    = $idVehiculo;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idTelemetria']  = $idTelemetria;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['idTrabajador']  = $idTrabajador;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['valor_id']      = $idInterno2;
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Vehiculo']      = $rowVehiculos['Nombre'];
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Telemetria']    = $rowTelemetria['Nombre'];
				$_SESSION['sol_apli_tractores'][$idInterno][$idInterno2]['Trabajador']    = $rowTrabajadores['Rut'].' - '.$rowTrabajadores['Nombre'].' '.$rowTrabajadores['ApellidoPat'];

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_trac':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['sol_apli_tractores'][$_GET['cuartel_id']][$_GET['del_trac']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'addproducto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/************************************************************/
			//se establece variable inicial
			$idInterno3 = 0;

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['sol_apli_productos'][$idInterno])){
				foreach ($_SESSION['sol_apli_productos'][$idInterno] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''){
						$idInterno3 = $trabajos['valor_id'];
						//verifico si tractor existe
						if($trabajos['idProducto']==$idProducto){
							$error['ndata_1'] = 'error/El producto quimico que esta agregando ya ha sido agregado';
						}
					}
				}
			}

			if(empty($error)){

				/**********************************************/
				//Se trae un listado con los productos
				$SIS_query = '
				productos_listado.Nombre AS NombreProducto,
				productos_listado.DosisRecomendada,
				productos_listado.idUml,
				sistema_productos_uml.Nombre AS Unimed
				';
				$SIS_join = '
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml
				';
				//Se trae un listado con los productos
				$rowProductos = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, 'productos_listado.idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				$idInterno3 = $idInterno3+1;
				//Para mostrar en la creación
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['idProducto']        = $idProducto;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['DosisAplicar']      = $DosisAplicar;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Objetivo']          = $Objetivo;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['valor_id']          = $idInterno3;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Producto']          = $rowProductos['NombreProducto'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['DosisRecomendada']  = $rowProductos['DosisRecomendada'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Unimed']            = $rowProductos['Unimed'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['idUml']             = $rowProductos['idUml'];

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'editproducto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['sol_apli_productos'][$idInterno])){
				foreach ($_SESSION['sol_apli_productos'][$idInterno] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''&&$trabajos['valor_id']!=$idInterno3){
						//verifico si tractor existe
						if($trabajos['idProducto']==$idProducto){
							$error['ndata_1'] = 'error/El producto quimico que esta agregando ya ha sido agregado';
						}
					}
				}
			}

			if(empty($error)){

				/**********************************************/
				//Se trae un listado con los productos
				$SIS_query = '
				productos_listado.Nombre AS NombreProducto,
				productos_listado.DosisRecomendada,
				productos_listado.idUml,
				sistema_productos_uml.Nombre AS Unimed
				';
				$SIS_join = '
				LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml
				';
				//Se trae un listado con los productos
				$rowProductos = db_select_data (false, $SIS_query, 'productos_listado', $SIS_join, 'productos_listado.idProducto = "'.$idProducto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/**********************************************/
				//Para mostrar en la creación
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['idProducto']        = $idProducto;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['DosisAplicar']      = $DosisAplicar;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Objetivo']          = $Objetivo;
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Producto']          = $rowProductos['NombreProducto'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['DosisRecomendada']  = $rowProductos['DosisRecomendada'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['Unimed']            = $rowProductos['Unimed'];
				$_SESSION['sol_apli_productos'][$idInterno][$idInterno3]['idUml']             = $rowProductos['idUml'];

				/************************************************************/
				//se redirije
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['sol_apli_productos'][$_GET['cuartel_id']][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'crear_solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//variables
			$n_cuarteles  = 0;
			$n_tractores  = 0;
			$n_productos  = 0;
			$n_materiales = 0;

			//Se verifican los datos basicos
			if (isset($_SESSION['sol_apli_basicos'])){
				if(!isset($_SESSION['sol_apli_basicos']['idPredio']) OR $_SESSION['sol_apli_basicos']['idPredio']=='' ){                       $error['idPredio']             = 'error/No ha seleccionado el predio';}
				if(!isset($_SESSION['sol_apli_basicos']['idTemporada']) OR $_SESSION['sol_apli_basicos']['idTemporada']=='' ){                 $error['idTemporada']          = 'error/No ha seleccionado la temporada';}
				if(!isset($_SESSION['sol_apli_basicos']['idEstadoFen']) OR $_SESSION['sol_apli_basicos']['idEstadoFen']=='' ){                 $error['idEstadoFen']          = 'error/No ha seleccionado el estado fenologico';}
				//if(!isset($_SESSION['sol_apli_basicos']['idCategoria']) OR $_SESSION['sol_apli_basicos']['idCategoria']=='' ){                 $error['idCategoria']          = 'error/No ha seleccionado la especie';}
				//if(!isset($_SESSION['sol_apli_basicos']['idProducto']) OR $_SESSION['sol_apli_basicos']['idProducto']=='' ){                   $error['idProducto']           = 'error/No ha seleccionado la variedad';}
				if(!isset($_SESSION['sol_apli_basicos']['f_programacion']) OR $_SESSION['sol_apli_basicos']['f_programacion']=='' ){           $error['f_programacion']       = 'error/No ha ingresado la Fecha inicio programación';}
				if(!isset($_SESSION['sol_apli_basicos']['f_programacion_fin']) OR $_SESSION['sol_apli_basicos']['f_programacion_fin']=='' ){   $error['f_programacion_fin']   = 'error/No ha ingresado la Fecha termino programación';}
				if(!isset($_SESSION['sol_apli_basicos']['idSistema']) OR $_SESSION['sol_apli_basicos']['idSistema']=='' ){                     $error['idSistema']            = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['sol_apli_basicos']['idUsuario']) OR $_SESSION['sol_apli_basicos']['idUsuario']=='' ){                     $error['idUsuario']            = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['sol_apli_basicos']['idEstado']) OR $_SESSION['sol_apli_basicos']['idEstado']=='' ){                       $error['idEstado']             = 'error/No ha seleccionado el estado';}
				if(!isset($_SESSION['sol_apli_basicos']['f_creacion']) OR $_SESSION['sol_apli_basicos']['f_creacion']=='' ){                   $error['f_creacion']           = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['sol_apli_basicos']['Observaciones']) OR $_SESSION['sol_apli_basicos']['Observaciones']=='' ){             $error['Observaciones']        = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['sol_apli_basicos']['horaProg']) OR $_SESSION['sol_apli_basicos']['horaProg']=='' ){                       $error['horaProg']             = 'error/No ha ingresado la hora inicio programada';}
				if(!isset($_SESSION['sol_apli_basicos']['horaProg_fin']) OR $_SESSION['sol_apli_basicos']['horaProg_fin']=='' ){               $error['horaProg_fin']         = 'error/No ha ingresado la hora termino programada';}
				if(!isset($_SESSION['sol_apli_basicos']['idPrioridad']) OR $_SESSION['sol_apli_basicos']['idPrioridad']=='' ){                 $error['idPrioridad']          = 'error/No ha seleccionado la prioridad';}

			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la solicitud';
			}
			//se verifica la existencia de cuarteles
			if(isset($_SESSION['sol_apli_cuarteles'])&&$_SESSION['sol_apli_cuarteles']!=''){
				foreach ($_SESSION['sol_apli_cuarteles'] as $key => $cuartel){
					//sumo los cuarteles
					$n_cuarteles++;
					if($_SESSION['sol_apli_tractores'][$cuartel['valor_id']]){
						//Se recorren los tractores
						foreach ($_SESSION['sol_apli_tractores'][$cuartel['valor_id']] as $key => $tract){
							//se verifican que existan todos los datos del tractor
							if(!isset($_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idVehiculo']) OR $_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idVehiculo']=='' ){         $error['idVehiculo']    = 'error/No ha seleccionado el tractor';}
							if(!isset($_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idTelemetria']) OR $_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idTelemetria']=='' ){     $error['idTelemetria']  = 'error/No ha seleccionado el Equipo Aplicación';}
							if(!isset($_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idTrabajador']) OR $_SESSION['sol_apli_tractores'][$cuartel['valor_id']][$tract['valor_id']]['idTrabajador']=='' ){     $error['idTrabajador']  = 'error/No ha seleccionado el Trabajador';}
							//suma
							$n_tractores++;
						}
					}
					if($_SESSION['sol_apli_productos'][$cuartel['valor_id']]){
						//Se recorren los quimicos a utilizar
						foreach ($_SESSION['sol_apli_productos'][$cuartel['valor_id']] as $key => $prod){
							$n_productos++;
						}
					}
				}
			}
			//se verifica la existencia de materiales de seguridad
			if(isset($_SESSION['sol_apli_materiales'])&&$_SESSION['sol_apli_materiales']!=''){
				foreach ($_SESSION['sol_apli_materiales'] as $key => $cuartel){
					//sumo los cuarteles
					$n_materiales++;
				}
			}

			//Se verifican los cuarteles
			if(isset($n_cuarteles)&&$n_cuarteles==0){
				$error['cuarteles'] = 'error/No tiene cuarteles asignados a la solicitud';
			}
			//Se verifican los tractores
			if(isset($n_tractores)&&$n_tractores==0){
				$error['trabajos'] = 'error/No tiene tractores asignados a la solicitud';
			}
			//Se verifican los productos
			if(isset($n_productos)&&$n_productos==0){
				$error['trabajos'] = 'error/No tiene productos asignados a la solicitud';
			}
			//Se verifican los productos
			if(isset($n_materiales)&&$n_materiales==0){
				$error['trabajos'] = 'error/No tiene materiales de seguridad asignados a la solicitud';
			}

			/******************************************/
			//Consulto el ultimo NSolicitud
			/*$rowNInforme = db_select_data (false, 'NSolicitud', 'cross_solicitud_aplicacion_listado', '', 'idSistema = '.$_SESSION['sol_apli_basicos']['idSistema'].' ORDER BY NSolicitud DESC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Verifico la existencia
			if(isset($rowNInforme['NSolicitud'])&&$rowNInforme['NSolicitud']!=''){
				$_SESSION['sol_apli_basicos']['NSolicitud'] = $rowNInforme['NSolicitud'] + 1;
			}else{
				$_SESSION['sol_apli_basicos']['NSolicitud'] = 1;
			}*/

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/**********************************************/
				//Se guardan los datos basicos
				if(isset($_SESSION['sol_apli_basicos']['idSistema']) && $_SESSION['sol_apli_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['sol_apli_basicos']['idSistema']."'";        }else{$SIS_data  = "''";}
				if(isset($_SESSION['sol_apli_basicos']['idPredio']) && $_SESSION['sol_apli_basicos']['idPredio']!=''){       $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idPredio']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idUsuario']) && $_SESSION['sol_apli_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idEstado']) && $_SESSION['sol_apli_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idTemporada']) && $_SESSION['sol_apli_basicos']['idTemporada']!=''){ $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idTemporada']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idEstadoFen']) && $_SESSION['sol_apli_basicos']['idEstadoFen']!=''){ $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idEstadoFen']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idCategoria']) && $_SESSION['sol_apli_basicos']['idCategoria']!=''){ $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idCategoria']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idProducto']) && $_SESSION['sol_apli_basicos']['idProducto']!=''){   $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idProducto']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['f_creacion']) && $_SESSION['sol_apli_basicos']['f_creacion']!=''){   $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['f_programacion']) && $_SESSION['sol_apli_basicos']['f_programacion']!=''){
					$SIS_data .= ",'".$_SESSION['sol_apli_basicos']['f_programacion']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['sol_apli_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['sol_apli_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['sol_apli_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['sol_apli_basicos']['f_programacion'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['sol_apli_basicos']['f_programacion_fin']) && $_SESSION['sol_apli_basicos']['f_programacion_fin']!=''){
					$SIS_data .= ",'".$_SESSION['sol_apli_basicos']['f_programacion_fin']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['sol_apli_basicos']['f_programacion_fin'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['sol_apli_basicos']['f_programacion_fin'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['sol_apli_basicos']['f_programacion_fin'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['sol_apli_basicos']['f_programacion_fin'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['sol_apli_basicos']['horaProg']) && $_SESSION['sol_apli_basicos']['horaProg']!=''){             $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['horaProg']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['horaProg_fin']) && $_SESSION['sol_apli_basicos']['horaProg_fin']!=''){     $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['horaProg_fin']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['Mojamiento']) && $_SESSION['sol_apli_basicos']['Mojamiento']!=''){         $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['Mojamiento']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['VelTractor']) && $_SESSION['sol_apli_basicos']['VelTractor']!=''){         $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['VelTractor']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['VelViento']) && $_SESSION['sol_apli_basicos']['VelViento']!=''){           $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['VelViento']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['TempMin']) && $_SESSION['sol_apli_basicos']['TempMin']!=''){               $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['TempMin']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['TempMax']) && $_SESSION['sol_apli_basicos']['TempMax']!=''){               $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['TempMax']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['HumTempMax']) && $_SESSION['sol_apli_basicos']['HumTempMax']!=''){         $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['HumTempMax']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['idPrioridad']) && $_SESSION['sol_apli_basicos']['idPrioridad']!=''){       $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idPrioridad']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['sol_apli_basicos']['NSolicitud']) && $_SESSION['sol_apli_basicos']['NSolicitud']!=''){         $SIS_data .= ",'".$_SESSION['sol_apli_basicos']['NSolicitud']."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idPredio, idUsuario, idEstado, idTemporada,
				idEstadoFen, idCategoria, idProducto, f_creacion, f_programacion, progDia, progSemana, progMes, progAno, f_programacion_fin,
				progDia_fin, progSemana_fin, progMes_fin, progAno_fin, horaProg, horaProg_fin, Mojamiento, VelTractor, VelViento, TempMin,
				TempMax, HumTempMax, idPrioridad, NSolicitud';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Solo si se ejecuto correctamente
					if(isset($ultimo_id)&&$ultimo_id!=''){
						/*********************************************************************/
						//Observacion
						$XObs  = 'Creacion del documento.';
						$XObs .= '<br/>'.$_SESSION['sol_apli_basicos']['Observaciones'].'.';
						//si hay carencias
						if(isset($_SESSION['sol_apli_basicos']['Carencias'])&&$_SESSION['sol_apli_basicos']['Carencias']!=''){
							$XObs .= '<br/><strong>Se registran los siguientes casos:</strong><br/>';
							$XObs .= '-'.$_SESSION['sol_apli_basicos']['Carencias'];
						}

						/************************************************************/
						//Se guarda en historial la accion
						if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
						if(isset($_SESSION['sol_apli_basicos']['f_creacion']) && $_SESSION['sol_apli_basicos']['f_creacion']!=''){
							$SIS_data .= ",'".$_SESSION['sol_apli_basicos']['f_creacion']."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'".$XObs."'";                                             //Observacion
						$SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idUsuario']."'";        //idUsuario
						$SIS_data .= ",'".$_SESSION['sol_apli_basicos']['idEstado']."'";         //Guardo el estado

						// inserto los datos de registro en la db
						$SIS_columns = 'idSolicitud, Creacion_fecha, Observacion, idUsuario, idEstado';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//se guardan los materiales
						if(isset($_SESSION['sol_apli_materiales'])&&$_SESSION['sol_apli_materiales']!=''){

							/*******************************************/
							//se recorren los materiales
							foreach ($_SESSION['sol_apli_materiales'] as $key => $mat){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                           $SIS_data  = "'".$ultimo_id."'";                }else{$SIS_data  = "''";}
								if(isset($mat['idMatSeguridad']) && $mat['idMatSeguridad']!=''){   $SIS_data .= ",'".$mat['idMatSeguridad']."'";   }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSolicitud, idMatSeguridad';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_materiales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}

						/*********************************************************************/
						//se guardan los cuarteles
						if(isset($_SESSION['sol_apli_cuarteles'])&&$_SESSION['sol_apli_cuarteles']!=''){

							/*******************************************/
							//se recorren los cuarteles
							foreach ($_SESSION['sol_apli_cuarteles'] as $key => $cuartel){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                             $SIS_data = "'".$ultimo_id."'";                  }else{$SIS_data  = "''";}
								if(isset($cuartel['idZona']) && $cuartel['idZona']!=''){             $SIS_data .= ",'".$cuartel['idZona']."'";        }else{$SIS_data .= ",''";}
								if(isset($cuartel['Mojamiento']) && $cuartel['Mojamiento']!=''){     $SIS_data .= ",'".$cuartel['Mojamiento']."'";    }else{$SIS_data .= ",''";}
								if(isset($cuartel['VelTractor']) && $cuartel['VelTractor']!=''){     $SIS_data .= ",'".$cuartel['VelTractor']."'";    }else{$SIS_data .= ",''";}
								if(isset($cuartel['VelViento']) && $cuartel['VelViento']!=''){       $SIS_data .= ",'".$cuartel['VelViento']."'";     }else{$SIS_data .= ",''";}
								if(isset($cuartel['TempMin']) && $cuartel['TempMin']!=''){           $SIS_data .= ",'".$cuartel['TempMin']."'";       }else{$SIS_data .= ",''";}
								if(isset($cuartel['TempMax']) && $cuartel['TempMax']!=''){           $SIS_data .= ",'".$cuartel['TempMax']."'";       }else{$SIS_data .= ",''";}
								if(isset($cuartel['HumTempMax']) && $cuartel['HumTempMax']!=''){     $SIS_data .= ",'".$cuartel['HumTempMax']."'";    }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'"; //se asigna el estado
								if(isset($cuartel['idCategoria']) && $cuartel['idCategoria']!=''){   $SIS_data .= ",'".$cuartel['idCategoria']."'";   }else{$SIS_data .= ",''";}
								if(isset($cuartel['idProducto']) && $cuartel['idProducto']!=''){     $SIS_data .= ",'".$cuartel['idProducto']."'";    }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSolicitud, idZona, Mojamiento, VelTractor, VelViento, TempMin, TempMax, HumTempMax, idEstado, idCategoria, idProducto';
								$ultimo_cuartel = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Si ejecuto correctamente la consulta
								if($ultimo_cuartel!=0){
									/*******************************************/
									//se recorren los tractores
									if($_SESSION['sol_apli_tractores'][$cuartel['valor_id']]){
										//Se recorren los tractores
										foreach ($_SESSION['sol_apli_tractores'][$cuartel['valor_id']] as $key => $tract){
											//filtros
											if(isset($ultimo_id) && $ultimo_id!=''){                          $SIS_data = "'".$ultimo_id."'";                 }else{$SIS_data  = "''";}
											if(isset($ultimo_cuartel) && $ultimo_cuartel!=''){                $SIS_data .= ",'".$ultimo_cuartel."'";          }else{$SIS_data .= ",''";}
											if(isset($tract['idTelemetria']) && $tract['idTelemetria']!=''){  $SIS_data .= ",'".$tract['idTelemetria']."'";   }else{$SIS_data .= ",''";}
											if(isset($tract['idVehiculo']) && $tract['idVehiculo']!=''){      $SIS_data .= ",'".$tract['idVehiculo']."'";     }else{$SIS_data .= ",''";}
											if(isset($tract['idTrabajador']) && $tract['idTrabajador']!=''){  $SIS_data .= ",'".$tract['idTrabajador']."'";   }else{$SIS_data .= ",''";}

											// inserto los datos de registro en la db
											$SIS_columns = 'idSolicitud, idCuarteles, idTelemetria, idVehiculo, idTrabajador';
											$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}
									}
									/*******************************************/
									//se recorren los cuarteles
									if($_SESSION['sol_apli_productos'][$cuartel['valor_id']]){
										//Se recorren los quimicos a utilizar
										foreach ($_SESSION['sol_apli_productos'][$cuartel['valor_id']] as $key => $prod){

											//filtros
											if(isset($ultimo_id) && $ultimo_id!=''){                                $SIS_data  = "'".$ultimo_id."'";                   }else{$SIS_data  = "''";}
											if(isset($ultimo_cuartel) && $ultimo_cuartel!=''){                      $SIS_data .= ",'".$ultimo_cuartel."'";             }else{$SIS_data .= ",''";}
											if(isset($prod['idProducto']) && $prod['idProducto']!=''){              $SIS_data .= ",'".$prod['idProducto']."'";         }else{$SIS_data .= ",''";}
											if(isset($prod['DosisRecomendada']) && $prod['DosisRecomendada']!=''){  $SIS_data .= ",'".$prod['DosisRecomendada']."'";   }else{$SIS_data .= ",''";}
											if(isset($prod['DosisAplicar']) && $prod['DosisAplicar']!=''){          $SIS_data .= ",'".$prod['DosisAplicar']."'";       }else{$SIS_data .= ",''";}
											if(isset($prod['idUml']) && $prod['idUml']!=''){                        $SIS_data .= ",'".$prod['idUml']."'";              }else{$SIS_data .= ",''";}
											if(isset($prod['Objetivo']) && $prod['Objetivo']!=''){                  $SIS_data .= ",'".$prod['Objetivo']."'";           }else{$SIS_data .= ",''";}

											// inserto los datos de registro en la db
											$SIS_columns = 'idSolicitud, idCuarteles, idProducto, DosisRecomendada, DosisAplicar, idUml, Objetivo';
											$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}
									}
								}
							}
						}

						/******************************************/
						//En base al estado se hacen las consultas
						$transaccion = 'cross_solicitud_aplicacion_ejecutar.php';
						$xbody = '
						<h3>Se ha creado la solicitud N° '.n_doc($_SESSION['sol_apli_basicos']['NSolicitud'], 5).'</h3>
						<p>Se ha cambiado el estado a Programado en la siguiente solicitud</p>
						<a href="'.DB_SITE_MAIN.'/view_solicitud_aplicacion.php?view='.simpleEncode($ultimo_id, fecha_actual()).'">Ver Aqui</a>';

						//Permisos a las transacciones
						$SIS_query = '
						usuarios_listado.usuario AS UsuarioNick,
						usuarios_listado.email AS UsuarioEmail,
						usuarios_listado.Nombre AS UsuarioNombre,
						core_sistemas.email_principal AS EmpresaCorreo,
						core_sistemas.Nombre AS EmpresaNombre,
						core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
						core_sistemas.Config_Gmail_Password AS Gmail_Password';
						$SIS_join  = '
						INNER JOIN `usuarios_permisos`  ON usuarios_permisos.idAdmpm    = core_permisos_listado.idAdmpm
						LEFT JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = usuarios_permisos.idUsuario
						INNER JOIN `usuarios_sistemas`  ON usuarios_sistemas.idUsuario  = usuarios_listado.idUsuario
						LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema      = usuarios_sistemas.idSistema';
						$SIS_where = 'core_permisos_listado.Direccionbase="'.$transaccion.'"
						AND usuarios_sistemas.idSistema = "'.$_SESSION['sol_apli_basicos']['idSistema'].'"';
						$SIS_order = 0;
						$arrCorreos = array();
						$arrCorreos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Notificaciones a los correos
						foreach ($arrCorreos as $correo) {
							//Envio de correo
							$rmail = tareas_envio_correo($correo['EmpresaCorreo'], $correo['EmpresaNombre'],
														 $correo['UsuarioEmail'], $correo['UsuarioNombre'],
														 '', '',
														 'Notificación creación de Consolidacion',
														 $xbody,'',
														 '',
														 1,
														 $correo['Gmail_Usuario'],
														 $correo['Gmail_Password']);
							//se guarda el log
							log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Notificación creación de Consolidacion)');
						}

						/*****************************************************/
						//Borro todas las sesiones una vez grabados los datos
						unset($_SESSION['sol_apli_basicos']);
						unset($_SESSION['sol_apli_cuarteles']);
						unset($_SESSION['sol_apli_tractores']);
						unset($_SESSION['sol_apli_productos']);
						unset($_SESSION['sol_apli_materiales']);

						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_Solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Solicitud']) OR !validaEntero($_GET['del_Solicitud']))&&$_GET['del_Solicitud']!=''){
				$indice = simpleDecode($_GET['del_Solicitud'], fecha_actual());
			}else{
				$indice = $_GET['del_Solicitud'];
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
				//variables
				$ndata_1 = 0;

					/*******************************************************************/
				//se verifica si existen cuarteles cerrados
				if(isset($indice)){
					$ndata_1 = db_select_nrows (false, 'idCuarteles', 'cross_solicitud_aplicacion_listado_cuarteles', '', "idSolicitud='".$indice."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				//generacion de errores
				if($ndata_1 > 0) {$error['ndata_1'] = 'error/Hay '.$ndata_1.' cuarteles con cierre realizado, no puede eliminar la solicitud';}

				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					//se borran los datos
					$resultado_1 = db_delete_data (false, 'cross_solicitud_aplicacion_listado', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_cuarteles', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_productos', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_4 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_tractores', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_5 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_materiales', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true OR $resultado_5==true){

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}
				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'updt_mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//si se esta cerrando la solicitud, verificar que todos los cuarteles esten cerrados
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idSolicitud)&&isset($idEstado)&&$idEstado==3){
				$ndata_1 = db_select_nrows (false, 'idCuarteles', 'cross_solicitud_aplicacion_listado_cuarteles', '', "idSolicitud='".$idSolicitud."' AND idEstado!='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Aun existen '.$ndata_1.' cuarteles con cierre pendiente';}
			/*******************************************************************/
			//Se verifica concordancia fecha y hora
			if(isset($f_ejecucion)&&$f_ejecucion!='0000-00-00'&&isset($f_termino)&&$f_termino!='0000-00-00'&&$f_ejecucion==$f_termino){
				if(isset($horaEjecucion)&&$horaEjecucion!='0000-00-00'&&isset($horaTermino)&&$horaTermino!='0000-00-00'&&$horaEjecucion>$horaTermino){
					$error['ejecucion'] = 'error/La hora de ejecucion es superior a la hora de termino';
				}
			}
			/*******************************************************************/
			//Se verifica que no existan cuarteles ya cerrados en caso de cancelar ejecucion
			if(isset($idEstado)&&$idEstado==1&&isset($idEstadoActual)&&$idEstadoActual==2){
				if(isset($idSolicitud)){
					$ndata_2 = db_select_nrows (false, 'idCuarteles', 'cross_solicitud_aplicacion_listado_cuarteles', '', "idSolicitud='".$idSolicitud."' AND idEstado='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}
				//generacion de errores
				if($ndata_2 > 0) {$error['ndata_2'] = 'error/Hay '.$ndata_2.' cuarteles con cierre realizado, no puede cancelar la ejecucion';}
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				$rowData = db_select_data (false, 'idProducto', 'cross_solicitud_aplicacion_listado', '', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//si cambia la variedad se resetea todo
				if(isset($rowData['idProducto'], $idProducto)&&$rowData['idProducto']!=$idProducto){
					//se borran los datos
					$resultado_1 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_cuarteles', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_productos', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_tractores', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				}

				//Filtros
				$SIS_data = "idSolicitud='".$idSolicitud."'";
				if(isset($idSistema) && $idSistema!=''){                     $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idPredio) && $idPredio!=''){                       $SIS_data .= ",idPredio='".$idPredio."'";}
				if(isset($idUsuario) && $idUsuario!=''){                     $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){                       $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idTemporada) && $idTemporada!=''){                 $SIS_data .= ",idTemporada='".$idTemporada."'";}
				if(isset($idEstadoFen) && $idEstadoFen!=''){                 $SIS_data .= ",idEstadoFen='".$idEstadoFen."'";}
				if(isset($idCategoria) && $idCategoria!=''){                 $SIS_data .= ",idCategoria='".$idCategoria."'";}
				if(isset($idProducto) && $idProducto!=''){                   $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($f_creacion) && $f_creacion!=''){                   $SIS_data .= ",f_creacion='".$f_creacion."'";}
				if(isset($f_programacion) && $f_programacion!=''){           $SIS_data .= ",f_programacion='".$f_programacion."'";}
				if(isset($f_ejecucion) && $f_ejecucion!=''){                 $SIS_data .= ",f_ejecucion='".$f_ejecucion."'";}
				if(isset($f_termino) && $f_termino!=''){                     $SIS_data .= ",f_termino='".$f_termino."'";}
				if(isset($Observaciones) && $Observaciones!=''){             $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($horaProg) && $horaProg!=''){                       $SIS_data .= ",horaProg='".$horaProg."'";}
				if(isset($horaEjecucion) && $horaEjecucion!=''){             $SIS_data .= ",horaEjecucion='".$horaEjecucion."'";}
				if(isset($horaTermino) && $horaTermino!=''){                 $SIS_data .= ",horaTermino='".$horaTermino."'";}
				if(isset($Mojamiento) && $Mojamiento!=''){                   $SIS_data .= ",Mojamiento='".$Mojamiento."'";}
				if(isset($VelTractor) && $VelTractor!=''){                   $SIS_data .= ",VelTractor='".$VelTractor."'";}
				if(isset($VelViento) && $VelViento!=''){                     $SIS_data .= ",VelViento='".$VelViento."'";}
				if(isset($TempMin) && $TempMin!=''){                         $SIS_data .= ",TempMin='".$TempMin."'";}
				if(isset($TempMax) && $TempMax!=''){                         $SIS_data .= ",TempMax='".$TempMax."'";}
				if(isset($HumTempMax) && $HumTempMax!=''){                   $SIS_data .= ",HumTempMax='".$HumTempMax."'";}
				if(isset($idPrioridad) && $idPrioridad!=''){                 $SIS_data .= ",idPrioridad='".$idPrioridad."'";}
				if(isset($horaProg_fin) && $horaProg_fin!=''){               $SIS_data .= ",horaProg_fin='".$horaProg_fin."'";}
				if(isset($horaEjecucion_fin) && $horaEjecucion_fin!=''){     $SIS_data .= ",horaEjecucion_fin='".$horaEjecucion_fin."'";}
				if(isset($horaTermino_fin) && $horaTermino_fin!=''){         $SIS_data .= ",horaTermino_fin='".$horaTermino_fin."'";}
				if(isset($f_programacion_fin) && $f_programacion_fin!=''){   $SIS_data .= ",f_programacion_fin='".$f_programacion_fin."'";}
				if(isset($f_ejecucion_fin) && $f_ejecucion_fin!=''){         $SIS_data .= ",f_ejecucion_fin='".$f_ejecucion_fin."'";}
				if(isset($f_termino_fin) && $f_termino_fin!=''){             $SIS_data .= ",f_termino_fin='".$f_termino_fin."'";}
				if(isset($idDosificador) && $idDosificador!=''){             $SIS_data .= ",idDosificador='".$idDosificador."'";}
				if(isset($NSolicitud) && $NSolicitud!=''){                   $SIS_data .= ",NSolicitud='".$NSolicitud."'";}

				if(isset($f_programacion) && $f_programacion!=''){
					$SIS_data .= ",progDia='".fecha2NdiaMes($f_programacion)."'";
					$SIS_data .= ",progSemana='".fecha2NSemana($f_programacion)."'";
					$SIS_data .= ",progMes='".fecha2NMes($f_programacion)."'";
					$SIS_data .= ",progAno='".fecha2Ano($f_programacion)."'";
				}
				if(isset($f_ejecucion) && $f_ejecucion!=''){
					$SIS_data .= ",ejeDia='".fecha2NdiaMes($f_ejecucion)."'";
					$SIS_data .= ",ejeSemana='".fecha2NSemana($f_ejecucion)."'";
					$SIS_data .= ",ejeMes='".fecha2NMes($f_ejecucion)."'";
					$SIS_data .= ",ejeAno='".fecha2Ano($f_ejecucion)."'";
				}
				if(isset($f_termino) && $f_termino!=''){
					$SIS_data .= ",terDia='".fecha2NdiaMes($f_termino)."'";
					$SIS_data .= ",terSemana='".fecha2NSemana($f_termino)."'";
					$SIS_data .= ",terMes='".fecha2NMes($f_termino)."'";
					$SIS_data .= ",terAno='".fecha2Ano($f_termino)."'";
				}
				if(isset($f_programacion_fin) && $f_programacion_fin!=''){
					$SIS_data .= ",progDia_fin='".fecha2NdiaMes($f_programacion_fin)."'";
					$SIS_data .= ",progSemana_fin='".fecha2NSemana($f_programacion_fin)."'";
					$SIS_data .= ",progMes_fin='".fecha2NMes($f_programacion_fin)."'";
					$SIS_data .= ",progAno_fin='".fecha2Ano($f_programacion_fin)."'";
				}
				if(isset($f_ejecucion_fin) && $f_ejecucion_fin!=''){
					$SIS_data .= ",ejeDia_fin='".fecha2NdiaMes($f_ejecucion_fin)."'";
					$SIS_data .= ",ejeSemana_fin='".fecha2NSemana($f_ejecucion_fin)."'";
					$SIS_data .= ",ejeMes_fin='".fecha2NMes($f_ejecucion_fin)."'";
					$SIS_data .= ",ejeAno_fin='".fecha2Ano($f_ejecucion_fin)."'";
				}
				if(isset($f_termino_fin) && $f_termino_fin!=''){
					$SIS_data .= ",terDia_fin='".fecha2NdiaMes($f_termino_fin)."'";
					$SIS_data .= ",terSemana_fin='".fecha2NSemana($f_termino_fin)."'";
					$SIS_data .= ",terMes_fin='".fecha2NMes($f_termino_fin)."'";
					$SIS_data .= ",terAno_fin='".fecha2Ano($f_termino_fin)."'";
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se actualizan los datos internos de los cuarteles
					$SIS_data = "idSolicitud='".$idSolicitud."'";
					if(isset($Mojamiento) && $Mojamiento!=''){           $SIS_data .= ",Mojamiento='".$Mojamiento."'";}
					if(isset($VelTractor) && $VelTractor!=''){           $SIS_data .= ",VelTractor='".$VelTractor."'";}
					if(isset($VelViento) && $VelViento!=''){             $SIS_data .= ",VelViento='".$VelViento."'";}
					if(isset($TempMin) && $TempMin!=''){                 $SIS_data .= ",TempMin='".$TempMin."'";}
					if(isset($TempMax) && $TempMax!=''){                 $SIS_data .= ",TempMax='".$TempMax."'";}
					if(isset($HumTempMax) && $HumTempMax!=''){           $SIS_data .= ",HumTempMax='".$HumTempMax."'";}

					/*******************************************************/
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado==true){

						/******************************************/
						//Historial
						if(isset($Observacion)&&$Observacion!=''){
							if(isset($idSolicitud) && $idSolicitud!=''){       $SIS_data  = "'".$idSolicitud."'";       }else{$SIS_data  = "''";}
							if(isset($Creacion_fecha) && $Creacion_fecha!=''){ $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
							if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}
							if(isset($Observacion) && $Observacion!=''){       $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
							if(isset($idEstado) && $idEstado!=''){             $SIS_data .= ",'".$idEstado."'";         }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idSolicitud, Creacion_fecha, idUsuario, Observacion, idEstado';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
						/******************************************/
						//se consulta por el numero interno
						$rownint = db_select_data (false, 'NSolicitud', 'cross_solicitud_aplicacion_listado', '', 'idSolicitud = "'.$idSolicitud.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/******************************************/
						//En base al estado se hacen las consultas
						switch ($idEstado) {
							//Solicitado
							case 1:
								$transaccion = 'cross_solicitud_aplicacion_crear.php';
								$xbody = '
								<h3>Se ha rechazado la solicitud N° '.n_doc($rownint['NSolicitud'], 5).'</h3>
								<p>Se ha cambiado el estado a Solicitado por el siguiente motivo:</p>
								<p><strong>Observacion :</strong>'.$Observacion.'</p>
								<a href="'.DB_SITE_MAIN.'/view_solicitud_aplicacion.php?view='.simpleEncode($idSolicitud, fecha_actual()).'">Ver Aqui</a>';
								break;
							//Programado
							case 2:
								$transaccion = 'cross_solicitud_aplicacion_ejecutar.php';
								$xbody = '
								<h3>Se ha programado la solicitud N° '.n_doc($rownint['NSolicitud'], 5).'</h3>
								<p>Se ha cambiado el estado a Programado en la siguiente solicitud</p>
								<a href="'.DB_SITE_MAIN.'/view_solicitud_aplicacion.php?view='.simpleEncode($idSolicitud, fecha_actual()).'">Ver Aqui</a>';
								break;
							//Ejecutado
							case 3:
								/****************************************************/
								//Se trae un listado con los tractores
								$SIS_query = '
								cross_solicitud_aplicacion_listado_tractores.idTractores,
								cross_solicitud_aplicacion_listado_tractores.idTelemetria,
								cross_solicitud_aplicacion_listado_cuarteles.idZona,
								cross_solicitud_aplicacion_listado.idSolicitud,
								telemetria_listado.cantSensores,
								telemetria_listado.Nombre AS Tractor';
								$SIS_join  = '
								LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`  ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles  = cross_solicitud_aplicacion_listado_tractores.idCuarteles
								LEFT JOIN `cross_solicitud_aplicacion_listado`            ON cross_solicitud_aplicacion_listado.idSolicitud            = cross_solicitud_aplicacion_listado_tractores.idSolicitud
								LEFT JOIN `telemetria_listado`                            ON telemetria_listado.idTelemetria                           = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
								$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idSolicitud = '.$idSolicitud.' AND cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin!=0';
								$SIS_order = 'cross_solicitud_aplicacion_listado_tractores.idTractores ASC';
								$arrTractores = array();
								$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//se corrige la geodistancia en la tabla relacionada
								foreach ($arrTractores as $trac) {

									//se consulta por los datos
									$arrTelemetria = array();
									$arrTelemetria = db_select_array (false, 'idTabla, GeoLatitud, GeoLongitud', 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', 'idZona = '.$trac['idZona'].' AND idSolicitud = '.$idSolicitud, 'idTabla ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//reset
									$GeoLatitud  = 0;
									$GeoLongitud = 0;
									foreach ($arrTelemetria as $tel) {
										//calculo la distancia entre el punto actual y el anterior
										if(isset($GeoLatitud) && $GeoLatitud != 0 && isset($GeoLongitud) && $GeoLongitud != 0 && isset($tel['GeoLatitud'])&&$tel['GeoLatitud']!=0 && isset($tel['GeoLongitud'])&&$tel['GeoLongitud']!=0 ){
											$GeoMovimiento = obtenerDistancia( $GeoLatitud, $GeoLongitud, $tel['GeoLatitud'], $tel['GeoLongitud'] );
											/*******************************************************/
											//se actualizan los datos
											$SIS_data = "GeoMovimiento='".$GeoMovimiento."'";
											$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], 'idTabla = "'.$tel['idTabla'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}
										//actualizo variables
										$GeoLatitud  = $tel['GeoLatitud'];
										$GeoLongitud = $tel['GeoLongitud'];

									}
								}

								//se corrige los datos de la tabla de los tractores
								foreach ($arrTractores as $trac) {
									//se consulta por los datos
									$rowTablaRel = db_select_data (false, 'SUM(GeoMovimiento) AS GeoDistance, SUM(Diferencia) AS Diferencia', 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', 'idZona = '.$trac['idZona'].' AND idSolicitud = '.$idSolicitud.' ORDER BY idTabla ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
									/***************************************/
									if(isset($rowTablaRel['GeoDistance']) && $rowTablaRel['GeoDistance']!=''){
										$SIS_data = "GeoDistance='".$rowTablaRel['GeoDistance']."'";
									}else{
										$SIS_data = "GeoDistance='0'";
									}
									if(isset($rowTablaRel['Diferencia']) && $rowTablaRel['Diferencia']!=''){
										$SIS_data .= ",Diferencia='".$rowTablaRel['Diferencia']."'";
									}

									/*******************************************************/
									//se actualizan los datos
									$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', 'idTractores = "'.$trac['idTractores'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
								/****************************************************/
								//envio de correos
								$transaccion2 = 'informe_cross_checking_05.php';
								$xbody2 = '
								<h3>Se ha cerrado la solicitud N° '.n_doc($rownint['NSolicitud'], 5).'</h3>
								<p>Se ha cambiado el estado a Cerrado en la siguiente solicitud</p>
								<a href="'.DB_SITE_MAIN.'/informe_cross_checking_05.php?idSolicitud='.$idSolicitud.'&submit_filter=Filtrar">Ver Aqui</a>';
								//Permisos a las transacciones
								$SIS_query = '
								usuarios_listado.usuario AS UsuarioNick,
								usuarios_listado.email AS UsuarioEmail,
								usuarios_listado.Nombre AS UsuarioNombre,
								core_sistemas.email_principal AS EmpresaCorreo,
								core_sistemas.Nombre AS EmpresaNombre,
								core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
								core_sistemas.Config_Gmail_Password AS Gmail_Password';
								$SIS_join  = '
								INNER JOIN `usuarios_permisos`  ON usuarios_permisos.idAdmpm    = core_permisos_listado.idAdmpm
								LEFT JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = usuarios_permisos.idUsuario
								INNER JOIN `usuarios_sistemas`  ON usuarios_sistemas.idUsuario  = usuarios_listado.idUsuario
								LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema      = usuarios_sistemas.idSistema';
								$SIS_where = 'core_permisos_listado.Direccionbase="'.$transaccion2.'"
								AND usuarios_sistemas.idSistema = '.$idSistema;
								$SIS_order = 0;
								$arrCorreosInt = array();
								$arrCorreosInt = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//Notificaciones a los correos
								foreach ($arrCorreosInt as $correo) {
									/*******************/
									//Envio de correo
									$rmail = tareas_envio_correo($correo['EmpresaCorreo'], $correo['EmpresaNombre'],
																 $correo['UsuarioEmail'], $correo['UsuarioNombre'],
																 '', '',
																 'Notificación Solicitud '.n_doc($idSolicitud, 5),
																 $xbody2,'',
																 '',
																 1,
																 $correo['Gmail_Usuario'],
																 $correo['Gmail_Password']);

									//Envio del mensaje
									if ($rmail!=1) {
										php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'En el envio de la notificacion:'.$rmail, '' );
									}else {
										log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Notificación Solicitud '.n_doc($idSolicitud, 5).')');
									}
								}

								/***********************************************/
								/*$transaccion = 'cross_solicitud_aplicacion_ejecucion.php';
								$xbody = '
								<h3>Se ha cerrado la solicitud N° '.n_doc($idSolicitud, 5).'</h3>
								<p>Se ha cambiado el estado a Cerrado en la siguiente solicitud</p>
								<a href="'.DB_SITE_MAIN.'/view_solicitud_aplicacion.php?view='.simpleEncode($idSolicitud, fecha_actual()).'">Ver Aqui</a>';*/

								break;
						}

						/***************************************************************/
						//Permisos a las transacciones
						/*$SIS_query = '
						usuarios_listado.usuario AS UsuarioNick,
						usuarios_listado.email AS UsuarioEmail,
						usuarios_listado.Nombre AS UsuarioNombre,
						core_sistemas.email_principal AS EmpresaCorreo,
						core_sistemas.Nombre AS EmpresaNombre,
						core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
						core_sistemas.Config_Gmail_Password AS Gmail_Password';
						$SIS_join  = '
						INNER JOIN `usuarios_permisos`  ON usuarios_permisos.idAdmpm    = core_permisos_listado.idAdmpm
						LEFT JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = usuarios_permisos.idUsuario
						INNER JOIN `usuarios_sistemas`  ON usuarios_sistemas.idUsuario  = usuarios_listado.idUsuario
						LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema      = usuarios_sistemas.idSistema';
						$SIS_where = 'core_permisos_listado.Direccionbase="'.$transaccion.'" AND usuarios_sistemas.idSistema = '.$idSistema;
						$SIS_order = 0;
						$arrCorreos = array();
						$arrCorreos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Notificaciones a los correos
						foreach ($arrCorreos as $correo) {
							/*******************/
							//Envio de correo
							/*$rmail = tareas_envio_correo($correo['EmpresaCorreo'], $correo['EmpresaNombre'],
														 $correo['UsuarioEmail'], $correo['UsuarioNombre'],
														 '', '',
														 'Notificación Solicitud '.n_doc($idSolicitud, 5),
														 $xbody,'',
														 '',
														 1,
														 $correo['Gmail_Usuario'],
														 $correo['Gmail_Password']);
                            //se guarda el log
							log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Notificación Solicitud '.n_doc($idSolicitud, 5).')');
							*
							//Envio del mensaje
							if ($rmail!=1) {
								error_log("Mailer Error 2:".$rmail, 0);
							} else {
								//error_log("Correo enviado", 0);
							}
						}*/

						//Notificaciones dentro del sistema

						header( 'Location: '.$location.'&not_modbase=true' );
						die;
					}
				}

			}

		break;

/*******************************************************************************************************************/
		case 'updt_addCuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/******************************************/
				//Obtengo datos
				$rowData = db_select_data (false, 'idCategoria, idProducto', 'cross_predios_listado_zonas', '', 'idZona = "'.$idZona.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Cuarteles
				if(isset($idSolicitud) && $idSolicitud!=''){                    $SIS_data  = "'".$idSolicitud."'";               }else{$SIS_data  = "''";}
				if(isset($idZona) && $idZona!=''){                              $SIS_data .= ",'".$idZona."'";                   }else{$SIS_data .= ",''";}
				if(isset($Mojamiento) && $Mojamiento!=''){                      $SIS_data .= ",'".$Mojamiento."'";               }else{$SIS_data .= ",''";}
				if(isset($VelTractor) && $VelTractor!=''){                      $SIS_data .= ",'".$VelTractor."'";               }else{$SIS_data .= ",''";}
				if(isset($VelViento) && $VelViento!=''){                        $SIS_data .= ",'".$VelViento."'";                }else{$SIS_data .= ",''";}
				if(isset($TempMin) && $TempMin!=''){                            $SIS_data .= ",'".$TempMin."'";                  }else{$SIS_data .= ",''";}
				if(isset($TempMax) && $TempMax!=''){                            $SIS_data .= ",'".$TempMax."'";                  }else{$SIS_data .= ",''";}
				if(isset($HumTempMax) && $HumTempMax!=''){                      $SIS_data .= ",'".$HumTempMax."'";               }else{$SIS_data .= ",''";}
				$SIS_data .= ",'1'"; //se asigna el estado
				if(isset($rowData['idCategoria'])&&$rowData['idCategoria']!=''){ $SIS_data .= ",'".$rowData['idCategoria']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idProducto'])&&$rowData['idProducto']!=''){   $SIS_data .= ",'".$rowData['idProducto']."'";    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSolicitud, idZona, Mojamiento, VelTractor, VelViento, TempMin, TempMax, HumTempMax, idEstado, idCategoria, idProducto';
				$idCuarteles_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($idCuarteles_id!=0){
					/******************************************/
					//tractores
					if(isset($idSolicitud) && $idSolicitud!=''){        $SIS_data  = "'".$idSolicitud."'";      }else{$SIS_data  = "''";}
					if(isset($idCuarteles_id) && $idCuarteles_id!=''){  $SIS_data .= ",'".$idCuarteles_id."'";  }else{$SIS_data .= ",''";}
					if(isset($idTelemetria) && $idTelemetria!=''){      $SIS_data .= ",'".$idTelemetria."'";    }else{$SIS_data .= ",''";}
					if(isset($idVehiculo) && $idVehiculo!=''){          $SIS_data .= ",'".$idVehiculo."'";      }else{$SIS_data .= ",''";}
					if(isset($idTrabajador) && $idTrabajador!=''){      $SIS_data .= ",'".$idTrabajador."'";    }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSolicitud, idCuarteles, idTelemetria, idVehiculo, idTrabajador';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/******************************************/
					//Producto
					if(isset($idSolicitud) && $idSolicitud!=''){           $SIS_data  = "'".$idSolicitud."'";       }else{$SIS_data  = "''";}
					if(isset($idCuarteles_id) && $idCuarteles_id!=''){     $SIS_data .= ",'".$idCuarteles_id."'";   }else{$SIS_data .= ",''";}
					if(isset($idProducto) && $idProducto!=''){             $SIS_data .= ",'".$idProducto."'";       }else{$SIS_data .= ",''";}
					if(isset($DosisRecomendada) && $DosisRecomendada!=''){ $SIS_data .= ",'".$DosisRecomendada."'"; }else{$SIS_data .= ",''";}
					if(isset($DosisAplicar) && $DosisAplicar!=''){         $SIS_data .= ",'".$DosisAplicar."'";     }else{$SIS_data .= ",''";}
					if(isset($idUml) && $idUml!=''){                       $SIS_data .= ",'".$idUml."'";            }else{$SIS_data .= ",''";}
					if(isset($Objetivo) && $Objetivo!=''){                 $SIS_data .= ",'".$Objetivo."'";         }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSolicitud, idCuarteles, idProducto, DosisRecomendada, DosisAplicar, idUml, Objetivo';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/************************************************************/
					//se redirije
					header( 'Location: '.$location.'&not_addcuartel=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'updt_editCuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/******************************************/
				//Obtengo datos
				$rowData = db_select_data (false, 'idCategoria, idProducto', 'cross_predios_listado_zonas', '', 'idZona = "'.$idZona.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************/
				//Filtros
				$SIS_data = "idCuarteles='".$idCuarteles."'";
				if(isset($idSolicitud) && $idSolicitud!=''){                     $SIS_data .= ",idSolicitud='".$idSolicitud."'";}
				if(isset($idZona) && $idZona!=''){                               $SIS_data .= ",idZona='".$idZona."'";}
				if(isset($Mojamiento) && $Mojamiento!=''){                       $SIS_data .= ",Mojamiento='".$Mojamiento."'";}
				if(isset($VelTractor) && $VelTractor!=''){                       $SIS_data .= ",VelTractor='".$VelTractor."'";}
				if(isset($VelViento) && $VelViento!=''){                         $SIS_data .= ",VelViento='".$VelViento."'";}
				if(isset($TempMin) && $TempMin!=''){                             $SIS_data .= ",TempMin='".$TempMin."'";}
				if(isset($TempMax) && $TempMax!=''){                             $SIS_data .= ",TempMax='".$TempMax."'";}
				if(isset($HumTempMax) && $HumTempMax!=''){                       $SIS_data .= ",HumTempMax='".$HumTempMax."'";}
				if(isset($rowData['idCategoria'])&&$rowData['idCategoria']!=''){ $SIS_data .= ",idCategoria='".$rowData['idCategoria']."'";}
				if(isset($rowData['idProducto'])&&$rowData['idProducto']!=''){   $SIS_data .= ",idProducto='".$rowData['idProducto']."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', 'idCuarteles = "'.$idCuarteles.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&not_editprod=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'updt_close_Cuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/***********************************************************/

			if(isset($idEjecucion)){
				switch ($idEjecucion) {

					/******************************************************/
					//Si no fue ejecutado
					case 1:
						/***************************************/
						//obtengo datos desde la solicitud
						$select_data = '
						cross_predios_listado_zonas.Plantas AS CuartelNPlantas,
						cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant';
						$select_join = 'LEFT JOIN `cross_predios_listado_zonas`    ON cross_predios_listado_zonas.idZona         = cross_solicitud_aplicacion_listado_cuarteles.idZona';
						$select_where = 'cross_solicitud_aplicacion_listado_cuarteles.idCuarteles = '.$idCuarteles;
						//consulto
						$rowData = db_select_data (false, $select_data, 'cross_solicitud_aplicacion_listado_cuarteles', $select_join, $select_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Operaciones
						$T_Aplicacion = minutos2horas((($rowData['CuartelNPlantas']*$rowData['CuartelDistanciaPlant'])/$VelPromedio)*60);

						/***************************************/
						//se cierra el cuartel
						$SIS_data  = "idEstado='2'";
						if(isset($f_cierre)&&$f_cierre!=''){                 $SIS_data .= ",f_cierre='".$f_cierre."'";}
						if(isset($idUsuario)&&$idUsuario!=''){               $SIS_data .= ",idUsuario='".$idUsuario."'";}
						if(isset($idEjecucion)&&$idEjecucion!=''){           $SIS_data .= ",idEjecucion='".$idEjecucion."'";}
						if(isset($GeoDistance)&&$GeoDistance!=''){           $SIS_data .= ",GeoDistance='".$GeoDistance."'";}
						if(isset($VelPromedio)&&$VelPromedio!=''){           $SIS_data .= ",VelPromedio='".$VelPromedio."'";}
						if(isset($LitrosAplicados)&&$LitrosAplicados!=''){   $SIS_data .= ",LitrosAplicados='".$LitrosAplicados."'";}
						if(isset($T_Aplicacion)&&$T_Aplicacion!=''){         $SIS_data .= ",T_Aplicacion='".$T_Aplicacion."'";}

						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', 'idCuarteles = "'.$idCuarteles.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//Si ejecuto correctamente la consulta
						if($resultado==true){

							header( 'Location: '.$location.'&not_closecuartel=true' );
							die;
						}

						break;

					/******************************************************/
					//Si fue ejecutado
					case 2:

						/***********************************************************/
						//Cuento si el cuartel tiene trabajos realizados
						$SIS_query = '
						cross_solicitud_aplicacion_listado_tractores.idTractores,
						cross_solicitud_aplicacion_listado_tractores.idTelemetria,
						cross_solicitud_aplicacion_listado_cuarteles.idZona,
						cross_solicitud_aplicacion_listado.idSolicitud,
						telemetria_listado.cantSensores,
						telemetria_listado.Nombre AS Tractor';
						$SIS_join  = '
						LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`  ON cross_solicitud_aplicacion_listado_cuarteles.idCuarteles  = cross_solicitud_aplicacion_listado_tractores.idCuarteles
						LEFT JOIN `cross_solicitud_aplicacion_listado`            ON cross_solicitud_aplicacion_listado.idSolicitud            = cross_solicitud_aplicacion_listado_tractores.idSolicitud
						LEFT JOIN `telemetria_listado`                            ON telemetria_listado.idTelemetria                           = cross_solicitud_aplicacion_listado_tractores.idTelemetria';
						$SIS_where = 'cross_solicitud_aplicacion_listado_tractores.idCuarteles = '.$idCuarteles;
						$SIS_order = 'cross_solicitud_aplicacion_listado_tractores.idTractores ASC';
						$arrTractores = array();
						$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*******************************************************************/
						//variables
						$in_idSolicitud  = 0;
						$ndata_1         = 0;
						$ntractores      = 0;
						//se recorren los tractores
						foreach ($arrTractores as $trac) {
							$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', "idZona = ".$trac['idZona']." AND idSolicitud=0 AND (FechaSistema BETWEEN '".$f_ejecucion."' AND '".$f_ejecucion_fin."') AND (Sensor_1!=0 OR Sensor_2!=0)", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//mientras sea distinto de 0
							if($ndata_1!=0) {
								$ntractores++;
							}
						}
						//generacion de errores
						if($ntractores==0) {$error['ndata_1'] = 'error/Ninguno de los equipos ha realizado su recorrido en el cuartel';}
						/*******************************************************************/

						if(empty($error)){

							/******************************************************************/
							//se actualizala solicitud de los recorridos realizados
							foreach ($arrTractores as $trac) {

								/***************************************/
								//se actualizala solicitud
								$SIS_data = "idSolicitud='".$trac['idSolicitud']."'";

								//Actualizo los datos de cuando estaba dentro de la zona
								$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], 'idZona = "'.$trac['idZona'].'"  AND idSolicitud=0 AND (FechaSistema BETWEEN "'.$f_ejecucion.'" AND "'.$f_ejecucion_fin.'") AND (Sensor_1!=0 OR Sensor_2!=0)', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//Actualizo los datos de cuando estaba fuera de la zona
								$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], 'idZona = 0 AND idSolicitud=0 AND (FechaSistema BETWEEN "'.$f_ejecucion.'" AND "'.$f_ejecucion_fin.'")', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//Actualizo las detenciones
								$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_error_detenciones', 'idTelemetria = '.$trac['idTelemetria'].' AND idZona = '.$trac['idZona'].' AND idSolicitud=0 AND (Fecha BETWEEN "'.$f_ejecucion.'" AND "'.$f_ejecucion_fin.'")', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								//Actualizo los fuera de linea
								$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_error_fuera_linea', 'idTelemetria = '.$trac['idTelemetria'].' AND idZona = '.$trac['idZona'].' AND idSolicitud=0 AND (Fecha_inicio BETWEEN "'.$f_ejecucion.'" AND "'.$f_ejecucion_fin.'")', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
							/******************************************************************/
							//se corrige la geodistancia en la tabla relacionada
							foreach ($arrTractores as $trac) {

								//se consulta por los datos
								$arrTelemetria = array();
								$arrTelemetria = db_select_array (false, 'idTabla, GeoLatitud, GeoLongitud', 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', 'idZona = '.$trac['idZona'].' AND idSolicitud = '.$trac['idSolicitud'], 'idTabla ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								//reset
								$GeoLatitud  = 0;
								$GeoLongitud = 0;
								foreach ($arrTelemetria as $tel) {
									//calculo la distancia entre el punto actual y el anterior
									if(isset($GeoLatitud) && $GeoLatitud != 0 && isset($GeoLongitud) && $GeoLongitud != 0 && isset($tel['GeoLatitud'])&&$tel['GeoLatitud']!=0 && isset($tel['GeoLongitud'])&&$tel['GeoLongitud']!=0 ){
										$GeoMovimiento = obtenerDistancia( $GeoLatitud, $GeoLongitud, $tel['GeoLatitud'], $tel['GeoLongitud'] );
										/*******************************************************/
										//se actualizan los datos
										$SIS_data = "GeoMovimiento='".$GeoMovimiento."'";
										$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], 'idTabla = "'.$tel['idTabla'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									}
									//actualizo variables
									$GeoLatitud  = $tel['GeoLatitud'];
									$GeoLongitud = $tel['GeoLongitud'];

								}
							}

							/******************************************************************/
							//variable para la cuenta de segundos
							$Total_Seg = 0;

							//se corrige los datos de la tabla de los tractores
							foreach ($arrTractores as $trac) {
								/***************************************/
								$aa = '';
								//se recorre deacuerdo a la cantidad de sensores
								for ($i = 1; $i <= $trac['cantSensores']; $i++) {
									$aa .= ',MIN(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_'.$i.'_Min';
									$aa .= ',MAX(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_'.$i.'_Max';
									$aa .= ',AVG(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_'.$i.'_Prom';
									$aa .= ',SUM(NULLIF(IF(Sensor_'.$i.'!=0,Sensor_'.$i.',0),0)) AS Sensor_'.$i.'_Sum';
								}

								/****************************************************************/
								//Si esta dentro del cuartel
								$SIS_query = '
								MIN(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadMin,
								MAX(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadMax,
								AVG(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadProm,
								SUM(GeoMovimiento) AS GeoDistance,
								SUM(Diferencia) AS Diferencia,
								SUM(Segundos) AS Segundos
								'.$aa;
								$SIS_where = 'idZona = '.$trac['idZona'].' AND idSolicitud = '.$trac['idSolicitud'].' ORDER BY idTabla ASC';
								$rowTablaRel = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								/****************************************************************/
								//Si esta fuera del cuartel
								$SIS_query = '
								MIN(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadMin,
								MAX(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadMax,
								AVG(NULLIF(IF(GeoVelocidad!=0,GeoVelocidad,0),0)) AS GeoVelocidadProm,
								SUM(GeoMovimiento) AS GeoDistance,
								SUM(Diferencia) AS Diferencia,
								SUM(Segundos) AS Segundos
								'.$aa;
								$SIS_where = 'idZona = 0 AND idSolicitud = '.$trac['idSolicitud'].' ORDER BY idTabla ASC';
								$rowTablaRel_out = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$trac['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
								/***************************************/
								//se transforman datos
								$In_T_Aplicacion     = segundos2horas($rowTablaRel['Segundos']);
								$In_T_Aplicacion_out = segundos2horas($rowTablaRel_out['Segundos']);
								$Total_Seg           = $Total_Seg + $rowTablaRel['Segundos'];

								//se guardan los datos
								$SIS_data = "idTractores='".$trac['idTractores']."'";
								if(isset($rowTablaRel['GeoVelocidadMin']) && $rowTablaRel['GeoVelocidadMin']!=''){             $SIS_data .= ",GeoVelocidadMin='".$rowTablaRel['GeoVelocidadMin']."'";}
								if(isset($rowTablaRel['GeoVelocidadMax']) && $rowTablaRel['GeoVelocidadMax']!=''){             $SIS_data .= ",GeoVelocidadMax='".$rowTablaRel['GeoVelocidadMax']."'";}
								if(isset($rowTablaRel['GeoVelocidadProm']) && $rowTablaRel['GeoVelocidadProm']!=''){           $SIS_data .= ",GeoVelocidadProm='".$rowTablaRel['GeoVelocidadProm']."'";}
								if(isset($rowTablaRel['GeoDistance']) && $rowTablaRel['GeoDistance']!=''){                     $SIS_data .= ",GeoDistance='".$rowTablaRel['GeoDistance']."'";}
								if(isset($rowTablaRel['Diferencia']) && $rowTablaRel['Diferencia']!=''){                       $SIS_data .= ",Diferencia='".$rowTablaRel['Diferencia']."'";}
								if(isset($In_T_Aplicacion) && $In_T_Aplicacion!=''){                                           $SIS_data .= ",T_Aplicacion='".$In_T_Aplicacion."'";}

								if(isset($rowTablaRel_out['GeoVelocidadMin']) && $rowTablaRel_out['GeoVelocidadMin']!=''){     $SIS_data .= ",GeoVelocidadMin_out='".$rowTablaRel_out['GeoVelocidadMin']."'";}
								if(isset($rowTablaRel_out['GeoVelocidadMax']) && $rowTablaRel_out['GeoVelocidadMax']!=''){     $SIS_data .= ",GeoVelocidadMax_out='".$rowTablaRel_out['GeoVelocidadMax']."'";}
								if(isset($rowTablaRel_out['GeoVelocidadProm']) && $rowTablaRel_out['GeoVelocidadProm']!=''){   $SIS_data .= ",GeoVelocidadProm_out='".$rowTablaRel_out['GeoVelocidadProm']."'";}
								if(isset($rowTablaRel_out['GeoDistance']) && $rowTablaRel_out['GeoDistance']!=''){             $SIS_data .= ",GeoDistance_out='".$rowTablaRel_out['GeoDistance']."'";}
								if(isset($rowTablaRel_out['Diferencia']) && $rowTablaRel_out['Diferencia']!=''){               $SIS_data .= ",Diferencia_out='".$rowTablaRel_out['Diferencia']."'";}
								if(isset($In_T_Aplicacion_out) && $In_T_Aplicacion_out!=''){                                   $SIS_data .= ",T_Aplicacion_out='".$In_T_Aplicacion_out."'";}

								//se recorre deacuerdo a la cantidad de sensores
								for ($i = 1; $i <= $trac['cantSensores']; $i++) {
									if(isset($rowTablaRel['Sensor_'.$i.'_Prom']) && $rowTablaRel['Sensor_'.$i.'_Prom']!=''){           $SIS_data .= ",Sensor_".$i."_Prom='".$rowTablaRel['Sensor_'.$i.'_Prom']."'";}
									if(isset($rowTablaRel['Sensor_'.$i.'_Min']) && $rowTablaRel['Sensor_'.$i.'_Min']!=''){             $SIS_data .= ",Sensor_".$i."_Min='".$rowTablaRel['Sensor_'.$i.'_Min']."'";}
									if(isset($rowTablaRel['Sensor_'.$i.'_Max']) && $rowTablaRel['Sensor_'.$i.'_Max']!=''){             $SIS_data .= ",Sensor_".$i."_Max='".$rowTablaRel['Sensor_'.$i.'_Max']."'";}
									if(isset($rowTablaRel['Sensor_'.$i.'_Sum']) && $rowTablaRel['Sensor_'.$i.'_Sum']!=''){             $SIS_data .= ",Sensor_".$i."_Sum='".$rowTablaRel['Sensor_'.$i.'_Sum']."'";}
									if(isset($rowTablaRel_out['Sensor_'.$i.'_Prom']) && $rowTablaRel_out['Sensor_'.$i.'_Prom']!=''){   $SIS_data .= ",Sensor_out_".$i."_Prom='".$rowTablaRel_out['Sensor_'.$i.'_Prom']."'";}
									if(isset($rowTablaRel_out['Sensor_'.$i.'_Min']) && $rowTablaRel_out['Sensor_'.$i.'_Min']!=''){     $SIS_data .= ",Sensor_out_".$i."_Min='".$rowTablaRel_out['Sensor_'.$i.'_Min']."'";}
									if(isset($rowTablaRel_out['Sensor_'.$i.'_Max']) && $rowTablaRel_out['Sensor_'.$i.'_Max']!=''){     $SIS_data .= ",Sensor_out_".$i."_Max='".$rowTablaRel_out['Sensor_'.$i.'_Max']."'";}
									if(isset($rowTablaRel_out['Sensor_'.$i.'_Sum']) && $rowTablaRel_out['Sensor_'.$i.'_Sum']!=''){     $SIS_data .= ",Sensor_out_".$i."_Sum='".$rowTablaRel_out['Sensor_'.$i.'_Sum']."'";}
								}

								/*******************************************************/
								//se actualizan los datos
								$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', 'idTractores = "'.$trac['idTractores'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}

							/******************************************************************/
							//se transforman datos
							$In_Total_Seg = segundos2horas($Total_Seg);

							//se cierra el cuartel
							$SIS_data  = "idEstado='2'";
							if(isset($f_cierre)&&$f_cierre!=''){          $SIS_data .= ",f_cierre='".$f_cierre."'";}
							if(isset($idUsuario)&&$idUsuario!=''){        $SIS_data .= ",idUsuario='".$idUsuario."'";}
							if(isset($idEjecucion)&&$idEjecucion!=''){    $SIS_data .= ",idEjecucion='".$idEjecucion."'";}
							if(isset($In_Total_Seg)&&$In_Total_Seg!=''){  $SIS_data .= ",T_Aplicacion='".$In_Total_Seg."'";}

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', 'idCuarteles = "'.$idCuarteles.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							header( 'Location: '.$location.'&not_closecuartel=true' );
							die;

						}

						break;
				}
			}

		break;

/*******************************************************************************************************************/
		case 'updt_del_Cuartel':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_cuartel']) OR !validaEntero($_GET['del_cuartel']))&&$_GET['del_cuartel']!=''){
				$indice = simpleDecode($_GET['del_cuartel'], fecha_actual());
			}else{
				$indice = $_GET['del_cuartel'];
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
				$resultado_1 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_cuarteles', 'idCuarteles = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_productos', 'idCuarteles = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_tractores', 'idCuarteles = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true){

					//redirijo
					header( 'Location: '.$location.'&not_delcuartel=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'updt_addtractor':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/******************************************/
				//tractores
				if(isset($idSolicitud) && $idSolicitud!=''){    $SIS_data  = "'".$idSolicitud."'";   }else{$SIS_data  = "''";}
				if(isset($idCuarteles) && $idCuarteles!=''){    $SIS_data .= ",'".$idCuarteles."'";  }else{$SIS_data .= ",''";}
				if(isset($idTelemetria) && $idTelemetria!=''){  $SIS_data .= ",'".$idTelemetria."'"; }else{$SIS_data .= ",''";}
				if(isset($idVehiculo) && $idVehiculo!=''){      $SIS_data .= ",'".$idVehiculo."'";   }else{$SIS_data .= ",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){  $SIS_data .= ",'".$idTrabajador."'"; }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSolicitud, idCuarteles, idTelemetria, idVehiculo, idTrabajador';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//se redirije
					header( 'Location: '.$location.'&not_addtractor=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'updt_edittractor':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//filtros
				$SIS_data = "idTractores='".$idTractores."'";
				if(isset($idSolicitud) && $idSolicitud!=''){     $SIS_data .= ",idSolicitud='".$idSolicitud."'";}
				if(isset($idCuarteles) && $idCuarteles!=''){     $SIS_data .= ",idCuarteles='".$idCuarteles."'";}
				if(isset($idTelemetria) && $idTelemetria!=''){   $SIS_data .= ",idTelemetria='".$idTelemetria."'";}
				if(isset($idVehiculo) && $idVehiculo!=''){       $SIS_data .= ",idVehiculo='".$idVehiculo."'";}
				if(isset($idTrabajador) && $idTrabajador!=''){   $SIS_data .= ",idTrabajador='".$idTrabajador."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', 'idTractores = "'.$idTractores.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&not_edittrac=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'updt_del_trac':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_trac']) OR !validaEntero($_GET['del_trac']))&&$_GET['del_trac']!=''){
				$indice = simpleDecode($_GET['del_trac'], fecha_actual());
			}else{
				$indice = $_GET['del_trac'];
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
				$resultado = db_delete_data (false, 'cross_solicitud_aplicacion_listado_tractores', 'idTractores = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&not_deltractor=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'updt_addmaterial':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idMatSeguridad)&&isset($idSolicitud)){
				$ndata_1 = db_select_nrows (false, 'idMatSeg', 'cross_solicitud_aplicacion_listado_materiales', '', "idMatSeguridad='".$idMatSeguridad."' AND idSolicitud='".$idSolicitud."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El material ya existe en la solicitud';}
			/*******************************************************************/

			if(empty($error)){

				/******************************************/
				//tractores
				if(isset($idSolicitud) && $idSolicitud!=''){        $SIS_data  = "'".$idSolicitud."'";      }else{$SIS_data  = "''";}
				if(isset($idMatSeguridad) && $idMatSeguridad!=''){  $SIS_data .= ",'".$idMatSeguridad."'";  }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSolicitud, idMatSeguridad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_materiales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//se redirije
					header( 'Location: '.$location.'&not_addmaterial=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'updt_del_material':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_material']) OR !validaEntero($_GET['del_material']))&&$_GET['del_material']!=''){
				$indice = simpleDecode($_GET['del_material'], fecha_actual());
			}else{
				$indice = $_GET['del_material'];
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
				$resultado = db_delete_data (false, 'cross_solicitud_aplicacion_listado_materiales', 'idMatSeg = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&not_delmaterial=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'updt_addproducto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/******************************************/
				//Producto
				if(isset($idSolicitud) && $idSolicitud!=''){           $SIS_data  = "'".$idSolicitud."'";       }else{$SIS_data  = "''";}
				if(isset($idCuarteles) && $idCuarteles!=''){           $SIS_data .= ",'".$idCuarteles."'";      }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){             $SIS_data .= ",'".$idProducto."'";       }else{$SIS_data .= ",''";}
				if(isset($DosisRecomendada) && $DosisRecomendada!=''){ $SIS_data .= ",'".$DosisRecomendada."'"; }else{$SIS_data .= ",''";}
				if(isset($DosisAplicar) && $DosisAplicar!=''){         $SIS_data .= ",'".$DosisAplicar."'";     }else{$SIS_data .= ",''";}
				if(isset($idUml) && $idUml!=''){                       $SIS_data .= ",'".$idUml."'";            }else{$SIS_data .= ",''";}
				if(isset($Objetivo) && $Objetivo!=''){                 $SIS_data .= ",'".$Objetivo."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSolicitud, idCuarteles, idProducto, DosisRecomendada, DosisAplicar, idUml, Objetivo';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//se redirije
					header( 'Location: '.$location.'&not_addprod=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'updt_editproducto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//filtros
				$SIS_data = "idProdQuim='".$idProdQuim."'";
				if(isset($idSolicitud) && $idSolicitud!=''){            $SIS_data .= ",idSolicitud='".$idSolicitud."'";}
				if(isset($idCuarteles) && $idCuarteles!=''){            $SIS_data .= ",idCuarteles='".$idCuarteles."'";}
				if(isset($idProducto) && $idProducto!=''){              $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($DosisRecomendada) && $DosisRecomendada!=''){  $SIS_data .= ",DosisRecomendada='".$DosisRecomendada."'";}
				if(isset($DosisAplicar) && $DosisAplicar!=''){          $SIS_data .= ",DosisAplicar='".$DosisAplicar."'";}
				if(isset($idUml) && $idUml!=''){                        $SIS_data .= ",idUml='".$idUml."'";}
				if(isset($Objetivo) && $Objetivo!=''){                  $SIS_data .= ",Objetivo='".$Objetivo."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'cross_solicitud_aplicacion_listado_productos', 'idProdQuim = "'.$idProdQuim.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&not_editprod=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'updt_del_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_prod']) OR !validaEntero($_GET['del_prod']))&&$_GET['del_prod']!=''){
				$indice = simpleDecode($_GET['del_prod'], fecha_actual());
			}else{
				$indice = $_GET['del_prod'];
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
				$resultado = db_delete_data (false, 'cross_solicitud_aplicacion_listado_productos', 'idProdQuim = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&not_delprod=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'updt_adddetalle':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				/******************************************/
				//Producto
				if(isset($idSolicitud) && $idSolicitud!=''){       $SIS_data  = "'".$idSolicitud."'";       }else{$SIS_data  = "''";}
				if(isset($Creacion_fecha) && $Creacion_fecha!=''){ $SIS_data .= ",'".$Creacion_fecha."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){           $SIS_data .= ",'".$idUsuario."'";        }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){       $SIS_data .= ",'".$Observacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){             $SIS_data .= ",'".$idEstado."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSolicitud, Creacion_fecha, idUsuario, Observacion, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//se redirije
					header( 'Location: '.$location.'&not_adddetalle=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_All_Solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Solicitud']) OR !validaEntero($_GET['del_Solicitud']))&&$_GET['del_Solicitud']!=''){
				$indice = simpleDecode($_GET['del_Solicitud'], fecha_actual());
			}else{
				$indice = $_GET['del_Solicitud'];
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
				//Si no hay errores ejecuto el codigo
				if(empty($error)){

					//se borran los datos
					$resultado_1 = db_delete_data (false, 'cross_solicitud_aplicacion_listado', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_2 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_cuarteles', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_3 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_productos', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$resultado_4 = db_delete_data (false, 'cross_solicitud_aplicacion_listado_tractores', 'idSolicitud = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//Si ejecuto correctamente la consulta
					if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true){

						//redirijo
						header( 'Location: '.$location.'&deleted=true' );
						die;

					}

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'clone_Solicitud':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//generacion de errores
			if($NSolicitud == $NSolicitudOld) {$error['ndata_1'] = 'error/El numero de solicitud es el mismo que el de la solicitud clonada, favor ingresar uno nuevo';}
			/*******************************************************************/

			if(empty($error)){

				/*******************************************************/
				$SIS_query = 'idPredio,idTemporada,idEstadoFen,idCategoria,idProducto,
				Mojamiento,VelTractor,VelViento,TempMin,TempMax,HumTempMax,idPrioridad,
				idDosificador';
				$SIS_where = 'idSolicitud='.$idSolicitud;
				$rowSolicitud = db_select_data (false, $SIS_query, 'cross_solicitud_aplicacion_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				$SIS_query = 'idMatSeguridad';
				$SIS_where = 'idSolicitud='.$idSolicitud;
				$arrMateriales = array();
				$arrMateriales = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_materiales', '', $SIS_where, 'idMatSeg ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				$SIS_query = 'idCuarteles,idZona,Mojamiento,VelTractor,VelViento,TempMin,TempMax,
				HumTempMax,idEstado,idCategoria,idProducto';
				$SIS_where = 'idSolicitud='.$idSolicitud;
				$arrCuarteles = array();
				$arrCuarteles = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_cuarteles', '', $SIS_where, 'idCuarteles ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				$SIS_query = 'idCuarteles,idTelemetria,idVehiculo,idTrabajador';
				$SIS_where = 'idSolicitud='.$idSolicitud;
				$arrTractores = array();
				$arrTractores = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_tractores', '', $SIS_where, 'idTractores ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				$SIS_query = 'idCuarteles,idProducto,DosisRecomendada,DosisAplicar,idUml,Objetivo';
				$SIS_where = 'idSolicitud='.$idSolicitud;
				$arrProductos = array();
				$arrProductos = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado_productos', '', $SIS_where, 'idProdQuim ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/****************************************************************************/
				/****************************************************************************/
				/**********************************************/
				//Se guardan los datos basicos
				if(isset($idSistema) && $idSistema!=''){                                     $SIS_data  = "'".$idSistema."'";                        }else{$SIS_data  = "''";}
				if(isset($rowSolicitud['idPredio']) && $rowSolicitud['idPredio']!=''){       $SIS_data .= ",'".$rowSolicitud['idPredio']."'";        }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                                     $SIS_data .= ",'".$idUsuario."'";                       }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                                       $SIS_data .= ",'".$idEstado."'";                        }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['idTemporada']) && $rowSolicitud['idTemporada']!=''){ $SIS_data .= ",'".$rowSolicitud['idTemporada']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['idEstadoFen']) && $rowSolicitud['idEstadoFen']!=''){ $SIS_data .= ",'".$rowSolicitud['idEstadoFen']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['idCategoria']) && $rowSolicitud['idCategoria']!=''){ $SIS_data .= ",'".$rowSolicitud['idCategoria']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['idProducto']) && $rowSolicitud['idProducto']!=''){   $SIS_data .= ",'".$rowSolicitud['idProducto']."'";      }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                                   $SIS_data .= ",'".$f_creacion."'";                      }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){
					$SIS_data .= ",'".$f_programacion."'";
					$SIS_data .= ",'".fecha2NdiaMes($f_programacion)."'";
					$SIS_data .= ",'".fecha2NSemana($f_programacion)."'";
					$SIS_data .= ",'".fecha2NMes($f_programacion)."'";
					$SIS_data .= ",'".fecha2Ano($f_programacion)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($f_programacion_fin) && $f_programacion_fin!=''){
					$SIS_data .= ",'".$f_programacion_fin."'";
					$SIS_data .= ",'".fecha2NdiaMes($f_programacion_fin)."'";
					$SIS_data .= ",'".fecha2NSemana($f_programacion_fin)."'";
					$SIS_data .= ",'".fecha2NMes($f_programacion_fin)."'";
					$SIS_data .= ",'".fecha2Ano($f_programacion_fin)."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($horaProg) && $horaProg!=''){                                        $SIS_data .= ",'".$horaProg."'";                      }else{$SIS_data .= ",''";}
				if(isset($horaProg_fin) && $horaProg_fin!=''){                                $SIS_data .= ",'".$horaProg_fin."'";                  }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['Mojamiento']) && $rowSolicitud['Mojamiento']!=''){    $SIS_data .= ",'".$rowSolicitud['Mojamiento']."'";    }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['VelTractor']) && $rowSolicitud['VelTractor']!=''){    $SIS_data .= ",'".$rowSolicitud['VelTractor']."'";    }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['VelViento']) && $rowSolicitud['VelViento']!=''){      $SIS_data .= ",'".$rowSolicitud['VelViento']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['TempMin']) && $rowSolicitud['TempMin']!=''){          $SIS_data .= ",'".$rowSolicitud['TempMin']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['TempMax']) && $rowSolicitud['TempMax']!=''){          $SIS_data .= ",'".$rowSolicitud['TempMax']."'";       }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['HumTempMax']) && $rowSolicitud['HumTempMax']!=''){    $SIS_data .= ",'".$rowSolicitud['HumTempMax']."'";    }else{$SIS_data .= ",''";}
				if(isset($rowSolicitud['idPrioridad']) && $rowSolicitud['idPrioridad']!=''){  $SIS_data .= ",'".$rowSolicitud['idPrioridad']."'";   }else{$SIS_data .= ",''";}
				if(isset($NSolicitud) && $NSolicitud!=''){                                    $SIS_data .= ",'".$NSolicitud."'";                    }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idPredio, idUsuario, idEstado, idTemporada,
				idEstadoFen, idCategoria, idProducto, f_creacion, f_programacion, progDia, progSemana, progMes, progAno, f_programacion_fin,
				progDia_fin, progSemana_fin, progMes_fin, progAno_fin, horaProg, horaProg_fin, Mojamiento, VelTractor, VelViento, TempMin,
				TempMax, HumTempMax, idPrioridad, NSolicitud';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Solo si se ejecuto correctamente
					if(isset($ultimo_id)&&$ultimo_id!=''){
						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
						if(isset($f_creacion) && $f_creacion!=''){
							$SIS_data .= ",'".$f_creacion."'";
						}else{
							$SIS_data .= ",''";
						}
						$SIS_data .= ",'".$Observaciones."'";    //Observacion
						$SIS_data .= ",'".$idUsuario."'";        //idUsuario
						$SIS_data .= ",'".$idEstado."'";        //Guardo el estado

						// inserto los datos de registro en la db
						$SIS_columns = 'idSolicitud, Creacion_fecha, Observacion, idUsuario, idEstado';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//se guardan los materiales
						if($arrMateriales!=false && !empty($arrMateriales) && $arrMateriales!=''){

							/*******************************************/
							//se recorren los materiales
							foreach ($arrMateriales as $mat){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                           $SIS_data = "'".$ultimo_id."'";                 }else{$SIS_data  = "''";}
								if(isset($mat['idMatSeguridad']) && $mat['idMatSeguridad']!=''){   $SIS_data .= ",'".$mat['idMatSeguridad']."'";   }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSolicitud, idMatSeguridad';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_materiales', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}

						/*********************************************************************/
						//se guardan los cuarteles
						if($arrCuarteles!=false && !empty($arrCuarteles) && $arrCuarteles!=''){

							/*******************************************/
							//se recorren los cuarteles
							foreach ($arrCuarteles as $cuartel){

								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                             $SIS_data = "'".$ultimo_id."'";                  }else{$SIS_data  = "''";}
								if(isset($cuartel['idZona']) && $cuartel['idZona']!=''){             $SIS_data .= ",'".$cuartel['idZona']."'";        }else{$SIS_data .= ",''";}
								if(isset($cuartel['Mojamiento']) && $cuartel['Mojamiento']!=''){     $SIS_data .= ",'".$cuartel['Mojamiento']."'";    }else{$SIS_data .= ",''";}
								if(isset($cuartel['VelTractor']) && $cuartel['VelTractor']!=''){     $SIS_data .= ",'".$cuartel['VelTractor']."'";    }else{$SIS_data .= ",''";}
								if(isset($cuartel['VelViento']) && $cuartel['VelViento']!=''){       $SIS_data .= ",'".$cuartel['VelViento']."'";     }else{$SIS_data .= ",''";}
								if(isset($cuartel['TempMin']) && $cuartel['TempMin']!=''){           $SIS_data .= ",'".$cuartel['TempMin']."'";       }else{$SIS_data .= ",''";}
								if(isset($cuartel['TempMax']) && $cuartel['TempMax']!=''){           $SIS_data .= ",'".$cuartel['TempMax']."'";       }else{$SIS_data .= ",''";}
								if(isset($cuartel['HumTempMax']) && $cuartel['HumTempMax']!=''){     $SIS_data .= ",'".$cuartel['HumTempMax']."'";    }else{$SIS_data .= ",''";}
								$SIS_data .= ",'1'"; //se asigna el estado
								if(isset($cuartel['idCategoria']) && $cuartel['idCategoria']!=''){   $SIS_data .= ",'".$cuartel['idCategoria']."'";   }else{$SIS_data .= ",''";}
								if(isset($cuartel['idProducto']) && $cuartel['idProducto']!=''){     $SIS_data .= ",'".$cuartel['idProducto']."'";    }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSolicitud, idZona, Mojamiento, VelTractor, VelViento, TempMin, TempMax, HumTempMax, idEstado, idCategoria, idProducto';
								$ultimo_cuartel = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_cuarteles', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*******************************************/
								//se recorren los tractores
								if($arrTractores!=false && !empty($arrTractores) && $arrTractores!=''){
									//Se recorren los tractores
									foreach ($arrTractores as $tract){
										//si pertenece al mismo cuartel
										if($cuartel['idCuarteles']==$tract['idCuarteles']){
											//filtros
											if(isset($ultimo_id) && $ultimo_id!=''){                          $SIS_data = "'".$ultimo_id."'";                 }else{$SIS_data  = "''";}
											if(isset($ultimo_cuartel) && $ultimo_cuartel!=''){                $SIS_data .= ",'".$ultimo_cuartel."'";          }else{$SIS_data .= ",''";}
											if(isset($tract['idTelemetria']) && $tract['idTelemetria']!=''){  $SIS_data .= ",'".$tract['idTelemetria']."'";   }else{$SIS_data .= ",''";}
											if(isset($tract['idVehiculo']) && $tract['idVehiculo']!=''){      $SIS_data .= ",'".$tract['idVehiculo']."'";     }else{$SIS_data .= ",''";}
											if(isset($tract['idTrabajador']) && $tract['idTrabajador']!=''){  $SIS_data .= ",'".$tract['idTrabajador']."'";   }else{$SIS_data .= ",''";}

											// inserto los datos de registro en la db
											$SIS_columns = 'idSolicitud, idCuarteles, idTelemetria, idVehiculo, idTrabajador';
											$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_tractores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}
									}
								}
								/*******************************************/
								//se recorren los cuarteles
								if($arrProductos!=false && !empty($arrProductos) && $arrProductos!=''){
									//Se recorren los quimicos a utilizar
									foreach ($arrProductos as $prod){
										//si pertenece al mismo cuartel
										if($cuartel['idCuarteles']==$prod['idCuarteles']){
											//filtros
											if(isset($ultimo_id) && $ultimo_id!=''){                                $SIS_data  = "'".$ultimo_id."'";                   }else{$SIS_data  = "''";}
											if(isset($ultimo_cuartel) && $ultimo_cuartel!=''){                      $SIS_data .= ",'".$ultimo_cuartel."'";             }else{$SIS_data .= ",''";}
											if(isset($prod['idProducto']) && $prod['idProducto']!=''){              $SIS_data .= ",'".$prod['idProducto']."'";         }else{$SIS_data .= ",''";}
											if(isset($prod['DosisRecomendada']) && $prod['DosisRecomendada']!=''){  $SIS_data .= ",'".$prod['DosisRecomendada']."'";   }else{$SIS_data .= ",''";}
											if(isset($prod['DosisAplicar']) && $prod['DosisAplicar']!=''){          $SIS_data .= ",'".$prod['DosisAplicar']."'";       }else{$SIS_data .= ",''";}
											if(isset($prod['idUml']) && $prod['idUml']!=''){                        $SIS_data .= ",'".$prod['idUml']."'";              }else{$SIS_data .= ",''";}
											if(isset($prod['Objetivo']) && $prod['Objetivo']!=''){                  $SIS_data .= ",'".$prod['Objetivo']."'";           }else{$SIS_data .= ",''";}

											// inserto los datos de registro en la db
											$SIS_columns = 'idSolicitud, idCuarteles, idProducto, DosisRecomendada, DosisAplicar, idUml, Objetivo';
											$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'cross_solicitud_aplicacion_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

										}
									}
								}
							}
						}

						/******************************************/
						//En base al estado se hacen las consultas
						$transaccion = 'cross_solicitud_aplicacion_ejecutar.php';
						$xbody = '
						<h3>Se ha creado la solicitud N° '.n_doc($NSolicitud, 5).'</h3>
						<p>Se ha cambiado el estado a Programado en la siguiente solicitud</p>
						<a href="'.DB_SITE_MAIN.'/view_solicitud_aplicacion.php?view='.simpleEncode($ultimo_id, fecha_actual()).'">Ver Aqui</a>';

						//Permisos a las transacciones
						$SIS_query = '
						usuarios_listado.usuario AS UsuarioNick,
						usuarios_listado.email AS UsuarioEmail,
						usuarios_listado.Nombre AS UsuarioNombre,
						core_sistemas.email_principal AS EmpresaCorreo,
						core_sistemas.Nombre AS EmpresaNombre,
						core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
						core_sistemas.Config_Gmail_Password AS Gmail_Password';
						$SIS_join  = '
						INNER JOIN `usuarios_permisos`  ON usuarios_permisos.idAdmpm    = core_permisos_listado.idAdmpm
						LEFT JOIN `usuarios_listado`    ON usuarios_listado.idUsuario   = usuarios_permisos.idUsuario
						INNER JOIN `usuarios_sistemas`  ON usuarios_sistemas.idUsuario  = usuarios_listado.idUsuario
						LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema      = usuarios_sistemas.idSistema';
						$SIS_where = 'core_permisos_listado.Direccionbase="'.$transaccion.'"
						AND usuarios_sistemas.idSistema = "'.$idSistema.'"';
						$SIS_order = 0;
						$arrCorreos = array();
						$arrCorreos = db_select_array (false, $SIS_query, 'core_permisos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Notificaciones a los correos
						foreach ($arrCorreos as $correo) {
							//Envio de correo
							$rmail = tareas_envio_correo($correo['EmpresaCorreo'], $correo['EmpresaNombre'],
														 $correo['UsuarioEmail'], $correo['UsuarioNombre'],
														 '', '',
														 'Notificación creación de Consolidacion',
														 $xbody,'',
														 '',
														 1,
														 $correo['Gmail_Usuario'],
														 $correo['Gmail_Password']);
							//se guarda el log
							log_response(1, $rmail, $correo['UsuarioEmail'].' (Asunto:Notificación creación de Consolidacion)');
						}

						header( 'Location: '.$location.'&cloned=true' );
						die;
					}
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
