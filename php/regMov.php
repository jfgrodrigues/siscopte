<?php
	require_once ("conecta.php");
	session_start();
	if (!isset($_SESSION["user"]) || !isset($_SESSION["password"])) {
		header("Location: logon.html");
		exit;
	}
	$tab = "movimentacoes";
	$admCTIC = $_SESSION["user"];
	$sentido = $_POST["sentido"];
	$solicitante = $_POST["solicitante"];
	$sentido == "entrada_CTIC" ? $status = "aguardando_retirada": $status = "aguardando_aprovacao_saida";
	$tipo_equipamento = $_POST["eqto-type"];
	$tecnico = $_POST["tecnico"];
	
	$banco = "siscopte";
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
	$query = "SELECT dpto FROM usuarios WHERE name='$solicitante'";
	$res = mysql_query($query) or die("Erro na query do select ". mysql_error());	
	$array = mysql_fetch_array($res);
	$dpto = $array["dpto"];
	echo $dpto;
	$query = "INSERT INTO $tab(solicitante, dpto, tipo_eqto, sentido, status, admCTIC, tecnico, resp_CTIC, resp_Solicitante) VALUES('$solicitante', '$dpto', '$tipo_equipamento', '$sentido', '$status', '$admCTIC', '$tecnico', 'false', 'false')";
	mysql_query($query) or die("Erro na insercao no banco de dados ". mysql_error());
	header("Location: ../?regMov=success&ultInsert=".mysql_insert_id());
	exit;
?>