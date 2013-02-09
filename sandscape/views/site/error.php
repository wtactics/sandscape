<?php $this->title = Yii::t('interface', 'Unexpected Error!'); ?>

<h2><?php echo Yii::t('interface', 'Oops!'); ?></h2>

<p>
    <?php echo Yii::t('interfaca', 'The system encountered an error and was unable to process the request. The error message is:'); ?>
</p>
<pre>
    <?php echo $message; ?>
</pre>
