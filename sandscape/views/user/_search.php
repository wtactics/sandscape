<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>

    <div class="row">
<?php echo $form->label($model, 'userId'); ?>
<?php echo $form->textField($model, 'userId', array('size' => 10, 'maxlength' => 10)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'email'); ?>
<?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'name'); ?>
<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'admin'); ?>
<?php echo $form->textField($model, 'admin'); ?>
    </div>

    <div class="row">
<?php echo $form->label($model, 'active'); ?>
<?php echo $form->textField($model, 'active'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->