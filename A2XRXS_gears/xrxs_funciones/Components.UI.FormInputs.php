<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1002-001).');
}
/*******************************************************************************************************************/
/*                                                    Clases                                                       */
/*******************************************************************************************************************/
class Basic_Form_Inputs{

	/////////////////////////////        PRIVADAS        /////////////////////////////
	/****************************************************************************************/
	//Crea el input en base a los datos
	private function chosen_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos){

		/******************************************/
		//se llama por obligacion libreria javascript desde aqui, porque en el head da problemas
		$data = '<script type="text/javascript" src="'.DB_SITE_REPO.'/LIBS_js/chosen/chosen.jquery.min.js"></script>';

		/******************************************/
		//generacion del input
		$data .= '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" '.$requerido.' data-placeholder="Seleccione una Opción" class="form-control chosen-select chosendiv_'.$name.' " tabindex="2" >
						<option value=""></option>';

						/******************************************/
						//se recorren las opciones
						foreach ( $arrSelect as $select ) {

							/******************************************/
							//Variables
							$selected     = '';
							$data_writing = '';

							/******************************************/
							//si la opción actual esta seleccionada
							if($value==$select['idData']){$selected = 'selected="selected"';}

							/******************************************/
							//Escribo los datos solicitados
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								//se crea cadena
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}

							/******************************************/
							//se escribe
							$data .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
						}

				$data .= '
					</select>
				</div>
			</div>';

		/******************************************/
		//devuelvo
		return $data;
	}
	/****************************************************************************************/
	//Funcionalidad de chosen
	private function chosen_select_script($name){

		/******************************************/
		//ejecucion script
		$data = '
		<script type="text/javascript">
			$.fn.oldChosen = $.fn.chosen;
			$.fn.chosen = function(options) {
				var selectcz_'.$name.' = $(".chosendiv_'.$name.'") , is_creating_chosen_'.$name.' = !!options;

				if (is_creating_chosen_'.$name.' && selectcz_'.$name.'.css(\'position\') === \'absolute\') {
					selectcz_'.$name.'.removeAttr(\'style\');
				}

				var ret_'.$name.' = selectcz_'.$name.'.oldChosen(options);

				if (is_creating_chosen_'.$name.') {
					selectcz_'.$name.'.attr(\'style\',\'display:visible; position:absolute; clip:rect(0,0,0,0)\');
					selectcz_'.$name.'.attr(\'tabindex\', -1);
				}

				return ret_'.$name.';
			}
			$(\'selectcz_'.$name.'\').chosen({allow_single_deselect: true});

		</script>';

		/******************************************/
		//devuelvo
		return $data;
	}
	/****************************************************************************************/
	//si chosen es obligatorio chosen
	private function chosen_required($name, $required){

		//validacion si es requerido
		if($required==2){
			$data ='<style>#div_'.$name.' .chosen-single {background:url('.DB_SITE_REPO.'/LIB_assets/img/required.png) no-repeat 5px center !important;background-color: #fff !important;}</style>';
		}else{
			$data = '';
		}

		/******************************************/
		//devuelvo
		return $data;
	}
	/****************************************************************************************/
	//Crea el input en base a los datos
	private function select_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos){

		/******************************************/
		//generacion del input
		$data = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" class="form-control select2_'.$name.'" '.$requerido.' >';
						//Recorro
						$selectedx = 'selected="selected"';
						foreach ( $arrSelect as $select ) {
							if($value==$select['idData']){
								$selectedx = '';
							}
						}

						$data .= '<option value="" '.$selectedx.'>Seleccione una Opción</option>';

						/******************************************/
						//Recorro
						foreach ( $arrSelect as $select ) {

							/******************************************/
							//Variables
							$selected     = '';
							$data_writing = '';

							/******************************************/
							//si la opción actual esta seleccionada
							if($value==$select['idData']){$selected = 'selected="selected"';}

							/******************************************/
							//Escribo los datos solicitados
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								//se crea cadena
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}

							/******************************************/
							//se escribe
							$data .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
						}
					$data .= '
					</select>
				</div>
			</div>';

		/******************************************/
		//devuelvo
		return $data;
	}
	/****************************************************************************************/
	//Crea el input en base a los datos
	private function select_input_empty($name, $placeholder, $requerido){

		/******************************************/
		//generacion del input
		$data = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
						<option value="" selected>Seleccione una Opción</option>
					</select>
				</div>
			</div>';

		/******************************************/
		//devuelvo
		return $data;
	}
	/****************************************************************************************/
	//Funcionalidad de select depend
	private function select_input_script($arrSelect, $Value, $name_1, $name_2, $datos, $form_name){
		//para corregir consulta en caso de vacio
		if(!isset($Value) OR $Value == ''){$Value = 0;}

		/******************************************/
		//ejecucion script
		$data = '<script>';

		//Filtro el segundo select con el id del primer select
		filtrar($arrSelect, 'idDataFilter');
		//caracteres prohibidos
		$vowels = array(" ", "´", "-");
		//recorro
		foreach($arrSelect as $tipo=>$componentes){
			//creo variable
			$Int_id_data = 'let id_data_'.$name_1.'_'.str_replace($vowels, '_',$tipo).'=new Array(""';
			$Int_data    = 'let data_'.$name_1.'_'.str_replace($vowels, '_',$tipo).'=new Array("Seleccione una Opción"';
			//recorro los datos
			foreach ($componentes as $idcomp) {
				//Escribo los datos solicitados
				if(count($datos)==1){
					$data_writing = TituloMenu(DeSanitizar($idcomp[$datos[0]])).' ';
				}else{
					$data_writing = '';
					foreach($datos as $dato){
						$data_writing .= TituloMenu(DeSanitizar($idcomp[$dato])).' ';
					}
				}
				//Guardo los datos
				$Int_id_data .= ',"'.$idcomp['idData'].'"';
				$Int_data    .= ',"'.str_replace('"', '',$data_writing).'"';
			}
			//cierro variable
			$Int_id_data .= ');';
			$Int_data    .= ');';
			//traspaso los datos
			$data .= $Int_id_data;
			$data .= $Int_data;

		}

		$data .= '
			//Se ocultan los select
			document.getElementById("div_'.$name_2.'").style.display = "none";
			//Si el select cambio
			document.getElementById("'.$name_1.'").onchange = function() {cngFnc_'.$name_1.'()};
			//Valor preseleccionado
			let slected_'.$name_2.' = 0;

			//Funcion cambio de estado
			function cngFnc_'.$name_1.'() {
				//Obtengo valor
				let Componente = document.getElementById("'.$name_1.'").value;
				//Verifico que valor exista
				if (Componente != "") {
					//actualizo los datos del select
					try {
						//Obtengo las variables con los id y los datos
						slectId_'.$name_1.'   = eval("id_data_'.$name_1.'_" + Componente);
						slectData_'.$name_1.' = eval("data_'.$name_1.'_" + Componente);
						//indico al select el numero de elementos
						document.'.$form_name.'.'.$name_2.'.length = slectId_'.$name_1.'.length;
						//recorro elementos y lo inserto al select
						for(i=0;i<slectId_'.$name_1.'.length;i++){
							document.'.$form_name.'.'.$name_2.'.options[i].value = slectId_'.$name_1.'[i];
							document.'.$form_name.'.'.$name_2.'.options[i].text  = slectData_'.$name_1.'[i];
						}
						//muestro el select
						document.getElementById("div_'.$name_2.'").style.display = "block";
					//si el select previo da error
					} catch (error) {
						for (let i = document.'.$form_name.'.'.$name_2.'.options.length; i >= 0; i--) {
							document.'.$form_name.'.'.$name_2.'.remove(i);
						}
						//Ingreso dato
						document.'.$form_name.'.'.$name_2.'.length = 1;
						document.'.$form_name.'.'.$name_2.'.options[0].value = 0;
						document.'.$form_name.'.'.$name_2.'.options[0].text  = "Seleccione una Opción";
					}
				//si el select previo no tiene datos
				}else{
					for (let i = document.'.$form_name.'.'.$name_2.'.options.length; i >= 0; i--) {
						document.'.$form_name.'.'.$name_2.'.remove(i);
					}
				}
				//reposiciono el selected al primer elemento
				document.getElementById("'.$name_2.'").selectedIndex = "0";
			}

			//al cargar pagina
			$(document).ready(function(){
				//Obtengo valor
				let Componente = document.getElementById("'.$name_1.'").value;
				//Verifico que valor exista
				if (Componente != "") {
					//actualizo los datos del select
					try {
						//Obtengo las variables con los id y los datos
						slectId_'.$name_1.'   = eval("id_data_'.$name_1.'_" + Componente);
						slectData_'.$name_1.' = eval("data_'.$name_1.'_" + Componente);
						//indico al select el numero de elementos
						document.'.$form_name.'.'.$name_2.'.length = slectId_'.$name_1.'.length;
						//recorro elementos y lo inserto al select
						for(i=0;i<slectId_'.$name_1.'.length;i++){
							document.'.$form_name.'.'.$name_2.'.options[i].value = slectId_'.$name_1.'[i];
							document.'.$form_name.'.'.$name_2.'.options[i].text  = slectData_'.$name_1.'[i];
							//guardo el id del index en caso de que coincidan los id de los elementos
							if(slectId_'.$name_1.'[i] == '.$Value.'){
								slected_'.$name_2.' = i;
							}
						}
						//muestro el select
						document.getElementById("div_'.$name_2.'").style.display = "block";
						//indico el selectedIndex que tiene asignado
						document.getElementById("'.$name_2.'").selectedIndex = slected_'.$name_2.';
					//si el select previo da error
					} catch (error) {
						//nada
					}
				}
			});';

		$data .= '</script>';

		/******************************************/
		//devuelvo
		return $data;
	}

	/******************************************/

	/////////////////////////////        PUBLICAS        /////////////////////////////
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un titulo
	*
	*===========================     Detalles    ===========================
	* Permite un titulo para los formularios
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_tittle(1, 'dato' );
	* 	$Form->form_tittle(2, '<strong>Dato:</strong>explicacion' );
	* 	$Form->form_tittle(3, '<strong>Dato 1:</strong>explicacion 1 <br/><strong>Dato 2:</strong>explicacion 2' );
	* 	$Form->form_tittle(4, 'bla' );
	* 	$Form->form_tittle(5, 'bla' );
	* 	$Form->form_tittle(6, 'bla' );
	*
	*===========================    Parametros   ===========================
	* String   $type      Tipo de titulo
	* String   $Text      Texto del titulo
	* @return  String
	************************************************************************/
	public function form_tittle($type, $Text){

		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6, 7);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($type, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $type ('.$type.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de mensaje
			$options = ['h1', 'h2', 'h3', 'h4', 'h5', 'p', 'strong'];
			$tipo    = $options[$type-1];

			/******************************************/
			//generacion del input
			$input = '<'.$tipo.' class="title_'.$tipo.'">'.$Text.'</'.$tipo.'>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un cuadro de mensaje
	*
	*===========================     Detalles    ===========================
	* Permite crear un cuadro de alerta mostrando mensajes de explicacion
	* para los inputs
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_post_data(1,1,1, 'dato' );
	* 	$Form->form_post_data(2,1,1, '<strong>Dato:</strong>explicacion' );
	* 	$Form->form_post_data(3,1,1, '<strong>Dato 1:</strong>explicacion 1 <br/><strong>Dato 2:</strong>explicacion 2' );
	* 	$Form->form_post_data(4,1,1, 'bla' );
	*
	*===========================    Parametros   ===========================
	* String   $type           Tipo de mensaje
	* String   $icon           icono a utilizar(fontawesome)
	* String   $iconAnimation  Animacion del icono
	* String   $Text           Texto del mensaje
	* @return  String
	************************************************************************/
	public function form_post_data($type, $icon, $iconAnimation, $Text){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5);
		$requerido_2 = array(0,1,2,3);
		$requerido_3 = array(0,1,2,3);
		//Definicion de errores
		$autoClose = 0;
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($type, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $type entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($icon, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $icon entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($iconAnimation, $requerido_3)) {
			alert_post_data(4,1,1,0, 'La configuracion $iconAnimation entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			alert_post_data($type, $icon, $iconAnimation, $autoClose, $Text);
		}

	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Genera una burbuja con informacion sobre el input seleccionado
	*
	*===========================     Detalles    ===========================
	* Permite crear una burbuja de informacion al pasar el cursor sobre
	* el input seleccionada
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	*   $dataC = 'Theres no image Theres no image Theres no image Theres no image';
	* 	$Form->form_info_data('usuario', 'Preview 1', $dataC, 1);
	* 	$Form->form_info_data('usuario', 'Preview 2', $dataC, 2);
	* 	$Form->form_info_data('usuario', 'Preview 3', $dataC, 3);
	* 	$Form->form_info_data('usuario', 'Preview 4', $dataC, 4);
	*
	*===========================    Parametros   ===========================
	* String   $IdElemento      ID del input
	* String   $Titulo          Titulo del mensaje
	* String   $Mensaje         Texto del mensaje
	* int      $Ubicacion       Ubicacion a mostrar la burbuja
	* @return  String
	************************************************************************/
	public function form_info_data($IdElemento, $Titulo, $Mensaje, $Ubicacion){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Ubicacion, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $Ubicacion entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			info_popover_data($IdElemento, $Titulo, $Mensaje, $Ubicacion);
		}

	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input invisible
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que no es mostrado por el navegador,
	* permite pasar datos ocultos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_hidden('idCategoria', 1, 1 );
	* 	$Form->form_input_hidden('Categoria', 'Categoria', 1 );
	* 	$Form->form_input_hidden('idCategoria', 1, 2 );
	*
	*===========================    Parametros   ===========================
	* String   $name       Nombre del identificador del Input
	* String   $value      Valor por defecto, puede ser texto o valor
	* int      $required   Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_hidden($name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			$input = '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' >';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un tipo texto
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_text('Categoria','idCategoria', 1, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_text($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<input type="text" placeholder="'.$placeholder.'" class="form-control"  name="'.$name.'" id="'.$name.'" value="'.$valor.'"  '.$requerido.' onkeydown="return soloLetras(event)">
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo password
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo password, el cual oculta los datos
	* ingresados, pero que permite verlos si se presiona el boton configurado
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_password('Password','password', '', 2 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_password($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'" >'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input type="password" placeholder="'.$placeholder.'"  class="form-control timepicker-default" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)"  >
						<span class="pass_impt" id="view_button_'.$name.'"><i class="fa fa-eye" aria-hidden="true"></i></span>
						<span class="input-group-addon add-on" ><i class="fa fa-key" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .= '
			<script>
				$(document).ready(function() {
					$("#view_button_'.$name.'").bind("mousedown touchstart", function() {
						$("#'.$name.'").attr("type", "text");
					})
					, $("#view_button_'.$name.'").bind("mouseup touchend", function() {
						$("#'.$name.'").attr("type", "password");
					})
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input desactivado
	*
	*===========================     Detalles    ===========================
	* Permite crear un input desactivado, el cual no puede ser modificado
	* por el usuario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_disabled('Dia actual','dia', '2018-02-02');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function form_input_disabled($placeholder,$name, $value){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<input type="text" placeholder="'.$placeholder.'" name="'.$name.'" id="'.$name.'" class="form-control input_disabled" value="'.$valor.'"  disabled="disabled">
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un tipo texto con la opción de poner un icono
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto, con un icono en el lado derecho,
	* el icono es tomado de la libreria de fontawesome
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_icon('Categoria','idCategoria', 1, 1,'fa fa-map');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $icon          icono a utilizar(fontawesome)
	* @return  String
	************************************************************************/
	public function form_input_icon($placeholder,$name, $value, $required, $icon){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''){$valor = $value;}

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'" >'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input type="text" placeholder="'.$placeholder.'"  class="form-control timepicker-default" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)"  >
						<span class="input-group-addon add-on"><i class="'.$icon.'"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo texto que solo admite Rut
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto en el cual solo se pueden ingresar
	* Rut chilenos, estos son formateados (puntos separador de miles) y
	* validados como rut
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_rut('Rut','rut', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_rut($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'" >'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input type="text" placeholder="'.$placeholder.'"  class="form-control timepicker-default" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloRut(event)">
						<span class="input-group-addon add-on"><i class="fa fa-male" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input.='<script>$("#'.$name.'").rut();</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros
	* enteros positivos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_values('Valores Enteros','valores', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_values($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			if($value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)">
						<span class="input-group-addon add-on"><i class="fa fa-usd" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros,
	* permite valores decimales y numeros negativos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_number('Numeros','numeros', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Decimal  $value         Valor por defecto, ingresar numeros enteros o decimales
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_number($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''){$valor = $value;}

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
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros
	* enteros
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_number_integer('Enteros','enteros', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_number_integer($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			if($value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNaturalReal(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-superscript" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Genera un input tipo evaluacion por estrellas
	*
	*===========================     Detalles    ===========================
	* Genera un input tipo evaluacion por estrellas, es altamente configurable
	*
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_nEstrellas('calificacion', 'calif', 5,1,5,1,2);
	* 	$Form->form_nEstrellas('calificacion', 'calif', 5,1,12,1,2);
	* 	$Form->form_nEstrellas('calificacion', 'calif', 1,1,3,1,2);
	* 	$Form->form_nEstrellas('calificacion', 'calif', 5,1,7,1,2);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $min           Valor por minimo, debe ser un numero entero
	* int      $max           Valor por maximo, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $size          Tamaño de las extrellas
	* @return  String
	************************************************************************/
	public function form_nEstrellas($placeholder,$name, $value, $min, $max, $required, $size){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1, 2);
		$requerido_2 = array(0, 1, 2, 3, 4, 5);
		$requerido_3 = array(1, 2, 3, 4, 5);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($value, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $value ('.$value.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($min, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $min ('.$min.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($max, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $max ('.$max.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($size, $requerido_3)) {
			alert_post_data(4,1,1,0, 'La configuracion $size ('.$size.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/************************************************/
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
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
			//Selecciono el tipo de mensaje
			$options = ['xs', 'sm', 'md', 'lg', 'xl'];
			$tamano  = $options[$size-1];

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<input id="'.$name.'" name="'.$name.'" class="rating rating-loading" data-min="'.$min.'" data-max="'.$max.'" data-step="1" value="'.$valor.'" data-size="'.$tamano.'" '.$requerido.'>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}

	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros,
	* permite valores decimales y numeros negativos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_number_alt('Numeros','numeros', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Decimal  $value         Valor por defecto, ingresar numeros enteros o decimales
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_number_alt($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			if($value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: left;">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros,
	* permite valores decimales y numeros negativos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_number_alt('Numeros','numeros', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Decimal  $value         Valor por defecto, ingresar numeros enteros o decimales
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_number_alt2($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			if($value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros,
	* permite valores decimales y numeros negativos, agregando botones
	* en ambos lados, que aumentan o disminuyen los valores ingresados,
	* en los rangos preestablecido
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_number_spinner('Numeros','numeros', '', 1, 50, 1, 2, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Decimal  $value         Valor por defecto, ingresar numeros enteros o decimales
	* Decimal  $min           Valor minimo posible
	* Decimal  $max           Valor maximo posible
	* Decimal  $step          Valor a aumentar o reducir
	* int      $ndecimal      Numero de decimales a aceptar
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_number_spinner($placeholder,$name, $value, $min, $max, $step, $ndecimal, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($min)&&$min!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $min ('.$min.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($max)&&$max!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $max ('.$max.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($step)&&$step!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $step ('.$step.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($ndecimal)&&$ndecimal!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $ndecimal ('.$ndecimal.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//se verifica si es un numero entero lo que se recibe
		if (!validaEntero($ndecimal)&&$ndecimal!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $ndecimal ('.$ndecimal.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname  = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=0){$valor = str_replace(',','.',$value);}

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
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)" style="text-align: center;">
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .= '
			<script>
				//se inicializa el plugin
				$("input[name=\''.$name.'\']").TouchSpin({
					min: '.$min.',
					max: '.$max.',
					step: '.$step.',
					decimals: '.$ndecimal.',
					boostat: 5,
					maxboostedstep: 10
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros
	* enteros positivos, agregando un icono de telefono
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_phone('Telefono','fono', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_phone($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=0){$valor = $value;}

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-phone" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input que solo admite numeros
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que solo permite el ingreso de numeros
	* enteros positivos, agregando un icono de fax
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_fax('Fax','fax', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_fax($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=0){$valor = $value;}

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-fax" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input de fechas
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que muestra un calendario al tratar de escribir
	* dentro de este, una vez seleccionada la fecha, el calendario
	* traspasa la fecha al input
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_date('Fecha','fecha', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Date     $value         Valor por defecto, debe tener formato fecha
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_date($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validaFecha($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una fecha');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

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
			if($value!=0&&$value!='0000-00-00'){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'" class="form-control timepicker-default" type="date" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' >
						<span class="input-group-addon add-on"><i class="fa fa-calendar" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input de fechas
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que muestra un calendario al tratar de escribir
	* dentro de este, una vez seleccionada la fecha, el calendario
	* traspasa la fecha al input
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_date('Fecha','fecha', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Date     $value         Valor por defecto, debe tener formato fecha
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_date($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validaFecha($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una fecha');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

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
			if($value!=0&&$value!='0000-00-00'){$valor = $value;}

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'" class="form-control timepicker-default '.$name.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.'>
						<span class="input-group-addon add-on"><i class="fa fa-calendar" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .='
			<script type="text/javascript">
				$(document).ready(function(){
					$("#'.$EXname.'").bootstrapMaterialDatePicker
					({
						time: false,
						lang: "es",
						weekStart: 1,
						cancelText : "Cancelar",
						clearButton: true,
						clearText : "Limpiar",
					});
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input de seleccion de hora
	*
	*===========================     Detalles    ===========================
	* Permite crear un input dentro del cual se selecciona la hora que se
	* desea ingresar, el selector de hora aparece al presionar dentro del
	* input, una vez seleccionada la hora esta sera traspasada al input
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_time('Hora', 'hora','', 1,1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Time     $value         Valor por defecto, debe tener formato hora
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $position      Posicion (1=arriba, 2=abajo)
	* @return  String
	************************************************************************/
	public function form_time($placeholder,$name, $value, $required, $position){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($position, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $position ('.$position.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		/*if (!validaHora($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una hora');
			$errorn++;
		}*/
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

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
			//Posicion de la burbuja
			$options = ['top', 'bottom'];
			$x_pos   = $options[$position-1];

			/******************************************/
			//generacion del input
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.'   >
						<span class="input-group-addon add-on"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .='
			<script type="text/javascript">
				$("#'.$EXname.'").clockpicker({
					placement: "'.$x_pos.'",
					align: "left",
					donetext: "Listo"
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input de seleccion de hora
	*
	*===========================     Detalles    ===========================
	* Permite crear un input dentro del cual se selecciona la hora que se
	* desea ingresar, el selector de hora aparece al presionar dentro del
	* input, una vez seleccionada la hora esta sera traspasada al input
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_time_popover('Hora Inspeccion','H_inspeccion', '', 1, 1, 24);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Time     $value         Valor por defecto, debe tener formato hora
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $position      Posicion (1=arriba, 2=abajo)
	* int      $limit         Limite de horas a aceptar, ej:24
	* @return  String
	************************************************************************/
	public function form_time_popover($placeholder,$name, $value, $required, $position, $limit){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($position, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $position ('.$position.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($limit)&&$limit!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $limit ('.$limit.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($limit)&&$limit!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $limit ('.$limit.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		//Verifica si el numero recibido es superior a 24
		if ($limit!=''&&$limit>24){
			alert_post_data(4,1,1,0, 'El valor ingresado en $limit ('.$limit.') en <strong>'.$placeholder.'</strong> es superior a 24');
			$errorn++;
		}
		//valido la hora
		if(!validaHora($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El dato ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una hora');
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Posicion de la burbuja
			$options = ['top', 'bottom'];
			$x_pos   = $options[$position-1];

			/******************************************/
			//solicitud recursos
			$input  ='<script src="'.DB_SITE_REPO.'/LIBS_js/popover_timepicker/js/timepicki_'.$x_pos.'.js"></script>';
			$input .='<link rel="stylesheet" type="text/css" href="'.DB_SITE_REPO.'/LIBS_js/popover_timepicker/css/timepicki_'.$x_pos.'.css">';

			/******************************************/
			//ejecucion script
			$input .='
			<script>
				$(document).ready(function(){
					$("#'.$name.'").timepicki({
						show_meridian:false,
						min_hour_value:0,
						max_hour_value:'.$limit.',
						step_size_minutes:1,
						overflow_minutes:true,
						increase_direction:\'up\',
						input_writable: false,
						disable_keyboard_mobile: true
					});
				});
			</script>';

			/******************************************/
			//generacion del input
			$input .='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.'   >
						<span class="input-group-addon add-on"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input de Hora
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que muestra un reloj al tratar de escribir
	* dentro de este, una vez seleccionada la Hora, el reloj
	* traspasa la Hora al input
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_time_picker('Hora','Hora', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Date     $value         Valor por defecto, debe tener formato fecha
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_time_picker($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validaFecha($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una fecha');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

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
			$input ='
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'" class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.'>
						<span class="input-group-addon add-on"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .='
			<script type="text/javascript">
				$(document).ready(function(){
					$("#'.$EXname.'").bootstrapMaterialDatePicker
					({
						date: false,
						shortTime: false,
						format: "HH:mm",
						lang: "es",
						cancelText : "Cancelar",
						clearButton: true,
						clearText : "Limpiar",
					});
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo color
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo selector de colores
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_color_picker('Categoria','idCategoria', 1, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_color_picker($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
					$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
					break;
			}

			/******************************************/
			//Si existe un valor entregado
			$valor  = '';
			$bcolor = '';
			if($value!=''){$valor = $value;$bcolor = 'style="background-color: '.$value.'!important;"';}

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input type="text" placeholder="'.$placeholder.'" class="form-control timepicker-default" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' '.$bcolor.' onkeydown="return soloLetras(event)">
						<span class="input-group-addon add-on"><i class="fa fa-paint-brush" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .= '
			<script type="text/javascript">
				$(function(){
					$("#'.$name.'").colorpickerplus();
					$("#'.$name.'").on("changeColor", function(e,color){
						if(color==null)
							$(this).val("transparent").css("background-color", "#fff");//tranparent
						else
							$(this).val(color).css("background-color", color);
					});
				});
			</script>
			';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un textarea
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo text, en el cual podemos definir su
	* altura a mostrar en el navegador
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_textarea('Observaciones','observaciones', '', 1);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_textarea($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<textarea name="'.$name.'" id="'.$name.'" class="form-control" style="overflow: auto; word-wrap: break-word; resize: horizontal;" '.$requerido.' onkeydown="return soloLetrasTextArea(event)" >'.$valor.'</textarea>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Inserta un editor de texto completo
	*
	*===========================     Detalles    ===========================
	* Permite crear un editor de texto completo
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_ckeditor('Observaciones','observaciones', '', 1, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $tipo          Opciones con los botones a mmostrar
	* @return  String
	************************************************************************/
	public function form_ckeditor($placeholder,$name, $value, $required, $tipo){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		$tipos     = array(1, 2, 3);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($tipo, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $tipo ('.$tipo.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			<div class="txtckedit field">
				<h3>'.$placeholder.'</h3>
				<textarea id="ckeditor_'.$name.'" class="ckeditor" name="'.$name.'" '.$requerido.'>'.$value.'</textarea>
			</div>';

			/******************************************/
			//ejecucion script
			$input .= '<script>';
				//se selecciona el tipo de editor a mostrar
				switch ($tipo) {
					case 1:
						$input .= "CKEDITOR.replace( 'ckeditor_".$name."', {
									toolbar: [
									[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
									{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule' ] },
									{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ],
									items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
									'/',
									{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
									{ name: 'styles', items: [ 'Styles', 'Format' ] }]})";
						break;
					case 2:
						$input .= "CKEDITOR.replace( 'ckeditor_".$name."', {
									toolbar: [
									[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
									{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ],
									items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
									'/',
									{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
									{ name: 'styles', items: [ 'Styles', 'Format' ] }]})";
						break;
					case 3:
						break;
				}

			$input .= '</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input para subir archivos
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que permite subir multiples archivos
	* simultaneamente, con validacion y previsualizacion para algunos
	* tipos de archivo
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_multiple_upload('Subir Archivos','archivos', 10, '"jpg", "png", "gif", "jpeg"' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $max_files     Cantidad Maxima de archivos
	* String   $type_files    Tipo de archivos a aceptar, son validados por el input
	* @return  String
	************************************************************************/
	public function form_multiple_upload($placeholder, $name, $max_files, $type_files){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($max_files)&&$max_files!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $max_files ('.$max_files.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($max_files)&&$max_files!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $max_files ('.$max_files.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Verifico si es mas de un archivo
			if(isset($max_files)&&$max_files!=1){
				$ndat = '[]';
			}else{
				$ndat = '';
			}

			/******************************************/
			//Mostrar Maximo de archivos
			$s_msg  = '<strong><i class="fa fa-file-o" aria-hidden="true"></i> Maximo de Archivos Permitidos: </strong>'.$max_files.'<br/>';
			$s_msg .= '<strong><i class="fa fa-file-o" aria-hidden="true"></i> Extensiones de Archivos Permitidos: </strong><br/>'.$type_files;
			$input  = alert_post_data(2,1,1,0,$s_msg );

			/******************************************/
			//generacion del input
			$input .= '
			<div class="form-group" id="div_'.$name.'">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<input id="kv-'.$name.'" name="'.$name.$ndat.'" type="file" multiple>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input .= '
			<script>
				$(document).ready(function () {
					$("#kv-'.$name.'").fileinput({
						\'theme\': \'explorer\',
						language: "es",
						allowedFileExtensions: ['.$type_files.'],
						maxFileCount: '.$max_files.',
						overwriteInitial: false,
						initialPreviewAsData: true,
						showUpload: false
					});
				});
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_checkbox('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $color         Color del input, tematizado
	* @return  String
	************************************************************************/
	public function form_input_checkbox($placeholder,$name,$value, $required, $color){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Si el tab correspondiente esta seleccionado
			if(isset($value)&&$value==2){
				$check = 'checked';
				$valor = '2';
			}else{
				$check = '';
				$valor = '2';
			}

			/******************************************/
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
			$tipo    = $options[$color-1];

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="checkbox checkbox-'.$tipo.'">
						<input                type="hidden"   value="1"          '.$check.' name="'.$name.'" >
						<input class="styled" type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'">
						<label for="'.$name.'">
							'.$placeholder.'
						</label>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_checkbox_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_checkbox_active($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">';

						/******************************************/
						//Recorro
						foreach ( $arrSelect as $select ) {

							/******************************************/
							//Si el tab correspondiente esta seleccionado
							if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
								$check = 'checked';
								$valor = '2';
							}else{
								$check = '';
								$valor = '2';
							}

							/******************************************/
							//Escribo los datos solicitados
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								$data_writing = '';
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}

							/******************************************/
							$input .= '
							<div class="checkbox checkbox-'.$tipo.'">
								<input                type="hidden"   value="1"          '.$check.' name="'.$name.'_'.$select['idData'].'"  >
								<input class="styled" type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'_'.$select['idData'].'"  id="'.$name.'_'.$select['idData'].'">
								<label for="'.$name.'_'.$select['idData'].'">
									'.TituloMenu(DeSanitizar($data_writing)).'
								</label>
							</div>';

						}

						$input .= '
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_radio('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* String   $required      Si es requerido
	* String   $color         El color del input
	* @return  String
	************************************************************************/
	public function form_input_radio($placeholder,$name,$value, $required, $color){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Si el tab correspondiente esta seleccionado
			if(isset($value)&&$value==2){
				$check = 'checked';
				$valor = '2';
			}else{
				$check = '';
				$valor = '2';
			}

			/******************************************/
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
			$tipo    = $options[$color-1];

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="radio radio-'.$tipo.'">
						<input  type="radio" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'">
						<label for="'.$name.'">
							'.$placeholder.'
						</label>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_radio_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_radio_active($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">';

						/******************************************/
						//Recorro
						foreach ( $arrSelect as $select ) {

							/******************************************/
							//Si el tab correspondiente esta seleccionado
							if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
								$check = 'checked';
								$valor = '2';
							}else{
								$check = '';
								$valor = '2';
							}

							/******************************************/
							//Escribo los datos solicitados
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								$data_writing = '';
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}

							/******************************************/
							$input .= '
							<div class="radio radio-'.$tipo.'">
								<input type="radio" value="'.$valor.'" '.$check.' name="'.$name.'"  id="'.$name.'_'.$select['idData'].'">
								<label for="'.$name.'">
									'.TituloMenu(DeSanitizar($data_writing)).'
								</label>
							</div>';

						}

						$input .= '
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_checkbox('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function form_input_checkbox_funky($placeholder,$name,$value, $required, $color){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Si el tab correspondiente esta seleccionado
			if(isset($value)&&$value==2){
				$check = 'checked';
				$valor = '2';
			}else{
				$check = '';
				$valor = '2';
			}

			/******************************************/
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
			$tipo    = $options[$color-1];

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
                    <div class="funkyradio">
                        <div class="funkyradio-'.$tipo.'">
                            <input type="hidden"   value="1"          '.$check.' name="'.$name.'" >
						    <input type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'" />
                            <label for="'.$name.'">'.$placeholder.'</label>
                        </div>
                    </div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_checkbox_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_checkbox_active_funky($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
                        <div class="funkyradio">';

                            /******************************************/
                            //Recorro
                            foreach ( $arrSelect as $select ) {

                                /******************************************/
                                //Si el tab correspondiente esta seleccionado
                                if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
                                    $check = 'checked';
                                    $valor = '2';
                                }else{
                                    $check = '';
                                    $valor = '2';
                                }

                                /******************************************/
                                //Escribo los datos solicitados
                                if(count($datos)==1){
                                    $data_writing = $select[$datos[0]].' ';
                                }else{
                                    $data_writing = '';
                                    foreach($datos as $dato){
                                        $data_writing .= $select[$dato].' ';
                                    }
                                }

                                /******************************************/
                                $input .= '
                                <div class="funkyradio-'.$tipo.'">
                                    <input type="hidden"   value="1"          '.$check.' name="'.$name.'_'.$select['idData'].'"  >
                                    <input type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'_'.$select['idData'].'"  id="'.$name.'_'.$select['idData'].'">
                                    <label for="'.$name.'_'.$select['idData'].'">'.TituloMenu(DeSanitizar($data_writing)).'</label>
                                </div>';

                            }

                            $input .= '
                        </div>
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_checkbox('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function form_input_radio_funky($placeholder,$name,$value, $required, $color){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Si el tab correspondiente esta seleccionado
			if(isset($value)&&$value==2){
				$check = 'checked';
				$valor = '2';
			}else{
				$check = '';
				$valor = '2';
			}

			/******************************************/
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
			$tipo    = $options[$color-1];

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
                    <div class="funkyradio">
                        <div class="funkyradio-'.$tipo.'">
                            <input  type="radio" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'">
                            <label for="'.$name.'">'.$placeholder.'</label>
                        </div>
                    </div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_checkbox_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_radio_active_funky($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
                        <div class="funkyradio">';

                            /******************************************/
                            //Recorro
                            foreach ( $arrSelect as $select ) {

                                /******************************************/
                                //Si el tab correspondiente esta seleccionado
                                if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
                                    $check = 'checked';
                                    $valor = '2';
                                }else{
                                    $check = '';
                                    $valor = '2';
                                }

                                /******************************************/
                                //Escribo los datos solicitados
                                if(count($datos)==1){
                                    $data_writing = $select[$datos[0]].' ';
                                }else{
                                    $data_writing = '';
                                    foreach($datos as $dato){
                                        $data_writing .= $select[$dato].' ';
                                    }
                                }

                                /******************************************/
                                $input .= '
                                <div class="funkyradio-'.$tipo.'">
                                    <input type="radio" value="'.$valor.'" '.$check.' name="'.$name.'"  id="'.$name.'_'.$select['idData'].'">
                                    <label for="'.$name.'_'.$select['idData'].'">'.TituloMenu(DeSanitizar($data_writing)).'</label>
                                </div>';

                            }

							$input .= '
                        </div>
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_checkbox('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function form_input_switch($placeholder,$name,$value, $required, $color){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

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
			//Si el tab correspondiente esta seleccionado
			if(isset($value)&&$value==2){
				$check = 'checked';
				$valor = '2';
				$label = '<label class="label label-success">Activo</label>';
			}else{
				$check = '';
				$valor = '2';
				$label = '<label class="label label-danger">Inactivo</label>';
			}

			/******************************************/
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
			$tipo    = $options[$color-1];

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					'.$placeholder.' <span id="spn_'.$EXname.'">'.$label.'</span>
					<div class="material-switch pull-right field">
						<input type="hidden"   value="1"          '.$check.' name="'.$name.'" >
						<input type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'" />
						<label for="'.$name.'" class="label-'.$tipo.'"></label>
					</div>
				</div>
			</div>';

			/******************************************/
			//generacion del input
			$input.= '
			<script>
				const checkbox_'.$EXname.' = $("#'.$name.'");

				checkbox_'.$EXname.'.change(function(event) {
					var checkbox_'.$EXname.' = event.target;
					if (checkbox_'.$EXname.'.checked) {
						document.getElementById("spn_'.$EXname.'").innerHTML="<label class=\"label label-success\">Activo</label>";
					} else {
						document.getElementById("spn_'.$EXname.'").innerHTML="<label class=\"label label-danger\">Inactivo</label>";
					}
				});
			</script>
			';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_checkbox_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_switch_active($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						'.$placeholder.'';

						/******************************************/
						//Recorro
						foreach ( $arrSelect as $select ) {

							/******************************************/
							//Si el tab correspondiente esta seleccionado
							if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
								$check = 'checked';
								$valor = '2';
								$label = '<label class="label label-success">Activo</label>';
							}else{
								$check = '';
								$valor = '2';
								$label = '<label class="label label-danger">Inactivo</label>';
							}

							/******************************************/
							//Escribo los datos solicitados
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								$data_writing = '';
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}

							/******************************************/
							$input .= '
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 30px;">
								<div class="pull-left">
									<label>'.TituloMenu(DeSanitizar($data_writing)).'</label> <span id="spn_'.$name.'_'.$select['idData'].'">'.$label.'</span>
								</div>
								<div class="material-switch pull-right field">
									<input type="hidden"   value="1"          '.$check.' name="'.$name.'_'.$select['idData'].'" >
									<input type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'_'.$select['idData'].'" id="'.$name.'_'.$select['idData'].'" />
									<label for="'.$name.'_'.$select['idData'].'" class="label-'.$tipo.'"></label>
								</div>
							</div>';

							/******************************************/
							//generacion del input
							$input.= '
							<script>
								const checkbox_'.$name.'_'.$select['idData'].' = $("#'.$name.'_'.$select['idData'].'");

								checkbox_'.$name.'_'.$select['idData'].'.change(function(event) {
									var checkbox_'.$name.'_'.$select['idData'].' = event.target;
									if (checkbox_'.$name.'_'.$select['idData'].'.checked) {
										document.getElementById("spn_'.$name.'_'.$select['idData'].'").innerHTML="<label class=\"label label-success\">Activo</label>";
									} else {
										document.getElementById("spn_'.$name.'_'.$select['idData'].'").innerHTML="<label class=\"label label-danger\">Inactivo</label>";
									}
								});
							</script>';

						}

						$input .= '
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo checkbox
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo checkbox en base a datos de la base de
	* datos, que lleva por defecto opciones activas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_checkbox_active('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_radio_lateral($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($color, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $color ('.$color.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';
			$arrValTab     = array();
			$y             = 1;

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Valores de cada tab
			$datos2 = explode(",", $value);
			foreach($datos2 as $dato){
				$arrValTab[$y] = $dato;
				$y++;
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $order_by, $dbConn, 'form_checkbox_active', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			//si hay resultados
			if($arrSelect!=false){

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
				//Selecciono el tipo de mensaje
				$options = ['default', 'primary', 'success', 'danger', 'warning', 'info'];
				$tipo    = $options[$color-1];

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="input-group">
							<div id="'.$name.'_div" class="radioBtn btn-group">
								<a class="btn btn-default btn-sm tittle" >'.$placeholder.'</a>';

								/******************************************/
								//contador
								$x = 0;
								//Recorro
								foreach ( $arrSelect as $select ) {

									/******************************************/
									//si es el primer elemento
									if($x==0){
										$fItem = 'fItem';
										$x++;
									}else{
										$fItem = '';
									}

									/******************************************/
									//Si el tab correspondiente esta seleccionado
									if(isset($arrValTab[$select['idData']])&&$arrValTab[$select['idData']]==2){
										$check = 'active';
									}else{
										$check = 'notActive';
									}

									/******************************************/
									//Escribo los datos solicitados
									if(count($datos)==1){
										$data_writing = $select[$datos[0]].' ';
									}else{
										$data_writing = '';
										foreach($datos as $dato){
											$data_writing .= $select[$dato].' ';
										}
									}

									/******************************************/
									$input .= '<a class="btn btn-'.$tipo.' btn-sm '.$check.' l_item '.$fItem.' Icon_'.$select['idData'].'" data-toggle="'.$name.'" data-title="'.$select['idData'].'">'.TituloMenu(DeSanitizar($data_writing)).'</a>';

								}
								$input .= '
							</div>
							<input type="hidden" name="'.$name.'" id="'.$name.'">
						</div>
					</div>
				</div>

				<script>
					$(\'#'.$name.'_div a\').on(\'click\', function(){
						var sel = $(this).data(\'title\');
						var tog = $(this).data(\'toggle\');
						document.getElementById("'.$name.'").value = sel;
						$(\'a[data-toggle="\'+tog+\'"]\').not(\'[data-title="\'+sel+\'"]\').removeClass(\'active\').addClass(\'notActive\');
						$(\'a[data-toggle="\'+tog+\'"][data-title="\'+sel+\'"]\').removeClass(\'notActive\').addClass(\'active\');
					})
				</script>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea una linea con un checkbox de terminos y condiciones
	*
	*===========================     Detalles    ===========================
	* Permite crear una linea en donde muestra la opción de terminos y
	* condiciones, al tener esta opción presente deshabilita el boton
	* submit del formulario, impidiendo su ejecucion hasta que no se
	* acepte, el enlace abre un popup con lo que el usuario debe aceptar
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_terms_and_conditions('terminos','He leido los ','www.google.cl','terminos y condiciones', 'submit_btn' );
	*
	*===========================    Parametros   ===========================
	* String   $name         Nombre del identificador del Input
	* String   $inicio       Texto inicio
	* String   $link         Enlace con el documento a mostrar en el popup
	* String   $fin          Texto final
	* String   $submit_name  Identificador del boton submit del formulario
	* @return  String
	************************************************************************/
	public function form_terms_and_conditions($name, $inicio, $link, $fin, $submit_name){

		/******************************************/
		//generacion del input
		$input = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 field '.$name.'">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="checkbox checkbox-primary">
					<input class="styled" type="checkbox" name="'.$name.'" id="'.$name.'" value="1" onchange="acbtn_'.$name.'(this)">
					<label>'.$inicio.'  <a class="iframe" href="'.$link.'">'.$fin.'</a></label>
				</div>
			</div>
		</div>';

		/******************************************/
		//ejecucion script
		$input .= '
		<script>
			//se desactiva el boton f5
			window.onload = function () {
				disableSubmit();
			}
			//se desactiva el boton submit
			function disableSubmit() {
				document.getElementById("'.$submit_name.'").disabled = true;
			}
			//si se esta de acuerdo se activa el boton submit
			function acbtn_'.$name.'(element) {
				if(element.checked) {
					document.getElementById("'.$submit_name.'").disabled = false;
				}else  {
					document.getElementById("'.$submit_name.'").disabled = true;
				}
			}
		</script>';

		/******************************************/
		//Imprimir dato
		echo $input;
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea una linea con un checkbox de terminos y condiciones
	*
	*===========================     Detalles    ===========================
	* Permite crear una linea en donde muestra la opción de terminos y
	* condiciones, al tener esta opción presente deshabilita el boton
	* submit del formulario, impidiendo su ejecucion hasta que no se
	* acepte, el enlace abre un popup con lo que el usuario debe aceptar
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_conditional_submit('terminos','He leido los terminos y condiciones', 'submit_btn' );
	*
	*===========================    Parametros   ===========================
	* String   $name         Nombre del identificador del Input
	* String   $text         Texto
	* String   $submit_name  Identificador del boton submit del formulario
	* @return  String
	************************************************************************/
	public function form_conditional_submit($name, $text, $submit_name){

		/******************************************/
		//generacion del input
		$input = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 field '.$name.'">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<div class="checkbox checkbox-primary">
					<input class="styled" type="checkbox" name="'.$name.'" id="'.$name.'" value="1" onchange="acbtn_'.$name.'(this)">
					<label>'.$text.'</label>
				</div>
			</div>
		</div>';

		/******************************************/
		//ejecucion script
		$input .= '
		<script>
			//se desactiva el boton f5
			window.onload = function () {
				disableSubmit();
			}
			//se desactiva el boton submit
			function disableSubmit() {
				document.getElementById("'.$submit_name.'").disabled = true;
			}
			//si se esta de acuerdo se activa el boton submit
			function acbtn_'.$name.'(element) {
				if(element.checked) {
					document.getElementById("'.$submit_name.'").disabled = false;
				}else{
					document.getElementById("'.$submit_name.'").disabled = true;
				}
			}
		</script>';

		/******************************************/
		//Imprimir dato
		echo $input;
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un cuadro con texto interno
	*
	*===========================     Detalles    ===========================
	* Permite crear un cuadro de texto
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_text_box('www.google.cl', 400);
	*
	*===========================    Parametros   ===========================
	* String   $link         Enlace con el documento a mostrar en el popup
	* String   $height       Altura del div
	* @return  String
	************************************************************************/
	public function form_text_box($link, $height, $arrCambios){

		//Obtengo datos
		$content = file_get_contents($link);
		//Elimina acentos
		$content = str_replace('á','a',$content);
		$content = str_replace('é','e',$content);
		$content = str_replace('í','i',$content);
		$content = str_replace('ó','o',$content);
		$content = str_replace('ú','u',$content);

		foreach($arrCambios as $cambios=>$cambio){
			$content = str_replace($cambio['Original'],$cambio['Cambio'],$content);
		}

		/******************************************/
		//generacion del input
		$input = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div style="overflow-y: auto;padding:10px;height: '.$height.'px;">
				'.$content.'
			</div>
		</div>
		<div class="clearfix"></div>';

		/******************************************/
		//Imprimir dato
		echo $input;
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un tipo texto que solo permite roles de terreno
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_input_rol('Categoria','idCategoria', 1, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function form_input_rol($placeholder,$name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<div class="input-group bootstrap-timepicker">
						<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' onkeydown="return rolTerreno(event)"  >
						<span class="input-group-addon add-on"><i class="fa fa-map-o" aria-hidden="true"></i></span>
					</div>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', 'idMes>2', 'ORDER BY Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $extrafilter   Comandos extras, tales como ORDER BY - GROUP BY
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $extrafilter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Verifica si se enviaron comandos extras
			if(!isset($extrafilter) OR $extrafilter==''){
				$extrafilter = $datos[0].' ASC ';
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//generacion del input
				$input = $this->select_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos);

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* el cual tiene un filtrode texto que permite encontrar facilmente el
	* dato necesario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filter('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', 'idMes>2', 'ORDER BY Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $extrafilter   Comandos extras, tales como ORDER BY - GROUP BY
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_filter($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $extrafilter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Valido dispositivo movil
			if(validaDispositivoMovil()){
				$input = $this->form_select($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $extrafilter, $dbConn);
			}else{

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
				//Variables
				$filtro        = '';
				$data_required = '';

				/******************************************/
				//Se separan los datos a mostrar
				$datos = explode(",", $data2);
				//Si es solo uno
				if(count($datos)==1){
					//datos requeridos
					$data_required .= ','.$datos[0].' AS '.$datos[0];
				//Si es mas de uno
				}else{
					//recorro todos los datos solicitados
					foreach($datos as $dato){
						//datos requeridos
						$data_required .= ','.$dato.' AS '.$dato;
					}
				}

				/******************************************/
				//Si se envia filtro desde afuera
				if($filter!='0' && $filter!=''){
					//que exista un dato
					$filtro .= $filter." AND ".$datos[0]."!='' ";
				}elseif($filter=='' OR $filter==0){
					//que exista un dato
					$filtro .= $datos[0]."!='' ";
				}

				/******************************************/
				//Verifica si se enviaron mas datos
				if(!isset($extrafilter) OR $extrafilter==''){
					$extrafilter = $datos[0].' ASC ';
				}

				/******************************************/
				//consulto
				$arrSelect = array();
				$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select_filter', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

				/******************************************/
				//si hay resultados
				if($arrSelect!=false){

					/******************************************/
					//generacion del input
					$input  = $this->chosen_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos);
					//funcionalidad
					$input .= $this->chosen_select_script($name);
					//si es requerido
					$input .= $this->chosen_required($name, $required);

					/******************************************/
					//Imprimir dato
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
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filtrar('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', 'idMes>2', 'ORDER BY Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $extrafilter   Comandos extras, tales como ORDER BY - GROUP BY
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_filtrar($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $extrafilter, $dbConn, $divContent = ''){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Verifica si se enviaron comandos extras
			if(!isset($extrafilter) OR $extrafilter==''){
				$extrafilter = $datos[0].' ASC ';
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//generacion del input
				$input = $this->select_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos);
				//genracion del filtro
				$input .= '
				<script>
					$(document).ready(function() {
						$(".select2_'.$name.'").select2(
							{';
								if($divContent!=''){
									$input .= 'dropdownParent: $("#'.$divContent.'"),';
								}
								$input .= '
								width: "100%",
								language: "es"
						  	}
						);
					});
				</script>';
				//validacion si es requerido
				if($required==2){
					$input .='<style>#div_'.$name.' .select2-container .select2-selection--single {background:url('.DB_SITE_REPO.'/LIB_assets/img/required.png) no-repeat 5px center !important;background-color: #fff !important;}</style>';
				}

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* que tambien obtiene datos desde otras tablas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_join('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table1        Tabla desde donde tomar los datos
	* String   $table2        Tabla a fucionar para tener los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_join($placeholder,$name, $value, $required, $data1, $data2, $table1, $table2, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$table1.'.'.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$table1.'.'.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $table1.'.'.$datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$table1.".".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $table1.".".$datos[0]."!='' ";
			}

			//Agrupo los datos
			$filtro .= ' GROUP BY '.$table1.'.'.$data1;

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $table1.'.'.$data1.' AS idData '.$data_required, $table1, 'INNER JOIN '.$table2.' ON '.$table2.'.'.$data1.' = '.$table1.'.'.$data1, $filtro, $order_by, $dbConn, 'form_select_join', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//se crea formulario
				$input = $this->select_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos);

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* que tambien obtiene datos desde otras tablas, agregando un filtro
	* para encontrar datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_join_filter('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table1        Tabla desde donde tomar los datos
	* String   $table2        Tabla a fucionar para tener los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_join_filter($placeholder,$name, $value, $required, $data1, $data2, $table1, $table2, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Valido dispositivo movil
			if(validaDispositivoMovil()){
				$input = $this->form_select_join($placeholder,$name, $value, $required, $data1, $data2, $table1, $table2, $filter, $dbConn);
			}else{

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
				//Variables
				$filtro        = '';
				$data_required = '';

				/******************************************/
				//Se separan los datos a mostrar
				$datos = explode(",", $data2);
				//Si es solo uno
				if(count($datos)==1){
					//datos requeridos
					$data_required .= ','.$table1.'.'.$datos[0];
				//Si es mas de uno
				}else{
					//recorro todos los datos solicitados
					foreach($datos as $dato){
						//datos requeridos
						$data_required .= ','.$table1.'.'.$dato;
					}
				}

				/******************************************/
				//Ordenar por el dato requerido
				$order_by = $table1.'.'.$datos[0].' ASC ';
				//Si se envia filtro desde afuera
				if($filter!='0' && $filter!=''){
					//que exista un dato
					$filtro .= $filter." AND ".$table1.".".$datos[0]."!='' ";
				}elseif($filter=='' OR $filter==0){
					//que exista un dato
					$filtro .= $table1.".".$datos[0]."!='' ";
				}

				//Agrupo los datos
				$filtro .= ' GROUP BY '.$table1.'.'.$data1;

				/******************************************/
				//consulto
				$arrSelect = array();
				$arrSelect = db_select_array (false, $table1.'.'.$data1.' AS idData '.$data_required, $table1, 'INNER JOIN '.$table2.' ON '.$table2.'.'.$data1.' = '.$table1.'.'.$data1, $filtro, $order_by, $dbConn, 'form_select_join_filter', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

				/******************************************/
				//si hay resultados
				if($arrSelect!=false){

					/******************************************/
					//generacion del input
					$input  = $this->chosen_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos);
					//funcionalidad
					$input .= $this->chosen_select_script($name);
					//si es requerido
					$input .= $this->chosen_required($name, $required);

					/******************************************/
					//Imprimir dato
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
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input descativado
	*
	*===========================     Detalles    ===========================
	* Permite crear un input desactivado con datos desde la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_disabled('Categoria','idCategoria', 1, 1,'idCategoria','Nombre','tabla_categorias','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_disabled($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $datos[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//se hace consulta
			$rowselect = db_select_data (false, $data1.' AS idData '.$data_required, $table, '', $data1.'='.$value.' AND '.$filtro.' ORDER BY '.$order_by, $dbConn, 'form_select_disabled', basename($_SERVER["REQUEST_URI"], ".php"), 'rowselect');

			/******************************************/
			//si hay resultados
			if($rowselect!=false){

				/******************************************/
				//Escribo los datos solicitados
				if(count($datos)==1){
					$data_writing = $rowselect[$datos[0]].' ';
				}else{
					$data_writing = '';
					foreach($datos as $dato){
						$data_writing .= $rowselect[$dato].' ';
					}
				}

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
						<input type="text" placeholder="'.$placeholder.'" name="'.$name.'" id="'.$name.'" class="form-control" value="'.TituloMenu(DeSanitizar($data_writing)).'"   disabled="disabled">
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
				echo $input;

			//si no hay datos
			}elseif(empty($rowselect) OR $rowselect==''){
				//Devuelvo mensaje
				alert_post_data(4,1,1,0, 'No hay datos en <strong>'.$placeholder.'</strong>, consulte con el administrador');
			//si existe un error
			}elseif($rowselect==false){
				//Devuelvo mensaje
				alert_post_data(4,1,1,0, 'Hay un error en la consulta <strong>'.$placeholder.'</strong>, consulte con el administrador');
			}
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input numerico
	*
	*===========================     Detalles    ===========================
	* Permite crear un input que contiene numeros enteros secuenciales
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_n_auto('Notas','notas', '', 1, 1, 7 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $valor_ini     Valor rango inicio, debe ser numero entero
	* int      $valor_fin     Valor rango fin, debe ser numero entero
	* @return  String
	************************************************************************/
	public function form_select_n_auto($placeholder,$name, $value, $required, $valor_ini, $valor_fin){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($valor_ini)&&$valor_ini!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $valor_ini ('.$valor_ini.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($valor_ini)&&$valor_ini!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $valor_ini ('.$valor_ini.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($valor_fin)&&$valor_fin!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $valor_fin ('.$valor_fin.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($valor_fin)&&$valor_fin!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $valor_fin ('.$valor_fin.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select class="form-control" name="'.$name.'" id="'.$name.'" '.$requerido.'>
						<option value="">Seleccione una Opción</option>';

						/******************************************/
						//Recorro
						for ($i = $valor_ini; $i <= $valor_fin; $i++) {

							/******************************************/
							//si la opción actual esta seleccionada
							if(isset($value)&&$value==$i) {
								$j = 'selected="selected"';
							}else{
								$j = '';
							}

							/******************************************/
							$input .= '<option value="'.$i.'" '.$j.'>'.$i.'</option>';
						}
					$input .= '
					</select>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input select con los paises
	*
	*===========================     Detalles    ===========================
	* Permite crear un input select que trae los paises
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_country('Pais','idPais', '', 2, $dbConn);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_country($placeholder,$name, $value, $required, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Pais por defecto
			if(isset($value)&&$value!=''){
				$pais = $value;
			}else{
				$pais = '0';
			}

			/******************************************/
			//generacion del input
			$input = '
			<div class="form-group" id="div_'.$name.'">
				<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
					<select name="'.$name.'" id="'.$name.'" class="form-control frm_country selectpicker countrypicker" '.$requerido.'  data-live-search="true" data-default="'.$pais.'" data-flag="true"></select>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* que tambien obtiene datos desde otras tablas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_group('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table1        Tabla desde donde tomar los datos
	* String   $table2        Tabla a fucionar para tener los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_group($placeholder,$name, $value, $required, $data1a, $data2a, $table1,
																			 $data1b, $data2b, $table2,
																			 $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

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
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos1 = explode(",", $data2a);
			$datos2 = explode(",", $data2b);
			//Si es solo uno
			if(count($datos1)==1){
				//datos requeridos
				$data_required .= ','.$table1.'.'.$datos1[0].' AS Data_A_0';
			//Si es mas de uno
			}else{
				$xs = 0;
				//recorro todos los datos solicitados
				foreach($datos1 as $dato){
					//datos requeridos
					$data_required .= ','.$table1.'.'.$dato.' AS Data_A_'.$xs;
					$xs++;
				}
			}
			//Si es solo uno
			if(count($datos2)==1){
				//datos requeridos
				$data_required .= ','.$table2.'.'.$datos2[0].' AS Data_B_0';
			//Si es mas de uno
			}else{
				$xs = 0;
				//recorro todos los datos solicitados
				foreach($datos2 as $dato){
					//datos requeridos
					$data_required .= ','.$table2.'.'.$dato.' AS Data_B_'.$xs;
					$xs++;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $table1.'.'.$datos1[0].' ASC ';
			$order_by.= ','.$table2.'.'.$datos2[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$table1.".".$datos1[0]."!='' ";
				$filtro .= " AND ".$table2.".".$datos2[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $table1.".".$datos1[0]."!='' ";
				$filtro .= " AND ".$table2.".".$datos2[0]."!='' ";
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $table1.'.'.$data1a.' AS idData1, '.$table2.'.'.$data1b.' AS idData2 '.$data_required, $table1, 'INNER JOIN '.$table2.' ON '.$table2.'.'.$data1a.' = '.$table1.'.'.$data1a, $filtro, $order_by, $dbConn, 'form_select_join', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field">
						<select name="'.$name.'" id="'.$name.'" class="form-control select2" '.$requerido.' >';

							/**************************************/
							//Recorro
							$selectedx = 'selected="selected"';
							foreach ( $arrSelect as $select ) {
								if($value==$select['idData2']){
									$selectedx = '';
								}
							}

							/**************************************/
							//Recorro
							$input .= '<option value="" '.$selectedx.'>Seleccione una Opción</option>';

							/**************************************/
							//Recorro
							filtrar($arrSelect, 'idData1');
							foreach($arrSelect as $categoria=>$selected){
								$input .= '<optgroup label="'.$selected[0]['Data_A_0'].'">';
									foreach ($selected as $select) {
										/******************************************/
										//Variables
										$selected     = '';
										$data_writing = '';

										/******************************************/
										//si la opción actual esta seleccionada
										if($value==$select['idData2']){$selected = 'selected="selected"';}

										/******************************************/
										//Escribo los datos solicitados
										if(count($datos2)==1){
											$data_writing = $select['Data_B_0'].' ';
										}else{
											$xs = 0;
											//se crea cadena
											foreach($datos2 as $dato){
												$data_writing .= $select['Data_B_'.$xs].' ';
											}
										}

										/******************************************/
										//se escribe
										$input .= '<option value="'.$select['idData2'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
									}
								$input .= '</optgroup>';
							}

						$input .= '
						</select>
					</div>
				</div>';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select que permite seleccionar multiples elementos
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_multiple('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', 'idMes>2', 'ORDER BY Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $extrafilter   Comandos extras, tales como ORDER BY - GROUP BY
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_multiple($placeholder,$name, $value, $required, $data1, $data2, $table, $filter, $extrafilter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name).'_'.rand(1, 999);

			/******************************************/
			//Valido si es requerido
			switch ($required) {
				//Si el dato no es requerido
				case 1:
					$requerido   = '';//variable vacia
					$requiredBox = '';//variable vacia
					break;
				//Si el dato es requerido
				case 2:
					$requerido   = 'required'; //se marca como requerido
					$requiredBox = 'requiredBox'; //se marca como requerido
					if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
					$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
					break;
			}

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos = explode(",", $data2);
			//Si es solo uno
			if(count($datos)==1){
				//datos requeridos
				$data_required .= ','.$datos[0].' AS '.$datos[0];
			//Si es mas de uno
			}else{
				//recorro todos los datos solicitados
				foreach($datos as $dato){
					//datos requeridos
					$data_required .= ','.$dato.' AS '.$dato;
				}
			}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$datos[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $datos[0]."!='' ";
			}

			/******************************************/
			//Verifica si se enviaron comandos extras
			if(!isset($extrafilter) OR $extrafilter==''){
				$extrafilter = $datos[0].' ASC ';
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//generacion del input
				$data = '
				<div class="form-group" id="div_'.$EXname.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$EXname.'">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field multi-select '.$requiredBox.'">
						<select name="'.$name.'" id="'.$EXname.'" class="form-control" '.$requerido.'  multiple="multiple">';
							/******************************************/
							//Recorro
							foreach ( $arrSelect as $select ) {

								/******************************************/
								//Variables
								$selected     = '';
								$data_writing = '';

								/******************************************/
								//si la opción actual esta seleccionada
								if($value==$select['idData']){$selected = 'selected="selected"';}

								/******************************************/
								//Escribo los datos solicitados
								if(count($datos)==1){
									$data_writing = $select[$datos[0]].' ';
								}else{
									//se crea cadena
									foreach($datos as $dato){
										$data_writing .= $select[$dato].' ';
									}
								}

								/******************************************/
								//se escribe
								$data .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
							}
						$data .= '
						</select>
					</div>
				</div>';

				$data .= '
				<script>
					$(document).ready(function() {
						$("#'.$EXname.'").multiselect({
						includeSelectAllOption: true,
						});
					});
				</script>
				';

				/******************************************/
				//Imprimir dato
				echo $data;
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* que tambien obtiene datos desde otras tablas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_group_multiple('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table1        Tabla desde donde tomar los datos
	* String   $table2        Tabla a fucionar para tener los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_group_multiple($placeholder,$name, $value, $required, $data1a, $data2a, $table1,
																			 $data1b, $data2b, $table2,
																			 $filter, $dbConn){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$placeholder.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Valido si es requerido
			switch ($required) {
				//Si el dato no es requerido
				case 1:
					$requerido   = '';//variable vacia
					$requiredBox = '';//variable vacia
					break;
				//Si el dato es requerido
				case 2:
					$requerido   = 'required'; //se marca como requerido
					$requiredBox = 'requiredBox'; //se marca como requerido
					if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
					$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario
					break;
			}

			/******************************************/
			//Variables
			$filtro        = '';
			$data_required = '';

			/******************************************/
			//Se separan los datos a mostrar
			$datos1 = explode(",", $data2a);
			$datos2 = explode(",", $data2b);
			//Si es solo uno
			if(count($datos1)==1){
				//datos requeridos
				$data_required .= ','.$table1.'.'.$datos1[0].' AS Data_A_0';
			//Si es mas de uno
			}else{
				$xs = 0;
				//recorro todos los datos solicitados
				foreach($datos1 as $dato){
					//datos requeridos
					$data_required .= ','.$table1.'.'.$dato.' AS Data_A_'.$xs;
					$xs++;
				}
			}
			//Si es solo uno
			if(count($datos2)==1){
				//datos requeridos
				$data_required .= ','.$table2.'.'.$datos2[0].' AS Data_B_0';
			//Si es mas de uno
			}else{
				$xs = 0;
				//recorro todos los datos solicitados
				foreach($datos2 as $dato){
					//datos requeridos
					$data_required .= ','.$table2.'.'.$dato.' AS Data_B_'.$xs;
					$xs++;
				}
			}

			/******************************************/
			//Ordenar por el dato requerido
			$order_by = $table1.'.'.$datos1[0].' ASC ';
			$order_by.= ','.$table2.'.'.$datos2[0].' ASC ';
			//Si se envia filtro desde afuera
			if($filter!='0' && $filter!=''){
				//que exista un dato
				$filtro .= $filter." AND ".$table1.".".$datos1[0]."!='' ";
				$filtro .= " AND ".$table2.".".$datos2[0]."!='' ";
			}elseif($filter=='' OR $filter==0){
				//que exista un dato
				$filtro .= $table1.".".$datos1[0]."!='' ";
				$filtro .= " AND ".$table2.".".$datos2[0]."!='' ";
			}

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $table1.'.'.$data1a.' AS idData1, '.$table2.'.'.$data1b.' AS idData2 '.$data_required, $table1, 'INNER JOIN '.$table2.' ON '.$table2.'.'.$data1a.' = '.$table1.'.'.$data1a, $filtro, $order_by, $dbConn, 'form_select_join', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){

				/******************************************/
				//generacion del input
				$input = '
				<div class="form-group" id="div_'.$name.'">
					<label class="control-label col-xs-12 col-sm-4 col-md-4 col-lg-4" id="label_'.$name.'">'.$placeholder.'</label>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 field multi-select '.$requiredBox.'">
						<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' multiple="multiple" >';

							/**************************************/
							//Recorro
							filtrar($arrSelect, 'idData1');
							foreach($arrSelect as $categoria=>$selected){
								$input .= '<optgroup label="'.$selected[0]['Data_A_0'].'">';
									foreach ($selected as $select) {
										/******************************************/
										//Variables
										$selected     = '';
										$data_writing = '';

										/******************************************/
										//si la opción actual esta seleccionada
										if($value==$select['idData2']){$selected = 'selected="selected"';}

										/******************************************/
										//Escribo los datos solicitados
										if(count($datos2)==1){
											$data_writing = $select['Data_B_0'].' ';
										}else{
											$xs = 0;
											//se crea cadena
											foreach($datos2 as $dato){
												$data_writing .= $select['Data_B_'.$xs].' ';
											}
										}

										/******************************************/
										//se escribe
										$input .= '<option value="'.$select['idData2'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
									}
								$input .= '</optgroup>';
							}

						$input .= '
						</select>
					</div>
				</div>';

				$input .= '
				<script>
					$(document).ready(function() {
						$("#'.$name.'").multiselect({
							enableCollapsibleOptGroups: true,
							collapseOptGroupsByDefault: true
						});
					});
				</script>
				';

				/******************************************/
				//Imprimir dato
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
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_join_depend1($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $join_1,  $filter_1,   $extracomand_1,
											 $placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $join_2,  $filter_2,   $extracomand_2,
											 $dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 2; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, $join_1, $filtro[1], $extracomand_1, $dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, $join_2, $filtro[2], $extracomand_2,$dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_depend1($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
										$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 2; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1_filter('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_depend1_filter($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
											   $placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
											   $dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 2; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
                /******************************************/
				//generacion del input
				$input .= $this->chosen_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
				//funcionalidad
				$input .= $this->chosen_select_script($name_1);
				//si es requerido
				$input .= $this->chosen_required($name_1, $required_1);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_depend1_filtrar($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
												$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
												$dbConn, $form_name, $divContent = ''){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 2; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
				//genracion del filtro
				$input .= '
				<script>
					$(document).ready(function() {
						$(".select2_'.$name_1.'").select2(
							{';
								if($divContent!=''){
									$input .= 'dropdownParent: $("#'.$divContent.'"),';
								}
								$input .= '
								width: "100%",
								language: "es"
						  	}
						);
					});
				</script>';
				//validacion si es requerido
				if($requerido[1]==2){
					$input .='<style>#div_'.$name_1.' .select2-container .select2-selection--single {background:url('.DB_SITE_REPO.'/LIB_assets/img/required.png) no-repeat 5px center !important;background-color: #fff !important;}</style>';
				}
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_depend2($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
										$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										$placeholder_3, $name_3,  $value_3,  $required_3,  $dataA_3,  $dataB_3,  $table_3,  $filter_3,   $extracomand_3,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 3; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) {case 1:$requerido[3] = '';break;case 2:$requerido[3] = 'required';$_SESSION['form_require'].= ','.$name_3;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);
			$datos[3] = explode(",", $dataB_3);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3] .= ','.$datos[3][0].' AS '.$datos[3][0];}else{foreach($datos[3] as $dato){$data_required[3] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3] .= $filter_3." AND ".$datos[3][0]."!='' ";}elseif($filter_3=='' OR $filter_3==0){$filtro[3] .= $datos[3][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){$extracomand_3 = $datos[3][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend2', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend2', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3 = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3], $table_3, '', $filtro[3], $extracomand_3, $dbConn, 'form_select_depend2', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_depend3($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
										$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										$placeholder_3, $name_3,  $value_3,  $required_3,  $dataA_3,  $dataB_3,  $table_3,  $filter_3,   $extracomand_3,
										$placeholder_4, $name_4,  $value_4,  $required_4,  $dataA_4,  $dataB_4,  $table_4,  $filter_4,   $extracomand_4,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_4, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_4 ('.$required_4.') entregada en '.$placeholder_4.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 4; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) {case 1:$requerido[3] = '';break;case 2:$requerido[3] = 'required';$_SESSION['form_require'].= ','.$name_3;break;}
			switch ($required_4) {case 1:$requerido[4] = '';break;case 2:$requerido[4] = 'required';$_SESSION['form_require'].= ','.$name_4;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);
			$datos[3] = explode(",", $dataB_3);
			$datos[4] = explode(",", $dataB_4);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3] .= ','.$datos[3][0].' AS '.$datos[3][0];}else{foreach($datos[3] as $dato){$data_required[3] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[4])==1){$data_required[4] .= ','.$datos[4][0].' AS '.$datos[4][0];}else{foreach($datos[4] as $dato){$data_required[4] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3] .= $filter_3." AND ".$datos[3][0]."!='' ";}elseif($filter_3=='' OR $filter_3==0){$filtro[3] .= $datos[3][0]."!='' ";}
			if($filter_4!='0' && $filter_4!=''){$filtro[4] .= $filter_4." AND ".$datos[4][0]."!='' ";}elseif($filter_4=='' OR $filter_4==0){$filtro[4] .= $datos[4][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){$extracomand_3 = $datos[3][0].' ASC ';}
			if(!isset($extracomand_4) OR $extracomand_4==''){$extracomand_4 = $datos[4][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_4 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3 = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3], $table_3, '', $filtro[3], $extracomand_3, $dbConn, 'form_select_depend3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');
			$arrSelect_4 = db_select_array (false, $dataA_4.' AS idData ,'.$dataA_3.' AS idDataFilter '.$data_required[4], $table_4, '', $filtro[4], $extracomand_4, $dbConn, 'form_select_depend3', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_4');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}
			//si hay resultados
			if($arrSelect_4!=false){
				$input .= $this->select_input_empty($name_4, $placeholder_4, $requerido[4]);
				$input .= $this->select_input_script($arrSelect_4, $value_4, $name_3, $name_4, $datos[4], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* el cual tiene un filtrode texto que permite encontrar facilmente el
	* dato necesario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filter('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $orderby       Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_depend4($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
										$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										$placeholder_3, $name_3,  $value_3,  $required_3,  $dataA_3,  $dataB_3,  $table_3,  $filter_3,   $extracomand_3,
										$placeholder_4, $name_4,  $value_4,  $required_4,  $dataA_4,  $dataB_4,  $table_4,  $filter_4,   $extracomand_4,
										$placeholder_5, $name_5,  $value_5,  $required_5,  $dataA_5,  $dataB_5,  $table_5,  $filter_5,   $extracomand_5,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_4, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_4 ('.$required_4.') entregada en '.$placeholder_4.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_5, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_5 ('.$required_5.') entregada en '.$placeholder_5.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 5; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) {case 1:$requerido[3] = '';break;case 2:$requerido[3] = 'required';$_SESSION['form_require'].= ','.$name_3;break;}
			switch ($required_4) {case 1:$requerido[4] = '';break;case 2:$requerido[4] = 'required';$_SESSION['form_require'].= ','.$name_4;break;}
			switch ($required_5) {case 1:$requerido[5] = '';break;case 2:$requerido[5] = 'required';$_SESSION['form_require'].= ','.$name_5;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);
			$datos[3] = explode(",", $dataB_3);
			$datos[4] = explode(",", $dataB_4);
			$datos[5] = explode(",", $dataB_5);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3] .= ','.$datos[3][0].' AS '.$datos[3][0];}else{foreach($datos[3] as $dato){$data_required[3] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[4])==1){$data_required[4] .= ','.$datos[4][0].' AS '.$datos[4][0];}else{foreach($datos[4] as $dato){$data_required[4] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[5])==1){$data_required[5] .= ','.$datos[5][0].' AS '.$datos[5][0];}else{foreach($datos[5] as $dato){$data_required[5] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3] .= $filter_3." AND ".$datos[3][0]."!='' ";}elseif($filter_3=='' OR $filter_3==0){$filtro[3] .= $datos[3][0]."!='' ";}
			if($filter_4!='0' && $filter_4!=''){$filtro[4] .= $filter_4." AND ".$datos[4][0]."!='' ";}elseif($filter_4=='' OR $filter_4==0){$filtro[4] .= $datos[4][0]."!='' ";}
			if($filter_5!='0' && $filter_5!=''){$filtro[5] .= $filter_5." AND ".$datos[5][0]."!='' ";}elseif($filter_5=='' OR $filter_5==0){$filtro[5] .= $datos[5][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){$extracomand_3 = $datos[3][0].' ASC ';}
			if(!isset($extracomand_4) OR $extracomand_4==''){$extracomand_4 = $datos[4][0].' ASC ';}
			if(!isset($extracomand_5) OR $extracomand_5==''){$extracomand_5 = $datos[5][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_4 = array();
			$arrSelect_5 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend4', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend4', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3 = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3], $table_3, '', $filtro[3], $extracomand_3, $dbConn, 'form_select_depend4', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');
			$arrSelect_4 = db_select_array (false, $dataA_4.' AS idData ,'.$dataA_3.' AS idDataFilter '.$data_required[4], $table_4, '', $filtro[4], $extracomand_4, $dbConn, 'form_select_depend4', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_4');
			$arrSelect_5 = db_select_array (false, $dataA_5.' AS idData ,'.$dataA_4.' AS idDataFilter '.$data_required[5], $table_5, '', $filtro[5], $extracomand_5, $dbConn, 'form_select_depend4', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_5');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}
			//si hay resultados
			if($arrSelect_4!=false){
				$input .= $this->select_input_empty($name_4, $placeholder_4, $requerido[4]);
				$input .= $this->select_input_script($arrSelect_4, $value_4, $name_3, $name_4, $datos[4], $form_name);
			}
			//si hay resultados
			if($arrSelect_5!=false){
				$input .= $this->select_input_empty($name_5, $placeholder_5, $requerido[5]);
				$input .= $this->select_input_script($arrSelect_5, $value_5, $name_4, $name_5, $datos[5], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* el cual tiene un filtrode texto que permite encontrar facilmente el
	* dato necesario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filter('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $orderby       Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_depend5($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,   $extracomand_1,
										$placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										$placeholder_3, $name_3,  $value_3,  $required_3,  $dataA_3,  $dataB_3,  $table_3,  $filter_3,   $extracomand_3,
										$placeholder_4, $name_4,  $value_4,  $required_4,  $dataA_4,  $dataB_4,  $table_4,  $filter_4,   $extracomand_4,
										$placeholder_5, $name_5,  $value_5,  $required_5,  $dataA_5,  $dataB_5,  $table_5,  $filter_5,   $extracomand_5,
										$placeholder_6, $name_6,  $value_6,  $required_6,  $dataA_6,  $dataB_6,  $table_6,  $filter_6,   $extracomand_6,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_4, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_4 ('.$required_4.') entregada en '.$placeholder_4.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_5, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_5 ('.$required_5.') entregada en '.$placeholder_5.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_6, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_6 ('.$required_6.') entregada en '.$placeholder_6.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 6; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) {case 1:$requerido[1] = '';break;case 2:$requerido[1] = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) {case 1:$requerido[2] = '';break;case 2:$requerido[2] = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) {case 1:$requerido[3] = '';break;case 2:$requerido[3] = 'required';$_SESSION['form_require'].= ','.$name_3;break;}
			switch ($required_4) {case 1:$requerido[4] = '';break;case 2:$requerido[4] = 'required';$_SESSION['form_require'].= ','.$name_4;break;}
			switch ($required_5) {case 1:$requerido[5] = '';break;case 2:$requerido[5] = 'required';$_SESSION['form_require'].= ','.$name_5;break;}
			switch ($required_6) {case 1:$requerido[6] = '';break;case 2:$requerido[6] = 'required';$_SESSION['form_require'].= ','.$name_6;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1] = explode(",", $dataB_1);
			$datos[2] = explode(",", $dataB_2);
			$datos[3] = explode(",", $dataB_3);
			$datos[4] = explode(",", $dataB_4);
			$datos[5] = explode(",", $dataB_5);
			$datos[6] = explode(",", $dataB_6);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1] .= ','.$datos[1][0].' AS '.$datos[1][0];}else{foreach($datos[1] as $dato){$data_required[1] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3] .= ','.$datos[3][0].' AS '.$datos[3][0];}else{foreach($datos[3] as $dato){$data_required[3] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[4])==1){$data_required[4] .= ','.$datos[4][0].' AS '.$datos[4][0];}else{foreach($datos[4] as $dato){$data_required[4] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[5])==1){$data_required[5] .= ','.$datos[5][0].' AS '.$datos[5][0];}else{foreach($datos[5] as $dato){$data_required[5] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[6])==1){$data_required[6] .= ','.$datos[6][0].' AS '.$datos[6][0];}else{foreach($datos[6] as $dato){$data_required[6] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1] .= $filter_1." AND ".$datos[1][0]."!='' ";}elseif($filter_1=='' OR $filter_1==0){$filtro[1] .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3] .= $filter_3." AND ".$datos[3][0]."!='' ";}elseif($filter_3=='' OR $filter_3==0){$filtro[3] .= $datos[3][0]."!='' ";}
			if($filter_4!='0' && $filter_4!=''){$filtro[4] .= $filter_4." AND ".$datos[4][0]."!='' ";}elseif($filter_4=='' OR $filter_4==0){$filtro[4] .= $datos[4][0]."!='' ";}
			if($filter_5!='0' && $filter_5!=''){$filtro[5] .= $filter_5." AND ".$datos[5][0]."!='' ";}elseif($filter_5=='' OR $filter_5==0){$filtro[5] .= $datos[5][0]."!='' ";}
			if($filter_6!='0' && $filter_6!=''){$filtro[6] .= $filter_6." AND ".$datos[6][0]."!='' ";}elseif($filter_6=='' OR $filter_6==0){$filtro[6] .= $datos[6][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){$extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){$extracomand_3 = $datos[3][0].' ASC ';}
			if(!isset($extracomand_4) OR $extracomand_4==''){$extracomand_4 = $datos[4][0].' ASC ';}
			if(!isset($extracomand_5) OR $extracomand_5==''){$extracomand_5 = $datos[5][0].' ASC ';}
			if(!isset($extracomand_6) OR $extracomand_6==''){$extracomand_6 = $datos[6][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_4 = array();
			$arrSelect_5 = array();
			$arrSelect_6 = array();
			$arrSelect_1 = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3 = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3], $table_3, '', $filtro[3], $extracomand_3, $dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');
			$arrSelect_4 = db_select_array (false, $dataA_4.' AS idData ,'.$dataA_3.' AS idDataFilter '.$data_required[4], $table_4, '', $filtro[4], $extracomand_4, $dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_4');
			$arrSelect_5 = db_select_array (false, $dataA_5.' AS idData ,'.$dataA_4.' AS idDataFilter '.$data_required[5], $table_5, '', $filtro[5], $extracomand_5, $dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_5');
			$arrSelect_6 = db_select_array (false, $dataA_6.' AS idData ,'.$dataA_5.' AS idDataFilter '.$data_required[6], $table_6, '', $filtro[6], $extracomand_6, $dbConn, 'form_select_depend5', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_6');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}
			//si hay resultados
			if($arrSelect_4!=false){
				$input .= $this->select_input_empty($name_4, $placeholder_4, $requerido[4]);
				$input .= $this->select_input_script($arrSelect_4, $value_4, $name_3, $name_4, $datos[4], $form_name);
			}
			//si hay resultados
			if($arrSelect_5!=false){
				$input .= $this->select_input_empty($name_5, $placeholder_5, $requerido[5]);
				$input .= $this->select_input_script($arrSelect_5, $value_5, $name_4, $name_5, $datos[5], $form_name);
			}
			//si hay resultados
			if($arrSelect_6!=false){
				$input .= $this->select_input_empty($name_6, $placeholder_6, $requerido[6]);
				$input .= $this->select_input_script($arrSelect_6, $value_6, $name_5, $name_6, $datos[6], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* el cual tiene un filtrode texto que permite encontrar facilmente el
	* dato necesario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filter('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $orderby       Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_depend25($placeholder_1,  $name_1,   $value_1,   $required_1,   $dataA_1,   $dataB_1,   $table_1,   $filter_1,   $extracomand_1,
										$placeholder_2,  $name_2,   $value_2,   $required_2,   $dataA_2,   $dataB_2,   $table_2,   $filter_2,   $extracomand_2,
										$placeholder_3,  $name_3,   $value_3,   $required_3,   $dataA_3,   $dataB_3,   $table_3,   $filter_3,   $extracomand_3,
										$placeholder_4,  $name_4,   $value_4,   $required_4,   $dataA_4,   $dataB_4,   $table_4,   $filter_4,   $extracomand_4,
										$placeholder_5,  $name_5,   $value_5,   $required_5,   $dataA_5,   $dataB_5,   $table_5,   $filter_5,   $extracomand_5,
										$placeholder_6,  $name_6,   $value_6,   $required_6,   $dataA_6,   $dataB_6,   $table_6,   $filter_6,   $extracomand_6,
										$placeholder_7,  $name_7,   $value_7,   $required_7,   $dataA_7,   $dataB_7,   $table_7,   $filter_7,   $extracomand_7,
										$placeholder_8,  $name_8,   $value_8,   $required_8,   $dataA_8,   $dataB_8,   $table_8,   $filter_8,   $extracomand_8,
										$placeholder_9,  $name_9,   $value_9,   $required_9,   $dataA_9,   $dataB_9,   $table_9,   $filter_9,   $extracomand_9,
										$placeholder_10, $name_10,  $value_10,  $required_10,  $dataA_10,  $dataB_10,  $table_10,  $filter_10,  $extracomand_10,
										$placeholder_11, $name_11,  $value_11,  $required_11,  $dataA_11,  $dataB_11,  $table_11,  $filter_11,  $extracomand_11,
										$placeholder_12, $name_12,  $value_12,  $required_12,  $dataA_12,  $dataB_12,  $table_12,  $filter_12,  $extracomand_12,
										$placeholder_13, $name_13,  $value_13,  $required_13,  $dataA_13,  $dataB_13,  $table_13,  $filter_13,  $extracomand_13,
										$placeholder_14, $name_14,  $value_14,  $required_14,  $dataA_14,  $dataB_14,  $table_14,  $filter_14,  $extracomand_14,
										$placeholder_15, $name_15,  $value_15,  $required_15,  $dataA_15,  $dataB_15,  $table_15,  $filter_15,  $extracomand_15,
										$placeholder_16, $name_16,  $value_16,  $required_16,  $dataA_16,  $dataB_16,  $table_16,  $filter_16,  $extracomand_16,
										$placeholder_17, $name_17,  $value_17,  $required_17,  $dataA_17,  $dataB_17,  $table_17,  $filter_17,  $extracomand_17,
										$placeholder_18, $name_18,  $value_18,  $required_18,  $dataA_18,  $dataB_18,  $table_18,  $filter_18,  $extracomand_18,
										$placeholder_19, $name_19,  $value_19,  $required_19,  $dataA_19,  $dataB_19,  $table_19,  $filter_19,  $extracomand_19,
										$placeholder_20, $name_20,  $value_20,  $required_20,  $dataA_20,  $dataB_20,  $table_20,  $filter_20,  $extracomand_20,
										$placeholder_21, $name_21,  $value_21,  $required_21,  $dataA_21,  $dataB_21,  $table_21,  $filter_21,  $extracomand_21,
										$placeholder_22, $name_22,  $value_22,  $required_22,  $dataA_22,  $dataB_22,  $table_22,  $filter_22,  $extracomand_22,
										$placeholder_23, $name_23,  $value_23,  $required_23,  $dataA_23,  $dataB_23,  $table_23,  $filter_23,  $extracomand_23,
										$placeholder_24, $name_24,  $value_24,  $required_24,  $dataA_24,  $dataB_24,  $table_24,  $filter_24,  $extracomand_24,
										$placeholder_25, $name_25,  $value_25,  $required_25,  $dataA_25,  $dataB_25,  $table_25,  $filter_25,  $extracomand_25,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_4, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_4 ('.$required_4.') entregada en '.$placeholder_4.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_5, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_5 ('.$required_5.') entregada en '.$placeholder_5.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_6, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_6 ('.$required_6.') entregada en '.$placeholder_6.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_7, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_7 ('.$required_7.') entregada en '.$placeholder_7.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_8, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_8 ('.$required_8.') entregada en '.$placeholder_8.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_9, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_9 ('.$required_9.') entregada en '.$placeholder_9.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_10, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_10 ('.$required_10.') entregada en '.$placeholder_10.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_11, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_11 ('.$required_11.') entregada en '.$placeholder_11.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_12, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_12 ('.$required_12.') entregada en '.$placeholder_12.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_13, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_13 ('.$required_13.') entregada en '.$placeholder_13.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_14, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_14 ('.$required_14.') entregada en '.$placeholder_14.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_15, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_15 ('.$required_15.') entregada en '.$placeholder_15.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_16, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_16 ('.$required_16.') entregada en '.$placeholder_16.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_17, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_17 ('.$required_17.') entregada en '.$placeholder_17.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_18, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_18 ('.$required_18.') entregada en '.$placeholder_18.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_19, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_19 ('.$required_19.') entregada en '.$placeholder_19.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_20, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_20 ('.$required_20.') entregada en '.$placeholder_20.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_21, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_21 ('.$required_21.') entregada en '.$placeholder_21.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_22, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_22 ('.$required_22.') entregada en '.$placeholder_22.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_23, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_23 ('.$required_23.') entregada en '.$placeholder_23.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_24, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_24 ('.$required_24.') entregada en '.$placeholder_24.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_25, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_25 ('.$required_25.') entregada en '.$placeholder_25.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_7)&&$value_7!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_7 ('.$value_7.') en <strong>'.$placeholder_7.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_8)&&$value_8!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_8 ('.$value_8.') en <strong>'.$placeholder_8.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_9)&&$value_9!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_9 ('.$value_9.') en <strong>'.$placeholder_9.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_10)&&$value_10!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_10 ('.$value_10.') en <strong>'.$placeholder_10.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_11)&&$value_11!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_11 ('.$value_11.') en <strong>'.$placeholder_11.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_12)&&$value_12!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_12 ('.$value_12.') en <strong>'.$placeholder_12.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_13)&&$value_13!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_13 ('.$value_13.') en <strong>'.$placeholder_13.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_14)&&$value_14!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_14 ('.$value_14.') en <strong>'.$placeholder_14.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_15)&&$value_15!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_15 ('.$value_15.') en <strong>'.$placeholder_15.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_16)&&$value_16!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_16 ('.$value_16.') en <strong>'.$placeholder_16.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_17)&&$value_17!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_17 ('.$value_17.') en <strong>'.$placeholder_17.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_18)&&$value_18!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_18 ('.$value_18.') en <strong>'.$placeholder_18.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_19)&&$value_19!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_19 ('.$value_19.') en <strong>'.$placeholder_19.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_20)&&$value_20!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_20 ('.$value_20.') en <strong>'.$placeholder_20.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_21)&&$value_21!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_21 ('.$value_21.') en <strong>'.$placeholder_21.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_22)&&$value_22!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_22 ('.$value_22.') en <strong>'.$placeholder_22.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_23)&&$value_23!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_23 ('.$value_23.') en <strong>'.$placeholder_23.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_24)&&$value_24!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_24 ('.$value_24.') en <strong>'.$placeholder_24.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_25)&&$value_25!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_25 ('.$value_25.') en <strong>'.$placeholder_25.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_7)&&$value_7!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_7 ('.$value_7.') en <strong>'.$placeholder_7.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_8)&&$value_8!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_8 ('.$value_8.') en <strong>'.$placeholder_8.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_9)&&$value_9!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_9 ('.$value_9.') en <strong>'.$placeholder_9.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_10)&&$value_10!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_10 ('.$value_10.') en <strong>'.$placeholder_10.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_11)&&$value_11!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_11 ('.$value_11.') en <strong>'.$placeholder_11.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_12)&&$value_12!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_12 ('.$value_12.') en <strong>'.$placeholder_12.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_13)&&$value_13!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_13 ('.$value_13.') en <strong>'.$placeholder_13.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_14)&&$value_14!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_14 ('.$value_14.') en <strong>'.$placeholder_14.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_15)&&$value_15!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_15 ('.$value_15.') en <strong>'.$placeholder_15.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_16)&&$value_16!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_16 ('.$value_16.') en <strong>'.$placeholder_16.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_17)&&$value_17!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_17 ('.$value_17.') en <strong>'.$placeholder_17.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_18)&&$value_18!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_18 ('.$value_18.') en <strong>'.$placeholder_18.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_19)&&$value_19!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_19 ('.$value_19.') en <strong>'.$placeholder_19.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_20)&&$value_20!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_20 ('.$value_20.') en <strong>'.$placeholder_20.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_21)&&$value_21!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_21 ('.$value_21.') en <strong>'.$placeholder_21.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_22)&&$value_22!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_22 ('.$value_22.') en <strong>'.$placeholder_22.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_23)&&$value_23!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_23 ('.$value_23.') en <strong>'.$placeholder_23.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_24)&&$value_24!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_24 ('.$value_24.') en <strong>'.$placeholder_24.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_25)&&$value_25!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_25 ('.$value_25.') en <strong>'.$placeholder_25.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 25; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) { case 1:$requerido[1]  = '';break;case 2:$requerido[1]  = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) { case 1:$requerido[2]  = '';break;case 2:$requerido[2]  = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) { case 1:$requerido[3]  = '';break;case 2:$requerido[3]  = 'required';$_SESSION['form_require'].= ','.$name_3;break;}
			switch ($required_4) { case 1:$requerido[4]  = '';break;case 2:$requerido[4]  = 'required';$_SESSION['form_require'].= ','.$name_4;break;}
			switch ($required_5) { case 1:$requerido[5]  = '';break;case 2:$requerido[5]  = 'required';$_SESSION['form_require'].= ','.$name_5;break;}
			switch ($required_6) { case 1:$requerido[6]  = '';break;case 2:$requerido[6]  = 'required';$_SESSION['form_require'].= ','.$name_6;break;}
			switch ($required_7) { case 1:$requerido[7]  = '';break;case 2:$requerido[7]  = 'required';$_SESSION['form_require'].= ','.$name_7;break;}
			switch ($required_8) { case 1:$requerido[8]  = '';break;case 2:$requerido[8]  = 'required';$_SESSION['form_require'].= ','.$name_8;break;}
			switch ($required_9) { case 1:$requerido[9]  = '';break;case 2:$requerido[9]  = 'required';$_SESSION['form_require'].= ','.$name_9;break;}
			switch ($required_10) {case 1:$requerido[10] = '';break;case 2:$requerido[10] = 'required';$_SESSION['form_require'].= ','.$name_10;break;}
			switch ($required_11) {case 1:$requerido[11] = '';break;case 2:$requerido[11] = 'required';$_SESSION['form_require'].= ','.$name_11;break;}
			switch ($required_12) {case 1:$requerido[12] = '';break;case 2:$requerido[12] = 'required';$_SESSION['form_require'].= ','.$name_12;break;}
			switch ($required_13) {case 1:$requerido[13] = '';break;case 2:$requerido[13] = 'required';$_SESSION['form_require'].= ','.$name_13;break;}
			switch ($required_14) {case 1:$requerido[14] = '';break;case 2:$requerido[14] = 'required';$_SESSION['form_require'].= ','.$name_14;break;}
			switch ($required_15) {case 1:$requerido[15] = '';break;case 2:$requerido[15] = 'required';$_SESSION['form_require'].= ','.$name_15;break;}
			switch ($required_16) {case 1:$requerido[16] = '';break;case 2:$requerido[16] = 'required';$_SESSION['form_require'].= ','.$name_16;break;}
			switch ($required_17) {case 1:$requerido[17] = '';break;case 2:$requerido[17] = 'required';$_SESSION['form_require'].= ','.$name_17;break;}
			switch ($required_18) {case 1:$requerido[18] = '';break;case 2:$requerido[18] = 'required';$_SESSION['form_require'].= ','.$name_18;break;}
			switch ($required_19) {case 1:$requerido[19] = '';break;case 2:$requerido[19] = 'required';$_SESSION['form_require'].= ','.$name_19;break;}
			switch ($required_20) {case 1:$requerido[20] = '';break;case 2:$requerido[20] = 'required';$_SESSION['form_require'].= ','.$name_20;break;}
			switch ($required_21) {case 1:$requerido[21] = '';break;case 2:$requerido[21] = 'required';$_SESSION['form_require'].= ','.$name_21;break;}
			switch ($required_22) {case 1:$requerido[22] = '';break;case 2:$requerido[22] = 'required';$_SESSION['form_require'].= ','.$name_22;break;}
			switch ($required_23) {case 1:$requerido[23] = '';break;case 2:$requerido[23] = 'required';$_SESSION['form_require'].= ','.$name_23;break;}
			switch ($required_24) {case 1:$requerido[24] = '';break;case 2:$requerido[24] = 'required';$_SESSION['form_require'].= ','.$name_24;break;}
			switch ($required_25) {case 1:$requerido[25] = '';break;case 2:$requerido[25] = 'required';$_SESSION['form_require'].= ','.$name_25;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1]  = explode(",", $dataB_1);
			$datos[2]  = explode(",", $dataB_2);
			$datos[3]  = explode(",", $dataB_3);
			$datos[4]  = explode(",", $dataB_4);
			$datos[5]  = explode(",", $dataB_5);
			$datos[6]  = explode(",", $dataB_6);
			$datos[7]  = explode(",", $dataB_7);
			$datos[8]  = explode(",", $dataB_8);
			$datos[9]  = explode(",", $dataB_9);
			$datos[10] = explode(",", $dataB_10);
			$datos[11] = explode(",", $dataB_11);
			$datos[12] = explode(",", $dataB_12);
			$datos[13] = explode(",", $dataB_13);
			$datos[14] = explode(",", $dataB_14);
			$datos[15] = explode(",", $dataB_15);
			$datos[16] = explode(",", $dataB_16);
			$datos[17] = explode(",", $dataB_17);
			$datos[18] = explode(",", $dataB_18);
			$datos[19] = explode(",", $dataB_19);
			$datos[20] = explode(",", $dataB_20);
			$datos[21] = explode(",", $dataB_21);
			$datos[22] = explode(",", $dataB_22);
			$datos[23] = explode(",", $dataB_23);
			$datos[24] = explode(",", $dataB_24);
			$datos[25] = explode(",", $dataB_25);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1]   .= ','.$datos[1][0].' AS '.$datos[1][0];  }else{foreach($datos[1] as $dato){$data_required[1]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2]   .= ','.$datos[2][0].' AS '.$datos[2][0];  }else{foreach($datos[2] as $dato){$data_required[2]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3]   .= ','.$datos[3][0].' AS '.$datos[3][0];  }else{foreach($datos[3] as $dato){$data_required[3]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[4])==1){$data_required[4]   .= ','.$datos[4][0].' AS '.$datos[4][0];  }else{foreach($datos[4] as $dato){$data_required[4]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[5])==1){$data_required[5]   .= ','.$datos[5][0].' AS '.$datos[5][0];  }else{foreach($datos[5] as $dato){$data_required[5]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[6])==1){$data_required[6]   .= ','.$datos[6][0].' AS '.$datos[6][0];  }else{foreach($datos[6] as $dato){$data_required[6]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[7])==1){$data_required[7]   .= ','.$datos[7][0].' AS '.$datos[7][0];  }else{foreach($datos[7] as $dato){$data_required[7]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[8])==1){$data_required[8]   .= ','.$datos[8][0].' AS '.$datos[8][0];  }else{foreach($datos[8] as $dato){$data_required[8]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[9])==1){$data_required[9]   .= ','.$datos[9][0].' AS '.$datos[9][0];  }else{foreach($datos[9] as $dato){$data_required[9]   .= ','.$dato.' AS '.$dato;}}
			if(count($datos[10])==1){$data_required[10] .= ','.$datos[10][0].' AS '.$datos[10][0];}else{foreach($datos[10] as $dato){$data_required[10] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[11])==1){$data_required[11] .= ','.$datos[11][0].' AS '.$datos[11][0];}else{foreach($datos[11] as $dato){$data_required[11] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[12])==1){$data_required[12] .= ','.$datos[12][0].' AS '.$datos[12][0];}else{foreach($datos[12] as $dato){$data_required[12] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[13])==1){$data_required[13] .= ','.$datos[13][0].' AS '.$datos[13][0];}else{foreach($datos[13] as $dato){$data_required[13] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[14])==1){$data_required[14] .= ','.$datos[14][0].' AS '.$datos[14][0];}else{foreach($datos[14] as $dato){$data_required[14] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[15])==1){$data_required[15] .= ','.$datos[15][0].' AS '.$datos[15][0];}else{foreach($datos[15] as $dato){$data_required[15] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[16])==1){$data_required[16] .= ','.$datos[16][0].' AS '.$datos[16][0];}else{foreach($datos[16] as $dato){$data_required[16] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[17])==1){$data_required[17] .= ','.$datos[17][0].' AS '.$datos[17][0];}else{foreach($datos[17] as $dato){$data_required[17] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[18])==1){$data_required[18] .= ','.$datos[18][0].' AS '.$datos[18][0];}else{foreach($datos[18] as $dato){$data_required[18] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[19])==1){$data_required[19] .= ','.$datos[19][0].' AS '.$datos[19][0];}else{foreach($datos[19] as $dato){$data_required[19] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[20])==1){$data_required[20] .= ','.$datos[20][0].' AS '.$datos[20][0];}else{foreach($datos[20] as $dato){$data_required[20] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[21])==1){$data_required[21] .= ','.$datos[21][0].' AS '.$datos[21][0];}else{foreach($datos[21] as $dato){$data_required[21] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[22])==1){$data_required[22] .= ','.$datos[22][0].' AS '.$datos[22][0];}else{foreach($datos[22] as $dato){$data_required[22] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[23])==1){$data_required[23] .= ','.$datos[23][0].' AS '.$datos[23][0];}else{foreach($datos[23] as $dato){$data_required[23] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[24])==1){$data_required[24] .= ','.$datos[24][0].' AS '.$datos[24][0];}else{foreach($datos[24] as $dato){$data_required[24] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[25])==1){$data_required[25] .= ','.$datos[25][0].' AS '.$datos[25][0];}else{foreach($datos[25] as $dato){$data_required[25] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1]   .= $filter_1." AND ".$datos[1][0]."!='' ";  }elseif($filter_1=='' OR $filter_1==0){ $filtro[1]   .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2]   .= $filter_2." AND ".$datos[2][0]."!='' ";  }elseif($filter_2=='' OR $filter_2==0){ $filtro[2]   .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3]   .= $filter_3." AND ".$datos[3][0]."!='' ";  }elseif($filter_3=='' OR $filter_3==0){ $filtro[3]   .= $datos[3][0]."!='' ";}
			if($filter_4!='0' && $filter_4!=''){$filtro[4]   .= $filter_4." AND ".$datos[4][0]."!='' ";  }elseif($filter_4=='' OR $filter_4==0){ $filtro[4]   .= $datos[4][0]."!='' ";}
			if($filter_5!='0' && $filter_5!=''){$filtro[5]   .= $filter_5." AND ".$datos[5][0]."!='' ";  }elseif($filter_5=='' OR $filter_5==0){ $filtro[5]   .= $datos[5][0]."!='' ";}
			if($filter_6!='0' && $filter_6!=''){$filtro[6]   .= $filter_6." AND ".$datos[6][0]."!='' ";  }elseif($filter_6=='' OR $filter_6==0){ $filtro[6]   .= $datos[6][0]."!='' ";}
			if($filter_7!='0' && $filter_7!=''){$filtro[7]   .= $filter_7." AND ".$datos[7][0]."!='' ";  }elseif($filter_7=='' OR $filter_7==0){ $filtro[7]   .= $datos[7][0]."!='' ";}
			if($filter_8!='0' && $filter_8!=''){$filtro[8]   .= $filter_8." AND ".$datos[8][0]."!='' ";  }elseif($filter_8=='' OR $filter_8==0){ $filtro[8]   .= $datos[8][0]."!='' ";}
			if($filter_9!='0' && $filter_9!=''){$filtro[9]   .= $filter_9." AND ".$datos[9][0]."!='' ";  }elseif($filter_9=='' OR $filter_9==0){ $filtro[9]   .= $datos[9][0]."!='' ";}
			if($filter_10!='0' && $filter_10!=''){$filtro[10] .= $filter_10." AND ".$datos[10][0]."!='' ";}elseif($filter_10=='' OR $filter_10==0){$filtro[10] .= $datos[10][0]."!='' ";}
			if($filter_11!='0' && $filter_11!=''){$filtro[11] .= $filter_11." AND ".$datos[11][0]."!='' ";}elseif($filter_11=='' OR $filter_11==0){$filtro[11] .= $datos[11][0]."!='' ";}
			if($filter_12!='0' && $filter_12!=''){$filtro[12] .= $filter_12." AND ".$datos[12][0]."!='' ";}elseif($filter_12=='' OR $filter_12==0){$filtro[12] .= $datos[12][0]."!='' ";}
			if($filter_13!='0' && $filter_13!=''){$filtro[13] .= $filter_13." AND ".$datos[13][0]."!='' ";}elseif($filter_13=='' OR $filter_13==0){$filtro[13] .= $datos[13][0]."!='' ";}
			if($filter_14!='0' && $filter_14!=''){$filtro[14] .= $filter_14." AND ".$datos[14][0]."!='' ";}elseif($filter_14=='' OR $filter_14==0){$filtro[14] .= $datos[14][0]."!='' ";}
			if($filter_15!='0' && $filter_15!=''){$filtro[15] .= $filter_15." AND ".$datos[15][0]."!='' ";}elseif($filter_15=='' OR $filter_15==0){$filtro[15] .= $datos[15][0]."!='' ";}
			if($filter_16!='0' && $filter_16!=''){$filtro[16] .= $filter_16." AND ".$datos[16][0]."!='' ";}elseif($filter_16=='' OR $filter_16==0){$filtro[16] .= $datos[16][0]."!='' ";}
			if($filter_17!='0' && $filter_17!=''){$filtro[17] .= $filter_17." AND ".$datos[17][0]."!='' ";}elseif($filter_17=='' OR $filter_17==0){$filtro[17] .= $datos[17][0]."!='' ";}
			if($filter_18!='0' && $filter_18!=''){$filtro[18] .= $filter_18." AND ".$datos[18][0]."!='' ";}elseif($filter_18=='' OR $filter_18==0){$filtro[18] .= $datos[18][0]."!='' ";}
			if($filter_19!='0' && $filter_19!=''){$filtro[19] .= $filter_19." AND ".$datos[19][0]."!='' ";}elseif($filter_19=='' OR $filter_19==0){$filtro[19] .= $datos[19][0]."!='' ";}
			if($filter_20!='0' && $filter_20!=''){$filtro[20] .= $filter_20." AND ".$datos[20][0]."!='' ";}elseif($filter_20=='' OR $filter_20==0){$filtro[20] .= $datos[20][0]."!='' ";}
			if($filter_21!='0' && $filter_21!=''){$filtro[21] .= $filter_21." AND ".$datos[21][0]."!='' ";}elseif($filter_21=='' OR $filter_21==0){$filtro[21] .= $datos[21][0]."!='' ";}
			if($filter_22!='0' && $filter_22!=''){$filtro[22] .= $filter_22." AND ".$datos[22][0]."!='' ";}elseif($filter_22=='' OR $filter_22==0){$filtro[22] .= $datos[22][0]."!='' ";}
			if($filter_23!='0' && $filter_23!=''){$filtro[23] .= $filter_23." AND ".$datos[23][0]."!='' ";}elseif($filter_23=='' OR $filter_23==0){$filtro[23] .= $datos[23][0]."!='' ";}
			if($filter_24!='0' && $filter_24!=''){$filtro[24] .= $filter_24." AND ".$datos[24][0]."!='' ";}elseif($filter_24=='' OR $filter_24==0){$filtro[24] .= $datos[24][0]."!='' ";}
			if($filter_25!='0' && $filter_25!=''){$filtro[25] .= $filter_25." AND ".$datos[25][0]."!='' ";}elseif($filter_25=='' OR $filter_25==0){$filtro[25] .= $datos[25][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){ $extracomand_1  = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){ $extracomand_2  = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){ $extracomand_3  = $datos[3][0].' ASC ';}
			if(!isset($extracomand_4) OR $extracomand_4==''){ $extracomand_4  = $datos[4][0].' ASC ';}
			if(!isset($extracomand_5) OR $extracomand_5==''){ $extracomand_5  = $datos[5][0].' ASC ';}
			if(!isset($extracomand_6) OR $extracomand_6==''){ $extracomand_6  = $datos[6][0].' ASC ';}
			if(!isset($extracomand_7) OR $extracomand_7==''){ $extracomand_7  = $datos[7][0].' ASC ';}
			if(!isset($extracomand_8) OR $extracomand_8==''){ $extracomand_8  = $datos[8][0].' ASC ';}
			if(!isset($extracomand_9) OR $extracomand_9==''){ $extracomand_9  = $datos[9][0].' ASC ';}
			if(!isset($extracomand_10) OR $extracomand_10==''){$extracomand_10 = $datos[10][0].' ASC ';}
			if(!isset($extracomand_11) OR $extracomand_11==''){$extracomand_11 = $datos[11][0].' ASC ';}
			if(!isset($extracomand_12) OR $extracomand_12==''){$extracomand_12 = $datos[12][0].' ASC ';}
			if(!isset($extracomand_13) OR $extracomand_13==''){$extracomand_13 = $datos[13][0].' ASC ';}
			if(!isset($extracomand_14) OR $extracomand_14==''){$extracomand_14 = $datos[14][0].' ASC ';}
			if(!isset($extracomand_15) OR $extracomand_15==''){$extracomand_15 = $datos[15][0].' ASC ';}
			if(!isset($extracomand_16) OR $extracomand_16==''){$extracomand_16 = $datos[16][0].' ASC ';}
			if(!isset($extracomand_17) OR $extracomand_17==''){$extracomand_17 = $datos[17][0].' ASC ';}
			if(!isset($extracomand_18) OR $extracomand_18==''){$extracomand_18 = $datos[18][0].' ASC ';}
			if(!isset($extracomand_19) OR $extracomand_19==''){$extracomand_19 = $datos[19][0].' ASC ';}
			if(!isset($extracomand_20) OR $extracomand_20==''){$extracomand_20 = $datos[20][0].' ASC ';}
			if(!isset($extracomand_21) OR $extracomand_21==''){$extracomand_21 = $datos[21][0].' ASC ';}
			if(!isset($extracomand_22) OR $extracomand_22==''){$extracomand_22 = $datos[22][0].' ASC ';}
			if(!isset($extracomand_23) OR $extracomand_23==''){$extracomand_23 = $datos[23][0].' ASC ';}
			if(!isset($extracomand_24) OR $extracomand_24==''){$extracomand_24 = $datos[24][0].' ASC ';}
			if(!isset($extracomand_25) OR $extracomand_25==''){$extracomand_25 = $datos[25][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_4 = array();
			$arrSelect_5 = array();
			$arrSelect_6 = array();
			$arrSelect_7 = array();
			$arrSelect_8 = array();
			$arrSelect_9 = array();
			$arrSelect_10 = array();
			$arrSelect_11 = array();
			$arrSelect_12 = array();
			$arrSelect_13 = array();
			$arrSelect_14 = array();
			$arrSelect_15 = array();
			$arrSelect_16 = array();
			$arrSelect_17 = array();
			$arrSelect_18 = array();
			$arrSelect_19 = array();
			$arrSelect_20 = array();
			$arrSelect_21 = array();
			$arrSelect_22 = array();
			$arrSelect_23 = array();
			$arrSelect_24 = array();
			$arrSelect_25 = array();
			$arrSelect_1  = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2  = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2],    $table_2,  '', $filtro[2],  $extracomand_2, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3  = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3],    $table_3,  '', $filtro[3],  $extracomand_3,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');
			$arrSelect_4  = db_select_array (false, $dataA_4.' AS idData ,'.$dataA_3.' AS idDataFilter '.$data_required[4],    $table_4,  '', $filtro[4],  $extracomand_4,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_4');
			$arrSelect_5  = db_select_array (false, $dataA_5.' AS idData ,'.$dataA_4.' AS idDataFilter '.$data_required[5],    $table_5,  '', $filtro[5],  $extracomand_5,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_5');
			$arrSelect_6  = db_select_array (false, $dataA_6.' AS idData ,'.$dataA_5.' AS idDataFilter '.$data_required[6],    $table_6,  '', $filtro[6],  $extracomand_6,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_6');
			$arrSelect_7  = db_select_array (false, $dataA_7.' AS idData ,'.$dataA_6.' AS idDataFilter '.$data_required[7],    $table_7,  '', $filtro[7],  $extracomand_7,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_7');
			$arrSelect_8  = db_select_array (false, $dataA_8.' AS idData ,'.$dataA_7.' AS idDataFilter '.$data_required[8],    $table_8,  '', $filtro[8],  $extracomand_8,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_8');
			$arrSelect_9  = db_select_array (false, $dataA_9.' AS idData ,'.$dataA_8.' AS idDataFilter '.$data_required[9],    $table_9,  '', $filtro[9],  $extracomand_9,  $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_9');
			$arrSelect_10 = db_select_array (false, $dataA_10.' AS idData ,'.$dataA_9.' AS idDataFilter '.$data_required[10],  $table_10, '', $filtro[10], $extracomand_10, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_10');
			$arrSelect_11 = db_select_array (false, $dataA_11.' AS idData ,'.$dataA_10.' AS idDataFilter '.$data_required[11], $table_11, '', $filtro[11], $extracomand_11, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_11');
			$arrSelect_12 = db_select_array (false, $dataA_12.' AS idData ,'.$dataA_11.' AS idDataFilter '.$data_required[12], $table_12, '', $filtro[12], $extracomand_12, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_12');
			$arrSelect_13 = db_select_array (false, $dataA_13.' AS idData ,'.$dataA_12.' AS idDataFilter '.$data_required[13], $table_13, '', $filtro[13], $extracomand_13, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_13');
			$arrSelect_14 = db_select_array (false, $dataA_14.' AS idData ,'.$dataA_13.' AS idDataFilter '.$data_required[14], $table_14, '', $filtro[14], $extracomand_14, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_14');
			$arrSelect_15 = db_select_array (false, $dataA_15.' AS idData ,'.$dataA_14.' AS idDataFilter '.$data_required[15], $table_15, '', $filtro[15], $extracomand_15, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_15');
			$arrSelect_16 = db_select_array (false, $dataA_16.' AS idData ,'.$dataA_15.' AS idDataFilter '.$data_required[16], $table_16, '', $filtro[16], $extracomand_16, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_16');
			$arrSelect_17 = db_select_array (false, $dataA_17.' AS idData ,'.$dataA_16.' AS idDataFilter '.$data_required[17], $table_17, '', $filtro[17], $extracomand_17, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_17');
			$arrSelect_18 = db_select_array (false, $dataA_18.' AS idData ,'.$dataA_17.' AS idDataFilter '.$data_required[18], $table_18, '', $filtro[18], $extracomand_18, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_18');
			$arrSelect_19 = db_select_array (false, $dataA_19.' AS idData ,'.$dataA_18.' AS idDataFilter '.$data_required[19], $table_19, '', $filtro[19], $extracomand_19, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_19');
			$arrSelect_20 = db_select_array (false, $dataA_20.' AS idData ,'.$dataA_19.' AS idDataFilter '.$data_required[20], $table_20, '', $filtro[20], $extracomand_20, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_20');
			$arrSelect_21 = db_select_array (false, $dataA_21.' AS idData ,'.$dataA_20.' AS idDataFilter '.$data_required[21], $table_21, '', $filtro[21], $extracomand_21, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_21');
			$arrSelect_22 = db_select_array (false, $dataA_22.' AS idData ,'.$dataA_21.' AS idDataFilter '.$data_required[22], $table_22, '', $filtro[22], $extracomand_22, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_22');
			$arrSelect_23 = db_select_array (false, $dataA_23.' AS idData ,'.$dataA_22.' AS idDataFilter '.$data_required[23], $table_23, '', $filtro[23], $extracomand_23, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_23');
			$arrSelect_24 = db_select_array (false, $dataA_24.' AS idData ,'.$dataA_23.' AS idDataFilter '.$data_required[24], $table_24, '', $filtro[24], $extracomand_24, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_24');
			$arrSelect_25 = db_select_array (false, $dataA_25.' AS idData ,'.$dataA_24.' AS idDataFilter '.$data_required[25], $table_25, '', $filtro[25], $extracomand_25, $dbConn, 'form_select_depend25', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_25');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}
			//si hay resultados
			if($arrSelect_4!=false){
				$input .= $this->select_input_empty($name_4, $placeholder_4, $requerido[4]);
				$input .= $this->select_input_script($arrSelect_4, $value_4, $name_3, $name_4, $datos[4], $form_name);
			}
			//si hay resultados
			if($arrSelect_5!=false){
				$input .= $this->select_input_empty($name_5, $placeholder_5, $requerido[5]);
				$input .= $this->select_input_script($arrSelect_5, $value_5, $name_4, $name_5, $datos[5], $form_name);
			}
			//si hay resultados
			if($arrSelect_6!=false){
				$input .= $this->select_input_empty($name_6, $placeholder_6, $requerido[6]);
				$input .= $this->select_input_script($arrSelect_6, $value_6, $name_5, $name_6, $datos[6], $form_name);
			}
			//si hay resultados
			if($arrSelect_7!=false){
				$input .= $this->select_input_empty($name_7, $placeholder_7, $requerido[7]);
				$input .= $this->select_input_script($arrSelect_7, $value_7, $name_6, $name_7, $datos[7], $form_name);
			}
			//si hay resultados
			if($arrSelect_8!=false){
				$input .= $this->select_input_empty($name_8, $placeholder_8, $requerido[8]);
				$input .= $this->select_input_script($arrSelect_8, $value_8, $name_7, $name_8, $datos[8], $form_name);
			}
			//si hay resultados
			if($arrSelect_9!=false){
				$input .= $this->select_input_empty($name_9, $placeholder_9, $requerido[9]);
				$input .= $this->select_input_script($arrSelect_9, $value_9, $name_8, $name_9, $datos[9], $form_name);
			}
			//si hay resultados
			if($arrSelect_10!=false){
				$input .= $this->select_input_empty($name_10, $placeholder_10, $requerido[10]);
				$input .= $this->select_input_script($arrSelect_10, $value_10, $name_9, $name_10, $datos[10], $form_name);
			}
			//si hay resultados
			if($arrSelect_11!=false){
				$input .= $this->select_input_empty($name_11, $placeholder_11, $requerido[11]);
				$input .= $this->select_input_script($arrSelect_11, $value_11, $name_10, $name_11, $datos[11], $form_name);
			}
			//si hay resultados
			if($arrSelect_12!=false){
				$input .= $this->select_input_empty($name_12, $placeholder_12, $requerido[12]);
				$input .= $this->select_input_script($arrSelect_12, $value_12, $name_11, $name_12, $datos[12], $form_name);
			}
			//si hay resultados
			if($arrSelect_13!=false){
				$input .= $this->select_input_empty($name_13, $placeholder_13, $requerido[13]);
				$input .= $this->select_input_script($arrSelect_13, $value_13, $name_12, $name_13, $datos[13], $form_name);
			}
			//si hay resultados
			if($arrSelect_14!=false){
				$input .= $this->select_input_empty($name_14, $placeholder_14, $requerido[14]);
				$input .= $this->select_input_script($arrSelect_14, $value_14, $name_13, $name_14, $datos[14], $form_name);
			}
			//si hay resultados
			if($arrSelect_15!=false){
				$input .= $this->select_input_empty($name_15, $placeholder_15, $requerido[15]);
				$input .= $this->select_input_script($arrSelect_15, $value_15, $name_14, $name_15, $datos[15], $form_name);
			}
			//si hay resultados
			if($arrSelect_16!=false){
				$input .= $this->select_input_empty($name_16, $placeholder_16, $requerido[16]);
				$input .= $this->select_input_script($arrSelect_16, $value_16, $name_15, $name_16, $datos[16], $form_name);
			}
			//si hay resultados
			if($arrSelect_17!=false){
				$input .= $this->select_input_empty($name_17, $placeholder_17, $requerido[17]);
				$input .= $this->select_input_script($arrSelect_17, $value_17, $name_16, $name_17, $datos[17], $form_name);
			}
			//si hay resultados
			if($arrSelect_18!=false){
				$input .= $this->select_input_empty($name_18, $placeholder_18, $requerido[18]);
				$input .= $this->select_input_script($arrSelect_18, $value_18, $name_17, $name_18, $datos[18], $form_name);
			}
			//si hay resultados
			if($arrSelect_19!=false){
				$input .= $this->select_input_empty($name_19, $placeholder_19, $requerido[19]);
				$input .= $this->select_input_script($arrSelect_19, $value_19, $name_18, $name_19, $datos[19], $form_name);
			}
			//si hay resultados
			if($arrSelect_20!=false){
				$input .= $this->select_input_empty($name_20, $placeholder_20, $requerido[20]);
				$input .= $this->select_input_script($arrSelect_20, $value_20, $name_19, $name_20, $datos[20], $form_name);
			}
			//si hay resultados
			if($arrSelect_21!=false){
				$input .= $this->select_input_empty($name_21, $placeholder_21, $requerido[21]);
				$input .= $this->select_input_script($arrSelect_21, $value_21, $name_20, $name_21, $datos[21], $form_name);
			}
			//si hay resultados
			if($arrSelect_22!=false){
				$input .= $this->select_input_empty($name_22, $placeholder_22, $requerido[22]);
				$input .= $this->select_input_script($arrSelect_22, $value_22, $name_21, $name_22, $datos[22], $form_name);
			}
			//si hay resultados
			if($arrSelect_23!=false){
				$input .= $this->select_input_empty($name_23, $placeholder_23, $requerido[23]);
				$input .= $this->select_input_script($arrSelect_23, $value_23, $name_22, $name_23, $datos[23], $form_name);
			}
			//si hay resultados
			if($arrSelect_24!=false){
				$input .= $this->select_input_empty($name_24, $placeholder_24, $requerido[24]);
				$input .= $this->select_input_script($arrSelect_24, $value_24, $name_23, $name_24, $datos[24], $form_name);
			}
			//si hay resultados
			if($arrSelect_25!=false){
				$input .= $this->select_input_empty($name_25, $placeholder_25, $requerido[25]);
				$input .= $this->select_input_script($arrSelect_25, $value_25, $name_24, $name_25, $datos[25], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select con filtro
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* el cual tiene un filtrode texto que permite encontrar facilmente el
	* dato necesario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_filter('Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $orderby       Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function form_select_depend50($placeholder_1,  $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1,  $filter_1,  $extracomand_1,
										$placeholder_2,  $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,  $extracomand_2,
										$placeholder_3,  $name_3,  $value_3,  $required_3,  $dataA_3,  $dataB_3,  $table_3,  $filter_3,  $extracomand_3,
										$placeholder_4,  $name_4,  $value_4,  $required_4,  $dataA_4,  $dataB_4,  $table_4,  $filter_4,  $extracomand_4,
										$placeholder_5,  $name_5,  $value_5,  $required_5,  $dataA_5,  $dataB_5,  $table_5,  $filter_5,  $extracomand_5,
										$placeholder_6,  $name_6,  $value_6,  $required_6,  $dataA_6,  $dataB_6,  $table_6,  $filter_6,  $extracomand_6,
										$placeholder_7,  $name_7,  $value_7,  $required_7,  $dataA_7,  $dataB_7,  $table_7,  $filter_7,  $extracomand_7,
										$placeholder_8,  $name_8,  $value_8,  $required_8,  $dataA_8,  $dataB_8,  $table_8,  $filter_8,  $extracomand_8,
										$placeholder_9,  $name_9,  $value_9,  $required_9,  $dataA_9,  $dataB_9,  $table_9,  $filter_9,  $extracomand_9,
										$placeholder_10, $name_10, $value_10, $required_10, $dataA_10, $dataB_10, $table_10, $filter_10, $extracomand_10,
										$placeholder_11, $name_11, $value_11, $required_11, $dataA_11, $dataB_11, $table_11, $filter_11, $extracomand_11,
										$placeholder_12, $name_12, $value_12, $required_12, $dataA_12, $dataB_12, $table_12, $filter_12, $extracomand_12,
										$placeholder_13, $name_13, $value_13, $required_13, $dataA_13, $dataB_13, $table_13, $filter_13, $extracomand_13,
										$placeholder_14, $name_14, $value_14, $required_14, $dataA_14, $dataB_14, $table_14, $filter_14, $extracomand_14,
										$placeholder_15, $name_15, $value_15, $required_15, $dataA_15, $dataB_15, $table_15, $filter_15, $extracomand_15,
										$placeholder_16, $name_16, $value_16, $required_16, $dataA_16, $dataB_16, $table_16, $filter_16, $extracomand_16,
										$placeholder_17, $name_17, $value_17, $required_17, $dataA_17, $dataB_17, $table_17, $filter_17, $extracomand_17,
										$placeholder_18, $name_18, $value_18, $required_18, $dataA_18, $dataB_18, $table_18, $filter_18, $extracomand_18,
										$placeholder_19, $name_19, $value_19, $required_19, $dataA_19, $dataB_19, $table_19, $filter_19, $extracomand_19,
										$placeholder_20, $name_20, $value_20, $required_20, $dataA_20, $dataB_20, $table_20, $filter_20, $extracomand_20,
										$placeholder_21, $name_21, $value_21, $required_21, $dataA_21, $dataB_21, $table_21, $filter_21, $extracomand_21,
										$placeholder_22, $name_22, $value_22, $required_22, $dataA_22, $dataB_22, $table_22, $filter_22, $extracomand_22,
										$placeholder_23, $name_23, $value_23, $required_23, $dataA_23, $dataB_23, $table_23, $filter_23, $extracomand_23,
										$placeholder_24, $name_24, $value_24, $required_24, $dataA_24, $dataB_24, $table_24, $filter_24, $extracomand_24,
										$placeholder_25, $name_25, $value_25, $required_25, $dataA_25, $dataB_25, $table_25, $filter_25, $extracomand_25,
										$placeholder_26, $name_26, $value_26, $required_26, $dataA_26, $dataB_26, $table_26, $filter_26, $extracomand_26,
										$placeholder_27, $name_27, $value_27, $required_27, $dataA_27, $dataB_27, $table_27, $filter_27, $extracomand_27,
										$placeholder_28, $name_28, $value_28, $required_28, $dataA_28, $dataB_28, $table_28, $filter_28, $extracomand_28,
										$placeholder_29, $name_29, $value_29, $required_29, $dataA_29, $dataB_29, $table_29, $filter_29, $extracomand_29,
										$placeholder_30, $name_30, $value_30, $required_30, $dataA_30, $dataB_30, $table_30, $filter_30, $extracomand_30,
										$placeholder_31, $name_31, $value_31, $required_31, $dataA_31, $dataB_31, $table_31, $filter_31, $extracomand_31,
										$placeholder_32, $name_32, $value_32, $required_32, $dataA_32, $dataB_32, $table_32, $filter_32, $extracomand_32,
										$placeholder_33, $name_33, $value_33, $required_33, $dataA_33, $dataB_33, $table_33, $filter_33, $extracomand_33,
										$placeholder_34, $name_34, $value_34, $required_34, $dataA_34, $dataB_34, $table_34, $filter_34, $extracomand_34,
										$placeholder_35, $name_35, $value_35, $required_35, $dataA_35, $dataB_35, $table_35, $filter_35, $extracomand_35,
										$placeholder_36, $name_36, $value_36, $required_36, $dataA_36, $dataB_36, $table_36, $filter_36, $extracomand_36,
										$placeholder_37, $name_37, $value_37, $required_37, $dataA_37, $dataB_37, $table_37, $filter_37, $extracomand_37,
										$placeholder_38, $name_38, $value_38, $required_38, $dataA_38, $dataB_38, $table_38, $filter_38, $extracomand_38,
										$placeholder_39, $name_39, $value_39, $required_39, $dataA_39, $dataB_39, $table_39, $filter_39, $extracomand_39,
										$placeholder_40, $name_40, $value_40, $required_40, $dataA_40, $dataB_40, $table_40, $filter_40, $extracomand_40,
										$placeholder_41, $name_41, $value_41, $required_41, $dataA_41, $dataB_41, $table_41, $filter_41, $extracomand_41,
										$placeholder_42, $name_42, $value_42, $required_42, $dataA_42, $dataB_42, $table_42, $filter_42, $extracomand_42,
										$placeholder_43, $name_43, $value_43, $required_43, $dataA_43, $dataB_43, $table_43, $filter_43, $extracomand_43,
										$placeholder_44, $name_44, $value_44, $required_44, $dataA_44, $dataB_44, $table_44, $filter_44, $extracomand_44,
										$placeholder_45, $name_45, $value_45, $required_45, $dataA_45, $dataB_45, $table_45, $filter_45, $extracomand_45,
										$placeholder_46, $name_46, $value_46, $required_46, $dataA_46, $dataB_46, $table_46, $filter_46, $extracomand_46,
										$placeholder_47, $name_47, $value_47, $required_47, $dataA_47, $dataB_47, $table_47, $filter_47, $extracomand_47,
										$placeholder_48, $name_48, $value_48, $required_48, $dataA_48, $dataB_48, $table_48, $filter_48, $extracomand_48,
										$placeholder_49, $name_49, $value_49, $required_49, $dataA_49, $dataB_49, $table_49, $filter_49, $extracomand_49,
										$placeholder_50, $name_50, $value_50, $required_50, $dataA_50, $dataB_50, $table_50, $filter_50, $extracomand_50,
										$dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_3, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_3 ('.$required_3.') entregada en '.$placeholder_3.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_4, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_4 ('.$required_4.') entregada en '.$placeholder_4.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_5, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_5 ('.$required_5.') entregada en '.$placeholder_5.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_6, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_6 ('.$required_6.') entregada en '.$placeholder_6.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_7, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_7 ('.$required_7.') entregada en '.$placeholder_7.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_8, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_8 ('.$required_8.') entregada en '.$placeholder_8.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_9, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_9 ('.$required_9.') entregada en '.$placeholder_9.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_10, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_10 ('.$required_10.') entregada en '.$placeholder_10.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_11, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_11 ('.$required_11.') entregada en '.$placeholder_11.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_12, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_12 ('.$required_12.') entregada en '.$placeholder_12.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_13, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_13 ('.$required_13.') entregada en '.$placeholder_13.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_14, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_14 ('.$required_14.') entregada en '.$placeholder_14.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_15, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_15 ('.$required_15.') entregada en '.$placeholder_15.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_16, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_16 ('.$required_16.') entregada en '.$placeholder_16.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_17, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_17 ('.$required_17.') entregada en '.$placeholder_17.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_18, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_18 ('.$required_18.') entregada en '.$placeholder_18.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_19, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_19 ('.$required_19.') entregada en '.$placeholder_19.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_20, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_20 ('.$required_20.') entregada en '.$placeholder_20.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_21, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_21 ('.$required_21.') entregada en '.$placeholder_21.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_22, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_22 ('.$required_22.') entregada en '.$placeholder_22.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_23, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_23 ('.$required_23.') entregada en '.$placeholder_23.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_24, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_24 ('.$required_24.') entregada en '.$placeholder_24.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_25, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_25 ('.$required_25.') entregada en '.$placeholder_25.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_26, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_26 ('.$required_26.') entregada en '.$placeholder_26.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_27, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_27 ('.$required_27.') entregada en '.$placeholder_27.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_28, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_28 ('.$required_28.') entregada en '.$placeholder_28.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_29, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_29 ('.$required_29.') entregada en '.$placeholder_29.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_30, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_30 ('.$required_30.') entregada en '.$placeholder_30.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_31, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_31 ('.$required_31.') entregada en '.$placeholder_31.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_32, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_32 ('.$required_32.') entregada en '.$placeholder_32.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_33, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_33 ('.$required_33.') entregada en '.$placeholder_33.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_34, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_34 ('.$required_34.') entregada en '.$placeholder_34.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_35, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_35 ('.$required_35.') entregada en '.$placeholder_35.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_36, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_36 ('.$required_36.') entregada en '.$placeholder_36.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_37, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_37 ('.$required_37.') entregada en '.$placeholder_37.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_38, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_38 ('.$required_38.') entregada en '.$placeholder_38.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_39, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_39 ('.$required_39.') entregada en '.$placeholder_39.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_40, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_40 ('.$required_40.') entregada en '.$placeholder_40.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_41, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_41 ('.$required_41.') entregada en '.$placeholder_41.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_42, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_42 ('.$required_42.') entregada en '.$placeholder_42.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_43, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_43 ('.$required_43.') entregada en '.$placeholder_43.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_44, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_44 ('.$required_44.') entregada en '.$placeholder_44.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_45, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_45 ('.$required_45.') entregada en '.$placeholder_45.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_46, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_46 ('.$required_46.') entregada en '.$placeholder_46.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_47, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_47 ('.$required_47.') entregada en '.$placeholder_47.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_48, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_48 ('.$required_48.') entregada en '.$placeholder_48.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_49, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_49 ('.$required_49.') entregada en '.$placeholder_49.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_50, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_50 ('.$required_50.') entregada en '.$placeholder_50.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_7)&&$value_7!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_7 ('.$value_7.') en <strong>'.$placeholder_7.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_8)&&$value_8!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_8 ('.$value_8.') en <strong>'.$placeholder_8.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_9)&&$value_9!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_9 ('.$value_9.') en <strong>'.$placeholder_9.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_10)&&$value_10!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_10 ('.$value_10.') en <strong>'.$placeholder_10.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_11)&&$value_11!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_11 ('.$value_11.') en <strong>'.$placeholder_11.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_12)&&$value_12!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_12 ('.$value_12.') en <strong>'.$placeholder_12.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_13)&&$value_13!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_13 ('.$value_13.') en <strong>'.$placeholder_13.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_14)&&$value_14!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_14 ('.$value_14.') en <strong>'.$placeholder_14.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_15)&&$value_15!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_15 ('.$value_15.') en <strong>'.$placeholder_15.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_16)&&$value_16!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_16 ('.$value_16.') en <strong>'.$placeholder_16.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_17)&&$value_17!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_17 ('.$value_17.') en <strong>'.$placeholder_17.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_18)&&$value_18!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_18 ('.$value_18.') en <strong>'.$placeholder_18.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_19)&&$value_19!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_19 ('.$value_19.') en <strong>'.$placeholder_19.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_20)&&$value_20!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_20 ('.$value_20.') en <strong>'.$placeholder_20.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_21)&&$value_21!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_21 ('.$value_21.') en <strong>'.$placeholder_21.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_22)&&$value_22!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_22 ('.$value_22.') en <strong>'.$placeholder_22.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_23)&&$value_23!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_23 ('.$value_23.') en <strong>'.$placeholder_23.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_24)&&$value_24!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_24 ('.$value_24.') en <strong>'.$placeholder_24.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_25)&&$value_25!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_25 ('.$value_25.') en <strong>'.$placeholder_25.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_26)&&$value_26!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_26 ('.$value_26.') en <strong>'.$placeholder_26.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_27)&&$value_27!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_27 ('.$value_27.') en <strong>'.$placeholder_27.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_28)&&$value_28!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_28 ('.$value_28.') en <strong>'.$placeholder_28.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_29)&&$value_29!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_29 ('.$value_29.') en <strong>'.$placeholder_29.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_30)&&$value_30!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_30 ('.$value_30.') en <strong>'.$placeholder_30.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_31)&&$value_31!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_31 ('.$value_31.') en <strong>'.$placeholder_31.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_32)&&$value_32!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_32 ('.$value_32.') en <strong>'.$placeholder_32.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_33)&&$value_33!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_33 ('.$value_33.') en <strong>'.$placeholder_33.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_34)&&$value_34!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_34 ('.$value_34.') en <strong>'.$placeholder_34.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_35)&&$value_35!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_35 ('.$value_35.') en <strong>'.$placeholder_35.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_36)&&$value_36!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_36 ('.$value_36.') en <strong>'.$placeholder_36.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_37)&&$value_37!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_37 ('.$value_37.') en <strong>'.$placeholder_37.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_38)&&$value_38!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_38 ('.$value_38.') en <strong>'.$placeholder_38.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_39)&&$value_39!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_39 ('.$value_39.') en <strong>'.$placeholder_39.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_40)&&$value_40!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_40 ('.$value_40.') en <strong>'.$placeholder_40.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_41)&&$value_41!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_41 ('.$value_41.') en <strong>'.$placeholder_41.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_42)&&$value_42!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_42 ('.$value_42.') en <strong>'.$placeholder_42.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_43)&&$value_43!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_43 ('.$value_43.') en <strong>'.$placeholder_43.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_44)&&$value_44!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_44 ('.$value_44.') en <strong>'.$placeholder_44.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_45)&&$value_45!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_45 ('.$value_45.') en <strong>'.$placeholder_45.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_46)&&$value_46!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_46 ('.$value_46.') en <strong>'.$placeholder_46.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_47)&&$value_47!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_47 ('.$value_47.') en <strong>'.$placeholder_47.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_48)&&$value_48!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_48 ('.$value_48.') en <strong>'.$placeholder_48.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_49)&&$value_49!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_49 ('.$value_49.') en <strong>'.$placeholder_49.'</strong> no es un numero');
			$errorn++;
		}
		if (!validarNumero($value_50)&&$value_50!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_50 ('.$value_50.') en <strong>'.$placeholder_50.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_1)&&$value_1!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_1 ('.$value_1.') en <strong>'.$placeholder_1.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_3)&&$value_3!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_3 ('.$value_3.') en <strong>'.$placeholder_3.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_4)&&$value_4!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_4 ('.$value_4.') en <strong>'.$placeholder_4.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_5)&&$value_5!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_5 ('.$value_5.') en <strong>'.$placeholder_5.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_6)&&$value_6!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_6 ('.$value_6.') en <strong>'.$placeholder_6.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_7)&&$value_7!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_7 ('.$value_7.') en <strong>'.$placeholder_7.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_8)&&$value_8!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_8 ('.$value_8.') en <strong>'.$placeholder_8.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_9)&&$value_9!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_9 ('.$value_9.') en <strong>'.$placeholder_9.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_10)&&$value_10!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_10 ('.$value_10.') en <strong>'.$placeholder_10.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_11)&&$value_11!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_11 ('.$value_11.') en <strong>'.$placeholder_11.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_12)&&$value_12!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_12 ('.$value_12.') en <strong>'.$placeholder_12.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_13)&&$value_13!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_13 ('.$value_13.') en <strong>'.$placeholder_13.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_14)&&$value_14!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_14 ('.$value_14.') en <strong>'.$placeholder_14.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_15)&&$value_15!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_15 ('.$value_15.') en <strong>'.$placeholder_15.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_16)&&$value_16!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_16 ('.$value_16.') en <strong>'.$placeholder_16.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_17)&&$value_17!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_17 ('.$value_17.') en <strong>'.$placeholder_17.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_18)&&$value_18!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_18 ('.$value_18.') en <strong>'.$placeholder_18.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_19)&&$value_19!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_19 ('.$value_19.') en <strong>'.$placeholder_19.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_20)&&$value_20!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_20 ('.$value_20.') en <strong>'.$placeholder_20.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_21)&&$value_21!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_21 ('.$value_21.') en <strong>'.$placeholder_21.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_22)&&$value_22!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_22 ('.$value_22.') en <strong>'.$placeholder_22.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_23)&&$value_23!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_23 ('.$value_23.') en <strong>'.$placeholder_23.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_24)&&$value_24!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_24 ('.$value_24.') en <strong>'.$placeholder_24.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_25)&&$value_25!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_25 ('.$value_25.') en <strong>'.$placeholder_25.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_26)&&$value_26!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_26 ('.$value_26.') en <strong>'.$placeholder_26.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_27)&&$value_27!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_27 ('.$value_27.') en <strong>'.$placeholder_27.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_28)&&$value_28!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_28 ('.$value_28.') en <strong>'.$placeholder_28.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_29)&&$value_29!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_29 ('.$value_29.') en <strong>'.$placeholder_29.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_30)&&$value_30!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_30 ('.$value_30.') en <strong>'.$placeholder_30.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_31)&&$value_31!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_31 ('.$value_31.') en <strong>'.$placeholder_31.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_32)&&$value_32!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_32 ('.$value_32.') en <strong>'.$placeholder_32.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_33)&&$value_33!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_33 ('.$value_33.') en <strong>'.$placeholder_33.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_34)&&$value_34!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_34 ('.$value_34.') en <strong>'.$placeholder_34.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_35)&&$value_35!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_35 ('.$value_35.') en <strong>'.$placeholder_35.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_36)&&$value_36!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_36 ('.$value_36.') en <strong>'.$placeholder_36.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_37)&&$value_37!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_37 ('.$value_37.') en <strong>'.$placeholder_37.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_38)&&$value_38!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_38 ('.$value_38.') en <strong>'.$placeholder_38.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_39)&&$value_39!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_39 ('.$value_39.') en <strong>'.$placeholder_39.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_40)&&$value_40!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_40 ('.$value_40.') en <strong>'.$placeholder_40.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_41)&&$value_41!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_41 ('.$value_41.') en <strong>'.$placeholder_41.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_42)&&$value_42!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_42 ('.$value_42.') en <strong>'.$placeholder_42.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_43)&&$value_43!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_43 ('.$value_43.') en <strong>'.$placeholder_43.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_44)&&$value_44!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_44 ('.$value_44.') en <strong>'.$placeholder_44.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_45)&&$value_45!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_45 ('.$value_45.') en <strong>'.$placeholder_45.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_46)&&$value_46!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_46 ('.$value_46.') en <strong>'.$placeholder_46.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_47)&&$value_47!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_47 ('.$value_47.') en <strong>'.$placeholder_47.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_48)&&$value_48!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_48 ('.$value_48.') en <strong>'.$placeholder_48.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_49)&&$value_49!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_49 ('.$value_49.') en <strong>'.$placeholder_49.'</strong> no es un numero entero');
			$errorn++;
		}
		if (!validaEntero($value_50)&&$value_50!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_50 ('.$value_50.') en <strong>'.$placeholder_50.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input = '';
			//recorro
			for ($i = 1; $i <= 50; $i++) {
				$data_required[$i] = '';
				$filtro[$i]        = '';
			}

			/******************************************/
			//Si el dato no es requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			switch ($required_1) { case 1:$requerido[1]  = '';break;case 2:$requerido[1]  = 'required';$_SESSION['form_require'].= ','.$name_1;break;}
			switch ($required_2) { case 1:$requerido[2]  = '';break;case 2:$requerido[2]  = 'required';$_SESSION['form_require'].= ','.$name_2;break;}
			switch ($required_3) { case 1:$requerido[3]  = '';break;case 2:$requerido[3]  = 'required';$_SESSION['form_require'].= ','.$name_3;break;}
			switch ($required_4) { case 1:$requerido[4]  = '';break;case 2:$requerido[4]  = 'required';$_SESSION['form_require'].= ','.$name_4;break;}
			switch ($required_5) { case 1:$requerido[5]  = '';break;case 2:$requerido[5]  = 'required';$_SESSION['form_require'].= ','.$name_5;break;}
			switch ($required_6) { case 1:$requerido[6]  = '';break;case 2:$requerido[6]  = 'required';$_SESSION['form_require'].= ','.$name_6;break;}
			switch ($required_7) { case 1:$requerido[7]  = '';break;case 2:$requerido[7]  = 'required';$_SESSION['form_require'].= ','.$name_7;break;}
			switch ($required_8) { case 1:$requerido[8]  = '';break;case 2:$requerido[8]  = 'required';$_SESSION['form_require'].= ','.$name_8;break;}
			switch ($required_9) { case 1:$requerido[9]  = '';break;case 2:$requerido[9]  = 'required';$_SESSION['form_require'].= ','.$name_9;break;}
			switch ($required_10) {case 1:$requerido[10] = '';break;case 2:$requerido[10] = 'required';$_SESSION['form_require'].= ','.$name_10;break;}
			switch ($required_11) {case 1:$requerido[11] = '';break;case 2:$requerido[11] = 'required';$_SESSION['form_require'].= ','.$name_11;break;}
			switch ($required_12) {case 1:$requerido[12] = '';break;case 2:$requerido[12] = 'required';$_SESSION['form_require'].= ','.$name_12;break;}
			switch ($required_13) {case 1:$requerido[13] = '';break;case 2:$requerido[13] = 'required';$_SESSION['form_require'].= ','.$name_13;break;}
			switch ($required_14) {case 1:$requerido[14] = '';break;case 2:$requerido[14] = 'required';$_SESSION['form_require'].= ','.$name_14;break;}
			switch ($required_15) {case 1:$requerido[15] = '';break;case 2:$requerido[15] = 'required';$_SESSION['form_require'].= ','.$name_15;break;}
			switch ($required_16) {case 1:$requerido[16] = '';break;case 2:$requerido[16] = 'required';$_SESSION['form_require'].= ','.$name_16;break;}
			switch ($required_17) {case 1:$requerido[17] = '';break;case 2:$requerido[17] = 'required';$_SESSION['form_require'].= ','.$name_17;break;}
			switch ($required_18) {case 1:$requerido[18] = '';break;case 2:$requerido[18] = 'required';$_SESSION['form_require'].= ','.$name_18;break;}
			switch ($required_19) {case 1:$requerido[19] = '';break;case 2:$requerido[19] = 'required';$_SESSION['form_require'].= ','.$name_19;break;}
			switch ($required_20) {case 1:$requerido[20] = '';break;case 2:$requerido[20] = 'required';$_SESSION['form_require'].= ','.$name_20;break;}
			switch ($required_21) {case 1:$requerido[21] = '';break;case 2:$requerido[21] = 'required';$_SESSION['form_require'].= ','.$name_21;break;}
			switch ($required_22) {case 1:$requerido[22] = '';break;case 2:$requerido[22] = 'required';$_SESSION['form_require'].= ','.$name_22;break;}
			switch ($required_23) {case 1:$requerido[23] = '';break;case 2:$requerido[23] = 'required';$_SESSION['form_require'].= ','.$name_23;break;}
			switch ($required_24) {case 1:$requerido[24] = '';break;case 2:$requerido[24] = 'required';$_SESSION['form_require'].= ','.$name_24;break;}
			switch ($required_25) {case 1:$requerido[25] = '';break;case 2:$requerido[25] = 'required';$_SESSION['form_require'].= ','.$name_25;break;}
			switch ($required_26) {case 1:$requerido[26] = '';break;case 2:$requerido[26] = 'required';$_SESSION['form_require'].= ','.$name_26;break;}
			switch ($required_27) {case 1:$requerido[27] = '';break;case 2:$requerido[27] = 'required';$_SESSION['form_require'].= ','.$name_27;break;}
			switch ($required_28) {case 1:$requerido[28] = '';break;case 2:$requerido[28] = 'required';$_SESSION['form_require'].= ','.$name_28;break;}
			switch ($required_29) {case 1:$requerido[29] = '';break;case 2:$requerido[29] = 'required';$_SESSION['form_require'].= ','.$name_29;break;}
			switch ($required_30) {case 1:$requerido[30] = '';break;case 2:$requerido[30] = 'required';$_SESSION['form_require'].= ','.$name_30;break;}
			switch ($required_31) {case 1:$requerido[31] = '';break;case 2:$requerido[31] = 'required';$_SESSION['form_require'].= ','.$name_31;break;}
			switch ($required_32) {case 1:$requerido[32] = '';break;case 2:$requerido[32] = 'required';$_SESSION['form_require'].= ','.$name_32;break;}
			switch ($required_33) {case 1:$requerido[33] = '';break;case 2:$requerido[33] = 'required';$_SESSION['form_require'].= ','.$name_33;break;}
			switch ($required_34) {case 1:$requerido[34] = '';break;case 2:$requerido[34] = 'required';$_SESSION['form_require'].= ','.$name_34;break;}
			switch ($required_35) {case 1:$requerido[35] = '';break;case 2:$requerido[35] = 'required';$_SESSION['form_require'].= ','.$name_35;break;}
			switch ($required_36) {case 1:$requerido[36] = '';break;case 2:$requerido[36] = 'required';$_SESSION['form_require'].= ','.$name_36;break;}
			switch ($required_37) {case 1:$requerido[37] = '';break;case 2:$requerido[37] = 'required';$_SESSION['form_require'].= ','.$name_37;break;}
			switch ($required_38) {case 1:$requerido[38] = '';break;case 2:$requerido[38] = 'required';$_SESSION['form_require'].= ','.$name_38;break;}
			switch ($required_39) {case 1:$requerido[39] = '';break;case 2:$requerido[39] = 'required';$_SESSION['form_require'].= ','.$name_39;break;}
			switch ($required_40) {case 1:$requerido[40] = '';break;case 2:$requerido[40] = 'required';$_SESSION['form_require'].= ','.$name_40;break;}
			switch ($required_41) {case 1:$requerido[41] = '';break;case 2:$requerido[41] = 'required';$_SESSION['form_require'].= ','.$name_41;break;}
			switch ($required_42) {case 1:$requerido[42] = '';break;case 2:$requerido[42] = 'required';$_SESSION['form_require'].= ','.$name_42;break;}
			switch ($required_43) {case 1:$requerido[43] = '';break;case 2:$requerido[43] = 'required';$_SESSION['form_require'].= ','.$name_43;break;}
			switch ($required_44) {case 1:$requerido[44] = '';break;case 2:$requerido[44] = 'required';$_SESSION['form_require'].= ','.$name_44;break;}
			switch ($required_45) {case 1:$requerido[45] = '';break;case 2:$requerido[45] = 'required';$_SESSION['form_require'].= ','.$name_45;break;}
			switch ($required_46) {case 1:$requerido[46] = '';break;case 2:$requerido[46] = 'required';$_SESSION['form_require'].= ','.$name_46;break;}
			switch ($required_47) {case 1:$requerido[47] = '';break;case 2:$requerido[47] = 'required';$_SESSION['form_require'].= ','.$name_47;break;}
			switch ($required_48) {case 1:$requerido[48] = '';break;case 2:$requerido[48] = 'required';$_SESSION['form_require'].= ','.$name_48;break;}
			switch ($required_49) {case 1:$requerido[49] = '';break;case 2:$requerido[49] = 'required';$_SESSION['form_require'].= ','.$name_49;break;}
			switch ($required_50) {case 1:$requerido[50] = '';break;case 2:$requerido[50] = 'required';$_SESSION['form_require'].= ','.$name_50;break;}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[1]  = explode(",", $dataB_1);
			$datos[2]  = explode(",", $dataB_2);
			$datos[3]  = explode(",", $dataB_3);
			$datos[4]  = explode(",", $dataB_4);
			$datos[5]  = explode(",", $dataB_5);
			$datos[6]  = explode(",", $dataB_6);
			$datos[7]  = explode(",", $dataB_7);
			$datos[8]  = explode(",", $dataB_8);
			$datos[9]  = explode(",", $dataB_9);
			$datos[10] = explode(",", $dataB_10);
			$datos[11] = explode(",", $dataB_11);
			$datos[12] = explode(",", $dataB_12);
			$datos[13] = explode(",", $dataB_13);
			$datos[14] = explode(",", $dataB_14);
			$datos[15] = explode(",", $dataB_15);
			$datos[16] = explode(",", $dataB_16);
			$datos[17] = explode(",", $dataB_17);
			$datos[18] = explode(",", $dataB_18);
			$datos[19] = explode(",", $dataB_19);
			$datos[20] = explode(",", $dataB_20);
			$datos[21] = explode(",", $dataB_21);
			$datos[22] = explode(",", $dataB_22);
			$datos[23] = explode(",", $dataB_23);
			$datos[24] = explode(",", $dataB_24);
			$datos[25] = explode(",", $dataB_25);
			$datos[26] = explode(",", $dataB_26);
			$datos[27] = explode(",", $dataB_27);
			$datos[28] = explode(",", $dataB_28);
			$datos[29] = explode(",", $dataB_29);
			$datos[30] = explode(",", $dataB_30);
			$datos[31] = explode(",", $dataB_31);
			$datos[32] = explode(",", $dataB_32);
			$datos[33] = explode(",", $dataB_33);
			$datos[34] = explode(",", $dataB_34);
			$datos[35] = explode(",", $dataB_35);
			$datos[36] = explode(",", $dataB_36);
			$datos[37] = explode(",", $dataB_37);
			$datos[38] = explode(",", $dataB_38);
			$datos[39] = explode(",", $dataB_39);
			$datos[40] = explode(",", $dataB_40);
			$datos[41] = explode(",", $dataB_41);
			$datos[42] = explode(",", $dataB_42);
			$datos[43] = explode(",", $dataB_43);
			$datos[44] = explode(",", $dataB_44);
			$datos[45] = explode(",", $dataB_45);
			$datos[46] = explode(",", $dataB_46);
			$datos[47] = explode(",", $dataB_47);
			$datos[48] = explode(",", $dataB_48);
			$datos[49] = explode(",", $dataB_49);
			$datos[50] = explode(",", $dataB_50);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[1])==1){$data_required[1]  .= ','.$datos[1][0].' AS '.$datos[1][0];  }else{foreach($datos[1] as $dato){$data_required[1]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[2])==1){$data_required[2]  .= ','.$datos[2][0].' AS '.$datos[2][0];  }else{foreach($datos[2] as $dato){$data_required[2]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[3])==1){$data_required[3]  .= ','.$datos[3][0].' AS '.$datos[3][0];  }else{foreach($datos[3] as $dato){$data_required[3]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[4])==1){$data_required[4]  .= ','.$datos[4][0].' AS '.$datos[4][0];  }else{foreach($datos[4] as $dato){$data_required[4]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[5])==1){$data_required[5]  .= ','.$datos[5][0].' AS '.$datos[5][0];  }else{foreach($datos[5] as $dato){$data_required[5]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[6])==1){$data_required[6]  .= ','.$datos[6][0].' AS '.$datos[6][0];  }else{foreach($datos[6] as $dato){$data_required[6]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[7])==1){$data_required[7]  .= ','.$datos[7][0].' AS '.$datos[7][0];  }else{foreach($datos[7] as $dato){$data_required[7]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[8])==1){$data_required[8]  .= ','.$datos[8][0].' AS '.$datos[8][0];  }else{foreach($datos[8] as $dato){$data_required[8]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[9])==1){$data_required[9]  .= ','.$datos[9][0].' AS '.$datos[9][0];  }else{foreach($datos[9] as $dato){$data_required[9]  .= ','.$dato.' AS '.$dato;}}
			if(count($datos[10])==1){$data_required[10] .= ','.$datos[10][0].' AS '.$datos[10][0];}else{foreach($datos[10] as $dato){$data_required[10] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[11])==1){$data_required[11] .= ','.$datos[11][0].' AS '.$datos[11][0];}else{foreach($datos[11] as $dato){$data_required[11] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[12])==1){$data_required[12] .= ','.$datos[12][0].' AS '.$datos[12][0];}else{foreach($datos[12] as $dato){$data_required[12] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[13])==1){$data_required[13] .= ','.$datos[13][0].' AS '.$datos[13][0];}else{foreach($datos[13] as $dato){$data_required[13] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[14])==1){$data_required[14] .= ','.$datos[14][0].' AS '.$datos[14][0];}else{foreach($datos[14] as $dato){$data_required[14] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[15])==1){$data_required[15] .= ','.$datos[15][0].' AS '.$datos[15][0];}else{foreach($datos[15] as $dato){$data_required[15] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[16])==1){$data_required[16] .= ','.$datos[16][0].' AS '.$datos[16][0];}else{foreach($datos[16] as $dato){$data_required[16] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[17])==1){$data_required[17] .= ','.$datos[17][0].' AS '.$datos[17][0];}else{foreach($datos[17] as $dato){$data_required[17] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[18])==1){$data_required[18] .= ','.$datos[18][0].' AS '.$datos[18][0];}else{foreach($datos[18] as $dato){$data_required[18] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[19])==1){$data_required[19] .= ','.$datos[19][0].' AS '.$datos[19][0];}else{foreach($datos[19] as $dato){$data_required[19] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[20])==1){$data_required[20] .= ','.$datos[20][0].' AS '.$datos[20][0];}else{foreach($datos[20] as $dato){$data_required[20] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[21])==1){$data_required[21] .= ','.$datos[21][0].' AS '.$datos[21][0];}else{foreach($datos[21] as $dato){$data_required[21] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[22])==1){$data_required[22] .= ','.$datos[22][0].' AS '.$datos[22][0];}else{foreach($datos[22] as $dato){$data_required[22] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[23])==1){$data_required[23] .= ','.$datos[23][0].' AS '.$datos[23][0];}else{foreach($datos[23] as $dato){$data_required[23] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[24])==1){$data_required[24] .= ','.$datos[24][0].' AS '.$datos[24][0];}else{foreach($datos[24] as $dato){$data_required[24] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[25])==1){$data_required[25] .= ','.$datos[25][0].' AS '.$datos[25][0];}else{foreach($datos[25] as $dato){$data_required[25] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[26])==1){$data_required[26] .= ','.$datos[26][0].' AS '.$datos[26][0];}else{foreach($datos[26] as $dato){$data_required[26] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[27])==1){$data_required[27] .= ','.$datos[27][0].' AS '.$datos[27][0];}else{foreach($datos[27] as $dato){$data_required[27] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[28])==1){$data_required[28] .= ','.$datos[28][0].' AS '.$datos[28][0];}else{foreach($datos[28] as $dato){$data_required[28] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[29])==1){$data_required[29] .= ','.$datos[29][0].' AS '.$datos[29][0];}else{foreach($datos[29] as $dato){$data_required[29] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[30])==1){$data_required[30] .= ','.$datos[30][0].' AS '.$datos[30][0];}else{foreach($datos[30] as $dato){$data_required[30] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[31])==1){$data_required[31] .= ','.$datos[31][0].' AS '.$datos[31][0];}else{foreach($datos[31] as $dato){$data_required[31] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[32])==1){$data_required[32] .= ','.$datos[32][0].' AS '.$datos[32][0];}else{foreach($datos[32] as $dato){$data_required[32] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[33])==1){$data_required[33] .= ','.$datos[33][0].' AS '.$datos[33][0];}else{foreach($datos[33] as $dato){$data_required[33] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[34])==1){$data_required[34] .= ','.$datos[34][0].' AS '.$datos[34][0];}else{foreach($datos[34] as $dato){$data_required[34] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[35])==1){$data_required[35] .= ','.$datos[35][0].' AS '.$datos[35][0];}else{foreach($datos[35] as $dato){$data_required[35] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[36])==1){$data_required[36] .= ','.$datos[36][0].' AS '.$datos[36][0];}else{foreach($datos[36] as $dato){$data_required[36] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[37])==1){$data_required[37] .= ','.$datos[37][0].' AS '.$datos[37][0];}else{foreach($datos[37] as $dato){$data_required[37] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[38])==1){$data_required[38] .= ','.$datos[38][0].' AS '.$datos[38][0];}else{foreach($datos[38] as $dato){$data_required[38] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[39])==1){$data_required[39] .= ','.$datos[39][0].' AS '.$datos[39][0];}else{foreach($datos[39] as $dato){$data_required[39] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[40])==1){$data_required[40] .= ','.$datos[40][0].' AS '.$datos[40][0];}else{foreach($datos[40] as $dato){$data_required[40] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[41])==1){$data_required[41] .= ','.$datos[41][0].' AS '.$datos[41][0];}else{foreach($datos[41] as $dato){$data_required[41] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[42])==1){$data_required[42] .= ','.$datos[42][0].' AS '.$datos[42][0];}else{foreach($datos[42] as $dato){$data_required[42] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[43])==1){$data_required[43] .= ','.$datos[43][0].' AS '.$datos[43][0];}else{foreach($datos[43] as $dato){$data_required[43] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[44])==1){$data_required[44] .= ','.$datos[44][0].' AS '.$datos[44][0];}else{foreach($datos[44] as $dato){$data_required[44] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[45])==1){$data_required[45] .= ','.$datos[45][0].' AS '.$datos[45][0];}else{foreach($datos[45] as $dato){$data_required[45] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[46])==1){$data_required[46] .= ','.$datos[46][0].' AS '.$datos[46][0];}else{foreach($datos[46] as $dato){$data_required[46] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[47])==1){$data_required[47] .= ','.$datos[47][0].' AS '.$datos[47][0];}else{foreach($datos[47] as $dato){$data_required[47] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[48])==1){$data_required[48] .= ','.$datos[48][0].' AS '.$datos[48][0];}else{foreach($datos[48] as $dato){$data_required[48] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[49])==1){$data_required[49] .= ','.$datos[49][0].' AS '.$datos[49][0];}else{foreach($datos[49] as $dato){$data_required[49] .= ','.$dato.' AS '.$dato;}}
			if(count($datos[50])==1){$data_required[50] .= ','.$datos[50][0].' AS '.$datos[50][0];}else{foreach($datos[50] as $dato){$data_required[50] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_1!='0' && $filter_1!=''){$filtro[1]  .= $filter_1." AND ".$datos[1][0]."!='' ";  }elseif($filter_1=='' OR $filter_1==0){ $filtro[1]  .= $datos[1][0]."!='' ";}
			if($filter_2!='0' && $filter_2!=''){$filtro[2]  .= $filter_2." AND ".$datos[2][0]."!='' ";  }elseif($filter_2=='' OR $filter_2==0){ $filtro[2]  .= $datos[2][0]."!='' ";}
			if($filter_3!='0' && $filter_3!=''){$filtro[3]  .= $filter_3." AND ".$datos[3][0]."!='' ";  }elseif($filter_3=='' OR $filter_3==0){ $filtro[3]  .= $datos[3][0]."!='' ";}
			if($filter_4!='0' && $filter_4!=''){$filtro[4]  .= $filter_4." AND ".$datos[4][0]."!='' ";  }elseif($filter_4=='' OR $filter_4==0){ $filtro[4]  .= $datos[4][0]."!='' ";}
			if($filter_5!='0' && $filter_5!=''){$filtro[5]  .= $filter_5." AND ".$datos[5][0]."!='' ";  }elseif($filter_5=='' OR $filter_5==0){ $filtro[5]  .= $datos[5][0]."!='' ";}
			if($filter_6!='0' && $filter_6!=''){$filtro[6]  .= $filter_6." AND ".$datos[6][0]."!='' ";  }elseif($filter_6=='' OR $filter_6==0){ $filtro[6]  .= $datos[6][0]."!='' ";}
			if($filter_7!='0' && $filter_7!=''){$filtro[7]  .= $filter_7." AND ".$datos[7][0]."!='' ";  }elseif($filter_7=='' OR $filter_7==0){ $filtro[7]  .= $datos[7][0]."!='' ";}
			if($filter_8!='0' && $filter_8!=''){$filtro[8]  .= $filter_8." AND ".$datos[8][0]."!='' ";  }elseif($filter_8=='' OR $filter_8==0){ $filtro[8]  .= $datos[8][0]."!='' ";}
			if($filter_9!='0' && $filter_9!=''){$filtro[9]  .= $filter_9." AND ".$datos[9][0]."!='' ";  }elseif($filter_9=='' OR $filter_9==0){ $filtro[9]  .= $datos[9][0]."!='' ";}
			if($filter_10!='0' && $filter_10!=''){$filtro[10] .= $filter_10." AND ".$datos[10][0]."!='' ";}elseif($filter_10=='' OR $filter_10==0){$filtro[10] .= $datos[10][0]."!='' ";}
			if($filter_11!='0' && $filter_11!=''){$filtro[11] .= $filter_11." AND ".$datos[11][0]."!='' ";}elseif($filter_11=='' OR $filter_11==0){$filtro[11] .= $datos[11][0]."!='' ";}
			if($filter_12!='0' && $filter_12!=''){$filtro[12] .= $filter_12." AND ".$datos[12][0]."!='' ";}elseif($filter_12=='' OR $filter_12==0){$filtro[12] .= $datos[12][0]."!='' ";}
			if($filter_13!='0' && $filter_13!=''){$filtro[13] .= $filter_13." AND ".$datos[13][0]."!='' ";}elseif($filter_13=='' OR $filter_13==0){$filtro[13] .= $datos[13][0]."!='' ";}
			if($filter_14!='0' && $filter_14!=''){$filtro[14] .= $filter_14." AND ".$datos[14][0]."!='' ";}elseif($filter_14=='' OR $filter_14==0){$filtro[14] .= $datos[14][0]."!='' ";}
			if($filter_15!='0' && $filter_15!=''){$filtro[15] .= $filter_15." AND ".$datos[15][0]."!='' ";}elseif($filter_15=='' OR $filter_15==0){$filtro[15] .= $datos[15][0]."!='' ";}
			if($filter_16!='0' && $filter_16!=''){$filtro[16] .= $filter_16." AND ".$datos[16][0]."!='' ";}elseif($filter_16=='' OR $filter_16==0){$filtro[16] .= $datos[16][0]."!='' ";}
			if($filter_17!='0' && $filter_17!=''){$filtro[17] .= $filter_17." AND ".$datos[17][0]."!='' ";}elseif($filter_17=='' OR $filter_17==0){$filtro[17] .= $datos[17][0]."!='' ";}
			if($filter_18!='0' && $filter_18!=''){$filtro[18] .= $filter_18." AND ".$datos[18][0]."!='' ";}elseif($filter_18=='' OR $filter_18==0){$filtro[18] .= $datos[18][0]."!='' ";}
			if($filter_19!='0' && $filter_19!=''){$filtro[19] .= $filter_19." AND ".$datos[19][0]."!='' ";}elseif($filter_19=='' OR $filter_19==0){$filtro[19] .= $datos[19][0]."!='' ";}
			if($filter_20!='0' && $filter_20!=''){$filtro[20] .= $filter_20." AND ".$datos[20][0]."!='' ";}elseif($filter_20=='' OR $filter_20==0){$filtro[20] .= $datos[20][0]."!='' ";}
			if($filter_21!='0' && $filter_21!=''){$filtro[21] .= $filter_21." AND ".$datos[21][0]."!='' ";}elseif($filter_21=='' OR $filter_21==0){$filtro[21] .= $datos[21][0]."!='' ";}
			if($filter_22!='0' && $filter_22!=''){$filtro[22] .= $filter_22." AND ".$datos[22][0]."!='' ";}elseif($filter_22=='' OR $filter_22==0){$filtro[22] .= $datos[22][0]."!='' ";}
			if($filter_23!='0' && $filter_23!=''){$filtro[23] .= $filter_23." AND ".$datos[23][0]."!='' ";}elseif($filter_23=='' OR $filter_23==0){$filtro[23] .= $datos[23][0]."!='' ";}
			if($filter_24!='0' && $filter_24!=''){$filtro[24] .= $filter_24." AND ".$datos[24][0]."!='' ";}elseif($filter_24=='' OR $filter_24==0){$filtro[24] .= $datos[24][0]."!='' ";}
			if($filter_25!='0' && $filter_25!=''){$filtro[25] .= $filter_25." AND ".$datos[25][0]."!='' ";}elseif($filter_25=='' OR $filter_25==0){$filtro[25] .= $datos[25][0]."!='' ";}
			if($filter_26!='0' && $filter_26!=''){$filtro[26] .= $filter_26." AND ".$datos[26][0]."!='' ";}elseif($filter_26=='' OR $filter_26==0){$filtro[26] .= $datos[26][0]."!='' ";}
			if($filter_27!='0' && $filter_27!=''){$filtro[27] .= $filter_27." AND ".$datos[27][0]."!='' ";}elseif($filter_27=='' OR $filter_27==0){$filtro[27] .= $datos[27][0]."!='' ";}
			if($filter_28!='0' && $filter_28!=''){$filtro[28] .= $filter_28." AND ".$datos[28][0]."!='' ";}elseif($filter_28=='' OR $filter_28==0){$filtro[28] .= $datos[28][0]."!='' ";}
			if($filter_29!='0' && $filter_29!=''){$filtro[29] .= $filter_29." AND ".$datos[29][0]."!='' ";}elseif($filter_29=='' OR $filter_29==0){$filtro[29] .= $datos[29][0]."!='' ";}
			if($filter_30!='0' && $filter_30!=''){$filtro[30] .= $filter_30." AND ".$datos[30][0]."!='' ";}elseif($filter_30=='' OR $filter_30==0){$filtro[30] .= $datos[30][0]."!='' ";}
			if($filter_31!='0' && $filter_31!=''){$filtro[31] .= $filter_31." AND ".$datos[31][0]."!='' ";}elseif($filter_31=='' OR $filter_31==0){$filtro[31] .= $datos[31][0]."!='' ";}
			if($filter_32!='0' && $filter_32!=''){$filtro[32] .= $filter_32." AND ".$datos[32][0]."!='' ";}elseif($filter_32=='' OR $filter_32==0){$filtro[32] .= $datos[32][0]."!='' ";}
			if($filter_33!='0' && $filter_33!=''){$filtro[33] .= $filter_33." AND ".$datos[33][0]."!='' ";}elseif($filter_33=='' OR $filter_33==0){$filtro[33] .= $datos[33][0]."!='' ";}
			if($filter_34!='0' && $filter_34!=''){$filtro[34] .= $filter_34." AND ".$datos[34][0]."!='' ";}elseif($filter_34=='' OR $filter_34==0){$filtro[34] .= $datos[34][0]."!='' ";}
			if($filter_35!='0' && $filter_35!=''){$filtro[35] .= $filter_35." AND ".$datos[35][0]."!='' ";}elseif($filter_35=='' OR $filter_35==0){$filtro[35] .= $datos[35][0]."!='' ";}
			if($filter_36!='0' && $filter_36!=''){$filtro[36] .= $filter_36." AND ".$datos[36][0]."!='' ";}elseif($filter_36=='' OR $filter_36==0){$filtro[36] .= $datos[36][0]."!='' ";}
			if($filter_37!='0' && $filter_37!=''){$filtro[37] .= $filter_37." AND ".$datos[37][0]."!='' ";}elseif($filter_37=='' OR $filter_37==0){$filtro[37] .= $datos[37][0]."!='' ";}
			if($filter_38!='0' && $filter_38!=''){$filtro[38] .= $filter_38." AND ".$datos[38][0]."!='' ";}elseif($filter_38=='' OR $filter_38==0){$filtro[38] .= $datos[38][0]."!='' ";}
			if($filter_39!='0' && $filter_39!=''){$filtro[39] .= $filter_39." AND ".$datos[39][0]."!='' ";}elseif($filter_39=='' OR $filter_39==0){$filtro[39] .= $datos[39][0]."!='' ";}
			if($filter_40!='0' && $filter_40!=''){$filtro[40] .= $filter_40." AND ".$datos[40][0]."!='' ";}elseif($filter_40=='' OR $filter_40==0){$filtro[40] .= $datos[40][0]."!='' ";}
			if($filter_41!='0' && $filter_41!=''){$filtro[41] .= $filter_41." AND ".$datos[41][0]."!='' ";}elseif($filter_41=='' OR $filter_41==0){$filtro[41] .= $datos[41][0]."!='' ";}
			if($filter_42!='0' && $filter_42!=''){$filtro[42] .= $filter_42." AND ".$datos[42][0]."!='' ";}elseif($filter_42=='' OR $filter_42==0){$filtro[42] .= $datos[42][0]."!='' ";}
			if($filter_43!='0' && $filter_43!=''){$filtro[43] .= $filter_43." AND ".$datos[43][0]."!='' ";}elseif($filter_43=='' OR $filter_43==0){$filtro[43] .= $datos[43][0]."!='' ";}
			if($filter_44!='0' && $filter_44!=''){$filtro[44] .= $filter_44." AND ".$datos[44][0]."!='' ";}elseif($filter_44=='' OR $filter_44==0){$filtro[44] .= $datos[44][0]."!='' ";}
			if($filter_45!='0' && $filter_45!=''){$filtro[45] .= $filter_45." AND ".$datos[45][0]."!='' ";}elseif($filter_45=='' OR $filter_45==0){$filtro[45] .= $datos[45][0]."!='' ";}
			if($filter_46!='0' && $filter_46!=''){$filtro[46] .= $filter_46." AND ".$datos[46][0]."!='' ";}elseif($filter_46=='' OR $filter_46==0){$filtro[46] .= $datos[46][0]."!='' ";}
			if($filter_47!='0' && $filter_47!=''){$filtro[47] .= $filter_47." AND ".$datos[47][0]."!='' ";}elseif($filter_47=='' OR $filter_47==0){$filtro[47] .= $datos[47][0]."!='' ";}
			if($filter_48!='0' && $filter_48!=''){$filtro[48] .= $filter_48." AND ".$datos[48][0]."!='' ";}elseif($filter_48=='' OR $filter_48==0){$filtro[48] .= $datos[48][0]."!='' ";}
			if($filter_49!='0' && $filter_49!=''){$filtro[49] .= $filter_49." AND ".$datos[49][0]."!='' ";}elseif($filter_49=='' OR $filter_49==0){$filtro[49] .= $datos[49][0]."!='' ";}
			if($filter_50!='0' && $filter_50!=''){$filtro[50] .= $filter_50." AND ".$datos[50][0]."!='' ";}elseif($filter_50=='' OR $filter_50==0){$filtro[50] .= $datos[50][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_1) OR $extracomand_1==''){ $extracomand_1 = $datos[1][0].' ASC ';}
			if(!isset($extracomand_2) OR $extracomand_2==''){ $extracomand_2 = $datos[2][0].' ASC ';}
			if(!isset($extracomand_3) OR $extracomand_3==''){ $extracomand_3 = $datos[3][0].' ASC ';}
			if(!isset($extracomand_4) OR $extracomand_4==''){ $extracomand_4 = $datos[4][0].' ASC ';}
			if(!isset($extracomand_5) OR $extracomand_5==''){ $extracomand_5 = $datos[5][0].' ASC ';}
			if(!isset($extracomand_6) OR $extracomand_6==''){ $extracomand_6 = $datos[6][0].' ASC ';}
			if(!isset($extracomand_7) OR $extracomand_7==''){ $extracomand_7 = $datos[7][0].' ASC ';}
			if(!isset($extracomand_8) OR $extracomand_8==''){ $extracomand_8 = $datos[8][0].' ASC ';}
			if(!isset($extracomand_9) OR $extracomand_9==''){ $extracomand_9 = $datos[9][0].' ASC ';}
			if(!isset($extracomand_10) OR $extracomand_10==''){$extracomand_10 = $datos[10][0].' ASC ';}
			if(!isset($extracomand_11) OR $extracomand_11==''){$extracomand_11 = $datos[11][0].' ASC ';}
			if(!isset($extracomand_12) OR $extracomand_12==''){$extracomand_12 = $datos[12][0].' ASC ';}
			if(!isset($extracomand_13) OR $extracomand_13==''){$extracomand_13 = $datos[13][0].' ASC ';}
			if(!isset($extracomand_14) OR $extracomand_14==''){$extracomand_14 = $datos[14][0].' ASC ';}
			if(!isset($extracomand_15) OR $extracomand_15==''){$extracomand_15 = $datos[15][0].' ASC ';}
			if(!isset($extracomand_16) OR $extracomand_16==''){$extracomand_16 = $datos[16][0].' ASC ';}
			if(!isset($extracomand_17) OR $extracomand_17==''){$extracomand_17 = $datos[17][0].' ASC ';}
			if(!isset($extracomand_18) OR $extracomand_18==''){$extracomand_18 = $datos[18][0].' ASC ';}
			if(!isset($extracomand_19) OR $extracomand_19==''){$extracomand_19 = $datos[19][0].' ASC ';}
			if(!isset($extracomand_20) OR $extracomand_20==''){$extracomand_20 = $datos[20][0].' ASC ';}
			if(!isset($extracomand_21) OR $extracomand_21==''){$extracomand_21 = $datos[21][0].' ASC ';}
			if(!isset($extracomand_22) OR $extracomand_22==''){$extracomand_22 = $datos[22][0].' ASC ';}
			if(!isset($extracomand_23) OR $extracomand_23==''){$extracomand_23 = $datos[23][0].' ASC ';}
			if(!isset($extracomand_24) OR $extracomand_24==''){$extracomand_24 = $datos[24][0].' ASC ';}
			if(!isset($extracomand_25) OR $extracomand_25==''){$extracomand_25 = $datos[25][0].' ASC ';}
			if(!isset($extracomand_26) OR $extracomand_26==''){$extracomand_26 = $datos[26][0].' ASC ';}
			if(!isset($extracomand_27) OR $extracomand_27==''){$extracomand_27 = $datos[27][0].' ASC ';}
			if(!isset($extracomand_28) OR $extracomand_28==''){$extracomand_28 = $datos[28][0].' ASC ';}
			if(!isset($extracomand_29) OR $extracomand_29==''){$extracomand_29 = $datos[29][0].' ASC ';}
			if(!isset($extracomand_30) OR $extracomand_30==''){$extracomand_30 = $datos[30][0].' ASC ';}
			if(!isset($extracomand_31) OR $extracomand_31==''){$extracomand_31 = $datos[31][0].' ASC ';}
			if(!isset($extracomand_32) OR $extracomand_32==''){$extracomand_32 = $datos[32][0].' ASC ';}
			if(!isset($extracomand_33) OR $extracomand_33==''){$extracomand_33 = $datos[33][0].' ASC ';}
			if(!isset($extracomand_34) OR $extracomand_34==''){$extracomand_34 = $datos[34][0].' ASC ';}
			if(!isset($extracomand_35) OR $extracomand_35==''){$extracomand_35 = $datos[35][0].' ASC ';}
			if(!isset($extracomand_36) OR $extracomand_36==''){$extracomand_36 = $datos[36][0].' ASC ';}
			if(!isset($extracomand_37) OR $extracomand_37==''){$extracomand_37 = $datos[37][0].' ASC ';}
			if(!isset($extracomand_38) OR $extracomand_38==''){$extracomand_38 = $datos[38][0].' ASC ';}
			if(!isset($extracomand_39) OR $extracomand_39==''){$extracomand_39 = $datos[39][0].' ASC ';}
			if(!isset($extracomand_40) OR $extracomand_40==''){$extracomand_40 = $datos[40][0].' ASC ';}
			if(!isset($extracomand_41) OR $extracomand_41==''){$extracomand_41 = $datos[41][0].' ASC ';}
			if(!isset($extracomand_42) OR $extracomand_42==''){$extracomand_42 = $datos[42][0].' ASC ';}
			if(!isset($extracomand_43) OR $extracomand_43==''){$extracomand_43 = $datos[43][0].' ASC ';}
			if(!isset($extracomand_44) OR $extracomand_44==''){$extracomand_44 = $datos[44][0].' ASC ';}
			if(!isset($extracomand_45) OR $extracomand_45==''){$extracomand_45 = $datos[45][0].' ASC ';}
			if(!isset($extracomand_46) OR $extracomand_46==''){$extracomand_46 = $datos[46][0].' ASC ';}
			if(!isset($extracomand_47) OR $extracomand_47==''){$extracomand_47 = $datos[47][0].' ASC ';}
			if(!isset($extracomand_48) OR $extracomand_48==''){$extracomand_48 = $datos[48][0].' ASC ';}
			if(!isset($extracomand_49) OR $extracomand_49==''){$extracomand_49 = $datos[49][0].' ASC ';}
			if(!isset($extracomand_50) OR $extracomand_50==''){$extracomand_50 = $datos[50][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_1 = array();
			$arrSelect_2 = array();
			$arrSelect_3 = array();
			$arrSelect_4 = array();
			$arrSelect_5 = array();
			$arrSelect_6 = array();
			$arrSelect_7 = array();
			$arrSelect_8 = array();
			$arrSelect_9 = array();
			$arrSelect_10 = array();
			$arrSelect_11 = array();
			$arrSelect_12 = array();
			$arrSelect_13 = array();
			$arrSelect_14 = array();
			$arrSelect_15 = array();
			$arrSelect_16 = array();
			$arrSelect_17 = array();
			$arrSelect_18 = array();
			$arrSelect_19 = array();
			$arrSelect_20 = array();
			$arrSelect_21 = array();
			$arrSelect_22 = array();
			$arrSelect_23 = array();
			$arrSelect_24 = array();
			$arrSelect_25 = array();
			$arrSelect_26 = array();
			$arrSelect_27 = array();
			$arrSelect_28 = array();
			$arrSelect_29 = array();
			$arrSelect_30 = array();
			$arrSelect_31 = array();
			$arrSelect_32 = array();
			$arrSelect_33 = array();
			$arrSelect_34 = array();
			$arrSelect_35 = array();
			$arrSelect_36 = array();
			$arrSelect_37 = array();
			$arrSelect_38 = array();
			$arrSelect_39 = array();
			$arrSelect_40 = array();
			$arrSelect_41 = array();
			$arrSelect_42 = array();
			$arrSelect_43 = array();
			$arrSelect_44 = array();
			$arrSelect_45 = array();
			$arrSelect_46 = array();
			$arrSelect_47 = array();
			$arrSelect_48 = array();
			$arrSelect_49 = array();
			$arrSelect_50 = array();
			$arrSelect_1  = db_select_array (false, $dataA_1.' AS idData '.$data_required[1], $table_1, '', $filtro[1], $extracomand_1, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_1');
			$arrSelect_2  = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2],    $table_2,  '', $filtro[2],  $extracomand_2, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');
			$arrSelect_3  = db_select_array (false, $dataA_3.' AS idData ,'.$dataA_2.' AS idDataFilter '.$data_required[3],    $table_3,  '', $filtro[3],  $extracomand_3,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_3');
			$arrSelect_4  = db_select_array (false, $dataA_4.' AS idData ,'.$dataA_3.' AS idDataFilter '.$data_required[4],    $table_4,  '', $filtro[4],  $extracomand_4,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_4');
			$arrSelect_5  = db_select_array (false, $dataA_5.' AS idData ,'.$dataA_4.' AS idDataFilter '.$data_required[5],    $table_5,  '', $filtro[5],  $extracomand_5,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_5');
			$arrSelect_6  = db_select_array (false, $dataA_6.' AS idData ,'.$dataA_5.' AS idDataFilter '.$data_required[6],    $table_6,  '', $filtro[6],  $extracomand_6,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_6');
			$arrSelect_7  = db_select_array (false, $dataA_7.' AS idData ,'.$dataA_6.' AS idDataFilter '.$data_required[7],    $table_7,  '', $filtro[7],  $extracomand_7,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_7');
			$arrSelect_8  = db_select_array (false, $dataA_8.' AS idData ,'.$dataA_7.' AS idDataFilter '.$data_required[8],    $table_8,  '', $filtro[8],  $extracomand_8,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_8');
			$arrSelect_9  = db_select_array (false, $dataA_9.' AS idData ,'.$dataA_8.' AS idDataFilter '.$data_required[9],    $table_9,  '', $filtro[9],  $extracomand_9,  $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_9');
			$arrSelect_10 = db_select_array (false, $dataA_10.' AS idData ,'.$dataA_9.' AS idDataFilter '.$data_required[10],  $table_10, '', $filtro[10], $extracomand_10, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_10');
			$arrSelect_11 = db_select_array (false, $dataA_11.' AS idData ,'.$dataA_10.' AS idDataFilter '.$data_required[11], $table_11, '', $filtro[11], $extracomand_11, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_11');
			$arrSelect_12 = db_select_array (false, $dataA_12.' AS idData ,'.$dataA_11.' AS idDataFilter '.$data_required[12], $table_12, '', $filtro[12], $extracomand_12, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_12');
			$arrSelect_13 = db_select_array (false, $dataA_13.' AS idData ,'.$dataA_12.' AS idDataFilter '.$data_required[13], $table_13, '', $filtro[13], $extracomand_13, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_13');
			$arrSelect_14 = db_select_array (false, $dataA_14.' AS idData ,'.$dataA_13.' AS idDataFilter '.$data_required[14], $table_14, '', $filtro[14], $extracomand_14, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_14');
			$arrSelect_15 = db_select_array (false, $dataA_15.' AS idData ,'.$dataA_14.' AS idDataFilter '.$data_required[15], $table_15, '', $filtro[15], $extracomand_15, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_15');
			$arrSelect_16 = db_select_array (false, $dataA_16.' AS idData ,'.$dataA_15.' AS idDataFilter '.$data_required[16], $table_16, '', $filtro[16], $extracomand_16, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_16');
			$arrSelect_17 = db_select_array (false, $dataA_17.' AS idData ,'.$dataA_16.' AS idDataFilter '.$data_required[17], $table_17, '', $filtro[17], $extracomand_17, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_17');
			$arrSelect_18 = db_select_array (false, $dataA_18.' AS idData ,'.$dataA_17.' AS idDataFilter '.$data_required[18], $table_18, '', $filtro[18], $extracomand_18, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_18');
			$arrSelect_19 = db_select_array (false, $dataA_19.' AS idData ,'.$dataA_18.' AS idDataFilter '.$data_required[19], $table_19, '', $filtro[19], $extracomand_19, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_19');
			$arrSelect_20 = db_select_array (false, $dataA_20.' AS idData ,'.$dataA_19.' AS idDataFilter '.$data_required[20], $table_20, '', $filtro[20], $extracomand_20, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_20');
			$arrSelect_21 = db_select_array (false, $dataA_21.' AS idData ,'.$dataA_20.' AS idDataFilter '.$data_required[21], $table_21, '', $filtro[21], $extracomand_21, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_21');
			$arrSelect_22 = db_select_array (false, $dataA_22.' AS idData ,'.$dataA_21.' AS idDataFilter '.$data_required[22], $table_22, '', $filtro[22], $extracomand_22, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_22');
			$arrSelect_23 = db_select_array (false, $dataA_23.' AS idData ,'.$dataA_22.' AS idDataFilter '.$data_required[23], $table_23, '', $filtro[23], $extracomand_23, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_23');
			$arrSelect_24 = db_select_array (false, $dataA_24.' AS idData ,'.$dataA_23.' AS idDataFilter '.$data_required[24], $table_24, '', $filtro[24], $extracomand_24, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_24');
			$arrSelect_25 = db_select_array (false, $dataA_25.' AS idData ,'.$dataA_24.' AS idDataFilter '.$data_required[25], $table_25, '', $filtro[25], $extracomand_25, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_25');
			$arrSelect_26 = db_select_array (false, $dataA_26.' AS idData ,'.$dataA_25.' AS idDataFilter '.$data_required[26], $table_26, '', $filtro[26], $extracomand_26, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_26');
			$arrSelect_27 = db_select_array (false, $dataA_27.' AS idData ,'.$dataA_26.' AS idDataFilter '.$data_required[27], $table_27, '', $filtro[27], $extracomand_27, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_27');
			$arrSelect_28 = db_select_array (false, $dataA_28.' AS idData ,'.$dataA_27.' AS idDataFilter '.$data_required[28], $table_28, '', $filtro[28], $extracomand_28, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_28');
			$arrSelect_29 = db_select_array (false, $dataA_29.' AS idData ,'.$dataA_28.' AS idDataFilter '.$data_required[29], $table_29, '', $filtro[29], $extracomand_29, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_29');
			$arrSelect_30 = db_select_array (false, $dataA_30.' AS idData ,'.$dataA_29.' AS idDataFilter '.$data_required[30], $table_30, '', $filtro[30], $extracomand_30, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_30');
			$arrSelect_31 = db_select_array (false, $dataA_31.' AS idData ,'.$dataA_30.' AS idDataFilter '.$data_required[31], $table_31, '', $filtro[31], $extracomand_31, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_31');
			$arrSelect_32 = db_select_array (false, $dataA_32.' AS idData ,'.$dataA_31.' AS idDataFilter '.$data_required[32], $table_32, '', $filtro[32], $extracomand_32, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_32');
			$arrSelect_33 = db_select_array (false, $dataA_33.' AS idData ,'.$dataA_32.' AS idDataFilter '.$data_required[33], $table_33, '', $filtro[33], $extracomand_33, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_33');
			$arrSelect_34 = db_select_array (false, $dataA_34.' AS idData ,'.$dataA_33.' AS idDataFilter '.$data_required[34], $table_34, '', $filtro[34], $extracomand_34, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_34');
			$arrSelect_35 = db_select_array (false, $dataA_35.' AS idData ,'.$dataA_34.' AS idDataFilter '.$data_required[35], $table_35, '', $filtro[35], $extracomand_35, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_35');
			$arrSelect_36 = db_select_array (false, $dataA_36.' AS idData ,'.$dataA_35.' AS idDataFilter '.$data_required[36], $table_36, '', $filtro[36], $extracomand_36, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_36');
			$arrSelect_37 = db_select_array (false, $dataA_37.' AS idData ,'.$dataA_36.' AS idDataFilter '.$data_required[37], $table_37, '', $filtro[37], $extracomand_37, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_37');
			$arrSelect_38 = db_select_array (false, $dataA_38.' AS idData ,'.$dataA_37.' AS idDataFilter '.$data_required[38], $table_38, '', $filtro[38], $extracomand_38, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_38');
			$arrSelect_39 = db_select_array (false, $dataA_39.' AS idData ,'.$dataA_38.' AS idDataFilter '.$data_required[39], $table_39, '', $filtro[39], $extracomand_39, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_39');
			$arrSelect_40 = db_select_array (false, $dataA_40.' AS idData ,'.$dataA_39.' AS idDataFilter '.$data_required[40], $table_40, '', $filtro[40], $extracomand_40, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_40');
			$arrSelect_41 = db_select_array (false, $dataA_41.' AS idData ,'.$dataA_40.' AS idDataFilter '.$data_required[41], $table_41, '', $filtro[41], $extracomand_41, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_41');
			$arrSelect_42 = db_select_array (false, $dataA_42.' AS idData ,'.$dataA_41.' AS idDataFilter '.$data_required[42], $table_42, '', $filtro[42], $extracomand_42, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_42');
			$arrSelect_43 = db_select_array (false, $dataA_43.' AS idData ,'.$dataA_42.' AS idDataFilter '.$data_required[43], $table_43, '', $filtro[43], $extracomand_43, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_43');
			$arrSelect_44 = db_select_array (false, $dataA_44.' AS idData ,'.$dataA_43.' AS idDataFilter '.$data_required[44], $table_44, '', $filtro[44], $extracomand_44, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_44');
			$arrSelect_45 = db_select_array (false, $dataA_45.' AS idData ,'.$dataA_44.' AS idDataFilter '.$data_required[45], $table_45, '', $filtro[45], $extracomand_45, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_45');
			$arrSelect_46 = db_select_array (false, $dataA_46.' AS idData ,'.$dataA_45.' AS idDataFilter '.$data_required[46], $table_46, '', $filtro[46], $extracomand_46, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_46');
			$arrSelect_47 = db_select_array (false, $dataA_47.' AS idData ,'.$dataA_46.' AS idDataFilter '.$data_required[47], $table_47, '', $filtro[47], $extracomand_47, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_47');
			$arrSelect_48 = db_select_array (false, $dataA_48.' AS idData ,'.$dataA_47.' AS idDataFilter '.$data_required[48], $table_48, '', $filtro[48], $extracomand_48, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_48');
			$arrSelect_49 = db_select_array (false, $dataA_49.' AS idData ,'.$dataA_48.' AS idDataFilter '.$data_required[49], $table_49, '', $filtro[49], $extracomand_49, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_49');
			$arrSelect_50 = db_select_array (false, $dataA_50.' AS idData ,'.$dataA_49.' AS idDataFilter '.$data_required[50], $table_50, '', $filtro[50], $extracomand_50, $dbConn, 'form_select_depend50', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_50');

			/******************************************/
			//si hay resultados
			if($arrSelect_1!=false){
				$input .= $this->select_input_gen($name_1, $placeholder_1, $requerido[1], $arrSelect_1, $value_1, $datos[1]);
			}
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}
			//si hay resultados
			if($arrSelect_3!=false){
				$input .= $this->select_input_empty($name_3, $placeholder_3, $requerido[3]);
				$input .= $this->select_input_script($arrSelect_3, $value_3, $name_2, $name_3, $datos[3], $form_name);
			}
			//si hay resultados
			if($arrSelect_4!=false){
				$input .= $this->select_input_empty($name_4, $placeholder_4, $requerido[4]);
				$input .= $this->select_input_script($arrSelect_4, $value_4, $name_3, $name_4, $datos[4], $form_name);
			}
			//si hay resultados
			if($arrSelect_5!=false){
				$input .= $this->select_input_empty($name_5, $placeholder_5, $requerido[5]);
				$input .= $this->select_input_script($arrSelect_5, $value_5, $name_4, $name_5, $datos[5], $form_name);
			}
			//si hay resultados
			if($arrSelect_6!=false){
				$input .= $this->select_input_empty($name_6, $placeholder_6, $requerido[6]);
				$input .= $this->select_input_script($arrSelect_6, $value_6, $name_5, $name_6, $datos[6], $form_name);
			}
			//si hay resultados
			if($arrSelect_7!=false){
				$input .= $this->select_input_empty($name_7, $placeholder_7, $requerido[7]);
				$input .= $this->select_input_script($arrSelect_7, $value_7, $name_6, $name_7, $datos[7], $form_name);
			}
			//si hay resultados
			if($arrSelect_8!=false){
				$input .= $this->select_input_empty($name_8, $placeholder_8, $requerido[8]);
				$input .= $this->select_input_script($arrSelect_8, $value_8, $name_7, $name_8, $datos[8], $form_name);
			}
			//si hay resultados
			if($arrSelect_9!=false){
				$input .= $this->select_input_empty($name_9, $placeholder_9, $requerido[9]);
				$input .= $this->select_input_script($arrSelect_9, $value_9, $name_8, $name_9, $datos[9], $form_name);
			}
			//si hay resultados
			if($arrSelect_10!=false){
				$input .= $this->select_input_empty($name_10, $placeholder_10, $requerido[10]);
				$input .= $this->select_input_script($arrSelect_10, $value_10, $name_9, $name_10, $datos[10], $form_name);
			}
			//si hay resultados
			if($arrSelect_11!=false){
				$input .= $this->select_input_empty($name_11, $placeholder_11, $requerido[11]);
				$input .= $this->select_input_script($arrSelect_11, $value_11, $name_10, $name_11, $datos[11], $form_name);
			}
			//si hay resultados
			if($arrSelect_12!=false){
				$input .= $this->select_input_empty($name_12, $placeholder_12, $requerido[12]);
				$input .= $this->select_input_script($arrSelect_12, $value_12, $name_11, $name_12, $datos[12], $form_name);
			}
			//si hay resultados
			if($arrSelect_13!=false){
				$input .= $this->select_input_empty($name_13, $placeholder_13, $requerido[13]);
				$input .= $this->select_input_script($arrSelect_13, $value_13, $name_12, $name_13, $datos[13], $form_name);
			}
			//si hay resultados
			if($arrSelect_14!=false){
				$input .= $this->select_input_empty($name_14, $placeholder_14, $requerido[14]);
				$input .= $this->select_input_script($arrSelect_14, $value_14, $name_13, $name_14, $datos[14], $form_name);
			}
			//si hay resultados
			if($arrSelect_15!=false){
				$input .= $this->select_input_empty($name_15, $placeholder_15, $requerido[15]);
				$input .= $this->select_input_script($arrSelect_15, $value_15, $name_14, $name_15, $datos[15], $form_name);
			}
			//si hay resultados
			if($arrSelect_16!=false){
				$input .= $this->select_input_empty($name_16, $placeholder_16, $requerido[16]);
				$input .= $this->select_input_script($arrSelect_16, $value_16, $name_15, $name_16, $datos[16], $form_name);
			}
			//si hay resultados
			if($arrSelect_17!=false){
				$input .= $this->select_input_empty($name_17, $placeholder_17, $requerido[17]);
				$input .= $this->select_input_script($arrSelect_17, $value_17, $name_16, $name_17, $datos[17], $form_name);
			}
			//si hay resultados
			if($arrSelect_18!=false){
				$input .= $this->select_input_empty($name_18, $placeholder_18, $requerido[18]);
				$input .= $this->select_input_script($arrSelect_18, $value_18, $name_17, $name_18, $datos[18], $form_name);
			}
			//si hay resultados
			if($arrSelect_19!=false){
				$input .= $this->select_input_empty($name_19, $placeholder_19, $requerido[19]);
				$input .= $this->select_input_script($arrSelect_19, $value_19, $name_18, $name_19, $datos[19], $form_name);
			}
			//si hay resultados
			if($arrSelect_20!=false){
				$input .= $this->select_input_empty($name_20, $placeholder_20, $requerido[20]);
				$input .= $this->select_input_script($arrSelect_20, $value_20, $name_19, $name_20, $datos[20], $form_name);
			}
			//si hay resultados
			if($arrSelect_21!=false){
				$input .= $this->select_input_empty($name_21, $placeholder_21, $requerido[21]);
				$input .= $this->select_input_script($arrSelect_21, $value_21, $name_20, $name_21, $datos[21], $form_name);
			}
			//si hay resultados
			if($arrSelect_22!=false){
				$input .= $this->select_input_empty($name_22, $placeholder_22, $requerido[22]);
				$input .= $this->select_input_script($arrSelect_22, $value_22, $name_21, $name_22, $datos[22], $form_name);
			}
			//si hay resultados
			if($arrSelect_23!=false){
				$input .= $this->select_input_empty($name_23, $placeholder_23, $requerido[23]);
				$input .= $this->select_input_script($arrSelect_23, $value_23, $name_22, $name_23, $datos[23], $form_name);
			}
			//si hay resultados
			if($arrSelect_24!=false){
				$input .= $this->select_input_empty($name_24, $placeholder_24, $requerido[24]);
				$input .= $this->select_input_script($arrSelect_24, $value_24, $name_23, $name_24, $datos[24], $form_name);
			}
			//si hay resultados
			if($arrSelect_25!=false){
				$input .= $this->select_input_empty($name_25, $placeholder_25, $requerido[25]);
				$input .= $this->select_input_script($arrSelect_25, $value_25, $name_24, $name_25, $datos[25], $form_name);
			}
			//si hay resultados
			if($arrSelect_26!=false){
				$input .= $this->select_input_empty($name_26, $placeholder_26, $requerido[26]);
				$input .= $this->select_input_script($arrSelect_26, $value_26, $name_25, $name_26, $datos[26], $form_name);
			}
			//si hay resultados
			if($arrSelect_27!=false){
				$input .= $this->select_input_empty($name_27, $placeholder_27, $requerido[27]);
				$input .= $this->select_input_script($arrSelect_27, $value_27, $name_26, $name_27, $datos[27], $form_name);
			}
			//si hay resultados
			if($arrSelect_28!=false){
				$input .= $this->select_input_empty($name_28, $placeholder_28, $requerido[28]);
				$input .= $this->select_input_script($arrSelect_28, $value_28, $name_27, $name_28, $datos[28], $form_name);
			}
			//si hay resultados
			if($arrSelect_29!=false){
				$input .= $this->select_input_empty($name_29, $placeholder_29, $requerido[29]);
				$input .= $this->select_input_script($arrSelect_29, $value_29, $name_28, $name_29, $datos[29], $form_name);
			}
			//si hay resultados
			if($arrSelect_30!=false){
				$input .= $this->select_input_empty($name_30, $placeholder_30, $requerido[30]);
				$input .= $this->select_input_script($arrSelect_30, $value_30, $name_29, $name_30, $datos[30], $form_name);
			}
			//si hay resultados
			if($arrSelect_31!=false){
				$input .= $this->select_input_empty($name_31, $placeholder_31, $requerido[31]);
				$input .= $this->select_input_script($arrSelect_31, $value_31, $name_30, $name_31, $datos[31], $form_name);
			}
			//si hay resultados
			if($arrSelect_32!=false){
				$input .= $this->select_input_empty($name_32, $placeholder_32, $requerido[32]);
				$input .= $this->select_input_script($arrSelect_32, $value_32, $name_31, $name_32, $datos[32], $form_name);
			}
			//si hay resultados
			if($arrSelect_33!=false){
				$input .= $this->select_input_empty($name_33, $placeholder_33, $requerido[33]);
				$input .= $this->select_input_script($arrSelect_33, $value_33, $name_32, $name_33, $datos[33], $form_name);
			}
			//si hay resultados
			if($arrSelect_34!=false){
				$input .= $this->select_input_empty($name_34, $placeholder_34, $requerido[34]);
				$input .= $this->select_input_script($arrSelect_34, $value_34, $name_33, $name_34, $datos[34], $form_name);
			}
			//si hay resultados
			if($arrSelect_35!=false){
				$input .= $this->select_input_empty($name_35, $placeholder_35, $requerido[35]);
				$input .= $this->select_input_script($arrSelect_35, $value_35, $name_34, $name_35, $datos[35], $form_name);
			}
			//si hay resultados
			if($arrSelect_36!=false){
				$input .= $this->select_input_empty($name_36, $placeholder_36, $requerido[36]);
				$input .= $this->select_input_script($arrSelect_36, $value_36, $name_35, $name_36, $datos[36], $form_name);
			}
			//si hay resultados
			if($arrSelect_37!=false){
				$input .= $this->select_input_empty($name_37, $placeholder_37, $requerido[37]);
				$input .= $this->select_input_script($arrSelect_37, $value_37, $name_36, $name_37, $datos[37], $form_name);
			}
			//si hay resultados
			if($arrSelect_38!=false){
				$input .= $this->select_input_empty($name_38, $placeholder_38, $requerido[38]);
				$input .= $this->select_input_script($arrSelect_38, $value_38, $name_37, $name_38, $datos[38], $form_name);
			}
			//si hay resultados
			if($arrSelect_39!=false){
				$input .= $this->select_input_empty($name_39, $placeholder_39, $requerido[39]);
				$input .= $this->select_input_script($arrSelect_39, $value_39, $name_38, $name_39, $datos[39], $form_name);
			}
			//si hay resultados
			if($arrSelect_40!=false){
				$input .= $this->select_input_empty($name_40, $placeholder_40, $requerido[40]);
				$input .= $this->select_input_script($arrSelect_40, $value_40, $name_39, $name_40, $datos[40], $form_name);
			}
			//si hay resultados
			if($arrSelect_41!=false){
				$input .= $this->select_input_empty($name_41, $placeholder_41, $requerido[41]);
				$input .= $this->select_input_script($arrSelect_41, $value_41, $name_40, $name_41, $datos[41], $form_name);
			}
			//si hay resultados
			if($arrSelect_42!=false){
				$input .= $this->select_input_empty($name_42, $placeholder_42, $requerido[42]);
				$input .= $this->select_input_script($arrSelect_42, $value_42, $name_41, $name_42, $datos[42], $form_name);
			}
			//si hay resultados
			if($arrSelect_43!=false){
				$input .= $this->select_input_empty($name_43, $placeholder_43, $requerido[43]);
				$input .= $this->select_input_script($arrSelect_43, $value_43, $name_42, $name_43, $datos[43], $form_name);
			}
			//si hay resultados
			if($arrSelect_44!=false){
				$input .= $this->select_input_empty($name_44, $placeholder_44, $requerido[44]);
				$input .= $this->select_input_script($arrSelect_44, $value_44, $name_43, $name_44, $datos[44], $form_name);
			}
			//si hay resultados
			if($arrSelect_45!=false){
				$input .= $this->select_input_empty($name_45, $placeholder_45, $requerido[45]);
				$input .= $this->select_input_script($arrSelect_45, $value_45, $name_44, $name_45, $datos[45], $form_name);
			}
			//si hay resultados
			if($arrSelect_46!=false){
				$input .= $this->select_input_empty($name_46, $placeholder_46, $requerido[46]);
				$input .= $this->select_input_script($arrSelect_46, $value_46, $name_45, $name_46, $datos[16], $form_name);
			}
			//si hay resultados
			if($arrSelect_47!=false){
				$input .= $this->select_input_empty($name_47, $placeholder_47, $requerido[47]);
				$input .= $this->select_input_script($arrSelect_47, $value_47, $name_46, $name_47, $datos[47], $form_name);
			}
			//si hay resultados
			if($arrSelect_48!=false){
				$input .= $this->select_input_empty($name_48, $placeholder_48, $requerido[48]);
				$input .= $this->select_input_script($arrSelect_48, $value_48, $name_47, $name_48, $datos[48], $form_name);
			}
			//si hay resultados
			if($arrSelect_49!=false){
				$input .= $this->select_input_empty($name_49, $placeholder_49, $requerido[49]);
				$input .= $this->select_input_script($arrSelect_49, $value_49, $name_48, $name_49, $datos[49], $form_name);
			}
			//si hay resultados
			if($arrSelect_50!=false){
				$input .= $this->select_input_empty($name_50, $placeholder_50, $requerido[50]);
				$input .= $this->select_input_script($arrSelect_50, $value_50, $name_49, $name_50, $datos[50], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->form_select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                              'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                              $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder_x   Nombre o texto a mostrar en el navegador
	* String   $name_x          Nombre del identificador del Input
	* int      $value_x         Valor por defecto, debe ser un numero entero
	* int      $required_x      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA_x         Identificador de la base de datos
	* String   $dataB_x         Texto a mostrar en la opción del input
	* String   $table_x         Tabla desde donde tomar los datos
	* String   $filter_x        Filtro de la seleccion de la base de datos
	* String   $extracomand_x   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn          Puntero a la base de datos
	* String   $form_name       Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function form_select_independ1($name_1, $dataA_1,
										  $placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2,  $filter_2,   $extracomand_2,
										  $dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required_2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
			$errorn++;
		}
		//se verifica si es un numero lo que se recibe
		if (!validarNumero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero');
			$errorn++;
		}
		//Verifica si el numero recibido es un entero
		if (!validaEntero($value_2)&&$value_2!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value_2 ('.$value_2.') en <strong>'.$placeholder_2.'</strong> no es un numero entero');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){

			/******************************************/
			//Arreglos
			$requerido     = array();
			$datos         = array();
			$data_required = array();
			$filtro        = array();

			//Variables Vacias
			$input            = '';
			$data_required[2] = '';
			$filtro[2]        = '';

			/******************************************/
			//Valido si es requerido
			switch ($required_2) {
				//Si el dato no es requerido
				case 1:
					$requerido[2] = '';//variable vacia
					break;
				//Si el dato es requerido
				case 2:
					$requerido[2]             = 'required';   //se marca como requerido
					if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
					$_SESSION['form_require'].= ','.$name_2;  //se guarda en la sesion para la validacion al guardar formulario
					break;
			}

			/******************************************/
			//Se separan los datos a mostrar
			$datos[2] = explode(",", $dataB_2);

			/******************************************/
			//Se arman los datos requeridos
			if(count($datos[2])==1){$data_required[2] .= ','.$datos[2][0].' AS '.$datos[2][0];}else{foreach($datos[2] as $dato){$data_required[2] .= ','.$dato.' AS '.$dato;}}

			/******************************************/
			//Si se envia filtro desde afuera
			if($filter_2!='0' && $filter_2!=''){$filtro[2] .= $filter_2." AND ".$datos[2][0]."!='' ";}elseif($filter_2=='' OR $filter_2==0){$filtro[2] .= $datos[2][0]."!='' ";}

			/******************************************/
			//Verifica si se enviaron mas datos
			if(!isset($extracomand_2) OR $extracomand_2==''){$extracomand_2 = $datos[2][0].' ASC ';}

			/******************************************/
			//consulto
			$arrSelect_2 = array();
			$arrSelect_2 = db_select_array (false, $dataA_2.' AS idData ,'.$dataA_1.' AS idDataFilter '.$data_required[2], $table_2, '', $filtro[2], $extracomand_2,$dbConn, 'form_select_independ1', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect_2');

			/******************************************/
			//si hay resultados
			if($arrSelect_2!=false){
				$input .= $this->select_input_empty($name_2, $placeholder_2, $requerido[2]);
				$input .= $this->select_input_script($arrSelect_2, $value_2, $name_1, $name_2, $datos[2], $form_name);
			}

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/




}


?>
