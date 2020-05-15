function send_msg() {
    console.log("Hatz");
    document.getElementById("contact-send").disabled = 'true';
    document.getElementById("contact-send").value = "Sending ...";

    var name = document.getElementById("contact-name").value;
    var mail = document.getElementById("contact-email").value;
    var sub = document.getElementById("contact-subject").value;
    var msg = document.getElementById("contact-message").value;

    $.ajax({
        url: 'php/contact.php',
        type: 'POST',
        data: 'contact=' + true + '&name=' + name + '&mail=' + mail + '&sub=' + sub + '&msg=' + msg,
        success: function(data){
            console.log(data);   
            document.getElementById("contact-send").value = "Success";
        },
        error: function(){
            alert('eroare');
        }
    });
}