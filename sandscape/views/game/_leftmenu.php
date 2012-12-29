<div id="leftmenunob" class="nob">
    <ul>
        <li>
            <a href="javascript:;" onclick="showWidget('infowidget', false);">
                <img src="_resources/images/board/I_Telescope.png" />
            </a>
        </li>
        <li>
            <a href="javascript:;" onclick="showWidget('chatwidget', false);">
                <img src="_resources/images/board/I_Feather01.png" />
            </a>
        </li>
    </ul>
</div>

<div id="infowidget" class="menububble">
    <div id="card-info">
        <div class="big-label" style="display:none;"></div>
        <img id="card-image" src="_game/cards/cardback.png" />
    </div>
    <div class="menububble-ab-left"></div>
    <div class="menububble-a-left"></div>
    <div class="closewidget">
        <a href="javascript:;" onclick="closeWidget('infowidget')">
            <img src="_resources/images/icon-x16-cross.png" />
        </a>
    </div>
</div>

<div id="chatwidget" class="menububble">
    <div id="chat">
        <?php
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'id' => 'chat-slider',
            'options' => array(
                'max' => 0,
                'animate' => true,
                'orientation' => 'vertical',
                'slide' => 'js:sliderScroll',
                'change' => 'js:sliderChange',
                'create' => 'js:sliderSetValue'
            )
        ));
        ?>
        <div id="content-view">
            <ul id="chat-messages">
                <?php
                foreach ($messages as $message) {
                    if ($message->system) {
                        ?>
                        <li class="system-message <?php echo ($player1 == $message->userId ? 'player1-action' : 'player2-action'); ?>">
                            <strong><?php echo date('H:i', strtotime($message->sent)); ?>:</strong>
                            <?php echo $message->message; ?>
                        </li>
                    <?php } else { ?>
                        <li class="user-message <?php echo ($player1 == $message->userId ? 'player1-text' : ($player2 == $message->userId ? 'player2-text' : 'spectator-text')); ?>">
                            <strong><?php echo date('H:i', strtotime($message->sent)); ?>:</strong>
                            <?php echo $message->message; ?>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="menububble-ab-left"></div>
    <div class="menububble-a-left"></div>
    <div class="closewidget">
        <a href="javascript:;" onclick="closeWidget('chatwidget')">
            <img src="_resources/images/icon-x16-cross.png" />
        </a>
    </div>
</div>