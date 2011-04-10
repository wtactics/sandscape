$(document).ready(function() {
    $('#stats-slide p a').click(function(){
        var slide = $('#stats-slide');
        slide.animate({
            left: parseInt(slide.css('left'),10) == 0 ? -slide.outerWidth() + 25 : 0
        });
        if(slide.data('hidden')) {
            slide.data('hidden', false);
            $('#stats-slide p a').html('&lt;&lt;&nbsp;');
        } else {
            slide.data('hidden', true);
            $('#stats-slide p a').html('&gt;&gt;&nbsp;');
        }
    });
});