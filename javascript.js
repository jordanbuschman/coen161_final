$(document).ready(function() {
	var validUser = false;
	var validPassword = false;

	$('#newUsername').keyup(function() { //Check if desired username is valid or not with ajax
		var usr = $(this).val();
		validUser = false;
    	$.post( "checkForUsername.php", { username:usr })
  		.done(function( data ) {
    		if( data == "F" ){
    			validUser = true;
    		}
  		}).fail(function() {
    		alert( "AJAX FAILED" );
  		});
  	
		if (validPassword && validUser){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$('#newPassword').keyup(function() { //Check if desired password is between 8-12 characters with at least 1 capital letter and 1 number
		var password = $(this).val();
		var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}$/; 
		if (password.match(pattern)) validPassword = true;
		else validPassword = false;

		if (validPassword && validUser){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
});
