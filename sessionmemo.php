<?php
class SSController {
	public $page = '';
	private $queryCases = '';
	private $sent = '';
	public $sql = '';
	private $query = '';
	public $queryCondition = '';
	public $search = '';
	
	/* function __construct() {
		$conn = $this->connectDB();
		if(!empty($conn)) {
			$this->selectDB($conn);
		}
	}
	
	function connectDB() {
		$conn = mysql_connect($this->host,$this->user,$this->password);
		return $conn;
	}
	
	function selectDB($conn) {
		mysql_select_db($this->database,$conn);
	}
	
	function runQuery($query) {
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysql_query($query);
		$rowcount = mysql_num_rows($result);
		return $rowcount;	
	} */
	
	function gen_query($search, $DB){
		if(!empty($search)) {
		foreach($search as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("topic","code","text","mark1","mark2");
				if(in_array($k,$queryCases)) {
					if(!empty($this->queryCondition)) {
						$this->queryCondition .= " AND ";
					} else {
						$this->queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "topic":
						$topic = $v;
						$this->queryCondition .= "topic LIKE '%" . $v . "%'";
						break;
					case "code":
						$code = $v;
						$this->queryCondition .= "code LIKE '%" . $v . "%'";
						break;
					case "text":
						$text = $v;
						$this->queryCondition .= "text LIKE '%" . $v . "%'";
						break;
					case "mark1":
						$mark1 = $v;
						$this->queryCondition .= "mark1 LIKE '%" . $v . "%'";
						break;
					case "mark2":
						$mark2 = $v;
						$this->queryCondition .= "mark2 LIKE '%" . $v . "%'";
						break;
					echo $v;
				}
			}
		}
	}
	
	$this->sql = "SELECT * FROM " . $DB . $this->queryCondition;
	$orderby = "";
	$perPage = 10; 
	//$page = $this->page;
	$start = ($this->page - 1)*$perPage;
	if($start < 0) $start = 0;
	$this->query =  $this->sql . $orderby .  " limit " . $start . "," . $perPage; 
	return $this->query;
	}
	
	function set_sent(){
		$this->sent = "sent";
	}
	
	function check_sent(){
		return $this->sent;
	}
	
	function clear_sent(){
		$this->sent = "";
	}
	
	function set_page($page){
		$this->page = $page;
	}
	
	function set_queryCases($queryCases){
		$this->queryCases = $queryCases;
	}
}
?>