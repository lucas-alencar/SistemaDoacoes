let formU = document.getElementById("formDoacaoCadastrada");
formU.addEventListener('submit', function(e){

	e.preventDefault();

	if(e.submitter.name == "confirmarPagamento"){
		confirmarPagamento(e);
	}else if(e.submitter.name == "naoPagou"){
		rejeitarPagamento(e);
	}
	
	return false;
	
});
 
function confirmarPagamento(e){

	let idDoacao = e.submitter.parentElement.id;

	 $.ajax({
      url:'../controller/acompanharDoacaoController.php',
	  method: "POST",
	  data: {idDoacao:idDoacao, op:"confirmarPagamento"},
      complete: function (response) {
		document.getElementById('mensagem1').innerHTML= "Status alterado!";
		 //setTimeout(() => {document.location.reload(true);}, 10);
		 //window.location.replace('confirmarDoacao.php');
      },
      error: function (error) {
		  document.getElementById('mensagem1').innerHTML= "Ocorreu um erro";
      }
  }); 
  
  return false;
	
}

function rejeitarPagamento(e){

	let idDoacao = e.submitter.parentElement.id;
	let quantidade = e.submitter.nextElementSibling.value;
	let idProduto = e.submitter.nextElementSibling.nextElementSibling.value;
	let idOng = e.submitter.nextElementSibling.nextElementSibling.nextElementSibling.value;
	console.log(idDoacao,quantidade, idProduto, idOng);
	 $.ajax({
      url:'../controller/acompanharDoacaoController.php',
	  method: "POST",
	  data: {idDoacao:idDoacao, idOng:idOng, idProduto:idProduto, quantidade:quantidade, op:"rejeitarPagamento"},
      complete: function (response) {
		document.getElementById('mensagem1').innerHTML= "Status alterado!";
		 //setTimeout(() => {document.location.reload(true);}, 10);
      },
      error: function (error) {
		  document.getElementById('mensagem1').innerHTML= "Ocorreu um erro";
      }
  }); 
  
  return false;
	
}


let form2 = document.getElementById("formDoacaoAtendida");
form2.addEventListener('submit', function(e){

	e.preventDefault();
	concluirDoacao(e);

	return false;
	
});

function concluirDoacao(e){

	let idDoacao = e.submitter.parentElement.id;
	let idOng= document.getElementById("idOng2").value;
	
	 $.ajax({
      url:'../controller/acompanharDoacaoController.php',
	  method: "POST",
	  data: {idDoacao:idDoacao, op:"concluirDoacao"},
      complete: function (response) {
		document.getElementById('mensagem2').innerHTML= "Status alterado!";
		 setTimeout(() => {document.location.reload(true);}, 10);
		 //window.location.replace('confirmarDoacao.php');
      },
      error: function (error) {
		  document.getElementById('mensagem2').innerHTML= "Ocorreu um erro";
      }
  }); 
  
  return false;
}
	