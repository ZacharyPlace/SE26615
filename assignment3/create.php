<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/25/2017
 * Time: 12:28 PM
 */
?>

<?php

require_once("assets/dbconn.php");
require_once("assets/function.php");
include_once("assets/header.php");
$db = dbconn();
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? "";
$corp = filter_input(INPUT_POST, 'corp', FILTER_SANITIZE_STRING) ?? "";
$incorp = filter_input(INPUT_POST, 'incorp', FILTER_SANITIZE_STRING) ?? "";
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING) ?? "";
$zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING) ?? "";
$owner = filter_input(INPUT_POST, 'owner', FILTER_SANITIZE_STRING) ?? "";
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING) ?? "";



switch ( $action ) {
    case "Add Corperation":
        AddCorp( $db, $corp, $incorp, $email, $zip, $owner, $phone );
        break;
}

include_once("assets/comp.php");
include_once("assets/footer.php");


?>
