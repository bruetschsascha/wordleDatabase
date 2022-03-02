<?php
//get letters from the textboxes
$resetArray = array("","","","","");

include "./php/greenLetters.php";
include "./php/grayLetters.php";
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
