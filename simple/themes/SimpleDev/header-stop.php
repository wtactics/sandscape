<title><?php echo $this->getTranslatedString('STAY_GENERAL_ADMINISTRATION'); ?></title>
</head>
<body>
    <div id="header">
        <span id="headertools">
            <a href="<?php echo StaySimple::app()->getURL(); ?>" target="_blank"><img src="<?php echo $this->getAssetLink('images/icons/eye.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_ADMIN_VIEW_SITE_ICON'); ?>" title="<?php echo $this->getTranslatedString('STAY_ADMIN_VIEW_SITE_ICON'); ?>" /></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $this->createURL('settings'); ?>"><img src="<?php echo $this->getAssetLink('images/icons/setting_tools.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_ADMIN_SETTINGS_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_ADMIN_SETTINGS_ICON_TITLE'); ?>" /></a>
            <a href="<?php echo $this->createURL('users/account'); ?>"><img src="<?php echo $this->getAssetLink('images/icons/user_orange.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_ADMIN_ACCOUNT_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_ADMIN_ACCOUNT_ICON_TITLE'); ?>" /></a>
            <a href="<?php echo $this->createURL('login/logout'); ?>"><img src="<?php echo $this->getAssetLink('images/icons/door_in.png', 'ui'); ?>" alt="<?php echo $this->getTranslatedString('STAY_ADMIN_LOGOUT_ICON_TITLE'); ?>" title="<?php echo $this->getTranslatedString('STAY_ADMIN_LOGOUT_ICON_TITLE'); ?>" /></a>
        </span>
        <h1><?php echo Config::getInstance()->get('site.name'); ?></h1>
        <div id="menu">
            <ul id="nav">
                <li><a href="<?php echo $this->createURL('dashboard'); ?>"><?php echo $this->getTranslatedString('STAY_DASHBOARD'); ?></a></li>
                <li><a href="<?php echo $this->createURL('pages'); ?>"><?php echo $this->getTranslatedString('STAY_PAGE'); ?></a></li>
                <?php
                foreach (Plugin::getActivePlugins() as $pluginName) {
                    $plugin = Plugin::plugin($pluginName);
                    if ($plugin instanceof IPluginAdministration) {
                        foreach ($plugin->getAdminOptions() as $option) {
                            ?> 
                            <li><a href="<?php echo $this->createURL($option->controller); ?>"><?php echo $option->name ?></a></li> 
                            <?php
                        }
                    }
                }
                ?>
                <li><a href="<?php echo $this->createURL('users'); ?>"><?php echo $this->getTranslatedString('STAY_USER'); ?></a></li>
                <li><a href="<?php echo $this->createURL('plugins'); ?>"><?php echo $this->getTranslatedString('STAY_PLUGINS'); ?></a></li>
            </ul>
        </div>
    </div>
    <div id="content">
