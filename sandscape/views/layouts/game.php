<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" />
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/game.js"></script>
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

        <!-- //TODO: //NOTE: IN DEV... -->
        <div style="margin: 0 auto; width: 800px; height: 600px;">
            <canvas width="600" height="400" id="drawarea"></canvas>
        </div>

    </body>
</html>
