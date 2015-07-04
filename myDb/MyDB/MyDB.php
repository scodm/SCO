<?php

require_once "MyDB/CREATE/AbstractCreateTable.php";
require_once "MyDB/CREATE/MySQlCreateTable.php";

class MyDB{
	private static $db = null;
	
	private static function dbConnection(){
		try{
			self::$db = new PDO("mysql:host=localhost;dbname=test", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
			self::$db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);	
			self::$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		}catch(Exception $e){
			die($e);
		}
	}
	
	private static function execute($query, $params = array()){
		self::dbConnection();
		try{
			$req = self::$db->prepare($query);
			$req->execute($params);
		}catch(Exception $e){
			die($e);
		}
	}
	
	public static function select($query, $params = array(), $function = null){
		self::dbConnection();
		if(is_null($params)){ $params = array(); }
		if(!is_array($params)){ $function = $params; $params = array(); }
		try{
			$req = self::$db->prepare($query);
			$r = $req->execute($params);
			if($r){ 
				if(!is_null($function)){ while($data = $req->fetch()){ $function($data); } }
				$req->closeCursor();
				return true;
			}else{ $req->closeCursor(); return false; }
		}catch(Exception $e){
			die($e);
		}
	}
	
	public static function createTable($name){
		//todo récuperer $db
		
		$db = strtolower("MySQL");
		
		switch($db){
			case "mysql" : 
				return new MySQLCreateTable($name);
			break;
		}
	}
	
	public static function viderTable($name){
		$db = strtolower("MySQL");
		
		switch($db){
			case "mysql" : 
				self::execute("DELETE FROM ".$name);
			break;
		}
	}
	
	public static function  deleteTable($name){
		$db = strtolower("MySQL");
		
		switch($db){
			case "mysql" : 
				self::execute("DROP TABLE IF EXISTS ".$name);
			break;
		}
	}
}
?>