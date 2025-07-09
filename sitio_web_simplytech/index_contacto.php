<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-006).');
}

?>

<section id="contacto" class="contact">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<?php
			if(isset($rowData['Contact_Tittle'])&&$rowData['Contact_Tittle']!=''){    echo '<h2 data-aos="fade-up">'.$rowData['Contact_Tittle'].'</h2>';}
			if(isset($rowData['Contact_Tittle_body'])&&$rowData['Contact_Tittle_body']!=''){ echo '<p data-aos="fade-up">'.$rowData['Contact_Tittle_body'].'</p>';}
			?>
		</div>

		<div class="row" data-aos="fade-up" data-aos-delay="100">
			<div class="my-3">
				<?php
				//Alertas
				if(isset($_GET['sended'])&&$_GET['sended']!=''){
					echo '<div class="alert alert-success" role="alert">Mensaje correctamente enviado</div>';
				}
				if(isset($_GET['error'])&&$_GET['error']!=''){
					echo '<div class="alert alert-danger" role="alert">Mensaje no pudo ser enviado</div>';
				}
				if(isset($_GET['dataerror'])&&$_GET['dataerror']!=''){
					echo '<div class="alert alert-warning" role="alert">Revise los campos obligatorios</div>';
				}
				?>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="row">

					<?php if(isset($rowData['Contact_Address_tittle'])&&$rowData['Contact_Address_tittle']!=''){ ?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="info-box">
								<i class="bx bx-map"></i>
								<h3><?php echo $rowData['Contact_Address_tittle']; ?></h3>
								<p><?php echo $rowData['Contact_Address_body']; ?></p>
							</div>
						</div>
					<?php } ?>

					<?php if(isset($rowData['Contact_Email_tittle'])&&$rowData['Contact_Email_tittle']!=''){ ?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4">
							<div class="info-box">
								<i class="bx bx-envelope"></i>
								<h3><?php echo $rowData['Contact_Email_tittle']; ?></h3>
								<p><?php echo $rowData['Contact_Email_body']; ?></p>
							</div>
						</div>
					<?php } ?>

					<?php if(isset($rowData['Contact_Phone_tittle'])&&$rowData['Contact_Phone_tittle']!=''){ ?>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 mt-4">
							<div class="info-box">
								<i class="bx bx-phone-call"></i>
								<h3><?php echo $rowData['Contact_Phone_tittle']; ?></h3>
								<p><?php echo $rowData['Contact_Phone_body']; ?></p>
							</div>
						</div>
					<?php } ?>

				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<form method="post" role="form" class="php-email-form">
					<div class="row">
						<div class="col form-group">
							<input type="text" name="De_nombre" class="form-control" id="name" placeholder="Su Nombre" required>
						</div>
						<div class="col form-group">
							<input type="email" class="form-control" name="De_correo" id="email" placeholder="Su Email" required>
						</div>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="Asunto" id="subject" placeholder="Asunto" required>
					</div>
					<div class="form-group">
						<textarea class="form-control" name="CuerpoHTML" rows="5" placeholder="Mensaje" required></textarea>
					</div>
					<div class="text-center">
						<input type="submit" value="Enviar Mensaje" name="submit">
					</div>
				</form>
			</div>

		</div>

	</div>
</section>




