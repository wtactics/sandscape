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
    $('#writemessage').keypress(function(e) {
        if(e.which == 13) {
            sendMessage();
        }
    });
    
    //create game menu: slider hidden in the right
    $('#menu-slider').data('on', false).click(function(e) {
        if($(this).data('on')) {
            //menu is visible: slide menu up, slide menu image right
            $('#menu-elements').slideToggle(100, function() {
                $('#game-menu').animate({
                    right: -170
                });
                //mark as hidden
                $('#menu-slider').data('on', false);
            });
        } else {
            //menu is hidden: slide menu image left, slide menu down
            $('#game-menu').animate({
                right: 0
            }, 'slow', function() {
                $('#menu-elements').slideToggle(100);
                //mark as visible
                $('#menu-slider').data('on', true);
            });
        }
    });   
    
    //start game creation
    $('#opponent-loader').show();
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
                            $('.hand').attr('id', create.player.hand.id)
                            $('.play').attr('id', create.player.playableArea.id)

                            for(i = 0; i < create.player.decks.length; i++) {
                                $(document.createElement('img'))
                                .attr({
                                    id: create.player.decks[i].id, 
                                    src: '_game/cards/thumbs/cardback.jpg'
                                })
                                .data('deck-name', create.player.decks[i].name)
                                .radialmenu({
                                    radius: 30,
                                    options: [{
                                        //draw card to hand
                                        option: '<img src="_resources/images/icon-x16-hand.png" alt="Draw to Hand" />',
                                        event: function(deck) {
                                            drawCard($(deck).attr('id'));
                                        }
                                    },{
                                        //shuffle
                                        option: '<img src="_resources/images/icon-x16-suffle.png" alt="Suffle Deck" />',
                                        event: function(deck) {
                                            shuffleDeck($(deck).attr('id'));
                                        }
                                    }, {
                                        //draw card to table
                                        option: '<img src="_resources/images/icon-x16-hand-table.png" alt="Draw to Table" />',
                                        event: function(deck) {
                                            drawCardToTable($(deck).attr('id'));
                                        }
                                    }]
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
                                //TODO: graveyard actions
                                .radialmenu({
                                    radius: 30,
                                    options: [{
                                        //draw card to hand
                                        option: '<img src="_resources/images/icon-x16-hand.png" alt="Draw to Hand" />',
                                        event: function(graveyard) {
                                        //drawCard($(deck).attr('id'));
                                        }
                                    },{
                                        //shuffle
                                        option: '<img src="_resources/images/icon-x16-suffle.png" alt="Suffle Deck" />',
                                        event: function(graveyard) {
                                        //shuffleDeck($(deck).attr('id'));
                                        }
                                    }, {
                                        //draw card to table
                                        option: '<img src="_resources/images/icon-x16-hand-table.png" alt="Draw to Table" />',
                                        event: function(graveyard) {
                                        //drawCardToTable($(deck).attr('id'));
                                        }
                                    }]
                                })
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
                        
                                $('#'+card.id).css({
                                    position: 'absolute',
                                    visibility: card.visibility
                                })
                                .css($('#deck-slide').offset())
                                .data('status', card)
                                .addClass('update')
                                .radialmenu({
                                    radius: 60,
                                    options: [{
                                        //details
                                        option: '<img src="_resources/images/icon-x16-eye.png" />',
                                        event: function (card) {
                                            requestCardInfo($(card).attr('id'));
                                        }
                                    }, {
                                        //tokens
                                        option: '<img src="_resources/images/icon-x16-bookmarks.png" />',
                                        subMenu: tokenMenu
                                    }, {
                                        //states
                                        option: '<img src="_resources/images/icon-x16-hand-state.png" />',
                                        subMenu: statesMenu
                                    }, {
                                        //give card to opponent
                                        option: '<img src="_resources/images/icon-x16-hand-give.png" />',
                                        event: function(card) {
                                            alert('Give not implemented yet!');
                                        }
                                    }, {
                                        //send card to graveyard
                                        option: '<img src="_resources/images/icon-x16-headstone.png" />',
                                        event: function(card) {
                                            alert('Graveyard not implemented yet!');
                                        }
                                    }, {
                                        //flip the card
                                        option: '<img src="_resources/images/icon-x16-flip" />',
                                        event: function(card) {
                                            flipCard($(card).attr('id'));
                                        }
                                    }, {
                                        //edit label
                                        option: '<img src="_resources/images/icon-x16-label.png" />',
                                        event: function (card) {
                                            alert('Label not implemented yet!');
                                        }
                                    }]
                                })
                                .children('img.face').attr('src', '_game/cards/thumbs/' 
                                    + (card.invertView ? 'reversed/' : '') + card.src);
                        
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
                            setTimeout(updateGame, 3000);
                            cyclicPositionUpdate();
                            
                            $('#game-loader').fadeOut('slow', function () {
                                $('#game-loader').remove();
                            });
                        }
                    }
                });
            } else  {
                setTimeout(checkGameStart, 3000);
            }
        },
        error: function () {
            setTimeout(checkGameStart, 3000);
        }
    });
}

