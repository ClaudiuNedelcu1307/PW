function changePage(page) {
    login_check();
    var x = document.getElementById("content_page");
    if(page === 'main') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                x.innerHTML = resp;
                $('#first_image_show').removeClass('item-navbar-min');
                $('#first_image_show').addClass('item-navbar');

                $('#first_image_show').css('background-image', 'url(images/first.jpg)');
                bringData();
                showSlides(1);
                showSlidesInstr(1);
            },
            error: function(){
                alert('eroare');
            }
        });
    } else if(page === 'contact') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                $('#first_image_show').removeClass('item-navbar');
                $('#first_image_show').addClass('item-navbar-min');

                $('#first_image_show').css('background-image', 'url(images/six.png)');
                x.innerHTML = resp;
            },
            error: function(){
                alert('eroare');
            }
        });
    } else if(page === 'market') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                $('#first_image_show').removeClass('item-navbar-min');
                $('#first_image_show').addClass('item-navbar');

                $('#first_image_show').css('background-image', 'url(images/second.jpg)');
                x.innerHTML = resp;
            },
            error: function(){
                alert('eroare');
            }
        });
    } else if(page === 'instruments') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                $('#first_image_show').removeClass('item-navbar-min');
                $('#first_image_show').addClass('item-navbar');

                $('#first_image_show').css('background-image', 'url(images/fourth.jpg)');
                x.innerHTML = resp;
            },
            error: function(){
                alert('eroare');
            }
        });
    } else if(page === 'lyrics') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                $('#first_image_show').removeClass('item-navbar-min');
                $('#first_image_show').addClass('item-navbar');

                $('#first_image_show').css('background-image', 'url(images/fifth.jpg)');
                x.innerHTML = resp;
            },
            error: function(){
                alert('eroare');
            }
        });
    } else if(page === 'profile') {
        $.ajax({
            url: 'php/change-page.php',
            type: 'GET',
            data: page + '=' + true,
            success: function(data){
                console.log(data);
                var resp = jQuery.parseJSON(data);
                $('#first_image_show').removeClass('item-navbar');
                $('#first_image_show').addClass('item-navbar-min');

                $('#first_image_show').css('background-image', 'url(images/profile.jpg)');
                
                x.innerHTML = resp;
                load_data_profile();
            },
            error: function(){
                alert('eroare1');
            }
        });
    } else {
        console.log("Page is not defined!!!");
    }
}
