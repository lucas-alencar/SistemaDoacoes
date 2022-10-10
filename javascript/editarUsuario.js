
let formu = document.getElementById("editarUsuario");
formu.addEventListener('submit', function(e){
	
	e.preventDefault();

	if(e.submitter.name == "editar"){
		editarUsuario(e);
	}else if(e.submitter.name == "remover"){
		removerUsuario(e);
	}
	
	return false;
	
});

function editarUsuario(e){

	let idUsuario =  document.getElementById("idUsuario").value;
	let login =  document.getElementById("login").value;
	let nome =  document.getElementById("nome").value;
	let senha =  document.getElementById("senha").value;
	let telefone =  document.getElementById("telefone").value;

	 $.ajax({
      url:'../controller/editarUsuarioController.php',
	  method: "POST",
	  data: {idUsuario: idUsuario, login: login, nome:nome, senha:senha, telefone:telefone, op:"editar"},
      complete: function (response) {

		document.getElementById('mensagem').innerHTML= response.responseText;		
      },
      error: function () {
          alert('Erro');
      }
  }); 

  return false;
	
}

function removerUsuario(e){

	let idUsuario =  document.getElementById("idUsuario").value;
	let login =  document.getElementById("login").value;
	let nome =  document.getElementById("nome").value;
	let senha =  document.getElementById("senha").value;
	let telefone =  document.getElementById("telefone").value;

	$.ajax({
      url:'../controller/editarUsuarioController.php',
	  method: "POST",
	  data: {idUsuario: idUsuario, login: login, nome:nome, senha:senha, telefone:telefone, op:"remover"},
      complete: function (response) {

		document.getElementById('mensagem').innerHTML= response.responseText;
		setTimeout(() => {  window.location.href = "../view/cadastroUsuario.php" }, 3000);

      },
      error: function () {
        alert('Erro');
      }
  });  

  return false;
	
}

let formP = document.getElementById("formPix");
formP.addEventListener('submit', function(e){

	e.preventDefault();
	cadastrarPix(e);
	
	return false;
	
});

function cadastrarPix(e){
	
	let pix =  document.getElementById("pix").value;
		
	 $.ajax({
      url:'../controller/editarUsuarioController.php',
	  method: "POST",
	  data: {pix: pix, op:"cadastrarpix"},
      complete: function (response) {
         //alert(response.responseText);
		 document.getElementById('mensagempix').innerHTML= response.responseText;
		 window.location.href = "editarUsuario.php";
		 //document.getElementById('mensagem').value= response.responseText;
      },
      error: function () {
		  document.getElementById('mensagempix').innerHTML= response.responseText;
      }
  });  

  return false;
	
}

let formP2 = document.getElementById("formEditarPix");
formP2.addEventListener('submit', function(e){

	e.preventDefault();
	removerPix(e);

	return false;
	
});

function removerPix(e){
	
	let pix = e.submitter.parentElement.id;
		
	 $.ajax({
      url:'../controller/editarUsuarioController.php',
	  method: "POST",
	  data: {pix: pix, op:"removerpix"},
      complete: function (response) {
		 e.submitter.parentElement.remove();
		 document.getElementById('mensagempix2').innerHTML= response.responseText;
		 //setTimeout(() => {  window.location.href = "login.php" }, 3000);
      },
      error: function () {
		  document.getElementById('mensagempix2').innerHTML= response.responseText;
      }
  });  

  return false;
	
}







