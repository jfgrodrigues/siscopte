<?php
	session_start();
	session_destroy();
	header("Location: logon.php");
?>