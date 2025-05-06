<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-249).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idOT']))                 $idOT                    = $_POST['idOT'];
	if (!empty($_POST['idSistema']))            $idSistema               = $_POST['idSistema'];
	if (!empty($_POST['idCliente']))            $idCliente               = $_POST['idCliente'];
	if (!empty($_POST['idMaquina']))            $idMaquina               = $_POST['idMaquina'];
	if (!empty($_POST['idUsuario']))            $idUsuario               = $_POST['idUsuario'];
	if (!empty($_POST['idEstado']))             $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idPrioridad']))          $idPrioridad             = $_POST['idPrioridad'];
	if (!empty($_POST['idTipo']))               $idTipo                  = $_POST['idTipo'];
	if (!empty($_POST['f_creacion']))           $f_creacion 	         = $_POST['f_creacion'];
	if (!empty($_POST['f_programacion']))       $f_programacion          = $_POST['f_programacion'];
	if (!empty($_POST['f_ejecucion']))          $f_ejecucion             = $_POST['f_ejecucion'];
	if (!empty($_POST['f_termino']))            $f_termino 	             = $_POST['f_termino'];
	if (!empty($_POST['Observaciones']))        $Observaciones           = $_POST['Observaciones'];
	if (!empty($_POST['progDia']))              $progDia                 = $_POST['progDia'];
	if (!empty($_POST['progMes']))              $progMes                 = $_POST['progMes'];
	if (!empty($_POST['progAno']))              $progAno                 = $_POST['progAno'];
	if (!empty($_POST['terDia']))               $terDia                  = $_POST['terDia'];
	if (!empty($_POST['terMes']))               $terMes                  = $_POST['terMes'];
	if (!empty($_POST['terAno']))               $terAno                  = $_POST['terAno'];
	if (!empty($_POST['idSupervisor']))         $idSupervisor            = $_POST['idSupervisor'];
	if (!empty($_POST['horaProg']))             $horaProg                = $_POST['horaProg'];
	if (!empty($_POST['horaInicio']))           $horaInicio              = $_POST['horaInicio'];
	if (!empty($_POST['horaTermino']))          $horaTermino             = $_POST['horaTermino'];
	if (!empty($_POST['idTelemetria']))         $idTelemetria            = $_POST['idTelemetria'];
	if (!empty($_POST['Descripcion']))          $Descripcion             = $_POST['Descripcion'];

	//Traspaso de valores input a variables
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

	//otros datos
	if (!empty($_POST['idTrabajador']))         $idTrabajador            = $_POST['idTrabajador'];
	if (!empty($_POST['idProducto']))           $idProducto              = $_POST['idProducto'];
	if (!empty($_POST['Cantidad']))             $Cantidad                = $_POST['Cantidad'];
	if (!empty($_POST['idItemizado']))          $idItemizado             = $_POST['idItemizado'];
	if (!empty($_POST['tabla']))                $tabla                   = $_POST['tabla'];
	if (!empty($_POST['id_tabla']))             $id_tabla                = $_POST['id_tabla'];
	if (!empty($_POST['idInterno']))            $idInterno               = $_POST['idInterno'];
	if (!empty($_POST['tablaitem']))            $tablaitem               = $_POST['tablaitem'];
	if (!empty($_POST['idUml']))                $idUml                   = $_POST['idUml'];
	if ( isset($_POST['Grasa_inicial']))        $Grasa_inicial           = $_POST['Grasa_inicial'];
	if ( isset($_POST['Grasa_relubricacion']))  $Grasa_relubricacion     = $_POST['Grasa_relubricacion'];
	if ( isset($_POST['Aceite']))               $Aceite                  = $_POST['Aceite'];
	if ( isset($_POST['idSubTipo']))            $idSubTipo               = $_POST['idSubTipo'];
	if (!empty($_POST['idResponsable']))        $idResponsable           = $_POST['idResponsable'];
	if (!empty($_POST['idInsumos']))            $idInsumos               = $_POST['idInsumos'];
	if (!empty($_POST['idProductos']))          $idProductos             = $_POST['idProductos'];
	if (!empty($_POST['idAnalisis']))           $idAnalisis              = $_POST['idAnalisis'];
	if (!empty($_POST['Observacion']))          $Observacion             = $_POST['Observacion'];
	if (!empty($_POST['idTrabajoOT']))          $idTrabajoOT             = $_POST['idTrabajoOT'];

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
			case 'idOT':                  if(empty($idOT)){                   $error['idOT']                    = 'error/No ha ingresado el id del sistema';}break;
			case 'idSistema':             if(empty($idSistema)){              $error['idSistema']               = 'error/No ha ingresado el idSistema del sistema';}break;
			case 'idCliente':             if(empty($idCliente)){              $error['idCliente']               = 'error/No ha seleccionado un cliente';}break;
			case 'idMaquina':             if(empty($idMaquina)){              $error['idMaquina']               = 'error/No ha ingresado la maquina';}break;
			case 'idUsuario':             if(empty($idUsuario)){              $error['idUsuario']               = 'error/No ha ingresado el usuario';}break;
			case 'idEstado':              if(empty($idEstado)){               $error['idEstado']                = 'error/No ha ingresado el estado';}break;
			case 'idPrioridad':           if(empty($idPrioridad)){            $error['idPrioridad']             = 'error/No ha ingresado la prioridad';}break;
			case 'idTipo':                if(empty($idTipo)){                 $error['idTipo']                  = 'error/No ha ingresado el tipo';}break;
			case 'f_creacion':            if(empty($f_creacion)){             $error['f_creacion']              = 'error/No ha ingresado la fecha de creación';}break;
			case 'f_programacion':        if(empty($f_programacion)){         $error['f_programacion']          = 'error/No ha ingresado la fecha de programacion';}break;
			case 'f_ejecucion':           if(empty($f_ejecucion)){            $error['f_ejecucion']             = 'error/No ha ingresado la fecha de ejecucion';}break;
			case 'f_termino':             if(empty($f_termino)){              $error['f_termino']               = 'error/No ha ingresado la fecha de termino';}break;
			case 'Observaciones':         if(empty($Observaciones)){          $error['Observaciones']           = 'error/No ha ingresado la observacion';}break;
			case 'progDia':               if(empty($progDia)){                $error['progDia']                 = 'error/No ha ingresado el dia de programacion';}break;
			case 'progMes':               if(empty($progMes)){                $error['progMes']                 = 'error/No ha ingresado el mes de programacion';}break;
			case 'progAno':               if(empty($progAno)){                $error['progAno']                 = 'error/No ha ingresado el año de programacion';}break;
			case 'terDia':                if(empty($terDia)){                 $error['terDia']                  = 'error/No ha ingresado el dia de termino';}break;
			case 'terMes':                if(empty($terMes)){                 $error['terMes']                  = 'error/No ha ingresado el mes de termino';}break;
			case 'terAno':                if(empty($terAno)){                 $error['terAno']                  = 'error/No ha ingresado el año de termino';}break;
			case 'idSupervisor':          if(empty($idSupervisor)){           $error['idSupervisor']            = 'error/No ha seleccionado el supervisor';}break;
			case 'horaProg':              if(empty($horaProg)){               $error['horaProg']                = 'error/No ha ingresado la hora programada';}break;
			case 'horaInicio':            if(empty($horaInicio)){             $error['horaInicio']              = 'error/No ha ingresado la hora de inicio';}break;
			case 'horaTermino':           if(empty($horaTermino)){            $error['horaTermino']             = 'error/No ha ingresado la hora de termino';}break;
			case 'idTelemetria':          if(empty($idTelemetria)){           $error['idTelemetria']            = 'error/No ha seleccionado el equipo de telemetria';}break;
			case 'Descripcion':           if(empty($Descripcion)){            $error['Descripcion']             = 'error/No ha ingresado la descripcion del trabajo a realizar';}break;

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

			case 'idTrabajador':          if(empty($idTrabajador)){           $error['idTrabajador']            = 'error/No ha ingresado el trabajador';}break;
			case 'idProducto':            if(empty($idProducto)){             $error['idProducto']              = 'error/No ha ingresado el componente';}break;
			case 'idItemizado':           if(empty($idItemizado)){            $error['idItemizado']             = 'error/No ha ingresado la observacion';}break;
			case 'tabla':                 if(empty($tabla)){                  $error['tabla']                   = 'error/No ha ingresado el trabajo';}break;
			case 'id_tabla':              if(empty($id_tabla)){               $error['id_tabla']                = 'error/No ha ingresado la tabla';}break;
			case 'idInterno':             if(empty($idInterno)){              $error['idInterno']               = 'error/No ha ingresado el id de tabla';}break;
			case 'tablaitem':             if(empty($tablaitem)){              $error['tablaitem']               = 'error/No ha ingresado la tabla itemizado';}break;
			case 'idUml':                 if(empty($idUml)){                  $error['idUml']                   = 'error/No ha ingresado el id unidad medida';}break;
			case 'Grasa_inicial':         if(!isset($Grasa_inicial)){         $error['Grasa_inicial']           = 'error/No ha ingresado la cantidad de grasa inicial';}break;
			case 'Grasa_relubricacion':   if(!isset($Grasa_relubricacion)){   $error['Grasa_relubricacion']     = 'error/No ha ingresado la cantidad de grasa de relubricacion';}break;
			case 'Aceite':                if(!isset($Aceite)){                $error['Aceite']                  = 'error/No ha ingresado la cantidad de aceite';}break;
			case 'Cantidad':              if(!isset($Cantidad)){              $error['Cantidad']                = 'error/No ha ingresado la cantidad';}break;
			case 'idSubTipo':             if(!isset($idSubTipo)){             $error['idSubTipo']               = 'error/No ha seleccionado el tipo de trabajo';}break;
			case 'idResponsable':         if(empty($idResponsable)){          $error['idResponsable']           = 'error/No ha seleccionado el responsable';}break;
			case 'idInsumos':             if(empty($idInsumos)){              $error['idInsumos']               = 'error/No ha seleccionado el insumo';}break;
			case 'idProductos':           if(empty($idProductos)){            $error['idProductos']             = 'error/No ha seleccionado el producto';}break;
			case 'idAnalisis':            if(empty($idAnalisis)){             $error['idAnalisis']              = 'error/No ha seleccionado el analisis';}break;
			case 'Observacion':           if(empty($Observacion)){            $error['Observacion']             = 'error/No ha ingresado la observacion';}break;
			case 'idTrabajoOT':           if(empty($idTrabajoOT)){            $error['idTrabajoOT']             = 'error/No ha ingresado el ID del trabajo';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}
	if(isset($Observacion) && $Observacion!=''){     $Observacion   = EstandarizarInput($Observacion);}
	if(isset($Descripcion) && $Descripcion!=''){     $Descripcion   = EstandarizarInput($Descripcion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}
	if(isset($Observacion)&&contar_palabras_censuradas($Observacion)!=0){      $error['Observacion']   = 'error/Edita Observacion, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){      $error['Descripcion']   = 'error/Edita Descripcion, contiene palabras no permitidas';}

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
				unset($_SESSION['ot_basicos']);
				unset($_SESSION['ot_trabajador']);
				unset($_SESSION['ot_trabajos']);
				unset($_SESSION['ot_temporal']);
				unset($_SESSION['ot_insumos']);
				unset($_SESSION['ot_productos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idMaquina)&&$idMaquina!=''){            $_SESSION['ot_basicos']['idMaquina']       = $idMaquina;       }else{$_SESSION['ot_basicos']['idMaquina']      = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){        $_SESSION['ot_basicos']['idPrioridad']     = $idPrioridad;     }else{$_SESSION['ot_basicos']['idPrioridad']    = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['ot_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['ot_basicos']['idTipo']         = '';}
				if(isset($f_programacion)&&$f_programacion!=''){  $_SESSION['ot_basicos']['f_programacion']  = $f_programacion;  }else{$_SESSION['ot_basicos']['f_programacion'] = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['ot_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['ot_basicos']['idSistema']      = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['ot_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['ot_basicos']['idUsuario']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['ot_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['ot_basicos']['idEstado']       = '';}
				if(isset($f_creacion)&&$f_creacion!=''){          $_SESSION['ot_basicos']['f_creacion']      = $f_creacion;      }else{$_SESSION['ot_basicos']['f_creacion']     = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['ot_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['ot_basicos']['Observaciones']  = '';}
				if(isset($idCliente)&&$idCliente!=''){            $_SESSION['ot_basicos']['idCliente']       = $idCliente;       }else{$_SESSION['ot_basicos']['idCliente']      = '';}
				if(isset($idTelemetria)&&$idTelemetria!=''){      $_SESSION['ot_basicos']['idTelemetria']    = $idTelemetria;    }else{$_SESSION['ot_basicos']['idTelemetria']   = '';}

				//Se guarda el trabajador asignado
				if(isset($idTrabajador)&&$idTrabajador!=''){ $_SESSION['ot_trabajador'][$idTrabajador]['idTrabajador'] = $idTrabajador;}

				/****************************************************/
				if(isset($idMaquina) && $idMaquina!=''){
					// consulto los datos
					$rowMaquina = db_select_data (false, 'Nombre', 'maquinas_listado', '', 'idMaquina='.$idMaquina, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['NombreMaquina'] = $rowMaquina['Nombre'];
				}else{
					$_SESSION['ot_basicos']['NombreMaquina'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente='.$idCliente, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['NombreCliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['ot_basicos']['NombreCliente'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_ot_prioridad', '', 'idPrioridad='.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_ot_tipos', '', 'idTipo='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Tipo'] = '';
				}
				/****************************************************/
				if(isset($idTrabajador) && $idTrabajador!=''){
					// consulto los datos
					$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_trabajador'][$idTrabajador]['Trabajador']   = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
					$_SESSION['ot_trabajador'][$idTrabajador]['Cargo']        = $rowTrabajador['Cargo'];
					$_SESSION['ot_trabajador'][$idTrabajador]['Rut']          = $rowTrabajador['Rut'];
				}else{
					$_SESSION['ot_trabajador'][$idTrabajador]['Trabajador']   = '';
					$_SESSION['ot_trabajador'][$idTrabajador]['Cargo']        = '';
					$_SESSION['ot_trabajador'][$idTrabajador]['Rut']          = '';
				}
				/****************************************************/
				if(isset($idTelemetria) && $idTelemetria!=''){
					// consulto los datos
					$rowTelemetria = db_select_data (false, 'Nombre', 'telemetria_listado', '', 'idTelemetria='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Telemetria'] = $rowTelemetria['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Telemetria'] = '';
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
			unset($_SESSION['ot_basicos']);
			unset($_SESSION['ot_trabajador']);
			unset($_SESSION['ot_trabajos']);
			unset($_SESSION['ot_temporal']);
			unset($_SESSION['ot_insumos']);
			unset($_SESSION['ot_productos']);

			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'mod_base':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				unset($_SESSION['ot_trabajos']);
				unset($_SESSION['ot_temporal']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($idMaquina)&&$idMaquina!=''){            $_SESSION['ot_basicos']['idMaquina']       = $idMaquina;       }else{$_SESSION['ot_basicos']['idMaquina']      = '';}
				if(isset($idPrioridad)&&$idPrioridad!=''){        $_SESSION['ot_basicos']['idPrioridad']     = $idPrioridad;     }else{$_SESSION['ot_basicos']['idPrioridad']    = '';}
				if(isset($idTipo)&&$idTipo!=''){                  $_SESSION['ot_basicos']['idTipo']          = $idTipo;          }else{$_SESSION['ot_basicos']['idTipo']         = '';}
				if(isset($f_programacion)&&$f_programacion!=''){  $_SESSION['ot_basicos']['f_programacion']  = $f_programacion;  }else{$_SESSION['ot_basicos']['f_programacion'] = '';}
				if(isset($idSistema)&&$idSistema!=''){            $_SESSION['ot_basicos']['idSistema']       = $idSistema;       }else{$_SESSION['ot_basicos']['idSistema']      = '';}
				if(isset($idUsuario)&&$idUsuario!=''){            $_SESSION['ot_basicos']['idUsuario']       = $idUsuario;       }else{$_SESSION['ot_basicos']['idUsuario']      = '';}
				if(isset($idEstado)&&$idEstado!=''){              $_SESSION['ot_basicos']['idEstado']        = $idEstado;        }else{$_SESSION['ot_basicos']['idEstado']       = '';}
				if(isset($f_creacion)&&$f_creacion!=''){          $_SESSION['ot_basicos']['f_creacion']      = $f_creacion;      }else{$_SESSION['ot_basicos']['f_creacion']     = '';}
				if(isset($Observaciones)&&$Observaciones!=''){    $_SESSION['ot_basicos']['Observaciones']   = $Observaciones;   }else{$_SESSION['ot_basicos']['Observaciones']  = '';}
				if(isset($idCliente)&&$idCliente!=''){            $_SESSION['ot_basicos']['idCliente']       = $idCliente;       }else{$_SESSION['ot_basicos']['idCliente']      = '';}
				if(isset($idTelemetria)&&$idTelemetria!=''){      $_SESSION['ot_basicos']['idTelemetria']    = $idTelemetria;    }else{$_SESSION['ot_basicos']['idTelemetria']   = '';}

				/****************************************************/
				if(isset($idMaquina) && $idMaquina!=''){
					// consulto los datos
					$rowMaquina = db_select_data (false, 'Nombre', 'maquinas_listado', '', 'idMaquina='.$idMaquina, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['NombreMaquina'] = $rowMaquina['Nombre'];
				}else{
					$_SESSION['ot_basicos']['NombreMaquina'] = '';
				}
				/****************************************************/
				if(isset($idCliente) && $idCliente!=''){
					// consulto los datos
					$rowCliente = db_select_data (false, 'Nombre', 'clientes_listado', '', 'idCliente='.$idCliente, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['NombreCliente'] = $rowCliente['Nombre'];
				}else{
					$_SESSION['ot_basicos']['NombreCliente'] = '';
				}
				/****************************************************/
				if(isset($idPrioridad) && $idPrioridad!=''){
					// consulto los datos
					$rowPrioridad = db_select_data (false, 'Nombre', 'core_ot_prioridad', '', 'idPrioridad='.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Prioridad'] = $rowPrioridad['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Prioridad'] = '';
				}
				/****************************************************/
				if(isset($idTipo) && $idTipo!=''){
					// consulto los datos
					$rowTipo = db_select_data (false, 'Nombre', 'core_ot_tipos', '', 'idTipo='.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Tipo'] = $rowTipo['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Tipo'] = '';
				}
				/****************************************************/
				if(isset($idTelemetria) && $idTelemetria!=''){
					// consulto los datos
					$rowTelemetria = db_select_data (false, 'Nombre', 'telemetria_listado', '', 'idTelemetria='.$idTelemetria, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se guarda dato
					$_SESSION['ot_basicos']['Telemetria'] = $rowTelemetria['Nombre'];
				}else{
					$_SESSION['ot_basicos']['Telemetria'] = '';
				}

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'addTrab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Se verifica si el dato existe
			if(isset($_SESSION['ot_trabajador'][$idTrabajador]['idTrabajador'])&&$_SESSION['ot_trabajador'][$idTrabajador]['idTrabajador']!=''){
				$error['ndata_1'] = 'error/El Trabajador seleccionado ya existe';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowTrabajador = db_select_data (false, 'Nombre,ApellidoPat, ApellidoMat, Cargo, Rut', 'trabajadores_listado', '', 'idTrabajador ='.$idTrabajador, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el trabajador asignado
				$_SESSION['ot_trabajador'][$idTrabajador]['idTrabajador'] = $idTrabajador;
				$_SESSION['ot_trabajador'][$idTrabajador]['Trabajador']   = $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'];
				$_SESSION['ot_trabajador'][$idTrabajador]['Cargo']        = $rowTrabajador['Cargo'];
				$_SESSION['ot_trabajador'][$idTrabajador]['Rut']          = $rowTrabajador['Rut'];

				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_trab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_trabajador'][$_GET['del_trab']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'add_ins':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Se verifica si el dato existe
			if(isset($_SESSION['ot_insumos'][$idProducto]['idProducto'])&&$_SESSION['ot_insumos'][$idProducto]['idProducto']!=''){
				$error['ndata_1'] = 'error/El Insumo seleccionado ya existe';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowProducto = db_select_data (false, 'insumos_listado.Nombre AS NombreProducto, sistema_productos_uml.Nombre AS Unimed', 'insumos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = insumos_listado.idUml', 'insumos_listado.idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el insumos asignado
				$_SESSION['ot_insumos'][$idProducto]['idProducto'] = $idProducto;
				$_SESSION['ot_insumos'][$idProducto]['Cantidad']   = $Cantidad;
				$_SESSION['ot_insumos'][$idProducto]['Nombre']     = $rowProducto['NombreProducto'];
				$_SESSION['ot_insumos'][$idProducto]['Unimed']     = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_ins':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_insumos'][$_GET['del_ins']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'add_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//Se verifica si el dato existe
			if(isset($_SESSION['ot_productos'][$idProducto]['idProducto'])&&$_SESSION['ot_productos'][$idProducto]['idProducto']!=''){
				$error['ndata_1'] = 'error/El Producto seleccionado ya existe';
			}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				// consulto los datos
				$rowProducto = db_select_data (false, 'productos_listado.Nombre AS NombreProducto, sistema_productos_uml.Nombre AS Unimed', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se guarda el productos asignado
				$_SESSION['ot_productos'][$idProducto]['idProducto'] = $idProducto;
				$_SESSION['ot_productos'][$idProducto]['Cantidad']   = $Cantidad;
				$_SESSION['ot_productos'][$idProducto]['Nombre']     = $rowProducto['NombreProducto'];
				$_SESSION['ot_productos'][$idProducto]['Unimed']     = $rowProducto['Unimed'];

				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'del_prod':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_productos'][$_GET['del_prod']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'submit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($idLevel[1])&&$idLevel[1]!=''){   $id_tabla = $idLevel[1];  $tabla=1;  $id_tabla_madre = 0;            $tabla_madre=0; }
			if(isset($idLevel[2])&&$idLevel[2]!=''){   $id_tabla = $idLevel[2];  $tabla=2;  $id_tabla_madre = $idLevel[1];  $tabla_madre=1; }
			if(isset($idLevel[3])&&$idLevel[3]!=''){   $id_tabla = $idLevel[3];  $tabla=3;  $id_tabla_madre = $idLevel[2];  $tabla_madre=2; }
			if(isset($idLevel[4])&&$idLevel[4]!=''){   $id_tabla = $idLevel[4];  $tabla=4;  $id_tabla_madre = $idLevel[3];  $tabla_madre=3; }
			if(isset($idLevel[5])&&$idLevel[5]!=''){   $id_tabla = $idLevel[5];  $tabla=5;  $id_tabla_madre = $idLevel[4];  $tabla_madre=4; }
			if(isset($idLevel[6])&&$idLevel[6]!=''){   $id_tabla = $idLevel[6];  $tabla=6;  $id_tabla_madre = $idLevel[5];  $tabla_madre=5; }
			if(isset($idLevel[7])&&$idLevel[7]!=''){   $id_tabla = $idLevel[7];  $tabla=7;  $id_tabla_madre = $idLevel[6];  $tabla_madre=6; }
			if(isset($idLevel[8])&&$idLevel[8]!=''){   $id_tabla = $idLevel[8];  $tabla=8;  $id_tabla_madre = $idLevel[7];  $tabla_madre=7; }
			if(isset($idLevel[9])&&$idLevel[9]!=''){   $id_tabla = $idLevel[9];  $tabla=9;  $id_tabla_madre = $idLevel[8];  $tabla_madre=8; }
			if(isset($idLevel[10])&&$idLevel[10]!=''){ $id_tabla = $idLevel[10]; $tabla=10; $id_tabla_madre = $idLevel[9];  $tabla_madre=9; }
			if(isset($idLevel[11])&&$idLevel[11]!=''){ $id_tabla = $idLevel[11]; $tabla=11; $id_tabla_madre = $idLevel[10]; $tabla_madre=10; }
			if(isset($idLevel[12])&&$idLevel[12]!=''){ $id_tabla = $idLevel[12]; $tabla=12; $id_tabla_madre = $idLevel[11]; $tabla_madre=11; }
			if(isset($idLevel[13])&&$idLevel[13]!=''){ $id_tabla = $idLevel[13]; $tabla=13; $id_tabla_madre = $idLevel[12]; $tabla_madre=12; }
			if(isset($idLevel[14])&&$idLevel[14]!=''){ $id_tabla = $idLevel[14]; $tabla=14; $id_tabla_madre = $idLevel[13]; $tabla_madre=13; }
			if(isset($idLevel[15])&&$idLevel[15]!=''){ $id_tabla = $idLevel[15]; $tabla=15; $id_tabla_madre = $idLevel[14]; $tabla_madre=14; }
			if(isset($idLevel[16])&&$idLevel[16]!=''){ $id_tabla = $idLevel[16]; $tabla=16; $id_tabla_madre = $idLevel[15]; $tabla_madre=15; }
			if(isset($idLevel[17])&&$idLevel[17]!=''){ $id_tabla = $idLevel[17]; $tabla=17; $id_tabla_madre = $idLevel[16]; $tabla_madre=16; }
			if(isset($idLevel[18])&&$idLevel[18]!=''){ $id_tabla = $idLevel[18]; $tabla=18; $id_tabla_madre = $idLevel[17]; $tabla_madre=17; }
			if(isset($idLevel[19])&&$idLevel[19]!=''){ $id_tabla = $idLevel[19]; $tabla=19; $id_tabla_madre = $idLevel[18]; $tabla_madre=18; }
			if(isset($idLevel[20])&&$idLevel[20]!=''){ $id_tabla = $idLevel[20]; $tabla=20; $id_tabla_madre = $idLevel[19]; $tabla_madre=19; }
			if(isset($idLevel[21])&&$idLevel[21]!=''){ $id_tabla = $idLevel[21]; $tabla=21; $id_tabla_madre = $idLevel[20]; $tabla_madre=20; }
			if(isset($idLevel[22])&&$idLevel[22]!=''){ $id_tabla = $idLevel[22]; $tabla=22; $id_tabla_madre = $idLevel[21]; $tabla_madre=21; }
			if(isset($idLevel[23])&&$idLevel[23]!=''){ $id_tabla = $idLevel[23]; $tabla=23; $id_tabla_madre = $idLevel[22]; $tabla_madre=22; }
			if(isset($idLevel[24])&&$idLevel[24]!=''){ $id_tabla = $idLevel[24]; $tabla=24; $id_tabla_madre = $idLevel[23]; $tabla_madre=23; }
			if(isset($idLevel[25])&&$idLevel[25]!=''){ $id_tabla = $idLevel[25]; $tabla=25; $id_tabla_madre = $idLevel[24]; $tabla_madre=24; }

			// Se traen los datos de la tabla madre
			if((!isset($Descripcion) OR $Descripcion=='')&&isset($id_tabla_madre)&&$id_tabla_madre!=0){
				$rowData_m = db_select_data (false, 'idUtilizable,tabla, table_value, idLicitacion', 'maquinas_listado_level_'.$tabla_madre, '', 'idLevel_'.$tabla_madre.'='.$id_tabla_madre, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica que sea un componente
				if(isset($rowData_m['idUtilizable'])&&$rowData_m['idUtilizable']!=3&&$rowData_m['tabla']==0){
					$error['tabla'] = 'error/El dato seleccionado no posee tareas asignadas';
				}
			}

			// Se traen todos los datos de la maquina
			$SIS_query = '
			maquinas_listado_level_'.$tabla.'.Nombre,
			maquinas_listado_level_'.$tabla.'.Codigo,
			maquinas_listado_level_'.$tabla.'.idUtilizable,
			maquinas_listado_level_'.$tabla.'.idSubTipo,
			maquinas_listado_level_'.$tabla.'.idProducto,
			maquinas_listado_level_'.$tabla.'.Grasa_inicial,
			maquinas_listado_level_'.$tabla.'.Grasa_relubricacion,
			maquinas_listado_level_'.$tabla.'.Aceite,
			maquinas_listado_level_'.$tabla.'.Cantidad,
			maquinas_listado_level_'.$tabla.'.idUml,
			productos_listado.Nombre AS Producto,
			sistema_productos_uml.Nombre AS Unimed';
			$SIS_join  = '
			LEFT JOIN `productos_listado`       ON productos_listado.idProducto  = maquinas_listado_level_'.$tabla.'.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = maquinas_listado_level_'.$tabla.'.idUml';
			$SIS_where = 'idLevel_'.$tabla.' = '.$id_tabla;
			$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_level_'.$tabla, $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//se verifica que sea un subcomponente
			if(isset($rowData['idUtilizable'])&&$rowData['idUtilizable']!=''&&$rowData['idUtilizable']!=3){
				$error['subcomponente'] = 'error/El dato seleccionado no es un subcomponente';
			}

			//se establece variable inicial
			$idInterno = 0;

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ot_trabajos'][$tabla][$id_tabla])){
				foreach ($_SESSION['ot_trabajos'][$tabla][$id_tabla] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''){
						$idInterno = $trabajos['valor_id'];
					}
				}
			}

			if(empty($error)){

				$idInterno = $idInterno+1;
				//Para mostrar en la creación
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Nombre']      = $rowData['Nombre'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Codigo']      = $rowData['Codigo'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Producto']    = $rowData['Producto'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Unimed']      = $rowData['Unimed'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['valor_id']    = $idInterno;
				if(isset($Descripcion)&&$Descripcion!=''){
					$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Descripcion'] = $Descripcion;
				}

				//variables vacias
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1']       = '';
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_2']       = '';
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t']       = '';
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Item_Codigo']  = '';
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Item_Nombre']  = '';

				//Datos para guardar en la base de datos
				//subcomponente seleccionado
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['id_tabla']       = $id_tabla;
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['tabla']          = $tabla;
				//tabla madre del itemizado
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['tabla_m']        = $rowData_m['tabla'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['tabla_m_value']  = $rowData_m['table_value'];
				//productos a utilizar
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idProducto']  = $rowData['idProducto'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idUml']       = $rowData['idUml'];
				//medidas
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = $rowData['Grasa_inicial'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = $rowData['Grasa_relubricacion'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Aceite']               = $rowData['Aceite'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Cantidad']             = $rowData['Cantidad'];
				//idSubTipo
				if(isset($idSubTipo)&&$idSubTipo!=''){
					//consulto
					$rowSubTipo = db_select_data (false, 'Nombre', 'core_maquinas_tipo', '', 'idSubTipo='.$idSubTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//guardo
					$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idSubTipo'] = $idSubTipo;
					$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['SubTipo']   = $rowSubTipo['Nombre'];
				}else{
					$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idSubTipo']   = $rowData['idSubTipo'];
				}

				//Licitacion relacionada
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idLicitacion']   = $rowData_m['idLicitacion'];

				switch ($rowData['idSubTipo']) {
					case 1://Grasa
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Grasa_inicial'];
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_2'] = $rowData['Grasa_relubricacion'];
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Grasa Lub/Relub';
						break;
					case 2://Aceite
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Aceite'];
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Aceite';
						break;
					case 3://Normal
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Cantidad'];
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Normal';
						break;
					case 4://Otro
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Otro';

						break;
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
			unset($_SESSION['ot_trabajos'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'submit_itemizado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos de la Trabajo
			$SIS_query = '
			licitacion_listado_level_'.$tablaitem.'.Nombre,
			licitacion_listado_level_'.$tablaitem.'.Codigo,
			licitacion_listado_level_'.$tablaitem.'.idTrabajo,
			core_licitacion_trabajos.Nombre as Trabajo';
			$SIS_join  = 'LEFT JOIN `core_licitacion_trabajos` ON core_licitacion_trabajos.idTrabajo = licitacion_listado_level_'.$tablaitem.'.idTrabajo';
			$SIS_where = 'idLevel_'.$tablaitem.' = '.$idItemizado;
			$rowData = db_select_data (false, $SIS_query, 'licitacion_listado_level_'.$tablaitem, $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Item_Nombre']      = $rowData['Nombre'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Item_Codigo']      = $rowData['Codigo'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Item_Trabajo']     = $rowData['Trabajo'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idTrabajo']        = $rowData['idTrabajo'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idItemizado']      = $idItemizado;
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['tablaitem']        = $tablaitem;


				switch ($rowData['idTrabajo']) {
					case 1: //Analisis
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Aceite']               = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Cantidad']             = 0;

						break;
					case 2: //Consumo de Materiales

						break;
					case 3: //Observacion
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Aceite']               = 0;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Cantidad']             = 0;

						break;
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'submit_producto':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos del producto
			$rowData = db_select_data (false, 'productos_listado.idProducto, productos_listado.Nombre AS Producto, sistema_productos_uml.Nombre AS Unimed, productos_listado.idUml', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idProducto']  = $rowData['idProducto'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['idUml']       = $rowData['idUml'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Producto']    = $rowData['Producto'];
				$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Unimed']      = $rowData['Unimed'];

				switch ($idSubTipo) {
					case 1: //Grasa
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t']         = 'Grasa Lub/Relub';
						if(isset($Grasa_inicial)&&$Grasa_inicial!='') {
							$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']  = $Grasa_inicial;
							$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1']         = $Grasa_inicial;
						}
						if(isset($Grasa_relubricacion)&&$Grasa_relubricacion!='') {
							$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = $Grasa_relubricacion;
							$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_2']               = $Grasa_relubricacion;
						}
						break;

					case 2: //Aceite
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Aceite'] = $Aceite;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1'] = $Aceite;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_2'] = '';
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Aceite';
						break;

					case 3: //Normal
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['Cantidad'] = $Cantidad;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_1']   = $Cantidad;
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_2']   = '';
						$_SESSION['ot_trabajos'][$tabla][$id_tabla][$idInterno]['data_t']   = 'Normal';
						break;

					case 4: //Otro

						break;
				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;
			}

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
			if (isset($_SESSION['ot_basicos'])){
				if(!isset($_SESSION['ot_basicos']['idSistema']) OR $_SESSION['ot_basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['ot_basicos']['idMaquina']) OR $_SESSION['ot_basicos']['idMaquina']=='' ){           $error['idMaquina']        = 'error/No ha seleccionado la maquina';}
				if(!isset($_SESSION['ot_basicos']['idUsuario']) OR $_SESSION['ot_basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha ingresado el id del usuario';}
				if(!isset($_SESSION['ot_basicos']['idEstado']) OR $_SESSION['ot_basicos']['idEstado']=='' ){             $error['idEstado']         = 'error/No ha ingresado el id del estado';}
				if(!isset($_SESSION['ot_basicos']['idPrioridad']) OR $_SESSION['ot_basicos']['idPrioridad']=='' ){       $error['idPrioridad']      = 'error/No ha seleccionado la prioridad';}
				if(!isset($_SESSION['ot_basicos']['idTipo']) OR $_SESSION['ot_basicos']['idTipo']=='' ){                 $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
				if(!isset($_SESSION['ot_basicos']['f_creacion']) OR $_SESSION['ot_basicos']['f_creacion']=='' ){         $error['f_creacion']       = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['ot_basicos']['f_programacion']) OR $_SESSION['ot_basicos']['f_programacion']=='' ){ $error['f_programacion']   = 'error/No ha ingresado la fecha de programacion';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la orden de trabajo';
			}
			//Se verifica que tenga trabajadores asignados
			if (isset($_SESSION['ot_trabajador'])){
				foreach ($_SESSION['ot_trabajador'] as $key => $trabajador){
					if(!isset($trabajador['idTrabajador']) OR $trabajador['idTrabajador'] == ''){  $error['idTrabajador']   = 'error/No ha ingresado un trabajador';}
					$n_trabajadores++;
				}
			}else{
				$error['trabajador'] = 'error/No tiene trabajadores asignados a la orden de trabajo';
			}
			//Se verifica que los trabajos tengan datos asignados
			if (isset($_SESSION['ot_trabajos'])){
				foreach ($_SESSION['ot_trabajos'] as $key => $x_tabla){
					foreach ($x_tabla as $x_id_tabla) {
						foreach ($x_id_tabla as $x_idInterno) {
							if(!isset($x_idInterno['idSubTipo']) OR $x_idInterno['idSubTipo'] == ''){       $error['idSubTipo']     = 'error/No ha seleccionado un tipo de subcomponente';}
							if(!isset($x_idInterno['id_tabla']) OR $x_idInterno['id_tabla'] == ''){         $error['id_tabla']      = 'error/No ha seleccionado un subcomponente';}
							if(!isset($x_idInterno['tabla']) OR $x_idInterno['tabla'] == ''){               $error['tabla']         = 'error/No ha seleccionado un subcomponente';}
							if(!isset($x_idInterno['Descripcion']) OR $x_idInterno['Descripcion'] == ''){
								if(!isset($x_idInterno['idItemizado']) OR $x_idInterno['idItemizado'] == ''){   $error['idItemizado']   = 'error/No ha seleccionado un trabajo para el subcomponente';}
								if(!isset($x_idInterno['idLicitacion']) OR $x_idInterno['idLicitacion'] == ''){ $error['idLicitacion']  = 'error/No ha seleccionado una licitacion';}
							}
							$n_trabajos++;
							//variable reseteada
							$n_grasa = 0;
							//solo si no hay una descripcion ingresada
							if(!isset($x_idInterno['Descripcion']) OR $x_idInterno['Descripcion'] == ''){
								//Se revisa por tipo de trabajo
								if(!isset($x_idInterno['idTrabajo']) OR $x_idInterno['idTrabajo'] == ''){
									$error['idTrabajo'] = 'error/No ha seleccionado un trabajo';
								}else{
									switch ($x_idInterno['idTrabajo']) {
										case 1: //Analisis

										break;
										case 2: //Consumo de Materiales
											//verifico si en grasa tiene ambas cantidades guardadas
											if(isset($x_idInterno['Grasa_inicial']) && $x_idInterno['Grasa_inicial'] != '' && $x_idInterno['Grasa_inicial'] != 0){ $n_grasa++;}
											if(isset($x_idInterno['Grasa_relubricacion']) && $x_idInterno['Grasa_relubricacion'] != '' && $x_idInterno['Grasa_relubricacion'] != 0){ $n_grasa++;}
											//Se verifica si lubricacion y relubricacion estan activos
											if(isset($n_grasa)&&$n_grasa==2){
												$error['n_grasa2'] = 'error/Un punto de trabajo tiene lubricacion y relubricacion asignado simultaneamente';
											}
											//Se verifica si lubricacion y relubricacion estan activos
											if(isset($x_idInterno['idSubTipo']) && $x_idInterno['idSubTipo'] != ''&& $x_idInterno['idSubTipo'] ==1){
												if(isset($n_grasa)&&$n_grasa==0){
													$error['n_grasa0'] = 'error/Un punto de trabajo no tiene lubricacion o relubricacion asignado';
												}
											}
										break;
										case 3: //Observacion

										break;
									}
								}
							}
						}
					}
				}
			}else{
				$error['trabajos'] = 'error/No tiene trabajos asignados a la orden de trabajo';
			}

			//Se verifica el minimo de trabajadores
			if(isset($n_trabajadores)&&$n_trabajadores==0){
				$error['trabajos'] = 'error/No tiene trabajadores asignados a la orden de trabajo';
			}

			//Se verifica el minimo de trabajos
			if(isset($n_trabajos)&&$n_trabajos==0){
				$error['trabajos'] = 'error/No tiene trabajos asignados a la orden de trabajo';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['ot_basicos']['idSistema']) && $_SESSION['ot_basicos']['idSistema']!=''){     $SIS_data  = "'".$_SESSION['ot_basicos']['idSistema']."'";        }else{$SIS_data  = "''";}
				if(isset($_SESSION['ot_basicos']['idMaquina']) && $_SESSION['ot_basicos']['idMaquina']!=''){     $SIS_data .= ",'".$_SESSION['ot_basicos']['idMaquina']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['idUsuario']) && $_SESSION['ot_basicos']['idUsuario']!=''){     $SIS_data .= ",'".$_SESSION['ot_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['idEstado']) && $_SESSION['ot_basicos']['idEstado']!=''){       $SIS_data .= ",'".$_SESSION['ot_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['idPrioridad']) && $_SESSION['ot_basicos']['idPrioridad']!=''){ $SIS_data .= ",'".$_SESSION['ot_basicos']['idPrioridad']."'";     }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['idTipo']) && $_SESSION['ot_basicos']['idTipo']!=''){           $SIS_data .= ",'".$_SESSION['ot_basicos']['idTipo']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['f_creacion']) && $_SESSION['ot_basicos']['f_creacion']!=''){   $SIS_data .= ",'".$_SESSION['ot_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['f_programacion']) && $_SESSION['ot_basicos']['f_programacion']!=''){
					$SIS_data .= ",'".$_SESSION['ot_basicos']['f_programacion']."'";
					$SIS_data .= ",'".fecha2NdiaMes($_SESSION['ot_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['ot_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['ot_basicos']['f_programacion'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['ot_basicos']['f_programacion'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['ot_basicos']['Observaciones']) && $_SESSION['ot_basicos']['Observaciones']!=''){   $SIS_data .= ",'".$_SESSION['ot_basicos']['Observaciones']."'";      }else{$SIS_data .= ",'Sin Observaciones'";}
				if(isset($_SESSION['ot_basicos']['idCliente']) && $_SESSION['ot_basicos']['idCliente']!=''){           $SIS_data .= ",'".$_SESSION['ot_basicos']['idCliente']."'";          }else{$SIS_data .= ",''";}
				if(isset($_SESSION['ot_basicos']['idTelemetria']) && $_SESSION['ot_basicos']['idTelemetria']!=''){     $SIS_data .= ",'".$_SESSION['ot_basicos']['idTelemetria']."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idMaquina, idUsuario, idEstado, idPrioridad, idTipo, f_creacion, f_programacion,
				progDia, progSemana, progMes, progAno, Observaciones,idCliente, idTelemetria';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*****************************************************/
					//Se guardan los datos de los trabajadores de la ot
					foreach ($_SESSION['ot_trabajador'] as $key => $trabajador){

						//filtros
						if(isset($ultimo_id) && $ultimo_id!=''){                                                                $SIS_data  = "'".$ultimo_id."'";                                  }else{$SIS_data  = "''";}
						if(isset($_SESSION['ot_basicos']['idSistema']) && $_SESSION['ot_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idSistema']."'";       }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['idMaquina']) && $_SESSION['ot_basicos']['idMaquina']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idMaquina']."'";       }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['idUsuario']) && $_SESSION['ot_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['idEstado']) && $_SESSION['ot_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['ot_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['idPrioridad']) && $_SESSION['ot_basicos']['idPrioridad']!=''){        $SIS_data .= ",'".$_SESSION['ot_basicos']['idPrioridad']."'";     }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['idTipo']) && $_SESSION['ot_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['ot_basicos']['idTipo']."'";          }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['f_creacion']) && $_SESSION['ot_basicos']['f_creacion']!=''){          $SIS_data .= ",'".$_SESSION['ot_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
						if(isset($_SESSION['ot_basicos']['f_programacion']) && $_SESSION['ot_basicos']['f_programacion']!=''){  $SIS_data .= ",'".$_SESSION['ot_basicos']['f_programacion']."'";  }else{$SIS_data .= ",''";}
						if(isset($trabajador['idTrabajador']) && $trabajador['idTrabajador']!=''){                              $SIS_data .= ",'".$trabajador['idTrabajador']."'";                }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT,idSistema, idMaquina, idUsuario, idEstado,idPrioridad, idTipo, f_creacion, f_programacion, idTrabajador';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
					/*****************************************************/
					//Se guardan los datos de los insumos si es que existen
					if (isset($_SESSION['ot_insumos'])){
						foreach ($_SESSION['ot_insumos'] as $key => $insumos){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                $SIS_data  = "'".$ultimo_id."'";                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['ot_basicos']['idSistema']) && $_SESSION['ot_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idSistema']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idMaquina']) && $_SESSION['ot_basicos']['idMaquina']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idMaquina']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idUsuario']) && $_SESSION['ot_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idEstado']) && $_SESSION['ot_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['ot_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idPrioridad']) && $_SESSION['ot_basicos']['idPrioridad']!=''){        $SIS_data .= ",'".$_SESSION['ot_basicos']['idPrioridad']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idTipo']) && $_SESSION['ot_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['ot_basicos']['idTipo']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['f_creacion']) && $_SESSION['ot_basicos']['f_creacion']!=''){          $SIS_data .= ",'".$_SESSION['ot_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['f_programacion']) && $_SESSION['ot_basicos']['f_programacion']!=''){  $SIS_data .= ",'".$_SESSION['ot_basicos']['f_programacion']."'";  }else{$SIS_data .= ",''";}
							if(isset($insumos['idProducto']) && $insumos['idProducto']!=''){                                        $SIS_data .= ",'".$insumos['idProducto']."'";   				     }else{$SIS_data .= ",''";}
							if(isset($insumos['Cantidad']) && $insumos['Cantidad']!=''){                                            $SIS_data .= ",'".$insumos['Cantidad']."'";                       }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOT, idSistema, idMaquina, idUsuario, idEstado,
							idPrioridad, idTipo, f_creacion, f_programacion, idProducto,Cantidad';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*****************************************************/
					//Se guardan los datos de los productos si es que existen
					if (isset($_SESSION['ot_productos'])){
						foreach ($_SESSION['ot_productos'] as $key => $prod){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                $SIS_data  = "'".$ultimo_id."'";                                  }else{$SIS_data  = "''";}
							if(isset($_SESSION['ot_basicos']['idSistema']) && $_SESSION['ot_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idSistema']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idMaquina']) && $_SESSION['ot_basicos']['idMaquina']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idMaquina']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idUsuario']) && $_SESSION['ot_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idEstado']) && $_SESSION['ot_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['ot_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idPrioridad']) && $_SESSION['ot_basicos']['idPrioridad']!=''){        $SIS_data .= ",'".$_SESSION['ot_basicos']['idPrioridad']."'";     }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['idTipo']) && $_SESSION['ot_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['ot_basicos']['idTipo']."'";          }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['f_creacion']) && $_SESSION['ot_basicos']['f_creacion']!=''){          $SIS_data .= ",'".$_SESSION['ot_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['ot_basicos']['f_programacion']) && $_SESSION['ot_basicos']['f_programacion']!=''){  $SIS_data .= ",'".$_SESSION['ot_basicos']['f_programacion']."'";  }else{$SIS_data .= ",''";}
							if(isset($prod['idProducto']) && $prod['idProducto']!=''){                                              $SIS_data .= ",'".$prod['idProducto']."'";   				      }else{$SIS_data .= ",''";}
							if(isset($prod['Cantidad']) && $prod['Cantidad']!=''){                                                  $SIS_data .= ",'".$prod['Cantidad']."'";                          }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idOT, idSistema, idMaquina, idUsuario, idEstado,
							idPrioridad, idTipo, f_creacion, f_programacion, idProducto,Cantidad';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*****************************************************/
					//Se guardan los trabajos a realizar
					if (isset($_SESSION['ot_trabajos'])){
						foreach ($_SESSION['ot_trabajos'] as $key => $x_tabla){
							foreach ($x_tabla as $x_id_tabla) {
								foreach ($x_id_tabla as $x_idInterno) {
									//filtros
									if(isset($ultimo_id) && $ultimo_id!=''){                                                                $SIS_data  = "'".$ultimo_id."'";                                  }else{$SIS_data  = "''";}
									if(isset($_SESSION['ot_basicos']['idSistema']) && $_SESSION['ot_basicos']['idSistema']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idSistema']."'";       }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['idMaquina']) && $_SESSION['ot_basicos']['idMaquina']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idMaquina']."'";       }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['idUsuario']) && $_SESSION['ot_basicos']['idUsuario']!=''){            $SIS_data .= ",'".$_SESSION['ot_basicos']['idUsuario']."'";       }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['idEstado']) && $_SESSION['ot_basicos']['idEstado']!=''){              $SIS_data .= ",'".$_SESSION['ot_basicos']['idEstado']."'";        }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['idPrioridad']) && $_SESSION['ot_basicos']['idPrioridad']!=''){        $SIS_data .= ",'".$_SESSION['ot_basicos']['idPrioridad']."'";     }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['idTipo']) && $_SESSION['ot_basicos']['idTipo']!=''){                  $SIS_data .= ",'".$_SESSION['ot_basicos']['idTipo']."'";          }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['f_creacion']) && $_SESSION['ot_basicos']['f_creacion']!=''){          $SIS_data .= ",'".$_SESSION['ot_basicos']['f_creacion']."'";      }else{$SIS_data .= ",''";}
									if(isset($_SESSION['ot_basicos']['f_programacion']) && $_SESSION['ot_basicos']['f_programacion']!=''){  $SIS_data .= ",'".$_SESSION['ot_basicos']['f_programacion']."'";  }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['id_tabla']) && $x_idInterno['id_tabla']!=''){                                    $SIS_data .= ",'".$x_idInterno['id_tabla']."'";                   }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['tabla']) && $x_idInterno['tabla']!=''){                                          $SIS_data .= ",'".$x_idInterno['tabla']."'";                      }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['tabla_m_value']) && $x_idInterno['tabla_m_value']!=''){                          $SIS_data .= ",'".$x_idInterno['tabla_m_value']."'";              }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['tabla_m']) && $x_idInterno['tabla_m']!=''){                                      $SIS_data .= ",'".$x_idInterno['tabla_m']."'";                    }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['idItemizado']) && $x_idInterno['idItemizado']!=''){                              $SIS_data .= ",'".$x_idInterno['idItemizado']."'";                }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['tablaitem']) && $x_idInterno['tablaitem']!=''){                                  $SIS_data .= ",'".$x_idInterno['tablaitem']."'";                  }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['idSubTipo']) && $x_idInterno['idSubTipo']!=''){                                  $SIS_data .= ",'".$x_idInterno['idSubTipo']."'";                  }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['idTrabajo']) && $x_idInterno['idTrabajo']!=''){                                  $SIS_data .= ",'".$x_idInterno['idTrabajo']."'";                  }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['idProducto']) && $x_idInterno['idProducto']!=''){                                $SIS_data .= ",'".$x_idInterno['idProducto']."'";                 }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['idUml']) && $x_idInterno['idUml']!=''){                                          $SIS_data .= ",'".$x_idInterno['idUml']."'";                      }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Grasa_inicial']) && $x_idInterno['Grasa_inicial']!=''){                          $SIS_data .= ",'".$x_idInterno['Grasa_inicial']."'";              }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Grasa_relubricacion']) && $x_idInterno['Grasa_relubricacion']!=''){              $SIS_data .= ",'".$x_idInterno['Grasa_relubricacion']."'";        }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Aceite']) && $x_idInterno['Aceite']!=''){                                        $SIS_data .= ",'".$x_idInterno['Aceite']."'";                     }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Cantidad']) && $x_idInterno['Cantidad']!=''){                                    $SIS_data .= ",'".$x_idInterno['Cantidad']."'";                   }else{$SIS_data .= ",''";}
									//Se guardan los nombres de los componentes
									if(isset($x_idInterno['Nombre']) && $x_idInterno['Nombre']!=''){                                        $SIS_data .= ",'".$x_idInterno['Codigo'].' - '.$x_idInterno['Nombre']."'";                                              }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Item_Nombre']) && $x_idInterno['Item_Nombre']!=''){                              $SIS_data .= ",'".$x_idInterno['Item_Trabajo'].': '.$x_idInterno['Item_Codigo'].' - '.$x_idInterno['Item_Nombre']."'";  }else{$SIS_data .= ",''";}
									//Se agrega el dato de la observacion
									$SIS_data .= ",'Sin Observaciones'";
									//Se guarda la licitacion
									if(isset($x_idInterno['idLicitacion']) && $x_idInterno['idLicitacion']!=''){    $SIS_data .= ",'".$x_idInterno['idLicitacion']."'";  }else{$SIS_data .= ",''";}
									if(isset($x_idInterno['Descripcion']) && $x_idInterno['Descripcion']!=''){      $SIS_data .= ",'".$x_idInterno['Descripcion']."'";   }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idOT, idSistema, idMaquina, idUsuario, idEstado, idPrioridad,
									idTipo, f_creacion, f_programacion, comp_tabla_id, comp_tabla, item_m_tabla_id, item_m_tabla, item_tabla_id, item_tabla,
									idSubTipo, idTrabajo, idProducto, idUml, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, NombreComponente, NombreTrabajo,
									Observacion, idLicitacion, Descripcion';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_trabajos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
						}
					}

					/*****************************************************/
					//Borro todas las sesiones una vez grabados los datos
					unset($_SESSION['ot_basicos']);
					unset($_SESSION['ot_trabajador']);
					unset($_SESSION['ot_trabajos']);
					unset($_SESSION['ot_temporal']);
					unset($_SESSION['ot_insumos']);
					unset($_SESSION['ot_productos']);

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
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'orden_trabajo_listado', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'orden_trabajo_listado_responsable', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_3 = db_delete_data (false, 'orden_trabajo_listado_trabajos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_4 = db_delete_data (false, 'orden_trabajo_listado_insumos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_5 = db_delete_data (false, 'orden_trabajo_listado_productos', 'idOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true OR $resultado_3==true OR $resultado_4==true OR $resultado_5==true){

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
				$rowData = db_select_data (false, 'idSistema,idMaquina,idPrioridad,idTipo,Observaciones,idCliente,idTelemetria', 'orden_trabajo_listado', '', 'idOT = '.$idOT, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				// Se trae un listado con los trabajadores de la OT
				$arrTrabajadores = array();
				$arrTrabajadores = db_select_array (false, 'idSistema,idMaquina,idPrioridad,idTipo,idTrabajador', 'orden_trabajo_listado_responsable', '', 'idOT ='.$idOT, 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				// Se trae un listado de los trabajos a realizar
				$arrTrabajo = array();
				$arrTrabajo = db_select_array (false, 'idSistema,idMaquina,idPrioridad,idTipo,comp_tabla_id,comp_tabla,item_m_tabla_id,item_m_tabla,item_tabla_id,item_tabla,idSubTipo,idTrabajo,idProducto,idUml,Grasa_inicial,Grasa_relubricacion,Aceite,Cantidad,NombreComponente,NombreTrabajo,idLicitacion,Descripcion', 'orden_trabajo_listado_trabajos', $SIS_join, 'idOT ='.$idOT, 'idOT ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				//Se guardan los datos basicos
				if(isset($rowData['idSistema']) &&$rowData['idSistema']!=''){       $SIS_data  = "'".$rowData['idSistema']."'";        }else{$SIS_data  = "''";}
				if(isset($rowData['idMaquina']) && $rowData['idMaquina']!=''){      $SIS_data .= ",'".$rowData['idMaquina']."'";       }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){                            $SIS_data .= ",'".$idUsuario."'";                  }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                              $SIS_data .= ",'".$idEstado."'";                   }else{$SIS_data .= ",''";}
				if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']!=''){  $SIS_data .= ",'".$rowData['idPrioridad']."'";     }else{$SIS_data .= ",''";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']!= ''){           $SIS_data .= ",'".$rowData['idTipo']."'";          }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){                          $SIS_data .= ",'".$f_creacion."'";                 }else{$SIS_data .= ",''";}
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
				if(isset($rowData['idCliente']) && $rowData['idCliente']!=''){           $SIS_data .= ",'".$rowData['idCliente']."'";          }else{$SIS_data .= ",''";}
				if(isset($rowData['idTelemetria']) && $rowData['idTelemetria']!=''){     $SIS_data .= ",'".$rowData['idTelemetria']."'";       }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idMaquina, idUsuario, idEstado, idPrioridad, idTipo, f_creacion, f_programacion,
				progDia, progSemana, progMes, progAno, Observaciones,idCliente, idTelemetria';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*****************************************************/
					//Se guardan los datos de los trabajadores
					foreach ($arrTrabajadores AS $trabajador){

						//filtros
						if(isset($ultimo_id) &&$ultimo_id!=''){                                    $SIS_data  = "'".$ultimo_id."'";                   }else{$SIS_data  = "''";}
						if(isset($trabajador['idSistema']) && $trabajador['idSistema']!=''){       $SIS_data .= ",'".$trabajador['idSistema']."'";    }else{$SIS_data .= ",''";}
						if(isset($trabajador['idMaquina']) && $trabajador['idMaquina']!=''){       $SIS_data .= ",'".$trabajador['idMaquina']."'";    }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                                   $SIS_data .= ",'".$idUsuario."'";                  }else{$SIS_data .= ",''";}
						if(isset($idEstado) && $idEstado!=''){                                     $SIS_data .= ",'".$idEstado."'";                   }else{$SIS_data .= ",''";}
						if(isset($trabajador['idPrioridad']) && $trabajador['idPrioridad']!=''){   $SIS_data .= ",'".$trabajador['idPrioridad']."'";  }else{$SIS_data .= ",''";}
						if(isset($trabajador['idTipo']) && $trabajador['idTipo']!= ''){            $SIS_data .= ",'".$trabajador['idTipo']."'";       }else{$SIS_data .= ",''";}
						if(isset($f_creacion) && $f_creacion!=''){                                 $SIS_data .= ",'".$f_creacion."'";                 }else{$SIS_data .= ",''";}
						if(isset($f_programacion) && $f_programacion!=''){                         $SIS_data .= ",'".$f_programacion."'";             }else{$SIS_data .= ",''";}
						if(isset($trabajador['idTrabajador']) && $trabajador['idTrabajador']!=''){ $SIS_data .= ",'".$trabajador['idTrabajador']."'"; }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT,idSistema,idMaquina,idUsuario,
						idEstado,idPrioridad,idTipo,f_creacion,f_programacion,idTrabajador';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					/*****************************************************/
					//Se guardan los trabajos a realizar
					foreach ($arrTrabajo AS $trabajos){

						//filtros
						if(isset($ultimo_id) &&$ultimo_id!=''){                                               $SIS_data  = "'".$ultimo_id."'";                         }else{$SIS_data  = "''";}
						if(isset($trabajos['idSistema']) && $trabajos['idSistema']!=''){                      $SIS_data .= ",'".$trabajos['idSistema']."'";            }else{$SIS_data .= ",''";}
						if(isset($trabajos['idMaquina']) && $trabajos['idMaquina']!=''){                      $SIS_data .= ",'".$trabajos['idMaquina']."'";            }else{$SIS_data .= ",''";}
						if(isset($idUsuario) && $idUsuario!=''){                                              $SIS_data .= ",'".$idUsuario."'";                        }else{$SIS_data .= ",''";}
						if(isset($idEstado) && $idEstado!=''){                                                $SIS_data .= ",'".$idEstado."'";                         }else{$SIS_data .= ",''";}
						if(isset($trabajos['idPrioridad']) && $trabajos['idPrioridad']!=''){                  $SIS_data .= ",'".$trabajos['idPrioridad']."'";          }else{$SIS_data .= ",''";}
						if(isset($trabajos['idTipo']) && $trabajos['idTipo']!= ''){                           $SIS_data .= ",'".$trabajos['idTipo']."'";               }else{$SIS_data .= ",''";}
						if(isset($f_creacion) && $f_creacion!=''){                                            $SIS_data .= ",'".$f_creacion."'";                       }else{$SIS_data .= ",''";}
						if(isset($f_programacion) && $f_programacion!=''){                                    $SIS_data .= ",'".$f_programacion."'";                   }else{$SIS_data .= ",''";}
						if(isset($trabajos['comp_tabla_id']) && $trabajos['comp_tabla_id']!=''){              $SIS_data .= ",'".$trabajos['comp_tabla_id']."'";        }else{$SIS_data .= ",''";}
						if(isset($trabajos['comp_tabla']) && $trabajos['comp_tabla']!=''){                    $SIS_data .= ",'".$trabajos['comp_tabla']."'";           }else{$SIS_data .= ",''";}
						if(isset($trabajos['item_m_tabla_id']) && $trabajos['item_m_tabla_id']!=''){          $SIS_data .= ",'".$trabajos['item_m_tabla_id']."'";      }else{$SIS_data .= ",''";}
						if(isset($trabajos['item_m_tabla']) && $trabajos['item_m_tabla']!=''){                $SIS_data .= ",'".$trabajos['item_m_tabla']."'";         }else{$SIS_data .= ",''";}
						if(isset($trabajos['item_tabla_id']) && $trabajos['item_tabla_id']!=''){              $SIS_data .= ",'".$trabajos['item_tabla_id']."'";        }else{$SIS_data .= ",''";}
						if(isset($trabajos['item_tabla']) && $trabajos['item_tabla']!=''){                    $SIS_data .= ",'".$trabajos['item_tabla']."'";           }else{$SIS_data .= ",''";}
						if(isset($trabajos['idSubTipo']) && $trabajos['idSubTipo']!=''){                      $SIS_data .= ",'".$trabajos['idSubTipo']."'";            }else{$SIS_data .= ",''";}
						if(isset($trabajos['idTrabajo']) && $trabajos['idTrabajo']!=''){                      $SIS_data .= ",'".$trabajos['idTrabajo']."'";            }else{$SIS_data .= ",''";}
						if(isset($trabajos['idProducto']) && $trabajos['idProducto']!=''){                    $SIS_data .= ",'".$trabajos['idProducto']."'";           }else{$SIS_data .= ",''";}
						if(isset($trabajos['idUml']) && $trabajos['idUml']!=''){                              $SIS_data .= ",'".$trabajos['idUml']."'";                }else{$SIS_data .= ",''";}
						if(isset($trabajos['Grasa_inicial']) && $trabajos['Grasa_inicial']!=''){              $SIS_data .= ",'".$trabajos['Grasa_inicial']."'";        }else{$SIS_data .= ",''";}
						if(isset($trabajos['Grasa_relubricacion']) && $trabajos['Grasa_relubricacion']!=''){  $SIS_data .= ",'".$trabajos['Grasa_relubricacion']."'";  }else{$SIS_data .= ",''";}
						if(isset($trabajos['Aceite']) && $trabajos['Aceite']!=''){                            $SIS_data .= ",'".$trabajos['Aceite']."'";               }else{$SIS_data .= ",''";}
						if(isset($trabajos['Cantidad']) && $trabajos['Cantidad']!=''){                        $SIS_data .= ",'".$trabajos['Cantidad']."'";             }else{$SIS_data .= ",''";}
						if(isset($trabajos['NombreComponente']) && $trabajos['NombreComponente']!=''){        $SIS_data .= ",'".$trabajos['NombreComponente']."'";     }else{$SIS_data .= ",''";}
						if(isset($trabajos['NombreTrabajo']) && $trabajos['NombreTrabajo']!=''){              $SIS_data .= ",'".$trabajos['NombreTrabajo']."'";        }else{$SIS_data .= ",''";}
						//Se agrega el dato de la observacion
						$SIS_data .= ",'Sin Observaciones'";
						if(isset($trabajos['idLicitacion']) && $trabajos['idLicitacion']!=''){                $SIS_data .= ",'".$trabajos['idLicitacion']."'";         }else{$SIS_data .= ",''";}
						if(isset($trabajos['Descripcion']) && $trabajos['Descripcion']!=''){                  $SIS_data .= ",'".$trabajos['Descripcion']."'";          }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idOT, idSistema, idMaquina, idUsuario,idEstado,
						idPrioridad, idTipo, f_creacion, f_programacion, comp_tabla_id, comp_tabla, item_m_tabla_id, item_m_tabla,
						item_tabla_id, item_tabla, idSubTipo, idTrabajo, idProducto, idUml, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
						NombreComponente, NombreTrabajo, Observacion, idLicitacion, Descripcion';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_trabajos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&created=true' );
					die;
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
				$progDia    = fecha2NdiaMes($f_programacion);
				$progSemana = fecha2NSemana($f_programacion);
				$progMes    = fecha2NMes($f_programacion);
				$progAno    = fecha2Ano($f_programacion);
			}
			if(isset($f_termino) && $f_termino!=''){
				$terDia    = fecha2NdiaMes($f_termino);
				$terSemana = fecha2NSemana($f_termino);
				$terMes    = fecha2NMes($f_termino);
				$terAno    = fecha2Ano($f_termino);
			}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idOT='".$idOT."'";
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idMaquina) && $idMaquina!=''){              $SIS_data .= ",idMaquina='".$idMaquina."'";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",idUsuario='".$idUsuario."'";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idPrioridad) && $idPrioridad!=''){          $SIS_data .= ",idPrioridad='".$idPrioridad."'";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($f_creacion) && $f_creacion!=''){            $SIS_data .= ",f_creacion='".$f_creacion."'";}
				if(isset($f_programacion) && $f_programacion!=''){    $SIS_data .= ",f_programacion='".$f_programacion."'";}
				if(isset($f_termino) && $f_termino!=''){              $SIS_data .= ",f_termino='".$f_termino."'";}
				if(isset($Observaciones) && $Observaciones!=''){      $SIS_data .= ",Observaciones='".$Observaciones."'";}
				if(isset($progDia) && $progDia!=''){                  $SIS_data .= ",progDia='".$progDia."'";}
				if(isset($progSemana) && $progSemana!=''){            $SIS_data .= ",progSemana='".$progSemana."'";}
				if(isset($progMes) && $progMes!=''){                  $SIS_data .= ",progMes='".$progMes."'";}
				if(isset($progAno) && $progAno!=''){                  $SIS_data .= ",progAno='".$progAno."'";}
				if(isset($terDia) && $terDia!=''){                    $SIS_data .= ",terDia='".$terDia."'";}
				if(isset($terSemana) && $terSemana!=''){              $SIS_data .= ",terSemana='".$terSemana."'";}
				if(isset($terMes) && $terMes!=''){                    $SIS_data .= ",terMes='".$terMes."'";}
				if(isset($terAno) && $terAno!=''){                    $SIS_data .= ",terAno='".$terAno."'";}
				if(isset($idSupervisor) && $idSupervisor!=''){        $SIS_data .= ",idSupervisor='".$idSupervisor."'";}
				if(isset($horaProg) && $horaProg!=''){                $SIS_data .= ",horaProg='".$horaProg."'";}
				if(isset($horaInicio) && $horaInicio!=''){            $SIS_data .= ",horaInicio='".$horaInicio."'";}
				if(isset($horaTermino) && $horaTermino!=''){          $SIS_data .= ",horaTermino='".$horaTermino."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado', 'idOT = "'.$idOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

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
				$ndata_1 = db_select_nrows (false, 'idResponsable', 'orden_trabajo_listado_responsable', '', "idTrabajador='".$idTrabajador."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                        $SIS_data  = "'".$idOT."'";               }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";         }else{$SIS_data .= ",''";}
				if(isset($idMaquina) && $idMaquina!=''){              $SIS_data .= ",'".$idMaquina."'";         }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){          $SIS_data .= ",'".$idPrioridad."'";       }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";            }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){            $SIS_data .= ",'".$f_creacion."'";        }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){    $SIS_data .= ",'".$f_programacion."'";    }else{$SIS_data .= ",''";}
				if(isset($idTrabajador) && $idTrabajador!=''){        $SIS_data .= ",'".$idTrabajador."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idMaquina,idUsuario,
				idEstado,idPrioridad,idTipo,f_creacion,f_programacion,idTrabajador';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_responsable', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&addtrab=true' );
					die;
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
				$ndata_1 = db_select_nrows (false, 'idResponsable', 'orden_trabajo_listado_responsable', '', "idTrabajador='".$idTrabajador."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idResponsable='".$idResponsable."'";
				if(isset($idTrabajador) && $idTrabajador!=''){   $SIS_data .= ",idTrabajador='".$idTrabajador."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_responsable', 'idResponsable = "'.$idResponsable.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
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
				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_listado_responsable', 'idResponsable = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$ndata_1 = db_select_nrows (false, 'idInsumos', 'orden_trabajo_listado_insumos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Insumo seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                        $SIS_data  = "'".$idOT."'";               }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";         }else{$SIS_data .= ",''";}
				if(isset($idMaquina) && $idMaquina!=''){              $SIS_data .= ",'".$idMaquina."'";         }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){          $SIS_data .= ",'".$idPrioridad."'";       }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";            }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){            $SIS_data .= ",'".$f_creacion."'";        }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){    $SIS_data .= ",'".$f_programacion."'";    }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){            $SIS_data .= ",'".$idProducto."'";        }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idMaquina,idUsuario,
				idEstado,idPrioridad,idTipo,f_creacion,f_programacion,idProducto, Cantidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_insumos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&addins=true' );
					die;
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
				$ndata_1 = db_select_nrows (false, 'idInsumos', 'orden_trabajo_listado_insumos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."' AND idInsumos!='".$idInsumos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Insumo seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idInsumos='".$idInsumos."'";
				if(isset($idProducto) && $idProducto!=''){    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){        $SIS_data .= ",Cantidad='".$Cantidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_insumos', 'idInsumos = "'.$idInsumos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
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
				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_listado_insumos', 'idInsumos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$ndata_1 = db_select_nrows (false, 'idProductos', 'orden_trabajo_listado_productos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idOT) && $idOT!=''){                        $SIS_data  = "'".$idOT."'";               }else{$SIS_data  = "''";}
				if(isset($idSistema) && $idSistema!=''){              $SIS_data .= ",'".$idSistema."'";         }else{$SIS_data .= ",''";}
				if(isset($idMaquina) && $idMaquina!=''){              $SIS_data .= ",'".$idMaquina."'";         }else{$SIS_data .= ",''";}
				if(isset($idUsuario) && $idUsuario!=''){              $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                $SIS_data .= ",'".$idEstado."'";          }else{$SIS_data .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){          $SIS_data .= ",'".$idPrioridad."'";       }else{$SIS_data .= ",''";}
				if(isset($idTipo) && $idTipo!=''){                    $SIS_data .= ",'".$idTipo."'";            }else{$SIS_data .= ",''";}
				if(isset($f_creacion) && $f_creacion!=''){            $SIS_data .= ",'".$f_creacion."'";        }else{$SIS_data .= ",''";}
				if(isset($f_programacion) && $f_programacion!=''){    $SIS_data .= ",'".$f_programacion."'";    }else{$SIS_data .= ",''";}
				if(isset($idProducto) && $idProducto!=''){            $SIS_data .= ",'".$idProducto."'";        }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                $SIS_data .= ",'".$Cantidad."'";          }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idOT,idSistema,idMaquina,idUsuario,
				idEstado,idPrioridad,idTipo,f_creacion,f_programacion,idProducto, Cantidad';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_productos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&addprod=true' );
					die;
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
				$ndata_1 = db_select_nrows (false, 'idProductos', 'orden_trabajo_listado_productos', '', "idProducto='".$idProducto."' AND idOT='".$idOT."' AND idProductos!='".$idProductos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Producto seleccionado ya esta asignado a esta OT';}

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				$SIS_data = "idProductos='".$idProductos."'";
				if(isset($idProducto) && $idProducto!=''){    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Cantidad) && $Cantidad!=''){        $SIS_data .= ",Cantidad='".$Cantidad."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_productos', 'idProductos = "'.$idProductos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
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
				//se borran los datos
				$resultado = db_delete_data (false, 'orden_trabajo_listado_productos', 'idProductos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'del_tarea_row':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['idInterno']) OR !validaEntero($_GET['idInterno']))&&$_GET['idInterno']!=''){
				$indice = simpleDecode($_GET['idInterno'], fecha_actual());
			}else{
				$indice = $_GET['idInterno'];
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
				$resultado = db_delete_data (false, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
		case 'submit_itemizado_row':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos de la Trabajo
			$rowData = db_select_data (false, 'licitacion_listado_level_'.$tablaitem.'.Nombre,licitacion_listado_level_'.$tablaitem.'.Codigo, licitacion_listado_level_'.$tablaitem.'.idTrabajo, core_licitacion_trabajos.Nombre as Trabajo', 'licitacion_listado_level_'.$tablaitem, 'LEFT JOIN `core_licitacion_trabajos` ON core_licitacion_trabajos.idTrabajo = licitacion_listado_level_'.$tablaitem.'.idTrabajo', 'idLevel_'.$tablaitem.' = '.$idItemizado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				//filtros
				$SIS_data = "idTrabajoOT='".$idInterno."'";
				if(isset($rowData['Nombre'])&&isset($rowData['Codigo'])&&isset($rowData['Trabajo'])){    $SIS_data .= ",NombreTrabajo='".$rowData['Trabajo'].': '.$rowData['Codigo'].' - '.$rowData['Nombre']."'";}
				if(isset($rowData['idTrabajo']) && $rowData['idTrabajo']!=''){                           $SIS_data .= ",idTrabajo='".$rowData['idTrabajo']."'";}
				if(isset($idItemizado) && $idItemizado!=''){                                             $SIS_data .= ",item_tabla_id='".$idItemizado."'";}
				if(isset($tablaitem) && $tablaitem!=''){                                                 $SIS_data .= ",item_tabla='".$tablaitem."'";}

				//Se ejecuta si se hace un cambio en el tipo de Trabajo
				switch ($rowData['idTrabajo']) {
					case 1: //Analisis
						$SIS_data .= ",Grasa_inicial=''";
						$SIS_data .= ",Grasa_relubricacion=''";
						$SIS_data .= ",Aceite=''";
						$SIS_data .= ",Cantidad=''";
					break;
					case 2: //Consumo de Materiales

					break;
					case 3: //Observacion
						$SIS_data .= ",Grasa_inicial=''";
						$SIS_data .= ",Grasa_relubricacion=''";
						$SIS_data .= ",Aceite=''";
						$SIS_data .= ",Cantidad=''";
					break;
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$idInterno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edittarea=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'submit_producto_row':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos del producto
			$rowData = db_select_data (false, 'idProducto, idUml', 'productos_listado', '', 'idProducto ='.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				//filtros
				$SIS_data = "idTrabajoOT='".$idInterno."'";
				if(isset($rowData['idProducto']) && $rowData['idProducto']!=''){   $SIS_data .= ",idProducto='".$rowData['idProducto']."'";}
				if(isset($rowData['idUml']) && $rowData['idUml']!=''){      $SIS_data .= ",idUml='".$rowData['idUml']."'";}
				if(isset($Grasa_inicial) && $Grasa_inicial!= ''){                    $SIS_data .= ",Grasa_inicial='".$Grasa_inicial."'";              }else{$SIS_data .= ",Grasa_inicial=''";}
				if(isset($Grasa_relubricacion) && $Grasa_relubricacion!= ''){        $SIS_data .= ",Grasa_relubricacion='".$Grasa_relubricacion."'";  }else{$SIS_data .= ",Grasa_relubricacion=''";}
				if(isset($Aceite) && $Aceite!= ''){                                  $SIS_data .= ",Aceite='".$Aceite."'";                            }else{$SIS_data .= ",Aceite=''";}
				if(isset($Cantidad) && $Cantidad!= ''){                              $SIS_data .= ",Cantidad='".$Cantidad."'";                        }else{$SIS_data .= ",Cantidad=''";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$idTrabajoOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					header( 'Location: '.$location.'&edittarea=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'submit_tarea_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(isset($idLevel[1])&&$idLevel[1]!=''){   $id_tabla = $idLevel[1];  $tabla=1;  $id_tabla_madre = 0;            $tabla_madre=0; }
			if(isset($idLevel[2])&&$idLevel[2]!=''){   $id_tabla = $idLevel[2];  $tabla=2;  $id_tabla_madre = $idLevel[1];  $tabla_madre=1; }
			if(isset($idLevel[3])&&$idLevel[3]!=''){   $id_tabla = $idLevel[3];  $tabla=3;  $id_tabla_madre = $idLevel[2];  $tabla_madre=2; }
			if(isset($idLevel[4])&&$idLevel[4]!=''){   $id_tabla = $idLevel[4];  $tabla=4;  $id_tabla_madre = $idLevel[3];  $tabla_madre=3; }
			if(isset($idLevel[5])&&$idLevel[5]!=''){   $id_tabla = $idLevel[5];  $tabla=5;  $id_tabla_madre = $idLevel[4];  $tabla_madre=4; }
			if(isset($idLevel[6])&&$idLevel[6]!=''){   $id_tabla = $idLevel[6];  $tabla=6;  $id_tabla_madre = $idLevel[5];  $tabla_madre=5; }
			if(isset($idLevel[7])&&$idLevel[7]!=''){   $id_tabla = $idLevel[7];  $tabla=7;  $id_tabla_madre = $idLevel[6];  $tabla_madre=6; }
			if(isset($idLevel[8])&&$idLevel[8]!=''){   $id_tabla = $idLevel[8];  $tabla=8;  $id_tabla_madre = $idLevel[7];  $tabla_madre=7; }
			if(isset($idLevel[9])&&$idLevel[9]!=''){   $id_tabla = $idLevel[9];  $tabla=9;  $id_tabla_madre = $idLevel[8];  $tabla_madre=8; }
			if(isset($idLevel[10])&&$idLevel[10]!=''){ $id_tabla = $idLevel[10]; $tabla=10; $id_tabla_madre = $idLevel[9];  $tabla_madre=9; }
			if(isset($idLevel[11])&&$idLevel[11]!=''){ $id_tabla = $idLevel[11]; $tabla=11; $id_tabla_madre = $idLevel[10]; $tabla_madre=10; }
			if(isset($idLevel[12])&&$idLevel[12]!=''){ $id_tabla = $idLevel[12]; $tabla=12; $id_tabla_madre = $idLevel[11]; $tabla_madre=11; }
			if(isset($idLevel[13])&&$idLevel[13]!=''){ $id_tabla = $idLevel[13]; $tabla=13; $id_tabla_madre = $idLevel[12]; $tabla_madre=12; }
			if(isset($idLevel[14])&&$idLevel[14]!=''){ $id_tabla = $idLevel[14]; $tabla=14; $id_tabla_madre = $idLevel[13]; $tabla_madre=13; }
			if(isset($idLevel[15])&&$idLevel[15]!=''){ $id_tabla = $idLevel[15]; $tabla=15; $id_tabla_madre = $idLevel[14]; $tabla_madre=14; }
			if(isset($idLevel[16])&&$idLevel[16]!=''){ $id_tabla = $idLevel[16]; $tabla=16; $id_tabla_madre = $idLevel[15]; $tabla_madre=15; }
			if(isset($idLevel[17])&&$idLevel[17]!=''){ $id_tabla = $idLevel[17]; $tabla=17; $id_tabla_madre = $idLevel[16]; $tabla_madre=16; }
			if(isset($idLevel[18])&&$idLevel[18]!=''){ $id_tabla = $idLevel[18]; $tabla=18; $id_tabla_madre = $idLevel[17]; $tabla_madre=17; }
			if(isset($idLevel[19])&&$idLevel[19]!=''){ $id_tabla = $idLevel[19]; $tabla=19; $id_tabla_madre = $idLevel[18]; $tabla_madre=18; }
			if(isset($idLevel[20])&&$idLevel[20]!=''){ $id_tabla = $idLevel[20]; $tabla=20; $id_tabla_madre = $idLevel[19]; $tabla_madre=19; }
			if(isset($idLevel[21])&&$idLevel[21]!=''){ $id_tabla = $idLevel[21]; $tabla=21; $id_tabla_madre = $idLevel[20]; $tabla_madre=20; }
			if(isset($idLevel[22])&&$idLevel[22]!=''){ $id_tabla = $idLevel[22]; $tabla=22; $id_tabla_madre = $idLevel[21]; $tabla_madre=21; }
			if(isset($idLevel[23])&&$idLevel[23]!=''){ $id_tabla = $idLevel[23]; $tabla=23; $id_tabla_madre = $idLevel[22]; $tabla_madre=22; }
			if(isset($idLevel[24])&&$idLevel[24]!=''){ $id_tabla = $idLevel[24]; $tabla=24; $id_tabla_madre = $idLevel[23]; $tabla_madre=23; }
			if(isset($idLevel[25])&&$idLevel[25]!=''){ $id_tabla = $idLevel[25]; $tabla=25; $id_tabla_madre = $idLevel[24]; $tabla_madre=24; }

			// Se traen los datos de la tabla madre
			if((!isset($Descripcion) OR $Descripcion=='')&&isset($id_tabla_madre)&&$id_tabla_madre!=0){
				$rowData_m = db_select_data (false, 'idUtilizable,tabla, table_value, idLicitacion', 'maquinas_listado_level_'.$tabla_madre, '', 'idLevel_'.$tabla_madre.' = '.$id_tabla_madre, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se verifica que sea un componente
				if(isset($rowData_m['idUtilizable'])&&$rowData_m['idUtilizable']!=3&&$rowData_m['tabla']==0){
					$error['tabla'] = 'error/El dato seleccionado no posee tareas asignadas';
				}
			}

			// Se traen todos los datos de la maquina
			$SIS_query = '
			maquinas_listado_level_'.$tabla.'.Nombre,
			maquinas_listado_level_'.$tabla.'.Codigo,
			maquinas_listado_level_'.$tabla.'.idUtilizable,
			maquinas_listado_level_'.$tabla.'.idSubTipo,
			maquinas_listado_level_'.$tabla.'.idProducto,
			maquinas_listado_level_'.$tabla.'.Grasa_inicial,
			maquinas_listado_level_'.$tabla.'.Grasa_relubricacion,
			maquinas_listado_level_'.$tabla.'.Aceite,
			maquinas_listado_level_'.$tabla.'.Cantidad,
			maquinas_listado_level_'.$tabla.'.idUml,
			productos_listado.Nombre AS Producto,
			sistema_productos_uml.Nombre AS Unimed';
			$SIS_join  = '
			LEFT JOIN `productos_listado`       ON productos_listado.idProducto  = maquinas_listado_level_'.$tabla.'.idProducto
			LEFT JOIN `sistema_productos_uml`   ON sistema_productos_uml.idUml   = maquinas_listado_level_'.$tabla.'.idUml';
			$SIS_where = 'idLevel_'.$tabla.' = '.$id_tabla;
			$rowData = db_select_data (false, $SIS_query, 'maquinas_listado_level_'.$tabla, $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//se verifica que sea un subcomponente
			if(isset($rowData['idUtilizable'])&&$rowData['idUtilizable']!=''&&$rowData['idUtilizable']!=3){
				$error['subcomponente'] = 'error/El dato seleccionado no es un subcomponente';
			}

			//se establece variable inicial
			$idInterno = 0;

			//verificar si el subcomponente ya existe
			if(isset($_SESSION['ot_trabajos_temp'][$tabla][$id_tabla])){
				foreach ($_SESSION['ot_trabajos_temp'][$tabla][$id_tabla] as $key => $trabajos){
					if(isset($trabajos['valor_id'])&&$trabajos['valor_id']!=''){
						$idInterno = $trabajos['valor_id'];
					}
				}
			}

			if(empty($error)){

				$idInterno = $idInterno+1;
				//Para mostrar en la creación
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Nombre']      = $rowData['Nombre'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Codigo']      = $rowData['Codigo'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Producto']    = $rowData['Producto'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Unimed']      = $rowData['Unimed'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['valor_id']    = $idInterno;
				if(isset($Descripcion)&&$Descripcion!=''){
					$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Descripcion'] = $Descripcion;
				}

				//variables vacias
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1']       = '';
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_2']       = '';
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t']       = '';
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Item_Codigo']  = '';
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Item_Nombre']  = '';

				//Datos para guardar en la base de datos
				//subcomponente seleccionado
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['id_tabla']       = $id_tabla;
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['tabla']          = $tabla;
				//tabla madre del itemizado
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['tabla_m']        = $rowData_m['tabla'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['tabla_m_value']  = $rowData_m['table_value'];
				//productos a utilizar
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idProducto']  = $rowData['idProducto'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idUml']       = $rowData['idUml'];
				//medidas
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = $rowData['Grasa_inicial'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = $rowData['Grasa_relubricacion'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Aceite']               = $rowData['Aceite'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Cantidad']             = $rowData['Cantidad'];
				//idSubTipo
				if(isset($idSubTipo)&&$idSubTipo!=''){
					//consulto
					$rowSubTipo = db_select_data (false, 'Nombre', 'core_maquinas_tipo', '', 'idSubTipo='.$idSubTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					//guardo
					$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idSubTipo'] = $idSubTipo;
					$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['SubTipo']   = $rowSubTipo['Nombre'];
				}else{
					$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idSubTipo'] = $rowData['idSubTipo'];
				}

				//Licitacion
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idLicitacion']   = $rowData_m['idLicitacion'];

				switch ($rowData['idSubTipo']) {
					case 1://Grasa
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Grasa_inicial'];
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_2'] = $rowData['Grasa_relubricacion'];
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Grasa Lub/Relub';
						break;
					case 2://Aceite
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Aceite'];
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Aceite';
						break;
					case 3://Normal
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1'] = $rowData['Cantidad'];
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Normal';
						break;
					case 4://Otro
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Otro';
						break;
				}

				//redirijo
				header( 'Location: '.$location.'&addtarea=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_tarea_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['ot_trabajos_temp'][$_GET['tabla']][$_GET['id_tabla']][$_GET['idInterno']]);

			header( 'Location: '.$location.'&deltarea=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'submit_itemizado_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos de la Trabajo
			$rowData = db_select_data (false, 'licitacion_listado_level_'.$tablaitem.'.Nombre,licitacion_listado_level_'.$tablaitem.'.Codigo, licitacion_listado_level_'.$tablaitem.'.idTrabajo, core_licitacion_trabajos.Nombre as Trabajo', 'licitacion_listado_level_'.$tablaitem, 'LEFT JOIN `core_licitacion_trabajos` ON core_licitacion_trabajos.idTrabajo = licitacion_listado_level_'.$tablaitem.'.idTrabajo', 'idLevel_'.$tablaitem.' = '.$idItemizado, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Item_Nombre']      = $rowData['Nombre'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Item_Codigo']      = $rowData['Codigo'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Item_Trabajo']     = $rowData['Trabajo'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idTrabajo']        = $rowData['idTrabajo'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idItemizado']      = $idItemizado;
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['tablaitem']        = $tablaitem;

				switch ($rowData['idTrabajo']) {
					case 1: //Analisis
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Aceite']               = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Cantidad']             = 0;

						break;
					case 2: //Consumo de Materiales

						break;
					case 3: //Observacion
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']        = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Aceite']               = 0;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Cantidad']             = 0;

						break;
				}

				//redirijo
				header( 'Location: '.$location.'&edittarea=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'submit_producto_edit':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se traen todos los datos del producto
			$rowData = db_select_data (false, 'productos_listado.idProducto, productos_listado.Nombre AS Producto, sistema_productos_uml.Nombre AS Unimed, productos_listado.idUml', 'productos_listado', 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = productos_listado.idUml', 'productos_listado.idProducto = '.$idProducto, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			if(empty($error)){

				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idProducto']  = $rowData['idProducto'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['idUml']       = $rowData['idUml'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Producto']    = $rowData['Producto'];
				$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Unimed']      = $rowData['Unimed'];

				switch ($idSubTipo) {
					case 1: //Grasa
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t']         = 'Grasa Lub/Relub';
						if(isset($Grasa_inicial)&&$Grasa_inicial!='') {
							$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_inicial']  = $Grasa_inicial;
							$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1']         = $Grasa_inicial;
						}
						if(isset($Grasa_relubricacion)&&$Grasa_relubricacion!='') {
							$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Grasa_relubricacion']  = $Grasa_relubricacion;
							$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_2']               = $Grasa_relubricacion;
						}
						break;

					case 2: //Aceite
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Aceite'] = $Aceite;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1'] = $Aceite;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_2'] = '';
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t'] = 'Aceite';
						break;

					case 3: //Normal
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['Cantidad'] = $Cantidad;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_1']   = $Cantidad;
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_2']   = '';
						$_SESSION['ot_trabajos_temp'][$tabla][$id_tabla][$idInterno]['data_t']   = 'Normal';
						break;

					case 4: //Otro

						break;
				}

				//redirijo
				header( 'Location: '.$location.'&edittarea=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'aprobar_trabajo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//variables
			$n_trabajos = 0;

			//Se verifica que los trabajos tengan datos asignados
			if (isset($_SESSION['ot_trabajos_temp'])){
				foreach ($_SESSION['ot_trabajos_temp'] as $key => $x_tabla){
					foreach ($x_tabla as $x_id_tabla) {
						foreach ($x_id_tabla as $x_idInterno) {
							if(!isset($x_idInterno['idSubTipo']) OR $x_idInterno['idSubTipo'] == ''){       $error['idSubTipo']     = 'error/No ha seleccionado un tipo de subcomponente';}
							if(!isset($x_idInterno['id_tabla']) OR $x_idInterno['id_tabla'] == ''){         $error['id_tabla']      = 'error/No ha seleccionado un subcomponente';}
							if(!isset($x_idInterno['tabla']) OR $x_idInterno['tabla'] == ''){               $error['tabla']         = 'error/No ha seleccionado un subcomponente';}
							if(!isset($x_idInterno['Descripcion']) OR $x_idInterno['Descripcion'] == ''){
								if(!isset($x_idInterno['idItemizado']) OR $x_idInterno['idItemizado'] == ''){   $error['idItemizado']   = 'error/No ha seleccionado un trabajo para el subcomponente';}
								//if(!isset($x_idInterno['idLicitacion']) OR $x_idInterno['idLicitacion'] == ''){ $error['idLicitacion']  = 'error/No ha seleccionado una licitacion';}
							}
							$n_trabajos++;
							//variable reseteada
							$n_grasa = 0;
							//solo si no hay una descripcion ingresada
							if(!isset($x_idInterno['Descripcion']) OR $x_idInterno['Descripcion'] == ''){
								//Se revisa por tipo de trabajo
								if(!isset($x_idInterno['idTrabajo']) OR $x_idInterno['idTrabajo'] == ''){
									$error['idTrabajo'] = 'error/No ha seleccionado un trabajo';
								}else{
									switch ($x_idInterno['idTrabajo']) {
										case 1: //Analisis

										break;
										case 2: //Consumo de Materiales
											//verifico si en grasa tiene ambas cantidades guardadas
											if(isset($x_idInterno['Grasa_inicial']) && $x_idInterno['Grasa_inicial'] != '' && $x_idInterno['Grasa_inicial'] != 0){ $n_grasa++;}
											if(isset($x_idInterno['Grasa_relubricacion']) && $x_idInterno['Grasa_relubricacion'] != '' && $x_idInterno['Grasa_relubricacion'] != 0){ $n_grasa++;}
											//Se verifica si lubricacion y relubricacion estan activos
											if(isset($n_grasa)&&$n_grasa==2){
												$error['n_grasa2'] = 'error/Un punto de trabajo tiene lubricacion y relubricacion asignado simultaneamente';
											}
											//Se verifica si lubricacion y relubricacion estan activos
											if(isset($x_idInterno['idSubTipo']) && $x_idInterno['idSubTipo'] != ''&& $x_idInterno['idSubTipo'] ==1){
												if(isset($n_grasa)&&$n_grasa==0){
													$error['n_grasa0'] = 'error/Un punto de trabajo no tiene lubricacion o relubricacion asignado';
												}
											}
										break;
										case 3: //Observacion

										break;
									}
								}
							}
						}
					}
				}
			}else{
				$error['trabajos'] = 'error/No tiene trabajos asignados a la orden de trabajo';
			}

			//Se verifica el minimo de trabajos
			if(isset($n_trabajos)&&$n_trabajos==0){
				$error['trabajos'] = 'error/No tiene trabajos asignados a la orden de trabajo';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//verifico si se envia un entero
				if((!validarNumero($_GET['view']) OR !validaEntero($_GET['view']))&&$_GET['view']!=''){
					$idOT = simpleDecode($_GET['view'], fecha_actual());
				}else{
					$idOT = $_GET['view'];
				}

				//Se traen los datos de la ot
				$rowData = db_select_data (false, 'idSistema, idMaquina, idUsuario, idEstado, idPrioridad, idTipo, f_creacion,f_programacion', 'orden_trabajo_listado', '', 'idOT = '.$idOT, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				//Se guardan los trabajos a realizar
				if (isset($_SESSION['ot_trabajos_temp'])){
					foreach ($_SESSION['ot_trabajos_temp'] as $key => $x_tabla){
						foreach ($x_tabla as $x_id_tabla) {
							foreach ($x_id_tabla as $x_idInterno) {
								//filtros
								if(isset($idOT) && $idOT!=''){                                                               $SIS_data  = "'".$idOT."'";                                  }else{$SIS_data  = "''";}
								if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){                               $SIS_data .= ",'".$rowData['idSistema']."'";                 }else{$SIS_data .= ",''";}
								if(isset($rowData['idMaquina']) && $rowData['idMaquina']!=''){                               $SIS_data .= ",'".$rowData['idMaquina']."'";                 }else{$SIS_data .= ",''";}
								if(isset($rowData['idUsuario']) && $rowData['idUsuario']!=''){                               $SIS_data .= ",'".$rowData['idUsuario']."'";                 }else{$SIS_data .= ",''";}
								if(isset($rowData['idEstado']) && $rowData['idEstado']!=''){                                 $SIS_data .= ",'".$rowData['idEstado']."'";                  }else{$SIS_data .= ",''";}
								if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']!=''){                           $SIS_data .= ",'".$rowData['idPrioridad']."'";               }else{$SIS_data .= ",''";}
								if(isset($rowData['idTipo']) && $rowData['idTipo']!=''){                                     $SIS_data .= ",'".$rowData['idTipo']."'";                    }else{$SIS_data .= ",''";}
								if(isset($rowData['f_creacion']) && $rowData['f_creacion']!=''){                             $SIS_data .= ",'".$rowData['f_creacion']."'";                }else{$SIS_data .= ",''";}
								if(isset($rowData['f_programacion']) && $rowData['f_programacion']!=''){                     $SIS_data .= ",'".$rowData['f_programacion']."'";            }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['id_tabla']) && $x_idInterno['id_tabla']!=''){                         $SIS_data .= ",'".$x_idInterno['id_tabla']."'";              }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['tabla']) && $x_idInterno['tabla']!=''){                               $SIS_data .= ",'".$x_idInterno['tabla']."'";                 }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['tabla_m_value']) && $x_idInterno['tabla_m_value']!=''){               $SIS_data .= ",'".$x_idInterno['tabla_m_value']."'";         }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['tabla_m']) && $x_idInterno['tabla_m']!=''){                           $SIS_data .= ",'".$x_idInterno['tabla_m']."'";               }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['idItemizado']) && $x_idInterno['idItemizado']!=''){                   $SIS_data .= ",'".$x_idInterno['idItemizado']."'";           }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['tablaitem']) && $x_idInterno['tablaitem']!=''){                       $SIS_data .= ",'".$x_idInterno['tablaitem']."'";             }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['idSubTipo']) && $x_idInterno['idSubTipo']!=''){                       $SIS_data .= ",'".$x_idInterno['idSubTipo']."'";             }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['idTrabajo']) && $x_idInterno['idTrabajo']!=''){                       $SIS_data .= ",'".$x_idInterno['idTrabajo']."'";             }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['idProducto']) && $x_idInterno['idProducto']!=''){                     $SIS_data .= ",'".$x_idInterno['idProducto']."'";            }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['idUml']) && $x_idInterno['idUml']!=''){                               $SIS_data .= ",'".$x_idInterno['idUml']."'";                 }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Grasa_inicial']) && $x_idInterno['Grasa_inicial']!=''){               $SIS_data .= ",'".$x_idInterno['Grasa_inicial']."'";         }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Grasa_relubricacion']) && $x_idInterno['Grasa_relubricacion']!=''){   $SIS_data .= ",'".$x_idInterno['Grasa_relubricacion']."'";   }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Aceite']) && $x_idInterno['Aceite']!=''){                             $SIS_data .= ",'".$x_idInterno['Aceite']."'";                }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Cantidad']) && $x_idInterno['Cantidad']!=''){                         $SIS_data .= ",'".$x_idInterno['Cantidad']."'";              }else{$SIS_data .= ",''";}
								//Se guardan los nombres de los componentes
								if(isset($x_idInterno['Nombre']) && $x_idInterno['Nombre']!=''){                             $SIS_data .= ",'".$x_idInterno['Codigo'].' - '.$x_idInterno['Nombre']."'";                                              }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Item_Nombre']) && $x_idInterno['Item_Nombre']!=''){                   $SIS_data .= ",'".$x_idInterno['Item_Trabajo'].': '.$x_idInterno['Item_Codigo'].' - '.$x_idInterno['Item_Nombre']."'";  }else{$SIS_data .= ",''";}
								//Se agrega el dato de la observacion
								$SIS_data .= ",'Sin Observaciones'";
								//Se guarda la licitacion
								if(isset($x_idInterno['idLicitacion']) && $x_idInterno['idLicitacion']!=''){     $SIS_data .= ",'".$x_idInterno['idLicitacion']."'";  }else{$SIS_data .= ",''";}
								if(isset($x_idInterno['Descripcion']) && $x_idInterno['Descripcion']!=''){       $SIS_data .= ",'".$x_idInterno['Descripcion']."'";   }else{$SIS_data .= ",''";}

								// inserto los datos de registro en la db
								$SIS_columns = 'idOT, idSistema, idMaquina, idUsuario, idEstado, idPrioridad,
								idTipo, f_creacion, f_programacion, comp_tabla_id, comp_tabla, item_m_tabla_id, item_m_tabla, item_tabla_id, item_tabla,
								idSubTipo, idTrabajo, idProducto, idUml, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, NombreComponente, NombreTrabajo,
								Observacion, idLicitacion, Descripcion';
								$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'orden_trabajo_listado_trabajos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							}
						}
					}
				}

				/*****************************************************/
				//Borro todas las sesiones una vez grabados los datos
				unset($_SESSION['ot_trabajos_temp']);

				header( 'Location: '.$location.'&addtarea=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'submit_editTrabajo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 1;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($idAnalisis)){
				$ndata_1 = db_select_nrows (false, 'idAnalisis', 'analisis_listado', '', "idAnalisis='".$idAnalisis."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($idAnalisis)&&isset($idOT)){
				$ndata_2 = db_select_nrows (false, 'idOT', 'analisis_listado', '', "idAnalisis='".$idAnalisis."' AND idOT!='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowan   = db_select_data (false, 'idOT', 'analisis_listado', '', "idAnalisis='".$idAnalisis."' AND idOT!='".$idOT."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 == 0) {$error['ndata_1'] = 'error/El Analisis que esta tratando de ingresar no existe';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Analisis que esta tratando de ingresar fue utilizado en la OT N° '.$rowan['idOT'];}
			/*******************************************************************/

			if(empty($error)){

				//filtros
				$SIS_data = "idTrabajoOT='".$idInterno."'";
				if(isset($idAnalisis) && $idAnalisis!=''){     $SIS_data .= ",idAnalisis='".$idAnalisis."'";}
				if(isset($Observacion) && $Observacion!=''){   $SIS_data .= ",Observacion='".$Observacion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$idInterno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/******************************************************************/
					//Guardo el numero de la OT en el analisis
					if(isset($idAnalisis)){
						$SIS_data = "idAnalisis='".$idAnalisis."'";
						if(isset($idOT) && $idOT!=''){   $SIS_data .= ",idOT='".$idOT."'";}

						/*******************************************************/
						//se actualizan los datos
						$resultado = db_update_data (false, $SIS_data, 'analisis_listado', 'idAnalisis = "'.$idAnalisis.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
					//redirijo
					header( 'Location: '.$location.'&edittarea=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'submit_edit_tarea':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//filtros
				$SIS_data = "idTrabajoOT='".$idTrabajoOT."'";
				if(isset($idSubTipo) && $idSubTipo!=''){      $SIS_data .= ",idSubTipo='".$idSubTipo."'";}
				if(isset($Descripcion) && $Descripcion!=''){  $SIS_data .= ",Descripcion='".$Descripcion."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$idTrabajoOT.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edittarea=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'del_TrabajoOT':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_TrabajoOT']) OR !validaEntero($_GET['del_TrabajoOT']))&&$_GET['del_TrabajoOT']!=''){
				$indice = simpleDecode($_GET['del_TrabajoOT'], fecha_actual());
			}else{
				$indice = $_GET['del_TrabajoOT'];
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
				$resultado = db_delete_data (false, 'orden_trabajo_listado_trabajos', 'idTrabajoOT = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

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
		case 'cerrar_ot':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*********************************************************************/
			//Se traen los datos de la OT
			$rowData = db_select_data (false, 'orden_trabajo_listado.idSistema, orden_trabajo_listado.idMaquina, orden_trabajo_listado.idUsuario, orden_trabajo_listado.idEstado, orden_trabajo_listado.idPrioridad, orden_trabajo_listado.idTipo, orden_trabajo_listado.f_creacion, orden_trabajo_listado.f_programacion, orden_trabajo_listado.f_termino, orden_trabajo_listado.idSupervisor, core_sistemas.OT_idBodegaProd, core_sistemas.OT_idBodegaIns', 'orden_trabajo_listado', 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = orden_trabajo_listado.idSistema', 'idOT = '.$_GET['view'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifican los datos basicos
			if(!isset($rowData['idSistema']) OR $rowData['idSistema']=='' OR $rowData['idSistema']==0){                            $error['idSistema']        = 'error/No ha ingresado el id del sistema';}
			if(!isset($rowData['idMaquina']) OR $rowData['idMaquina']=='' OR $rowData['idMaquina']==0){                            $error['idMaquina']        = 'error/No ha seleccionado la maquina';}
			if(!isset($rowData['idUsuario']) OR $rowData['idUsuario']=='' OR $rowData['idUsuario']==0){                            $error['idUsuario']        = 'error/No ha ingresado el id del usuario';}
			if(!isset($rowData['idEstado']) OR $rowData['idEstado']=='' OR $rowData['idEstado']==0){                               $error['idEstado']         = 'error/No ha ingresado el id del estado';}
			if(!isset($rowData['idPrioridad']) OR $rowData['idPrioridad']=='' OR $rowData['idPrioridad']==0){                      $error['idPrioridad']      = 'error/No ha seleccionado la prioridad';}
			if(!isset($rowData['idTipo']) OR $rowData['idTipo']=='' OR $rowData['idTipo']==0){                                     $error['idTipo']           = 'error/No ha seleccionado el tipo de trabajo';}
			if(!isset($rowData['f_creacion']) OR $rowData['f_creacion']=='' OR $rowData['f_creacion']=='0000-00-00'){              $error['f_creacion']       = 'error/No ha ingresado la fecha de creación';}
			if(!isset($rowData['f_programacion']) OR $rowData['f_programacion']=='' OR $rowData['f_programacion']=='0000-00-00'){  $error['f_programacion']   = 'error/No ha ingresado la fecha de programacion';}
			if(!isset($rowData['f_termino']) OR $rowData['f_termino']=='' OR $rowData['f_termino']=='0000-00-00'){                 $error['f_termino']        = 'error/No ha ingresado la fecha de termino';}
			if(!isset($rowData['idSupervisor']) OR $rowData['idSupervisor']=='' OR $rowData['idSupervisor']==0){                   $error['idSupervisor']     = 'error/No ha seleccionado el supervisor';}

			/*********************************************************************/
			//Se traen a todos los trabajadores relacionados a las ot
			$arrTrabajadores = array();
			$arrTrabajadores = db_select_array (false, 'idTrabajador', 'orden_trabajo_listado_responsable', '', 'idOT = '.$_GET['view'], 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//variables
			$n_trabajadores = 0;
			//Se verifica que tenga trabajadores asignados
			foreach ($arrTrabajadores as $trabajador){
				if(!isset($trabajador['idTrabajador']) OR $trabajador['idTrabajador'] == '' OR $trabajador['idTrabajador'] == 0){  $error['idTrabajador']   = 'error/No ha ingresado un trabajador';}
				$n_trabajadores++;
			}
			//Se verifica el minimo de trabajadores
			if(isset($n_trabajadores)&&$n_trabajadores==0){
				$error['trabajos'] = 'error/No tiene trabajadores asignados a la orden de trabajo';
			}
			/*********************************************************************/
			// Se trae un listado con todos los trabajos relacionados a la orden
			$arrTrabajo = array();
			$arrTrabajo = db_select_array (false, 'idTrabajoOT, idSubTipo, comp_tabla_id, comp_tabla, idTrabajo, idAnalisis, idProducto, idUml, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, item_m_tabla_id, item_m_tabla, Observacion', 'orden_trabajo_listado_trabajos', '', 'idOT = '.$_GET['view'], 'idTrabajoOT ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//variables
			$n_trabajos = 0;
			//Se verifica que los trabajos tengan datos asignados
			foreach ($arrTrabajo as $trab){
				if(!isset($trab['idTrabajoOT']) OR $trab['idTrabajoOT'] == '' OR $trab['idTrabajoOT'] == 0){              $error['idTrabajoOT']      = 'error/No ha seleccionado un trabajo para el subcomponente';}
				if(!isset($trab['idSubTipo']) OR $trab['idSubTipo'] == '' OR $trab['idSubTipo'] == 0){                    $error['idSubTipo']        = 'error/No ha seleccionado un tipo de subcomponente';}
				if(!isset($trab['comp_tabla_id']) OR $trab['comp_tabla_id'] == '' OR $trab['comp_tabla_id'] == 0){        $error['comp_tabla_id']    = 'error/No ha seleccionado un subcomponente';}
				if(!isset($trab['comp_tabla']) OR $trab['comp_tabla'] == '' OR $trab['comp_tabla'] == 0){                 $error['comp_tabla']       = 'error/No ha seleccionado un subcomponente';}
				if(!isset($trab['item_m_tabla_id']) OR $trab['item_m_tabla_id'] == '' OR $trab['item_m_tabla_id'] == 0){  $error['item_m_tabla_id']  = 'error/No ha seleccionado un subcomponente';}
				if(!isset($trab['item_m_tabla']) OR $trab['item_m_tabla'] == '' OR $trab['item_m_tabla'] == 0){           $error['item_m_tabla']     = 'error/No ha seleccionado un subcomponente';}
				$n_trabajos++;
				//variable reseteada
				$n_grasa = 0;
				//Se revisa por tipo de trabajo
				if(!isset($trab['idTrabajo']) OR $trab['idTrabajo'] == '' OR $trab['idTrabajo'] == 0){
					$error['idTrabajo'] = 'error/No ha seleccionado un trabajo';
				}else{
					switch ($trab['idTrabajo']) {
						case 1: //Analisis
							if(!isset($trab['idAnalisis']) OR $trab['idAnalisis'] == '' OR $trab['idAnalisis'] == 0){   $error['idAnalisis'] = 'error/No ha ingresado un analisis';}
						break;
						case 2: //Consumo de Materiales
							if(!isset($trab['idProducto']) OR $trab['idProducto'] == '' OR $trab['idProducto'] == ''){ $error['idProducto'] = 'error/No ha seleccionado un producto';}
							if(!isset($trab['idUml']) OR $trab['idUml'] == '' OR $trab['idUml'] == ''){                $error['idUml']      = 'error/No ha seleccionado una unidad de medida';}
							//verifico si en grasa tiene ambas cantidades guardadas
							if(isset($trab['Grasa_inicial']) && $trab['Grasa_inicial'] != '' && $trab['Grasa_inicial'] != 0){ $n_grasa++;}
							if(isset($trab['Grasa_relubricacion']) && $trab['Grasa_relubricacion'] != '' && $trab['Grasa_relubricacion'] != 0){ $n_grasa++;}
							//Se verifica si lubricacion y relubricacion estan activos
							if(isset($n_grasa)&&$n_grasa==2){
								$error['n_grasa2'] = 'error/Un punto de trabajo tiene lubricacion y relubricacion asignado simultaneamente';
							}
							switch ($trab['idSubTipo']) {
								case 1: //Grasa
									if(isset($n_grasa)&&$n_grasa==0){
										$error['n_grasa0'] = 'error/Un punto de trabajo no tiene lubricacion o relubricacion asignado';
									}
								break;
								case 2: //Aceite
									if(!isset($trab['Aceite']) OR $trab['Aceite'] == '' OR $trab['Aceite'] == 0){   $error['Aceite'] = 'error/No ha ingresado una cantidad de aceite';}
								break;
								case 3: //Normal
									if(!isset($trab['Cantidad']) OR $trab['Cantidad'] == '' OR $trab['Cantidad'] == 0){   $error['Cantidad'] = 'error/No ha ingresado una cantidad';}
								break;
								case 4: //Otro

								break;
							}

						break;
						case 3: //Observacion
							if(!isset($trab['Observacion']) OR $trab['Observacion'] == '' ){   $error['Observacion'] = 'error/No ha ingresado una observacion';}
						break;
					}
				}
			}
			//Se verifica el minimo de trabajos
			if(isset($n_trabajos)&&$n_trabajos==0){
				$error['trabajos'] = 'error/No tiene trabajos asignados a la orden de trabajo';
			}
			/*********************************************************************/
			// Se trae un listado con todos los trabajos relacionados a la orden y si existen materiales para hacerlo
			$SIS_query = '
			orden_trabajo_listado_trabajos.idSubTipo,
			orden_trabajo_listado_trabajos.NombreComponente,
			orden_trabajo_listado_trabajos.NombreTrabajo,
			SUM(orden_trabajo_listado_trabajos.Grasa_inicial) AS sum_ginicial,
			SUM(orden_trabajo_listado_trabajos.Grasa_relubricacion) AS sum_grelu,
			SUM(orden_trabajo_listado_trabajos.Aceite) AS sum_aceite,
			SUM(orden_trabajo_listado_trabajos.Cantidad) AS sum_cantidad,
			orden_trabajo_listado_trabajos.idProducto,
			licitacion_listado.idBodegaProd,
			licitacion_listado.idBodegaIns,
			productos_listado.Nombre AS NombreProducto,
			(SELECT SUM(Cantidad_ing) FROM bodegas_productos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_trabajos.idProducto AND idBodega=licitacion_listado.idBodegaProd LIMIT 1) AS BodegaProdIngresos,
			(SELECT SUM(Cantidad_eg)  FROM bodegas_productos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_trabajos.idProducto AND idBodega=licitacion_listado.idBodegaProd LIMIT 1) AS BodegaProdEgresos';
			$SIS_join  = '
			LEFT JOIN `licitacion_listado`  ON licitacion_listado.idLicitacion   = orden_trabajo_listado_trabajos.idLicitacion
			LEFT JOIN `productos_listado`   ON productos_listado.idProducto      = orden_trabajo_listado_trabajos.idProducto';
			$SIS_where = 'orden_trabajo_listado_trabajos.idOT = '.$_GET['view'].' GROUP BY orden_trabajo_listado_trabajos.idLicitacion, orden_trabajo_listado_trabajos.idProducto';
			$SIS_order = 0;
			$arrConsumosOT = array();
			$arrConsumosOT = db_select_array (false, $SIS_query, 'orden_trabajo_listado_trabajos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica que los trabajos tengan datos asignados
			foreach ($arrConsumosOT as $trab){
				if(!isset($trab['idBodegaProd']) OR $trab['idBodegaProd'] == '' OR $trab['idBodegaProd'] == 0){   $error['idTrabajoOT']      = 'error/El Componente '.$trab['NombreComponente'].' con el trabajo '.$trab['NombreTrabajo'].', la licitacion relacionada no posee una bodega de productos asignada';}
				if(!isset($trab['idBodegaIns']) OR $trab['idBodegaIns'] == '' OR $trab['idBodegaIns'] == 0){      $error['idTrabajoOT']      = 'error/El Componente '.$trab['NombreComponente'].' con el trabajo '.$trab['NombreTrabajo'].', la licitacion relacionada no posee una bodega de insumos asignada';}
				//Se revisa si existe la cantidad sificiente de materiales
				switch ($trab['idSubTipo']) {
					case 1: $valor = $trab['sum_ginicial']+$trab['sum_grelu']; break;   //Grasa
					case 2: $valor = $trab['sum_aceite']; break;                        //Aceite
					case 3: $valor = $trab['sum_cantidad']; break;                      //Normal
				}
				//Realizo las operaciones
				$ingreso = $trab['BodegaProdIngresos'];
				$egreso  = $trab['BodegaProdEgresos'] + $valor;
				$total   = $trab['BodegaProdIngresos'] - $trab['BodegaProdEgresos'];
				//condiciono el error
				if($ingreso < $egreso){
					$error['productos1'] = 'error/No hay suficientes '.$trab['NombreProducto'].', en bodega solo hay '.$total.' y necesitas '.$valor;
				}
			}
			/*********************************************************************/
			//Se verifica el stock de productos de la bodega de productos
			$SIS_query = '
			SUM(orden_trabajo_listado_productos.Cantidad) AS Cantidad,
			orden_trabajo_listado_productos.idProducto,
			productos_listado.Nombre AS NombreProducto,
			core_sistemas.OT_idBodegaProd,
			(SELECT SUM(Cantidad_ing) FROM bodegas_productos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_productos.idProducto AND idBodega=core_sistemas.OT_idBodegaProd LIMIT 1) AS BodegaProdIngresos,
			(SELECT SUM(Cantidad_eg)  FROM bodegas_productos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_productos.idProducto AND idBodega=core_sistemas.OT_idBodegaProd LIMIT 1) AS BodegaProdEgresos';
			$SIS_join  = '
			LEFT JOIN `productos_listado`   ON productos_listado.idProducto      = orden_trabajo_listado_productos.idProducto
			LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema           = orden_trabajo_listado_productos.idSistema';
			$SIS_where = 'orden_trabajo_listado_productos.idOT = '.$_GET['view'].' GROUP BY orden_trabajo_listado_productos.idProducto';
			$SIS_order = 0;
			$arrProdCons = array();
			$arrProdCons = db_select_array (false, $SIS_query, 'orden_trabajo_listado_productos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica que los trabajos tengan datos asignados
			if($arrProdCons!=false){
				foreach ($arrProdCons as $trab){
					if(!isset($trab['OT_idBodegaProd']) OR $trab['OT_idBodegaProd'] == '' OR $trab['OT_idBodegaProd'] == 0){   $error['idTrabajoOT']      = 'error/La empresa no tiene una bodega de productos asignada a la OT';}		
					//Realizo las operaciones
					$ingreso = $trab['BodegaProdIngresos'];
					$egreso  = $trab['BodegaProdEgresos'] + $trab['Cantidad'];
					$total   = $trab['BodegaProdIngresos'] - $trab['BodegaProdEgresos'];
					//condiciono el error
					if($ingreso < $egreso){
						$error['productos2'] = 'error/No hay suficientes '.$trab['NombreProducto'].', en bodega solo hay '.$total.' y necesitas '.$trab['Cantidad'];
					}
				}
			}
			/*********************************************************************/
			//Se verifica el stock de productos de la bodega de insumos
			$SIS_query = 'SUM(orden_trabajo_listado_insumos.Cantidad) AS Cantidad,
			orden_trabajo_listado_insumos.idProducto,
			insumos_listado.Nombre AS NombreProducto,
			core_sistemas.OT_idBodegaIns,
			(SELECT SUM(Cantidad_ing) FROM bodegas_insumos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_insumos.idProducto AND idBodega=core_sistemas.OT_idBodegaIns LIMIT 1) AS BodegaProdIngresos,
			(SELECT SUM(Cantidad_eg)  FROM bodegas_insumos_facturacion_existencias  WHERE idProducto = orden_trabajo_listado_insumos.idProducto AND idBodega=core_sistemas.OT_idBodegaIns LIMIT 1) AS BodegaProdEgresos';
			$SIS_join  = '
			LEFT JOIN `insumos_listado`     ON insumos_listado.idProducto        = orden_trabajo_listado_insumos.idProducto
			LEFT JOIN `core_sistemas`       ON core_sistemas.idSistema           = orden_trabajo_listado_insumos.idSistema';
			$SIS_where = 'orden_trabajo_listado_insumos.idOT = '.$_GET['view'].' GROUP BY orden_trabajo_listado_insumos.idProducto';
			$SIS_order = 0;
			$arrInsCons = array();
			$arrInsCons = db_select_array (false, $SIS_query, 'orden_trabajo_listado_insumos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//Se verifica que los trabajos tengan datos asignados
			if($arrInsCons!=false){
				foreach ($arrInsCons as $trab){
					if(!isset($trab['OT_idBodegaIns']) OR $trab['OT_idBodegaIns'] == '' OR $trab['OT_idBodegaIns'] == 0){   $error['idTrabajoOT']      = 'error/La empresa no tiene una bodega de productos asignada a la OT';}		
					//Realizo las operaciones
					$ingreso = $trab['BodegaProdIngresos'];
					$egreso  = $trab['BodegaProdEgresos'] + $trab['Cantidad'];
					$total   = $trab['BodegaProdIngresos'] - $trab['BodegaProdEgresos'];
					//condiciono el error
					if($ingreso < $egreso){
						$error['productos3'] = 'error/No hay suficientes '.$trab['NombreProducto'].', en bodega solo hay '.$total.' y necesitas '.$trab['Cantidad'];
					}
				}
			}


			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*************************************************************************/
				//Se actualizan los estados de todos los registros
				//filtros
				$SIS_data = "idEstado='2'";
				if(isset($rowData['idSistema']) && $rowData['idSistema']=='' && $rowData['idSistema']==0){                            $SIS_data .= ",idAnalisis='".$rowData['idSistema']."'";}
				if(isset($rowData['idMaquina']) && $rowData['idMaquina']=='' && $rowData['idMaquina']==0){                            $SIS_data .= ",idMaquina='".$rowData['idMaquina']."'";}
				if(isset($rowData['idUsuario']) && $rowData['idUsuario']=='' && $rowData['idUsuario']==0){                            $SIS_data .= ",idUsuario='".$rowData['idUsuario']."'";}
				if(isset($rowData['idPrioridad']) && $rowData['idPrioridad']=='' && $rowData['idPrioridad']==0){                      $SIS_data .= ",idPrioridad='".$rowData['idPrioridad']."'";}
				if(isset($rowData['idTipo']) && $rowData['idTipo']=='' && $rowData['idTipo']==0){                                     $SIS_data .= ",idTipo='".$rowData['idTipo']."'";}
				if(isset($rowData['f_creacion']) && $rowData['f_creacion']=='' && $rowData['f_creacion']=='0000-00-00'){              $SIS_data .= ",f_creacion='".$rowData['f_creacion']."'";}
				if(isset($rowData['f_programacion']) && $rowData['f_programacion']=='' && $rowData['f_programacion']=='0000-00-00'){  $SIS_data .= ",f_programacion='".$rowData['f_programacion']."'";}
				if(isset($rowData['f_termino']) && $rowData['f_termino']=='' && $rowData['f_termino']=='0000-00-00'){                 $SIS_data .= ",f_termino='".$rowData['f_termino']."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado', 'idOT = "'.$_GET['view'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_insumos', 'idOT = "'.$_GET['view'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_productos', 'idOT = "'.$_GET['view'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_responsable', 'idOT = "'.$_GET['view'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'orden_trabajo_listado_trabajos', 'idOT = "'.$_GET['view'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				/*********************************************************************/
				// Se actualizan los analisis utilizados
				$arrAnalisis = array();
				$arrAnalisis = db_select_array (false, 'idAnalisis', 'orden_trabajo_listado_trabajos', '', 'idOT = '.$_GET['view'].' AND idAnalisis!=0 AND idTrabajo=1', 'idAnalisis ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se actualizan los registros
				foreach ($arrAnalisis as $trab){
					if(isset($trab['idAnalisis']) && $trab['idAnalisis'] == '' && $trab['idAnalisis'] == 0){
						/*******************************************************/
						//se actualizan los datos
						$SIS_data = "idOT='".$_GET['view']."'";
						$resultado = db_update_data (false, $SIS_data, 'analisis_listado', 'idAnalisis = "'.$trab['idAnalisis'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					}
				}

				/*************************************************************************/
				/*************************************************************************/

				$Observaciones  = 'Consumo de materiales desde la OT '.$_GET['view'];
				$idTipo         = 7;
				$fecha_auto     = fecha_actual();

				/*********************************************************************/
				//Se Se verifica que exista bodega y que existan consumos
				if($arrProdCons&&isset($rowData['OT_idBodegaProd']) && $rowData['OT_idBodegaProd']!=''){
					$SIS_data  = "'".$rowData['OT_idBodegaProd']."'";
					if(isset($_GET['view']) && $_GET['view']!=''){                  $SIS_data .= ",'".$_GET['view']."'";            }else{$SIS_data .= ",''";}
					if(isset($Observaciones) && $Observaciones!=''){                $SIS_data .= ",'".$Observaciones."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){  $SIS_data .= ",'".$rowData['idSistema']."'";    }else{$SIS_data .= ",''";}
					if(isset($rowData['idUsuario']) && $rowData['idUsuario']!=''){  $SIS_data .= ",'".$rowData['idUsuario']."'";    }else{$SIS_data .= ",''";}
					if(isset($idTipo) && $idTipo!=''){                              $SIS_data .= ",'".$idTipo."'";                  }else{$SIS_data .= ",''";}
					if(isset($rowData['f_termino']) && $rowData['f_termino']!=''){
						$SIS_data .= ",'".$rowData['f_termino']."'";
						$SIS_data .= ",'".fecha2NMes($rowData['f_termino'])."'";
						$SIS_data .= ",'".fecha2Ano($rowData['f_termino'])."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($fecha_auto) && $fecha_auto!=''){    $SIS_data .= ",'".$fecha_auto."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idBodegaOrigen, idOT, Observaciones, idSistema,
					idUsuario, idTipo, Creacion_fecha, Creacion_mes, Creacion_ano, fecha_auto';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_productos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						/*********************************************************************/
						//Se guardan los datos
						foreach ($arrProdCons as $trab){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                    $SIS_data  = "'".$ultimo_id."'";                     }else{$SIS_data  = "''";}
							if(isset($_GET['view']) && $_GET['view']!=''){                              $SIS_data .= ",'".$_GET['view']."'";                 }else{$SIS_data .= ",''";}
							if(isset($rowData['OT_idBodegaProd']) && $rowData['OT_idBodegaProd']!=''){  $SIS_data .= ",'".$rowData['OT_idBodegaProd']."'";   }else{$SIS_data .= ",''";}
							if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){              $SIS_data .= ",'".$rowData['idSistema']."'";         }else{$SIS_data .= ",''";}
							if(isset($rowData['idUsuario']) && $rowData['idUsuario']!=''){              $SIS_data .= ",'".$rowData['idUsuario']."'";         }else{$SIS_data .= ",''";}
							if(isset($rowData['f_termino']) && $rowData['f_termino']!=''){
								$SIS_data .= ",'".$rowData['f_termino']."'";
								$SIS_data .= ",'".fecha2NMes($rowData['f_termino'])."'";
								$SIS_data .= ",'".fecha2Ano($rowData['f_termino'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($idTipo) && $idTipo!=''){                             $SIS_data .= ",'".$idTipo."'";                }else{$SIS_data .= ",''";}
							if(isset($trab['idProducto']) && $trab['idProducto']!=''){     $SIS_data .= ",'".$trab['idProducto']."'";    }else{$SIS_data .= ",''";}
							if(isset($trab['Cantidad']) && $trab['Cantidad']!=''){         $SIS_data .= ",'".$trab['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($fecha_auto) && $fecha_auto!=''){                     $SIS_data .= ",'".$fecha_auto."'";            }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idOT, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,  idTipo, idProducto,
							Cantidad_eg, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_productos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
				}
				/*********************************************************************/
				//Se Se verifica que exista bodega y que existan consumos
				if($arrInsCons&&isset($rowData['OT_idBodegaIns']) && $rowData['OT_idBodegaIns']!=''){
					$SIS_data  = "'".$rowData['OT_idBodegaIns']."'";
					if(isset($_GET['view']) && $_GET['view']!=''){                  $SIS_data .= ",'".$_GET['view']."'";            }else{$SIS_data .= ",''";}
					if(isset($Observaciones) && $Observaciones!=''){                $SIS_data .= ",'".$Observaciones."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){  $SIS_data .= ",'".$rowData['idSistema']."'";    }else{$SIS_data .= ",''";}
					if(isset($rowData['idUsuario']) && $rowData['idUsuario']!=''){  $SIS_data .= ",'".$rowData['idUsuario']."'";    }else{$SIS_data .= ",''";}
					if(isset($idTipo) && $idTipo!=''){                              $SIS_data .= ",'".$idTipo."'";                  }else{$SIS_data .= ",''";}
					if(isset($rowData['f_termino']) && $rowData['f_termino']!=''){
						$SIS_data .= ",'".$rowData['f_termino']."'";
						$SIS_data .= ",'".fecha2NMes($rowData['f_termino'])."'";
						$SIS_data .= ",'".fecha2Ano($rowData['f_termino'])."'";
					}else{
						$SIS_data .= ",''";
						$SIS_data .= ",''";
						$SIS_data .= ",''";
					}
					if(isset($fecha_auto) && $fecha_auto!=''){    $SIS_data .= ",'".$fecha_auto."'";   }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'idBodegaOrigen, idOT, Observaciones, idSistema,
					idUsuario, idTipo, Creacion_fecha, Creacion_mes, Creacion_ano, fecha_auto';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						/*********************************************************************/
						//Se guardan los datos
						foreach ($arrInsCons as $trab){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                    $SIS_data  = "'".$ultimo_id."'";                     }else{$SIS_data  = "''";}
							if(isset($_GET['view']) && $_GET['view']!=''){                              $SIS_data .= ",'".$_GET['view']."'";                 }else{$SIS_data .= ",''";}
							if(isset($rowData['OT_idBodegaIns']) && $rowData['OT_idBodegaIns']!=''){    $SIS_data .= ",'".$rowData['OT_idBodegaIns']."'";    }else{$SIS_data .= ",''";}
							if(isset($rowData['idSistema']) && $rowData['idSistema']!=''){              $SIS_data .= ",'".$rowData['idSistema']."'";         }else{$SIS_data .= ",''";}
							if(isset($rowData['idUsuario']) && $rowData['idUsuario']!=''){              $SIS_data .= ",'".$rowData['idUsuario']."'";         }else{$SIS_data .= ",''";}
							if(isset($rowData['f_termino']) && $rowData['f_termino']!=''){
								$SIS_data .= ",'".$rowData['f_termino']."'";
								$SIS_data .= ",'".fecha2NMes($rowData['f_termino'])."'";
								$SIS_data .= ",'".fecha2Ano($rowData['f_termino'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($idTipo) && $idTipo!=''){                             $SIS_data .= ",'".$idTipo."'";                }else{$SIS_data .= ",''";}
							if(isset($trab['idProducto']) && $trab['idProducto']!=''){     $SIS_data .= ",'".$trab['idProducto']."'";    }else{$SIS_data .= ",''";}
							if(isset($trab['Cantidad']) && $trab['Cantidad']!=''){         $SIS_data .= ",'".$trab['Cantidad']."'";      }else{$SIS_data .= ",''";}
							if(isset($fecha_auto) && $fecha_auto!=''){                     $SIS_data .= ",'".$fecha_auto."'";            }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idOT, idBodega, idSistema, idUsuario, Creacion_fecha, Creacion_mes, Creacion_ano,  idTipo, idProducto,
							Cantidad_eg, fecha_auto';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'bodegas_insumos_facturacion_existencias', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}
				}

				//redirijo
				header( 'Location: orden_trabajo_terminar.php?terminated=true' );
				die;

			}

		break;

/*******************************************************************************************************************/
	}

?>
