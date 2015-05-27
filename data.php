<?php

class Connection {
	private $host = 'localhost', $name = 'seprj', $user = 'root', $pass = 'root';

	public function Connect() {
		return new PDO("mysql:host=$this->host; dbname=$this->name", $this -> user, $this -> pass);
	}

}
class showData {
    	public function __construct() {
		$this -> database = new Connection();
		$this -> database = $this -> database -> Connect();
	}
    public function jsonShowAllItemsDataWithField($item, $fieldName) {
		$this -> item = $item;
		$finalArray = array( $id = array());
		$this -> fieldName = $fieldName;
		$query = 'SELECT * FROM food_' . $this -> item;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		for($i = 0 ; $i < count($result); $i++) {
			foreach ($result[$i] as $key => $value) {
				if($key == $this -> fieldName) {
					array_push($finalArray, $value);					
				}
			}
		}
		return json_encode($finalArray, JSON_NUMERIC_CHECK);
	}
	
	public function jsonShowAllItemsData($item) {
		$this -> item = $item;
		$finalArray = array( $id = array());
		$query = 'SELECT * FROM food_' . $this -> item;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		
		return json_encode($result[1], JSON_NUMERIC_CHECK);
	}
}
/*
$someA = array( $id = array('1','1.1'), '2');
print_r($someA[0][1]);*/
?>