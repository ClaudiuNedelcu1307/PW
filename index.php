<?php
    session_start();
    // echo isset($_SESSION['login']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Music Garage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="css/menuu.css">
    <link rel="stylesheet" href="css/slide-nav.css">
    <script src="js/menu.js"></script>
    <script src="js/slide-nav.js"></script>
    <script src="js/login.js"></script>
    <script src="js/register.js"></script>
    <script src="js/counter.js"></script>
    <script src="js/heatHarta.js"></script>
    <script src="js/xy.js"></script>
    <link rel="stylesheet" href="css/style-home.css">
    <link rel="stylesheet" href="css/modal-style.css">
    <link rel="stylesheet" href="css/background.css">

    <link rel="icon" href="img/icon.png">

</head>
<body onload="login_check(); makeTop5();">
    <div id="meniu" >
        <ul id="navbar-ul">
            <li><a class="active" href="#"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="adminPage.html">Administration</a></li>
            <li><a href="contact.html"><i class="fa fa-envelope"></i> Contact</a></li>
            <li id="register_li" style="float:right; display:none;"><a onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Register</a></li>
            <li id="login_li" style="float:right; display:none;"><a onclick="document.getElementById('id01').style.display='block'" style="width:auto;"><i class="fa fa-user"></i> Log-in</a></li>
            
            <li id="logout_li" style="float:right; display:none;"><a onclick="logout()" style="width:auto;">Logout</a></li>
            <li id="user_li" class="width-auto" style="float:right; display:none;"><a id="username_li" onclick="goProfile()" style="width:auto;"> </a></li>

            <li class="dropdown">
                <a href="market.html" class="dropbtn">Market</a>
                <div class="dropdown-content">
                    <a href="#" onclick="xyCheck('x', 'music.html');">Music</a>
                    <a href="instruments.html">Instruments</a>
                </div>
            </li>
        </ul>
    </div>
    <div class="item-navbar" style="background-image:url(images/first.jpg); background-attachment: fixed;">
        <div class="container"> 
            <div class="row"> 
                <div class="col-md-6 col-sm-6">
                </div>
                <div class="col-md-5 col-sm-5">
                    <h1 class="text-center">Welcome to the<br> Music Garage</h1>
                </div>

            </div>
        </div>
    </div>
    <!-- Unleash The Creativity -->
<!-- ////////////////////////////////////////////// -->

    <div id="id01" class="modalLogin">
      <div class="modalLogin-content animate">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
          <img src="img/avatar.png" alt="Avatar" class="avatarLogin">
        </div>
    
        <div class="containerLogin">
          <label class="requiredStar" for="uname"><b>Username</b></label>
          <input id="uname" type="text" placeholder="Enter Username" name="uname" required><br>
    
          <label class="requiredStar" for="upass"><b>Password</b></label>
          <input id="upass" type="password" placeholder="Enter Password" name="psw" required><br>
            
          <button id="confirmLogin" onclick="submit_login()">Login</button>
          <label>
            <input type="checkbox" checked="checked" name="remember"> Remember me
          </label>
        </div>
        <div id="StatusLogin"></div>
        <div class="containerLogin" style="background-color:#f1f1f1">
          <button id="cancelLogin" type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
          <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
    </div>
    </div>
    
<!-- ////////////////////////////////////////////// -->
<!-- REGISTER ////////////////////////////////////////////// -->

    <div id="id02" class="modalRegister">
            <div class="modalReg-content animate">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="img/avatar2.jpg" alt="Avatar" class="avatarLogin">
                </div>
                <form class="containerReg" action="#" onsubmit="submit_register(); return false;">
                  <h1>Register</h1>
                  <p>Please fill in this form to create an account.</p>
                  <hr>
                  <label for="email_reg"><b>Email</b></label>
                  <input id="email_reg" type="email" placeholder="Enter Email" name="email" required>

                  <label for="uname_reg"><b>Username</b></label>
                  <input id="uname_reg" type="text" placeholder="Enter a username" name="username_reg" maxlength="50" required>
            
                  <label for="upass_reg"><b>Password</b></label>
                  <input id="upass_reg" type="password" placeholder="Enter Password" name="psw" required>
            
                  <label for="urepass_reg"><b>Repeat Password</b></label>
                  <input id="urepass_reg" type="password" placeholder="Repeat Password" name="psw-repeat" required>

            
                  <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
            
                  <div class="clearfix">
                    <button id="cancelReg" type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
                    <button id="confirmReg" type="submit" class="signupbtn float-right">Sign Up</button>
                  </div>
                </form>
            </div>
    </div>
      
      <script>
          // Get the modal
          var modal = document.getElementById('id01');
          var modalR = document.getElementById('id02');
          // When the user clicks anywhere outside of the modal, close it
          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
              if (event.target == modalR) {
                  modalR.style.display = "none";
              }
          }
      </script>
  
  
  <!-- ////////////////////////////////////////////// -->


    <section class="section-gray">
        <div class="container spacing">
            <div class="col-sm-6">

                <p>Discover, Stream, Discuss and Buy Music from Music Creators from across music spectrum.<br><br>

                Music Creators - Embed your Music Player on websites and sell your music to Music Fans and the Creative Industries.<br>
                (Dance, Film, Music and Video Games).<br><br>

                Muzicity - The Online Music Community<br><br>

            </p></div>
            <div class="col-sm-6">
                <img src="images/1.jpg" alt="alti" class="img-responsive">
            </div>
        </div>
    </section>
