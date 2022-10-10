<?php 

require_once("ConnectionDB.php");

class Produto{
	public $idProduto;	
	public $nome;
	public $imagem;
	
	public function __construct($param = null){

		if(isset($param[0])) $this->nome = $param[0];
		if(isset($param[1])) $this->imagem = $param[1];
		
	}

	public static function getObjetoPorId($param = null){
		try{

			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM produto where idProduto = ?;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto = $row;	
				}			
			}
			return self::converteLinhaObjeto($objeto);
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}
	
	public static function getProdutoPorNome($param = null){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM produto where nome = ?;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto= $row;	
				}			
			}
			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function converteLinhaObjeto($linha = null){
		
		$objeto = new Produto();
		if(!is_null($linha) && !empty($linha)){
			if(isset($linha->idProduto))$objeto->idProduto = $linha->idProduto;
			if(isset($linha->nome))$objeto->nome = $linha->nome;
			if(isset($linha->imagem))$objeto->imagem = $linha->imagem;
		}

		return $objeto;		
	}

	public static function listarTodos(){

		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM produto;");
			$objeto = array();
			
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

	public static function listarTodosFornecidos($idOng = NULL){

		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM produto p inner join fornecedor_has_produto f on p.idProduto = f.idProduto inner join ong_has_fornecedor o on o.idFornecedor = f.idFornecedor where o.idOng = ? GROUP BY p.idProduto;");
			$objeto = array();
			
			if($stmt->execute([$idOng])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = self::converteLinhaObjeto($row);	
				}			
			}
			return $objeto;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}

	}

	public function remover(){
		try{
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("DELETE from produto where idProduto=?");
			$stmt->execute([$this->idProduto]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;

		}

	}

	public function editar(){

		try{

			$objetoExistente = self::getProdutoPorNome($this->nome);
		
			if(!is_null($objetoExistente) && !empty($objetoExistente)){
				if($objetoExistente->idProduto != $this->idProduto){
					return false;
				}
				
			}
			
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("UPDATE produto set nome = ?, imagem = ? where idProduto=?");
			$stmt->execute([$this->nome, $this->imagem, $this->idProduto]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;

		}

	}
	
	public function salvar(){
		
		try{
			
			$objetoExistente = self::getProdutoPorNome($this->nome);
		
			if(!is_null($objetoExistente) && !empty($objetoExistente)){
				return false;
			}
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO produto (nome, imagem) values(?,?)");
			$stmt->execute([$this->nome, $this->imagem]);
			
			//$id = $connection->lastInsertId();
			
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}	
		
}


?>

