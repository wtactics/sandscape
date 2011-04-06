<?php
$this->widget('zii.widgets.CMenu', array(
    'id' => 'submenu',
    'items' => $menu
        )
);
?>

<div class="clear"></div>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('card-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Cards</h1>

<!-- START: search-form -->
<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none"> <?php $this->renderPartial('_search', array('model' => $model)); ?></div>
<!-- END: search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', $grid); ?>
