<?php
/** @var StatesController $this */
$this->title = Yii::t('sandscape', 'New State');
?>

<h2><?php echo Yii::t('sandscape', 'New State'); ?></h2>

<?php
echo $this->renderPartial('_form', array('state' => $state));
