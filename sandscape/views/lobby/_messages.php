<div id="chat-area" class="well">
    <?php
    /* $this->widget('zii.widgets.jui.CJuiSlider', array(
      'id' => 'chat-slider',
      'options' => array(
      'max' => 0,
      'animate' => true,
      'orientation' => 'vertical',
      //'slide' => 'js:chatSliderScroll',
      //'change' => 'js:chatSliderChange',
      //'create' => 'js:chatSliderSetValue'
      )
      )); */
    ?>
    <div id="chat-view">
        <ul id="messages-list">
            <?php foreach ($messages as $message) { ?>
                <li>
                    <strong><?php echo $message->user->name; ?>:</strong>&nbsp;
                    <?php echo CHtml::encode($message->message); ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>