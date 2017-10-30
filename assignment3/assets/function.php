<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/25/2017
 * Time: 12:30 PM
 */
?>

<?php

function ListCorp($db) {
    try {
        $sql = $db->prepare("SELECT * FROM corps");
        $sql->execute();
        $phpclassfall2017 = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ( $sql->rowCount() > 0 ) {
            $table = "<table>" . PHP_EOL;
            foreach ( $phpclassfall2017 as $corpLs ) {
                $table .= "<tr><td style='display:none'>" . $corpLs['id'];
                $table .= "</td><td>" . $corpLs['corp'];
                $table .= "</td><td>" . "<a href=\"read.php?id=" . $corpLs['id'] . "\"> View </a>";
                $table .= "</td><td>" . "<a href=\"update.php?id=" . $corpLs['id'] . "\"> Update </a>";
                $table .= "</td><td>" . "<a href=\"delete.php?id=" . $corpLs['id'] . "\"> Remove </a>";
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<br />";
            $table .= "<br />";
        } else {
            $table = "There are no Corporations.";
            $table .= "<br />";
            $table .= "<br />";
        }
        return $table;
    } catch (PDOException $e){
        die("There was a problem with getting the Corporations from the database.");
    }
}
//Displays corp when the 'View' Button is clicked
function ViewCorp($db, $id)
{
    try {
        $sql = $db->prepare("SELECT * FROM corps WHERE id = $id");
        $sql->execute();
        $phpclassfall2017 = $sql->fetchAll(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            $table = "<table>" . PHP_EOL;
            foreach ($phpclassfall2017 as $corpV) {
                $table .= "<tr><td>" . $corpV['corp'];
                //$table .= "</td></tr><tr><td>" . $corpV['incorp'];
                $table .= "</td></tr><tr><td>" . $corpV['email'];
                $table .= "</td></tr><tr><td>" . $corpV['zipcode'];
                $table .= "</td></tr><tr><td>" . $corpV['owner'];
                $table .= "</td</tr><tr>><td>" . $corpV['phone'];
                $table .= "</td></tr>";
            }
            $table .= "</table>" . PHP_EOL;
            $table .= "<br />";
            $table .= "<br />";
        } else {
            $table = "There are no Corporations.";
            $table .= "<br />";
            $table .= "<br />";
        }
        return $table;
    } catch (PDOException $e) {
        die("There was a problem with getting the Corporations from the database.");
    }
}
//Function adds a corp to the database
function AddCorp($db, $corp, $incorp, $email, $zip, $owner, $phone) {
    try {
        $sql = $db->prepare("INSERT INTO corps SET corp = :corp, incorp_dt = :incorp_dt, email = :email, zipcode = :zipcode, owner = :owner, phone = :phone");
        $sql->bindParam(':corp', $corp);
        $sql->bindParam(':incorp', $incorp);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':zip', $zip);
        $sql->bindParam(':owner', $owner);
        $sql->bindParam(':phone', $phone);
        $sql->execute();
        return $sql->rowCount();
    } catch (PDOException $e) {
        die("There was a problem adding a Corporation.");
    }
}
//Function updates corp
function UpdateCorp($db, $id, $corp, $incorp, $email, $zip, $owner, $phone ){
    try {
        $sql = $db->prepare("UPDATE corps SET corp = :corp, incorp = :incorp, email = :email, zip = :zip, owner = :owner, phone = :phone WHERE id = $id");
        $sql->fetchAll(PDO::FETCH_ASSOC);
        $sql->bindParam(':corp', $corp);
        $sql->bindParam(':incorp', $incorp);
        $sql->bindParam(':email', $email);
        $sql->bindParam(':zip', $zip);
        $sql->bindParam(':owner', $owner);
        $sql->bindParam(':phone', $phone);
        $sql->execute();
        return $sql->rowCount();
    } catch (PDOException $e) {
        die("There was a problem updating a Corporation.");
    }
}
//Post request function
function isPostRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}
//Get request function
function isGetRequest() {
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'GET' );
}
?>