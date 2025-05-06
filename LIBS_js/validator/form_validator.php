<script>
	var validator = new FormValidator();
	// select your "form" element from the DOM and attach an "onsubmit" event handler to it:
	document.forms[0].onsubmit = function(e){
		var validatorResult = validator.checkAll(this); // "this" reffers to the currently submitetd form element

		return !!validatorResult.valid;
	};
</script>