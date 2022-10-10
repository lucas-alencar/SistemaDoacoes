
let formL = document.getElementById("formLogin");
formL.addEventListener('submit', function(e){

	e.preventDefault();
	entrar(e);
	
	return false;
	
});

function entrar(e){
	
	let login =  document.getElementById("login").value;
	let senha =  document.getElementById("senha").value;
	
	 $.ajax({
      url:'../controller/loginController.php',
	  method: "POST",
	  data: {login: login, senha:senha},
      complete: function (response) {
         //alert(response.responseText);
		 document.getElementById('mensagem').innerHTML= response.responseText;
		 setTimeout(() => {window.location.href = "../view/index.php"}, 1000);
		 //document.getElementById('mensagem').value= response.responseText;
      },
      error: function () {
          alert('Erro');
      }
  });  

  return false;
	
}
