<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/8/2017
 * Time: 12:53 PM
 */
//Function grabs sites when called
function getSites($db) {
    try {
        $sql = "SELECT * FROM sites";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $sites = $stmt->fetchALL(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die ("There was a problem getting the table of sites");
    }
    return $sites;
}
//Function that creates a site form when called
function siteForm() {
    $form = "<form method='post' action='#'>";
    $form .= "URL: <input type='text' name='site' /> <br />" . PHP_EOL;
    $form .=  "<input type='submit' name='action' value='Save' />" . PHP_EOL;
    $form .= "</form>";
    return $form;
}
function validateSite($db, $site, $date, $sites) {
    //Function Compares site with all other sites in the database and check to make sure site is valid, if it is, website will be added to the database
    if (isset($_POST['site'])) {
        if (empty($_POST['site'])) {
            echo "You must enter a site name";
        } else if (!preg_match("/(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)/", $_POST['site'])) {
            echo "Site is in invalid format. Example: https://www.cnn.com/";
        } else {
            //No Duplicates
            $rowNum = findSite($db, $site);
            if($rowNum == 0) {
                $sites = array();
                $file = file_get_contents($_POST['site']);
                preg_match_all("/(https?:\/\/[\da-z\.-]+\.[a-z\.]{2,6}[\/\w \.-]+)/", $file, $matches, PREG_OFFSET_CAPTURE);
                foreach($matches as $match) {
                    foreach($match as $m){
                        array_push($sites, $m[0]);
                        echo "<a href='" . $m[0] . "'>" . $m[0] . "</a><br />";
                    }
                }
                addSite($db, $site, $date, $sites);
            } else {
                echo "Site has already been entered";
            }
        }
    }
}
//Function adds sites when called
function addSite($db, $site, $date, $sites) {
    try {
        $sql = $db->prepare("INSERT INTO sites SET site = :site, date = :date");
        $sql->bindParam(':site', $site);
        $sql->bindParam(':date', $date);
        $sql->execute();
        $siteID = $db->lastInsertId();
        foreach ($sites as $link){
            $sql = $db->prepare("INSERT INTO sitelinks VALUES (:site_id, :link)");
            $sql->bindParam(':link', $link);
            $sql->bindParam(':site_id', $siteID);
            $sql->execute();
        }
        return $sql->rowCount();
    } catch (PDOException $e) {
        die ("There was a problem adding a Site.");
    }
}
//Function finds sites when called
function findSite($db, $site){
    try {
        $sql = $db->prepare("SELECT Count(*) FROM sites WHERE site=:site");
        $sql->bindParam(':site', $site);
        $sql->execute();
        $rowNum = $sql->fetchColumn();
        return $rowNum;
    } catch (PDOException $e) {
        die ("There was a problem checking the Sites.");
    }
}
//Function creates and populates a drop down when called
function dropDown($db){
    try {
        $sql = $db->prepare("SELECT * FROM sites");
        $sql->execute();
        $sites = $sql->fetchALL(PDO::FETCH_ASSOC);
        if ($sql->rowCount() > 0) {
            $select = "<select name='option'>" . PHP_EOL;
            //$select .= "<option select='true'> Select A Website </option>";
            foreach ($sites as $site) {
                $select .= "<option>" . $site['site'] . "</option>";
            }
            $select .= "</select>";
        } else {
            $select = "there are no sites to grab";
        }
        return $select;
    } catch (PDOException $e) {
        die ("There was a problem retrieving the sites");
    }
}
//Function grabs site links when called from drop down
function grabSite($db, $option){
    try{
        $sql = $db->prepare("SELECT site_id, date FROM sites WHERE site=:option");
        $sql->bindParam(":option", $option);
        $sql->execute();
        $sites = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach($sites as $site) {
            echo "<br>" . "Links for " . $option . " was stored on " . $site['date'] . "<hr>";
            $siteID = $site['site_id'];
        }
        $sql = $db->prepare("SELECT * FROM sitelinks WHERE site_id=:site_id");
        $sql->bindParam(":site_id", $siteID);
        $sql->execute();
        $sites = $sql->fetchAll(PDO::FETCH_ASSOC);
        foreach($sites as $site){
            echo "<a href='" . $site['link'] . "' target='_blank'/>" . $site['link'] . "<br>";
        }
    } catch(PDOException $e){
        die ("There was a problem getting the site links");
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