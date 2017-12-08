<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/4/2017
 * Time: 7:37 PM
 */
?>

<?php


function getCorpsAsTable($db, $corps, $cols = null, $sortable = false)
{
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    $table = "";
    if ( count($corps) > 0):
        $table .= "<table>" . PHP_EOL;
        if ($cols && !$sortable):
            $table .= "\t<tr>";
            foreach ($cols as $col) {
                $table .= "<th>$col</th>";
            }
            $table .= "</tr>" . PHP_EOL;
        endif;
        if ($cols && $sortable):
            $table .= "\t<tr>";
            foreach ($cols as $col) {
                $dir = "ASC";
                $table .= "<th><a href='?action=sort&col=$col&dir=$dir'>$col</a></th>";
            }
            $table .= "</tr>" . PHP_EOL;
        endif;
        foreach ($corps as $corp):
            $table .= "\t<tr>";
            $table .= "<td>" . $corp['id'] . "</td>";
            $table .= "<td>" . $corp['corp'] . "</td>";
            $table .= "<td>" . date('m/d/Y', strtotime($corp['incorp_dt'])) . "</td>";
            if (strtotime($corp['incorp_dt']) > 0) :
                $table .= date('m/d/Y', strtotime($corp['incorp_dt']));
            else :
                $table .= "&nbsp;";
            endif;
            $table .= "<td>" . $corp['email'] . "</td>";
            $table .= "<td>" . $corp['zipcode'] . "</td>";
            $table .= "<td>" . $corp['owner'] . "</td>";
            $table .= "<td>" . $corp['phone'] . "</td>";
            $table .= "</tr>" . PHP_EOL;
        endforeach;
        $table .= "</table>" . PHP_EOL;
        return $table;
    else :
        return "<section>There is nothing to display</section>";
    endif;
}
//Function gets corps as sorted table
function getCorpsAsSortedTable($db, $col, $dir) {
    try {
        $sql = "SELECT `corps`.`id`, `corps`.`corp`, `corps`.`incorp_dt`, `corps`.`email`, `corps`.`zipcode`, `corps`.`owner`, `corps`.`phone` 
FROM `corps`
ORDER BY $col $dir`";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $corps = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $table = "<table>";
        foreach ($corps as $corp):
            $table .= "\t<tr>";
            $table .= "<td>" . $corp['id'] . "</td>";
            $table .= "<td>" . $corp['corp'] . "</td>";
            $table .= "<td>" . date('m/d/Y', strtotime($corp['incorp_dt'])) . "</td>";
            if (strtotime($corp['incorp_dt']) > 0) :
                $table .= date('m/d/Y', strtotime($corp['incorp_dt']));
            else :
                $table .= "&nbsp;";
            endif;
            $table .= "<td>" . $corp['email'] . "</td>";
            $table .= "<td>" . $corp['zipcode'] . "</td>";
            $table .= "<td>" . $corp['owner'] . "</td>";
            $table .= "<td>" . $corp['phone'] . "</td>";
            $table .= "</tr>" . PHP_EOL;
        endforeach;
    } catch (PDOException $e) {
        die ("There was a problem getting the table of Corps");
    }
    return $corps;
}

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
                $table .= "</td></tr><tr><td>" . $corpV['zip'];
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
function getCorps($db) {
    try {
        $sql = "SELECT * FROM corps";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $corps = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("Could not retrieve Corperations");
    }
    return $corps;
}
//Function retrieves form
function companyForm() {
    $form = "<form method='post' action=''>";
    $form .= "<input type='text' name='corp' />" . PHP_EOL;
    $form .= "<input type='text' name='incorp' />" . PHP_EOL;
    $form .= "<input type='text' name='email' />" . PHP_EOL;
    $form .= "<input type='text' name='zip' />" . PHP_EOL;
    $form .= "<input type='text' name='owner' />" . PHP_EOL;
    $form .= "<input type='text' name='phone' />" . PHP_EOL;
    $form .= "<input type='submit' name='action' value='Submit' />" . PHP_EOL;
    $form .= "</form>";
    return $form;
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

//function delete corp
function deleteCorp($db, $id) {
    $sql = "DELETE FROM corps WHERE id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}
//function delete corp table
function getCorpAsDelete($db, $id)
{
    try {
        $sql = $db->prepare("SELECT * FROM corps WHERE id = $id");
        $sql->execute();
        $corps = $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("There was a problem getting the table of Corps");
    }
    //var_dump($corps);
    setlocale(LC_MONETARY, 'en_US.UTF-8');
    $table = "<table>";
    foreach ($corps as $corp):
        $table .= "<tr><td>Are you sure you want to delete this corp? </td>";
        $table .= "<td>" . $corp['id'] . "</td>";
        $table .= "<td>" . $corp['corp'] . "</td>";
        $table .= "<td>" . date('m/d/Y', strtotime($corp['incorp_dt'])) . "</td>";
        $table .= "<td>" . $corp['email'] . "</td>";
        $table .= "<td>" . $corp['zipcode'] . "</td>";
        $table .= "<td>" . $corp['owner'] . "</td>";
        $table .= "<td>" . $corp['phone'] . "</td></tr>";
        $table .= "<tr><td>" . "<form method='post' action='#'>" . "</td></tr>";
        $table .= "<tr><td>" . "<input type='submit' name='action' value='Delete' />" . "</td></tr>";
    endforeach;
    $table .= "</table>" . PHP_EOL;
    return $table;
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