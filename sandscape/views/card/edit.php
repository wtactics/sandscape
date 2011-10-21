<h2><?php echo ($card->isNewRecord ? 'Create Card' : 'Edit Card'); ?></h2>
<?php echo $this->renderPartial('_form', array('card' => $card)); ?>