<?php
//get all grayLetters

//build query with green letters
$greenLettersQueryArray = [];
for($i = 0; $i < 5; $i++) {
    if(empty($greenLettersArray[$i]) || $greenLettersArray[$i] == " ") {
        $greenLettersQueryArray[$i] = "_";
    }
    else $greenLettersQueryArray[$i] = $greenLettersArray[$i];
}

$greenLettersQuery = 'AND word LIKE "';
for($i = 0; $i < 5; $i++) {
    $greenLettersQuery = $greenLettersQuery . $greenLettersQueryArray[$i];
}
$greenLettersQuery = $greenLettersQuery . '"';