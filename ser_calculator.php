<?php

/*
 * Metric Formula (Cm):
 * Men #Percentage of Fat = 495 / (1.0324 - 0.19077 x (LOG10(waist - neck)) + 0.15456 x (LOG10(height))) - 450
 * Women #Percentage of Fat = 495 / (1.29579 - 0.35004 x (LOG10(waist + hip - neck)) + 0.22100 x (LOG10(height))) - 450
 * English Formula (Inches):
 * Men #Percentage of Fat = (86.01 x LOG10((waist) - (neck))) - (70.041 x LOG10(height)) + 36.76
 * Women #Percentage of Fat = (163.205 x LOG10((waist) + (hip) - (neck))) - (97.684 x LOG10(height)) - 78.387

 * 
 * 64.96
 * */

// Defining the "BodyFatCalculator" class 
class BodyCalculator {

    private $BMR, $leftArray = array();

    function setArray($object) {
        $this->object = object;
        array_push($this->leftArray, $this->object);
    }

    function getArray() {
        return ($this->leftArray);
    }

    function getBMR() {
        return $this->BMR;
    }

    function clearArray() {
        $this->leftArray = array();
    }

    function chooseMeasurement($sex, $measure, $height, $weight, $waist, $hip, $neck, $activity) {
        $this->sex = $sex;
        $this->height = $height;
        $this->weight = $weight;
        $this->waist = $waist;
        $this->hip = $hip;
        $this->neck = $neck;
        $this->measure = $measure;
        $this->activity = $activity;
        
        if ($this->measure == 1 && $this->sex == 1) {
            $result = $this->calMaleBodyFatUS($this->height, $this->waist, $this->neck);
            $result2 = $this->calBMRUS($this->height, $this->weight, $this->age);
            $result3 = $this->calTDEE($this->activity);
            $this->clearArray();
            array_push($this->leftArray, $result);
            array_push($this->leftArray, $result2);
            array_push($this->leftArray, $result3);
            return $this->leftArray;
        } else if ($this->measure == 2 && $this->sex == 1) {
            $result = $this->calMaleBodyFatMetric($this->height, $this->waist, $this->neck);
            $result2 = $this->calBMRMetric($this->height, $this->$weight, $this->age);
            $result3 = $this->calTDEE($this->activity); 
            $this->clearArray();
            array_push($this->leftArray, $result);
            array_push($this->leftArray, $result2);
            array_push($this->leftArray, $result3);
            return $this->leftArray;
        } else if ($this->measure == 1 && $this->sex == 2) {
            if ($this->hip == NULL) {
                echo "Please enter your hip rate!";
            } else {
                $result = $this->calFemaleBodyFatUS($this->height, $this->waist, $this->hip, $this->neck);
                $result2 = $this->calBMRUS($this->height, $this->weight, $this->age);
                $result3 = $this->calTDEE($this->activity);
                $this->clearArray();
                array_push($this->leftArray, $result);
                array_push($this->leftArray, $result2);
                array_push($this->leftArray, $result3);
                return $this->leftArray;
            }
        } else if ($this->measure == 2 && $this->sex == 2) {
            if ($this->hip == NULL) {
                echo "Please enter your hip rate!";
            } else {
                $result = $this->calFemaleBodyFatMetric($this->height, $this->waist, $this->hip, $this->neck);
                $result2 = $this->calBMRMetric($this->height, $this->weight, $this->age);
                $result3 = $this->calTDEE($this->activity);
                $this->clearArray();
                array_push($this->leftArray, $result);
                array_push($this->leftArray, $result2);
                array_push($this->leftArray, $result3);
                return $this->leftArray;
            }
        }
    }

    function calMaleBodyFatUS($height, $waist, $neck) {
        $this->height = $height;
        $this->waist = $waist;
        $this->neck = $neck;
        $this->height = ($this->height / 2.54);
        $this->waist = ($this->waist / 2.54);
        $this->neck = ($this->neck / 2.54);
        $this->US_bodyFat = (86.01 * (log10($this->waist - $this->neck))) - (70.041 * (log10($this->height))) + 36.76;
        
        return '(US-Male) Your Body Fat percentage is ' . abs(round($this->US_bodyFat)) . ' %';
    }

    function calMaleBodyFatMetric($height, $waist, $neck) {
        $this->height = $height;
        $this->weight = $weight;
        $this->waist = $waist;
        $this->hip = $hip;
        $this->neck = $neck;
        $this->M_bodyFat = 495 / (1.0324 - 0.19077 * (log10($this->waist - $this->neck)) + 0.15456 * (log10($this->height))) - 450;
        return '(Metric-Male) Your Body Fat percentage is ' . abs(round($this->M_bodyFat)) . ' %';
    }

    function calFemaleBodyFatUS($height, $waist, $hip, $neck) {
        $this->height = ($this->height / 2.54);
        $this->waist = ($this->waist / 2.54);
        $this->hip = ($this->hip / 2.54);
        $this->neck = ($this->neck / 2.54);
        $this->US_bodyFat = (163.205 * (log10($this->waist + $this->hip - $this->neck))) - (97.684 * (log10($this->height))) - 78.387;
        //round($this->US_bodyFat);
        return '(US-Female) Your Body Fat percentage is ' . abs(round($this->US_bodyFat)) . ' %';
    }

    function calFemaleBodyFatMetric($height, $waist, $hip, $neck) {
        $this->height = $height;
        $this->waist = $waist;
        $this->hip = $hip;
        $this->neck = $neck;
        $this->M_bodyFat = 495 / (1.29579 - 0.35004 * (log10($this->waist + $this->hip - $this->neck)) + 0.22100 * (log10($this->height))) - 450;
        //$this->M_bodyFat = round($this->M_bodyFat);
        return '(Metric-Female) Your Body Fat percentage is ' . abs(round($this->M_bodyFat)) . ' %';
    }

    function calBMRUS($height, $weight, $age) {
        $this->height = ($this->height / 2.54);
        $this->weight = ($this->weight / 2.54);
        $this->age = $age;
        $this->BMR = 66 + ( 13.7 * $this->weight ) + ( 5 * $this->height ) - ( 6.8 * $this->age);
        return "Minimum Calorie requirement is: " . round($this->BMR) . ' calories per day.';
    }

    function calBMRMetric($height, $weight, $age) {
        $this->height = $height;
        $this->weight = $weight;
        $this->age = $age;
        $this->BMR = 655 + ( 9.6 * $this->weight ) + ( 1.8 * $this->height ) - ( 4.7 * $this->age );
        return "Minimum Calorie requirement is: " . round($this->BMR) . ' calories per day.';
    }

    function calTDEE($activity) {
        $TDEE = 0;
        $this->BMR = $this->getBMR();
        $this->activity = $activity;
        
        switch ($this->activity) {
            case 1:
                $TDEE = 1.2 * $this->BMR;
                break;
            case 2:
                $TDEE = 1.375 * $this->BMR;
                break;
            case 3:
                $TDEE = 1.375 * $this->BMR;
                break;
            case 4:
                $TDEE = 1.725 * $this->BMR;
                break;
            case 5:
                $TDEE = 1.9 * $this->BMR;
                break;
            default:
                echo "";
        }
        return "The total calories you will burn in a day is " . round($TDEE);
    }

}

$getResult = new BodyCalculator();

$getResult->getArray();

$req = $_GET;
$preq = $req[request];
$post = $_POST;
if ($preq == 'chooseMeasurement')
    echo json_encode($getResult->chooseMeasurement($post[sex], $post[measure], $post[height], $post[weight], $post[waist], $post[hip], $post[neck], $post[activity]));
?>