<?php
	session_start();

	/*if (!$_POST['username']){ //Return if you maliciously navigated to the page
		header("location: index.php");
		exit;
	}*/

	$host = "localhost";
	$sql_username = "root";
	$sql_password = "";
	$db = "kidzcamp";
	$tbl = "user";

	$childfirst = $_POST['firstName'];
	$childlast = $_POST['lastName'];
	$firstName = $_POST['parentFirstName'];
	$lastName = $_POST['parentLastName'];
	$username = $_SESSION['user']->username;
	
	$birth = $_POST['bdate'];
	$email = $_POST['email'];
	$grade = $_POST['grade'];
	$school = $_POST['school'];
	$session = $_POST['session'];
	$phone = $_POST['phone'];
	$enrolled = 1;
	
	mysql_connect($host, $sql_username, $sql_password) or die ("Cannot connect to SQL server.");
	mysql_select_db("$db") or die ("Cannot select kidzcamp database. (Did you run init.sql yet?)");
	
	if($_SESSION['user']->numEnrolled == 0){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child1first`='$childfirst',`child1last`='$childlast',`child1birth`='$birth',`child1grade`='$grade',`child1school`='$school',`child1session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	}
	else if($_SESSION['user']->numEnrolled == 1){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child2first`='$childfirst',`child2last`='$childlast',`child2birth`='$birth',`child2grade`='$grade',`child2school`='$school',`child2session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	
	}
	else if($_SESSION['user']->numEnrolled == 2){
		$numEnrolled = $_SESSION['user']->numEnrolled+1;
		$query = "UPDATE `user` SET `didEnroll`='$enrolled', `child3first`='$childfirst',`child3last`='$childlast',`child3birth`='$birth',`child3grade`='$grade',`child3school`='$school',`child3session`='$session',`phone`='$phone',`email`='$email',`numEnrolled`='$numEnrolled' WHERE `username` = '$username'";
	
	}
	//$query = "UPDATE `user` SET `child1first`= '$childfirst', `child1last`='$childlast' WHERE `username`= 'adeartola'";
	//$query = "UPDATE  `kidzcamp`.`user` SET  `child1first` =  'Potato' WHERE  `user`.`id` =7";
	mysql_query($query);

	header("location: index.php");

?>
