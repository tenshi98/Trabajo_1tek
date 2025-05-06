<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1002-002).');
}
/*******************************************************************************************************************/
/*                                                    Clases                                                       */
/*******************************************************************************************************************/
class Basic_Inputs{

    /////////////////////////////        PRIVADAS        /////////////////////////////
	/****************************************************************************************/
	//Crea el input en base a los datos
	private function select_input_gen($name, $placeholder, $requerido, $arrSelect, $value, $datos){

		/******************************************/
		//generacion del input
		$data = '
			<div class="form-group" id="div_'.$name.'">
				<div class="field">
					<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >';
						//Recorro
						$selectedx = 'selected="selected"';
						foreach ( $arrSelect as $select ) {
							if($value==$select['idData']){
								$selectedx = '';
							}
						}

						$data .= '<option value="" '.$selectedx.'>Seleccione un(a) '.$placeholder.'</option>';

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
				<div class="field">
					<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
						<option value="" selected>Seleccione un(a) '.$placeholder.'</option>
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
		$tipos = array(1, 2, 3, 4, 5, 6);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($type, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $type ('.$type.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de mensaje
			switch ($type) {
				case 1: $tipo = 'h1'; break;
				case 2: $tipo = 'h2'; break;
				case 3: $tipo = 'h3'; break;
				case 4: $tipo = 'h4'; break;
				case 5: $tipo = 'h5'; break;
				case 6: $tipo = 'p';  break;
			}

			/******************************************/
			//generacion del input
			$input = '<'.$tipo.'>'.$Text.'</'.$tipo.'>';

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
	* String   $type      Tipo de mensaje
	* String   $Text      Texto del mensaje
	* @return  String
	************************************************************************/
	public function form_post_data($type, $icon, $iconAnimation, $Text){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$tipos = array(1, 2, 3, 4);
		//Definicion de errores
		$autoClose = 0;
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($type, $tipos)) {
			alert_post_data(4,1,1,0, 'La configuracion $type ('.$type.') entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			alert_post_data($type,$icon, $iconAnimation, $autoClose, $Text);
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
	/***********************************************************************
	* Crea un input tipo texto
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto, especificamente para ingresar usuario
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_login_usr('Usuario','user', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_login_usr($placeholder,$name, $value){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Valido si es requerido (siempre es requerido)
			$requerido = 'required'; //se marca como requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''&&$value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="field" id="div_'.$name.'">
				<input type="text" placeholder="'.$placeholder.'" class="form-control top" name="'.$name.'" autocomplete="off" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)">
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
		}
	}
	/*******************************************************************************************************************/
	/***********************************************************************
	* Crea un input tipo rut
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo rut, el cual valida el formato de rut ingresado
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_login_rut('Rut','rut', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_login_rut($placeholder,$name, $value){

		//********************************************************/
		//Definicion de errores
		$errorn = 0;
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Valido si es requerido (siempre es requerido)
			$requerido = 'required'; //se marca como requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''&&$value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="field" id="div_'.$name.'">
				<input type="text" placeholder="'.$placeholder.'" class="form-control top" id="'.$name.'" name="'.$name.'" autocomplete="off" value="'.$valor.'" '.$requerido.' onkeydown="return soloRut(event)">
			</div>';

			/******************************************/
			//ejecucion script
			$input .='<script>$("#'.$name.'").rut();</script>';

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
	* 	$Form->input_login_pass('Password','password', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_login_pass($placeholder,$name, $value){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Valido si es requerido (siempre es requerido)
			$requerido = 'required'; //se marca como requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''&&$value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="field" id="div_'.$name.'">
				<div class="input-group col-sm-12 bootstrap-timepicker">
					<input type="password" placeholder="'.$placeholder.'" class="form-control bottom border_fix" name="'.$name.'" id="'.$name.'" autocomplete="off" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)">
					<span class="pass_view_log" id="view_button_'.$name.'"><i class="fa fa-eye" aria-hidden="true"></i></span>
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
	* Crea un input tipo email
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo texto, el cual permite ingresar elemail
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_login_mail('Email','email', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_login_mail($placeholder,$name, $value){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Valido si es requerido (siempre es requerido)
			$requerido = 'required'; //se marca como requerido
			if(!isset($_SESSION['form_require']) OR $_SESSION['form_require']==''){$_SESSION['form_require'] = 'required';}
			$_SESSION['form_require'].= ','.$name;  //se guarda en la sesion para la validacion al guardar formulario

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''&&$value!=0){$valor = $value;}

			/******************************************/
			//generacion del input
			$input = '
			<div class="field" id="div_'.$name.'">
				<input type="email"  placeholder="'.$placeholder.'" class="form-control"    name="'.$name.'" autocomplete="off" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)">
			</div>';

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
	* Permite crear un input tipo texto, al enviar un nombre tipo arreglo,
	* lo remmplaza por nombre normal
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input('text','Categoria','Cat', 'Categoria 1', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $type          Tipo de input creado
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input($type,$placeholder,$name, $value, $required){

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
			$XXname = str_replace('[]', '', $name);

			/******************************************/
			//Si existe un valor entregado
			$valor = '';
			if($value!=''&&$value!=0){$valor = $value;}

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
			<div class="field" id="div_'.$name.'">
				<input class="form-control '.$XXname.'" type="'.$type.'" placeholder="'.$placeholder.'" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)">
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
	* 	$Form->input_icon('text','Categoria','idCategoria', 1, 1,'fa fa-map');
	*
	*===========================    Parametros   ===========================
	* String   $type          Tipo de input creado
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $icon          icono a utilizar(fontawesome)
	* @return  String
	************************************************************************/
	public function input_icon($type,$placeholder,$name, $value, $required, $icon){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input type="'.$type.'" placeholder="'.$placeholder.'"  class="form-control timepicker-default" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloLetras(event)"  >
					<span class="input-group-addon add-on"><i class="'.$icon.'"></i></span>
				</div>
			</div>';

			/******************************************/
			//Imprimir dato
			echo $input;
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
	* 	$Form->input_hidden('idCategoria', 1, 1 );
	* 	$Form->input_hidden('Categoria', 'Categoria', 1 );
	* 	$Form->input_hidden('idCategoria', 1, 2 );
	*
	*===========================    Parametros   ===========================
	* String   $name       Nombre del identificador del Input
	* String   $value      Valor por defecto, puede ser texto o valor
	* int      $required   Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_hidden($name, $value, $required){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required ('.$required.') entregada en <strong>'.$name.'</strong> no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			/******************************************/
			//Nuevo Nombre
			$EXname = str_replace('[]', '', $name);

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
			$input = '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' class="'.$EXname.'" >';

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
	* 	$Form->input_disabled('text', 'Dia actual','dia', '2018-02-02', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $type          Tipo de input creado
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_disabled($type,$placeholder,$name, $value, $required){

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
			$input = '<input type="'.$type.'" placeholder="'.$placeholder.'" name="'.$name.'" id="'.$name.'" class="form-control '.$name.'" value="'.$valor.'"  '.$requerido.' disabled="disabled">';

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
	* Permite crear un input tipo texto, permite nombres tipo arreglo
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_values_val('text','Categoria','Cat', 1, '', '', 25);
	*
	*===========================    Parametros   ===========================
	* String   $type          Tipo de input creado
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $extra_class   Permite ingresar estilos extras al input
	* String   $style         Permite escribir directamente un estilo css
	* String   $value         Valor por defecto, ingresar numeros enteros
	* @return  String
	************************************************************************/
	public function input_values_val($type,$placeholder,$name,$required,$extra_class,$style,$value){

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
			<div class="field" id="div_'.$name.'">
				<input placeholder="'.$placeholder.'"  class="form-control '.$extra_class.'" style="'.$style.'" type="'.$type.'" name="'.$name.'" id="'.$name.'"  '.$requerido.' onkeydown="return soloNumeroNaturalReal(event)" value="'.$valor.'" >
			</div>';

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
	* 	$Form->input_values_val_2('text','Categoria','Cat', 1, '', '', 'Categoria' );
	*
	*===========================    Parametros   ===========================
	* String   $type          Tipo de input creado
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $extra_class   Permite ingresar estilos extras al input
	* String   $style         Permite escribir directamente un estilo css
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_values_val_2($type,$placeholder,$name,$required,$extra_class,$style,$value){

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
			<div class="field" id="div_'.$name.'">
				<input placeholder="'.$placeholder.'"  class="form-control '.$extra_class.'" style="'.$style.'" type="'.$type.'" name="'.$name.'" id="'.$EXname.'"  '.$requerido.' onkeydown="return soloNumeroRealRacional(event)" value="'.$valor.'" >
			</div>';

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
	* Permite crear un input tipo text
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_textarea_obs('Observaciones','observaciones', 1, '', 'Observaciones varias' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $style         Permite escribir directamente un estilo css
	* @return  String
	************************************************************************/
	public function input_textarea_obs($placeholder,$name,$value, $required,$style){

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
			<div class="field" id="div_'.$name.'">
				<textarea placeholder="'.$placeholder.'" name="'.$name.'" id="'.$EXname.'" class="form-control" style="overflow: auto; word-wrap: break-word; resize: horizontal; '.$style.'" '.$requerido.' onkeydown="return soloLetrasTextArea(event)" >'.$valor.'</textarea>
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
	* 	$Form->input_date('Fecha','fecha', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* int      $value         Valor por defecto, debe ser un numero entero
	* @return  String
	************************************************************************/
	public function input_date($placeholder, $name, $value, $required){

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
			<div class="field" id="div_'.$name.'">
				<input placeholder="'.$placeholder.'" class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.'>
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
	* 	$Form->input_time('Hora', 'hora','', 1);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Time     $value         Valor por defecto, debe tener formato hora
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_time($placeholder,$name, $value, $required){

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
		if (!validaHora($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El valor ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una hora');
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
			<div class="field" id="div_'.$name.'">
				<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' >
			</div>';

			/******************************************/
			//ejecucion script
			$input .='
			<script type="text/javascript">
				$("#'.$EXname.'").clockpicker({
					placement: "top",
					align: "right",
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
	* 	$Form->input_time_popover('Hora Inspeccion','H_inspeccion', '', 1);
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Time     $value         Valor por defecto, debe tener formato hora
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_time_popover($placeholder,$name, $value, $required){

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
		//valido la hora
		if(!validaHora($value)&&$value!=''){
			alert_post_data(4,1,1,0, 'El dato ingresado en $value ('.$value.') en <strong>'.$placeholder.'</strong> no es una hora');
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

			//solicitud de recursos
			$input  ='<script src="'.DB_SITE_REPO.'/LIBS_js/popover_timepicker/js/timepicki_bottom.js"></script>';
			$input .='<link rel="stylesheet" type="text/css" href="'.DB_SITE_REPO.'/LIBS_js/popover_timepicker/css/timepicki_bottom.css">';

			//generacion del input
			$input .='
			<div class="field" id="div_'.$name.'">
				<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' >
			</div>';

			/******************************************/
			//ejecucion script
			$input .='<script type="text/javascript">$("#'.$EXname.'").timepicker();</script>';

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
	* 	$Form->input_radio('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_radio($placeholder,$name,$value, $required, $color){

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
			<div class="field" id="div_'.$name.'">
				<div class="radio radio-'.$tipo.'">
					<input  type="radio" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'">
					<label for="'.$name.'">
						'.$placeholder.'
					</label>
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
	* Permite crear un input tipo checkbox
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->input_checkbox('Opciones','opciones', '');
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* @return  String
	************************************************************************/
	public function input_checkbox($placeholder,$name,$value, $required, $color){

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
			<div class="field" id="div_'.$name.'">
				<div class="checkbox checkbox-'.$tipo.'">
					<input                type="hidden"   value="1"          '.$check.' name="'.$name.'" >
					<input class="styled" type="checkbox" value="'.$valor.'" '.$check.' name="'.$name.'" id="'.$name.'">
					<label for="'.$name.'">
						'.$placeholder.'
					</label>
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
	public function input_number($placeholder,$name, $value, $required){

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
			$EXname  = str_replace('[]', '', $name).'_'.rand(1, 999);
			$EXname2 = str_replace('[]', '', $name);

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
			<div class="field" id="div_'.$EXname.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default '.$EXname2.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)"  >
					<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
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
	public function input_values($placeholder,$name, $value, $required){

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
			$EXname  = str_replace('[]', '', $name).'_'.rand(1, 999);
			$EXname2 = str_replace('[]', '', $name);

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
			<div class="field" id="div_'.$EXname.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default '.$EXname2.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)"  >
					<span class="input-group-addon add-on"><i class="fa fa-usd" aria-hidden="true"></i></span>
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
	public function input_integer($placeholder,$name, $value, $required){

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
			$EXname  = str_replace('[]', '', $name).'_'.rand(1, 999);
			$EXname2 = str_replace('[]', '', $name);

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
			<div class="field" id="div_'.$EXname.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default '.$EXname2.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNaturalReal(event)"  >
					<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
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
	* 	$Form->input_number_change('Numeros','numeros', '', 1, 'OnChange' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* Decimal  $value         Valor por defecto, ingresar numeros enteros o decimales
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_number_change($placeholder,$name, $value, $required,$OnChange){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default number_change" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)" onkeyup="'.$OnChange.'(this)"  >
					<span class="input-group-addon add-on"><i class="fa fa-subscript" aria-hidden="true"></i></span>
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
	public function input_number_spinner($placeholder,$name, $value, $min, $max, $step, $ndecimal, $required){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroRealRacional(event)" style="text-align: center;">
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
	public function input_phone($placeholder,$name, $value, $required){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)"  >
					<span class="input-group-addon add-on"><i class="fa fa-phone" aria-hidden="true"></i></span>
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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input placeholder="'.$placeholder.'"  class="form-control timepicker-default" type="text" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloNumeroNatural(event)"  >
					<span class="input-group-addon add-on"><i class="fa fa-fax" aria-hidden="true"></i></span>
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
	* 	$Form->input_rut('Rut','rut', '', 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function input_rut($placeholder,$name, $value, $required){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input type="text" placeholder="'.$placeholder.'"  class="form-control timepicker-default" name="'.$name.'" id="'.$EXname.'" value="'.$valor.'" '.$requerido.' onkeydown="return soloRut(event)" oninput="checkRut(this)"  >
					<span class="input-group-addon add-on"><i class="fa fa-male" aria-hidden="true"></i></span>
				</div>
			</div>';

			/******************************************/
			//ejecucion script
			$input.= "
			<script>
				function checkRut(rut) {
					let value = rut.value.replace(/\./g, '').replace('-', '');
					if (value.match(/^(\d{2})(\d{3}){2}(\w{1})$/)) {
						value = value.replace(/^(\d{2})(\d{3})(\d{3})(\w{1})$/, '$1.$2.$3-$4');
					}else if (value.match(/^(\d)(\d{3}){2}(\w{0,1})$/)) {
						value = value.replace(/^(\d)(\d{3})(\d{3})(\w{0,1})$/, '$1.$2.$3-$4');
					}else if (value.match(/^(\d)(\d{3})(\d{0,2})$/)) {
						value = value.replace(/^(\d)(\d{3})(\d{0,2})$/, '$1.$2.$3');
					}else if (value.match(/^(\d)(\d{0,2})$/)) {
						value = value.replace(/^(\d)(\d{0,2})$/, '$1.$2');
					}
					rut.value = value;
				}
			</script>";
			//$input.='<script>$("#'.$EXname.'").rut();</script>';

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
	* 	$Form->color_picker('Categoria','idCategoria', 1, 1 );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* String   $value         Valor por defecto, puede ser texto o valor
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* @return  String
	************************************************************************/
	public function color_picker($placeholder,$name, $value, $required){

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
			<div class="field" id="div_'.$name.'">
				<div class="input-group bootstrap-timepicker">
					<input type="text" placeholder="'.$placeholder.'" class="form-control timepicker-default" name="'.$name.'" id="'.$name.'" value="'.$valor.'" '.$requerido.' '.$bcolor.' onkeydown="return soloLetras(event)">
					<span class="input-group-addon add-on"><i class="fa fa-paint-brush" aria-hidden="true"></i></span>
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
			</script>';

			/******************************************/
			//Imprimir dato
			echo $input;
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
	* 	$Form->terms_and_conditions('terminos','He leido los ','www.google.cl','terminos y condiciones', 'submit_btn' );
	*
	*===========================    Parametros   ===========================
	* String   $name         Nombre del identificador del Input
	* String   $inicio       Texto inicio
	* String   $link         Enlace con el documento a mostrar en el popup
	* String   $fin          Texto final
	* String   $submit_name  Identificador del boton submit del formulario
	* @return  String
	************************************************************************/
	public function terms_and_conditions($name, $inicio, $link, $fin, $submit_name){

		/******************************************/
		//generacion del input
		$input = '
		<div class="field" id="div_'.$name.'">
			<div class="checkbox checkbox-primary">
				<input class="styled" type="checkbox" name="'.$name.'" id="'.$name.'" value="1" onchange="acbtn_'.$name.'(this)">
				<label>
					'.$inicio.'  <a class="iframe" href="'.$link.'">'.$fin.'</a>
				</label>
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
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->select('Meses del año','idMeses', 1, 2, 'idMes', 'Nombre', 'tabla_meses', '', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $style         Permite escribir directamente un estilo css
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function select($placeholder,$name, $value, $required, $data1, $data2, $table, $filter,$style, $dbConn){

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
			//Ordenamiento
			$extrafilter = $datos[0].' ASC ';

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){
				/******************************************/
				//generacion del input
				$input = '
				<div class="field" id="div_'.$EXname.'">
					<select name="'.$name.'" id="'.$EXname.'" class="form-control" '.$requerido.' style="'.$style.'">';

						//Recorro
						$selectedx = 'selected="selected"';
						foreach ( $arrSelect as $select ) {
							if($value==$select['idData']){
								$selectedx = '';
							}
						}

						$input .= '<option value="" '.$selectedx.'>Seleccione '.$placeholder.'</option>';

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
							$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
						}
						$input .= '
					</select>
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
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->select_filter('Meses del año','idMeses', 1, 'idMes', 'Nombre', 'tabla_meses', '', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $style         Permite escribir directamente un estilo css
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function select_filter($placeholder,$name, $value, $required, $data1, $data2, $table, $filter,$style, $dbConn){

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

			//Valido dispositivo movil
			if(validaDispositivoMovil()){
				$input = $this->select($placeholder,$name, $value, $required, $data1, $data2, $table, $filter,$style, $dbConn);
			}else{
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
				//Ordenamiento
				$extrafilter = $datos[0].' ASC ';

				/******************************************/
				//consulto
				$arrSelect = array();
				$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

				/******************************************/
				//si hay resultados
				if($arrSelect!=false){
					/******************************************/
					//se llama por obligacion libreria javascript desde aqui, porque en el head da problemas
					$input = '<script type="text/javascript" src="'.DB_SITE_REPO.'/LIBS_js/chosen/chosen.jquery.min.js"></script>';

					/******************************************/
					//generacion del input
					$input.= '
					<div class="field" id="div_'.$EXname.'">
						<select name="'.$name.'" id="'.$EXname.'" '.$requerido.' style="'.$style.'" data-placeholder="Seleccione una Opción" class="form-control chosen-select chosendiv_'.$name.'" tabindex="2">';

							//Recorro
							$selectedx = 'selected="selected"';
							foreach ( $arrSelect as $select ) {
								if($value==$select['idData']){
									$selectedx = '';
								}
							}

							$input .= '<option value="" '.$selectedx.'>Seleccione '.$placeholder.'</option>';

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
								$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
							}
							$input .= '
						</select>
					</div>';

					/******************************************/
					//ejecucion script
					$input .= '
					<script type="text/javascript">
						$.fn.oldChosen = $.fn.chosen;
						$.fn.chosen = function(options) {
							var selectcz_'.$EXname.' = $(".chosendiv_'.$EXname.'"), is_creating_chosen_'.$EXname.' = !!options;

							if (is_creating_chosen_'.$EXname.' && selectcz_'.$EXname.'.css(\'position\') === \'absolute\') {
								selectcz_'.$EXname.'.removeAttr(\'style\');
							}

							var ret_'.$EXname.' = selectcz_'.$EXname.'.oldChosen(options);

							if (is_creating_chosen_'.$EXname.') {
								selectcz_'.$EXname.'.attr(\'style\',\'display:visible; position:absolute; clip:rect(0,0,0,0)\');
								selectcz_'.$EXname.'.attr(\'tabindex\', -1);
							}
							return ret_'.$EXname.';
						}
						$(\'selectcz_'.$EXname.'\').chosen({allow_single_deselect: true});
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
	* 	$Form->select('Meses del año','idMeses', 1, 'idMes', 'Nombre', 'tabla_meses', '', '', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $style         Permite escribir directamente un estilo css
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function select_filtrar($placeholder,$name,$value, $required, $data1, $data2, $table, $filter, $dbConn, $divContent = ''){

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
			$EXname  = str_replace('[]', '', $name).'_'.rand(1, 999);
			$EXname2 = str_replace('[]', '', $name);

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
			//Ordenamiento
			$extrafilter = $datos[0].' ASC ';

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){
				/******************************************/
				//generacion del input
				$input = '
				<div class="field" id="div_'.$EXname.'">
					<select name="'.$name.'" id="'.$EXname.' uniqueID" class="form-control select2_'.$EXname.' select2_'.$EXname2.'" '.$requerido.'>';

						//Recorro
						$selectedx = 'selected="selected"';
						foreach ( $arrSelect as $select ) {
							if($value==$select['idData']){
								$selectedx = '';
							}
						}

						$input .= '<option value="" '.$selectedx.'>Seleccione '.$placeholder.'</option>';

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
							$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
						}
						$input .= '
					</select>
				</div>';

				//genracion del filtro
				$input .= '
				<script>
					$(document).ready(function() {
						$(".select2_'.$EXname.'").select2(
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
					$input .='<style>#div_'.$EXname.' .select2-container .select2-selection--single {background:url('.DB_SITE_REPO.'/LIB_assets/img/required.png) no-repeat 5px center !important;background-color: #fff !important;}</style>';
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
	* agregando un comando javascript onchange
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->select_change('Meses del año','idMeses', 1, 'idMes', 'Nombre', 'tabla_meses', '', '', 'cambia_mes', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1         Identificador de la base de datos
	* String   $data2         Texto a mostrar en la opción del input
	* String   $table         Tabla desde donde tomar los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* String   $style         Permite escribir directamente un estilo css
	* String   $OnChange      Comando javascript a llamar cuando se seleccione algo
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function select_change($placeholder,$name, $required, $data1, $data2, $table, $filter,$style,$OnChange,$dbConn){

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
			//Ordenamiento
			$extrafilter = $datos[0].' ASC ';

			/******************************************/
			//consulto
			$arrSelect = array();
			$arrSelect = db_select_array (false, $data1.' AS idData '.$data_required, $table, '', $filtro, $extrafilter, $dbConn, 'form_select', basename($_SERVER["REQUEST_URI"], ".php"), 'arrSelect');

			/******************************************/
			//si hay resultados
			if($arrSelect!=false){
				/******************************************/
				//generacion del input
				$input = '
				<div class="field" id="div_'.$EXname.'">
					<select name="'.$name.'" id="'.$EXname.'" class="form-control" '.$requerido.' style="'.$style.'" onchange="'.$OnChange.' (this)">
						<option value="" selected>Seleccione '.$placeholder.'</option>';

						foreach ( $arrSelect as $select ) {
							if(count($datos)==1){
								$data_writing = $select[$datos[0]].' ';
							}else{
								$data_writing = '';
								foreach($datos as $dato){
									$data_writing .= $select[$dato].' ';
								}
							}
							$input .= '<option value="'.$select['idData'].'" >'.TituloMenu(DeSanitizar($data_writing)).'</option>';
						}
						$input .= '
					</select>
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
	* Crea un input tipo select
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* que tambien obtiene datos desde otras tablas
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->select_group('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder   Nombre o texto a mostrar en el navegador
	* String   $name          Nombre del identificador del Input
	* int      $value         Valor por defecto, debe ser un numero entero
	* int      $required      Si dato es obligatorio (1=no, 2=si)
	* String   $data1a         Identificador de la base de datos
	* String   $data2a         Texto a mostrar en la opción del input
	* String   $table1        Tabla desde donde tomar los datos
	* String   $data1b         Identificador de la base de datos
	* String   $data2b         Texto a mostrar en la opción del input
	* String   $table2        Tabla a fucionar para tener los datos
	* String   $filter        Filtro de la seleccion de la base de datos
	* Object   $dbConn        Puntero a la base de datos
	* @return  String
	************************************************************************/
	public function select_group($placeholder,$name, $value, $required, $data1a, $data2a, $table1,
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
				<div class="field" id="div_'.$name.'">
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
						//recorro
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
	* 	$Form->radio_lateral('Opciones','opciones', '', 1, 'ID', 'Nombre', 'tabla_opciones', '', $dbConn );
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
	public function radio_lateral($placeholder,$name, $value, $required, $color, $data1, $data2, $table, $filter, $dbConn){

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
	* Crea un input tipo select dependiente
	*
	*===========================     Detalles    ===========================
	* Permite crear un input tipo select en base a datos de la base de datos,
	* dependiente uno de otro
	*===========================    Modo de uso  ===========================
	*
	* 	//se imprime input
	* 	$Form->select_depend1('Año','idMeses', 1, 1, 'idAno', 'Nombre', 'tabla_anos', '', 'Nombre ASC',
	*                         'Meses del año','idMeses', 1, 1, 'idMes', 'Nombre', 'tabla_meses', '', 'Nombre ASC',
	*                         $dbConn, 'form1' );
	*
	*===========================    Parametros   ===========================
	* String   $placeholder1   Nombre o texto a mostrar en el navegador
	* String   $name1          Nombre del identificador del Input
	* int      $value1         Valor por defecto, debe ser un numero entero
	* int      $required1      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA1         Identificador de la base de datos
	* String   $dataB1         Texto a mostrar en la opción del input
	* String   $table1         Tabla desde donde tomar los datos
	* String   $filter1        Filtro de la seleccion de la base de datos
	* String   $extracomand1   Ordenamiento de los datos, si no hay nada ordena automatico
	* String   $placeholder2   Nombre o texto a mostrar en el navegador
	* String   $name2          Nombre del identificador del Input
	* int      $value2         Valor por defecto, debe ser un numero entero
	* int      $required2      Si dato es obligatorio (1=no, 2=si)
	* String   $dataA2         Identificador de la base de datos
	* String   $dataB2         Texto a mostrar en la opción del input
	* String   $table2         Tabla desde donde tomar los datos
	* String   $filter2        Filtro de la seleccion de la base de datos
	* String   $extracomand2   Ordenamiento de los datos, si no hay nada ordena automatico
	* Object   $dbConn         Puntero a la base de datos
	* String   $form_name      Nombre del formulario actual
	* @return  String
	************************************************************************/
	public function select_depend1($placeholder_1, $name_1,  $value_1,  $required_1,  $dataA_1,  $dataB_1,  $table_1, $filter_1, $extracomand1,
								   $placeholder_2, $name_2,  $value_2,  $required_2,  $dataA_2,  $dataB_2,  $table_2, $filter_2, $extracomand2,
								   $dbConn, $form_name){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido = array(1, 2);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($required_1, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required1 ('.$required_1.') entregada en '.$placeholder_1.' no esta dentro de las opciones');
			$errorn++;
		}
		if (!in_array($required_2, $requerido)) {
			alert_post_data(4,1,1,0, 'La configuracion $required2 ('.$required_2.') entregada en '.$placeholder_2.' no esta dentro de las opciones');
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



}
?>
