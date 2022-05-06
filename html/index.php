<?php
//get letters from the textboxes
$resetArray = array("","","","","");

$yellowLettersArray = array(0 => (isset($_GET['yellowLetter1']))? $_GET['yellowLetter1']:"", 1 => (isset($_GET['yellowLetter2']))? $_GET['yellowLetter2']:"", 2 => (isset($_GET['yellowLetter3']))? $_GET['yellowLetter3']:"", 3 => (isset($_GET['yellowLetter4']))? $_GET['yellowLetter4']:"", 4 =>(isset($_GET['yellowLetter5']))? $_GET['yellowLetter5']:"");
$greenLettersArray = array(0 => (isset($_GET['greenLetter1']))? $_GET['greenLetter1']:"", 1 => (isset($_GET['greenLetter2']))? $_GET['greenLetter2']:"", 2 => (isset($_GET['greenLetter3']))? $_GET['greenLetter3']:"", 3 => (isset($_GET['greenLetter4']))? $_GET['greenLetter4']:"", 4 =>(isset($_GET['greenLetter5']))? $_GET['greenLetter5']:"");
$grayLetters = (isset($_GET['grayLetters']))? $_GET['grayLetters']:0;

include "./php/grayLetters.php";
include "./php/greenLetters.php";
include "./php/yellowLetters.php";
include "index.html";

//reset button
if(isset($_POST['reset'])) {
    $yellowLetters = "";
    $grayLetters = "";
    for($i = 0; $i <5; $i++){
        $greenLettersArray[$i] = "";
    }
}

//connect to database
$host = 'mariadb';
$user = 'root';
$pass = 'pw';
$mydatabase = 'dictionary';
$conn = new mysqli($host, $user, $pass, $mydatabase);

//build full query
$sql = 'SELECT DISTINCT word FROM words WHERE word LIKE "_____" AND word NOT LIKE "% %" AND word not like "%-%" ' . $yellowLettersQuery . $grayLettersQuery . $greenLettersQuery;

//output of query
if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $words[] = $data;
    }

    if(!empty($words)) {
        foreach ($words as $word) {
            echo "<br>";
            echo $word->word;
        }
    }else {
        echo "Ich kann leider kein Wort finden 🙂";
    }
}
?>
