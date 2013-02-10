<?php
/** @var $this StatesController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $state,
    'attributes' => array(
        'id',
        'name',
        'description'
    ),
));
if ($state->image) {
    ?>
    <!-- <h4><?php echo Yii::t('interface', 'Current Image'); ?></h4> -->
    <ul class="thumbnails">
        <li class="span3">
            <a href="#" class="thumbnail" rel="tooltip" data-title="<?php echo Yii::t('interface', 'State Image'); ?>">
                <img src="<?php echo Yii::app()->baseUrl, '/gamedata/states/', $state->image; ?>" alt="" />
            </a>
        </li>
    </ul>
    <?php
}
$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('states/update', array('id' => $state->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));