function updateCardExtras(card) {
    if (card.data('status')){
        card.find('.token').remove();
        for (var i = 0; i < card.data('status').tokens.length; ++i) {
            $(document.createElement('img'))
            .addClass('token')
            .attr('src', '_game/tokens/thumbs/' + (card.data('status').invertView ? 'reversed/' : '') 
                + card.data('status').tokens[i].src)
            .appendTo(card);
        }
      
        card.find('.state').remove();
        for(i = 0; i<card.data('status').states.length; ++i) {
            $(document.createElement('img'))
            .addClass('state')
            .attr('src', '_game/states/thumbs/' + (card.data('status').invertView ? 'reversed/' : '') 
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
                var left;
                
                if (!o.data('status').invertView) {
                    top = location.offset().top + Math.round(data.yOffset * location.height());
                    left = location.offset().left + Math.round(data.xOffset * location.width());
                }
                else {
                    top = location.offset().top + Math.round((1 - o.data('status').yOffset) * location.height()) - o.height();
                    left = location.offset().left + Math.round((1 - o.data('status').xOffset) * location.width()) - o.width();
                }
                    
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
            .children('img.face').attr('src',  '_game/cards/thumbs/' + (json.update[i].invertView ? 'reversed/' : '') 
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
                //                lastChange: globals.game.lastChange,
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
            $('#card-info .temp').remove();
            if(json.success) {
                var owner = $('#card-info');
                $('#card-image').attr('src', '_game/cards/' + json.status.src);
                for(var i = 0; i < json.status.tokens.length; i++) {
                    $(document.createElement('img'))
                    .addClass('temp')
                    .css('z-index', 1)
                    .attr('src', '_game/tokens/' + json.status.tokens[i].src)
                    .appendTo(owner);
                }
                
                for(i = 0; i < json.status.states.length; i++) {
                    $(document.createElement('img'))
                    .addClass('temp')
                    .css('z-index', -1)
                    .attr('src', '_game/states/' + json.status.states[i].src)
                    .appendTo(owner);
                }
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
        left: 270,
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
                    $('#chat-messages').append('<li class="user-message"><strong>' 
                        + json.name + '</strong>:' + message + '</li>');
                    
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
                    $('#chat-messages').append('<li class="user-message"><strong>' 
                        + this.name + '</strong>:' + this.message + '</li>');
                });

                globals.chat.lastReceived = json.last;
                updateMessageScroll();
            }
        }
    });
}

function updateMessageScroll() {
//$('#chat-messages').scrollTop($('#chat-messages')[0].scrollHeight);
}

function filterChatMessages(filter) {
    switch(filter) {
        case 0:
            $('li.user-message').show();
            $('li.user-system').show();
            break;
        case 1:
            $('li.user-message').show();
            $('li.user-system').hide();
            break;
        case 2:
            $('li.user-message').hide();
            $('li.user-system').show();
    }
}

function roll(diceId) {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'roll',
            dice: diceId
        },
        type: 'POST',
        dataType: 'json',
        success: function(json) {
            if(json.success) {
                alert('Rolled ' + json.roll);
                //$('#chat-messages').append('<li class="system-message">' + json.user + 
                //    'rolled ' + json.dice + '(1, ' + json.face + '): ' + json.roll + '</li>');
            } else {
                //$('#chat-messages').append('<li class="system-message">Dice roll failed.</li>');
            }
        }
    });
}

function scrollMessages(event, ui) {
}

function exit() {
}

function flipCard(id) {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'flipCard',
            card: id
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.success) {
                $('#' + id).attr('src', '_game/cards/thumbs/' 
                    + (json.status.invertView ? 'reversed/' : '') + json.status.src);
            }
        }
    });
}

function shuffleDeck(deckId) {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'shuffleDeck',
            deck: deckId
        },
        dataType: 'json',
        type: 'POST',
        success: function (json) {
        //alert(json.success);
        //TODO: warn users with jGrowl and chat message
        }
    });   
}

function drawCardToTable(deckId) {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'drawCardToTable',
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