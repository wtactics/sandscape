TODO: not implemented yet.
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => 'p'
    )
        ));
?>

<p>
    <?php echo CHtml::label('', ''), '<br />'; ?>
</p>
<?php $this->endWidget(); ?>