<div id="joindlg">
    <?php echo CHtml::beginForm($this->createURL('lobby/join'), 'post', array('id' => 'joinform')); ?>
    <h2>Join Game</h2>
    <div class="lobby-dlg-only success">
        <h3>Deck Options</h3>
        <p class="deck-list">
            <?php
            echo CHtml::label('Available Decks:', 'deckList'), '<br />',
            CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'), array(
                'class' => 'marker',
                'onchange' => 'limitDeckSelection("#btnJoin")',
            ));
            ?>
        </p>
    </div>
    <p>
        <?php
        echo CHtml::submitButton('I\'m Ready!', array(
            'name' => 'JoinGame',
            'id' => 'btnJoin',
            'disabled' => 'disabled',
            'class' => 'button'
        ));
        ?>
    </p>
    <?php
    echo CHtml::hiddenField('game'), CHtml::hiddenField('maxDecks', null, array('id' => 'maxDecksJoin')),
    CHtml::endForm();
    ?>
</div>
