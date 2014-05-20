<?php
/** @var TokensController $this */
$this->title = Yii::t('sandscape', 'New Token');
?>

<h2><?php echo Yii::t('sandscape', 'New Token'); ?></h2>

<?php
echo $this->renderPartial('_form', array('token' => $token));
