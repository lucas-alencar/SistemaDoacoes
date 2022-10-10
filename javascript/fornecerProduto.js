let formu2 = document.getElementById("produtosFornecidosForm");
if(formu2 != null){
	formu2.addEventListener('submit', function(e){
		
		e.preventDefault();

		if(e.submitter.name == "editar"){
			editarProdutoFornecido(e);
		}else if(e.submitter.name == "remover"){
			removerProdutoFornecido(e);
		}

		return false;
		
	});
}

function editarProdutoFornecido(e){

	let idFornecedor =  document.getElementById("idFornecedor").value;
	let idProduto = e.submitter.parentElement.id;
	let valor = e.submitter.previousElementSibling.value;

	 $.ajax({
      url:'../controller/fornecerProdutoController.php',
	  method: "POST",
	  data: {idProduto: idProduto, idFornecedor: idFornecedor, valor: valor, op:"editar"},
      complete: function (response) {
		document.getElementById('mensagem').innerHTML= response.responseText;
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}

function removerProdutoFornecido(e){

	let idFornecedor =  document.getElementById("idFornecedor").value;
	let idProduto = e.submitter.parentElement.id;
	let valor = e.submitter.previousElementSibling.previousElementSibling.value;

	 $.ajax({
      url:'../controller/fornecerProdutoController.php',
	  method: "POST",
	  data: {idProduto: idProduto, idFornecedor: idFornecedor, valor: valor, op:"remover"},
      complete: function (response) {
		document.getElementById('mensagem').innerHTML= response.responseText;
		e.submitter.parentElement.remove();
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}

let formu = document.getElementById("produtosNaoFornecidosForm");
if(formu != null){
	formu.addEventListener('submit', function(e){
		
		e.preventDefault();
		fornecerProduto(e);

		return false;
		
	});
}

function fornecerProduto(e){

	let idFornecedor =  document.getElementById("idFornecedor2").value;
	let idProduto = e.submitter.parentElement.id;
	let valor = e.submitter.previousElementSibling.value;

	 $.ajax({
      url:'../controller/fornecerProdutoController.php',
	  method: "POST",
	  data: {idProduto: idProduto, idFornecedor: idFornecedor, valor: valor, op:"fornecer"},
      complete: function (response) {
		//document.getElementById('mensagem').innerHTML= response.responseText;
		window.location.href = "../view/fornecerProduto.php";		
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}