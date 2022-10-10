let formU = document.getElementById("formAtenderDoacao");
formU.addEventListener('submit', function(e){

	e.preventDefault();
	atenderDoacao(e);
	
	return false;
	
});
 
function atenderDoacao(e){

	let idDoacao = e.submitter.parentElement.id;
	let idFornecedor = document.getElementById("idFornecedor").value;
	
	 $.ajax({
      url:'../controller/atenderDoacaoController.php',
	  method: "POST",
	  data: {idDoacao:idDoacao, idFornecedor: idFornecedor, op:"atenderDoacao"},
      complete: function (response) {
		 setTimeout(() => {document.location.reload(true);}, 10);
		 //window.location.replace('confirmarDoacao.php');
      },
      error: function (error) {
		  document.getElementById('mensagem').innerHTML= "Ocorreu um erro";
      }
  }); 
  
  return false;
	
}