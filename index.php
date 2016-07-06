<?php
	require_once ("./php/conecta.php");
	session_start();
	if (!isset($_SESSION["user"]) || !isset($_SESSION["password"])) {
		header("Location: php/logon.php");
		exit;
	}
	$user = $_SESSION["user"];
	$tab = "usuarios";
	$banco = "siscopte";
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
	
	$query = "SELECT * FROM $tab WHERE user = '$user'";
	$resultado = mysql_query($query)
				or die ("Erro na query ". mysql_error());
	$usr = mysql_fetch_array($resultado);
	$profile = $usr["role"];
	$nome = $usr["name"];
	
	isset($_GET["action"]) ? $action = $_GET["action"] : $action = "none";
	
	isset($statusEntrada) ? $statusEntrada = $statusEntrada : $statusEntrada = "";
	isset($statusSaida) ? $statusSaida = $statusSaida : $statusSaida = "";
	isset($_GET["regMov"]) ? $regMov = $_GET["regMov"] : $regMov = "";
	$regMov == "success" ? $success = 'role="alert"' : $success = "";
	isset($_GET["ultInsert"]) ? $ultimoInsert =  $_GET["ultInsert"] : $ultimoInsert = "";
	
	if ((isset($_GET["termoAssinado"]) AND $_GET["termoAssinado"] == "success") OR (isset($_GET["edtMov"]) AND $_GET["edtMov"] == "success"))
		$successMsg = 'role="alert"';
	else
		$successMsg = "";
	
	$query = "SELECT dpto FROM usuarios WHERE user='$user'";
	$resultado = mysql_query($query) or die("Erro na query ". mysql_error());
	$dpto = mysql_fetch_array($resultado);
	$dpto = $dpto["dpto"];
?>

