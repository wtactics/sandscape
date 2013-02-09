<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'createdlg')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('interface', 'Create a New Game'); ?></h4>
</div>

<div class="modal-body">
    <p>One fine body...</p>
</div>

<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'primary',
        'label' => 'Save changes',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Close',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>

<?php
$this->endWidget();
