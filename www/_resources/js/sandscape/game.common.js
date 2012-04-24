function showWidget(elemId, withShader) {
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
