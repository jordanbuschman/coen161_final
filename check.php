<?php
	ob_start();

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	echo "<p>INPUT - USERNAME: $username, PASSWORD: $password</p>";

	$query = "SELECT * FROM $tbl WHERE username='$username' AND password='$password'";	
	$result = mysql_query($query);
	
	$count = mysql_num_rows($result); 
	if ($count != 1)
		echo 0;
	else {
		$user = mysql_fetch_object($result);
		$_SESSION["user"] = $user;
		echo 1;
	}
	ob_end_flush();
?>
