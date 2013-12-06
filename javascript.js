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
function showCart(uId) {
    $.post( "fetchCart.php", { userId: uId }) //Runs fetchCart.php, which fetches the cart for the userUsername.php
  	.done(function( encoded ) {
		var cart = JSON.parse(encoded);
		var data = [];
		var total = 0;

		var cartDiv = document.createElement("div");
		cartDiv.id = "cart";
		data.push("<h3>Your cart:</h3>",
			"<table>",
			"<tr>",
			"<th>Item</th>",
			"<th>Price</th>",
			"<th>Quantity</th>",
			"</tr>");
		for (var i = 0; i < cart.length; i++) {
			var priceForOne = ((100 - cart[i]['discount']) * cart[i]['price'] / 100).toFixed(2);
			var priceForAll = priceForOne * cart[i]['count'];
			total += priceForAll;
			data.push("<tr>",
				"<td>", cart[i]['name'], "</td>",
				"<td>$<span>", priceForOne, "</span></td>",
				"<td><input type='text' size='3' onfocusin='javascript: updateOld(", i, ")' onfocusout='javascript: updateCart(", i, ", ", uId, ", ", cart[i]['itemId'], ");' value='", cart[i]['count'], "' /></td>",
				"</tr>");
		}
		data.push("</table>",
			"<p>Total: $<span>", total.toFixed(2), "</span></p>",
			"<input type='button' value='Go back' onclick='window.location = window.location.pathname;' />",
			"<input id='checkOut' type='button' value='Check out' onclick='javascript: checkOut1(", uId, ", ", total, ")' />");
		
		var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
		background.id = 'background';
		document.body.appendChild(background);
		
		$('#background').fadeTo( "slow" , 0.6, function() {
			document.body.appendChild(cartDiv);
			$('#cart').html(data.join(''));

			if (cart.length == 0)
				$('#cart input').last().attr('disabled', 'disabled');
			else
				$('#cart input').last().removeAttr('disabled');
		});	
	}).fail(function() {
    		alert( "AJAX FAILED" );
  	});
}

function updateOld(index) {
	quantity = $('#cart tr:eq(' + (index + 1) + ') td:eq(' + 2 + ') input');
	quantity.data("oldVal", quantity.val());
}
function updateCart(index, uId, iId) {
	var row = $('#cart tr:eq(' + (index + 1) + ')');
	var item = $('#cart tr:eq(' + (index + 1) + ') td:eq(' + 0 + ')');
	var price = $('#cart tr:eq(' + (index + 1) + ') td:eq(' + 1 + ') span');
	var quantity = $('#cart tr:eq(' + (index + 1) + ') td:eq(' + 2 + ') input');
	var total = $('#cart > p > span');

	var newTotal = (total.html() - price.html() * (quantity.data("oldVal") - quantity.val())).toFixed(2);
	total.html((isNaN(newTotal) || newTotal < 0 || quantity.val() < 0) ? 0.00 : newTotal);

	var qty = quantity.val();
	$.post( "updateCart.php", { userId:uId, itemId:iId, count:qty })
		.done(function( data ) {
		}).fail(function() {
			alert( "AJAX FAILED" );
		});
}
function checkOut1(uId, total) {
	$('#checkOut').attr('disabled', 'disabled');	

	$('#cart').append('<div>Credit Card number <input size="16" id="checkoutCreditCard" maxlength="16"/><input size="4" id="checkoutCsv" maxlength="4" placeholder="CSV"/></div><br/>');
	var text = '<input id="purchace" type="button" value="Place purchace" onclick="javascript: checkOut2(' + uId + ', ' + total + ')" />';
	$('#cart').append(text);
}
function checkOut2(uId, total) {
	var creditCard = $('#checkoutCreditCard').val();
	var csv = $('#checkoutCsv').val();
	alert(total);

	$.post( "addOrder.php", { userId:uId, creditCart:creditCard, csv:csv, total:total})
		.done(function( data ) {
			$.post( "deleteCart.php", { userId:uId })
				.done(function( data ) {
				}).fail(function() {
					alert( "AJAX FAILED" );
				});
		}).fail(function() {
			alert( "AJAX FAILED" );
		});
	alert("Thank you for your purchase! Your item(s) should arrive within 8-10 business days.");
}
function alertLogin() {
	alert ("Please Login to continue.");
}

