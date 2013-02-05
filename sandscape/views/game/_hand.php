<div id="handnob" class="nob">
    <u>
        <li>
            <a href="javascript:;" onclick="showHandWidget()">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/gameboard/W_Book01.png" />
            </a>
        </li>
    </u>
</div>

<div id="handwidget" class="menububble">
    <div class="hand"><!-- WHERE HAND CARDS WILL BE PLACED --></div>
    <div class="menububble-ab-bottom"></div>
    <div class="menububble-a-bottom"></div>
    <div class="closewidget">
        <a href="javascript:;" onclick="hideHandWidget()">
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/general/icon-x16-cross.png" />
        </a>
    </div>
</div>