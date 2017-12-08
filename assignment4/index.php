<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/5/2017
 * Time: 7:36 PM
 */
?>

<?php

require_once ("assets/dbconn.php");
require_once("assets/function.php");
$title = "";
$db = dbconn();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING) ??
    filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING) ?? NULL;
$col = filter_input(INPUT_GET, 'col', FILTER_SANITIZE_STRING) ?? NULL;
$dir = filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_STRING) ?? NULL;
switch ($action) {
    case 'sort':
        $title = "Sort";
        include_once ('assets/header.php');
        $sortable = true;
        $corps = getCorpsAsSortedTable($db, $col, $dir);
        $cols = getColumnNames($db, 'corps');
        echo getCorpsAsSortedTable($db, $col, $dir);
        break;
    case 'Read':
        include_once ('assets/header.php');

        break;
    case 'New':
        $title = "Add Corp";
        include_once ('assets/header.php');
        $corps = getCorps($db);
        echo corpsForm($corps);
        break;

    case 'Save':
        include_once ('assets/header.php');

        break;
    case 'Edit':
        include_once ('assets/header.php');

        break;
    case 'Update':
        include_once ('assets/header.php');

        break;
    case 'Delete':
        include_once ('assets/header.php');
        // deleteEmployee()
        break;
    default:
        $title = "default";
        include_once ('assets/header.php');
        $sortable = true;
        $corps = getCorps($db);
        $cols = getColumnNames($db, 'corps');
        echo getCorpsAsTable($db, $corps, $cols, $sortable);
        break;
}
include_once ("assets/footer.php");
?>