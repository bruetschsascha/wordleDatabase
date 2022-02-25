<?php
//get letters from the textboxes
$resetArray = array("","","","","");
$yellowLetters = (isset($_GET['yellowLetters']))? $_GET['yellowLetters']:"";
$grayLetters = (isset($_GET['grayLetters']))? $_GET['grayLetters']:0;
$greenLettersArray = array(0 => (isset($_GET['greenLetter1']))? $_GET['greenLetter1']:"", 1 => (isset($_GET['greenLetter2']))? $_GET['greenLetter2']:"", 2 => (isset($_GET['greenLetter3']))? $_GET['greenLetter3']:"", 3 => (isset($_GET['greenLetter4']))? $_GET['greenLetter4']:"", 4 =>(isset($_GET['greenLetter5']))? $_GET['greenLetter5']:"");
$yellowLettersArray = array(0 => (isset($_GET['yellowLetter1']))? $_GET['yellowLetter1']:"", 1 => (isset($_GET['yellowLetter2']))? $_GET['yellowLetter2']:"", 2 => (isset($_GET['yellowLetter3']))? $_GET['yellowLetter3']:"", 3 => (isset($_GET['yellowLetter4']))? $_GET['yellowLetter4']:"", 4 =>(isset($_GET['yellowLetter5']))? $_GET['yellowLetter5']:"");

if(isset($_POST['reset'])) {
    $yellowLetters = "";
    $grayLetters = "";
    for($i = 0; $i <5; $i++){
        $greenLettersArray[$i] = "";
    }
}
?>
<container>
    <form action="index.php" method="GET">
        <input type="text" name="yellowLetter1" class="yellowLetters" value = "<?if(empty($yellowLettersArray[0])){echo"";} else {echo $yellowLettersArray[0];} ?>">
        <input type="text" name="yellowLetter2" class="yellowLetters" value = "<?if(empty($yellowLettersArray[1])){echo"";} else {echo $yellowLettersArray[1];} ?>">
        <input type="text" name="yellowLetter3" class="yellowLetters" value = "<?if(empty($yellowLettersArray[2])){echo"";} else {echo $yellowLettersArray[2];} ?>">
        <input type="text" name="yellowLetter4" class="yellowLetters" value = "<?if(empty($yellowLettersArray[3])){echo"";} else {echo $yellowLettersArray[3];} ?>">
        <input type="text" name="yellowLetter5" class="yellowLetters" value = "<?if(empty($yellowLettersArray[4])){echo"";} else {echo $yellowLettersArray[4];} ?>">
        <input type="text" name="grayLetters" value = "<?if(empty($grayLetters)){echo"";} else {echo $grayLetters;} ?>">
        <input type="text" name="greenLetter1" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[0])){echo"";} else {echo $greenLettersArray[0];} ?>">
        <input type="text" name="greenLetter2" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[1])){echo"";} else {echo $greenLettersArray[1];} ?>">
        <input type="text" name="greenLetter3" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[2])){echo"";} else {echo $greenLettersArray[2];} ?>">
        <input type="text" name="greenLetter4" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[3])){echo"";} else {echo $greenLettersArray[3];} ?>">
        <input type="text" name="greenLetter5" class="greenLetters" maxlength="1" value = "<?if(empty($greenLettersArray[4])){echo"";} else {echo $greenLettersArray[4];} ?>">
        <input type="submit">
    </form>
    <form action="index.php" method="POST">
        <input type="submit" name="reset" value="Reset" />
    </form>
</container>

<script>
    let body = document.querySelector('body');
    body.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            document.querySelector("form").submit();
        }
    });


</script>
<style>
    input[class="yellowLetters"]{
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


//build query with green letters
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

$yellowLettersArray0 = str_split($yellowLettersArray[0], $length = 1);
$yellowLettersArray1 = str_split($yellowLettersArray[1], $length = 1);
$yellowLettersArray2 = str_split($yellowLettersArray[2], $length = 1);
$yellowLettersArray3 = str_split($yellowLettersArray[3], $length = 1);
$yellowLettersArray4 = str_split($yellowLettersArray[4], $length = 1);


//save letters from yellow/gray textbox in array
$yellowLettersArray2D = [
    $yellowLettersArray0,
    $yellowLettersArray1,
    $yellowLettersArray2,
    $yellowLettersArray3,
    $yellowLettersArray4,
];



$grayLettersArray = str_split($grayLetters, $length = 1);

//build part of the query with yellow letters
for($i = 0; $i < count($yellowLettersArray2D); $i++) {
    for($j = 0; $j < count($yellowLettersArray2D[$i]); $j++) {
    $yellowLettersQuery = $yellowLettersQuery .  'AND word LIKE "%' . $yellowLettersArray2D[$i][$j] . '%" ';
    if($i == 0){$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "' . $yellowLettersArray2D[$i][$j] . '____" ';}
    if($i == 1){$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "_' . $yellowLettersArray2D[$i][$j] . '___" ';}
    if($i == 2){$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "__' . $yellowLettersArray2D[$i][$j] . '__" ';}
    if($i == 3){$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "___' . $yellowLettersArray2D[$i][$j] . '_" ';}
    if($i == 4){$yellowLettersQuery = $yellowLettersQuery . 'AND word NOT LIKE "____' . $yellowLettersArray2D[$i][$j] . '" ';}
    }
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
