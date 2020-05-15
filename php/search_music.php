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

function get_music($text) {
    $date = array();
    $search = $text . "%";

    $result = ORM::for_table('market_music')->where_like('genre', $search)->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->username);
        array_push($aux, $data->title);
        array_push($aux, $data->artists);
        array_push($aux, $data->language);

        array_push($aux, $data->currency);
        array_push($aux, $data->price);
        array_push($aux, $data->genre);
        array_push($aux, $data->genre2);
        array_push($aux, $data->date);
        array_push($aux, $data->details);
        array_push($aux, $data->id);
        array_push($aux, $data->exp);
        array_push($aux, takePerm($data->username, $data->rights));
        array_push($date, $aux);
    }

    echo JSON_encode($date);
}

function get_gear($text) {
    $date = array();
    $search = $text . "%";

    $result = ORM::for_table('market_gear')->where_like('genre', $search)->find_many();
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

function get_lyrics($text) {
    $date = array();
    $search = $text . "%";

    $result = ORM::for_table('market_lyrics')->where_like('genre', $search)->find_many();
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
        array_push($date, $aux);
    }

    echo JSON_encode($date);
}



if(isset($_GET['search_music'])){
    $text = $_GET['text'];
    get_music($text);
}

if(isset($_GET['search_lyrics'])){
    $text = $_GET['text'];
    get_lyrics($text);
}

if(isset($_GET['search_gear'])){
    $text = $_GET['text'];
    get_gear($text);
}