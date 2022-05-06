<?php

$grayLettersArray = str_split($grayLetters, $length = 1);

for($i = 0; $i < count($grayLettersArray); $i++){
    for($j = 0; $j < count($greenLettersArray); $j++){
        if($greenLettersArray[$j] == $grayLettersArray[$i] && !empty($greenLettersArray[$j])){
            $grayLettersQuery = $grayLettersQuery . 'AND word NOT LIKE "%' . $grayLettersArray[$i] . '%' . $grayLettersArray[$i] .'%" ';
            $grayLettersArray[$i] = " ";
        }
    }
}

//build part of the query with gray letters
for($i = 0; $i < count($grayLettersArray); $i++) {
    if($grayLettersArray[$i] != " ") {
        $grayLettersQueryArray[$i] = 'AND word NOT LIKE "%' . $grayLettersArray[$i] . '%" ';
        $grayLettersQuery = $grayLettersQuery . $grayLettersQueryArray[$i];
    }
}


if(empty($grayLetters)) {
    $grayLettersQuery = "";
}
