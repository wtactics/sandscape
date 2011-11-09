var globals = {
    chat: {
        lastReceived: 0, 
        updID: 0, 
        sendUrl: '', 
        updateUrl:''
    },
    game: {
        lastChange: 0, 
        running: false, 
        url: '', 
        chkID: 0, 
        updID: 0
    },
    time: new Date(),
    stopPositionUpdate: false,
    updatingGame: false
}

function init() {
    $('#opponent-loader').show();
    
    $('#writemessage').keypress(function(e) {
        if(e.which == 13) {
            sendMessage();
        }
    });
    
    pack();
    checkGameStart();
    globals.chat.updID = setInterval(function() {
        updateMessages(globals.chat.updateUrl);
    }, 5000);
}

function checkGameStart() {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'startGame'
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.result == 'ok') {
                $('#opponent-loader').hide();
                $('#game-loader').show();
                $.ajax({
                    url: globals.game.url,
                    data: {
                        event: 'startUp'
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (json) {                       
                        if(json.result == 'ok') {
                            var create = json.createThis;
                     
                            // tokens
                            var tokenMenu = new Array();
                            $(json.gameInfo.tokens).each(function (i,o) {
                                tokenMenu.push({
                                    option : o.name,
                                    event: function (card) {
                                        toggleCardToken($(card).attr('id'), o.id)
                                    }
                                })
                            })
                     
                            // card states
                            var statesMenu = new Array();
                            $(json.gameInfo.cardStates).each(function (i,o) {
                                statesMenu.push({
                                    option: o.name,
                                    event: function (state) {
                                        toggleCardState($(state).attr('id'), o.id)
                                    }
                                })
                            })
                            
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
                            $('.hand')
                            .attr('id', create.player.hand.id)
                            
                            $('.play')
                            .attr('id', create.player.playableArea.id)

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
                                .appendTo($('body'));
                            }
                     
                            // Cards must be positioned after all cards are in the 
                            // DOM because there are cards 'inside' other cards
                            for(i = 0; i < create.cards.length; i++) {
                                card = create.cards[i];
                                var location = $('#'+card.location);
                        
                                $('#'+card.id).css({
                                    position: 'absolute',
                                    visibility: card.visibility
                                })
                                .css($('#deck-slide').offset())
                                .data('status', card)
                                .addClass('update')
                                .radialmenu({
                                    radius: 60,
                                    options: [ {
                                        option: 'info',
                                        event: function (card) {
                                            requestCardInfo($(card).attr('id'));
                                        }
                                    }, {
                                        option: 'tokens',
                                        subMenu: tokenMenu
                                    }, {
                                        option: 'card states',
                                        subMenu: statesMenu
                                    } ]
                                })
                                .children('img.face').attr('src', '_game/cards/thumbs/' 
                                    + (card.invertY ? 'reversed/' : '') + card.src);
                        
                                updateCardExtras($('#'+card.id));
                            }
                     
                            $('.card').droppable({
                                drop: function (event, ui) {
                                    moveCard(ui.draggable.attr('id'), $(this).attr('id'), 0, .2);
                                    return false;
                                }
                            })
                            $('.play, .hand').droppable({
                                drop: function(event, ui) {
                                    var card = ui.draggable;
                           
                                    var xOffset = (card.offset().left - $(this).offset().left) / $(this).width();
                                    var yOffset = (card.offset().top - $(this).offset().top) / $(this).height();
                           
                                    moveCard(card.attr('id'), $(this).attr('id'), xOffset, yOffset);
                                    return false;
                                }
                            })
                                                        
                            //Configure and set deck-nob widget
                            $(document.createElement('img')).attr({
                                id: 'deck-nob',
                                src: '_resources/images/game-deck-nob.png'
                            })
                            .css('z-index', 100)
                            .click(deckSlide)
                            .appendTo($('body'));

                            globals.game.running = true;
                            $('#game-loader').fadeOut('slow', function () {
                                $('#game-loader').remove();
                            }); 
                     
                            setTimeout(updateGame, 3000);
                            cyclicPositionUpdate();
                        }
                    }
                });
            } else  {
                setTimeout(checkGameStart, 3000);
            }
        },
        error: function () {
            setTimeout(checkGameStart, 3000);
        }, 
        complete: function () {
            $('#game-loader').hide();
        }
    });
}

function updateCardExtras(card) {
    if (card.data('status')){
        card.find('.token').remove();
        for (var i = 0; i < card.data('status').tokens.length; ++i) {
            $(document.createElement('img'))
            .addClass('token')
            .attr('src', '_game/tokens/thumbs/' + (card.data('status').invertY ? 'reversed/' : '') 
                + card.data('status').tokens[i].src)
            .appendTo(card);
        }
      
        card.find('.state').remove();
        for(i = 0; i<card.data('status').states.length; ++i) {
            $(document.createElement('img'))
            .addClass('state')
            .attr('src', '_game/states/thumbs/' + (card.data('status').invertY ? 'reversed/' : '') 
                + card.data('status').states[i].src)
            .appendTo(card);
        }
    }
}

