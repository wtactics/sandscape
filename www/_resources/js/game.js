var globals = new function() {
//TODO: move globals here
}

//Global control variables
//TODO: //NOTE: shouldn't this be placed in a global object for easier control 
//and maintenance
var lastChange = 0;
var lastReceived = 0;
var gameRunning = false;
var bUrl;
var chkGameID;
var updGameID;
var updMessagesID;
var clientTime = new Date();
var stopPositionUpdate = false;

function initTable(base, messageUpUrl) {
    bUrl = base
    
    $('#opponent-loader').show();
    pack();
    $('#card-info-image').dblclick(function(e){
        alert('Not implemented yet!');
    });
    checkGameStart();
    
    chkGameID = setInterval(checkGameStart, 3000);
    updMessagesID = setInterval(function() {
        updateMessages(messageUpUrl)
    }, 5000);
}

function checkGameStart() {
    $.ajax({
        url: bUrl,
        data: {
            event: 'startGame'
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.result == 'ok') {
                $('#opponent-loader').remove();
                $('#game-loader').show();
                clearInterval(chkGameID);
                $.ajax({
                    url: bUrl,
                    data: {
                        event: 'startUp'
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (json) {                       
                        if(json.result == 'ok') {
                            var create = json.createThis;
                            
                            //set void object
                            $(document.createElement('div')).attr({
                                id: create.nowhere.id
                            })
                            .css({
                                visibility: 'hidden',
                                position: 'absolute',
                                top: -200,
                                left: -200
                            })
                            .appendTo($('body'));
    
                            //Player area: left hand, decks and play zone
                            $('.hand').html(create.player.hand.html).attr('id', create.player.hand.id);
                            $('.hand > table').css({
                                height: $('.hand').height()
                            });
                            
                            
                            $('.play').html(create.player.playableArea.html).attr('id', create.player.playableArea.id);
                            $('.play > table').css({
                                height: $('.play').height()
                            });

                            for(i = 0; i < create.player.decks.length; i++) {
                                $(document.createElement('img'))
                                .attr({
                                    id: create.player.decks[i].id, 
                                    src: '_game/cards/thumbs/cardback.jpg'
                                })
                                .data('deck-name', create.player.decks[i].name)
                                .click(function() {
                                    drawCard($(this).attr('id'));
                                })
                                .appendTo($('#deck-slide'));
                            }
                            
                            if(create.player.graveyard) {
                                $(document.createElement('img'))
                                .attr({
                                    id: create.player.graveyard.id,
                                    src: '_game/cards/thumbs/noimage.jpg'
                                })
                                .data('deck-name', 'Graveyard')
                                .appendTo($('#deck-slide'));
                            }
                            
                            //Configure deck widgets
                            //Define positions for existing decks
                            $('#deck-slide').children('img').each(function(index) {
                                $(this).css({
                                    left: index * 85, 
                                    top: 0,
                                    position: 'absolute'
                                });
                            })
                            
                            //Opponent area (top window zone)
                            $('.opponent-area').attr('id', create.opponent.playableArea.id)
                            .html(create.opponent.playableArea.html);
                            
                            $('.opponent-area > table').css({
                                height: $('.opponent-area').height() 
                            });
                        
                     
                            var card;
                            for(i = 0; i < create.cards.length; i++) {
                                card = create.cards[i];
                                
                                $(document.createElement('div'))
                                .html('<img class="face" />')
                                .attr({
                                    id: card.id
                                })
                                .addClass('card')
                                .draggable({
                                    stack: '.card',
                                    revert: 'invalid'
                                })
                                .dblclick(requestCardInfo)
                                .appendTo($('body'));
                            }
                            // Cards must be positioned after all cards are in the DOM because there are cards 'inside' other cards
                            for(i = 0; i < create.cards.length; i++) {
                                card = create.cards[i];
                                $('#'+card.id).css({
                                    position: 'absolute',
                                    visibility: card.visibility
                                })
                                .css($('#'+card.location).offset())
                                .data('status', card)
                                .addClass('update')
                                .children('img.face').attr('src', '_game/cards/thumbs/' + card.src);
                        
                                updateCardExtras($('#'+card.id));
                            }
                            $('.card').droppable({
                                drop: function (event, ui) {
                                    moveCard(ui.draggable.attr('id'), $(this).attr('id'));
                                    return false;
                                }
                            });
                     
                         
                            $('#play-area * .grid').droppable({
                                drop: function(event, ui) {
                                    var card = ui.draggable;
                                    $(this).find('td').each(function (i, o) {
                                        o = $(o);
                                        if (                                 
                                            card.offset().left >= o.offset().left - 1 &&  
                                            card.offset().left < o.offset().left + o.width() + 2  &&  
                                            card.offset().top >= o.offset().top - 1 && 
                                            card.offset().top < o.offset().top + o.height() + 2
                                            ) {
                                            moveCard(ui.draggable.attr('id'), o.attr('id'));
                                            return false;
                                        }
                                    });
                                }
                            });
                                                        
                            //Configure and set deck-nob widget
                            $(document.createElement('img')).attr({
                                id: 'deck-nob',
                                src: '_resources/images/game-deck-nob.png'
                            })
                            .css('z-index', 100)
                            .click(deckSlide)
                            .appendTo($('body'));

                            gameRunning = true;
                            $('#game-loader').fadeOut('slow', function () {
                                $('#game-loader').remove();
                            }); 
                     
                            setTimeout(updateGame, 3000);
                            cyclicPositionUpdate();
                        }
                    }
                });
            }
        }
    });
}

