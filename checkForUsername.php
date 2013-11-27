<?php
	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$username = $_POST['username'];
	$query = "SELECT COUNT(*) FROM $tbl WHERE username='$username'";	
	$result = mysql_query($query);
	$count=mysql_fetch_assoc($result);
	
	if ($count['total'] == 0) echo "F";
	else echo "T";
?>
