<!DOCTYPE HTML>
<html>
    <head>

        <link type="text/css" rel="stylesheet" href="_resources/css/game.css" />
        <script type="text/javascript" src="_resources/js/game.js"></script>
        <title></title>
    </head>
    <body id="appendable">
        <!-- Left vertical area -->
        <div id="system">
            <!-- Bigger image -->
            <div id="zoom">
                <!-- <img src="http://localhost/spikes/card-images/CardBack.png" id="zoomedImage" /> -->
                <!-- <img src="http://192.168.10.2/spikes/card-images/CardBack.png" id="zoomedImage" /> -->
                <!-- <button type="button" onclick="drawCardFromDeck()">ok</button> -->
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
    </body>
</html>