function updateCardExtras(card) {
    if (card.data('status')){
        card.find('.token').remove();
        for (var i = 0; i < card.data('status').tokens.length; ++i) {
            $(document.createElement('img'))
            .addClass('token')
            .attr('src', '_game/tokens/thumbs/' + card.data('status').tokens[i].src)
            .appendTo(card);
        }
      
        card.find('.state').remove();
        for(var i=0; i<card.data('status').states.length; ++i) {
            $(document.createElement('img'))
            .addClass('state')
            .attr('src', '_game/states/thumbs/' + card.data('status').states[i].src)
            .appendTo(card);
        }
    }
}

function cyclicPositionUpdate() {
    if (!stopPositionUpdate){
        $('.update').each(function (i, o) {
            o = $(o);
      
            if (o.data('status')  &&  !o.hasClass('ui-draggable-dragging')  &&  !o.is(':animated')  &&  o.data('status').visibility == 'visible')
            {
                var location = $('#'+o.data('status').location);
                var top = location.offset().top + (o.data('status').offsetHeight ? 20 : 0);
                var left = location.offset().left;
            
                if (o.offset().top != top  ||  o.offset().left != left) {
                    o.animate({
                        top: top+'px',
                        left: left+'px'
                    }, 300);
               
                    o.css({
                        zIndex: o.data('status').zIndex
                    });
                }
            }         
        });
    }  
    setTimeout(cyclicPositionUpdate, 200);
}

function doGameUpdate(json) {
    if(json.result == 'ok'  &&  parseInt(json.clientTime) == clientTime.getTime()) {
        if (json.lastChange) lastChange = json.lastChange;
 
        for(i = 0; i < json.update.length; i++) {
            $('#' + json.update[i].id).data('status', json.update[i]);
            if(!$('#' + json.update[i].id).hasClass('update')) $('#' + json.update[i].id).addClass('movable');
         
         
            $('#' + json.update[i].id)
            .css({
                zIndex: json.update[i].zIndex,
                visibility: json.update[i].visibility
            })
            .children('img.face').attr('src',  '_game/cards/thumbs/' + json.update[i].src);
         
            updateCardExtras($('#' + json.update[i].id));
        }
    }
}


function updateGame() {
    clientTime = new Date();
    if ($('.ui-draggable-dragging').length == 0){
        $.ajax({
            url: bUrl,
            data: {
                event: 'update',
                lastChange: lastChange,
                clientTime: clientTime.getTime()
            },
            dataType: 'json',
            type: 'POST',
            success: doGameUpdate,
            complete: function () { 
                setTimeout(updateGame, 3000);
            }
        });
    }
}

