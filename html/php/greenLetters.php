<?php
//get all grayLetters
$greenLettersArray = array(0 => (isset($_GET['greenLetter1']))? $_GET['greenLetter1']:"", 1 => (isset($_GET['greenLetter2']))? $_GET['greenLetter2']:"", 2 => (isset($_GET['greenLetter3']))? $_GET['greenLetter3']:"", 3 => (isset($_GET['greenLetter4']))? $_GET['greenLetter4']:"", 4 =>(isset($_GET['greenLetter5']))? $_GET['greenLetter5']:"");

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