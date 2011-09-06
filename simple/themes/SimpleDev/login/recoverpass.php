<div class="login">
    <form action="<?php echo $this->createURL('login/recover'); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_LOGIN_RECOVER_TITLE'); ?></legend>
            <p>
                <label for="email"><?php echo $this->getTranslatedString('STAY_GENERAL_EMAIL'); ?>:</label>
                <?php echo new TextField(null, 'email'); ?>
                <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_OK')); ?>
            </p>
            <?php $this->includeTemplateFile('_messages'); ?>
            
            <input type="hidden" name="doRecover" value="doRecover" />
        </fieldset>
    </form>
</div>
