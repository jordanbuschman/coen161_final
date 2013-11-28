<?php
	session_start();
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Kidz Camp</title>
		<link rel="stylesheet" type="text/css" href="jordanstyles.css">
	</head>

	<body>
 		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="javascript.js" ></script>

		<script type="text/javascript">
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
				<img src="images/logo.png" />
			</div>
			<div class="links">
				<a href="jordanIndex.php"><span id="home">Home</span></a>
				<a href="jordanIndex.php"><span id="theCamp">The Camp</span></a>
				<a href="jordanIndex.php"><span id="shop">Shop</span></a>
				<a href="jordanIndex.php"><span id="contact">Contact</span></a>
			</div>
			<div class="loginOrWelcome">
			<?php
				if(isset($_SESSION['user'])) {
					echo '<span>Welcome ' . $_SESSION['user']->firstName . '!</span>';
					echo '<button type="button" onclick="logout();" >Logout</button>';
				}
				else {
					echo '<form action="javascript:handleLogin();">';
					echo '<table><tr>';
					echo '<th style = "text-align: right">Username</th>';
					echo '<td><input type="text" name="username" size="16" /></td>';
					echo '</tr><tr>';
					echo '<th style="text-align: right">Password</th>';
					echo '<td><input type="password" name="password" size="16" /></td>';
					echo '</tr><tr>';
					echo '<td><input type="button" onclick="displaySignup()" value="Create account" /></td>';
					echo '<td><input type="submit" value="Login" /></td>';
					echo '</tr></table></form>';
				}
			?>
			</div>
		</header>
		<section id="boxholder">
			<div id="box1"></div>
			<div id="box2"></div>
			<div id="box3"></div>
			<div id="box4"></div>
		</section>
		<div id="centerpage"></div>
	</body>
</html> 
