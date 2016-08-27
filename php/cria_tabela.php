<?php
	require_once("config.php");
	$tabelas = array("dpto", "equipamentos", "movimentacoes", "resp_dpto", "tipo_eqto", "usuarios");
	foreach($tabelas as $value){
		switch($value){
			case "dpto": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									dpto_name VARCHAR(15) NOT NULL,
									PRIMARY KEY(id))"; break;
			case "equipamentos": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									service_tag VARCHAR(30) NOT NULL,
									patrimonio VARCHAR(10) NOT NULL,
									tipo VARCHAR (10) NOT NULL,
									localizacao VARCHAR (15) NULL,
									PRIMARY KEY(id))"; break;
			case "movimentacoes": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									solicitante VARCHAR(25) NOT NULL,
									dpto VARCHAR(10) NOT NULL,
									tipo_eqto VARCHAR (15) NOT NULL,
									patrimonio VARCHAR (15) NOT NULL,
									sentido VARCHAR(12) NOT NULL,
									status VARCHAR(30) NOT NULL,
									admCTIC VARCHAR (25) NOT NULL,
									tecnico VARCHAR(25) NOT NULL,
									resp_CTIC tinyint(1) NOT NULL,
									resp_Solicitante tinyint(1) NOT NULL,
									criacao timestamp NOT NULL,
									movimentacao timestamp NULL,
									aprov_ctic timestamp NULL,
									aprov_solicitante timestamp NULL,
									PRIMARY KEY(id))"; break;
			case "resp_dpto": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									user_name varchar(30) NOT NULL,
									dpto_name varchar(15) NOT NULL,
									PRIMARY KEY(id))"; break;
			case "tipo_eqto": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									tipo_nome VARCHAR(10) NOT NULL,
									PRIMARY KEY(id))"; break;
			case "usuarios": $criatab="CREATE TABLE IF NOT EXISTS $value(
									id INT(5) NOT NULL AUTO_INCREMENT,
									user VARCHAR(20) NOT NULL,
									password VARCHAR(30) NOT NULL,
									role VARCHAR (20) NOT NULL,
									dpto VARCHAR(10) NOT NULL,
									name VARCHAR(30) NOT NULL,
									PRIMARY KEY(id))"; break;
		}
		mysql_query($criatab) or die ("<br />Erro na criaчуo da tabela ".mysql_error());
	}
?>