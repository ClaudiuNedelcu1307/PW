

<?php
require_once 'idiorm.php';
ORM::configure('sqlite:db.sqlite');

ORM::get_db()->exec('DROP TABLE IF EXISTS loginTable;');
ORM::get_db()->exec('DROP TABLE IF EXISTS market_music;');
ORM::get_db()->exec('DROP TABLE IF EXISTS market_lyrics;');
ORM::get_db()->exec('DROP TABLE IF EXISTS market_gear;');
ORM::get_db()->exec('DROP TABLE IF EXISTS num_logs;');
ORM::get_db()->exec('DROP TABLE IF EXISTS heat;');
ORM::get_db()->exec('DROP TABLE IF EXISTS xyButton;');

ORM::get_db()->exec(
    'CREATE TABLE num_logs (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'timeUnix VARCHAR(50), ' .
    'counter INTEGER' .
    ')'
);

ORM::get_db()->exec(
    'CREATE TABLE xyButton (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'buttonX INTEGER, ' .
    'buttonY INTEGER' .
    ')'
);


ORM::get_db()->exec(
    'CREATE TABLE loginTable (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'username VARCHAR(50), ' .
    'password VARCHAR(50), ' .
    'first_name VARCHAR(50), ' .
    'last_name VARCHAR(50), ' .
    'email VARCHAR(50), ' .
    'city VARCHAR(50), ' .
    'fb_user VARCHAR(50), ' .
    'tel1 VARCHAR(50), ' .
    'tel2 VARCHAR(50), ' .
    'birth VARCHAR(50), ' .
    'perm_create VARCHAR(1), ' .
    'rights VARCHAR(50)' .
    ')'
);

ORM::get_db()->exec(
    'CREATE TABLE market_music (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'username VARCHAR(100), ' .
    'title VARCHAR(100), ' .
    'artists VARCHAR(1000), ' .
    'language VARCHAR(50), ' .
    'price VARCHAR(50), ' .
    'currency VARCHAR(50), ' .
    'genre VARCHAR(50), ' .
    'genre2 VARCHAR(50), ' .
    'date VARCHAR(50), ' .
    'details VARCHAR(50),' .
    'timeUnix INTEGER,' .
    'rights VARCHAR(3),' .
    'exp TEXT(2)' .
    ')'
);

ORM::get_db()->exec(
    'CREATE TABLE market_gear (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'username VARCHAR(100), ' .
    'title VARCHAR(100), ' .
    'artists VARCHAR(1000), ' .
    'language VARCHAR(50), ' .
    'price VARCHAR(50), ' .
    'currency VARCHAR(50), ' .
    'genre VARCHAR(50), ' .
    'date VARCHAR(50), ' .
    'details VARCHAR(50),' .
    'timeUnix INTEGER,' .
    'rights VARCHAR(3),' .
    'exp TEXT(2)' .
    ')'
);

ORM::get_db()->exec(
    'CREATE TABLE market_lyrics (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'username VARCHAR(100), ' .
    'title VARCHAR(100), ' .
    'artists VARCHAR(1000), ' .
    'language VARCHAR(50), ' .
    'price VARCHAR(50), ' .
    'currency VARCHAR(50), ' .
    'genre VARCHAR(50), ' .
    'details VARCHAR(1000),' .
    'timeUnix INTEGER' .
    ')'
);

ORM::get_db()->exec(
    'CREATE TABLE heat (' .
    'id INTEGER PRIMARY KEY AUTOINCREMENT, ' .
    'heat0 INTEGER, ' .
    'heat1 INTEGER, ' .
    'heat2 INTEGER, ' .
    'heat3 INTEGER, ' .
    'heat4 INTEGER, ' .
    'heat5 INTEGER, ' .
    'heat6 INTEGER, ' .
    'heat7 INTEGER ' .
    ')'
);

function create_heat() {
    $heat = ORM::for_table('heat')->create();
    $heat->heat0 = 10;
    $heat->heat1 = 5;
    $heat->heat2 = 25;
    $heat->heat3 = 30;
    $heat->heat4 = 5;
    $heat->heat5 = 75;
    $heat->heat6 = 100;
    $heat->heat7 = 2;
    
    $heat->save();  
}

