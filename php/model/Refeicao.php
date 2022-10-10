<?php 

require_once("ConnectionDB.php");
require_once("Usuario.php");

class Refeicao{
	public $idRefeicao;
	public $data;	
	public $ong;
	public $produtos;

	public function __construct($param = null){
	}
	
	public function salvar(){
		
		try{

			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO refeicao (data, idOng) values(?,?)");
			$stmt->execute([$this->data, $this->ong]);

			$id = $connection->lastInsertId();

			foreach($this->produtos as $prod){
				$stmt    = $connection->prepare("INSERT INTO refeicao_has_produto (idRefeicao,idProduto,quantidade_necessaria, quantidade_recebida) 
											values(?,?,?,?)");
				$stmt->execute([$id, $prod[0], $prod[1], 0]);
			}
			

			$connection->commit();

			return true;

		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
			$connection->rollBack();
			return false;

		}

	}

	public static function listarRefeicaoOng($param){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM refeicao r inner join refeicao_has_produto rp on r.idRefeicao = rp.idRefeicao where r.idOng = ? order by r.idRefeicao;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = $row;
				}			
			}

			$resultado = self::converteLinhaObjeto($objeto);
			return $resultado;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function listarRefeicaoOngAtuais($param){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM refeicao r inner join refeicao_has_produto rp on r.idRefeicao = rp.idRefeicao where r.idOng = ? and r.data >= NOW() - INTERVAL 7 DAY order by r.idRefeicao;");
			$objeto = [];
			
			if($stmt->execute([$param])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = $row;
				}			
			}

			$resultado = self::converteLinhaObjeto($objeto);
			return $resultado;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function listarRefeicaoAberta(){
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM refeicao r inner join refeicao_has_produto rp on r.idRefeicao = rp.idRefeicao where r.data>= now() and quantidade_recebida < quantidade_necessaria order by r.idOng,r.idRefeicao;");
			$objeto = [];
			
			if($stmt->execute([])){			
				while ($row = $stmt->fetchObject()) {
					$objeto[] = $row;
				}			
			}
			$resultado = self::converteLinhaObjeto($objeto);
			return $resultado;
		
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function remover($idRefeicao){
		try{
			$connection = ConnectionDB::getInstance();
			$connection->beginTransaction();
			$stmt    = $connection->prepare("DELETE FROM refeicao where idRefeicao = ?;");

			$stmt->execute([$idRefeicao]);
			$connection->commit();		

			return true;
		
		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
		}			
	}

	public static function converteLinhaObjeto($linhas = null){
		
		$listaderefeicoes = [];
		$idRefeicaoTemp = '';
		$dataTemp = '';
		$idOng='';
		$produtoQtdTemp = [];
		$produtosRefeicao = [];

		foreach($linhas as $linha){
			
			if(isset($linha->idRefeicao) && $idRefeicaoTemp != $linha->idRefeicao && !empty($idRefeicaoTemp)){
				$refeicao = new Refeicao();
				$usuario = Usuario::getObjetoPorId($idOng);
				$refeicao->ong = $usuario;

				$refeicao->data = $dataTemp;
				$refeicao->idRefeicao = $idRefeicaoTemp;
				$refeicao->produtos = $produtosRefeicao;
				$produtoQtdTemp = array();
				$produtosRefeicao = array();
				$listaderefeicoes[] = $refeicao;
				
			} 
			if(isset($linha->idOng)) $idOng = $linha->idOng;
			if(isset($linha->idRefeicao)) $idRefeicaoTemp = $linha->idRefeicao;
			if(isset($linha->data)) $dataTemp = $linha->data;
			if(isset($linha->idProduto)){
				$produto = Produto::getObjetoPorId($linha->idProduto);
				$produtoQtdTemp[] = $produto;
				
			}

			if(isset($linha->quantidade_necessaria)){
				$produtoQtdTemp[] = $linha->quantidade_necessaria;
			} else{
				$produtoQtdTemp[] = 0 ;
			}

			if(isset($linha->quantidade_recebida)){
				$produtoQtdTemp[]= $linha->quantidade_recebida;
			} else{
				$produtoQtdTemp[] = 0;
			}
			$produtosRefeicao[] = $produtoQtdTemp;
			$produtoQtdTemp = array();

		}

		$refeicao = new Refeicao();
		$usuario = Usuario::getObjetoPorId($idOng);
		$refeicao->ong = $usuario;

		$refeicao->data = $dataTemp;
		$refeicao->idRefeicao = $idRefeicaoTemp;
		$refeicao->produtos = $produtosRefeicao;
		$produtoQtdTemp = array();
		$produtosRefeicao = array();
		$listaderefeicoes[] = $refeicao;

		return $listaderefeicoes;		
	}


	public static function listarTodos(){
		try{
			$connection = ConnectionDB::getInstance();
			$sql = "SELECT * FROM refeicao;";
			$result    = $connection->query($sql);
			return $result;
		} catch(Exception $e){
			echo 'Erro: ',  $e->getMessage(), "\n";
		}

	}

}?>
