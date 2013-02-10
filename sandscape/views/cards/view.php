<?php
/** @var $this CardsController */
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $card,
    'attributes' => array(
        'id',
        'name',
        array(
            'name' => 'backFrom',
            'value' => $card->backOriginString()
        ),
        array(
            'name' => 'cardscapeId',
            'value' => $card->cardscapeId ? $card->cardscapeId : '-'
        ),
        'rules',
    ),
));

if ($card->face || $card->back) {
    ?>
    <!-- <h4><?php echo Yii::t('interface', 'Current Images'); ?></h4> -->
    <ul class="thumbnails">
        <?php if ($card->face) { ?>
            <li class="span3">
                <a href="#" class="thumbnail" rel="tooltip" data-title="<?php echo Yii::t('interface', 'Card Face'); ?>">
                    <img src="<?php echo Yii::app()->baseUrl, '/gamedata/cards/', $card->face; ?>" alt="" />
                </a>
            </li>
            <?php
        }
        if ($card->back) {
            ?>
            <li class="span3">
                <a href="#" class="thumbnail" rel="tooltip" data-title="<?php echo Yii::t('interface', 'Card Back'); ?>">
                    <img src="<?php echo Yii::app()->baseUrl, '/gamedata/cards/', $card->back; ?>" alt="" />
                </a>
            </li>
        <?php } ?>
    </ul>
    <?php
}

$this->widget('bootstrap.widgets.TbButton', array(
    'url' => $this->createUrl('cards/update', array('id' => $card->id)),
    'label' => Yii::t('interface', 'Edit'),
    'type' => 'info'
));
