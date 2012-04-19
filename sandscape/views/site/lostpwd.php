<?php
$this->title = 'Recover your password';
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'recover-form',
    'enableClientValidation' => false
        )
);
?>
<h2>Recover Password</h2>

<fieldset>
    <legend>Request new password</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($recover, 'email'),
        $form->textField($recover, 'email', array('class' => 'text'));
        ?>
    </div>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Send', array('class' => 'button')); ?>
</div>

<?php
$this->endWidget();
