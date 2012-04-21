<?php
Yii::app()->clientScript->registerScriptFile('_resources/js/sandscape/game.common' . (YII_DEBUG ? '' : '.min') . '.js', CClientScript::POS_HEAD);
?>

<div id="menunob">
    <ul>
        <li><a href="javascript:;" onclick="showWidget('dicewidget');">D</a></li>
        <li><a href="javascript:;" onclick="showWidget('counterswidget');">C</a></li>
        <li><a href="javascript:;" onclick="showWidget('deckswidget');">G</a></li>
        <li><a href="javascript:;" onclick="showWidget('systemwidget');">S</a></li>
    </ul>
</div>

<div id="dicewidget" class="menububble">
    <div class="menucontents">
        <?php if (count($dice)) { ?>
            <ul id="">
                <?php foreach ($dice as $die) { ?>
                    <li><a href="javascript:roll(<?php echo $die->diceId; ?>)"><?php echo $die->name; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <div class="menububble-arrowborder"></div>
    <div class="menububble-arrow"></div>
</div>

<div id="systemwidget" class="menububble">
    <div class="menucontents">
        <ul>
            <li>Filter Messages
                <ul>
                    <li>
                        <?php
                        echo Chtml::checkBox('show-user-messages', true, array('onchange' => 'filterChatMessages()'));
                        ?> 
                        User
                    </li>
                    <li>
                        <?php
                        echo Chtml::checkBox('show-system-messages', true, array('onchange' => 'filterChatMessages()'));
                        ?> 
                        System
                    </li>
                </ul>
            </li>
            <li><a href="javascript:exit();">Exit</a></li>
        </ul>
    </div>
    <div class="menububble-arrowborder"></div>
    <div class="menububble-arrow"></div>
</div>

<div id="counterswidget" class="menububble">
    <div class="menucontents">
        <h2>Player Counters</h2>
        <div id="player-counters">
            <div id="pc-area"><!-- PLAYER COUNTERS ARE PLACED HERE --></div>
        </div>
        <h2>Opponent Counters</h2>
        <div id="opponent-counters">
            <div id="opc-area"><!-- OPPONENT COUNTERS ARE PLACED HERE --></div>
        </div>
    </div>
    <div class="menububble-arrowborder"></div>
    <div class="menububble-arrow"></div>
</div>

<div id="deckswidget" class="menububble">
    <div class="menucontents">
        <h2>Decks</h2>
        <div id="decks"><!-- DECKS ARE PLACED HERE --></div>
    </div>
    <div class="menububble-arrowborder"></div>
    <div class="menububble-arrow"></div>
</div>