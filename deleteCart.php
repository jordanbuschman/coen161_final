<?php
	session_start();

	if (!$_POST['userId']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "cart";

	$userId = $_POST['userId'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");

	$query = "DELETE FROM $tbl WHERE userId=$userId";
	mysql_query($query);
?>
