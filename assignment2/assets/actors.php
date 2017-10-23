<?php
/**
 * Created by PhpStorm.
 * User: 001428022
 * Date: 10/19/2017
 * Time: 11:013 AM
 */
?>
<?php
function ActorsTable($db) {
try {
$sql = $db->prepare("SELECT * FROM actors");
$sql->execute();
$phpclassfall2017 = $sql->fetchAll(PDO::FETCH_ASSOC);
if ( $sql->rowCount() > 0 ) {
$table = "<table>" . PHP_EOL;
    foreach ( $phpclassfall2017 as $actor ) {
    $table .= "<tr><td>" . $actor['firstname'];
            $table .= "</td><td>" . $actor['lastname'];
            $table .= "</td><td>" . $actor['dob'];
            $table .= "</td><td>" . $actor['height'];
            $table .= "</td></tr>";
    }
    $table .= "</table>" . PHP_EOL;
$table .= "<br />";
$table .= "<br />";
} else {
$table = "There are no actors available.";
$table .= "<br />";
$table .= "<br />";
}
return $table;
} catch (PDOException $e){
die("could not locate actors");
}
}
function addActor($db, $firstname, $lastname, $dob, $height) {
try {
$sql = $db->prepare("INSERT INTO actors VALUES (null, :firstname, :lastname, :dob, :height)");
$sql->bindParam(':firstname', $firstname);
$sql->bindParam(':lastname', $lastname);
$sql->bindParam(':dob', $dob);
$sql->bindParam(':height', $height);
$sql->execute();
return $sql->rowCount();
} catch (PDOException $e) {
die("could not add actor.");
}
}
?>
