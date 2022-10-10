
let formU = document.getElementById("formUsuario");
formU.addEventListener('submit', function(e){

	e.preventDefault();
	cadastrarUsuario(e);
	
	return false;
	
});

function cadastrarUsuario(e){
	
	let login =  document.getElementById("login").value;
	let nome =  document.getElementById("nome").value;
	let senha =  document.getElementById("senha").value;
	let telefone =  document.getElementById("telefone").value;
	let tipo =  document.getElementById("tipo").value;
		
	 $.ajax({
      url:'../controller/cadastroUsuarioController.php',
	  method: "POST",
	  data: {login: login, nome:nome, senha:senha, telefone:telefone, tipo:tipo},
      success: function (response) {
         //alert(response.responseText);
		 document.getElementById('mensagem').innerHTML= "Usuário cadastrado com sucesso";
		 setTimeout(() => {  window.location.href = "../view/login.php" }, 1000);
      },
      error: function (error) {
		  document.getElementById('mensagem').innerHTML= "Já existe usuário cadastrado com esse login!";
      }
  });  

  return false;
	
}
