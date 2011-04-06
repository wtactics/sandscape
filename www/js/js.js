function addGame(){
    $(this).dialog("close");

    $.ajax({
        url: $('#action').val(),
        dataType: 'json',
        type: 'POST',
        data : $('#newgame-form').serialize() + '&ajax=newgame-form'
    });    
}

