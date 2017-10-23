<?php
/**
 * Created by PhpStorm.
 * User: 001428022
 * Date: 10/19/2017
 * Time: 11:37 AM
 */
?>
<?php
require_once ("assets/dbconn.php");
require_once ("assets/actors.php");
include_once ("assets/header.php");

$db = dbconn();


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? "";
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING) ?? "";
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING) ?? "";
$dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING) ?? "";
$height = filter_input(INPUT_POST, 'height', FILTER_SANITIZE_STRING) ?? "";

    switch ( $action ) {
      case "Add":
           addActor( $db, $firstname, $lastname, $dob, $height );
          break;
}

echo ActorsTable($db);

include_once ("assets/actorform.php");
include_once ("assets/footer.php");
?>