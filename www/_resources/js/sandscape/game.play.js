/* game.play.js
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */
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
    updatingGame: false,
    user: ''
}

function init() {
    $('#writemessage').keypress(sendMessage);
    $('#menu-slider').click(menuSlide);
    $('#menu-header').click(menuSlide);
    
    $('#opponent-loader').show();
    
    //start game creation
    pack();
    checkGameStart();
    setTimeout(updateMessages, 1000);
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
                            var create = json.createThis, tokenMenu = new Array(), statesMenu = new Array(),
                            card, i, id, left, right, decks, dest = $('#decks'), opts, useGrave;
                            
                            // tokens
                            $(json.gameInfo.tokens).each(function (i,o) {
                                tokenMenu.push({
                                    option : o.name,
                                    event: function (card) {
                                        toggleCardToken($(card).attr('id'), o.id)
                                    }
                                })
                            })
                     
                            // card states
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

                            decks = create.player.decks;
                            for(i = 0; i < decks.length; i++) {
                                id = decks[i].id;
                                                             
                                left = $(document.createElement('div'))
                                .addClass('deck-info-left');
                               
                                right = $(document.createElement('div'))
                                .addClass('deck-info-right');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(function(e) {
                                    drawCard(id);
                                })
                                .html('Draw to Hand')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(function(e) {
                                    drawCardToTable(id);
                                })
                                .html('Draw to Table')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(function(e) {
                                    shuffleDeck(id);
                                })
                                .html('Shuffle')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('img'))
                                .attr({
                                    id: decks[i].id, 
                                    src: '_game/cards/thumbs/cardback.jpg'
                                })
                                .appendTo(right);
                                
                                $(document.createElement('div'))
                                .addClass('deck-info')
                                .append('<h3>' + decks[i].name + '</h3>')
                                .append(left)
                                .append(right)                             
                                .appendTo(dest);
                                
                                dest.append('<div class="clearfix"></div>');
                            }
                            
                            if(create.player.graveyard) {                                                             
                                left = $(document.createElement('div'))
                                .addClass('deck-info-left');
                               
                                right = $(document.createElement('div'))
                                .addClass('deck-info-right');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(drawFromGraveyard)
                                .html('Draw to Hand')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(drawFromGraveyardToTable)
                                .html('Draw to Table')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('a'))
                                .attr('href', 'javascript:;')
                                .click(shuffleGraveyard)
                                .html('Shuffle')
                                .appendTo(left);
                                left.append('<br />');
                               
                                $(document.createElement('img'))
                                .attr({
                                    id: create.player.graveyard.id,
                                    src: '_game/cards/thumbs/noimage.jpg'
                                })
                                .appendTo(right);
                                
                                $(document.createElement('div'))
                                .addClass('deck-info')
                                .append('<h3>Graveyard</h3>')
                                .append(left)
                                .append(right)                             
                                .appendTo(dest);
                                
                                dest.append('<div class="clearfix"></div>');
                            }
                                                        
                            //Opponent area (top window zone)
                            $('.opponent-area').attr('id', create.opponent.playableArea.id)
                     
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
                                .append($(document.createElement('div'))
                                    .addClass('label'))
                                .appendTo($('body'));
                            }
                     
                            // Cards must be positioned after all cards are in the 
                            // DOM because there are cards 'inside' other cards
                            useGrave = (create.player.graveyard != null);
                            for(i = 0; i < create.cards.length; i++) {
                                card = create.cards[i];
                                
                                opts = [{
                                    //details
                                    option: '<img src="_resources/images/icon-x16-eye.png" title="Card Details" />',
                                    event: function (card) {
                                        requestCardInfo($(card).attr('id'));
                                    }
                                }, {
                                    //tokens
                                    option: '<img src="_resources/images/icon-x16-bookmarks.png" title="Tokens" />',
                                    subMenu: tokenMenu
                                }, {
                                    //states
                                    option: '<img src="_resources/images/icon-x16-hand-state.png" title="States" />',
                                    subMenu: statesMenu
                                }, {
                                    //flip the card
                                    option: '<img src="_resources/images/icon-x16-flip" title="Flip Card" />',
                                    event: function(card) {
                                        flipCard($(card).attr('id'));
                                    }
                                }, {
                                    //edit label
                                    option: '<img src="_resources/images/icon-x16-label.png" title="Custom Label" />',
                                    event: function (card) {
                                        $('#label-text').val($(card).find('.label').html());
                                        $('#label-card-id').val($(card).attr('id'));
                                        $('#label-dlg').modal();
                                    }
                                }]
                            
                                if(useGrave) {
                                    opts.push({
                                        //send card to graveyard
                                        option: '<img src="_resources/images/icon-x16-headstone.png" title="Send to Graveyard" />',
                                        event: function(card) {
                                            moveToGraveyard($(card).attr('id'));
                                        }
                                    });
                                }
                        
                                $('#'+card.id).css({
                                    position: 'absolute',
                                    visibility: card.visibility
                                })
                                .css({
                                    top: 350, 
                                    left: -250
                                })
                                .data('status', card)
                                .addClass('update')
                                .radialmenu({
                                    radius: 60,
                                    options: opts
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
                            });
                            
                            $('.play, .hand').droppable({
                                drop: function(event, ui) {
                                    var card = ui.draggable, xOffset, yOffset, me = $(this);
                           
                                    xOffset= (card.offset().left - me.offset().left) / me.width();
                                    yOffset = (card.offset().top - me.offset().top) / me.height();
                           
                                    moveCard(card.attr('id'), me.attr('id'), xOffset, yOffset);
                                    return false;
                                }
                            });

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
        var i;
        card.find('.token').remove();
        for (i = 0; i < card.data('status').tokens.length; ++i) {
            $(document.createElement('img'))
            .addClass('token')
            .attr('src', '_game/tokens/thumbs/' + (card.data('status').invertView ? 'reversed/' : '') 
                + card.data('status').tokens[i].src)
            .appendTo(card);
        }
      
        card.find('.state').remove();
        for(i = 0; i < card.data('status').states.length; ++i) {
            $(document.createElement('img'))
            .addClass('state')
            .attr('src', '_game/states/thumbs/' + (card.data('status').invertView ? 'reversed/' : '') 
                + card.data('status').states[i].src)
            .appendTo(card);
        }
        
        card.find('.label')
        .css('display', card.data('status').label ? '' : 'none')
        .html(card.data('status').label);
    }
}

