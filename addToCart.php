<?php
	session_start();

	if (!$_POST['userId'] || !$_POST['itemId'] || !$_POST['count']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "cart";

	$userId = $_POST['userId'];
	$itemId = $_POST['itemId'];
	$count = $_POST['count'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$query = "INSERT INTO $tbl (userId, itemId, count) VALUES ('$userId', '$itemId', '$count')"; //Register new user
	mysql_query($query);
	
	$search_query = "SELECT * FROM $tbl WHERE username='$username'";
	$result = mysql_query($search_query);
	
	$user = mysql_fetch_object($result);
	$_SESSION["user"] = $user;
	header("location: index.php");

?>
