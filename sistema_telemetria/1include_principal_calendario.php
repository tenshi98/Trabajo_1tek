<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
if(isset($rowlevel['level'])&&$rowlevel['level']!=''){
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
}
// consulto los datos
$SIS_query = 'Fecha, Titulo, Cuerpo, idSistema,idOpciones';
$SIS_join  = '';
$SIS_where = 'idCalendario = '.$_GET['id'];
$rowData = db_select_data (false, $SIS_query, 'principal_calendario_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación de la Agenda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){      $x1 = $Fecha;       }else{$x1 = $rowData['Fecha'];}
				if(isset($Titulo)){     $x2 = $Titulo;      }else{$x2 = $rowData['Titulo'];}
				if(isset($Cuerpo)){     $x3 = $Cuerpo;      }else{$x3 = $rowData['Cuerpo'];}
				if(isset($idOpciones)){ $x4 = $idOpciones;  }else{$x4 = $rowData['idOpciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha del Evento','Fecha', $x1, 2);
				$Form_Inputs->form_input_text('Título', 'Titulo', $x2, 2);
				$Form_Inputs->form_ckeditor('Detalle','Cuerpo', $x3, 2, 2);
				$Form_Inputs->form_post_data(2,1,1, '<strong>Tipo de evento: </strong>En el caso de que sea un evento publico, todos pueden verlo, en caso de que no sea un evento publico, solo podra verlo quien lo creo.' );
				$Form_Inputs->form_select('Es un evento Publico','idOpciones', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idUsuario9999', 9999, 2);
				$Form_Inputs->form_input_hidden('idCalendario', $_GET['id'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $location.'&view='.$_GET['id']; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){
//consulto
$SIS_query = '
principal_calendario_listado.Fecha,
principal_calendario_listado.Titulo,
principal_calendario_listado.Cuerpo,
usuarios_listado.Nombre AS Autor,
principal_calendario_listado.idUsuario';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = principal_calendario_listado.idUsuario';
$SIS_where = 'principal_calendario_listado.idCalendario = '.$_GET['view'];
$rowData = db_select_data (false, $SIS_query, 'principal_calendario_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Evento</h5>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="margin-bottom:5px;">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/calendario.jpg">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary">Datos de la Agenda</h2>
						<p class="text-muted">
							<strong>Autor: </strong><?php if($rowData['idUsuario']!=9999){echo $rowData['Autor'];}else{echo 'Sistema';} ?><br/>
							<strong>Titulo: </strong><?php echo $rowData['Titulo']; ?><br/>
							<strong>Fecha: </strong><?php echo fecha_estandar($rowData['Fecha']); ?>
						</p>

						<h2 class="text-primary">Mensaje</h2>
						<div class="text-muted" style="white-space: normal;">
							<?php echo $rowData['Cuerpo']; ?>
						</div>

						<?php if ($rowData['idUsuario']!=9999){ ?>
							<div class="form-group">
								<a href="<?php echo $location.'&id='.$_GET["view"]; ?>" class="btn btn-default pull-right margin_width" >Editar Evento</a>
								<?php
								$ubicacion = $location.'&del='.simpleEncode($_GET['view'], fecha_actual());
								$dialogo   = '¿Realmente deseas eliminar el registro?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn" ><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Evento</a>
							</div>
						<?php } ?>

					</div>
					<div class="clearfix" style="margin-bottom:5px;"></div>

				</div>
			</div>
        </div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
if(isset($rowlevel['level'])&&$rowlevel['level']!=''){
	validaPermisoUser($rowlevel['level'], 3, $dbConn);
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear evento</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Fecha)){       $x1 = $Fecha;       }else{$x1 = '';}
				if(isset($Titulo)){      $x2 = $Titulo;      }else{$x2 = '';}
				if(isset($Cuerpo)){      $x3 = $Cuerpo;      }else{$x3 = '';}
				if(isset($idOpciones)){  $x4 = $idOpciones;  }else{$x4 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha del Evento','Fecha', $x1, 2);
				$Form_Inputs->form_input_text('Título', 'Titulo', $x2, 2);
				$Form_Inputs->form_ckeditor('Detalle','Cuerpo', $x3, 2, 2);
				$Form_Inputs->form_post_data(2,1,1, '<strong>Tipo de evento: </strong>En el caso de que sea un evento publico, todos pueden verlo, en caso de que no sea un evento publico, solo podra verlo quien lo creo.' );
				$Form_Inputs->form_select('Es un evento Publico','idOpciones', $x4, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('idUsuario9999', 9999, 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Crear Evento" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Se definen las variables
if(isset($_GET['Mes'])){   $Mes = $_GET['Mes'];   } else { $Mes  = mes_actual();}
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}
$diaActual = dia_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7;
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));

//Traigo los eventos guardados en la base de datos
$SIS_query = 'idCalendario, Titulo, Dia, idUsuario';
$SIS_join  = '';
$SIS_where = '(idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].' OR idUsuario=9999) AND Ano='.$Ano.' AND Mes='.$Mes.' AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'Fecha ASC';
$arrEventos = array();
$arrEventos = db_select_array (false, $SIS_query, 'principal_calendario_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEventos');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<a href="<?php echo $location.'&new=true'; ?>" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evento</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<h5>Agenda General</h5>
		</header>

		<div id="calendar_content" class="body">
			<div id="calendar" class="fc fc-ltr">

				<table class="fc-header" style="width:100%">
					<tbody>
						<tr>
							<?php
							if(isset($_GET['Ano'])){
								$Ano_a  = $_GET['Ano'];
								$Ano_b  = $_GET['Ano'];
							} else {
								$Ano_a  = date("Y");
								$Ano_b  = date("Y");
							}
							if (($Mes-1)==0){$mes_atras=12;   $Ano_a=$Ano_a-1;}else{$mes_atras=$Mes-1; }
							if (($Mes+1)==13) {$mes_adelante=1; $Ano_b=$Ano_b+1;}else{$mes_adelante=$Mes+1; }
							?>
							<td class="fc-header-left"><a href="<?php echo $original.'?Mes='.$mes_atras.'&Ano='.$Ano_a ?>" class="btn btn-default"><i class="fa fa-angle-left faa-horizontal animated" aria-hidden="true"></i></a></td>
							<td class="fc-header-center"><span class="fc-header-title"><h2><?php echo numero_a_mes($Mes)." ".$Ano?></h2></span></td>
							<td class="fc-header-right"><a href="<?php echo $original.'?Mes='.$mes_adelante.'&Ano='.$Ano_b ?>" class="btn btn-default"><i class="fa fa-angle-right faa-horizontal animated" aria-hidden="true"></i></a></td>
						</tr>
					</tbody>
				</table>

				<div class="fc-content" style="position: relative;margin-left: -10px;margin-right: -10px;">
					<div class="fc-view fc-view-Mes fc-grid" style="position:relative" unselectable="on">

						<table class="fc-border-separate correct_border" style="width:100%" cellspacing="0">
							<thead>
								<tr class="fc-first fc-last">
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Lunes</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Martes</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Miercoles</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Jueves</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Viernes</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Sabado</th>
									<th class="fc-day-header fc-sun fc-widget-header" width="14%">Domingo</th>
								</tr>
							</thead>
							<tbody>
								<tr class="fc-week">
									<?php
									$last_cell = $diaSemana + $ultimoDiaMes;
									// hacemos un bucle hasta 42, que es el máximo de valores que puede
									// haber... 6 columnas de 7 dias
									for($i=1;$i<=42;$i++){
										// determinamos en que dia empieza
										if($i==$diaSemana){
											$Dia=1;
										}
										// celca vacia
										if($i<$diaSemana || $i>=$last_cell){
											echo "<td class='fc-Dia fc-wed fc-widget-content fc-other-Mes fc-future fc-state-none'> </td>";
										// mostramos el dia
										}else{ ?>
											<td class="fc-Dia fc-sun fc-widget-content fc-past fc-first <?php if($Dia==$diaActual){ echo 'fc-state-highlight';} ?>">
												<div class="calendar_min">
													<div class="fc-Dia-number"><?php echo $Dia; ?></div>
													<div class="fc-Dia-content">
														<?php foreach ($arrEventos as $evento) {
															if ($evento['Dia']==$Dia) {
																$ver = $location.'&view='.$evento['idCalendario'];
																if ($evento['idUsuario']==9999){
																	echo '<a class="event_calendar evcal_color2 word_break" href="'.$ver.'">'.cortar('Administrador : '.$evento['Titulo'], 20).'</a>';
																}else{
																	echo '<a class="event_calendar evcal_color1 word_break" href="'.$ver.'">'.cortar($evento['Titulo'], 20).'</a>';
																}
															}
														} ?>
													</div>
												</div>
											</td>
											<?php
											$Dia++;
										}
										// cuando llega al final de la semana, iniciamos una columna nueva
										if($i%7==0){
											echo "</tr><tr class='fc-week'>\n";
										}
									}
									?>
								</tr>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>
