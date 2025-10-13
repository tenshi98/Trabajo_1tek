<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-250).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idOT']))                     $idOT                    = $_POST['idOT'];
	if (!empty($_POST['idSistema']))                $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idUbicacion']))              $idUbicacion             = $_POST['idUbicacion'];
	if (!empty($_POST['idUbicacion_lvl_1']))        $idUbicacion_lvl_1       = $_POST['idUbicacion_lvl_1'];
	if (!empty($_POST['idUbicacion_lvl_2']))        $idUbicacion_lvl_2       = $_POST['idUbicacion_lvl_2'];
	if (!empty($_POST['idUbicacion_lvl_3']))        $idUbicacion_lvl_3       = $_POST['idUbicacion_lvl_3'];
	if (!empty($_POST['idUbicacion_lvl_4']))        $idUbicacion_lvl_4       = $_POST['idUbicacion_lvl_4'];
	if (!empty($_POST['idUbicacion_lvl_5']))        $idUbicacion_lvl_5       = $_POST['idUbicacion_lvl_5'];
	if (!empty($_POST['idUsuario']))                $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))                 $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idPrioridad']))              $idPrioridad             = $_POST['idPrioridad'];
	if (!empty($_POST['idTipo']))                   $idTipo                  = $_POST['idTipo'];
	if (!empty($_POST['f_creacion']))               $f_creacion 	           = $_POST['f_creacion'];
	if (!empty($_POST['f_programacion']))           $f_programacion          = $_POST['f_programacion'];
	if (!empty($_POST['f_programacion_Dia']))       $f_programacion_Dia      = $_POST['f_programacion_Dia'];
	if (!empty($_POST['f_programacion_Semana']))    $f_programacion_Semana   = $_POST['f_programacion_Semana'];
	if (!empty($_POST['f_programacion_Mes']))       $f_programacion_Mes      = $_POST['f_programacion_Mes'];
	if (!empty($_POST['f_programacion_Ano']))       $f_programacion_Ano      = $_POST['f_programacion_Ano'];
	if (!empty($_POST['f_termino']))                $f_termino 	           = $_POST['f_termino'];
	if (!empty($_POST['f_termino_Dia']))            $f_termino_Dia 	       = $_POST['f_termino_Dia'];
	if (!empty($_POST['f_termino_Semana']))         $f_termino_Semana 	   = $_POST['f_termino_Semana'];
	if (!empty($_POST['f_termino_Mes']))            $f_termino_Mes 	       = $_POST['f_termino_Mes'];
	if (!empty($_POST['f_termino_Ano']))            $f_termino_Ano 	       = $_POST['f_termino_Ano'];
	if (!empty($_POST['hora_Inicio']))              $hora_Inicio 	           = $_POST['hora_Inicio'];
	if (!empty($_POST['hora_Termino']))             $hora_Termino 	       = $_POST['hora_Termino'];
	if (!empty($_POST['Observaciones']))            $Observaciones           = $_POST['Observaciones'];
	if (!empty($_POST['idUsuarioCancel']))          $idUsuarioCancel         = $_POST['idUsuarioCancel'];
	if (!empty($_POST['f_cancel']))                 $f_cancel                = $_POST['f_cancel'];
	if (!empty($_POST['ObservacionesCancel']))      $ObservacionesCancel     = $_POST['ObservacionesCancel'];

	//Traspaso de valores input a variables
	if (!empty($_POST['idTrabajoOT']))          $idTrabajoOT             = $_POST['idTrabajoOT'];
	if (!empty($_POST['idEstadoTarea']))        $idEstadoTarea           = $_POST['idEstadoTarea'];
	if (!empty($_POST['idLicitacion']))         $idLicitacion            = $_POST['idLicitacion'];
	$idLevel = array();
	if (!empty($_POST['idLevel_1']))            $idLevel[1]              = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))            $idLevel[2]              = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))            $idLevel[3]              = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))            $idLevel[4]              = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))            $idLevel[5]              = $_POST['idLevel_5'];
	if (!empty($_POST['idLevel_6']))            $idLevel[6]              = $_POST['idLevel_6'];
	if (!empty($_POST['idLevel_7']))            $idLevel[7]              = $_POST['idLevel_7'];
	if (!empty($_POST['idLevel_8']))            $idLevel[8]              = $_POST['idLevel_8'];
	if (!empty($_POST['idLevel_9']))            $idLevel[9]              = $_POST['idLevel_9'];
	if (!empty($_POST['idLevel_10']))           $idLevel[10]             = $_POST['idLevel_10'];
	if (!empty($_POST['idLevel_11']))           $idLevel[11]             = $_POST['idLevel_11'];
	if (!empty($_POST['idLevel_12']))           $idLevel[12]             = $_POST['idLevel_12'];
	if (!empty($_POST['idLevel_13']))           $idLevel[13]             = $_POST['idLevel_13'];
	if (!empty($_POST['idLevel_14']))           $idLevel[14]             = $_POST['idLevel_14'];
	if (!empty($_POST['idLevel_15']))           $idLevel[15]             = $_POST['idLevel_15'];
	if (!empty($_POST['idLevel_16']))           $idLevel[16]             = $_POST['idLevel_16'];
	if (!empty($_POST['idLevel_17']))           $idLevel[17]             = $_POST['idLevel_17'];
	if (!empty($_POST['idLevel_18']))           $idLevel[18]             = $_POST['idLevel_18'];
	if (!empty($_POST['idLevel_19']))           $idLevel[19]             = $_POST['idLevel_19'];
	if (!empty($_POST['idLevel_20']))           $idLevel[20]             = $_POST['idLevel_20'];
	if (!empty($_POST['idLevel_21']))           $idLevel[21]             = $_POST['idLevel_21'];
	if (!empty($_POST['idLevel_22']))           $idLevel[22]             = $_POST['idLevel_22'];
	if (!empty($_POST['idLevel_23']))           $idLevel[23]             = $_POST['idLevel_23'];
	if (!empty($_POST['idLevel_24']))           $idLevel[24]             = $_POST['idLevel_24'];
	if (!empty($_POST['idLevel_25']))           $idLevel[25]             = $_POST['idLevel_25'];
	if (!empty($_POST['Observacion']))          $Observacion             = $_POST['Observacion'];

	//otros datos
	if (!empty($_POST['idTrabajador']))         $idTrabajador            = $_POST['idTrabajador'];
	if (!empty($_POST['idProducto']))           $idProducto              = $_POST['idProducto'];
	if (!empty($_POST['Cantidad']))             $Cantidad                = $_POST['Cantidad'];
	if (!empty($_POST['idResponsable']))        $idResponsable           = $_POST['idResponsable'];
	if (!empty($_POST['idInsumos']))            $idInsumos               = $_POST['idInsumos'];
	if (!empty($_POST['idProductos']))          $idProductos             = $_POST['idProductos'];

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
			case 'idOT':                      if(empty($idOT)){                   $error['idOT']                    = 'error/No ha ingresado el id del sistema';}break;
			case 'idSistema':                 if(empty($idSistema)){              $error['idSistema']               = 'error/No ha ingresado el idSistema del sistema';}break;
			case 'idUbicacion':               if(empty($idUbicacion)){            $error['idUbicacion']             = 'error/No ha seleccionado una ubicacion';}break;
			case 'idUbicacion_lvl_1':         if(empty($idUbicacion_lvl_1)){      $error['idUbicacion_lvl_1']       = 'error/No ha seleccionado el nivel 1 de la ubicacion';}break;
			case 'idUbicacion_lvl_2':         if(empty($idUbicacion_lvl_2)){      $error['idUbicacion_lvl_2']       = 'error/No ha seleccionado el nivel 2 de la ubicacion';}break;
			case 'idUbicacion_lvl_3':         if(empty($idUbicacion_lvl_3)){      $error['idUbicacion_lvl_3']       = 'error/No ha seleccionado el nivel 3 de la ubicacion';}break;
			case 'idUbicacion_lvl_4':         if(empty($idUbicacion_lvl_4)){      $error['idUbicacion_lvl_4']       = 'error/No ha seleccionado el nivel 4 de la ubicacion';}break;
			case 'idUbicacion_lvl_5':         if(empty($idUbicacion_lvl_5)){      $error['idUbicacion_lvl_5']       = 'error/No ha seleccionado el nivel 5 de la ubicacion';}break;
			case 'idUsuario':                 if(empty($idUsuario)){              $error['idUsuario']               = 'error/No ha ingresado el usuario';}break;
			case 'idEstado':                  if(empty($idEstado)){               $error['idEstado']                = 'error/No ha ingresado el estado';}break;
			case 'idPrioridad':               if(empty($idPrioridad)){            $error['idPrioridad']             = 'error/No ha ingresado la prioridad';}break;
			case 'idTipo':                    if(empty($idTipo)){                 $error['idTipo']                  = 'error/No ha ingresado el tipo';}break;
			case 'f_creacion':                if(empty($f_creacion)){             $error['f_creacion']              = 'error/No ha ingresado la fecha de creación';}break;
			case 'f_programacion':            if(empty($f_programacion)){         $error['f_programacion']          = 'error/No ha ingresado la fecha de programacion';}break;
			case 'f_programacion_Dia':        if(empty($f_programacion_Dia)){     $error['f_programacion_Dia']      = 'error/No ha ingresado el dia de la fecha de programacion';}break;
			case 'f_programacion_Semana':     if(empty($f_programacion_Semana)){  $error['f_programacion_Semana']   = 'error/No ha ingresado la semana de la fecha de programacion';}break;
			case 'f_programacion_Mes':        if(empty($f_programacion_Mes)){     $error['f_programacion_Mes']      = 'error/No ha ingresado el mes de la fecha de programacion';}break;
			case 'f_programacion_Ano':        if(empty($f_programacion_Ano)){     $error['f_programacion_Ano']      = 'error/No ha ingresado el año de la fecha de programacion';}break;
			case 'f_termino':                 if(empty($f_termino)){              $error['f_termino']               = 'error/No ha ingresado la fecha de termino';}break;
			case 'f_termino_Dia':             if(empty($f_termino_Dia)){          $error['f_termino_Dia']           = 'error/No ha ingresado el dia de la fecha de termino';}break;
			case 'f_termino_Semana':          if(empty($f_termino_Semana)){       $error['f_termino_Semana']        = 'error/No ha ingresado la semana de la fecha de termino';}break;
			case 'f_termino_Mes':             if(empty($f_termino_Mes)){          $error['f_termino_Mes']           = 'error/No ha ingresado el mes de la fecha de termino';}break;
			case 'f_termino_Ano':             if(empty($f_termino_Ano)){          $error['f_termino_Ano']           = 'error/No ha ingresado el año de la fecha de termino';}break;
			case 'hora_Inicio':               if(empty($hora_Inicio)){            $error['hora_Inicio']             = 'error/No ha ingresado la hora de inicio';}break;
			case 'hora_Termino':              if(empty($hora_Termino)){           $error['hora_Termino']            = 'error/No ha ingresado la hora de termino';}break;
			case 'Observaciones':             if(empty($Observaciones)){          $error['Observaciones']           = 'error/No ha ingresado la observacion';}break;
			case 'idUsuarioCancel':           if(empty($idUsuarioCancel)){        $error['idUsuarioCancel']         = 'error/No ha ingresado el usuario que cancelo la ot';}break;
			case 'f_cancel':                  if(empty($f_cancel)){               $error['f_cancel']                = 'error/No ha ingresado la fecha de cancelacion de la ot';}break;
			case 'ObservacionesCancel':       if(empty($ObservacionesCancel)){    $error['ObservacionesCancel']     = 'error/No ha ingresado la observacion de cancelacion de la ot';}break;

			case 'idTrabajoOT':           if(empty($idTrabajoOT)){            $error['idTrabajoOT']             = 'error/No ha seleccionado la tarea';}break;
			case 'idEstadoTarea':         if(empty($idEstadoTarea)){          $error['idEstadoTarea']           = 'error/No ha seleccionado el estado de la tarea';}break;
			case 'idLicitacion':          if(empty($idLicitacion)){           $error['idLicitacion']            = 'error/No ha seleccionado el contrato';}break;
			case 'idLevel_1':             if(empty($idLevel[1])){             $error['idLevel_1']               = 'error/No ha ingresado el idLevel_1';}break;
			case 'idLevel_2':             if(empty($idLevel[2])){             $error['idLevel_2']               = 'error/No ha ingresado el idLevel_2';}break;
			case 'idLevel_3':             if(empty($idLevel[3])){             $error['idLevel_3']               = 'error/No ha ingresado el idLevel_3';}break;
			case 'idLevel_4':             if(empty($idLevel[4])){             $error['idLevel_4']               = 'error/No ha ingresado el idLevel_4';}break;
			case 'idLevel_5':             if(empty($idLevel[5])){             $error['idLevel_5']               = 'error/No ha ingresado el idLevel_5';}break;
			case 'idLevel_6':             if(empty($idLevel[6])){             $error['idLevel_6']               = 'error/No ha ingresado el idLevel_6';}break;
			case 'idLevel_7':             if(empty($idLevel[7])){             $error['idLevel_7']               = 'error/No ha ingresado el idLevel_7';}break;
			case 'idLevel_8':             if(empty($idLevel[8])){             $error['idLevel_8']               = 'error/No ha ingresado el idLevel_8';}break;
			case 'idLevel_9':             if(empty($idLevel[9])){             $error['idLevel_9']               = 'error/No ha ingresado el idLevel_9';}break;
			case 'idLevel_10':            if(empty($idLevel[10])){            $error['idLevel_10']              = 'error/No ha ingresado el idLevel_10';}break;
			case 'idLevel_11':            if(empty($idLevel[11])){            $error['idLevel_11']              = 'error/No ha ingresado el idLevel_11';}break;
			case 'idLevel_12':            if(empty($idLevel[12])){            $error['idLevel_12']              = 'error/No ha ingresado el idLevel_12';}break;
			case 'idLevel_13':            if(empty($idLevel[13])){            $error['idLevel_13']              = 'error/No ha ingresado el idLevel_13';}break;
			case 'idLevel_14':            if(empty($idLevel[14])){            $error['idLevel_14']              = 'error/No ha ingresado el idLevel_14';}break;
			case 'idLevel_15':            if(empty($idLevel[15])){            $error['idLevel_15']              = 'error/No ha ingresado el idLevel_15';}break;
			case 'idLevel_16':            if(empty($idLevel[16])){            $error['idLevel_16']              = 'error/No ha ingresado el idLevel_16';}break;
			case 'idLevel_17':            if(empty($idLevel[17])){            $error['idLevel_17']              = 'error/No ha ingresado el idLevel_17';}break;
			case 'idLevel_18':            if(empty($idLevel[18])){            $error['idLevel_18']              = 'error/No ha ingresado el idLevel_18';}break;
			case 'idLevel_19':            if(empty($idLevel[19])){            $error['idLevel_19']              = 'error/No ha ingresado el idLevel_19';}break;
			case 'idLevel_20':            if(empty($idLevel[20])){            $error['idLevel_20']              = 'error/No ha ingresado el idLevel_20';}break;
			case 'idLevel_21':            if(empty($idLevel[21])){            $error['idLevel_21']              = 'error/No ha ingresado el idLevel_21';}break;
			case 'idLevel_22':            if(empty($idLevel[22])){            $error['idLevel_22']              = 'error/No ha ingresado el idLevel_22';}break;
			case 'idLevel_23':            if(empty($idLevel[23])){            $error['idLevel_23']              = 'error/No ha ingresado el idLevel_23';}break;
			case 'idLevel_24':            if(empty($idLevel[24])){            $error['idLevel_24']              = 'error/No ha ingresado el idLevel_24';}break;
			case 'idLevel_25':            if(empty($idLevel[25])){            $error['idLevel_25']              = 'error/No ha ingresado el idLevel_25';}break;
			case 'Observacion':           if(empty($Observacion)){            $error['Observacion']             = 'error/No ha ingresado la observacion';}break;

			case 'idTrabajador':          if(empty($idTrabajador)){           $error['idTrabajador']            = 'error/No ha ingresado el trabajador';}break;
			case 'idProducto':            if(empty($idProducto)){             $error['idProducto']              = 'error/No ha ingresado el componente';}break;
			case 'Cantidad':              if(empty($Cantidad)){               $error['Cantidad']                = 'error/No ha ingresado la cantidad';}break;
			case 'idResponsable':         if(empty($idResponsable)){          $error['idResponsable']           = 'error/No ha seleccionado el responsable';}break;
			case 'idInsumos':             if(empty($idInsumos)){              $error['idInsumos']               = 'error/No ha seleccionado el insumo';}break;
			case 'idProductos':           if(empty($idProductos)){            $error['idProductos']             = 'error/No ha seleccionado el producto';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){             $Observaciones       = EstandarizarInput($Observaciones);}
	if(isset($ObservacionesCancel) && $ObservacionesCancel!=''){ $ObservacionesCancel = EstandarizarInput($ObservacionesCancel);}
	if(isset($Observacion) && $Observacion!=''){                 $Observacion         = EstandarizarInput($Observacion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){              $error['Observaciones']       = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($ObservacionesCancel)&&contar_palabras_censuradas($ObservacionesCancel)!=0){  $error['ObservacionesCancel'] = 'error/Edita ObservacionesCancel, contiene palabras no permitidas';}
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){                  $error['Observacion']         = 'error/Edita Observacion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'creacion':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones="Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['ot_motivo_basicos']);
				unset($_SESSION['ot_motivo_trabajador']);
				unset($_SESSION['ot_motivo_tareas']);
				unset($_SESSION['ot_motivo_temporal']);
				unset($_SESSION['ot_motivo_insumos']);
				unset($_SESSION['ot_motivo_productos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idUbicacion)&&$idUbicacion!=''){              $_SESSION['ot_motivo_basicos']['idUbicacion']       = $idUbicacion;       }else{$_SESSION['ot_motivo_basicos']['idUbicacion']        = '';}
				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1'] = $idUbicacion_lvl_1; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']  = '';}
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2'] = $idUbicacion_lvl_2; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']  = '';}
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3'] = $idUbicacion_lvl_3; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']  = '';}
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4'] = $idUbicacion_lvl_4; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']  = '';}
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5'] = $idUbicacion_lvl_5; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']  = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){              $_SESSION['ot_motivo_basicos']['idPrioridad']       = $idPrioridad;       }else{$_SESSION['ot_motivo_basicos']['idPrioridad']        = '';}
				if(isset($idTipo)&&$idTipo!=''){                        $_SESSION['ot_motivo_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['ot_motivo_basicos']['idTipo']             = '';}
				if(isset($f_programacion)&&$f_programacion!=''){        $_SESSION['ot_motivo_basicos']['f_programacion']    = $f_programacion;    }else{$_SESSION['ot_motivo_basicos']['f_programacion']     = '';}
				if(isset($idSistema)&&$idSistema!=''){                  $_SESSION['ot_motivo_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['ot_motivo_basicos']['idSistema']          = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                  $_SESSION['ot_motivo_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['ot_motivo_basicos']['idUsuario']          = '';}
				if(isset($idEstado)&&$idEstado!=''){                    $_SESSION['ot_motivo_basicos']['idEstado']          = $idEstado;          }else{$_SESSION['ot_motivo_basicos']['idEstado']           = '';}
				if(isset($f_creacion)&&$f_creacion!=''){                $_SESSION['ot_motivo_basicos']['f_creacion']        = $f_creacion;        }else{$_SESSION['ot_motivo_basicos']['f_creacion']         = '';}
				if(isset($Observaciones)&&$Observaciones!=''){          $_SESSION['ot_motivo_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['ot_motivo_basicos']['Observaciones']      = '';}

				//Se guarda el trabajador asignado
				if(isset($idTrabajador)&&$idTrabajador!=''){$_SESSION['ot_motivo_trabajador'][$idTrabajador]['idTrabajador'] = $idTrabajador;}

				/********************************************************************************/
				if(isset($idUbicacion) && $idUbicacion!=''){
					$subquery = '';
					if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_1` WHERE idLevel_1 = '.$idUbicacion_lvl_1.') AS LVL1';}
					if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_2` WHERE idLevel_2 = '.$idUbicacion_lvl_2.') AS LVL2';}
					if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_3` WHERE idLevel_3 = '.$idUbicacion_lvl_3.') AS LVL3';}
					if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_4` WHERE idLevel_4 = '.$idUbicacion_lvl_4.') AS LVL4';}
					if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_5` WHERE idLevel_5 = '.$idUbicacion_lvl_5.') AS LVL5';}
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre'.$subquery, 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Ubicacion'] = $rowUbicacion['Nombre'];
					if(isset($rowUbicacion['LVL1'])&&$rowUbicacion['LVL1']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL2'])&&$rowUbicacion['LVL2']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL3'])&&$rowUbicacion['LVL3']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL4'])&&$rowUbicacion['LVL4']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL5'])&&$rowUbicacion['LVL5']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
				}else{
					$_SESSION['ot_motivo_basicos']['Ubicacion'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_ot_prioridad', '', 'idPrioridad = '.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['ot_motivo_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_ot_motivos_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['ot_motivo_basicos']['Tipo'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Trabajador']   = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Cargo']        = $rowTrabajador['Cargo'];
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Rut']          = $rowTrabajador['Rut'];
				}else{
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Trabajador']   = '';
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Cargo']        = '';
					$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Rut']          = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clear_all':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_motivo_basicos']);
			unset($_SESSION['ot_motivo_trabajador']);
			unset($_SESSION['ot_motivo_tareas']);
			unset($_SESSION['ot_motivo_temporal']);
			unset($_SESSION['ot_motivo_insumos']);
			unset($_SESSION['ot_motivo_productos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				unset($_SESSION['ot_motivo_tareas']);
				unset($_SESSION['ot_motivo_temporal']);

				if(isset($idUbicacion)&&$idUbicacion!=''){              $_SESSION['ot_motivo_basicos']['idUbicacion']       = $idUbicacion;       }else{$_SESSION['ot_motivo_basicos']['idUbicacion']        = '';}
				if(isset($idUbicacion_lvl_1)&&$idUbicacion_lvl_1!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1'] = $idUbicacion_lvl_1; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']  = '';}
				if(isset($idUbicacion_lvl_2)&&$idUbicacion_lvl_2!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2'] = $idUbicacion_lvl_2; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']  = '';}
				if(isset($idUbicacion_lvl_3)&&$idUbicacion_lvl_3!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3'] = $idUbicacion_lvl_3; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']  = '';}
				if(isset($idUbicacion_lvl_4)&&$idUbicacion_lvl_4!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4'] = $idUbicacion_lvl_4; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']  = '';}
				if(isset($idUbicacion_lvl_5)&&$idUbicacion_lvl_5!=''){  $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5'] = $idUbicacion_lvl_5; }else{$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']  = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){              $_SESSION['ot_motivo_basicos']['idPrioridad']       = $idPrioridad;       }else{$_SESSION['ot_motivo_basicos']['idPrioridad']        = '';}
				if(isset($idTipo)&&$idTipo!=''){                        $_SESSION['ot_motivo_basicos']['idTipo']            = $idTipo;            }else{$_SESSION['ot_motivo_basicos']['idTipo']             = '';}
				if(isset($f_programacion)&&$f_programacion!=''){        $_SESSION['ot_motivo_basicos']['f_programacion']    = $f_programacion;    }else{$_SESSION['ot_motivo_basicos']['f_programacion']     = '';}
				if(isset($idSistema)&&$idSistema!=''){                  $_SESSION['ot_motivo_basicos']['idSistema']         = $idSistema;         }else{$_SESSION['ot_motivo_basicos']['idSistema']          = '';}
				if(isset($idUsuario)&&$idUsuario!=''){                  $_SESSION['ot_motivo_basicos']['idUsuario']         = $idUsuario;         }else{$_SESSION['ot_motivo_basicos']['idUsuario']          = '';}
				if(isset($idEstado)&&$idEstado!=''){                    $_SESSION['ot_motivo_basicos']['idEstado']          = $idEstado;          }else{$_SESSION['ot_motivo_basicos']['idEstado']           = '';}
				if(isset($f_creacion)&&$f_creacion!=''){                $_SESSION['ot_motivo_basicos']['f_creacion']        = $f_creacion;        }else{$_SESSION['ot_motivo_basicos']['f_creacion']         = '';}
				if(isset($Observaciones)&&$Observaciones!=''){          $_SESSION['ot_motivo_basicos']['Observaciones']     = $Observaciones;     }else{$_SESSION['ot_motivo_basicos']['Observaciones']      = '';}

				/********************************************************************************/
				if(isset($idUbicacion) && $idUbicacion!=''){
					$subquery = '';
					if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_1` WHERE idLevel_1 = '.$idUbicacion_lvl_1.') AS LVL1';}
					if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_2` WHERE idLevel_2 = '.$idUbicacion_lvl_2.') AS LVL2';}
					if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_3` WHERE idLevel_3 = '.$idUbicacion_lvl_3.') AS LVL3';}
					if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_4` WHERE idLevel_4 = '.$idUbicacion_lvl_4.') AS LVL4';}
					if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $subquery .= ',(SELECT Nombre FROM `ubicacion_listado_level_5` WHERE idLevel_5 = '.$idUbicacion_lvl_5.') AS LVL5';}
					// consulto los datos
					$rowUbicacion = db_select_data (false, 'Nombre'.$subquery, 'ubicacion_listado', '', 'idUbicacion = '.$idUbicacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Ubicacion'] = $rowUbicacion['Nombre'];
					if(isset($rowUbicacion['LVL1'])&&$rowUbicacion['LVL1']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL2'])&&$rowUbicacion['LVL2']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL3'])&&$rowUbicacion['LVL3']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL4'])&&$rowUbicacion['LVL4']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
					if(isset($rowUbicacion['LVL5'])&&$rowUbicacion['LVL5']!=''){$_SESSION['ot_motivo_basicos']['Ubicacion'] .= ' - '.$rowUbicacion['LVL1'];}
				}else{
					$_SESSION['ot_motivo_basicos']['Ubicacion'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_ot_prioridad', '', 'idPrioridad = '.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['ot_motivo_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_ot_motivos_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['ot_motivo_basicos']['Tipo'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'addTrab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el trabajador asignado
				$_SESSION['ot_motivo_trabajador'][$idTrabajador]['idTrabajador'] = $idTrabajador;
				$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Trabajador']   = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Cargo']        = $rowTrabajador['Cargo'];
				$_SESSION['ot_motivo_trabajador'][$idTrabajador]['Rut']          = $rowTrabajador['Rut'];

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_trab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_motivo_trabajador'][$_GET['del_trab']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'add_ins':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre AS NombreProducto, sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el insumos asignado
				$_SESSION['ot_motivo_insumos'][$idProducto]['idProducto'] = $idProducto;
				$_SESSION['ot_motivo_insumos'][$idProducto]['Cantidad']   = $Cantidad;
				$_SESSION['ot_motivo_insumos'][$idProducto]['Nombre']     = $rowProducto['NombreProducto'];
				$_SESSION['ot_motivo_insumos'][$idProducto]['Unimed']     = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_ins':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_motivo_insumos'][$_GET['del_ins']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'add_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowProducto = db_select_data (false, 'productos_listado.Nombre AS NombreProducto, sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el productos asignado
				$_SESSION['ot_motivo_productos'][$idProducto]['idProducto'] = $idProducto;
				$_SESSION['ot_motivo_productos'][$idProducto]['Cantidad']   = $Cantidad;
				$_SESSION['ot_motivo_productos'][$idProducto]['Nombre']     = $rowProducto['NombreProducto'];
				$_SESSION['ot_motivo_productos'][$idProducto]['Unimed']     = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_motivo_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'submit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Condiciono la variable observaciones
			if(empty($Observacion)){ $Observacion = "Sin observacion";}

			//se establece variable inicial
			$idInterno = 0;

			//verificar si la tarea ya existe
			if(isset($_SESSION['ot_motivo_tareas'])){
				foreach ($_SESSION['ot_motivo_tareas'] as $key => $trabajos){
					if(isset($trabajos['idInterno'])&&$trabajos['idInterno']!=''){
						$idInterno = $trabajos['idInterno'];
					}
				}
			}

			if(empty($error)){

				$idInterno = $idInterno+1;

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idInterno)&&$idInterno!=''){         $_SESSION['ot_motivo_tareas'][$idInterno]['idInterno']     = $idInterno;}
				if(isset($idEstadoTarea)&&$idEstadoTarea!=''){ $_SESSION['ot_motivo_tareas'][$idInterno]['idEstadoTarea'] = $idEstadoTarea;}
				if(isset($idLicitacion)&&$idLicitacion!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLicitacion']  = $idLicitacion;}
				if(isset($Observacion)&&$Observacion!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['Observacion']   = $Observacion;}
				if(isset($idLevel[1]) && $idLevel[1]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_1']     = $idLevel[1];}
				if(isset($idLevel[2]) && $idLevel[2]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_2']     = $idLevel[2];}
				if(isset($idLevel[3]) && $idLevel[3]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_3']     = $idLevel[3];}
				if(isset($idLevel[4]) && $idLevel[4]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_4']     = $idLevel[4];}
				if(isset($idLevel[5]) && $idLevel[5]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_5']     = $idLevel[5];}
				if(isset($idLevel[6]) && $idLevel[6]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_6']     = $idLevel[6];}
				if(isset($idLevel[7]) && $idLevel[7]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_7']     = $idLevel[7];}
				if(isset($idLevel[8]) && $idLevel[8]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_8']     = $idLevel[8];}
				if(isset($idLevel[9]) && $idLevel[9]!=''){     $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_9']     = $idLevel[9];}
				if(isset($idLevel[10]) && $idLevel[10]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_10']    = $idLevel[10];}
				if(isset($idLevel[11]) && $idLevel[11]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_11']    = $idLevel[11];}
				if(isset($idLevel[12]) && $idLevel[12]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_12']    = $idLevel[12];}
				if(isset($idLevel[13]) && $idLevel[13]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_13']    = $idLevel[13];}
				if(isset($idLevel[14]) && $idLevel[14]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_14']    = $idLevel[14];}
				if(isset($idLevel[15]) && $idLevel[15]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_15']    = $idLevel[15];}
				if(isset($idLevel[16]) && $idLevel[16]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_16']    = $idLevel[16];}
				if(isset($idLevel[17]) && $idLevel[17]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_17']    = $idLevel[17];}
				if(isset($idLevel[18]) && $idLevel[18]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_18']    = $idLevel[18];}
				if(isset($idLevel[19]) && $idLevel[19]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_19']    = $idLevel[19];}
				if(isset($idLevel[20]) && $idLevel[20]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_20']    = $idLevel[20];}
				if(isset($idLevel[21]) && $idLevel[21]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_21']    = $idLevel[21];}
				if(isset($idLevel[22]) && $idLevel[22]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_22']    = $idLevel[22];}
				if(isset($idLevel[23]) && $idLevel[23]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_23']    = $idLevel[23];}
				if(isset($idLevel[24]) && $idLevel[24]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_24']    = $idLevel[24];}
				if(isset($idLevel[25]) && $idLevel[25]!=''){   $_SESSION['ot_motivo_tareas'][$idInterno]['idLevel_25']    = $idLevel[25];}

				/********************************************************************************/
				if(isset($idLicitacion) && $idLicitacion!=''){
					$subquery = '';
					if(isset($idLevel[1]) && $idLevel[1]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_1`  WHERE idLevel_1 = '.$idLevel[1].') AS LVL1';}
					if(isset($idLevel[2]) && $idLevel[2]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_2`  WHERE idLevel_2 = '.$idLevel[2].') AS LVL2';}
					if(isset($idLevel[3]) && $idLevel[3]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_3`  WHERE idLevel_3 = '.$idLevel[3].') AS LVL3';}
					if(isset($idLevel[4]) && $idLevel[4]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_4`  WHERE idLevel_4 = '.$idLevel[4].') AS LVL4';}
					if(isset($idLevel[5]) && $idLevel[5]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_5`  WHERE idLevel_5 = '.$idLevel[5].') AS LVL5';}
					if(isset($idLevel[6]) && $idLevel[6]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_6`  WHERE idLevel_6 = '.$idLevel[6].') AS LVL6';}
					if(isset($idLevel[7]) && $idLevel[7]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_7`  WHERE idLevel_7 = '.$idLevel[7].') AS LVL7';}
					if(isset($idLevel[8]) && $idLevel[8]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_8`  WHERE idLevel_8 = '.$idLevel[8].') AS LVL8';}
					if(isset($idLevel[9]) && $idLevel[9]!=''){    $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_9`  WHERE idLevel_9 = '.$idLevel[9].') AS LVL9';}
					if(isset($idLevel[10]) && $idLevel[10]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_10` WHERE idLevel_10 = '.$idLevel[10].') AS LVL10';}
					if(isset($idLevel[11]) && $idLevel[11]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_11` WHERE idLevel_11 = '.$idLevel[11].') AS LVL11';}
					if(isset($idLevel[12]) && $idLevel[12]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_12` WHERE idLevel_12 = '.$idLevel[12].') AS LVL12';}
					if(isset($idLevel[13]) && $idLevel[13]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_13` WHERE idLevel_13 = '.$idLevel[13].') AS LVL13';}
					if(isset($idLevel[14]) && $idLevel[14]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_14` WHERE idLevel_14 = '.$idLevel[14].') AS LVL14';}
					if(isset($idLevel[15]) && $idLevel[15]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_15` WHERE idLevel_15 = '.$idLevel[15].') AS LVL15';}
					if(isset($idLevel[16]) && $idLevel[16]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_16` WHERE idLevel_16 = '.$idLevel[16].') AS LVL16';}
					if(isset($idLevel[17]) && $idLevel[17]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_17` WHERE idLevel_17 = '.$idLevel[17].') AS LVL17';}
					if(isset($idLevel[18]) && $idLevel[18]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_18` WHERE idLevel_18 = '.$idLevel[18].') AS LVL18';}
					if(isset($idLevel[19]) && $idLevel[19]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_19` WHERE idLevel_19 = '.$idLevel[19].') AS LVL19';}
					if(isset($idLevel[20]) && $idLevel[20]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_20` WHERE idLevel_20 = '.$idLevel[20].') AS LVL20';}
					if(isset($idLevel[21]) && $idLevel[21]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_21` WHERE idLevel_21 = '.$idLevel[21].') AS LVL21';}
					if(isset($idLevel[22]) && $idLevel[22]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_22` WHERE idLevel_22 = '.$idLevel[22].') AS LVL22';}
					if(isset($idLevel[23]) && $idLevel[23]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_23` WHERE idLevel_23 = '.$idLevel[23].') AS LVL23';}
					if(isset($idLevel[24]) && $idLevel[24]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_24` WHERE idLevel_24 = '.$idLevel[24].') AS LVL24';}
					if(isset($idLevel[25]) && $idLevel[25]!=''){  $subquery .= ',(SELECT Nombre FROM `licitacion_listado_level_25` WHERE idLevel_25 = '.$idLevel[25].') AS LVL25';}

					// consulto los datos
					$rowLicitacion = db_select_data (false, 'Nombre'.$subquery, 'licitacion_listado', '', 'idLicitacion = '.$idLicitacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_motivo_tareas'][$idInterno]['Licitacion'] = $rowLicitacion['Nombre'];
					//Tarea
					$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] = $rowLicitacion['LVL1'];
					if(isset($rowLicitacion['LVL2'])&&$rowLicitacion['LVL2']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL2'];}
					if(isset($rowLicitacion['LVL3'])&&$rowLicitacion['LVL3']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL3'];}
					if(isset($rowLicitacion['LVL4'])&&$rowLicitacion['LVL4']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL4'];}
					if(isset($rowLicitacion['LVL5'])&&$rowLicitacion['LVL5']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL5'];}
					if(isset($rowLicitacion['LVL6'])&&$rowLicitacion['LVL6']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL6'];}
					if(isset($rowLicitacion['LVL7'])&&$rowLicitacion['LVL7']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL7'];}
					if(isset($rowLicitacion['LVL8'])&&$rowLicitacion['LVL8']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL8'];}
					if(isset($rowLicitacion['LVL9'])&&$rowLicitacion['LVL9']!=''){  $_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL9'];}
					if(isset($rowLicitacion['LVL10'])&&$rowLicitacion['LVL10']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL10'];}
					if(isset($rowLicitacion['LVL11'])&&$rowLicitacion['LVL11']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL11'];}
					if(isset($rowLicitacion['LVL12'])&&$rowLicitacion['LVL12']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL12'];}
					if(isset($rowLicitacion['LVL13'])&&$rowLicitacion['LVL13']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL13'];}
					if(isset($rowLicitacion['LVL14'])&&$rowLicitacion['LVL14']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL14'];}
					if(isset($rowLicitacion['LVL15'])&&$rowLicitacion['LVL15']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL15'];}
					if(isset($rowLicitacion['LVL16'])&&$rowLicitacion['LVL16']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL16'];}
					if(isset($rowLicitacion['LVL17'])&&$rowLicitacion['LVL17']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL17'];}
					if(isset($rowLicitacion['LVL18'])&&$rowLicitacion['LVL18']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL18'];}
					if(isset($rowLicitacion['LVL19'])&&$rowLicitacion['LVL19']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL19'];}
					if(isset($rowLicitacion['LVL20'])&&$rowLicitacion['LVL20']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL20'];}
					if(isset($rowLicitacion['LVL21'])&&$rowLicitacion['LVL21']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL21'];}
					if(isset($rowLicitacion['LVL22'])&&$rowLicitacion['LVL22']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL22'];}
					if(isset($rowLicitacion['LVL23'])&&$rowLicitacion['LVL23']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL23'];}
					if(isset($rowLicitacion['LVL24'])&&$rowLicitacion['LVL24']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL24'];}
					if(isset($rowLicitacion['LVL25'])&&$rowLicitacion['LVL25']!=''){$_SESSION['ot_motivo_tareas'][$idInterno]['Tarea'] .= ' - '.$rowLicitacion['LVL25'];}

				}else{
					$_SESSION['ot_motivo_tareas'][$idInterno]['Licitacion'] = '';
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_motivo_tareas'][$_GET['idInterno']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'crear_ot':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//variables
			$n_trabajadores = 0;
			$n_trabajos     = 0;

			//Se verifican los datos basicos
			if (isset($_SESSION['ot_motivo_basicos'])){
				if(!isset($_SESSION['ot_motivo_basicos']['idSistema']) OR $_SESSION['ot_motivo_basicos']['idSistema']=='' ){                  $error['idSistema']          = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['ot_motivo_basicos']['idUbicacion']) OR $_SESSION['ot_motivo_basicos']['idUbicacion']=='' ){              $error['idUbicacion']        = 'error/No ha seleccionado la ubicacion';}
				if(!isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) OR $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']=='' ){  $error['idUbicacion_lvl_1']  = 'error/No ha seleccionado la el nivel 1 de la ubicacion';}
				if(!isset($_SESSION['ot_motivo_basicos']['idUsuario']) OR $_SESSION['ot_motivo_basicos']['idUsuario']=='' ){                  $error['idUsuario']          = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['ot_motivo_basicos']['idEstado']) OR $_SESSION['ot_motivo_basicos']['idEstado']=='' ){                    $error['idEstado']           = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['ot_motivo_basicos']['idPrioridad']) OR $_SESSION['ot_motivo_basicos']['idPrioridad']=='' ){              $error['idPrioridad']        = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['ot_motivo_basicos']['idTipo']) OR $_SESSION['ot_motivo_basicos']['idTipo']=='' ){                        $error['idTipo']             = 'error/No ha seleccionado el tipo de trabajo';}
				if(!isset($_SESSION['ot_motivo_basicos']['f_creacion']) OR $_SESSION['ot_motivo_basicos']['f_creacion']=='' ){                $error['f_creacion']         = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['ot_motivo_basicos']['f_programacion']) OR $_SESSION['ot_motivo_basicos']['f_programacion']=='' ){        $error['f_programacion']     = 'error/No ha ingresado la fecha de programacion';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la orden de trabajo';
			}
			//Se verifica que tenga trabajadores asignados
			if (isset($_SESSION['ot_motivo_trabajador'])){
				foreach ($_SESSION['ot_motivo_trabajador'] as $key => $trabajador){
					if(!isset($trabajador['idTrabajador']) OR $trabajador['idTrabajador'] == ''){  $error['idTrabajador']   = 'error/No ha ingresado un trabajador';}
					$n_trabajadores++;
				}
			}else{
				$error['trabajador'] = 'error/No tiene trabajadores asignados a la orden de trabajo';
			}
			//Se verifica que los trabajos tengan datos asignados
			if (isset($_SESSION['ot_motivo_tareas'])){
				foreach ($_SESSION['ot_motivo_tareas'] as $key => $x_tabla){
					$n_trabajos++;
				}
			}else{
				$error['trabajos'] = 'error/No tiene tareas asignados a la orden de trabajo';
			}

			//Se verifica el minimo de trabajadores
			if(isset($n_trabajadores)&&$n_trabajadores==0){
				$error['trabajos'] = 'error/No tiene trabajadores asignados a la orden de trabajo';
			}

			//Se verifica el minimo de trabajos
			if(isset($n_trabajos)&&$n_trabajos==0){
				$error['trabajos'] = 'error/No tiene tareas asignados a la orden de trabajo';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['ot_motivo_basicos']['idSistema']) && $_SESSION['ot_motivo_basicos']['idSistema']!=''){                  $SIS_data  = "'".$_SESSION['ot_motivo_basicos']['idSistema']."'";          }else{$SIS_data  = "''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion']) && $_SESSION['ot_motivo_basicos']['idUbicacion']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idUsuario']) && $_SESSION['ot_motivo_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idEstado']) && $_SESSION['ot_motivo_basicos']['idEstado']!=''){                    $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idEstado']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idPrioridad']) && $_SESSION['ot_motivo_basicos']['idPrioridad']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idPrioridad']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['idTipo']) && $_SESSION['ot_motivo_basicos']['idTipo']!=''){                        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){                $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_motivo_basicos']['f_programacion']) && $_SESSION['ot_motivo_basicos']['f_programacion']!=''){
					$SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_programacion']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['ot_motivo_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['ot_motivo_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['ot_motivo_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['ot_motivo_basicos']['f_programacion'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['ot_motivo_basicos']['Observaciones']) && $_SESSION['ot_motivo_basicos']['Observaciones']!=''){   $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['Observaciones']."'";      }else{$SIS_data .= ",'Sin Observaciones'";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idUsuario, idEstado, 
				idPrioridad, idTipo, f_creacion, f_programacion, f_programacion_Dia, f_programacion_Semana,
				f_programacion_Mes, f_programacion_Ano, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*****************************************************/
					//Se guardan los datos de los trabajadores de la ot
					foreach ($_SESSION['ot_motivo_trabajador'] as $key => $trabajador){

						//filtros
						if(isset($ultimo_id) && $ultimo_id!=''){                                                                                    $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
						if(isset($_SESSION['ot_motivo_basicos']['idSistema']) && $_SESSION['ot_motivo_basicos']['idSistema']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idSistema']."'";         }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion']) && $_SESSION['ot_motivo_basicos']['idUbicacion']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion']."'";       }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']."'"; }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']."'"; }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']."'"; }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']."'"; }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']."'"; }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idUsuario']) && $_SESSION['ot_motivo_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idEstado']) && $_SESSION['ot_motivo_basicos']['idEstado']!=''){                    $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idEstado']."'";          }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idPrioridad']) && $_SESSION['ot_motivo_basicos']['idPrioridad']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idPrioridad']."'";       }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['idTipo']) && $_SESSION['ot_motivo_basicos']['idTipo']!=''){                        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){                $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";        }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_motivo_basicos']['f_programacion']) && $_SESSION['ot_motivo_basicos']['f_programacion']!=''){        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_programacion']."'";    }else{$SIS_data .= ",''";}
						if(isset($trabajador['idTrabajador']) && $trabajador['idTrabajador']!=''){                                                  $SIS_data .= ",'".$trabajador['idTrabajador']."'";                         }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT,idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
						idUbicacion_lvl_5, idUsuario, idEstado,idPrioridad, idTipo, f_creacion, f_programacion,
						idTrabajador';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*****************************************************/
					//Se guardan los datos de los insumos si es que existen
					if (isset($_SESSION['ot_motivo_insumos'])){
						foreach ($_SESSION['ot_motivo_insumos'] as $key => $insumos){
							//se verifica la existencia
							if(isset($insumos['idProducto']) && $insumos['idProducto']!=''){
								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                    $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
								if(isset($_SESSION['ot_motivo_basicos']['idSistema']) && $_SESSION['ot_motivo_basicos']['idSistema']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idSistema']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion']) && $_SESSION['ot_motivo_basicos']['idUbicacion']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUsuario']) && $_SESSION['ot_motivo_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idEstado']) && $_SESSION['ot_motivo_basicos']['idEstado']!=''){                    $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idEstado']."'";          }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idPrioridad']) && $_SESSION['ot_motivo_basicos']['idPrioridad']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idPrioridad']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idTipo']) && $_SESSION['ot_motivo_basicos']['idTipo']!=''){                        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){                $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";        }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_programacion']) && $_SESSION['ot_motivo_basicos']['f_programacion']!=''){        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_programacion']."'";    }else{$SIS_data .= ",''";}
								if(isset($insumos['idProducto']) && $insumos['idProducto']!=''){                                                            $SIS_data .= ",'".$insumos['idProducto']."'";   				              }else{$SIS_data .= ",''";}
								if(isset($insumos['Cantidad']) && $insumos['Cantidad']!=''){                                                                $SIS_data .= ",'".$insumos['Cantidad']."'";                                }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT, idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
								idUbicacion_lvl_5, idUsuario, idEstado, idPrioridad, idTipo, f_creacion, f_programacion,
								idProducto,Cantidad';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*****************************************************/
					//Se guardan los datos de los productos si es que existen
					if (isset($_SESSION['ot_motivo_productos'])){
						foreach ($_SESSION['ot_motivo_productos'] as $key => $prod){
							//se verifica existencia
							if(isset($prod['idProducto']) && $prod['idProducto']!=''){
								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                    $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
								if(isset($_SESSION['ot_motivo_basicos']['idSistema']) && $_SESSION['ot_motivo_basicos']['idSistema']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idSistema']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion']) && $_SESSION['ot_motivo_basicos']['idUbicacion']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUsuario']) && $_SESSION['ot_motivo_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idEstado']) && $_SESSION['ot_motivo_basicos']['idEstado']!=''){                    $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idEstado']."'";          }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idPrioridad']) && $_SESSION['ot_motivo_basicos']['idPrioridad']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idPrioridad']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idTipo']) && $_SESSION['ot_motivo_basicos']['idTipo']!=''){                        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){                $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";        }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_programacion']) && $_SESSION['ot_motivo_basicos']['f_programacion']!=''){        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_programacion']."'";    }else{$SIS_data .= ",''";}
								if(isset($prod['idProducto']) && $prod['idProducto']!=''){                                                                  $SIS_data .= ",'".$prod['idProducto']."'";   				              }else{$SIS_data .= ",''";}
								if(isset($prod['Cantidad']) && $prod['Cantidad']!=''){                                                                      $SIS_data .= ",'".$prod['Cantidad']."'";                                   }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT, idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
								idUbicacion_lvl_5, idUsuario, idEstado, idPrioridad, idTipo, f_creacion, f_programacion,
								idProducto,Cantidad';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*****************************************************/
					//Se guardan los trabajos a realizar
					if (isset($_SESSION['ot_motivo_tareas'])){
						foreach ($_SESSION['ot_motivo_tareas'] as $key => $trabajos){
							//se verifica la existencia
							if(isset($trabajos['idLicitacion']) && $trabajos['idLicitacion']!=''){
								//filtros
								if(isset($ultimo_id) && $ultimo_id!=''){                                                                                    $SIS_data  = "'".$ultimo_id."'";                                           }else{$SIS_data  = "''";}
								if(isset($_SESSION['ot_motivo_basicos']['idSistema']) && $_SESSION['ot_motivo_basicos']['idSistema']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idSistema']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion']) && $_SESSION['ot_motivo_basicos']['idUbicacion']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_1']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_2']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_3']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_4']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']) && $_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUbicacion_lvl_5']."'"; }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idUsuario']) && $_SESSION['ot_motivo_basicos']['idUsuario']!=''){                  $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idUsuario']."'";         }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idEstado']) && $_SESSION['ot_motivo_basicos']['idEstado']!=''){                    $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idEstado']."'";          }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idPrioridad']) && $_SESSION['ot_motivo_basicos']['idPrioridad']!=''){              $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idPrioridad']."'";       }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['idTipo']) && $_SESSION['ot_motivo_basicos']['idTipo']!=''){                        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['idTipo']."'";            }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){                $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";        }else{$SIS_data .= ",''";}
								if(isset($_SESSION['ot_motivo_basicos']['f_programacion']) && $_SESSION['ot_motivo_basicos']['f_programacion']!=''){        $SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_programacion']."'";    }else{$SIS_data .= ",''";}
								if(isset($trabajos['idEstadoTarea']) && $trabajos['idEstadoTarea']!=''){                                                    $SIS_data .= ",'".$trabajos['idEstadoTarea']."'";                          }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLicitacion']) && $trabajos['idLicitacion']!=''){                                                      $SIS_data .= ",'".$trabajos['idLicitacion']."'";                           }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_1']) && $trabajos['idLevel_1']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_1']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_2']) && $trabajos['idLevel_2']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_2']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_3']) && $trabajos['idLevel_3']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_3']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_4']) && $trabajos['idLevel_4']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_4']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_5']) && $trabajos['idLevel_5']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_5']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_6']) && $trabajos['idLevel_6']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_6']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_7']) && $trabajos['idLevel_7']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_7']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_8']) && $trabajos['idLevel_8']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_8']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_9']) && $trabajos['idLevel_9']!=''){                                                            $SIS_data .= ",'".$trabajos['idLevel_9']."'";                              }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_10']) && $trabajos['idLevel_10']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_10']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_11']) && $trabajos['idLevel_11']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_11']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_12']) && $trabajos['idLevel_12']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_12']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_13']) && $trabajos['idLevel_13']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_13']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_14']) && $trabajos['idLevel_14']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_14']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_15']) && $trabajos['idLevel_15']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_15']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_16']) && $trabajos['idLevel_16']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_16']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_17']) && $trabajos['idLevel_17']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_17']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_18']) && $trabajos['idLevel_18']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_18']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_19']) && $trabajos['idLevel_19']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_19']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_20']) && $trabajos['idLevel_20']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_20']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_21']) && $trabajos['idLevel_21']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_21']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_22']) && $trabajos['idLevel_22']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_22']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_23']) && $trabajos['idLevel_23']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_23']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_24']) && $trabajos['idLevel_24']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_24']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['idLevel_25']) && $trabajos['idLevel_25']!=''){                                                          $SIS_data .= ",'".$trabajos['idLevel_25']."'";                             }else{$SIS_data .= ",''";}
								if(isset($trabajos['Observacion']) && $trabajos['Observacion']!=''){                                                        $SIS_data .= ",'".$trabajos['Observacion']."'";                            }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT, idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
								idUbicacion_lvl_5, idUsuario, idEstado, idPrioridad, idTipo, f_creacion, f_programacion,
								idEstadoTarea,idLicitacion, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5,
								idLevel_6, idLevel_7, idLevel_8, idLevel_9, idLevel_10, idLevel_11, idLevel_12,
								idLevel_13, idLevel_14, idLevel_15, idLevel_16, idLevel_17, idLevel_18, idLevel_19,
								idLevel_20, idLevel_21, idLevel_22, idLevel_23, idLevel_24, idLevel_25, Observacion';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_tareas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					if(isset($_SESSION['ot_motivo_basicos']['f_creacion']) && $_SESSION['ot_motivo_basicos']['f_creacion']!=''){
						$SIS_data .= ",'".$_SESSION['ot_motivo_basicos']['f_creacion']."'";
					}else{
						$SIS_data .= ",''";
					}
					$SIS_data .= ",'1'";                                                     //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                                //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";   //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*****************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['ot_motivo_basicos']);
					unset($_SESSION['ot_motivo_trabajador']);
					unset($_SESSION['ot_motivo_tareas']);
					unset($_SESSION['ot_motivo_temporal']);
					unset($_SESSION['ot_motivo_insumos']);
					unset($_SESSION['ot_motivo_productos']);

					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_ot':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_ot']) OR !validaEntero($_GET['del_ot']))&&$_GET['del_ot']!=''){
				$indice = simpleDecode($_GET['del_ot'], fecha_actual());
			}else{
				$indice = $_GET['del_ot'];
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
				/*************************************************************/
				// Se obtiene el nombre de los archivos
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, 'NombreArchivo', 'orden_trabajo_tareas_listado_tareas_adjuntos', '', 'idOT = '.$indice, 'NombreArchivo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_insumos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_productos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_responsable', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_tareas', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_tareas_adjuntos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_historial', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					foreach ($arrArchivos as $archivos) {
						if(isset($archivos['NombreArchivo'])&&$archivos['NombreArchivo']!=''){
							try {
								if(!is_writable('upload/'.$archivos['NombreArchivo'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivos['NombreArchivo']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
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
		case 'clone':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************************/
				// Se traen todos los datos de la ot seleccionada
				$rowData = db_select_data (false, 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idPrioridad, idTipo, Observaciones', 'orden_trabajo_tareas_listado', '', 'idOT = '.$idOT, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				// Se trae un listado con los trabajadores de la OT
				$arrTrabajadores = array();
				$arrTrabajadores = db_select_array (false, 'idTrabajador', 'orden_trabajo_tareas_listado_responsable', '', 'idOT = '.$idOT, 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				// Se trae un listado de los trabajos a realizar
				$arrTareas = array();
				$arrTareas = db_select_array (false, 'idLicitacion, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5, idLevel_6, idLevel_7, idLevel_8, idLevel_9, idLevel_10, idLevel_11, idLevel_12, idLevel_13, idLevel_14, idLevel_15, idLevel_16, idLevel_17, idLevel_18, idLevel_19, idLevel_20, idLevel_21, idLevel_22, idLevel_23, idLevel_24, idLevel_25, Observacion', 'orden_trabajo_tareas_listado_tareas', '', 'idOT = '.$idOT, 'idLicitacion ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				//Se guardan los datos basicos
				if(isset($rowData['idSistema']) &&$rowData['idSistema']!=''){                   $SIS_data  = "'".$rowData['idSistema']."'";            }else{$SIS_data  = "''";}
				if(isset($rowData['idUbicacion']) && $rowData['idUbicacion']!=''){              $SIS_data .= ",'".$rowData['idUbicacion']."'";         }else{$SIS_data .= ",''";}
				if(isset($rowData['idUbicacion_lvl_1']) && $rowData['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_1']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idUbicacion_lvl_2']) && $rowData['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_2']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idUbicacion_lvl_3']) && $rowData['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_3']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idUbicacion_lvl_4']) && $rowData['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_4']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idUbicacion_lvl_5']) && $rowData['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_5']."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                                        $SIS_data .= ",'".$idUsuario."'";                      }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                                          $SIS_data .= ",'".$idEstado."'";                       }else{$SIS_data .= ",''";}
				if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']!=''){              $SIS_data .= ",'".$rowData['idPrioridad']."'";         }else{$SIS_data .= ",''";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']!= ''){                       $SIS_data .= ",'".$rowData['idTipo']."'";              }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                                      $SIS_data .= ",'".$f_creacion."'";                     }else{$SIS_data .= ",''";}
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
				if(isset($rowData['Observaciones']) && $rowData['Observaciones']!=''){   $SIS_data .= ",'".$rowData['Observaciones']."'";      }else{$SIS_data .= ",'Sin Observaciones'";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
				idUbicacion_lvl_5, idUsuario, idEstado, idPrioridad, idTipo, f_creacion,
				f_programacion, f_programacion_Dia, f_programacion_Semana, f_programacion_Mes,
				f_programacion_Ano, Observaciones';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*****************************************************/
					//Se guardan los datos de los trabajadores
					foreach ($arrTrabajadores AS $trabajador){

						//filtros
						if(isset($ultimo_id) &&$ultimo_id!=''){                                         $SIS_data  = "'".$ultimo_id."'";                       }else{$SIS_data  = "''";}
						if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){                  $SIS_data .= ",'".$rowData['idSistema']."'";           }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion']) && $rowData['idUbicacion']!=''){              $SIS_data .= ",'".$rowData['idUbicacion']."'";         }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_1']) && $rowData['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_1']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_2']) && $rowData['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_2']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_3']) && $rowData['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_3']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_4']) && $rowData['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_4']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_5']) && $rowData['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_5']."'";   }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                                        $SIS_data .= ",'".$idUsuario."'";                      }else{$SIS_data .= ",''";}
						if(isset($idEstado) && $idEstado!=''){                                          $SIS_data .= ",'".$idEstado."'";                       }else{$SIS_data .= ",''";}
						if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']!=''){              $SIS_data .= ",'".$rowData['idPrioridad']."'";         }else{$SIS_data .= ",''";}
						if(isset($rowData['idTipo']) && $rowData['idTipo']!= ''){                       $SIS_data .= ",'".$rowData['idTipo']."'";              }else{$SIS_data .= ",''";}
						if(isset($f_creacion) && $f_creacion!=''){                                      $SIS_data .= ",'".$f_creacion."'";                     }else{$SIS_data .= ",''";}
						if(isset($f_programacion) && $f_programacion!=''){                              $SIS_data .= ",'".$f_programacion."'";                 }else{$SIS_data .= ",''";}
						if(isset($trabajador['idTrabajador']) && $trabajador['idTrabajador']!=''){      $SIS_data .= ",'".$trabajador['idTrabajador']."'";     }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
						idUbicacion_lvl_5,idUsuario, idEstado,idPrioridad,idTipo,f_creacion,
						f_programacion,idTrabajador';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*****************************************************/
					//Se guardan los trabajos a realizar
					foreach ($arrTareas AS $tareas){

						//filtros
						if(isset($ultimo_id) &&$ultimo_id!=''){                                         $SIS_data  = "'".$ultimo_id."'";                       }else{$SIS_data  = "''";}
						if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){                  $SIS_data .= ",'".$rowData['idSistema']."'";           }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion']) && $rowData['idUbicacion']!=''){              $SIS_data .= ",'".$rowData['idUbicacion']."'";         }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_1']) && $rowData['idUbicacion_lvl_1']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_1']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_2']) && $rowData['idUbicacion_lvl_2']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_2']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_3']) && $rowData['idUbicacion_lvl_3']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_3']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_4']) && $rowData['idUbicacion_lvl_4']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_4']."'";   }else{$SIS_data .= ",''";}
						if(isset($rowData['idUbicacion_lvl_5']) && $rowData['idUbicacion_lvl_5']!=''){  $SIS_data .= ",'".$rowData['idUbicacion_lvl_5']."'";   }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                                        $SIS_data .= ",'".$idUsuario."'";                      }else{$SIS_data .= ",''";}
						if(isset($idEstado) && $idEstado!=''){                                          $SIS_data .= ",'".$idEstado."'";                       }else{$SIS_data .= ",''";}
						if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']!=''){              $SIS_data .= ",'".$rowData['idPrioridad']."'";         }else{$SIS_data .= ",''";}
						if(isset($rowData['idTipo']) && $rowData['idTipo']!= ''){                       $SIS_data .= ",'".$rowData['idTipo']."'";              }else{$SIS_data .= ",''";}
						if(isset($f_creacion) && $f_creacion!=''){                                      $SIS_data .= ",'".$f_creacion."'";                     }else{$SIS_data .= ",''";}
						if(isset($f_programacion) && $f_programacion!=''){                              $SIS_data .= ",'".$f_programacion."'";                 }else{$SIS_data .= ",''";}
						$SIS_data .= ",'1'";//idEstadoTarea
						if(isset($tareas['idLicitacion']) && $tareas['idLicitacion']!=''){              $SIS_data .= ",'".$tareas['idLicitacion']."'";         }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_1']) && $tareas['idLevel_1']!=''){                    $SIS_data .= ",'".$tareas['idLevel_1']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_2']) && $tareas['idLevel_2']!=''){                    $SIS_data .= ",'".$tareas['idLevel_2']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_3']) && $tareas['idLevel_3']!=''){                    $SIS_data .= ",'".$tareas['idLevel_3']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_4']) && $tareas['idLevel_4']!=''){                    $SIS_data .= ",'".$tareas['idLevel_4']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_5']) && $tareas['idLevel_5']!=''){                    $SIS_data .= ",'".$tareas['idLevel_5']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_6']) && $tareas['idLevel_6']!=''){                    $SIS_data .= ",'".$tareas['idLevel_6']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_7']) && $tareas['idLevel_7']!=''){                    $SIS_data .= ",'".$tareas['idLevel_7']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_8']) && $tareas['idLevel_8']!=''){                    $SIS_data .= ",'".$tareas['idLevel_8']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_9']) && $tareas['idLevel_9']!=''){                    $SIS_data .= ",'".$tareas['idLevel_9']."'";            }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_10']) && $tareas['idLevel_10']!=''){                  $SIS_data .= ",'".$tareas['idLevel_10']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_11']) && $tareas['idLevel_11']!=''){                  $SIS_data .= ",'".$tareas['idLevel_11']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_12']) && $tareas['idLevel_12']!=''){                  $SIS_data .= ",'".$tareas['idLevel_12']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_13']) && $tareas['idLevel_13']!=''){                  $SIS_data .= ",'".$tareas['idLevel_13']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_14']) && $tareas['idLevel_14']!=''){                  $SIS_data .= ",'".$tareas['idLevel_14']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_15']) && $tareas['idLevel_15']!=''){                  $SIS_data .= ",'".$tareas['idLevel_15']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_16']) && $tareas['idLevel_16']!=''){                  $SIS_data .= ",'".$tareas['idLevel_16']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_17']) && $tareas['idLevel_17']!=''){                  $SIS_data .= ",'".$tareas['idLevel_17']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_18']) && $tareas['idLevel_18']!=''){                  $SIS_data .= ",'".$tareas['idLevel_18']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_19']) && $tareas['idLevel_19']!=''){                  $SIS_data .= ",'".$tareas['idLevel_19']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_20']) && $tareas['idLevel_20']!=''){                  $SIS_data .= ",'".$tareas['idLevel_20']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_21']) && $tareas['idLevel_21']!=''){                  $SIS_data .= ",'".$tareas['idLevel_21']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_22']) && $tareas['idLevel_22']!=''){                  $SIS_data .= ",'".$tareas['idLevel_22']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_23']) && $tareas['idLevel_23']!=''){                  $SIS_data .= ",'".$tareas['idLevel_23']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_24']) && $tareas['idLevel_24']!=''){                  $SIS_data .= ",'".$tareas['idLevel_24']."'";           }else{$SIS_data .= ",''";}
						if(isset($tareas['idLevel_25']) && $tareas['idLevel_25']!=''){                  $SIS_data .= ",'".$tareas['idLevel_25']."'";           }else{$SIS_data .= ",''";}
						$SIS_data .= ",'Sin observacion'";//Observacion

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, idSistema, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5,
						idUsuario,idEstado, idPrioridad, idTipo, f_creacion, f_programacion, idEstadoTarea,
						idLicitacion, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5,
						idLevel_6, idLevel_7, idLevel_8, idLevel_9, idLevel_10, idLevel_11, idLevel_12,
						idLevel_13, idLevel_14, idLevel_15, idLevel_16, idLevel_17, idLevel_18, idLevel_19,
						idLevel_20, idLevel_21, idLevel_22, idLevel_23, idLevel_24, idLevel_25, Observacion';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_tareas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".$f_creacion."'";
					$SIS_data .= ",'1'";                                                                        //Creacion Satisfactoria
					$SIS_data .= ",'OT N°".n_doc($ultimo_id, 8)." clonada desde la OT N°".n_doc($idOT, 8)."'";  //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";                      //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id2!=0){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
/*                                         Se actualizan los datos maestros                                        */
/*******************************************************************************************************************/
		case 'edit_ot_list':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Secreanlas variables temporales
			if(isset($f_programacion) && $f_programacion!=''){
				$f_programacion_Dia    = fecha2NdiaMes($f_programacion);
				$f_programacion_Semana = fecha2NSemana($f_programacion);
				$f_programacion_Mes    = fecha2NMes($f_programacion);
				$f_programacion_Ano    = fecha2Ano($f_programacion);
			}
			if(isset($f_termino) && $f_termino!=''){
				$f_termino_Dia    = fecha2NdiaMes($f_termino);
				$f_termino_Semana = fecha2NSemana($f_termino);
				$f_termino_Mes    = fecha2NMes($f_termino);
				$f_termino_Ano    = fecha2Ano($f_termino);
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se consultan datos antiguos
				$SIS_query = '
				orden_trabajo_tareas_listado.f_programacion,
				orden_trabajo_tareas_listado.f_termino,
				orden_trabajo_tareas_listado.hora_Inicio,
				orden_trabajo_tareas_listado.hora_Termino,
				orden_trabajo_tareas_listado.Observaciones,
				orden_trabajo_tareas_listado.idEstado,
				core_estado_ot_motivos.Nombre AS NombreEstado,
				core_ot_prioridad.Nombre AS NombrePrioridad,
				core_ot_motivos_tipos.Nombre AS NombreTipo,
				ubicacion_listado.Nombre AS Ubicacion,
				ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
				ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
				ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
				ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
				ubicacion_listado_level_5.Nombre AS UbicacionLVL_5';
				$SIS_join  = '
				LEFT JOIN `core_estado_ot_motivos`     ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado
				LEFT JOIN `core_ot_prioridad`          ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
				LEFT JOIN `core_ot_motivos_tipos`      ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
				LEFT JOIN `ubicacion_listado`          ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
				LEFT JOIN `ubicacion_listado_level_1`  ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
				LEFT JOIN `ubicacion_listado_level_2`  ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
				LEFT JOIN `ubicacion_listado_level_3`  ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
				LEFT JOIN `ubicacion_listado_level_4`  ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
				LEFT JOIN `ubicacion_listado_level_5`  ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5';
				$SIS_where = 'orden_trabajo_tareas_listado.idOT = '.$idOT;
				$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Filtros
				$SIS_data = "idOT='".$idOT."'";
				if(isset($idSistema) && $idSistema!=''){                            $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){                        $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){            $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){            $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){            $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){            $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){            $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
				if(isset($idUsuario) && $idUsuario!=''){                            $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){                              $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPrioridad) && $idPrioridad!=''){                        $SIS_data .= ",idPrioridad='".$idPrioridad."'";}
				if(isset($idTipo) && $idTipo!=''){                                  $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($f_creacion) && $f_creacion!=''){                          $SIS_data .= ",f_creacion='".$f_creacion."'";}
				if(isset($f_programacion) && $f_programacion!=''){                  $SIS_data .= ",f_programacion='".$f_programacion."'";}
				if(isset($f_programacion_Dia) && $f_programacion_Dia!=''){          $SIS_data .= ",f_programacion_Dia='".$f_programacion_Dia."'";}
				if(isset($f_programacion_Semana) && $f_programacion_Semana!=''){    $SIS_data .= ",f_programacion_Semana='".$f_programacion_Semana."'";}
				if(isset($f_programacion_Mes) && $f_programacion_Mes!=''){          $SIS_data .= ",f_programacion_Mes='".$f_programacion_Mes."'";}
				if(isset($f_programacion_Ano) && $f_programacion_Ano!=''){          $SIS_data .= ",f_programacion_Ano='".$f_programacion_Ano."'";}
				if(isset($f_termino) && $f_termino!=''){                            $SIS_data .= ",f_termino='".$f_termino."'";}
				if(isset($f_termino_Dia) && $f_termino_Dia!=''){                    $SIS_data .= ",f_termino_Dia='".$f_termino_Dia."'";}
				if(isset($f_termino_Semana) && $f_termino_Semana!=''){              $SIS_data .= ",f_termino_Semana='".$f_termino_Semana."'";}
				if(isset($f_termino_Mes) && $f_termino_Mes!=''){                    $SIS_data .= ",f_termino_Mes='".$f_termino_Mes."'";}
				if(isset($f_termino_Ano) && $f_termino_Ano!=''){                    $SIS_data .= ",f_termino_Ano='".$f_termino_Ano."'";}
				if(isset($hora_Inicio) && $hora_Inicio!=''){                        $SIS_data .= ",hora_Inicio='".$hora_Inicio."'";}
				if(isset($hora_Termino) && $hora_Termino!=''){                      $SIS_data .= ",hora_Termino='".$hora_Termino."'";}
				if(isset($Observaciones) && $Observaciones!=''){                    $SIS_data .= ",Observaciones='".$Observaciones."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Se consultan datos nuevos
					$SIS_query = '
					orden_trabajo_tareas_listado.f_programacion,
					orden_trabajo_tareas_listado.f_termino,
					orden_trabajo_tareas_listado.hora_Inicio,
					orden_trabajo_tareas_listado.hora_Termino,
					orden_trabajo_tareas_listado.Observaciones,
					orden_trabajo_tareas_listado.idEstado,
					core_estado_ot_motivos.Nombre AS NombreEstado,
					core_ot_prioridad.Nombre AS NombrePrioridad,
					core_ot_motivos_tipos.Nombre AS NombreTipo,
					ubicacion_listado.Nombre AS Ubicacion,
					ubicacion_listado_level_1.Nombre AS UbicacionLVL_1,
					ubicacion_listado_level_2.Nombre AS UbicacionLVL_2,
					ubicacion_listado_level_3.Nombre AS UbicacionLVL_3,
					ubicacion_listado_level_4.Nombre AS UbicacionLVL_4,
					ubicacion_listado_level_5.Nombre AS UbicacionLVL_5';
					$SIS_join  = '
					LEFT JOIN `core_estado_ot_motivos`     ON core_estado_ot_motivos.idEstado       = orden_trabajo_tareas_listado.idEstado
					LEFT JOIN `core_ot_prioridad`          ON core_ot_prioridad.idPrioridad         = orden_trabajo_tareas_listado.idPrioridad
					LEFT JOIN `core_ot_motivos_tipos`      ON core_ot_motivos_tipos.idTipo          = orden_trabajo_tareas_listado.idTipo
					LEFT JOIN `ubicacion_listado`          ON ubicacion_listado.idUbicacion         = orden_trabajo_tareas_listado.idUbicacion
					LEFT JOIN `ubicacion_listado_level_1`  ON ubicacion_listado_level_1.idLevel_1   = orden_trabajo_tareas_listado.idUbicacion_lvl_1
					LEFT JOIN `ubicacion_listado_level_2`  ON ubicacion_listado_level_2.idLevel_2   = orden_trabajo_tareas_listado.idUbicacion_lvl_2
					LEFT JOIN `ubicacion_listado_level_3`  ON ubicacion_listado_level_3.idLevel_3   = orden_trabajo_tareas_listado.idUbicacion_lvl_3
					LEFT JOIN `ubicacion_listado_level_4`  ON ubicacion_listado_level_4.idLevel_4   = orden_trabajo_tareas_listado.idUbicacion_lvl_4
					LEFT JOIN `ubicacion_listado_level_5`  ON ubicacion_listado_level_5.idLevel_5   = orden_trabajo_tareas_listado.idUbicacion_lvl_5';
					$SIS_where = 'orden_trabajo_tareas_listado.idOT = '.$idOT;
					$rowDataPost = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Comparacion datos antiguos con datos nuevos
					$compare = 'Modificacion en los datos basicos de la OT:</strong><br/>';
					if(isset($rowData['f_programacion'])&&isset($rowDataPost['f_programacion'])&&$rowData['f_programacion']!=$rowDataPost['f_programacion']){
						$compare .= ' - Se cambia la fecha de programacion, de <strong>'.fecha_estandar($rowData['f_programacion']).'</strong> a <strong>'.fecha_estandar($rowDataPost['f_programacion']).'</strong><br/>';
					}
					if(isset($rowData['f_termino'])&&isset($rowDataPost['f_termino'])&&$rowData['f_termino']!=$rowDataPost['f_termino']){
						$compare .= ' - Se cambia la fecha de termino, de <strong>'.fecha_estandar($rowData['f_termino']).'</strong> a <strong>'.fecha_estandar($rowDataPost['f_termino']).'</strong><br/>';
					}
					if(isset($rowData['hora_Inicio'])&&isset($rowDataPost['hora_Inicio'])&&$rowData['hora_Inicio']!=$rowDataPost['hora_Inicio']){
						$compare .= ' - Se cambia la hora de inicio, de <strong>'.$rowData['hora_Inicio'].'</strong> a <strong>'.$rowDataPost['hora_Inicio'].'</strong><br/>';
					}
					if(isset($rowData['hora_Termino'])&&isset($rowDataPost['hora_Termino'])&&$rowData['hora_Termino']!=$rowDataPost['hora_Termino']){
						$compare .= ' - Se cambia la hora de termino, de <strong>'.$rowData['hora_Termino'].'</strong> a <strong>'.$rowDataPost['hora_Termino'].'</strong><br/>';
					}
					if(isset($rowData['Observaciones'])&&isset($rowDataPost['Observaciones'])&&$rowData['Observaciones']!=$rowDataPost['Observaciones']){
						$compare .= ' - Se cambia la observacion, de <strong>'.$rowData['Observaciones'].',</strong> a <strong>'.$rowDataPost['Observaciones'].'</strong><br/>';
					}
					if(isset($rowData['idEstado'])&&isset($rowDataPost['idEstado'])&&$rowData['idEstado']!=$rowDataPost['idEstado']){
						$compare .= ' - Se cambia el estado, de <strong>'.$rowData['NombreEstado'].'</strong> a <strong>'.$rowDataPost['NombreEstado'].'</strong><br/>';
					}
					if(isset($rowData['NombrePrioridad'])&&isset($rowDataPost['NombrePrioridad'])&&$rowData['NombrePrioridad']!=$rowDataPost['NombrePrioridad']){
						$compare .= ' - Se cambia la prioridad de la OT, de <strong>'.$rowData['NombrePrioridad'].'</strong> a <strong>'.$rowDataPost['NombrePrioridad'].'</strong><br/>';
					}
					if(isset($rowData['NombreTipo'])&&isset($rowDataPost['NombreTipo'])&&$rowData['NombreTipo']!=$rowDataPost['NombreTipo']){
						$compare .= ' - Se cambia el tipo de OT, de <strong>'.$rowData['NombreTipo'].'</strong> a <strong>'.$rowDataPost['NombreTipo'].'</strong><br/>';
					}
					if(isset($rowData['Ubicacion'])&&isset($rowDataPost['Ubicacion'])&&$rowData['Ubicacion']!=$rowDataPost['Ubicacion']){
						$compare .= ' - Se cambia la ubicacion de la OT, de <strong>'.$rowData['Ubicacion'].'</strong> a <strong>'.$rowDataPost['Ubicacion'].'</strong><br/>';
					}
					if(isset($rowData['UbicacionLVL_1'])&&isset($rowDataPost['UbicacionLVL_1'])&&$rowData['UbicacionLVL_1']!=$rowDataPost['UbicacionLVL_1']){
						$compare .= ' - Se cambia el nivel 1 la ubicacion de la OT, de <strong>'.$rowData['UbicacionLVL_1'].'</strong> a <strong>'.$rowDataPost['UbicacionLVL_1'].'</strong><br/>';
					}
					if(isset($rowData['UbicacionLVL_2'])&&isset($rowDataPost['UbicacionLVL_2'])&&$rowData['UbicacionLVL_2']!=$rowDataPost['UbicacionLVL_2']){
						$compare .= ' - Se cambia el nivel 2 la ubicacion de la OT, de <strong>'.$rowData['UbicacionLVL_2'].'</strong> a <strong>'.$rowDataPost['UbicacionLVL_2'].'</strong><br/>';
					}
					if(isset($rowData['UbicacionLVL_3'])&&isset($rowDataPost['UbicacionLVL_3'])&&$rowData['UbicacionLVL_3']!=$rowDataPost['UbicacionLVL_3']){
						$compare .= ' - Se cambia el nivel 3 la ubicacion de la OT, de <strong>'.$rowData['UbicacionLVL_3'].'</strong> a <strong>'.$rowDataPost['UbicacionLVL_3'].'</strong><br/>';
					}
					if(isset($rowData['UbicacionLVL_4'])&&isset($rowDataPost['UbicacionLVL_4'])&&$rowData['UbicacionLVL_4']!=$rowDataPost['UbicacionLVL_4']){
						$compare .= ' - Se cambia el nivel 4 la ubicacion de la OT, de <strong>'.$rowData['UbicacionLVL_4'].'</strong> a <strong>'.$rowDataPost['UbicacionLVL_4'].'</strong><br/>';
					}
					if(isset($rowData['UbicacionLVL_5'])&&isset($rowDataPost['UbicacionLVL_5'])&&$rowData['UbicacionLVL_5']!=$rowDataPost['UbicacionLVL_5']){
						$compare .= ' - Se cambia el nivel 5 la ubicacion de la OT, de <strong>'.$rowData['UbicacionLVL_5'].'</strong> a <strong>'.$rowDataPost['UbicacionLVL_5'].'</strong><br/>';
					}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'".$compare."'";                                         //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

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
		case 'edit_addTrab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idTrabajador)&&isset($idOT)){
				$ndata_1 = db_select_nrows (false, 'idResponsable', 'orden_trabajo_tareas_listado_responsable', '', "idTrabajador='".$idTrabajador."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                            $SIS_data  = "'".$idOT."'";                 }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){              $SIS_data .= ",'".$idPrioridad."'";         }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                $SIS_data .= ",'".$f_creacion."'";          }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){        $SIS_data .= ",'".$f_programacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){            $SIS_data .= ",'".$idTrabajador."'";        }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5,
				idUsuario, idEstado,idPrioridad,idTipo,f_creacion,f_programacion,idTrabajador';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Consulto por el item recien ingresado
					$rowData = db_select_data (false, 'trabajadores_listado.Nombre,trabajadores_listado.ApellidoPat, trabajadores_listado.ApellidoMat', 'orden_trabajo_tareas_listado_responsable', 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador  = orden_trabajo_tareas_listado_responsable.idTrabajador', 'orden_trabajo_tareas_listado_responsable.idResponsable = '.$ultimo_id, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Nombre del item
					$NombreItem = $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'];

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                       //Creacion Satisfactoria
					$SIS_data .= ",'Se agrega Trabajador: <strong>".$NombreItem."</strong>'";  //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";     //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&addtrab=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_editTrab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idTrabajador)&&isset($idOT)){
				$ndata_1 = db_select_nrows (false, 'idResponsable', 'orden_trabajo_tareas_listado_responsable', '', "idTrabajador='".$idTrabajador."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Consulto por el item antiguo
				$rowData = db_select_data (false, 'trabajadores_listado.Nombre,trabajadores_listado.ApellidoPat, trabajadores_listado.ApellidoMat', 'orden_trabajo_tareas_listado_responsable', 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador  = orden_trabajo_tareas_listado_responsable.idTrabajador', 'orden_trabajo_tareas_listado_responsable.idResponsable = '.$idResponsable, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//filtros
				$SIS_data = "idResponsable='".$idResponsable."'";
				if(isset($idTrabajador) && $idTrabajador!=''){   $SIS_data .= ",idTrabajador='".$idTrabajador."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_responsable', 'idResponsable = "'.$idResponsable.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Consulto por el item antiguo
					$rowDataPost = db_select_data (false, 'trabajadores_listado.Nombre,trabajadores_listado.ApellidoPat, trabajadores_listado.ApellidoMat', 'orden_trabajo_tareas_listado_responsable', 'LEFT JOIN `trabajadores_listado`    ON trabajadores_listado.idTrabajador  = orden_trabajo_tareas_listado_responsable.idTrabajador', 'orden_trabajo_tareas_listado_responsable.idResponsable = '.$idResponsable, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se hace la comparacion
					if(isset($rowData['ApellidoPat'])&&isset($rowDataPost['ApellidoPat'])&&$rowData['ApellidoPat']!=$rowDataPost['ApellidoPat']){
						$NombreItem1 = $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'];
						$NombreItem2 = $rowDataPost['Nombre'].' '.$rowDataPost['ApellidoPat'].' '.$rowDataPost['ApellidoMat'];
						$NombreItem  = 'Se cambia Trabajador: <strong>'.$NombreItem1.'</strong> por <strong>'.$NombreItem2.'</strong>';
						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$NombreItem."'";                                      //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&edittrab=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'edit_delTrab':
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_trab']) OR !validaEntero($_GET['del_trab']))&&$_GET['del_trab']!=''){
				$indice = simpleDecode($_GET['del_trab'], fecha_actual());
			}else{
				$indice = $_GET['del_trab'];
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
				//Consulto por el item recien ingresado
				$rowData = db_select_data (false, 'orden_trabajo_tareas_listado_responsable.idOT, trabajadores_listado.Nombre,trabajadores_listado.ApellidoPat, trabajadores_listado.ApellidoMat', 'orden_trabajo_tareas_listado_responsable', 'LEFT JOIN `trabajadores_listado` ON trabajadores_listado.idTrabajador  = orden_trabajo_tareas_listado_responsable.idTrabajador', 'orden_trabajo_tareas_listado_responsable.idResponsable = '.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Nombre del item
				$NombreItem = $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'];

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($rowData['idOT']) && $rowData['idOT']!=''){    $SIS_data  = "'".$rowData['idOT']."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                        //Creacion Satisfactoria
				$SIS_data .= ",'Se elimina Trabajador: <strong>".$NombreItem."</strong>'";  //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";      //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_responsable', 'idResponsable = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deltrab=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'edit_addIns':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProducto)&&isset($idOT)){
				$ndata_1 = db_select_nrows (false, 'idInsumos', 'orden_trabajo_tareas_listado_insumos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Insumo seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                            $SIS_data  = "'".$idOT."'";                 }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){              $SIS_data .= ",'".$idPrioridad."'";         }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                $SIS_data .= ",'".$f_creacion."'";          }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){        $SIS_data .= ",'".$f_programacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){                $SIS_data .= ",'".$idProducto."'";          }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                    $SIS_data .= ",'".$Cantidad."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
				idUbicacion_lvl_5, idUsuario, idEstado,idPrioridad,idTipo,f_creacion,f_programacion,
				idProducto, Cantidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Consulto por el item recien ingresado
					$rowData = db_select_data (false, 'insumos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_insumos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = orden_trabajo_tareas_listado_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'orden_trabajo_tareas_listado_insumos.idInsumos = '.$ultimo_id, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Nombre del item
					$NombreItem = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Se agrega Insumo: <strong>".$NombreItem."</strong>'";   //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&addins=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_editIns':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProducto)&&isset($idOT)&&isset($idInsumos)){
				$ndata_1 = db_select_nrows (false, 'idInsumos', 'orden_trabajo_tareas_listado_insumos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."' AND idInsumos!='".$idInsumos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Insumo seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Consulto por el item recien ingresado
				$rowData = db_select_data (false, 'insumos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_insumos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = orden_trabajo_tareas_listado_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'orden_trabajo_tareas_listado_insumos.idInsumos = '.$idInsumos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//filtros
				$SIS_data = "idInsumos='".$idInsumos."'";
				if(isset($idProducto) && $idProducto!=''){    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){        $SIS_data .= ",Cantidad='".$Cantidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_insumos', 'idInsumos = "'.$idInsumos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Consulto por el item recien ingresado
					$rowDataPost = db_select_data (false, 'insumos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_insumos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = orden_trabajo_tareas_listado_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'orden_trabajo_tareas_listado_insumos.idInsumos = '.$idInsumos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					if(isset($rowData['Producto'])&&isset($rowDataPost['Producto'])&&($rowData['Producto']!=$rowDataPost['Producto'] OR $rowData['Cantidad']!=$rowDataPost['Cantidad'])){
						//Nombre del item
						$NombreItem1 = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];
						$NombreItem2 = $rowDataPost['Cantidad'].' '.$rowDataPost['Unidad'].' de '.$rowDataPost['Producto'];
						$NombreItem  = 'Se cambia Insumo: <strong>'.$NombreItem1.'</strong> por <strong>'.$NombreItem2.'</strong>';

						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$NombreItem."'";                                      //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&editins=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'edit_delIns':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_ins']) OR !validaEntero($_GET['del_ins']))&&$_GET['del_ins']!=''){
				$indice = simpleDecode($_GET['del_ins'], fecha_actual());
			}else{
				$indice = $_GET['del_ins'];
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
				//Consulto por el item recien ingresado
				$rowData = db_select_data (false, 'orden_trabajo_tareas_listado_insumos.idOT, insumos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_insumos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_insumos', 'LEFT JOIN `insumos_listado` ON insumos_listado.idProducto = orden_trabajo_tareas_listado_insumos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'orden_trabajo_tareas_listado_insumos.idInsumos = '.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Nombre del item
				$NombreItem = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($rowData['idOT']) && $rowData['idOT']!=''){    $SIS_data  = "'".$rowData['idOT']."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
				$SIS_data .= ",'Se elimina Insumo: <strong>".$NombreItem."</strong>'";  //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_insumos', 'idInsumos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&delins=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'edit_addProd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProducto)&&isset($idOT)){
				$ndata_1 = db_select_nrows (false, 'idProductos', 'orden_trabajo_tareas_listado_productos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                            $SIS_data  = "'".$idOT."'";                 }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){              $SIS_data .= ",'".$idPrioridad."'";         }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                $SIS_data .= ",'".$f_creacion."'";          }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){        $SIS_data .= ",'".$f_programacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){                $SIS_data .= ",'".$idProducto."'";          }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                    $SIS_data .= ",'".$Cantidad."'";            }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
				idUbicacion_lvl_5,idUsuario, idEstado,idPrioridad,idTipo,f_creacion,f_programacion,
				idProducto, Cantidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Consulto por el item recien ingresado
					$rowData = db_select_data (false, 'productos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_productos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = orden_trabajo_tareas_listado_productos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'orden_trabajo_tareas_listado_productos.idProductos = '.$ultimo_id, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Nombre del item
					$NombreItem = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Se agrega Producto: <strong>".$NombreItem."</strong>'"; //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&addprod=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_editProd':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idProducto)&&isset($idOT)&&isset($idProductos)){
				$ndata_1 = db_select_nrows (false, 'idProductos', 'orden_trabajo_tareas_listado_productos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."' AND idProductos!='".$idProductos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Consulto por el item recien ingresado
				$rowData = db_select_data (false, 'productos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_productos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = orden_trabajo_tareas_listado_productos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'orden_trabajo_tareas_listado_productos.idProductos = '.$idProductos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//filtros
				$SIS_data = "idProductos='".$idProductos."'";
				if(isset($idProducto) && $idProducto!=''){    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){        $SIS_data .= ",Cantidad='".$Cantidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_productos', 'idProductos = "'.$idProductos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//Consulto por el item recien ingresado
					$rowDataPost = db_select_data (false, 'productos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_productos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = orden_trabajo_tareas_listado_productos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'orden_trabajo_tareas_listado_productos.idProductos = '.$idProductos, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					if(isset($rowData['Producto'])&&isset($rowDataPost['Producto'])&&($rowData['Producto']!=$rowDataPost['Producto'] OR $rowData['Cantidad']!=$rowDataPost['Cantidad'])){
						//Nombre del item
						$NombreItem1 = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];
						$NombreItem2 = $rowDataPost['Cantidad'].' '.$rowDataPost['Unidad'].' de '.$rowDataPost['Producto'];
						$NombreItem  = 'Se cambia Producto: <strong>'.$NombreItem1.'</strong> por <strong>'.$NombreItem2.'</strong>';

						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$NombreItem."'";                                      //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&editprod=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_delProd':

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
				//Consulto por el item recien ingresado
				$rowData = db_select_data (false, 'orden_trabajo_tareas_listado_productos.idOT, productos_listado.Nombre AS Producto, orden_trabajo_tareas_listado_productos.Cantidad, sistema_productos_uml.Nombre AS Unidad', 'orden_trabajo_tareas_listado_productos', 'LEFT JOIN `productos_listado` ON productos_listado.idProducto = orden_trabajo_tareas_listado_productos.idProducto LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'orden_trabajo_tareas_listado_productos.idProductos = '.$indice, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Nombre del item
				$NombreItem = $rowData['Cantidad'].' '.$rowData['Unidad'].' de '.$rowData['Producto'];

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($rowData['idOT']) && $rowData['idOT']!=''){    $SIS_data  = "'".$rowData['idOT']."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                      //Creacion Satisfactoria
				$SIS_data .= ",'Se elimina Producto: <strong>".$NombreItem."</strong>'";  //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";    //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_productos', 'idProductos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&delprod=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

/*******************************************************************************************************************/
		case 'edit_addTarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                            $SIS_data  = "'".$idOT."'";                 }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";         }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";   }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";   }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){              $SIS_data .= ",'".$idPrioridad."'";         }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                $SIS_data .= ",'".$f_creacion."'";          }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){        $SIS_data .= ",'".$f_programacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idEstadoTarea) && $idEstadoTarea!=''){          $SIS_data .= ",'".$idEstadoTarea."'";       }else{$SIS_data .= ",''";}
				if(isset($idLicitacion) && $idLicitacion!=''){            $SIS_data .= ",'".$idLicitacion."'";        }else{$SIS_data .= ",''";}
				if(isset($idLevel[1]) && $idLevel[1]!=''){                $SIS_data .= ",'".$idLevel[1]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[2]) && $idLevel[2]!=''){                $SIS_data .= ",'".$idLevel[2]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[3]) && $idLevel[3]!=''){                $SIS_data .= ",'".$idLevel[3]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[4]) && $idLevel[4]!=''){                $SIS_data .= ",'".$idLevel[4]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[5]) && $idLevel[5]!=''){                $SIS_data .= ",'".$idLevel[5]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[6]) && $idLevel[6]!=''){                $SIS_data .= ",'".$idLevel[6]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[7]) && $idLevel[7]!=''){                $SIS_data .= ",'".$idLevel[7]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[8]) && $idLevel[8]!=''){                $SIS_data .= ",'".$idLevel[8]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[9]) && $idLevel[9]!=''){                $SIS_data .= ",'".$idLevel[9]."'";          }else{$SIS_data .= ",''";}
				if(isset($idLevel[10]) && $idLevel[10]!=''){              $SIS_data .= ",'".$idLevel[10]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[11]) && $idLevel[11]!=''){              $SIS_data .= ",'".$idLevel[11]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[12]) && $idLevel[12]!=''){              $SIS_data .= ",'".$idLevel[12]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[13]) && $idLevel[13]!=''){              $SIS_data .= ",'".$idLevel[13]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[14]) && $idLevel[14]!=''){              $SIS_data .= ",'".$idLevel[14]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[15]) && $idLevel[15]!=''){              $SIS_data .= ",'".$idLevel[15]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[16]) && $idLevel[16]!=''){              $SIS_data .= ",'".$idLevel[16]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[17]) && $idLevel[17]!=''){              $SIS_data .= ",'".$idLevel[17]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[18]) && $idLevel[18]!=''){              $SIS_data .= ",'".$idLevel[18]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[19]) && $idLevel[19]!=''){              $SIS_data .= ",'".$idLevel[19]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[20]) && $idLevel[20]!=''){              $SIS_data .= ",'".$idLevel[20]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[21]) && $idLevel[21]!=''){              $SIS_data .= ",'".$idLevel[21]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[22]) && $idLevel[22]!=''){              $SIS_data .= ",'".$idLevel[22]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[23]) && $idLevel[23]!=''){              $SIS_data .= ",'".$idLevel[23]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[24]) && $idLevel[24]!=''){              $SIS_data .= ",'".$idLevel[24]."'";         }else{$SIS_data .= ",''";}
				if(isset($idLevel[25]) && $idLevel[25]!=''){              $SIS_data .= ",'".$idLevel[25]."'";         }else{$SIS_data .= ",''";}
				if(isset($Observacion) && $Observacion!=''){              $SIS_data .= ",'".$Observacion."'";         }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
				idUbicacion_lvl_5,idUsuario, idEstado,idPrioridad,idTipo,f_creacion,f_programacion,
				idEstadoTarea, idLicitacion, idLevel_1, idLevel_2, idLevel_3, idLevel_4, idLevel_5,
				idLevel_6, idLevel_7, idLevel_8, idLevel_9, idLevel_10, idLevel_11, idLevel_12,
				idLevel_13, idLevel_14, idLevel_15, idLevel_16, idLevel_17, idLevel_18, idLevel_19,
				idLevel_20, idLevel_21, idLevel_22, idLevel_23, idLevel_24, idLevel_25, Observacion';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_tareas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//Consulto por el item recien ingresado
					$SIS_query = '
					licitacion_listado.Nombre AS Licitacion,
					licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
					licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
					licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
					licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
					licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
					licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
					licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
					licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
					licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
					licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
					licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
					licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
					licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
					licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
					licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
					licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
					licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
					licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
					licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
					licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
					licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
					licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
					licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
					licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
					licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
					$SIS_join  = '
					LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
					LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
					LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
					LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
					LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
					LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
					LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
					LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
					LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
					LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
					LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
					LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
					LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
					LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
					LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
					LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
					LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
					LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
					LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
					LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
					LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
					LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
					LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
					LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
					LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
					LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
					LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
					$SIS_where = 'orden_trabajo_tareas_listado_tareas.idTrabajoOT = '.$ultimo_id;
					$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Nombre del item
					$NombreItem  = 'Se agrega Tarea:<br/>';
					$NombreItem .= '<strong>Licitacion:</strong>'.$rowData['Licitacion'].'<br/>';
					if(isset($rowData['LicitacionLVL_1'])&&$rowData['LicitacionLVL_1']!=''){   $NombreItem .= '<strong>Tarea:</strong>'.$rowData['LicitacionLVL_1'];}
					if(isset($rowData['LicitacionLVL_2'])&&$rowData['LicitacionLVL_2']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_2'];}
					if(isset($rowData['LicitacionLVL_3'])&&$rowData['LicitacionLVL_3']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_3'];}
					if(isset($rowData['LicitacionLVL_4'])&&$rowData['LicitacionLVL_4']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_4'];}
					if(isset($rowData['LicitacionLVL_5'])&&$rowData['LicitacionLVL_5']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_5'];}
					if(isset($rowData['LicitacionLVL_6'])&&$rowData['LicitacionLVL_6']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_6'];}
					if(isset($rowData['LicitacionLVL_7'])&&$rowData['LicitacionLVL_7']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_7'];}
					if(isset($rowData['LicitacionLVL_8'])&&$rowData['LicitacionLVL_8']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_8'];}
					if(isset($rowData['LicitacionLVL_9'])&&$rowData['LicitacionLVL_9']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_9'];}
					if(isset($rowData['LicitacionLVL_10'])&&$rowData['LicitacionLVL_10']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_10'];}
					if(isset($rowData['LicitacionLVL_11'])&&$rowData['LicitacionLVL_11']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_11'];}
					if(isset($rowData['LicitacionLVL_12'])&&$rowData['LicitacionLVL_12']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_12'];}
					if(isset($rowData['LicitacionLVL_13'])&&$rowData['LicitacionLVL_13']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_13'];}
					if(isset($rowData['LicitacionLVL_14'])&&$rowData['LicitacionLVL_14']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_14'];}
					if(isset($rowData['LicitacionLVL_15'])&&$rowData['LicitacionLVL_15']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_15'];}
					if(isset($rowData['LicitacionLVL_16'])&&$rowData['LicitacionLVL_16']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_16'];}
					if(isset($rowData['LicitacionLVL_17'])&&$rowData['LicitacionLVL_17']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_17'];}
					if(isset($rowData['LicitacionLVL_18'])&&$rowData['LicitacionLVL_18']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_18'];}
					if(isset($rowData['LicitacionLVL_19'])&&$rowData['LicitacionLVL_19']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_19'];}
					if(isset($rowData['LicitacionLVL_20'])&&$rowData['LicitacionLVL_20']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_20'];}
					if(isset($rowData['LicitacionLVL_21'])&&$rowData['LicitacionLVL_21']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_21'];}
					if(isset($rowData['LicitacionLVL_22'])&&$rowData['LicitacionLVL_22']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_22'];}
					if(isset($rowData['LicitacionLVL_23'])&&$rowData['LicitacionLVL_23']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_23'];}
					if(isset($rowData['LicitacionLVL_24'])&&$rowData['LicitacionLVL_24']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_24'];}
					if(isset($rowData['LicitacionLVL_25'])&&$rowData['LicitacionLVL_25']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_25'];}

					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                      //Creacion Satisfactoria
					$SIS_data .= ",'".$NombreItem."'";                                        //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";    //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&addtarea=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_editTarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************/
				//Consulto por el item recien ingresado
				$SIS_query = '
				core_estado_ot_motivos_tareas.Nombre AS EstadoTarea,
				licitacion_listado.Nombre AS Licitacion,
				licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
				licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
				licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
				licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
				licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
				licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
				licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
				licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
				licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
				licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
				licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
				licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
				licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
				licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
				licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
				licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
				licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
				licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
				licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
				licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
				licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
				licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
				licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
				licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
				licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
				$SIS_join  = '
				LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
				LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
				LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
				LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
				LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
				LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
				LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
				LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
				LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
				LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
				LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
				LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
				LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
				LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
				LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
				LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
				LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
				LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
				LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
				LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
				LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
				LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
				LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
				LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
				LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
				LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
				LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
				$SIS_where = 'orden_trabajo_tareas_listado_tareas.idTrabajoOT = '.$idTrabajoOT;
				$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/***********************************************************/
				//Reseteo todo antes de guardar
				if(isset($idLevel[1]) && $idLevel[1]!=''){
					$SIS_data  = "idEstadoTarea='0'";
					$SIS_data .= ",idLicitacion='0'";
					$SIS_data .= ",idLevel_1='0'";
					$SIS_data .= ",idLevel_2='0'";
					$SIS_data .= ",idLevel_3='0'";
					$SIS_data .= ",idLevel_4='0'";
					$SIS_data .= ",idLevel_5='0'";
					$SIS_data .= ",idLevel_6='0'";
					$SIS_data .= ",idLevel_7='0'";
					$SIS_data .= ",idLevel_8='0'";
					$SIS_data .= ",idLevel_9='0'";
					$SIS_data .= ",idLevel_10='0'";
					$SIS_data .= ",idLevel_11='0'";
					$SIS_data .= ",idLevel_12='0'";
					$SIS_data .= ",idLevel_13='0'";
					$SIS_data .= ",idLevel_14='0'";
					$SIS_data .= ",idLevel_15='0'";
					$SIS_data .= ",idLevel_16='0'";
					$SIS_data .= ",idLevel_17='0'";
					$SIS_data .= ",idLevel_18='0'";
					$SIS_data .= ",idLevel_19='0'";
					$SIS_data .= ",idLevel_20='0'";
					$SIS_data .= ",idLevel_21='0'";
					$SIS_data .= ",idLevel_22='0'";
					$SIS_data .= ",idLevel_23='0'";
					$SIS_data .= ",idLevel_24='0'";
					$SIS_data .= ",idLevel_25='0'";
					$SIS_data .= ",Observacion=''";

					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas', 'idTrabajoOT = "'.$idTrabajoOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/***********************************************************/
				//filtros
				$SIS_data = "idTrabajoOT='".$idTrabajoOT."'";
				if(isset($idEstadoTarea) && $idEstadoTarea!=''){          $SIS_data .= ",idEstadoTarea='".$idEstadoTarea."'";}
				if(isset($idLicitacion) && $idLicitacion!=''){            $SIS_data .= ",idLicitacion='".$idLicitacion."'";}
				if(isset($idLevel[1]) && $idLevel[1]!=''){                $SIS_data .= ",idLevel_1='".$idLevel[1]."'";}
				if(isset($idLevel[2]) && $idLevel[2]!=''){                $SIS_data .= ",idLevel_2='".$idLevel[2]."'";}
				if(isset($idLevel[3]) && $idLevel[3]!=''){                $SIS_data .= ",idLevel_3='".$idLevel[3]."'";}
				if(isset($idLevel[4]) && $idLevel[4]!=''){                $SIS_data .= ",idLevel_4='".$idLevel[4]."'";}
				if(isset($idLevel[5]) && $idLevel[5]!=''){                $SIS_data .= ",idLevel_5='".$idLevel[5]."'";}
				if(isset($idLevel[6]) && $idLevel[6]!=''){                $SIS_data .= ",idLevel_6='".$idLevel[6]."'";}
				if(isset($idLevel[7]) && $idLevel[7]!=''){                $SIS_data .= ",idLevel_7='".$idLevel[7]."'";}
				if(isset($idLevel[8]) && $idLevel[8]!=''){                $SIS_data .= ",idLevel_8='".$idLevel[8]."'";}
				if(isset($idLevel[9]) && $idLevel[9]!=''){                $SIS_data .= ",idLevel_9='".$idLevel[9]."'";}
				if(isset($idLevel[10]) && $idLevel[10]!=''){              $SIS_data .= ",idLevel_10='".$idLevel[10]."'";}
				if(isset($idLevel[11]) && $idLevel[11]!=''){              $SIS_data .= ",idLevel_11='".$idLevel[11]."'";}
				if(isset($idLevel[12]) && $idLevel[12]!=''){              $SIS_data .= ",idLevel_12='".$idLevel[12]."'";}
				if(isset($idLevel[13]) && $idLevel[13]!=''){              $SIS_data .= ",idLevel_13='".$idLevel[13]."'";}
				if(isset($idLevel[14]) && $idLevel[14]!=''){              $SIS_data .= ",idLevel_14='".$idLevel[14]."'";}
				if(isset($idLevel[15]) && $idLevel[15]!=''){              $SIS_data .= ",idLevel_15='".$idLevel[15]."'";}
				if(isset($idLevel[16]) && $idLevel[16]!=''){              $SIS_data .= ",idLevel_16='".$idLevel[16]."'";}
				if(isset($idLevel[17]) && $idLevel[17]!=''){              $SIS_data .= ",idLevel_17='".$idLevel[17]."'";}
				if(isset($idLevel[18]) && $idLevel[18]!=''){              $SIS_data .= ",idLevel_18='".$idLevel[18]."'";}
				if(isset($idLevel[19]) && $idLevel[19]!=''){              $SIS_data .= ",idLevel_19='".$idLevel[19]."'";}
				if(isset($idLevel[20]) && $idLevel[20]!=''){              $SIS_data .= ",idLevel_20='".$idLevel[20]."'";}
				if(isset($idLevel[21]) && $idLevel[21]!=''){              $SIS_data .= ",idLevel_21='".$idLevel[21]."'";}
				if(isset($idLevel[22]) && $idLevel[22]!=''){              $SIS_data .= ",idLevel_22='".$idLevel[22]."'";}
				if(isset($idLevel[23]) && $idLevel[23]!=''){              $SIS_data .= ",idLevel_23='".$idLevel[23]."'";}
				if(isset($idLevel[24]) && $idLevel[24]!=''){              $SIS_data .= ",idLevel_24='".$idLevel[24]."'";}
				if(isset($idLevel[25]) && $idLevel[25]!=''){              $SIS_data .= ",idLevel_25='".$idLevel[25]."'";}
				if(isset($Observacion) && $Observacion!=''){              $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas', 'idTrabajoOT = "'.$idTrabajoOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/***********************************************************/
					//Consulto por el item recien ingresado
					$SIS_query = '
					core_estado_ot_motivos_tareas.Nombre AS EstadoTarea,
					licitacion_listado.Nombre AS Licitacion,
					licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
					licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
					licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
					licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
					licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
					licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
					licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
					licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
					licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
					licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
					licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
					licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
					licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
					licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
					licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
					licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
					licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
					licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
					licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
					licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
					licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
					licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
					licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
					licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
					licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
					$SIS_join  = '
					LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
					LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
					LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
					LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
					LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
					LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
					LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
					LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
					LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
					LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
					LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
					LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
					LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
					LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
					LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
					LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
					LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
					LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
					LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
					LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
					LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
					LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
					LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
					LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
					LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
					LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
					LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
					$SIS_where = 'orden_trabajo_tareas_listado_tareas.idTrabajoOT = '.$idTrabajoOT;
					$rowDataPost = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/************************************************************************/
					//Nombre del item antiguo
					$NombreItem1  = '';
					$NombreItem1 .= '<strong>Licitacion:</strong>'.$rowData['Licitacion'].'<br/>';
					if(isset($rowData['LicitacionLVL_1'])&&$rowData['LicitacionLVL_1']!=''){   $NombreItem1 .= '<strong>Tarea:</strong>'.$rowData['LicitacionLVL_1'];}
					if(isset($rowData['LicitacionLVL_2'])&&$rowData['LicitacionLVL_2']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_2'];}
					if(isset($rowData['LicitacionLVL_3'])&&$rowData['LicitacionLVL_3']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_3'];}
					if(isset($rowData['LicitacionLVL_4'])&&$rowData['LicitacionLVL_4']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_4'];}
					if(isset($rowData['LicitacionLVL_5'])&&$rowData['LicitacionLVL_5']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_5'];}
					if(isset($rowData['LicitacionLVL_6'])&&$rowData['LicitacionLVL_6']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_6'];}
					if(isset($rowData['LicitacionLVL_7'])&&$rowData['LicitacionLVL_7']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_7'];}
					if(isset($rowData['LicitacionLVL_8'])&&$rowData['LicitacionLVL_8']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_8'];}
					if(isset($rowData['LicitacionLVL_9'])&&$rowData['LicitacionLVL_9']!=''){   $NombreItem1 .= ' - '.$rowData['LicitacionLVL_9'];}
					if(isset($rowData['LicitacionLVL_10'])&&$rowData['LicitacionLVL_10']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_10'];}
					if(isset($rowData['LicitacionLVL_11'])&&$rowData['LicitacionLVL_11']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_11'];}
					if(isset($rowData['LicitacionLVL_12'])&&$rowData['LicitacionLVL_12']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_12'];}
					if(isset($rowData['LicitacionLVL_13'])&&$rowData['LicitacionLVL_13']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_13'];}
					if(isset($rowData['LicitacionLVL_14'])&&$rowData['LicitacionLVL_14']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_14'];}
					if(isset($rowData['LicitacionLVL_15'])&&$rowData['LicitacionLVL_15']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_15'];}
					if(isset($rowData['LicitacionLVL_16'])&&$rowData['LicitacionLVL_16']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_16'];}
					if(isset($rowData['LicitacionLVL_17'])&&$rowData['LicitacionLVL_17']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_17'];}
					if(isset($rowData['LicitacionLVL_18'])&&$rowData['LicitacionLVL_18']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_18'];}
					if(isset($rowData['LicitacionLVL_19'])&&$rowData['LicitacionLVL_19']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_19'];}
					if(isset($rowData['LicitacionLVL_20'])&&$rowData['LicitacionLVL_20']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_20'];}
					if(isset($rowData['LicitacionLVL_21'])&&$rowData['LicitacionLVL_21']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_21'];}
					if(isset($rowData['LicitacionLVL_22'])&&$rowData['LicitacionLVL_22']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_22'];}
					if(isset($rowData['LicitacionLVL_23'])&&$rowData['LicitacionLVL_23']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_23'];}
					if(isset($rowData['LicitacionLVL_24'])&&$rowData['LicitacionLVL_24']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_24'];}
					if(isset($rowData['LicitacionLVL_25'])&&$rowData['LicitacionLVL_25']!=''){ $NombreItem1 .= ' - '.$rowData['LicitacionLVL_25'];}
					/************************************************************************/
					//Nombre del item nuevo
					$NombreItem2  = '';
					$NombreItem2 .= '<strong>Licitacion:</strong>'.$rowDataPost['Licitacion'].'<br/>';
					if(isset($rowDataPost['LicitacionLVL_1'])&&$rowDataPost['LicitacionLVL_1']!=''){   $NombreItem2 .= '<strong>Tarea:</strong>'.$rowDataPost['LicitacionLVL_1'];}
					if(isset($rowDataPost['LicitacionLVL_2'])&&$rowDataPost['LicitacionLVL_2']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_2'];}
					if(isset($rowDataPost['LicitacionLVL_3'])&&$rowDataPost['LicitacionLVL_3']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_3'];}
					if(isset($rowDataPost['LicitacionLVL_4'])&&$rowDataPost['LicitacionLVL_4']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_4'];}
					if(isset($rowDataPost['LicitacionLVL_5'])&&$rowDataPost['LicitacionLVL_5']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_5'];}
					if(isset($rowDataPost['LicitacionLVL_6'])&&$rowDataPost['LicitacionLVL_6']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_6'];}
					if(isset($rowDataPost['LicitacionLVL_7'])&&$rowDataPost['LicitacionLVL_7']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_7'];}
					if(isset($rowDataPost['LicitacionLVL_8'])&&$rowDataPost['LicitacionLVL_8']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_8'];}
					if(isset($rowDataPost['LicitacionLVL_9'])&&$rowDataPost['LicitacionLVL_9']!=''){   $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_9'];}
					if(isset($rowDataPost['LicitacionLVL_10'])&&$rowDataPost['LicitacionLVL_10']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_10'];}
					if(isset($rowDataPost['LicitacionLVL_11'])&&$rowDataPost['LicitacionLVL_11']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_11'];}
					if(isset($rowDataPost['LicitacionLVL_12'])&&$rowDataPost['LicitacionLVL_12']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_12'];}
					if(isset($rowDataPost['LicitacionLVL_13'])&&$rowDataPost['LicitacionLVL_13']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_13'];}
					if(isset($rowDataPost['LicitacionLVL_14'])&&$rowDataPost['LicitacionLVL_14']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_14'];}
					if(isset($rowDataPost['LicitacionLVL_15'])&&$rowDataPost['LicitacionLVL_15']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_15'];}
					if(isset($rowDataPost['LicitacionLVL_16'])&&$rowDataPost['LicitacionLVL_16']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_16'];}
					if(isset($rowDataPost['LicitacionLVL_17'])&&$rowDataPost['LicitacionLVL_17']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_17'];}
					if(isset($rowDataPost['LicitacionLVL_18'])&&$rowDataPost['LicitacionLVL_18']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_18'];}
					if(isset($rowDataPost['LicitacionLVL_19'])&&$rowDataPost['LicitacionLVL_19']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_19'];}
					if(isset($rowDataPost['LicitacionLVL_20'])&&$rowDataPost['LicitacionLVL_20']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_20'];}
					if(isset($rowDataPost['LicitacionLVL_21'])&&$rowDataPost['LicitacionLVL_21']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_21'];}
					if(isset($rowDataPost['LicitacionLVL_22'])&&$rowDataPost['LicitacionLVL_22']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_22'];}
					if(isset($rowDataPost['LicitacionLVL_23'])&&$rowDataPost['LicitacionLVL_23']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_23'];}
					if(isset($rowDataPost['LicitacionLVL_24'])&&$rowDataPost['LicitacionLVL_24']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_24'];}
					if(isset($rowDataPost['LicitacionLVL_25'])&&$rowDataPost['LicitacionLVL_25']!=''){ $NombreItem2 .= ' - '.$rowDataPost['LicitacionLVL_25'];}
					//comparacion cambio tarea
					if(isset($NombreItem1)&&isset($NombreItem2)&&$NombreItem1!=$NombreItem2){
						$NombreItem = 'Se cambia Tarea:<br/>'.$NombreItem1.'<br/>por<br/>'.$NombreItem2;
						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                      //Creacion Satisfactoria
						$SIS_data .= ",'".$NombreItem."'";                                        //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";    //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
					//comparacion cambio de estado
					if(isset($rowData['EstadoTarea'])&&isset($rowDataPost['EstadoTarea'])&&$rowData['EstadoTarea']!=$rowDataPost['EstadoTarea']){
						$NombreItem = 'Se cambia el estado de la Tarea: <br/>'.$NombreItem1.'<br/>- De <strong>'.$rowData['EstadoTarea'].'</strong> por <strong>'.$rowDataPost['EstadoTarea'].'</strong>';
						/*********************************************************************/
						//Se guarda en historial la accion
						if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'1'";                                                      //Creacion Satisfactoria
						$SIS_data .= ",'".$NombreItem."'";                                        //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";    //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/******************************************************************/
						//se revisan la cantidad de tareas pendientes en la OT
						$ndata_1 = 99;
						//Se verifica si el dato existe
						if(isset($idOT)){
							$ndata_1 = db_select_nrows (false, 'idTrabajoOT', 'orden_trabajo_tareas_listado_tareas', '', "idOT='".$idOT."' AND idEstadoTarea='1' ", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						}

						//se actualizala OT dependiendo del caso
						if($ndata_1==0) {
							$SIS_data  = "idEstado='3'";//Finalizada
							$SIS_data .= ",f_termino='".fecha_actual()."'";
							$zza  = "";
							$zza .= ",f_termino_Dia='".fecha2NdiaMes(fecha_actual())."'";
							$zza .= ",f_termino_Semana='".fecha2NSemana(fecha_actual())."'";
							$zza .= ",f_termino_Mes='".fecha2NMes(fecha_actual())."'";
							$zza .= ",f_termino_Ano='".fecha2Ano(fecha_actual())."'";

						}else{
							$SIS_data = "idEstado='2'";//En Ejecucion
						}

						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_insumos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_productos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_responsable', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas_adjuntos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						//se actualizan los datos
						$SIS_data .= $zza ;
						$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&edittarea=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'edit_delTarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_tarea']) OR !validaEntero($_GET['del_tarea']))&&$_GET['del_tarea']!=''){
				$indice = simpleDecode($_GET['del_tarea'], fecha_actual());
			}else{
				$indice = $_GET['del_tarea'];
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
				//Consulto por el item recien ingresado
				$SIS_query = '
				orden_trabajo_tareas_listado_tareas.idOT,
				licitacion_listado.Nombre AS Licitacion,
				licitacion_listado_level_1.Nombre AS LicitacionLVL_1,
				licitacion_listado_level_2.Nombre AS LicitacionLVL_2,
				licitacion_listado_level_3.Nombre AS LicitacionLVL_3,
				licitacion_listado_level_4.Nombre AS LicitacionLVL_4,
				licitacion_listado_level_5.Nombre AS LicitacionLVL_5,
				licitacion_listado_level_6.Nombre AS LicitacionLVL_6,
				licitacion_listado_level_7.Nombre AS LicitacionLVL_7,
				licitacion_listado_level_8.Nombre AS LicitacionLVL_8,
				licitacion_listado_level_9.Nombre AS LicitacionLVL_9,
				licitacion_listado_level_10.Nombre AS LicitacionLVL_10,
				licitacion_listado_level_11.Nombre AS LicitacionLVL_11,
				licitacion_listado_level_12.Nombre AS LicitacionLVL_12,
				licitacion_listado_level_13.Nombre AS LicitacionLVL_13,
				licitacion_listado_level_14.Nombre AS LicitacionLVL_14,
				licitacion_listado_level_15.Nombre AS LicitacionLVL_15,
				licitacion_listado_level_16.Nombre AS LicitacionLVL_16,
				licitacion_listado_level_17.Nombre AS LicitacionLVL_17,
				licitacion_listado_level_18.Nombre AS LicitacionLVL_18,
				licitacion_listado_level_19.Nombre AS LicitacionLVL_19,
				licitacion_listado_level_20.Nombre AS LicitacionLVL_20,
				licitacion_listado_level_21.Nombre AS LicitacionLVL_21,
				licitacion_listado_level_22.Nombre AS LicitacionLVL_22,
				licitacion_listado_level_23.Nombre AS LicitacionLVL_23,
				licitacion_listado_level_24.Nombre AS LicitacionLVL_24,
				licitacion_listado_level_25.Nombre AS LicitacionLVL_25';
				$SIS_join  = '
				LEFT JOIN `core_estado_ot_motivos_tareas`  ON core_estado_ot_motivos_tareas.idEstadoTarea   = orden_trabajo_tareas_listado_tareas.idEstadoTarea
				LEFT JOIN `licitacion_listado`             ON licitacion_listado.idLicitacion               = orden_trabajo_tareas_listado_tareas.idLicitacion
				LEFT JOIN `licitacion_listado_level_1`     ON licitacion_listado_level_1.idLevel_1          = orden_trabajo_tareas_listado_tareas.idLevel_1
				LEFT JOIN `licitacion_listado_level_2`     ON licitacion_listado_level_2.idLevel_2          = orden_trabajo_tareas_listado_tareas.idLevel_2
				LEFT JOIN `licitacion_listado_level_3`     ON licitacion_listado_level_3.idLevel_3          = orden_trabajo_tareas_listado_tareas.idLevel_3
				LEFT JOIN `licitacion_listado_level_4`     ON licitacion_listado_level_4.idLevel_4          = orden_trabajo_tareas_listado_tareas.idLevel_4
				LEFT JOIN `licitacion_listado_level_5`     ON licitacion_listado_level_5.idLevel_5          = orden_trabajo_tareas_listado_tareas.idLevel_5
				LEFT JOIN `licitacion_listado_level_6`     ON licitacion_listado_level_6.idLevel_6          = orden_trabajo_tareas_listado_tareas.idLevel_6
				LEFT JOIN `licitacion_listado_level_7`     ON licitacion_listado_level_7.idLevel_7          = orden_trabajo_tareas_listado_tareas.idLevel_7
				LEFT JOIN `licitacion_listado_level_8`     ON licitacion_listado_level_8.idLevel_8          = orden_trabajo_tareas_listado_tareas.idLevel_8
				LEFT JOIN `licitacion_listado_level_9`     ON licitacion_listado_level_9.idLevel_9          = orden_trabajo_tareas_listado_tareas.idLevel_9
				LEFT JOIN `licitacion_listado_level_10`    ON licitacion_listado_level_10.idLevel_10        = orden_trabajo_tareas_listado_tareas.idLevel_10
				LEFT JOIN `licitacion_listado_level_11`    ON licitacion_listado_level_11.idLevel_11        = orden_trabajo_tareas_listado_tareas.idLevel_11
				LEFT JOIN `licitacion_listado_level_12`    ON licitacion_listado_level_12.idLevel_12        = orden_trabajo_tareas_listado_tareas.idLevel_12
				LEFT JOIN `licitacion_listado_level_13`    ON licitacion_listado_level_13.idLevel_13        = orden_trabajo_tareas_listado_tareas.idLevel_13
				LEFT JOIN `licitacion_listado_level_14`    ON licitacion_listado_level_14.idLevel_14        = orden_trabajo_tareas_listado_tareas.idLevel_14
				LEFT JOIN `licitacion_listado_level_15`    ON licitacion_listado_level_15.idLevel_15        = orden_trabajo_tareas_listado_tareas.idLevel_15
				LEFT JOIN `licitacion_listado_level_16`    ON licitacion_listado_level_16.idLevel_16        = orden_trabajo_tareas_listado_tareas.idLevel_16
				LEFT JOIN `licitacion_listado_level_17`    ON licitacion_listado_level_17.idLevel_17        = orden_trabajo_tareas_listado_tareas.idLevel_17
				LEFT JOIN `licitacion_listado_level_18`    ON licitacion_listado_level_18.idLevel_18        = orden_trabajo_tareas_listado_tareas.idLevel_18
				LEFT JOIN `licitacion_listado_level_19`    ON licitacion_listado_level_19.idLevel_19        = orden_trabajo_tareas_listado_tareas.idLevel_19
				LEFT JOIN `licitacion_listado_level_20`    ON licitacion_listado_level_20.idLevel_20        = orden_trabajo_tareas_listado_tareas.idLevel_20
				LEFT JOIN `licitacion_listado_level_21`    ON licitacion_listado_level_21.idLevel_21        = orden_trabajo_tareas_listado_tareas.idLevel_21
				LEFT JOIN `licitacion_listado_level_22`    ON licitacion_listado_level_22.idLevel_22        = orden_trabajo_tareas_listado_tareas.idLevel_22
				LEFT JOIN `licitacion_listado_level_23`    ON licitacion_listado_level_23.idLevel_23        = orden_trabajo_tareas_listado_tareas.idLevel_23
				LEFT JOIN `licitacion_listado_level_24`    ON licitacion_listado_level_24.idLevel_24        = orden_trabajo_tareas_listado_tareas.idLevel_24
				LEFT JOIN `licitacion_listado_level_25`    ON licitacion_listado_level_25.idLevel_25        = orden_trabajo_tareas_listado_tareas.idLevel_25';
				$SIS_where = 'orden_trabajo_tareas_listado_tareas.idTrabajoOT = '.$indice;
				$rowData = db_select_data (false, $SIS_query, 'orden_trabajo_tareas_listado_tareas', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Nombre del item
				$NombreItem  = 'Se elimina Tarea:<br/>';
				$NombreItem .= '<strong>Licitacion:</strong>'.$rowData['Licitacion'].'<br/>';
				if(isset($rowData['LicitacionLVL_1'])&&$rowData['LicitacionLVL_1']!=''){   $NombreItem .= '<strong>Tarea:</strong>'.$rowData['LicitacionLVL_1'];}
				if(isset($rowData['LicitacionLVL_2'])&&$rowData['LicitacionLVL_2']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_2'];}
				if(isset($rowData['LicitacionLVL_3'])&&$rowData['LicitacionLVL_3']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_3'];}
				if(isset($rowData['LicitacionLVL_4'])&&$rowData['LicitacionLVL_4']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_4'];}
				if(isset($rowData['LicitacionLVL_5'])&&$rowData['LicitacionLVL_5']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_5'];}
				if(isset($rowData['LicitacionLVL_6'])&&$rowData['LicitacionLVL_6']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_6'];}
				if(isset($rowData['LicitacionLVL_7'])&&$rowData['LicitacionLVL_7']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_7'];}
				if(isset($rowData['LicitacionLVL_8'])&&$rowData['LicitacionLVL_8']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_8'];}
				if(isset($rowData['LicitacionLVL_9'])&&$rowData['LicitacionLVL_9']!=''){   $NombreItem .= ' - '.$rowData['LicitacionLVL_9'];}
				if(isset($rowData['LicitacionLVL_10'])&&$rowData['LicitacionLVL_10']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_10'];}
				if(isset($rowData['LicitacionLVL_11'])&&$rowData['LicitacionLVL_11']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_11'];}
				if(isset($rowData['LicitacionLVL_12'])&&$rowData['LicitacionLVL_12']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_12'];}
				if(isset($rowData['LicitacionLVL_13'])&&$rowData['LicitacionLVL_13']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_13'];}
				if(isset($rowData['LicitacionLVL_14'])&&$rowData['LicitacionLVL_14']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_14'];}
				if(isset($rowData['LicitacionLVL_15'])&&$rowData['LicitacionLVL_15']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_15'];}
				if(isset($rowData['LicitacionLVL_16'])&&$rowData['LicitacionLVL_16']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_16'];}
				if(isset($rowData['LicitacionLVL_17'])&&$rowData['LicitacionLVL_17']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_17'];}
				if(isset($rowData['LicitacionLVL_18'])&&$rowData['LicitacionLVL_18']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_18'];}
				if(isset($rowData['LicitacionLVL_19'])&&$rowData['LicitacionLVL_19']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_19'];}
				if(isset($rowData['LicitacionLVL_20'])&&$rowData['LicitacionLVL_20']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_20'];}
				if(isset($rowData['LicitacionLVL_21'])&&$rowData['LicitacionLVL_21']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_21'];}
				if(isset($rowData['LicitacionLVL_22'])&&$rowData['LicitacionLVL_22']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_22'];}
				if(isset($rowData['LicitacionLVL_23'])&&$rowData['LicitacionLVL_23']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_23'];}
				if(isset($rowData['LicitacionLVL_24'])&&$rowData['LicitacionLVL_24']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_24'];}
				if(isset($rowData['LicitacionLVL_25'])&&$rowData['LicitacionLVL_25']!=''){ $NombreItem .= ' - '.$rowData['LicitacionLVL_25'];}

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($rowData['idOT']) && $rowData['idOT']!=''){    $SIS_data  = "'".$rowData['idOT']."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                      //Creacion Satisfactoria
				$SIS_data .= ",'".$NombreItem."'";                                        //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";    //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*************************************************************/
				// Se obtiene el nombre de los archivos
				$arrArchivos = array();
				$arrArchivos = db_select_array (false, 'NombreArchivo', 'orden_trabajo_tareas_listado_tareas_adjuntos', '', 'idTrabajoOT = '.$indice, 'NombreArchivo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado_1 = db_delete_data (false, 'orden_trabajo_tareas_listado_tareas', 'idTrabajoOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'orden_trabajo_tareas_listado_tareas_adjuntos', 'idTrabajoOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

					//se elimina el archivo
					foreach ($arrArchivos as $archivos) {
						if(isset($archivos['NombreArchivo'])&&$archivos['NombreArchivo']!=''){
							try {
								if(!is_writable('upload/'.$archivos['NombreArchivo'])){
									//throw new Exception('File not writable');
								}else{
									unlink('upload/'.$archivos['NombreArchivo']);
								}
							}catch(Exception $e) {
								//guardar el dato en un archivo log
							}
						}
					}

					//redirijo
					header( 'Location: '.$location.'&deltarea=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'edit_editTarea_insert_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'ot_tareas_'.genera_password_unica().'_';
			//Se verifican las extensiones de los archivos
			$permitidos = array("application/msword",
								"application/vnd.ms-word",
								"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

								"application/msexcel",
								"application/vnd.ms-excel",
								"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

								"application/mspowerpoint",
								"application/vnd.ms-powerpoint",
								"application/vnd.openxmlformats-officedocument.presentationml.presentation",

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

			/********************************************************************/
			//Verifico errores en los archivos
			foreach($_FILES["NombreArchivo"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["NombreArchivo"]["error"][$key] > 0){
					$error['NombreArchivo'] = 'error/'.uploadPHPError($_FILES["NombreArchivo"]["error"][$key]);
				}
				if (in_array($_FILES['NombreArchivo']['type'][$key], $permitidos) && $_FILES['NombreArchivo']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['NombreArchivo']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['NombreArchivo']     = 'error/El archivo '.$_FILES['NombreArchivo']['name'][$key].' ya existe';
					}
				} else {
					$error['NombreArchivo']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

			/********************************************************************/
			if(empty($error)){

				//Verifico errores en los archivos
				foreach($_FILES["NombreArchivo"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["NombreArchivo"]["error"][$key] > 0){
						$error['NombreArchivo']  = 'error/'.uploadPHPError($_FILES["NombreArchivo"]["error"][$key]);
					}
					if (in_array($_FILES['NombreArchivo']['type'][$key], $permitidos) && $_FILES['NombreArchivo']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = "upload/".$sufijo.$_FILES['NombreArchivo']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$move_result = @move_uploaded_file($_FILES["NombreArchivo"]["tmp_name"][$key], $ruta);
							if ($move_result){

								//renombro archivo
								$NombreArchivo = $sufijo.$_FILES['NombreArchivo']['name'][$key];
								//filtros
								if(isset($idOT) && $idOT!=''){                            $SIS_data  = "'".$idOT."'";                 }else{$SIS_data  = "''";}
								if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
								if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",'".$idUbicacion."'";         }else{$SIS_data .= ",''";}
								if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",'".$idUbicacion_lvl_1."'";   }else{$SIS_data .= ",''";}
								if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",'".$idUbicacion_lvl_2."'";   }else{$SIS_data .= ",''";}
								if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",'".$idUbicacion_lvl_3."'";   }else{$SIS_data .= ",''";}
								if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",'".$idUbicacion_lvl_4."'";   }else{$SIS_data .= ",''";}
								if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",'".$idUbicacion_lvl_5."'";   }else{$SIS_data .= ",''";}
								if(isset($idUsuario) && $idUsuario!=''){                  $SIS_data .= ",'".$idUsuario."'";           }else{$SIS_data .= ",''";}
								if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
								if(isset($idPrioridad) && $idPrioridad!=''){              $SIS_data .= ",'".$idPrioridad."'";         }else{$SIS_data .= ",''";}
								if(isset($idTipo) && $idTipo!=''){                        $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
								if(isset($f_creacion) && $f_creacion!=''){                $SIS_data .= ",'".$f_creacion."'";          }else{$SIS_data .= ",''";}
								if(isset($f_programacion) && $f_programacion!=''){        $SIS_data .= ",'".$f_programacion."'";      }else{$SIS_data .= ",''";}
								if(isset($idTrabajoOT) && $idTrabajoOT!=''){              $SIS_data .= ",'".$idTrabajoOT."'";         }else{$SIS_data .= ",''";}
								if(isset($NombreArchivo) && $NombreArchivo!=''){          $SIS_data .= ",'".$NombreArchivo."'";       }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT,idSistema,idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
								idUbicacion_lvl_5,idUsuario, idEstado,idPrioridad,idTipo,f_creacion,f_programacion,
								idTrabajoOT, NombreArchivo';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_tareas_adjuntos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/*********************************************************************/
								//Se guarda en historial la accion
								if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
								$SIS_data .= ",'".fecha_actual()."'";
								$SIS_data .= ",'1'";                                                        //Creacion Satisfactoria
								$SIS_data .= ",'Se adjunta Archivo: <strong>".$NombreArchivo."</strong>'";  //Observacion
								$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";      //idUsuario

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							} else {
								$error['NombreArchivo']     = 'error/Ocurrio un error al mover el archivo';
							}
						}else{
							$error['NombreArchivo']     = 'error/El archivo '.$_FILES['NombreArchivo']['name'][$key].' ya existe';
						}
					} else {
						$error['NombreArchivo']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
					}
				}

				header( 'Location: '.$location.'&addArchivo=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'edit_editTarea_del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_file']) OR !validaEntero($_GET['del_file']))&&$_GET['del_file']!=''){
				$indice = simpleDecode($_GET['del_file'], fecha_actual());
			}else{
				$indice = $_GET['del_file'];
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
				$rowData = db_select_data (false, 'idOT, NombreArchivo', 'orden_trabajo_tareas_listado_tareas_adjuntos', '', 'idAdjunto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*********************************************************************/
				//Se guarda en historial la accion
				if(isset($rowData['idOT']) && $rowData['idOT']!=''){    $SIS_data  = "'".$rowData['idOT']."'";  }else{$SIS_data  = "''";}
				$SIS_data .= ",'".fecha_actual()."'";
				$SIS_data .= ",'1'";                                                                   //Creacion Satisfactoria
				$SIS_data .= ",'Se elimina Archivo: <strong>".$rowData['NombreArchivo']."</strong>'";  //Observacion
				$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";                 //idUsuario

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_tareas_listado_tareas_adjuntos', 'idAdjunto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//se elimina el archivo
					if(isset($rowData['NombreArchivo'])&&$rowData['NombreArchivo']!=''){
						try {
							if(!is_writable('upload/'.$rowData['NombreArchivo'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$rowData['NombreArchivo']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}

					//redirijo
					header( 'Location: '.$location.'&delArchivo=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'cancel_ot':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se actualizala OT dependiendo del caso
			$SIS_data  = "idEstado='4'";//Cancelada
			$zza  = "";
			$zza .= ",idUsuarioCancel='".$idUsuarioCancel."'";
			$zza .= ",f_cancel='".$f_cancel."'";
			$zza .= ",ObservacionesCancel='".$ObservacionesCancel."'";

			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_insumos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_productos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_responsable', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//se actualizan los datos
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado_tareas_adjuntos', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//se actualizan los datos
			$SIS_data .= $zza ;
			$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_tareas_listado', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*********************************************************************/
			//Se guarda en historial la accion
			if(isset($idOT) && $idOT!=''){    $SIS_data  = "'".$idOT."'";  }else{$SIS_data  = "''";}
			$SIS_data .= ",'".fecha_actual()."'";
			$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
			$SIS_data .= ",'La Orden de Trabajo es cancelada'";                     //Observacion
			$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

			// inserto los datos de registro en la db
			$SIS_columns = 'idOT, Creacion_fecha, idTipo, Observacion, idUsuario';
			$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_tareas_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Si ejecuto correctamente la consulta
			if($ultimo_id!=0){
				//redirijo
				header( 'Location: '.$location.'&canceled=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
	}

?>
