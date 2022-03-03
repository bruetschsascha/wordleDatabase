<?php
//getting input of yellowletter in Array
$yellowLettersArray = array(0 => (isset($_GET['yellowLetter1']))? $_GET['yellowLetter1']:"", 1 => (isset($_GET['yellowLetter2']))? $_GET['yellowLetter2']:"", 2 => (isset($_GET['yellowLetter3']))? $_GET['yellowLetter3']:"", 3 => (isset($_GET['yellowLetter4']))? $_GET['yellowLetter4']:"", 4 =>(isset($_GET['yellowLetter5']))? $_GET['yellowLetter5']:"");

//take every letter in every textbox
$yellowLettersArray0 = str_split($yellowLettersArray[0], $length = 1);
$yellowLettersArray1 = str_split($yellowLettersArray[1], $length = 1);
$yellowLettersArray2 = str_split($yellowLettersArray[2], $length = 1);
$yellowLettersArray3 = str_split($yellowLettersArray[3], $length = 1);
$yellowLettersArray4 = str_split($yellowLettersArray[4], $length = 1);


//save letters from yellow textbox in 2D array
$yellowLettersArray2D = [
    $yellowLettersArray0,
    $yellowLettersArray1,
    $yellowLettersArray2,
    $yellowLettersArray3,
    $yellowLettersArray4,
];


//build part of the query with yellow letters
for($i = 0; $i < count($yellowLettersArray2D); $i++) {
    for($j = 0; $j < count($yellowLettersArray2D[$i]); $j++) {
        if($yellowLettersArray2D[$i][$j] != " ") {
            $yellowLettersQuery = $yellowLettersQuery .  'AND word LIKE "%' . $yellowLettersArray2D[$i][$j] . '%" ';
            if ($i == 0) {$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "' . $yellowLettersArray2D[$i][$j] . '____" ';}
            if ($i == 1) {$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "_' . $yellowLettersArray2D[$i][$j] . '___" ';}
            if ($i == 2) {$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "__' . $yellowLettersArray2D[$i][$j] . '__" ';}
            if ($i == 3) {$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "___' . $yellowLettersArray2D[$i][$j] . '_" ';}
            if ($i == 4) {$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "____' . $yellowLettersArray2D[$i][$j] . '" ';}
        }
    }
}
