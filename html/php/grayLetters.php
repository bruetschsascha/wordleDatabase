<?php

$grayLetters = (isset($_GET['grayLetters']))? $_GET['grayLetters']:0;

$grayLettersArray = str_split($grayLetters, $length = 1);

//build part of the query with gray letters
for($i = 0; $i < count($grayLettersArray); $i++) {
    $grayLettersQueryArray[$i] = 'AND word NOT LIKE "%' . $grayLettersArray[$i] . '%" ';
    $grayLettersQuery = $grayLettersQuery . $grayLettersQueryArray[$i];
}
if(empty($grayLetters)) {
    $grayLettersQuery = "";
}
