<form action="index.php" method="get">
    <input type="text" name="yellowLetters">
    <input type="submit">
</form>
<style>
    input[name="yellowLetters"]{
        background-color: yellow
    }
</style>
<?php
$yellowLetters = (isset($_GET['yellowLetters']))? $_GET['yellowLetters']:8;