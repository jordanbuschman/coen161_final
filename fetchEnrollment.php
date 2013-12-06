<?php
	session_start();

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl1 = "enrollment";

	$userId = $_POST['userId'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	/*$result = array();
	$query = "SELECT sessionNum, COUNT(*) FROM $tbl1";

	$sql = mysql_query($query);

	$result = array();
	while ($row = mysql_fetch_assoc($sql))
		array_push($result, $row);*/
		
	$result = array();
	$query = "SELECT * FROM $tbl1 WHERE 1";
	
	
	$sql = mysql_query($query);
	$result = array();
	for ($i = 0; $i<7; $i++){
		$result[] = 0;	
	}
	while($row = mysql_fetch_assoc($sql)){
		$temp = $row['sessionNum'];
		$result[$temp] += 1;
	}
	
	echo json_encode($result);
?>
