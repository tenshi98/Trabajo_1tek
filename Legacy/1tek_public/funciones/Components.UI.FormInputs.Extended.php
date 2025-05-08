<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1005-001).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                    Se llama a la clase de la que se hereda                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.FormInputs.php';
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
class Form_Inputs extends Basic_Form_Inputs{

	/*******************************************************************************************************************/
	public function form_select_temporada($placeholder,$name, $value, $required, $data){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************************/
		//generacion del input
		$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
					<option value="" selected>Seleccione una Opción</option>';
					//pongo rango de +4 y -4
					$desde = $data - 4;
					$hasta = $data + 4;
					for ($i = $desde; $i <= $hasta; $i++) {
						$selected = '';
						$x = $i+1;
						$xdata = $i.' - '.$x;
						if($value==$xdata){
							$selected = 'selected="selected"';
						}
						$input .= '<option value="'.$xdata.'" '.$selected.' >'.$xdata.'</option>';
					}

					$input .= '
					</select>
				</div>
			</div>';

		/******************************************/
		//Imprimir dato
		echo $input;

	}
	/*******************************************************************************************************************/
	public function form_select_temporada_2($placeholder,$name, $value, $required, $data){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************************/
		//generacion del input
		$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
						<option value="" selected>Seleccione una Opción</option>';
						//pongo rango de +4 y -4
						$desde = $data;
						$hasta = $data;
						for ($i = $desde; $i <= $hasta; $i++) {
							$selected = '';
							$x = $i+1;
							$xdata = $i.' - '.$x;
							if($value==$xdata){
								$selected = 'selected="selected"';
							}
							$input .= '<option value="'.$xdata.'" '.$selected.' >'.$xdata.'</option>';
						}

					$input .= '
					</select>
				</div>
			</div>';

		/******************************************/
		//Imprimir dato
		echo $input;

	}
	/*******************************************************************************************************************/
	public function form_visualizacion($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $dbConn){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************************/
		//FILTRO
		$filtro = '';
		if ($filter!='0'){$filtro ="WHERE ".$filter; }

		//se trae un listado con todas las categorias
		$arrSelect = array();
		$arrSelect = db_select_array (false, $data1.' AS idData, '.$data2.' AS Nombre', $table, '', $filtro, 'Nombre ASC', $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

		//si hay resultados
		if($arrSelect!=false){

			$input = '<div class="form-group" id="div_'.$name.'">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
								<option value="" selected>Seleccione una Opción</option>';
								$w1 = '';
								$w2 = '';
								if($value==9998){
									$w1 = 'selected="selected"';
								}elseif($value==9999){
									$w2 = 'selected="selected"';
								}
								$input .= '<option value="9998" '.$w1.'>Todos</option>';
								$input .= '<option value="9999" '.$w2.'>Solo Superadministradores</option>';

								foreach ( $arrSelect as $select ) {
									$selected = '';
									if($value==$select['idData']){
										$selected = 'selected="selected"';
									}
									$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.$select['Nombre'].'</option>';
								}
							$input .= '
							</select>
						</div>
					</div>';

			echo $input;

		//si no hay datos
		}elseif(empty($arrSelect) OR $arrSelect==''){
			//Devuelvo mensaje
			alert_post_data(4,1,1,0, 'No hay datos en <strong>'.$placeholder.'</strong>, consulte con el administrador');
		//si existe un error
		}elseif($arrSelect==false){
			//Devuelvo mensaje
			alert_post_data(4,1,1,0, 'Hay un error en la consulta <strong>'.$placeholder.'</strong>, consulte con el administrador');
		}

	}
	/*******************************************************************************************************************/
	public function form_select_sys($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $dbConn){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************************/
		//Filtro para el where
		$filtro = '';
		if ($filter!='0'){$filtro .="WHERE ".$filter;	}
		//explode para poder crear cadena
		$datos = explode(",", $data2);
		if(count($datos)==1){
			$data_required = ','.$datos[0].' AS '.$datos[0];
			$order_by = $datos[0].' ASC ';
			if($filter!=''){$filtro .=" AND ".$datos[0]."!='' ";}elseif($filter==''){$filtro .="WHERE ".$datos[0]."!='' ";}
		}else{
			$data_required = '';
			$order_by = $datos[0].' ASC ';
			if($filter!=''){$filtro .=" AND ".$datos[0]."!='' ";}elseif($filter==''){$filtro .="WHERE ".$datos[0]."!='' ";}
			foreach($datos as $dato){
				$data_required .= ','.$dato.' AS '.$dato;
			}
		}

		//se trae un listado con todas las categorias
		$arrSelect = array();
		$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

		//Si ejecuto correctamente la consulta
		if($arrSelect!=false){

			$input = '
					<div class="form-group" id="div_'.$name.'">
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
								<option value="" selected>Seleccione una Opción</option>';

								$selected = '';
								if($value==9999){
									$selected = 'selected="selected"';
								}
								$input .= '<option value="9999" '.$selected.' >Todos</option>';

								foreach ( $arrSelect as $select ) {

									if($value==$select['idData']){
										$selected = 'selected="selected"';
									}
									if(count($datos)==1){
										$data_writing = $select[$datos[0]].' ';
									}else{
										$data_writing = '';
										foreach($datos as $dato){
											$data_writing .= $select[$dato].' ';
										}
									}
									$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.$data_writing.'</option>';
								}
								$input .= '
							</select>
						</div>
					</div>';

			echo $input;

		//si no hay datos
		}elseif(empty($arrSelect) OR $arrSelect==''){
			//Devuelvo mensaje
			alert_post_data(4,1,1,0, 'No hay datos en <strong>'.$placeholder.'</strong>, consulte con el administrador');
		//si existe un error
		}elseif($arrSelect==false){
			//Devuelvo mensaje
			alert_post_data(4,1,1,0, 'Hay un error en la consulta <strong>'.$placeholder.'</strong>, consulte con el administrador');
		}
	}
	/*******************************************************************************************************************/
	public function form_input_validate($placeholder,$name, $value, $required, $aValidar){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************************/
		//Si existe un valor entregado
		$valor = '';
		if($value!=''){$valor = $value;}

		/******************************************/
		//generacion del input
		$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field autocomplete">
					<input type="text" placeholder="'.$placeholder.'" class="form-control"  name="'.$name.'" id="'.$name.'" value="'.$valor.'"  '.$requerido.' onkeydown="return soloLetras(event)" autocomplete="off">
					<input type="hidden" name="rev_'.$name.'" id="rev_'.$name.'" value="'.$aValidar.'" >
				</div>
			</div>';

		/******************************************/
		//ejecucion script
		$input .= '
				<script>
				function autocomplete(inp, arr) {
					/*the autocomplete function takes two arguments,
					the text field element and an array of possible autocompleted values:*/
					var currentFocus;
					/*execute a function when someone writes in the text field:*/
					inp.addEventListener("input", function(e) {
						var a, b, i, val = this.value;
						/*close any already open lists of autocompleted values*/
						closeAllLists();
						if (!val) { return false;}
						currentFocus = -1;
						/*create a DIV element that will contain the items (values):*/
						a = document.createElement("DIV");
						a.setAttribute("id", this.id + "autocomplete-list");
						a.setAttribute("class", "autocomplete-items");
						/*append the DIV element as a child of the autocomplete container:*/
						this.parentNode.appendChild(a);
						/*for each item in the array...*/
						for (i = 0; i < arr.length; i++) {
							/*check if the item starts with the same letters as the text field value:*/
							if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
								/*create a DIV element for each matching element:*/
								b = document.createElement("DIV");
								/*make the matching letters bold:*/
								b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
								b.innerHTML += arr[i].substr(val.length);
								/*insert a input field that will hold the current array items value:*/
								b.innerHTML += "<input type=\'hidden\' value=\'" + arr[i] + "\'>";
								/*execute a function when someone clicks on the item value (DIV element):*/
								b.addEventListener("click", function(e) {
									/*insert the value for the autocomplete text field:*/
									inp.value = this.getElementsByTagName("input")[0].value;
									/*close the list of autocompleted values,
									(or any other open lists of autocompleted values:*/
									closeAllLists();
								});
							a.appendChild(b);
							}
						}
					});
					/*execute a function presses a key on the keyboard:*/
					inp.addEventListener("keydown", function(e) {
						var x = document.getElementById(this.id + "autocomplete-list");
						if (x) x = x.getElementsByTagName("div");
						if (e.keyCode == 40) {
							/*If the arrow DOWN key is pressed,
							increase the currentFocus variable:*/
							currentFocus++;
							/*and and make the current item more visible:*/
							addActive(x);
						} else if (e.keyCode == 38) { //up
							/*If the arrow UP key is pressed,
							decrease the currentFocus variable:*/
							currentFocus--;
							/*and and make the current item more visible:*/
							addActive(x);
						} else if (e.keyCode == 13) {
							/*If the ENTER key is pressed, prevent the form from being submitted,*/
							e.preventDefault();
							if (currentFocus > -1) {
								/*and simulate a click on the "active" item:*/
								if (x) x[currentFocus].click();
							}
						}
					});
					function addActive(x) {
						/*a function to classify an item as "active":*/
						if (!x) return false;
						/*start by removing the "active" class on all items:*/
						removeActive(x);
						if (currentFocus >= x.length) currentFocus = 0;
						if (currentFocus < 0) currentFocus = (x.length - 1);
						/*add class "autocomplete-active":*/
						x[currentFocus].classList.add("autocomplete-active");
					}
					function removeActive(x) {
						/*a function to remove the "active" class from all autocomplete items:*/
						for (let i = 0; i < x.length; i++) {
						  x[i].classList.remove("autocomplete-active");
						}
					}
					function closeAllLists(elmnt) {
						/*close all autocomplete lists in the document,
						except the one passed as an argument:*/
						var x = document.getElementsByClassName("autocomplete-items");
						for (let i = 0; i < x.length; i++) {
						  if (elmnt != x[i] && elmnt != inp) {
							x[i].parentNode.removeChild(x[i]);
						  }
						}
					}
					/*execute a function when someone clicks in the document:*/
					document.addEventListener("click", function (e) {
						closeAllLists(e.target);
					});
				}';

			$input .= '
				/*An array containing all the country names in the world:*/
				var vali_val = [""';

				//limpio y separo los datos de la cadena de comprobacion
				$obligatorios = str_replace(' ', '', $aValidar);
				$piezas       = explode(",", $obligatorios);
				//recorro los elementos
				foreach ($piezas as $validd) {
					$input .= ',"'.$validd.'"';
				}

			$input .= '];

			/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
			autocomplete(document.getElementById("'.$name.'"), vali_val);
		</script>';

		/******************************************/
		//Imprimir dato
		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_tel_group_sens($placeholder,$name, $idChanged, $idForm, $required, $dbConn){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************/
		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		// Se trae un listado de todos los registros
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.cantSensores';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_grupo`    ON telemetria_listado_sensores_grupo.idTelemetria    = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_nombre`   ON telemetria_listado_sensores_nombre.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`   ON telemetria_listado_sensores_activo.idTelemetria   = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'telemetria_listado.idTelemetria ASC';
		$arrSelect = array();
		$arrSelect = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');
		// Se trae un listado de todos los registros
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorren los grupos
		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
		}

		/******************************/
		//se dibuja
		$input = '<div class="form-group" id="div_'.$name.'" >
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.'>
								<option value="" selected>Seleccione una Opción</option>
							</select>
						</div>
					</div>';

		/******************************************/
		//script
		$input .= '<script>';
		$input .= 'document.getElementById("'.$idChanged.'").onchange = function() {cambia_'.$idChanged.'()};';

		foreach ($arrSelect as $select) {
			$id_data = 'let id_data_'.$select['idTelemetria'].'=new Array(""';
			$data    = 'let data_'.$select['idTelemetria'].'=new Array("Seleccione una Opción"';
			//se arma arreglo temporal
			$arrTempGrupos = array();
			//recorro
			for ($i = 1; $i <= $select['cantSensores']; $i++) {
				//solo sensores activos
				if(isset($select['SensoresActivo_'.$i])&&$select['SensoresActivo_'.$i]==1){
					//si el arreglo temporal existe
					if(isset($arrTempGrupos[$select['SensoresGrupo_'.$i]])&&$arrTempGrupos[$select['SensoresGrupo_'.$i]]==1){
						//nada
					}else{
						/***************************/
						//id_data
						$id_data .= ',"'.$i.'"';

						/***************************/
						//data
						if(isset($arrFinalGrupos[$select['SensoresGrupo_'.$i]])){
							$grupo = $arrFinalGrupos[$select['SensoresGrupo_'.$i]].' - ';
						}else{
							$grupo = '';
						}
						$data .= ',"'.$grupo.str_replace('"', '',$select['SensoresNombre_'.$i]).'"';

						/***************************/
						//genero valor
						$arrTempGrupos[$select['SensoresGrupo_'.$i]] = 1;
					}
				}
			}
			$id_data .= ')
			';
			$data .= ')
			';
			/***************************/
			//guardo dentro del input
			$input .= $id_data;
			$input .= $data;
		}

		/******************************************/
		//ejecucion script
		$input .= '
		function cambia_'.$idChanged.'(){

			let Componente = document.'.$idForm.'.'.$idChanged.'[document.'.$idForm.'.'.$idChanged.'.selectedIndex].value
			try {
				if (Componente != "") {
					id_data = eval("id_data_" + Componente);
					data    = eval("data_" + Componente);
					num_int = id_data.length;
					document.'.$idForm.'.'.$name.'.length = num_int;
					for(i=0;i<num_int;i++){
						document.'.$idForm.'.'.$name.'.options[i].value = id_data[i];
						document.'.$idForm.'.'.$name.'.options[i].text  = data[i];
					}
					document.getElementById("div_'.$name.'").style.display = "block";
				}else{
					document.'.$idForm.'.'.$name.'.length = 1;
					document.'.$idForm.'.'.$name.'.options[0].value = "";
					document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
					document.getElementById("div_'.$name.'").style.display = "none";
				}
			} catch (e) {
				document.'.$idForm.'.'.$name.'.length = 1;
				document.'.$idForm.'.'.$name.'.options[0].value = "";
				document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
				document.getElementById("div_'.$name.'").style.display = "none";

			}
			document.'.$idForm.'.'.$name.'.options[0].selected = true;
		}
		</script>';

		/******************************************/
		//imprimo
		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_tel_group($placeholder,$name, $idChanged, $idForm, $required, $dbConn){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************/
		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		// Se trae un listado de todos los registros
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.cantSensores';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'telemetria_listado.idTelemetria ASC';
		$arrSelect = array();
		$arrSelect = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');
		// Se trae un listado de todos los registros
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorren los grupos
		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
		}

		/******************************/
		//se dibuja
		$input = '
		<div class="form-group" id="div_'.$name.'" >
			<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
				<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.'>
					<option value="" selected>Seleccione una Opción</option>
				</select>
			</div>
		</div>';

		/******************************************/
		//script
		$input .= '<script>';
		$input .= 'document.getElementById("'.$idChanged.'").onchange = function() {cambia_'.$idChanged.'()};';

		foreach ($arrSelect as $select) {
			$id_data = 'let id_data_'.$select['idTelemetria'].'=new Array(""';
			$data    = 'let data_'.$select['idTelemetria'].'=new Array("Seleccione una Opción"';
			$valorx  = 0;
			//se arma arreglo temporal
			$arrTempGrupos = array();
			//recorro
			for ($i = 1; $i <= $select['cantSensores']; $i++) {
				//solo sensores activos
				if(isset($select['SensoresActivo_'.$i])&&$select['SensoresActivo_'.$i]==1){
					//si el arreglo temporal existe
					if(isset($arrTempGrupos[$select['SensoresGrupo_'.$i]])&&$arrTempGrupos[$select['SensoresGrupo_'.$i]]==1){
						//nada
					}else{
						//ejecuto
						//verifico que el grupo no este ingresado
						if($valorx != $select['SensoresGrupo_'.$i]){

							/***************************/
							//guardo valor
							$valorx = $select['SensoresGrupo_'.$i];
							//genero valor
							$arrTempGrupos[$select['SensoresGrupo_'.$i]] = 1;

							if($valorx!=0){
								/***************************/
								//id_data
								$id_data .= ',"'.$valorx.'"';

								/***************************/
								//data
								if(isset($arrFinalGrupos[$select['SensoresGrupo_'.$i]])){
									$grupo = $arrFinalGrupos[$select['SensoresGrupo_'.$i]];
								}else{
									$grupo = '';
								}
								$data .= ',"'.$grupo.'"';
							}
						}
					}
				}
			}
			$id_data .= ')
			';
			$data .= ')
			';

			/***************************/
			//guardo dentro del input
			$input .= $id_data;
			$input .= $data;

		}

		/******************************************/
		//ejecucion script
		$input .= '
		function cambia_'.$idChanged.'(){

			let Componente = document.'.$idForm.'.'.$idChanged.'[document.'.$idForm.'.'.$idChanged.'.selectedIndex].value
			try {
				if (Componente != "") {
					id_data = eval("id_data_" + Componente);
					data    = eval("data_" + Componente);
					num_int = id_data.length;
					document.'.$idForm.'.'.$name.'.length = num_int;
					for(i=0;i<num_int;i++){
						document.'.$idForm.'.'.$name.'.options[i].value = id_data[i];
						document.'.$idForm.'.'.$name.'.options[i].text  = data[i];
					}
					document.getElementById("div_'.$name.'").style.display = "block";
				}else{
					document.'.$idForm.'.'.$name.'.length = 1;
					document.'.$idForm.'.'.$name.'.options[0].value = "";
					document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
					document.getElementById("div_'.$name.'").style.display = "none";
				}
			} catch (e) {
				document.'.$idForm.'.'.$name.'.length = 1;
				document.'.$idForm.'.'.$name.'.options[0].value = "";
				document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
				document.getElementById("div_'.$name.'").style.display = "none";

			}
			document.'.$idForm.'.'.$name.'.options[0].selected = true;
		}
		</script>';

		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_tel_group_apert($placeholder,$name, $idChanged, $idForm, $required, $dbConn){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/******************************/
		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		}
		// Se trae un listado de todos los registros
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.cantSensores'.$subquery;
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'telemetria_listado.idTelemetria ASC';
		$arrSelect = array();
		$arrSelect = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');
		// Se trae un listado de todos los registros
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorren los grupos
		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
		}

		/******************************/
		//se dibuja
		$input = '<div class="form-group" id="div_'.$name.'" >
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.'>
								<option value="" selected>Seleccione una Opción</option>
							</select>
						</div>
					</div>';

		/******************************************/
		//script
		$input .= '<script>';
		$input .= 'document.getElementById("'.$idChanged.'").onchange = function() {cambia_'.$idChanged.'()};';

		foreach ($arrSelect as $select) {
			$id_data = 'let id_data_'.$select['idTelemetria'].'=new Array(""';
			$data    = 'let data_'.$select['idTelemetria'].'=new Array("Seleccione una Opción"';
			$valorx  = 0;
			//se arma arreglo temporal
			$arrTempGrupos = array();
			//recorro
			for ($i = 1; $i <= $select['cantSensores']; $i++) {
				//solo sensores activos
				if(isset($select['SensoresUniMed_'.$i],$select['SensoresActivo_'.$i])&&$select['SensoresUniMed_'.$i]==12&&$select['SensoresActivo_'.$i]==1){
					//si el arreglo temporal existe
					if(isset($arrTempGrupos[$select['SensoresGrupo_'.$i]])&&$arrTempGrupos[$select['SensoresGrupo_'.$i]]==1){
						//nada
					}else{
						//ejecuto
						//verifico que el grupo no este ingresado
						if($valorx != $select['SensoresGrupo_'.$i]){

							/***************************/
							//guardo valor
							$valorx = $select['SensoresGrupo_'.$i];
							//genero valor
							$arrTempGrupos[$select['SensoresGrupo_'.$i]] = 1;

							if($valorx!=0){
								/***************************/
								//id_data
								$id_data .= ',"'.$valorx.'"';

								/***************************/
								//data
								if(isset($arrFinalGrupos[$select['SensoresGrupo_'.$i]])){
									$grupo = $arrFinalGrupos[$select['SensoresGrupo_'.$i]];
								}else{
									$grupo = '';
								}
								$data .= ',"'.$grupo.'"';
							}
						}
					}
				}
			}
			$id_data .= ')
			';
			$data .= ')
			';

			/***************************/
			//guardo dentro del input
			$input .= $id_data;
			$input .= $data;

		}

		/******************************************/
		//ejecucion script
		$input .= '
		function cambia_'.$idChanged.'(){

			let Componente = document.'.$idForm.'.'.$idChanged.'[document.'.$idForm.'.'.$idChanged.'.selectedIndex].value
			try {
				if (Componente != "") {
					id_data = eval("id_data_" + Componente);
					data    = eval("data_" + Componente);
					num_int = id_data.length;
					document.'.$idForm.'.'.$name.'.length = num_int;
					for(i=0;i<num_int;i++){
						document.'.$idForm.'.'.$name.'.options[i].value = id_data[i];
						document.'.$idForm.'.'.$name.'.options[i].text  = data[i];
					}
					document.getElementById("div_'.$name.'").style.display = "block";
				}else{
					document.'.$idForm.'.'.$name.'.length = 1;
					document.'.$idForm.'.'.$name.'.options[0].value = "";
					document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
					document.getElementById("div_'.$name.'").style.display = "none";
				}
			} catch (e) {
				document.'.$idForm.'.'.$name.'.length = 1;
				document.'.$idForm.'.'.$name.'.options[0].value = "";
				document.'.$idForm.'.'.$name.'.options[0].text  = "Seleccione una Opción";
				document.getElementById("div_'.$name.'").style.display = "none";

			}
			document.'.$idForm.'.'.$name.'.options[0].selected = true;
		}
		</script>';

		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_col_tem_hum($placeholder, $name, $required){

		/******************************************/
		//Valido si es requerido
		switch ($required) {
			//Si el dato no es requerido
			case 1:
				$requerido = '';//variable vacia
				break;
			//Si el dato es requerido
			case 2:
				$requerido = 'required'; //se marca como requerido
				if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
				$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
				break;
		}

		/****************************************************************/
		//seleccionar temperatura o humedad
		$input = '
					<div class="form-group" id="div_'.$name.'" >
						<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.'>
								<option value="" selected>Seleccione una Opción</option>
								<option value="1">Temperatura</option>
								<option value="2">Humedad</option>
							</select>
						</div>
					</div>';
		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_tel_group_checkbox($placeholder,$name, $idChanged, $idForm, $dbConn){

		/******************************/
		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		// Se trae un listado de todos los registros
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.cantSensores';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'telemetria_listado.idTelemetria ASC';
		$arrSelect = array();
		$arrSelect = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');
		// Se trae un listado de todos los registros
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorren los grupos
		$arrFinalGrupos = array();
		foreach ($arrGrupos as $sen) {
			$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
		}

		/******************************/
		//se dibuja
		$input = '
		<div class="form-group" id="div_'.$name.'">
			<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">';
				//recorro los equipos
				foreach ($arrSelect as $select) {
					//div para ocultar
					$input .= '<div class="div_group_tel" id="div_group_tel_'.$name.'_'.$select['idTelemetria'].'">';
					//variables
					$valorx  = 0;
					//se arma arreglo temporal
					$arrTempGrupos = array();
					//recorro
					for ($i = 1; $i <= $select['cantSensores']; $i++) {
						//solo sensores activos
						if(isset($select['SensoresActivo_'.$i])&&$select['SensoresActivo_'.$i]==1){
							//si el arreglo temporal existe
							if(isset($arrTempGrupos[$select['SensoresGrupo_'.$i]])&&$arrTempGrupos[$select['SensoresGrupo_'.$i]]==1){
								//nada
							}else{
								//verifico que el grupo no este ingresado
								if($valorx != $select['SensoresGrupo_'.$i]){
									//guardo valor
									$valorx = $select['SensoresGrupo_'.$i];
									//genero valor
									$arrTempGrupos[$select['SensoresGrupo_'.$i]] = 1;
									if($valorx!=0){
										$input .= '
										<div class="checkbox checkbox-primary">
											<input class="styled" type="checkbox" value="'.$valorx.'" name="'.$name.'[]">
											<label for="'.$name.'[]">
												'.TituloMenu($arrFinalGrupos[$select['SensoresGrupo_'.$i]]).'
											</label>
										</div>';
									}
								}
							}
						}
					}
					//cierro div
					$input .= '</div>';
				}
			//cierro div
			$input .= '
			</div>
		</div>';

		/******************************************/
		//script
		$input .= '
		<script>
			//oculto todos los div
			$(".div_group_tel").hide();
			//ejecuto segun
			$("#'.$idChanged.'").on("change", function() {
				//oculto todos los div
				$(".div_group_tel").hide();
				//obtengo id
				let Componente = document.'.$idForm.'.'.$idChanged.'[document.'.$idForm.'.'.$idChanged.'.selectedIndex].value
				try {
					if (Componente != "") {
						document.getElementById("div_group_tel_'.$name.'_" + Componente).style.display = "block";
					}else{
						document.getElementById("div_group_tel_'.$name.'_" + Componente).style.display = "none";
					}
				} catch (e) {
					document.getElementById("div_group_tel_'.$name.'_" + Componente).style.display = "none";
				}
			});
		</script>';

		echo $input;
	}
	/*******************************************************************************************************************/
	public function form_select_tel_unimed_radio($placeholder,$name, $idChanged, $idForm, $dbConn){

		/******************************/
		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		// Se trae un listado de todos los registros
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.cantSensores';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_unimed`   ON telemetria_listado_sensores_unimed.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$SIS_order = 'telemetria_listado.idTelemetria ASC';
		$arrSelect = array();
		$arrSelect = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');
		// Se trae un listado de todos los registros
		$arrUniMed = array();
		$arrUniMed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUniMed');
		//se recorren los grupos
		$arrFinalUniMed = array();
		foreach ($arrUniMed as $sen) {
			$arrFinalUniMed[$sen['idUniMed']] = $sen['Nombre'];
		}

		/******************************/
		//se dibuja
		$input = '
		<div class="form-group" id="div_'.$name.'">
			<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">';
				//recorro los equipos
				foreach ($arrSelect as $select) {
					//div para ocultar
					$input .= '<div class="div_radio_tel" id="div_radio_tel_'.$name.'_'.$select['idTelemetria'].'">';
					//variables
					$valorx  = 0;
					//se arma arreglo temporal
					$arrTempUniMed = array();
					//recorro
					for ($i = 1; $i <= $select['cantSensores']; $i++) {
						//solo sensores activos
						if(isset($select['SensoresActivo_'.$i])&&$select['SensoresActivo_'.$i]==1){
							//si el arreglo temporal existe
							if(isset($arrTempUniMed[$select['SensoresUniMed_'.$i]])&&$arrTempUniMed[$select['SensoresUniMed_'.$i]]==1){
								//nada
							}else{
								//verifico que el grupo no este ingresado
								if($valorx != $select['SensoresUniMed_'.$i]&&($select['SensoresUniMed_'.$i]==2 OR $select['SensoresUniMed_'.$i]==3 OR $select['SensoresUniMed_'.$i]==13)){
									//guardo valor
									$valorx = $select['SensoresUniMed_'.$i];
									//genero valor
									$arrTempUniMed[$select['SensoresUniMed_'.$i]] = 1;
									if($valorx!=0){
										$input .= '
										<div class="radio radio-primary">
											<input type="radio" value="'.$valorx.'"  name="'.$name.'">
											<label for="SensoresUniMed">'.TituloMenu($arrFinalUniMed[$select['SensoresUniMed_'.$i]]).'</label>
										</div>';
									}
								}
							}
						}
					}
					//cierro div
					$input .= '</div>';
				}
			//cierro div
			$input .= '
			</div>
		</div>';

		/******************************************/
		//script
		$input .= '
		<script>
			//oculto todos los div
			$(".div_radio_tel").hide();
			//ejecuto segun
			$("#'.$idChanged.'").on("change", function() {
				//oculto todos los div
				$(".div_radio_tel").hide();
				//obtengo id
				let Componente = document.'.$idForm.'.'.$idChanged.'[document.'.$idForm.'.'.$idChanged.'.selectedIndex].value
				try {
					if (Componente != "") {
						document.getElementById("div_radio_tel_'.$name.'_" + Componente).style.display = "block";
					}else{
						document.getElementById("div_radio_tel_'.$name.'_" + Componente).style.display = "none";
					}
				} catch (e) {
					document.getElementById("div_radio_tel_'.$name.'_" + Componente).style.display = "none";
				}
			});
		</script>';

		echo $input;
	}

}

?>
