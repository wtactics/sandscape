<?php $this->widget('zii.widgets.CMenu', $menu); ?>

<div class="clear"></div>

<h1>Update <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>