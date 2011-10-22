<div id="joinprivatedlg">
    <h2>Join Private Game</h2>
    <?php echo CHtml::beginForm($this->createURL('game/join'), 'post', array('id' => 'joinform')); ?>
    <p class="deck-list">
        <?php
        echo CHtml::label('Available Decks:', 'deckList'), '<br />',
        CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'));
        ?>
    </p>
    <p>
        <?php echo CHtml::label('Game ID:', 'game'), '<br />', CHtml::textField('game'); ?>
    </p>
    <p><?php echo CHtml::submitButton('Ready!', array('name' => 'JoinGame')); ?></p>
    <?php echo CHtml::endForm(); ?>
</div>
