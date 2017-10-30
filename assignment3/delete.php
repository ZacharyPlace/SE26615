<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/25/2017
 * Time: 12:28 PM
 */
?>

<?php

require_once ("assets/dbconn.php");
require_once("assets/function.php");
include_once ("assets/header.php");
$id = filter_input(INPUT_GET, 'id' );
$db = dbconn();
$sql = $db->prepare("DELETE FROM corps WHERE id = :id");
$array = array(
    ":id" => $id
);
$isDeleted = false;
if ($sql->execute($array) && $sql->rowCount() > 0 ) {
    $isDeleted = true;
}

?>

Record <?php echo $id; ?>
<?php if (!$isDeleted ): ?>Not<?php endif; ?>
Deleted

<?php include_once("assets/footer.php"); ?>
