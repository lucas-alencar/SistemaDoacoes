let formU = document.getElementById("confirmarDoacaoUsr");
formU.addEventListener('submit', function(e){
	e.preventDefault();
	confirmarDoacaoUsr(e);
	
	return false;
	
});

function confirmarDoacaoUsr(e){
  
   let idDoador =  document.getElementById("idDoador").value;
   let idOng =  document.getElementById("idOng").value;
   let idProduto =  document.getElementById("idProduto").value;
   let quantidade =  document.getElementById("qtdProduto").value;
   let valor =  document.getElementById("valor").value;
   let idRefeicao = document.getElementById("idRefeicao").value;
	 $.ajax({
      url:'../controller/confirmarDoacaoUsrController.php',
	  method: "POST",
	  data: {idRefeicao:idRefeicao,idDoador: idDoador, idOng:idOng,idProduto:idProduto,quantidade:quantidade,valor:valor},
      success: function (response) {
         window.location.replace('index.php');
      },
      error: function (error) {
        
      }
  });  

  return false;
	
}
