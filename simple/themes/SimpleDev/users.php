<?php $this->registerScript('js/admin.js'); ?>
<div id="left">
    <h2><?php echo $this->getTranslatedString('STAY_USER_TITLE_LIST'); ?></h2>
    <?php $this->includeTemplateFile('_messages'); ?>
    <form action="<?php echo $this->createURL('users/deleteselected'); ?>" method="post" id="selection">
        <ul>
            <?php foreach ($this->users as $user) { ?>
                <li>
                    <span style="margin-right: 1em"><?php echo new CheckBox(null, 'select[]', array('value' => $user->getId())); ?></span>
                    <span><a href="<?php echo $this->createURL('users/edit'), '/', $user->getId(); ?>"><?php echo $user->getName(); ?></a></span>
                    <span style="float: right;">
                        <a href="<?php echo $this->createURL('users/edit'), '/', $user->getId(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/pencil.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_USER_EDIT_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_USER_EDIT_ICON_TITLE'); ?>" /></a>
                        <a href="<?php echo $this->createURL('users/delete'), '/', $user->getId(); ?>"><img src="<?php echo $this->getAssetLink('images/icons/bin.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_USER_DELETE_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_USER_DELETE_ICON_TITLE'); ?>" /></a>
                    </span>
                </li>
            <?php } ?>
        </ul>
    </form>
</div>

<div id="right">
    <div class="box">
        <ul id="tools">
            <li class="ui-corner-all"><a href="<?php echo $this->createURL('users/edit'); ?>"><?php echo $this->getTranslatedString('STAY_USER_NEW_USER'); ?></a></li>
        </ul>
    </div>
</div>