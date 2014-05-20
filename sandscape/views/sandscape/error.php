<?php $this->title = Yii::t('sandscape', 'Unexpected Error!'); ?>

<h2><?php echo Yii::t('sandscape', 'Oops!'); ?></h2>

<p>
    <?php echo Yii::t('sandscape', 'The system encountered an error and was unable to process the request.'); ?>
</p>

<pre>
    <?php echo $message; ?>
</pre>
