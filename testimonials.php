<?php
	session_start();
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>Kidz Camp</title>
		<link rel="stylesheet" type="text/css" href="mystyles.css">
		<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script src="maplocations.js" type="text/javascript"></script>	
		<style>
		td {
			min-width: 100px;
		}
		th {
			min-width: 100px;
		}
    </style>
	</head>

	<body>
 		<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="javascript.js" ></script>


		<script type="text/javascript">
			function initialize() {
				var mapCanvas = document.getElementById('map1');
				var mapOptions = {
					center: new google.maps.LatLng(36.3492, -121.9381),
					zoom: 6,
					mapTypeId: google.maps.MapTypeId.ROADMAP
					}
				var map = new google.maps.Map(mapCanvas, mapOptions);
				var infowindow = new google.maps.InfoWindow();
			var marker, i;
			for (i = 0; i < locations.length; i++) {  
				marker = new google.maps.Marker({
				position: new google.maps.LatLng(locations[i][1], locations[i][2], locations[i][3]),
				map: map
			});
			}
			}
			google.maps.event.addDomListener(window, 'load', initialize);
			
			$(document).ready(function() {
				$.post("getCartCount.php", {userId: <?php echo (isset($_SESSION['user']) ? $_SESSION['user']->id : -1); ?>})
				.done(function(data) {
					$("#cartnum").text(data); //Set number of items in cart
				})
				.fail(function() { alert("AJAX FAILED"); });
			});

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
			    		alert( "AJAX FAILED 1" );
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
						echo '<p>Welcome, <strong>' . $_SESSION['user']->firstName . '</strong>!</p>';
						echo '<button type="button" onclick="showCart(' . $_SESSION['user']->id . ')">Cart: <span id="cartnum">0</span> item(s)</button>';
						echo '<button type="button" onclick="logout();">Logout</button>';
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
					<a href="javascript:displayRegistration()"><img src="images/parentsregistration.jpg" /></a>
					</div>
				</div>
			</div>
		</section>
		<section class="centerpage" style="min-width: 600px; width:600px; font-size: 18px; line-height: 20px;">
		<h1> Testimonials and Reviews </h1>
		<?php

	if (!$_SESSION['user']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";
	$tbl2 = "forum";
	$id = $_SESSION['user']->id;
	$num = $_SESSION['user']->numEnrolled;
	$namef = $_SESSION['user']->firstName;
	$namel = $_SESSION['user']->lastName;
	$username = $_SESSION['user']->username;
	$nume = $_SESSION['user']->numEnrolled;
	
	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	$query = "SELECT * FROM $tbl2 WHERE 1";
	$result = mysql_query($query);
	$i = 1;
	
	while($row = mysql_fetch_assoc($result)){
		echo "&nbsp&nbsp&nbsp&nbsp<strong>";
		echo $row['username'];
		echo "</strong> gives a rating of <strong>";
		echo $row['rating'];
		echo "</strong> and says:<br /> ''";
		echo $row['review'];
		echo "'' <br /><br />";
	}
	
	
		?>
		</section>
		<br />
		<footer>
			<center> Web Master:<a href="mailto:jbuschman@scu.edu"> Jordan Buschman </a>  Web Master:<a href="mailto:achung@scu.edu"> Aaron Chung</a> Web Master:<a href="mailto:adeartola@scu.edu"> Andy de Artola</a></center>
			<center>Copyright 2013 KidzCamp Inc. </center>
		</footer>
	</body>
</html> 
