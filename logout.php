<?php
	session_start();
	session_destroy();
	header("Location: jordanIndex.php");
?>
