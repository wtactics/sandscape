//General functions
var last = 0;

/**
 * Sends a message to the server that can then be pulled by other clients. Part
 * of the chat system.
 */
function sendMessage() {
    var text = $('#message');
    if(text.val() != '') {
        $.post('', {
            message: text.val()
        });
    
        text.val('');
    }
}

/**
 * Pulls messages from the server. All messages after a give message/time are 
 * pulled, even the ones posted by the current client.
 */
function reload() {
    $.get('', {
        after: last
    }, function(e) {
        var chat = $('#chat');
        var temp = '';
        for(i = 0; i < e.length; i++) {
            
            if(e[i].system) {
                temp += '<br /><span style="color: ' + e[i].color 
                + '"><strong>&lt;&lt;</strong> ' + e[i].stamp 
                + '<strong>&gt;&gt;:</strong>' + e[i].message + '</span>';
            } else {
                temp += '<br /><span style="color: ' + e[i].color 
                + '"><strong>&lt;</strong> ' + e[i].stamp 
                + '<strong>&gt;:</strong>' + e[i].message + '</span>';
            }
        
            //TODO: //NOTE: will give all chat messages on refresh...
            last = e[i].messageId;
        }
    }, 'json');
}

//Game functions
function drawCardFromDeck() {
    //debug
    //var base = 'http://192.168.10.2/spikes/card-images/';
    var base = 'http://localhost/spikes/card-images/';
    //
    var cards = ['DonationsforRecovery.png', 'DoubttheViolence.png', 'ElvishArcher.png', 
    'ElvishFighter.png', 'ElvishRanger.png', 'ElvishMarksman.png', 'ElvishScout.png', 
    'ElvishShaman.png', 'ElvishSharpshooter.png', 'ElvishShyde.png', 'MermanBrawler.png', 
    'MermanHoplite.png'];
    //end
    var deck = $('#deck');
    var img = $(document.createElement('img'));
    img.attr('height', '113');
    img.attr('width', '81');
        
    img.css('left', deck.css('left'));
    img.css('top', deck.css('top'));
    img.css('position', 'absolute');
        
    var path = base + cards[Math.floor(Math.random() * cards.length)];
    img.attr('src', path);
    img.addClass('card');
    img.draggable();
    img.click(function (event) {
        $('#zoomedImage').attr('src', path);
        
        var off = $(this).offset();
        
        //see if the click was at the left top corner area (16 x 16 pixel) 
        if(event.pageX > (off.left + 81 - 16) && event.pageY < (off.top + 113 - 16)) {           
            $('#radial_container').css('left', event.pageX);
            $('#radial_container').css('top', event.pageY);
            $('#radial_container').radmenu('show');
        }
    });
    
    $('#player').append(img);    
}

function init() {
    $('#board').css('width', $(window).width() - 300);
    $('#opponent').css('height', $(window).height() / 2);
    $('#player').css('height', $(window).height() / 2);
    
    $('#graveyard').droppable({
        accept: '.card',
        drop: function(event, ui) {
        //TODO: ...
        }
    });
/*var left = 0;
    var top = 0
    $( ".drags" ).draggable({
        drag: function(event, ui) {
            if($(this).data('piled')) {
                left = parseInt($(this).css('left'), 10);
                top = parseInt($(this).css('top'), 10);

                //TOP,RIGH,BOTTOM,LEFT: -170, 10, 170, -240
                if(left < -240 || left > 10 || top < -170 || top > 170) {
                    //1)remove from parent span
                    //2)if no child spans: active droppable as we may
                    //have been the last in the pile
                    //3)add to body

                    $(this).parent().parent().append($(this));
                    if($(this).children('.drags').length == 0) {
                        $(this).children('.cards').droppable('droppable', true);
                    }
                    $(this).data('piled', false);
                }

                $("#stats").html('LEFT: ' + $(this).css('left') + '&nbsp;/&nbsp;TOP: ' + $(this).css('top'));
            }
        }
    });
                
    $( ".cards" ).droppable({
        drop: function(event, ui) {
            $(this).parent().append($(ui.draggable));
            $(ui.draggable).data('piled', true);
            $(ui.draggable).css('left', -100);
            $(ui.draggable).css('top', $(this).parent().css('top'));
            $(this).droppable('droppable', false);
        }
    });*/
}

$(document).ready(function() {   
    //setInterval(reload, 3000);
    
    $('#radial_container').radmenu({
        listClass: 'list', // the list class to look within for items
        itemClass: 'item', // the items - NOTE: the HTML inside the item is copied into the menu item
        radius: 25, // in pixels
        animSpeed: 400, //in millis
        selectEvent: 'click', // the select event
        onSelect: function($selected){
            //TODO: ... create event...
            $('#radial_container').hide();
        },
        angleOffset: Math.PI // in radians
    });

    init();
});
