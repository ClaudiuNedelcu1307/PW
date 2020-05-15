<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

if(isset($_POST['heat'])) {
    $result = ORM::for_table('heat')->where('id', 1)->find_one();
    $x = 'heat' . $_POST['heat'];
    $result->$x += 1;

    $result->save();
    $result = ORM::for_table('heat')->where('id', 1)->find_one();
    echo $result->heat0 . " " . $result->heat1 . " " . $result->heat2 . " " . $result->heat3 . " " . $result->heat4 . " " . $result->heat5 . " " . $result->heat6 . " " . $result->heat7;
}
if(isset($_GET['heatGet'])) {
    $result = ORM::for_table('heat')->where('id', 1)->find_one();
    $aux = array();
    for($i = 0; $i < 8; $i++) {
        $x = 'heat' . $i;
        array_push($aux, $result->$x);
    }

    echo JSON_encode($aux); 
}
?>