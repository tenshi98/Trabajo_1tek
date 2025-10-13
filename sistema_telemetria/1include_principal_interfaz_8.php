<?php
/*****************************************************************************************************************/
/*                                               Transacciones                                                   */
/*****************************************************************************************************************/
//Tipo de usuario
$idTipoUsuario  = $_SESSION['usuario']['basic_data']['idTipoUsuario'];
$SemanaAnterior  = restarDias(fecha_actual(),7);

//variable de numero de permiso
$x_nperm = 0;

//permisos a las transacciones
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_clientes_listado.php";           //01 - Administrar Vecinos
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_publicaciones_eventos.php";      //02 - Publicaciones - Eventos
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_publicaciones_peligros.php";     //03 - Publicaciones - Zonas de Peligro
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_reportes_comment_listado.php";   //04 - Reportes - Comentarios
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_clientes_infracciones.php";      //05 - Reportes - Infracciones
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_reportes_post_listado.php";      //06 - Reportes - Post
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_lista_bloqueo.php";              //07 - Seguridad - Bloqueos de IP
$x_nperm++; $trans[$x_nperm] = "seg_vecinal_intento_hackeo.php";             //08 - Seguridad - Intentos de Hackeo

//Genero los permisos
for ($i = 1; $i <= $x_nperm; $i++) {
	//Seteo la variable a 0
	$prm_x[$i] = 0;
	//recorro los permisos
	if(isset($_SESSION['usuario']['menu'])){
		foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
			foreach($productos as $producto) {
				//elimino los datos extras
				$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
				//le asigno el valor 1 en caso de que exista
				if($trans[$i]==$str){
					$prm_x[$i] = 1;
				}
			}
		}
	}
}
/*****************************************************************************************************************/
/*                                                Subconsultas                                                   */
/*****************************************************************************************************************/
//Variables
$subquery       = '';
$z  = " idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

/*Administrar Vecinos*/               if($prm_x[1]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idCliente)    FROM seg_vecinal_clientes_listado          WHERE idEstado=1 AND ".$z." LIMIT 1) AS Count_1";}
/*Publicaciones - Eventos*/           if($prm_x[2]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idEvento)     FROM seg_vecinal_eventos_listado           WHERE Fecha>='".$SemanaAnterior."' AND ".$z." LIMIT 1) AS Count_2";}
/*Publicaciones - Zonas de Peligro*/  if($prm_x[3]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idPeligro)    FROM seg_vecinal_peligros_listado          WHERE idEstado=1 AND ".$z." LIMIT 1) AS Count_3";}
/*Reportes - Comentarios*/            if($prm_x[4]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idReportes)   FROM seg_vecinal_reportes_comment_listado  WHERE idRevisado=1 AND ".$z." LIMIT 1) AS Count_4";}
/*Reportes - Infracciones*/           if($prm_x[5]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idInfraccion) FROM seg_vecinal_clientes_infracciones     WHERE idEstado=1 AND ".$z." LIMIT 1) AS Count_5";}
/*Reportes - Post*/                   if($prm_x[6]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idReportes)   FROM seg_vecinal_reportes_post_listado     WHERE idRevisado=1 AND ".$z." LIMIT 1) AS Count_6";}
/*Seguridad - Bloqueos de IP*/        if($prm_x[7]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idBloqueo)    FROM sistema_seguridad_bloqueo_ip          WHERE idBloqueo!=0 AND ".$z." LIMIT 1) AS Count_7";}
/*Seguridad - Intentos de Hackeo*/    if($prm_x[8]=='1' OR $idTipoUsuario==1) {$subquery .= ",(SELECT COUNT(idHacking)    FROM sistema_seguridad_hacking             WHERE idHacking!=0 AND ".$z." LIMIT 1) AS Count_8";}


/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = '
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
core_ubicacion_comunas.Wheater AS Wheater'.$subquery;
$SIS_join  = '
LEFT JOIN core_ubicacion_ciudad    ON core_ubicacion_ciudad.idCiudad    = core_sistemas.idCiudad
LEFT JOIN core_ubicacion_comunas   ON core_ubicacion_comunas.idComuna   = core_sistemas.idComuna';
$SIS_where = 'core_sistemas.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$subconsulta = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'subconsulta');
									
?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php
		/***************************************************************/
		echo '
		<div class="panel-heading">
			<h3 class="supertittle text-primary">Pendientes de Chequeo</h3>
		</div>';
			
		echo '<div class="row">';
			echo widget_Ficha_1('bg-purple', 'fa-users', 100, 'Clientes', $subconsulta['Count_1'].' Clientes Activos', 'seg_vecinal_clientes_listado.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-green', 'fa-flag', 100, 'Publicaciones', $subconsulta['Count_2'].' Eventos', 'seg_vecinal_publicaciones_eventos.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-yellow', 'fa-exclamation-triangle', 100, 'Publicaciones', $subconsulta['Count_3'].' Zonas de Peligro', 'seg_vecinal_publicaciones_peligros.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-aqua', 'fa-comments-o', 100, 'Reportes', $subconsulta['Count_4'].' Comentarios', 'seg_vecinal_reportes_comment_listado.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-black', 'fa-ban', 100, 'Reportes', $subconsulta['Count_5'].' Infracciones', 'seg_vecinal_clientes_infracciones.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-red', 'fa-comment-o', 100, 'Reportes', $subconsulta['Count_6'].' Post', 'seg_vecinal_reportes_post_listado.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-ocean_boat_blue', 'fa-asterisk', 100, 'Seguridad', $subconsulta['Count_7'].' Bloqueos de IP', 'seg_vecinal_lista_bloqueo.php?pagina=1', 'Ver Pendientes', 2,1);
			echo widget_Ficha_1('bg-pastel_blue', 'fa-user-secret', 100, 'Seguridad', $subconsulta['Count_8'].' Intentos de Hackeo', 'seg_vecinal_intento_hackeo.php?pagina=1', 'Ver Pendientes', 2,1);
		echo '</div>';						
														
		?>

	</div>
</div>