function cyclicPositionUpdate() {
    if (!globals.stopPositionUpdate){
        $('.update').each(function (i, o) {
            o = $(o);
      
            if (o.data('status')  &&  !o.hasClass('ui-draggable-dragging')  
                &&  !o.is(':animated')  &&  o.data('status').visibility == 'visible') {
                var data = o.data('status');
                var location = $('#'+data.location);
                var top;
                var left = location.offset().left + Math.round(data.xOffset * location.width());
                
                if (!o.data('status').invertY) top = location.offset().top + Math.round(data.yOffset * location.height());
                else top = location.offset().top + Math.round((1 - o.data('status').yOffset) * location.height()) - o.height();
                
                o.animate({
                    top: top+'px',
                    left: left+'px'
                }, 500)
               
                if ($('.ui-draggable-dragging').length == 0) {
                    o.css({
                        zIndex: o.data('status').zIndex
                    });
                }
            }
        });         
    }
    setTimeout(cyclicPositionUpdate, 300);
}

function doGameUpdate(json) {
    if(json.result == 'ok'  &&  parseInt(json.clientTime) == globals.time.getTime()) {
        if (json.lastChange) globals.game.lastChange = json.lastChange;
 
        for(var i = 0; i < json.update.length; i++) {
            $('#' + json.update[i].id).data('status', json.update[i]);
            if(!$('#' + json.update[i].id).hasClass('update')) $('#' + json.update[i].id).addClass('movable');
         
         
            $('#' + json.update[i].id)
            .css({
                zIndex: json.update[i].zIndex,
                visibility: json.update[i].visibility
            })
            .children('img.face').attr('src',  '_game/cards/thumbs/' + (json.update[i].invertY ? 'reversed/' : '') 
                + json.update[i].src);
         
            updateCardExtras($('#' + json.update[i].id));
        }
    }
    globals.updatingGame = false;
}


function updateGame() {
    globals.time = new Date();
    if (!globals.updatingGame  &&  parseInt($.active) == 0  &&  $('.ui-draggable-dragging').length == 0){
        globals.updatingGame = true;
        $.ajax({
            url: globals.game.url,
            data: {
                event: 'update',
                // TODO: Solve the sync problems; lastChange will still disabled until then
                lastChange: globals.game.lastChange,
                clientTime: globals.time.getTime()
            },
            dataType: 'json',
            type: 'POST',
            success: doGameUpdate,
            complete: function () { 
                setTimeout(updateGame, 3000);
            }
        });
    }
    else setTimeout(updateGame, 3000);
}


function toggleCardToken(cardId, tokenId){
    globals.updatingGame = true;
    globals.time = new Date();
    if ($('.ui-draggable-dragging').length == 0) {
        $.ajax({
            url: globals.game.url,
            data: {
                event: 'toggleCardToken',
                card: cardId,
                token: tokenId,
                clientTime: globals.time.getTime()
            },
            dataType: 'json',
            type: 'POST',
            success: doGameUpdate
        })
    }
}

function toggleCardState(cardId, stateId) {
    globals.updatingGame = true;
    globals.time = new Date();
    if ($('.ui-draggable-dragging').length == 0) {
        $.ajax({
            url: globals.game.url,
            data: {
                event: 'toggleCardState',
                card: cardId, 
                state: stateId,
                clientTime: globals.time.getTime()
            },
            dataType: 'json',
            type: 'POST',
            success: doGameUpdate
        })
    }
}

function drawCard(deckId) {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'drawCard',
            deck: deckId,
            clientTime: globals.time.getTime()
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate,
        complete: function () {
            globals.stopPositionUpdate = false;
        }
    });
}

function moveCard(cardId, destinationId, xOffset, yOffset) {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'moveCard',
            card: cardId,
            location: destinationId,
            xOffset: xOffset,
            yOffset: yOffset,
            clientTime: globals.time.getTime()
        },
        dataType: 'json',
        type: 'POST',
        success: doGameUpdate,
        complete: function () {
            globals.stopPositionUpdate = false;
        }
    });
}

function requestCardInfo(id) {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'cardInfo',
            card: id
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.success) {
            //TODO: show image, states and tokens
            } else {
                $('#card-image').attr('src', '_game/cards/cardback.jpg');
            }
        }
    })
}

function pack() {
    $('#left-column').css({
        height: $(window).height(),
        top: 0,
        left: 0,
        position: 'absolute'
    });
    $('.hand').css({
        height: $(window).height() - 543
    });  
    
    $('.opponent-area').css({
        width: $(window).width() - 270,
        height: $(window).height() / 2,
        top: 0,
        left: 250,
        position: 'absolute'
    });
    
    $('.play').css({
        width: $(window).width() - 270,
        height: $(window).height() / 2,
        top: $(window).height() / 2,
        left: 270,
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
    if(globals.game.running) {
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

function sendMessage(e) {
    var message = $("#writemessage").val();
    if(message.length > 0) {
        $.ajax({
            type: "POST",
            url: globals.chat.sendUrl,
            data: {
                'gamemessage': message
            },
            dataType: 'json',
            success: function(json) {
                if(json.success) {
                    $('#chat-messages').append('<li class="user-message"><span><strong>' + json.name + '</strong>&nbsp;[' 
                        + json.date + ']:</span>' + message + '</li>');
                    
                    globals.chat.lastReceived = json.id;
                    updateMessageScroll();
                }
            }
        });
        $("#writemessage").val('');
    }
}

function updateMessages() {
    $.ajax({
        type: "POST",
        url: globals.chat.updateUrl,
        data: {
            'lastupdate': globals.chat.lastReceived
        },
        dataType: 'json',
        success: function(json) {
            if(json.has) {
                $.each(json.messages, function() {
                    $('#chat-messages').append('<li class="user-message"><strong>' + this.name + '</strong>:' 
                        + this.message + '</li>');
                });

                globals.chat.lastReceived = json.last;
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

function roll(dice) {
    $.ajax({
        url: globals.game.url,
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
