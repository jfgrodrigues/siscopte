function successAuth() {
	document.getElementById("authMsg").className += 'alert alert-success';
	document.getElementById("sinal").className += 'glyphicon glyphicon-thumbs-up';
	setTimeout("window.location='../'", 900);
}

function failAuth() {
	document.getElementById("user").focus();
	document.getElementById("authMsg").className += 'alert alert-danger';
	document.getElementById("sinal").className += 'glyphicon glyphicon-thumbs-down';
}
		
function editMovimentacao(){
	var nome = document.getElementById("nome");
	var email = document.getElementById("inputEmail3");
	var mensagem = document.getElementById("mensagem");	
}

function moveRecSuccess(){
	document.getElementById("msg").className += 'alert alert-success';
}

function assinaturaTermoFail(){
	document.getElementById("msg").className += 'alert alert-danger';
	document.getElementById("sinal").className += 'glyphicon glyphicon-thumbs-down';
}

function assinaturaTermoSuccess(){
	document.getElementById("msg").className += 'alert alert-success';
	document.getElementById("sinal").className += 'glyphicon glyphicon-thumbs-up';
}

function setCadastrar(){
		if(document.getElementById("cadastro").style.display == 'none'){
		document.getElementById("logon").style.display = 'none';
		document.getElementById("cadastro").style.display = 'block';
	}
}

function successCadastro(){
	document.getElementById("authMsg").className += 'alert alert-success';
	document.getElementById("sinal").className += 'glyphicon glyphicon-thumbs-up';
}

$(function($){
    $('#user').keyup(function(){
		var user = $('#user').val();
		$.ajax({
			url: "chkUsr.php?user="+user,
			success:  function(data){
				if(data == 1){
					document.getElementById("chkUser").className += 'alert alert-danger';
					chkUser.innerHTML = "<span class='glyphicon glyphicon-thumbs-down'></span> Usuário já cadastrado! insira outro";
					document.getElementById("btn_voltar").style.display = 'none';
					document.getElementById("btn_cadastrar").style.display = 'none';
				} else {
					document.getElementById("chkUser").className = "";
					chkUser.innerHTML = "";
					document.getElementById("btn_voltar").style.display = 'block';
					document.getElementById("btn_cadastrar").style.display = 'block';
				}
			}             
		});
	});
	$('#dpto').change(function(){
		var dpto = $('#dpto').val();
		if(dpto != ""){
			document.getElementById("perfil").style.display = 'block';
		} else {
			document.getElementById("perfil").style.display = 'none';
		}
		if(dpto != "CTIC"){
			document.getElementById("admCTIC").style.display = 'none';
			document.getElementById("Resp_CTIC").style.display = 'none';
			document.getElementById("tecnico").style.display = 'none';
			document.getElementById("Resp_Solicitante").style.display = 'block';
			document.getElementById("usuario").style.display = 'block';
		} else {
			document.getElementById("admCTIC").style.display = 'block';
			document.getElementById("Resp_CTIC").style.display = 'block';
			document.getElementById("tecnico").style.display = 'block';
			document.getElementById("Resp_Solicitante").style.display = 'none';
			document.getElementById("usuario").style.display = 'none';
		}
	});
	$('#cadastrar').submit(function(){
		var nome = $('#nome').val();
		var user = $('#user').val();
		var dpto = $('#dpto').val();
		var role = $('#role').val();
		var senha = $('#password').val();
		if(!chkFill(nome, user, senha, dpto, role)){
			document.getElementById("chkUser").className += 'alert alert-danger';
			chkUser.innerHTML = "<span class='glyphicon glyphicon-thumbs-down'></span> Preencha todos os dados para fazer o cadastro.";
			return false;
		}
	});

});

$(function($){
    $('#usr').keyup(function(){
		var user = $('#usr').val();
		$.ajax({
			url: "php/chkUsr.php?user="+user,
			success:  function(data){
				if(data == 1){
					document.getElementById("chkUser").className += 'alert alert-danger';
					chkUser.innerHTML = "<span class='glyphicon glyphicon-thumbs-down'></span> Usuário já cadastrado! insira outro";
					document.getElementById("btn_voltar").style.display = 'none';
					document.getElementById("btn_cadastrar").style.display = 'none';
				} else {
					document.getElementById("chkUser").className = "";
					chkUser.innerHTML = "";
					document.getElementById("btn_voltar").style.display = 'block';
					document.getElementById("btn_cadastrar").style.display = 'block';
				}
			}             
		});
	});
});

function chkFill(){
	var verificacao = new Array();
	for (var i = 0, j = arguments.length; i < j; i++) {
        if(arguments[i]!=""){
			verificacao[i]=true;
		} else { 
			return false; break;
		}
    }
	return true;
}
