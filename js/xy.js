function xyCheck(name = '', page = '#') {
    var apasa = localStorage.getItem("xy");
    console.log(name);
    console.log(apasa);

    if(name === '') {
        apasa = false;
        localStorage.setItem("xy",apasa);
    } else if(name === 'x') {
        apasa = true;
        localStorage.setItem("xy",apasa);
        $.ajax({
            url: 'php/posts.php',
            type: 'POST',
            data: 'xy=' + 'x',
            success: function(data){
                console.log(data);
                location.href = page;
            },
            error: function(){
                alert('Codrin');
            }
        });
    } else if(name === 'y') {
        console.log('inainte de ajax');
        if(apasa === "true") {
            console.log('ajax');
            $.ajax({
                url: 'php/posts.php',
                type: 'POST',
                data: 'xy=' + 'y',
                success: function(data){
                    console.log(data);
                    apasa = false;
                    localStorage.setItem("xy",apasa);
                },
                error: function(){
                    alert('Mata');
                }
            });
        }
        
    }
}