<?php
/** @var TokensController $this */
$this->title = Yii::t('Sandscape', 'Edit Token');
?>

<h2><?php echo Yii::t('Sandscape', 'Edit Token'); ?></h2>

<?php
echo $this->renderPartial('_form', array('token' => $token));
