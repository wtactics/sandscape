<?php
/** @var DiceController $this */
$this->title = Yii::t('sandscape', 'New Die');
?>

<h2><?php echo Yii::t('sandscape', 'New Die'); ?></h2>

<?php
echo $this->renderPartial('_form', array('dice' => $dice));
