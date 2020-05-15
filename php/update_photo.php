<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

if(isset($_SESSION['username']) ) {
    $path = "/opt/lampp/htdocs/PW/profile/" . $_SESSION['username'] . "/" . $_SESSION['username'] . "_profile.jpg";
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
        echo "Update success !";
    } else {
        echo "Something went wrong";
    }
}

?>