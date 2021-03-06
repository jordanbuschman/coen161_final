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
		
	</head>

	<body>
 		

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
			function handleCart(index, iId) {
				var id = "#qty" + index;
				var qty = $(id).find(":selected").val();
				if (<?php echo (isset($_SESSION['user']) ? 0 : 1) ?>) return; //Return if session is not registered
				if (qty != "Qty") {
					var userId = <?php echo (isset($_SESSION['user']) ? $_SESSION['user']->id : -1); ?>; //Should never have to deal with an index of -1, otherwise you have a serious problem
					var itemId = iId;
					$.post( "addToCart.php", { userId: userId, itemId: itemId, count: qty })
					.done(function( data ) {
						//Append "added to cart" to screen
						var background = document.createElement("div"); //Fade and disable screen by overlaying opaque div to the screen
						background.id = 'background';
						background.style.backgroundColor = 'green';
						document.body.appendChild(background);
						$('#background').hide();

						$('#background').fadeTo( "fast" , 0.3, function() {
							$('#background').fadeTo( "fast" , 0.0, function() {
								$('#background').remove();
							});
						});

						$("#cartnum").text(parseInt($("#cartnum").text()) + parseInt(qty)); //Change number of things in cart
			  		}).fail(function() {
			  	  		alert( "AJAX FAILED" );
			  		});
				}
			}
			function logout() {
				window.location.href = "logout.php";
			}

			$(document).ready(function() { //Access fetchItems.php to get all of the items in the item table;
				$.post("fetchItems.php") 
				.done(function(data) {
					var items = []; //To be appended to #itembox 
					var rows = JSON.parse(data);

					for (var i = 0; i < rows.length; i++) {
						items.push('<div class="item"><div>');
						items.push('<h3>', rows[i].name, '</h3>');
						items.push('<div class="itemImg"><img src="images/', rows[i].location, '" /></div>');
						items.push('<p>Price: $', rows[i].price, '</p>');
						<?php if(!(isset($_SESSION['user']))) { ?> //If person is not logged in/did not enroll
							if (rows[i].discount != 0)
								items.push('<p style="color: red">Enroll in a class to get a ', rows[i].discount, '% discount!</p><p style="color: red;">Log in or create an account<br/> to purchase items!</p>');
							else items.push('<p style="color: red;">Log in or create an account<br/> to purchase items!</p>');
						<?php } elseif(!($_SESSION['user']->didEnroll)) { ?>	
							if (rows[i].discount != 0)
								items.push('<p style="color: red">Enroll in a class to get a ', rows[i].discount, '% discount!</p>');
							else items.push('<p></br></p>');
						<?php } else { ?>
							if (rows[i].discount != 0)
								items.push('<p style="color: red">Camper price: $',
									(Math.round((100 - rows[i].discount) * rows[i].price, 2) / 100).toFixed(2),
									' (', rows[i].discount, '% off!)</p>');
							else items.push('<p></br></p>');
						<?php } if (isset($_SESSION['user'])) { ?>
							items.push('<form action="javascript:handleCart(', i, ', ', rows[i].id, ')">');
							items.push('<select id="qty', i, '">');
							items.push('<option value="Qty">Qty</option>');
							items.push('<option value="1">1</option>');
							items.push('<option value="2">2</option>');
							items.push('<option value="3">3</option>');
							items.push('<option value="4">4</option>');
							items.push('<option value="5">5</option>');
							items.push('<option value="6">6</option>');
							items.push('<option value="7">7</option>');
							items.push('<option value="8">8</option>');
							items.push('<option value="9">9</option>');
							items.push('<option value="10">10</option>');
							items.push('</select>');
							items.push('<input type="submit" value="Add to cart"/>');
							items.push('</form>');
						<?php } ?>
						items.push('</div></div>');
					}
					$('#itemBox').html(items.join(''));
				})
				.fail(function() { alert("AJAX FAILED"); });

				$.post("getCartCount.php", {userId: <?php echo (isset($_SESSION['user']) ? $_SESSION['user']->id : -1); ?>})
				.done(function(data) {
					$("#cartnum").text(data); //Set number of items in cart
				})
				.fail(function() { alert("AJAX FAILED"); });
			});	
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
					</div>
				</div>
			</div>
		</section>
		<section class="centerpage">
			<h1>KidzCamp Shop</h1>
			<h3>Purchase fun and exciting KidzCamp memorabilia. <span style="color: red">We offer discounts for all KidzCampers, past and present!</span></h3>
			<div id="itemBox"></div>
		</section>
		<br />
		<footer>
			<center> Web Master:<a href="mailto:jbuschman@scu.edu"> Jordan Buschman </a>  Web Master:<a href="mailto:achung@scu.edu"> Aaron Chung</a> Web Master:<a href="mailto:adeartola@scu.edu"> Andy de Artola</a></center>
			<center>Copyright 2013 KidzCamp Inc. </center>
		</footer>
	</body>
</html> 
