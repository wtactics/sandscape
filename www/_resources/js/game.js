//Global control variables
//TODO: //NOTE: shouldn't this be placed in a global object for easier control 
//and maintenance
var gameRunning = false;
var bUrl;
var chkGameID;
var updGame;

function initTable(base) {
    bUrl = base;
    
    pack();
    checkGameStart();
    
    chkGameID = setInterval(checkGameStart, 3000);
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
            console.log('checking game start');
            if(json.result == 'ok') {
                console.log('all players ready');
                clearInterval(chkGameID);
                $.ajax({
                    url: bUrl,
                    data: {
                        event: 'startUp'
                    },
                    type: 'POST',
                    dataType: 'json',
                    success: function (json) {
                        console.log('starting game');
                        //debugger;
                        if(json.result == 'ok') {
                            console.log('game started');
                            
                            var create = json.createThis;
                            
                            //set void object
                            $(document.createElement('div')).attr({
                                id: create.nowhere.id
                            })
                            .css({
                                visibility: 'hidden',
                                position: 'absolute',
                                top: 0,
                                left: 0
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
                            //debugger;
                            for(i = 0; i < create.player.decks.length; i++) {
                                $(document.createElement('img'))
                                .attr({
                                    id: create.player.decks[i].id, 
                                    src: '_cards/up/thumbs/cardback.jpg'
                                })
                                .data('deck-name', create.player.decks[i].name)
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
                            
                            //Opponent area (top window zone)
                            $('.opponent-area').attr('id', create.opponent.playableArea.id)
                            .html(create.opponent.playableArea.html);
                            
                            $('.opponent-area > table').css({
                                height: $('.opponent-area').height() 
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
                                    position: 'absolute'
                                })
                                .css($('#' + card.position).position())
                                .appendTo($('body'));
                            }
                            
                            //updGame = setInterval(updateGame, 3000);*/
                            
                            
                            //Configure deck widgets
                            ui();
                        }
                    }
                });
            }
        }
    });
}

function doGameUpdate(json) {
    if(json.result == 'ok') {
        console.log('doing game update');
        for(i = 0; i < json.update.lenght; i++) {
            $('#' + json.update[i].id)
            .animate($('#' + json.update[i].location).position())
            .attr('src', '_cards/up/thumbs/' + json.update[i].src);
        }
    }
    
}

function updateGame() {
    console.log('requesting game update');
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
    console.log('drawing a card');
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
    console.log('moving a card');
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

//TODO: revise....
function pack() {
    //Define area sizes: horizontal mid-point and with for opponent area
    $('.opponent-area').css('width', $(window).width() - 350);
    $('.play').css('width', $(window).width() - 350);
    
    $('#top').css('height', $(window).height() / 2); 
    $('#bottom').css('height', $(window).height() / 2);
    $('.play').css('height', $(window).height() / 2);
        
    //$('#wait-modal').modal();
    console.log('packing');
}

function ui() { 
    //Define positions for existing decks
    $('#deck-slide').children('img').each(function(index) {
        $(this).css({
            left: index * 85, 
            top: 0,
            position: 'absolute'
        });
    })
    
    //bind click event for deck widget slide
    $('#deck-nob').click(deckSlide);
    
//bind keybord events
    
//TODO: remove, do after init
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
                    
                    //TODO: track received messages
                    lastReceived = json.id;
                }
            }
        });
        $("#writemessage").val('');
    }
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