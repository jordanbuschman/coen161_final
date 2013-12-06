<?php
	session_start();

	if (!$_POST['userId'] || !$_POST['itemId']){ //Return if you maliciously navigated to the page
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

	$query;
	if ($count == 0) {
		$query = "DELETE FROM $tbl WHERE userId=$userId AND itemId=$itemId";
	}
	else {
		$query = "UPDATE $tbl SET count=$count WHERE userId=$userId AND itemId=$itemId";
	}
	mysql_query($query);
?>
