let formU = document.getElementById("formDoacao");
formU.addEventListener('submit', function(e){

	e.preventDefault();
	cadastrarDoacao(e);
	
	return false;
	
});
 
function cadastrarDoacao(e){

	let idRefeicao = e.submitter.previousElementSibling.value;
	let qtd = e.submitter.parentElement.previousElementSibling.children[0].value;
	let idProduto = e.submitter.previousElementSibling.previousElementSibling.value;
	let idDoador = e.submitter.previousElementSibling.previousElementSibling.previousElementSibling.value;
	let idOng = e.submitter.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.value;
	let preco = e.submitter.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.value;
	let nomeProduto = e.submitter.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.value;
	let doacao = [idDoador, idOng, idProduto, qtd, idRefeicao, qtd*preco,nomeProduto];
	
	 $.ajax({
      url:'../controller/cadastroDoacaoController.php',
	  method: "POST",
	  data: {doacao:doacao, op:"cadastrar"},
      complete: function (response) {
		 //document.getElementById('mensagem').innerHTML= response.responseText;
		 //setTimeout(() => {document.location.reload(true);}, 10);
		 window.location.replace('confirmarDoacao.php');
      },
      error: function (error) {
		  document.getElementById('mensagem').innerHTML= "Ocorreu um erro";
      }
  }); 
  
  return false;
	
}