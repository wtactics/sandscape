<?php
/** @var StatesController $this */
$this->title = Yii::t('sandscape', 'Edit State');
?>

<h2><?php echo Yii::t('sandscape', 'Edit State'); ?></h2>

<?php
echo $this->renderPartial('_form', array('state' => $state));