<!-- SLIDER -->
    <div class="row space-elem"></div>
    <div class="row"><div class="col-md-6">
    <div id="slide-nav">
        <div class="mySlides">
            <img class="middle-alg" src="images/gnr.jpg" width="350" height="350" alt="gnr">
        </div>
        
        <div class="mySlides">
            <img class="middle-alg" src="images/bon_jovi.png" width="350" height="350" alt="bj">
        </div>
        
        <div class="mySlides">
            <img class="middle-alg" src="images/whitesnake.jpg" width="350" height="350" alt="whitesnake">
        </div>

        <div class="mySlides">
            <img class="middle-alg" src="images/metallica.png" width="350" height="350" alt="metallica">
        </div>

        <div class="mySlides">
            <img class="middle-alg" src="images/voltaj.jpg" width="350" height="350" alt="voltaj">
        </div>

        <div class="mySlides">
            <img class="middle-alg" src="images/scorpions.jpg" width="350" height="350" alt="scorpions">
        </div>

        <div class="mySlides">
            <img class="middle-alg" src="images/kiss.jpg" width="350" height="350" alt="kiss">
        </div>

        <div class="mySlides">
            <img class="middle-alg" src="images/def_leppard.jpg" width="350" height="350" alt="def">
        </div>
        
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        
    </div>
    <br>
    <div id="slide-nav-dot">
    <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span> 
        <span class="dot" onclick="currentSlide(2)"></span> 
        <span class="dot" onclick="currentSlide(3)"></span> 
        <span class="dot" onclick="currentSlide(4)"></span> 
        <span class="dot" onclick="currentSlide(5)"></span> 
        <span class="dot" onclick="currentSlide(6)"></span> 
        <span class="dot" onclick="currentSlide(7)"></span> 
        <span class="dot" onclick="currentSlide(8)"></span> 
    </div>
    </div></div>

    <div class="col-md-6">
            <div id="slide-nav-instr">
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/gnr.jpg" width="350" height="350" alt="gnr">
                </div>
                
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/bon_jovi.png" width="350" height="350" alt="bj">
                </div>
                
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/whitesnake.jpg" width="350" height="350" alt="whitesnake">
                </div>
        
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/metallica.png" width="350" height="350" alt="makeTop5">
                </div>
        
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/voltaj.jpg" width="350" height="350" alt="voltaj">
                </div>
        
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/scorpions.jpg" width="350" height="350" alt="scorpions">
                </div>
        
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/kiss.jpg" width="350" height="350" alt="kiss">
                </div>
        
                <div class="mySlidesInstr">
                    <img class="middle-alg" src="images/def_leppard.jpg" width="350" height="350" alt="def">
                </div>
                
                <a class="prevInstr" onclick="plusSlidesInstr(-1)">&#10094;</a>
                <a class="nextInstr" onclick="plusSlidesInstr(1)">&#10095;</a>
                
            </div>
            <br>
            <div id="slide-nav-instr-dot">
            <div style="text-align:center">
                <span class="dotInstr" onclick="currentSlideInstr(1)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(2)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(3)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(4)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(5)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(6)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(7)"></span> 
                <span class="dotInstr" onclick="currentSlideInstr(8)"></span> 
            </div>
            </div></div>
    </div>
    <script>
        showSlides(1);
        showSlidesInstr(1);
    </script>
