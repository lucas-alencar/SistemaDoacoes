<?php 

require_once("ConnectionDB.php");

class Usuario{
	public $idUsuario;	
	public $login;
	public $nome;
	public $senha;
	public $telefone;
	public $tipo;

	public function __construct($param = null){
		if(isset($param[0]))$this->login = $param[0];
		if(isset($param[1]))$this->nome = $param[1];
		if(isset($param[2]))$this->senha = $param[2];
		if(isset($param[3]))$this->telefone = $param[3];
		if(isset($param[4]))$this->tipo = $param[4];			
	}
	
	public static function getObjetoPorId($param = null){
		try{

			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM usuario where idUsuario= ?;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto= $row;	
				}			
			}
			return self::converteLinhaObjeto($objeto);
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}
	
	public static function converteLinhaObjeto($linha = null){
		
		$objeto = new Usuario();
		if(!is_null($linha) && !empty($linha)){

			$objeto->idUsuario = $linha->idUsuario;
			$objeto->login = $linha->login;
			$objeto->nome = $linha->nome;
			$objeto->senha = $linha->senha;
			$objeto->telefone = $linha->telefone;
		}

		return $objeto;		
	}
	
	public static function getObjetoPorLogin($param = null){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM usuario where login = '{$param}';");
			$objeto = [];
			
			if($stmt->execute()){			
				while ($row = $stmt->fetchObject()) {
					$objeto= $row;	
				}			
			}
			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}
	
	public function salvar(){
		
		try{
			
			$objetoExistente = self::getObjetoPorLogin($this->login);
		
			if(!is_null($objetoExistente) && !empty($objetoExistente)){
				return false;
			}
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO usuario (login, nome, senha, telefone) values(?,?,?,?)");
			$stmt->execute([$this->login, $this->nome, $this->senha, $this->telefone]);
			
			$id = $connection->lastInsertId();
			
			if($this->tipo=="DOADOR"){
				$stmt    = $connection->prepare("INSERT INTO doador values(?)");
				$stmt->execute([$id]);			
			}else if($this->tipo=="ONG"){
				$stmt    = $connection->prepare("INSERT INTO ong values(?)");
				$stmt->execute([$id]);			
			}else if($this->tipo=="FORNECEDOR"){
				$stmt    = $connection->prepare("INSERT INTO fornecedor values(?)");
				$stmt->execute([$id]);
			}
			
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}
	
	public static function validar($param = null){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM usuario where login = ? and senha = ?;");
				
			$stmt->execute([$param[0], $param[1]]);
			$resultado = $stmt->fetchObject();			
			
			return $resultado;
			
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}
		
	}

	public function editar(){

		try{

			$objetoExistente = self::getObjetoPorLogin($this->login);
		
			if(!is_null($objetoExistente) && !empty($objetoExistente)){
				if($objetoExistente->idUsuario != $this->idUsuario){
					return false;
				}				
			}
			
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			if(empty($this->senha)){
				$stmt = $connection->prepare("UPDATE usuario set login = ?, nome = ?, telefone  = ? where idUsuario=?");
				$stmt->execute([$this->login, $this->nome, $this->telefone, $this->idUsuario]);

			}else{
				$stmt = $connection->prepare("UPDATE usuario set login = ?, nome = ?, senha = ?, telefone  = ? where idUsuario=?");
				$stmt->execute([$this->login, $this->nome, $this->senha, $this->telefone, $this->idUsuario]);
			}			

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;

		}

	}

	public function remover(){
		try{
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("DELETE from usuario where idUsuario=?");
			$stmt->execute([$this->idUsuario]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;

		}

	}
	
	public static function tipoUsuario($param = null){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM doador where idDoador = ?");
				
			$stmt->execute([$param[0]]);
			$resultado = $stmt->fetchObject();
			if($resultado){
				return "DOADOR";
			}else{
				
				$stmt    = $connection->prepare("SELECT * FROM ong where idOng = ?");
				
				$stmt->execute([$param[0]]);
				$resultado = $stmt->fetchObject();
				if($resultado){
					return "ONG";
				} else{
					$stmt    = $connection->prepare("SELECT * FROM fornecedor where idFornecedor = ?");
				
					$stmt->execute([$param[0]]);
					$resultado = $stmt->fetchObject();
					if($resultado){
						return "FORNECEDOR";
					}

				}
	
			}

			return null;
			
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}
		
	}
	
}


?>

