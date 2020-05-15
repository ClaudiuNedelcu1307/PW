<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

if(isset($_SESSION['username']) && isset($_POST['id'])) {
    
    $path = "/opt/lampp/htdocs/PW/profile/" . $_SESSION['username'] . "/" . $_POST['id'] . "_1.jpg";
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
        // echo "Update success !";
        echo $path;
    } else {
        echo "Something went wrong " . $_SESSION['username'];
    }
}
if(isset($_SESSION['username']) && isset($_POST['idG'])) {
    
    $path = "/opt/lampp/htdocs/PW/profile/" . $_SESSION['username'] . "/" . $_POST['idG'] . "G_1.jpg";
    if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
        // echo "Update success !";
        echo $path;
    } else {
        echo "Something went wrong " . $_SESSION['username'];
    }
}

?>