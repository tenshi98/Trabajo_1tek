<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-222).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Variables
	$Medidas  = array();
	for ($i = 1; $i <= 50; $i++) {
		if (!empty($_POST['Medida_'.$i])) $Medidas[$i] = $_POST['Medida_'.$i];
	}

	//Traspaso de valores input a variables
	if (!empty($_POST['idAnalisis']))       $idAnalisis       = $_POST['idAnalisis'];
	if (!empty($_POST['idMaquina']))        $idMaquina        = $_POST['idMaquina'];
	if (!empty($_POST['idMatriz']))         $idMatriz         = $_POST['idMatriz'];
	if (!empty($_POST['idSistema']))        $idSistema        = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))         $idEstado         = $_POST['idEstado'];
	if (!empty($_POST['idOT']))             $idOT             = $_POST['idOT'];
	if (!empty($_POST['f_muestreo']))       $f_muestreo       = $_POST['f_muestreo'];
	if (!empty($_POST['f_recibida']))       $f_recibida       = $_POST['f_recibida'];
	if (!empty($_POST['f_reporte']))        $f_reporte        = $_POST['f_reporte'];
	if (!empty($_POST['n_muestra']))        $n_muestra        = $_POST['n_muestra'];

	if (!empty($_POST['obs_Diagnostico']))  $obs_Diagnostico  = $_POST['obs_Diagnostico'];
	if (!empty($_POST['obs_Accion']))       $obs_Accion       = $_POST['obs_Accion'];
	if (!empty($_POST['idTipo']))           $idTipo           = $_POST['idTipo'];
	if (!empty($_POST['idLaboratorio']))    $idLaboratorio    = $_POST['idLaboratorio'];

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
			case 'idAnalisis':        if(empty($idAnalisis)){         $error['idAnalisis']          = 'error/No ha ingresado el id';}break;
			case 'idMaquina':         if(empty($idMaquina)){          $error['idMaquina']           = 'error/No ha seleccionado la maquina';}break;
			case 'idMatriz':          if(empty($idMatriz)){           $error['idMatriz']            = 'error/No ha seleccionado la matriz';}break;
			case 'idSistema':         if(empty($idSistema)){          $error['idSistema']           = 'error/No ha seleccionado el idSistema';}break;
			case 'idEstado':          if(empty($idEstado)){           $error['idEstado']            = 'error/No ha seleccionado el idEstado';}break;
			case 'idOT':              if(empty($idOT)){               $error['idOT']                = 'error/No ha seleccionado la OT';}break;
			case 'f_muestreo':        if(empty($f_muestreo)){         $error['f_muestreo']          = 'error/No ha ingresado la fecha de muestros';}break;
			case 'f_recibida':        if(empty($f_recibida)){         $error['f_recibida']          = 'error/No ha ingresado la fecha de recepcion';}break;
			case 'f_reporte':         if(empty($f_reporte)){          $error['f_reporte']           = 'error/No ha ingresado la fecha del reporte';}break;
			case 'n_muestra':         if(empty($n_muestra)){          $error['n_muestra']           = 'error/No ha ingresado el numero de muestra';}break;
			case 'obs_Diagnostico':   if(empty($obs_Diagnostico)){    $error['obs_Diagnostico']     = 'error/No ha ingresado la observacion de diagnostico';}break;
			case 'obs_Accion':        if(empty($obs_Accion)){         $error['obs_Accion']          = 'error/No ha ingresado la observacion de accion';}break;
			case 'idTipo':            if(empty($idTipo)){             $error['idTipo']              = 'error/No ha seleccionado el tipo de analisis';}break;
			case 'idLaboratorio':     if(empty($idLaboratorio)){      $error['idLaboratorio']       = 'error/No ha seleccionado el laboratorio';}break;

			/*for ($i = 1; $i <= 50; $i++) {
				case 'Medida_'.$i: if(empty($Medidas[$i])){  $error['Medida_'.$i] = 'error/No ha ingresado la medida '.$i;}break;
			}*/

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($obs_Diagnostico) && $obs_Diagnostico!=''){ $obs_Diagnostico = EstandarizarInput($obs_Diagnostico);}
	if(isset($obs_Accion) && $obs_Accion!=''){           $obs_Accion      = EstandarizarInput($obs_Accion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($obs_Diagnostico)&&contar_palabras_censuradas($obs_Diagnostico)!=0){  $error['obs_Diagnostico'] = 'error/Edita obs Diagnostico, contiene palabras no permitidas';}
	if(isset($obs_Accion)&&contar_palabras_censuradas($obs_Accion)!=0){            $error['obs_Accion']      = 'error/Edita obs Accion, contiene palabras no permitidas';}

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
			if(isset($idMaquina)&&isset($idMatriz)&&isset($n_muestra)){
				$ndata_1 = db_select_nrows (false, 'idAnalisis', 'analisis_listado', '', "idMaquina='".$idMaquina."' AND idMatriz='".$idMatriz."' AND n_muestra='".$n_muestra."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}

			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_2'] = 'error/El analisis que esta tratando de ingresar ya existe';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************************/
				//filtros
				if(isset($idMaquina) && $idMaquina!=''){                $SIS_data  = "'".$idMaquina."'";            }else{$SIS_data  = "''";}
				if(isset($idMatriz) && $idMatriz!=''){                  $SIS_data .= ",'".$idMatriz."'";            }else{$SIS_data .= ",''";}
				if(isset($idSistema) && $idSistema!=''){                $SIS_data .= ",'".$idSistema."'";           }else{$SIS_data .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                  $SIS_data .= ",'".$idEstado."'";            }else{$SIS_data .= ",''";}
				if(isset($idOT) && $idOT!=''){                          $SIS_data .= ",'".$idOT."'";                }else{$SIS_data .= ",''";}
				if(isset($f_muestreo) && $f_muestreo!=''){              $SIS_data .= ",'".$f_muestreo."'";          }else{$SIS_data .= ",''";}
				if(isset($f_recibida) && $f_recibida!=''){              $SIS_data .= ",'".$f_recibida."'";          }else{$SIS_data .= ",''";}
				if(isset($f_reporte) && $f_reporte!=''){                $SIS_data .= ",'".$f_reporte."'";           }else{$SIS_data .= ",''";}
				if(isset($n_muestra) && $n_muestra!=''){                $SIS_data .= ",'".$n_muestra."'";           }else{$SIS_data .= ",''";}
				if(isset($obs_Diagnostico) && $obs_Diagnostico!=''){    $SIS_data .= ",'".$obs_Diagnostico."'";     }else{$SIS_data .= ",'Sin Observaciones'";}
				if(isset($obs_Accion) && $obs_Accion!=''){              $SIS_data .= ",'".$obs_Accion."'";          }else{$SIS_data .= ",'Sin Observaciones'";}
				if(isset($idTipo) && $idTipo!=''){                      $SIS_data .= ",'".$idTipo."'";              }else{$SIS_data .= ",''";}
				if(isset($idLaboratorio) && $idLaboratorio!=''){        $SIS_data .= ",'".$idLaboratorio."'";       }else{$SIS_data .= ",''";}

				$zz = '';
				for ($i = 1; $i <= 50; $i++) {
					if(isset($Medidas[$i]) && $Medidas[$i]!=''){   $SIS_data .= ",'".$Medidas[$i]."'";   }else{$SIS_data .= ",''";}
					$zz .= ',Medida_'.$i;
				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idMaquina,idMatriz,idSistema,idEstado,idOT, f_muestreo, f_recibida,
				f_reporte,n_muestra,obs_Diagnostico,obs_Accion, idTipo, idLaboratorio '.$zz;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					/*******************************************************************/
					if(isset($ultimo_id) && $ultimo_id!=''){
						//bucle
						$qry = '';
						for ($i = 1; $i <= 50; $i++) {
							$qry .= ',PuntoNombre_'.$i;
							$qry .= ',PuntoMedAceptable_'.$i;
							$qry .= ',PuntoMedAlerta_'.$i;
							$qry .= ',PuntoMedCondenatorio_'.$i;
						}

						/**************************************/
						// Se traen todos los datos de la maquina
						$rowData = db_select_data (false, 'idMaquina, cantPuntos '.$qry, 'maquinas_listado_matriz', '', 'idMatriz = "'.$idMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/**************************************/
						//se realiza la verificacion
						for ($i = 1; $i <= 50; $i++) {

							/***************************************************************/
							//verifico cual es mayor para proceder a la verificacion
							if($rowData['PuntoMedAceptable_'.$i]>$rowData['PuntoMedCondenatorio_'.$i]){
								//alerta amarilla
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]>$rowData['PuntoMedAlerta_'.$i]&&$Medidas[$i]<=$rowData['PuntoMedAceptable_'.$i]){
									//variables alerta amarilla
									$alert_lvl = 1; //amarilla

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
								//alerta naranja
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]>$rowData['PuntoMedCondenatorio_'.$i]&&$Medidas[$i]<=$rowData['PuntoMedAlerta_'.$i]){
									//variables alerta naranja
									$alert_lvl = 2; //naranja

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
								//alerta roja
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]<=$rowData['PuntoMedCondenatorio_'.$i]){
									//variables alerta roja
									$alert_lvl = 3; //roja

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}

							/***************************************************************/
							}elseif($rowData['PuntoMedAceptable_'.$i]<$rowData['PuntoMedCondenatorio_'.$i]){

								//alerta amarilla
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]<$rowData['PuntoMedAlerta_'.$i]&&$Medidas[$i]>=$rowData['PuntoMedAceptable_'.$i]){
									//variables alerta amarilla
									$alert_lvl = 1; //amarilla

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
								//alerta naranja
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]<$rowData['PuntoMedCondenatorio_'.$i]&&$Medidas[$i]>=$rowData['PuntoMedAlerta_'.$i]){
									//variables alerta naranja
									$alert_lvl = 2; //naranja

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
								//alerta roja
								if(isset($Medidas[$i])&&$Medidas[$i]!=''&&$Medidas[$i]>=$rowData['PuntoMedCondenatorio_'.$i]){
									//variables alerta roja
									$alert_lvl = 3; //roja

									//guardo el dato
									$SIS_data  = "'".$ultimo_id."'";
									$SIS_data .= ",'".$alert_lvl."'";
									$SIS_data .= ",'".$i."'";
									$SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";
									if(isset($f_reporte) && $f_reporte!= ''){
										$SIS_data .= ",'".$f_reporte."'";
										$SIS_data .= ",'".fecha2NdiaMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2NSemana($f_reporte)."'";
										$SIS_data .= ",'".fecha2NMes($f_reporte)."'";
										$SIS_data .= ",'".fecha2Ano($f_reporte)."'";
									}else{
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
										$SIS_data .= ",''";
									}
									$SIS_data .= ",'".$Medidas[$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";
									$SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idAnalisis,nivel,idPunto,Nombrepunto, Creacion_fecha, Creacion_dia,
									Creacion_Semana, Creacion_mes, Creacion_ano,valor, medAceptable,medAlerta,
									medCondenatorio';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'analisis_listado_alertas', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}
						}
					}

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
				//Filtros
				$SIS_data = "idAnalisis='".$idAnalisis."'";
				if(isset($idMaquina) && $idMaquina!=''){               $SIS_data .= ",idMaquina='".$idMaquina."'";}
				if(isset($idMatriz) && $idMatriz!=''){                 $SIS_data .= ",idMatriz='".$idMatriz."'";}
				if(isset($idSistema) && $idSistema!=''){               $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                 $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idOT) && $idOT!=''){                         $SIS_data .= ",idOT='".$idOT."'";}
				if(isset($f_muestreo) && $f_muestreo!=''){             $SIS_data .= ",f_muestreo='".$f_muestreo."'";}
				if(isset($f_recibida) && $f_recibida!=''){             $SIS_data .= ",f_recibida='".$f_recibida."'";}
				if(isset($f_reporte) && $f_reporte!=''){               $SIS_data .= ",f_reporte='".$f_reporte."'";}
				if(isset($n_muestra) && $n_muestra!=''){               $SIS_data .= ",n_muestra='".$n_muestra."'";}
				if(isset($obs_Diagnostico) && $obs_Diagnostico!=''){   $SIS_data .= ",obs_Diagnostico='".$obs_Diagnostico."'";}
				if(isset($obs_Accion) && $obs_Accion!=''){             $SIS_data .= ",obs_Accion='".$obs_Accion."'";}
				if(isset($idTipo) && $idTipo!=''){                     $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idLaboratorio) && $idLaboratorio!=''){       $SIS_data .= ",idLaboratorio='".$idLaboratorio."'";}

				for ($i = 1; $i <= 50; $i++) {
					if(isset($Medidas[$i]) && $Medidas[$i]!=''){    $SIS_data .= ",Medida_".$i."='".$Medidas[$i]."'";}
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'analisis_listado', 'idAnalisis = "'.$idAnalisis.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'analisis_listado', 'idAnalisis = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