<!-- //////////////////////////////////////////////////////////////////////////////// -->
<!-- Beneficii -->    
    <section style="background-color: #fafafa;">
        <div class="container benefits-container">
            <div class="row">
                <div class="col-md-6 col-sm-6"> 
                    <div class="features_table red-table">
                        <h3 class="red-table-backgorund">Music Gear</h3>
                        <p></p>
                        <ul>
                            <li>Known and Upcoming <b>Producers and Vocalists</b></li>
                            <li><b>100,000+</b> items registered in Music Garage</li>
                            <li><b>Fast publish of your </b> Instrument</li>
                        </ul>
                        <p></p>
                        <a href="instruments.html#buyGear" class="btn btn-primary spacing red-table-backgorund">Search the Music Gear Catalogue</a>
                        <a href="instruments.html#sellGear" class="btn btn-primary spacing red-table-backgorund">Sell your Music Gear Now</a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="features_table">
                        <h3>For Music Creators</h3>
                        <p></p>
                        <ul>
                            <li><b>Profile Page</b> With <b>Domain Name</b></li>
                            <li><b>Set</b> Your Sale <b> Prices</b></li>
                            <li>Choose <b>Music Player</b> In Four Designs</li>
                            <li><b>Embed</b> Music Player<b> on Websites</b></li>
                            <li><b>Share</b> Your Music on <b>Social Media</b></li>
                            <li><b>Get Paid Instantly</b> </li>
                        </ul>
                        <p></p>
                        <a href="music.html#sellMusic" class="btn btn-primary spacing">Upload Your Music</a>
                        <a href="music.html#buyMusic" class="btn btn-primary spacing">Search Our Music Catalogue</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="features">
        <div class="container">
            <br>
            <h3 class="module-title font-alt">Key Benefits for Music</h3>
            
            <div class="row multi-columns-row">
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="features-item">
                        <div class="features-icon">
                            <i class="fa fa-play-circle"></i>
                        </div>
                        <h3 class="features-title font-alt"> Songs </h3> 
                        Buy and Sell Original Songs of every style from Orchestral film scores to top chart hits
                    </div>
            
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="features-item">
                        <div class="features-icon">
                            <i class="fa fa-pencil-square-o"></i>
                        </div>
                        <h3 class="features-title font-alt">Lyrics</h3>
                         Buy and Sell Lyrics of every style from a catchy pop chant to a powerful poetic verse
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="features-item">
                        <div class="features-icon">
                            <i class="fa fa-share-square-o"></i>
                        </div>
                        <h3 class="features-title font-alt">Promotion</h3>
                        We're a world leader in original Music and Lyric sales and massively promote the work of our sellers and buyers
                    </div>

				</div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="features-item">
                        <div class="features-icon">
                            <i class="fa fa-times"></i>
                        </div>
                        <h3 class="features-title font-alt">Zero Commission</h3>
                        We take absolutely no percentages from Sales or Royalties
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="container">
        Who am I? ... None of your business !<br>
        Miraculous<br>
        Hatz<br>
        Codrin<br>
    </div>
    <div class="container text-align-center">
        <img src="images/41029489544_0bfffedcba_b.jpg" class="img-responsive img-center img-resize " alt="led">
    </div>

    <section id="featuresGear">
            <div class="container">
                <br>
                <h3 class="module-title font-alt">Key Benefits for Gear</h3>
                
                <div class="row multi-columns-row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <div class="features-item">
                            <div class="features-icon">
                                <i class="fa fa-times"></i>
                            </div>
                            <h3 class="features-title font-alt">Zero Commission</h3>
                            We take absolutely no percentages from Sales or Royalties
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section style="background-color: #fafafa;">
        <div class="container">
            <br>
            <h3 class="module-title font-alt">Top 5 Music Sellers:</h3>
            
            <div id="top5" class="row multi-columns-row">
                <div class="col-sm-2 col-md-2 col-lg-2">
                    Nothing to show
                </div>
            </div>
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
                                    <a href="banner.html" class="m-20 f-w-bold">Banner Exchange</a>
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
                                        <img title="Facebook Page" src="img/Facebook_button.jpg" alt="Facebook_button" class="img-responsive img-center">
                                    </a>
    
                                    <a href="https://twitter.com/Muzicity1" target="_blank" class="m-20" style="text-decoration: none;">
                                        <img title="Twitter Page" src="img/twitter_button.jpg" alt="twitter_button" class="img-responsive img-center">
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="contact.html" class="m-20 f-w-bold">Contact Us</a>
                                </td>
                            </tr>
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>