<!DOCTYPE html>
<?php

/**
 * index.php
 *
 * Displays all movie title combinations returned from getMovieTitleCombos() in TLTController.php.
 * Displays the titles in an aesthetically pleasing Bootstrap table, sorted by number of combinations.
 *
 * @author     Jordan Rifaey <contact@jordanrifaey.com>
 * @license    https://www.php.net/license/3_01.txt  PHP License 3.1
 */

require_once("TLTController.php");
$controller = new TLTController();

if (array_key_exists("submit", $_POST)) {
    $titles = $controller->getMovieTitleCombos();
} else {
    $titles = array();
}
?>

<html lang="en">
<head>
    <title>The Longest Title</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<header>
    <h1>The Longest Title</h1>
    <hr>
    <br>
</header>
<body style="text-align:center">
<form name="submit" action="index.php" method="post">
    <button name="submit" class="btn btn-success">Find the 10 longest movie title combinations</button>
    <br>
    <br>
</form>
<table style="width:100%" class="table table-striped">
    <thead>
    <tr>
        <th>Title</th>
        <th>Number of Combinations</th>
    </tr>
    </thead>
    <?php
    //Echo out the results as an HTML table.
    foreach ($titles as $title => $numCombinations) {
        echo "\t<tr>\n";
        echo "\t\t<td>" . $title . "</td>\n";
        echo "\t\t<td>" . $numCombinations . "</td>\n";
        echo "\t</tr>\n";
    }
    ?>
</body>
</html>