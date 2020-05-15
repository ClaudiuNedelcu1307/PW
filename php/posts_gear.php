<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function takePerm($username, $rights) {
    if(isset($_SESSION['username']) && $_SESSION['username'] == $username) {
        if($rights[0] == "2") {
            return "2";
        } else if($rights[0] == "1") {
            return "1";
        } else {
            return "0";
        }
    } else if(isset($_SESSION['username'])) {
        if($rights[1] == "2") {
            return "2";
        } else if($rights[1] == "1") {
            return "1";
        } else {
            return "0";
        }
    } else {
        if($rights[2] == "2") {
            return "2";
        } else if($rights[2] == "1") {
            return "1";
        } else {
            return "0";
        }
    }
}

function get_all_post_g() {
    $date = array();

    $result = ORM::for_table('market_gear')->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->username);
        array_push($aux, $data->title);
        array_push($aux, $data->artists);
        array_push($aux, $data->language);

        array_push($aux, $data->currency);
        array_push($aux, $data->price);
        array_push($aux, $data->genre);
        array_push($aux, $data->date);
        array_push($aux, $data->details);
        array_push($aux, $data->id);
        array_push($aux, $data->exp);
        array_push($aux, takePerm($data->username, $data->rights));
        array_push($date, $aux);
    }

    echo JSON_encode($date);
}

if(isset($_GET['posts_gear'])){
    if($_GET['posts_gear'] == true) {
        get_all_post_g();
    } else {
        echo "1";
    }
}

function create_gear($user, $title, $artists, $language, $price, $currency, $genre, $date, $details, $exp) {
    $timestamp = time();
    $marketTable = ORM::for_table('market_gear')->create();
    $marketTable->username = $user;
    $marketTable->title = $title;
    $marketTable->artists = $artists;
    $marketTable->language = $language;
    $marketTable->currency = $currency;
    $marketTable->price = $price;
    $marketTable->genre = $genre;
    $marketTable->date = $date;
    $marketTable->details = $details;
    $marketTable->exp = $exp;
    $marketTable->timeUnix = $timestamp;
    $marketTable->rights = "210";
    
    $marketTable->save();  

    $rez = ORM::for_table('market_gear')->where('timeUnix', $timestamp)->find_one();
    $date = array();
    array_push($date, $rez->id);
    array_push($date, $rez->title);
    echo  JSON_encode($date);
}


if(isset($_POST['add_gear'])){
    if($_POST['add_gear'] == true) {
        $username = $_POST['username'];
        $title = $_POST['title'];
        $artists = $_POST['artists'];
        $language = $_POST['language'];
        $currency = $_POST['currency'];
        $price = $_POST['price'];
        $genre = $_POST['genre'];
        $date = $_POST['date'];
        $details = $_POST['details'];  
        $exp = $_POST['exp']; 

        create_gear($username, $title, $artists, $language, $price, $currency, $genre, $date, $details, $exp);
    } else {
        echo "1";
    }
}

function get_id_post($id) {

    $data = ORM::for_table('market_gear')->where('id', $id)->find_one();
    $aux = array();
    array_push($aux, $data->username);
    array_push($aux, $data->title);
    array_push($aux, $data->artists);
    array_push($aux, $data->language);

    array_push($aux, $data->currency);
    array_push($aux, $data->price);
    array_push($aux, $data->genre);
    array_push($aux, $data->date);
    array_push($aux, $data->details);
    array_push($aux, $data->id);
    array_push($aux, $data->exp);
    array_push($aux, takePerm($data->username, $data->rights));

    echo JSON_encode($aux);
}

function update_post_gear($id, $user, $title, $artists, $language, $price, $currency, $genre, $date, $details, $exp) {
    $marketTable = ORM::for_table('market_gear')->where('id', $id)->find_one();
    $marketTable->username = $user;
    $marketTable->set('title', $title);
    $marketTable->set('artists', $artists);
    $marketTable->set('language', $language);
    $marketTable->set('currency', $currency);
    $marketTable->set('price', $price);
    $marketTable->set('genre', $genre);
    $marketTable->set('date', $date);
    $marketTable->set('details', $details);
    $marketTable->set('exp', $exp);
    
    $marketTable->save();  
}


if(isset($_GET['posts_id'])) {
    if($_GET['posts_id'] == true && isset($_GET['id'])) {
        get_id_post($_GET['id']);
    } else {
        echo "1";
    }
}

if(isset($_POST['update_post_gear'])) {
    if($_POST['update_post_gear'] == true) {
        $username = $_POST['username'];
        $id = $_POST['id'];
        $title = $_POST['title'];
        $artists = $_POST['artists'];
        $language = $_POST['language'];
        $currency = $_POST['currency'];
        $price = $_POST['price'];
        $genre = $_POST['genre'];
        $date = $_POST['date'];
        $details = $_POST['details'];     
        $exp = $_POST['exp'];        

        update_post_gear($id, $username, $title, $artists, $language, $price, $currency, $genre, $date, $details, $exp);
        echo "0";
    } else {
        echo "1";
    }
}

?>