function submit_login() {
    var username = document.getElementById('uname').value;
    var pass = document.getElementById('upass').value;
    
    $.ajax({
        url: 'php/login.php',
        type: 'POST',
        data: 'login_post=' + true + "&username=" + username + "&password=" + pass + "&rights=" + "-",
        success: function(data){
            console.log(data);
            if(data === "User-or-password-wrong") {
                document.getElementById("StatusLogin").innerHTML = "User-or-password-wrong";
            } else {
                var resp = jQuery.parseJSON(data);
                console.log(resp);
                document.getElementById("StatusLogin").innerHTML = resp;
                if(resp === 0) {
                    login_check();
                    document.getElementById('id01').style.display = 'none';
                    document.getElementById('sell-btn-music') ? document.getElementById('sell-btn-music').style.display = 'inline' : "";
                    document.getElementById('sell-btn-music') ? get_all_music() : "";

                    document.getElementById('sell-btn-gear') ? document.getElementById('sell-btn-gear').style.display = 'inline' : "";
                    document.getElementById('sell-btn-gear') ? get_all_gear() : "";
                }
            }

        },
        error: function(){
            alert('eroare');
        }
    });
}

function getCookie(name) {
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    // because unescape has been deprecated, replaced with decodeURI
    //return unescape(dc.substring(begin + prefix.length, end));
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

function login_check() {
    var myCookie = getCookie("login_s");
    if (myCookie == null) {
        // do cookie doesn't exist stuff;
        document.getElementById("login_li").style.display = "block"; 
        document.getElementById("register_li").style.display = "block";
        

        document.getElementById("user_li").style.display = "none"; 
        document.getElementById("logout_li").style.display = "none";
    }
    else {
        // do cookie exists stuff
        document.getElementById("user_li").style.display = "block"; 
        document.getElementById("username_li").innerHTML = '<i class="fa fa-user"></i> ' + myCookie;
        document.getElementById("logout_li").style.display = "block";

        document.getElementById("login_li").style.display = "none"; 
        document.getElementById("register_li").style.display = "none";
    }
}

function logout() {
    $.ajax({
        url: 'php/logout.php',
        type: 'POST',
        data: 'logout_post=' + true,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            console.log(resp);
            login_check();

        },
        error: function(){
            alert('eroare');
        }
    });
}

function goProfile() {
    window.location = "profile/" + getCookie("login_s") + ".html";
}
