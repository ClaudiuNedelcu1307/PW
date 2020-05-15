function removeActive() {
    var element = document.getElementById("a_basic");
    element.classList.remove("activeTab");

    element = document.getElementById("a_details");
    element.classList.remove("activeTab");

    element = document.getElementById("a_pass");
    element.classList.remove("activeTab");

    document.getElementById("Basic_Info").style.display = "none";
    document.getElementById("Details").style.display = "none";
    document.getElementById("Pass_Change").style.display = "none";
}


function click_basic() {
    removeActive();
    var element = document.getElementById("a_basic");
    element.classList.add("activeTab");
    document.getElementById("Basic_Info").style.display = "block";
}

function click_details() {
    removeActive();
    var element = document.getElementById("a_details");
    element.classList.add("activeTab");
    document.getElementById("Details").style.display = "block";
}

function click_pass() {
    removeActive();
    var element = document.getElementById("a_pass");
    element.classList.add("activeTab");
    document.getElementById("Pass_Change").style.display = "block";
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

function check_perm(name) {
    
    $.ajax({
        url: '../php/login.php',
        type: 'GET',
        data: 'get_profile_user=' + name,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            console.log(resp);
            if(resp[2] === "4") {
                var inputs = document.getElementsByTagName("input"); 
                for (var i = 0; i < inputs.length; i++) { 
                    inputs[i].disabled = true;
                }
                var textareas = document.getElementsByTagName("textarea"); 
                for (var i = 0; i < textareas.length; i++) { 
                    textareas[i].disabled = true;
                }
                document.getElementById("a_pass").style.display = "none";
                document.getElementById("div_edit").innerHTML = "View Profile";
                document.getElementById("applyChanges").style.display = "none";
                document.getElementById("confirmChange").style.display = "none";
            } else {
                var inputs = document.getElementsByTagName("input"); 
                for (var i = 0; i < inputs.length; i++) { 
                    inputs[i].disabled = false;
                }
                var textareas = document.getElementsByTagName("textarea"); 
                for (var i = 0; i < textareas.length; i++) { 
                    textareas[i].disabled = false;
                }
                document.getElementById("a_pass").style.display = "block";
                document.getElementById("applyChanges").style.display = "block";
                document.getElementById("confirmChange").style.display = "block";
            }
        },
        error: function(){
            alert('eroare');
        }
    });
}

function load_data() {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    var name = page.substring(0, page.length-5);

    check_perm(name);
    get_user_music();
    click_basic();

    $.ajax({
        url: '../php/login.php',
        type: 'GET',
        data: 'get_profile=' + name,
        success: function(data){
            var resp = jQuery.parseJSON(data);
            document.getElementById("first_Profile").value = resp[1];
            document.getElementById("last_Profile").value = resp[2];
            document.getElementById("mail_Profile").value = resp[3];
            document.getElementById("city_Profile").value = resp[4];
            document.getElementById("fb_Profile").value = resp[5];
            document.getElementById("tel1_Profile").value = resp[6];
            document.getElementById("tel2_Profile").value = resp[7];
            document.getElementById("born_Profile").value = resp[8];

            var pathImg = name + '/' + name + '_profile.jpg?' + new Date().getTime();
            $.get(pathImg)
            .done(function() { 
                $('#profilePicture').attr('src', pathImg);

            }).fail(function() { 
                $('#profilePicture').attr('src', 'default.png?' + new Date().getTime());
            })
        },
        error: function(){
            alert('eroare');
        }
    });
    
}

