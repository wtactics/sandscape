var lastReceived = 0;

/**
 * Creates the initial lobby objects and events.
 */
function initLobby(url) {
    $('#writemessage').keypress(function(e) {
        if(e.which == 13) {
            $('#sendbtn').click();
        }
    });

    //5 sec delay before asking for more messages
    setInterval(function() {
        updateMessages(url)
    }, 5000);
    
    $('.join').click(function(e) {
        $('#game').val($(this).children('.hGameId').val());
        $('#maxDecksJoin').val($(this).children('.hGameDM').val());
        
        $('#joindlg').modal(); 
    });
        
    $('.spectate').click(function(e) {
        $('#specgame').val($(this).children('.hGameId').val());
        $('#spectatedlg').modal();
        
    });
}

/**
 * Sends a message to the server. Note that the new message is appended to the 
 * chat area without being filtered by the server.
 */
function sendMessage(destination) {
    var message = $("#writemessage").val();
    if(message.length > 0) {
        $.ajax({
            type: "POST",
            url: destination,
            data: {
                'chatmessage': message
            },
            dataType: 'json',
            success: function(json) {
                if(json.success) {
                    $('#lobbychat').append('<li><span><strong>' + json.name + '</strong>&nbsp;[' 
                        + json.date + ']:</span><br />' + message + '</li>');
                    
                    lastReceived = json.id;
                    updateMessageScroll();
                }
            }
        });
        $("#writemessage").val('');
    }
}

/**
 * Requests new messages from other users.
 */
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
                    $('#lobbychat').append('<li><span><strong>' + this.name + '</strong>&nbsp;[' 
                        + this.date + ']:</span><br />' + this.message + '</li>');                    
                });

                lastReceived = json.last;
                updateMessageScroll();
            }
        }
    });
}

/**
 * Moves the message area down in order to show new messages.
 */
function updateMessageScroll() {
    $("#lobbychat").scrollTop($("#lobbychat")[0].scrollHeight);
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