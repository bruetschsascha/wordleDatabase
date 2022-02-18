<?php
//get letters from the textboxes

$yellowLetters = (isset($_GET['yellowLetters']))? $_GET['yellowLetters']:0;
$grayLetters = (isset($_GET['grayLetters']))? $_GET['grayLetters']:0;
$greenLettersArray = array(0 => (isset($_GET['greenLetter1']))? $_GET['greenLetter1']:"", 1 => (isset($_GET['greenLetter2']))? $_GET['greenLetter2']:"", 2 => (isset($_GET['greenLetter3']))? $_GET['greenLetter3']:"", 3 => (isset($_GET['greenLetter4']))? $_GET['greenLetter4']:"", 4 =>(isset($_GET['greenLetter5']))? $_GET['greenLetter5']:"");

?>
<form action="index.php" method="GET">
    <input type="text" name="yellowLetters" value = "<?if(empty($yellowLetters)){echo"";} else {echo $yellowLetters;} ?>">
    <input type="text" name="grayLetters" value = "<?if(empty($grayLetters)){echo"";} else {echo $grayLetters;} ?>">
    <input type="text" name="greenLetter1" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[0])){echo"";} else {echo $greenLettersArray[0];} ?>">
    <input type="text" name="greenLetter2" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[1])){echo"";} else {echo $greenLettersArray[1];} ?>">
    <input type="text" name="greenLetter3" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[2])){echo"";} else {echo $greenLettersArray[2];} ?>">
    <input type="text" name="greenLetter4" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[3])){echo"";} else {echo $greenLettersArray[3];} ?>">
    <input type="text" name="greenLetter5" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[4])){echo"";} else {echo $greenLettersArray[4];} ?>">
    <input type="submit">
</form>
<style>
    input[name="yellowLetters"]{
        background-color: #c9b458;
    }
    input[name="grayLetters"]{
        background-color: #787c7e;
    }
    input:focus-visible {
        border-color: #fff;
    }
    .greenLetters{
        background-color: #6aaa64;
        width: 25px;
        height: 25px;
    }
    input[type="text"] {
        border-color: #fff;
        color: #fff;
        font-family: "Arial Rounded MT Bold";
        height: 25px;
        text-align: center;
    }
</style>

<?php
//connect to database
$host = 'mariadb';
$user = 'root';
$pass = 'pw';
$mydatabase = 'dictionary';
$conn = new mysqli($host, $user, $pass, $mydatabase);


//build part of the query with green letters
$greenLettersQueryArray = [];


for($i = 0; $i < 5; $i++) {
    if(empty($greenLettersArray[$i])) {
        $greenLettersQueryArray[$i] = "_";
    }
    else $greenLettersQueryArray[$i] = $greenLettersArray[$i];
}

$greenLettersQuery = 'AND word LIKE "';
for($i = 0; $i < 5; $i++) {
    $greenLettersQuery = $greenLettersQuery . $greenLettersQueryArray[$i];
}
$greenLettersQuery = $greenLettersQuery . '"';


//save letters from yellow/gray textbox in array
$yellowLettersArray = str_split($yellowLetters, $length = 1);
$grayLettersArray = str_split($grayLetters, $length = 1);

//build part of the query with yellow letters
for($i = 0; $i < count($yellowLettersArray); $i++) {
    $yellowLettersQueryArray[$i] = 'AND word LIKE "%' . $yellowLettersArray[$i] . '%" ';
    $yellowLettersQuery = $yellowLettersQuery . $yellowLettersQueryArray[$i];
}

//build part of the query with gray letters
for($i = 0; $i < count($grayLettersArray); $i++) {
    $grayLettersQueryArray[$i] = 'AND word NOT LIKE "%' . $grayLettersArray[$i] . '%" ';
    $grayLettersQuery = $grayLettersQuery . $grayLettersQueryArray[$i];
}
if(empty($grayLetters)) {
    $grayLettersQuery = "";
}

//build full query
$sql = 'SELECT DISTINCT word FROM words WHERE word LIKE "_____" AND word NOT LIKE "% %" AND word not like "%-%" ' . $yellowLettersQuery . $grayLettersQuery . $greenLettersQuery;

//

if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $words[] = $data;
    }
    foreach ($words as $word) {
        echo "<br>";
        echo $word->word;
    }
}
?>
