<?
class BD{
	private $host;
	private $user;	
	private $password;
	private $database;
	private $conn;	

	public function BD($c){
		$this->host=$c['host'];
		$this->user= $c['user'];
		$this->password = $c['password'];
		$this->database= $c['database'];
		$this->abrir();
	}
	
	/*Abre la base de datos*/	
	private function abrir() {
		if($this->conn = mysql_connect($this->host, $this->user, $this->password)){
			if(!mysql_select_db($this->database, $this->conn) ){
				throw new Exception("Error al seleccionar la base de datos '".$this->database."', MySQL Error ".mysql_error());
			}else{
				mysql_query ("SET NAMES 'utf8'",$this->conn);
			}
		}else{
			throw new Exception("Error al conectarse con '".$this->host."', MySQL Error ".mysql_error());
		}
	}
	
	/*cierra la base de datos*/
	private function cerrar() {
		if(!mysql_close($this->conn)){
			throw new Exception("Error al cerrar la conexión,  MySQL Error ".mysql_error());
		}
	}
	public function consultar($sql) {
		if($rs = mysql_query($sql, $this->conn)){
			$registros = array();
			while ( $reg=mysql_fetch_array($rs) ) {
				$registros[] = $reg;
			}		
			return $registros;		
		}else{
			throw new Exception("Error al ejecutar la consulta '".$sql."',  MySQL Error ".mysql_error());
		}
	}
        public function consultar_($sql) {
		if($rs = mysql_query($sql, $this->conn)){
			$reg=mysql_fetch_array($rs);
			return $reg;		
		}else{
			throw new Exception("Error al ejecutar la consulta '".$sql."',  MySQL Error ".mysql_error());
		}
	}
	public function ejecutar($sql) {
		if(mysql_query($sql, $this->conn)){		
			return true;		
		}else{
			throw new Exception("Error al ejecutar la consulta '".$sql."',  MySQL Error ".mysql_error());
		}
	}
	public function ejecutarInsert($sql) {
		if(mysql_query($sql, $this->conn)){		
			return mysql_insert_id($this->conn);		
		}else{
			throw new Exception("Error al ejecutar la consulta '".$sql."',  MySQL Error ".mysql_error());
		}
	}
	
	public function ejecutarInsertArray($array, $table) {
		try{
			$columnas="";
			$valores="";
			foreach($array as $c=>$v){
				$columnas .= $c.",";
				$valores .= "'".$v."',";
			}
			$columnas = substr($columnas,0,strlen($columnas)-1);
			$valores = substr($valores,0,strlen($valores)-1);
			$sql="INSERT INTO ".$table."(".$columnas.") values(".$valores.")";
			return $this->ejecutarInsert($sql);
		}catch(Exception $e){
			throw new Exception($e->getMessage());
		}
	}
	
	public function ejecutarUpdateArray($array,$table, $where){
		$columnas="";
		$valores="";
		foreach($array as $c=>$v){
			$columnas .= $c."="."'".addslashes($v)."',";
		}
		$columnas = substr($columnas,0,strlen($columnas)-1);

		$sql="UPDATE ".$table." SET ".$columnas." WHERE ".$where ;
		return $this->ejecutar($sql);
	}
        
        public function ejecutarBorrar($table, $where){
            $sql="DELETE from ".$table." WHERE ".$where ;
		return $this->ejecutar($sql);
        }
	
	public function num_consulta($sql) {
		if($rs = mysql_query($sql, $this->conn) ){
			return mysql_num_rows($rs);		
		}else{
			throw new Exception("No es posible determinar el número de filas de la consulta '".$sql."',  MySQL Error ".mysql_error());
		}
	}
}

$bd = new BD($conexion['local']);
//$bd = new BD($dbconfig['db_hostname'],$dbconfig['db_username'],$dbconfig['db_password'] ,$dbconfig['db_name']);
?>