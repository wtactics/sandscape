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
		<?php echo $form->label($model,'playerA'); ?>
		<?php echo $form->textField($model,'playerA',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'playerB'); ?>
		<?php echo $form->textField($model,'playerB',array('size'=>10,'maxlength'=>10)); ?>
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
		<?php echo $form->label($model,'deckA'); ?>
		<?php echo $form->textField($model,'deckA',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'deckB'); ?>
		<?php echo $form->textField($model,'deckB',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'hash'); ?>
		<?php echo $form->textField($model,'hash',array('size'=>8,'maxlength'=>8)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'chatId'); ?>
		<?php echo $form->textField($model,'chatId',array('size'=>10,'maxlength'=>10)); ?>
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