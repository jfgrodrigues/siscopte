<?php
	require_once ("config.php");
	if(isset($_GET["cad"]) AND $_GET["cad"] == "user"){
		$user = $_POST["user"];
		$password = $_POST["password"];
		$role = $_POST["role"];
		$dpto = $_POST["dpto"];
		$name = $_POST["nome"];
		$query = "INSERT INTO usuarios(user, password, role, dpto, name) VALUES('$user', '$password', '$role', '$dpto', '$name')";
		mysql_query($query) or die("Erro no cadastro ". mysql_error());
		header("Location: ../?cadastro=success&ultInsert=".mysql_insert_id()."&cad=user");
	} elseif(isset($_GET["cad"]) AND $_GET["cad"] == "dpto"){
		$dpto = $_POST["dpto"];
		$query = "INSERT INTO dpto(dpto_name) VALUE('$dpto')";
		mysql_query($query) or die("Erro no cadastro ". mysql_error());
		header("Location: ../?cadastro=success&ultInsert=".mysql_insert_id()."&cad=dpto");
	} elseif(isset($_GET["cad"]) AND $_GET["cad"] == "tp_eqto"){
		$tipo_eqto = $_POST["tipo_eqto"];
		$query = "INSERT INTO tipo_eqto(tipo_nome) VALUE('$tipo_eqto')";
		mysql_query($query) or die("Erro no cadastro ". mysql_error());
		header("Location: ../?cadastro=success&ultInsert=".mysql_insert_id()."&cad=tipo_eqto");
	} elseif(isset($_GET["cad"]) AND $_GET["cad"] == "eqto"){
		$tipo_eqto = $_POST["tipo_eqto"];
		$patrimonio = $_POST["patrimonio"];
		$service_tag = $_POST["service_tag"];
		$query = "INSERT INTO equipamentos(tipo, service_tag, patrimonio) VALUES('$tipo_eqto', '$service_tag', '$patrimonio')";
		mysql_query($query) or die("Erro no cadastro ". mysql_error());
		header("Location: ../?cadastro=success&ultInsert=".mysql_insert_id()."&cad=eqto");
	}
?>
