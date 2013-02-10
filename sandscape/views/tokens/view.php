<?php
/** @var $this TokensController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $token,
    'attributes' => array(
        'id',
        'name',
        'description'
    ),
));
if ($token->image) {
    ?>
    <!-- <h4><?php echo Yii::t('interface', 'Current Image'); ?></h4> -->
    <ul class="thumbnails">
        <li class="span3">
            <a href="#" class="thumbnail" rel="tooltip" data-title="<?php echo Yii::t('interface', 'Token Image'); ?>">
                <img src="<?php echo Yii::app()->baseUrl, '/gamedata/tokens/', $token->image; ?>" alt="" />
            </a>
        </li>
    </ul>
    <?php
}
$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('tokens/update', array('id' => $token->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));