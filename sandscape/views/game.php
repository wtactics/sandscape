<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <link type="text/css" rel="stylesheet" href="<?php echo url(); ?>resources/css/style.css" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript">
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
        </script>
    </head>
    <body>
        <div id="stats-slide">
            <p><a href="#">&lt;&lt;</a>&nbsp;</p>
            <div id="stats">
            </div>
        </div>
        <div id="system">
            <div id="system-events"></div>
            <div id="chat">
                <div id="messages">
                </div>
                <input id="text" name="text" type="text" />
                <button id="send" name="send" type="button">OK</button>
            </div>
        </div>
    </body>
</html>