<div style="display:none;">
    <?php
    $this->renderPartial('_labeldlg');

    $this->renderPartial('_cardcounterdlg');

    $this->renderPartial('_exitdlg', array('gameId' => $gameId));
    ?>
</div>