function cyclicPositionUpdate() {
    if (!globals.stopPositionUpdate){
        $('.update').each(function (i, o) {
            o = $(o);
      
            if (o.data('status')  &&  !o.hasClass('ui-draggable-dragging')  
                &&  !o.is(':animated')  &&  o.data('status').visibility == 'visible') {
                var data = o.data('status'), location = $('#'+data.location), top, left;
                
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
                // TODO: Solve the sync problems; lastChange will still disabled 
                // until then: lastChange: globals.game.lastChange,
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
                var owner = $('#card-info'), i;
                $('#card-image').attr('src', '_game/cards/' + json.status.src);
                for(i = 0; i < json.status.tokens.length; i++) {
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
                
                owner.find('.big-label')
                .css('display', json.status.label ? '' : 'none')
                .html(json.status.label);
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

function sendMessage(e) {
    if(e.keyCode == 13) {
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
                        //TODO: add message received from server
                        //$('#chat-messages').append('<li class="user-message"><strong>' 
                        //    + json.name + '</strong>:' + message + '</li>');
                    
                        globals.chat.lastReceived = json.id;
                        chatToBottom();
                    }
                }
            });
            $("#writemessage").val('');
        }
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
                chatToBottom();
            }
        },
        complete: function() {
            setTimeout(updateMessages, 5000);
        }
        
    });
}

function sliderSetValue(event, ui) {
    $('#chat-slider').slider('option', 'value', -($('#chat-messages').height() - 130));
}

function chatToBottom() {
    var sl = $('#chat-slider'), cm = $('#chat-messages'), h = -(cm.height() - 130);
    
    sl.slider('option', 'min', h).slider('option', 'value', h);
    
    cm.animate({
        top: sl.slider('option', 'value')
    }, 'slow');
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
                $.jGrowl(json.dice + ' rolled for (1 - ' + json.face + '): '+ json.roll);
            }
        }
    });
}

function sliderChange(e, ui) {
    $('#chat-messages').css({
        top: ui.value
    });
}

function sliderScroll(e, ui) {   
    $('#chat-messages').css({
        top: ui.value
    });
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
            $.jGrowl('Deck shuffled.');
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

function menuSlide() {
    if(globals.game.running) {
        var wrapper = $('#menu-wrapper');
        if(wrapper.width() > 0) {       
            wrapper.animate({
                width: 0
            });
            $('#menu-slider').animate({
                right: 0
            });
        } else {
            wrapper.animate({
                width: 250
            });
            $('#menu-slider').animate({
                right: 250
            });
        }
    }
}

function setLabel() {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'label',
            card: $('#label-card-id').val(),
            label: $('#label-text').val(),
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

function moveToGraveyard(cardId) {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'toGraveyard',
            card: cardId,
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

function drawFromGraveyard() {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'fromGraveyard',
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

function drawFromGraveyardToTable() {
    globals.updatingGame = true;
    globals.stopPositionUpdate = true;
    globals.time = new Date();
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'fromGraveyardToTable',
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

function shuffleGraveyard() {
    $.ajax({
        url: globals.game.url,
        data: {
            event: 'shuffleGraveyard'
        },
        dataType: 'json',
        type: 'POST',
        success: function (json) {
            $.jGrowl('Graveyard shuffled.');
        }
    });    
}