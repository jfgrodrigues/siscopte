<?php
	$host = "127.0.0.1";
	$user = "root";
	$pass = "";
	$link=@mysql_connect($host, $user, $pass)
		or die("Erro de conex�o ".mysql_error());
?>