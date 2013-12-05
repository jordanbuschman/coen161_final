<?php
	session_start();

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$username = $_SESSION['user']->username;
	$rating = $_POST['numStars'];
	$review = $_POST['review'];
	
	
	$checkusername = mysql_query("SELECT username FROM users WHERE username = '$username'");
	$row83 = mysql_fetch_assoc($checkusername);

	if ($_POST['username'] == $row83['username']) die('Username already in use.');
	
	$query = "UPDATE `user` SET `didEnroll`='$enrolled', `numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	mysql_query($query);
	
	$query = "SELECT * FROM $tbl WHERE username='$username' AND password='$password'";	
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); 
	if ($count != 1)
		echo "F";
	else {
		$user = mysql_fetch_object($result);
		$_SESSION["user"] = $user;
		echo "T";
	}
?>
