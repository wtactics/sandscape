<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu
        )
);
?>

<div class="clear"></div>
<h1>Create Card</h1>

<?php echo $this->renderPartial('_form', array('model' => $card, 'image' => $image)); ?>