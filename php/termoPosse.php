<?php
	require_once ("conecta.php");
	session_start();
	if (!isset($_SESSION["user"]) || !isset($_SESSION["password"])) {
		header("Location: logon.html");
		exit;
	}
	isset($_POST["idMov"]) ? $idMovimentacao = $_POST["idMov"] : $idMovimentacao = $_GET["update"];
	$tab = "movimentacoes";
	$banco = "siscopte";
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
	$query = "SELECT * FROM $tab WHERE id='$idMovimentacao'";
	$res = mysql_query($query) or die("Erro na query ". mysql_error());	
	$movimentacao = mysql_fetch_array($res);
	$name = $movimentacao["solicitante"];
	
	$query = "SELECT dpto FROM usuarios WHERE name='$name'";
	$resultado = mysql_query($query) or die("Erro na query ". mysql_error());
	$dpto = mysql_fetch_array($resultado);
	$dpto = $dpto["dpto"];
	
	$query = "SELECT name FROM usuarios WHERE role='Resp_CTIC'";
	$resultado = mysql_query($query) or die("Erro na query ". mysql_error());
	$respCTIC = mysql_fetch_array($resultado);
	$respCTIC = $respCTIC["name"];
	
	$query = "SELECT name FROM usuarios WHERE role='resp_Solicitante' AND dpto='$dpto'";
	$resultado = mysql_query($query) or die("Erro na query ". mysql_error());
	$respSolicitante = mysql_fetch_array($resultado);
	$respSolicitante = $respSolicitante["name"];
	if (isset($_GET["termoAssinado"]) AND $_GET["termoAssinado"] == "fail")
		$failMsg = 'role="alert"' ; 
	else
		$failMsg = "";
	
	$user = $_SESSION["user"];
	$query = "SELECT role FROM usuarios WHERE user='$user'";
	$resultado = mysql_query($query) or die("Erro na query ". mysql_error());
	$user_role = mysql_fetch_array($resultado);
	$user_role = $user_role["role"];
?>

