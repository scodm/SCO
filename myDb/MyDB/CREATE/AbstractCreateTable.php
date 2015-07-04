<?php

abstract class AbstractCreateTable{
	
	public $name = null;
	public $engine = "INNODB";
	public $description = array();
	
	public function __construct($name = ""){
		$this->name($name);
	}
	
	public function name($name){
			$this->name = $name;
			return $this;
	}
	public function engine($name){
			$this->engine = $name;
			return $this;
	}
	public function integer($colname, $definition = array()){
		$this->addData($colname, "integer", $definition);
		return $this;
	}
	public function tinyint($colname, $definition = array()){
		$this->addData($colname, "tinyint", $definition);
		return $this;
	}
	public function smallint($colname, $definition = array()){
		$this->addData($colname, "smallint", $definition);
		return $this;
	}
	public function mediumint($colname, $definition = array()){
		$this->addData($colname, "mediumint", $definition);
		return $this;
	}
	public function bigint($colname, $definition = array()){
		$this->addData($colname, "bigint", $definition);
		return $this;
	}
	public function float($colname, $definition = array()){
		$this->addData($colname, "float", $definition);
		return $this;
	}
	public function varchar($colname, $definition = array()){
		$this->addData($colname, "varchar", $definition);
		return $this;
	}
	public function text($colname, $definition = array()){
		$this->addData($colname, "text", $definition);
		return $this;
	}
	public function tinytext($colname, $definition = array()){
		$this->addData($colname, "tinytext", $definition);
		return $this;
	}
	public function mediumtext($colname, $definition = array()){
		$this->addData($colname, "mediumtext", $definition);
		return $this;
	}
	public function longtext($colname, $definition = array()){
		$this->addData($colname, "longtext", $definition);
		return $this;
	}
	public function enum($colname, $definition = array()){
		$this->addData($colname, "enum", $definition);
		return $this;	
	}
	public function char($colname, $definition = array()){
		$this->addData($colname, "char", $definition);
		return $this;	
	}
	public function bool($colname, $definition = array()){
		$this->addData($colname, "bool", $definition);
		return $this;	
	}
	public function datetime($colname, $definition = array()){
		$this->addData($colname, "datetime", $definition);
		return $this;
	}
	public function date($colname, $definition = array()){
		$this->addData($colname, "date", $definition);
		return $this;
	}
	public function time($colname, $definition = array()){
		$this->addData($colname, "time", $definition);
		return $this;
	}
	public function timestamp($colname, $definition = array()){
		$this->addData($colname, "timestamp", $definition);
		return $this;
	}
	protected function addData($name, $type, $definition){
		$definition["datatype"] = $type;
		$names  = preg_split("#,#", $name);
		foreach($names as $col){
			$col = trim($col);
			if(empty($col)) continue;
			$this->description[$col] = $definition;
		}
	}
	
	
	public function dbConnection(){
		try{
			$this->db = new PDO("mysql:host=localhost;dbname=test", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
			$this->db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);	
			$this->db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		}catch(Exception $e){
			$this->sqlError($e);
		}
	}
	
	public function execute($query, $params = array()){
			
		try{
			$req = $this->db->prepare($query);
			$req->execute($params);
		}catch(Exception $e){
			die($e);
		}
	}
	
	public function select($query, $params = array(), $function = null){
		$this->dbConnection();
		if(is_null($params)){ $params = array(); }
		if(!is_array($params)){ $function = $params; $params = array(); }
		try{
			$req = $this->db->prepare($query);
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
		
	public function exec(){
		 echo "None";
	}
}
?>