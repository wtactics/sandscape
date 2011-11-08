<?php
$this->title = 'Recover your password';
Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms.css');

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'recover-form',
    'enableClientValidation' => false
        )
);
?>
<h2>Recover Password</h2>
<div class="span-12 last">
    <fieldset>
        <legend>Request new password</legend>
        <p>
            <?php echo $form->labelEx($recover, 'email'), '<br />', $form->textField($recover, 'email', array('class' => 'text')); ?>
        </p>
    </fieldset>
    <p>
        <?php echo CHtml::submitButton('Send', array('class' => 'button')); ?>
    </p>
</div>
<?php
$this->endWidget();
