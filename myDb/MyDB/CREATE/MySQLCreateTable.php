<?php

class MySQLCreateTable extends AbstractCreateTable{
	protected $dbName = "test";
	
	private function alterTable($cols){
		foreach($desc as $k => $v){
			if(!in_array($v["Field"], $cols)){
				echo $v["Field"];
				$this->execute("ALTER TABLE ".$this->name." DROP COLUMN ".$v["Field"]."");
			}
		}
		var_dump($desc);
		var_dump($cols);
	}
	
	private function existTable($name){
		$table = array();
		$dbName = $this->dbName;
		
		$this->select("SHOW TABLES FROM ".$this->dbName."", function($t) use(&$table, $dbName){
			$table[] =  $t["Tables_in_$dbName"];
		});
		
		return in_array($name, $table);
	}
	
	private function descTable($name){
		$desc = array();
		$this->select("DESCRIBE $name", function($d) use(&$desc){
			$desc[] = $d;
		});
		return $desc;
	}
	
	private function colNames(){
		$cols = array();
		foreach($this->description as $col => $p){
			$cols[] = $col;
		}
		return $cols;
	}
	
	public function exec(){
		if($this->existTable($this->name)){
			$descs =  $this->descTable($this->name);
			$cols =  $this->colNames();
			$this->alterTable(array)
			return;
		}
		
		$sqlCode = array();
		$cols = array();
		$primaryKey = array();
		$foreignKey = array();
		// var_dump($this->name, $this->description);
		
		foreach($this->description as $colname => $col){
			$cols[] = $colname;
			$code = "$colname";
			switch($col["datatype"]){
				case "integer" : $code .= " INT"; break;
				case "tinyint" : $code .= " TINYINT"; break;
				case "smallint" : $code .= " SMALLINT"; break;
				case "mediumint" : $code .= " MEDIUMINT"; break;
				case "bigint" : $code .= " BIGINT"; break;
				case "float" : $code .= " FLOAT"; break;
				case "varchar" : $code .= " VARCHAR"; break;
				case "text" : $code .= " TEXT"; break;
				case "tinytext" : $code .= " TINYTEXT"; break;
				case "mediumtext" : $code .= " MEDIUMTEXT"; break;
				case "longtext" : $code .= " LONGTEXT"; break;
				case "enum" : $code .= " ENUM"; break;
				case "char" : $code .= " CHAR"; break;
				case "bool" : $code .= " BOOLEAN"; break;
				case "datetime" : $code .= " DATETIME"; break;
				case "date" : $code .= " DATE"; break;
				case "time" : $code .= " TIME"; break;
				case "timestamp" : $code .= " TIMESTAMP"; break;
			}
			if(isset($col["size"])){
				$code .= "(".$col["size"].")";
			}else{
				switch($col["datatype"]){
					case "integer" : $code .= "(11)"; break;
					case "varchar" : $code .= "(255)"; break;
					case "char" : $code .= "(1)"; break;
				}
			}
			if($col["datatype"] == "enum"){
				if(!isset($col["value"])){$col["value"] = "0, 1";}
				$values = preg_split("#,#", $col["value"]);
				$v = array();
				foreach($values as $value){
					$v[] = "'".trim($value)."'";
				}
				$code .= "(".implode(",", $v).")";
			}
			if(isset($col["pk"]) and $col["pk"] == true){
				$primaryKey[] = $colname;
			}
			if(isset($col["null"]) and $col["null"] == true){
				$code .= " NULL";
			}else{
				$code .=  " NOT NULL";
			}
			
			if(isset($col["ai"]) and $col["ai"] == true){
				$code .= " AUTO_INCREMENT";
			}
			if(isset($col["fk"]) && $col["fk"] == true){
				$foreignKey[] = "CONSTRAINT fk_".$this->name."_".$colname." FOREIGN KEY($colname) REFERENCES ".$col["tableName"]."(".$colname.")";
			}
			$sqlCode[] = $code;
		}
		if(!empty($primaryKey)) $sqlCode[] = "PRIMARY KEY(".implode(",", $primaryKey).")";
		if(!empty($foreignKey)) $sqlCode[] = implode(",", $foreignKey);	
		// var_dump($sqlCode);
		$code = "CREATE TABLE IF NOT EXISTS ".$this->name."(".implode(",", $sqlCode).")ENGINE=".$this->engine;
		// $this->execute($code);
	}
}
?>