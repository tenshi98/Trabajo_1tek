					</div>
				</div>
			</div>
		</div>
		<footer id="footer">
			<p><?php echo ano_actual(); ?> &copy; <?php echo DB_EMPRESA_NAME ?> Todos los derechos reservados.</p>
		</footer>

		<!-- Animacion carga pagina -->
		<script>
			//ocultar el loader
			$(document).ready(function() {
				setTimeout(function(){
					$('body').addClass('loaded');
				}, 500);
			});
			//ajustar tamaño de todos los textarea
			autosize(document.querySelectorAll('textarea'));
			//se toma raiz
			var domain_val = "<?php echo DB_SITE_REPO ?>";
		</script>

		<!--Otros archivos javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/screenfull/screenfull.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-ui-1.10.3.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/countrypicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker-plus.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/modal/jquery.colorbox.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/tooltipster/js/tooltipster.bundle.min.js"></script>

		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".iframe").colorbox({iframe:true, width:"90%", height:"95%"});
				$(".callbacks").colorbox({
					onOpen:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onOpen: colorbox is about to open.'});},
					onLoad:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onLoad: colorbox has started to load the targeted content.'});},
					onComplete:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onComplete: colorbox has displayed the loaded content.'});},
					onCleanup:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onCleanup: colorbox has begun the close process.'});},
					onClosed:function(){ Swal.fire({icon: 'error',title: 'Oops...',text: 'onClosed: colorbox has completely closed.'});}
				});

				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
				//Burbuja de ayuda
				$('.tooltip').tooltipster({
					animation: 'grow',
					delay: 130,
					maxWidth: 300
				});
			});
		</script>
		<?php
		/******************************************************************************************************/
		/*                              Ventana Debug Superadministrador                                      */
		/******************************************************************************************************/
		//cuadro mensajes
		widget_avgrund();
		/******************************************************************************************************/
		/*                                                                                                    */
		/*                                              CIERRE DE LA BASE                                     */
		/*                                                                                                    */
		/******************************************************************************************************/
		mysqli_close($dbConn);
		?>
	</body>
</html>
