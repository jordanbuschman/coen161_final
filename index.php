<?php
session_start();
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Kidz Camp</title>
		<link rel="stylesheet" type="text/css" href="mystyles.css">
 		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="javascript.js" ></script>

<script>
function handleLogin() {
    var usr = document.getElementsByName('username')[0].value;
    var pwd = document.getElementsByName('password')[0].value;
    
    $.post( "check.php", { username:usr, password:pwd })
  	.done(function( data ) {
    	if( data == "T" ){
    		//Refresh the page
    		window.location = window.location.pathname;
    	}else{
    		alert( "Password and/or Username Incorrect" );
    	}
  	}).fail(function() {
    	alert( "AJAX FAILED" );
  	});
}

function logout(){
	window.location.href = "logout.php";
}
</script>

	</head>

	<body>
		<header>
			<div id="nav">
				<div id="logo"></div>
				<div id="nav2">
					<div id='cssmenu'>
						<ul>
	  						<li class='active'><a href='index.php'><span style="color: yellow">Home</span></a></li>
							<li class='has-sub'><a href='#'><span style="color: red">The Camp</span></a></li>
							<li class='has-sub'><a href='#'><span style="color: green">Shop</span></a></li>
							<li class='last'><a href='#'><span style="color: blue">Contact</span></a></li>
						</ul>
					</div>
				</div>
			</div>
	
			<div id="nav3">
				<div id="login">
					<?php
						if(isset($_SESSION['user'])){
							$username = $_SESSION['user']->username;
							echo "Welcome $username!";
							echo '<button type="button" onclick="logout();" >Logout</button>';
						} else {  ?>
							<form action="javascript:handleLogin();">
							Username: <input type="text" name="username" size="15" /><br />
							Password: <input type="password" name="password" size="15" /><br />
							<div align="right" style="margin-top: -12px;">
								<p><input type="submit" value="Login" /></p>
							</div>
							</form>
						<?php }
					?>
				</div>
			</div>
		</header>

		<div id="boxholder">
			<div id="box1"></div>
			<div id="box2"></div>
			<div id="box3"></div>
			<div id="box4"></div>
		</div>
		<div id="centerpage"></div>
	</body>
</html> 
