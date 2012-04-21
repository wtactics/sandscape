function showWidget(elemId) {
    closeAllWidgets();
    
    $('#' + elemId).show();
}

function closeAllWidgets() {
    $('.menububble').hide();
}