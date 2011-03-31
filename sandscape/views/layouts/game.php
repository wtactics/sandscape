<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <!-- <?php //echo Yii::app()->request->baseUrl;      ?> -->
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" />
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
                
                //var context = document.getElementById("drawarea").getContext("2d");
                //context.fillRect(50, 25, 150, 100);
            });
        </script>
        <script type="text/javascript">
            <!--
            if (!window.CanvasRenderingContext2D)
            {
                //document.getElementById('loading').innerHTML = 'Your browser doesn\'t support canvas, if you are using IE then the <a href="v1/">older version</a> will likely work.<br>I suggest you download a standards compliant browser such as <a href="http://www.opera.com/">Opera</a>.';
            }
            else
            {
                //document.getElementById('loading').innerHTML = '<img src="img/loading.gif" alt="" style="width:16px;height:16px;vertical-align:top;"> Loading game...';
            }
            -->
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

        <div>
            <ul style="margin: 0 0 5px 0; padding: 0;">     
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
            </ul>
        </div>

        <!-- IN DEV... -->
        <div style="margin: 0 auto; width: 800px; height: 600px;">
            <canvas width="600" height="400" id="drawarea"></canvas>
        </div>

    </body>
</html>
