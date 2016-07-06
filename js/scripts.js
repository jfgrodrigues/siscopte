function successAuth() {
	document.getElementById("authMsg").className += 'glyphicon glyphicon-thumbs-up alert alert-success';
	authMsg.innerHTML="Autenticação realizada com sucesso! Redirecionando..."
	setTimeout("window.location='../'", 1100);
}

function failAuth() {
	document.getElementById("user").focus();
	document.getElementById("authMsg").className += 'glyphicon glyphicon-thumbs-down alert alert-danger';
}
		
function editMovimentacao(){
	var nome = document.getElementById("nome");
	var email = document.getElementById("inputEmail3");
	var mensagem = document.getElementById("mensagem");	
}

function moveRecSuccess(){
	document.getElementById("msg").className += 'glyphicon glyphicon-ok alert alert-success';
}

function assinaturaTermoFail(){
	document.getElementById("msg").className += 'glyphicon glyphicon-thumbs-down alert alert-danger';
}

function assinaturaTermoSuccess(){
	document.getElementById("msg").className += 'glyphicon glyphicon-thumbs-up alert alert-success';
}
