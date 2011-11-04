<?php echo CHtml::form($this->createURL('administration/savewords')); ?>
<p>
    You can configure words to be filtered in chat messages. Separate each word 
    by a comma [ , ].
</p>
<p>
    <?php echo CHtml::label('Word Filter', 'wfilter'), '<br />', CHtml::textArea('wfilter', $words); ?>
</p>
<p>
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</p>
<?php Chtml::endForm(); ?>