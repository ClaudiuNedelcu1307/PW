function submit_register() {
    var username = document.getElementById('uname_reg').value;
    var email = document.getElementById('email_reg').value;
    var pass = document.getElementById('upass_reg').value;
    var rePass = document.getElementById('urepass_reg').value;

    if(pass !== rePass) {
        alert('prostule .. nu poti sa scrii o parola');
    } else {
        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: 'register_post=' + true + "&username=" + username + "&password=" + pass + "&rights=" + "-" + "&email=" + email,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                console.log(resp);
                document.getElementById("StatusLogin").innerHTML = resp;
                if(resp === 0) {
                    document.getElementById('id02').style.display='none';
                } else {
                    alert('User deja existent');
                }

            },
            error: function(){
                alert('eroarez');
            }
        });
    }
}

