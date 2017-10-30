<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/25/2017
 * Time: 12:31 PM
 */
?>

<?php
require_once ("assets/dbconn.php");
require_once("assets/function.php");
include_once ("assets/header.php");

$db = dbconn();

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ?? "";
echo ListCorp($db);
switch ( $action ) {
    case "Add Corperation":
        break;
}
include_once ("assets/footer.php");
?>