function send_data() {
    var user = getCookie("login_s");
    var fist_name = document.getElementById("first_Profile") ? document.getElementById("first_Profile").value : "";
    var last_name = document.getElementById("last_Profile") ? document.getElementById("last_Profile").value : "";;
    var city = document.getElementById("city_Profile") ? document.getElementById("city_Profile").value : "";;
    var email = document.getElementById("mail_Profile") ? document.getElementById("mail_Profile").value : "";;
    var fb_user = document.getElementById("fb_Profile") ? document.getElementById("fb_Profile").value : "";;
    var tel1 = document.getElementById("tel1_Profile") ? document.getElementById("tel1_Profile").value : "";;
    var tel2 = document.getElementById("tel2_Profile") ? document.getElementById("tel2_Profile").value : "";;
    var birth = document.getElementById("born_Profile") ? document.getElementById("born_Profile").value : "";;
    var bio = document.getElementById("detail_block_Profile") ? document.getElementById("detail_block_Profile").value : "";

    var pass = document.getElementById('upass_edit').value;
    var rePass = document.getElementById('urepass_edit').value;

    if(pass !== "" && rePass !== "" && pass !== rePass) {
        alert('prostule .. nu poti sa scrii o parola');
    } else {

        $.ajax({
            url: '../php/login.php',
            type: 'POST',
            data: 'update_profile=' + user + "&first_name=" + fist_name + "&last_name=" + last_name + "&email=" + email + "&city=" + city + "&fb_user=" + fb_user + "&tel1=" + tel1 + "&tel2=" + tel2 + "&birth=" + birth + "&pass=" + pass,
            success: function(data){
                load_data();
            },
            error: function(){
                alert('eroare');
            }
        });
    }
}

function changePicture() {
    var fd = new FormData();
    fd.append('file', $('#file')[0].files[0]);

    $.ajax({
        url: '../php/update_photo.php',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            document.getElementById('id01').style.display='none';
            load_data();
        },
        error: function(){
            alert('eroare');
        }
    });
}

function get_user_music() {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    var name = page.substring(0, page.length-5);

    var x = document.getElementById("search_rez");
    $.ajax({
        url: '../php/posts.php',
        type: 'GET',
        data: 'posts_user=' + true + '&user=' + name,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            var text = "";
            for(var i = 0; i < resp.length; i++) {
                if(i % 4 === 0) {
                    if(i != 0) {
                        text += "</div><br>";
                    }
                    text += '<div class="row">'
                }
                text += '<div class="col-md-3 ">';
                text += '<div class="box-post">';
                if(resp[i][7] === "GEAR-ITEM") {
                    text += '<img class="img-to-post" src=' + resp[i][0] + '/' + resp[i][10] + 'G_1.jpg?' + new Date().getTime() +'>';
                } else {
                    text += '<img class="img-to-post" src=' + resp[i][0] + '/' + resp[i][10] + '_1.jpg?' + new Date().getTime() +'>';
                }
                
                text += ' <div class="details">';
                text += '<span class="item_card"><span class="sup">Title: </span>' + resp[i][1] +  '</span><br>';
                text += '<span class="item_card"><span class="sup">Artists: </span>' + resp[i][2] + '</span><br>';
                text += '<span class="item_card"><span class="sup">Price:  </span>' + resp[i][5] + ' ' + resp[i][4] + '</span><br>';
                text += '<span class="item_card"><span class="sup">Genre: </span>' + resp[i][6] + '</span><br>';
                console.log(resp[i][12] + " " + "dsfsdf");
                if(resp[i][7] !== "GEAR-ITEM" && (resp[i][12] === "1" || resp[i][12] === "2")) {
                    text += '<button class="btn-detail" name="' + resp[i][10] + '" onclick="detailButton(' + resp[i][10] +')">Details</button>'
                } else {
                    text += resp[i][7];
                }
                text += "</div></div></div>";
            }
            x.innerHTML = text;

        },
        error: function(){
            alert('eroare');
        }
    });
}

function detailButton(x) {
    localStorage.setItem("storageID",x);
    var x = document.getElementById("search_rez");
    $.ajax({
        url: '../php/change-page.php',
        type: 'GET',
        data: 'get_item_details=' + true,
        success: function(data){
            console.log(data);   
            var resp = jQuery.parseJSON(data);
            var text = '<div id="buyMusic" class="col-md-12 text-align-center quick-title"><h3 class="sellGear-title">Item and Seller Details:</h3><hr class="hr-style"></div>';
            x.innerHTML = text;
            x.insertAdjacentHTML('beforeend', resp);
            var path = "../";
            bring_item(path);
            document.getElementById('edit_button').setAttribute('onclick','editItem("../")');
            document.getElementById("del-btn").setAttribute('onclick','deleteBtn("../")');
        },
        error: function(){
            alert('eroare1234');
        }
    });
}