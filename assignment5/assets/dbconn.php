<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/8/2017
 * Time: 12:52 PM
 */

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