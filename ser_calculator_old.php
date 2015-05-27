<?php
/*
 * Metric Formula (Cm):
 * Men #Percentage of Fat = 495 / (1.0324 - 0.19077 x (LOG10(waist - neck)) + 0.15456 x (LOG10(height))) - 450
 * Women #Percentage of Fat = 495 / (1.29579 - 0.35004 x (LOG10(waist + hip - neck)) + 0.22100 x (LOG10(height))) - 450
 * English Formula (Inches):
 * Men #Percentage of Fat = (86.01 x LOG10((waist) - (neck))) - (70.041 x LOG10(height)) + 36.76
 * Women #Percentage of Fat = (163.205 x LOG10((waist) + (hip) - (neck))) - (97.684 x LOG10(height)) - 78.387
 */

// Defining the "BodyFatCalculator" class 
class BodyCalculator {
    
    private $BMR;
    
    function getBMR(){return $this->BMR;}

    function calMaleMetric($height, $weight, $waist, $hip, $neck) {
        $this->height = $height;
        $this->weight = $weight;
        $this->waist = $waist;
        $this->hip = $hip;
        $this->neck = $neck;
        $this->BMR = 495 / (1.0324 - 0.19077 * (log10($this->waist - $this->neck)) + 0.15456 * (log10($this->height))) - 450;
        return round($this->BMR);
    }

    function calFemaleMetric($height, $weight, $waist, $hip, $neck) {
        $this->height = $height;
        $this->weight = $weight;
        $this->waist = $waist;
        $this->hip = $hip;
        $this->neck = $neck;
        $this->BMR = 495 / (1.29579 - 0.35004 * (log10($this->waist + $this->hip - $this->neck)) + 0.22100 * (log10($this->height))) - 450;
        echo round($this->BMR) . '%<br>';
    }

    function calMaleBMR($height, $weight, $age) {
        $this->height = $height;
        $this->weight = $weight;
        $this->age = $age;
        $this->BMR = 655 + ( 9.6 * $this->weight ) + ( 1.8 * $this->height ) - ( 4.7 * $this->age );
        echo "Don't exceed ".round($this->BMR).' calories per day.<br>';
    }
    
    function calFemaleBMR($height, $weight, $age) {
        $this->height = $height;
        $this->weight = $weight;
        $this->age = $age;
        $this->BMR = 66 + ( 13.7 * $this->weight ) + ( 5 * $this->height ) - ( 6.8 * $this->age);
        echo "Don't exceed ".round($this->BMR).' calories per day.<br>';
    }
    
    function calTDEE() {
        $BMR = $this->getBMR();
        $TDEE = 1.55*$BMR;
        echo "The total calories you will burn in a day is ".round($TDEE);
    }

}

$getResult = new BodyCalculator();
/*
$getResult->calMaleMetric(185, 87, 99, 108, 38); //height, weight, waist, hip, neck
$getResult->calFemaleMetric(185, 87, 99, 108, 38);
$getResult->calMaleBMR(87, 185, 20); // height, weight, age
$getResult->calFemaleBMR(56, 177, 22); // height, weight, age
$getResult->calTDEE();
*/

	$req = $_GET;
    $preq = $req[request];
    $post = $_POST;
    if ($preq == 'calMaleMetric')
        echo $getResult->calMaleMetric($post[height], $post[weight], $post[waist], $post[hip], $post[neck]);
?>
