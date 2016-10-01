# SisCoPTE

## Resumo:
SisCoPTE (Sistema de Controle de Posse Temporária de Equipamentos) foi desenvolvido com a finalidade de se fazer o gerenciamento e controle de quem possui a posse temporária de um equipamento tecnológico numa organização. Toma-se por premissa que os equipamentos de TI ("CPU's", Notebooks, Monitores, etc...) ficam sob "guarda" da área de tecnologia de informação, que faz uma "concessão de uso" desse equipamento a outras áreas da organização e essa área de TI precisa fazer o controle desses equipamentos, tendo o registro de onde está cada equipamento e atribuindo, através de um documento assinado, a posse temporária ao responsável de cada área que faz o uso do euipamento no momento. O SisCoPTE faz o controle eletrônico disso tudo. Foi desenvolvido em PHP e baseado num processo já existente de uma Secretaria de Estado de São Paulo, onde o processo é feito todo "manualmente" e no papel, sem o registro digital, e entregue como trabalho acadêmico na matéria de Engenharia de Software III na minha graduação na FATEC-SP.

## Instalação e configuração
Antes de mais nada, é pré-requisitos para fazer a implementação e configuração do sistema, ter um servidor WEB com PHP e banco de dados MySQL instalados (com o banco criado e os dados de acesso ao mesmo).

Com os pré-requisitos atendidos, basta baixar os arquivos-fonte e copiá-los para a pasta do servidor web onde o serviço irá rodar. Depois disso, basta abrir o arquivo 'config.php' na pasta '/php' e inserir as informações de acesso ao banco de dados. Abaixo o arquivo 'config' e a informação que deve ser preenchida em cada campo:

```shell
<?php
	$host = ""; -> inserir a informação do host onde o banco está instalado (ex.: localhost)
	$user = ""; -> inserir o usuário no banco de dados 
	$pass = ""; -> inserir a senha do usuário no banco de dados
	$banco = ""; -> inserir o nome do banco de dados (ex.: siscopte)
	$link=@mysql_connect($host, $user, $pass)
		or die("Erro de conexão ".mysql_error());
	mysql_select_db($banco)
		or die("Erro na selecao do banco ". mysql_error());
?>
```

Depois disso, basta começar a usar o sistema.

Obs.: A versão baixada virá com um botão "cadastrar" na página inicial para que o primeiro usuário possa ser cadastrado. Esse botão permanecerá posteriormente se não for alterado o código-fonte do sistema por quem for administrá-lo.

## Versão de Teste Online
O sistema pode ser acessado e testado online no endereço http://siscopte.byethost7.com/. Nessa versão, é possível criar um usuário de teste na página inicial em qualquer perfil e fazer o acesso e validar cada funcionalidade.
