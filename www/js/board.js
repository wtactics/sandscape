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

function init() {
    //TODO: 300...
    $('#board').css('width', $(window).width() - 300);
    
    $.ajax({
        url: '/sandscape/index.php/game/startup/gameId/1/playerId/2',
        dataType: 'json',
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
            
            $('#' + json.opponentArea.id + ' > table').css('height', $(window).height() / 2);
            
            $('#' + json.playableArea.id + ' > table').css('height', $(window).height() / 2);
            $('#' + json.playableArea.id + ' > table td').addClass('dropzone');
            
            $('#' + json.hand.id + ' > table').css('height', '303');
            $('#' + json.hand.id + ' > table td').addClass('dropzone');
            
            var deck = $('.deck');
            deck.attr('id', json.deck.id);
            
            var grave = $('.graveyard').attr('id', json.graveyard.id);
            grave.addClass('dropzone');
            //
            grave.droppable({
                accept: '.card',
                drop: function(event, ui) {
                }
            });
            
            $.each(json.update, function(index, elem) {
                
                if(elem.f == 'create') {
                    createCard(elem.id, elem.idLocation);
                } else if(elem.f == 'image') {
                    defineCardSource(elem.id, elem.src);
                } else if(elem.f == 'move') {
                    moveCard(elem.id, elem.idDestination);
                } else {
                    alert('Wrong function request');
                } 
            });            
        }//END: success
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

function createCard(id, location) {
    if( $('#' + id).length == 0) {
        var image = $(document.createElement('img'));
        $('#appendable').append(image);
        
        image.css('position', 'absolute');
        image.css($('#' + location).position());
        //TODO: ....
        image.css('width', 81);
        image.css('height', 113);
        image.attr('id', id);
       
        image.draggable({
            scroll: false,
            containment: 'window',
            stop: function (event, ui) {
                //ui.offset;
                var moved = false;
                $('.dropzone').each(function(index, cell) {
                    if(ui.offset.left > $(cell).offset().left && ui.offset.left < $(cell).offset().left + $(cell).width()
                        && ui.offset.top > $(cell).offset().top && ui.offset.top < $(cell).offset().top + $(cell).height()) {
                        //
                        moved = true;
                        $.ajax({
                            url: 'http://192.168.10.3/wtserver/?quiet',
                            dataType: 'jsonp',
                            data: {
                                'event' : 'moveCard',
                                'id': ui.helper.attr('id'),
                                'idDestination': cell.id
                            },
                            crossDomain: true,
                            success: function(json) {
                                $.each(json.update, function(index, elem){
                                    if(elem.f == 'create') {
                                        createCard(elem.id, elem.idLocation);
                                    } else if(elem.f == 'image') {
                                        defineCardSource(elem.id, elem.src);
                                    } else if(elem.f == 'move') {
                                        moveCard(elem.id, elem.idDestination);
                                    } else {
                                        alert('Wrong function request');
                                    }
                                });    
                            }
                        });
                    //
                    }
                })
                
                if(!moved) {
                    ui.helper.animate(ui.helper.data('originalPos'), 'fast');
                }
            },
            //END: stop
            start: function (event, ui) {
                ui.helper.data('originalPos', ui.offset);
            }
        });
    }
}

function defineCardSource(id, source) {
    $('#' + id).attr('src', source);
}

function moveCard(id, destination) {
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
                    createCard(elem.id, elem.idLocation);
                } else if(elem.f == 'image') {
                    defineCardSource(elem.id, elem.src);
                } else if(elem.f == 'move') {
                    moveCard(elem.id, elem.idDestination);
                } else {
                    alert('Wrong function request');
                }
            });
        }
    });
}