<?php
	if (isset($_SESSION["user"]))
		header("location: index.php");

	ob_start();

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";
	$username = $_POST['username'];
	$password = $_POST['password'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$query = "INSERT INTO $tbl (username, password, firstName, lastName) VALUES ('$username', '$password', '$username', 'Bob')"; //Insert into table
	mysql_query($query);
	
	$search_query = "SELECT * FROM $tbl WHERE username='$username'";
	$result = mysql_query($search_query);
	
	session_start();
	$user = mysql_fetch_object($result);
	$_SESSION["user"] = $user;
	header("location: index.php");

	ob_end_flush();
?>
