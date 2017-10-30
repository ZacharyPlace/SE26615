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
include_once ("assets/header.php");
$db = dbconn();
$id = filter_input(INPUT_GET, 'id');
//Declared Variables
$corp = '';
$email = '';
$zipcode = '';
$owner = '';
$phone = '';
$message = '';
//Gets the current data from the DB
$sql = $db->prepare("SELECT * FROM corps WHERE id = $id");
$sql->execute();
$phpclassfall2017 = $sql->fetchAll(PDO::FETCH_ASSOC);
if ($sql->rowCount() > 0) {
    $corpid = '';
    foreach ($phpclassfall2017 as $corpD) {
        $corpid .= $corpD['corp'];
        $corpid .= $corpD['incorp'];
        $corpid .= $corpD['email'];
        $corpid .= $corpD['zip'];
        $corpid .= $corpD['owner'];
        $corpid .= $corpD['phone'];
    }
}
//Sents the update to the server
if( isPostRequest()){
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? "";
    $id = filter_input(INPUT_GET, 'id');
    $corp = filter_input(INPUT_POST, 'corp');
    $incorp_dt = filter_input(INPUT_POST, 'incorp');
    $email = filter_input(INPUT_POST, 'email');
    $zipcode = filter_input(INPUT_POST, 'zip');
    $owner = filter_input(INPUT_POST, 'owner');
    $phone = filter_input(INPUT_POST, 'phone');
    UpdateCorp($db, $id, $corp, $incorp, $email, $zip, $owner, $phone);
    if($sql->rowCount() > 0 ){
        $message = 'Corporation record has been updated';
    }else {
        $message = 'Corporation record did not update';
    }
}
?>

<form method="post" action="#">
    Corporation: <input type="text" name="corp" value="<?php echo $corpD['corp'] ?>" />
    <br />
    Email: <input type="text" name="email" value="<?php echo $corpD['email'] ?>"/>
    <br />
    Zip Code: <input type="text" name="zip" value="<?php echo $corpD['zip'] ?>"/>
    <br />
    Owner: <input type="text" name="owner" value="<?php echo $corpD['owner'] ?>"/>
    <br />
    Phone: <input type="text" name="phone" value="<?php echo $corpD['phone'] ?>"/>
    <br />
    <input type="submit" name="action" value="Submit" />
</form>
<p> <?php echo $message ?> </p>
</br></br>
<p> <a href = "index.php"> Back </a></p>
<?php
include_once("assets/footer.php");
?>
