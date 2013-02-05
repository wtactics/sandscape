/* lobby.js
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Global object with properties used mostly in AJAX calls.
 */
var globals = {
    lastReceived: 0,
    //update and send message URLs
    urls: {
        upd: '',
        send: ''
    },
    //Filter constants
    filter: {
        ALL: 0,    
        PAUSED: 1,
        RUNNING: 2,
        IPLAY: 3,
        WAITINGME: 4,
        WAITINGOPPONENT: 5
    }
}

/**
 * Creates the initial lobby objects and events.
 */
function initLobby() {
    $('#writemessage').keypress(function(e) {
        if(e.which == 13) {
            $('#sendbtn').click();
        }
    });

    //5 sec delay before asking for messages
    setTimeout(updateMessages, 5000);
    
    $('.join').click(function(e) {
        $('#game').val($(this).children('.hGameId').val());
        $('#maxDecksJoin').val($(this).children('.hGameDM').val());
        $('#joindlg').modal(); 
    });
        
    $('.spectate').click(function(e) {
        $('#specgame').val($(this).children('.hGameId').val());
        $('#spectatedlg').modal();
        
    });
    
    $('.return').click(function(e) {
        window.location = $(this).children('.hGameUrl').val();
    });
}

/**
 * Sends a message to the server.
 */
function sendMessage() {
    var message = $("#writemessage").val();
    if(message.length > 0) {
        $.ajax({
            type: "POST",
            url: globals.urls.send,
            data: {
                'chatmessage': message
            },
            dataType: 'json',
            success: function(json) {
                if(json.success) {
                    $('#messages-list').append('<li><strong>' + json.name + ':</strong>&nbsp;' + message + '</li>');
                    
                    globals.lastReceived = json.id;
                    chatToBottom();
                }
            }
        });
        $("#writemessage").val('');
    }
}

/**
 * Requests new messages from other users.
 */
function updateMessages() {
    $.ajax({
        type: "POST",
        url: globals.urls.upd,
        data: {
            'lastupdate': globals.lastReceived
        },
        dataType: 'json',
        success: function(json) {
            if(json.has) {
                $.each(json.messages, function() {
                    $('#lobbychat').append('<li><span><strong>' + this.name + '</strong>&nbsp;[' 
                        + this.date + ']:</span><br />' + this.message + '</li>');                    
                });

                globals.lastReceived = json.last;
                chatToBottom();
            }
        },
        complete: function(){
            setTimeout(updateMessages, 5000);
        }
    });
}

/**
 * Validates the number of selected decks and prevents games from being created 
 * or users joining games if the number of selected decks is not the same as the 
 * number of configured decks, either globally or per-game.
 * 
 * This function is used by several dialog windows and thus the button selector 
 * string needs to be passed as a parameter.
 */
function limitDeckSelection(jqSearch) {
    var max = parseInt($('#maxDecks').val(), 10), sel = $('.marker').filter(':checked').length,
    button = $(jqSearch);
    
    if(button.is(':disabled')) {
        if(sel == max) {
            button.removeAttr('disabled');
        }
    } else if(sel != max) {
        button.attr('disabled', 'disabled');
    }
}

/**
 * Slider JS for user listing. Used by jQuery UI Slider.
 */
function usersSliderScroll(e, ui) {
    var view = $('#users-view'), list = $('#users-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#users-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

/**
 * Slider JS for user listing. Used by jQuery UI Slider.
 */
function usersSliderChange(e, ui) {
    var view = $('#users-view'), list = $('#users-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#users-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

/**
 * Slider JS for chat messages. Used by jQuery UI Slider.
 */
function chatSliderScroll(e, ui) {
    $('#messages-list').css({
        top: ui.value
    });
}

/**
 * Slider JS for chat messages. Used by jQuery UI Slider.
 */
function chatSliderChange(e, ui) {
    $('#messages-list').css({
        top: ui.value
    });
}

/**
 * Slider JS for chat messages. Used by jQuery UI Slider.
 */
function chatSliderSetValue(e, ui) {
    chatChatToBottom();
}

/**
 * Moves the messages list down to show the last added list. It is used every 
 * time the message list is updated, a new message is added and when the slider 
 * is created so that the slider value is properly set.
 */
function chatChatToBottom() {
    var csl = $('#chat-slider'), ml = $('#messages-list'), bh = ml.height(), 
    vh = $('#chat-view').height(), h = -(bh - vh);
    console.log('bh: ' + bh + ', vh: ' + vh + ', h: ' + h);
    if(bh > vh) {
        csl.slider('option', 'min', h)
        .slider('option', 'value', h);
    
        ml.animate({
            top: h
        }, 'slow');
    }
}

/**
 * Slider JS for game listing. Used by jQuery UI Slider.
 */
function gamesSliderScroll(e, ui) {
    var view = $('#games-view'), list = $('#games-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#games-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

/**
 * Slider JS for game listing. Used by jQuery UI Slider.
 */
function gamesSliderChange(e, ui) {
    var view = $('#games-view'), list = $('#games-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#games-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

/**
 * Filters games in the game list according to the filter criteria.
 * Currently all filters are hardcoded with the view file for the lobby having 
 * the combobox and the text and the JS function comparing to fixed integer 
 * values defined in the <em>globals.filter</em> object.
 */
function filterGameList() {
    switch(parseInt($('#filterGames').val(), 10)) {
        //all
        case globals.filter.ALL:
            $('.paused').show();
            $('.running').show();
            $('.my-game').show();
            $('.wait-me').show();
            $('.wait-opponent').show();
            break;
        //paused
        case globals.filter.PAUSED:
            $('.running').hide();
            $('.my-game').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.paused').show();
            break;
        //running
        case globals.filter.RUNNING:
            $('.paused').hide();
            $('.my-game').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.running').show();
            break;
        //that I play
        case globals.filter.IPLAY:
            $('.paused').hide();
            $('.running').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.my-game').show();
            break;
        //waiting for me
        case globals.filter.WAITINGME:
            $('.paused').hide();
            $('.running').hide();
            $('.my-game').hide();
            $('.wait-opponent').hide();
            //
            $('.wait-me').show();
            break;
        //waiting for opponent
        case globals.filter.WAITINGOPPONENT:
            $('.paused').hide();
            $('.running').hide();
            $('.my-game').hide();
            $('.wait-me').hide();
            //
            $('.wait-opponent').show();
            break;
    }
    $('#games-list').css({
        top: 0
    });
    
    $('#games-slider').slider('option', 'value', 100);
}