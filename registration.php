<?php
	session_start();

	if (!$_POST['username']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	$childfirst = $_POST['firstName'];
	$childlast = $_POST['lastName'];
	$firstName = $_POST['parentfirstName'];
	$lastName = $_POST['parentlastName'];
	$username = $_SESSION['user']->username;
	$numEnrolled = $_SESSION['user']->numEnrolled++;
	$birth = $_POST['bdate'];
	$email = $_POST['email'];
	$grade = $_POST['grade'];
	$school = $_POST['school'];
	$session = $_POST['session'];
	$phone = $_POST['phone'];

	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	//$query = "UPDATE 'user' SET 'didEnroll'='1','child1first'='$childfirst','child1last'='$childlast','child1birth'='$birth','child1grade'='$grade','child1school'='$school','child1session'='$session','phone'='$phone','email'='$email','numEnrolled'='$numEnrolled' WHERE 'username' = '$username'";
	//$query = "UPDATE `user` SET `child1first`='Joe' WHERE `username`= 'adeartola'";
	
	mysql_query("UPDATE `user` SET `child1first`='John' WHERE `username`= 'adeartola'");

	header("location: index.php");

?>