function drawCard(deckId) {
    stopPositionUpdate = true;
    clientTime = new Date();
    $.ajax({
        url: bUrl,
        data: {
            event: 'drawCard',
            deck: deckId,
            clientTime: clientTime.getTime()
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate,
        complete: function () {
            stopPositionUpdate = false;
        }
    });
}

function moveCard(cardId, destinationId) {
    stopPositionUpdate = true;
    clientTime = new Date();
    $.ajax({
        url: bUrl,
        data: {
            event: 'moveCard',
            card: cardId,
            location: destinationId,
            clientTime: clientTime.getTime()
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate,
        complete: function () {
            stopPositionUpdate = false;
        }
    });
}

function requestCardInfo(e) {
    $.ajax({
        url: bUrl,
        data: {
            event: 'cardInfo',
            card: $(this).attr('id')
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.success) {
                $('#card-info-name').html(json.name);
                $('#card-info-image').attr('src', '_game/cards/thumbs/' + json.image);
                $('#card-info-states').html(json.states);
                $('#card-info-rules').html(json.rules);
            }
        }
    })
                                
}

function pack() {   
    $('#info-widget').css({
        width: 350,
        height: $(window).height() * 0.65,
        top: 0,
        left: 0,
        position: 'absolute'
    });
    $('.opponent-area').css({
        width: $(window).width() - 350,
        height: $(window).height() / 2,
        top: 0,
        left: 350,
        position: 'absolute'
    });
    
    $('.hand').css({
        width: 350,
        height: $(window).height() * 0.35,
        top: $(window).height() * 0.65,
        left: 0,
        position: 'absolute'
    });  
    
    $('.play').css({
        width: $(window).width() - 350,
        height: $(window).height() / 2,
        top: $(window).height() / 2,
        left: 350,
        position: 'absolute'
    });
}

function bubbles() {   
    $('#deck-slide img').CreateBubblePopup({
        position: 'top',
        align: 'center',
        tail: {
            align: 'center'
        },

        themeName: 'all-black',
        themePath: '_resources/images/jqBubblePopup',
        alwaysVisible: false,
        closingDelay: 100
    });
    
    var text;
    $('#deck-slide img').each(function(index) {
        text = $(this).data('deck-name');
        
        if(text.length == 0) {
            text = 'Unknown Deck';
        }
        $(this).SetBubblePopupInnerHtml(text);
    })
}

function deckSlide (event) {
    if(gameRunning) {
        if($('#deck-widget').width() > 0) {
            $('#deck-slide img').each(function() {
                if( $(this).HasBubblePopup() ){
                    $(this).RemoveBubblePopup();
                }
            });    
       
            $('#deck-widget').animate({
                width: 0
            });
        } else {
            $('#deck-widget').animate({
                width: $('#deck-slide').children('img').length * 85
            }, function() {
                bubbles();
            });
        }
    }
}

function sendMessage(destination) {
    var message = $("#writemessage").val();
    if(message.length > 0) {
        $.ajax({
            type: "POST",
            url: destination,
            data: {
                'gamemessage': message
            },
            dataType: 'json',
            success: function(json) {
                if(json.success) {
                    $('#chat-messages').append('<li class="user-message"><span><strong>' + json.name + '</strong>&nbsp;[' 
                        + json.date + ']:</span>' + message + '</li>');
                    
                    lastReceived = json.id;
                    updateMessageScroll();
                }
            }
        });
        $("#writemessage").val('');
    }
}

function updateMessages(destination) {
    $.ajax({
        type: "POST",
        url: destination,
        data: {
            'lastupdate': lastReceived
        },
        dataType: 'json',
        success: function(json) {
            if(json.has) {
                $.each(json.messages, function() {
                    $('#chat-messages').append('<li class="user-message"><strong>' + this.name + '</strong>:' 
                        + this.message + '</li>');
                });

                lastReceived = json.last;
                updateMessageScroll();
            }
        }
    });
}

function updateMessageScroll() {
    $('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
}

function filterChatMessages(elem) {
    if(elem.id == 'fshow-all') {
        $('li.user-message').show();
        $('li.user-system').show();
    } else if(elem.id == 'fshow-user') {
        $('li.user-message').show();
        $('li.user-system').hide();
    } else if(elem.id == 'fshow-system') {
        $('li.user-message').hide();
        $('li.user-system').show();
    }    
}

function lost() {
    alert('Not implemented yet!');
}

function roll(dice) {
    $.ajax({
        url: bUrl,
        data: {
            event: 'roll',
            dice: dice
        },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if(json.success) {
                $('#chat-messages').append('<li class="system-message">' + json.user + 
                    'rolled ' + json.dice + '(1, ' + json.face + '): ' + json.roll + '</li>');
            } else {
                $('#chat-messages').append('<li class="system-message">Dice roll failed.</li>');
            }
        }
    });
}