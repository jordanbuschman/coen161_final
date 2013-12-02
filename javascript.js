function displaySignup() {
	var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
	background.id = 'background';
	document.body.appendChild(background);
	
	var signup = document.createElement("form"); //The actual form to fill out to sign up
	signup.id = 'signup';
	signup.method = 'post';
	signup.action = 'addUser.php';
	var data = [];
	data.push("<div id='signup1'>It's easy to create an account with us, simply complete the following fields.",
		"<table>",
		"<tr>",
		"<td style='text-align: right'><input name='firstName' type='text' size='16' placeholder='First Name' id='firstName'/></td>",
		"<td><input name='lastName' type='text' size='16' placeholder='Last Name' id='lastName'/></td>",
		"</tr>",
		"<tr>",
		"<th id='usernameText'>Username</th>",
		"<td><input name='username' type='text' id='newUsername' size='16'/></td>",
		"</tr>",
		"<tr>",
		"<th id='passwordText'>Password</th>",
		"<td><input name='password' type='password' id='newPassword' size='16' maxlength='16'/></td>",
		"</tr>",
		"<tr>",
		"<th id='password2Text'>Confirm Password</th>",
		"<td><input type='password' id='newPassword2' size='16' maxlength='16'/></td>",
		"</tr>",
		"<tr>",
		"<th colspan='2' style='text-align: center'><input type='submit' name='Submit' value='Create' id='create' disabled='disabled' /></td>",
		"<td></td>",
		"</tr>",
		"<tr><td colspan='2' id='validUsername'></td></tr>",
		"<tr><td colspan='2' id='validPassword'></td></tr>",
		"<tr><td colspan='2' id='validPassword2'></td></tr>",
		"<tr><td><input type='button' value='Go back' onclick='window.location = window.location.pathname;' /><td></tr>",
		"</table></div>");

	$('#background').fadeTo( "slow" , 0.6, function() {
		document.body.appendChild(signup);
		$('#signup').html(data.join(''));
	});
}

$(document).ready(function() {
	var validFirstName = false;
	var validLastName = false;
	var validUser = false;
	var validPassword = false;
	var validPassword2 = false;

	$(document).on('change keyup input', '#firstName', function() { //Check if first name field isn't blank
		var firstName = $(this).val();
		var pattern = /\s/;
		if (firstName.match(pattern) || firstName.trim() == "") //If there is a space in the first name field or the box is empty
			validFirstName = false;
		else validFirstName = true;

		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#lastName', function() { //Check if last name field isn't blank
		var lastName = $(this).val();
		var pattern = /\s/;
		if (lastName.match(pattern) || lastName.trim() == "") //If there is a space in the last name field or the box is empty
			validLastName = false;
		else validLastName = true;

		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#newUsername', function() { //Check if desired username is valid or not
		var usr = $(this).val();
		var pattern = /\s/;
		if (usr.match(pattern) || usr.trim() == "") { //If there is a space in the username field or the box is empty
			validUser = false;
			$('#validUsername').html("<span style='color:red'>Username is invalid (No whitespace allowed)</span>");
			$('#usernameText').css("color", "red");
			$('#create').attr('disabled', 'disabled');
			return;
		}
    		$.post( "checkForUsername.php", { username:usr }) //Runs checkForUsername.php, which checks the current username field against all registered usernames
  			.done(function( data ) {
    				if( data == "F") {
					validUser = true;
					$('#validUsername').html("<span style='color:green'>Username is valid</span>");
					$('#usernameText').css("color", "green");
				}
				else {
					validUser = false;
					$('#validUsername').html("<span style='color:red'>Username is invalid (Name already taken)</span>");
					$('#usernameText').css("color", "red");
				}
  			}).fail(function() {
    				alert( "AJAX FAILED" );
  			});
  	
		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#newPassword', function() { //Check if desired password is between 8-12 characters with at least 1 capital letter and 1 number (and if passwords match)
		validPassword2 = false;
		$('#validPassword2').html("<span style='color:red'>Passwords do not match</span>");
		$('#password2Text').css("color", "red");

		var password = $(this).val();
		var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,16}$/; //8-16 characters from a-z, with at least 1 letter from A-Z, and 1 number

		if (password.match(pattern)) {
			$('#validPassword').html("<span style='color:green'>Password is valid</span>");
			$('#passwordText').css("color", "green");
			validPassword = true;
		}
		else {
			$('#validPassword').html("<span style='color:red'>Password must be 8-16 characters long with at least 1 capital letter and 1 number</span>");
			$('#passwordText').css("color", "red");
			validPassword = false;
		}

		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#newPassword2',  function() { //Check if passwords match
		var password = $(this).val();

		if (password == $('#newPassword').val()) {
			$('#validPassword2').html("<span style='color:green'>Passwords match</span>");
			$('#password2Text').css("color", "green");
			validPassword2 = true;
		}
		else {
			$('#validPassword2').html("<span style='color:red'>Passwords do not match</span>");
			$('#password2Text').css("color", "red");
			validPassword2 = false;
		}

		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
});
