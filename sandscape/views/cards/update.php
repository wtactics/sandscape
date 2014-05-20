<?php
/** @var CardsController $this */
$this->title = Yii::t('sandscape', 'Edit Card');
?>

<h2><?php echo Yii::t('sandscape', 'Edit Card'); ?></h2>

<?php
echo $this->renderPartial('_form', array('card' => $card));
