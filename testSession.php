<?php
session_start();
if(isset($_SESSION['username'])){
	echo "Welcome ". $_SESSION['username'] ."!";
	//session_destroy();
}else{
	echo "NotLoggedIn";
	session_destroy();
}
?>
