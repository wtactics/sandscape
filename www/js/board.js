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
function drawCardFromDeckOld() {
    //debug
    var base = 'http://192.168.10.2/spikes/card-images/';
    //var base = 'http://localhost/spikes/card-images/';
    //
    var cards = ['DonationsforRecovery.png', 'DoubttheViolence.png', 'ElvishArcher.png', 
    'ElvishFighter.png', 'ElvishRanger.png', 'ElvishMarksman.png', 'ElvishScout.png', 
    'ElvishShaman.png', 'ElvishSharpshooter.png', 'ElvishShyde.png', 'MermanBrawler.png', 
    'MermanHoplite.png'];
    //end
    var deck = $('.deck');
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
        //$('#zoomedImage').attr('src', path);
        
        //var off = $(this).offset();
        
        //see if the click was at the left top corner area (16 x 16 pixel) 
        //if(event.pageX > (off.left + 81 - 16) && event.pageY < (off.top + 113 - 16)) {           
        //    $('#radial_container').css('left', event.pageX);
        //    $('#radial_container').css('top', event.pageY);
        //    $('#radial_container').radmenu('show');
        //}
        });
    
    $('.player').append(img);    
}

function init() {
    $('#board').css('width', $(window).width() - 300);
    
    $.ajax({
        url: 'http://192.168.10.3/wtserver/?quiet',
        dataType: 'jsonp',
        data: {
            'event' : 'startup'
        },
        crossDomain: true,
        success: function(json) {
            
            var opp = $('.opponent');
            opp.attr('id', json.opponentArea.id);
            opp.css('height', $(window).height() / 2);
            opp.append(json.opponentArea.html);
            
            var hand = $('.hand');
            hand.attr('id', json.hand.id);
            hand.append(json.hand.html);
        
            //
            var player = $('.player').attr('id', json.playableArea.id);
            player.css('height', $(window).height() / 2);
            player.append(json.playableArea.html);
        
            var deck = $('.deck');
            deck.attr('id', json.deck.id);
            
            var grave = $('.graveyard').attr('id', json.graveyard.id);
            grave.droppable({
                accept: '.card',
                drop: function(event, ui) {
                }
            });
            
            $.each(json.update, function(index, elem) {
                
                if(elem.f == 'create') {
                    create(elem.id, elem.idLocation);
                } else if(elem.f == 'image') {
                    image(elem.id, elem.src);
                } else if(elem.f == 'move') {
                    move(elem.id, elem.idDestination);
                } else {
                    alert('Wrong function request');
                }
                
            });
        }
    });
}

$(document).ready(function() {   
    //setInterval(reload, 3000);
    init();
    
//TODO: passar para o init   
//    $('#radial_container').radmenu({
//        listClass: 'list', // the list class to look within for items
//        itemClass: 'item', // the items - NOTE: the HTML inside the item is copied into the menu item
//        radius: 25, // in pixels
//        animSpeed: 400, //in millis
//        selectEvent: 'click', // the select event
//        onSelect: function($selected){
//            //TODO: ... create event...
//            $('#radial_container').hide();
//        },
//        angleOffset: Math.PI // in radians
//    });
});

function create(id, location) {
    if( $('#' + id).length == 0) {
        var image = $(document.createElement('img'));
        $('#appendable').append(image);
        
        image.css('position', 'absolute');
        image.css($('#' + location).position());
        //TODO: ....
        image.css('width', 81);
        image.css('height', 113);
        image.attr('id', id); 
    }
}

function image(id, source) {
    $('#' + id).attr('src', source);
}

function move(id, destination) {
    $('#' + id).animate($('#' + destination).position(), 'slow');
}


function drawCardFromDeck() {
    $.ajax({
        url: 'http://192.168.10.3/wtserver/?quiet',
        dataType: 'jsonp',
        data: {
            'event' : 'cardFromDeck'
        },
        crossDomain: true,
        success: function(json) {
            $.each(json.update, function(index, elem){
                if(elem.f == 'create') {
                    create(elem.id, elem.idLocation);
                } else if(elem.f == 'image') {
                    image(elem.id, elem.src);
                } else if(elem.f == 'move') {
                    move(elem.id, elem.idDestination);
                } else {
                    alert('Wrong function request');
                }
            }); 
            
        }
    });
}