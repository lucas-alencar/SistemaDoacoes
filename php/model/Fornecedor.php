<?php 

require_once("ConnectionDB.php");
require_once("Usuario.php");

class Fornecedor{
	public $usuario;

	public function __construct($param = null){		
	}
	
	public static function listarFornecedores(){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM fornecedor inner join usuario on idUsuario = idFornecedor;");
			$objeto = [];
			
			if($stmt->execute()){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = self::converteLinhaObjeto($row);
				}			
			}
			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function listarNaoFornecedoresOng($param){
		try{

			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM fornecedor f inner join usuario on f.idFornecedor = idUsuario 
											where f.idFornecedor not in (SELECT ofa.idFornecedor from ong_has_fornecedor ofa where ofa.idOng=?) ;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = self::converteLinhaObjeto($row);
				}			
			}
			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function listarFornecedoresOng($param){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM ong_has_fornecedor inner join usuario on idFornecedor = idUsuario where idOng = ?;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = self::converteLinhaObjeto($row);
				}			
			}

			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function vincular($idOng,$idFornecedor){
		try{
			$connection = ConnectionDB::getInstance();
			$connection->beginTransaction();
			$stmt    = $connection->prepare("INSERT INTO ong_has_fornecedor (idOng, idFornecedor) values (?,?);");
			$stmt->execute([$idOng, $idFornecedor]);
			$connection->commit();
			return true;
		
		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;
		}			
	}

	public static function desvincular($idOng,$idFornecedor){
		try{
			$connection = ConnectionDB::getInstance();
			$connection->beginTransaction();
			$stmt    = $connection->prepare("DELETE FROM ong_has_fornecedor where idOng = ? and idFornecedor=?;");
			$stmt->execute([$idOng, $idFornecedor]);
			$connection->commit();
			return true;
		
		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;
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
	
}


?>

