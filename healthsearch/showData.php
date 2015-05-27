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

	public function selectCategory($category) {
		$finalResult = array();
		$this -> category = $category;
		$query = 'SELECT name FROM category WHERE name = \'' . $this -> category . '\'';
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		for ($i = 0; $i < count($result); $i++)
			array_push($finalResult, $result[$i]["name"]);
		return $finalResult;
	}

	public function selectInCategory($category, $in_category) {
		$finalResult = array();
		$this -> category = $category;
		$this -> in_category = $in_category;
		$query = 'SELECT name FROM category_' . strtolower($this -> category) . ' WHERE name =\'' . $this -> in_category . '\'';
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		for ($i = 0; $i < count($result); $i++)
			array_push($finalResult, $result[$i]["name"]);
		return $finalResult;
	}

	public function selectItem($item) {
		$finalResult = array();
		$this -> item = $item;
		$query = 'SELECT * FROM food_' . $this -> item;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $key => $value)
			array_push($finalResult, $value);
		return $finalResult;
	}

	public function jsonShowAllCategory() {
		$finalResult = array();
		$query = 'SELECT * FROM category';
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $key => $value)
			array_push($finalResult, $value["name"]);
		return json_encode($finalResult);
	}

	public function jsonShowAllInCategory($category) {
		$finalResult = array();
		$this -> category = $category;
		$query = 'SELECT * FROM category_' . $this -> category;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $key => $value)
			array_push($finalResult, $value["name"]);
		return json_encode($finalResult);
	}

	public function jsonShowAllItemsData($item) {

		/* To get specific field $finalArray[index]["fieldName"] */

		$this -> item = $item;
		$finalArray = array();
		$query = 'SELECT * FROM food_' . $this -> item;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		for ($i = 0; $i < Count($result); $i++)
			array_push($finalArray, $result[$i]);
		return json_encode($finalArray);
	}

	public function jsonShowAllItemsDataWithField($item, $fieldName) {

		$this -> item = $item;
		$finalArray = array();
		$this -> fieldName = $fieldName;
		$query = 'SELECT * FROM food_' . $this -> item;
		$statement = $this -> database -> prepare($query);
		$statement -> execute();
		$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
		for ($i = 0; $i < count($result); $i++) {
			foreach ($result[$i] as $key => $value) {
				if ($key == $this -> fieldName)
					array_push($finalArray, $value);
			}
		}
		return json_encode($finalArray);
	}

	public function jsonSelectOnlyCategory($category) {
		$this -> category = $category;
		$_resultCategory = $this -> selectCategory($this -> category);
		return json_encode($_resultCategory);
	}

	public function jsonSelectInCategory($category, $in_category) {
		$this -> category = $category;
		$this -> in_category = $in_category;
		$_resultInCategory = $this -> selectInCategory($this -> category, $this -> in_category);
		return json_encode($_resultInCategory);
	}

	public function jsonSelectItem($item) {
		$this -> item = $item;
		$_resultItem = $this -> selectItem($this -> item);
		return json_encode($_resultItem);
	}

	public function rangedSelectInCategory($category, $startInCategory, $untilInCategory) {

		/* Select ranged of category with item, but not with data  */

		$start;
		$end;
		$finalResult = array();
		$this -> category = $category;
		$this -> startInCategory = $startInCategory;
		$this -> untilInCategory = $untilInCategory;
		$result = json_decode($this -> jsonShowAllInCategory($category));
		foreach ($result as $key => $value) {
			if ($this -> startInCategory == strtolower($value))
				$start = $key;
			elseif ($this -> untilInCategory == strtolower($value))
				$end = $key;
		}
		for ($i = $start; $i <= $end; $i++)
			array_push($finalResult, $result[$i]);
		return json_encode($finalResult);
	}

	/*  ----------------------------------------Utilities function---------------------------------------- */

	public function decompose($string) {
		$this -> string = $string;
		$attribute = array();
		$tableArray = array();
		$valueArray = array();
		$paramArray = array();
		$finalResult = array();
		$this -> string = explode('" ', strtolower($this -> string));
		for ($i = 0; $i < count($this -> string); $i++) {
			$this -> string[$i] = explode(":", $this -> string[$i]);
			for ($j = 0; $j < count($this -> string[$i]); $j++) {
				$frag = preg_replace('/[\"\s+]/', "", $this -> string[$i]);
				array_push($attribute, $frag[$j]);
			}
		}
		for ($a = 0; $a < count($attribute); $a++) {
			if (!preg_match('/[0-9]/', $attribute[$a])) {
				if ($this -> selectItem($attribute[$a]) && !empty($attribute[$a]) && !$this -> selectCategory($attribute[$a])) {
					array_push($tableArray, $attribute[$a]);
				}
				else if (!$this -> selectCategory($attribute[$a]) && !empty($attribute[$a])) {
					array_push($paramArray, $attribute[$a]);
				}
			} else if(preg_match('/[0-9]/', $attribute[$a])) {
				if (!preg_match('/[<>]/', $attribute[$a])) {
					$attribute[$a] = str_replace($attribute[$a], '=' . $attribute[$a], $attribute[$a]);
				}
				if(!empty($attribute[$a]))	
					array_push($valueArray, $attribute[$a]);
			}
		}
		if(empty($tableArray)) {
			$all = json_decode($this -> jsonShowAllCategory());
			for($b = 0; $b < count($all); $b++) {
				$allInAll = json_decode($this -> jsonShowAllInCategory(strtolower($all[$b])));
				for($c = 0; $c < count($allInAll); $c++)
					array_push($tableArray, strtolower($allInAll[$c]));
			}
		}
		foreach ($tableArray as $key => $value) {
			$length = 1;
			if(!empty($paramArray)) {
				$query = 'SELECT * FROM food_' . $value . ' WHERE ';
				for ($i = 0; $i < count($paramArray); $i++) {
					if (count($paramArray) != $length)
						$query = $query . $paramArray[$i] . ' ' . $valueArray[$i] . ' AND ';
					else
						$query = $query . $paramArray[$i] . ' ' . $valueArray[$i];
					$length++;
				}
			} else
				$query = 'SELECT * FROM food_' . $value;
			$statement = $this -> database -> prepare($query);
			$statement -> execute();
			$result = $statement -> fetchAll(PDO::FETCH_ASSOC);
			if(!empty($result)) {
				for($c = 0; $c < count($result); $c++)
					array_push($finalResult, $result[$c]);
			}
		}
		echo '<table border="1"><tr><td>Portion</td><td>Fat(g):</td>
		<td>Calories(g):</td><td>Sugar(g):</td><td>Fiber(g):</td>
		<td>Total Carbs(g):</td><td>Transfat(g):</td><td>Protein(g):</td>
		<td>Sodium(mg):</td><td>Cholestrol(mg):</td></tr>';
		
		for ($d=0; $d < count($finalResult); $d++) {
			echo'<td>';
			print $finalResult[$d]['name'];
			echo'</td><td>';
			print $finalResult[$d]['fat'];
			echo'</td><td>';
			print $finalResult[$d]['calories'];
			echo'</td><td>';
			print $finalResult[$d]['sugar'];
			echo'</td><td>';
			print $finalResult[$d]['fiber'];
			echo'</td><td>';
			print $finalResult[$d]['total_carbs'];
			echo'</td><td>';
			print $finalResult[$d]['trans'];
			echo'</td><td>';
			print $finalResult[$d]['protein'];
			echo'</td><td>';
			print $finalResult[$d]['sodium'];
			echo'</td><td>';
			print $finalResult[$d]['cholesterol'];
			echo'</td>';
			echo '</tr>';
		}
		echo '</table>';
	}

	public function searchQueryFormator($string) {
		$this -> string = $string;
		$this -> string = preg_replace('/<[^>]*>/', "", $this -> string);
		return $this -> string;
	}
	
	public function tableNameFormator($prefix, $resultIndex) {
		$this -> prefix = $prefix;
		$this -> resultIndex = $resultIndex;
		$formatedResult = str_replace($this -> resultIndex, $this -> prefix . strtolower($this -> resultIndex), $this -> resultIndex);
		return $formatedResult;
	}
}
$myShow = new showData();
$obtainFromJS = '';
if(isset($_POST['value'])) {
	$obtainFromJS = $_POST['value'];
	$formatedString = $myShow -> searchQueryFormator($obtainFromJS);
	$myShow -> decompose($formatedString);
}

?>
