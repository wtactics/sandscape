<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <!-- <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/game.css" /> -->
        <link type="text/css" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/board.css" />

        <?php
        Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl() . '/jui/css/base/jquery-ui.css');
        //
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jQuery.radmenu.min.js"></script>

        <!-- <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/game.js"></script> -->
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/board.js"></script>
        <style type="text/css">
            #radial_container { 
                position:relative; 
                left:425px; 
                top: 75px; 
                width:100px; 
                height:100px; 
                text-align:center;
            }
            .radial_div_item {
                background-color:none;
                height:30px;
                padding:10px;
                color:#234;
                -moz-border-radius:10px;
                -webkit-border-radius:10px;
                cursor:pointer;
            }
            .radial_div_item.active { 
                background-color:#511; color:white;
                padding: 10px; 
                -moz-border-radius:40px;
                z-index:100;
            }
            .my_class { 
                font-size:1.5em; 
                color:#abc;
                background-color:#def;
                -moz-border-radius:30px;
                width:30px;
                height:30px;
                -webkit-border-radius:30px;
            }
        </style>
    </head>
    <body id="appendable">
        <!-- Left vertical area -->
        <div id="system">
            <!-- Bigger image -->
            <div id="zoom">
                <!-- <img src="http://localhost/spikes/card-images/CardBack.png" id="zoomedImage" /> -->
                <!-- <img src="http://192.168.10.2/spikes/card-images/CardBack.png" id="zoomedImage" /> -->
                
                <button type="button" onclick="drawCardFromDeck()">ok</button>
            </div>

            <!-- Chat widget -->
            <div id="chat">
                <div id="messages">
                </div>
                &nbsp;Message:&nbsp;
                <input id="message" name="message" type="text" />
                <button id="send" name="send" type="button" onclick="sendMessage();">OK</button>
            </div>
            <!-- TODO: find hand size -->
            <div class="hand" style="background-color: green;height: 303px">
                
            </div>
        </div>
        <!-- END: left vertical area -->

        <!-- Game area -->
        <div id="board">
            <?php echo $content; ?>
        </div>
        <!-- END: game area -->
        
        <!-- TODO: ... -->
        <!-- <div id='radial_container'>
            <ul class='list'>
                <li class='item'><div class='my_class'>8</div></li>
                <li class='item'><div class='my_class'>9</div></li>
            </ul>
        </div> -->
    </body>
</html>
