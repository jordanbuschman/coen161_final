<?php
	session_start();

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "orderHistory";

	$userId = $_POST['userId'];
	$creditCard = $_POST['creditCard'];
	$csv = $_POST['csv'];
	$total = $_POST['total'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");

	$query = "INSERT INTO $tbl (userId, total, creditCard, csv) VALUES ($userId, $total, $creditCard, $csv)";
	mysql_query($query);
?>
