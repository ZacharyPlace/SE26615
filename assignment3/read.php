<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/25/2017
 * Time: 12:29 PM
 */
?>

<?php

require_once ("assets/dbconn.php");
require_once("assets/function.php");
include_once ("assets/header.php");
//Displays one corp with all information
$db = dbconn();
$id = filter_input(INPUT_GET, 'id');
echo ViewCorp($db, $id);
include_once ("assets/footer.php");
?>