<html lang="pt-br">          
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>SisCoPTE | <?php echo $user ?></title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Orbitron:700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Merriweather+Sans' rel='stylesheet' type='text/css'>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
	</head>
	<body>
	<div class="page-header">
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="?about=SisCoPTE">SisCoPTE</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="./">Início <span class="sr-only">(current)</span></a></li>
			  </ul>
			  <form class="navbar-form navbar-left" role="search"  method="post" action="?search=true">
				<div class="form-group">
				  <input type="text" class="form-control" placeholder="Busque pelo patrimônio">
				</div>
				<button type="submit" class="btn btn-default glyphicon glyphicon-search"> Procurar</button>
			  </form>
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="?about=profile-<?php echo $profile ?>">Perfil: <?php echo $profile ?></a></li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle glyphicon glyphicon-user" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $user ?> <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li class="disabled"><a href="?action=changePassword">Alterar Senha</a></li>
					<li><a href="?about=SisCoPTE">Sobre o <i>SisCoPTE</i></a></li>
					<li><a href="?about=license">Licença (MIT)</a></li>
					<li role="separator" class="divider"></li>
					<li><a href="./php/logoff.php">Logoff</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
		  </div>
		</nav>
	</div>
	<div class="container">	
		<h1>SisCoPTE</h1><br />
		<h2>Bem vindo(a), <?php echo $nome ?>!</h2>
		<div id="about" class="container">
		<?php if (isset($_GET["about"]) AND $_GET["about"] == "SisCoPTE"): ?>
			<h3><b>Sobre o <i>SisCoPTE</i> - Sistema de Controle de Posse Temporária de Equipamento</b></h3>
			<p><b>Versão:α</b></p>
			<P>O sistema "nasce" da ideia de diminuir o uso de papel na execução das atividades de um determinado orgão do poder público do Estado de São Paulo. O sistema atende a um processo específico, que é o de registro de posse temporária de equipamentos de TI.</P>
			<h4><b>Escopo:</b></h4>
			<p>Basicamente, fazer o registro (salvar numa base de dados) e controle eletrônico de posse temporária de equipamento de TI (notebooks, monitores, "CPUs") e suas movimentações (departamento "usuário" -> TI, ou vice-versa). Baseado num procedimento já existente (no local em questão), mas feito em papel.</p>
			<p>O papel e a visão que cada ator tem no uso do sistema é diferente. Segue um resumo do papel desempenhado por cada um no sistema:<p>
			<ul>
				<li><b>admCTIC:</b> este role consegue criar as movimentações no sistema, visualizar todas as movimentações registradas em todos os status e realizar as tarefas administrativas no sistema (como cadastrar outros usuários, por exemplo) <a href="?about=profile-admCTIC">(leia mais)</a>;</li>
				<li><b>tecnico:</b> este perfil consegue visualizar as movimentações a fazer assimiladas a ele (pelo perfil acima) e assinalar no sistema a movimentação feita e o patrimonio do equipamento em questão <a href="?about=profile-tecnico">(leia mais)</a>;</li>
				<li><b>Resp_Solicitante:</b> pode visualizar e assinar eletronicamente os termos referentes às movimentações do departamento pelo qual responde enquanto estão "em aberto" <a href="?about=profile-Resp_Solicitante">(leia mais)</a>;</li>
				<li><b>Resp_CTIC:</b> visualiza e assina eletronicamente os termos de posse (concessão e recebimento) de todas as movimentações enquanto estão "em aberto" <a href="?about=profile-Resp_CTIC">(leia mais)</a>.</li>
			</ul>
			<p>A interface busca ser simples, objetiva, fácil de aprender a usar e entender, dando feedback ao usuário (de sucesso ou erro) a cada ação tomada e mostrando apenas elementos essenciais.</p>
			<p>O sistema foi desenvolvido e lançado com código-aberto, sob a <a href="">licença MIT</a>. O código-fonte pode ser consultado e baixado <a href="https://github.com/jfgrodrigues/siscopte" target="_blank">aqui</a>. Esta versão alpha não inclui os códigos de criação das bases de dados.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php elseif (isset($_GET["about"]) AND $_GET["about"] == "profile-admCTIC"): ?>
			<h3><b>Sobre o perfil <i>admCTIC</i></b></h3>
			<p>É o único perfil que consegue visualizar todas as movimentações em todos os <i>status</i>. Também é o único que consegue criar novos usuários, redefinir senha de outros usuários, cadastrar equipamentos, ou seja, é o perfil que possui funções administrativas no sistema, apesar de que nesta primeira versão, apenas as funções essenciais para registro de movimentações foram incluídas.</p>
			<p>A navegação é muito simples: na barra superior pode-se realizar busca das movimentações registradas pelo número de patrimônio (à esquerda), e à direita pode-ser ver o perfil do usuário conectado e encontrar os botões para fazer <i>logoff</i> e informações de <a href="?about=license">licenciamento</a> e <a href="?about=SisCoPTE">sobre o sistema</a>.</p>
			<p>Abaixo, após a saudação de boas vindas, o usuário encontra uma lista de botões com cada tarefa a fazer: registrar movimentação, cadastrar usuário e cadastrar equipamento. Nesta versão, apenas a função "registrar movimentação" se encontra habilitada. Clicando no botão, é aberto um formulário para a execução da tarefa. abaixo disso, há um grid onde é possível visualizar as moviemntações registradas, separadas entre entrada / saída do departamento de TI.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php elseif (isset($_GET["about"]) AND $_GET["about"] == "profile-tecnico"): ?>
			<h3><b>Sobre o perfil <i>tecnico</i></b></h3>
			<p>Este perfil consegue visualizar todas as movimentações a realizar atribuídas ao seu usuário pelo <i>admCTIC</i>, e assinalar que as realiza.</p>
			<p>A navegação é muito simples: na barra superior pode-se realizar busca das movimentações realizadas pelo número de patrimônio (à esquerda), e à direita pode-ser ver o perfil do usuário conectado e encontrar os botões para fazer <i>logoff</i> e informações de <a href="?about=license">licenciamento</a> e <a href="?about=SisCoPTE">sobre o sistema</a>.</p>
			<p>Abaixo, após a saudação de boas vindas, o usuário encontra uma lista de movimentações a realizar, separadas entre entrada / saída do departamento de TI.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php elseif (isset($_GET["about"]) AND $_GET["about"] == "profile-Resp_Solicitante"): ?>
			<h3><b>Sobre o perfil <i>Resp_Solicitante</i></b></h3>
			<p>Este perfil consegue visualizar todas as movimentações que necessitam de assinatura do termo de posse, assinando eletronicamente esses termos.</p>
			<p>A navegação é muito simples: na barra superior pode-se realizar busca das movimentações de seu departamento pelo número de patrimônio (à esquerda), e à direita pode-ser ver o perfil do usuário conectado e encontrar os botões para fazer <i>logoff</i> e informações de <a href="?about=license">licenciamento</a> e <a href="?about=SisCoPTE">sobre o sistema</a>.</p>
			<p>Abaixo, após a saudação de boas vindas, o usuário encontra um grid com os termos a serem assinados, separadas entre equipamentos solicitados / devolvidos ao departamento de TI.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php elseif (isset($_GET["about"]) AND $_GET["about"] == "profile-Resp_CTIC"): ?>
			<h3><b>Sobre o perfil <i>Resp_CTIC</i></b></h3>
			<p>Este perfil visualiza e assina eletronicamente os termos de posse (concessão e recebimento) de todas as movimentações enquanto estão "em aberto".</p>
			<p>A navegação é muito simples: na barra superior pode-se realizar busca das movimentações de seu departamento pelo número de patrimônio (à esquerda), e à direita pode-ser ver o perfil do usuário conectado e encontrar os botões para fazer <i>logoff</i> e informações de <a href="?about=license">licenciamento</a> e <a href="?about=SisCoPTE">sobre o sistema</a>.</p>
			<p>Abaixo, após a saudação de boas vindas, o usuário encontra um grid com os termos a serem assinados, separadas entre equipamentos que entram / saem ao departamento de TI.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php elseif (isset($_GET["about"]) AND $_GET["about"] == "license"): ?>
			<h3><b>The MIT License (MIT)</b></h3><br />
			<p>Copyright (c) 2016 Jean F. G. Rodrigues</p><br />
			<p>Permission is hereby granted, free of charge, to any person obtaining a copy of
				this software and associated documentation files (the "Software"), to deal in
				the Software without restriction, including without limitation the rights to
				use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
				the Software, and to permit persons to whom the Software is furnished to do so,
				subject to the following conditions:</p><br />
			<p>The above copyright notice and this permission notice shall be included in all
				copies or substantial portions of the Software.</p><br />
			<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
				IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
				FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
				COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
				IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
				CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
			<a href="./" class="glyphicon glyphicon-minus"> Recolher</a>
		<?php endif ?>
		</div>
		<div id="search" class="container">
		</div><br /><br />
		<?php if($profile == "admCTIC"): ?>
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  <div class="btn-group" role="group">
				<a type="button" class="btn btn-primary btn-lg" href="?action=regMov">Registrar Movimentação</a>
			  </div>
			  <div class="btn-group" role="group">
				<a type="button" class="btn btn-primary btn-lg" href="?action=regUsr" disabled="disabled">Cadastrar Usuário</a>
			  </div>
			  <div class="btn-group" role="group">
				<a type="button" class="btn btn-primary btn-lg" href="?action=regEqt" disabled="disabled">Cadastrar Equipamento</a>
			  </div>
			</div> <br /> <center>
			<div id="msg" <?php echo $success?>>
				<?php 
					if ($regMov == "success") {
						$query = "SELECT * FROM movimentacoes WHERE id='$ultimoInsert'";
						$resultado = mysql_query($query) or die("Erro na query ".mysql_error());
						$ultimoInsert = mysql_fetch_array($resultado);
						echo "<b>Movimentação registrada com sucesso!</b><br />Dados: Ticket #: <b>".$ultimoInsert["id"]."</b><br />Tipo de Equipamento: <b>".$ultimoInsert["tipo_eqto"]."</b><br />Solicitante: <b>".$ultimoInsert["solicitante"]."</b><br />Sentido: <b>".$ultimoInsert["sentido"]."</b>";
					}
				
				?>
			</div></center>
			<?php
				if (isset($_GET["regMov"])) {
					echo "<script>moveRecSuccess()</script>";
				}
			?>
	<?php if ($action != "none") echo '<div class="container jumbotron">'; ?>
			<?php if ($action == "regMov"): ?>
			<form name="regMov" method="post" action="./php/regMov.php" onsubmit="return chkRegMov();">
				<div class="form-group">
					<input type="radio" name="sentido" value="entrada_CTIC" checked> Entrada CTIC<br />
					<input type="radio" name="sentido" value="saida_CTIC"> Saida CTIC
				</div>
				<div class="form-group">
					<label for="solicitante">Solicitante</label>
					<select name="solicitante">
						<option value=""></option>
						<?php
							$query = "SELECT name, dpto FROM usuarios WHERE role='usuario' ORDER BY name";
							$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
							while ( $row = mysql_fetch_assoc( $resultado ) ) {
								echo '<option value="'.$row['name'].'">'.$row['name'].' - '.$row['dpto'].'</option>';
							}
						?>	
					</select>
				</div>
				<div class="form-group">
					<label for="eqto-type">Tipo de equipamento</label>
					<select name="eqto-type">
						<option value=""></option>
						<?php
							$query = "SELECT tipo_name FROM tipo_eqto ORDER BY id";
							$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
							while ($row = mysql_fetch_assoc($resultado)) {
								echo '<option value="'.$row['tipo_name'].'">'.$row['tipo_name'].'</option>';
							}
						?>	
					</select>
				</div>
				<div class="form-group">
					<label for="tecnico">Técnico Responsável</label>
					<select name="tecnico">
						<option value=""></option>
						<?php
							$query = "SELECT name FROM usuarios WHERE role='tecnico' ORDER BY name";
							$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
							while ($row = mysql_fetch_assoc($resultado)) {
								echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
							}
						?>	
					</select>
				</div>
				<div class="form-group">
					<center><button type="submit" class="btn btn-primary" class="form-control">Registrar</button></center>
				</div>
				<div id="errMsg"></div>
			</form>
			<?php elseif ($action == "regUsr"): ?>
			<form name="regUsr" method="post" action="php/logon.php">
			</form>
			
			<?php elseif ($action == "regEqt"): ?>
			<form name="regEqt" method="post" action="php/logon.php">
			</form>
			<?php endif ?>
			</div><br />
			<h2>Movimentações</h2>
			<?php 
				isset($_POST["sentido"]) ? $sentido = $_POST["sentido"] : $sentido = "saida_CTIC"; 
				if ($sentido == "entrada_CTIC") {
					$statusEntrada = "checked";
				} else {
					$statusSaida = "checked";
				}
			?>
			<center><form method="post" action="./">
				<div class="form-group">
					<input type="radio" name="sentido" value="entrada_CTIC" <?php echo $statusEntrada ?>> Entrada CTIC
					<input type="radio" name="sentido" value="saida_CTIC" <?php echo $statusSaida ?>> Saida CTIC
					<button type="submit" class="btn btn-primary" class="form-control">Pesquisar</button>
				</div>
			</form></center>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Ticket #</th>
						<th>Solicitante</th>
						<th>Tipo Equipamento</th>
						<th>Patrimonio</th>
						<th>Técnico Responsável</th>
						<th>Status</th>
						<th>Termo de posse CTIC?</th>
						<th>Termo de posse solicitante?</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' ORDER BY id DESC";
						$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
						while ( $row = mysql_fetch_assoc( $resultado ) ) {
							$statusRespCTIC = $row["resp_CTIC"];
							$statusRespCTIC == "0" ? $statusRespCTIC = "Não Confirmado" : $statusRespCTIC = "Confirmado";
							$statusRespSolicitante = $row["resp_Solicitante"];
							$statusRespSolicitante == "0" ? $statusRespSolicitante = "Não Confirmado" : $statusRespSolicitante = "Confirmado";
							echo '<tr><td>'.$row['id'].'</td>'.'<td>'.$row['solicitante'].'</td><td>'.$row['tipo_eqto'].'</td><td>'.$row['patrimonio'].'</td><td>'.$row['tecnico'].'</td><td>'.$row['status'].'</td><td>'.$statusRespCTIC.'</td><td>'.$statusRespSolicitante.'</td></tr>';
						}
					?>
				</tbody>
			</table>
			
		<?php elseif($profile == "tecnico"): ?>
			<h2>Movimentações a fazer:</h2>
			<center><div id="msg" <?php echo $successMsg ?>>
				<?php
					if(isset($_GET["edtMov"]) AND $_GET["edtMov"] == "success") {
						$id = $_GET["update"];
						echo "<b>Movimentação #$id assinalada com sucesso!</b>";
						echo "<script>assinaturaTermoSuccess()</script>";
					}
					?>
				</div></center><br />
			
			<?php 
				isset($_POST["sentido"]) ? $sentido = $_POST["sentido"] : $sentido = "saida_CTIC"; 
				if ($sentido == "entrada_CTIC") {
					$statusEntrada = "checked";
				} else {
					$statusSaida = "checked";
				}
			?>
			<center><form method="post" action="./">
				<div class="form-group">
					<input type="radio" name="sentido" value="entrada_CTIC" <?php echo $statusEntrada ?>> Entrada CTIC
					<input type="radio" name="sentido" value="saida_CTIC" <?php echo $statusSaida ?>> Saida CTIC
					<button type="submit" class="btn btn-info glyphicon glyphicon-refresh" class="form-control"> Pesquisar</button>
				</div>
			</form></center>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Ticket #</th>
						<th>Solicitante</th>
						<th>Tipo Equipamento</th>
						<th>Patrimonio</th>
						<th>Técnico Responsável</th>
						<th>Status</th>
						<th>Termo de posse CTIC?</th>
						<th>Termo de posse solicitante?</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($sentido == "entrada_CTIC") {
					$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' AND tecnico='$nome' AND status='aguardando_retirada' ORDER BY id ASC";
				}	else {
					$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' AND tecnico='$nome' AND status='posse_temporaria_cedida' ORDER BY id ASC";
				}
					$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
					while ($row = mysql_fetch_assoc($resultado)) {
						$statusRespCTIC = $row["resp_CTIC"];
						$statusRespCTIC == "0" ? $statusRespCTIC = "Não Confirmado" : $statusRespCTIC = "Confirmado";
						$statusRespSolicitante = $row["resp_Solicitante"];
						$statusRespSolicitante == "0" ? $statusRespSolicitante = "Não Confirmado" : $statusRespSolicitante = "Confirmado";
						echo '<tr><td><form method="post" action="php/edtMov.php"><input type="radio" name="idMov" value="'.$row['id'].'" checked> '.$row['id'].'</td>'.'<td>'.$row['solicitante'].'</td><td>'.$row['tipo_eqto'].'</td><td>'.$row['patrimonio'].'</td><td>'.$row['tecnico'].'</td><td>'.$row['status'].'</td><td>'.$statusRespCTIC.'</td><td>'.$statusRespSolicitante.'</td><td>'.'<button type="submit" class="btn btn-default form-control glyphicon glyphicon-pencil"> Fazer movimentação</button></form>'.'</td></tr>';
					}
				?>
				</tbody>
			</table>
			
		<?php elseif($profile == "Resp_CTIC"): ?>
			<h2>Termos de Posse:</h2>
				<center><div id="msg" <?php echo $successMsg ?>>
				<?php
					if(isset($_GET["termoAssinado"]) AND $_GET["termoAssinado"] == "success") {
						$id = $_GET["update"];
						echo "<b>Termo da movimentação #$id assinado com sucesso!</b>";
						echo "<script>assinaturaTermoSuccess()</script>";
					}
					?>
				</div></center><br />
				
			<?php 
				isset($_POST["sentido"]) ? $sentido = $_POST["sentido"] : $sentido = "saida_CTIC"; 
				if ($sentido == "entrada_CTIC") {
					$statusEntrada = "checked";
				} else {
					$statusSaida = "checked";
				}
			?>
			<center><form method="post" action="./">
				<div class="form-group">
					<input type="radio" name="sentido" value="entrada_CTIC" <?php echo $statusEntrada ?>> Equipamentos que entram no CTIC
					<input type="radio" name="sentido" value="saida_CTIC" <?php echo $statusSaida ?>> Equipamentos que saem do CTIC
					<button type="submit" class="btn btn-info glyphicon glyphicon-refresh" class="form-control"> Pesquisar</button>
				</div>
			</form></center>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Ticket #</th>
						<th>Solicitante</th>
						<th>Tipo Equipamento</th>
						<th>Patrimonio</th>
						<th>Técnico Responsável</th>
						<th>Status</th>
						<th>Termo de posse CTIC?</th>
						<th>Termo de posse solicitante?</th>
					</tr>
				</thead>
				<tbody>
				<?php if ($sentido == "entrada_CTIC") {
					$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' AND resp_Solicitante='1' AND status='posse_temporaria_devolvida' ORDER BY id ASC";
				}	else {
					$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' AND status='aguardando_aprovacao_saida' ORDER BY id ASC";
				}
					$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
					while ($row = mysql_fetch_assoc($resultado)) {
						$statusRespCTIC = $row["resp_CTIC"];
						$statusRespCTIC == "0" ? $statusRespCTIC = "Não Confirmado" : $statusRespCTIC = "Confirmado";
						$statusRespSolicitante = $row["resp_Solicitante"];
						$statusRespSolicitante == "0" ? $statusRespSolicitante = "Não Confirmado" : $statusRespSolicitante = "Confirmado";
						echo '<tr><td><form method="post" action="php/termoPosse.php"><input type="radio" name="idMov" value="'.$row['id'].'" checked> '.$row['id'].'</td>'.'<td>'.$row['solicitante'].'</td><td>'.$row['tipo_eqto'].'</td><td>'.$row['patrimonio'].'</td><td>'.$row['tecnico'].'</td><td>'.$row['status'].'</td><td>'.$statusRespCTIC.'</td><td>'.$statusRespSolicitante.'</td><td>'.'<button type="submit" class="btn btn-info form-control glyphicon glyphicon-pencil"> Termo de Posse</button></form>'.'</td></tr>';
					}
				?>
				</tbody>
			</table>
		
		<?php elseif($profile == "Resp_Solicitante"): ?>
			<h2>Termos de Posse:</h2>
				<center><div id="msg" <?php echo $successMsg ?>>
				<?php
					if(isset($_GET["termoAssinado"]) AND $_GET["termoAssinado"] == "success") {
						$id = $_GET["update"];
						echo "<b>Termo da movimentação #$id assinado com sucesso!</b>";
						echo "<script>assinaturaTermoSuccess()</script>";
					}
					?>
				</div></center><br />
				
			<?php 
				isset($_POST["sentido"]) ? $sentido = $_POST["sentido"] : $sentido = "saida_CTIC"; 
				if ($sentido == "entrada_CTIC") {
					$statusEntrada = "checked";
				} elseif ($sentido == "saida_CTIC") {
					$statusSaida = "checked";
				}
			?>
			<center><form method="post" action="./">
				<div class="form-group">
					<input type="radio" name="sentido" value="entrada_CTIC" <?php echo $statusEntrada ?>> Equipamentos devolvidos
					<input type="radio" name="sentido" value="saida_CTIC" <?php echo $statusSaida ?>> Equipamentos solicitados
					<button type="submit" class="btn btn-info glyphicon glyphicon-refresh" class="form-control"> Pesquisar</button>
				</div>
			</form></center>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Ticket #</th>
						<th>Solicitante</th>
						<th>Tipo Equipamento</th>
						<th>Patrimonio</th>
						<th>Técnico Responsável</th>
						<th>Status</th>
						<th>Termo de posse CTIC?</th>
						<th>Termo de posse solicitante?</th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$query = "SELECT * FROM movimentacoes WHERE sentido='$sentido' AND status='realizando_movimentacao' AND dpto='$dpto' ORDER BY id ASC";
					$resultado = mysql_query($query) or die("Erro na query do select ". mysql_error());
					while ($row = mysql_fetch_assoc($resultado)) {
						$statusRespCTIC = $row["resp_CTIC"];
						$statusRespCTIC == "0" ? $statusRespCTIC = "Não Confirmado" : $statusRespCTIC = "Confirmado";
						$statusRespSolicitante = $row["resp_Solicitante"];
						$statusRespSolicitante == "0" ? $statusRespSolicitante = "Não Confirmado" : $statusRespSolicitante = "Confirmado";
						echo '<tr><td><form method="post" action="php/termoPosse.php"><input type="radio" name="idMov" value="'.$row['id'].'" checked> '.$row['id'].'</td>'.'<td>'.$row['solicitante'].'</td><td>'.$row['tipo_eqto'].'</td><td>'.$row['patrimonio'].'</td><td>'.$row['tecnico'].'</td><td>'.$row['status'].'</td><td>'.$statusRespCTIC.'</td><td>'.$statusRespSolicitante.'</td><td>'.'<button type="submit" class="btn btn-info form-control glyphicon glyphicon-pencil"> Termo de Posse</button></form>'.'</td></tr>';
					}
				?>
				</tbody>
			</table>
		
		<?php endif ?>
	</div>
	</body>
</html>