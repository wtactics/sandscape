<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'game-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'player1'); ?>
		<?php echo $form->textField($model,'player1',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'player1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'player2'); ?>
		<?php echo $form->textField($model,'player2',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'player2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'started'); ?>
		<?php echo $form->textField($model,'started'); ?>
		<?php echo $form->error($model,'started'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ended'); ?>
		<?php echo $form->textField($model,'ended'); ?>
		<?php echo $form->error($model,'ended'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'running'); ?>
		<?php echo $form->textField($model,'running'); ?>
		<?php echo $form->error($model,'running'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deck1'); ?>
		<?php echo $form->textField($model,'deck1',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'deck1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deck2'); ?>
		<?php echo $form->textField($model,'deck2',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'deck2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'private'); ?>
		<?php echo $form->textField($model,'private'); ?>
		<?php echo $form->error($model,'private'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->