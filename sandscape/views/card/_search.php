<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'cardId'); ?>
		<?php echo $form->textField($model,'cardId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'faction'); ?>
		<?php echo $form->textField($model,'faction',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'subtype'); ?>
		<?php echo $form->textField($model,'subtype',array('size'=>60,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'threshold'); ?>
		<?php echo $form->textField($model,'threshold',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attack'); ?>
		<?php echo $form->textField($model,'attack'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'defense'); ?>
		<?php echo $form->textField($model,'defense'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rules'); ?>
		<?php echo $form->textField($model,'rules',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'revision'); ?>
		<?php echo $form->textField($model,'revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cardscapeId'); ?>
		<?php echo $form->textField($model,'cardscapeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'imageId'); ?>
		<?php echo $form->textField($model,'imageId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'private'); ?>
		<?php echo $form->textField($model,'private'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->