// RIGHTS: 0 -> - | 1 -> r | 2 -> rw
// ORDER_RIGHTS: owner | users | guests
function create_post($user, $title, $artists, $language, $price, $currency, $genre, $genre2, $date, $details) {
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
    $marketTable->exp = "0";
    $marketTable->timeUnix = time();
    $marketTable->rights = "210"; 

    $marketTable->save();
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

function create_gear($user, $title, $artists, $language, $price, $currency, $genre, $date, $details) {
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
    $marketTable->exp = "0";
    $marketTable->timeUnix = time();
    $marketTable->rights = "210";
    
    $marketTable->save(); 
}

function create_user($username, $password, $rights, $email) {
    $loginTable = ORM::for_table('loginTable')->create();
    $loginTable->username = $username;
    $loginTable->password = $password;
    $loginTable->email = $email;
    $loginTable->rights = $rights;

    $loginTable->first_name = $username;
    $loginTable->last_name = "";
    $loginTable->city = "";
    $loginTable->fb_user = "";
    $loginTable->tel1 = "";
    $loginTable->tel2 = "";
    $loginTable->birth = "";
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

    <link rel="stylesheet" href="../css/background.css">
    <link rel="stylesheet" href="../css/upload.css">
    

</head>
    <body onload="load_data()">
        <div id="meniu" >
            <ul id="navbar-ul">
                <li><a href="../index.php"><i class="fa fa-home"></i> Home</a></li>
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
                                <input class="colorInput" id="born_Profile" type="date" name="born_Profile"><br><br>
                            
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
                                    <textarea class="colorInput" id="detail_block_Profile" name="detail_block_Profile" cols="40" rows="5" aria-invalid="false" placeholder="Your Bio"></textarea>
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

                                <label for="upass_edit"><b>New Password</b></label><br>
                                <input id="upass_edit" class="colorInput" type="password" name="pass1"><br><br>

                                <label for="urepass_edit"><b>Repeat Password</b></label><br>
                                <input id="urepass_edit" class="colorInput" type="password" name="pass2"><br><br>
                        
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
                                    <a href="licensee-terms-and-conditions.html" class="m-20 f-w-bold">Terms for Music Buyers</a>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>
                    <div class="col-md-3 text-left">
                        <table>
                            <tbody><tr>
                                <td>
                                    <a href="about-us.html" class="m-20 f-w-bold">About Us</a>
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


    return $loginTable;
}

function create_entrys($timeUnix, $counter) {
    $loginTable = ORM::for_table('num_logs')->create();
    $loginTable->timeUnix = $timeUnix;
    $loginTable->counter = $counter;

    $loginTable->save();
}


function create_xy($button) {
    $btn = ORM::for_table('xyButton')->create();
    $btn->buttonX = 0;
    $btn->buttonY = 0;

    $btn->save();
}


$curr_time = time();
$day1 = $curr_time - date('H') * 60 * 60 - date('i') * 60 - date('s');
$day2 = $day1 - 24 * 60 * 60;
$day3 = $day2 - 24 * 60 * 60;
$day4 = $day3 - 24 * 60 * 60;
$day5 = $day4 - 24 * 60 * 60;
create_entrys($day1, 100);
create_entrys($day2, 245);
create_entrys($day3, 90);
create_entrys($day4, 408);
create_entrys($day5, 85);


create_user("admin", md5("admin"), "-", "-");

create_user("Hay-Lin", md5("WITCH"), "-", "Air");

create_post("admin", "KBoom", "CRBL", "Romania", "75", "EUR", "Pop", "", "", "Sus in aer!");
usleep(5);
create_post("Hay-Lin", "Hatz", "Dorian", "Romania", "2018", "LEI", "Dance", "", "", "Hatz Hatz Jonule Hatz");
usleep(5);
create_lyrics("admin", "Sub chiuveta", "ECHO", "RO", "666", "LEI", "da", "Viata ne-o dat la cap dar nu ne-o dat si cascheta");
usleep(10);
create_gear("Hay-Lin", "KBOOM", "Dorian", "Romania", "2018", "LEI", "Dance", "", "Hatz Hatz Jonule Hatz");

create_heat();

create_xy('');

echo('ok<br>');
echo('person ' . ORM::for_table('loginTable')->count() . '<br>');

