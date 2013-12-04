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
	
	$query = "SELECT * FROM $tbl WHERE userId=$userId AND itemId=$itemId";
	$result = mysql_query($query);
	$row = mysql_fetch_row($result);

	if ($row) { //Person already has this item in their cart, so all that needs to be done is incrementing count
		$query = "UPDATE $tbl SET count=count+$count WHERE userId=$userId AND itemId=$itemId";
	}
	else { //Add new item to user's cart
		$query = "INSERT INTO $tbl (userId, itemId, count) VALUES ('$userId', '$itemId', '$count')";
	}
	mysql_query($query);
?>
