<div id="joindlg" class="lobbydlg">
    <h2>Join Game</h2>

    <?php echo CHtml::beginForm($this->createURL('lobby/join'), 'post', array('id' => 'joinform')); ?>

    <fieldset>
        <legend>Deck Options</legend>
        <div class="dlgrow">
            <?php
            echo CHtml::label('Available Decks:', 'deckList'),
            CHtml::checkBoxList('deckList', array(), CHtml::listData($decks, 'deckId', 'name'), array(
                'class' => 'marker',
                'onchange' => 'limitDeckSelection("#btnJoin")',
            ));
            ?>
        </div>
        <div class="dlgbuttons">
            <?php
            echo CHtml::submitButton('I\'m Ready!', array(
                'name' => 'JoinGame',
                'id' => 'btnJoin',
                'disabled' => 'disabled',
                'class' => 'button'
            )),
            CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
            ?>
        </div>
    </fieldset>
    <?php
    echo CHtml::hiddenField('game'), CHtml::hiddenField('maxDecks', null, array('id' => 'maxDecksJoin')),
    CHtml::endForm();
    ?>
</div>
