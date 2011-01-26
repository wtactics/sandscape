<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
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

        <div>
            <ul style="margin: 0 0 5px 0; padding: 0;">
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
                <li style="display: inline;list-style: none; margin-right: 1em;"><a href="#">op1</a></li>
            </ul>
        </div>

        <!-- IN DEV... -->
        <!-- TOP PLAYER DIV -->
        <div style="margin: 0 auto; background-color: yellow;height: 350px;">
            <!-- TOP LEFT DECKS -->
            <div style="float: left; width: 100px; background-color: red">
                <div style="border: dashed 1px blue;height: 100px; width: 95px;margin: 0 auto; background-color: white;"></div>
                <div style="border: dashed 1px blue;height: 100px; width: 95px;margin: 10px auto;background-color: white;"></div>
            </div>
            <!-- TOP CARD ROWS -->
            <div style="float: left;background-color: gray;height: 100%;width: 800px;margin-left: 10px;">
                <div style="border: dashed 2px white; height: 100px; margin-bottom: 10px;"></div>
                <div style="border: dashed 2px white; height: 100px; margin-bottom: 10px;"></div>
                <div style="border: dashed 2px white; height: 100px;"></div>
            </div>
            <div style="clear:both"></div>
        </div>
        
        <hr style="margin: 5px 0 5px 0;"/>

        <!-- BOTTOM PLAYER DIV -->
        <div style="margin: 0 auto; background-color: pink;height: 350px;">
            <!-- TOP CARD ROWS -->
            <div style="float: left;background-color: gray;height: 100%;width: 800px;margin-left: 110px;">
                <div style="border: dashed 2px white; height: 100px; margin-bottom: 10px;"></div>
                <div style="border: dashed 2px white; height: 100px; margin-bottom: 10px;"></div>
                <div style="border: dashed 2px white; height: 100px;"></div>
            </div>
            <!-- BOTTOM RIGHT DECKS -->
            <div style="float: left; width: 100px; background-color: red;margin-left: 10px;">
                <div style="border: dashed 1px blue;height: 100px; width: 95px;margin: 0 auto; background-color: white;"></div>
                <div style="border: dashed 1px blue;height: 100px; width: 95px;margin: 10px auto;background-color: white;"></div>
            </div>
            <div style="clear:both"></div>
        </div>
    </body>
</html>
