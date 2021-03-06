function changeItemsInList(x, resp) {
    console.log(resp);
    var text = "";
    if(resp.length === 0) {
        text = '<div class="col-md-12 text-align-center font-16">' + "Nothing to show" + '</div>';
    }
    for(var i = 0; i < resp.length; i++) {
        if(i % 4 === 0) {
            if(i != 0) {
                text += "</div><br>";
            }
            text += '<div class="row">'
        }
        text += '<div class="col-md-3 ">';
        text += '<div class="box-post">';
        text += '<img class="img-to-post" src=profile/' + resp[i][0] + '/' + resp[i][9] + 'G_1.jpg?' + new Date().getTime() +'>';
                
        text += ' <div class="details">';
        text += '<span class="item_card"><span class="sup">Title: </span>' + resp[i][1] +  '</span><br>';
        text += '<span class="item_card"><span class="sup">Artists: </span>' + resp[i][2] + '</span><br>';
        text += '<span class="item_card"><span class="sup">Price:  </span>' + resp[i][5] + ' ' + resp[i][4] + '</span><br>';
        text += '<span class="item_card underline"><span class="sup">Sell by: </span>' + '<a href="profile/' + resp[i][0] + '.html">'+resp[i][0] + '</a>' +  '</span><br>';
        text += '<span class="item_card"><span class="sup">Type: </span>' + resp[i][6] + '</span><br>';
        if(resp[i][11] === "1" || resp[i][11] === "2") {
            text += '<button class="btn-detail" name="' + resp[i][9] + '" onclick="detailButton(' + resp[i][9] +')">Details</button>'
        }
        text += "</div></div></div>";
    }
    x.innerHTML = text;
}

function checkLogin() {
    $.ajax({
        url: 'php/login.php',
        type: 'GET',
        data: 'perm_create=' + true,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            console.log(resp);
            if(resp === 0) {
                document.getElementById("sell-btn-gear").style.display = "none";
            }
            else {
                document.getElementById("sell-btn-gear").style.display = "inline";
            }
        },
        error: function(){
            alert('eroare');
        }
    });
    document.getElementById("LoadingAct").style.display = "none";
    document.getElementById("sell_div").style.display = "none";
}

function get_all_gear() {
    checkLogin();
    take_music();
}

function take_music() {
    var x = document.getElementById("search_rez");
    if(x != null) {
        $.ajax({
            url: 'php/posts_gear.php',
            type: 'GET',
            data: 'posts_gear=' + true,
            success: function(data){
                console.log("dsfsdf" + data);
                var resp = jQuery.parseJSON(data);
                changeItemsInList(x, resp);
            },
            error: function(){
                alert('eroare');
            }
        });
    }
}


function search_for(text) {
    var x = document.getElementById("search_rez");
    document.getElementById("search-bar").value = text;
    $.ajax({
        url: 'php/search_music.php',
        type: 'GET',
        data: 'search_gear=' + true + '&text=' + text,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            changeItemsInList(x, resp);
        },
        error: function(){
            alert('eroare');
        }
    });
}

function postItem() {

    var fd = new FormData();
    fd.append('file', $('#fileToUpload1')[0].files[0]);

    document.getElementById("LoadingAct").style.display = "block";
    document.getElementById("sell_button").disabled = true; 
    setTimeout(function(){
        var user = getCookie("login_s");
        var title = document.getElementById("single_album_name") ? document.getElementById("single_album_name").value : "";
        var artists = document.getElementById("primary_artists") ? document.getElementById("primary_artists").value : "";
        var language = document.getElementById("single_language") ? document.getElementById("single_language").value : "";
        var currency = document.getElementById("currency") ? document.getElementById("currency").value : "";
        var price = document.getElementById("price") ? document.getElementById("price").value : "";
        var genre = document.getElementById("single_primary_genre") ? document.getElementById("single_primary_genre").value : "";
        var date = document.getElementById("release_date") ? document.getElementById("release_date").value : "";
        var details = document.getElementById("rec_location") ? document.getElementById("rec_location").value : "";
        var exp = document.getElementById("single_parental_advisory").value;
        
        $.ajax({
            url: 'php/posts_gear.php',
            type: 'POST',
            data: 'add_gear=' + true + "&username=" + user + "&title=" + title + "&artists=" + artists + "&language=" + language + "&currency=" + currency + "&price=" + price + "&genre=" + genre + "&date=" + date + "&details=" + details + "&exp=" + exp,
            success: function(data){
                console.log(data);     
                var resp = jQuery.parseJSON(data);

                fd.append('id', resp[0] + 'G');
                $.ajax({
                    url: 'php/posts_image.php',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        console.log(data);
                        document.getElementById("LoadingAct").style.display = "none";
                        document.getElementById("sell_div").style.display = "block";
                        document.getElementById("sell_button").style.display = "none";
                        take_music();

                        setTimeout(function() {
                            $('#single_album_name').val("");
                            $('#primary_artists').val("");
                            $('#single_language').val("");
                            $('#currency').val("");
                            $('#price').val("");
                            $('#single_primary_genre').val("");
                            $('#single_secondary_genre').val("");
                            $('#release_date').val("");
                            $('#rec_location').val("");
                            $('#fileToUpload1').val(null);

                            document.getElementById('confModalAct').style.display='none';
                            document.getElementById('modalMarketAct').style.display='none';
                            document.getElementById("sell_div").style.display = "none";
                            document.getElementById("sell_button").style.display = "inline";
                            document.getElementById("sell_button").disabled = false; 
                        }, 2000);
        
                    },
                    error: function(){
                        alert('eroare');
                    }
                });
            },
            error: function(){
                alert('eroare');
            }
        });
        
    }, 3000);

    

}

function detailButton(x) {
    localStorage.setItem("storageIDGear",x);
    var x = document.getElementById("detail_search");
    $.ajax({
        url: 'php/change-page.php',
        type: 'GET',
        data: 'get_gear_details=' + true,
        success: function(data){
            console.log(data);   
            var resp = jQuery.parseJSON(data);
            var text = '<div id="buyGear" class="col-md-12 text-align-center quick-title"><h3 class="sellGear-title">Item and Seller Details:</h3><hr class="hr-style"></div>';
            x.innerHTML = text;
            x.insertAdjacentHTML('beforeend', resp);

            bring_item();
        },
        error: function(){
            alert('eroare');
        }
    });
}