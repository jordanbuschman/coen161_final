<?php
	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$username = $_POST['username'];
	$query = "SELECT * FROM $tbl WHERE username='$username'";	
	$result = mysql_query($query);
	$count=mysql_num_rows($result);

	if ($count > 0) echo "T";
	else echo "F";
?>
