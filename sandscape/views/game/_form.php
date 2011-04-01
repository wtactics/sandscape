<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'game-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'playerA'); ?>
		<?php echo $form->textField($model,'playerA',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'playerA'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'playerB'); ?>
		<?php echo $form->textField($model,'playerB',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'playerB'); ?>
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
		<?php echo $form->labelEx($model,'deckA'); ?>
		<?php echo $form->textField($model,'deckA',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'deckA'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'deckB'); ?>
		<?php echo $form->textField($model,'deckB',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'deckB'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'hash'); ?>
		<?php echo $form->textField($model,'hash',array('size'=>8,'maxlength'=>8)); ?>
		<?php echo $form->error($model,'hash'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'chatId'); ?>
		<?php echo $form->textField($model,'chatId',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'chatId'); ?>
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