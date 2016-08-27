<?php
	require_once("config.php");
	$usuarios = mysql_query("SELECT id, user FROM usuarios");
	$usrArray = array();
	while($linha = mysql_fetch_array($usuarios)){
		$usrArray[] = $linha;
	}
	$usuarios = json_encode($usrArray);
	echo $usuarios;
?>