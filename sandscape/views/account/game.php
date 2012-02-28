<?php $this->title = 'Game Information [' . $game->gameId . ']'; ?>

<h2><?php echo $this->title ?></h2>

<div class="span-22 last">
    <table>
        <tr>
            <td>Player 1:</td>
            <td>
                <?php
                echo CHtml::image('_resources/images/' .
                        ($game->player1Ready ? 'icon-x16-tick-circle.png' : 'icon-x16-cross.png'), ''
                        , array('title' => ($game->player1Ready ? 'Ready' : 'Not ready'))), '&nbsp;',
                CHtml::link($game->player10->name, $this->createUrl('account/profile'
                                , array('id' => $game->player1))
                );
                ?>
            </td>
        </tr>
        <tr>
            <td>Player 2:</td>
            <td>
                <?php
                if ($game->player2) {
                    echo CHtml::image('_resources/images/' .
                            ($game->player2Ready ? 'icon-x16-tick-circle.png' : 'icon-x16-cross.png')
                            , '', array('title' => ($game->player2Ready ? 'Ready' : 'Not ready'))), '&nbsp;',
                    CHtml::link($game->player20->name, $this->createUrl('account/profile'
                                    , array('id' => $game->player2))
                    );
                } else {
                    ?>
                    No opponent yet.
                <?php } ?>
            </td>
        </tr>
        <?php if ($game->winnerId) { ?>
            <tr>
                <td>Winner was:</td>
                <td><?php echo $game->winner->name; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>Created at:</td>
            <td><?php echo $game->created; ?></td>
        </tr>
        <?php if ($game->started) { ?>
            <tr>
                <td>Started at:</td>
                <td><?php echo $game->started; ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td>Game status:</td>
            <td><?php echo ($game->running ? 'Running' : ($game->paused ? 'Paused' : ($game->ended ? 'Finished' : 'Unknown'))); ?></td>
        </tr>
        <tr>
            <td>Extra:</td>
            <td>
                Using <?php echo $game->maxDecks; ?> deck(s)<?php echo ($game->graveyard ? ' and graveyard' : ''); ?>.<br />
                <?php if ($game->ended || !$game->started || ($game->running || $game->paused)) { ?>
                    Spectators are able to speak in game chat.
                <?php } else if ($game->ended) { ?>
                    Spectators were able to speak in game chat.
                <?php } ?>
            </td>
        </tr>
    </table>
    <h3>Own Decks</h3>
    <table>
        <?php
        foreach ($game->decks as $deck) {
            if ($deck->userId == Yii::app()->user->id) {
                ?>
                <tr>
                    <td><?php echo CHtml::link($deck->name, $this->createUrl('decks/view', array('id' => $deck->deckId))); ?></td>
                    <td><?php echo count($deck->deckCards); ?> cards</td>
                    <!-- <td><?php $this->widget('CStarRating', array('name' => 'rating')); ?></td> -->
                    <td>
                        <?php
                        echo CHtml::link(CHtml::image('_resources/images/icon-x16-document-pencil.png', ''
                                        , array('title' => 'Edit notes')), 'javascript:;'
                                , array('onclick' => 'editNotes(' . $game->gameId . ',' . $deck->deckId . ')')
                        );
                        ?>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>
</div>