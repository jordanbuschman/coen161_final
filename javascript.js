function displaySignup() {
	var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
	background.id = 'background';
	background.style.position = 'fixed';
	background.style.left = 0;
	background.style.top = 0;
	background.style.width = '100%';
	background.style.height = '100%';
	background.style.backgroundColor = 'white';
	background.style.opacity = 0;
	background.style.zIndex = 200;
	document.body.appendChild(background);
	
	var signup = document.createElement("form"); //The actual form to fill out to sign up
	signup.id = 'signup';
	signup.method = 'post';
	signup.action = 'addUser.php';
	signup.style.position = 'fixed';
	signup.style.left = '100px';
	signup.style.top = '100px';
	signup.style.zIndex = 300;
	var data = [];
	data.push("<table>",
		"<tr>",
		"<th>Username</th>",
		"<td><input name='username' type='text' id='newUsername' /></td>",
		"<td id='validUsername'></td>",
		"</tr>",
		"<tr>",
		"<th>Password</th>",
		"<td><input name='password' type='password' id='newPassword' /></td>",
		"<td id='validPassword'></td>",
		"</tr>",
		"<tr>",
		"<th>Confirm Password</th>",
		"<td><input name='password2' type='password' id='newPassword2' /></td>",
		"<td id='validPassword2'></td>",
		"</tr>",
		"<tr>",
		"<th colspan='2' style='text-align: center'><input type='submit' name='Submit' value='Create' id='create' disabled='disabled' /></td>",
		"<td></td>",
		"</tr>",
		"</table>");

	$('#background').fadeTo( "slow" , 0.6, function() {
		document.body.appendChild(signup);
		$('#signup').html(data.join(''));
	});
}

$(document).ready(function() {
	var validUser = false;
	var validPassword = false;
	var validPassword2 = false;

	$(document).on('change keyup input', '#newUsername', function() { //Check if desired username is valid or not with ajax
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
	$(document).on('change keyup input', '#newPassword', function() { //Check if desired password is between 8-12 characters with at least 1 capital letter and 1 number (and if passwords match)
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
	$(document).on('change keyup input', '#newPassword2',  function() { //Check if passwords match
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
