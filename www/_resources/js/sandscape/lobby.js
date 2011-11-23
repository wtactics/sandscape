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
var globals = {
    lastReceived: 0,
    urls: {
        upd: '',
        send: ''
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

    //5 sec delay before asking for more messages
    //setTimeout(updateMessages, 5000);
    
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
                    $('#lobbychat').append('<li><strong>' + json.name + ':</strong>&nbsp;' + message + '</li>');
                    
                    globals.lastReceived = json.id;
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
 */
function limitDeckSelection(jqSearch) {
    var max = parseInt($('#maxDecks').val(), 10), sel = $('.marker').filter(':checked').length;
    
    if($(jqSearch).attr('disabled') != '') {
        if(sel == max) {
            $(jqSearch).attr('disabled', '');
        }
    } else {
        if(sel != max) {
            $(jqSearch).attr('disabled', 'disabled');
        }
    }
}

function usersSliderScroll(e, ui) {
    var view = $('#users-view'), list = $('#users-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#users-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

function usersSliderChange(e, ui) {
    var view = $('#users-view'), list = $('#users-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#users-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

function chatSliderScroll(e, ui) {
//$('#messages-list').css({
//    top: ui.value
//});
}

function chatSliderChange(e, ui) {
//$('#messages-list').css({
//    top: ui.value
//});
}

function chatSliderSetValue(e, ui) {
    chatChatToBottom();
}

function chatChatToBottom() {
//var sl = $('#chat-slider'), cm = $('#chat-messages'), bh = cm.height(), h = -(bh - 130);
//if(bh > 130) {
//    sl.slider('option', 'min', h)
//    .slider('option', 'value', h);
    
//    cm.animate({
//        top: h
//    }, 'slow');
//}
}

function gamesSliderScroll(e, ui) {
    var view = $('#games-view'), list = $('#games-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#games-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

function gamesSliderChange(e, ui) {
    var view = $('#games-view'), list = $('#games-list'), scroll = list.height() - view.height();
    if(scroll > 0) {
        $('#games-list').css({
            top: -(scroll * (100 - ui.value) / 100)
        });
    }
}

function filterGameList() {
    switch(parseInt($('#filterGames').val(), 10)) {
        //all
        case 0:
            $('.paused').show();
            $('.running').show();
            $('.my-game').show();
            $('.wait-me').show();
            $('.wait-opponent').show();
            break;
        //paused
        case 1:
            $('.running').hide();
            $('.my-game').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.paused').show();
            break;
        //running
        case 2:
            $('.paused').hide();
            $('.my-game').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.running').show();
            break;
        //that I play
        case 3:
            $('.paused').hide();
            $('.running').hide();
            $('.wait-me').hide();
            $('.wait-opponent').hide();
            //
            $('.my-game').show();
            break;
        //waiting for me
        case 4:
            $('.paused').hide();
            $('.running').hide();
            $('.my-game').hide();
            $('.wait-opponent').hide();
            //
            $('.wait-me').show();
            break;
        //waiting for opponent
        case 5:
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