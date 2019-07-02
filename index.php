<!DOCTYPE html>
<?php

require_once("TLTController.php");
$controller = new TLTController();

if (array_key_exists("submit", $_POST)) {
    $titles = $controller->getTheLongestTitles();
} else {
    $titles = array();
}
?>

<html>
<head>
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<header>
    <h1>The Longest Title</h1>
    <hr>
    <br>
</header>
<body style="text-align:center">
<form name="submit" action="index.php" method="post">
    <button name="submit" class="btn btn-success">Get Top 10 Longest Titles</button>
    <br>
    <br>
    <table style="width:100%" class="table table-dark">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Number of Combinations</th>
            </tr>
        </thead>
        <?php
        foreach ($titles as $title => $numCombinations) {
            echo "\t\t<tr>\n";
            echo "\t\t\t\t<td>" . $title . "</td>\n";
            echo "\t\t\t\t<td>" . $numCombinations . "</td>\n";
            echo "\t\t</tr>\n";
        }
        ?>
        <tr>
</form>
</body>
</html>