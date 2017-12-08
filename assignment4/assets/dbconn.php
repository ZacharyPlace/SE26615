<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/3/2017
 * Time: 12:42 AM
 */
?>

<?php

function dbconn() {
    $dsn = "mysql:host=localhost;dbname=phpclassfall2017";
    $username = "PHPClassFall2017";
    $password = "se266";
    try {
        $db = new PDO($dsn, $username, $password);
        return $db;
    } catch (PDOException $e) {

        die("There was a problem connecting to the database.");
    }
}
function getColumnNames($db, $tbl) {
    $sql = "select column_name from information_schema.columns where lower(table_name)=lower('". $tbl . "')";
    $stmt = $db->prepare($sql);
    try {
        if($stmt->execute()):
            $raw_column_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($raw_column_data as $outer_key => $array):
                foreach($array as $inner_key => $value):
                    if (!(int)$inner_key):
                        $column_names[] = $value;
                    endif;
                endforeach;
            endforeach;
        endif;
    } catch (Exception $e){
        die("There was a problem retrieving the column names");
    }
    return $column_names;
}
?>
