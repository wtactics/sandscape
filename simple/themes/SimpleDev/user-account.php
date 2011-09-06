<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_USER_ACCOUNT_TITLE'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('users/account'); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_USER_ACCOUNT_INFO_SECTION'); ?></legend>
            <p>
                <label for="name"><?php echo $this->getTranslatedString('STAY_USER_NAME'); ?></label>
                <?php echo new TextField($this->user, 'name'); ?>
            </p>
            <p>
                <label for="email"><?php echo $this->getTranslatedString('STAY_GENERAL_EMAIL'); ?></label>
                <?php echo new TextField($this->user, 'email'); ?>
                <span class="required">*</span>
            </p>
            <p>
                <label for="password"><?php echo $this->getTranslatedString('STAY_GENERAL_PASSWORD'); ?></label>
                <?php echo new PasswordField('password'); ?>
                <span class="required">*</span>
            </p>
            <p>
                <label for="rpassword"><?php echo $this->getTranslatedString('STAY_USER_REPEAT_PASSWORD'); ?></label>
                <?php echo new PasswordField('rpassword'); ?>
                <span class="required">*</span>
            </p>
        </fieldset>
        <p>
            <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_SAVE')); ?>
            &nbsp;&nbsp;
            <a href="<?php echo $this->createURL('dashboard'); ?>"><?php echo $this->getTranslatedString('STAY_GENERAL_CANCEL'); ?></a>
        </p>
        <input type="hidden" name="User" id="User" value="User" />
    </form>
</div>

<div id="righ">
    <div class="box">
    </div>
</div>