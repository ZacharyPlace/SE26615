<?php

$dsn = "mysql:host=localhost;dbname=dogs";
$username = "dogs";
$password = "se266";
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e)  {
die("There was a problem connecting to the database.");
}


/*
if (isset($_POST['submit'])  ){

    $submit = $_POST['submit'];         //can do this if statement
} else {
    $submit="";
}
*/


//$submit = isset($_POST['submit']) ? $_POST['submit'] : ""; //ternary  or this alternate if statement


$submit = $_POST['submit'] ?? ""; //php7
if($submit == "do it") {
        $name = $_POST['name'] ?? "";
        $gender = $_POST ['gender'] ?? "F";
        $fixed = $_POST ['fixed'] ?? false ;
        try {
            $sql = $db->prepare("INSERT INTO animals VALUES (null, :name, :gender, :fixed)");
            $sql->bindParam(':name', $name);
            $sql->bindParam(':gender', $gender);
            $sql->bindParam(':fixed', $fixed);
            $sql->execute();
            echo $sql->rowCount() . " rows inserted.";
        }catch(PDOException $e) {
            $se->getMessage();
        }
}


?>

<form method="post" action="#">
    name: <input type="text" name="name" /><br />
    gender: M <input type="radio" name ="gender" value="M" />
    F <input type="radio" name ="gender" value="M" />
    fixed: <input type="checkbox" name="fixed" value="T" />
    <input type="submit" name="submit" value="doit"/>
</form>

