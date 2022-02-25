<?php
//get letters from the textboxes
$letter1 = (isset($_GET['letter1']))? $_GET['letter1']:0;
$letter2 = (isset($_GET['letter2']))? $_GET['letter2']:0;
$letter3 = (isset($_GET['letter3']))? $_GET['letter3']:0;
$letter4 = (isset($_GET['letter4']))? $_GET['letter4']:0;
$letter5 = (isset($_GET['letter5']))? $_GET['letter5']:0;


?>
<form action="index2.php" method="GET">
    <input type="text" name="letter1" maxlength="1" value = "<?if(empty($letter1)){echo"";} else
    {}?>">
    <input type="text" name="letter2" maxlength="1" value = "<?if(empty($letter2)){echo"";} else {echo $letter2;}?>">
    <input type="text" name="letter3" maxlength="1" value = "<?if(empty($letter3)){echo"";} else {echo $letter3;} ?>">
    <input type="text" name="letter4" maxlength="1" value = "<?if(empty($letter4)){echo"";} else {echo $letter4;} ?>">
    <input type="text" name="letter5" maxlength="1" value = "<?if(empty($letter5)){echo"";} else {echo $letter5;} ?>">
    <input type="submit">
</form>
<script>
    let body = document.querySelector('body');
    body.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            document.querySelector("form").submit();
        }
    });
    console.log(document.getElementsByName("letter1").value)
</script>
<style>
    input[type="text"] {
        border-color: #fff;
        color: #fff;
        font-family: "Arial Rounded MT Bold";
        font-size: 50px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        height: 50px;
        background-color: #e70000;
        margin: auto;
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
$greenLettersArray = array($greenLetter1, $greenLetter2, $greenLetter3, $greenLetter4, $greenLetter5);
$greenLettersQuery = 'AND word LIKE "';

for($i = 0; $i < 5; $i++) {
    echo "<br>";
    echo 'greenletters[' . $i . ']' . $greenLettersArray[$i];
    if(empty($greenLettersArray[$i])) {
        $greenLettersQuery = $greenLettersQuery . '_';

    }
    else {
        $greenLettersQuery = $greenLettersQuery . $greenLettersArray[$i];
    }
}
$greenLettersQuery = $greenLettersQuery . '"';
echo "<br>";
echo $greenLettersQuery;
if(empty($greenLetter1)) {
    $greenLetter1 = "";
}
else {
    $greenLetter1 = 'AND word LIKE "' . $greenLetter1 . '____"';
}
if(empty($greenLetter2)) {
    $greenLetter2 = "";
}
else {
    $greenLetter2 = 'AND word LIKE "_' . $greenLetter2 . '___"';
}
if(empty($greenLetter3)) {
    $greenLetter3 = "";
}
else {
    $greenLetter3 = 'AND word LIKE "__' . $greenLetter3 . '__"';
}
if(empty($greenLetter4)) {
    $greenLetter4 = "";
}
else {
    $greenLetter4 = 'AND word LIKE "___' . $greenLetter4 . '_"';
}
if(empty($greenLetter5)) {
    $greenLetter5 = "";
}
else {
    $greenLetter5 = 'AND word LIKE "____' . $greenLetter5 . '"';
}

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
$sql = 'SELECT DISTINCT word FROM words WHERE word LIKE "_____" AND word NOT LIKE "% %" AND word not like "%-%" ' . $yellowLettersQuery . $grayLettersQuery . $greenLetter1 . $greenLetter2 . $greenLetter3 . $greenLetter4 . $greenLetter5;

//
if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $words[] = $data;
    }
    if(empty($words)) {
        $words[] = "";
    }
    foreach ($words as $word) {
        echo "<br>";
        echo $word->word;
    }
}
?>