function displayRegistration(userfirst,userlast, numenrolled) {
	var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
	background.id = 'background';
	document.body.appendChild(background);
	
	
	var signup = document.createElement("form"); //The actual form to fill out to sign up
	signup.id = 'signup2';
	signup.method = 'post';
	signup.action = 'registration.php';
	var data = [];
	data.push("<div id='left' style='margin-top: -20px;'><h2>Registration Form</h2> Please complete the following information.<br />",
					"<input name='firstName' type='text' size='16' placeholder='Child First Name' id='firstName'/>",
					"<input name='lastName' type='text' size='16' placeholder='Child Last Name' id='lastName'/><br />",
					"Birthday: <input name='bdate' type='text' id='bdate' maxlength='10' placeholder='mm/dd/yyyy'/><br />",
					"Grade Level: <input name='grade' type='number' size='16' id='grade' min='4' max ='9'/>",
					"<input name='school' type='text' size='16' placeholder='School Name' id='school'/><br />",
					"<input name='parentFirstName' type='text' size='16' placeholder='Parent First Name' id='parentfirstName' value='",
					userfirst,
					"'/>",
					"<input name='parentLastName' type='text' size='16' id='parentlastName' value='",
					userlast,
					"'/><br />",
					"<input name='email' type='email' size='16' placeholder='Email' id='email'/>",
					"<input name='phone' type='tel' size='16' maxlength='10' placeholder='Phone' id='phone'/>",
					"You currently have <strong><input hidden id='numenroll' value='",numenrolled,"' />",
					numenrolled,
					"</strong> child(ren) enrolled.<br />",
					"Which camp session will your child be attending? <select name='session'><option value=1>1</option><option value=2>2</option><option value=3>3</option><option value=4>4</option><option value=5>5</option><option value=6>6</option><option value=7>7</option></select><br />",
					"How long will your child attend this session?<br /> <select name='length' id='length'><option>*</option><option>1</option><option>2</option></select> week(s) ($600 for 1 week, $900 for 2)<br />",
					"<div id='currentcost' style='color: red'><br /></div>",
					"<strong>Payment Information:</strong><br />",
					"Card Type: <select name='cardtype'><option value='visa'>Visa</option><option value='mastercard'>Mastercard</option><option value=discover'>Discover</option><option value='amex'>AMEX</option></select> CSV: <input name='csv' type='text' size='4' maxlength='4' placeholder='CSV' id='csv'/><br />",
					"Expiration:<input name='expdate' type='text' id='expdate' maxlength='10' placeholder='mm/dd/yyyy'/> <br />",
					"<input name='cardholder' type='text' size='16' placeholder='Cardholder Name' id='cardholder'/>",
					"<input name='cardnumber' type='text' size='16' maxlength='16' placeholder='Card Number' id='cardnumber'/><br /> <br />",
					"<input type='submit' name='Submit' value='Enroll' id='submit' disabled='disabled' />",
					"<input type='button' value='Go back' onclick='window.location = window.location.pathname;' />",
					"</div><div id='right'>",
					/*"Session 1: June 24-June 30<br/>",
					"Session 2: June 24-June 30<br/>",
					"Session 3: June 24-June 30<br/>",
					"Session 4: June 24-June 30<br/>",
					"Session 5: June 24-June 30<br/>",
					"Session 6: June 24-June 30<br/>",
					"Session 7: June 24-June 30<br/>",
					"Session 8: June 24-June 30<br/>",
					"Session 9: June 24-June 30",*/
					"<center>We appreciate your interest in KidzCamp. The calendar below shows the next sessions we have. Please fill out the form on the left with your child's information (Your information has been autofilled). All fields are required!</center><br /><iframe src='http://www.google.com/calendar/embed?showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;src=scu.edu_86oe3fanhm15i4daq4ghq9rmhg%40group.calendar.google.com&ctz=America/Los_Angeles&dates=20140601%2F20140830' style='border: 0' width='600' height='500' frameborder='0' scrolling='no'></iframe>",
					"</div>");
	$('#background').fadeTo( "slow" , 0.6, function() {
		document.body.appendChild(signup);
		$('#signup2').html(data.join(''));
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
		if (firstName.match(pattern) || firstName.trim() == "") { //If there is a space in the first name field or the box is empty
			$('#firstName').css("background-color", "red");
			validFirstName = false;
		}
		else {
			$('#firstName').css("background-color", "green");
			validFirstName = true;
		}

		if (validFirstName && validLastName && validUser && validPassword && validPassword2){
			$('#create').removeAttr('disabled');
		}
		else $('#create').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#lastName', function() { //Check if last name field isn't blank
		var lastName = $(this).val();
		var pattern = /\s/;
		if (lastName.match(pattern) || lastName.trim() == "") { //If there is a space in the last name field or the box is empty
			$('#lastName').css("background-color", "red");
			validLastName = false;
		}
		else {
			$('#lastName').css("background-color", "green");
			validLastName = true;
		}

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

$(document).ready(function() {
	var validFirstName = false;
	var validLastName = false;
	var validBirth = true;
	var validEmail = false;
	var validPhone = false;
	var validCSV = false;
	var validExpiration = true;
	var validCardholder = false;
	var validCardNumber = false;
	var validLength = false;
	var validBirthday = false;
	
	$(document).bind('change keyup input', '#length', function() {
	var length1 = $('#length').val();
	var num = $('#numenroll').val();
	var cost = 0.00;
	var discount;
	if (num > 0)
		discount = .9;
	else discount = 1;
	if (length1 == '*'){
		validLength = false;
		$('#currentcost').html("<span style='color:red'>Please select a valid length.</span>");
	}
	else{
		if (length1 == '1')
			cost = 600.00 * discount;
		else if (length1 == '2') 
			cost = 900.00 * discount;
		$('#currentcost').html("<span style='color:red'>Your total cost is $"+cost+".00</span>");
		validLength = true;
	}
	if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#submit').attr('disabled', 'disabled');

	});

	$(document).on('change keyup input', '#firstName', function() { //Check if first name field isn't blank
		var firstName = $(this).val();
		var pattern = /\s/;
		if (firstName.match(pattern) || firstName.trim() == "") //If there is a space in the first name field or the box is empty
			validFirstName = false;
		else validFirstName = true;

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#submit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#lastName', function() { //Check if last name field isn't blank
		var lastName = $(this).val();
		var pattern = /^([A-Za-z]{2}[ éàëA-Za-z]*)$/;
		if (!lastName.match(pattern) || lastName.trim() == "") //If there is a space in the last name field or the box is empty
			validLastName = false;
		else validLastName = true;

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});

	$(document).on('change keyup input', '#email', function() {
		var email = $(this).val();
		var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if (email.match(pattern)) {
			$('#email').css("background-color", "green");
			validEmail = true;
		}
		else {
			$('#email').css("background-color", "red");
			validEmail = false;;
		}
		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#phone', function() {
		var phone = $(this).val();
		var pattern = /^\d{10}$/;
		if (phone.match(pattern)) {
			$('#phone').css("background-color", "green");
			validPhone = true;
		}
		else {
			$('#phone').css("background-color", "red");
			validPhone = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#csv', function() {
		var csv = $(this).val();
		var pattern = /^\d{3,}$/;
		if (csv.match(pattern)) {
			$('#csv').css("background-color", "green");
			validCSV = true;
		}
		else {
			$('#csv').css("background-color", "red");
			validCSV = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#expdate', function() {
		var expiration = $(this).val();
		var pattern = /^\d{2}[./-]\d{2}[./-]\d{4}$/;
		if (expiration.match(pattern)) {
			$('#expdate').css("background-color", "green");
			validExpiration = true;
		}
		else {
			$('#expdate').css("background-color", "red");
			 validExpiration = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#cardholder', function() {
		var cardholder = $(this).val();
		var pattern = /^([A-Za-z]{2}[ éàëA-Za-z]*)$/;
		if (cardholder.match(pattern)) {
			$('#cardholder').css("background-color", "green");
			validCardholder = true;
		}
		else {
			$('#cardholder').css("background-color", "red");
			validCardholder = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#cardnumber', function() {
		var cardnumber = $(this).val();
		var pattern = /^\d{16}$/;
		if (cardnumber.match(pattern)) {
			$('#cardnumber').css("background-color", "green");
			validCardNumber = true;
		}
		else {
			$('#cardnumber').css("background-color", "red");
			validCardNumber = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
	$(document).on('change keyup input', '#bdate', function() {
		var birthday = $(this).val();
		var pattern = /^\d{2}[./-]\d{2}[./-]\d{4}$/;
		if (birthday.match(pattern)) { //If there is a space in the last name field or the box is empty
			$('#bdate').css("background-color", "green");
			validBirthday = true;
		}
		else {
			$('#bdate').css("background-color", "red");
			validBirthday = false;
		}

		if (validFirstName && validLastName && validBirth && validEmail && validPhone && validCSV && validExpiration && validCardholder && validCardNumber && validLength && validBirthday){
			$('#submit').removeAttr('disabled');
		}
		else $('#ssubmit').attr('disabled', 'disabled');
	});
});

