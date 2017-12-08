<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/8/2017
 * Time: 12:46 PM
 */

require_once ("assets/dbconn.php");
require_once("assets/functions.php");
$title = "Site Listings";
include_once ('assets/header.php');
$option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING) ?? NULL;
$db = dbconn();
$varSel = "<form method='post' action='#'>";
$varSel .= dropDown($db);
$varSel .= "<input type='submit' name='action' value='Submit' />";
echo $varSel;
if (isPostRequest()) {
    echo grabSite($db, $option);
}
include_once('assets/footer.php');