<html lang="pt-br">          
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SisCoPTE | Termo de Posse | <?php echo $user ?></title>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<!--link href="../css/style.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Orbitron:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/scripts.js"></script>
	</head>
	<body>
		<header>
			<center><h2>Termo de posse - movimentação #<b><?php echo $idMovimentacao ?></b></h2></center>
		</header><br />
		<div class="container jumbotron">
			<form name="termoPosse" method="post" action="?assinar=true&id=<?php echo $idMovimentacao ?>&sentido=<?php echo $movimentacao["sentido"] ?>">
			<?php if($movimentacao["sentido"]=="saida_CTIC"): ?>
				<?php if($user_role == "Resp_CTIC"): ?>
				<p><i>Eu, <b><?php echo $respCTIC ?></b>, declaro que a partir de agora concedo a posse temporária do <b><?php echo $movimentacao["tipo_eqto"] ?></b> a ser designado pelo técnico <b><?php echo $movimentacao["tecnico"] ?></b>, a <b><?php echo $respSolicitante ?></b>, responsável pelo departamento <b><?php echo $dpto?></b>, passando o(a) mesmo(a) a se reponsabilizar pelo correto uso e guarda do mesmo, conforme Decreto nº XXXXX/XXXX.</i></p>
				<?php elseif($user_role == "Resp_Solicitante"): ?>
				<p><i>Eu, <b><?php echo $respSolicitante ?></b>, responsável pelo departamento <b><?php echo $dpto?></b>, declaro que a partir de agora assumo a posse temporária do <b><?php echo $movimentacao["tipo_eqto"] ?></b> patrimônio <b><?php echo $movimentacao["patrimonio"] ?></b>, me reponsabilizando por manter o correto uso e guarda do mesmo, conforme Decreto nº XXXXX/XXXX.</i></p>
				<?php endif ?>
				<br />
			<?php elseif($movimentacao["sentido"]=="entrada_CTIC"): ?>
				<?php if($user_role == "Resp_CTIC"): ?>
				<p><i>Eu, <b><?php echo $respCTIC ?></b>, declaro que a partir de agora volto a deter a posse temporária do <b><?php echo $movimentacao["tipo_eqto"] ?></b> patrimônio <b><?php echo $movimentacao["patrimonio"] ?></b>, recebida de <b><?php echo $respSolicitante ?></b>, responsável pelo departamento <b><?php echo $dpto?></b>, passando, a partir de agora, a me reponsabilizar pelo correto uso e guarda do mesmo, conforme Decreto nº XXXXX/XXXX.</i></p>
				<?php elseif($user_role == "Resp_Solicitante"): ?>
				<p><i>Eu, <b><?php echo $respSolicitante ?></b>, responsável pelo departamento <b><?php echo $dpto?></b>, declaro que a partir de agora devolvo a posse temporária do <b><?php echo $movimentacao["tipo_eqto"] ?></b> patrimônio <b><?php echo $movimentacao["patrimonio"] ?></b>, a <b><?php echo $respCTIC ?></b>, que passa a se reponsabilizar por manter o correto uso e guarda do mesmo, conforme Decreto nº XXXXX/XXXX.</i></p>
				<?php endif ?>
			<?php endif ?>
				<br />
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label ">Senha</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="password" name="password" placeholder="Insira a senha para assinatura eletrônica do termo de posse">
					</div>
				</div>
				<br /><br /><center>
				<div id="msg" <?php echo $failMsg ?>>
					<?php
						if(isset($_GET["termoAssinado"]) AND $_GET["termoAssinado"] == "fail") {
							echo "<b>Senha não confere! Digite a senha novamente</b>";
							echo "<script>assinaturaTermoFail()</script>";
						}
					?>
				</div><br />
				<div class="form-group">
					<button type="submit" class="btn btn-primary" class="form-control">Assinar Termo de posse</button>
				</div>
			</form>
			<form name="voltar" action="../">	
				<button class="btn btn-danger">Voltar à página Anterior</button></center>
			</form>
			
		</div>
		<?php
			if (isset($_GET["assinar"]) AND $_GET["assinar"] == "true" AND isset($_POST["password"]) AND $_POST["password"] == $_SESSION["password"] AND $user_role == "Resp_CTIC" AND $_GET["sentido"] == "saida_CTIC") {
				$id = $_GET["id"];
				$update = "UPDATE $tab SET resp_CTIC = '1', status = 'posse_temporaria_cedida' WHERE id = '$id'";
				mysql_query($update) or die ("Erro na atualização da movimentação ".mysql_error());
				header("Location: ../?termoAssinado=success&update=$id");
				exit;
			} elseif (isset($_GET["assinar"]) AND $_GET["assinar"] == "true" AND isset($_POST["password"]) AND $_POST["password"] == $_SESSION["password"] AND $user_role == "Resp_Solicitante" AND $_GET["sentido"] == "saida_CTIC") {
				$id = $_GET["id"];
				$update = "UPDATE $tab SET resp_Solicitante = '1', status = 'posse_temporaria_transferida' WHERE id = '$id'";
				mysql_query($update) or die ("Erro na atualização da movimentação ".mysql_error());
				header("Location: ../?termoAssinado=success&update=$id");
				exit;
			} elseif (isset($_GET["assinar"]) AND $_GET["assinar"] == "true" AND isset($_POST["password"]) AND $_POST["password"] == $_SESSION["password"] AND $user_role == "Resp_CTIC" AND $_GET["sentido"] == "entrada_CTIC") {
				$id = $_GET["id"];
				$update = "UPDATE $tab SET resp_CTIC = '1', status = 'posse_temporaria_restabelecida' WHERE id = '$id'";
				mysql_query($update) or die ("Erro na atualização da movimentação ".mysql_error());
				header("Location: ../?termoAssinado=success&update=$id");
				exit;
			} elseif (isset($_GET["assinar"]) AND $_GET["assinar"] == "true" AND isset($_POST["password"]) AND $_POST["password"] == $_SESSION["password"] AND $user_role == "Resp_Solicitante" AND $_GET["sentido"] == "entrada_CTIC") {
				$id = $_GET["id"];
				$update = "UPDATE $tab SET resp_Solicitante = '1', status = 'posse_temporaria_devolvida' WHERE id = '$id'";
				mysql_query($update) or die ("Erro na atualização da movimentação ".mysql_error());
				header("Location: ../?termoAssinado=success&update=$id");
				exit;
			} elseif (isset($_GET["assinar"]) AND $_GET["assinar"] == "true" AND isset($_POST["password"]) AND $_POST["password"] != $_SESSION["password"]) {
				$id = $_GET["id"];
				header("Location: ?termoAssinado=fail&update=$id");
			}
		?>
	</body>
</html>