<?php
/** @var BootActiveForm $form */
/** @var UsersController $this */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'user-form',
    'type' => 'horizontal',
    'enableAjaxValidation' => true,
    'focus' => array($user, 'name'),
        ));
?>

<legend><?php echo Yii::t('sandscape', 'Public Information'); ?></legend>


<?php
echo $form->textFieldRow($user, 'name', array('maxlength' => 150)),
 $form->textFieldRow($user, 'email', array('maxlength' => 255)),
 $form->dropDownListRow($user, 'role', User::rolesArray()),
 $form->textFieldRow($user, 'website', array('maxlength' => 255)),
 $form->textFieldRow($user, 'twitter', array('maxlength' => 255)),
 $form->textFieldRow($user, 'facebook', array('maxlength' => 255)),
 $form->textFieldRow($user, 'googleplus', array('maxlength' => 255)),
 $form->textFieldRow($user, 'skype', array('maxlength' => 255)),
 $form->dropDownListRow($user, 'country', array_merge(array('' => ''), User::countries()));

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label' => Yii::t('sandscape', 'Save'),
    'type' => 'success'
));

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('users/index'),
    'label' => Yii::t('sandscape', 'Cancel'),
    'type' => 'warning'
));
?>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'counter-form')); ?>
<fieldset>
    <legend>Player Counter information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'name'),
        $form->textField($counter, 'name', array('maxlength' => 150, 'class' => 'large'));
        ?>
    </div>
    <?php echo $form->error($counter, 'name'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'startValue'),
        $form->textField($counter, 'startValue', array('class' => 'numeric'));
        ?>
    </div>
    <?php echo $form->error($counter, 'startValue'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'step'),
        $form->textField($counter, 'step', array('class' => 'numeric'));
        ?>
    </div>
    <?php echo $form->error($counter, 'step'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($counter, 'available'), $form->checkBox($counter, 'available');
        ?>
    </div>
    <?php echo $form->error($counter, 'available'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton('Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('counters/index'));
    ?>
</div>
<?php
$this->endWidget();