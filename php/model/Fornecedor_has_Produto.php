<?php 

require_once("ConnectionDB.php");
require_once("Usuario.php");
require_once("Produto.php");

class Fornecedor_has_Produto{
	public $usuario;
	public $produto;
	public $valor;

	public function __construct($param = null){		
	}

	public static function converteLinhaObjeto($linha = null){
		
		$objeto = new Fornecedor_has_Produto();
		if(!is_null($linha) && !empty($linha)){

			if(isset($linha->idUsuario)){
				$usuario = Usuario::getObjetoPorId($linha->idFornecedor);
				$objeto->usuario = $usuario;
			}
			if(isset($linha->idProduto)){
				$produto = Produto::getObjetoPorId($linha->idProduto);
				$objeto->produto = $produto;
			}
			if(isset($linha->valor)) $objeto->valor = $linha->valor;

		}

		return $objeto;		
	}

	public static function menorPreco($idProduto,$idOng){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT min(f.valor) as menor FROM fornecedor_has_produto f inner join ong_has_fornecedor o on f.idFornecedor = o.idFornecedor where o.idOng = ? and f.idProduto = ?;");
			$objeto = [];
			
			$stmt->execute([ $idOng, $idProduto]);
			$min = $stmt->fetchObject();
			if(isset($min->menor)) return $min->menor;
			else return "10";
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}


	}

	public static function listarProdutosFornecidos($param){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM fornecedor_has_produto f inner join produto p on f.idProduto = p.idProduto where f.idFornecedor = ?;");
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


	public static function listarProdutosNaoFornecidos($param){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM produto p where p.idProduto not in (SELECT fp.idProduto from fornecedor_has_produto fp where fp.idFornecedor = ?);");
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

	public static function salvar($idFornecedor, $idProduto, $valor){
		
		try{
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO fornecedor_has_produto (idFornecedor, idProduto, valor) values(?,?,?)");
			$stmt->execute([$idFornecedor, $idProduto, $valor]);
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function editar($idFornecedor, $idProduto, $valor){
		
		try{
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("UPDATE fornecedor_has_produto set valor = ? where idFornecedor = ? and idProduto = ?");
			$stmt->execute([$valor, $idFornecedor, $idProduto]);
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function remover($idFornecedor, $idProduto){
		
		try{
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("DELETE FROM fornecedor_has_produto where idFornecedor = ? and idProduto = ?");
			$stmt->execute([$idFornecedor, $idProduto]);
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

}


?>

