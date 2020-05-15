function bringData() {
    document.getElementById("btn-perm").disabled = false;
    document.getElementById("btn-perm-gear").disabled = false;
    $.ajax({
        url: 'php/login.php',
        type: 'GET',
        data: 'adminOn=' + true,
        success: function(data){
            console.log(data);
            if(data === "1") {
                document.getElementById('mareleDiv').style.display = "block";
                makeTop5();
                make_gr();
                getProb();
            } else {
                document.getElementById('mareleDiv').innerHTML = "You are not an admin !";
            }
            
        },
        error: function(){
            alert('eroare');
        }
    });
}

function makeTop5() {
    var x = document.getElementById("top5");
    $.ajax({
        url: 'php/login.php',
        type: 'GET',
        data: 'top5=' + true,
        success: function(data){
            console.log(data);   
            var resp = jQuery.parseJSON(data);

            var text = "";
            var len = resp.length < 5 ? resp.length : 5;
            resp.sort(function(a,b){return a[2]>b[2];});
            resp.reverse();
            for(var i = 0; i < len; i++) {
                text += '<div class="top5 col-sm-2 col-md-2 col-lg-2">';
                text += '<span class="font-16"><a href="profile/' + resp[i][0] + '.html">' + resp[i][0] + '#' + resp[i][1] +  '</a> with <b>' + resp[i][2] + '</b> posts</span>';
                text += '</div>';
            }
            x.innerHTML = text;
        },
        error: function(){
            alert('eroare');
        }
    });
}

function make_gr() {
    var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var labelY = [20, 94, 168, 242, 326];
    $.ajax({
        url: 'php/login.php',
        type: 'GET',
        data: 'graphic=' + true,
        success: function(data){
            console.log("Hatz Hatz John " + data);   
            var resp = jQuery.parseJSON(data);
            var X = document.getElementById("Xs");
            var Y = document.getElementById("Ys");
            var P = document.getElementById("points");

            var aux = [];
            var pozX = [];
           

            var textX = "";
            var textY = "";
            var textP = "";
            for(var i = 0; i < resp.length; i++) {
                var a = new Date(resp[i][1] * 1000);
                var valData = a.getDate() + months[a.getMonth()] + a.getFullYear();
                var valX = 102 + 146 * i;
                pozX[i] = valX;
                textX += '<text x="' + valX + '" y="400">' + valData + '</text>';
            }
            textX += '<text x="400" y="440" class="label-title">Dates</text>';

            for(var i = 0; i < resp.length; i++) {
                aux[i] = parseInt(resp[i][0]);
            }
            for(var i = 0; i < resp.length - 1; i++) {
                for(var j = i + 1; j < resp.length; j++) {
                    if(aux[i] < aux[j]) {
                        var aux2 = aux[i];
                        aux[i] = aux[j];
                        aux[j] = aux2;

                        aux2 = pozX[i];
                        pozX[i] = pozX[j];
                        pozX[j] = aux2;
                    }
                }
            }

            for(var i = 0; i < resp.length; i++) {
                textY += '<text x="80" y="' + labelY[i] + '">' + aux[i] + '</text>';
                textP += '<circle cx="' + pozX[i] + '" cy="' + labelY[i] + '" data-value="' + aux[i] +'" r="4"></circle>';
            }
            textY += '<text x="50" y="200" class="label-title">No.</text>';
            X.innerHTML = textX;
            Y.innerHTML = textY;
            P.innerHTML = textP;
            
        },
        error: function(){
            alert('eroare');
        }
    });
}

function changePerm() {
    var userPerm = document.getElementById("userPerm") ? document.getElementById("userPerm").value : "";
    var permEditOwner = document.getElementById("permEditOwner") ? document.getElementById("permEditOwner").value : "0";
    var permEditUsers = document.getElementById("permEditUsers") ? document.getElementById("permEditUsers").value : "0";
    var permEditGuest = document.getElementById("permEditGuest") ? document.getElementById("permEditGuest").value : "0";
    
    $.ajax({
        url: 'php/posts.php',
        type: 'POST',
        data: 'changePerm=' + true +'&id=' + userPerm + '&one=' + permEditOwner + '&two=' + permEditUsers + '&three=' + permEditGuest,
        success: function(data){
            console.log(data);   
            // var resp = jQuery.parseJSON(data);
            if(data === "1") {
                document.getElementById("rezPerm").innerHTML = "Success";
                document.getElementById("btn-perm").disabled = true;
            } else {
                document.getElementById("rezPerm").innerHTML = "Failed";
            }
        },
        error: function(){
            alert('eroare');
        }
    });
}

function changePermGear() {
    var userPerm = document.getElementById("userPermGear") ? document.getElementById("userPermGear").value : "";
    var permEditOwner = document.getElementById("permEditOwnerG") ? document.getElementById("permEditOwnerG").value : "0";
    var permEditUsers = document.getElementById("permEditUsersG") ? document.getElementById("permEditUsersG").value : "0";
    var permEditGuest = document.getElementById("permEditGuestG") ? document.getElementById("permEditGuestG").value : "0";
    
    $.ajax({
        url: 'php/posts.php',
        type: 'POST',
        data: 'changePermGear=' + true +'&id=' + userPerm + '&one=' + permEditOwner + '&two=' + permEditUsers + '&three=' + permEditGuest,
        success: function(data){
            console.log(data);
            if(data === "1") {
                document.getElementById("rezPermGear").innerHTML = "Success";
                document.getElementById("btn-perm-gear").disabled = true;
            } else {
                document.getElementById("rezPermGear").innerHTML = "Failed";
            }
        },
        error: function(){
            alert('eroare');
        }
    });
}

function getProb() {
    $.ajax({
        url: 'php/login.php',
        type: 'GET',
        data: 'xy=' + true,
        success: function(data){
            console.log(data);
            var resp = jQuery.parseJSON(data);
            var elem = document.getElementById('prob');
            var text = '<p>Button Music: ' + resp[0] + '</p><br>';
            text += '<p>Button Sell_Music: ' + resp[1] + '</p><br>';
            var value = resp[0] != 0 ? (resp[1]/resp[0]) * 100 : 0;
            value = value.toFixed(3);
            text += '<p>Probabilitatea sa apesi pe butonul Sell_Music imediat dupa apasarea butonului Music este: ' + value + '%</p><br>';

            elem.innerHTML = text;

        },
        error: function(){
            alert('eroare');
        }
    });
}