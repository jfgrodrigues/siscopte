<?php
	require_once ("config.php");
	session_start();
	if (!isset($_SESSION["user"]) || !isset($_SESSION["password"])) {
		header("Location: logon.php");
		exit;
	}
	$tab = "movimentacoes";
	$admCTIC = $_SESSION["user"];
	$sentido = $_POST["sentido"];
	$solicitante = $_POST["solicitante"];
	$sentido == "entrada_CTIC" ? $status = "aguardando_retirada": $status = "aguardando_aprovacao_saida";
	$tipo_equipamento = $_POST["eqto-type"];
	$tecnico = $_POST["tecnico"];
	$timestamp = date("Y-m-d H-i-s"); 
	echo $timestamp;
	
	$query = "SELECT dpto FROM usuarios WHERE name='$solicitante'";
	$res = mysql_query($query) or die("Erro na query do select ". mysql_error());	
	$array = mysql_fetch_array($res);
	$dpto = $array["dpto"];
	echo $dpto;
	$query = "INSERT INTO $tab(solicitante, dpto, tipo_eqto, sentido, status, admCTIC, tecnico, resp_CTIC, resp_Solicitante, criacao) VALUES('$solicitante', '$dpto', '$tipo_equipamento', '$sentido', '$status', '$admCTIC', '$tecnico', 'false', 'false', '$timestamp')";
	mysql_query($query) or die("Erro na insercao no banco de dados ". mysql_error());
	header("Location: ../?regMov=success&ultInsert=".mysql_insert_id());
?>