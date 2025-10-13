<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1002-004).');
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico lineal (Seleccion Normal)
*===========================    Modo de uso  ===========================
*
* 	//generar grafico
* 	$Graphics_xData = 'var xData = [
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016]
*				];';
*	$Graphics_yData = 'var yData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17],
*				  [12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19],
*				  [14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21],
*				  [16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23],
*				  [18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25],
*				  [20, 25, 23, 27, 20, 25, 23, 27, 20, 25, 23, 27, 20, 25, 23, 27],
*				  [22, 27, 25, 29, 22, 27, 25, 29, 22, 27, 25, 29, 22, 27, 25, 29],
*				];';
*	$Graphics_names = "var names = ['Normal', 'Solo linea', 'Solo marcador', 'Linea+marcador', 'Comentario simple', 'dashdot', 'dot'];";
*	$Graphics_types = "var types = ['', 'lines', 'markers', 'lines+markers', '', '', ''];";
*	$Graphics_texts = "var texts = [
*				[],
*				[],
*				[],
*				[],
*				['1° Linea de prueba A<br>2° Linea de prueba A',
*				  '1° Linea de prueba B<br>2° Linea de prueba B',
*				  '1° Linea de prueba C<br>2° Linea de prueba C',
*				  '1° Linea de prueba D<br>2° Linea de prueba D',
*				  '1° Linea de prueba E<br>2° Linea de prueba E',
*				  '1° Linea de prueba F<br>2° Linea de prueba F',
*				  '1° Linea de prueba G<br>2° Linea de prueba G',
*				  '1° Linea de prueba H<br>2° Linea de prueba H',
*				  '1° Linea de prueba I<br>2° Linea de prueba I',
*				  '1° Linea de prueba J<br>2° Linea de prueba J',
*				  '1° Linea de prueba K<br>2° Linea de prueba K',
*				  '1° Linea de prueba L<br>2° Linea de prueba L',
*				  '1° Linea de prueba M<br>2° Linea de prueba M',
*				  '1° Linea de prueba N<br>2° Linea de prueba N',
*				  '1° Linea de prueba O<br>2° Linea de prueba O',
*				  '1° Linea de prueba P<br>2° Linea de prueba P'],
*				[],
*				[]
*				];";
*	$Graphics_lineColors = "var lineColors = ['#FF0000', '#1E90FF', '#90EE90','#800080','#4D4D4D','#FFA500','#90EE90'];";
*	$Graphics_lineDash = "var lineDash = ['', '', '','','','dashdot','dot'];";
*	$Graphics_lineWidth = "var lineWidth = ['', '', '','','','4','4'];";
*
*	GraphLinear_1('graphLinear_1', 'Seleccion Normal', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $eje_x_titulo   Titulo del eje x del grafico
* String   $eje_y_titulo   Titulo del eje y del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* String   $names          Nombre de los puntos del grafico
* String   $types          Tipo de puntos
* String   $texts          Textos de los puntos del grafico
* String   $lineColors     Colores de las lineas
* String   $lineDash       Tipos de lineas
* String   $lineWidth      Ancho de las lineas
* int      $legendOptions  Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphLinear_1($idDiv,
						$titulo, $eje_x_titulo, $eje_y_titulo,
						$xData, $yData, $names, $types, $texts, $lineColors, $lineDash, $lineWidth,
						$legendOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo) OR $eje_y_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData) OR $xData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($names) OR $names==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	if(!isset($types) OR $types==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el tipo de punto.');}
	if(!isset($texts) OR $texts==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el texto de descripcion de cada punto.');}
	if(!isset($lineColors) OR $lineColors==''){         return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los colores de las lineas.');}
	if(!isset($lineDash) OR $lineDash==''){             return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el tipo de linea.');}
	if(!isset($lineWidth) OR $lineWidth==''){           return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el ancho de la linea.');}
	//if(!isset($legendOptions) OR $legendOptions==''){   return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Opciones del legend
	switch ($legendOptions) {
		case 1:  $lopts = 'height: 600,legend: {"orientation": "h",x: 0,  y: -1, bgcolor: "#E2E2E2", bordercolor: "#FFFFFF", borderwidth: 2}';break; //Legend abajo
		case 2:  $lopts = 'legend: {x: 0,y: 1.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado izquierdo
		case 3:  $lopts = 'legend: {x: 0,y: 2.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado derecho
		default: $lopts = '';                                                                                                                        //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $xData;
		$graph .= $yData;
		$graph .= $names;
		$graph .= $types;
		$graph .= $texts;
		$graph .= $lineColors;
		$graph .= $lineDash;
		$graph .= $lineWidth;
		$graph .='
		//se arman datos
		var dataPlotly = [];
		for ( var i = 0 ; i < xData.length ; i++ ) {
			var result = {
				x: xData[i],
				y: yData[i],
				type: \'scatter\',
				name: names[i],
				mode: types[i],
				text: texts[i],
				line: {
					color: lineColors[i],
					dash: lineDash[i],
					width: lineWidth[i]
				}
			};
			dataPlotly.push(result);
		}
		//vista de los label
		var labelview = true;
		if(xData[0].length > 30){
			labelview = false;
		}
		/*****************************************************************/
		var layout = {';
			if(isset($titulo)&&$titulo!=''){             $graph .= 'title:\''.$titulo.'\',';}
			if(isset($eje_x_titulo)&&$eje_x_titulo!=''){ $graph .= 'xaxis: {title: \''.$eje_x_titulo.'\', showticklabels: labelview},';}
			if(isset($eje_y_titulo)&&$eje_y_titulo!=''){ $graph .= 'yaxis: {title: \''.$eje_y_titulo.'\'},';}
			$graph .= 'showlegend: true,';
			$graph .= $lopts;
		$graph .= ' };

		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico lineal (Seleccion con Rango)
*===========================    Modo de uso  ===========================
*
* 	//generar grafico
* 	$Graphics_xData = 'var xData = [
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016]
*				];';
*	$Graphics_yData = 'var yData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17],
*				  [12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19],
*				  [14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21],
*				  [16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23],
*				  [18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25],
*				  [20, 25, 23, 27, 20, 25, 23, 27, 20, 25, 23, 27, 20, 25, 23, 27],
*				  [22, 27, 25, 29, 22, 27, 25, 29, 22, 27, 25, 29, 22, 27, 25, 29],
*				];';
*	$Graphics_names = "var names = ['Normal', 'Solo linea', 'Solo marcador', 'Linea+marcador', 'Comentario simple', 'dashdot', 'dot'];";
*	$Graphics_types = "var types = ['', 'lines', 'markers', 'lines+markers', '', '', ''];";
*	$Graphics_texts = "var texts = [
*				[],
*				[],
*				[],
*				[],
*				['1° Linea de prueba A<br>2° Linea de prueba A',
*				  '1° Linea de prueba B<br>2° Linea de prueba B',
*				  '1° Linea de prueba C<br>2° Linea de prueba C',
*				  '1° Linea de prueba D<br>2° Linea de prueba D',
*				  '1° Linea de prueba E<br>2° Linea de prueba E',
*				  '1° Linea de prueba F<br>2° Linea de prueba F',
*				  '1° Linea de prueba G<br>2° Linea de prueba G',
*				  '1° Linea de prueba H<br>2° Linea de prueba H',
*				  '1° Linea de prueba I<br>2° Linea de prueba I',
*				  '1° Linea de prueba J<br>2° Linea de prueba J',
*				  '1° Linea de prueba K<br>2° Linea de prueba K',
*				  '1° Linea de prueba L<br>2° Linea de prueba L',
*				  '1° Linea de prueba M<br>2° Linea de prueba M',
*				  '1° Linea de prueba N<br>2° Linea de prueba N',
*				  '1° Linea de prueba O<br>2° Linea de prueba O',
*				  '1° Linea de prueba P<br>2° Linea de prueba P'],
*				[],
*				[]
*				];";
*	$Graphics_lineColors = "var lineColors = ['#FF0000', '#1E90FF', '#90EE90','#800080','#4D4D4D','#FFA500','#90EE90'];";
*	$Graphics_lineDash = "var lineDash = ['', '', '','','','dashdot','dot'];";
*	$Graphics_lineWidth = "var lineWidth = ['', '', '','','','4','4'];";
*
*	GraphLinear_2('graphLinear_2', 'Seleccion con Rango', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $eje_x_titulo   Titulo del eje x del grafico
* String   $eje_y_titulo   Titulo del eje y del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* String   $names          Nombre de los puntos del grafico
* String   $types          Tipo de puntos
* String   $texts          Textos de los puntos del grafico
* String   $lineColors     Colores de las lineas
* String   $lineDash       Tipos de lineas
* String   $lineWidth      Ancho de las lineas
* int      $legendOptions  Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphLinear_2($idDiv,
						$titulo, $eje_x_titulo, $eje_y_titulo,
						$xData, $yData, $names, $types, $texts, $lineColors, $lineDash, $lineWidth,
						$legendOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo) OR $eje_y_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData) OR $xData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($names) OR $names==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	if(!isset($types) OR $types==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el tipo de punto.');}
	if(!isset($texts) OR $texts==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el texto de descripcion de cada punto.');}
	if(!isset($lineColors) OR $lineColors==''){         return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los colores de las lineas.');}
	if(!isset($lineDash) OR $lineDash==''){             return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el tipo de linea.');}
	if(!isset($lineWidth) OR $lineWidth==''){           return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el ancho de la linea.');}
	//if(!isset($legendOptions) OR $legendOptions==''){   return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Opciones del legend
	switch ($legendOptions) {
		case 1:  $lopts = 'height: 600,legend: {"orientation": "h",x: 0,  y: -1, bgcolor: "#E2E2E2", bordercolor: "#FFFFFF", borderwidth: 2}';break; //Legend abajo
		case 2:  $lopts = 'legend: {x: 0,y: 1.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado izquierdo
		case 3:  $lopts = 'legend: {x: 0,y: 2.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado derecho
		default: $lopts = '';                                                                                                                        //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $xData;
		$graph .= $yData;
		$graph .= $names;
		$graph .= $types;
		$graph .= $texts;
		$graph .= $lineColors;
		$graph .= $lineDash;
		$graph .= $lineWidth;
		$graph .='
		//se arman datos
		var dataPlotly = [];
		for ( var i = 0 ; i < xData.length ; i++ ) {
			var result = {
				x: xData[i],
				y: yData[i],
				type: \'scatter\',
				name: names[i],
				mode: types[i],
				text: texts[i],
				line: {
					color: lineColors[i],
					dash: lineDash[i],
					width: lineWidth[i]
				}
			};
			dataPlotly.push(result);
		}
		/*****************************************************************/
		var layout = {
			title:\''.$titulo.'\',
			xaxis: {title: \''.$eje_x_titulo.'\', autorange: true,rangeslider: {range: [xData[0][0], xData[0][xData[0].length]]},type: \'linear\'},
			yaxis: {title: \''.$eje_y_titulo.'\'},
			showlegend: true,
			'.$lopts.'
		};

		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico de doble eje
*===========================    Modo de uso  ===========================
*
*
*===========================    Parametros   ===========================
* String   $idDiv            Identificador del div
* String   $titulo           Titulo del grafico
* String   $eje_x_titulo     Titulo del eje x del grafico
* String   $eje_y_titulo_1   Titulo del eje y del grafico
* String   $eje_y_titulo_2   Titulo del eje y del grafico
* String   $xData_1          Data x del grafico
* String   $yData_1          Data y del grafico
* String   $name_1           Nombre de los puntos del grafico
* String   $xData_2          Data x del grafico
* String   $yData_2          Data y del grafico
* String   $name_2           Nombre de los puntos del grafico
* int      $legendOptions    Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphLinear_3($idDiv,
						$titulo, $eje_x_titulo, $eje_y_titulo_1, $eje_y_titulo_2,
						$xData_1, $yData_1, $name_1,
						$xData_2, $yData_2, $name_2,
						$legendOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                     return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){       return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo_1) OR $eje_y_titulo_1==''){   return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($eje_y_titulo_2) OR $eje_y_titulo_2==''){   return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData_1) OR $xData_1==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData_1) OR $yData_1==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($name_1) OR $name_1==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	if(!isset($xData_2) OR $xData_2==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData_2) OR $yData_2==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($name_2) OR $name_2==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	//if(!isset($legendOptions) OR $legendOptions==''){     return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Opciones del legend
	switch ($legendOptions) {
		case 1: $lopts = 'height: 600,legend: {"orientation": "h",x: 0,  y: -1, bgcolor: "#E2E2E2", bordercolor: "#FFFFFF", borderwidth: 2}';break; //Legend abajo
		case 2: $lopts = 'legend: {x: 0,y: 1.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado izquierdo
		case 3: $lopts = 'legend: {x: 0,y: 2.0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;               //Legend dentro al lado derecho
		default:$lopts = '';                                                                                                                        //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>
		//guardo las fechas
		var xData_1 = ['.$xData_1.'];
		var xData_2 = ['.$xData_2.'];

		var trace1 = {
			x: xData_1,
			y: ['.$yData_1.'],
			name: '.$name_1.',
			type: \'scatter\'
		};

		var trace2 = {
			x: xData_2,
			y: ['.$yData_2.'],
			name: '.$name_2.',
			yaxis: \'y2\',
			type: \'scatter\'
		};

		var dataPlotly = [trace1, trace2];

		//vista de los label
		var labelview = true;
		if(xData_1.length > 30){
			labelview = false;
		}
		if(xData_2.length > 30){
			labelview = false;
		}

		var layout = {';
			if(isset($titulo)&&$titulo!=''){                  $graph .= 'title:\''.$titulo.'\',';}
			if(isset($eje_x_titulo)&&$eje_x_titulo!=''){      $graph .= 'xaxis: {title: \''.$eje_x_titulo.'\', showticklabels: labelview},';}
			if(isset($eje_y_titulo_1)&&$eje_y_titulo_1!=''){  $graph .= 'yaxis: {title: \''.$eje_y_titulo_1.'\'},';}
			if(isset($eje_y_titulo_2)&&$eje_y_titulo_2!=''){  $graph .= 'yaxis2: {title: \''.$eje_y_titulo_2.'\', titlefont: {color: \'rgb(148, 103, 189)\'}, tickfont: {color: \'rgb(148, 103, 189)\'}, overlaying: \'y\', side: \'right\' },';}
			$graph .= 'showlegend: true,';
			$graph .= $lopts;
		$graph .= ' };

		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico de barras (distintas versiones)
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
* 	$Graphics_xData = 'var xData = [
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				];';
*	$Graphics_yData = 'var yData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17],
*				];';
*	$Graphics_names       = "var names = ['Normal'];";
*	$Graphics_info        = "var grf_info = [''];";
*	$Graphics_markerColor = "var markerColor = [''];";
*	$Graphics_markerLine  = "var markerLine = [''];";
*
*	GraphBarr_1('graphBarra_1', 'Basico', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 0);
*
*	//se crea grafico
*	$Graphics_xData = 'var xData = [
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2013, 2014, 2015, 2016],
*				];';
*	$Graphics_yData = 'var yData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17],
*				  [12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19, 12, 17, 15, 19],
*				  [14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21, 14, 19, 17, 21],
*				  [16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23, 16, 21, 19, 23],
*				  [18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25, 18, 23, 21, 25],
*				];';
*	$Graphics_names       = "var names = ['data 1', 'data 2', 'data 3', 'data 4', 'data 5'];";
*	$Graphics_info        = "var grf_info = ['','','','',''];";
*	$Graphics_markerColor = "var markerColor = ['','','','',''];";
*	$Graphics_markerLine  = "var markerLine = ['','','','',''];";
*
*	GraphBarr_1('graphBarra_2', 'Agrupado', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 1);
*	GraphBarr_1('graphBarra_3', 'Apilado', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,2, 2); 
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $eje_x_titulo   Titulo del eje x del grafico
* String   $eje_y_titulo   Titulo del eje y del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* String   $Name           Nombre de los puntos del grafico
* String   $hoverinfo      Informacion de cada barra
* String   $markerColor    Color de cada barra
* String   $markerLine     Borde de cada barra
* int      $type           Tipos de barra
* int      $legendOptions  Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphBarr_1($idDiv,
					$titulo, $eje_x_titulo, $eje_y_titulo,
					$xData, $yData, $Name, $hoverinfo, $markerColor, $markerLine,
					$type, $legendOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo) OR $eje_y_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData) OR $xData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($Name) OR $Name==''){                     return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	if(!isset($hoverinfo) OR $hoverinfo==''){           return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con la Informacion de cada barra.');}
	if(!isset($markerColor) OR $markerColor==''){       return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Color de cada barra.');}
	if(!isset($markerLine) OR $markerLine==''){         return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Borde de cada barra.');}
	//if(!isset($type) OR $type==''){                     return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Tipos de barra.');}
	//if(!isset($legendOptions) OR $legendOptions==''){   return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Tipo de grafico
	switch ($type) {
		case 1:  $typeopts = 'group'; break;
		case 2:  $typeopts = 'stack'; break;
		default: $typeopts = '';
	}

	//Opciones del legend
	switch ($legendOptions) {
		case 1: $lopts = 'legend: {"orientation": "h",x: 0,  y: -1, bgcolor: "#E2E2E2", bordercolor: "#FFFFFF", borderwidth: 2}';break; //Legend abajo
		case 2: $lopts = 'legend: {x: 0,y: 1, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado izquierdo superior
		case 3: $lopts = 'legend: {x: 1,y: 1, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado derecho superior
		case 4: $lopts = 'legend: {x: 0,y: 0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado izquierdo inferior
		case 5: $lopts = 'legend: {x: 1,y: 0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado derecho inferior
		default:$lopts = '';                                                                                                            //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $xData;
		$graph .= $yData;
		$graph .= $Name;
		$graph .= $hoverinfo;
		$graph .= $markerColor;
		$graph .= $markerLine;

		$graph .='
		//se arman datos
		var dataPlotly = [];
		for ( var i = 0 ; i < xData.length ; i++ ) {
			var textin = "";
			if(grf_info[i]!=""){
				textin = grf_info[i];
			}else{
				textin = yData[i].map(String);
			}

			var result = {
				x: xData[i],
				y: yData[i],
				type: \'bar\',
				name: names[i],
				text: textin,
				textposition: \'auto\',
				hoverinfo: \'grf_info[i]\',
				marker: {
					color: \'markerColor[i]\',
					line: {
						color: \'markerLine[i]\',
						width: 1.5
					}
				}
			};
			dataPlotly.push(result);
		}
		//vista de los label
		var labelview = true;
		if(xData[0].length > 30){
			labelview = false;
		}
		/*****************************************************************/
		var layout = {
			title: \''.$titulo.'\',
			barmode: \''.$typeopts.'\',';
			if(isset($eje_x_titulo)&&$eje_x_titulo!=''){ $graph .= 'xaxis: {title: \''.$eje_x_titulo.'\',titlefont: {size: 16,color: \'rgb(107, 107, 107)\'},tickfont: {size: 14,color: \'rgb(107, 107, 107)\'}},';}
			if(isset($eje_y_titulo)&&$eje_y_titulo!=''){ $graph .= 'yaxis: {title: \''.$eje_y_titulo.'\',titlefont: {size: 16,color: \'rgb(107, 107, 107)\'},tickfont: {size: 14,color: \'rgb(107, 107, 107)\'}},';}
			$graph .= $lopts;
		 $graph .= '
		};
		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico tipo pie
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
* 	$Graphics_values = 'var allValues = [2, 3, 4, 4];';
* 	$Graphics_labels = 'var allLabels = ["Wages", "Operating expenses", "Cost of sales", "Insurance"];';
* 	$Graphics_width  = 600;
* 	$Graphics_height = 400;
*
* 	GraphPie_1('graphPie_1', 'Normal', $Graphics_values,$Graphics_labels,$Graphics_width,$Graphics_height, 1,0);
* 	GraphPie_1('graphPie_2', 'Valores fuera', $Graphics_values,$Graphics_labels,$Graphics_width,$Graphics_height, 2,1);
* 	GraphPie_1('graphPie_3', 'Donut Chart', $Graphics_values,$Graphics_labels,$Graphics_width,$Graphics_height, 3,0);
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $values         Valores
* String   $labels         Textos de cada zona
* String   $width          Ancho del grafico
* String   $height         Alto del grafico
* int      $dataOptions    Opciones de visualizacion
* int      $legendOptions  Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphPie_1($idDiv,
					$titulo,
					$values,$labels,$width,$height,
					$dataOptions, $layoutOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($values) OR $values==''){                 return alert_post_data(4,1,1,0,'No ha ingresado los Valores.');}
	if(!isset($labels) OR $labels==''){                 return alert_post_data(4,1,1,0,'No ha ingresado los Textos de cada zona.');}
	if(!isset($width) OR $width==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el Ancho del grafico.');}
	if(!isset($height) OR $height==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el Alto del grafico.');}
	//if(!isset($dataOptions) OR $dataOptions==''){       return alert_post_data(4,1,1,0,'No ha ingresado las Opciones de visualizacion.');}
	//if(!isset($layoutOptions) OR $layoutOptions==''){   return alert_post_data(4,1,1,0,'No ha ingresado las Opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Tipo de grafico
	switch ($dataOptions) {
		case 1: $dopts = 'textinfo: "label+percent", textposition: "inside", automargin: true';break;  //Normal
		case 2: $dopts = 'textinfo: "label+percent", textposition: "outside", automargin: true';break; //Valores fuera
		case 3: $dopts = 'hole: .4,';break;                                                            //Donut Chart
		default:$dopts = '';                                                                           //Sin Opciones
	}
	//Tipo de grafico
	switch ($layoutOptions) {
		case 1: $lopts = 'showlegend: false,';break; //Normal
		default:$lopts = '';                         //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $values;
		$graph .= $labels;
		$graph .='
		//se arman datos
		var dataPlotly = [{
			values: allValues,
			labels: allLabels,
			name: allLabels,
			type: \'pie\',
			automargin: true,';
			$graph .= $dopts;
			$graph .= '
		}];

		/*****************************************************************/
		var layout = {
			title: \''.$titulo.'\',
			width: \''.$width.'\',
			height: \''.$height.'\',
			margin: {"t": 45, "b": 0, "l": 0, "r": 0},';
			$graph .= $lopts;
		 $graph .= '
		};
		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico de barras lateral
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
*	$Graphics_xData = 'var xData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10, 15, 13, 17],
*				];';
*	$Graphics_yData = "var yData = [
*				  ['test 1', 'test 2', 'test 3', 'test 4', 'test 5', 'test 6', 'test 7', 'test 8', 'test 9', 'test 10', 'test 11'],
*				];";
*	$Graphics_names       = "var names = ['Normal'];";
*	$Graphics_info        = "var grf_info = [''];";
*	$Graphics_markerColor = "var markerColor = [''];";
*	$Graphics_markerLine  = "var markerLine = [''];";
*
*	GraphBarrLat_1('graphBarraLat_1', 'Basico', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 0);
*
* 	//se crea grafico
*	$Graphics_xData = 'var xData = [
*				  [10, 15, 13, 17, 10, 15, 13, 17, 10],
*				  [12, 17, 15, 19, 12, 17, 15, 19, 12],
*				];';
*	$Graphics_yData = 'var yData = [
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008],
*				  [2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008],
*				];';
*	$Graphics_names       = "var names = ['data 1', 'data 2'];";
*	$Graphics_info        = "var grf_info = ['',''];";
*	$Graphics_markerColor = "var markerColor = ['',''];";
*	$Graphics_markerLine  = "var markerLine = ['',''];";
*
*	GraphBarrLat_1('graphBarraLat_2', 'Agrupado', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,1, 1);
*	GraphBarrLat_1('graphBarraLat_3', 'Apilado', 'Eje-x Titulo', 'Eje-y Titulo', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_info, $Graphics_markerColor, $Graphics_markerLine,2, 3); 
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $eje_x_titulo   Titulo del eje x del grafico
* String   $eje_y_titulo   Titulo del eje y del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* String   $Name           Nombre de los puntos del grafico
* String   $hoverinfo      Informacion de cada barra
* String   $markerColor    Color de cada barra
* String   $markerLine     Borde de cada barra
* int      $type           Tipos de barra
* int      $legendOptions  Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphBarrLat_1($idDiv,
						$titulo, $eje_x_titulo, $eje_y_titulo,
						$xData, $yData, $Name, $hoverinfo, $markerColor, $markerLine,
						$type, $legendOptions){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo) OR $eje_y_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData) OR $xData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($Name) OR $Name==''){                     return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con los nombres de cada punto.');}
	if(!isset($hoverinfo) OR $hoverinfo==''){           return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con la Informacion de cada barra.');}
	if(!isset($markerColor) OR $markerColor==''){       return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Color de cada barra.');}
	if(!isset($markerLine) OR $markerLine==''){         return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Borde de cada barra.');}
	//if(!isset($type) OR $type==''){                     return alert_post_data(4,1,1,0,'No ha ingresado el arreglo con el Tipos de barra.');}
	//if(!isset($legendOptions) OR $legendOptions==''){   return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Tipo de grafico
	switch ($type) {
		case 1:  $typeopts = 'group'; break;
		case 2:  $typeopts = 'stack'; break;
		default: $typeopts = '';
	}

	//Opciones del legend
	switch ($legendOptions) {
		case 1: $lopts = 'legend: {"orientation": "h",x: 0,  y: -1, bgcolor: "#E2E2E2", bordercolor: "#FFFFFF", borderwidth: 2}';break; //Legend abajo
		case 2: $lopts = 'legend: {x: 0,y: 1, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado izquierdo superior
		case 3: $lopts = 'legend: {x: 1,y: 1, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado derecho superior
		case 4: $lopts = 'legend: {x: 0,y: 0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado izquierdo inferior
		case 5: $lopts = 'legend: {x: 1,y: 0, bgcolor: \'rgba(255, 255, 255, 0)\',bordercolor: \'rgba(255, 255, 255, 0)\'},';break;     //Legend dentro al lado derecho inferior
		case 6: $lopts = 'margin: {l: 300, r: 0, t: 100, b: 100 },height: 600,';break;                                                  //Legend dentro al lado derecho inferior
		default:$lopts = '';                                                                                                            //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $xData;
		$graph .= $yData;
		$graph .= $Name;
		$graph .= $hoverinfo;
		$graph .= $markerColor;
		$graph .= $markerLine;
		$graph .='
		//se arman datos
		var dataPlotly = [];
		for ( var i = 0 ; i < xData.length ; i++ ) {
			var result = {
				x: xData[i],
				y: yData[i],
				type: \'bar\',
				name: names[i],
				orientation: \'h\',
				text: xData[i].map(String),
				textposition: \'auto\',
				hoverinfo: \'grf_info[i]\',
				marker: {
					color: \'markerColor[i]\',
					line: {
						color: \'markerLine[i]\',
						width: 1.5
					}
				}
			};
			dataPlotly.push(result);
		}
		/*****************************************************************/
		var layout = {
			title: \''.$titulo.'\',
			barmode: \''.$typeopts.'\',';
			if(isset($eje_x_titulo)&&$eje_x_titulo!=''){ $graph .= 'xaxis: {title: \''.$eje_x_titulo.'\',titlefont: {size: 16,color: \'rgb(107, 107, 107)\'},tickfont: {size: 14,color: \'rgb(107, 107, 107)\'}},';}
			if(isset($eje_y_titulo)&&$eje_y_titulo!=''){ $graph .= 'yaxis: {title: \''.$eje_y_titulo.'\',titlefont: {size: 16,color: \'rgb(107, 107, 107)\'},tickfont: {size: 14,color: \'rgb(107, 107, 107)\'}},';}
			$graph .= $lopts;
		 $graph .= '
		};
		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico lineal (Seleccion Normal)
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
* 	$Graphics_xData = 'var xData = [225, 220, 100, 88, 78, 65, 56, 46, 43, 25, 13, 7];';
*	$Graphics_yData = "var yData = ['test 1', 'test 2', 'test 3', 'test 4', 'test 5', 'test 6', 'test 7', 'test 8', 'test 9', 'test 10', 'test 11'];";
*	$Graphics_width  = 1000;
*	$Graphics_height = 800;
*
*	GraphEmbudo_1('graphEmbudo_1', 'Normal', $Graphics_xData, $Graphics_yData, $Graphics_width, $Graphics_height, 0);
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* String   $width          Ancho del grafico
* String   $height         Alto del grafico
* int      $Options        Opciones del grafico
* @return  html
************************************************************************/
//Funcion
function GraphEmbudo_1($idDiv, $titulo, $xData, $yData,$width,$height, $Options){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){       return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($xData) OR $xData==''){       return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){       return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}
	if(!isset($width) OR $width==''){       return alert_post_data(4,1,1,0,'No ha ingresado el Ancho del grafico.');}
	if(!isset($height) OR $height==''){     return alert_post_data(4,1,1,0,'No ha ingresado el Alto del grafico.');}
	//if(!isset($Options) OR $Options==''){   return alert_post_data(4,1,1,0,'No ha ingresado las opciones del grafico.');}

	/**********************/
	//Si todo esta ok
	//Opciones del legend
	switch ($Options) {
		case 1: $lopts = 'margin: {l: 300, r: 0, t: 100, b: 100 },';break; //Debajo
		default:$lopts = '';                                               //Sin Opciones
	}

	/*************************************************/
	//imprime
	$graph  = '
	<div id="'.$idDiv.'"></div>
	<script>';
		$graph .= $xData;
		$graph .= $yData;
		$graph .='
		var dataPlotly = [
			{
				type: \'funnel\',
				y: yData,
				x: xData,
				textposition: "inside",
				textinfo: "value+percent initial",
				hoverinfo: "percent total+x",
				opacity: 0.65,
				marker: {
					color: ["59D4E8", "DDB6C6", "A696C8", "67EACA", "94D2E6", "59D4E8", "DDB6C6", "A696C8", "67EACA", "94D2E6", "59D4E8", "DDB6C6", "A696C8", "67EACA", "94D2E6"],
					line: {
						"width": [4, 2, 2, 3, 1, 1],
						color: ["3E4E88", "606470", "3E4E88", "606470", "3E4E88", "3E4E88", "606470", "3E4E88", "606470", "3E4E88", "3E4E88", "606470", "3E4E88", "606470", "3E4E88"]
					}
				},
				connector: {
					line: {
						color: "royalblue",
						dash: "dot",
						width: 3
					}
				}
			}
		];

		/*****************************************************************/
		var layout = {
			title: \''.$titulo.'\',
			width: \''.$width.'\',
			height: \''.$height.'\',';
			$graph .= $lopts;
		 $graph .= '
		};
		var config = {
			locale: \'es-ar\',
			displayModeBar: true,
			modeBarButtonsToRemove: [\'select2d\', \'lasso2d\', \'zoomIn2d\', \'zoomOut2d\'],
			displaylogo: false,
			responsive: true
		};

		Plotly.newPlot(\''.$idDiv.'\', dataPlotly, layout, config);
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico lineal (Seleccion Normal)
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $eje_x_titulo   Titulo del eje x del grafico
* String   $eje_y_titulo   Titulo del eje y del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* @return  html
************************************************************************/
//Funcion
function Chartist_Line_1($idDiv, $titulo, $eje_x_titulo, $eje_y_titulo, $xData, $yData){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){                 return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($eje_x_titulo) OR $eje_x_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje x.');}
	if(!isset($eje_y_titulo) OR $eje_y_titulo==''){     return alert_post_data(4,1,1,0,'No ha ingresado el titulo del eje y.');}
	if(!isset($xData) OR $xData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){                   return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}

	/**********************/
	//Si todo esta ok
	/*************************************************/
	//imprime
	$graph  = '
	<link rel="stylesheet" type="text/css" href="'.DB_SITE_REPO.'/LIBS_js/chartist/dist/chartist.min.css">
	<script type="text/javascript" src="'.DB_SITE_REPO.'/LIBS_js/chartist/dist/chartist.min.js"></script>
	<div id="'.$idDiv.'" style="width:100%;height:100%;"></div>
	<script>
		new Chartist.Line("#'.$idDiv.'", {
			labels: ['.$xData.'],
			series: [ ['.$yData.']]
		}, {
			low: 0,
			showArea: true
		});
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un grafico
*
*===========================     Detalles    ===========================
* Crea un grafico lineal (Seleccion Normal)
*===========================    Modo de uso  ===========================
*
* 	//se crea grafico
* 	$Graphics_xData = 'const xValues = ['01-01-2024', '02-01-2024', '03-01-2024', '04-01-2024', '05-01-2024'];';
*	$Graphics_yData = 'const yValues = [15, 25, 18, 22, 11];';
*
*	Chartjs_Line_1('Chartjs_Line_1','valores random',$Graphics_xData, $Graphics_yData);
*
*===========================    Parametros   ===========================
* String   $idDiv          Identificador del div
* String   $titulo         Titulo del grafico
* String   $xData          Data x del grafico
* String   $yData          Data y del grafico
* @return  html
************************************************************************/
//Funcion
function Chartjs_Line_1($idDiv, $titulo, $xData, $yData){

	/**********************/
	//Validaciones
	if(!isset($idDiv) OR $idDiv==''){    return alert_post_data(4,1,1,0,'No ha ingresado el identificador.');}
	if(!isset($titulo) OR $titulo==''){  return alert_post_data(4,1,1,0,'No ha ingresado el titulo.');}
	if(!isset($xData) OR $xData==''){    return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de xData.');}
	if(!isset($yData) OR $yData==''){    return alert_post_data(4,1,1,0,'No ha ingresado el arreglo de yData.');}

	/**********************/
	//Si todo esta ok
	/*************************************************/
	$graph  = '
	<canvas id="'.$idDiv.'" style="width:100%;max-width:600px"></canvas>
	<script>';
		$graph .=$xData;
		$graph .=$yData;
		$graph .= '
		new Chart("'.$idDiv.'", {
			type: "line",
			data: {
				labels: xValues,
				datasets: [{
					fill: false,
					lineTension: 0,
					backgroundColor: "rgba(0,0,255,1.0)",
					borderColor: "rgba(0,0,255,0.1)",
					data: yValues
				}]
			},
			options: {
				legend: {display: false},
				title: {
					display: true,
					text: "'.$titulo.'",
					fontSize: 16
				}
			}
		});
	</script>';

	/**********************/
	//devuelvo
	return $graph;

}

?>
