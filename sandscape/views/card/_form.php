<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'card-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'faction'); ?>
		<?php echo $form->textField($model,'faction',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'faction'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subtype'); ?>
		<?php echo $form->textField($model,'subtype',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'subtype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cost'); ?>
		<?php echo $form->textField($model,'cost'); ?>
		<?php echo $form->error($model,'cost'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'threshold'); ?>
		<?php echo $form->textField($model,'threshold',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'threshold'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attack'); ?>
		<?php echo $form->textField($model,'attack'); ?>
		<?php echo $form->error($model,'attack'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'defense'); ?>
		<?php echo $form->textField($model,'defense'); ?>
		<?php echo $form->error($model,'defense'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rules'); ?>
		<?php echo $form->textField($model,'rules',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'rules'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'revision'); ?>
		<?php echo $form->textField($model,'revision'); ?>
		<?php echo $form->error($model,'revision'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cardscapeId'); ?>
		<?php echo $form->textField($model,'cardscapeId'); ?>
		<?php echo $form->error($model,'cardscapeId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'imageId'); ?>
		<?php echo $form->textField($model,'imageId',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'imageId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'private'); ?>
		<?php echo $form->textField($model,'private'); ?>
		<?php echo $form->error($model,'private'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->