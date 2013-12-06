<?php
	session_start();

	if (!$_POST['email']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";
	$tbl2 = "enrollment";

	$childfirst = $_POST['firstName'];
	$childlast = $_POST['lastName'];
	$firstName = $_POST['parentFirstName'];
	$lastName = $_POST['parentLastName'];
	$username = $_SESSION['user']->username;
	$password = $_SESSION['user']->password;
	$id = $_SESSION['user']->id;
	$birth = $_POST['bdate'];
	$email = $_POST['email'];
	$grade = $_POST['grade'];
	$school = $_POST['school'];
	$session = $_POST['session'];
	$phone = $_POST['phone'];
	$length = $_POST['length'];
	$cardtype = $_POST['cardtype'];
	$csv = $_POST['csv'];
	$expiration = $_POST['expdate'];
	$cardholder = $_POST['cardholder'];
	$cardnumber = $_POST['cardnumber'];
	$enrolled = 1;
	$cost = 900.00;
	if($length == '1'){
		$cost = 600.00;
	}
	else {
		$cost == 900.00;
	}
	if($numEnrolled = $_SESSION['user']->numEnrolled > 0)
		$cost = $cost * .90;
	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$numEnrolled = $_SESSION['user']->numEnrolled+1;
	$query = "UPDATE `user` SET `didEnroll`='$enrolled', `numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	mysql_query($query);
	
	
	$query = "INSERT INTO $tbl2 (userId, childNum, firstName, lastName, birth, grade, school, sessionNum, sessionLength, phone, email, cost, cardtype, csv, expiration, cardholder, cardnumber) VALUES ('$id', '$numEnrolled', '$childfirst', '$childlast', '$birth', '$grade', '$school', '$session', '$length', '$phone', '$email', '$cost', '$cardtype', '$csv', '$expiration', '$cardholder', '$cardnumber')";
	/*if($_SESSION['user']->numEnrolled == 0){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child1first`='$childfirst',`child1last`='$childlast',`child1birth`='$birth',`child1grade`='$grade',`child1school`='$school',`child1session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	}
	else if($_SESSION['user']->numEnrolled == 1){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child2first`='$childfirst',`child2last`='$childlast',`child2birth`='$birth',`child2grade`='$grade',`child2school`='$school',`child2session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	
	}
	else if($_SESSION['user']->numEnrolled == 2){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child3first`='$childfirst',`child3last`='$childlast',`child3birth`='$birth',`child3grade`='$grade',`child3school`='$school',`child3session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	
	}
	//$query = "UPDATE `user` SET `child1first`= '$childfirst', `child1last`='$childlast' WHERE `username`= 'adeartola'";*/
	//$query = "UPDATE  `kidzcamp`.`user` SET  `child1first` =  'Potato' WHERE  `user`.`id` =7";
	mysql_query($query);
	
	$query = "SELECT * FROM $tbl WHERE username='$username' AND password='$password'";	
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); 
	$user = mysql_fetch_object($result);
	$_SESSION["user"] = $user;

