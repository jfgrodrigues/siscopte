<?php
	require_once("config.php");
	$user = $_GET["user"];
	$usuario = mysql_query("SELECT user FROM usuarios WHERE user = '$user'");
	if(mysql_num_rows($usuario) > 0){
		$chk = true;
	} else {
		$chk = false;
	}
	echo $chk;
?>