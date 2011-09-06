<div id="left">
    <h2><?php echo ($this->user->getId() ? $this->getTranslatedString('STAY_USER_TITLE_EDIT') : $this->getTranslatedString('STAY_USER_TITLE_CREATE')); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('users/edit'), '/', $this->user->getId(); ?>" method="post">
        <fieldset>
            <legend><?php echo $this->getTranslatedString('STAY_USER_INFO_SECTION'); ?></legend>
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
            <p>
                <label for="active"><?php echo $this->getTranslatedString('STAY_USER_ACTIVE'); ?></label>
                <?php echo new CheckBox($this->user, 'active'); ?>
            </p>
        </fieldset>
        <p>
            <?php echo new SubmitButton($this->getTranslatedString('STAY_GENERAL_SAVE')); ?>
            &nbsp;&nbsp;
            <a href="<?php echo $this->createURL('users'); ?>"><?php echo $this->getTranslatedString('STAY_GENERAL_CANCEL'); ?></a>
        </p>
        <input type="hidden" name="User" id="User" value="User" />
        <input type="hidden" name="userId" id="userId" value="<?php $this->user->getId(); ?>" />
    </form>
</div>

<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('users/edit'); ?>"><?php echo $this->getTranslatedString('STAY_USER_NEW_USER'); ?></a></li>
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('users/delete'), '/', $this->user->getId(); ?>"><?php echo $this->getTranslatedString('STAY_USER_DELETE_THIS'); ?></a></li>
        </ul>
    </div>
</div>