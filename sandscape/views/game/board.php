<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('initjs', 'ui()');
?>

<div id="top">
    <div id="info-widget">
        <div id="tools-widget">
            <a href="javascript:;" onclick="showChat();">Chat</a>
            <a href="javascript:;" onclick="alert('Not implemented yet!');">Leave</a>
        </div>
        <table id="card-info">
            <tr>
                <td colspan="2"><strong>Card:</strong> name</td>
            </tr>
            <tr  style="vertical-align: top;">
                <td style="width: 30%;"><img src="_cards/default/cardback.thumb.jpg" /></td>
                <td>
                    <strong>States:</strong>
                </td>
            </tr>
            <tr colspane="2">
                <td>
                    <strong>Rules:</strong>
                </td>
            </tr>
        </table>
        <a id="inspect-card" href="javascript:;" onclick="inspect();">Inspect</a>
    </div>
    <div id="opponent-area">Opponent</div>
</div>
<div id="bottom" style="">
    <div id="play-area">
        <div id="hand"></div>
        <img id="deck-nob" src="_cards/default/cardback.thumb.jpg" />
        <div id="deck-widget">
            <div id="deck-slide">
                <!-- //TODO: remove dummy cards -->
                <img src="_cards/up/thumbs/18e9b964776bbe6c9f6842f1feba8b8b.jpg" />
                <img src="_cards/up/thumbs/6aaa6d9ba4e77aced6f6a1243f91d189" />
                <img src="_cards/up/thumbs/0faee65bce7f5bbfad77cdb00a8e0414" />
            </div>
        </div>                   
    </div>
</div>

<div id="chat">
    <ul id="chat-messages"></ul>
    <div>
        <div style="float:left; width: 34%;">
            Show:
            <input type="radio" name="filter" id="fshow-all" onchange="filterChatMessages(this);" /> All ::
            <input type="radio" name="filter" id="fshow-user"onchange="filterChatMessages(this);" /> User ::
            <input type="radio" name="filter" id="fshow-system" onchange="filterChatMessages(this);" /> System         
        </div>
        <div style="float:left; width: 65%;">
            <p>
                <input type="text" class="text" id="writemessage" />
                <button type="button" onclick="sendMessage('<?php echo $this->createURL('game/sendgamemessage', array('id' => $gameId)); ?>');" id="sendbtn">Send</button>
            </p>
        </div>
    </div>
</div>