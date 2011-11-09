var imageUrl;

//TODO: finish this...
function init(url) {
    imageUrl = url;
    
    $('#selected-cards').droppable({
        accept: '.available'
    });
    $('#selected-cards li').dblclick(function(e) {
        })
    .click(function (e) {
        loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
    });
    
    $('#available-cards li').draggable({
        appendTo: 'body',
        helper: 'clone',
        revert: 'invalid'
    })
    .dblclick(function (e) {
        })
    .click(function (e) {
        loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
    });
}

function loadPreviewImage(id) {
    $.ajax({
        url: imageUrl,
        data: {
            card: id 
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.success) {
                $('#previewImage').attr('src', '_game/cards/' + json.image);
            } else {
                $('#previewImage').attr('src', '_game/cards/cardback.jpg');
            }
        }
    });
}

/*$(function () {
    //Configure draggables for existing cards
    //These cards can be dragged using a helper clone function and dropped in 
    //the #usecards area.
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

    //Configure the #usercards area where selected cards are dropped.
    //Whenever a card is dropped, two new elements are created: the visible card 
    //that the user can manipulate and the hidden field that carries the card's 
    //ID to the server
    $('#usecards').droppable({
        accept: '.available',
        drop: function(event, ui) {
            var destination  = $('#usecards');
            var cardCount = destination.children().length, top = 0, left = 0, mv = parseInt(cardCount / 14, 10);
            
            if(cardCount > 0) {
                top =  mv * 40;
                left = (cardCount - (14  * mv)) * 25;
            }
            
            var count = $('.s-' + ui.draggable.attr('id')).length;
            
            configureSelectedCard($(document.createElement('img'))
                .addClass('chosen')
                .addClass('s-' + ui.draggable.attr('id'))
                .css({
                    'left': left, 
                    'top': top
                })
                .attr({
                    src: ui.draggable.attr('src'),
                    id: 's-' + ui.draggable.attr('id') + count
                })
                .appendTo(destination));
            
            $(document.createElement('input'))
            .addClass('hs-' + ui.draggable.attr('id'))
            .attr({
                type: 'hidden', 
                name: 'using[]',
                value: ui.draggable.attr('id'),
                id: 'hs-' + ui.draggable.attr('id') + count
            })
            .appendTo($('#deck-form'));
        }
    });
    
    //The #existingcards area is also a droppable for cards that have been added 
    //to the deck, it allows cards to be removed from the deck
    $('#existingcards').droppable({
        accept: '.chosen',
        drop: function(event, ui) {           
            $('#h' + ui.draggable.attr('id')).remove();
            ui.draggable.remove();
        }
    });
    
    $('.chosen').each(function(index) {
        configureSelectedCard($(this));
    });
});*/

/*function configureSelectedCard(card) {
    card.draggable({
        containment: 'body',
        stack: '.chosen'
    });
    
}*/