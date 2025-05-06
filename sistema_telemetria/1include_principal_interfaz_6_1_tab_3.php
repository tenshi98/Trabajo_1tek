<div role="tabpanel" class="tab-pane fade" id="solicitud">
	<style>
		.iframe_elfinder{height: 3000px;}
		iframe{float:right;width: 100%;height: 100%;padding: 0;margin: 0;border:none;}
	</style>

	<script>
		window.addEventListener('message', function(event) {
			if(event.data['setAnchor']>0) {
				var offsetHeight =event.data['setAnchor'];
				jQuery('html, body').animate({
					scrollTop: offsetHeight
				}, 200);
			}
		})
	</script>

	<div class="iframe_elfinder">
		<iframe class="embed-responsive-item" src="<?php echo getRootURL().'principal_solicitud_finalizada.php'?>" allowfullscreen></iframe>
	</div>

</div>
