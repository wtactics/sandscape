var lastReceived = 0;

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
                    $('#lobbychat').append('<li><span><strong>' + this.name + '</strong>&nbsp;[' 
                        + this.date + ']:</span><br />' + this.message + '</li>');                    
                });

                lastReceived = json.last;
            }
        }
    });
}