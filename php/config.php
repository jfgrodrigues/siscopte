<?php
	$host = "";
	$user = "";
	$pass = "";
	$banco = "";
	$link=@mysql_connect($host, $user, $pass)
		or die("Erro de conexão ".mysql_error());
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
?>