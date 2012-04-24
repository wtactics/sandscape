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
