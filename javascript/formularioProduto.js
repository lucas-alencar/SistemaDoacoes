
let formP = document.getElementById("formProduto");
formP.addEventListener('submit', function(e){

	e.preventDefault();
	cadastrarProduto(e);
	return false;
	
});

function cadastrarProduto(e){
	
	let nome =  document.getElementById("nome").value;
	let imagem =  document.getElementById("imagem").value;
	console.log(imagem);
		
	 $.ajax({
      url:'../controller/cadastroProdutoController.php',
	  method: "POST",
	  data: {nome:nome, imagem:imagem, op:"cadastrar"},
      complete: function (response) {
         //alert(response.responseText);
		 document.getElementById('mensagem').innerHTML= response.responseText;
		 setTimeout(() => {  window.location.href = "../view/cadastroProduto.php" }, 3000);

      },
      error: function () {
          alert('Erro');
      }
  });  

  return false;
	
}

let form2 = document.getElementById("editarProduto");
form2.addEventListener('submit', function(e){
	
	e.preventDefault();

	if(e.submitter.name == "editar"){
		editarProduto(e);
	}else if(e.submitter.name == "remover"){
		removerProduto(e);
	}
	
	return false;
	
});

function editarProduto(e){
	
	let idProduto = e.submitter.parentElement.id;
	let nome =  e.submitter.previousElementSibling.previousElementSibling.value;
	let imagem =  e.submitter.previousElementSibling.value;

	 $.ajax({
      url:'../controller/cadastroProdutoController.php',
	  method: "POST",
	  data: {idProduto: idProduto, nome:nome, imagem:imagem, op:"editar"},
      complete: function (response) {

		document.getElementById('mensagem2').innerHTML= response.responseText;

      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}

function removerProduto(e){

	let idProduto = e.submitter.parentElement.id;
	let nome =  e.submitter.previousElementSibling.previousElementSibling.value;
	let imagem =  e.submitter.previousElementSibling.value;

	$.ajax({
      url:'../controller/cadastroProdutoController.php',
	  method: "POST",
	  data: {idProduto: idProduto, nome:nome, imagem:imagem, op:"remover"},
      complete: function (response) {
		e.submitter.parentElement.remove();
		document.getElementById('mensagem2').innerHTML= response.responseText;
		//document.getElementById('mensagem').value= response.responseText;
      },
      error: function () {
        alert('Erro');
      }
  });  

  return false;
	
}


