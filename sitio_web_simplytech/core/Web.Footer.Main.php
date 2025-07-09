
<footer id="footer">

	<div class="footer-top">
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 footer-contact">
					<?php
					if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
						echo '<h3>'.$rowData['Nombre'].'</h3>';
					}
					echo '<p>';
					if(isset($rowData['Contact_Address_body'])&&$rowData['Contact_Address_body']!=''){
						echo $rowData['Contact_Address_body'].'<br><br>';
					}
					if(isset($rowData['Contact_Email_body'])&&$rowData['Contact_Email_body']!=''){
						echo '<strong>Email:</strong> '.$rowData['Contact_Email_body'].'<br>';
					}
					if(isset($rowData['Contact_Phone_body'])&&$rowData['Contact_Phone_body']!=''){
						echo '<strong>Telefono:</strong> '.$rowData['Contact_Phone_body'].'<br>';
					}
					echo '</p>';
					?>
				</div>

				<?php
				if(isset($rowData['Config_Footer_Links'])&&$rowData['Config_Footer_Links']==1){
					echo '
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-2 footer-links">
						<h4>Enlaces</h4>
						<ul>';
					//se recorre
					foreach ($arrBody as $tipos) {
						if(isset($tipos['idTipo'])&&$tipos['idTipo']==$FooterLinks){
							//opción nuevo tab
							switch ($tipos['idNewTab']) {
								case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
								case 2: $tab = '';break;
							}
							//opción popup
							switch ($tipos['idPopup']) {
								case 1: $frame = 'glightbox'; break;
								case 2: $frame = '';break;
							}
							//imprime
							if(isset($tipos['LinkNombre'])&&$tipos['LinkNombre']!=''){
								echo '<li><i class="bx bx-chevron-right"></i> <a href="'.$tipos['LinkURL'].'" class="'.$frame.'" style="'.$tipos['LinkStyle'].'" '.$tab.'>'.$tipos['LinkNombre'].'</a></li>';
							}
						}
					}
					echo '</ul>
					</div>';
				}
				/******************************************************************************/
				if(isset($rowData['Config_Footer_Services'])&&$rowData['Config_Footer_Services']==1){
					echo '
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 footer-links">
						<h4>Nuestros Servicios</h4>
						<ul>';
					//se recorre
					foreach ($arrBody as $tipos) {
						if(isset($tipos['idTipo'])&&$tipos['idTipo']==$FooterServicios){
							//opción nuevo tab
							switch ($tipos['idNewTab']) {
								case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
								case 2: $tab = '';break;
							}
							//opción popup
							switch ($tipos['idPopup']) {
								case 1: $frame = 'glightbox'; break;
								case 2: $frame = '';break;
							}
							//imprime
							if(isset($tipos['LinkNombre'])&&$tipos['LinkNombre']!=''){
								echo '<li><i class="bx bx-chevron-right"></i> <a href="'.$tipos['LinkURL'].'" class="'.$frame.'" style="'.$tipos['LinkStyle'].'" '.$tab.'>'.$tipos['LinkNombre'].'</a></li>';
							}
						}
					}
					echo '</ul>
					</div>';
				}
				/******************************************************************************/
				if(isset($rowData['Config_Footer_Letters'])&&$rowData['Config_Footer_Letters']==1){ ?>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 footer-newsletter">
						<h4>Join Our Newsletter</h4>
						<p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
						<form action="" method="post">
							<input type="email" name="email">
							<input type="submit" value="Subscribe">
						</form>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="container d-md-flex py-4">

		<div class="me-md-auto text-center text-md-start">
			<div class="copyright">
				<?php
				if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
					echo '&copy; Derechos de <strong><span>'.$rowData['Nombre'].'</span></strong>. Todos los derechos reservados.';
				} ?>
			</div>
		</div>
		<div class="social-links text-center text-md-end pt-3 pt-md-0">
			<?php
			if(isset($rowData['Social_Twitter'])&&$rowData['Social_Twitter']!=''){echo '<a href="'.$rowData['Social_Twitter'].'"    class="twitter"><i class="bx bxl-twitter"></i></a>';}
			if(isset($rowData['Social_Facebook'])&&$rowData['Social_Facebook']!=''){     echo '<a href="'.$rowData['Social_Facebook'].'"   class="facebook"><i class="bx bxl-facebook"></i></a>';}
			if(isset($rowData['Social_Instagram'])&&$rowData['Social_Instagram']!=''){   echo '<a href="'.$rowData['Social_Instagram'].'"  class="instagram"><i class="bx bxl-instagram"></i></a>';}
			if(isset($rowData['Social_Googleplus'])&&$rowData['Social_Googleplus']!=''){ echo '<a href="'.$rowData['Social_Googleplus'].'" class="google-plus"><i class="bx bxl-skype"></i></a>';}
			if(isset($rowData['Social_Linkedin'])&&$rowData['Social_Linkedin']!=''){     echo '<a href="'.$rowData['Social_Linkedin'].'"   class="linkedin"><i class="bx bxl-linkedin"></i></a>';}
			?>
		</div>
	</div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
