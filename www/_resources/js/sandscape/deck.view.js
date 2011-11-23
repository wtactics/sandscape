/* deck.view.js
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
