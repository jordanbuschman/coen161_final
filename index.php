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
		<link rel="icon" href="images/flavicon.png" type="image/x-icon" />
		<style>
		#map1 {
        width: 500px;
        height: 400px;
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
					infowindow.setContent(locations[i][0]);
					marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2], locations[i][3]),
					map: map
				});
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
		  infowindow.open(map, marker);
		}
		}
		) (marker, i));
				
			}
				
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
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
						echo '<button type="button" onclick="showCart(' . $_SESSION['user']->id .', ' . $_SESSION['user']->didEnroll . ')">Cart: <span id="cartnum">0</span> item(s)</button>';
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
		
		</div>
		<section class="centerpage">
		<div id="left1" style="float: left; width: 59%; margin-left: 25px; font-size: 18px; line-height: 18px;">
		<h1>Welcome to KidzCamp!</h1>
		<p>KidzCamp Inc. is an organization that offers educational summer camps for children aged 10-14. Our camps our offered during the summer and each session lasts 2 weeks, although you can attend our shorter 1 week camp for a discounted price. </p>
		<p>We aim to give our participants an experience they will cherish and lessons that will help them grow and succeed. Here at KidzCamp we focus on teaching kids the importance of computers in our lives as well as teaching them valuable skills in Computer Science.</p>
		<p>All of our camps are hosted at universities throughout California. The map to the right shows where we currently offer camps.</p>
		<p>We invite you to navigate through our site where you have the opportunity to <span style="color:red;">Sign-Up</span> and <span style="color:red;">Register</span> your child, Look through our online catalog, leave comments and suggestions, and even take a look at some of the activities we offer at the camp.</p>
		<p>Navigating through our site is easy! Go to the <span style="color:red;">The Camp</span> page to see some enrollment statistics and the camp schedule. Check out the <span style="color:green;">Shop</span> page to purchase exclusive KidzCamp gear! We encourage you to create an account as it makes navigating through our site easier. </p>
		
		</div>
		<img src="images/homekids.jpg" style="width: 38%; height: 375px; float:right; margin-top: 10px;" />
		<div id="map1" style="width: 50%; height: 350px; margin-top: 15px; float: left;"></div>
		<div style="width: 45%; float: right; margin-top: 20px; margin-right: 15px;">
		<h1 style="color:blue;">Kidz Camp Locations</h1>
		<p>This map shows each one of our locations located in California. As you can see they are labeled by the univeristy they are held at.</p>
		<p>Feel free to click on one of the markers to find out which session is held at which university.</p>
		<p>Don't forget to enroll your kids!</p>
		<center><p>**Hints to Our Site!**</p></center>
		<p> Signing-up and enrolling in a class can earn you discounts on our site. The two discounts we offer are found in the shop page or through registration. If you enroll more than 1 child, you get 10% off each additional child!</p>
		<p>Don't worry if your child has special requests(allergies, illnesses, etc.) we are fully equiped to handle any situation!</p>
		</div>
		</section>
		<br />
		<footer>
			<center> Web Master:<a href="mailto:jbuschman@scu.edu"> Jordan Buschman </a>  Web Master:<a href="mailto:achung@scu.edu"> Aaron Chung</a> Web Master:<a href="mailto:adeartola@scu.edu"> Andy de Artola</a></center>
			<center>Copyright 2013 KidzCamp Inc. </center>
		</footer>
	</body>
</html> 
