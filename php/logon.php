<?php
	require_once ("config.php");
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
			<div id="cadastro" style="display:none">
				<form name="cadastrar" id="cadastrar" method="post" action="?p=cadastrar">
					<div class="form-group">
						<label for="nome" class="col-sm-3 control-label ">Nome</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Insira o seu nome">
						</div>
					</div>
					<div class="form-group">
						<label for="user" class="col-sm-3 control-label ">Usuário</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="user" name="user" placeholder="Nome de usuário no sistema">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label ">Senha</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" name="password" placeholder="Senha para acessar o sistema">
						</div>
					</div>
					<div class="form-group">
						<label for="dpto">Departamento</label>
						<select class="form-control" id="dpto" name="dpto">
							<option>CTIC</option>
							<option>CJ</option>
							<option>DRH</option>
						</select>
					</div>
					<div class="form-group">
						<label for="role"><i>Role</i> (perfil)</label>
						<select class="form-control" id="role" name="role">
							<option></option>
							<option id="admCTIC">admCTIC</option>
							<option id="Resp_CTIC">Resp_CTIC</option>
							<option id="tecnico">tecnico</option>
							<option id="Resp_Solicitante" style="display:none">Resp_Solicitante</option>
							<option id="usuario">usuario</option>
						</select>
					</div>
					<div id="chkUser"></div>
					<div class="form-group">
						<center><button type="submit" class="btn btn-primary form-control" id="btn_cadastrar">Cadastrar</button></center>
					</div>
				</form>
				<center><a role="button" class="btn btn-danger form-control" href="./logon.php" id="btn_voltar">Voltar</a></center>
			</div>
			<div id="logon">
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
						<center><button type="submit" class="btn btn-primary form-control">Entrar</button></center>
					</div>
					
				</form>
				<?php if(!(isset($_GET["auth"]) AND $_GET["auth"] == "success")): ?> <center><a role="button" class="btn btn-danger form-control" href="#" onclick="setCadastrar();">Cadastrar-se</a></center><?php endif ?>
					<br /><center><div id="authMsg" <?php echo $authMsg ?>><span id="sinal"></span>
						<?php
							if (isset($_GET["auth"]) AND $_GET["auth"] == "success") {
								echo "<script>successAuth()</script>";
								echo " Autenticação realizada com sucesso! Redirecionando...";
							} elseif (isset($_GET["auth"]) AND $_GET["auth"] == "fail") {
								echo " Usuário / senha incorreta! Tente novamente";
							} elseif(isset($_GET["cadastro"]) AND $_GET["cadastro"] == "success"){
								$id = $_GET["ultInsert"];
								$query = "SELECT * FROM usuarios WHERE id = '$id'";
								$resultado = mysql_query($query) or die("Erro na busca de verificação da última inserção ". mysql_error());
								$usr = mysql_fetch_array($resultado);
								echo "<script>successCadastro()</script>";
								echo " <b>".$usr["name"]."</b>, seu usuário foi cadastrado com sucesso!!!<br />Usuário: <b>".$usr["user"]."</b><br />senha: <b>".$usr["password"]."</b><br />Use as credenciais acima para acessar o ambiente de teste do SisCoPTE";
							
							}
						?>
					</div></center>
			</div>
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
				header("Location: ?auth=success");
			} else {
				header("Location: ?auth=fail");
			}
		}	
		if(isset($_GET["auth"]) AND $_GET["auth"] == "fail")
			echo "<script>failAuth()</script>";
		?>
	</body>
</html>

