//Global control variables
//TODO: //NOTE: shouldn't this be placed in a global object for easier control 
//and maintenance
var lastReceived = 0;
var gameRunning = false;
var bUrl;
var chkGameID;
var updGameID;
var updMessagesID;

function initTable(base, messageUpUrl) {
    bUrl = base
    
    //$('#opponent-loader').show();
    pack();
    checkGameStart();
    
    chkGameID = setInterval(checkGameStart, 3000);
//updMessagesID = setInterval(function() {
//    updateMessages(messageUpUrl)
//}, 5000);
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
                //$('#opponent-loader').remove();
                //$('#game-loader').show();
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
                                    src: '_cards/up/thumbs/cardback.jpg'
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
                                    src: '_cards/up/thumbs/noimage.jpg'
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
                            
                            $('#play-area * .grid * td').droppable({
                                drop: function(event, ui) {
                                    moveCard(ui.draggable.attr('id'), $(this).attr('id'));
                                }
                            });
                            
                            var card;
                            for(i = 0; i < create.cards.length; i++) {
                                card = create.cards[i];
                                
                                $(document.createElement('img'))
                                .attr({
                                    id: card.id,
                                    src: '_cards/up/thumbs/' + card.src
                                })
                                .css({
                                    position: 'absolute',
                                    zIndex: 50,
                                    top: $('#' + card.location).offset().top,
                                    left: $('#' + card.location).offset().left
                                })
                                .addClass('card')
                                .draggable({
                                    stack: '.card',
                                    revert: 'invalid'
                                })
                                .dblclick(requestCardInfo)
                                .appendTo($('body'));
                            }
                                                        
                            //Configure and set deck-nob widget
                            $(document.createElement('img')).attr({
                                id: 'deck-nob',
                                src: '_cards/up/thumbs/cardback.jpg'
                            })
                            .css('z-index', 100)
                            .click(deckSlide)
                            .appendTo($('body'));

                            gameRunning = true;
                            //updGameID = setInterval(updateGame, 3000);
                            //$('#game-loader').remove();
                        }
                    }
                });
            }
        }
    });
}

function doGameUpdate(json) {
    if(json.result == 'ok') {
        for(i = 0; i < json.update.length; i++) {
            $('#' + json.update[i].id)
            .animate($('#' + json.update[i].location).offset())
            .attr('src', '_cards/up/thumbs/' + json.update[i].src);
        }
    }
    
}

function updateGame() {
    $.ajax({
        url: bUrl,
        data: {
            event: 'update'
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate
    });
}

function drawCard(deckId) {
    $.ajax({
        url: bUrl,
        data: {
            event: 'drawCard',
            deck: deckId
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate
    });
}

function moveCard(cardId, destinationId) {
    $.ajax({
        url: bUrl,
        data: {
            event: 'moveCard',
            card: cardId,
            location: destinationId
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate
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
                $('#card-info-image').attr('src', '_cards/up/thumbs/' + json.image);
                $('#card-info-states').html(json.states);
                $('#card-info-rules').html(json.rules);
            }
        }
    })
                                
}

function pack() {   
    $('#info-widget').css({
        width: 350,
        height: $(window).height() / 2,
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
        height: $(window).height() / 2,
        top: $(window).height() / 2,
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
function showChat() {
    if($('#chat').position().top == 0) {
        $('#chat').animate({
            top: -255
        });
    } else {
        $('#chat').animate({
            top: 0
        });
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
                    $('#chat-messages').append('<li class="user-message"><span><strong>' + this.name + '</strong>&nbsp;[' 
                        + this.date + ']:</span>' + this.message + '</li>');
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

function inspect() {
    alert('Not implemented yet!');
}