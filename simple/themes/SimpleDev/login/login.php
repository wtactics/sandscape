<div class="login">
    <form action="<?php echo $this->createURL('login/login'); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_LOGIN'); ?></legend>
            <p>
                <label for="email"><?php echo $this->getTranslatedString('STAY_GENERAL_EMAIL'); ?>:</label>
                <?php echo new TextField(null, 'email'); ?>
            </p>
            <p>
                <label for="password"><?php echo $this->getTranslatedString('STAY_GENERAL_PASSWORD'); ?>:</label>
                <?php echo new PasswordField('password'); ?>
                <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_OK')); ?>
            </p>
            <?php $this->includeTemplateFile('_messages'); ?>
            <div id="recoverdiv">
                <a href="<?php echo $this->createURL('login/recover'); ?>"><?php echo $this->getTranslatedString('STAY_LOGIN_RECOVER_PASSWORD'); ?></a>
                <br /><br />
                <a href="<?php echo StaySimple::app()->getURL(); ?>"><?php echo $this->getTranslatedString('STAY_ADMIN_VIEW_SITE_ICON'); ?></a>
            </div>
        </fieldset>
    </form>
</div>
