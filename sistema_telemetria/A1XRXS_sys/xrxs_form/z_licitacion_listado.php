<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-245).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Formulario para licitaciones
	if (!empty($_POST['idLicitacion']))        $idLicitacion         = $_POST['idLicitacion'];
	if (!empty($_POST['idSistema']))           $idSistema            = $_POST['idSistema'];
	if (!empty($_POST['Codigo']))              $Codigo               = $_POST['Codigo'];
	if (!empty($_POST['Nombre']))              $Nombre               = $_POST['Nombre'];
	if (!empty($_POST['FechaInicio']))         $FechaInicio          = $_POST['FechaInicio'];
	if (!empty($_POST['FechaTermino']))        $FechaTermino         = $_POST['FechaTermino'];
	if ( isset($_POST['Presupuesto']))         $Presupuesto          = $_POST['Presupuesto'];
	if (!empty($_POST['idEstado']))            $idEstado             = $_POST['idEstado'];
	if (!empty($_POST['idBodegaProd']))        $idBodegaProd         = $_POST['idBodegaProd'];
	if (!empty($_POST['idBodegaIns']))         $idBodegaIns          = $_POST['idBodegaIns'];
	if (!empty($_POST['idAprobado']))          $idAprobado           = $_POST['idAprobado'];
	if (!empty($_POST['idCliente']))           $idCliente            = $_POST['idCliente'];
	if (!empty($_POST['idTipoLicitacion']))    $idTipoLicitacion     = $_POST['idTipoLicitacion'];
	if ( isset($_POST['ValorMensual']))        $ValorMensual         = $_POST['ValorMensual'];
	if (!empty($_POST['idOpcionItem']))        $idOpcionItem         = $_POST['idOpcionItem'];

	if (!empty($_POST['idUtilizable']))        $idUtilizable         = $_POST['idUtilizable'];
	if ( isset($_POST['idFrecuencia']))        $idFrecuencia         = $_POST['idFrecuencia'];
	if ( isset($_POST['Cantidad']))            $Cantidad             = $_POST['Cantidad'];
	if ( isset($_POST['Valor']))               $Valor                = $_POST['Valor'];
	if ( isset($_POST['ValorTotal']))          $ValorTotal           = $_POST['ValorTotal'];
	if (!empty($_POST['TiempoProgramado']))    $TiempoProgramado     = $_POST['TiempoProgramado'];
	if (!empty($_POST['idTrabajo']))           $idTrabajo            = $_POST['idTrabajo'];

	if (!empty($_POST['lvl']))                 $lvl                  = $_POST['lvl'];

	//formulariopara el itemizado
	//Traspaso de valores input a variables
	$idLevel = array();
	if (!empty($_POST['idLevel_1']))      $idLevel[1]      = $_POST['idLevel_1'];
	if (!empty($_POST['idLevel_2']))      $idLevel[2]      = $_POST['idLevel_2'];
	if (!empty($_POST['idLevel_3']))      $idLevel[3]      = $_POST['idLevel_3'];
	if (!empty($_POST['idLevel_4']))      $idLevel[4]      = $_POST['idLevel_4'];
	if (!empty($_POST['idLevel_5']))      $idLevel[5]      = $_POST['idLevel_5'];
	if (!empty($_POST['idLevel_6']))      $idLevel[6]      = $_POST['idLevel_6'];
	if (!empty($_POST['idLevel_7']))      $idLevel[7]      = $_POST['idLevel_7'];
	if (!empty($_POST['idLevel_8']))      $idLevel[8]      = $_POST['idLevel_8'];
	if (!empty($_POST['idLevel_9']))      $idLevel[9]      = $_POST['idLevel_9'];
	if (!empty($_POST['idLevel_10']))     $idLevel[10]     = $_POST['idLevel_10'];
	if (!empty($_POST['idLevel_11']))     $idLevel[11]     = $_POST['idLevel_11'];
	if (!empty($_POST['idLevel_12']))     $idLevel[12]     = $_POST['idLevel_12'];
	if (!empty($_POST['idLevel_13']))     $idLevel[13]     = $_POST['idLevel_13'];
	if (!empty($_POST['idLevel_14']))     $idLevel[14]     = $_POST['idLevel_14'];
	if (!empty($_POST['idLevel_15']))     $idLevel[15]     = $_POST['idLevel_15'];
	if (!empty($_POST['idLevel_16']))     $idLevel[16]     = $_POST['idLevel_16'];
	if (!empty($_POST['idLevel_17']))     $idLevel[17]     = $_POST['idLevel_17'];
	if (!empty($_POST['idLevel_18']))     $idLevel[18]     = $_POST['idLevel_18'];
	if (!empty($_POST['idLevel_19']))     $idLevel[19]     = $_POST['idLevel_19'];
	if (!empty($_POST['idLevel_20']))     $idLevel[20]     = $_POST['idLevel_20'];
	if (!empty($_POST['idLevel_21']))     $idLevel[21]     = $_POST['idLevel_21'];
	if (!empty($_POST['idLevel_22']))     $idLevel[22]     = $_POST['idLevel_22'];
	if (!empty($_POST['idLevel_23']))     $idLevel[23]     = $_POST['idLevel_23'];
	if (!empty($_POST['idLevel_24']))     $idLevel[24]     = $_POST['idLevel_24'];
	if (!empty($_POST['idLevel_25']))     $idLevel[25]     = $_POST['idLevel_25'];

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
			case 'idLicitacion':        if(empty($idLicitacion)){         $error['idLicitacion']          = 'error/No ha seleccionado la licitacion';}break;
			case 'idSistema':           if(empty($idSistema)){            $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'Codigo':              if(empty($Codigo)){               $error['Codigo']                = 'error/No ha ingresado el codigo';}break;
			case 'Nombre':              if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'FechaInicio':         if(empty($FechaInicio)){          $error['FechaInicio']           = 'error/No ha ingresado la Fecha de inicio';}break;
			case 'FechaTermino':        if(empty($FechaTermino)){         $error['FechaTermino']          = 'error/No ha ingresado la Fecha de termino';}break;
			case 'Presupuesto':         if(!isset($Presupuesto)){         $error['Presupuesto']           = 'error/No ha ingresado el presupuesto';}break;
			case 'idEstado':            if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			case 'idBodegaProd':        if(empty($idBodegaProd)){         $error['idBodegaProd']          = 'error/No ha seleccionado la bodega de productos';}break;
			case 'idBodegaIns':         if(empty($idBodegaIns)){          $error['idBodegaIns']           = 'error/No ha seleccionado la bodega de insumos';}break;
			case 'idAprobado':          if(empty($idAprobado)){           $error['idAprobado']            = 'error/No ha seleccionado el estado de aprobacion';}break;
			case 'idCliente':           if(empty($idCliente)){            $error['idCliente']             = 'error/No ha seleccionado el cliente';}break;
			case 'idTipoLicitacion':    if(empty($idTipoLicitacion)){     $error['idTipoLicitacion']      = 'error/No ha seleccionado el tipo de contrato';}break;
			case 'ValorMensual':        if(!isset($ValorMensual)){        $error['ValorMensual']          = 'error/No ha ingresado el valor mensual';}break;
			case 'idOpcionItem':        if(empty($idOpcionItem)){         $error['idOpcionItem']          = 'error/No ha seleccionado la opción de mostrar itemizado';}break;

			case 'idUtilizable':        if(empty($idUtilizable)){         $error['idUtilizable']          = 'error/No ha seleccionado si es utilizable';}break;
			case 'idFrecuencia':        if(!isset($idFrecuencia)){        $error['idFrecuencia']          = 'error/No ha seleccionado la unidad de medida';}break;
			case 'Cantidad':            if(!isset($Cantidad)){            $error['Cantidad']              = 'error/No ha ingresado la cantidad';}break;
			case 'Valor':               if(!isset($Valor)){               $error['Valor']                 = 'error/No ha ingresado el valor';}break;
			case 'ValorTotal':          if(!isset($ValorTotal)){          $error['ValorTotal']            = 'error/No ha ingresado el valor total';}break;
			case 'TiempoProgramado':    if(empty($TiempoProgramado)){     $error['TiempoProgramado']      = 'error/No ha ingresado el tiempo programado';}break;
			case 'idTrabajo':           if(empty($idTrabajo)){            $error['idTrabajo']             = 'error/No ha seleccionado el tipo de trabajo';}break;
			case 'lvl':                 if(empty($lvl)){                  $error['lvl']                   = 'error/No ha ingresado el nivel';}break;

			case 'idLevel_1':           if(empty($idLevel[1])){           $error['idLevel_1']             = 'error/No ha ingresado el idLevel_1';}break;
			case 'idLevel_2':           if(empty($idLevel[2])){           $error['idLevel_2']             = 'error/No ha ingresado el idLevel_2';}break;
			case 'idLevel_3':           if(empty($idLevel[3])){           $error['idLevel_3']             = 'error/No ha ingresado el idLevel_3';}break;
			case 'idLevel_4':           if(empty($idLevel[4])){           $error['idLevel_4']             = 'error/No ha ingresado el idLevel_4';}break;
			case 'idLevel_5':           if(empty($idLevel[5])){           $error['idLevel_5']             = 'error/No ha ingresado el idLevel_5';}break;
			case 'idLevel_6':           if(empty($idLevel[6])){           $error['idLevel_6']             = 'error/No ha ingresado el idLevel_6';}break;
			case 'idLevel_7':           if(empty($idLevel[7])){           $error['idLevel_7']             = 'error/No ha ingresado el idLevel_7';}break;
			case 'idLevel_8':           if(empty($idLevel[8])){           $error['idLevel_8']             = 'error/No ha ingresado el idLevel_8';}break;
			case 'idLevel_9':           if(empty($idLevel[9])){           $error['idLevel_9']             = 'error/No ha ingresado el idLevel_9';}break;
			case 'idLevel_10':          if(empty($idLevel[10])){          $error['idLevel_10']            = 'error/No ha ingresado el idLevel_10';}break;
			case 'idLevel_11':          if(empty($idLevel[11])){          $error['idLevel_11']            = 'error/No ha ingresado el idLevel_11';}break;
			case 'idLevel_12':          if(empty($idLevel[12])){          $error['idLevel_12']            = 'error/No ha ingresado el idLevel_12';}break;
			case 'idLevel_13':          if(empty($idLevel[13])){          $error['idLevel_13']            = 'error/No ha ingresado el idLevel_13';}break;
			case 'idLevel_14':          if(empty($idLevel[14])){          $error['idLevel_14']            = 'error/No ha ingresado el idLevel_14';}break;
			case 'idLevel_15':          if(empty($idLevel[15])){          $error['idLevel_15']            = 'error/No ha ingresado el idLevel_15';}break;
			case 'idLevel_16':          if(empty($idLevel[16])){          $error['idLevel_16']            = 'error/No ha ingresado el idLevel_16';}break;
			case 'idLevel_17':          if(empty($idLevel[17])){          $error['idLevel_17']            = 'error/No ha ingresado el idLevel_17';}break;
			case 'idLevel_18':          if(empty($idLevel[18])){          $error['idLevel_18']            = 'error/No ha ingresado el idLevel_18';}break;
			case 'idLevel_19':          if(empty($idLevel[19])){          $error['idLevel_19']            = 'error/No ha ingresado el idLevel_19';}break;
			case 'idLevel_20':          if(empty($idLevel[20])){          $error['idLevel_20']            = 'error/No ha ingresado el idLevel_20';}break;
			case 'idLevel_21':          if(empty($idLevel[21])){          $error['idLevel_21']            = 'error/No ha ingresado el idLevel_21';}break;
			case 'idLevel_22':          if(empty($idLevel[22])){          $error['idLevel_22']            = 'error/No ha ingresado el idLevel_22';}break;
			case 'idLevel_23':          if(empty($idLevel[23])){          $error['idLevel_23']            = 'error/No ha ingresado el idLevel_23';}break;
			case 'idLevel_24':          if(empty($idLevel[24])){          $error['idLevel_24']            = 'error/No ha ingresado el idLevel_24';}break;
			case 'idLevel_25':          if(empty($idLevel[25])){          $error['idLevel_25']            = 'error/No ha ingresado el idLevel_25';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Codigo) && $Codigo!=''){ $Codigo = EstandarizarInput($Codigo);}
	if(isset($Nombre) && $Nombre!=''){$Nombre = EstandarizarInput($Nombre);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){  $error['Codigo'] = 'error/Edita Codigo, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){  $error['Nombre'] = 'error/Edita Nombre,contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'createBasicData':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'licitacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                $SIS_data  = "'".$idSistema."'";         }else{$SIS_data  = "''";}
				if(isset($Codigo) && $Codigo!=''){                      $SIS_data .= ",'".$Codigo."'";           }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                      $SIS_data .= ",'".$Nombre."'";           }else{$SIS_data .= ",''";}
				if(isset($FechaInicio) && $FechaInicio!=''){            $SIS_data .= ",'".$FechaInicio."'";      }else{$SIS_data .= ",''";}
				if(isset($FechaTermino) && $FechaTermino!=''){          $SIS_data .= ",'".$FechaTermino."'";     }else{$SIS_data .= ",''";}
				if(isset($Presupuesto) && $Presupuesto!=''){            $SIS_data .= ",'".$Presupuesto."'";      }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",'".$idEstado."'";         }else{$SIS_data .= ",''";}
				if(isset($idBodegaProd) && $idBodegaProd!=''){          $SIS_data .= ",'".$idBodegaProd."'";     }else{$SIS_data .= ",''";}
				if(isset($idBodegaIns) && $idBodegaIns!=''){            $SIS_data .= ",'".$idBodegaIns."'";      }else{$SIS_data .= ",''";}
				if(isset($idAprobado) && $idAprobado!=''){              $SIS_data .= ",'".$idAprobado."'";       }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){                $SIS_data .= ",'".$idCliente."'";        }else{$SIS_data .= ",''";}
				if(isset($idTipoLicitacion) && $idTipoLicitacion!=''){  $SIS_data .= ",'".$idTipoLicitacion."'"; }else{$SIS_data .= ",''";}
				if(isset($ValorMensual) && $ValorMensual!=''){          $SIS_data .= ",'".$ValorMensual."'";     }else{$SIS_data .= ",''";}
				if(isset($idOpcionItem) && $idOpcionItem!=''){          $SIS_data .= ",'".$idOpcionItem."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Codigo, Nombre,FechaInicio, FechaTermino, Presupuesto, idEstado, idBodegaProd, idBodegaIns, idAprobado, idCliente, idTipoLicitacion, ValorMensual, idOpcionItem';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*********************************************************************/
					//Se guarda en historial la accion
					if(isset($ultimo_id) && $ultimo_id!=''){    $SIS_data  = "'".$ultimo_id."'";  }else{$SIS_data  = "''";}
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'1'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'Creacion del documento'";                               //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'updateBasicData':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idLicitacion)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'licitacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idLicitacion!='".$idLicitacion."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*****************************************************/
				// Se traen todos los datos de la licitacion
				$rowData = db_select_data (false, 'Codigo, Nombre,FechaInicio, FechaTermino, Presupuesto, idBodegaProd, idBodegaIns, idSistema, idAprobado, idCliente, idEstado, idTipoLicitacion, ValorMensual, idOpcionItem', 'licitacion_listado', '', 'idLicitacion = '.$idLicitacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				// Se traen todos los datos de la licitacion
				$SIS_data = "idLicitacion='".$idLicitacion."'";
				if(isset($idSistema) && $idSistema!=''){                $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Codigo) && $Codigo!=''){                      $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($Nombre) && $Nombre!=''){                      $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($FechaInicio) && $FechaInicio!=''){            $SIS_data .= ",FechaInicio='".$FechaInicio."'";}
				if(isset($FechaTermino) && $FechaTermino!=''){          $SIS_data .= ",FechaTermino='".$FechaTermino."'";}
				if(isset($Presupuesto) && $Presupuesto!=''){            $SIS_data .= ",Presupuesto='".$Presupuesto."'";}
				if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idBodegaProd) && $idBodegaProd!=''){          $SIS_data .= ",idBodegaProd='".$idBodegaProd."'";}
				if(isset($idBodegaIns) && $idBodegaIns!=''){            $SIS_data .= ",idBodegaIns='".$idBodegaIns."'";}
				if(isset($idAprobado) && $idAprobado!=''){              $SIS_data .= ",idAprobado='".$idAprobado."'";}
				if(isset($idCliente) && $idCliente!=''){                $SIS_data .= ",idCliente='".$idCliente."'";}
				if(isset($idTipoLicitacion) && $idTipoLicitacion!=''){  $SIS_data .= ",idTipoLicitacion='".$idTipoLicitacion."'";}
				if(isset($ValorMensual) && $ValorMensual!=''){          $SIS_data .= ",ValorMensual='".$ValorMensual."'";}
				if(isset($idOpcionItem) && $idOpcionItem!=''){          $SIS_data .= ",idOpcionItem='".$idOpcionItem."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'licitacion_listado', 'idLicitacion = "'.$idLicitacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/*****************************************************/
					//se crean el mensaje
					$hist_Observacion = '<strong>Modificaciones:</strong><br/>';

					if(isset($idSistema) && $idSistema != $rowData['idSistema']){                      $hist_Observacion .= '-Se cambia el sistema<br/>';}
					if(isset($Codigo) && $Codigo != $rowData['Codigo']){                               $hist_Observacion .= '-Se cambia el Codigo, de <strong>'.$rowData['Codigo'].'</strong> a <strong>'.$Codigo.'</strong><br/>';}
					if(isset($Nombre) && $Nombre != $rowData['Nombre']){                               $hist_Observacion .= '-Se cambia el Nombre,de <strong>'.$rowData['Nombre'].'</strong> a <strong>'.$Nombre.'</strong><br/>';}
					if(isset($FechaInicio) && $FechaInicio != $rowData['FechaInicio']){                $hist_Observacion .= '-Se cambia la Fecha de Inicio, de <strong>'.fecha_estandar($rowData['FechaInicio']).'</strong> a <strong>'.fecha_estandar($FechaInicio).'</strong><br/>';}
					if(isset($FechaTermino) && $FechaTermino != $rowData['FechaTermino']){             $hist_Observacion .= '-Se cambia la Fecha de Termino, de <strong>'.fecha_estandar($rowData['FechaTermino']).'</strong> a <strong>'.fecha_estandar($FechaTermino).'</strong><br/>';}
					if(isset($Presupuesto) && $Presupuesto != $rowData['Presupuesto']){                $hist_Observacion .= '-Se cambia el Presupuesto, de <strong>'.valores($rowData['Presupuesto'], 0).'</strong> a <strong>'.valores($Presupuesto, 0).'</strong><br/>';}
					if(isset($idEstado) && $idEstado != $rowData['idEstado']){                         $hist_Observacion .= '-Se cambia el Estado<br/>';}
					if(isset($idBodegaProd) && $idBodegaProd != $rowData['idBodegaProd']){             $hist_Observacion .= '-Se cambia la Bodega de Productos<br/>';}
					if(isset($idBodegaIns) && $idBodegaIns != $rowData['idBodegaIns']){                $hist_Observacion .= '-Se cambia la Bodega de Insumos<br/>';}
					if(isset($idAprobado) && $idAprobado != $rowData['idAprobado']){                   $hist_Observacion .= '-Se cambia el estado de aprobacion<br/>';}
					if(isset($idCliente) && $idCliente != $rowData['idCliente']){                      $hist_Observacion .= '-Se cambia el cliente<br/>';}
					if(isset($idTipoLicitacion) && $idTipoLicitacion != $rowData['idTipoLicitacion']){ $hist_Observacion .= '-Se cambia el Tipo de Contrato<br/>';}
					if(isset($ValorMensual) && $ValorMensual != $rowData['ValorMensual']){             $hist_Observacion .= '-Se cambia el valor mensual del contrato<br/>';}
					if(isset($idOpcionItem) && $idOpcionItem != $rowData['idOpcionItem']){             $hist_Observacion .= '-Se cambia la opción de telemetria<br/>';}

					/*****************************************************/
					//se guarda el registro
					if(isset($hist_Observacion)&&$hist_Observacion!='<strong>Modificaciones:</strong><br/>'){
						//Se guarda en historial la accion
						$SIS_data  = "'".$idLicitacion."'";
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'2'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$hist_Observacion."'";                                //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'delBasicData':

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
				//maximo de registros
				$nmax = 25;

				//se borran los datos
				$resultado = db_delete_data (false, 'licitacion_listado', 'idLicitacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos relacionados
				for ($i = 1; $i <= $nmax; $i++) {
					$resultado = db_delete_data (false, 'licitacion_listado_level_'.$i, 'idLicitacion = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				//redirijo
				header( 'Location: '.$location.'&deleted=true' );
				die;
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;

/*******************************************************************************************************************/
		case 'insert_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($lvl)&&isset($Nombre)&&isset($idLicitacion)&&isset($idSistema)&&isset($Codigo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'licitacion_listado_level_'.$lvl, '', "Nombre='".$Nombre."' AND idLicitacion='".$idLicitacion."' AND idSistema='".$idSistema."' AND Codigo='".$Codigo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe';}
			/*******************************************************************/

			// si no hay errores ejecuto
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($idLicitacion) && $idLicitacion!=''){          $SIS_data .= ",'".$idLicitacion."'";      }else{$SIS_data .= ",''";}
				if(isset($idUtilizable) && $idUtilizable!=''){          $SIS_data .= ",'".$idUtilizable."'";      }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                      $SIS_data .= ",'".$Nombre."'";            }else{$SIS_data .= ",''";}
				if(isset($Codigo) && $Codigo!=''){                      $SIS_data .= ",'".$Codigo."'";            }else{$SIS_data .= ",''";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){          $SIS_data .= ",'".$idFrecuencia."'";      }else{$SIS_data .= ",''";}
				if(isset($Cantidad) && $Cantidad!=''){                  $SIS_data .= ",'".$Cantidad."'";          }else{$SIS_data .= ",''";}
				if(isset($Valor) && $Valor!=''){                        $SIS_data .= ",'".$Valor."'";             }else{$SIS_data .= ",''";}
				if(isset($ValorTotal) && $ValorTotal!=''){              $SIS_data .= ",'".$ValorTotal."'";        }else{$SIS_data .= ",''";}
				if(isset($TiempoProgramado) && $TiempoProgramado!=''){  $SIS_data .= ",'".$TiempoProgramado."'";  }else{$SIS_data .= ",''";}
				if(isset($idTrabajo) && $idTrabajo!=''){                $SIS_data .= ",'".$idTrabajo."'";         }else{$SIS_data .= ",''";}

				$xbla = '';
				for ($i = 2; $i <= $lvl; $i++) {
					//Ubico correctamente el puntero
					$point = $i - 1;
					//Valor a insertar
					if(isset($idLevel[$point]) && $idLevel[$point]!=''){   $SIS_data .= ",'".$idLevel[$point]."'";   }else{$SIS_data .=",''";}
					//donde insertar
					$xbla .= ',idLevel_'.$point;
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idLicitacion, idUtilizable,Nombre,Codigo,idFrecuencia,Cantidad,Valor,ValorTotal,TiempoProgramado, idTrabajo '.$xbla;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_level_'.$lvl, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					/*****************************************************/
					//se crean el mensaje
					$hist_Observacion = '<strong>Modificaciones:</strong><br/>';

					if(isset($Nombre) && $Nombre!=''){   $hist_Observacion .= '-Se crea el itemizado '.$Nombre.'<br/>';}

					/*****************************************************/
					//se guarda el registro
					if(isset($hist_Observacion)&&$hist_Observacion!='<strong>Modificaciones:</strong><br/>'){
						//Se guarda en historial la accion
						$SIS_data  = "'".$idLicitacion."'";
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'2'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$hist_Observacion."'";                                //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// si no hay errores ejecuto
			if(empty($error)){
				/*****************************************************/
				// Se traen todos los datos de la licitacion
				$rowData = db_select_data (false, 'idSistema, idLicitacion, idUtilizable, Nombre,Codigo, idFrecuencia, Cantidad, Valor, ValorTotal, TiempoProgramado, idTrabajo', 'licitacion_listado_level_'.$lvl, '', 'idLevel_'.$lvl.' = "'.$idLevel[$lvl].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*****************************************************/
				//Filtros
				$SIS_data = "idLevel_".$lvl."='".$idLevel[$lvl]."'";
				if(isset($idSistema) && $idSistema!=''){                 $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idLicitacion) && $idLicitacion!=''){           $SIS_data .= ",idLicitacion='".$idLicitacion."'";}
				if(isset($idUtilizable) && $idUtilizable!=''){           $SIS_data .= ",idUtilizable='".$idUtilizable."'";}
				if(isset($Nombre) && $Nombre!=''){                       $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Codigo) && $Codigo!=''){                       $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){           $SIS_data .= ",idFrecuencia='".$idFrecuencia."'";}
				if(isset($Cantidad) && $Cantidad!=''){                   $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($Valor) && $Valor!=''){                         $SIS_data .= ",Valor='".$Valor."'";}
				if(isset($ValorTotal) && $ValorTotal!=''){               $SIS_data .= ",ValorTotal='".$ValorTotal."'";}
				if(isset($TiempoProgramado) && $TiempoProgramado!=''){   $SIS_data .= ",TiempoProgramado='".$TiempoProgramado."'";}
				if(isset($idTrabajo) && $idTrabajo!=''){                 $SIS_data .= ",idTrabajo='".$idTrabajo."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'licitacion_listado_level_'.$lvl, 'idLevel_'.$lvl.' = "'.$idLevel[$lvl].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/*****************************************************/
					//se crean el mensaje
					$hist_Observacion = '<strong>Modificaciones:</strong><br/>';

					if(isset($idSistema) && $idSistema != $rowData['idSistema']){                       $hist_Observacion .= '-Se cambia el sistema del item '.$rowData['Nombre'].'<br/>';}
					if(isset($idLicitacion) && $idLicitacion != $rowData['idLicitacion']){              $hist_Observacion .= '-Se cambia la licitacion del item '.$rowData['Nombre'].'<br/>';}
					if(isset($idUtilizable) && $idUtilizable != $rowData['idUtilizable']){              $hist_Observacion .= '-Se cambia el estado de utilizacion del item '.$rowData['Nombre'].'<br/>';}
					if(isset($Nombre) && $Nombre != $rowData['Nombre']){                                $hist_Observacion .= '-Se cambia el nombre del item '.$rowData['Nombre'].', de <strong>'.$rowData['Nombre'].'</strong> a <strong>'.$Nombre.'</strong><br/>';}
					if(isset($Codigo) && $Codigo != $rowData['Codigo']){                                $hist_Observacion .= '-Se cambia el codigo del item '.$rowData['Nombre'].', de <strong>'.$rowData['Codigo'].'</strong> a <strong>'.$Codigo.'</strong><br/>';}
					if(isset($idFrecuencia) && $idFrecuencia != $rowData['idFrecuencia']){              $hist_Observacion .= '-Se cambia la fecuencia del item '.$rowData['Nombre'].'<br/>';}
					if(isset($Cantidad) && $Cantidad != $rowData['Cantidad']){                          $hist_Observacion .= '-Se cambia la cantidad del item '.$rowData['Nombre'].', de <strong>'.cantidades($rowData['Cantidad'], 0).'</strong> a <strong>'.cantidades($Cantidad, 0).'</strong><br/>';}
					if(isset($Valor) && $Valor != $rowData['Valor']){                                   $hist_Observacion .= '-Se cambia el valor unitario del item '.$rowData['Nombre'].', de <strong>'.valores($rowData['Valor'], 0).'</strong> a <strong>'.valores($Valor, 0).'</strong><br/>';}
					if(isset($ValorTotal) && $ValorTotal != $rowData['ValorTotal']){                    $hist_Observacion .= '-Se cambia el valor total del item '.$rowData['Nombre'].', de <strong>'.valores($rowData['ValorTotal'], 0).'</strong> a <strong>'.valores($ValorTotal, 0).'</strong><br/>';}
					if(isset($TiempoProgramado) && $TiempoProgramado != $rowData['TiempoProgramado']){  $hist_Observacion .= '-Se cambia el tiempo programado del item '.$rowData['Nombre'].', de <strong>'.$rowData['TiempoProgramado'].'</strong> a <strong>'.$TiempoProgramado.'</strong><br/>';}
					if(isset($idTrabajo) && $idTrabajo != $rowData['idTrabajo']){                       $hist_Observacion .= '-Se cambia el tipo de trabajo del item '.$rowData['Nombre'].'<br/>';}

					/*****************************************************/
					//se guarda el registro
					if(isset($hist_Observacion)&&$hist_Observacion!='<strong>Modificaciones:</strong><br/>'){
						//Se guarda en historial la accion
						$SIS_data  = "'".$idLicitacion."'";
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'2'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$hist_Observacion."'";                                //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					header( 'Location: '.$location.'&edited=true' );
					die;

				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del_idLevel']) OR !validaEntero($_GET['del_idLevel']))&&$_GET['del_idLevel']!=''){
				$indice = simpleDecode($_GET['del_idLevel'], fecha_actual());
			}else{
				$indice = $_GET['del_idLevel'];
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
				for ($i = $_GET['lvl']; $i <= $_GET['nmax']; $i++) {

					/*****************************************************/
					// Se traen todos los datos de la licitacion
					$rowData = db_select_data (false, 'Nombre', 'licitacion_listado_level_'.$i, '', 'idLevel_'.$_GET['lvl'].' = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*****************************************************/
					//se borran los datos
					$resultado = db_delete_data (false, 'licitacion_listado_level_'.$i, 'idLevel_'.$_GET['lvl'].' = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/*****************************************************/
					//se crean el mensaje
					$hist_Observacion = '<strong>Modificaciones:</strong><br/>';
					$hist_Observacion .= '-Se elimina el item '.$rowData['Nombre'].'<br/>';

					/*****************************************************/
					//se guarda el registro
					if(isset($hist_Observacion)&&$hist_Observacion!='<strong>Modificaciones:</strong><br/>'){
						//Se guarda en historial la accion
						$SIS_data  = "'".$idLicitacion."'";
						$SIS_data .= ",'".fecha_actual()."'";
						$SIS_data .= ",'3'";                                                    //Creacion Satisfactoria
						$SIS_data .= ",'".$hist_Observacion."'";                                //Observacion
						$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

						// inserto los datos de registro en la db
						$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				//redirijo
				header( 'Location: '.$location.'&deleted=true' );
				die;
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
		case 'estado':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idLicitacion  = $_GET['id'];
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());

			/*****************************************************/
			// Se traen todos los datos de la licitacion
			$rowData = db_select_data (false, 'idEstado', 'licitacion_listado', '', 'idLicitacion = '.$idLicitacion, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'licitacion_listado', 'idLicitacion = "'.$idLicitacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				/*****************************************************/
				//se crean el mensaje
				$hist_Observacion = '<strong>Modificaciones:</strong><br/>';

				if(isset($idEstado) && $idEstado != $rowData['idEstado']){   $hist_Observacion .= '-Se cambia el Estado<br/>';}

				/*****************************************************/
				//se guarda el registro
				if(isset($hist_Observacion)&&$hist_Observacion!='<strong>Modificaciones:</strong><br/>'){
					//Se guarda en historial la accion
					$SIS_data  = "'".$idLicitacion."'";
					$SIS_data .= ",'".fecha_actual()."'";
					$SIS_data .= ",'2'";                                                    //Creacion Satisfactoria
					$SIS_data .= ",'".$hist_Observacion."'";                                //Observacion
					$SIS_data .= ",'".$_SESSION['usuario']['basic_data']['idUsuario']."'";  //idUsuario

					// inserto los datos de registro en la db
					$SIS_columns = 'idLicitacion, Creacion_fecha, idTipo, Observacion, idUsuario';
					$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado_historial', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'createBasicDataContrato':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'licitacion_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";      }else{$SIS_data  = "''";}
				if(isset($Codigo) && $Codigo!=''){               $SIS_data .= ",'".$Codigo."'";        }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){               $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .= ",''";}
				if(isset($FechaInicio) && $FechaInicio!=''){     $SIS_data .= ",'".$FechaInicio."'";   }else{$SIS_data .= ",''";}
				if(isset($FechaTermino) && $FechaTermino!=''){   $SIS_data .= ",'".$FechaTermino."'";  }else{$SIS_data .= ",''";}
				if(isset($Presupuesto) && $Presupuesto!=''){     $SIS_data .= ",'".$Presupuesto."'";   }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){           $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .= ",''";}
				if(isset($idBodegaProd) && $idBodegaProd!=''){   $SIS_data .= ",'".$idBodegaProd."'";  }else{$SIS_data .= ",''";}
				if(isset($idBodegaIns) && $idBodegaIns!=''){     $SIS_data .= ",'".$idBodegaIns."'";   }else{$SIS_data .= ",''";}
				if(isset($idAprobado) && $idAprobado!=''){       $SIS_data .= ",'".$idAprobado."'";    }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){         $SIS_data .= ",'".$idCliente."'";     }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, Codigo, Nombre,FechaInicio, FechaTermino, Presupuesto, idEstado, idBodegaProd, idBodegaIns, idAprobado, idCliente';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'licitacion_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
		case 'estadoContrato':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idLicitacion  = $_GET['status'];
			$idEstado      = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'licitacion_listado', 'idLicitacion = "'.$idLicitacion.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
	}

?>
