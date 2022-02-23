<?php
//get letters from the textboxes
$yellowLetters = (isset($_GET['yellowLetters']))? $_GET['yellowLetters']:0;
$grayLetters = (isset($_GET['grayLetters']))? $_GET['grayLetters']:0;
$greenLetter1 = (isset($_GET['greenLetter1']))? $_GET['greenLetter1']:0;
$greenLetter2 = (isset($_GET['greenLetter2']))? $_GET['greenLetter2']:0;
$greenLetter3 = (isset($_GET['greenLetter3']))? $_GET['greenLetter3']:0;
$greenLetter4 = (isset($_GET['greenLetter4']))? $_GET['greenLetter4']:0;
$greenLetter5 = (isset($_GET['greenLetter5']))? $_GET['greenLetter5']:0;


?>
<form action="index.php" method="GET">
    <input type="text" name="yellowLetters" value = "<?if(empty($yellowLetters)){echo"";} else {echo $yellowLetters;} ?>">

    <input type="text" name="grayLetters" value = "<?if(empty($grayLetters)){echo"";} else {echo $grayLetters;} ?>">

    <input type="text" name="greenLetter1" class="greenLetters" maxlength="1" value = "<?if(empty($greenLetter1)){echo"";} else {echo $greenLetter1;} ?>">
    <input type="text" name="greenLetter2" class="greenLetters" maxlength="1" value = "<?if(empty($greenLetter2)){echo"";} else {echo $greenLetter2;}?>">
    <input type="text" name="greenLetter3" class="greenLetters" maxlength="1" value = "<?if(empty($greenLetter3)){echo"";} else {echo $greenLetter3;} ?>">
    <input type="text" name="greenLetter4" class="greenLetters" maxlength="1" value = "<?if(empty($greenLetter4)){echo"";} else {echo $greenLetter4;} ?>">
    <input type="text" name="greenLetter5" class="greenLetters" maxlength="1" value = "<?if(empty($greenLetter5)){echo"";} else {echo $greenLetter5;} ?>">
    <input type="submit">
</form>
<script>
    let body = document.querySelector('body');
    body.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            document.querySelector("form").submit();
        }
    });
</script>
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
