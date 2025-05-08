<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1005-002).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                    Se llama a la clase de la que se hereda                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Inputs.php';
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
class Inputs extends Basic_Inputs{
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
	* 	$Form->select_bodega('Empresas','empresas', 1, 1, 'idEmpresa', 'Nombre,Tipo', 'tabla_empresas', 'tabla_tipo','', $dbConn );
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
	public function select_bodega($placeholder,$name, $value, $required, $data1, $data2, $table1, $table2, $filter, $dbConn){

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
			//Filtro para el where
			$filtro = '';
			if ($filter!='0'){$filtro .="WHERE ".$filter;	}

			//se trae un listado con todas las categorias
			$arrSelect = array();
			$query = "SELECT
			".$table1.".".$data1." AS idData,
			".$table1.".".$data2."
			FROM `".$table1."`
			INNER JOIN ".$table2." ON ".$table2.".".$data1." = ".$table1.".".$data1."
			".$filtro."
			GROUP BY ".$table1.".".$data1."
			ORDER BY ".$table1.".".$data2." ASC";
			//Consulta
			$resultado = mysqli_query ($dbConn, $query);
			//Si ejecuto correctamente la consulta
			if($resultado){
				while ( $row = mysqli_fetch_assoc ($resultado)) {
					array_push( $arrSelect,$row );
				}
				mysqli_free_result($resultado);

				/******************************************/
				//generacion del input
				$input = '<div class="field" id="div_'.$name.'">
							<select name="'.$name.'" id="'.$name.'" class="form-control" '.$requerido.' >
							<option value="" selected>Seleccione '.$placeholder.'</option>';

							foreach ( $arrSelect as $select ) {
								$selected = '';
								if($value==$select['idData']){
									$selected = 'selected="selected"';
								}
								//imprimo
								$input .= '<option value="'.$select['idData'].'" '.$selected.' >'.DeSanitizar($select[$data2]).'</option>';
							}
				$input .= '</select>
						</div>';

				/******************************************/
				//Imprimir dato
				echo $input;

			//si da error, guardar en el log de errores una copia
			}else{
				//Genero numero aleatorio
				$vardata = genera_password(8,'alfanumerico');

				//Guardo el error en una variable temporal
				
				
				

				//Devuelvo mensaje
				alert_post_data(4,1,1,0, 'Error en la consulta en <strong>'.$placeholder.'</strong>, consulte con el administrador');
			}
		}
	}
}


?>
