<?php 

class ConnectionDB{
	private static $connection;
	
	private function __construct(){
		
	}
	
	public static function getInstance()
    {
        if (is_null(self::$connection)) {
            self::$connection = new \PDO('mysql:host=localhost;port=3306;dbname=mydb', 'root', '');
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$connection->exec('set names utf8');
        }
        return self::$connection;
    }
	
	
}


?>

