<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'gameId'); ?>
		<?php echo $form->textField($model,'gameId',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'player1'); ?>
		<?php echo $form->textField($model,'player1',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'player2'); ?>
		<?php echo $form->textField($model,'player2',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'started'); ?>
		<?php echo $form->textField($model,'started'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ended'); ?>
		<?php echo $form->textField($model,'ended'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'running'); ?>
		<?php echo $form->textField($model,'running'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deck1'); ?>
		<?php echo $form->textField($model,'deck1',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deck2'); ?>
		<?php echo $form->textField($model,'deck2',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'private'); ?>
		<?php echo $form->textField($model,'private'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->