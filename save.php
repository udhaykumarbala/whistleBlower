<?php

include_once 'config.php';

if(isset($_POST['submit']))
{
	
function randomNumber() {
    $result = '';

    for($i = 0; $i < 16; $i++) {
        $result .= mt_rand(0, 9);
    }

    echo "$result";
}

$title = $_POST['title'];
$department = $_POST['department'];
$description = $_POST['description'];
$notes = $_POST['notes'];
$whistle_id = randomNumber();

$sql = 'INSERT INTO whistle(title,department,description,notes,whistle_id) VALUES (?,?,?,?,?)'
$paramArray = array();
        $paramArray[] = $title;
        $paramArray[] = $department
        $paramArray[] = $description
        $paramArray[] = $notes
        $paramArray[] = $whistle_id
        $paramArray[] = $
        $dbOps = new DBOperations();        
        return $dbOps->cudData($sql, 'sissi', $paramArray);



}
?>