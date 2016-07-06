<?php
	require_once ("conecta.php");
	$banco = "siscopte";
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
	isset($_GET["auth"]) ? $authMsg = 'role="alert"' : $authMsg = "";
?>

<html lang="pt-br">          
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>SisCoPTE - Logon</title>
		
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link href="../css/style.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/scripts.js"></script>
	</head>
	<body>
		<header>
			<h1><center>SisCoPTE - Logon</center></h1>
		</header>
		<div class="container jumbotron">
			<form name="logon" method="post" action="?logon=attempt">
				<div class="form-group">
					<label for="user" class="col-sm-3 control-label ">Usuário</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="user" name="user" placeholder="Usuário">
					</div>
				</div><br />
				<div class="form-group">
					<label for="password" class="col-sm-3 control-label ">Senha</label>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="password" name="password" placeholder="Senha">
					</div>
				</div>
				<br /><br />
				<div class="form-group">
					<center><button type="submit" class="btn btn-primary" class="form-control">Entrar</button></center>
				</div>
				
				<center><div id="authMsg" <?php echo $authMsg ?>>
					<?php
						if (isset($_GET["auth"]) AND $_GET["auth"] == "success") {
							echo "Autenticação realizada com sucesso! Redirecionando...";
						} elseif (isset($_GET["auth"]) AND $_GET["auth"] == "fail") {
							echo "Usuário / senha incorreta! Tente novamente";
						}
					?>
				</div></center>
			</form>
		</div>
		<?php 
		if(isset($_GET["logon"]) AND $_GET["logon"] == "attempt") {
			$user = $_POST["user"];
			$password = $_POST["password"];
			$query = mysql_query("SELECT * FROM usuarios WHERE user = '$user' and password = '$password'")
				or die("Erro na query ". mysql_error());
			$row = mysql_num_rows($query);
			if ($row == 1) {
				session_start();
				$_SESSION["user"] = $_POST["user"];
				$_SESSION["password"] = $_POST["password"];
				echo "<script>successAuth()</script>";
			} else {
				header("Location: ?auth=fail");
			}
		}	
		if(isset($_GET["auth"]) AND $_GET["auth"] == "fail")
			echo "<script>failAuth()</script>";
		?>
	</body>
</html>

