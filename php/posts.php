<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function create_post($user, $title, $artists, $language, $price, $currency, $genre, $genre2, $date, $details, $exp) {
    $timestamp = time();
    $marketTable = ORM::for_table('market_music')->create();
    $marketTable->username = $user;
    $marketTable->title = $title;
    $marketTable->artists = $artists;
    $marketTable->language = $language;
    $marketTable->currency = $currency;
    $marketTable->price = $price;
    $marketTable->genre = $genre;
    $marketTable->genre2 = $genre2;
    $marketTable->date = $date;
    $marketTable->details = $details;
    $marketTable->exp = $exp;
    $marketTable->timeUnix = $timestamp;
    $marketTable->rights = "210";
    
    $marketTable->save();  

    $rez = ORM::for_table('market_music')->where('timeUnix', $timestamp)->find_one();
    $date = array();
    array_push($date, $rez->id);
    array_push($date, $rez->title);
    echo  JSON_encode($date);
}

function update_post($id, $user, $title, $artists, $language, $price, $currency, $genre, $genre2, $date, $details, $exp) {
    $marketTable = ORM::for_table('market_music')->where('id', $id)->find_one();
    $marketTable->username = $user;
    $marketTable->set('title', $title);
    $marketTable->set('artists', $artists);
    $marketTable->set('language', $language);
    $marketTable->set('currency', $currency);
    $marketTable->set('price', $price);
    $marketTable->set('genre', $genre);
    $marketTable->set('genre2', $genre2);
    $marketTable->set('date', $date);
    $marketTable->set('details', $details);
    $marketTable->set('exp', $exp);
    
    $marketTable->save();  
}

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

function get_user_post($user) {
    $date = array();

    $result = ORM::for_table('market_music')->where('username', $user)->find_many();
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
    $result = ORM::for_table('market_gear')->where('username', $user)->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->username);
        array_push($aux, $data->title);
        array_push($aux, $data->artists);
        array_push($aux, $data->language);

        array_push($aux, $data->currency);
        array_push($aux, $data->price);
        array_push($aux, $data->genre);
        array_push($aux, "GEAR-ITEM");
        array_push($aux, $data->date);
        array_push($aux, $data->details);
        array_push($aux, $data->id);
        array_push($aux, $data->exp);
        array_push($aux, takePerm($data->username, $data->rights));
        array_push($date, $aux);
    }

    echo JSON_encode($date);
}

function get_id_post($id) {

    $data = ORM::for_table('market_music')->where('id', $id)->find_one();
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

    echo JSON_encode($aux);
}

function delete_post($id) {
    $data = ORM::for_table('market_music')->where('id', $id)->find_one();
    $data->delete();
}

function get_all_post() {
    $date = array();

    $result = ORM::for_table('market_music')->find_many();
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

function changePerm($id, $owner, $users, $guest) {
    $rights = (string)$owner . (string)$users . (string)$guest;
    $data = ORM::for_table('market_music')->where('id', $id)->find_one();
    if($data !== false) {
        $data->set('rights', $rights);
        $data->save();
        echo "1";
    } else {
        echo "0";
    }
}

function changePermGear($id, $owner, $users, $guest) {
    $rights = (string)$owner . (string)$users . (string)$guest;
    $data = ORM::for_table('market_gear')->where('id', $id)->find_one();
    if($data !== false) {
        $data->set('rights', $rights);
        $data->save(); 
        echo "1";   
    } else {
        echo "0";
    }

}

function create_xy($button) {
    
    $btn = ORM::for_table('xyButton')->where('id', 1)->find_one();
    if($button === 'x') {
        $btn->buttonX += 1;
    } else if($button === 'y'){
        $btn->buttonY += 1;
    }
    $btn->save();
}

if(isset($_POST['add_post'])){
    if($_POST['add_post'] == true) {
        $username = $_POST['username'];
        $title = $_POST['title'];
        $artists = $_POST['artists'];
        $language = $_POST['language'];
        $currency = $_POST['currency'];
        $price = $_POST['price'];
        $genre = $_POST['genre'];
        $genre2 = $_POST['genre2'];
        $date = $_POST['date'];
        $details = $_POST['details'];  
        $exp = $_POST['exp'];        

        create_post($username, $title, $artists, $language, $price, $currency, $genre, $genre2, $date, $details, $exp);
    } else {
        echo "1";
    }
}

if(isset($_GET['posts'])){
    if($_GET['posts'] == true) {
        get_all_post();
    } else {
        echo "1";
    }
}

if(isset($_POST['update_post'])) {
    if($_POST['update_post'] == true) {
        $username = $_POST['username'];
        $id = $_POST['id'];
        $title = $_POST['title'];
        $artists = $_POST['artists'];
        $language = $_POST['language'];
        $currency = $_POST['currency'];
        $price = $_POST['price'];
        $genre = $_POST['genre'];
        $genre2 = $_POST['genre2'];
        $date = $_POST['date'];
        $details = $_POST['details'];     
        $exp = $_POST['exp'];        

        update_post($id, $username, $title, $artists, $language, $price, $currency, $genre, $genre2, $date, $details, $exp);
        echo "0";
    } else {
        echo "1";
    }
}

if(isset($_GET['posts_user'])) {
    if($_GET['posts_user'] == true && isset($_GET['user'])) {
        get_user_post($_GET['user']);
    } else {
        echo "1";
    }
}

if(isset($_POST['delete_item'])) {
    $id = $_POST['delete_item'];
    delete_post($id);
    echo "0";
}

if(isset($_GET['posts_id'])) {
    if($_GET['posts_id'] == true && isset($_GET['id'])) {
        get_id_post($_GET['id']);
    } else {
        echo "1";
    }
}

if(isset($_POST['changePerm'])) {
    if($_POST['changePerm'] == true && isset($_POST['id'])) {
        changePerm($_POST['id'], $_POST['one'], $_POST['two'], $_POST['three']);
    } else {
        echo "-1";
    }
}

if(isset($_POST['changePermGear'])) {
    if($_POST['changePermGear'] == true && isset($_POST['id'])) {
        changePermGear($_POST['id'], $_POST['one'], $_POST['two'], $_POST['three']);
    } else {
        echo "-1";
    }
}

if(isset($_POST['xy'])) {
    create_xy($_POST['xy']);
    $btn = ORM::for_table('xyButton')->where('id', 1)->find_one();
    echo $btn->buttonX . " " . $btn->buttonY;
}