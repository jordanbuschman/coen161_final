<?php
	session_start();
	
	if(!$_POST['userId'])
		header("Location: index.php");

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl1 = "cart";
	$tbl2 = "item";

	$userId = $_POST['userId'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$result = array();
	$query = "SELECT $tbl2.name, $tbl1.count, $tbl2.price, $tbl2.discount FROM $tbl1 JOIN $tbl2 ON $tbl1.userId=$userId && $tbl1.itemId=$tbl2.id ORDER BY $tbl2.name ASC";

	$sql = mysql_query($query);

	$result = array();
	while ($row = mysql_fetch_assoc($sql))
		array_push($result, $row);
	
	echo json_encode($result);
?>
