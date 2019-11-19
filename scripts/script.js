$(document).ready(function() {
	$('.element-group .element').click(function(){
		$this = $(this).parent('.element-group').find('.actions');
		$nothis = $(this).parent('.element-group').siblings().find('.actions');
		$this.slideToggle();
		$nothis.slideUp();
	});
	$('.image_box').click(function(){
		$this = $(this).find('form');
		$nothis = $(this).parent(".image_outer").siblings('.image_outer').find('form');
		$this.slideToggle();
		$nothis.slideUp();
	})
	$('#login-form').disableAutoFill({
	    passwordField: '.password',
	    debugMode: false,
	    randomizeInputName: true,
	    callback: function() {
	        return checkForm();
	    }
	});

	function checkForm() {
	    form = document.getElementById('login-form');

	    if (form.password.value == '') {
	        alert('Cannot leave Password field blank.');
	        form.password.focus();
	        return false;
	    }
	    if (form.username.value == '') {
	        alert('Cannot leave User Id field blank.');
	        form.username.focus();
	        return false;
	    }
	    return true;
	}

});