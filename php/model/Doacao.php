<?php 
require_once("ConnectionDB.php");
require_once("Usuario.php");
require_once("Produto.php");
require_once("ConnectionDB.php");


class Doacao{
	public $idDoador; 
	public $idOng; 
	public $idProduto; 
	public $data;
	public $quantidade; 
	public $idRefeicao;
	public $status;
	public $fornecedor;
	public $valor;
	public $produto;
	public $ong;
	public $doador;


	public function __construct($param1 = NULL, $param2 = NULL,$param3 = NULL, $param4 = NULL,$param5 = NULL,$param6=NULL){
		if(isset($param6)){
			$this->idDoador = $param1;
			$this->idOng = $param2;
			$this->idProduto = $param3;
			$this->quantidade = $param4;
			$this->idRefeicao = $param5;
			$this->valor = $param6;

		}
		
	}
	
	public function doar(){
		try{
			$connection = ConnectionDB::getInstance();
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO doacao (`data`,`idDoador`,`idOng`,`idProduto`,`quantidade`,`valor`) values (NOW(),?,?,?,?,?)");
			$stmt->execute([$this->idDoador,$this->idOng,$this->idProduto,$this->quantidade,$this->valor]);
			
			$updateRecebido = $connection->prepare('UPDATE `refeicao_has_produto` SET `quantidade_recebida` = quantidade_recebida+?  WHERE `refeicao_has_produto`.`idRefeicao` = ? AND `refeicao_has_produto`.`idProduto` = ?');
			$updateRecebido->execute([$this->quantidade,$this->idRefeicao,$this->idProduto]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}
	}

	public static function listarConfirmadas($idFornecedor){
		
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM doacao d inner join ong_has_fornecedor ofa on d.idOng = ofa.idOng inner join produto p on d.idProduto = p.idProduto where ofa.idFornecedor = ? and d.status = 'CONFIRMADA' order by d.idOng");
			$objeto = [];
			
			if($stmt->execute([$idFornecedor])){			
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

	public static function listarCadastradas($idOng){
		
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM doacao d inner join produto p on d.idProduto = p.idProduto where d.idOng = ? and d.status = 'CADASTRADA'");
			$objeto = [];
			
			if($stmt->execute([$idOng])){			
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

	public static function listarEmAtendimento($idOng){
		
		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM doacao d inner join usuario u on d.idFornecedor = u.idUsuario inner join produto p on d.idProduto = p.idProduto where d.idOng = ? and d.status = 'EM ATENDIMENTO'");
			$objeto = [];
			
			if($stmt->execute([$idOng])){			
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

	public static function confirmarPagamento($idDoacao){

		try{
			
			$connection = ConnectionDB::getInstance();

			$connection->beginTransaction();

			$stmt = $connection->prepare("UPDATE doacao d set d.status = 'CONFIRMADA' where d.idDoacao = ?;");
			$stmt->execute([$idDoacao]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function rejeitarPagamento($idDoacao,$idProduto,$idOng,$quantidade){
		try{
			
			$connection = ConnectionDB::getInstance();

			$connection->beginTransaction();
			var_dump("qualquer coisaaaaaa");
			echo 'QUALQUER COISA';

			$stmt = $connection->prepare("UPDATE doacao d set d.status = 'NEGADA' where d.idDoacao = ?;");
			$stmt->execute([$idDoacao]);
			
			
			$stmt = $connection->prepare("SELECT * from refeicao_has_produto rhp inner join refeicao r on rhp.idRefeicao = r.idRefeicao where rhp.idProduto = ? and r.idOng = ? and rhp.quantidade_recebida >= ? order by r.data desc limit 1;");
			$idRefeicao='';
			if($stmt->execute([$idProduto, $idOng, $quantidade])){			
				while ($row = $stmt->fetchObject()) {
					$idRefeicao = $row->idRefeicao;
				}			
			}
			
			$stmt = $connection->prepare("UPDATE refeicao_has_produto set quantidade_recebida = quantidade_recebida - ? where idRefeicao = ? and idProduto = ? ;");
			$stmt->execute([$quantidade,$idRefeicao, $idProduto]);
			

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function concluirDoacao($idDoacao){
		try{
			
			$connection = ConnectionDB::getInstance();

			$connection->beginTransaction();

			$stmt = $connection->prepare("UPDATE doacao d set d.status = 'CONCLUÍDA' where d.idDoacao = ?;");
			$stmt->execute([$idDoacao]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function atenderDoacao($idDoacao, $idFornecedor){
		try{
			
			$connection = ConnectionDB::getInstance();

			$connection->beginTransaction();

			$stmt = $connection->prepare("SELECT*FROM doacao where idDoacao = ?;");
			$stmt->execute([$idDoacao]);
			$row = $stmt->fetchObject();
			if($row->status != "CONFIRMADA"){
				return false;
			}

			$stmt = $connection->prepare("UPDATE doacao d set d.idFornecedor = ?, d.status='EM ATENDIMENTO' where d.idDoacao = ?;");
			$stmt->execute([$idFornecedor,$idDoacao]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function converteLinhaObjeto($linhas){

		$listadedoacoes = [];
		foreach($linhas as $linha){
			$doacao = new Doacao();
			if(isset($linha->idDoacao)) $doacao->idDoacao = $linha->idDoacao;
			if(isset($linha->status)) $doacao->status = $linha->status;
			if(isset($linha->data)) $doacao->data = $linha->data;
			if(isset($linha->quantidade)) $doacao->quantidade = $linha->quantidade;
			if(isset($linha->valor)) $doacao->valor = $linha->valor;
			if(isset($linha->idProduto)){
				$produto = Produto::getObjetoPorId($linha->idProduto);
				$doacao->produto = $produto;
			} 
			if(isset($linha->idOng)){
				$ong = Usuario::getObjetoPorId($linha->idOng);
				$doacao->ong = $ong;
				
			} 
			if(isset($linha->idDoador)){
				$doador = Usuario::getObjetoPorId($linha->idDoador);
				$doacao->doador = $doador;
			}
			if(isset($linha->idFornecedor)){
				$fornecedor = Usuario::getObjetoPorId($linha->idFornecedor);
				$doacao->fornecedor = $fornecedor;
			}

			$listadedoacoes[] = $doacao;

		}
		return $listadedoacoes;
	}

}
?>