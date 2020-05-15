<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function get_all_post() {
    $date = array();

    $result = ORM::for_table('market_lyrics')->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->username);
        array_push($aux, $data->title);
        array_push($aux, $data->artists);
        array_push($aux, $data->language);

        array_push($aux, $data->currency);
        array_push($aux, $data->price);
        array_push($aux, $data->genre);
        array_push($aux, $data->details);
        array_push($aux, $data->id);
        array_push($date, $aux);
    }

    echo JSON_encode($date);
}

if(isset($_GET['posts_lyrics'])){
    if($_GET['posts_lyrics'] == true) {
        get_all_post();
    } else {
        echo "1";
    }
}

function create_lyrics($user, $title, $artists, $language, $price, $currency, $genre, $details) {
    $marketTable = ORM::for_table('market_lyrics')->create();
    $marketTable->username = $user;
    $marketTable->title = $title;
    $marketTable->artists = $artists;
    $marketTable->language = $language;
    $marketTable->currency = $currency;
    $marketTable->price = $price;
    $marketTable->genre = $genre;
    $marketTable->timeUnix = time();
    
    $marketTable->save();  
}

if(isset($_POST['add_lyrics'])){
    if($_POST['add_lyrics'] == true) {
        $username = $_POST['username'];
        $title = $_POST['title'];
        $artists = $_POST['artists'];
        $language = $_POST['language'];
        $currency = $_POST['currency'];
        $price = $_POST['price'];
        $genre = $_POST['genre'];
        $date = $_POST['date'];
        $details = $_POST['details'];

        create_lyrics($username, $title, $artists, $language, $price, $currency, $genre, $date, $details);
    } else {
        echo "1";
    }
}

?>