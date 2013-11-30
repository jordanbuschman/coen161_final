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
			function handleLogin() { //Calls check.php to handle logging in
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

			$(document).ready(function() { //Access fetchItems.php to get all of the items in the item table;
				var rows = []; //Result set
				var items = []; //HTML to be appended
				$.post("fetchItems.php") 
					.done(function(data) { rows = JSON.parse(data); alert (rows[0].name); })
					.fail(function() { alert("AJAX FAILED"); });

				for (var i = 0; i < rows.length; i++) {
					items.push('<p>NAME: ', rows[i].name, ' LOCATION: ', rows[i].location, ' PRICE: ', rows[i].price, '</p>');
				}
				$('#itemBox').html(items.join(''));
			});	
		</script>

		<header>
			<div class="logo">
				<img src="images/logo.png"/>
			</div>
			<div id='cssmenu'>
				<ul>
	  				<li><a href='jordanIndex.php'><span style="color: yellow">Home</span></a></li>
					<li><a href='#'><span style="color: red">The Camp</span></a></li>
					<li><a href='shop.php'><span style="color: green">Shop</span></a></li>
					<li><a href='#'><span style="color: blue">Contact</span></a></li>
				</ul>
			</div>
			<div class="loginOrWelcome">
				<?php
					if(isset($_SESSION['user'])) {
						echo '<div>';
						echo '<span>Welcome, <strong>' . $_SESSION['user']->firstName . '</strong>!</span>';
						echo '<button type="button" onclick="logout();" >Logout</button>';
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
			<div>
				<div class="crop">
					<img src="images/childrenplaying.jpg" />
				</div>
			</div>
			<div>
				<div class="crop">
					<img src="images/teencomputer.jpg" />
				</div>
			</div>
			<div>
				<div class="crop">
					<img src="images/kids.jpg" />
				</div>
			</div>
			<div>
				<div class="crop">
					<img src="images/parentsregistration.jpg" />
				</div>
			</div>
		</section>
		<section class="centerpage">
			<h1>KidzCamp Shop</h1>
			<h3>Purchase fun and exciting KidzCamp memorabilia. <span style="color: red">We offer discounts for all KidzCampers, past and present!</span></h3>
			<div id="itemBox"></div>
		</section>
	</body>
</html> 
