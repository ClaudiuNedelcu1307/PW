<?php
    if(isset($_POST['logout_post'])) {
        session_start();
        setcookie('login_s',"", time() - 3600, "/");
        session_unset();
        session_destroy();
        
        echo "0";
    }
 ?>
