$(function () {
    $('.available').draggable({
        appendTo: '#usecards',
        containment: 'body', 
        stack: '.available',
        helper: function(event, ui) {
            return $(document.createElement('img')).attr('src', $(this).attr('src'));            
        },
        start: function(event, ui) {            
            $(this).css('opacity', '0.6');
        },
        stop: function (event, ui) {
            $(this).css('opacity', '1');
        }
    });

    $('#usecards').droppable({
        accept: '.available',
        drop: function(event, ui) {
            var destination  = $('#usecards');
            var cardCount = destination.children().length, top = 0, left = 0, mv = parseInt(cardCount / 14, 10);
            
            if(cardCount > 0) {
                top =  mv * 40;
                left = (cardCount - (14  * mv)) * 25;
            }
            
            var newimg = $(document.createElement('img'));
            
            newimg.addClass('chosen').css({
                'left': left, 
                'top': top
            });
            newimg.attr('src', ui.draggable.attr('src'));
            newimg.appendTo(destination);
            
            $(ui.draggable).remove();
        }
    });
});