?>
<script src="http://code.jquery.com/jquery-1.7.2.js"></script>
<script src="javascript.js"></script>
<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Kidz Camp</title>
		<link rel="stylesheet" type="text/css" href="mystyles.css">
		<style type="text/css">
		#signup2 {
	width: 47.5%;
	margin-left: auto;
	margin-right: auto;
	left: 26.25%; 
	min-width: 40%
}
		</style>
	</head>

	<body>
 		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="javascript.js" ></script>

		<script type="text/javascript">
		$(document).ready(function(){
			var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
			background.id = 'background';
			document.body.appendChild(background);
			/*
			//userId, childNum, firstName, lastName, birth, grade, school, sessionNum, sessionLength, phone, email, cost;*/
			
			
	
			var signup = document.createElement("div"); //The actual form to fill out to sign up
			signup.id = 'signup2';
			var data = [];
			var childfirst = "<?php echo $_POST['firstName'];?>";
			var childlast ="<?php echo $_POST['lastName'];?>";
			var firstName ="<?php echo $_POST['parentFirstName'];?>";
			var lastName ="<?php echo $_POST['parentLastName'];?>";
			var username ="<?php echo $_SESSION['user']->username;?>";
			var id ="<?php echo $_SESSION['user']->id;?>";
			var birth ="<?php echo $_POST['bdate'];?>";
			var email ="<?php echo $_POST['email'];?>";
			var grade ="<?php echo $_POST['grade'];?>";
			var school ="<?php echo $_POST['school'];?>";
			var session ="<?php echo $_POST['session'];?>";
			var phone ="<?php echo $_POST['phone'];?>";
			var length ="<?php echo $_POST['length'];?>";
			var cost ="<?php echo $cost;?>";
			data.push(
				"<center><h2>Congratulations! You have registered<span style='color: red;'> ", childfirst,"</span> for Kids Camp!</h2></center>",
				"<div style='width: 75%; margin-left: auto; margin-right:auto;'><table style='margin-left: auto; margin-right:auto;'>",
				"<tr>",
				"<td style='width: 300px;'> Your Name: ", firstName, " ", lastName, "</td><td>Your Child's Name: ", childfirst, " ", childlast, "</td></tr>",
				"<tr><td> Email: ", email, "</td><td>Birth Date: ", birth, "</td></tr>",
				"<tr><td> Phone Number: ", phone, "</td><td>School: ", school, "</td></tr>",
				"<tr><td> Your username: ", firstName, " ", lastName, "</td><td>Grade Number: ", grade, "</td></tr>",
				"<tr><td><br /></td></tr><br /></table></div>",
				"<center><h3><span style='color: red;'>", childfirst,"</span> is registered for Session ",session," for ",length," week(s).<br/><br/> Total Cost: $",cost, ".00</h3></center>",
				"<div style='margin-right: 25px; text-align: right;'><input type='button' value='Finish' onclick='openIndex();' /></div>");
	$('#background').fadeTo( "slow" , 0.6, function() {
		document.body.appendChild(signup);
		$('#signup2').html(data.join(''));
	});
	});
			function openIndex() {
				window.location.href = "index.php";
			}
			function handleLogin() {
				var usr = document.getElementsByName('username')[0].value;
				var pwd = document.getElementsByName('password')[0].value;
			    
				$.post( "check.php", { username:usr, password:pwd })
				.done(function( data ) {
			    		if( data == "T" ){
			    			//Refresh the page
			    			window.location = window.location.pathname;
			    		}else {
			    			alert( "Password and/or Username Incorrect" );
			    		}
			  	}).fail(function() {
			    		alert( "AJAX FAILED" );
			  	});
			}
			
			function logout() {
				window.location.href = "logout.php";
			}
			

		</script>

		<header>
			<div class="logo">
				<a href='index.php'><img src="images/logo.png"/></a>
			</div>
			<div id='cssmenu'>
				<ul>
	  				<li><a href='index.php'><span style="color: yellow">Home</span></a></li>
					<li><a href='camp.php'><span style="color: red">The Camp</span></a></li>
					<li><a href='shop.php'><span style="color: green">Shop</span></a></li>
					<li><?php
					if(isset($_SESSION['user'])) {
						echo '<a href="account.php"><span style="color: blue">Your Account</span></a></li>';
					}
					else {
						echo '<a href="javascript:alertLogin()"><span style="color: blue">Your Account</span></a>';
					}
					?></li>
				</ul>
			</div>
			<div class="loginOrWelcome">
				<?php
					if(isset($_SESSION['user'])) {
						echo '<div>';
						echo '<span>Welcome, <strong>' . $_SESSION['user']->firstName . '</strong>!</span><br />';
						echo '<button type="button" onclick="logout();" style="margin-top: 5px;">Logout</button>';
						echo '</div>';
					}
					else {
						echo '<form action="javascript:handleLogin();">';
						echo '<table><tr>';
						echo '<td colspan="2"><input type="text" name="username" width="16" placeholder="Username"></td>';
						echo '</tr><tr>';
						echo '<td colspan="2"><input type="password" name="password" width="16" maxlength="16" placeholder="Password"></td>';
						echo '</tr><tr>';
						echo '<td><input type="button" onclick="displaySignup()" value="Create account" /></td>';
						echo '<td><input type="submit" value="Login" /></td>';
						echo '</tr></table></form>';
					}
				?>
			</div>
		</header>
		<section id="boxholder">
			<div id="outer" style="margin-left: auto; margin-right: auto;">
				<div id="boxes">
					<div class="crop">
						<a href="testimonials.php"><img src="images/childrenplaying.jpg" /></a>
					</div>
				</div>
				<div id="boxes">
					<div class="crop">
						<a href="forum.php"><img src="images/kids.jpg" /></a>
					</div>
				</div>
				<div id="boxes">
					<div class="crop">
						<a href="activities.php"><img src="images/teencomputer.jpg" /></a>
					</div>
				</div>
				<div id="boxes">
					<div class="crop">
					<?php
					if(isset($_SESSION['user'])) {
						$a = $_SESSION['user']->firstName;
						$b = $_SESSION['user']->lastName;
						$c = $_SESSION['user']->numEnrolled;
						echo '<a href="javascript:displayRegistration(';
						echo "'" . $a . "'";
						echo ', ';
						echo "'" . $b . "'";
						echo ', ';
						echo "'" . $c . "'";
						echo ')"><img src="images/parentsregistration.jpg" /></a>';
					}
					else {
						echo "<a href='javascript:alertLogin()'><img src='images/parentsregistration.jpg' /></a>";
					}
					?>
					</div>
				</div>
			</div>
		</section>
		<section class="centerpage"></section>
	</body>
</html> 


