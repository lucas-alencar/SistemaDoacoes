
let formu2 = document.getElementById("fornecedorNaoVinculadoForm");
formu2.addEventListener('submit', function(e){
	
	e.preventDefault();
	vincularFornecedor(e);

	return false;
	
});

function vincularFornecedor(e){

	let idOng =  document.getElementById("idOngVincular").value;
	let idFornecedor = e.submitter.parentElement.id;

	 $.ajax({
      url:'../controller/vincularFornecedorController.php',
	  method: "POST",
	  data: {idOng: idOng, idFornecedor: idFornecedor, op:"vincular"},
      complete: function (response) {
		//document.getElementById('mensagem').innerHTML= response.responseText;
		window.location.href = "../view/vincularFornecedor.php";	
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}

let formu = document.getElementById("fornecedorVinculadoForm");
formu.addEventListener('submit', function(e){
	
	e.preventDefault();
	desvincularFornecedor(e);

	return false;
	
});

function desvincularFornecedor(e){

	let idOng =  document.getElementById("idOngDesvincular").value;
	let idFornecedor = e.submitter.parentElement.id;

	 $.ajax({
      url:'../controller/vincularFornecedorController.php',
	  method: "POST",
	  data: {idOng: idOng, idFornecedor: idFornecedor, op:"desvincular"},
      complete: function (response) {
		//document.getElementById('mensagem').innerHTML= response.responseText;
		window.location.href = "../view/vincularFornecedor.php";		
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}