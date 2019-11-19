$(document).ready(function() {
	// CLIENT SIDE VALIDATION
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var string;
	function errorNote(string){
		return "<div class='text-danger'><small>" + string + "</div>";
	}

	// $('#register_form').submit(function(e){
	// 	var $name = $('#name').val();
	// 	var $email = $('#email').val();
	// 	var $password = $('#password').val();
	// 	var $c_password = $('#c_password').val();
	// 	$('.text-danger').remove();
	// 	$('input').removeClass('is-invalid');
		
		

	// 	if($name.length<1){
	// 		e.preventDefault();

	// 		$('#name').after(errorNote('Please choose a username'));
	// 		$('#name').addClass("is-invalid");

	// 	} 

	// 	if($email.length<1){
	// 		e.preventDefault();

	// 		$('#email').after(errorNote('Please choose a username'));
	// 		$('#email').addClass("is-invalid");

	// 	} else if (!regex.test($email)){
	// 		e.preventDefault();

	// 		$('#email').after(errorNote('Please choose a username'));
	// 		$('#email').addClass("is-invalid");

	// 	}


	// 	if($password.length<8){
	// 		e.preventDefault();

	// 		$('#password').after(errorNote('Please choose a username'));
	// 		$('#password').addClass("is-invalid");

	// 	} else {
	// 		if($password !== $c_password){
	// 		e.preventDefault();
				
	// 			$('#c_password').after(errorNote('Please choose a username'));
	// 			$('#c_password').addClass("is-invalid");

	// 		}
	// 	}
		
	// });
	
	// $('#login_form').submit(function(e){
	// 	e.preventDefault();
	// 	var string;
	// 	var $email = $('#email').val();
	// 	var $password = $('#password').val();
	// 	$('.text-danger').remove();
	// 	$('input').removeClass('is-invalid');

	// 	if($email.length<1 || !regex.test($email)){
	// 		$('#email').after(errorNote('Please enter a valid email'));
	// 		$('#email').addClass("is-invalid");
	// 	}
	// 	if($password.length<8){
	// 		$('#password').after(errorNote('Please enter a valid password'));
	// 		$('#password').addClass("is-invalid");
	// 	}
	// })

	// });
});