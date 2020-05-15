<?php
session_start();
if(isset($_GET['main'])) {
    $my_file = 'pages/main.html';
    $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
    $data = fread($handle, filesize($my_file));

    fclose($handle);
    echo JSON_encode($data);
} else if(isset($_GET['contact'])) {
    $my_file = 'pages/contact.html';
    $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
    $data = fread($handle, filesize($my_file));

    fclose($handle);
    echo JSON_encode($data);
} else if(isset($_GET['market'])) {
    $my_file = 'pages/market.html';
    $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
    $data = fread($handle, filesize($my_file));

    fclose($handle);
    echo JSON_encode($data);
} else if(isset($_GET['get_item_details'])) {
    $my_file = 'pages/music_item.html';
    $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
    $data = fread($handle, filesize($my_file));

    fclose($handle);
    echo JSON_encode($data);
} else if(isset($_GET['get_gear_details'])) {
    $my_file = 'pages/gear_item.html';
    $handle = fopen($my_file, 'r') or die('Cannot open file:  '.$my_file);
    $data = fread($handle, filesize($my_file));

    fclose($handle);
    echo JSON_encode($data);
}


?>