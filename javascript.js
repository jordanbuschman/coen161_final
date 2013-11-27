$(document).ready(function() {
	var validUser = false;
	var validPassword = false;
	var validPassword2 = false;

	$('#newUsername').bind('change keyup input', function() { //Check if desired username is valid or not with ajax
		var usr = $(this).val();
		var pattern = /\s/;
		if (usr.match(pattern) || usr.trim() == "") {
			validUser = false;
			$('#validUsername').html("<p style='color:red'>Username is invalid (No whitespace allowed)</p>");
			$('#create').attr('disabled', 'disabled');
			return;
		}
    		$.post( "checkForUsername.php", { username:usr })
  			.done(function( data ) {
    				if( data == "F") {
					validUser = true;
					$('#validUsername').html("<p style='color:green'>Username is valid</p>");
				}
				else {
					validUser = false;
					$('#validUsername').html("<p style='color:red'>Username is invalid (Name already taken)</p>");
				}
  			}).fail(function() {
    				alert( "AJAX FAILED" );
  			});
  	
		if (validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$('#newPassword').bind('change keyup input', function() { //Check if desired password is between 8-12 characters with at least 1 capital letter and 1 number
		validPassword2 = false;
		$('#validPassword2').html("<p style='color:red'>Passwords do not match</p>");

		var password = $(this).val();
		var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}$/; 

		if (password.match(pattern)) {
			$('#validPassword').html("<p style='color:green'>Password is valid</p>");
			validPassword = true;
		}
		else {
			$('#validPassword').html("<p style='color:red'>Password must be 8-16 chars long with at least 1 capital letter and 1 number</p>");
			validPassword = false;
		}

		if (validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$('#newPassword2').bind('change keyup input', function() { //Check if passwords match
		var password = $(this).val();

		if (password == $('#newPassword').val()) {
			$('#validPassword2').html("<p style='color:green'>Passwords match</p>");
			validPassword2 = true;
		}
		else {
			$('#validPassword2').html("<p style='color:red'>Passwords do not match</p>");
			validPassword2 = false;
		}

		if (validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
});
