<?php
	require_once ("config.php");
	session_start();
	if (!isset($_SESSION["user"]) || !isset($_SESSION["password"])) {
		header("Location: logon.php");
		exit;
	}
	$idMovimentacao = $_POST["idMov"];
	$tab = "movimentacoes";
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
	$user = $_SESSION["user"];
?>

<html lang="pt-br">          
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SisCoPTE | Realizar Movimentação | <?php echo $user ?></title>
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Orbitron:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/scripts.js"></script>
	</head>
	<body>
		<header>
			<h2>Editar informações da movimentação #<b><?php echo $idMovimentacao ?></b></h2>
		</header>
		<div class="container jumbotron">
			<form name="edtMov" method="post" action="?mudar=true&id=<?php echo $idMovimentacao ?>">
				<p>Usuário solicitante: <?php echo $movimentacao["solicitante"] ?></p>
				<p>Departamento: <?php echo $dpto ?></p>
				<p>Tipo de Equipamento: <?php echo $movimentacao["tipo_eqto"] ?></p>
				<p>Sentido: <?php echo $movimentacao["sentido"] ?></p>
				<div class="form-group">
					<label for="patrimonio" class="col-sm-3 control-label ">Patrimônio </label>
					<select name="patrimonio">
						<option value="<?php echo $movimentacao["patrimonio"] ?>"><?php echo $movimentacao["patrimonio"] ?></option>
						<?php
							$tipo = $movimentacao["tipo_eqto"];
							$query = "SELECT patrimonio FROM equipamentos WHERE tipo='$tipo'";
							$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
							while ($row = mysql_fetch_assoc($resultado)) {
								echo '<option value="'.$row['patrimonio'].'">'.$row['patrimonio'].'</option>';
							}
						?>	
					</select>
				</div><br />
				<div class="form-group">
					<center><button type="submit" class="btn btn-primary" class="form-control">Realizar Movimentação</button></center>
				</div>
			</form>
				<center><button class="btn btn-danger" onclick="window.location='../'">Voltar à página Anterior</button></center>
		</div>
		<?php
			if (isset($_GET["mudar"]) AND $_GET["mudar"] == "true" AND isset($_POST["patrimonio"])) {
				$patrimonio = $_POST["patrimonio"];
				$id = $_GET["id"];
				$timestamp = date("Y-m-d H-i-s"); 
				$update = "UPDATE $tab SET patrimonio = '$patrimonio', status = 'realizando_movimentacao', movimentacao = '$timestamp' WHERE id = '$id'";
				mysql_query($update) or die ("Erro na atualização da movimentação ".mysql_error());
				header("Location: ../?edtMov=success&update=$id");
			}
		?>
	</body>
</html>
