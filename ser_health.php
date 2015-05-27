<?php
class Goal {
	private $goalBMR = 0;
	
	function calGoal() {
		$current_weight = $_POST[w];			// UI取資料  	現在體重
		$height = $_POST[h];					// UI取資料		身高
		$age = $_POST[age];						// UI取資料		年齡
		$goal_weight = $_POST[gw];				// UI取資料  	目標減到幾多公斤
		
		// 維持現在體重所需要既卡路里
		$currentBMR = 655 + (9.6 * $current_weight) + (1.8 * $height) - (4.7 * $age);
		echo "Your Calorie requirement is: " . round($currentBMR) . ' calories per day.<br />';


		// 減肥所需要既卡路里
		$goalBMR = 655 + (9.6 * $goal_weight) + (1.8 * $height) - (4.7 * $age);
		echo "Your future calorie requirement is: " . round($goalBMR) . ' calories per day.<br />';
	}


		// 每日既運動會用幾多卡路里
	function calTDEE($activity) {
		$TDEE = 0;					//value from UI
		$this -> BMR = 1557;
		$this -> activity = $activity;

		switch ($this->activity) {
			case 1 :
				$TDEE = 1.2 * $this -> BMR;
				break;
			case 2 :
				$TDEE = 1.375 * $this -> BMR;
				break;
			case 3 :
				$TDEE = 1.375 * $this -> BMR;
				break;
			case 4 :
				$TDEE = 1.725 * $this -> BMR;
				break;
			case 5 :
				$TDEE = 1.9 * $this -> BMR;
				break;
			default :
				echo "";
		}
		echo "The total calories you will burn in a day is " . round($TDEE);
	}

}
$ex = new Goal();
$ex->calGoal();
$ex->calTDEE(1);

?>
