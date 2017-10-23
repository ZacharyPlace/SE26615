<?php
/**
 * Created by PhpStorm.
 * User: 001428022
 * Date: 10/19/2017
 * Time: 11:20 AM
 */
?>

function dbconn() {
$dsn = "mysql:host=localhost;dbname=phpclassfall2017";
$username = "phpclassfall2017";
$password = "se266";
try {
$db = new PDO($dsn, $username, $password);
return $db;
} catch (PDOException $e) {
//echo $e->getMessage();
die("There was a problem connecting to the database.");
}
}
?>