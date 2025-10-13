<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-269).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_POST['idFacturacion']))    $idFacturacion      = $_POST['idFacturacion'];
	if (!empty($_POST['idSistema']))        $idSistema          = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))        $idUsuario          = $_POST['idUsuario'];
	if (!empty($_POST['fecha_auto']))       $fecha_auto         = $_POST['fecha_auto'];
	if (!empty($_POST['Creacion_fecha']))   $Creacion_fecha     = $_POST['Creacion_fecha'];
	if (!empty($_POST['Fecha_desde']))      $Fecha_desde        = $_POST['Fecha_desde'];
	if (!empty($_POST['Fecha_hasta']))      $Fecha_hasta        = $_POST['Fecha_hasta'];
	if (!empty($_POST['Observaciones']))    $Observaciones      = $_POST['Observaciones'];
	if (!empty($_POST['UF']))               $UF                 = $_POST['UF'];
	if (!empty($_POST['UTM']))              $UTM                = $_POST['UTM'];
	if (!empty($_POST['IMM']))              $IMM                = $_POST['IMM'];
	if (!empty($_POST['TopeImpAFP']))       $TopeImpAFP         = $_POST['TopeImpAFP'];
	if (!empty($_POST['TopeImpIPS']))       $TopeImpIPS         = $_POST['TopeImpIPS'];
	if (!empty($_POST['TopeSegCesantia']))  $TopeSegCesantia    = $_POST['TopeSegCesantia'];
	if (!empty($_POST['TopeAPVMensual']))   $TopeAPVMensual     = $_POST['TopeAPVMensual'];
	if (!empty($_POST['TopeDepConv']))      $TopeDepConv        = $_POST['TopeDepConv'];

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
			case 'idFacturacion':    if(empty($idFacturacion)){      $error['idFacturacion']     = 'error/No ha ingresado el id';}break;
			case 'idSistema':        if(empty($idSistema)){          $error['idSistema']         = 'error/No ha ingresado el numero de documento';}break;
			case 'idUsuario':        if(empty($idUsuario)){          $error['idUsuario']         = 'error/No ha seleccionado el usuario';}break;
			case 'fecha_auto':       if(empty($fecha_auto)){         $error['fecha_auto']        = 'error/No ha ingresado la fecha automatica';}break;
			case 'Creacion_fecha':   if(empty($Creacion_fecha)){     $error['Creacion_fecha']    = 'error/No ha ingresado la fecha de creación';}break;
			case 'Fecha_desde':      if(empty($Fecha_desde)){        $error['Fecha_desde']       = 'error/No ha ingresado la fecha desde';}break;
			case 'Fecha_hasta':      if(empty($Fecha_hasta)){        $error['Fecha_hasta']       = 'error/No ha ingresado la fecha hasta';}break;
			case 'Observaciones':    if(empty($Observaciones)){      $error['Observaciones']     = 'error/No ha ingresado la observacion';}break;
			case 'UF':               if(empty($UF)){                 $error['UF']                = 'error/No ha ingresado la UF';}break;
			case 'UTM':              if(empty($UTM)){                $error['UTM']               = 'error/No ha ingresado la UTM';}break;
			case 'IMM':              if(empty($IMM)){                $error['IMM']               = 'error/No ha ingresado el sueldo minimo';}break;
			case 'TopeImpAFP':       if(empty($TopeImpAFP)){         $error['TopeImpAFP']        = 'error/No ha ingresado el tope imponible de la afp';}break;
			case 'TopeImpIPS':       if(empty($TopeImpIPS)){         $error['TopeImpIPS']        = 'error/No ha ingresado el tope imponible del ips';}break;
			case 'TopeSegCesantia':  if(empty($TopeSegCesantia)){    $error['TopeSegCesantia']   = 'error/No ha ingresado el tope del seguro de cesantia';}break;
			case 'TopeAPVMensual':   if(empty($TopeAPVMensual)){     $error['TopeAPVMensual']    = 'error/No ha ingresado el tope del apv mensual';}break;
			case 'TopeDepConv':      if(empty($TopeDepConv)){        $error['TopeDepConv']       = 'error/No ha ingresado el tope del deposito convenido';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Observaciones) && $Observaciones!=''){ $Observaciones = EstandarizarInput($Observaciones);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Observaciones)&&contar_palabras_censuradas($Observaciones)!=0){  $error['Observaciones'] = 'error/Edita Observaciones, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Fecha_desde)&&isset($Fecha_hasta)&&$Fecha_desde>$Fecha_hasta){ $error['Fono']    = 'error/La fecha Periodo Inicio debe ser inferior a la fecha de Periodo Termino';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                        INGRESOS                                                 */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/

		case 'new_ingreso':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			$ndata_4 = 0;
			$ndata_5 = 0;
			//Consulto los nombres y los sueldos de los trabajadores
			$arrTrabajador = array();
			$arrTrabajador = db_select_array (false, 'idTipoContratoTrab, idTipoContrato, horas_pactadas, idAFP, idSalud', 'trabajadores_listado', '', 'idEstado = 1', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//verificacion de errores
			foreach ($arrTrabajador as $trab) {
				if(isset($trab['idTipoContratoTrab'])&&$trab['idTipoContratoTrab']==0){  $ndata_1++;}
				if(isset($trab['idTipoContrato'])&&$trab['idTipoContrato']==0){          $ndata_2++;}
				if(isset($trab['horas_pactadas'])&&$trab['horas_pactadas']==0){          $ndata_3++;}
				if(isset($trab['idAFP'])&&$trab['idAFP']==0){                            $ndata_4++;}
				if(isset($trab['idSalud'])&&$trab['idSalud']==0){                        $ndata_5++;}
			}

			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Uno o mas trabajadores no tiene configurado el tipo de contrato trabajador';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/Uno o mas trabajadores no tiene configurado el tipo de contrato';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/Uno o mas trabajadores no tiene configurado las horas pactadas';}
			if($ndata_4 > 0) {$error['ndata_4'] = 'error/Uno o mas trabajadores no tiene configurado la AFP';}
			if($ndata_5 > 0) {$error['ndata_5'] = 'error/Uno o mas trabajadores no tiene configurado la Salud';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['fact_sueldos_basicos']);
				unset($_SESSION['fact_sueldos_sueldos']);
				unset($_SESSION['fact_sueldos_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['fact_sueldos_archivos'])){
					foreach ($_SESSION['fact_sueldos_archivos'] as $key => $producto){
						try {
							if(!is_writable('upload/'.$producto['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$producto['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
				unset($_SESSION['fact_sueldos_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){    $_SESSION['fact_sueldos_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['fact_sueldos_basicos']['Creacion_fecha']   = '';}
				if(isset($Fecha_desde)&&$Fecha_desde!=''){          $_SESSION['fact_sueldos_basicos']['Fecha_desde']      = $Fecha_desde;     }else{$_SESSION['fact_sueldos_basicos']['Fecha_desde']      = '';}
				if(isset($Fecha_hasta)&&$Fecha_hasta!=''){          $_SESSION['fact_sueldos_basicos']['Fecha_hasta']      = $Fecha_hasta;     }else{$_SESSION['fact_sueldos_basicos']['Fecha_hasta']      = '';}
				if(isset($idSistema)&&$idSistema!=''){              $_SESSION['fact_sueldos_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['fact_sueldos_basicos']['idSistema']        = '';}
				if(isset($idUsuario)&&$idUsuario!=''){              $_SESSION['fact_sueldos_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['fact_sueldos_basicos']['idUsuario']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){            $_SESSION['fact_sueldos_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['fact_sueldos_basicos']['fecha_auto']       = '';}
				if(isset($Observaciones)&&$Observaciones!=''){      $_SESSION['fact_sueldos_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['fact_sueldos_basicos']['Observaciones']    = '';}
				if(isset($UF)&&$UF!=''){                            $_SESSION['fact_sueldos_basicos']['UF']               = $UF;              }else{$_SESSION['fact_sueldos_basicos']['UF']               = '';}
				if(isset($UTM)&&$UTM!=''){                          $_SESSION['fact_sueldos_basicos']['UTM']              = $UTM;             }else{$_SESSION['fact_sueldos_basicos']['UTM']              = '';}
				if(isset($IMM)&&$IMM!=''){                          $_SESSION['fact_sueldos_basicos']['IMM']              = $IMM;             }else{$_SESSION['fact_sueldos_basicos']['IMM']              = '';}
				if(isset($TopeImpAFP)&&$TopeImpAFP!=''){            $_SESSION['fact_sueldos_basicos']['TopeImpAFP']       = $TopeImpAFP;      }else{$_SESSION['fact_sueldos_basicos']['TopeImpAFP']       = '';}
				if(isset($TopeImpIPS)&&$TopeImpIPS!=''){            $_SESSION['fact_sueldos_basicos']['TopeImpIPS']       = $TopeImpIPS;      }else{$_SESSION['fact_sueldos_basicos']['TopeImpIPS']       = '';}
				if(isset($TopeSegCesantia)&&$TopeSegCesantia!=''){  $_SESSION['fact_sueldos_basicos']['TopeSegCesantia']  = $TopeSegCesantia; }else{$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']  = '';}
				if(isset($TopeAPVMensual)&&$TopeAPVMensual!=''){    $_SESSION['fact_sueldos_basicos']['TopeAPVMensual']   = $TopeAPVMensual;  }else{$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']   = '';}
				if(isset($TopeDepConv)&&$TopeDepConv!=''){          $_SESSION['fact_sueldos_basicos']['TopeDepConv']      = $TopeDepConv;     }else{$_SESSION['fact_sueldos_basicos']['TopeDepConv']      = '';}

				//Consulto los nombres y los sueldos de los trabajadores
				$SIS_query = '
				trabajadores_listado.idTrabajador,
				trabajadores_listado.idTipoContratoTrab,
				trabajadores_listado.idTipoTrabajador,
				trabajadores_listado.idTipoContrato,
				trabajadores_listado.SueldoLiquido,
				trabajadores_listado.SueldoDia,
				trabajadores_listado.SueldoHora,
				trabajadores_listado.Gratificacion,
				trabajadores_listado.horas_pactadas,
				trabajadores_listado.email,
				trabajadores_listado.idCentroCosto,
				trabajadores_listado.idLevel_1,
				trabajadores_listado.idLevel_2,
				trabajadores_listado.idLevel_3,
				trabajadores_listado.idLevel_4,
				trabajadores_listado.idLevel_5,
				trabajadores_listado.idTipoTrabajo,
				trabajadores_listado.PorcentajeTrabajoPesado,
				trabajadores_listado.idMutual,
				trabajadores_listado.idCotizacionSaludExtra,
				trabajadores_listado.PorcCotSaludExtra,
				trabajadores_listado.MontoCotSaludExtra,

				trabajadores_listado.Nombre,
				trabajadores_listado.ApellidoPat,
				trabajadores_listado.ApellidoMat,
				trabajadores_listado.Rut,
				trabajadores_listado.F_Inicio_Contrato,
				trabajadores_listado.Cargo,

				sistema_afp.idAFP AS AFP_idAFP,
				sistema_afp.Nombre AS AFP_Nombre,
				sistema_afp.PorcentajeDependiente AS AFP_PorcentajeDep,
				sistema_afp.PorcentajeIndependiente AS AFP_PorcentajeIndep,
				sistema_afp.IPS AS AFP_IPS,

				sistema_salud.idSalud AS Salud_idAFP,
				sistema_salud.Nombre AS Salud_Nombre,
				sistema_salud.Porcentaje AS Salud_Porcentaje,

				core_sistemas.Nombre AS SistemaNombre,
				core_sistemas.Rut AS SistemaRut,

				(SELECT COUNT(idCarga) AS Cantidad FROM `trabajadores_listado_cargas` WHERE idEstado = 1 AND idTrabajador = trabajadores_listado.idTrabajador) AS N_cargas,

				trabajadores_listado_tipos.Nombre AS TipoTrabajador,

				centrocosto_listado.Nombre AS CentroCosto_Nombre,
				centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
				centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
				centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
				centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
				centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5,

				sistema_mutual.Nombre AS MutualNombre,
				sistema_mutual.Porcentaje AS MutualPorcentaje,
				core_sistemas_opciones.Nombre AS CotizacionExtra';
				$SIS_join  = '
				LEFT JOIN `trabajadores_listado_tipos`       ON trabajadores_listado_tipos.idTipo         = trabajadores_listado.idTipo
				LEFT JOIN `sistema_afp`                      ON sistema_afp.idAFP                         = trabajadores_listado.idAFP
				LEFT JOIN `sistema_salud`                    ON sistema_salud.idSalud                     = trabajadores_listado.idSalud
				LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                   = trabajadores_listado.idSistema
				LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto         = trabajadores_listado.idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1     = trabajadores_listado.idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2     = trabajadores_listado.idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3     = trabajadores_listado.idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4     = trabajadores_listado.idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5     = trabajadores_listado.idLevel_5
				LEFT JOIN `sistema_mutual`                   ON sistema_mutual.idMutual                   = trabajadores_listado.idMutual
				LEFT JOIN `core_sistemas_opciones`           ON core_sistemas_opciones.idOpciones         = trabajadores_listado.idCotizacionSaludExtra';
				$SIS_where = 'trabajadores_listado.idEstado = 1';
				$SIS_order = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC';
				$arrTrabajador = array();
				$arrTrabajador = db_select_array (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Inasistencias
				$arrInasistenciaDias = array();
				$arrInasistenciaDias = db_select_array (false, 'idTrabajador, COUNT(idTrabajador)AS Cuenta', 'trabajadores_inasistencias_dias', '', 'idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY idTrabajador', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Dias de inasistencia
				foreach ($arrInasistenciaDias as $inasis) {
					$_SESSION['fact_sueldos_sueldos'][$inasis['idTrabajador']]['diasInasistencia'] = $inasis['Cuenta'];
				}
				/************************************/
				//Licencias
				$arrLicencias = array();
				$arrLicencias = db_select_array (false, 'idTrabajador, SUM(N_Dias)AS Cuenta', 'trabajadores_licencias', '', 'idUso=1 AND Fecha_inicio BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY idTrabajador', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Licencias
				foreach ($arrLicencias as $lic) {
					$_SESSION['fact_sueldos_sueldos'][$lic['idTrabajador']]['diasLicencias'] = $lic['Cuenta'];
				}
				/************************************/
				//Bonos Fijos
				$arrBonoFijo = array();
				$arrBonoFijo = db_select_array (false, 'trabajadores_listado_bonos_fijos.idBonoFijo, trabajadores_listado_bonos_fijos.idTrabajador, trabajadores_listado_bonos_fijos.Monto, sistema_bonos_fijos.Nombre,sistema_bonos_fijos.idTipo', 'trabajadores_listado_bonos_fijos', 'LEFT JOIN `sistema_bonos_fijos` ON sistema_bonos_fijos.idBonoFijo = trabajadores_listado_bonos_fijos.idBonoFijo', '', 'trabajadores_listado_bonos_fijos.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Fijos
				foreach ($arrBonoFijo as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['idBonoFijo']  = $bono['idBonoFijo'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoNombre']  = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoMonto']   = $bono['Monto'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoTipo']    = $bono['idTipo'];
				}
				/************************************/
				//Bonos por turnos
				$arrBonoTurno = array();
				$arrBonoTurno = db_select_array (false, 'trabajadores_horas_extras_facturacion_turnos.idServicios,trabajadores_horas_extras_facturacion_turnos.idTrabajador, trabajadores_horas_extras_facturacion_turnos.idTurnos, core_horas_extras_turnos.Nombre,core_horas_extras_turnos.Valor', 'trabajadores_horas_extras_facturacion_turnos', 'LEFT JOIN `core_horas_extras_turnos` ON core_horas_extras_turnos.idTurnos = trabajadores_horas_extras_facturacion_turnos.idTurnos', 'trabajadores_horas_extras_facturacion_turnos.idUso=1 AND trabajadores_horas_extras_facturacion_turnos.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'trabajadores_horas_extras_facturacion_turnos.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos por turnos
				foreach ($arrBonoTurno as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['idServicios']  = $bono['idServicios'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['idTurnos']     = $bono['idTurnos'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['BonoNombre']   = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['BonoMonto']    = $bono['Valor'];
				}
				/************************************/
				//Bonos Temporales
				$arrBonoTemporal = array();
				$arrBonoTemporal = db_select_array (false, 'trabajadores_bonos_temporales.idBonoTemporal,trabajadores_bonos_temporales.idTrabajador, trabajadores_bonos_temporales.Monto, sistema_bonos_temporales.Nombre,sistema_bonos_temporales.idTipo', 'trabajadores_bonos_temporales', 'LEFT JOIN `sistema_bonos_temporales` ON sistema_bonos_temporales.idBonoTemporal = trabajadores_bonos_temporales.idBonoTemporal', 'trabajadores_bonos_temporales.idUso=1 AND trabajadores_bonos_temporales.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'trabajadores_bonos_temporales.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Temporales
				foreach ($arrBonoTemporal as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['idBonoTemporal']  = $bono['idBonoTemporal'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoNombre']      = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoMonto']       = $bono['Monto'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoTipo']        = $bono['idTipo'];
				}
				/************************************/
				//Horas Extras
				$SIS_query = '
				trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador,
				trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje,
				core_horas_extras_porcentajes.Porcentaje,
				trabajadores_listado.idTipoContratoTrab,
				trabajadores_listado.horas_pactadas,
				trabajadores_listado.SueldoLiquido,
				trabajadores_listado.SueldoDia,
				trabajadores_listado.SueldoHora,
				SUM(trabajadores_horas_extras_mensuales_facturacion_horas.N_Horas) AS Horas';
				$SIS_join  = '
				LEFT JOIN `core_horas_extras_porcentajes`   ON core_horas_extras_porcentajes.idPorcentaje  = trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje
				LEFT JOIN `trabajadores_listado`            ON trabajadores_listado.idTrabajador           = trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador';
				$SIS_where = '
				trabajadores_horas_extras_mensuales_facturacion_horas.idUso=1 AND trabajadores_horas_extras_mensuales_facturacion_horas.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador, trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje';
				$SIS_order = 'trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador ASC, trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje ASC';
				$arrHorasExtras = array();
				$arrHorasExtras = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Horas Extras
				foreach ($arrHorasExtras as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['idPorcentaje']   = $bono['idPorcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['Porcentaje']     = $bono['Porcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['N_Horas']        = $bono['Horas'];

					switch ($bono['idTipoContratoTrab']) {
						//Trabajador con sueldo mensual
						case 1:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoLiquido']*((7/30)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoLiquido']*((7/30)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo semanal
						case 2:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoLiquido']*((7/7)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoLiquido']*((7/7)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo diario (jornada semanal de 5 días)
						case 3:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] =  $bono['SueldoDia']*((0.5)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoDia']*((0.5)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo diario (jornada semanal de 6 días)
						case 4:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoDia']*((0.6)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoDia']*((0.6)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo por hora
						case 5:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $trab['SueldoHora'];
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = $trab['SueldoHora']*$bono['Horas'];
						break;

					}
				}
				/************************************/
				//Valor de las cargas familiares
				$arrTablaCargas = array();
				$arrTablaCargas = db_select_array (false, 'idTablaCarga, Tramo, Valor_Desde, Valor_Hasta, Valor_Pago', 'sistema_rrhh_tabla_carga_familiar', '', '', 'idTablaCarga ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Valor de las cargas familiares
				$arrSeguro = array();
				$arrSeguro = db_select_array (false, 'idTipoContrato,Porc_Empleador,Porc_Trabajador', 'sistema_rrhh_tabla_seguro_cesantia', '', '', 'idTablaSeguro ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Valor de las cargas familiares
				$arrImpuestoRenta = array();
				$arrImpuestoRenta = db_select_array (false, 'UTM_Desde, UTM_Hasta, Tasa, Rebaja', 'sistema_rrhh_tabla_iusc', '', '', 'idTablaImpuesto ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Bonos Fijos
				$SIS_query = '
				trabajadores_listado_descuentos_fijos.idDescuentoFijo,
				trabajadores_listado_descuentos_fijos.idTrabajador,
				trabajadores_listado_descuentos_fijos.Monto,
				sistema_descuentos_fijos.Nombre,
				trabajadores_listado_descuentos_fijos.idAFP,
				sistema_afp.Nombre AS AFP';
				$SIS_join  = '
				LEFT JOIN `sistema_descuentos_fijos` ON sistema_descuentos_fijos.idDescuentoFijo = trabajadores_listado_descuentos_fijos.idDescuentoFijo
				LEFT JOIN `sistema_afp`              ON sistema_afp.idAFP                        = trabajadores_listado_descuentos_fijos.idAFP';
				$SIS_where = '';
				$SIS_order = 'trabajadores_listado_descuentos_fijos.idTrabajador ASC';
				$arrDescuentoFijo = array();
				$arrDescuentoFijo = db_select_array (false, $SIS_query, 'trabajadores_listado_descuentos_fijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Fijos
				foreach ($arrDescuentoFijo as $desc) {
					//Verifico si alguno de los descuentos es superior
					//APV
					if($desc['idDescuentoFijo']==1){
						//Si el monto establecido es inferior al tope
						if($desc['Monto']<=$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $desc['Monto'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						//si es superior al tope se asigna el tope
						}elseif($desc['Monto']>$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $_SESSION['fact_sueldos_basicos']['TopeAPVMensual'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						}
					//Deposito Convenido
					}elseif($desc['idDescuentoFijo']==2){
						//Si el monto establecido es inferior al tope
						if($desc['Monto']<=$_SESSION['fact_sueldos_basicos']['TopeDepConv']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $desc['Monto'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						//si es superior al tope se asigna el tope
						}elseif($desc['Monto']>$_SESSION['fact_sueldos_basicos']['TopeDepConv']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $_SESSION['fact_sueldos_basicos']['TopeDepConv'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						}
					}

				}
				/************************************/
				//Anticipos
				$arrAnticipos = array();
				$arrAnticipos = db_select_array (false, 'idAnticipos, Creacion_fecha, idTrabajador, Monto', 'trabajadores_descuentos_anticipos', '', 'idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Anticipos
				foreach ($arrAnticipos as $anticipo) {
					$_SESSION['fact_sueldos_sueldos'][$anticipo['idTrabajador']]['Anticipo'][$anticipo['idAnticipos']]['Creacion_fecha']  = $anticipo['Creacion_fecha'];
					$_SESSION['fact_sueldos_sueldos'][$anticipo['idTrabajador']]['Anticipo'][$anticipo['idAnticipos']]['Monto']           = $anticipo['Monto'];
				}
				/************************************/
				//Descuento Cuota
				$SIS_query = '
				trabajadores_descuentos_cuotas_listado.idCuotas,
				trabajadores_descuentos_cuotas_listado.idTrabajador,
				trabajadores_descuentos_cuotas_listado.Fecha,
				trabajadores_descuentos_cuotas_listado.nCuota,
				trabajadores_descuentos_cuotas_listado.TotalCuotas,
				trabajadores_descuentos_cuotas_listado.monto_cuotas,
				trabajadores_descuentos_cuotas_tipos.Nombre AS Tipo';
				$SIS_join  = '
				LEFT JOIN `trabajadores_descuentos_cuotas`        ON trabajadores_descuentos_cuotas.idFacturacion  = trabajadores_descuentos_cuotas_listado.idFacturacion
				LEFT JOIN `trabajadores_descuentos_cuotas_tipos`  ON trabajadores_descuentos_cuotas_tipos.idTipo   = trabajadores_descuentos_cuotas.idTipo';
				$SIS_where = 'trabajadores_descuentos_cuotas_listado.idUso=1 AND trabajadores_descuentos_cuotas_listado.Fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"';
				$SIS_order = 'trabajadores_descuentos_cuotas_listado.idTrabajador ASC';
				$arrDescuentoCuota = array();
				$arrDescuentoCuota = db_select_array (false, $SIS_query, 'trabajadores_descuentos_cuotas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Descuento Cuota
				foreach ($arrDescuentoCuota as $cuota) {
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['Fecha']         = $cuota['Fecha'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['nCuota']        = $cuota['nCuota'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['TotalCuotas']   = $cuota['TotalCuotas'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['monto_cuotas']  = $cuota['monto_cuotas'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['Tipo']          = $cuota['Tipo'];
				}

				/************************************/
				//Recorro y guardo los datos
				foreach ($arrTrabajador as $trab) {
					/***********************************************************/
					/*                     Guardables                          */
					/***********************************************************/
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idTrabajador']         = $trab['idTrabajador'];        //Trabajador
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idTipoContratoTrab']   = $trab['idTipoContratoTrab'];  //Tipo Contrato
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['horas_pactadas']       = $trab['horas_pactadas'];      //Horas por semana pactado
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Gratificacion']        = $trab['Gratificacion'];       //Gratificacion

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idCentroCosto']        = $trab['idCentroCosto'];       //idCentroCosto
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_1']            = $trab['idLevel_1'];           //idLevel_1
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_2']            = $trab['idLevel_2'];           //idLevel_2
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_3']            = $trab['idLevel_3'];           //idLevel_3
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_4']            = $trab['idLevel_4'];           //idLevel_4
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_5']            = $trab['idLevel_5'];           //idLevel_5

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto']          = '';  //CentroCosto
					if(isset($trab['CentroCosto_Nombre'])&&$trab['CentroCosto_Nombre']!=''){   $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto']  = $trab['CentroCosto_Nombre'];}
					if(isset($trab['CentroCosto_Level_1'])&&$trab['CentroCosto_Level_1']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_1'];}
					if(isset($trab['CentroCosto_Level_2'])&&$trab['CentroCosto_Level_2']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_2'];}
					if(isset($trab['CentroCosto_Level_3'])&&$trab['CentroCosto_Level_3']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_3'];}
					if(isset($trab['CentroCosto_Level_4'])&&$trab['CentroCosto_Level_4']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_4'];}
					if(isset($trab['CentroCosto_Level_5'])&&$trab['CentroCosto_Level_5']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_5'];}

					/************************************************************************************************/
					/*                                            Haberes                                           */
					/************************************************************************************************/
					//Sueldo y dias pactados
					switch ($trab['idTipoContratoTrab']) {
						//Trabajador con sueldo mensual
						case 1:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Mensual';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoLiquido'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 30;
						break;
						//Trabajador con sueldo semanal
						case 2:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Semanal';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoLiquido'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 7;
						break;
						//Trabajador con sueldo diario (jornada semanal de 5 días)
						case 3:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Diario (jornada semanal de 5 días)';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoDia'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 5;
						break;
						//Trabajador con sueldo diario (jornada semanal de 6 días)
						case 4:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Diario (jornada semanal de 6 días)';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoDia'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 6;
						break;
						//Trabajador con sueldo por hora
						case 5:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo por hora';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoHora'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 1;
						break;
					}
					//Dias trabajados
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados'];
					if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasInasistencia'])){$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasInasistencia'];}
					if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasLicencias'])){$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasLicencias'];}
					//Calculo del base a pagar
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPagado'] = ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados']/$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados'])*$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado'];
					//Calculo Total Bonos Fijos(100 tipos bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto']   = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] = 0;
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==1){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoMonto'];
						//verifico si existe y si esta no afecto a descuentos
						}elseif(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==2){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos por turno (6 maximo)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno']   = 0;
					for ($x = 0; $x <= 6; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto']!=0){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos Temporales(100  bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto']   = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] = 0;
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==1){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'];
						//verifico si existe y si esta no afecto a descuentos
						}elseif(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==2){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos Temporales(100  bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras']   = 0;
					for ($x = 0; $x <= 31; $x++) {
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['N_Horas'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['N_Horas']!=0){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras']   = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['TotalHora'];
						}
					}
					//Calculo de las cargas familiares
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_n']              = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_valor']          = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_idTramo']        = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_tramo']          = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_n']              = $trab['N_cargas'];
					//Recorro la tabla para establecer el valor de la carga familiar
					foreach ($arrTablaCargas as $tabla) {
						if($tabla['Valor_Desde']<=$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']<=$tabla['Valor_Hasta']){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_idTramo']        = $tabla['idTablaCarga'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_valor']          = $tabla['Valor_Pago'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_tramo']          = $tabla['Tramo'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'] = $tabla['Valor_Pago']*$trab['N_cargas'];
						}
					}

					//Calculo del Sueldo imponible
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPagado'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Gratificacion'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'];

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'];

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHaberes'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'];
					/************************************************************************************************/
					/*                                            Deberes                                           */
					/************************************************************************************************/
					//Se verifica el tipo de sistema previsional en el que esta
					//Si esta en AFP
					if($trab['AFP_IPS']==0){
						//Verifico si es un trabajador dependiente
						if($trab['idTipoTrabajador']==1){
							$AFPPorcentaje = $trab['AFP_PorcentajeDep'];
						//Verifico si es un trabajador independiente
						}elseif($trab['idTipoTrabajador']==2){
							$AFPPorcentaje = $trab['AFP_PorcentajeIndep'];
						}

						//Se establece el sueldo imponible Maximo
						if($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible']<=$_SESSION['fact_sueldos_basicos']['TopeImpAFP']){
							$Sueldo_Imp = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'];
						}else{
							$Sueldo_Imp = $_SESSION['fact_sueldos_basicos']['TopeImpAFP'];
						}

					//Si esta en el IPS
					}elseif($trab['AFP_IPS']==1){
						//Verifico si es un trabajador dependiente
						if($trab['idTipoTrabajador']==1){
							$AFPPorcentaje = $trab['AFP_PorcentajeDep'];
						//Verifico si es un trabajador independiente
						}elseif($trab['idTipoTrabajador']==2){
							$AFPPorcentaje = $trab['AFP_PorcentajeIndep'];
						}

						//Se establece el sueldo imponible Maximo
						if($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible']<=$_SESSION['fact_sueldos_basicos']['TopeImpIPS']){
							$Sueldo_Imp = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'];
						}else{
							$Sueldo_Imp = $_SESSION['fact_sueldos_basicos']['TopeImpIPS'];
						}

					}

					//Se guardan las imposiciones
					//AFP
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_idAFP']      = $trab['AFP_idAFP'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Nombre']     = $trab['AFP_Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Porcentaje'] = $AFPPorcentaje;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Total']      = ($Sueldo_Imp/100)*$AFPPorcentaje;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_SIS']        = ($Sueldo_Imp/100)*1.94;

					//SALUD
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_idAFP']      = $trab['Salud_idAFP'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Nombre']     = $trab['Salud_Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Porcentaje'] = $trab['Salud_Porcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Total']      = ($Sueldo_Imp/100)*$trab['Salud_Porcentaje'];

					//COTIZACION EXTRA
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_idCotizacion']         = $trab['idCotizacionSaludExtra'];  //idCotizacionSaludExtra
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionPorcentaje'] = $trab['PorcCotSaludExtra'];  //PorcCotSaludExtra
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionMonto']      = $trab['MontoCotSaludExtra'];  //MontoCotSaludExtra
					//Si hay porcentaje
					if(isset($trab['PorcCotSaludExtra'])&&$trab['PorcCotSaludExtra']!=0){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = ($Sueldo_Imp/100)*$trab['PorcCotSaludExtra'];
					//si hay monto
					}elseif(isset($trab['MontoCotSaludExtra'])&&$trab['MontoCotSaludExtra']!=0){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = $trab['MontoCotSaludExtra'];
					//si no hay nada
					}else{
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = 0;
					}

					//MUTUAL
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_id']         = $trab['idMutual'];          //idMutual
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Nombre']     = $trab['MutualNombre'];      //MutualNombre
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Porcentaje'] = $trab['MutualPorcentaje'];  //MutualPorcentaje
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Valor']      = ($Sueldo_Imp/100)*$trab['MutualPorcentaje'];

					//TRABAJO PESADO
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Id']          = $trab['idTipoTrabajo'];            //idTipoTrabajo
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Porcentaje']  = $trab['PorcentajeTrabajoPesado'];  //Porcentaje Trabajo Pesado
					//si es trabajo pesado
					if(isset($trab['idTipoTrabajo'])&&$trab['idTipoTrabajo']==2){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Valor'] = ($Sueldo_Imp/100)*$trab['PorcentajeTrabajoPesado'];
					}else{
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Valor'] = 0;
					}

					//Se suman todos los descuentos
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Total'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Total'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'];
					//$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Valor'];

					//Calculo Total Bonos Fijos(100 tipos bonos estimados en el sistema)
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'])){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'];
						}
					}

					//Recorro la tabla para establecer el valor del seguro de cesantia
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] = 0;
					foreach ($arrSeguro as $seguro) {
						//Si el seguro es el mismo
						if($trab['idTipoContrato']==$seguro['idTipoContrato']){
							if($Sueldo_Imp<$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']){
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  =($Sueldo_Imp/100)*$seguro['Porc_Empleador'];
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] =($Sueldo_Imp/100)*$seguro['Porc_Trabajador'];
							}else{
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  =($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']/100)*$seguro['Porc_Empleador'];
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] =($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']/100)*$seguro['Porc_Trabajador'];
							}
						}
					}
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'];

					//Calculo del impuesto a la renta
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'];
					foreach ($arrImpuestoRenta as $imp_renta) {
						//Verifico si el sueldo afecto esta dentro de los limites
						if(($imp_renta['UTM_Desde'] * $_SESSION['fact_sueldos_basicos']['UTM'])<=$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta']&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta']<=($imp_renta['UTM_Hasta'] * $_SESSION['fact_sueldos_basicos']['UTM'])){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'] = ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta'] * $imp_renta['Tasa'])-($_SESSION['fact_sueldos_basicos']['UTM'] * $imp_renta['Rebaja']);
						}
					}
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'];

					//Calculo de los otros descuentos
					if(!empty($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Anticipo'])){
						foreach ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Anticipo'] as $key => $producto){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $producto['Monto'];
						}
					}
					if(!empty($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cuotas'])){
						foreach ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cuotas'] as $key => $producto){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $producto['monto_cuotas'];
						}
					}

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalAPagar'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalAPagar'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHaberes'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'];

					/***********************************************************/
					/*                    No Guardables                        */
					/***********************************************************/
					//Datos del trabajador
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorNombre']    = $trab['ApellidoPat'].' '.$trab['ApellidoMat'].' '.$trab['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorRut']       = $trab['Rut'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorEmail']     = $trab['email'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorContrato']  = $trab['F_Inicio_Contrato'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorCargo']     = $trab['Cargo'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SistemaNombre']       = $trab['SistemaNombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SistemaRut']          = $trab['SistemaRut'];

				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;
/*******************************************************************************************************************/
		case 'clear_all_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['fact_sueldos_basicos']);
			unset($_SESSION['fact_sueldos_sueldos']);
			unset($_SESSION['fact_sueldos_temporal']);

			//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
			if (isset($_SESSION['fact_sueldos_archivos'])){
				foreach ($_SESSION['fact_sueldos_archivos'] as $key => $producto){
					try {
						if(!is_writable('upload/'.$producto['Nombre'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$producto['Nombre']);
						}
					}catch(Exception $e) {
						//guardar el dato en un archivo log
					}
				}
			}
			unset($_SESSION['fact_sueldos_archivos']);

			//redirijo
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/
		case 'modBase_ing':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			$ndata_3 = 0;
			$ndata_4 = 0;
			$ndata_5 = 0;
			//Consulto los nombres y los sueldos de los trabajadores
			$arrTrabajador = array();
			$arrTrabajador = db_select_array (false, 'idTipoContratoTrab, idTipoContrato, horas_pactadas, idAFP, idSalud', 'trabajadores_listado', '', 'idEstado = 1', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//verificacion de errores
			foreach ($arrTrabajador as $trab) {
				if(isset($trab['idTipoContratoTrab'])&&$trab['idTipoContratoTrab']==0){  $ndata_1++;}
				if(isset($trab['idTipoContrato'])&&$trab['idTipoContrato']==0){          $ndata_2++;}
				if(isset($trab['horas_pactadas'])&&$trab['horas_pactadas']==0){          $ndata_3++;}
				if(isset($trab['idAFP'])&&$trab['idAFP']==0){                            $ndata_4++;}
				if(isset($trab['idSalud'])&&$trab['idSalud']==0){                        $ndata_5++;}
			}

			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Uno o mas trabajadores no tiene configurado el tipo de contrato';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/Uno o mas trabajadores no tiene configurado el tipo de contrato';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/Uno o mas trabajadores no tiene configurado las horas pactadas';}
			if($ndata_4 > 0) {$error['ndata_4'] = 'error/Uno o mas trabajadores no tiene configurado la AFP';}
			if($ndata_5 > 0) {$error['ndata_5'] = 'error/Uno o mas trabajadores no tiene configurado la Salud';}
			/*******************************************************************/

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Condiciono la variable observaciones
				if(empty($Observaciones)){ $Observaciones= "Sin observaciones";}

				//Borro todas las sesiones
				unset($_SESSION['fact_sueldos_basicos']);
				unset($_SESSION['fact_sueldos_sueldos']);
				unset($_SESSION['fact_sueldos_temporal']);

				//Recorro los archivos subidos y los borro antes de eliminar la variable de sesion
				if (isset($_SESSION['fact_sueldos_archivos'])){
					foreach ($_SESSION['fact_sueldos_archivos'] as $key => $producto){
						try {
							if(!is_writable('upload/'.$producto['Nombre'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/'.$producto['Nombre']);
							}
						}catch(Exception $e) {
							//guardar el dato en un archivo log
						}
					}
				}
				unset($_SESSION['fact_sueldos_archivos']);

				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Creacion_fecha)&&$Creacion_fecha!=''){    $_SESSION['fact_sueldos_basicos']['Creacion_fecha']   = $Creacion_fecha;  }else{$_SESSION['fact_sueldos_basicos']['Creacion_fecha']   = '';}
				if(isset($Fecha_desde)&&$Fecha_desde!=''){          $_SESSION['fact_sueldos_basicos']['Fecha_desde']      = $Fecha_desde;     }else{$_SESSION['fact_sueldos_basicos']['Fecha_desde']      = '';}
				if(isset($Fecha_hasta)&&$Fecha_hasta!=''){          $_SESSION['fact_sueldos_basicos']['Fecha_hasta']      = $Fecha_hasta;     }else{$_SESSION['fact_sueldos_basicos']['Fecha_hasta']      = '';}
				if(isset($idSistema)&&$idSistema!=''){              $_SESSION['fact_sueldos_basicos']['idSistema']        = $idSistema;       }else{$_SESSION['fact_sueldos_basicos']['idSistema']        = '';}
				if(isset($idUsuario)&&$idUsuario!=''){              $_SESSION['fact_sueldos_basicos']['idUsuario']        = $idUsuario;       }else{$_SESSION['fact_sueldos_basicos']['idUsuario']        = '';}
				if(isset($fecha_auto)&&$fecha_auto!=''){            $_SESSION['fact_sueldos_basicos']['fecha_auto']       = $fecha_auto;      }else{$_SESSION['fact_sueldos_basicos']['fecha_auto']       = '';}
				if(isset($Observaciones)&&$Observaciones!=''){      $_SESSION['fact_sueldos_basicos']['Observaciones']    = $Observaciones;   }else{$_SESSION['fact_sueldos_basicos']['Observaciones']    = '';}
				if(isset($UF)&&$UF!=''){                            $_SESSION['fact_sueldos_basicos']['UF']               = $UF;              }else{$_SESSION['fact_sueldos_basicos']['UF']               = '';}
				if(isset($UTM)&&$UTM!=''){                          $_SESSION['fact_sueldos_basicos']['UTM']              = $UTM;             }else{$_SESSION['fact_sueldos_basicos']['UTM']              = '';}
				if(isset($IMM)&&$IMM!=''){                          $_SESSION['fact_sueldos_basicos']['IMM']              = $IMM;             }else{$_SESSION['fact_sueldos_basicos']['IMM']              = '';}
				if(isset($TopeImpAFP)&&$TopeImpAFP!=''){            $_SESSION['fact_sueldos_basicos']['TopeImpAFP']       = $TopeImpAFP;      }else{$_SESSION['fact_sueldos_basicos']['TopeImpAFP']       = '';}
				if(isset($TopeImpIPS)&&$TopeImpIPS!=''){            $_SESSION['fact_sueldos_basicos']['TopeImpIPS']       = $TopeImpIPS;      }else{$_SESSION['fact_sueldos_basicos']['TopeImpIPS']       = '';}
				if(isset($TopeSegCesantia)&&$TopeSegCesantia!=''){  $_SESSION['fact_sueldos_basicos']['TopeSegCesantia']  = $TopeSegCesantia; }else{$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']  = '';}
				if(isset($TopeAPVMensual)&&$TopeAPVMensual!=''){    $_SESSION['fact_sueldos_basicos']['TopeAPVMensual']   = $TopeAPVMensual;  }else{$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']   = '';}
				if(isset($TopeDepConv)&&$TopeDepConv!=''){          $_SESSION['fact_sueldos_basicos']['TopeDepConv']      = $TopeDepConv;     }else{$_SESSION['fact_sueldos_basicos']['TopeDepConv']      = '';}

				//Consulto los nombres y los sueldos de los trabajadores
				$SIS_query = '
				trabajadores_listado.idTrabajador,
				trabajadores_listado.idTipoContratoTrab,
				trabajadores_listado.idTipoTrabajador,
				trabajadores_listado.idTipoContrato,
				trabajadores_listado.SueldoLiquido,
				trabajadores_listado.SueldoDia,
				trabajadores_listado.SueldoHora,
				trabajadores_listado.Gratificacion,
				trabajadores_listado.horas_pactadas,
				trabajadores_listado.email,
				trabajadores_listado.idCentroCosto,
				trabajadores_listado.idLevel_1,
				trabajadores_listado.idLevel_2,
				trabajadores_listado.idLevel_3,
				trabajadores_listado.idLevel_4,
				trabajadores_listado.idLevel_5,
				trabajadores_listado.idTipoTrabajo,
				trabajadores_listado.PorcentajeTrabajoPesado,
				trabajadores_listado.idMutual,
				trabajadores_listado.idCotizacionSaludExtra,
				trabajadores_listado.PorcCotSaludExtra,
				trabajadores_listado.MontoCotSaludExtra,

				trabajadores_listado.Nombre,
				trabajadores_listado.ApellidoPat,
				trabajadores_listado.ApellidoMat,
				trabajadores_listado.Rut,
				trabajadores_listado.F_Inicio_Contrato,
				trabajadores_listado.Cargo,

				sistema_afp.idAFP AS AFP_idAFP,
				sistema_afp.Nombre AS AFP_Nombre,
				sistema_afp.PorcentajeDependiente AS AFP_PorcentajeDep,
				sistema_afp.PorcentajeIndependiente AS AFP_PorcentajeIndep,
				sistema_afp.IPS AS AFP_IPS,

				sistema_salud.idSalud AS Salud_idAFP,
				sistema_salud.Nombre AS Salud_Nombre,
				sistema_salud.Porcentaje AS Salud_Porcentaje,

				core_sistemas.Nombre AS SistemaNombre,
				core_sistemas.Rut AS SistemaRut,

				(SELECT COUNT(idCarga) AS Cantidad FROM `trabajadores_listado_cargas` WHERE idEstado = 1 AND idTrabajador = trabajadores_listado.idTrabajador) AS N_cargas,

				trabajadores_listado_tipos.Nombre AS TipoTrabajador,

				centrocosto_listado.Nombre AS CentroCosto_Nombre,
				centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
				centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
				centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
				centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
				centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5,

				sistema_mutual.Nombre AS MutualNombre,
				sistema_mutual.Porcentaje AS MutualPorcentaje,
				core_sistemas_opciones.Nombre AS CotizacionExtra';
				$SIS_join  = '
				LEFT JOIN `trabajadores_listado_tipos`       ON trabajadores_listado_tipos.idTipo         = trabajadores_listado.idTipo
				LEFT JOIN `sistema_afp`                      ON sistema_afp.idAFP                         = trabajadores_listado.idAFP
				LEFT JOIN `sistema_salud`                    ON sistema_salud.idSalud                     = trabajadores_listado.idSalud
				LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                   = trabajadores_listado.idSistema
				LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto         = trabajadores_listado.idCentroCosto
				LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1     = trabajadores_listado.idLevel_1
				LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2     = trabajadores_listado.idLevel_2
				LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3     = trabajadores_listado.idLevel_3
				LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4     = trabajadores_listado.idLevel_4
				LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5     = trabajadores_listado.idLevel_5
				LEFT JOIN `sistema_mutual`                   ON sistema_mutual.idMutual                   = trabajadores_listado.idMutual
				LEFT JOIN `core_sistemas_opciones`           ON core_sistemas_opciones.idOpciones         = trabajadores_listado.idCotizacionSaludExtra';
				$SIS_where = 'trabajadores_listado.idEstado = 1';
				$SIS_order = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC';
				$arrTrabajador = array();
				$arrTrabajador = db_select_array (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Inasistencias
				$arrInasistenciaDias = array();
				$arrInasistenciaDias = db_select_array (false, 'idTrabajador, COUNT(idTrabajador)AS Cuenta', 'trabajadores_inasistencias_dias', '', 'idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY idTrabajador', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Dias de inasistencia
				foreach ($arrInasistenciaDias as $inasis) {
					$_SESSION['fact_sueldos_sueldos'][$inasis['idTrabajador']]['diasInasistencia'] = $inasis['Cuenta'];
				}
				/************************************/
				//Licencias
				$arrLicencias = array();
				$arrLicencias = db_select_array (false, 'idTrabajador, SUM(N_Dias)AS Cuenta', 'trabajadores_licencias', '', 'idUso=1 AND Fecha_inicio BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY idTrabajador', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Licencias
				foreach ($arrLicencias as $lic) {
					$_SESSION['fact_sueldos_sueldos'][$lic['idTrabajador']]['diasLicencias'] = $lic['Cuenta'];
				}
				/************************************/
				//Bonos Fijos
				$arrBonoFijo = array();
				$arrBonoFijo = db_select_array (false, 'trabajadores_listado_bonos_fijos.idBonoFijo, trabajadores_listado_bonos_fijos.idTrabajador, trabajadores_listado_bonos_fijos.Monto, sistema_bonos_fijos.Nombre,sistema_bonos_fijos.idTipo', 'trabajadores_listado_bonos_fijos', 'LEFT JOIN `sistema_bonos_fijos` ON sistema_bonos_fijos.idBonoFijo = trabajadores_listado_bonos_fijos.idBonoFijo', '', 'trabajadores_listado_bonos_fijos.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Fijos
				foreach ($arrBonoFijo as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['idBonoFijo']  = $bono['idBonoFijo'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoNombre']  = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoMonto']   = $bono['Monto'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoFijo'][$bono['idBonoFijo']]['BonoTipo']    = $bono['idTipo'];
				}
				/************************************/
				//Bonos por turnos
				$arrBonoTurno = array();
				$arrBonoTurno = db_select_array (false, 'trabajadores_horas_extras_facturacion_turnos.idServicios,trabajadores_horas_extras_facturacion_turnos.idTrabajador, trabajadores_horas_extras_facturacion_turnos.idTurnos, core_horas_extras_turnos.Nombre,core_horas_extras_turnos.Valor', 'trabajadores_horas_extras_facturacion_turnos', 'LEFT JOIN `core_horas_extras_turnos` ON core_horas_extras_turnos.idTurnos = trabajadores_horas_extras_facturacion_turnos.idTurnos', 'trabajadores_horas_extras_facturacion_turnos.idUso=1 AND trabajadores_horas_extras_facturacion_turnos.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'trabajadores_horas_extras_facturacion_turnos.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos por turnos
				foreach ($arrBonoTurno as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['idServicios']  = $bono['idServicios'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['idTurnos']     = $bono['idTurnos'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['BonoNombre']   = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTurno'][$bono['idTurnos']]['BonoMonto']    = $bono['Valor'];
				}
				/************************************/
				//Bonos Temporales
				$arrBonoTemporal = array();
				$arrBonoTemporal = db_select_array (false, 'trabajadores_bonos_temporales.idBonoTemporal,trabajadores_bonos_temporales.idTrabajador, trabajadores_bonos_temporales.Monto, sistema_bonos_temporales.Nombre,sistema_bonos_temporales.idTipo', 'trabajadores_bonos_temporales', 'LEFT JOIN `sistema_bonos_temporales` ON sistema_bonos_temporales.idBonoTemporal = trabajadores_bonos_temporales.idBonoTemporal', 'trabajadores_bonos_temporales.idUso=1 AND trabajadores_bonos_temporales.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'trabajadores_bonos_temporales.idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Temporales
				foreach ($arrBonoTemporal as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['idBonoTemporal']  = $bono['idBonoTemporal'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoNombre']      = $bono['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoMonto']       = $bono['Monto'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['BonoTemporal'][$bono['idBonoTemporal']]['BonoTipo']        = $bono['idTipo'];
				}
				/************************************/
				//Horas Extras
				$SIS_query = '
				trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador,
				trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje,
				core_horas_extras_porcentajes.Porcentaje,
				trabajadores_listado.idTipoContratoTrab,
				trabajadores_listado.horas_pactadas,
				trabajadores_listado.SueldoLiquido,
				trabajadores_listado.SueldoDia,
				trabajadores_listado.SueldoHora,
				SUM(trabajadores_horas_extras_mensuales_facturacion_horas.N_Horas) AS Horas';
				$SIS_join  = '
				LEFT JOIN `core_horas_extras_porcentajes`   ON core_horas_extras_porcentajes.idPorcentaje  = trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje
				LEFT JOIN `trabajadores_listado`            ON trabajadores_listado.idTrabajador           = trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador';
				$SIS_where = '
				trabajadores_horas_extras_mensuales_facturacion_horas.idUso=1 AND trabajadores_horas_extras_mensuales_facturacion_horas.Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'" GROUP BY trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador, trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje';
				$SIS_order = 'trabajadores_horas_extras_mensuales_facturacion_horas.idTrabajador ASC, trabajadores_horas_extras_mensuales_facturacion_horas.idPorcentaje ASC';
				$arrHorasExtras = array();
				$arrHorasExtras = db_select_array (false, $SIS_query, 'trabajadores_horas_extras_mensuales_facturacion_horas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Horas Extras
				foreach ($arrHorasExtras as $bono) {
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['idPorcentaje']   = $bono['idPorcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['Porcentaje']     = $bono['Porcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['N_Horas']        = $bono['Horas'];

					switch ($bono['idTipoContratoTrab']) {
						//Trabajador con sueldo mensual
						case 1:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoLiquido']*((7/30)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoLiquido']*((7/30)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo semanal
						case 2:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoLiquido']*((7/7)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoLiquido']*((7/7)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo diario (jornada semanal de 5 días)
						case 3:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] =  $bono['SueldoDia']*((0.5)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoDia']*((0.5)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo diario (jornada semanal de 6 días)
						case 4:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $bono['SueldoDia']*((0.6)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100));
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = ($bono['SueldoDia']*((0.6)/$bono['horas_pactadas']*((100+$bono['Porcentaje'])/100)))*$bono['Horas'];
						break;
						//Trabajador con sueldo por hora
						case 5:
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['ValorHora'] = $trab['SueldoHora'];
							$_SESSION['fact_sueldos_sueldos'][$bono['idTrabajador']]['HorasExtras'][$bono['idPorcentaje']]['TotalHora'] = $trab['SueldoHora']*$bono['Horas'];
						break;

					}
				}
				/************************************/
				//Valor de las cargas familiares
				$arrTablaCargas = array();
				$arrTablaCargas = db_select_array (false, 'idTablaCarga, Tramo, Valor_Desde, Valor_Hasta, Valor_Pago', 'sistema_rrhh_tabla_carga_familiar', '', '', 'idTablaCarga ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Valor de las cargas familiares
				$arrSeguro = array();
				$arrSeguro = db_select_array (false, 'idTipoContrato,Porc_Empleador,Porc_Trabajador', 'sistema_rrhh_tabla_seguro_cesantia', '', '', 'idTablaSeguro ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Valor de las cargas familiares
				$arrImpuestoRenta = array();
				$arrImpuestoRenta = db_select_array (false, 'UTM_Desde, UTM_Hasta, Tasa, Rebaja', 'sistema_rrhh_tabla_iusc', '', '', 'idTablaImpuesto ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/************************************/
				//Bonos Fijos
				$SIS_query = '
				trabajadores_listado_descuentos_fijos.idDescuentoFijo,
				trabajadores_listado_descuentos_fijos.idTrabajador,
				trabajadores_listado_descuentos_fijos.Monto,
				sistema_descuentos_fijos.Nombre,
				trabajadores_listado_descuentos_fijos.idAFP,
				sistema_afp.Nombre AS AFP';
				$SIS_join  = '
				LEFT JOIN `sistema_descuentos_fijos` ON sistema_descuentos_fijos.idDescuentoFijo = trabajadores_listado_descuentos_fijos.idDescuentoFijo
				LEFT JOIN `sistema_afp`              ON sistema_afp.idAFP                        = trabajadores_listado_descuentos_fijos.idAFP';
				$SIS_where = '';
				$SIS_order = 'trabajadores_listado_descuentos_fijos.idTrabajador ASC';
				$arrDescuentoFijo = array();
				$arrDescuentoFijo = db_select_array (false, $SIS_query, 'trabajadores_listado_descuentos_fijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Bonos Fijos
				foreach ($arrDescuentoFijo as $desc) {
					//Verifico si alguno de los descuentos es superior
					//APV
					if($desc['idDescuentoFijo']==1){
						//Si el monto establecido es inferior al tope
						if($desc['Monto']<=$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $desc['Monto'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						//si es superior al tope se asigna el tope
						}elseif($desc['Monto']>$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $_SESSION['fact_sueldos_basicos']['TopeAPVMensual'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						}
					//Deposito Convenido
					}elseif($desc['idDescuentoFijo']==2){
						//Si el monto establecido es inferior al tope
						if($desc['Monto']<=$_SESSION['fact_sueldos_basicos']['TopeDepConv']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $desc['Monto'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						//si es superior al tope se asigna el tope
						}elseif($desc['Monto']>$_SESSION['fact_sueldos_basicos']['TopeDepConv']){
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['idDescuentoFijo']  = $desc['idDescuentoFijo'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoNombre']  = $desc['Nombre'].' ('.$desc['AFP'].')';
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoMonto']   = $_SESSION['fact_sueldos_basicos']['TopeDepConv'];
							$_SESSION['fact_sueldos_sueldos'][$desc['idTrabajador']]['DescuentoFijo'][$desc['idDescuentoFijo']]['DescuentoIDAFP']   = $desc['idAFP'];
						}
					}

				}
				/************************************/
				//Anticipos
				$arrAnticipos = array();
				$arrAnticipos = db_select_array (false, 'idAnticipos, Creacion_fecha, idTrabajador, Monto', 'trabajadores_descuentos_anticipos', '', 'idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', 'idTrabajador ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Anticipos
				foreach ($arrAnticipos as $anticipo) {
					$_SESSION['fact_sueldos_sueldos'][$anticipo['idTrabajador']]['Anticipo'][$anticipo['idAnticipos']]['Creacion_fecha']  = $anticipo['Creacion_fecha'];
					$_SESSION['fact_sueldos_sueldos'][$anticipo['idTrabajador']]['Anticipo'][$anticipo['idAnticipos']]['Monto']           = $anticipo['Monto'];
				}
				/************************************/
				//Descuento Cuota
				$SIS_query = '
				trabajadores_descuentos_cuotas_listado.idCuotas,
				trabajadores_descuentos_cuotas_listado.idTrabajador,
				trabajadores_descuentos_cuotas_listado.Fecha,
				trabajadores_descuentos_cuotas_listado.nCuota,
				trabajadores_descuentos_cuotas_listado.TotalCuotas,
				trabajadores_descuentos_cuotas_listado.monto_cuotas,
				trabajadores_descuentos_cuotas_tipos.Nombre AS Tipo';
				$SIS_join  = '
				LEFT JOIN `trabajadores_descuentos_cuotas`        ON trabajadores_descuentos_cuotas.idFacturacion  = trabajadores_descuentos_cuotas_listado.idFacturacion
				LEFT JOIN `trabajadores_descuentos_cuotas_tipos`  ON trabajadores_descuentos_cuotas_tipos.idTipo   = trabajadores_descuentos_cuotas.idTipo';
				$SIS_where = 'trabajadores_descuentos_cuotas_listado.idUso=1 AND trabajadores_descuentos_cuotas_listado.Fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"';
				$SIS_order = 'trabajadores_descuentos_cuotas_listado.idTrabajador ASC';
				$arrDescuentoCuota = array();
				$arrDescuentoCuota = db_select_array (false, $SIS_query, 'trabajadores_descuentos_cuotas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Descuento Cuota
				foreach ($arrDescuentoCuota as $cuota) {
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['Fecha']         = $cuota['Fecha'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['nCuota']        = $cuota['nCuota'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['TotalCuotas']   = $cuota['TotalCuotas'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['monto_cuotas']  = $cuota['monto_cuotas'];
					$_SESSION['fact_sueldos_sueldos'][$cuota['idTrabajador']]['Cuotas'][$cuota['idCuotas']]['Tipo']          = $cuota['Tipo'];
				}

				/************************************/
				//Recorro y guardo los datos
				foreach ($arrTrabajador as $trab) {
					/***********************************************************/
					/*                     Guardables                          */
					/***********************************************************/
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idTrabajador']         = $trab['idTrabajador'];        //Trabajador
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idTipoContratoTrab']   = $trab['idTipoContratoTrab'];  //Tipo Contrato
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['horas_pactadas']       = $trab['horas_pactadas'];      //Horas por semana pactado
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Gratificacion']        = $trab['Gratificacion'];       //Gratificacion

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idCentroCosto']        = $trab['idCentroCosto'];       //idCentroCosto
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_1']            = $trab['idLevel_1'];           //idLevel_1
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_2']            = $trab['idLevel_2'];           //idLevel_2
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_3']            = $trab['idLevel_3'];           //idLevel_3
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_4']            = $trab['idLevel_4'];           //idLevel_4
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['idLevel_5']            = $trab['idLevel_5'];           //idLevel_5

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto']          = '';  //CentroCosto
					if(isset($trab['CentroCosto_Nombre'])&&$trab['CentroCosto_Nombre']!=''){   $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto']  = $trab['CentroCosto_Nombre'];}
					if(isset($trab['CentroCosto_Level_1'])&&$trab['CentroCosto_Level_1']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_1'];}
					if(isset($trab['CentroCosto_Level_2'])&&$trab['CentroCosto_Level_2']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_2'];}
					if(isset($trab['CentroCosto_Level_3'])&&$trab['CentroCosto_Level_3']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_3'];}
					if(isset($trab['CentroCosto_Level_4'])&&$trab['CentroCosto_Level_4']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_4'];}
					if(isset($trab['CentroCosto_Level_5'])&&$trab['CentroCosto_Level_5']!=''){ $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['CentroCosto'] .= ' - '.$trab['CentroCosto_Level_5'];}

					/************************************************************************************************/
					/*                                            Haberes                                           */
					/************************************************************************************************/
					//Sueldo y dias pactados
					switch ($trab['idTipoContratoTrab']) {
						//Trabajador con sueldo mensual
						case 1:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Mensual';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoLiquido'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 30;
						break;
						//Trabajador con sueldo semanal
						case 2:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Semanal';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoLiquido'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 7;
						break;
						//Trabajador con sueldo diario (jornada semanal de 5 días)
						case 3:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Diario (jornada semanal de 5 días)';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoDia'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 5;
						break;
						//Trabajador con sueldo diario (jornada semanal de 6 días)
						case 4:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo Diario (jornada semanal de 6 días)';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoDia'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 6;
						break;
						//Trabajador con sueldo por hora
						case 5:
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TipoContratoTrab'] = 'Sueldo por hora';
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']    = $trab['SueldoHora'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados']     = 1;
						break;
					}
					//Dias trabajados
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados'];
					if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasInasistencia'])){$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasInasistencia'];}
					if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasLicencias'])){$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['diasLicencias'];}
					//Calculo del base a pagar
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPagado'] = ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasTrabajados']/$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DiasPactados'])*$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado'];
					//Calculo Total Bonos Fijos(100 tipos bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto']   = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] = 0;
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==1){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoMonto'];
						//verifico si existe y si esta no afecto a descuentos
						}elseif(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoTipo']==2){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoFijo'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos por turno (6 maximo)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno']   = 0;
					for ($x = 0; $x <= 6; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto']!=0){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTurno'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos Temporales(100  bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto']   = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] = 0;
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe y si esta afecto a descuentos
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==1){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'];
						//verifico si existe y si esta no afecto a descuentos
						}elseif(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']==2){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['BonoTemporal'][$x]['BonoMonto'];
						}
					}
					//Calculo Total Bonos Temporales(100  bonos estimados en el sistema)
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras']   = 0;
					for ($x = 0; $x <= 31; $x++) {
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['N_Horas'])&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['N_Horas']!=0){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras']   = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['HorasExtras'][$x]['TotalHora'];
						}
					}
					//Calculo de las cargas familiares
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_n']              = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_valor']          = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_idTramo']        = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_tramo']          = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_n']              = $trab['N_cargas'];
					//Recorro la tabla para establecer el valor de la carga familiar
					foreach ($arrTablaCargas as $tabla) {
						if($tabla['Valor_Desde']<=$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPactado']<=$tabla['Valor_Hasta']){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_idTramo']        = $tabla['idTablaCarga'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_valor']          = $tabla['Valor_Pago'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cargas_tramo']          = $tabla['Tramo'];
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'] = $tabla['Valor_Pago']*$trab['N_cargas'];
						}
					}

					//Calculo del Sueldo imponible
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoPagado'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Gratificacion'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTurno'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHorasExtras'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalCargasFamiliares'];

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoFijoNoAfecto'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalBonoTemporalNoAfecto'];

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHaberes'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoNoImponible'];
					/************************************************************************************************/
					/*                                            Deberes                                           */
					/************************************************************************************************/
					//Se verifica el tipo de sistema previsional en el que esta
					//Si esta en AFP
					if($trab['AFP_IPS']==0){
						//Verifico si es un trabajador dependiente
						if($trab['idTipoTrabajador']==1){
							$AFPPorcentaje = $trab['AFP_PorcentajeDep'];
						//Verifico si es un trabajador independiente
						}elseif($trab['idTipoTrabajador']==2){
							$AFPPorcentaje = $trab['AFP_PorcentajeIndep'];
						}

						//Se establece el sueldo imponible Maximo
						if($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible']<=$_SESSION['fact_sueldos_basicos']['TopeImpAFP']){
							$Sueldo_Imp = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'];
						}else{
							$Sueldo_Imp = $_SESSION['fact_sueldos_basicos']['TopeImpAFP'];
						}

					//Si esta en el IPS
					}elseif($trab['AFP_IPS']==1){
						//Verifico si es un trabajador dependiente
						if($trab['idTipoTrabajador']==1){
							$AFPPorcentaje = $trab['AFP_PorcentajeDep'];
						//Verifico si es un trabajador independiente
						}elseif($trab['idTipoTrabajador']==2){
							$AFPPorcentaje = $trab['AFP_PorcentajeIndep'];
						}

						//Se establece el sueldo imponible Maximo
						if($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible']<=$_SESSION['fact_sueldos_basicos']['TopeImpIPS']){
							$Sueldo_Imp = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'];
						}else{
							$Sueldo_Imp = $_SESSION['fact_sueldos_basicos']['TopeImpIPS'];
						}

					}

					//Se guardan las imposiciones
					//AFP
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_idAFP']      = $trab['AFP_idAFP'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Nombre']     = $trab['AFP_Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Porcentaje'] = $AFPPorcentaje;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Total']      = ($Sueldo_Imp/100)*$AFPPorcentaje;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_SIS']        = ($Sueldo_Imp/100)*1.94;

					//SALUD
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_idAFP']      = $trab['Salud_idAFP'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Nombre']     = $trab['Salud_Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Porcentaje'] = $trab['Salud_Porcentaje'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Total']      = ($Sueldo_Imp/100)*$trab['Salud_Porcentaje'];

					//COTIZACION EXTRA
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_idCotizacion']         = $trab['idCotizacionSaludExtra'];  //idCotizacionSaludExtra
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionPorcentaje'] = $trab['PorcCotSaludExtra'];  //PorcCotSaludExtra
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionMonto']      = $trab['MontoCotSaludExtra'];  //MontoCotSaludExtra
					//Si hay porcentaje
					if(isset($trab['PorcCotSaludExtra'])&&$trab['PorcCotSaludExtra']!=0){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = ($Sueldo_Imp/100)*$trab['PorcCotSaludExtra'];
					//si hay monto
					}elseif(isset($trab['MontoCotSaludExtra'])&&$trab['MontoCotSaludExtra']!=0){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = $trab['MontoCotSaludExtra'];
					//si no hay nada
					}else{
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'] = 0;
					}

					//MUTUAL
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_id']         = $trab['idMutual'];          //idMutual
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Nombre']     = $trab['MutualNombre'];      //MutualNombre
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Porcentaje'] = $trab['MutualPorcentaje'];  //MutualPorcentaje
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Valor']      = ($Sueldo_Imp/100)*$trab['MutualPorcentaje'];

					//TRABAJO PESADO
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Id']          = $trab['idTipoTrabajo'];            //idTipoTrabajo
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Porcentaje']  = $trab['PorcentajeTrabajoPesado'];  //Porcentaje Trabajo Pesado
					//si es trabajo pesado
					if(isset($trab['idTipoTrabajo'])&&$trab['idTipoTrabajo']==2){
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Valor'] = ($Sueldo_Imp/100)*$trab['PorcentajeTrabajoPesado'];
					}else{
						$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajoPesado_Valor'] = 0;
					}

					//Se suman todos los descuentos
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_Total'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['AFP_Total'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Salud_CotizacionValor'];
					//$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Mutual_Valor'];

					//Calculo Total Bonos Fijos(100 tipos bonos estimados en el sistema)
					for ($x = 0; $x <= 100; $x++) {
						//verifico si existe
						if(isset($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'])){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'];
						}
					}

					//Recorro la tabla para establecer el valor del seguro de cesantia
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] = 0;
					foreach ($arrSeguro as $seguro) {
						//Si el seguro es el mismo
						if($trab['idTipoContrato']==$seguro['idTipoContrato']){
							if($Sueldo_Imp<$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']){
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  =($Sueldo_Imp/100)*$seguro['Porc_Empleador'];
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] =($Sueldo_Imp/100)*$seguro['Porc_Trabajador'];
							}else{
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Empleador']  =($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']/100)*$seguro['Porc_Empleador'];
								$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'] =($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']/100)*$seguro['Porc_Trabajador'];
							}
						}
					}
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SegCesantia_Trabajador'];

					//Calculo del impuesto a la renta
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SueldoImponible'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'];
					foreach ($arrImpuestoRenta as $imp_renta) {
						//Verifico si el sueldo afecto esta dentro de los limites
						if(($imp_renta['UTM_Desde'] * $_SESSION['fact_sueldos_basicos']['UTM'])<=$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta']&&$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta']<=($imp_renta['UTM_Hasta'] * $_SESSION['fact_sueldos_basicos']['UTM'])){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'] = ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['RentaAfecta'] * $imp_renta['Tasa'])-($_SESSION['fact_sueldos_basicos']['UTM'] * $imp_renta['Rebaja']);
						}
					}
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['ImpuestoRenta'];

					//Calculo de los otros descuentos
					if(!empty($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Anticipo'])){
						foreach ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Anticipo'] as $key => $producto){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $producto['Monto'];
						}
					}
					if(!empty($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cuotas'])){
						foreach ($_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['Cuotas'] as $key => $producto){
							$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'] + $producto['monto_cuotas'];
						}
					}

					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalAPagar'] = 0;
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalAPagar'] = $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalHaberes'] - $_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TotalDescuentos'];

					/***********************************************************/
					/*                    No Guardables                        */
					/***********************************************************/
					//Datos del trabajador
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorNombre']    = $trab['ApellidoPat'].' '.$trab['ApellidoMat'].' '.$trab['Nombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorRut']       = $trab['Rut'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorEmail']     = $trab['email'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorContrato']  = $trab['F_Inicio_Contrato'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['TrabajadorCargo']     = $trab['Cargo'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SistemaNombre']       = $trab['SistemaNombre'];
					$_SESSION['fact_sueldos_sueldos'][$trab['idTrabajador']]['SistemaRut']          = $trab['SistemaRut'];

				}

				//redirijo
				header( 'Location: '.$location.'&view=true' );
				die;

			}

		break;

/*******************************************************************************************************************/

		case 'del_trab':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Borro todas las sesiones
			unset($_SESSION['fact_sueldos_sueldos'][$_GET['del_trab']]);

			header( 'Location: '.$location.'&view=true' );
			die;

		break;
/*******************************************************************************************************************/
		case 'new_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//se inicializa variable
			$idInterno = 0;

			//verificar la cantidad de trabajos
			if(isset($_SESSION['fact_sueldos_archivos'])){
				foreach ($_SESSION['fact_sueldos_archivos'] as $key => $trabajos){
					if($idInterno<$trabajos['idFile']){$idInterno = $trabajos['idFile'];}
				}
			}

			if(empty($error)){

				//Se verifica
				if(isset($_FILES["exFile"])){
					if ($_FILES["exFile"]["error"] > 0){
						$error['exFile'] = 'error/'.uploadPHPError($_FILES["exFile"]["error"]);
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("application/msword",
											"application/vnd.ms-word",
											"application/vnd.openxmlformats-officedocument.wordprocessingml.document",

											"application/msexcel",
											"application/vnd.ms-excel",
											"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",

											"application/mspowerpoint",
											"application/vnd.ms-powerpoint",
											"application/vnd.openxmlformats-officedocument.presentationml.presentation",

											"application/pdf",
											"application/octet-stream",
											"application/x-real",
											"application/vnd.adobe.xfdf",
											"application/vnd.fdf",
											"binary/octet-stream",

											"image/jpg",
											"image/jpeg",
											"image/gif",
											"image/png"

											);
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 10000;
						//Sufijo
						$sufijo = 'sueldo_fact_'.genera_password_unica().'_';

						if (in_array($_FILES['exFile']['type'], $permitidos) && $_FILES['exFile']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = "upload/".$sufijo.$_FILES['exFile']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$move_result = @move_uploaded_file($_FILES["exFile"]["tmp_name"], $ruta);
								if ($move_result){

									//se guarda en el indice siguiente
									$idInterno = $idInterno+1;
									//Se guarda el trabajo asignado
									$_SESSION['fact_sueldos_archivos'][$idInterno]['idFile'] = $idInterno;
									$_SESSION['fact_sueldos_archivos'][$idInterno]['Nombre'] = $sufijo.$_FILES['exFile']['name'];

									header( 'Location: '.$location.'&view=true' );
									die;

								}else {
									$error['exFile']     = 'error/Ocurrio un error al mover el archivo';
								}
							} else {
								$error['exFile']     = 'error/El archivo '.$_FILES['exFile']['name'].' ya existe';
							}
						} else {
							$error['exFile']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido';
						}
					}
				}

			}

		break;

/*******************************************************************************************************************/
		case 'del_file':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			try {
				if(!is_writable('upload/'.$_SESSION['fact_sueldos_archivos'][$_GET['del_file']]['Nombre'])){
					//throw new Exception('File not writable');
				}else{
					unlink('upload/'.$_SESSION['fact_sueldos_archivos'][$_GET['del_file']]['Nombre']);
					unset($_SESSION['fact_sueldos_archivos'][$_GET['del_file']]);
				}
			}catch(Exception $e) {
					//guardar el dato en un archivo log
			}

			//redirijo
			header( 'Location: '.$location.'&view=true' );
			die;


		break;
/*******************************************************************************************************************/
		case 'ing_sueldo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*********************************************************************/
			//variables
			$n_data1 = 0;
			$n_data2 = 0;

			//verificacion de errores
			//Datos basicos
			if (isset($_SESSION['fact_sueldos_basicos'])){
				if(!isset($_SESSION['fact_sueldos_basicos']['idSistema']) OR $_SESSION['fact_sueldos_basicos']['idSistema']=='' ){               $error['idSistema']         = 'error/No ha seleccionado el sistema';}
				if(!isset($_SESSION['fact_sueldos_basicos']['idUsuario']) OR $_SESSION['fact_sueldos_basicos']['idUsuario']=='' ){               $error['idUsuario']         = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['fact_sueldos_basicos']['fecha_auto']) OR $_SESSION['fact_sueldos_basicos']['fecha_auto']=='' ){             $error['fecha_auto']        = 'error/No ha ingresado la fecha auto';}
				if(!isset($_SESSION['fact_sueldos_basicos']['Creacion_fecha']) OR $_SESSION['fact_sueldos_basicos']['Creacion_fecha']=='' ){     $error['Creacion_fecha']    = 'error/No ha ingresado la fecha de creación';}
				if(!isset($_SESSION['fact_sueldos_basicos']['Fecha_desde']) OR $_SESSION['fact_sueldos_basicos']['Fecha_desde']=='' ){           $error['Fecha_desde']       = 'error/No ha ingresado la fecha de inicio de facturacion';}
				if(!isset($_SESSION['fact_sueldos_basicos']['Fecha_hasta']) OR $_SESSION['fact_sueldos_basicos']['Fecha_hasta']=='' ){           $error['Fecha_hasta']       = 'error/No ha ingresado la fecha de termino de facturacion';}
				if(!isset($_SESSION['fact_sueldos_basicos']['Observaciones']) OR $_SESSION['fact_sueldos_basicos']['Observaciones']=='' ){       $error['Observaciones']     = 'error/No ha ingresado la observacion';}
				if(!isset($_SESSION['fact_sueldos_basicos']['UF']) OR $_SESSION['fact_sueldos_basicos']['UF']=='' ){                             $error['UF']                = 'error/No ha ingresado la UF';}
				if(!isset($_SESSION['fact_sueldos_basicos']['UTM']) OR $_SESSION['fact_sueldos_basicos']['UTM']=='' ){                           $error['UTM']               = 'error/No ha ingresado la UTM';}
				if(!isset($_SESSION['fact_sueldos_basicos']['IMM']) OR $_SESSION['fact_sueldos_basicos']['IMM']=='' ){                           $error['IMM']               = 'error/No ha ingresado la IMM';}
				if(!isset($_SESSION['fact_sueldos_basicos']['TopeImpAFP']) OR $_SESSION['fact_sueldos_basicos']['TopeImpAFP']=='' ){             $error['TopeImpAFP']        = 'error/No ha ingresado el Tope AFP';}
				if(!isset($_SESSION['fact_sueldos_basicos']['TopeImpIPS']) OR $_SESSION['fact_sueldos_basicos']['TopeImpIPS']=='' ){             $error['TopeImpIPS']        = 'error/No ha ingresado el Tope IPS';}
				if(!isset($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']) OR $_SESSION['fact_sueldos_basicos']['TopeSegCesantia']=='' ){   $error['TopeSegCesantia']   = 'error/No ha ingresado el Tope Seguro Cesantia';}
				if(!isset($_SESSION['fact_sueldos_basicos']['TopeAPVMensual']) OR $_SESSION['fact_sueldos_basicos']['TopeAPVMensual']=='' ){     $error['TopeAPVMensual']    = 'error/No ha ingresado el Tope APV Mensual';}
				if(!isset($_SESSION['fact_sueldos_basicos']['TopeDepConv']) OR $_SESSION['fact_sueldos_basicos']['TopeDepConv']=='' ){           $error['TopeDepConv']       = 'error/No ha ingresado el Tope Deposito Convenido';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados al ingreso de bodega';
			}

			if(!isset($_SESSION['fact_sueldos_sueldos'])){
				$error['impuesto']  = 'error/No se han seleccionado trabajadores';
			}
			//Se verifican que existan trabajadores
			$n_data = 0;
			if (isset($_SESSION['fact_sueldos_sueldos'])){
				foreach ($_SESSION['fact_sueldos_sueldos'] as $key => $producto){
					$n_data++;
				}
			}
			if(isset($n_data)&&$n_data==0){
				$error['trabajos'] = 'error/No se han seleccionado trabajadores';
			}

			/*********************************************************************/
			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//Se guardan los datos basicos
				if(isset($_SESSION['fact_sueldos_basicos']['idSistema']) && $_SESSION['fact_sueldos_basicos']['idSistema']!=''){      $SIS_data  = "'".$_SESSION['fact_sueldos_basicos']['idSistema']."'";   }else{$SIS_data  = "''";}
				if(isset($_SESSION['fact_sueldos_basicos']['idUsuario']) && $_SESSION['fact_sueldos_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['fecha_auto']) && $_SESSION['fact_sueldos_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['Creacion_fecha']) && $_SESSION['fact_sueldos_basicos']['Creacion_fecha']!=''){
					$SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Creacion_fecha']."'";
					$SIS_data .= ",'".fecha2NSemana($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2NMes($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
					$SIS_data .= ",'".fecha2Ano($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
				}else{
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
					$SIS_data .= ",''";
				}
				if(isset($_SESSION['fact_sueldos_basicos']['Fecha_desde']) && $_SESSION['fact_sueldos_basicos']['Fecha_desde']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_desde']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['Fecha_hasta']) && $_SESSION['fact_sueldos_basicos']['Fecha_hasta']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_hasta']."'";      }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['Observaciones']) && $_SESSION['fact_sueldos_basicos']['Observaciones']!=''){     $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Observaciones']."'";    }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['UF']) && $_SESSION['fact_sueldos_basicos']['UF']!=''){                           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['UF']."'";               }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['UTM']) && $_SESSION['fact_sueldos_basicos']['UTM']!=''){                         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['UTM']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['IMM']) && $_SESSION['fact_sueldos_basicos']['IMM']!=''){                         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['IMM']."'";              }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['TopeImpAFP']) && $_SESSION['fact_sueldos_basicos']['TopeImpAFP']!=''){           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeImpAFP']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['TopeImpIPS']) && $_SESSION['fact_sueldos_basicos']['TopeImpIPS']!=''){           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeImpIPS']."'";       }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']) && $_SESSION['fact_sueldos_basicos']['TopeSegCesantia']!=''){ $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']."'";  }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['TopeAPVMensual']) && $_SESSION['fact_sueldos_basicos']['TopeAPVMensual']!=''){   $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']."'";   }else{$SIS_data .= ",''";}
				if(isset($_SESSION['fact_sueldos_basicos']['TopeDepConv']) && $_SESSION['fact_sueldos_basicos']['TopeDepConv']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeDepConv']."'";      }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema, idUsuario, fecha_auto, Creacion_fecha,
				Creacion_Semana, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta, Observaciones, UF, UTM, IMM,
				TopeImpAFP, TopeImpIPS, TopeSegCesantia, TopeAPVMensual, TopeDepConv';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					/*********************************************************************/
					//Se guardan los datos de los productos
					if(isset($_SESSION['fact_sueldos_sueldos'])){
						foreach ($_SESSION['fact_sueldos_sueldos'] as $key => $producto){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                              $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['fact_sueldos_basicos']['idSistema']) && $_SESSION['fact_sueldos_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['idUsuario']) && $_SESSION['fact_sueldos_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['fecha_auto']) && $_SESSION['fact_sueldos_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['Creacion_fecha']) && $_SESSION['fact_sueldos_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['fact_sueldos_basicos']['Fecha_desde']) && $_SESSION['fact_sueldos_basicos']['Fecha_desde']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_desde']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['Fecha_hasta']) && $_SESSION['fact_sueldos_basicos']['Fecha_hasta']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_hasta']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['Observaciones']) && $_SESSION['fact_sueldos_basicos']['Observaciones']!=''){     $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Observaciones']."'";    }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['UF']) && $_SESSION['fact_sueldos_basicos']['UF']!=''){                           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['UF']."'";               }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['UTM']) && $_SESSION['fact_sueldos_basicos']['UTM']!=''){                         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['UTM']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['IMM']) && $_SESSION['fact_sueldos_basicos']['IMM']!=''){                         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['IMM']."'";              }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['TopeImpAFP']) && $_SESSION['fact_sueldos_basicos']['TopeImpAFP']!=''){           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeImpAFP']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['TopeImpIPS']) && $_SESSION['fact_sueldos_basicos']['TopeImpIPS']!=''){           $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeImpIPS']."'";       }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['TopeSegCesantia']) && $_SESSION['fact_sueldos_basicos']['TopeSegCesantia']!=''){ $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeSegCesantia']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['TopeAPVMensual']) && $_SESSION['fact_sueldos_basicos']['TopeAPVMensual']!=''){   $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeAPVMensual']."'";   }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['TopeDepConv']) && $_SESSION['fact_sueldos_basicos']['TopeDepConv']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['TopeDepConv']."'";      }else{$SIS_data .= ",''";}

							if(isset($producto['idTrabajador']) && $producto['idTrabajador']!=''){                              $SIS_data .= ",'".$producto['idTrabajador']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['idTipoContratoTrab']) && $producto['idTipoContratoTrab']!=''){                  $SIS_data .= ",'".$producto['idTipoContratoTrab']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['TipoContratoTrab']) && $producto['TipoContratoTrab']!=''){                      $SIS_data .= ",'".$producto['TipoContratoTrab']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['horas_pactadas']) && $producto['horas_pactadas']!=''){                          $SIS_data .= ",'".$producto['horas_pactadas']."'";                }else{$SIS_data .= ",''";}
							if(isset($producto['Gratificacion']) && $producto['Gratificacion']!=''){                            $SIS_data .= ",'".$producto['Gratificacion']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajadorNombre']) && $producto['TrabajadorNombre']!=''){                      $SIS_data .= ",'".$producto['TrabajadorNombre']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajadorRut']) && $producto['TrabajadorRut']!=''){                            $SIS_data .= ",'".$producto['TrabajadorRut']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajadorEmail']) && $producto['TrabajadorEmail']!=''){                        $SIS_data .= ",'".$producto['TrabajadorEmail']."'";               }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajadorContrato']) && $producto['TrabajadorContrato']!=''){                  $SIS_data .= ",'".$producto['TrabajadorContrato']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajadorCargo']) && $producto['TrabajadorCargo']!=''){                        $SIS_data .= ",'".$producto['TrabajadorCargo']."'";               }else{$SIS_data .= ",''";}
							if(isset($producto['SistemaNombre']) && $producto['SistemaNombre']!=''){                            $SIS_data .= ",'".$producto['SistemaNombre']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['SistemaRut']) && $producto['SistemaRut']!=''){                                  $SIS_data .= ",'".$producto['SistemaRut']."'";                    }else{$SIS_data .= ",''";}
							if(isset($producto['SueldoPactado']) && $producto['SueldoPactado']!=''){                            $SIS_data .= ",'".$producto['SueldoPactado']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['DiasPactados']) && $producto['DiasPactados']!=''){                              $SIS_data .= ",'".$producto['DiasPactados']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['DiasTrabajados']) && $producto['DiasTrabajados']!=''){                          $SIS_data .= ",'".$producto['DiasTrabajados']."'";                }else{$SIS_data .= ",''";}
							if(isset($producto['diasInasistencia']) && $producto['diasInasistencia']!=''){                      $SIS_data .= ",'".$producto['diasInasistencia']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['diasLicencias']) && $producto['diasLicencias']!=''){                            $SIS_data .= ",'".$producto['diasLicencias']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['SueldoPagado']) && $producto['SueldoPagado']!=''){                              $SIS_data .= ",'".$producto['SueldoPagado']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['TotalBonoFijoAfecto']) && $producto['TotalBonoFijoAfecto']!=''){                $SIS_data .= ",'".$producto['TotalBonoFijoAfecto']."'";           }else{$SIS_data .= ",''";}
							if(isset($producto['TotalBonoFijoNoAfecto']) && $producto['TotalBonoFijoNoAfecto']!=''){            $SIS_data .= ",'".$producto['TotalBonoFijoNoAfecto']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['TotalBonoTurno']) && $producto['TotalBonoTurno']!=''){                          $SIS_data .= ",'".$producto['TotalBonoTurno']."'";                }else{$SIS_data .= ",''";}
							if(isset($producto['TotalBonoTemporalAfecto']) && $producto['TotalBonoTemporalAfecto']!=''){        $SIS_data .= ",'".$producto['TotalBonoTemporalAfecto']."'";       }else{$SIS_data .= ",''";}
							if(isset($producto['TotalBonoTemporalNoAfecto']) && $producto['TotalBonoTemporalNoAfecto']!=''){    $SIS_data .= ",'".$producto['TotalBonoTemporalNoAfecto']."'";     }else{$SIS_data .= ",''";}
							if(isset($producto['TotalHorasExtras']) && $producto['TotalHorasExtras']!=''){                      $SIS_data .= ",'".$producto['TotalHorasExtras']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['Cargas_n']) && $producto['Cargas_n']!=''){                                      $SIS_data .= ",'".$producto['Cargas_n']."'";                      }else{$SIS_data .= ",''";}
							if(isset($producto['Cargas_valor']) && $producto['Cargas_valor']!=''){                              $SIS_data .= ",'".$producto['Cargas_valor']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['Cargas_idTramo']) && $producto['Cargas_idTramo']!=''){                          $SIS_data .= ",'".$producto['Cargas_idTramo']."'";                }else{$SIS_data .= ",''";}
							if(isset($producto['Cargas_tramo']) && $producto['Cargas_tramo']!=''){                              $SIS_data .= ",'".$producto['Cargas_tramo']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['TotalCargasFamiliares']) && $producto['TotalCargasFamiliares']!=''){            $SIS_data .= ",'".$producto['TotalCargasFamiliares']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['SueldoImponible']) && $producto['SueldoImponible']!=''){                        $SIS_data .= ",'".$producto['SueldoImponible']."'";               }else{$SIS_data .= ",''";}
							if(isset($producto['SueldoNoImponible']) && $producto['SueldoNoImponible']!=''){                    $SIS_data .= ",'".$producto['SueldoNoImponible']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['TotalHaberes']) && $producto['TotalHaberes']!=''){                              $SIS_data .= ",'".$producto['TotalHaberes']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['AFP_idAFP']) && $producto['AFP_idAFP']!=''){                                    $SIS_data .= ",'".$producto['AFP_idAFP']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['AFP_Nombre']) && $producto['AFP_Nombre']!=''){                                  $SIS_data .= ",'".$producto['AFP_Nombre']."'";                    }else{$SIS_data .= ",''";}
							if(isset($producto['AFP_Porcentaje']) && $producto['AFP_Porcentaje']!=''){                          $SIS_data .= ",'".$producto['AFP_Porcentaje']."'";                }else{$SIS_data .= ",''";}
							if(isset($producto['AFP_Total']) && $producto['AFP_Total']!=''){                                    $SIS_data .= ",'".$producto['AFP_Total']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['AFP_SIS']) && $producto['AFP_SIS']!=''){                                        $SIS_data .= ",'".$producto['AFP_SIS']."'";                       }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_idAFP']) && $producto['Salud_idAFP']!=''){                                $SIS_data .= ",'".$producto['Salud_idAFP']."'";                   }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_Nombre']) && $producto['Salud_Nombre']!=''){                              $SIS_data .= ",'".$producto['Salud_Nombre']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_Porcentaje']) && $producto['Salud_Porcentaje']!=''){                      $SIS_data .= ",'".$producto['Salud_Porcentaje']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_Total']) && $producto['Salud_Total']!=''){                                $SIS_data .= ",'".$producto['Salud_Total']."'";                   }else{$SIS_data .= ",''";}
							if(isset($producto['TotalDescuentos']) && $producto['TotalDescuentos']!=''){                        $SIS_data .= ",'".$producto['TotalDescuentos']."'";               }else{$SIS_data .= ",''";}
							if(isset($producto['SegCesantia_Empleador']) && $producto['SegCesantia_Empleador']!=''){            $SIS_data .= ",'".$producto['SegCesantia_Empleador']."'";         }else{$SIS_data .= ",''";}
							if(isset($producto['SegCesantia_Trabajador']) && $producto['SegCesantia_Trabajador']!=''){          $SIS_data .= ",'".$producto['SegCesantia_Trabajador']."'";        }else{$SIS_data .= ",''";}
							if(isset($producto['ImpuestoRenta']) && $producto['ImpuestoRenta']!=''){                            $SIS_data .= ",'".$producto['ImpuestoRenta']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['RentaAfecta']) && $producto['RentaAfecta']!=''){                                $SIS_data .= ",'".$producto['RentaAfecta']."'";                   }else{$SIS_data .= ",''";}
							if(isset($producto['TotalAPagar']) && $producto['TotalAPagar']!=''){                                $SIS_data .= ",'".$producto['TotalAPagar']."'";                   }else{$SIS_data .= ",''";}
							if(isset($producto['idCentroCosto']) && $producto['idCentroCosto']!=''){                            $SIS_data .= ",'".$producto['idCentroCosto']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_1']) && $producto['idLevel_1']!=''){                                    $SIS_data .= ",'".$producto['idLevel_1']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_2']) && $producto['idLevel_2']!=''){                                    $SIS_data .= ",'".$producto['idLevel_2']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_3']) && $producto['idLevel_3']!=''){                                    $SIS_data .= ",'".$producto['idLevel_3']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_4']) && $producto['idLevel_4']!=''){                                    $SIS_data .= ",'".$producto['idLevel_4']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['idLevel_5']) && $producto['idLevel_5']!=''){                                    $SIS_data .= ",'".$producto['idLevel_5']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['CentroCosto']) && $producto['CentroCosto']!=''){                                $SIS_data .= ",'".$producto['CentroCosto']."'";                   }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajoPesado_Id']) && $producto['TrabajoPesado_Id']!=''){                      $SIS_data .= ",'".$producto['TrabajoPesado_Id']."'";              }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajoPesado_Porcentaje']) && $producto['TrabajoPesado_Porcentaje']!=''){      $SIS_data .= ",'".$producto['TrabajoPesado_Porcentaje']."'";      }else{$SIS_data .= ",''";}
							if(isset($producto['TrabajoPesado_Valor']) && $producto['TrabajoPesado_Valor']!=''){                $SIS_data .= ",'".$producto['TrabajoPesado_Valor']."'";           }else{$SIS_data .= ",''";}
							if(isset($producto['Mutual_id']) && $producto['Mutual_id']!=''){                                    $SIS_data .= ",'".$producto['Mutual_id']."'";                     }else{$SIS_data .= ",''";}
							if(isset($producto['Mutual_Nombre']) && $producto['Mutual_Nombre']!=''){                            $SIS_data .= ",'".$producto['Mutual_Nombre']."'";                 }else{$SIS_data .= ",''";}
							if(isset($producto['Mutual_Porcentaje']) && $producto['Mutual_Porcentaje']!=''){                    $SIS_data .= ",'".$producto['Mutual_Porcentaje']."'";             }else{$SIS_data .= ",''";}
							if(isset($producto['Mutual_Valor']) && $producto['Mutual_Valor']!=''){                              $SIS_data .= ",'".$producto['Mutual_Valor']."'";                  }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_idCotizacion']) && $producto['Salud_idCotizacion']!=''){                  $SIS_data .= ",'".$producto['Salud_idCotizacion']."'";            }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_CotizacionPorcentaje']) && $producto['Salud_CotizacionPorcentaje']!=''){  $SIS_data .= ",'".$producto['Salud_CotizacionPorcentaje']."'";    }else{$SIS_data .= ",''";}
							if(isset($producto['Salud_CotizacionValor']) && $producto['Salud_CotizacionValor']!=''){            $SIS_data .= ",'".$producto['Salud_CotizacionValor']."'";         }else{$SIS_data .= ",''";}
							$SIS_data .= ",'1'";//estado no pagado

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha,
							Creacion_Semana, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta, Observaciones, UF, UTM, IMM,
							TopeImpAFP, TopeImpIPS, TopeSegCesantia, TopeAPVMensual, TopeDepConv,idTrabajador,idTipoContratoTrab,TipoContratoTrab,
							horas_pactadas,Gratificacion,TrabajadorNombre,TrabajadorRut,TrabajadorEmail,TrabajadorContrato,
							TrabajadorCargo,SistemaNombre,SistemaRut,SueldoPactado,DiasPactados,DiasTrabajados,diasInasistencia,
							diasLicencias,SueldoPagado,TotalBonoFijoAfecto,TotalBonoFijoNoAfecto,TotalBonoTurno,
							TotalBonoTemporalAfecto,TotalBonoTemporalNoAfecto,TotalHorasExtras,Cargas_n,Cargas_valor,
							Cargas_idTramo,Cargas_tramo,TotalCargasFamiliares,SueldoImponible,SueldoNoImponible,
							TotalHaberes,AFP_idAFP,AFP_Nombre,AFP_Porcentaje,AFP_Total,AFP_SIS,Salud_idAFP,
							Salud_Nombre,Salud_Porcentaje,Salud_Total ,TotalDescuentos,SegCesantia_Empleador,
							SegCesantia_Trabajador,ImpuestoRenta,RentaAfecta,TotalAPagar, idCentroCosto, idLevel_1,
							idLevel_2, idLevel_3, idLevel_4, idLevel_5, CentroCosto, idTipoTrabajo,PorcentajeTrabajoPesado,
							TrabajoPesado,idMutual,MutualNombre,MutualPorcentaje,MutualValor,Salud_idCotizacion,
							Salud_CotizacionPorcentaje,Salud_CotizacionValor, idEstado';
							$ultimo_idmain = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

							/*****************************************************************************/
							//Bonos Fijos
							for ($x = 0; $x <= 100; $x++) {
								//verifico si existe
								if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoTipo'])){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                                                                                                                                                            $SIS_data  = "'".$ultimo_idmain."'";                                                                                 }else{$SIS_data  = "''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['idBonoFijo']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['idBonoFijo']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['idBonoFijo']."'";    }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoNombre']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoNombre']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoNombre']."'";    }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoMonto']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoMonto']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoMonto']."'";     }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoTipo']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoTipo']!=''){        $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoFijo'][$x]['BonoTipo']."'";      }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, idBonoFijo, BonoNombre,BonoMonto, BonoTipo';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_bonofijo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//Bonos por turno
							for ($x = 0; $x <= 6; $x++) {
								//verifico si existe
								if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoMonto'])&&$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoMonto']!=0){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                                                                                                                                                              $SIS_data  = "'".$ultimo_idmain."'";                                                                                  }else{$SIS_data  = "''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['idTurnos']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['idTurnos']!=''){ $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['idTurnos']."'";      }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoNombre']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoNombre']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoNombre']."'";    }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoMonto']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoMonto']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTurno'][$x]['BonoMonto']."'";     }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, idTurnos, BonoNombre,BonoMonto';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_bonoturno', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//Bonos Temporales
							for ($x = 0; $x <= 100; $x++) {
								//verifico si existe
								if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoTipo'])){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                                                                                                                                                                            $SIS_data  = "'".$ultimo_idmain."'";                                                                                       }else{$SIS_data  = "''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['idBonoTemporal']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['idBonoTemporal']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['idBonoTemporal']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoNombre']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoNombre']!=''){     $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoNombre']."'";      }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoMonto']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoMonto']!=''){       $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoMonto']."'";       }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']!=''){         $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['BonoTemporal'][$x]['BonoTipo']."'";        }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, idBonoTemporal, BonoNombre,BonoMonto, BonoTipo';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_bonotemporal', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//Horas extras
							for ($x = 0; $x <= 31; $x++) {
								//verifico si existe
								if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['N_Horas'])&&$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['N_Horas']!=0){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                                                                                                                                                                     $SIS_data  = "'".$ultimo_idmain."'";                                                                                    }else{$SIS_data  = "''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['idPorcentaje']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['idPorcentaje']!=''){   $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['idPorcentaje']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['Porcentaje']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['Porcentaje']!=''){$SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['Porcentaje']."'";    }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['N_Horas']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['N_Horas']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['N_Horas']."'";       }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['ValorHora']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['ValorHora']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['ValorHora']."'";     }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['TotalHora']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['TotalHora']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['HorasExtras'][$x]['TotalHora']."'";     }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, idPorcentaje, Porcentaje, N_Horas, ValorHora, TotalHora';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_horasextras', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//Descuentos previsionales
							for ($x = 0; $x <= 100; $x++) {
								//verifico si existe
								if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto'])&&$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']!=''){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                                                                                                                                                                              $SIS_data  = "'".$ultimo_idmain."'";                                                                                         }else{$SIS_data  = "''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['idDescuentoFijo']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['idDescuentoFijo']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['idDescuentoFijo']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoNombre']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoNombre']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoNombre']."'";  }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoMonto']."'";   }else{$SIS_data .= ",''";}
									if(isset($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoIDAFP']) && $_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoIDAFP']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['DescuentoFijo'][$x]['DescuentoIDAFP']."'";   }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, idDescuentoFijo, DescuentoNombre,DescuentoMonto, DescuentoIDAFP';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_descuentofijo', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//anticipos
							if(!empty($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['Anticipo'])){
								foreach ($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['Anticipo'] as $key => $anticipo){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                              $SIS_data  = "'".$ultimo_idmain."'";                 }else{$SIS_data  = "''";}
									if(isset($anticipo['Creacion_fecha']) && $anticipo['Creacion_fecha']!=''){    $SIS_data .= ",'".$anticipo['Creacion_fecha']."'";   }else{$SIS_data .= ",''";}
									if(isset($anticipo['Monto']) && $anticipo['Monto']!=''){                      $SIS_data .= ",'".$anticipo['Monto']."'";            }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, Creacion_fecha, Monto';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_anticipos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*****************************************************************************/
							//Cuotas
							if(!empty($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['Cuotas'])){
								foreach ($_SESSION['fact_sueldos_sueldos'][$producto['idTrabajador']]['Cuotas'] as $key => $cuotas){
									//filtros
									if(isset($ultimo_idmain) && $ultimo_idmain!=''){                    $SIS_data  = "'".$ultimo_idmain."'";            }else{$SIS_data  = "''";}
									if(isset($cuotas['Fecha']) && $cuotas['Fecha']!=''){                $SIS_data .= ",'".$cuotas['Fecha']."'";         }else{$SIS_data .= ",''";}
									if(isset($cuotas['nCuota']) && $cuotas['nCuota']!=''){              $SIS_data .= ",'".$cuotas['nCuota']."'";        }else{$SIS_data .= ",''";}
									if(isset($cuotas['TotalCuotas']) && $cuotas['TotalCuotas']!=''){    $SIS_data .= ",'".$cuotas['TotalCuotas']."'";   }else{$SIS_data .= ",''";}
									if(isset($cuotas['monto_cuotas']) && $cuotas['monto_cuotas']!=''){  $SIS_data .= ",'".$cuotas['monto_cuotas']."'";  }else{$SIS_data .= ",''";}
									if(isset($cuotas['Tipo']) && $cuotas['Tipo']!=''){                  $SIS_data .= ",'".$cuotas['Tipo']."'";          }else{$SIS_data .= ",''";}

									// inserto los datos de registro en la db
									$SIS_columns = 'idFactTrab, Fecha, nCuota, TotalCuotas, monto_cuotas, Tipo';
									$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_trabajadores_descuentos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

								}
							}

							/*********************************************************************************/
							/*                      SE ACTUALIZAN LOS DATOS UTILIZADOS                       */
							/*********************************************************************************/
							//filtro
							$SIS_data = "idUso='2'";
							$SIS_data .= ",idFactRRHH='".$ultimo_id."'";

							/****************************************************/
							//Inasistencias
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_inasistencias_dias', 'idTrabajador = "'.$producto['idTrabajador'].'" AND  idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Licencias
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_licencias', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Fecha_inicio BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Bonos por turno
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_horas_extras_facturacion_turnos', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Bonos temporales
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_bonos_temporales', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Horas extras
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_horas_extras_mensuales_facturacion_horas', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Anticipos
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_descuentos_anticipos', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Creacion_fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							/****************************************************/
							//Descuento Cuota
							$resultado = db_update_data (false, $SIS_data, 'trabajadores_descuentos_cuotas_listado', 'idTrabajador = "'.$producto['idTrabajador'].'" AND idUso=1 AND Fecha BETWEEN "'.$_SESSION['fact_sueldos_basicos']['Fecha_desde'].'" AND "'.$_SESSION['fact_sueldos_basicos']['Fecha_hasta'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Archivos
					if(isset($_SESSION['insumos_ing_archivos'])){
						foreach ($_SESSION['insumos_ing_archivos'] as $key => $archivo){

							//filtros
							if(isset($ultimo_id) && $ultimo_id!=''){                                                                              $SIS_data  = "'".$ultimo_id."'";                                       }else{$SIS_data  = "''";}
							if(isset($_SESSION['fact_sueldos_basicos']['idSistema']) && $_SESSION['fact_sueldos_basicos']['idSistema']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['idSistema']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['idUsuario']) && $_SESSION['fact_sueldos_basicos']['idUsuario']!=''){      $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['idUsuario']."'";  }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['fecha_auto']) && $_SESSION['fact_sueldos_basicos']['fecha_auto']!=''){    $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['fecha_auto']."'"; }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['Creacion_fecha']) && $_SESSION['fact_sueldos_basicos']['Creacion_fecha']!=''){
								$SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Creacion_fecha']."'";
								$SIS_data .= ",'".fecha2NSemana($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2NMes($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
								$SIS_data .= ",'".fecha2Ano($_SESSION['fact_sueldos_basicos']['Creacion_fecha'])."'";
							}else{
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
								$SIS_data .= ",''";
							}
							if(isset($_SESSION['fact_sueldos_basicos']['Fecha_desde']) && $_SESSION['fact_sueldos_basicos']['Fecha_desde']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_desde']."'";      }else{$SIS_data .= ",''";}
							if(isset($_SESSION['fact_sueldos_basicos']['Fecha_hasta']) && $_SESSION['fact_sueldos_basicos']['Fecha_hasta']!=''){  $SIS_data .= ",'".$_SESSION['fact_sueldos_basicos']['Fecha_hasta']."'";      }else{$SIS_data .= ",''";}
							if(isset($archivo['Nombre']) && $archivo['Nombre']!=''){                                                              $SIS_data .= ",'".$archivo['Nombre']."'";                                    }else{$SIS_data .= ",''";}

							// inserto los datos de registro en la db
							$SIS_columns = 'idFacturacion, idSistema, idUsuario, fecha_auto, Creacion_fecha, Creacion_Semana, Creacion_mes, Creacion_ano, Fecha_desde, Fecha_hasta, Nombre';
							$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'rrhh_sueldos_facturacion_archivos', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						}
					}

					/*********************************************************************/
					//Borro todas las sesiones una vez grabados los datos
					//Borro todas las sesiones
					unset($_SESSION['fact_sueldos_basicos']);
					unset($_SESSION['fact_sueldos_sueldos']);
					unset($_SESSION['fact_sueldos_temporal']);
					unset($_SESSION['fact_sueldos_archivos']);
					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}

			}

		break;
/*******************************************************************************************************************/
	}

?>
