<?php $this->title = ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter'); ?>

<h2><?php echo ($counter->isNewRecord ? 'Create Player Counter' : 'Edit Player Counter'); ?></h2>   

<?php
echo $this->renderPartial('_form', array('counter' => $counter));
