<div class="media user-media">
    <div class="user-media-toggleHover">
        <i class="fa fa-user" aria-hidden="true"></i>
    </div>
    <div class="user-wrapper">
        <a class="user-link" href="principal_datos.php">
        <?php if ($_SESSION['usuario']['basic_data']['Direccion_img']=='') { ?>
        	<img class="media-object img-thumbnail user-img" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
        <?php }else{  ?>
        	<img class="media-object img-thumbnail user-img" alt="Imagen Referencia" src="upload/<?php echo $_SESSION['usuario']['basic_data']['Direccion_img']; ?>">
        <?php } ?>
        </a>
        <div class="media-body">
            <h5 class="media-heading"><?php echo $_SESSION['usuario']['basic_data']['Nombre'] ?></h5>
            <ul class="list-unstyled user-info">
                <li> <a href="principal_datos.php"><?php echo $_SESSION['usuario']['basic_data']['Usuario_Tipo'] ?></a></li>
				<li>
					Ultimo Acceso :<br/>
					<small><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
						<?php echo fecha2NdiaMes($_SESSION['usuario']['basic_data']['FechaLogin']).' '.fecha2NombreMesCorto($_SESSION['usuario']['basic_data']['FechaLogin']).' '.Hora_estandar($_SESSION['usuario']['basic_data']['HoraLogin']); ?>
					</small>
				</li>
			</ul>
      </div>
  </div>
</div>
