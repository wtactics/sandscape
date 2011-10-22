<div id="createdlg">
    <h2>Create Game</h2>
    <?php echo CHtml::beginForm($this->createURL('game/create')); ?>
    <p><?php echo CHtml::label('Max. Decks:', 'maxDecks'), '<br />', CHtml::textField('maxDecks', '1', array('size' => 4)); ?></p>
    <p class="deck-list">
        <?php
        echo CHtml::label('Available Decks:', 'deckList'), '<br />',
        CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'));
        ?>
    </p>
    <p><?php echo CHtml::checkBox('useGraveyard', true, array('value' => 1)), '&nbsp;', CHtml::label('Use Graveyard:', 'useGraveyard'); ?></p>
    <p><?php echo CHtml::checkBox('private', false, array('value' => 1)), '&nbsp;', CHtml::label('Private:', 'private'); ?></p>
    <p><?php echo CHtml::submitButton('Ready!', array('name' => 'CreateGame')); ?></p>

    <?php echo CHtml::endForm(); ?>
</div>
