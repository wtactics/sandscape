<?php

/** @var CardsController $this */
$this->title = Yii::t('sandsacpe', 'Edit Card');

echo $this->renderPartial('_form', array('card' => $card));
<?php
$this->title = ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter');

if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
}
?>

<h2><?php echo ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('counter' => $counter));
