	var validUser = false;
	var validPassword = false;

$('document').ready(function() {
	$('#newUsername').change(function() { //Check if desired username is valid or not with ajax
		var username = $(this).val();
	});
	$('#newPassword').keyup(function() { //Check if desired password is between 8-12 characters with at least 1 capital letter and 1 number
		var password = $(this).val();
		var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}$/ 
		if (password.match(pattern)) validPassword = true;
		else validPassword = false;

		if (validPassword && validUser){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
});
