$( document ).ready(function() {
    var heatmapArray = []; 
    for(var i = 0; i < 8; i++) {
        heatmapArray[i] = 0;
    }

    var mouseX, mouseY;
    $(document).on('click', function(e) {
        // console.log(e.pageX +" " + e.pageY);
        var windowX = $(window).width();
        var windowY = $(window).height();

        var mouseX = e.pageX;
        var mouseY = e.pageY;
        var gasit = -1;

        if(mouseY > windowY) {
            mouseY -= windowY;
        }
        // console.log(windowX + " " + windowY + " " + mouseX + " " + mouseY);
        if(mouseY <= windowY / 2) {
            if(mouseX <= windowX / 4) {
                heatmapArray[0] += 1;
                gasit = 0;
            } else if(mouseX <= windowX / 2) {
                heatmapArray[1] += 1;
                gasit = 1;
            } else if(mouseX <= 3 * windowX / 4) {
                heatmapArray[2] += 1;
                gasit = 2;
            } else {
                heatmapArray[3] += 1;
                gasit = 3;
            }
        } else {
            if(mouseX <= windowX / 4) {
                heatmapArray[4] += 1;
                gasit = 4;
            } else if(mouseX <= windowX / 2) {
                heatmapArray[5] += 1;
                gasit = 5;
            } else if(mouseX <= 3 * windowX / 4) {
                heatmapArray[6] += 1;
                gasit = 6;
            } else {
                heatmapArray[7] += 1;
                gasit = 7;
            }
        }
        if(gasit !== -1) {
            $.ajax({
                url: 'php/heatHarta.php',
                type: 'POST',
                data: 'heat=' + gasit,
                success: function(data){
                    var sPath = window.location.pathname;
                    var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
                    if(sPage === 'heatmap.html')
                        makeHeatmapPage();
                },
                error: function(){
                }
            });
        }
        
        // console.log(heatmapArray[0] + " " + heatmapArray[1] + " " + heatmapArray[2] + " " + heatmapArray[3] + "\n");
        
        // console.log(heatmapArray[4] + " " + heatmapArray[5] + " " + heatmapArray[6] + " " + heatmapArray[7] + "\n");
    });

});

function makeHeatmapPage() {
    var windowY = $(window).height();
    var culori = ['#E50001', '#DF3700', '#DA6E00', '#D4A200', '#CBCF00', '#92C900', '#5BC400', '#27BF00'].reverse();

    $.ajax({
        url: 'php/heatHarta.php',
        type: 'GET',
        data: 'heatGet=' + true,
        success: function(data){ 
            console.log(data);
            var resp = jQuery.parseJSON(data);
            var maxim = -1;
            var minim = Number.MAX_SAFE_INTEGER;
            for(var i = 0; i < 8; i++) {
                resp[i] =  parseInt(resp[i]);
                if(resp[i] > maxim) {
                    maxim = resp[i];
                }
                if(resp[i] < minim) {
                    minim = resp[i];
                }
            }
            var pas = (maxim - minim) / 8;
            if(pas !== 0) {
                for(var i = 0; i < 8; i++) {
                    var interval = Math.floor((resp[i] - minim) / pas) + 1;
                    console.log("Interval " + interval);
                    $("#heat" + i).css('background-color', culori[(interval - 1) === 8 ? 7 : (interval - 1)]);
                }
            }
            
        },
        error: function(){
            alert('eroare000');
        }
    });

    $("#heat0").css('height', windowY / 2);
    $("#heat1").css('height', windowY / 2);
    $("#heat2").css('height', windowY / 2);
    $("#heat3").css('height', windowY / 2);
    $("#heat4").css('height', windowY / 2);
    $("#heat5").css('height', windowY / 2);
    $("#heat6").css('height', windowY / 2);
    $("#heat7").css('height', windowY / 2);

}
