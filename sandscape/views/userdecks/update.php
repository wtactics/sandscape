<?php
/** @var DecksController $this */
$this->title = Yii::t('sandscape', 'Edit Deck');
?>

<h2><?php echo Yii::t('sandscape', 'Edit Deck'); ?></h2>

<?php
echo $this->renderPartial('_form', array('deck' => $deck));
