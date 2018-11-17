<?php
// Define configuration
define("DB_HOST", "localhost");
define("DB_USER", "vocabje1_user");//vocabje1_admin
define("DB_PASS", "mysqlvocabjet#2");//mkj942804#1
define("DB_NAME", "vocabje1_admin");

class Database{		
	private $host      = DB_HOST;
    private $user      = DB_USER;
    private $pass      = DB_PASS;
    private $dbname    = DB_NAME; 
    private $dbh;
    private $error;
	private $stmt;	
	
	
	
	
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname.';charset=utf8';
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}
	public function pdoInsert($_dataBaseAndTable, $_dataAry){
				$dLen = count($_dataAry);//$_dataAry[0,0]=>timestamp, $_dataAry[0,1]=>uId
				$colAry=[];
				$colAry_2=[];
				$valAry=[];
				
				for($i=0; $i<$dLen; $i++){
					$colAry[$i] = $_dataAry[$i][0];
					$valAry[$i] = $_dataAry[$i][1];
				}
				for($k=0; $k<$dLen; $k++){
					$colAry_2[$k]=":".$colAry[$k];
				}
				
				$colStr_1= implode(",", $colAry);
				$colStr_2= implode(",", $colAry_2);			
				$sql	=	'INSERT INTO '.$_dataBaseAndTable.' ('.$colStr_1.') VALUES ('.$colStr_2.')';
				$this->query($sql);
				for($j=0; $j<$dLen; $j++){
					$this->bind(":".$colAry[$j]		, $valAry[$j] );
				}
				$this->execute();		
	}
	
	
	public function pdoUpdate($_dataBaseAndTable, $_dataAry, $_whereStr){
				$dLen = count($_dataAry);//$_dataAry[0,0]=>timestamp, $_dataAry[0,1]=>uId
				$colAry=[];
				$colAry_2=[];
				$valAry=[];
				
				for($i=0; $i<$dLen; $i++){
					$colAry[$i] = $_dataAry[$i][0];
					$valAry[$i] = $_dataAry[$i][1];
				}
				for($k=0; $k<$dLen; $k++){
					$colAry_2[$k]=":".$colAry[$k];
				}					
				for($m=0; $m<$dLen; $m++){
					$colAry_1[$m]= "`".$colAry[$m]."` = :".$colAry[$m];
				}								
				
				$colStr_1= implode(",", $colAry_1);
			
				$sql = "UPDATE ".$_dataBaseAndTable." SET ".$colStr_1." WHERE ".$_whereStr;
				$this->query($sql);
				for($j=0; $j<$dLen; $j++){
					$this->bind(":".$colAry[$j]		, $valAry[$j] );
				}
				$this->execute();		
	}
	
	
	
	

	public function bind($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}
	public function execute(){
		return $this->stmt->execute();
	}	
	public function resultset(){//搜尋結果陣列用欄位名取出
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function resultsetByNum(){//搜尋結果陣列用數字取出
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_NUM);
	}	
	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function singleByNum(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_NUM);
	}
	public function fetchColumn(){//回傳總列數
		return $this->stmt->fetchColumn();
	}
	public function rowCount(){//回傳總異動列數
		return $this->stmt->rowCount();
	}
	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}
	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}
	public function endTransaction(){
		return $this->dbh->commit();
	}
	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}
	public function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}	
}