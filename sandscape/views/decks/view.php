<?php
/** @var $this DecksController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $deck,
    'attributes' => array(
        'id',
        'name',
        'createdOn'
    ),
));
if ($deck->back) {
    ?>
    <!-- <h4><?php echo Yii::t('interface', 'Current Image'); ?></h4> -->
    <ul class="thumbnails">
        <li class="span3">
            <a href="#" class="thumbnail" rel="tooltip" data-title="<?php echo Yii::t('interface', 'Deck Back Image'); ?>">
                <img src="<?php echo Yii::app()->baseUrl, '/gamedata/decks/', $deck->back; ?>" alt="" />
            </a>
        </li>
    </ul>
    <?php
}
$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('decks/update', array('id' => $deck->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));