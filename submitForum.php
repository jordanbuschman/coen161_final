<?php
	session_start();
	if (!isset($_SESSION['user']) || !$_POST['numStars'] || !$_POST['review'])
		header("Location: index.php");

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "forum";

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	$username = $_SESSION['user']->username;
	$rating = $_POST['numStars'];
	$review = $_POST['review'];
		
	$query = "INSERT INTO $tbl (username, rating, review) VALUES ('$username', '$rating', '$review')";
	mysql_query($query);
	
?>
