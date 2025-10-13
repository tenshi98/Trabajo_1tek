<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-246).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Formulario para maquinas
	if (!empty($_POST['idMaquina']))            $idMaquina             = $_POST['idMaquina'];
	if (!empty($_POST['idSistema']))            $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idEstado']))             $idEstado              = $_POST['idEstado'];
	if (!empty($_POST['Codigo']))               $Codigo                = $_POST['Codigo'];
	if (!empty($_POST['Nombre']))               $Nombre                = $_POST['Nombre'];
	if (!empty($_POST['Modelo']))               $Modelo                = $_POST['Modelo'];
	if (!empty($_POST['Serie']))                $Serie                 = $_POST['Serie'];
	if (!empty($_POST['Fabricante']))           $Fabricante            = $_POST['Fabricante'];
	if (!empty($_POST['fincorporacion']))       $fincorporacion        = $_POST['fincorporacion'];
	if (!empty($_POST['Descripcion']))          $Descripcion           = $_POST['Descripcion'];
	if (!empty($_POST['idConfig_1']))           $idConfig_1            = $_POST['idConfig_1'];
	if (!empty($_POST['idConfig_2']))           $idConfig_2            = $_POST['idConfig_2'];
	if (!empty($_POST['idConfig_3']))           $idConfig_3            = $_POST['idConfig_3'];
	if (!empty($_POST['idConfig_4']))           $idConfig_4            = $_POST['idConfig_4'];
	if (!empty($_POST['idUbicacion']))          $idUbicacion           = $_POST['idUbicacion'];
	if (!empty($_POST['idUbicacion_lvl_1']))    $idUbicacion_lvl_1     = $_POST['idUbicacion_lvl_1'];
	if (!empty($_POST['idUbicacion_lvl_2']))    $idUbicacion_lvl_2     = $_POST['idUbicacion_lvl_2'];
	if (!empty($_POST['idUbicacion_lvl_3']))    $idUbicacion_lvl_3     = $_POST['idUbicacion_lvl_3'];
	if (!empty($_POST['idUbicacion_lvl_4']))    $idUbicacion_lvl_4     = $_POST['idUbicacion_lvl_4'];
	if (!empty($_POST['idUbicacion_lvl_5']))    $idUbicacion_lvl_5     = $_POST['idUbicacion_lvl_5'];
	if (!empty($_POST['idCliente']))            $idCliente             = $_POST['idCliente'];
	if (!empty($_POST['FakeidCliente']))        $FakeidCliente         = $_POST['FakeidCliente'];

	//formulario para componentes
	if (!empty($_POST['idUtilizable']))         $idUtilizable          = $_POST['idUtilizable'];
	if ( isset($_POST['Marca']))                $Marca                 = $_POST['Marca'];
	if ( isset($_POST['AnoFab']))               $AnoFab                = $_POST['AnoFab'];
	if ( isset($_POST['idSubTipo']))            $idSubTipo             = $_POST['idSubTipo'];
	if ( isset($_POST['Grasa_inicial']))        $Grasa_inicial         = $_POST['Grasa_inicial'];
	if ( isset($_POST['Grasa_relubricacion']))  $Grasa_relubricacion   = $_POST['Grasa_relubricacion'];
	if ( isset($_POST['Aceite']))               $Aceite                = $_POST['Aceite'];
	if ( isset($_POST['Cantidad']))             $Cantidad              = $_POST['Cantidad'];
	if (!empty($_POST['idUml']))                $idUml                 = $_POST['idUml'];
	if (!empty($_POST['Frecuencia']))           $Frecuencia            = $_POST['Frecuencia'];
	if (!empty($_POST['idFrecuencia']))         $idFrecuencia          = $_POST['idFrecuencia'];
	if (!empty($_POST['idProducto']))           $idProducto            = $_POST['idProducto'];
	if (!empty($_POST['Saf']))                  $Saf                   = $_POST['Saf'];
	if (!empty($_POST['Numero']))               $Numero                = $_POST['Numero'];
	if (!empty($_POST['lvl']))                  $lvl                   = $_POST['lvl'];
	if (!empty($_POST['idLicitacion']))         $idLicitacion          = $_POST['idLicitacion'];
	if (!empty($_POST['addTrabajo']))           $SIS_dataddTrabajo     = $_POST['addTrabajo'];

	//formulario para matriz analisis
	if (!empty($_POST['cantPuntos']))           $cantPuntos            = $_POST['cantPuntos'];
	if (!empty($_POST['mod']))                  $mod                   = $_POST['mod'];
	if (!empty($_POST['idMatriz']))             $idMatriz              = $_POST['idMatriz'];
	if (!empty($_POST['PuntoNombre']))          $PuntoNombre           = $_POST['PuntoNombre'];
	if (!empty($_POST['PuntoidTipo']))          $PuntoidTipo           = $_POST['PuntoidTipo'];
	if (!empty($_POST['PuntoMedAceptable']))    $PuntoMedAceptable     = $_POST['PuntoMedAceptable'];
	if (!empty($_POST['PuntoMedAlerta']))       $PuntoMedAlerta        = $_POST['PuntoMedAlerta'];
	if (!empty($_POST['PuntoMedCondenatorio'])) $PuntoMedCondenatorio  = $_POST['PuntoMedCondenatorio'];
	if (!empty($_POST['PuntoUniMed']))          $PuntoUniMed           = $_POST['PuntoUniMed'];
	if (!empty($_POST['PuntoidGrupo']))         $PuntoidGrupo          = $_POST['PuntoidGrupo'];

	//formulariopara el itemizado
	//Traspaso de valores input a variables
	$idLevel = array();
	for ($i = 1; $i <= 25; $i++) {
		if (!empty($_POST['idLevel_'.$i]))      $idLevel[$i]      = $_POST['idLevel_'.$i];
	}

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
			case 'idMaquina':           if(empty($idMaquina)){            $error['idMaquina']             = 'error/No ha seleccionado la licitacion';}break;
			case 'idSistema':           if(empty($idSistema)){            $error['idSistema']             = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':            if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			case 'Codigo':              if(empty($Codigo)){               $error['Codigo']                = 'error/No ha ingresado el codigo';}break;
			case 'Nombre':              if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'Modelo':              if(empty($Modelo)){               $error['Modelo']                = 'error/No ha ingresado la Fecha de inicio';}break;
			case 'Serie':               if(empty($Serie)){                $error['Serie']                 = 'error/No ha ingresado la Fecha de termino';}break;
			case 'Fabricante':          if(empty($Fabricante)){           $error['Fabricante']            = 'error/No ha ingresado el Fabricante';}break;
			case 'fincorporacion':      if(empty($fincorporacion)){       $error['fincorporacion']        = 'error/No ha seleccionado la bodega de productos';}break;
			case 'Descripcion':         if(empty($Descripcion)){          $error['Descripcion']           = 'error/No ha ingresado la descripcion';}break;
			case 'idConfig_1':          if(empty($idConfig_1)){           $error['idConfig_1']            = 'error/No ha seleccionado la opción 1';}break;
			case 'idConfig_2':          if(empty($idConfig_2)){           $error['idConfig_2']            = 'error/No ha seleccionado la opción 2';}break;
			case 'idConfig_3':          if(empty($idConfig_3)){           $error['idConfig_3']            = 'error/No ha seleccionado la opción 3';}break;
			case 'idConfig_4':          if(empty($idConfig_4)){           $error['idConfig_4']            = 'error/No ha seleccionado la opción 4';}break;
			case 'idUbicacion':         if(empty($idUbicacion)){          $error['idUbicacion']           = 'error/No ha seleccionado la ubicacion';}break;
			case 'idUbicacion_lvl_1':   if(empty($idUbicacion_lvl_1)){    $error['idUbicacion_lvl_1']     = 'error/No ha seleccionado el nivel 1';}break;
			case 'idUbicacion_lvl_2':   if(empty($idUbicacion_lvl_2)){    $error['idUbicacion_lvl_2']     = 'error/No ha seleccionado el nivel 2';}break;
			case 'idUbicacion_lvl_3':   if(empty($idUbicacion_lvl_3)){    $error['idUbicacion_lvl_3']     = 'error/No ha seleccionado el nivel 3';}break;
			case 'idUbicacion_lvl_4':   if(empty($idUbicacion_lvl_4)){    $error['idUbicacion_lvl_4']     = 'error/No ha seleccionado el nivel 4';}break;
			case 'idUbicacion_lvl_5':   if(empty($idUbicacion_lvl_5)){    $error['idUbicacion_lvl_5']     = 'error/No ha seleccionado el nivel 5';}break;
			case 'idCliente':           if(empty($idCliente)){            $error['idCliente']             = 'error/No ha seleccionado el cliente';}break;

			case 'idUtilizable':        if(empty($idUtilizable)){         $error['idUtilizable']          = 'error/No ha seleccionado si es utilizable';}break;
			case 'Marca':               if(!isset($Marca)){               $error['Marca']                 = 'error/No ha ingresado la marca';}break;
			case 'AnoFab':              if(!isset($AnoFab)){              $error['AnoFab']                = 'error/No ha ingresado el año de fabricacion';}break;
			case 'idSubTipo':           if(!isset($idSubTipo)){           $error['idSubTipo']             = 'error/No ha seleccionado el tipo';}break;
			case 'Grasa_inicial':       if(!isset($Grasa_inicial)){       $error['Grasa_inicial']         = 'error/No ha ingresado la grasa inicial';}break;
			case 'Grasa_relubricacion': if(!isset($Grasa_relubricacion)){ $error['Grasa_relubricacion']   = 'error/No ha ingresado la grasa de relubricacion';}break;
			case 'Aceite':              if(!isset($Aceite)){              $error['Aceite']                = 'error/No ha ingresado el aceite';}break;
			case 'Cantidad':            if(!isset($Cantidad)){            $error['Cantidad']              = 'error/No ha ingresado la cantidad';}break;
			case 'idUml':               if(empty($idUml)){                $error['idUml']                 = 'error/No ha seleccionado la unidad de medida';}break;
			case 'Frecuencia':          if(empty($Frecuencia)){           $error['Frecuencia']            = 'error/No ha ingresado la frecuencia';}break;
			case 'idFrecuencia':        if(empty($idFrecuencia)){         $error['idFrecuencia']          = 'error/No ha seleccionado la frecuencia';}break;
			case 'idProducto':          if(empty($idProducto)){           $error['idProducto']            = 'error/No ha seleccionado el producto';}break;
			case 'Saf':                 if(empty($Saf)){                  $error['Saf']                   = 'error/No ha ingresado el numero Saf';}break;
			case 'Numero':              if(empty($Numero)){               $error['Numero']                = 'error/No ha ingresado el numero';}break;
			case 'lvl':                 if(empty($lvl)){                  $error['lvl']                   = 'error/No ha ingresado el nivel';}break;
			case 'idLicitacion':        if(empty($idLicitacion)){         $error['idLicitacion']          = 'error/No ha seleccionado la licitacion';}break;
			case 'addTrabajo':          if(empty($SIS_dataddTrabajo)){    $error['addTrabajo']            = 'error/No ha seleccionado el trabajo';}break;

			case 'cantPuntos':          if(empty($cantPuntos)){           $error['cantPuntos']            = 'error/No ha ingresado la cantidad de puntos';}break;
			case 'mod':                 if(empty($mod)){                  $error['mod']                   = 'error/No ha ingresado el mod';}break;
			case 'idMatriz':            if(empty($idMatriz)){             $error['idMatriz']              = 'error/No ha ingresado el nombre del punto';}break;
			case 'PuntoNombre':         if(empty($PuntoNombre)){          $error['PuntoNombre']           = 'error/No ha ingresado el nombre del punto';}break;
			case 'PuntoidTipo':         if(empty($PuntoidTipo)){          $error['PuntoidTipo']           = 'error/No ha seleccionado el tipo de punto';}break;
			case 'PuntoMedAceptable':   if(empty($PuntoMedAceptable)){    $error['PuntoMedAceptable']     = 'error/No ha ingresado el valor aceptable';}break;
			case 'PuntoMedAlerta':      if(empty($PuntoMedAlerta)){       $error['PuntoMedAlerta']        = 'error/No ha ingresado el valor de alerta';}break;
			case 'PuntoMedCondenatorio':if(empty($PuntoMedCondenatorio)){ $error['PuntoMedCondenatorio']  = 'error/No ha ingresado el valor condenatorio';}break;
			case 'PuntoUniMed':         if(empty($PuntoUniMed)){          $error['PuntoUniMed']           = 'error/No ha seleccionado la unidad de medida';}break;

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
	if(isset($Codigo) && $Codigo!=''){            $Codigo      = EstandarizarInput($Codigo);}
	if(isset($Nombre) && $Nombre!=''){            $Nombre      = EstandarizarInput($Nombre);}
	if(isset($Modelo) && $Modelo!=''){            $Modelo      = EstandarizarInput($Modelo);}
	if(isset($Serie) && $Serie!=''){              $Serie       = EstandarizarInput($Serie);}
	if(isset($Fabricante) && $Fabricante!=''){    $Fabricante  = EstandarizarInput($Fabricante);}
	if(isset($Descripcion) && $Descripcion!=''){  $Descripcion = EstandarizarInput($Descripcion);}
	if(isset($Marca) && $Marca!=''){              $Marca       = EstandarizarInput($Marca);}
	if(isset($Frecuencia) && $Frecuencia!=''){    $Frecuencia  = EstandarizarInput($Frecuencia);}
	if(isset($Saf) && $Saf!=''){                  $Saf         = EstandarizarInput($Saf);}
	if(isset($Numero) && $Numero!=''){            $Numero      = EstandarizarInput($Numero);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Codigo)&&contar_palabras_censuradas($Codigo)!=0){             $error['Codigo']      = 'error/Edita Codigo, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){             $error['Nombre']      = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Modelo)&&contar_palabras_censuradas($Modelo)!=0){             $error['Modelo']      = 'error/Edita Modelo, contiene palabras no permitidas';}
	if(isset($Serie)&&contar_palabras_censuradas($Serie)!=0){               $error['Serie']       = 'error/Edita Serie, contiene palabras no permitidas';}
	if(isset($Fabricante)&&contar_palabras_censuradas($Fabricante)!=0){     $error['Fabricante']  = 'error/Edita Fabricante, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){   $error['Descripcion'] = 'error/Edita Descripcion, contiene palabras no permitidas';}
	if(isset($Marca)&&contar_palabras_censuradas($Marca)!=0){               $error['Marca']       = 'error/Edita Marca, contiene palabras no permitidas';}
	if(isset($Frecuencia)&&contar_palabras_censuradas($Frecuencia)!=0){     $error['Frecuencia']  = 'error/Edita Frecuencia, contiene palabras no permitidas';}
	if(isset($Saf)&&contar_palabras_censuradas($Saf)!=0){                   $error['Saf']         = 'error/Edita Saf, contiene palabras no permitidas';}
	if(isset($Numero)&&contar_palabras_censuradas($Numero)!=0){             $error['Numero']      = 'error/Edita Numero, contiene palabras no permitidas';}

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
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la maquina ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                   $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  ="''";}
				if(isset($idEstado) && $idEstado!=''){                     $SIS_data .= ",'".$idEstado."'";               }else{$SIS_data .=",''";}
				if(isset($Codigo) && $Codigo!=''){                         $SIS_data .= ",'".$Codigo."'";                 }else{$SIS_data .=",''";}
				if(isset($Nombre) && $Nombre!=''){                         $SIS_data .= ",'".$Nombre."'";                 }else{$SIS_data .=",''";}
				if(isset($Modelo) && $Modelo!=''){                         $SIS_data .= ",'".$Modelo."'";                 }else{$SIS_data .=",''";}
				if(isset($Serie) && $Serie!=''){                           $SIS_data .= ",'".$Serie."'";                  }else{$SIS_data .=",''";}
				if(isset($Fabricante) && $Fabricante!=''){                 $SIS_data .= ",'".$Fabricante."'";             }else{$SIS_data .=",''";}
				if(isset($fincorporacion) && $fincorporacion!=''){         $SIS_data .= ",'".$fincorporacion."'";         }else{$SIS_data .=",''";}
				if(isset($Descripcion) && $Descripcion!=''){               $SIS_data .= ",'".$Descripcion."'";            }else{$SIS_data .=",''";}
				if(isset($idConfig_1) && $idConfig_1!=''){                 $SIS_data .= ",'".$idConfig_1."'";             }else{$SIS_data .=",''";}
				if(isset($idConfig_2) && $idConfig_2!=''){                 $SIS_data .= ",'".$idConfig_2."'";             }else{$SIS_data .=",''";}
				if(isset($idConfig_3) && $idConfig_3!=''){                 $SIS_data .= ",'".$idConfig_3."'";             }else{$SIS_data .=",''";}
				if(isset($idConfig_4) && $idConfig_4!=''){                 $SIS_data .= ",'".$idConfig_4."'";             }else{$SIS_data .=",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){               $SIS_data .= ",'".$idUbicacion."'";            }else{$SIS_data .=",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){   $SIS_data .= ",'".$idUbicacion_lvl_1."'";      }else{$SIS_data .=",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){   $SIS_data .= ",'".$idUbicacion_lvl_2."'";      }else{$SIS_data .=",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){   $SIS_data .= ",'".$idUbicacion_lvl_3."'";      }else{$SIS_data .=",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){   $SIS_data .= ",'".$idUbicacion_lvl_4."'";      }else{$SIS_data .=",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){   $SIS_data .= ",'".$idUbicacion_lvl_5."'";      }else{$SIS_data .=",''";}
				if(isset($idCliente) && $idCliente!=''){                   $SIS_data .= ",'".$idCliente."'";              }else{$SIS_data .=",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Codigo, Nombre,Modelo, Serie, Fabricante, fincorporacion, Descripcion, idConfig_1,
				idConfig_2, idConfig_3, idConfig_4, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2, idUbicacion_lvl_3, idUbicacion_lvl_4,
				idUbicacion_lvl_5, idCliente';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&id='.simpleEncode($ultimo_id, fecha_actual()).'&created=true' );
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
			if(isset($Nombre)&&isset($idSistema)&&isset($idMaquina)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idMaquina!='".$idMaquina."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la licitacion ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/***********************************************************************/
				//Filtros
				$SIS_data = "idMaquina='".$idMaquina."'";
				if(isset($idSistema) && $idSistema!=''){                  $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($Codigo) && $Codigo!=''){                        $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($Nombre) && $Nombre!=''){                        $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Modelo) && $Modelo!=''){                        $SIS_data .= ",Modelo='".$Modelo."'";}
				if(isset($Serie) && $Serie!=''){                          $SIS_data .= ",Serie='".$Serie."'";}
				if(isset($Fabricante) && $Fabricante!=''){                $SIS_data .= ",Fabricante='".$Fabricante."'";}
				if(isset($idEstado) && $idEstado!=''){                    $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($fincorporacion) && $fincorporacion!=''){        $SIS_data .= ",fincorporacion='".$fincorporacion."'";}
				if(isset($Descripcion) && $Descripcion!=''){              $SIS_data .= ",Descripcion='".$Descripcion."'";}
				if(isset($idConfig_1) && $idConfig_1!=''){                $SIS_data .= ",idConfig_1='".$idConfig_1."'";}
				if(isset($idConfig_2) && $idConfig_2!=''){                $SIS_data .= ",idConfig_2='".$idConfig_2."'";}
				if(isset($idConfig_3) && $idConfig_3!=''){                $SIS_data .= ",idConfig_3='".$idConfig_3."'";}
				if(isset($idConfig_4) && $idConfig_4!=''){                $SIS_data .= ",idConfig_4='".$idConfig_4."'";}
				if(isset($idUbicacion) && $idUbicacion!=''){              $SIS_data .= ",idUbicacion='".$idUbicacion."'";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){  $SIS_data .= ",idUbicacion_lvl_1='".$idUbicacion_lvl_1."'";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){  $SIS_data .= ",idUbicacion_lvl_2='".$idUbicacion_lvl_2."'";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){  $SIS_data .= ",idUbicacion_lvl_3='".$idUbicacion_lvl_3."'";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){  $SIS_data .= ",idUbicacion_lvl_4='".$idUbicacion_lvl_4."'";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){  $SIS_data .= ",idUbicacion_lvl_5='".$idUbicacion_lvl_5."'";}
				if(isset($idCliente) && $idCliente!=''){                  $SIS_data .= ",idCliente='".$idCliente."'";}

				//Verifico si el cliente no es el mismo que el anterior
				if(isset($FakeidCliente)&&isset($idCliente)&&$FakeidCliente!=0&&$idCliente!=0&&$FakeidCliente!=$idCliente){
					//reseteo la ubicacion
					$SIS_data .= ",idUbicacion_lvl_1=''";
					$SIS_data .= ",idUbicacion_lvl_2=''";
					$SIS_data .= ",idUbicacion_lvl_3=''";
					$SIS_data .= ",idUbicacion_lvl_4=''";
					$SIS_data .= ",idUbicacion_lvl_5=''";
				}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
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

				// Se obtiene el nombre del archivo
				$rowData = db_select_data (false, 'Direccion_img, FichaTecnica, HDS', 'maquinas_listado', '', 'idMaquina = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//se borran los datos
				$resultado = db_delete_data (false, 'maquinas_listado', 'idMaquina = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se elimina la imagen
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
				//Se elimina el archivo adjunto
				if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
					try {
						if(!is_writable('upload/'.$rowData['FichaTecnica'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['FichaTecnica']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//Se elimina el archivo adjunto
				if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
					try {
						if(!is_writable('upload/'.$rowData['HDS'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['HDS']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//se borran los datos relacionados
				for ($i = 1; $i <= $nmax; $i++) {
					$resultado = db_delete_data (false, 'maquinas_listado_level_'.$i, 'idMaquina = "'.$_GET['del'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$sufijo = 'maquinas_img_'.$idMaquina.'_';

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
							$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								//redirijo
								header( 'Location: '.$location.'&img_id='.$idMaquina );
								die;

							}
						} else {
							$error['Direccion_img']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']       = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'submit_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["FichaTecnica"]["error"] > 0){
				$error['FichaTecnica'] = 'error/'.uploadPHPError($_FILES["FichaTecnica"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/pdf", "application/octet-stream", "application/x-real", "application/vnd.adobe.xfdf", "application/vnd.fdf", "binary/octet-stream");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'maquinas_file_'.$idMaquina.'_';

				if (in_array($_FILES['FichaTecnica']['type'], $permitidos) && $_FILES['FichaTecnica']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['FichaTecnica']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["FichaTecnica"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "FichaTecnica='".$sufijo.$_FILES['FichaTecnica']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}

						} else {
							$error['FichaTecnica']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['FichaTecnica']       = 'error/El archivo '.$_FILES['FichaTecnica']['name'].' ya existe';
					}
				} else {
					$error['FichaTecnica']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'submit_hds':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if ($_FILES["HDS"]["error"] > 0){
				$error['HDS'] = 'error/'.uploadPHPError($_FILES["HDS"]["error"]);
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/pdf", "application/octet-stream", "application/x-real", "application/vnd.adobe.xfdf", "application/vnd.fdf", "binary/octet-stream");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'maquinas_hds_'.$idMaquina.'_';

				if (in_array($_FILES['HDS']['type'], $permitidos) && $_FILES['HDS']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['HDS']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["HDS"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtro para idSistema
							$SIS_data = "HDS='".$sufijo.$_FILES['HDS']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){

								header( 'Location: '.$location );
								die;

							}
						} else {
							$error['HDS']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['HDS']       = 'error/El archivo '.$_FILES['HDS']['name'].' ya existe';
					}
				} else {
					$error['HDS']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_img':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre de la imagen
			$rowData = db_select_data (false, 'Direccion_img', 'maquinas_listado', '', 'idMaquina = "'.simpleDecode($_GET['del_img'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.simpleDecode($_GET['del_img'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				header( 'Location: '.$location );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'FichaTecnica', 'maquinas_listado', '', 'idMaquina = "'.simpleDecode($_GET['del_file'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "FichaTecnica=''";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.simpleDecode($_GET['del_file'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
					try {
						if(!is_writable('upload/'.$rowData['FichaTecnica'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['FichaTecnica']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'del_hds':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'HDS', 'maquinas_listado', '', 'idMaquina = "'.simpleDecode($_GET['del_hds'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "HDS=''";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.simpleDecode($_GET['del_hds'], fecha_actual()).'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//se elimina el archivo
				if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
					try {
						if(!is_writable('upload/'.$rowData['HDS'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowData['HDS']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}

				//redirijo
				header( 'Location: '.$location );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'insert_item':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Verifico otros datos
			/*******************************************************************/
			//variables
			/*$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($lvl)&&isset($Nombre)&&isset($idMaquina)&&isset($idSistema)&&isset($Codigo)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado_level_', '', "Nombre='".$Nombre."' AND idMaquina='".$idMaquina."' AND idSistema='".$idSistema."' AND Codigo='".$Codigo."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El dato ya existe';}
			/*******************************************************************/

			// si no hay errores ejecuto
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                       $SIS_data = "'".$idSistema."'";               }else{$SIS_data  ="''";}
				if(isset($idMaquina) && $idMaquina!=''){                       $SIS_data .= ",'".$idMaquina."'";             }else{$SIS_data .=",''";}
				if(isset($idUtilizable) && $idUtilizable!=''){                 $SIS_data .= ",'".$idUtilizable."'";          }else{$SIS_data .=",''";}
				if(isset($Codigo) && $Codigo!=''){                             $SIS_data .= ",'".$Codigo."'";                }else{$SIS_data .=",''";}
				if(isset($Nombre) && $Nombre!=''){                             $SIS_data .= ",'".$Nombre."'";                }else{$SIS_data .=",''";}
				if(isset($Marca) && $Marca!=''){                               $SIS_data .= ",'".$Marca."'";                 }else{$SIS_data .=",''";}
				if(isset($Modelo) && $Modelo!=''){                             $SIS_data .= ",'".$Modelo."'";                }else{$SIS_data .=",''";}
				if(isset($AnoFab) && $AnoFab!=''){                             $SIS_data .= ",'".$AnoFab."'";                }else{$SIS_data .=",''";}
				if(isset($Serie) && $Serie!=''){                               $SIS_data .= ",'".$Serie."'";                 }else{$SIS_data .=",''";}
				if(isset($Direccion_img) && $Direccion_img!=''){               $SIS_data .= ",'".$Direccion_img."'";         }else{$SIS_data .=",''";}
				if(isset($idSubTipo) && $idSubTipo!=''){                       $SIS_data .= ",'".$idSubTipo."'";             }else{$SIS_data .=",''";}
				if(isset($Grasa_inicial) && $Grasa_inicial!=''){               $SIS_data .= ",'".$Grasa_inicial."'";         }else{$SIS_data .=",''";}
				if(isset($Grasa_relubricacion) && $Grasa_relubricacion!=''){   $SIS_data .= ",'".$Grasa_relubricacion."'";   }else{$SIS_data .=",''";}
				if(isset($Aceite) && $Aceite!=''){                             $SIS_data .= ",'".$Aceite."'";                }else{$SIS_data .=",''";}
				if(isset($Cantidad) && $Cantidad!=''){                         $SIS_data .= ",'".$Cantidad."'";              }else{$SIS_data .=",''";}
				if(isset($idUml) && $idUml!=''){                               $SIS_data .= ",'".$idUml."'";                 }else{$SIS_data .=",''";}
				if(isset($Frecuencia) && $Frecuencia!=''){                     $SIS_data .= ",'".$Frecuencia."'";            }else{$SIS_data .=",''";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){                 $SIS_data .= ",'".$idFrecuencia."'";          }else{$SIS_data .=",''";}
				if(isset($idProducto) && $idProducto!=''){                     $SIS_data .= ",'".$idProducto."'";            }else{$SIS_data .=",''";}
				if(isset($Saf) && $Saf!=''){                                   $SIS_data .= ",'".$Saf."'";                   }else{$SIS_data .=",''";}
				if(isset($Numero) && $Numero!=''){                             $SIS_data .= ",'".$Numero."'";                }else{$SIS_data .=",''";}

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
				$SIS_columns = 'idSistema,idMaquina, idUtilizable, Codigo, Nombre,Marca,
				Modelo, AnoFab, Serie, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion,
				Aceite, Cantidad, idUml, Frecuencia, idFrecuencia,idProducto,Saf , Numero
				'.$xbla;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$lvl, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
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
				//Filtros
				$SIS_data = "idLevel_".$lvl."='".$idLevel[$lvl]."'";
				if(isset($idSistema) && $idSistema!=''){                      $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idMaquina) && $idMaquina!=''){                      $SIS_data .= ",idMaquina='".$idMaquina."'";}
				if(isset($idUtilizable) && $idUtilizable!=''){                $SIS_data .= ",idUtilizable='".$idUtilizable."'";}
				if(isset($Codigo) && $Codigo!=''){                            $SIS_data .= ",Codigo='".$Codigo."'";}
				if(isset($Nombre) && $Nombre!=''){                            $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($Marca) && $Marca!=''){                              $SIS_data .= ",Marca='".$Marca."'";}
				if(isset($Modelo) && $Modelo!=''){                            $SIS_data .= ",Modelo='".$Modelo."'";}
				if(isset($AnoFab) && $AnoFab!=''){                            $SIS_data .= ",AnoFab='".$AnoFab."'";}
				if(isset($Serie) && $Serie!=''){                              $SIS_data .= ",Serie='".$Serie."'";}
				if(isset($Direccion_img) && $Direccion_img!=''){              $SIS_data .= ",Direccion_img='".$Direccion_img."'";}
				if(isset($idSubTipo) && $idSubTipo!=''){                      $SIS_data .= ",idSubTipo='".$idSubTipo."'";}
				if(isset($Grasa_inicial) && $Grasa_inicial!=''){              $SIS_data .= ",Grasa_inicial='".$Grasa_inicial."'";}
				if(isset($Grasa_relubricacion) && $Grasa_relubricacion!=''){  $SIS_data .= ",Grasa_relubricacion='".$Grasa_relubricacion."'";}
				if(isset($Aceite) && $Aceite!=''){                            $SIS_data .= ",Aceite='".$Aceite."'";}
				if(isset($Cantidad) && $Cantidad!=''){                        $SIS_data .= ",Cantidad='".$Cantidad."'";}
				if(isset($idUml) && $idUml!=''){                              $SIS_data .= ",idUml='".$idUml."'";}
				if(isset($Frecuencia) && $Frecuencia!=''){                    $SIS_data .= ",Frecuencia='".$Frecuencia."'";}
				if(isset($idFrecuencia) && $idFrecuencia!=''){                $SIS_data .= ",idFrecuencia='".$idFrecuencia."'";}
				if(isset($idProducto) && $idProducto!=''){                    $SIS_data .= ",idProducto='".$idProducto."'";}
				if(isset($Saf) && $Saf!=''){                                  $SIS_data .= ",Saf='".$Saf."'";}
				if(isset($Numero) && $Numero!=''){                            $SIS_data .= ",Numero='".$Numero."'";}
				if(isset($idUml) && $idUml!=''){                              $SIS_data .= ",idUml='".$idUml."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'maquinas_listado_level_'.$lvl, 'idLevel_'.$lvl.' = "'.$idLevel[$lvl].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
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

					// Se obtiene el nombre del archivo
					$rowData = db_select_data (false, 'Direccion_img', 'maquinas_listado_level_'.$i, '', 'idLevel_'.$_GET['lvl'].' = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//se borran los datos
					$resultado = db_delete_data (false, 'maquinas_listado_level_'.$i, 'idLevel_'.$_GET['lvl'].' = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se elimina la imagen
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

			$idMaquina  = simpleDecode($_GET['id'], fecha_actual());
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'add_trabajo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				if(isset($idLevel[1])&&$idLevel[1]!=''){   $xx = $idLevel[1];  $level=1; }
				if(isset($idLevel[2])&&$idLevel[2]!=''){   $xx = $idLevel[2];  $level=2; }
				if(isset($idLevel[3])&&$idLevel[3]!=''){   $xx = $idLevel[3];  $level=3; }
				if(isset($idLevel[4])&&$idLevel[4]!=''){   $xx = $idLevel[4];  $level=4; }
				if(isset($idLevel[5])&&$idLevel[5]!=''){   $xx = $idLevel[5];  $level=5; }
				if(isset($idLevel[6])&&$idLevel[6]!=''){   $xx = $idLevel[6];  $level=6; }
				if(isset($idLevel[7])&&$idLevel[7]!=''){   $xx = $idLevel[7];  $level=7; }
				if(isset($idLevel[8])&&$idLevel[8]!=''){   $xx = $idLevel[8];  $level=8; }
				if(isset($idLevel[9])&&$idLevel[9]!=''){   $xx = $idLevel[9];  $level=9; }
				if(isset($idLevel[10])&&$idLevel[10]!=''){ $xx = $idLevel[10]; $level=10; }
				if(isset($idLevel[11])&&$idLevel[11]!=''){ $xx = $idLevel[11]; $level=11; }
				if(isset($idLevel[12])&&$idLevel[12]!=''){ $xx = $idLevel[12]; $level=12; }
				if(isset($idLevel[13])&&$idLevel[13]!=''){ $xx = $idLevel[13]; $level=13; }
				if(isset($idLevel[14])&&$idLevel[14]!=''){ $xx = $idLevel[14]; $level=14; }
				if(isset($idLevel[15])&&$idLevel[15]!=''){ $xx = $idLevel[15]; $level=15; }
				if(isset($idLevel[16])&&$idLevel[16]!=''){ $xx = $idLevel[16]; $level=16; }
				if(isset($idLevel[17])&&$idLevel[17]!=''){ $xx = $idLevel[17]; $level=17; }
				if(isset($idLevel[18])&&$idLevel[18]!=''){ $xx = $idLevel[18]; $level=18; }
				if(isset($idLevel[19])&&$idLevel[19]!=''){ $xx = $idLevel[19]; $level=19; }
				if(isset($idLevel[20])&&$idLevel[20]!=''){ $xx = $idLevel[20]; $level=20; }
				if(isset($idLevel[21])&&$idLevel[21]!=''){ $xx = $idLevel[21]; $level=21; }
				if(isset($idLevel[22])&&$idLevel[22]!=''){ $xx = $idLevel[22]; $level=22; }
				if(isset($idLevel[23])&&$idLevel[23]!=''){ $xx = $idLevel[23]; $level=23; }
				if(isset($idLevel[24])&&$idLevel[24]!=''){ $xx = $idLevel[24]; $level=24; }
				if(isset($idLevel[25])&&$idLevel[25]!=''){ $xx = $idLevel[25]; $level=25; }

				//Filtros
				$SIS_data = "idLevel_".$lvl."='".$SIS_dataddTrabajo."'";
				if(isset($idLicitacion) && $idLicitacion!=''){   $SIS_data .= ",idLicitacion='".$idLicitacion."'";}
				if(isset($level) && $level!=''){                 $SIS_data .= ",tabla='".$level."'";}
				if(isset($xx) && $xx!=''){                       $SIS_data .= ",table_value='".$xx."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'maquinas_listado_level_'.$lvl, 'idLevel_'.$lvl.' = "'.$SIS_dataddTrabajo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&view=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'insert_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idMaquina)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado_matriz', '', "Nombre='".$Nombre."' AND idMaquina='".$idMaquina."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idMaquina) && $idMaquina!=''){       $SIS_data  = "'".$idMaquina."'";      }else{$SIS_data ="''";}
				if(isset($Nombre) && $Nombre!=''){             $SIS_data .= ",'".$Nombre."'";        }else{$SIS_data .=",''";}
				if(isset($cantPuntos) && $cantPuntos!=''){     $SIS_data .= ",'".$cantPuntos."'";    }else{$SIS_data .=",''";}
				if(isset($idEstado) && $idEstado!=''){         $SIS_data .= ",'".$idEstado."'";      }else{$SIS_data .=",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idMaquina, Nombre,cantPuntos, idEstado';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&idMatriz='.$ultimo_id.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'update_matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			if(empty($error)){

				//Filtros
				$SIS_data = "idMatriz='".$idMatriz."'";
				if(isset($Nombre) && $Nombre!=''){                              $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($cantPuntos) && $cantPuntos!=''){                      $SIS_data .= ",cantPuntos='".$cantPuntos."'";}
				if(isset($PuntoNombre) && $PuntoNombre!=''){                    $SIS_data .= ",PuntoNombre_".$mod."='".$PuntoNombre."'";}
				if(isset($PuntoidTipo) && $PuntoidTipo!=''){                    $SIS_data .= ",PuntoidTipo_".$mod."='".$PuntoidTipo."'";}
				if(isset($PuntoMedAceptable) && $PuntoMedAceptable!=''){        $SIS_data .= ",PuntoMedAceptable_".$mod."='".$PuntoMedAceptable."'";}
				if(isset($PuntoMedAlerta) && $PuntoMedAlerta!=''){              $SIS_data .= ",PuntoMedAlerta_".$mod."='".$PuntoMedAlerta."'";}
				if(isset($PuntoMedCondenatorio) && $PuntoMedCondenatorio!=''){  $SIS_data .= ",PuntoMedCondenatorio_".$mod."='".$PuntoMedCondenatorio."'";}
				if(isset($PuntoUniMed) && $PuntoUniMed!=''){                    $SIS_data .= ",PuntoUniMed_".$mod."='".$PuntoUniMed."'";}
				if(isset($PuntoidGrupo) && $PuntoidGrupo!=''){                  $SIS_data .= ",PuntoidGrupo_".$mod."='".$PuntoidGrupo."'";}
				if(isset($idEstado) && $idEstado!=''){                          $SIS_data .= ",idEstado".$mod."='".$idEstado."'";}

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'maquinas_listado_matriz', 'idMatriz = "'.$idMatriz.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_matriz':

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
				$resultado = db_delete_data (false, 'maquinas_listado_matriz', 'idMatriz = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
		case 'clone_Maquina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//obtengo los datos de la maquina previamente seleccionada
			$rowData = db_select_data (false, 'idSistema', 'maquinas_listado', '', 'idMaquina ='.$idMaquina, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($rowData['idSistema'])){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$rowData['idSistema']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la maquina ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$rowData = db_select_data (false, 'idSistema, Codigo, Modelo, Serie, Fabricante, fincorporacion, Descripcion, idConfig_1, idConfig_2, idConfig_3, idConfig_4, idCliente', 'maquinas_listado', '', 'idMaquina ='.$idMaquina, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Se crea la maquina
				$SIS_data  = "'".$rowData['idSistema']."'";
				$SIS_data .= ",'2'";                        //inactivo hasta editar
				$SIS_data .= ",'".$rowData['Codigo']."'";
				$SIS_data .= ",'".$Nombre."'";
				$SIS_data .= ",'".$rowData['Modelo']."'";
				$SIS_data .= ",'".$rowData['Serie']."'";
				$SIS_data .= ",'".$rowData['Fabricante']."'";
				$SIS_data .= ",'".$rowData['fincorporacion']."'";
				$SIS_data .= ",'".$rowData['Descripcion']."'";
				$SIS_data .= ",'".$rowData['idConfig_1']."'";
				$SIS_data .= ",'".$rowData['idConfig_2']."'";
				$SIS_data .= ",'".$rowData['idConfig_3']."'";
				$SIS_data .= ",'".$rowData['idConfig_4']."'";
				$SIS_data .= ",'".$rowData['idCliente']."'";

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Codigo, Nombre,Modelo,
				Serie, Fabricante, fincorporacion, Descripcion, idConfig_1,
				idConfig_2, idConfig_3, idConfig_4,idCliente';
				$maquina_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				$arrLVL_1 = array();
				$arrLVL_1 = db_select_array (false, 'idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_1', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_2 = array();
				$arrLVL_2 = db_select_array (false, 'idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_2', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_3 = array();
				$arrLVL_3 = db_select_array (false, 'idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_3', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_4 = array();
				$arrLVL_4 = db_select_array (false, 'idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_4', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_5 = array();
				$arrLVL_5 = db_select_array (false, 'idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_5', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_6 = array();
				$arrLVL_6 = db_select_array (false, 'idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_6', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_7 = array();
				$arrLVL_7 = db_select_array (false, 'idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_7', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_8 = array();
				$arrLVL_8 = db_select_array (false, 'idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_8', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_9 = array();
				$arrLVL_9 = db_select_array (false, 'idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_9', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_10 = array();
				$arrLVL_10 = db_select_array (false, 'idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_10', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_11 = array();
				$arrLVL_11 = db_select_array (false, 'idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_11', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_12 = array();
				$arrLVL_12 = db_select_array (false, 'idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_12', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_13 = array();
				$arrLVL_13 = db_select_array (false, 'idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_13', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_14 = array();
				$arrLVL_14 = db_select_array (false, 'idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_14', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_15 = array();
				$arrLVL_15 = db_select_array (false, 'idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_15', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				/*$arrLVL_16 = array();
				$arrLVL_16 = db_select_array (false, 'idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_16', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_17 = array();
				$arrLVL_17 = db_select_array (false, 'idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_17', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_18 = array();
				$arrLVL_18 = db_select_array (false, 'idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_18', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_19 = array();
				$arrLVL_19 = db_select_array (false, 'idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_19', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_20 = array();
				$arrLVL_20 = db_select_array (false, 'idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_20', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_21 = array();
				$arrLVL_21 = db_select_array (false, 'idLevel_21, idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_21', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_22 = array();
				$arrLVL_22 = db_select_array (false, 'idLevel_22, idLevel_21, idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_22', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_23 = array();
				$arrLVL_23 = db_select_array (false, 'idLevel_23, idLevel_22, idLevel_21, idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_23', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_24 = array();
				$arrLVL_24 = db_select_array (false, 'idLevel_24, idLevel_23, idLevel_22, idLevel_21, idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_24', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$arrLVL_25 = array();
				$arrLVL_25 = db_select_array (false, 'idLevel_25, idLevel_24, idLevel_23, idLevel_22, idLevel_21, idLevel_20,idLevel_19, idLevel_18, idLevel_17, idLevel_16, idLevel_15, idLevel_14, idLevel_13, idLevel_12, idLevel_11, idLevel_10, idLevel_9, idLevel_8, idLevel_7, idLevel_6, idLevel_5, idLevel_4, idLevel_3, idLevel_2, idLevel_1, idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero', 'maquinas_listado_level_25', '', 'idMaquina = '.$idMaquina, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/

				foreach ($arrLVL_1 as $lvl_1) {

					//Se crea la maquina
					$SIS_data  = "'".$lvl_1['idSistema']."'";
					$SIS_data .= ",'".$maquina_id."'";
					$SIS_data .= ",'".$lvl_1['idUtilizable']."'";
					$SIS_data .= ",'".$lvl_1['Codigo']."'";
					$SIS_data .= ",'".$lvl_1['Nombre']."'";
					$SIS_data .= ",'".$lvl_1['Marca']."'";
					$SIS_data .= ",'".$lvl_1['Modelo']."'";
					$SIS_data .= ",'".$lvl_1['AnoFab']."'";
					$SIS_data .= ",'".$lvl_1['Serie']."'";
					$SIS_data .= ",'".$lvl_1['idLicitacion']."'";
					$SIS_data .= ",'".$lvl_1['tabla']."'";
					$SIS_data .= ",'".$lvl_1['table_value']."'";
					$SIS_data .= ",'".$lvl_1['Direccion_img']."'";
					$SIS_data .= ",'".$lvl_1['idSubTipo']."'";
					$SIS_data .= ",'".$lvl_1['Grasa_inicial']."'";
					$SIS_data .= ",'".$lvl_1['Grasa_relubricacion']."'";
					$SIS_data .= ",'".$lvl_1['Aceite']."'";
					$SIS_data .= ",'".$lvl_1['Cantidad']."'";
					$SIS_data .= ",'".$lvl_1['idUml']."'";
					$SIS_data .= ",'".$lvl_1['Frecuencia']."'";
					$SIS_data .= ",'".$lvl_1['idFrecuencia']."'";
					$SIS_data .= ",'".$lvl_1['idProducto']."'";
					$SIS_data .= ",'".$lvl_1['Saf']."'";
					$SIS_data .= ",'".$lvl_1['Numero']."'";

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema, idMaquina, idUtilizable,
					Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
					Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
					idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
					$id_lvl_1 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Nivel 2
					foreach ($arrLVL_2 as $lvl_2) {
						//Se verifica que sea el mismo sensor
						if($lvl_1['idLevel_1']==$lvl_2['idLevel_1']){

							//Se crea la maquina
							$SIS_data  = "'".$id_lvl_1."'";
							$SIS_data .= ",'".$lvl_2['idSistema']."'";
							$SIS_data .= ",'".$maquina_id."'";
							$SIS_data .= ",'".$lvl_2['idUtilizable']."'";
							$SIS_data .= ",'".$lvl_2['Codigo']."'";
							$SIS_data .= ",'".$lvl_2['Nombre']."'";
							$SIS_data .= ",'".$lvl_2['Marca']."'";
							$SIS_data .= ",'".$lvl_2['Modelo']."'";
							$SIS_data .= ",'".$lvl_2['AnoFab']."'";
							$SIS_data .= ",'".$lvl_2['Serie']."'";
							$SIS_data .= ",'".$lvl_2['idLicitacion']."'";
							$SIS_data .= ",'".$lvl_2['tabla']."'";
							$SIS_data .= ",'".$lvl_2['table_value']."'";
							$SIS_data .= ",'".$lvl_2['Direccion_img']."'";
							$SIS_data .= ",'".$lvl_2['idSubTipo']."'";
							$SIS_data .= ",'".$lvl_2['Grasa_inicial']."'";
							$SIS_data .= ",'".$lvl_2['Grasa_relubricacion']."'";
							$SIS_data .= ",'".$lvl_2['Aceite']."'";
							$SIS_data .= ",'".$lvl_2['Cantidad']."'";
							$SIS_data .= ",'".$lvl_2['idUml']."'";
							$SIS_data .= ",'".$lvl_2['Frecuencia']."'";
							$SIS_data .= ",'".$lvl_2['idFrecuencia']."'";
							$SIS_data .= ",'".$lvl_2['idProducto']."'";
							$SIS_data .= ",'".$lvl_2['Saf']."'";
							$SIS_data .= ",'".$lvl_2['Numero']."'";

							// inserto los datos de registro en la db
							$SIS_columns = 'idLevel_1, idSistema, idMaquina, idUtilizable,
							Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
							Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
							idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
							$id_lvl_2 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_2', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							//Nivel 3
							foreach ($arrLVL_3 as $lvl_3) {
								//Se verifica que sea el mismo sensor
								if($lvl_2['idLevel_2']==$lvl_3['idLevel_2']){

									//Se crea la maquina
									$SIS_data  = "'".$id_lvl_2."'";
									$SIS_data .= ",'".$id_lvl_1."'";
									$SIS_data .= ",'".$lvl_3['idSistema']."'";
									$SIS_data .= ",'".$maquina_id."'";
									$SIS_data .= ",'".$lvl_3['idUtilizable']."'";
									$SIS_data .= ",'".$lvl_3['Codigo']."'";
									$SIS_data .= ",'".$lvl_3['Nombre']."'";
									$SIS_data .= ",'".$lvl_3['Marca']."'";
									$SIS_data .= ",'".$lvl_3['Modelo']."'";
									$SIS_data .= ",'".$lvl_3['AnoFab']."'";
									$SIS_data .= ",'".$lvl_3['Serie']."'";
									$SIS_data .= ",'".$lvl_3['idLicitacion']."'";
									$SIS_data .= ",'".$lvl_3['tabla']."'";
									$SIS_data .= ",'".$lvl_3['table_value']."'";
									$SIS_data .= ",'".$lvl_3['Direccion_img']."'";
									$SIS_data .= ",'".$lvl_3['idSubTipo']."'";
									$SIS_data .= ",'".$lvl_3['Grasa_inicial']."'";
									$SIS_data .= ",'".$lvl_3['Grasa_relubricacion']."'";
									$SIS_data .= ",'".$lvl_3['Aceite']."'";
									$SIS_data .= ",'".$lvl_3['Cantidad']."'";
									$SIS_data .= ",'".$lvl_3['idUml']."'";
									$SIS_data .= ",'".$lvl_3['Frecuencia']."'";
									$SIS_data .= ",'".$lvl_3['idFrecuencia']."'";
									$SIS_data .= ",'".$lvl_3['idProducto']."'";
									$SIS_data .= ",'".$lvl_3['Saf']."'";
									$SIS_data .= ",'".$lvl_3['Numero']."'";

									// inserto los datos de registro en la db
									$SIS_columns = 'idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
									Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
									Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
									idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
									$id_lvl_3 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_3', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

									//Nivel 4
									foreach ($arrLVL_4 as $lvl_4) {
										//Se verifica que sea el mismo sensor
										if($lvl_3['idLevel_3']==$lvl_4['idLevel_3']){

											//Se crea la maquina
											$SIS_data  = "'".$id_lvl_3."'";
											$SIS_data .= ",'".$id_lvl_2."'";
											$SIS_data .= ",'".$id_lvl_1."'";
											$SIS_data .= ",'".$lvl_4['idSistema']."'";
											$SIS_data .= ",'".$maquina_id."'";
											$SIS_data .= ",'".$lvl_4['idUtilizable']."'";
											$SIS_data .= ",'".$lvl_4['Codigo']."'";
											$SIS_data .= ",'".$lvl_4['Nombre']."'";
											$SIS_data .= ",'".$lvl_4['Marca']."'";
											$SIS_data .= ",'".$lvl_4['Modelo']."'";
											$SIS_data .= ",'".$lvl_4['AnoFab']."'";
											$SIS_data .= ",'".$lvl_4['Serie']."'";
											$SIS_data .= ",'".$lvl_4['idLicitacion']."'";
											$SIS_data .= ",'".$lvl_4['tabla']."'";
											$SIS_data .= ",'".$lvl_4['table_value']."'";
											$SIS_data .= ",'".$lvl_4['Direccion_img']."'";
											$SIS_data .= ",'".$lvl_4['idSubTipo']."'";
											$SIS_data .= ",'".$lvl_4['Grasa_inicial']."'";
											$SIS_data .= ",'".$lvl_4['Grasa_relubricacion']."'";
											$SIS_data .= ",'".$lvl_4['Aceite']."'";
											$SIS_data .= ",'".$lvl_4['Cantidad']."'";
											$SIS_data .= ",'".$lvl_4['idUml']."'";
											$SIS_data .= ",'".$lvl_4['Frecuencia']."'";
											$SIS_data .= ",'".$lvl_4['idFrecuencia']."'";
											$SIS_data .= ",'".$lvl_4['idProducto']."'";
											$SIS_data .= ",'".$lvl_4['Saf']."'";
											$SIS_data .= ",'".$lvl_4['Numero']."'";

											// inserto los datos de registro en la db
											$SIS_columns = 'idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
											Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
											Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
											idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
											$id_lvl_4 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_4', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

											//Nivel 5
											foreach ($arrLVL_5 as $lvl_5) {
												//Se verifica que sea el mismo sensor
												if($lvl_4['idLevel_4']==$lvl_5['idLevel_4']){

													//Se crea la maquina
													$SIS_data  = "'".$id_lvl_4."'";
													$SIS_data .= ",'".$id_lvl_3."'";
													$SIS_data .= ",'".$id_lvl_2."'";
													$SIS_data .= ",'".$id_lvl_1."'";
													$SIS_data .= ",'".$lvl_5['idSistema']."'";
													$SIS_data .= ",'".$maquina_id."'";
													$SIS_data .= ",'".$lvl_5['idUtilizable']."'";
													$SIS_data .= ",'".$lvl_5['Codigo']."'";
													$SIS_data .= ",'".$lvl_5['Nombre']."'";
													$SIS_data .= ",'".$lvl_5['Marca']."'";
													$SIS_data .= ",'".$lvl_5['Modelo']."'";
													$SIS_data .= ",'".$lvl_5['AnoFab']."'";
													$SIS_data .= ",'".$lvl_5['Serie']."'";
													$SIS_data .= ",'".$lvl_5['idLicitacion']."'";
													$SIS_data .= ",'".$lvl_5['tabla']."'";
													$SIS_data .= ",'".$lvl_5['table_value']."'";
													$SIS_data .= ",'".$lvl_5['Direccion_img']."'";
													$SIS_data .= ",'".$lvl_5['idSubTipo']."'";
													$SIS_data .= ",'".$lvl_5['Grasa_inicial']."'";
													$SIS_data .= ",'".$lvl_5['Grasa_relubricacion']."'";
													$SIS_data .= ",'".$lvl_5['Aceite']."'";
													$SIS_data .= ",'".$lvl_5['Cantidad']."'";
													$SIS_data .= ",'".$lvl_5['idUml']."'";
													$SIS_data .= ",'".$lvl_5['Frecuencia']."'";
													$SIS_data .= ",'".$lvl_5['idFrecuencia']."'";
													$SIS_data .= ",'".$lvl_5['idProducto']."'";
													$SIS_data .= ",'".$lvl_5['Saf']."'";
													$SIS_data .= ",'".$lvl_5['Numero']."'";

													// inserto los datos de registro en la db
													$SIS_columns = 'idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
													Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
													Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
													idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
													$id_lvl_5 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_5', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

													//Nivel 6
													foreach ($arrLVL_6 as $lvl_6) {
														//Se verifica que sea el mismo sensor
														if($lvl_5['idLevel_5']==$lvl_6['idLevel_5']){

															//Se crea la maquina
															$SIS_data  = "'".$id_lvl_5."'";
															$SIS_data .= ",'".$id_lvl_4."'";
															$SIS_data .= ",'".$id_lvl_3."'";
															$SIS_data .= ",'".$id_lvl_2."'";
															$SIS_data .= ",'".$id_lvl_1."'";
															$SIS_data .= ",'".$lvl_6['idSistema']."'";
															$SIS_data .= ",'".$maquina_id."'";
															$SIS_data .= ",'".$lvl_6['idUtilizable']."'";
															$SIS_data .= ",'".$lvl_6['Codigo']."'";
															$SIS_data .= ",'".$lvl_6['Nombre']."'";
															$SIS_data .= ",'".$lvl_6['Marca']."'";
															$SIS_data .= ",'".$lvl_6['Modelo']."'";
															$SIS_data .= ",'".$lvl_6['AnoFab']."'";
															$SIS_data .= ",'".$lvl_6['Serie']."'";
															$SIS_data .= ",'".$lvl_6['idLicitacion']."'";
															$SIS_data .= ",'".$lvl_6['tabla']."'";
															$SIS_data .= ",'".$lvl_6['table_value']."'";
															$SIS_data .= ",'".$lvl_6['Direccion_img']."'";
															$SIS_data .= ",'".$lvl_6['idSubTipo']."'";
															$SIS_data .= ",'".$lvl_6['Grasa_inicial']."'";
															$SIS_data .= ",'".$lvl_6['Grasa_relubricacion']."'";
															$SIS_data .= ",'".$lvl_6['Aceite']."'";
															$SIS_data .= ",'".$lvl_6['Cantidad']."'";
															$SIS_data .= ",'".$lvl_6['idUml']."'";
															$SIS_data .= ",'".$lvl_6['Frecuencia']."'";
															$SIS_data .= ",'".$lvl_6['idFrecuencia']."'";
															$SIS_data .= ",'".$lvl_6['idProducto']."'";
															$SIS_data .= ",'".$lvl_6['Saf']."'";
															$SIS_data .= ",'".$lvl_6['Numero']."'";

															// inserto los datos de registro en la db
															$SIS_columns = 'idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
															Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
															Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
															idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
															$id_lvl_6 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_6', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

															//Nivel 7
															foreach ($arrLVL_7 as $lvl_7) {
																//Se verifica que sea el mismo sensor
																if($lvl_6['idLevel_6']==$lvl_7['idLevel_6']){

																	//Se crea la maquina
																	$SIS_data  = "'".$id_lvl_6."'";
																	$SIS_data .= ",'".$id_lvl_5."'";
																	$SIS_data .= ",'".$id_lvl_4."'";
																	$SIS_data .= ",'".$id_lvl_3."'";
																	$SIS_data .= ",'".$id_lvl_2."'";
																	$SIS_data .= ",'".$id_lvl_1."'";
																	$SIS_data .= ",'".$lvl_7['idSistema']."'";
																	$SIS_data .= ",'".$maquina_id."'";
																	$SIS_data .= ",'".$lvl_7['idUtilizable']."'";
																	$SIS_data .= ",'".$lvl_7['Codigo']."'";
																	$SIS_data .= ",'".$lvl_7['Nombre']."'";
																	$SIS_data .= ",'".$lvl_7['Marca']."'";
																	$SIS_data .= ",'".$lvl_7['Modelo']."'";
																	$SIS_data .= ",'".$lvl_7['AnoFab']."'";
																	$SIS_data .= ",'".$lvl_7['Serie']."'";
																	$SIS_data .= ",'".$lvl_7['idLicitacion']."'";
																	$SIS_data .= ",'".$lvl_7['tabla']."'";
																	$SIS_data .= ",'".$lvl_7['table_value']."'";
																	$SIS_data .= ",'".$lvl_7['Direccion_img']."'";
																	$SIS_data .= ",'".$lvl_7['idSubTipo']."'";
																	$SIS_data .= ",'".$lvl_7['Grasa_inicial']."'";
																	$SIS_data .= ",'".$lvl_7['Grasa_relubricacion']."'";
																	$SIS_data .= ",'".$lvl_7['Aceite']."'";
																	$SIS_data .= ",'".$lvl_7['Cantidad']."'";
																	$SIS_data .= ",'".$lvl_7['idUml']."'";
																	$SIS_data .= ",'".$lvl_7['Frecuencia']."'";
																	$SIS_data .= ",'".$lvl_7['idFrecuencia']."'";
																	$SIS_data .= ",'".$lvl_7['idProducto']."'";
																	$SIS_data .= ",'".$lvl_7['Saf']."'";
																	$SIS_data .= ",'".$lvl_7['Numero']."'";

																	// inserto los datos de registro en la db
																	$SIS_columns = 'idLevel_6,
																	idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																	Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																	Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																	idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																	$id_lvl_7 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_7', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																	//Nivel 8
																	foreach ($arrLVL_8 as $lvl_8) {
																		//Se verifica que sea el mismo sensor
																		if($lvl_7['idLevel_7']==$lvl_8['idLevel_7']){

																			//Se crea la maquina
																			$SIS_data  = "'".$id_lvl_7."'";
																			$SIS_data .= ",'".$id_lvl_6."'";
																			$SIS_data .= ",'".$id_lvl_5."'";
																			$SIS_data .= ",'".$id_lvl_4."'";
																			$SIS_data .= ",'".$id_lvl_3."'";
																			$SIS_data .= ",'".$id_lvl_2."'";
																			$SIS_data .= ",'".$id_lvl_1."'";
																			$SIS_data .= ",'".$lvl_8['idSistema']."'";
																			$SIS_data .= ",'".$maquina_id."'";
																			$SIS_data .= ",'".$lvl_8['idUtilizable']."'";
																			$SIS_data .= ",'".$lvl_8['Codigo']."'";
																			$SIS_data .= ",'".$lvl_8['Nombre']."'";
																			$SIS_data .= ",'".$lvl_8['Marca']."'";
																			$SIS_data .= ",'".$lvl_8['Modelo']."'";
																			$SIS_data .= ",'".$lvl_8['AnoFab']."'";
																			$SIS_data .= ",'".$lvl_8['Serie']."'";
																			$SIS_data .= ",'".$lvl_8['idLicitacion']."'";
																			$SIS_data .= ",'".$lvl_8['tabla']."'";
																			$SIS_data .= ",'".$lvl_8['table_value']."'";
																			$SIS_data .= ",'".$lvl_8['Direccion_img']."'";
																			$SIS_data .= ",'".$lvl_8['idSubTipo']."'";
																			$SIS_data .= ",'".$lvl_8['Grasa_inicial']."'";
																			$SIS_data .= ",'".$lvl_8['Grasa_relubricacion']."'";
																			$SIS_data .= ",'".$lvl_8['Aceite']."'";
																			$SIS_data .= ",'".$lvl_8['Cantidad']."'";
																			$SIS_data .= ",'".$lvl_8['idUml']."'";
																			$SIS_data .= ",'".$lvl_8['Frecuencia']."'";
																			$SIS_data .= ",'".$lvl_8['idFrecuencia']."'";
																			$SIS_data .= ",'".$lvl_8['idProducto']."'";
																			$SIS_data .= ",'".$lvl_8['Saf']."'";
																			$SIS_data .= ",'".$lvl_8['Numero']."'";

																			// inserto los datos de registro en la db
																			$SIS_columns = 'idLevel_7,idLevel_6,
																			idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																			Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																			Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																			idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																			$id_lvl_8 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_8', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																			//Nivel 9
																			foreach ($arrLVL_9 as $lvl_9) {
																				//Se verifica que sea el mismo sensor
																				if($lvl_8['idLevel_8']==$lvl_9['idLevel_8']){

																					//Se crea la maquina
																					$SIS_data  = "'".$id_lvl_8."'";
																					$SIS_data .= ",'".$id_lvl_7."'";
																					$SIS_data .= ",'".$id_lvl_6."'";
																					$SIS_data .= ",'".$id_lvl_5."'";
																					$SIS_data .= ",'".$id_lvl_4."'";
																					$SIS_data .= ",'".$id_lvl_3."'";
																					$SIS_data .= ",'".$id_lvl_2."'";
																					$SIS_data .= ",'".$id_lvl_1."'";
																					$SIS_data .= ",'".$lvl_9['idSistema']."'";
																					$SIS_data .= ",'".$maquina_id."'";
																					$SIS_data .= ",'".$lvl_9['idUtilizable']."'";
																					$SIS_data .= ",'".$lvl_9['Codigo']."'";
																					$SIS_data .= ",'".$lvl_9['Nombre']."'";
																					$SIS_data .= ",'".$lvl_9['Marca']."'";
																					$SIS_data .= ",'".$lvl_9['Modelo']."'";
																					$SIS_data .= ",'".$lvl_9['AnoFab']."'";
																					$SIS_data .= ",'".$lvl_9['Serie']."'";
																					$SIS_data .= ",'".$lvl_9['idLicitacion']."'";
																					$SIS_data .= ",'".$lvl_9['tabla']."'";
																					$SIS_data .= ",'".$lvl_9['table_value']."'";
																					$SIS_data .= ",'".$lvl_9['Direccion_img']."'";
																					$SIS_data .= ",'".$lvl_9['idSubTipo']."'";
																					$SIS_data .= ",'".$lvl_9['Grasa_inicial']."'";
																					$SIS_data .= ",'".$lvl_9['Grasa_relubricacion']."'";
																					$SIS_data .= ",'".$lvl_9['Aceite']."'";
																					$SIS_data .= ",'".$lvl_9['Cantidad']."'";
																					$SIS_data .= ",'".$lvl_9['idUml']."'";
																					$SIS_data .= ",'".$lvl_9['Frecuencia']."'";
																					$SIS_data .= ",'".$lvl_9['idFrecuencia']."'";
																					$SIS_data .= ",'".$lvl_9['idProducto']."'";
																					$SIS_data .= ",'".$lvl_9['Saf']."'";
																					$SIS_data .= ",'".$lvl_9['Numero']."'";

																					// inserto los datos de registro en la db
																					$SIS_columns = 'idLevel_8,idLevel_7,idLevel_6,
																					idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																					Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																					Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																					idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																					$id_lvl_9 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_9', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																					//Nivel 10
																					foreach ($arrLVL_10 as $lvl_10) {
																						//Se verifica que sea el mismo sensor
																						if($lvl_9['idLevel_9']==$lvl_10['idLevel_9']){

																							//Se crea la maquina
																							$SIS_data  = "'".$id_lvl_9."'";
																							$SIS_data .= ",'".$id_lvl_8."'";
																							$SIS_data .= ",'".$id_lvl_7."'";
																							$SIS_data .= ",'".$id_lvl_6."'";
																							$SIS_data .= ",'".$id_lvl_5."'";
																							$SIS_data .= ",'".$id_lvl_4."'";
																							$SIS_data .= ",'".$id_lvl_3."'";
																							$SIS_data .= ",'".$id_lvl_2."'";
																							$SIS_data .= ",'".$id_lvl_1."'";
																							$SIS_data .= ",'".$lvl_10['idSistema']."'";
																							$SIS_data .= ",'".$maquina_id."'";
																							$SIS_data .= ",'".$lvl_10['idUtilizable']."'";
																							$SIS_data .= ",'".$lvl_10['Codigo']."'";
																							$SIS_data .= ",'".$lvl_10['Nombre']."'";
																							$SIS_data .= ",'".$lvl_10['Marca']."'";
																							$SIS_data .= ",'".$lvl_10['Modelo']."'";
																							$SIS_data .= ",'".$lvl_10['AnoFab']."'";
																							$SIS_data .= ",'".$lvl_10['Serie']."'";
																							$SIS_data .= ",'".$lvl_10['idLicitacion']."'";
																							$SIS_data .= ",'".$lvl_10['tabla']."'";
																							$SIS_data .= ",'".$lvl_10['table_value']."'";
																							$SIS_data .= ",'".$lvl_10['Direccion_img']."'";
																							$SIS_data .= ",'".$lvl_10['idSubTipo']."'";
																							$SIS_data .= ",'".$lvl_10['Grasa_inicial']."'";
																							$SIS_data .= ",'".$lvl_10['Grasa_relubricacion']."'";
																							$SIS_data .= ",'".$lvl_10['Aceite']."'";
																							$SIS_data .= ",'".$lvl_10['Cantidad']."'";
																							$SIS_data .= ",'".$lvl_10['idUml']."'";
																							$SIS_data .= ",'".$lvl_10['Frecuencia']."'";
																							$SIS_data .= ",'".$lvl_10['idFrecuencia']."'";
																							$SIS_data .= ",'".$lvl_10['idProducto']."'";
																							$SIS_data .= ",'".$lvl_10['Saf']."'";
																							$SIS_data .= ",'".$lvl_10['Numero']."'";

																							// inserto los datos de registro en la db
																							$SIS_columns = 'idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																							idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																							Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																							Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																							idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																							$id_lvl_10 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_10', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																							//Nivel 11
																							foreach ($arrLVL_11 as $lvl_11) {
																								//Se verifica que sea el mismo sensor
																								if($lvl_10['idLevel_10']==$lvl_11['idLevel_10']){

																									//Se crea la maquina
																									$SIS_data  = "'".$id_lvl_10."'";
																									$SIS_data .= ",'".$id_lvl_9."'";
																									$SIS_data .= ",'".$id_lvl_8."'";
																									$SIS_data .= ",'".$id_lvl_7."'";
																									$SIS_data .= ",'".$id_lvl_6."'";
																									$SIS_data .= ",'".$id_lvl_5."'";
																									$SIS_data .= ",'".$id_lvl_4."'";
																									$SIS_data .= ",'".$id_lvl_3."'";
																									$SIS_data .= ",'".$id_lvl_2."'";
																									$SIS_data .= ",'".$id_lvl_1."'";
																									$SIS_data .= ",'".$lvl_11['idSistema']."'";
																									$SIS_data .= ",'".$maquina_id."'";
																									$SIS_data .= ",'".$lvl_11['idUtilizable']."'";
																									$SIS_data .= ",'".$lvl_11['Codigo']."'";
																									$SIS_data .= ",'".$lvl_11['Nombre']."'";
																									$SIS_data .= ",'".$lvl_11['Marca']."'";
																									$SIS_data .= ",'".$lvl_11['Modelo']."'";
																									$SIS_data .= ",'".$lvl_11['AnoFab']."'";
																									$SIS_data .= ",'".$lvl_11['Serie']."'";
																									$SIS_data .= ",'".$lvl_11['idLicitacion']."'";
																									$SIS_data .= ",'".$lvl_11['tabla']."'";
																									$SIS_data .= ",'".$lvl_11['table_value']."'";
																									$SIS_data .= ",'".$lvl_11['Direccion_img']."'";
																									$SIS_data .= ",'".$lvl_11['idSubTipo']."'";
																									$SIS_data .= ",'".$lvl_11['Grasa_inicial']."'";
																									$SIS_data .= ",'".$lvl_11['Grasa_relubricacion']."'";
																									$SIS_data .= ",'".$lvl_11['Aceite']."'";
																									$SIS_data .= ",'".$lvl_11['Cantidad']."'";
																									$SIS_data .= ",'".$lvl_11['idUml']."'";
																									$SIS_data .= ",'".$lvl_11['Frecuencia']."'";
																									$SIS_data .= ",'".$lvl_11['idFrecuencia']."'";
																									$SIS_data .= ",'".$lvl_11['idProducto']."'";
																									$SIS_data .= ",'".$lvl_11['Saf']."'";
																									$SIS_data .= ",'".$lvl_11['Numero']."'";

																									// inserto los datos de registro en la db
																									$SIS_columns = 'idLevel_10,idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																									idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																									Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																									Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																									idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																									$id_lvl_11 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_11', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																									//Nivel 12
																									foreach ($arrLVL_12 as $lvl_12) {
																										//Se verifica que sea el mismo sensor
																										if($lvl_11['idLevel_11']==$lvl_12['idLevel_11']){

																											//Se crea la maquina
																											$SIS_data  = "'".$id_lvl_11."'";
																											$SIS_data .= ",'".$id_lvl_10."'";
																											$SIS_data .= ",'".$id_lvl_9."'";
																											$SIS_data .= ",'".$id_lvl_8."'";
																											$SIS_data .= ",'".$id_lvl_7."'";
																											$SIS_data .= ",'".$id_lvl_6."'";
																											$SIS_data .= ",'".$id_lvl_5."'";
																											$SIS_data .= ",'".$id_lvl_4."'";
																											$SIS_data .= ",'".$id_lvl_3."'";
																											$SIS_data .= ",'".$id_lvl_2."'";
																											$SIS_data .= ",'".$id_lvl_1."'";
																											$SIS_data .= ",'".$lvl_12['idSistema']."'";
																											$SIS_data .= ",'".$maquina_id."'";
																											$SIS_data .= ",'".$lvl_12['idUtilizable']."'";
																											$SIS_data .= ",'".$lvl_12['Codigo']."'";
																											$SIS_data .= ",'".$lvl_12['Nombre']."'";
																											$SIS_data .= ",'".$lvl_12['Marca']."'";
																											$SIS_data .= ",'".$lvl_12['Modelo']."'";
																											$SIS_data .= ",'".$lvl_12['AnoFab']."'";
																											$SIS_data .= ",'".$lvl_12['Serie']."'";
																											$SIS_data .= ",'".$lvl_12['idLicitacion']."'";
																											$SIS_data .= ",'".$lvl_12['tabla']."'";
																											$SIS_data .= ",'".$lvl_12['table_value']."'";
																											$SIS_data .= ",'".$lvl_12['Direccion_img']."'";
																											$SIS_data .= ",'".$lvl_12['idSubTipo']."'";
																											$SIS_data .= ",'".$lvl_12['Grasa_inicial']."'";
																											$SIS_data .= ",'".$lvl_12['Grasa_relubricacion']."'";
																											$SIS_data .= ",'".$lvl_12['Aceite']."'";
																											$SIS_data .= ",'".$lvl_12['Cantidad']."'";
																											$SIS_data .= ",'".$lvl_12['idUml']."'";
																											$SIS_data .= ",'".$lvl_12['Frecuencia']."'";
																											$SIS_data .= ",'".$lvl_12['idFrecuencia']."'";
																											$SIS_data .= ",'".$lvl_12['idProducto']."'";
																											$SIS_data .= ",'".$lvl_12['Saf']."'";
																											$SIS_data .= ",'".$lvl_12['Numero']."'";

																											// inserto los datos de registro en la db
																											$SIS_columns = 'idLevel_11,idLevel_10,idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																											idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																											Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																											Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																											idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																											$id_lvl_12 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_12', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																											//Nivel 13
																											foreach ($arrLVL_13 as $lvl_13) {
																												//Se verifica que sea el mismo sensor
																												if($lvl_12['idLevel_12']==$lvl_13['idLevel_12']){

																													//Se crea la maquina
																													$SIS_data  = "'".$id_lvl_12."'";
																													$SIS_data .= ",'".$id_lvl_11."'";
																													$SIS_data .= ",'".$id_lvl_10."'";
																													$SIS_data .= ",'".$id_lvl_9."'";
																													$SIS_data .= ",'".$id_lvl_8."'";
																													$SIS_data .= ",'".$id_lvl_7."'";
																													$SIS_data .= ",'".$id_lvl_6."'";
																													$SIS_data .= ",'".$id_lvl_5."'";
																													$SIS_data .= ",'".$id_lvl_4."'";
																													$SIS_data .= ",'".$id_lvl_3."'";
																													$SIS_data .= ",'".$id_lvl_2."'";
																													$SIS_data .= ",'".$id_lvl_1."'";
																													$SIS_data .= ",'".$lvl_13['idSistema']."'";
																													$SIS_data .= ",'".$maquina_id."'";
																													$SIS_data .= ",'".$lvl_13['idUtilizable']."'";
																													$SIS_data .= ",'".$lvl_13['Codigo']."'";
																													$SIS_data .= ",'".$lvl_13['Nombre']."'";
																													$SIS_data .= ",'".$lvl_13['Marca']."'";
																													$SIS_data .= ",'".$lvl_13['Modelo']."'";
																													$SIS_data .= ",'".$lvl_13['AnoFab']."'";
																													$SIS_data .= ",'".$lvl_13['Serie']."'";
																													$SIS_data .= ",'".$lvl_13['idLicitacion']."'";
																													$SIS_data .= ",'".$lvl_13['tabla']."'";
																													$SIS_data .= ",'".$lvl_13['table_value']."'";
																													$SIS_data .= ",'".$lvl_13['Direccion_img']."'";
																													$SIS_data .= ",'".$lvl_13['idSubTipo']."'";
																													$SIS_data .= ",'".$lvl_13['Grasa_inicial']."'";
																													$SIS_data .= ",'".$lvl_13['Grasa_relubricacion']."'";
																													$SIS_data .= ",'".$lvl_13['Aceite']."'";
																													$SIS_data .= ",'".$lvl_13['Cantidad']."'";
																													$SIS_data .= ",'".$lvl_13['idUml']."'";
																													$SIS_data .= ",'".$lvl_13['Frecuencia']."'";
																													$SIS_data .= ",'".$lvl_13['idFrecuencia']."'";
																													$SIS_data .= ",'".$lvl_13['idProducto']."'";
																													$SIS_data .= ",'".$lvl_13['Saf']."'";
																													$SIS_data .= ",'".$lvl_13['Numero']."'";

																													// inserto los datos de registro en la db
																													$SIS_columns = 'idLevel_12,idLevel_11,idLevel_10,idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																													idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																													Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																													Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																													idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																													$id_lvl_13 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_13', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																													//Nivel 14
																													foreach ($arrLVL_14 as $lvl_14) {
																														//Se verifica que sea el mismo sensor
																														if($lvl_13['idLevel_13']==$lvl_14['idLevel_13']){

																															//Se crea la maquina
																															$SIS_data  = "'".$id_lvl_13."'";
																															$SIS_data .= ",'".$id_lvl_12."'";
																															$SIS_data .= ",'".$id_lvl_11."'";
																															$SIS_data .= ",'".$id_lvl_10."'";
																															$SIS_data .= ",'".$id_lvl_9."'";
																															$SIS_data .= ",'".$id_lvl_8."'";
																															$SIS_data .= ",'".$id_lvl_7."'";
																															$SIS_data .= ",'".$id_lvl_6."'";
																															$SIS_data .= ",'".$id_lvl_5."'";
																															$SIS_data .= ",'".$id_lvl_4."'";
																															$SIS_data .= ",'".$id_lvl_3."'";
																															$SIS_data .= ",'".$id_lvl_2."'";
																															$SIS_data .= ",'".$id_lvl_1."'";
																															$SIS_data .= ",'".$lvl_14['idSistema']."'";
																															$SIS_data .= ",'".$maquina_id."'";
																															$SIS_data .= ",'".$lvl_14['idUtilizable']."'";
																															$SIS_data .= ",'".$lvl_14['Codigo']."'";
																															$SIS_data .= ",'".$lvl_14['Nombre']."'";
																															$SIS_data .= ",'".$lvl_14['Marca']."'";
																															$SIS_data .= ",'".$lvl_14['Modelo']."'";
																															$SIS_data .= ",'".$lvl_14['AnoFab']."'";
																															$SIS_data .= ",'".$lvl_14['Serie']."'";
																															$SIS_data .= ",'".$lvl_14['idLicitacion']."'";
																															$SIS_data .= ",'".$lvl_14['tabla']."'";
																															$SIS_data .= ",'".$lvl_14['table_value']."'";
																															$SIS_data .= ",'".$lvl_14['Direccion_img']."'";
																															$SIS_data .= ",'".$lvl_14['idSubTipo']."'";
																															$SIS_data .= ",'".$lvl_14['Grasa_inicial']."'";
																															$SIS_data .= ",'".$lvl_14['Grasa_relubricacion']."'";
																															$SIS_data .= ",'".$lvl_14['Aceite']."'";
																															$SIS_data .= ",'".$lvl_14['Cantidad']."'";
																															$SIS_data .= ",'".$lvl_14['idUml']."'";
																															$SIS_data .= ",'".$lvl_14['Frecuencia']."'";
																															$SIS_data .= ",'".$lvl_14['idFrecuencia']."'";
																															$SIS_data .= ",'".$lvl_14['idProducto']."'";
																															$SIS_data .= ",'".$lvl_14['Saf']."'";
																															$SIS_data .= ",'".$lvl_14['Numero']."'";

																															// inserto los datos de registro en la db
																															$SIS_columns = 'idLevel_13,idLevel_12,idLevel_11,idLevel_10,idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																															idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																															Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																															Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																															idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																															$id_lvl_14 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_14', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																															//Nivel 15
																															foreach ($arrLVL_15 as $lvl_15) {
																																//Se verifica que sea el mismo sensor
																																if($lvl_14['idLevel_14']==$lvl_15['idLevel_14']){

																																	//Se crea la maquina
																																	$SIS_data  = "'".$id_lvl_14."'";
																																	$SIS_data .= ",'".$id_lvl_13."'";
																																	$SIS_data .= ",'".$id_lvl_12."'";
																																	$SIS_data .= ",'".$id_lvl_11."'";
																																	$SIS_data .= ",'".$id_lvl_10."'";
																																	$SIS_data .= ",'".$id_lvl_9."'";
																																	$SIS_data .= ",'".$id_lvl_8."'";
																																	$SIS_data .= ",'".$id_lvl_7."'";
																																	$SIS_data .= ",'".$id_lvl_6."'";
																																	$SIS_data .= ",'".$id_lvl_5."'";
																																	$SIS_data .= ",'".$id_lvl_4."'";
																																	$SIS_data .= ",'".$id_lvl_3."'";
																																	$SIS_data .= ",'".$id_lvl_2."'";
																																	$SIS_data .= ",'".$id_lvl_1."'";
																																	$SIS_data .= ",'".$lvl_15['idSistema']."'";
																																	$SIS_data .= ",'".$maquina_id."'";
																																	$SIS_data .= ",'".$lvl_15['idUtilizable']."'";
																																	$SIS_data .= ",'".$lvl_15['Codigo']."'";
																																	$SIS_data .= ",'".$lvl_15['Nombre']."'";
																																	$SIS_data .= ",'".$lvl_15['Marca']."'";
																																	$SIS_data .= ",'".$lvl_15['Modelo']."'";
																																	$SIS_data .= ",'".$lvl_15['AnoFab']."'";
																																	$SIS_data .= ",'".$lvl_15['Serie']."'";
																																	$SIS_data .= ",'".$lvl_15['idLicitacion']."'";
																																	$SIS_data .= ",'".$lvl_15['tabla']."'";
																																	$SIS_data .= ",'".$lvl_15['table_value']."'";
																																	$SIS_data .= ",'".$lvl_15['Direccion_img']."'";
																																	$SIS_data .= ",'".$lvl_15['idSubTipo']."'";
																																	$SIS_data .= ",'".$lvl_15['Grasa_inicial']."'";
																																	$SIS_data .= ",'".$lvl_15['Grasa_relubricacion']."'";
																																	$SIS_data .= ",'".$lvl_15['Aceite']."'";
																																	$SIS_data .= ",'".$lvl_15['Cantidad']."'";
																																	$SIS_data .= ",'".$lvl_15['idUml']."'";
																																	$SIS_data .= ",'".$lvl_15['Frecuencia']."'";
																																	$SIS_data .= ",'".$lvl_15['idFrecuencia']."'";
																																	$SIS_data .= ",'".$lvl_15['idProducto']."'";
																																	$SIS_data .= ",'".$lvl_15['Saf']."'";
																																	$SIS_data .= ",'".$lvl_15['Numero']."'";

																																	// inserto los datos de registro en la db
																																	$SIS_columns = 'idLevel_14,
																																	idLevel_13,idLevel_12,idLevel_11,idLevel_10,idLevel_9,idLevel_8,idLevel_7,idLevel_6,
																																	idLevel_5,idLevel_4,idLevel_3,idLevel_2, idLevel_1, idSistema, idMaquina, idUtilizable,
																																	Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																	Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																	idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero';
																																	$id_lvl_15 = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_15', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																}
																															}
																														}
																													}
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
				header( 'Location: '.$location.'&clone=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
		case 'clone_component':

			$idLevel  = $_GET['clone_compo'];
			$lvl      = $_GET['lvl'];

			if(isset($_GET['lv_1'])&&$_GET['lv_1']!=''){  $lv_1     = $_GET['lv_1'];  }else{$lv_1 = 0;}
			if(isset($_GET['lv_2'])&&$_GET['lv_2']!=''){  $lv_2     = $_GET['lv_2'];  }else{$lv_2 = 0;}
			if(isset($_GET['lv_3'])&&$_GET['lv_3']!=''){  $lv_3     = $_GET['lv_3'];  }else{$lv_3 = 0;}
			if(isset($_GET['lv_4'])&&$_GET['lv_4']!=''){  $lv_4     = $_GET['lv_4'];  }else{$lv_4 = 0;}
			if(isset($_GET['lv_5'])&&$_GET['lv_5']!=''){  $lv_5     = $_GET['lv_5'];  }else{$lv_5 = 0;}
			if(isset($_GET['lv_6'])&&$_GET['lv_6']!=''){  $lv_6     = $_GET['lv_6'];  }else{$lv_6 = 0;}
			if(isset($_GET['lv_7'])&&$_GET['lv_7']!=''){  $lv_7     = $_GET['lv_7'];  }else{$lv_7 = 0;}
			if(isset($_GET['lv_8'])&&$_GET['lv_8']!=''){  $lv_8     = $_GET['lv_8'];  }else{$lv_8 = 0;}
			if(isset($_GET['lv_9'])&&$_GET['lv_9']!=''){  $lv_9     = $_GET['lv_9'];  }else{$lv_9 = 0;}
			if(isset($_GET['lv_10'])&&$_GET['lv_10']!=''){$lv_10    = $_GET['lv_10'];}else{$lv_10 = 0;}
			if(isset($_GET['lv_11'])&&$_GET['lv_11']!=''){$lv_11    = $_GET['lv_11'];}else{$lv_11 = 0;}
			if(isset($_GET['lv_12'])&&$_GET['lv_12']!=''){$lv_12    = $_GET['lv_12'];}else{$lv_12 = 0;}
			if(isset($_GET['lv_13'])&&$_GET['lv_13']!=''){$lv_13    = $_GET['lv_13'];}else{$lv_13 = 0;}
			if(isset($_GET['lv_14'])&&$_GET['lv_14']!=''){$lv_14    = $_GET['lv_14'];}else{$lv_14 = 0;}
			if(isset($_GET['lv_15'])&&$_GET['lv_15']!=''){$lv_15    = $_GET['lv_15'];}else{$lv_15 = 0;}
			if(isset($_GET['lv_16'])&&$_GET['lv_16']!=''){$lv_16    = $_GET['lv_16'];}else{$lv_16 = 0;}
			if(isset($_GET['lv_17'])&&$_GET['lv_17']!=''){$lv_17    = $_GET['lv_17'];}else{$lv_17 = 0;}
			if(isset($_GET['lv_18'])&&$_GET['lv_18']!=''){$lv_18    = $_GET['lv_18'];}else{$lv_18 = 0;}
			if(isset($_GET['lv_19'])&&$_GET['lv_19']!=''){$lv_19    = $_GET['lv_19'];}else{$lv_19 = 0;}
			if(isset($_GET['lv_20'])&&$_GET['lv_20']!=''){$lv_20    = $_GET['lv_20'];}else{$lv_20 = 0;}
			if(isset($_GET['lv_21'])&&$_GET['lv_21']!=''){$lv_21    = $_GET['lv_21'];}else{$lv_21 = 0;}
			if(isset($_GET['lv_22'])&&$_GET['lv_22']!=''){$lv_22    = $_GET['lv_22'];}else{$lv_22 = 0;}
			if(isset($_GET['lv_23'])&&$_GET['lv_23']!=''){$lv_23    = $_GET['lv_23'];}else{$lv_23 = 0;}
			if(isset($_GET['lv_24'])&&$_GET['lv_24']!=''){$lv_24    = $_GET['lv_24'];}else{$lv_24 = 0;}
			if(isset($_GET['lv_25'])&&$_GET['lv_25']!=''){$lv_25    = $_GET['lv_25'];}else{$lv_25 = 0;}

			/*******************************************************************/
			//Creo todas las consultas hasta el final del arbol
			for ($i = $lvl; $i <= 15; $i++) {
				//creo cadena con los idLevel
				$cadena = '';
				for ($x = $i; $x >= 1; $x--) {
					$cadena .= ',idLevel_'.$x;
				}
				$arrLVL[$i] = array();
				$arrLVL[$i] = db_select_array (false, 'idSistema, idUtilizable, Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value, Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad, idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero, idMaquina '.$cadena, 'maquinas_listado_level_'.$i, '', 'idLevel_'.$lvl.' = '.$idLevel, 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			}

			/*******************************************************************/
			//Variables
			$id_lvl = array();
			//Arreglos
			$dis_1  = $lvl;
			$dis_2  = $lvl + 1;
			$dis_3  = $lvl + 2;
			$dis_4  = $lvl + 3;
			$dis_5  = $lvl + 4;
			$dis_6  = $lvl + 5;
			$dis_7  = $lvl + 6;
			$dis_8  = $lvl + 7;
			$dis_9  = $lvl + 8;
			$dis_10 = $lvl + 9;
			$dis_11 = $lvl + 10;
			$dis_12 = $lvl + 11;
			$dis_13 = $lvl + 12;
			$dis_14 = $lvl + 13;
			$dis_15 = $lvl + 14;
			$dis_16 = $lvl + 15;
			$dis_17 = $lvl + 16;
			$dis_18 = $lvl + 17;
			$dis_19 = $lvl + 18;
			$dis_20 = $lvl + 19;
			$dis_21 = $lvl + 20;
			$dis_22 = $lvl + 21;
			$dis_23 = $lvl + 22;
			$dis_24 = $lvl + 23;
			$dis_25 = $lvl + 24;

			//Consultas
			/********************************************/
			if(isset($arrLVL[$dis_1])){
				foreach ($arrLVL[$dis_1] as $arreglo_1) {

					//Se crea la maquina
					$SIS_data  = "'".$arreglo_1['idSistema']."'";
					$SIS_data .= ",'".$arreglo_1['idMaquina']."'";
					$SIS_data .= ",'".$arreglo_1['idUtilizable']."'";
					$SIS_data .= ",'".$arreglo_1['Codigo']."'";
					$SIS_data .= ",'".$arreglo_1['Nombre']." (Nuevo)'";
					$SIS_data .= ",'".$arreglo_1['Marca']."'";
					$SIS_data .= ",'".$arreglo_1['Modelo']."'";
					$SIS_data .= ",'".$arreglo_1['AnoFab']."'";
					$SIS_data .= ",'".$arreglo_1['Serie']."'";
					$SIS_data .= ",'".$arreglo_1['idLicitacion']."'";
					$SIS_data .= ",'".$arreglo_1['tabla']."'";
					$SIS_data .= ",'".$arreglo_1['table_value']."'";
					$SIS_data .= ",'".$arreglo_1['Direccion_img']."'";
					$SIS_data .= ",'".$arreglo_1['idSubTipo']."'";
					$SIS_data .= ",'".$arreglo_1['Grasa_inicial']."'";
					$SIS_data .= ",'".$arreglo_1['Grasa_relubricacion']."'";
					$SIS_data .= ",'".$arreglo_1['Aceite']."'";
					$SIS_data .= ",'".$arreglo_1['Cantidad']."'";
					$SIS_data .= ",'".$arreglo_1['idUml']."'";
					$SIS_data .= ",'".$arreglo_1['Frecuencia']."'";
					$SIS_data .= ",'".$arreglo_1['idFrecuencia']."'";
					$SIS_data .= ",'".$arreglo_1['idProducto']."'";
					$SIS_data .= ",'".$arreglo_1['Saf']."'";
					$SIS_data .= ",'".$arreglo_1['Numero']."'";

					$cadena = '';
					$x = 1;
					if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}
					if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_1['idLevel_'.$x]."'";$x++;}

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema, idMaquina, idUtilizable,
					Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
					Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
					idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
					$id_lvl[$dis_1] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/////////////////////////////////////////////////
					if(isset($arrLVL[$dis_2])){
						foreach ($arrLVL[$dis_2] as $arreglo_2) {
							//Se verifica que sea el mismo sensor
							if($arreglo_1['idLevel_'.$dis_1]==$arreglo_2['idLevel_'.$dis_1]){

								//Se crea la maquina
								$SIS_data  = "'".$arreglo_2['idSistema']."'";
								$SIS_data .= ",'".$arreglo_2['idMaquina']."'";
								$SIS_data .= ",'".$arreglo_2['idUtilizable']."'";
								$SIS_data .= ",'".$arreglo_2['Codigo']."'";
								$SIS_data .= ",'".$arreglo_2['Nombre']."'";
								$SIS_data .= ",'".$arreglo_2['Marca']."'";
								$SIS_data .= ",'".$arreglo_2['Modelo']."'";
								$SIS_data .= ",'".$arreglo_2['AnoFab']."'";
								$SIS_data .= ",'".$arreglo_2['Serie']."'";
								$SIS_data .= ",'".$arreglo_2['idLicitacion']."'";
								$SIS_data .= ",'".$arreglo_2['tabla']."'";
								$SIS_data .= ",'".$arreglo_2['table_value']."'";
								$SIS_data .= ",'".$arreglo_2['Direccion_img']."'";
								$SIS_data .= ",'".$arreglo_2['idSubTipo']."'";
								$SIS_data .= ",'".$arreglo_2['Grasa_inicial']."'";
								$SIS_data .= ",'".$arreglo_2['Grasa_relubricacion']."'";
								$SIS_data .= ",'".$arreglo_2['Aceite']."'";
								$SIS_data .= ",'".$arreglo_2['Cantidad']."'";
								$SIS_data .= ",'".$arreglo_2['idUml']."'";
								$SIS_data .= ",'".$arreglo_2['Frecuencia']."'";
								$SIS_data .= ",'".$arreglo_2['idFrecuencia']."'";
								$SIS_data .= ",'".$arreglo_2['idProducto']."'";
								$SIS_data .= ",'".$arreglo_2['Saf']."'";
								$SIS_data .= ",'".$arreglo_2['Numero']."'";

								$cadena = '';
								$x = 1;
								if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}
								if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_2['idLevel_'.$x]."'";$x++;}

								$x = 1;
								if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
								if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
								if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
								if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
								if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
								if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
								if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
								if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
								if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
								if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
								if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
								if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
								if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
								if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
								if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
								if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
								if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
								if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
								if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
								if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
								if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
								if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
								if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
								if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
								if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

								// inserto los datos de registro en la db
								$SIS_columns = 'idSistema, idMaquina, idUtilizable,
								Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
								Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
								idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
								$id_lvl[$dis_2] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								/////////////////////////////////////////////////
								if(isset($arrLVL[$dis_3])){
									foreach ($arrLVL[$dis_3] as $arreglo_3) {
										//Se verifica que sea el mismo sensor
										if($arreglo_2['idLevel_'.$dis_2]==$arreglo_3['idLevel_'.$dis_2]){

											//Se crea la maquina
											$SIS_data  = "'".$arreglo_3['idSistema']."'";
											$SIS_data .= ",'".$arreglo_3['idMaquina']."'";
											$SIS_data .= ",'".$arreglo_3['idUtilizable']."'";
											$SIS_data .= ",'".$arreglo_3['Codigo']."'";
											$SIS_data .= ",'".$arreglo_3['Nombre']."'";
											$SIS_data .= ",'".$arreglo_3['Marca']."'";
											$SIS_data .= ",'".$arreglo_3['Modelo']."'";
											$SIS_data .= ",'".$arreglo_3['AnoFab']."'";
											$SIS_data .= ",'".$arreglo_3['Serie']."'";
											$SIS_data .= ",'".$arreglo_3['idLicitacion']."'";
											$SIS_data .= ",'".$arreglo_3['tabla']."'";
											$SIS_data .= ",'".$arreglo_3['table_value']."'";
											$SIS_data .= ",'".$arreglo_3['Direccion_img']."'";
											$SIS_data .= ",'".$arreglo_3['idSubTipo']."'";
											$SIS_data .= ",'".$arreglo_3['Grasa_inicial']."'";
											$SIS_data .= ",'".$arreglo_3['Grasa_relubricacion']."'";
											$SIS_data .= ",'".$arreglo_3['Aceite']."'";
											$SIS_data .= ",'".$arreglo_3['Cantidad']."'";
											$SIS_data .= ",'".$arreglo_3['idUml']."'";
											$SIS_data .= ",'".$arreglo_3['Frecuencia']."'";
											$SIS_data .= ",'".$arreglo_3['idFrecuencia']."'";
											$SIS_data .= ",'".$arreglo_3['idProducto']."'";
											$SIS_data .= ",'".$arreglo_3['Saf']."'";
											$SIS_data .= ",'".$arreglo_3['Numero']."'";

											$cadena = '';
											$x = 1;
											if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}
											if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_3['idLevel_'.$x]."'";$x++;}

											$x = 1;
											if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
											if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
											if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
											if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
											if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
											if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
											if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
											if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
											if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
											if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
											if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
											if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
											if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
											if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
											if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
											if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
											if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
											if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
											if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
											if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
											if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
											if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
											if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
											if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
											if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

											// inserto los datos de registro en la db
											$SIS_columns = 'idSistema, idMaquina, idUtilizable,
											Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
											Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
											idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
											$id_lvl[$dis_3] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_3, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

											/////////////////////////////////////////////////
											if(isset($arrLVL[$dis_4])){
												foreach ($arrLVL[$dis_4] as $arreglo_4) {
													//Se verifica que sea el mismo sensor
													if($arreglo_3['idLevel_'.$dis_3]==$arreglo_4['idLevel_'.$dis_3]){

														//Se crea la maquina
														$SIS_data  = "'".$arreglo_4['idSistema']."'";
														$SIS_data .= ",'".$arreglo_4['idMaquina']."'";
														$SIS_data .= ",'".$arreglo_4['idUtilizable']."'";
														$SIS_data .= ",'".$arreglo_4['Codigo']."'";
														$SIS_data .= ",'".$arreglo_4['Nombre']."'";
														$SIS_data .= ",'".$arreglo_4['Marca']."'";
														$SIS_data .= ",'".$arreglo_4['Modelo']."'";
														$SIS_data .= ",'".$arreglo_4['AnoFab']."'";
														$SIS_data .= ",'".$arreglo_4['Serie']."'";
														$SIS_data .= ",'".$arreglo_4['idLicitacion']."'";
														$SIS_data .= ",'".$arreglo_4['tabla']."'";
														$SIS_data .= ",'".$arreglo_4['table_value']."'";
														$SIS_data .= ",'".$arreglo_4['Direccion_img']."'";
														$SIS_data .= ",'".$arreglo_4['idSubTipo']."'";
														$SIS_data .= ",'".$arreglo_4['Grasa_inicial']."'";
														$SIS_data .= ",'".$arreglo_4['Grasa_relubricacion']."'";
														$SIS_data .= ",'".$arreglo_4['Aceite']."'";
														$SIS_data .= ",'".$arreglo_4['Cantidad']."'";
														$SIS_data .= ",'".$arreglo_4['idUml']."'";
														$SIS_data .= ",'".$arreglo_4['Frecuencia']."'";
														$SIS_data .= ",'".$arreglo_4['idFrecuencia']."'";
														$SIS_data .= ",'".$arreglo_4['idProducto']."'";
														$SIS_data .= ",'".$arreglo_4['Saf']."'";
														$SIS_data .= ",'".$arreglo_4['Numero']."'";

														$cadena = '';
														$x = 1;
														if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}
														if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_4['idLevel_'.$x]."'";$x++;}

														$x = 1;
														if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
														if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
														if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
														if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
														if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
														if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
														if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
														if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
														if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
														if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
														if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
														if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
														if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
														if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
														if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
														if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
														if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
														if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
														if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
														if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
														if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
														if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
														if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
														if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
														if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

														// inserto los datos de registro en la db
														$SIS_columns = 'idSistema, idMaquina, idUtilizable,
														Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
														Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
														idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
														$id_lvl[$dis_4] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_4, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

														/////////////////////////////////////////////////
														if(isset($arrLVL[$dis_5])){
															foreach ($arrLVL[$dis_5] as $arreglo_5) {
																//Se verifica que sea el mismo sensor
																if($arreglo_4['idLevel_'.$dis_4]==$arreglo_5['idLevel_'.$dis_4]){

																	//Se crea la maquina
																	$SIS_data  = "'".$arreglo_5['idSistema']."'";
																	$SIS_data .= ",'".$arreglo_5['idMaquina']."'";
																	$SIS_data .= ",'".$arreglo_5['idUtilizable']."'";
																	$SIS_data .= ",'".$arreglo_5['Codigo']."'";
																	$SIS_data .= ",'".$arreglo_5['Nombre']."'";
																	$SIS_data .= ",'".$arreglo_5['Marca']."'";
																	$SIS_data .= ",'".$arreglo_5['Modelo']."'";
																	$SIS_data .= ",'".$arreglo_5['AnoFab']."'";
																	$SIS_data .= ",'".$arreglo_5['Serie']."'";
																	$SIS_data .= ",'".$arreglo_5['idLicitacion']."'";
																	$SIS_data .= ",'".$arreglo_5['tabla']."'";
																	$SIS_data .= ",'".$arreglo_5['table_value']."'";
																	$SIS_data .= ",'".$arreglo_5['Direccion_img']."'";
																	$SIS_data .= ",'".$arreglo_5['idSubTipo']."'";
																	$SIS_data .= ",'".$arreglo_5['Grasa_inicial']."'";
																	$SIS_data .= ",'".$arreglo_5['Grasa_relubricacion']."'";
																	$SIS_data .= ",'".$arreglo_5['Aceite']."'";
																	$SIS_data .= ",'".$arreglo_5['Cantidad']."'";
																	$SIS_data .= ",'".$arreglo_5['idUml']."'";
																	$SIS_data .= ",'".$arreglo_5['Frecuencia']."'";
																	$SIS_data .= ",'".$arreglo_5['idFrecuencia']."'";
																	$SIS_data .= ",'".$arreglo_5['idProducto']."'";
																	$SIS_data .= ",'".$arreglo_5['Saf']."'";
																	$SIS_data .= ",'".$arreglo_5['Numero']."'";

																	$cadena = '';
																	$x = 1;
																	if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}
																	if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_5['idLevel_'.$x]."'";$x++;}

																	$x = 1;
																	if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																	if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																	if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																	if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																	if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																	if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																	if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																	if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																	if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																	if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																	if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																	if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																	if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																	if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																	if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																	if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																	if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																	if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																	if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																	if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																	if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																	if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																	if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																	if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																	if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																	// inserto los datos de registro en la db
																	$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																	Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																	Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																	idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																	$id_lvl[$dis_5] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_5, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																	/////////////////////////////////////////////////
																	if(isset($arrLVL[$dis_6])){
																		foreach ($arrLVL[$dis_6] as $arreglo_6) {
																			//Se verifica que sea el mismo sensor
																			if($arreglo_5['idLevel_'.$dis_5]==$arreglo_6['idLevel_'.$dis_5]){

																				//Se crea la maquina
																				$SIS_data  = "'".$arreglo_6['idSistema']."'";
																				$SIS_data .= ",'".$arreglo_6['idMaquina']."'";
																				$SIS_data .= ",'".$arreglo_6['idUtilizable']."'";
																				$SIS_data .= ",'".$arreglo_6['Codigo']."'";
																				$SIS_data .= ",'".$arreglo_6['Nombre']."'";
																				$SIS_data .= ",'".$arreglo_6['Marca']."'";
																				$SIS_data .= ",'".$arreglo_6['Modelo']."'";
																				$SIS_data .= ",'".$arreglo_6['AnoFab']."'";
																				$SIS_data .= ",'".$arreglo_6['Serie']."'";
																				$SIS_data .= ",'".$arreglo_6['idLicitacion']."'";
																				$SIS_data .= ",'".$arreglo_6['tabla']."'";
																				$SIS_data .= ",'".$arreglo_6['table_value']."'";
																				$SIS_data .= ",'".$arreglo_6['Direccion_img']."'";
																				$SIS_data .= ",'".$arreglo_6['idSubTipo']."'";
																				$SIS_data .= ",'".$arreglo_6['Grasa_inicial']."'";
																				$SIS_data .= ",'".$arreglo_6['Grasa_relubricacion']."'";
																				$SIS_data .= ",'".$arreglo_6['Aceite']."'";
																				$SIS_data .= ",'".$arreglo_6['Cantidad']."'";
																				$SIS_data .= ",'".$arreglo_6['idUml']."'";
																				$SIS_data .= ",'".$arreglo_6['Frecuencia']."'";
																				$SIS_data .= ",'".$arreglo_6['idFrecuencia']."'";
																				$SIS_data .= ",'".$arreglo_6['idProducto']."'";
																				$SIS_data .= ",'".$arreglo_6['Saf']."'";
																				$SIS_data .= ",'".$arreglo_6['Numero']."'";

																				$cadena = '';
																				$x = 1;
																				if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}
																				if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_6['idLevel_'.$x]."'";$x++;}

																				$x = 1;
																				if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																				if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																				if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																				if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																				if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																				if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																				if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																				if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																				if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																				if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																				if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																				if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																				if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																				if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																				if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																				if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																				if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																				if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																				if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																				if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																				if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																				if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																				if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																				if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																				if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																				// inserto los datos de registro en la db
																				$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																				Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																				Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																				idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																				$id_lvl[$dis_6] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_6, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																				/////////////////////////////////////////////////
																				if(isset($arrLVL[$dis_7])){
																					foreach ($arrLVL[$dis_7] as $arreglo_7) {
																						//Se verifica que sea el mismo sensor
																						if($arreglo_6['idLevel_'.$dis_6]==$arreglo_7['idLevel_'.$dis_6]){

																							//Se crea la maquina
																							$SIS_data  = "'".$arreglo_7['idSistema']."'";
																							$SIS_data .= ",'".$arreglo_7['idMaquina']."'";
																							$SIS_data .= ",'".$arreglo_7['idUtilizable']."'";
																							$SIS_data .= ",'".$arreglo_7['Codigo']."'";
																							$SIS_data .= ",'".$arreglo_7['Nombre']."'";
																							$SIS_data .= ",'".$arreglo_7['Marca']."'";
																							$SIS_data .= ",'".$arreglo_7['Modelo']."'";
																							$SIS_data .= ",'".$arreglo_7['AnoFab']."'";
																							$SIS_data .= ",'".$arreglo_7['Serie']."'";
																							$SIS_data .= ",'".$arreglo_7['idLicitacion']."'";
																							$SIS_data .= ",'".$arreglo_7['tabla']."'";
																							$SIS_data .= ",'".$arreglo_7['table_value']."'";
																							$SIS_data .= ",'".$arreglo_7['Direccion_img']."'";
																							$SIS_data .= ",'".$arreglo_7['idSubTipo']."'";
																							$SIS_data .= ",'".$arreglo_7['Grasa_inicial']."'";
																							$SIS_data .= ",'".$arreglo_7['Grasa_relubricacion']."'";
																							$SIS_data .= ",'".$arreglo_7['Aceite']."'";
																							$SIS_data .= ",'".$arreglo_7['Cantidad']."'";
																							$SIS_data .= ",'".$arreglo_7['idUml']."'";
																							$SIS_data .= ",'".$arreglo_7['Frecuencia']."'";
																							$SIS_data .= ",'".$arreglo_7['idFrecuencia']."'";
																							$SIS_data .= ",'".$arreglo_7['idProducto']."'";
																							$SIS_data .= ",'".$arreglo_7['Saf']."'";
																							$SIS_data .= ",'".$arreglo_7['Numero']."'";

																							$cadena = '';
																							$x = 1;
																							if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}
																							if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_7['idLevel_'.$x]."'";$x++;}

																							$x = 1;
																							if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																							if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																							if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																							if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																							if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																							if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																							if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																							if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																							if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																							if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																							if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																							if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																							if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																							if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																							if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																							if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																							if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																							if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																							if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																							if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																							if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																							if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																							if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																							if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																							if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																							// inserto los datos de registro en la db
																							$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																							Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																							Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																							idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																							$id_lvl[$dis_7] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_7, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																							/////////////////////////////////////////////////
																							if(isset($arrLVL[$dis_8])){
																								foreach ($arrLVL[$dis_8] as $arreglo_8) {
																									//Se verifica que sea el mismo sensor
																									if($arreglo_7['idLevel_'.$dis_7]==$arreglo_8['idLevel_'.$dis_7]){

																										//Se crea la maquina
																										$SIS_data  = "'".$arreglo_8['idSistema']."'";
																										$SIS_data .= ",'".$arreglo_8['idMaquina']."'";
																										$SIS_data .= ",'".$arreglo_8['idUtilizable']."'";
																										$SIS_data .= ",'".$arreglo_8['Codigo']."'";
																										$SIS_data .= ",'".$arreglo_8['Nombre']."'";
																										$SIS_data .= ",'".$arreglo_8['Marca']."'";
																										$SIS_data .= ",'".$arreglo_8['Modelo']."'";
																										$SIS_data .= ",'".$arreglo_8['AnoFab']."'";
																										$SIS_data .= ",'".$arreglo_8['Serie']."'";
																										$SIS_data .= ",'".$arreglo_8['idLicitacion']."'";
																										$SIS_data .= ",'".$arreglo_8['tabla']."'";
																										$SIS_data .= ",'".$arreglo_8['table_value']."'";
																										$SIS_data .= ",'".$arreglo_8['Direccion_img']."'";
																										$SIS_data .= ",'".$arreglo_8['idSubTipo']."'";
																										$SIS_data .= ",'".$arreglo_8['Grasa_inicial']."'";
																										$SIS_data .= ",'".$arreglo_8['Grasa_relubricacion']."'";
																										$SIS_data .= ",'".$arreglo_8['Aceite']."'";
																										$SIS_data .= ",'".$arreglo_8['Cantidad']."'";
																										$SIS_data .= ",'".$arreglo_8['idUml']."'";
																										$SIS_data .= ",'".$arreglo_8['Frecuencia']."'";
																										$SIS_data .= ",'".$arreglo_8['idFrecuencia']."'";
																										$SIS_data .= ",'".$arreglo_8['idProducto']."'";
																										$SIS_data .= ",'".$arreglo_8['Saf']."'";
																										$SIS_data .= ",'".$arreglo_8['Numero']."'";

																										$cadena = '';
																										$x = 1;
																										if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}
																										if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_8['idLevel_'.$x]."'";$x++;}

																										$x = 1;
																										if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																										if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																										if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																										if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																										if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																										if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																										if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																										if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																										if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																										if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																										if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																										if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																										if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																										if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																										if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																										if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																										if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																										if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																										if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																										if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																										if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																										if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																										if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																										if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																										if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																										// inserto los datos de registro en la db
																										$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																										Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																										Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																										idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																										$id_lvl[$dis_8] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_8, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																										/////////////////////////////////////////////////
																										if(isset($arrLVL[$dis_9])){
																											foreach ($arrLVL[$dis_9] as $arreglo_9) {
																												//Se verifica que sea el mismo sensor
																												if($arreglo_8['idLevel_'.$dis_8]==$arreglo_9['idLevel_'.$dis_8]){

																													//Se crea la maquina
																													$SIS_data  = "'".$arreglo_9['idSistema']."'";
																													$SIS_data .= ",'".$arreglo_9['idMaquina']."'";
																													$SIS_data .= ",'".$arreglo_9['idUtilizable']."'";
																													$SIS_data .= ",'".$arreglo_9['Codigo']."'";
																													$SIS_data .= ",'".$arreglo_9['Nombre']."'";
																													$SIS_data .= ",'".$arreglo_9['Marca']."'";
																													$SIS_data .= ",'".$arreglo_9['Modelo']."'";
																													$SIS_data .= ",'".$arreglo_9['AnoFab']."'";
																													$SIS_data .= ",'".$arreglo_9['Serie']."'";
																													$SIS_data .= ",'".$arreglo_9['idLicitacion']."'";
																													$SIS_data .= ",'".$arreglo_9['tabla']."'";
																													$SIS_data .= ",'".$arreglo_9['table_value']."'";
																													$SIS_data .= ",'".$arreglo_9['Direccion_img']."'";
																													$SIS_data .= ",'".$arreglo_9['idSubTipo']."'";
																													$SIS_data .= ",'".$arreglo_9['Grasa_inicial']."'";
																													$SIS_data .= ",'".$arreglo_9['Grasa_relubricacion']."'";
																													$SIS_data .= ",'".$arreglo_9['Aceite']."'";
																													$SIS_data .= ",'".$arreglo_9['Cantidad']."'";
																													$SIS_data .= ",'".$arreglo_9['idUml']."'";
																													$SIS_data .= ",'".$arreglo_9['Frecuencia']."'";
																													$SIS_data .= ",'".$arreglo_9['idFrecuencia']."'";
																													$SIS_data .= ",'".$arreglo_9['idProducto']."'";
																													$SIS_data .= ",'".$arreglo_9['Saf']."'";
																													$SIS_data .= ",'".$arreglo_9['Numero']."'";

																													$cadena = '';
																													$x = 1;
																													if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}
																													if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_9['idLevel_'.$x]."'";$x++;}

																													$x = 1;
																													if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																													if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																													if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																													if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																													if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																													if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																													if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																													if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																													if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																													if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																													if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																													if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																													if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																													if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																													if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																													if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																													if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																													if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																													if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																													if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																													if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																													if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																													if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																													if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																													if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																													// inserto los datos de registro en la db
																													$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																													Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																													Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																													idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																													$id_lvl[$dis_9] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_9, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																													/////////////////////////////////////////////////
																													if(isset($arrLVL[$dis_10])){
																														foreach ($arrLVL[$dis_10] as $arreglo_10) {
																															//Se verifica que sea el mismo sensor
																															if($arreglo_9['idLevel_'.$dis_9]==$arreglo_10['idLevel_'.$dis_9]){

																																//Se crea la maquina
																																$SIS_data  = "'".$arreglo_10['idSistema']."'";
																																$SIS_data .= ",'".$arreglo_10['idMaquina']."'";
																																$SIS_data .= ",'".$arreglo_10['idUtilizable']."'";
																																$SIS_data .= ",'".$arreglo_10['Codigo']."'";
																																$SIS_data .= ",'".$arreglo_10['Nombre']."'";
																																$SIS_data .= ",'".$arreglo_10['Marca']."'";
																																$SIS_data .= ",'".$arreglo_10['Modelo']."'";
																																$SIS_data .= ",'".$arreglo_10['AnoFab']."'";
																																$SIS_data .= ",'".$arreglo_10['Serie']."'";
																																$SIS_data .= ",'".$arreglo_10['idLicitacion']."'";
																																$SIS_data .= ",'".$arreglo_10['tabla']."'";
																																$SIS_data .= ",'".$arreglo_10['table_value']."'";
																																$SIS_data .= ",'".$arreglo_10['Direccion_img']."'";
																																$SIS_data .= ",'".$arreglo_10['idSubTipo']."'";
																																$SIS_data .= ",'".$arreglo_10['Grasa_inicial']."'";
																																$SIS_data .= ",'".$arreglo_10['Grasa_relubricacion']."'";
																																$SIS_data .= ",'".$arreglo_10['Aceite']."'";
																																$SIS_data .= ",'".$arreglo_10['Cantidad']."'";
																																$SIS_data .= ",'".$arreglo_10['idUml']."'";
																																$SIS_data .= ",'".$arreglo_10['Frecuencia']."'";
																																$SIS_data .= ",'".$arreglo_10['idFrecuencia']."'";
																																$SIS_data .= ",'".$arreglo_10['idProducto']."'";
																																$SIS_data .= ",'".$arreglo_10['Saf']."'";
																																$SIS_data .= ",'".$arreglo_10['Numero']."'";

																																$cadena = '';
																																$x = 1;
																																if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}
																																if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_10['idLevel_'.$x]."'";$x++;}

																																$x = 1;
																																if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																// inserto los datos de registro en la db
																																$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																$id_lvl[$dis_10] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_10, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																/////////////////////////////////////////////////
																																if(isset($arrLVL[$dis_11])){
																																	foreach ($arrLVL[$dis_11] as $arreglo_11) {
																																		//Se verifica que sea el mismo sensor
																																		if($arreglo_10['idLevel_'.$dis_10]==$arreglo_11['idLevel_'.$dis_10]){

																																			//Se crea la maquina
																																			$SIS_data  = "'".$arreglo_11['idSistema']."'";
																																			$SIS_data .= ",'".$arreglo_11['idMaquina']."'";
																																			$SIS_data .= ",'".$arreglo_11['idUtilizable']."'";
																																			$SIS_data .= ",'".$arreglo_11['Codigo']."'";
																																			$SIS_data .= ",'".$arreglo_11['Nombre']."'";
																																			$SIS_data .= ",'".$arreglo_11['Marca']."'";
																																			$SIS_data .= ",'".$arreglo_11['Modelo']."'";
																																			$SIS_data .= ",'".$arreglo_11['AnoFab']."'";
																																			$SIS_data .= ",'".$arreglo_11['Serie']."'";
																																			$SIS_data .= ",'".$arreglo_11['idLicitacion']."'";
																																			$SIS_data .= ",'".$arreglo_11['tabla']."'";
																																			$SIS_data .= ",'".$arreglo_11['table_value']."'";
																																			$SIS_data .= ",'".$arreglo_11['Direccion_img']."'";
																																			$SIS_data .= ",'".$arreglo_11['idSubTipo']."'";
																																			$SIS_data .= ",'".$arreglo_11['Grasa_inicial']."'";
																																			$SIS_data .= ",'".$arreglo_11['Grasa_relubricacion']."'";
																																			$SIS_data .= ",'".$arreglo_11['Aceite']."'";
																																			$SIS_data .= ",'".$arreglo_11['Cantidad']."'";
																																			$SIS_data .= ",'".$arreglo_11['idUml']."'";
																																			$SIS_data .= ",'".$arreglo_11['Frecuencia']."'";
																																			$SIS_data .= ",'".$arreglo_11['idFrecuencia']."'";
																																			$SIS_data .= ",'".$arreglo_11['idProducto']."'";
																																			$SIS_data .= ",'".$arreglo_11['Saf']."'";
																																			$SIS_data .= ",'".$arreglo_11['Numero']."'";

																																			$cadena = '';
																																			$x = 1;
																																			if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}
																																			if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_11['idLevel_'.$x]."'";$x++;}

																																			$x = 1;
																																			if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																			if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																			if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																			if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																			if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																			if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																			if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																			if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																			if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																			if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																			if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																			if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																			if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																			if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																			if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																			if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																			if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																			if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																			if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																			if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																			if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																			if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																			if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																			if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																			if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																			// inserto los datos de registro en la db
																																			$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																			Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																			Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																			idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																			$id_lvl[$dis_11] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_11, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																			/////////////////////////////////////////////////
																																			if(isset($arrLVL[$dis_12])){
																																				foreach ($arrLVL[$dis_12] as $arreglo_12) {
																																					//Se verifica que sea el mismo sensor
																																					if($arreglo_11['idLevel_'.$dis_11]==$arreglo_12['idLevel_'.$dis_11]){

																																						//Se crea la maquina
																																						$SIS_data  = "'".$arreglo_12['idSistema']."'";
																																						$SIS_data .= ",'".$arreglo_12['idMaquina']."'";
																																						$SIS_data .= ",'".$arreglo_12['idUtilizable']."'";
																																						$SIS_data .= ",'".$arreglo_12['Codigo']."'";
																																						$SIS_data .= ",'".$arreglo_12['Nombre']."'";
																																						$SIS_data .= ",'".$arreglo_12['Marca']."'";
																																						$SIS_data .= ",'".$arreglo_12['Modelo']."'";
																																						$SIS_data .= ",'".$arreglo_12['AnoFab']."'";
																																						$SIS_data .= ",'".$arreglo_12['Serie']."'";
																																						$SIS_data .= ",'".$arreglo_12['idLicitacion']."'";
																																						$SIS_data .= ",'".$arreglo_12['tabla']."'";
																																						$SIS_data .= ",'".$arreglo_12['table_value']."'";
																																						$SIS_data .= ",'".$arreglo_12['Direccion_img']."'";
																																						$SIS_data .= ",'".$arreglo_12['idSubTipo']."'";
																																						$SIS_data .= ",'".$arreglo_12['Grasa_inicial']."'";
																																						$SIS_data .= ",'".$arreglo_12['Grasa_relubricacion']."'";
																																						$SIS_data .= ",'".$arreglo_12['Aceite']."'";
																																						$SIS_data .= ",'".$arreglo_12['Cantidad']."'";
																																						$SIS_data .= ",'".$arreglo_12['idUml']."'";
																																						$SIS_data .= ",'".$arreglo_12['Frecuencia']."'";
																																						$SIS_data .= ",'".$arreglo_12['idFrecuencia']."'";
																																						$SIS_data .= ",'".$arreglo_12['idProducto']."'";
																																						$SIS_data .= ",'".$arreglo_12['Saf']."'";
																																						$SIS_data .= ",'".$arreglo_12['Numero']."'";

																																						$cadena = '';
																																						$x = 1;
																																						if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}
																																						if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_12['idLevel_'.$x]."'";$x++;}

																																						$x = 1;
																																						if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																						if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																						if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																						if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																						if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																						if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																						if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																						if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																						if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																						if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																						if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																						if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																						if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																						if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																						if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																						if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																						if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																						if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																						if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																						if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																						if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																						if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																						if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																						if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																						if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																						// inserto los datos de registro en la db
																																						$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																						Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																						Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																						idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																						$id_lvl[$dis_12] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_12, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																						/////////////////////////////////////////////////
																																						if(isset($arrLVL[$dis_13])){
																																							foreach ($arrLVL[$dis_13] as $arreglo_13) {
																																								//Se verifica que sea el mismo sensor
																																								if($arreglo_12['idLevel_'.$dis_12]==$arreglo_13['idLevel_'.$dis_12]){

																																									//Se crea la maquina
																																									$SIS_data  = "'".$arreglo_13['idSistema']."'";
																																									$SIS_data .= ",'".$arreglo_13['idMaquina']."'";
																																									$SIS_data .= ",'".$arreglo_13['idUtilizable']."'";
																																									$SIS_data .= ",'".$arreglo_13['Codigo']."'";
																																									$SIS_data .= ",'".$arreglo_13['Nombre']."'";
																																									$SIS_data .= ",'".$arreglo_13['Marca']."'";
																																									$SIS_data .= ",'".$arreglo_13['Modelo']."'";
																																									$SIS_data .= ",'".$arreglo_13['AnoFab']."'";
																																									$SIS_data .= ",'".$arreglo_13['Serie']."'";
																																									$SIS_data .= ",'".$arreglo_13['idLicitacion']."'";
																																									$SIS_data .= ",'".$arreglo_13['tabla']."'";
																																									$SIS_data .= ",'".$arreglo_13['table_value']."'";
																																									$SIS_data .= ",'".$arreglo_13['Direccion_img']."'";
																																									$SIS_data .= ",'".$arreglo_13['idSubTipo']."'";
																																									$SIS_data .= ",'".$arreglo_13['Grasa_inicial']."'";
																																									$SIS_data .= ",'".$arreglo_13['Grasa_relubricacion']."'";
																																									$SIS_data .= ",'".$arreglo_13['Aceite']."'";
																																									$SIS_data .= ",'".$arreglo_13['Cantidad']."'";
																																									$SIS_data .= ",'".$arreglo_13['idUml']."'";
																																									$SIS_data .= ",'".$arreglo_13['Frecuencia']."'";
																																									$SIS_data .= ",'".$arreglo_13['idFrecuencia']."'";
																																									$SIS_data .= ",'".$arreglo_13['idProducto']."'";
																																									$SIS_data .= ",'".$arreglo_13['Saf']."'";
																																									$SIS_data .= ",'".$arreglo_13['Numero']."'";

																																									$cadena = '';
																																									$x = 1;
																																									if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}
																																									if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_13['idLevel_'.$x]."'";$x++;}

																																									$x = 1;
																																									if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																									if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																									if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																									if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																									if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																									if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																									if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																									if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																									if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																									if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																									if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																									if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																									if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																									if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																									if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																									if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																									if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																									if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																									if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																									if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																									if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																									if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																									if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																									if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																									if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																									// inserto los datos de registro en la db
																																									$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																									Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																									Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																									idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																									$id_lvl[$dis_13] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_13, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																									/////////////////////////////////////////////////
																																									if(isset($arrLVL[$dis_14])){
																																										foreach ($arrLVL[$dis_14] as $arreglo_14) {
																																											//Se verifica que sea el mismo sensor
																																											if($arreglo_13['idLevel_'.$dis_13]==$arreglo_14['idLevel_'.$dis_13]){

																																												//Se crea la maquina
																																												$SIS_data  = "'".$arreglo_14['idSistema']."'";
																																												$SIS_data .= ",'".$arreglo_14['idMaquina']."'";
																																												$SIS_data .= ",'".$arreglo_14['idUtilizable']."'";
																																												$SIS_data .= ",'".$arreglo_14['Codigo']."'";
																																												$SIS_data .= ",'".$arreglo_14['Nombre']."'";
																																												$SIS_data .= ",'".$arreglo_14['Marca']."'";
																																												$SIS_data .= ",'".$arreglo_14['Modelo']."'";
																																												$SIS_data .= ",'".$arreglo_14['AnoFab']."'";
																																												$SIS_data .= ",'".$arreglo_14['Serie']."'";
																																												$SIS_data .= ",'".$arreglo_14['idLicitacion']."'";
																																												$SIS_data .= ",'".$arreglo_14['tabla']."'";
																																												$SIS_data .= ",'".$arreglo_14['table_value']."'";
																																												$SIS_data .= ",'".$arreglo_14['Direccion_img']."'";
																																												$SIS_data .= ",'".$arreglo_14['idSubTipo']."'";
																																												$SIS_data .= ",'".$arreglo_14['Grasa_inicial']."'";
																																												$SIS_data .= ",'".$arreglo_14['Grasa_relubricacion']."'";
																																												$SIS_data .= ",'".$arreglo_14['Aceite']."'";
																																												$SIS_data .= ",'".$arreglo_14['Cantidad']."'";
																																												$SIS_data .= ",'".$arreglo_14['idUml']."'";
																																												$SIS_data .= ",'".$arreglo_14['Frecuencia']."'";
																																												$SIS_data .= ",'".$arreglo_14['idFrecuencia']."'";
																																												$SIS_data .= ",'".$arreglo_14['idProducto']."'";
																																												$SIS_data .= ",'".$arreglo_14['Saf']."'";
																																												$SIS_data .= ",'".$arreglo_14['Numero']."'";

																																												$cadena = '';
																																												$x = 1;
																																												if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}
																																												if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_14['idLevel_'.$x]."'";$x++;}

																																												$x = 1;
																																												if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																												if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																												if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																												if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																												if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																												if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																												if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																												if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																												if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																												if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																												if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																												if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																												if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																												if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																												if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																												if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																												if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																												if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																												if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																												if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																												if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																												if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																												if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																												if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																												if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																												// inserto los datos de registro en la db
																																												$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																												Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																												Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																												idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																												$id_lvl[$dis_14] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_14, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																												/////////////////////////////////////////////////
																																												if(isset($arrLVL[$dis_15])){
																																													foreach ($arrLVL[$dis_15] as $arreglo_15) {
																																														//Se verifica que sea el mismo sensor
																																														if($arreglo_14['idLevel_'.$dis_14]==$arreglo_15['idLevel_'.$dis_14]){

																																															//Se crea la maquina
																																															$SIS_data  = "'".$arreglo_15['idSistema']."'";
																																															$SIS_data .= ",'".$arreglo_15['idMaquina']."'";
																																															$SIS_data .= ",'".$arreglo_15['idUtilizable']."'";
																																															$SIS_data .= ",'".$arreglo_15['Codigo']."'";
																																															$SIS_data .= ",'".$arreglo_15['Nombre']."'";
																																															$SIS_data .= ",'".$arreglo_15['Marca']."'";
																																															$SIS_data .= ",'".$arreglo_15['Modelo']."'";
																																															$SIS_data .= ",'".$arreglo_15['AnoFab']."'";
																																															$SIS_data .= ",'".$arreglo_15['Serie']."'";
																																															$SIS_data .= ",'".$arreglo_15['idLicitacion']."'";
																																															$SIS_data .= ",'".$arreglo_15['tabla']."'";
																																															$SIS_data .= ",'".$arreglo_15['table_value']."'";
																																															$SIS_data .= ",'".$arreglo_15['Direccion_img']."'";
																																															$SIS_data .= ",'".$arreglo_15['idSubTipo']."'";
																																															$SIS_data .= ",'".$arreglo_15['Grasa_inicial']."'";
																																															$SIS_data .= ",'".$arreglo_15['Grasa_relubricacion']."'";
																																															$SIS_data .= ",'".$arreglo_15['Aceite']."'";
																																															$SIS_data .= ",'".$arreglo_15['Cantidad']."'";
																																															$SIS_data .= ",'".$arreglo_15['idUml']."'";
																																															$SIS_data .= ",'".$arreglo_15['Frecuencia']."'";
																																															$SIS_data .= ",'".$arreglo_15['idFrecuencia']."'";
																																															$SIS_data .= ",'".$arreglo_15['idProducto']."'";
																																															$SIS_data .= ",'".$arreglo_15['Saf']."'";
																																															$SIS_data .= ",'".$arreglo_15['Numero']."'";

																																															$cadena = '';
																																															$x = 1;
																																															if($lv_1!=0&&$lvl>1){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_2!=0&&$lvl>2){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_3!=0&&$lvl>3){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_4!=0&&$lvl>4){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_5!=0&&$lvl>5){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_6!=0&&$lvl>6){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_7!=0&&$lvl>7){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_8!=0&&$lvl>8){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_9!=0&&$lvl>9){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_10!=0&&$lvl>10){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_11!=0&&$lvl>11){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_12!=0&&$lvl>12){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_13!=0&&$lvl>13){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_14!=0&&$lvl>14){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_15!=0&&$lvl>15){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_16!=0&&$lvl>16){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_17!=0&&$lvl>17){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_18!=0&&$lvl>18){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_19!=0&&$lvl>19){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_20!=0&&$lvl>20){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_21!=0&&$lvl>21){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_22!=0&&$lvl>22){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_23!=0&&$lvl>23){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_24!=0&&$lvl>24){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}
																																															if($lv_25!=0&&$lvl>25){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$arreglo_15['idLevel_'.$x]."'";$x++;}

																																															$x = 1;
																																															if(isset($id_lvl[$dis_1])&&$id_lvl[$dis_1]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_1]."'";$x++;}
																																															if(isset($id_lvl[$dis_2])&&$id_lvl[$dis_2]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_2]."'";$x++;}
																																															if(isset($id_lvl[$dis_3])&&$id_lvl[$dis_3]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_3]."'";$x++;}
																																															if(isset($id_lvl[$dis_4])&&$id_lvl[$dis_4]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_4]."'";$x++;}
																																															if(isset($id_lvl[$dis_5])&&$id_lvl[$dis_5]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_5]."'";$x++;}
																																															if(isset($id_lvl[$dis_6])&&$id_lvl[$dis_6]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_6]."'";$x++;}
																																															if(isset($id_lvl[$dis_7])&&$id_lvl[$dis_7]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_7]."'";$x++;}
																																															if(isset($id_lvl[$dis_8])&&$id_lvl[$dis_8]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_8]."'";$x++;}
																																															if(isset($id_lvl[$dis_9])&&$id_lvl[$dis_9]!=''){    $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_9]."'";$x++;}
																																															if(isset($id_lvl[$dis_10])&&$id_lvl[$dis_10]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_10]."'";$x++;}
																																															if(isset($id_lvl[$dis_11])&&$id_lvl[$dis_11]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_11]."'";$x++;}
																																															if(isset($id_lvl[$dis_12])&&$id_lvl[$dis_12]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_12]."'";$x++;}
																																															if(isset($id_lvl[$dis_13])&&$id_lvl[$dis_13]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_13]."'";$x++;}
																																															if(isset($id_lvl[$dis_14])&&$id_lvl[$dis_14]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_14]."'";$x++;}
																																															if(isset($id_lvl[$dis_15])&&$id_lvl[$dis_15]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_15]."'";$x++;}
																																															if(isset($id_lvl[$dis_16])&&$id_lvl[$dis_16]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_16]."'";$x++;}
																																															if(isset($id_lvl[$dis_17])&&$id_lvl[$dis_17]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_17]."'";$x++;}
																																															if(isset($id_lvl[$dis_18])&&$id_lvl[$dis_18]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_18]."'";$x++;}
																																															if(isset($id_lvl[$dis_19])&&$id_lvl[$dis_19]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_19]."'";$x++;}
																																															if(isset($id_lvl[$dis_20])&&$id_lvl[$dis_20]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_20]."'";$x++;}
																																															if(isset($id_lvl[$dis_21])&&$id_lvl[$dis_21]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_21]."'";$x++;}
																																															if(isset($id_lvl[$dis_22])&&$id_lvl[$dis_22]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_22]."'";$x++;}
																																															if(isset($id_lvl[$dis_23])&&$id_lvl[$dis_23]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_23]."'";$x++;}
																																															if(isset($id_lvl[$dis_24])&&$id_lvl[$dis_24]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_24]."'";$x++;}
																																															if(isset($id_lvl[$dis_25])&&$id_lvl[$dis_25]!=''){  $cadena .= ',idLevel_'.$x;$SIS_data .= ",'".$id_lvl[$dis_25]."'";$x++;}

																																															// inserto los datos de registro en la db
																																															$SIS_columns = 'idSistema, idMaquina, idUtilizable,
																																															Codigo, Nombre,Marca, Modelo, AnoFab, Serie, idLicitacion, tabla, table_value,
																																															Direccion_img, idSubTipo, Grasa_inicial, Grasa_relubricacion, Aceite, Cantidad,
																																															idUml, Frecuencia, idFrecuencia, idProducto, Saf, Numero '.$cadena;
																																															$id_lvl[$dis_15] = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_level_'.$dis_15, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

																																														}
																																													}
																																												}
																																											}
																																										}
																																									}
																																								}
																																							}
																																						}
																																					}
																																				}
																																			}
																																		}
																																	}
																																}
																															}
																														}
																													}
																												}
																											}
																										}
																									}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}

			header( 'Location: '.$location.'&clone_comp=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'clone_Matriz':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado_matriz', '', "Nombre='".$Nombre."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la matriz ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//bucle
				$qry = '';
				for ($i = 1; $i <= 50; $i++) {
					$qry .= ',PuntoNombre_'.$i;
					$qry .= ',PuntoMedAceptable_'.$i;
					$qry .= ',PuntoMedAlerta_'.$i;
					$qry .= ',PuntoMedCondenatorio_'.$i;
					$qry .= ',PuntoUltimaMed_'.$i;
					$qry .= ',PuntoUniMed_'.$i;
					$qry .= ',PuntoidTipo_'.$i;
					$qry .= ',PuntoidGrupo_'.$i;
				}

				/*******************************************************************/
				// Se traen todos los datos de la maquina
				$rowData = db_select_data (false, 'idMaquina, cantPuntos, idEstado'.$qry , 'maquinas_listado_matriz', '', 'idMatriz ='.$idMatriz, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************************/
				//filtros
				if(isset($rowData['idMaquina']) && $rowData['idMaquina']!=''){     $SIS_data  = "'".$rowData['idMaquina']."'";     }else{$SIS_data  = "''";}
				if(isset($rowData['cantPuntos']) && $rowData['cantPuntos']!=''){   $SIS_data .= ",'".$rowData['cantPuntos']."'";   }else{$SIS_data .= ",''";}
				if(isset($rowData['idEstado']) && $rowData['idEstado']!=''){       $SIS_data .= ",'".$rowData['idEstado']."'";     }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                                 $SIS_data .= ",'".$Nombre."'";                  }else{$SIS_data .= ",''";}

				for ($i = 1; $i <= 50; $i++) {
					if(isset($rowData['PuntoNombre_'.$i]) && $rowData['PuntoNombre_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoNombre_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAceptable_'.$i]) && $rowData['PuntoMedAceptable_'.$i]!=''){        $SIS_data .= ",'".$rowData['PuntoMedAceptable_'.$i]."'";     }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedAlerta_'.$i]) && $rowData['PuntoMedAlerta_'.$i]!=''){              $SIS_data .= ",'".$rowData['PuntoMedAlerta_'.$i]."'";        }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoMedCondenatorio_'.$i]) && $rowData['PuntoMedCondenatorio_'.$i]!=''){  $SIS_data .= ",'".$rowData['PuntoMedCondenatorio_'.$i]."'";  }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoUltimaMed_'.$i]) && $rowData['PuntoUltimaMed_'.$i]!=''){              $SIS_data .= ",'".$rowData['PuntoUltimaMed_'.$i]."'";        }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoUniMed_'.$i]) && $rowData['PuntoUniMed_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoUniMed_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidTipo_'.$i]) && $rowData['PuntoidTipo_'.$i]!=''){                    $SIS_data .= ",'".$rowData['PuntoidTipo_'.$i]."'";           }else{$SIS_data .= ",''";}
					if(isset($rowData['PuntoidGrupo_'.$i]) && $rowData['PuntoidGrupo_'.$i]!=''){                  $SIS_data .= ",'".$rowData['PuntoidGrupo_'.$i]."'";          }else{$SIS_data .= ",''";}

				}

				// inserto los datos de registro en la db
				$SIS_columns = 'idMaquina,cantPuntos,idEstado, Nombre'.$qry;
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado_matriz', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&clone=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'createBasicDataMaquina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre, $idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'maquinas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre de la maquina ya existe en el sistema';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){                   $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
				if(isset($idEstado) && $idEstado!=''){                     $SIS_data .= ",'".$idEstado."'";               }else{$SIS_data .= ",''";}
				if(isset($Codigo) && $Codigo!=''){                         $SIS_data .= ",'".$Codigo."'";                 }else{$SIS_data .= ",''";}
				if(isset($Nombre) && $Nombre!=''){                         $SIS_data .= ",'".$Nombre."'";                 }else{$SIS_data .= ",''";}
				if(isset($Modelo) && $Modelo!=''){                         $SIS_data .= ",'".$Modelo."'";                 }else{$SIS_data .= ",''";}
				if(isset($Serie) && $Serie!=''){                           $SIS_data .= ",'".$Serie."'";                  }else{$SIS_data .= ",''";}
				if(isset($Fabricante) && $Fabricante!=''){                 $SIS_data .= ",'".$Fabricante."'";             }else{$SIS_data .= ",''";}
				if(isset($fincorporacion) && $fincorporacion!=''){         $SIS_data .= ",'".$fincorporacion."'";         }else{$SIS_data .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){               $SIS_data .= ",'".$Descripcion."'";            }else{$SIS_data .= ",''";}
				if(isset($idConfig_1) && $idConfig_1!=''){                 $SIS_data .= ",'".$idConfig_1."'";             }else{$SIS_data .= ",''";}
				if(isset($idConfig_2) && $idConfig_2!=''){                 $SIS_data .= ",'".$idConfig_2."'";             }else{$SIS_data .= ",''";}
				if(isset($idConfig_3) && $idConfig_3!=''){                 $SIS_data .= ",'".$idConfig_3."'";             }else{$SIS_data .= ",''";}
				if(isset($idConfig_4) && $idConfig_4!=''){                 $SIS_data .= ",'".$idConfig_4."'";             }else{$SIS_data .= ",''";}
				if(isset($idUbicacion) && $idUbicacion!=''){               $SIS_data .= ",'".$idUbicacion."'";            }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_1) && $idUbicacion_lvl_1!=''){   $SIS_data .= ",'".$idUbicacion_lvl_1."'";      }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_2) && $idUbicacion_lvl_2!=''){   $SIS_data .= ",'".$idUbicacion_lvl_2."'";      }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_3) && $idUbicacion_lvl_3!=''){   $SIS_data .= ",'".$idUbicacion_lvl_3."'";      }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_4) && $idUbicacion_lvl_4!=''){   $SIS_data .= ",'".$idUbicacion_lvl_4."'";      }else{$SIS_data .= ",''";}
				if(isset($idUbicacion_lvl_5) && $idUbicacion_lvl_5!=''){   $SIS_data .= ",'".$idUbicacion_lvl_5."'";      }else{$SIS_data .= ",''";}
				if(isset($idCliente) && $idCliente!=''){                   $SIS_data .= ",'".$idCliente."'";              }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idEstado, Codigo, Nombre,Modelo, Serie, Fabricante,
				fincorporacion, Descripcion, idConfig_1, idConfig_2, idConfig_3, idConfig_4, idUbicacion, idUbicacion_lvl_1, idUbicacion_lvl_2,
				idUbicacion_lvl_3, idUbicacion_lvl_4, idUbicacion_lvl_5, idCliente';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'maquinas_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'estadoMaquina':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$idMaquina  = $_GET['status'];
			$idEstado   = simpleDecode($_GET['estado'], fecha_actual());
			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "idEstado='".$idEstado."'";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado', 'idMaquina = "'.$idMaquina.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//redirijo
				header( 'Location: '.$location.'&edited=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'submit_img_comp':

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
				$sufijo = 'mq_subc_img_'.$lvl.'_'.$idLevel[$lvl].'_';

				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						if ($move_result){

							//Filtros
							$SIS_data = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'";

							/*******************************************************/
							//se actualizan los datos
							$resultado = db_update_data (false, $SIS_data, 'maquinas_listado_level_'.$lvl, 'idLevel_'.$lvl.' = "'.$idLevel[$lvl].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								//redirijo
								header( 'Location: '.$location.'&edited=true' );
								die;

							}

						} else {
							$error['Direccion_img']       = 'error/Ocurrio un error al mover el archivo';
						}
					} else {
						$error['Direccion_img']       = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe';
					}
				} else {
					$error['Direccion_img']       = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_img_comp':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// Se obtiene el nombre del archivo
			$rowData = db_select_data (false, 'Direccion_img', 'maquinas_listado_level_'.$_GET['lvl'], '', 'idLevel_'.$_GET['lvl'].' = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			/*******************************************************/
			//se actualizan los datos
			$SIS_data = "Direccion_img=''";
			$resultado = db_update_data (false, $SIS_data, 'maquinas_listado_level_'.$_GET['lvl'], 'idLevel_'.$_GET['lvl'].' = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){

				//Se elimina la imagen
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
				header( 'Location: '.$location.'&deleted=true' );
				die;
			}

		break;
/*******************************************************************************************************************/
	}

?>
