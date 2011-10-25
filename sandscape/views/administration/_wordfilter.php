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
    <?php echo CHtml::label('Word Filter', 'wfilter'), '<br />', CHtml::textArea('wfilter'); ?>
</p>
<?php $this->endWidget(); ?>