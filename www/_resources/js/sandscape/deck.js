var globals = {
    imageUrl: ''
}


function init(url) {
    globals.imageUrl = url;
    var avCards = $('#available-cards'), selCards = $('#selected-cards');
    
    $('#filterSelected').keyup(function (e) {
        var me = $(this);
        if(me.val().length) {
            filter(selCards.find('li'), me.val());
        } else {
            selCards.find('li:hidden').show();
        }
    });
    
    $('#filterAvailable').keyup(function (e) {
        var me = $(this);
        if(me.val().length) {
            filter(avCards.find('li'), me.val());
        } else {
            avCards.find('li:hidden').show();
        }
    });
    
    //left column, cards in deck
    selCards.droppable({
        accept: '.available',
        drop: dropCard
    })
    .find('li').draggable({
        appendTo: 'body',
        revert: 'invalid',
        helper: inDeckDragHelper
    })
    .dblclick(removeSelectedCard)
    .click(function (e) {
        loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
    })
    .find('img')
    .click(removeSeveral);
    
    //right column, available cards
    avCards.droppable({
        accept: '.in-deck',
        drop: dropRemoveCard
    })
    .find('li').draggable({
        appendTo: 'body',
        revert: 'invalid',
        helper: function() {
            return $(document.createElement('div'))
            .append($(document.createElement('img'))
                .attr('src', '_resources/images/icon-x16-small-plus.png'))
            .append($(this).text());
        }
    })
    .dblclick(selectCard)
    .click(function (e) {
        loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
    });
    
    //add extra information that controlls adding and removal of new cards to deck
    $('#hiddenIds input[name="selected\\[\\]"]').each(function() {
        $(this).data('for', 's' + $(this).val());
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

function dropCard(event, ui) {
    var dropin = $(this), idValue = 's' + ui.draggable.attr('id').substr(1);
    addCard(dropin, ui.draggable, dropin.find('#' + idValue), $('#card-total'))
}

function selectCard(e) {
    var dropin = $('#selected-cards'), origin = $(this), idValue = 's' + origin.attr('id').substr(1);
    addCard(dropin, origin, dropin.find('#' + idValue), $('#card-total'));
}

function addCard(dropin, origin, existing, total) {
    var count = 1, span, idValue = origin.attr('id').substr(1);
    
    if(existing.length) {
        span = existing.find('.card-count');
        span.html(parseInt(span.html(), 10) + 1);
    } else {
        $(document.createElement('li'))
        .attr('id', 's' + idValue)
        .addClass('in-deck')
        .draggable({
            appendTo: 'body',
            revert: 'invalid',
            helper: inDeckDragHelper
        })
        .append($(document.createElement('img'))
            .attr('src', '_resources/images/icon-x16-small-cross.png')
            .click(removeSeveral))
        .append(origin.text())
        .append($(document.createElement('span'))
            .addClass('card-count')
            .html(count))
        .dblclick(removeSelectedCard)
        .click(function (e) {
            loadPreviewImage(parseInt($(this).attr('id').substr(1), 10));
        })
        .appendTo(dropin);
    }
    
    $(document.createElement('input'))
    .attr({
        type: 'hidden',
        name: 'selected[]',
        id: 'h' + idValue + '-' + count,
        value: idValue
    })
    .data('for', 's' + idValue)
    .appendTo($('#hiddenIds'));
    
    total.html(parseInt(total.html(), 10) + 1);
}

function removeSelectedCard(e) {
    var me = $(this), id = me.attr('id'), found = null, inputs = $('#hiddenIds input[name="selected\\[\\]"]'),
    size = 0, working = null, span, total = $('#card-total');
    
    inputs.each(function() {
        working = $(this);
        
        if(working.data('for') == id) {
            if(size == 0) {
                found = working;
            }
            
            size ++;
        }
    });
    
    if(found) {        
        span = me.find('.card-count');
        span.text(parseInt(span.text(), 10) - 1);
        total.text(parseInt(total.text(), 10) - 1);
        found.remove();
        
        if(size == 1) {
            me.remove();
        }
    }
}

function filter(elems, text) {  
    text = $.trim(text).replace(/ /gi, '|');
  
    elems.each(function() {
        ($(this).text().search(new RegExp(text, "i")) < 0) ? $(this).hide() : $(this).show();
    });  
}

function removeSeveral(e) {
    removeNCards($(this).parent('li'));
    
    //prevent event propagation
    return false;
}

function dropRemoveCard(event, ui) {
    removeNCards(ui.draggable);
}

function removeNCards(me) {
    var id = me.attr('id'), count = 1, found = Array(), i, span, 
    total = $('#card-total'), sCount = 0;
    
    $('#hiddenIds input[name="selected\\[\\]"]').each(function() {
        if($(this).data('for') == id) {
            found.push($(this));
        }
    });
    
    if(found.length > 1) {
        count = parseInt(prompt("How many cards to remove?", found.length), 10);
    }
    
    if(!isNaN(count)) {
        for(i = 0; i < count; i++) {
            found[i].remove();
        }
        
        span = me.find('.card-count');
        sCount = parseInt(span.text(), 10);
        
        if(sCount - count == 0) {
            me.remove();
        } else {
            span.text(sCount - count);
        }
        total.text(parseInt(total.text(), 10) - count);
    }
}

function inDeckDragHelper() {
    return $(document.createElement('div'))
    .append($(document.createElement('img'))
        .attr('src', '_resources/images/icon-x16-small-minus.png'))
    .append($(this)
        .find('.card-name')
        .text());
}