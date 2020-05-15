<?php
session_start();
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

function create_user($username, $password, $rights, $email) {
    $loginTable = ORM::for_table('loginTable')->create();
    $loginTable->username = $username;
    $loginTable->password = $password;
    $loginTable->rights = $rights;

    $loginTable->first_name = "";
    $loginTable->last_name = "";
    $loginTable->city = "";
    $loginTable->fb_user = "";
    $loginTable->tel1 = "";
    $loginTable->tel2 = "";
    $loginTable->birth = "";
    $loginTable->email = $email;
    $loginTable->perm_create = "1";

    $loginTable->save();

    $fileName = "../profile/" . $username . ".html";
    $myfile = fopen($fileName, "w") or die("Unable to open file!");
    $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Profile Page </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../css/menuu.css">
    <link rel="stylesheet" href="../css/music-style.css">
    <link rel="stylesheet" href="../css/modal-style.css">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/slide-nav.css">
    <script src="../js/menu.js"></script>
    <script src="../js/heatHarta.js"></script>
    <script src="../js/xy.js"></script>
    <script src="../js/profile.js"></script>
    <script src="../js/details_item.js"></script>
    <link rel="stylesheet" href="../css/style-home.css">
    <link rel="stylesheet" href="../css/market-modal.css">
    <link rel="stylesheet" href="../css/item_detail.css">


</head>
    <body onload="load_data()">
        <div id="meniu" >
            <ul id="navbar-ul">
                <li><a href="../index.php" href="#"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="../adminPage.html">Administration</a></li>
                <li><a href="../contact.html"><i class="fa fa-envelope"></i> Contact</a></li>
                
                <li class="dropdown">
                    <a href="../market.html" class="dropbtn">Market</a>
                    <div class="dropdown-content">
                        <a href="../music.html" name="xNameCheck" class="xyCheck">Music</a>
                        <a href="../instruments.html">Instruments</a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="item-navbar-min" style="background-image:url(../images/profile.jpg); background-attachment: fixed;">
            <div class="container"> 
                <div class="row"> 
                    <div class="col-md-7 col-sm-7">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <h1 class="text-center">Welcome, <br>' . $username . '</h1>
                    </div>
                    <div class="col-md-3">
                        <img id="profilePicture" class="img-profile" src="'. $username .'/'. $username .'_profile.jpg" onclick="document.getElementById(\'id01\').style.display=\'block\'" alt="profile" style="width:150px">

                    </div>
    
                </div>
            </div>
        </div>

        <div id="id01" class="modalLogin">
            <div class="modalLogin-content animate">
              <div class="imgcontainer">
                <span onclick="document.getElementById(\'id01\').style.display=\'none\'" class="close" title="Close Modal">&times;</span>
                <img src="' . $username . '/' . $username .'_profile.jpg" alt="Avatar" class="avatarLogin">
              </div>
              <div class="containerLogin">
                <label for="file"><b>Change profile picture:</b></label>
                <input id="file" type="file" name="file"><br><br>

                <button id="confirmChange" onclick="changePicture()">Apply Change</button>
              </div>
          
              
          </div>
          </div>

          <script>
            // Get the modal
            var modal = document.getElementById(\'id01\');
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        <section style="background-color: #fafafa;">
                <div class="container benefits-container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h3 id="div_edit">Edit your profile page</h3>
                        </div>    
                    </div>
                </div>
            </section>


            <section class="section-gray" style="background-image:url(../images/back_profile.jpg); background-attachment: fixed;">
            <div class="row">
                <div class="container spacing">
                    <div class="col-md-6">
                        <div class="vertical-menu">
                            <a id="a_basic" onclick="click_basic()" class="activeTab">Basic Info</a>
                            <a id="a_details" onclick="click_details()">Details</a>
                            <a id="a_pass" onclick="click_pass()">Password</a>

                        </div>
                    </div>
                    <div id="Basic_Info" class="colorForm">
                        <h3>Basic Info</h3>
                        <div class="col-md-3">
                            <div class="containerLogin">
                                <label class="requiredStar" for="first_Profile"><b>First Name</b></label><br>
                                <input class="colorInput" id="first_Profile" type="text" placeholder="Enter First Name" name="first_Profile"><br><br>
                            
                                <label class="requiredStar" for="last_Profile"><b>Last Name</b></label><br>
                                <input class="colorInput" id="last_Profile" type="text" placeholder="Enter Last Name" name="last_Profile"><br><br>

                                <label class="requiredStar" for="mail_Profile"><b>Email</b></label><br>
                                <input class="colorInput" id="mail_Profile" type="email" placeholder="Enter Email" name="mail_Profile"><br><br>
                        
                            </div>
            
                        </div>
                        <div class="col-md-3">
                            <div class="containerLogin">
                                <label for="born_Profile"><b>Birthday</b></label><br>
                                <input class="colorInput" id="born_Profile" type="date" placeholder="Enter Birthday" name="born_Profile"><br><br>
                            
                                <label class="city" for="city_Profile"><b>City</b></label><br>
                                <input class="colorInput" id="city_Profile" type="text" placeholder="Enter Last Name" name="city_Profile"><br><br>

                                <label  for="fb_Profile"><b>Facebook Username</b></label><br>
                                <input class="colorInput" id="fb_Profile" type="text" placeholder="Facebook User Name" name="fb_Profile"><br><br>
                                    
                                
                            </div>
                        </div>
                    </div>
                    <div id="Details" class="colorForm">
                        <h3>Details</h3>
                        <div class="col-md-6">
                            <div class="containerLogin">
                                <div class="form-group">
                                    <label for="detail_block_Profile"><b>Write something about yourself</b></label><br>
                                    <textarea class="colorInput" id="detail_block_Profile" name="detail_block_Profile" cols="40" rows="5" class="form-control" id="contact-message" aria-invalid="false" placeholder="Your Bio"></textarea>
                                </div>

                                <label for="tel1_Profile"><b>Telephone 1</b></label><br>
                                <input class="colorInput" id="tel1_Profile" type="text" placeholder="Enter Phone Number" name="tel1_Profile"><br><br>

                                <label for="tel2_Profile"><b>Telephone 2</b></label><br>
                                <input class="colorInput" id="tel2_Profile" type="text" placeholder="Enter Phone Number" name="tel2_Profile"><br><br>
                        
                            </div>
            
                        </div>
                    </div>

                    <div id="Pass_Change" class="colorForm">
                        <h3>Change Password</h3>
                        <div class="col-md-6">
                            <div class="containerLogin">

                                <label for="pass1"><b>New Password</b></label><br>
                                <input id="upass_edit" class="colorInput" id="pass1" type="password" name="pass1"><br><br>

                                <label for="pass2"><b>Repeat Password</b></label><br>
                                <input id="urepass_edit" class="colorInput" id="pass2" type="password" name="pass2"><br><br>
                        
                            </div>
            
                        </div>
                    </div>

                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4 text-align-center"><button id="applyChanges" onclick="send_data()">Apply Changes</button></div>
                <div class="col-md-4"></div>
            </div>
        </section>

        <section>
            <div id="search_rez" class="container benefits-container">
                Nothing to show
            </div>
        </section>


        <footer>
            <div class="foot-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 text-left">
                            <table style="margin-left: 10px;">
                                <tbody><tr>
                                    <td>
                                        <a href="../banner.html" class="m-20 f-w-bold">Banner Exchange</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="../licensee-terms-and-conditions.html" class="m-20 f-w-bold">Terms for Music Buyers</a>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                        <div class="col-md-3 text-left">
                            <table>
                                <tbody><tr>
                                    <td>
                                        <a href="../about-us.html" class="m-20 f-w-bold">About Us</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 11px 0;">
                                        <a href="https://www.facebook.com/Muzicity.co.uk" target="_blank" class="m-20" style="text-decoration: none;">
                                            <img title="Facebook Page" src="../img/Facebook_button.jpg" alt="Facebook_button" class="img-responsive img-center">
                                        </a>
        
                                        <a href="https://twitter.com/Muzicity1" target="_blank" class="m-20" style="text-decoration: none;">
                                            <img title="Twitter Page" src="../img/twitter_button.jpg" alt="twitter_button" class="img-responsive img-center">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="../contact.html" class="m-20 f-w-bold">Contact Us</a>
                                    </td>
                                </tr>
                            </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
    </body>
    
</html>';
    fwrite($myfile, $html);
    mkdir(("../profile/" . $username), 0777);

    return $loginTable;
}

function get_perm() {
    if(!(isset($_SESSION['username']))) {
        $aux = array();
        array_push($aux, -1);
        array_push($aux, "");
        array_push($aux, "4");
        echo JSON_encode($aux); 
        return;
    }
    $user = $_SESSION['username'];
    $page = $_GET['get_profile_user'];
    $ok = 1;
    $result = ORM::for_table('loginTable')-> where('username', $user)->find_one();
    if($result !== false) {
        $aux = array();
        array_push($aux, $result->id);
        array_push($aux, $result->username);

        foreach($_SESSION['edit_profile'] as $iter){            
            if(strcmp($iter, $page) == 0) {
                array_push($aux, "7");
                $ok = 0; 
                break;
            }
        }
        if($ok == 1) {
            array_push($aux, "4");
        }
      
        echo JSON_encode($aux); 
    } else {
        echo $user . " NUUU";
    }
}

if(isset($_GET['top5'])){
    $date = array();
    $result = ORM::for_table('market_music')
    ->select_expr('market_music.username')
    ->select_expr('loginTable.id')
    ->select_expr('COUNT(*)', 'nr')
    ->group_by('market_music.username')
    ->join('loginTable', array(
        'market_music.username', '=', 'loginTable.username'
    ))
    ->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->username);
        array_push($aux, $data->id);
        array_push($aux, $data->nr);
        array_push($date, $aux);
    }
    echo JSON_encode($date); 
}

