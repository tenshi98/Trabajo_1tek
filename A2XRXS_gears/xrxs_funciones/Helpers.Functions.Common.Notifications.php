<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-003).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	alert_post_data(1,0,3,0, 'dato' );
* 	alert_post_data(2,1,2,0, '<strong>Dato:</strong>explicacion' );
* 	alert_post_data(3,2,1,0, '<strong>Dato 1:</strong>explicacion 1 <br/><strong>Dato 2:</strong>explicacion 2' );
* 	alert_post_data(4,3,0,0, 'bla' );
*
*===========================    Parametros   ===========================
* int      $type            Tipo de mensaje (define el color de este)
* int      $icon            Icono a utilizar
* int      $iconAnimation   Animacion del icono utilizado
* String   $autoClose       Configuracion para el cierre automatico del div
* String   $Text            Texto del mensaje (permite HTML)
* @return  String
************************************************************************/
//Funcion
function alert_post_data($type, $icon, $iconAnimation, $autoClose, $Text){

	//Valido si los datos ingresados estan correctos
	if (validarNumero($type)&&validarNumero($icon)&&validarNumero($iconAnimation)&&validarNumero($autoClose)){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5,6);
		$requerido_2 = array(0,1,2,3);
		$requerido_3 = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20);
		$requerido_4 = array(0,1);
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
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($autoClose, $requerido_4)) {
			alert_post_data(4,1,1,0, 'La configuracion $autoClose entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de mensaje
			$options = ['success', 'info', 'warning', 'danger', 'primary', 'default'];
			$tipo    = $options[$type-1];

			//Selecciono el icono del mensaje
			$options  = [
							'',
							'faa-bounce animated',
							'faa-vertical animated',
							'faa-flash animated',
							'faa-wrench',
							'faa-ring',
							'faa-horizontal',
							'faa-horizontal faa-reverse',
							'faa-bounce faa-reverse',
							'faa-spin',
							'faa-spin faa-reverse',
							'faa-float',
							'faa-pulse',
							'faa-shake',
							'faa-tada',
							'faa-passing',
							'faa-passing faa-reverse',
							'faa-burst',
							'faa-falling',
							'faa-falling faa-reverse',
							'faa-rising',
						];
			$Animation = $options[$iconAnimation];

			//Selecciono el tipo de icono
			$options  = [
							'',
							'<div class="icon"><i class="fa fa-info-circle '.$Animation.'" aria-hidden="true"></i></div>',
							'<div class="icon"><i class="fa fa-exclamation '.$Animation.'" aria-hidden="true"></i></div>',
							'<div class="icon"><i class="fa fa-exclamation-triangle '.$Animation.'" aria-hidden="true"></i></div>'
						];
			$iconType = $options[$icon];

			//Selecciono el tipo de mensaje
			$options  = ['', 'alert-dismissible'];
			$closeDiv = $options[$autoClose];

			//Selecciono el tipo de mensaje
			$options = ['', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'];
			$closeBtn = $options[$autoClose];

			//generacion del mensaje
			if($icon!=0){
				$input  = '<div class="alert alert-'.$tipo.' '.$closeDiv.' alert-white rounded alert_box_correction" role="alert">';
					$input .= $closeBtn;
					$input .= $iconType;
					$input .= '<span id="alert_post_data">'.$Text.'</span>';
					$input .= '<div class="clearfix"></div>';
				$input .= '</div>';
			}else{
				$input  = '<div class="alert alert-'.$tipo.' '.$closeDiv.' alert-white rounded alert_box_correction" role="alert" style="padding-left: 15px;">';
					$input .= $closeBtn;
					$input .= $iconType;
					$input .= '<span id="alert_post_data">'.$Text.'</span>';
					$input .= '<div class="clearfix"></div>';
				$input .= '</div>';
			}

			//Imprimir dato
			echo $input;
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	info_post_data(1,'dato' );
* 	info_post_data(2,'<strong>Dato:</strong>explicacion' );
* 	info_post_data(3,'<strong>Dato 1:</strong>explicacion 1 <br/><strong>Dato 2:</strong>explicacion 2' );
* 	info_post_data(4,'bla' );
*
*===========================    Parametros   ===========================
* int      $type            Tipo de mensaje (define el color de este)
* String   $Text            Texto del mensaje (permite HTML)
* @return  String
************************************************************************/
//Funcion
function info_post_data($type, $Text){

	//Valido si los datos ingresados estan correctos
	if (validarNumero($type)){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5,6,7);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($type, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $type entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de mensaje
			$options = ['default', 'primary', 'success', 'info', 'warning', 'danger', 'link'];
			$tipo = $options[$type-1];

			//generacion del mensaje
			$input  = '<div class="bs-callout bs-callout-'.$tipo.'" >'.$Text.'<div class="clearfix"></div></div>';

			//Imprimir dato
			echo $input;
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	info_post_data(1,'dato' );
* 	info_post_data(2,'<strong>Dato:</strong>explicacion' );
* 	info_post_data(3,'<strong>Dato 1:</strong>explicacion 1 <br/><strong>Dato 2:</strong>explicacion 2' );
* 	info_post_data(4,'bla' );
*
*===========================    Parametros   ===========================
* int      $type            Tipo de mensaje (define el color de este)
* String   $Text            Texto del mensaje (permite HTML)
* @return  String
************************************************************************/
//Funcion
function sweetalert2(int $icon = 0, String $title = '', String $text = '', String $html = '', String $footer = '',
					String $imageUrl = '', int $imageHeight = 0, String $imageAlt = '',
					bool $showCloseButton = false, bool $showConfirmButton = true, int $position = 4, int $timer = 0){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$requerido = array(1,2,3,4,5);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($icon, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $icon entregada no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){
		//Selecciono el tipo de mensaje
		$options = ['success', 'error', 'warning', 'info', 'question'];
		$Icono = $options[$icon];

		$options = ['top', 'top-start', 'top-end', 'center', 'center-start', 'center-end', 'bottom', 'bottom-start', 'bottom-end'];
		$Posicion = $options[$position];

		//generacion del mensaje
		$input = 'Swal.fire({';
			if(isset($icon)&&$icon!=0){                $input.= 'icon: \''.$Icono.'\',';}
			if(isset($title)&&$title!=''){             $input.= 'title: \''.$title.'\',';}
			if(isset($text)&&$text!=''){               $input.= 'text: \''.$text.'\',';}
			if(isset($html)&&$html!=''){               $input.= 'html: \''.$html.'\'';}
			if(isset($footer)&&$footer!=''){           $input.= 'footer: \''.$footer.'\'';}
			if(isset($imageUrl)&&$imageUrl!=''){       $input.= 'imageUrl: \''.$imageUrl.'\'';}
			if(isset($imageHeight)&&$imageHeight!=0){  $input.= 'imageHeight: \''.$imageHeight.'\'';}
			if(isset($imageAlt)&&$imageAlt!=''){       $input.= 'imageAlt: \''.$imageAlt.'\'';}
			if(isset($position)&&$position!=0){        $input.= 'position: \''.$Posicion.'\'';}
			if(isset($timer)&&$timer!=0){              $input.= 'timer: \''.$timer.'\'';}
			//Botones
			$input.= 'showCloseButton: \''.$showCloseButton.'\'';
			$input.= 'showConfirmButton: \''.$showConfirmButton.'\'';
		$input.= '})';

		//Imprimir dato
		echo $input;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
*   info_popover_data('usuario', 'Preview 1', $dataC, 1);
* 	info_popover_data('usuario', 'Preview 2', $dataC, 2);
* 	info_popover_data('usuario', 'Preview 3', $dataC, 3);
* 	info_popover_data('usuario', 'Preview 4', $dataC, 4);
*
*===========================    Parametros   ===========================
* String   $IdElemento      ID del input
* String   $Titulo          Titulo del mensaje
* String   $Mensaje         Texto del mensaje
* int      $Ubicacion       Ubicacion a mostrar la burbuja
* @return  String
************************************************************************/
//Funcion
function info_popover_data($IdElemento, $Titulo, $Mensaje, $Ubicacion){

	//Valido si los datos ingresados estan correctos
	if (validarNumero($Ubicacion)){

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
			//Selecciono el tipo de mensaje
			$options = ['top', 'bottom', 'left', 'right'];
			$placement = $options[$Ubicacion-1];

			//generacion del mensaje
			$input  = '
			<script>
				$(document).ready(function(){
					//se crea elemento
					$("#'.$IdElemento.'").popover({html:true, title: "<strong>'.$Titulo.'</strong>", content: "'.$Mensaje.'", placement:"'.$placement.'" });
					//se condiciona visualizacion
					$("#'.$IdElemento.'").hover(function () {$("#'.$IdElemento.'").popover("show");},function () {$("#'.$IdElemento.'").popover("hide");});

				});
			</script>';

			//Imprimir dato
			echo $input;
		}
	}
}

?>
