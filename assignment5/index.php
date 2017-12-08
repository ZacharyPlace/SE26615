<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/8/2017
 * Time: 12:46 PM
 */

require_once ("assets/dbconn.php");
require_once("assets/functions.php");
//include_once("assets/header.php");
$title = "";
$db = dbconn();
// get the data from user, if any
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? NULL;
$site = filter_input(INPUT_POST, 'site', FILTER_SANITIZE_STRING) ?? NULL;
$sites = filter_input(INPUT_POST, 'sites', FILTER_SANITIZE_STRING) ?? NULL;
//$date = filter_input(INPUT_GET, 'date', FILTER_SANITIZE_STRING) ?? NULL;
switch ($action) {
    case 'Add':
        $title = "Add URL";
        include_once('assets/header.php');
        echo siteForm();
        if (isPostRequest()) {
            $date = date_create('now')->format('Y-m-d H:i:s');
            $form = validateSite($db, $site, $date, $sites);
            //$url = addSite($db, $site, $date);
        }
        break;
    default:
        $title = "default";
        include_once ('assets/header.php');
        break;
}
include_once("assets/footer.php");