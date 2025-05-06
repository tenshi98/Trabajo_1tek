<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "informe_cross_shipping_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search ='&submit_filter=Filtrar';
if(isset($_GET['CTNNombreCompañia'])&&$_GET['CTNNombreCompañia']!=''){$location .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];       $search .= "&CTNNombreCompañia=".$_GET['CTNNombreCompañia'];}
if(isset($_GET['NInforme'])&&$_GET['NInforme']!=''){                   $location .="&NInforme=".$_GET['NInforme'];                          $search .="&NInforme=".$_GET['NInforme'];}
if(isset($_GET['Creacion_fechaDesde'])&&$_GET['Creacion_fechaDesde']!=''){    $location .="&Creacion_fechaDesde=".$_GET['Creacion_fechaDesde'];    $search .="&Creacion_fechaDesde=".$_GET['Creacion_fechaDesde'];}
if(isset($_GET['Creacion_fechaHasta'])&&$_GET['Creacion_fechaHasta']!=''){    $location .="&Creacion_fechaHasta=".$_GET['Creacion_fechaHasta'];    $search .="&Creacion_fechaHasta=".$_GET['Creacion_fechaHasta'];}
if(isset($_GET['FechaInicioEmbarque'])&&$_GET['FechaInicioEmbarque']!=''){    $location .="&FechaInicioEmbarque=".$_GET['FechaInicioEmbarque'];    $search .="&FechaInicioEmbarque=".$_GET['FechaInicioEmbarque'];}
if(isset($_GET['HoraInicioCarga'])&&$_GET['HoraInicioCarga']!=''){     $location .="&HoraInicioCarga=".$_GET['HoraInicioCarga'];            $search .="&HoraInicioCarga=".$_GET['HoraInicioCarga'];}
if(isset($_GET['FechaTerminoEmbarque'])&&$_GET['FechaTerminoEmbarque']!=''){  $location .="&FechaTerminoEmbarque=".$_GET['FechaTerminoEmbarque'];  $search .="&FechaTerminoEmbarque=".$_GET['FechaTerminoEmbarque'];}
if(isset($_GET['HoraTerminoCarga'])&&$_GET['HoraTerminoCarga']!=''){   $location .="&HoraTerminoCarga=".$_GET['HoraTerminoCarga'];          $search .="&HoraTerminoCarga=".$_GET['HoraTerminoCarga'];}
if(isset($_GET['idPlantaDespacho'])&&$_GET['idPlantaDespacho']!=''){   $location .="&idPlantaDespacho=".$_GET['idPlantaDespacho'];          $search .="&idPlantaDespacho=".$_GET['idPlantaDespacho'];}
if(isset($_GET['idCategoria'])&&$_GET['idCategoria']!=''){             $location .="&idCategoria=".$_GET['idCategoria'];                    $search .="&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto'])&&$_GET['idProducto']!=''){               $location .="&idProducto=".$_GET['idProducto'];                      $search .="&idProducto=".$_GET['idProducto'];}
if(isset($_GET['CantidadCajas'])&&$_GET['CantidadCajas']!=''){         $location .="&CantidadCajas=".$_GET['CantidadCajas'];                $search .="&CantidadCajas=".$_GET['CantidadCajas'];}
if(isset($_GET['idInstructivo'])&&$_GET['idInstructivo']!=''){         $location .="&idInstructivo=".$_GET['idInstructivo'];                $search .="&idInstructivo=".$_GET['idInstructivo'];}
if(isset($_GET['idNaviera'])&&$_GET['idNaviera']!=''){                 $location .="&idNaviera=".$_GET['idNaviera'];                        $search .="&idNaviera=".$_GET['idNaviera'];}
if(isset($_GET['idPuertoEmbarque'])&&$_GET['idPuertoEmbarque']!=''){   $location .="&idPuertoEmbarque=".$_GET['idPuertoEmbarque'];          $search .="&idPuertoEmbarque=".$_GET['idPuertoEmbarque'];}
if(isset($_GET['idMercado'])&&$_GET['idMercado']!=''){                 $location .="&idMercado=".$_GET['idMercado'];                        $search .="&idMercado=".$_GET['idMercado'];}
if(isset($_GET['idPais'])&&$_GET['idPais']!=''){                       $location .="&idPais=".$_GET['idPais'];                              $search .="&idPais=".$_GET['idPais'];}
if(isset($_GET['idEmpresaTransporte'])&&$_GET['idEmpresaTransporte']!=''){    $location .="&idEmpresaTransporte=".$_GET['idEmpresaTransporte'];    $search .="&idEmpresaTransporte=".$_GET['idEmpresaTransporte'];}
if(isset($_GET['ChoferNombreRut'])&&$_GET['ChoferNombreRut']!=''){     $location .="&ChoferNombreRut=".$_GET['ChoferNombreRut'];            $search .="&ChoferNombreRut=".$_GET['ChoferNombreRut'];}
if(isset($_GET['PatenteCamion'])&&$_GET['PatenteCamion']!=''){         $location .="&PatenteCamion=".$_GET['PatenteCamion'];                $search .="&PatenteCamion=".$_GET['PatenteCamion'];}
if(isset($_GET['PatenteCarro'])&&$_GET['PatenteCarro']!=''){           $location .="&PatenteCarro=".$_GET['PatenteCarro'];                  $search .="&PatenteCarro=".$_GET['PatenteCarro'];}
if(isset($_GET['idCondicion'])&&$_GET['idCondicion']!=''){             $location .="&idCondicion=".$_GET['idCondicion'];                    $search .="&idCondicion=".$_GET['idCondicion'];}
if(isset($_GET['idSellado'])&&$_GET['idSellado']!=''){                 $location .="&idSellado=".$_GET['idSellado'];                        $search .="&idSellado=".$_GET['idSellado'];}
if(isset($_GET['TSetPoint'])&&$_GET['TSetPoint']!=''){                 $location .="&TSetPoint=".$_GET['TSetPoint'];                        $search .="&TSetPoint=".$_GET['TSetPoint'];}
if(isset($_GET['TVentilacion'])&&$_GET['TVentilacion']!=''){           $location .="&TVentilacion=".$_GET['TVentilacion'];                  $search .="&TVentilacion=".$_GET['TVentilacion'];}
if(isset($_GET['TAmbiente'])&&$_GET['TAmbiente']!=''){                 $location .="&TAmbiente=".$_GET['TAmbiente'];                        $search .="&TAmbiente=".$_GET['TAmbiente'];}
if(isset($_GET['NumeroSello'])&&$_GET['NumeroSello']!=''){             $location .="&NumeroSello=".$_GET['NumeroSello'];                    $search .="&NumeroSello=".$_GET['NumeroSello'];}
if(isset($_GET['idInspector'])&&$_GET['idInspector']!=''){             $location .="&idInspector=".$_GET['idInspector'];                    $search .="&idInspector=".$_GET['idInspector'];}
if(isset($_GET['Observaciones'])&&$_GET['Observaciones']!=''){         $location .="&Observaciones=".$_GET['Observaciones'];                $search .="&Observaciones=".$_GET['Observaciones'];}
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){                 $location .="&idSistema=".$_GET['idSistema'];                        $search .="&idSistema=".$_GET['idSistema'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){                   $location .="&idEstado=".$_GET['idEstado'];                          $search .="&idEstado=".$_GET['idEstado'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
//Variable con la ubicacion
$SIS_where = "cross_shipping_consolidacion.idConsolidacion!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['CTNNombreCompañia'])&&$_GET['CTNNombreCompañia']!=''){  $SIS_where .=" AND cross_shipping_consolidacion.CTNNombreCompañia LIKE '%".EstandarizarInput($_GET['CTNNombreCompañia'])."%'";}
if(isset($_GET['NInforme'])&&$_GET['NInforme']!=''){                    $SIS_where .=" AND cross_shipping_consolidacion.NInforme LIKE '%".EstandarizarInput($_GET['NInforme'])."%'";}
if(isset($_GET['FechaInicioEmbarque'])&&$_GET['FechaInicioEmbarque']!=''){     $SIS_where .=" AND cross_shipping_consolidacion.FechaInicioEmbarque='".$_GET['FechaInicioEmbarque']."'";}
if(isset($_GET['HoraInicioCarga'])&&$_GET['HoraInicioCarga']!=''){      $SIS_where .=" AND cross_shipping_consolidacion.HoraInicioCarga='".$_GET['HoraInicioCarga']."'";}
if(isset($_GET['FechaTerminoEmbarque'])&&$_GET['FechaTerminoEmbarque']!=''){   $SIS_where .=" AND cross_shipping_consolidacion.FechaTerminoEmbarque='".$_GET['FechaTerminoEmbarque']."'";}
if(isset($_GET['HoraTerminoCarga'])&&$_GET['HoraTerminoCarga']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.HoraTerminoCarga='".$_GET['HoraTerminoCarga']."'";}
if(isset($_GET['idPlantaDespacho'])&&$_GET['idPlantaDespacho']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.idPlantaDespacho=".$_GET['idPlantaDespacho'];}
if(isset($_GET['idCategoria'])&&$_GET['idCategoria']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto'])&&$_GET['idProducto']!=''){                $SIS_where .=" AND cross_shipping_consolidacion.idProducto=".$_GET['idProducto'];}
if(isset($_GET['CantidadCajas'])&&$_GET['CantidadCajas']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.CantidadCajas LIKE '%".EstandarizarInput($_GET['CantidadCajas'])."%'";}
if(isset($_GET['idInstructivo'])&&$_GET['idInstructivo']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.idInstructivo=".$_GET['idInstructivo'];}
if(isset($_GET['idNaviera'])&&$_GET['idNaviera']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idNaviera=".$_GET['idNaviera'];}
if(isset($_GET['idPuertoEmbarque'])&&$_GET['idPuertoEmbarque']!=''){    $SIS_where .=" AND cross_shipping_consolidacion.idPuertoEmbarque=".$_GET['idPuertoEmbarque'];}
if(isset($_GET['idMercado'])&&$_GET['idMercado']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idMercado=".$_GET['idMercado'];}
if(isset($_GET['idPais'])&&$_GET['idPais']!=''){                        $SIS_where .=" AND cross_shipping_consolidacion.idPais=".$_GET['idPais'];}
if(isset($_GET['idEmpresaTransporte'])&&$_GET['idEmpresaTransporte']!=''){     $SIS_where .=" AND cross_shipping_consolidacion.idEmpresaTransporte=".$_GET['idEmpresaTransporte'];}
if(isset($_GET['ChoferNombreRut'])&&$_GET['ChoferNombreRut']!=''){      $SIS_where .=" AND cross_shipping_consolidacion.ChoferNombreRut LIKE '%".EstandarizarInput($_GET['ChoferNombreRut'])."%'";}
if(isset($_GET['PatenteCamion'])&&$_GET['PatenteCamion']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.PatenteCamion LIKE '%".EstandarizarInput($_GET['PatenteCamion'])."%'";}
if(isset($_GET['PatenteCarro'])&&$_GET['PatenteCarro']!=''){            $SIS_where .=" AND cross_shipping_consolidacion.PatenteCarro LIKE '%".EstandarizarInput($_GET['PatenteCarro'])."%'";}
if(isset($_GET['idCondicion'])&&$_GET['idCondicion']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idCondicion=".$_GET['idCondicion'];}
if(isset($_GET['idSellado'])&&$_GET['idSellado']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idSellado=".$_GET['idSellado'];}
if(isset($_GET['TSetPoint'])&&$_GET['TSetPoint']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.TSetPoint=".$_GET['TSetPoint'];}
if(isset($_GET['TVentilacion'])&&$_GET['TVentilacion']!=''){            $SIS_where .=" AND cross_shipping_consolidacion.TVentilacion=".$_GET['TVentilacion'];}
if(isset($_GET['TAmbiente'])&&$_GET['TAmbiente']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.TAmbiente=".$_GET['TAmbiente'];}
if(isset($_GET['NumeroSello'])&&$_GET['NumeroSello']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.NumeroSello LIKE '%".EstandarizarInput($_GET['NumeroSello'])."%'";}
if(isset($_GET['idInspector'])&&$_GET['idInspector']!=''){              $SIS_where .=" AND cross_shipping_consolidacion.idInspector=".$_GET['idInspector'];}
if(isset($_GET['Observaciones'])&&$_GET['Observaciones']!=''){          $SIS_where .=" AND cross_shipping_consolidacion.Observaciones LIKE '%".EstandarizarInput($_GET['Observaciones'])."%'";}
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''){                  $SIS_where .=" AND cross_shipping_consolidacion.idSistema=".$_GET['idSistema'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){                    $SIS_where .=" AND cross_shipping_consolidacion.idEstado=".$_GET['idEstado'];}

if(isset($_GET['Creacion_fechaDesde']) && $_GET['Creacion_fechaDesde'] != ''&&isset($_GET['Creacion_fechaHasta']) && $_GET['Creacion_fechaHasta']!=''){
	$SIS_where .= " AND cross_shipping_consolidacion.Creacion_fecha BETWEEN '".$_GET['Creacion_fechaDesde']."' AND '".$_GET['Creacion_fechaHasta']."'";
}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idEstibaListado', 'cross_shipping_consolidacion_estibas', 'LEFT JOIN `cross_shipping_consolidacion` ON cross_shipping_consolidacion.idConsolidacion = cross_shipping_consolidacion_estibas.idConsolidacion', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
/*******************************************************/
// consulto los datos
$SIS_query = '
cross_shipping_consolidacion.idConsolidacion,
cross_shipping_consolidacion.Creacion_fecha,
cross_shipping_consolidacion.CTNNombreCompañia,
usuarios_listado.Nombre AS Usuario,
core_sistemas.Nombre AS Sistema,
sistema_variedades_categorias.Nombre AS ProductoCategoria,
variedades_listado.Nombre AS ProductoNombre,
core_estibas.Nombre AS Estiba,
core_estibas_ubicacion.Nombre AS EstibaUbicacion,
core_cross_shipping_consolidacion_posicion.Nombre AS Posicion';
$SIS_join  = '
LEFT JOIN `cross_shipping_consolidacion`                  ON cross_shipping_consolidacion.idConsolidacion             = cross_shipping_consolidacion_estibas.idConsolidacion
LEFT JOIN `usuarios_listado`                              ON usuarios_listado.idUsuario                               = cross_shipping_consolidacion.idUsuario
LEFT JOIN `core_sistemas`                                 ON core_sistemas.idSistema                                  = cross_shipping_consolidacion.idSistema
LEFT JOIN `sistema_variedades_categorias`                 ON sistema_variedades_categorias.idCategoria                = cross_shipping_consolidacion.idCategoria
LEFT JOIN `variedades_listado`                            ON variedades_listado.idProducto                            = cross_shipping_consolidacion.idProducto
LEFT JOIN `core_estibas`                                  ON core_estibas.idEstiba                                    = cross_shipping_consolidacion_estibas.idEstiba
LEFT JOIN `core_estibas_ubicacion`                        ON core_estibas_ubicacion.idEstibaUbicacion                 = cross_shipping_consolidacion_estibas.idEstibaUbicacion
LEFT JOIN `core_cross_shipping_consolidacion_posicion`    ON core_cross_shipping_consolidacion_posicion.idPosicion    = cross_shipping_consolidacion_estibas.idPosicion';
$SIS_order = 'cross_shipping_consolidacion.Creacion_fecha ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'cross_shipping_consolidacion_estibas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<?php
	$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	?>		
	<a target="new" href="<?php echo 'informe_cross_shipping_01_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado Consolidaciones</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Fecha del informe</th>
						<th>Contenedor Nro.</th>
						<th>Categoria - Producto</th>
						<th>Estiba</th>
						<th>Ubicación</th>
						<th>Posicion</th>
						<th>Creador</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
						<td><?php echo $tipo['CTNNombreCompañia']; ?></td>
						<td><?php echo $tipo['ProductoCategoria'].' - '.$tipo['ProductoNombre']; ?></td>
						<td><?php echo $tipo['Estiba']; ?></td>
						<td><?php echo $tipo['EstibaUbicacion']; ?></td>
						<td><?php echo $tipo['Posicion']; ?></td>
						<td><?php echo $tipo['Usuario']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_cross_shipping_consolidacion.php?view='.simpleEncode($tipo['idConsolidacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z="idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idEstado)){              $xz  = $idEstado;              }else{$xz  = '';}
				if(isset($CTNNombreCompañia)){     $x0  = $CTNNombreCompañia;     }else{$x0  = '';}
				if(isset($NInforme)){              $x1  = $NInforme;              }else{$x1  = '';}
				if(isset($Creacion_fechaDesde)){   $x2  = $Creacion_fechaDesde;   }else{$x2  = '';}
				if(isset($Creacion_fechaHasta)){   $x3  = $Creacion_fechaHasta;   }else{$x3  = '';}
				if(isset($FechaInicioEmbarque)){   $x4  = $FechaInicioEmbarque;   }else{$x4  = '';}
				if(isset($HoraInicioCarga)){       $x5  = $HoraInicioCarga;       }else{$x5  = '';}
				if(isset($FechaTerminoEmbarque)){  $x6  = $FechaTerminoEmbarque;  }else{$x6  = '';}
				if(isset($HoraTerminoCarga)){      $x7  = $HoraTerminoCarga;      }else{$x7  = '';}
				if(isset($idPlantaDespacho)){      $x8  = $idPlantaDespacho;      }else{$x8  = '';}
				if(isset($idCategoria)){           $x9  = $idCategoria;           }else{$x9  = '';}
				if(isset($idProducto)){            $x10 = $idProducto;            }else{$x10 = '';}
				if(isset($CantidadCajas)){         $x11 = $CantidadCajas;         }else{$x11 = '';}
				if(isset($idInstructivo)){         $x12 = $idInstructivo;         }else{$x12 = '';}
				if(isset($idNaviera)){             $x13 = $idNaviera;             }else{$x13 = '';}
				if(isset($idPuertoEmbarque)){      $x14 = $idPuertoEmbarque;      }else{$x14 = '';}
				if(isset($idMercado)){             $x15 = $idMercado;             }else{$x15 = '';}
				if(isset($idPais)){                $x16 = $idPais;                }else{$x16 = '';}
				if(isset($idEmpresaTransporte)){   $x17 = $idEmpresaTransporte;   }else{$x17 = '';}
				if(isset($ChoferNombreRut)){       $x18 = $ChoferNombreRut;       }else{$x18 = '';}
				if(isset($PatenteCamion)){         $x19 = $PatenteCamion;         }else{$x19 = '';}
				if(isset($PatenteCarro)){          $x20 = $PatenteCarro;          }else{$x20 = '';}
				if(isset($idCondicion)){           $x21 = $idCondicion;           }else{$x21 = '';}
				if(isset($idSellado)){             $x22 = $idSellado;             }else{$x22 = '';}
				if(isset($TSetPoint)){             $x23 = $TSetPoint;             }else{$x23 = '';}
				if(isset($TVentilacion)){          $x24 = $TVentilacion;          }else{$x24 = '';}
				if(isset($TAmbiente)){             $x25 = $TAmbiente;             }else{$x25 = '';}
				if(isset($NumeroSello)){           $x26 = $NumeroSello;           }else{$x26 = '';}
				if(isset($idInspector)){           $x27 = $idInspector;           }else{$x27 = '';}
				if(isset($Observaciones)){         $x28 = $Observaciones;         }else{$x28 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Cuerpo Indentificacion');
				$Form_Inputs->form_select('Estado','idEstado', $xz, 2, 'idEstado', 'Nombre', 'core_oc_estado', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Contenedor Nro.', 'CTNNombreCompañia', $x0, 1);
				$Form_Inputs->form_input_number_integer('Nro. Del Informe', 'NInforme', $x1, 1);
				$Form_Inputs->form_date('Fecha del informe Desde','Creacion_fechaDesde', $x2, 1);
				$Form_Inputs->form_date('Fecha del informe Hasta','Creacion_fechaHasta', $x3, 1);
				$Form_Inputs->form_date('Fecha Inicio del Embarque','FechaInicioEmbarque', $x4, 1);
				$Form_Inputs->form_time('Hora Inicio Carga','HoraInicioCarga', $x5, 1, 1, 24);
				$Form_Inputs->form_date('Fecha Termino del Embarque','FechaTerminoEmbarque', $x6, 1);
				$Form_Inputs->form_time('Hora Termino Carga','HoraTerminoCarga', $x7, 1, 1, 24);
				$Form_Inputs->form_select_filter('Planta Despachadora','idPlantaDespacho', $x8, 1, 'idPlantaDespacho', 'Codigo,Nombre', 'cross_shipping_plantas', $z, '', $dbConn);
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x9, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x10, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_input_number_integer('Cantidad de Cajas', 'CantidadCajas', $x11, 1);
				$Form_Inputs->form_select_filter('N° Instructivo','idInstructivo', $x12, 1, 'idInstructivo', 'Codigo,Nombre', 'cross_shipping_instructivo', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Naviera','idNaviera', $x13, 1, 'idNaviera', 'Codigo,Nombre', 'cross_shipping_naviera', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Puerto Embarque','idPuertoEmbarque', $x14, 1, 'idPuertoEmbarque', 'Codigo,Nombre', 'cross_shipping_puerto_embarque', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Mercado','idMercado', $x15, 1, 'idMercado', 'Codigo,Nombre', 'cross_shipping_mercado', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Pais','idPais', $x16, 1, 'idPais', 'Nombre', 'core_paises', 0, '', $dbConn);

				$Form_Inputs->form_tittle(3, 'Cuerpo Indentificacion Empresa Transportista');
				$Form_Inputs->form_select_filter('Empresa Transporte','idEmpresaTransporte', $x17, 1, 'idEmpresaTransporte', 'Nombre', 'cross_shipping_empresa_transporte', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Conductor', 'ChoferNombreRut', $x18, 1);
				$Form_Inputs->form_input_text('Patente Camion', 'PatenteCamion', $x19, 1);
				$Form_Inputs->form_input_text('Patente Carro', 'PatenteCarro', $x20, 1);

				$Form_Inputs->form_tittle(3, 'Cuerpo Parametros Evaluados');
				$Form_Inputs->form_select('Condición CTN','idCondicion', $x21, 1, 'idCondicion', 'Nombre', 'core_cross_shipping_consolidacion_condicion', 0, '', $dbConn);
				$Form_Inputs->form_select('Sellado Piso','idSellado', $x22, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
				$Form_Inputs->form_input_number('T° Set Point', 'TSetPoint', $x23, 1);
				$Form_Inputs->form_input_number('T° Ventilacion', 'TVentilacion', $x24, 1);
				$Form_Inputs->form_input_number('T° Ambiente', 'TAmbiente', $x25, 1);
				$Form_Inputs->form_input_text('Numero de sello', 'NumeroSello', $x26, 1);
				$Form_Inputs->form_select_filter('Inspector','idInspector', $x27, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
