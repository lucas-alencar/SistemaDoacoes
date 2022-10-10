let formU = document.getElementById("formRefeicao");
formU.addEventListener('submit', function(e){

	e.preventDefault();
	cadastrarRefeicao(e);
	
	return false;
	
});
 
function cadastrarRefeicao(e){

	let produtos = document.querySelectorAll('.check'); 
	let produtosEscolhidos = [];  
	for (let i = 0; i < produtos.length; i++) { 
		if(produtos[i].checked && produtos[i].previousElementSibling.value>0){
			let temp =[];
			temp.push(produtos[i].parentElement.id);
			temp.push(produtos[i].previousElementSibling.value);
			produtosEscolhidos.push(temp);
		}   
	}

	let dataref =  document.getElementById("data").value; 
	let idOng = document.getElementById("idOng").value;

	 $.ajax({
      url:'../controller/cadastroRefeicaoController.php',
	  method: "POST",
	  data: {idOng:idOng, dataref:dataref, produtosEscolhidos:produtosEscolhidos, op:"cadastrar"},
      complete: function (response) {
		 document.getElementById('mensagem').innerHTML= response.responseText;
		 //setTimeout(() => {document.location.reload(true);}, 10);
      },
      error: function (error) {
		  document.getElementById('mensagem').innerHTML= "Ocorreu um erro";
      }
  });  

  return false;
	
}


let form2 = document.getElementById("editarRefeicao");
form2.addEventListener('submit', function(e){

	e.preventDefault();
	removerRefeicao(e);
	
	return false;
	
});
 
function removerRefeicao(e){
	let idRefeicao = e.submitter.nextElementSibling.value;

	 $.ajax({
      url:'../controller/cadastroRefeicaoController.php',
	  method: "POST",
	  data: {idRefeicao:idRefeicao, op:"remover"},
      complete: function (response) {
		 document.getElementById('mensagem2').innerHTML= response.responseText;
		 e.submitter.parentElement.parentElement.parentElement.remove();
		 //setTimeout(() => {document.location.reload(true);}, 10);
      },
      error: function (error) {
		  document.getElementById('mensagem2').innerHTML= "Ocorreu um erro";
      }
  });  

  return false;
	
}