if(isset($_GET['graphic'])){
    $date = array();
    $result = ORM::for_table('num_logs')->order_by_desc('timeUnix')->limit(5)->find_many();
    foreach($result as $data) {
        $aux = array();
        array_push($aux, $data->counter);
        array_push($aux, $data->timeUnix);
        array_push($date, $aux);
    }
    echo JSON_encode($date); 
}

if(isset($_POST['login_post'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    $result = ORM::for_table('loginTable')-> where('username', $user)->find_one();
    if($result !== false){
        if($result->password === md5($pass)){

            $_SESSION['login'] = true;
            $_SESSION['username'] = $user;
            $_SESSION['password'] = md5($pass);
            $_SESSION['edit_profile'] = array();

            array_push($_SESSION['edit_profile'], $user);

            setcookie("login_s", $user, time() + (86400 * 30),"/");
            $timeUnix_curr = time();
            $hatz = $timeUnix_curr - date('H') * 60 * 60 - date('i') * 60 - date('s');
            $data = ORM::for_table('num_logs')-> where('timeUnix', $hatz)->find_one();

            if($data != false) {
                $data->set('counter', $data->counter + 1);
                $data->save();
                echo "0"; 
            } else {
                $newEntry = ORM::for_table('num_logs')->create();
                $newEntry->timeUnix = $hatz;
                $newEntry->counter = 1;

                $newEntry->save();  
                echo "0";
            }

            
        }else{
            echo "User-or-password-wrong";
        }
    }else{
        echo "User-or-password-wrong";
    }
}

if(isset($_POST['register_post'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email'];

    $result = ORM::for_table('loginTable')-> where('username', $user)->find_one();
    if($result === false) {
        create_user($user, md5($pass), "-", $email);
        echo "0";
    } else {
        echo "1";
    }
}

if(isset($_GET['get_profile'])){
    $user = $_GET['get_profile'];

    $result = ORM::for_table('loginTable')-> where('username', $user)->find_one();
    if($result !== false) {
        $aux = array();
        array_push($aux, $result->id);
        array_push($aux, $result->first_name);
        array_push($aux, $result->last_name);
        array_push($aux, $result->email);
        array_push($aux, $result->city);
        array_push($aux, $result->fb_user);
        array_push($aux, $result->tel1);
        array_push($aux, $result->tel2);
        array_push($aux, $result->birth);
        array_push($aux, $result->username);
        echo JSON_encode($aux); 
    } else {
        echo "76";
    }
}

if(isset($_GET['get_profile_user'])){
    get_perm();
}

if(isset($_POST['update_profile'])){
    $user = $_POST['update_profile'];

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $fb_user = $_POST['fb_user'];
    $tel1 = $_POST['tel1'];
    $tel2 = $_POST['tel2'];
    $city = $_POST['city'];
    $birth = $_POST['birth'];
    $pass = $_POST['pass'];

    $result = ORM::for_table('loginTable')->where('username', $user)->find_one();
    $result->set('first_name', $first_name);
    $result->set('last_name', $last_name);
    $result->set('email', $email);
    $result->set('fb_user', $fb_user);
    $result->set('tel1', $tel1);
    $result->set('tel2', $tel2);
    $result->set('city', $city);
    $result->set('birth', $birth);
    if($pass != "" && $pass != null) {
        $result->set('password', md5($pass));
    }
    $result->save();
}

if(isset($_GET['perm_create'])){
    if(isset($_SESSION['username'])) {
        $result = ORM::for_table('loginTable')-> where('username', $_SESSION['username'])->find_one();
        if($result !== false && $result->perm_create == "1") {
            echo "1";
        } else {
            echo "0";
        }
    } else {
        echo "0";
    }
}

function checkFain($result) {
    if($result !== false) {
        $rights = $result->rights;
        if(isset($_SESSION['username']) && $_SESSION['username'] == $result->username) {
            if($rights[0] == "2") {
                echo "2";
            } else if($rights[0] == "1") {
                echo "1";
            } else {
                echo "0";
            }
        } else if(isset($_SESSION['username'])) {
            if($rights[1] == "2") {
                echo "2";
            } else if($rights[1] == "1") {
                echo "1";
            } else {
                echo "0";
            }
        } else {
            if($rights[2] == "2") {
                echo "2";
            } else if($rights[2] == "1") {
                echo "1";
            } else {
                echo "0";
            } 
        }
    }
}

if(isset($_GET['perm_edit'])){
    $result = ORM::for_table('market_music')-> where('id',  $_GET['id'])->find_one();
    checkFain($result);
}

if(isset($_GET['perm_edit_gear'])){
    $result = ORM::for_table('market_gear')-> where('id',  $_GET['id'])->find_one();
    checkFain($result);
}

if(isset($_GET['adminOn'])){
    if(isset($_SESSION['username']) && $_SESSION['username'] === 'admin') {
        echo "1";
    } else {
        echo "0";
    }
}

if(isset($_GET['xy'])){
    $btn = ORM::for_table('xyButton')->where('id', 1)->find_one();
    $aux = array();
    array_push($aux, $btn->buttonX);
    array_push($aux, $btn->buttonY);
    echo JSON_encode($aux); 
}

?>
