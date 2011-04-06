<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'newgame-form',
                'enableAjaxValidation' => false,
            ));

    echo 'Private game?&nbsp;',  CHtml::checkBox('private');


    $this->endWidget();
    ?>

</div><!-- form -->