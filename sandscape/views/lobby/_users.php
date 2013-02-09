<div id="users-area" class="well">
    <?php
    /*$this->widget('zii.widgets.jui.CJuiSlider', array(
        'id' => 'users-slider',
        'options' => array(
            'value' => 100,
            'animate' => true,
            'orientation' => 'vertical',
        //'slide' => 'js:usersSliderScroll',
        //'change' => 'js:usersSliderChange'
        )
    ));*/
    ?>
    <div id="users-view">
        <ul id="users-list">
            <?php foreach ($users as $user) { ?>
                <li>
                    <a href="<?php echo $this->createURL((Yii::app()->user->id != $user->id ? 'account/profile' : '/account'), array('id' => $user->id)); ?>">
                        <?php echo $user->name; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>