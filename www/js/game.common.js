$(function (lobby, $, _, undefined) {
    var gameFilters = {
        ALL: 0,
        PAUSED: 1,
        RUNNING: 2,
        INPLAY: 3,
        WAITINGME: 4,
        WAINTINGOPPONENT: 5
    };
    
    _.extend(lobby, {
        urls: {
            update: null,
            send: null
        },

        initialize: function (updateUrl, sendUrl) {
            lobby.urls.update = updateUrl;
            lobby.urls.send = sendUrl;
            
        //$('#writemessage').keypress(function(e) {
        //    if(e.which == 13) {
        //        $('#sendbtn').click();
        //    }
        //});
        }
    });

}(window.lobby = window.lobby || {}, jQuery, _));

/*function showWidget(elemId, withShader) {
    closeAllWidgets();
    
    if(withShader) {
        $('#shader').show();
    }
    $('#' + elemId).show();
}

function closeAllWidgets() {
    $('.autoclosebubble').hide();
    $('#shader').hide();
}

function closeWidget(elemId) {
    $('#' + elemId).hide();
}

function closeShader() {
    $('#shader').hide();
}

function showHandWidget() {
    $('#handwidget').css({
        left: 10
    });
}

function hideHandWidget() {
    $('#handwidget').css({
        left: -500
    });
}
*/
