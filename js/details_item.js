var idItem = -1;

function set_btn() {
    document.getElementById("Loading").style.display = "none";
    document.getElementById("edit_div").style.display = "none";
}

function checkLoginItem(path, id) {
    $.ajax({
        url: path + 'php/login.php',
        type: 'GET',
        data: 'perm_edit=' + true + "&id=" + id,
        success: function(data){
            console.log("data: " + data);
            var resp = jQuery.parseJSON(data);
            console.log(resp);
            if(resp === 1 || resp === 0) {
                document.getElementById("edit-btn").style.display = "none";
                document.getElementById("del-btn").style.display = "none";
            }
            else {
                document.getElementById("edit-btn").style.display = "inline";
                document.getElementById("del-btn").style.display = "inline";
            }
        },
        error: function(){
            alert('eroare7777');
        }
    });
}

function bring_item(path = "") {
    set_btn();
    take_item(path);
}

function take_item(path) {
    var id = localStorage.getItem("storageID");
    $.ajax({
        url: path + 'php/posts.php',
        type: 'GET',
        data: 'posts_id=' + true + '&id=' + id,
        success: function(data){
            // console.log(data);
            var resp = jQuery.parseJSON(data);
            console.log("AICI ", resp);
            document.getElementById("username_item").innerHTML = resp[0];
            document.getElementById("username_item").href = 'profile/' + resp[0] + '.html';
            document.getElementById("title").innerHTML = resp[1];
            document.getElementById("artists").innerHTML = resp[2];
            document.getElementById("lang").innerHTML = resp[3];
            document.getElementById("price").innerHTML = resp[5];
            document.getElementById("curr").innerHTML = resp[4];
            document.getElementById("genre").innerHTML = resp[6];
            document.getElementById("date").innerHTML = resp[7] ? resp[7] : "-";
            document.getElementById("idi").innerHTML = "#" + resp[10];
            document.getElementById("more_details").innerHTML = resp[8] ? resp[8] : "Nothing to show";
            document.getElementById("single_parental").innerHTML = resp[10] === "1" ? "Yes" : "No";
            checkLoginItem(path, resp[10]);
            document.getElementById("edit_single_album_name").value = resp[1];
            document.getElementById("edit_primary_artists").value = resp[2];
            document.getElementById("edit_single_language").value = resp[3];
            document.getElementById("edit_money").value = parseInt(resp[5]);
            document.getElementById("edit_currency").value = resp[4];
            document.getElementById("edit_single_primary_genre").value = resp[6];
            document.getElementById("edit_release_date").value = resp[7] ? resp[7] : "";
            document.getElementById("edit_id-item").value = "#" + resp[9];
            document.getElementById("edit_rec_location").value = resp[8] ? resp[8] : "";;
            document.getElementById("edit_single_parental_advisory_1").checked = resp[10] === "1" ? true : false;
            idItem = resp[10];

            var pathImg = path + 'profile/' + resp[0] + '/' + resp[10] + '_1.jpg?' + new Date().getTime();
            $('#photo_1').attr('src', pathImg);
            $.ajax({
                url: path + 'php/login.php',
                type: 'GET',
                data: 'get_profile=' + resp[0],
                success: function(data){
                    console.log(data);
                    var resp1 = jQuery.parseJSON(data);
                    console.log("Mare hatz johnule " + resp[0] + " " + resp1);
                    document.getElementById("first").innerHTML = resp1[1] ? resp1[1] : resp[0];
                    document.getElementById("last").innerHTML = resp1[2] ? resp1[2] : "-";
                    document.getElementById("email").innerHTML = resp1[3] ? resp1[3] : "-";
                    document.getElementById("city").innerHTML = resp1[4] ? resp1[4] : "-";
                    document.getElementById("tel").innerHTML = resp1[6] ? resp1[6] : "-";
                },
                error: function(){
                    alert('eroare12345');
                }
            });
        },
        error: function(){
            alert('eroare7575');
        }
    });

    
}
function deleteBtn(path = "") {
    $.ajax({
        url: path + 'php/posts.php',
        type: 'POST',
        data: 'delete_item=' + idItem,
        success: function(data){
            console.log(data);
            location.href = 'music.html';
        },
        error: function(){
            alert('eroare');
        }
    });
}

function editItem(path = "") {

    var fd = new FormData();
    fd.append('file', $('#edit_fileToUpload1')[0].files[0]);
    fd.append('id', idItem);

    document.getElementById("Loading").style.display = "block";
    document.getElementById("edit_button").disabled = true; 
    setTimeout(function(){
        var user = getCookie("login_s");
        var title = document.getElementById("edit_single_album_name") ? document.getElementById("edit_single_album_name").value : "";
        var artists = document.getElementById("edit_primary_artists") ? document.getElementById("edit_primary_artists").value : "";
        var language = document.getElementById("edit_single_language") ? document.getElementById("edit_single_language").value : "";
        var currency = document.getElementById("edit_currency") ? document.getElementById("edit_currency").value : "";
        var price = document.getElementById("edit_money") ? document.getElementById("edit_money").value : "";
        var genre = document.getElementById("edit_single_primary_genre") ? document.getElementById("edit_single_primary_genre").value : "";
        var genre2 = document.getElementById("edit_single_secondary_genre") ? document.getElementById("edit_single_secondary_genre").value : "";
        var date = document.getElementById("edit_release_date") ? document.getElementById("edit_release_date").value : "";
        var details = document.getElementById("edit_rec_location") ? document.getElementById("edit_rec_location").value : "";
        var exp = document.getElementById("edit_single_parental_advisory_1").value;
        
        $.ajax({
            url: path + 'php/posts.php',
            type: 'POST',
            data: 'update_post=' + true + "&id=" + idItem + "&username=" + user + "&title=" + title + "&artists=" + artists + "&language=" + language + "&currency=" + currency + "&price=" + price + "&genre=" + genre + "&genre2=" + genre2 + "&date=" + date + "&details=" + details + "&exp=" + exp,
            success: function(data){
                console.log(data);     
        
                $.ajax({
                    url: path + 'php/posts_image.php',
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(data){
                        document.getElementById("Loading").style.display = "none";
                        document.getElementById("edit_div").style.display = "block";
                        document.getElementById("edit_button").style.display = "none";
                        take_item(path);
                        setTimeout(function() {
                            document.getElementById('confModalEdit').style.display='none';
                            document.getElementById('modalMarketEdit').style.display='none';
                            document.getElementById("edit_div").style.display = "none";
                            document.getElementById("edit_button").style.display = "inline";
                            document.getElementById("edit_button").disabled = false; 
                        }, 2000);
        
                    },
                    error: function(){
                        alert('eroare852');
                    }
                });
            },
            error: function(){
                alert('eroare987');
            }
        });
        
    }, 3000);
}