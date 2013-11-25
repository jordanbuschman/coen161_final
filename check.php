<?php
	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (have you ran init.sql?)");
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	echo "<p>USERNAME: $username, PASSWORD: $password</p>";
?>
