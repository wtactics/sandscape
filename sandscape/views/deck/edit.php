<div class="span-24">
    <h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>
    <?php echo $this->renderPartial('_form', array('deck' => $deck)); ?>
</div>