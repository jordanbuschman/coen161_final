<?php
	session_start();

	if (!$_POST['userId']) { //Return if you maliciously navigated to the page
		header("location: shop.php");
		exit;
	}
	if ($_POST['userId'] == -1) { //Error, invalid userId passed in
		echo 0;
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
	
	$query = "SELECT SUM(count) from $tbl WHERE userId='$userId'";
	$result = mysql_query($query);

	if (!mysql_result($result, 0)) echo 0;
	else echo mysql_result($result, 0);
?>
