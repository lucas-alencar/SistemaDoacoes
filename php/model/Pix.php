<?php 

require_once("ConnectionDB.php");
require_once("Usuario.php");

class Pix{
	public $pix;
	public $ong;	

	public function __construct($param = null){
		if (isset($param[0]))$this->pix = $param[0];
		if (isset($param[1]))$this->ong = Usuario::getObjetoPorId($param[1]);

	}
	
	public static function getobjetoPorPix($param = null){
		try{
		$connection = ConnectionDB::getInstance();
		$stmt    = $connection->prepare("SELECT * FROM pix where pix = ?;");
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
	
	public function salvar(){
		
		try{
			
			$objetoExistente = self::getobjetoPorPix($this->pix);
		
			if(!is_null($objetoExistente) && !empty($objetoExistente)){
				return false;
			}
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("INSERT INTO pix (pix, idOng) values(?,?)");
			$stmt->execute([$this->pix, $this->ong->idUsuario]);
			
			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			return false;

		}

	}

	public static function converteLinhaObjeto($linha = null){
		
		$objeto = new Pix();

		if(!is_null($linha) && !empty($linha)){
			$objeto->pix = $linha->pix;
			$objeto->ong = Usuario::getObjetoPorId($linha->idOng);
		}
		

		return $objeto;		
	}

	public static function listarTodosOng($param = null){

		try{
			$connection = ConnectionDB::getInstance();
			$stmt    = $connection->prepare("SELECT * FROM pix where idOng = ?;");
			$objeto = array();
			
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

	public function remover(){
		try{
		
			$connection = ConnectionDB::getInstance();
			
			$connection->beginTransaction();
			$stmt = $connection->prepare("DELETE from pix where pix=?");
			$stmt->execute([$this->pix]);

			$connection->commit();
			return true;

		} catch(Exception $e){
			$connection->rollBack();
			echo 'Erro: ',  $e->getMessage(), "\n";
			return false;

		}

	}
		
}


?>

