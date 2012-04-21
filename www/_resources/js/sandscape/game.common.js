function showWidget(elemId) {
    closeAllWidgets();
    
    $('#shader').show();
    $('#' + elemId).show();
}

function closeAllWidgets() {
    $('.menububble').hide();
    $('#shader').hide();
}