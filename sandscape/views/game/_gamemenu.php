<div id="rightmenunob" class="nob">
    <ul>
        <li>
            <a href="javascript:;" onclick="showWidget('dicewidget', true);">
                <img src="_resources/images/board/I_Diamond.png" />
            </a>
        </li>
        <li>
            <a href="javascript:;" onclick="showWidget('counterswidget', true);">
                <img src="_resources/images/board/S_Buff08.png" />
            </a>
        </li>
        <li>
            <a href="javascript:;" onclick="showWidget('deckswidget', true);">
                <img src="_resources/images/board/W_Book02.png" />
            </a>
        </li>
        <li>
            <a href="javascript:;" onclick="showWidget('systemwidget', true);">
                <img src="_resources/images/board/I_Key01.png" />
            </a>
        </li>
    </ul>
</div>


<div id="dicewidget" class="menububble autoclosebubble">
    <div class="menucontents">
        <?php if (count($dice)) { ?>
            <h2>Dice</h2>
            <ul>
                <?php foreach ($dice as $die) { ?>
                    <li><a href="javascript:roll(<?php echo $die->diceId; ?>)"><?php echo $die->name; ?></a></li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
    <div class="menububble-ab-right"></div>
    <div class="menububble-a-right"></div>
</div>

<div id="counterswidget" class="menububble autoclosebubble">
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
    <div class="menububble-ab-right"></div>
    <div class="menububble-a-right"></div>
</div>

<div id="deckswidget" class="menububble autoclosebubble">
    <div class="menucontents">
        <h2>Decks</h2>
        <div id="decks"><!-- DECKS ARE PLACED HERE --></div>
    </div>
    <div class="menububble-ab-right"></div>
    <div class="menububble-a-right"></div>
</div>

<div id="systemwidget" class="menububble autoclosebubble">
    <div class="menucontents">
        <h2>System Menu</h2>
        <ul>
            <li>Show Messages:
                <ul style="padding-left: .2em;">
                    <li>
                        <?php echo Chtml::checkBox('show-user-messages', true, array('onchange' => 'filterChatMessages()')); ?> 
                        User
                    </li>
                    <li>
                        <?php echo Chtml::checkBox('show-system-messages', true, array('onchange' => 'filterChatMessages()')); ?> 
                        System
                    </li>
                </ul>
            </li>
            <li><a href="javascript:;" onclick="$('#exit-dlg').modal();">Exit</a></li>
        </ul>
    </div>
    <div class="menububble-ab-right"></div>
    <div class="menububble-a-right"></div>
</div>

<!-- helper shader div -->
<div id="shader"onclick="closeAllWidgets()"></div>