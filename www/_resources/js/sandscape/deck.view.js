var globals = {
    imageUrl: ''
}

function init(url) {
    globals.imageUrl = url;
    var avCards = $('#cards');
    
    $('#filterSelected').keyup(function (e) {
        var me = $(this);
        if(me.val().length) {
            filter(avCards.find('li'), me.val());
        } else {
            avCards.find('li:hidden').show();
        }
    });
    
    //right column, available cards
    avCards.find('li')
    .click(function (e) {
        loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
    });
}

function loadPreviewImage(id) {
    $.ajax({
        url: globals.imageUrl,
        data: {
            card: id 
        },
        type: 'POST',
        dataType: 'json',
        success: function (json) {
            if(json.success) {
                $('#previewImage').attr('src', '_game/cards/' + json.image);
            } else {
                $('#previewImage').attr('src', '_game/cards/cardback.jpg');
            }
        }
    });
}

function filter(elems, text) {  
    text = $.trim(text).replace(/ /gi, '|');
  
    elems.each(function() {
        ($(this).text().search(new RegExp(text, "i")) < 0) ? $(this).hide() : $(this).show();
    });  
}
