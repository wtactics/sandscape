var initUrl = 'http://localhost/www/sandscape/game/1/init';

(function(sandscape, $, undefined) {

    sandscape.initBoard = function() {
        sandscape.pack();
        sandscape.initGame();
    };

    sandscape.initGame = function() {
        $.ajax({
            type: 'GET',
            url: initUrl,
            //data: {},
            dataType: 'json',
            contentType: 'application/json',
            success: function(data, status, xhr) {

            },
            error: function(xhr, status) {

            }
        });
    };

    sandscape.pack = function() {
        $('.opponent-play-area').css({
            width: $(window).width() - 260
        });

        $('.my-play-area').css({
            width: $(window).width() - 260
        });
    };

}(window.sandscape = window.sandscape || {}, Zepto));
