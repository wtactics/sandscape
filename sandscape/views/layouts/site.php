<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="<?php echo Yii::app()->baseUrl; ?>/_resources/css/sandscape/main<?php echo (YII_DEBUG ? '' : '.min'); ?>.css" rel="stylesheet" type="text/css" media="screen, projection" />

        <title><?php echo $this->title; ?></title>
    </head>
    <body>
        <div id="header">
            <h1><a href="<?php echo Yii::app()->baseUrl; ?>">Sandscape</a></h1>
            <div id="accounttools">
                <?php if (Yii::app()->user->isGuest) { ?>
                    <a href="<?php echo $this->createUrl('site/login'); ?>">Login / Register</a>
                <?php } else { ?>
                    <a href="<?php echo $this->createUrl('account/index'); ?>">Account</a>
                    <a href="<?php echo $this->createUrl('site/logout'); ?>">Logout</a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
            <div id="menu">
                <?php $this->widget('zii.widgets.CMenu', array('items' => $this->menu, 'encodeLabel' => false)); ?>
                <div class="clearfix"></div>
            </div>
        </div>

        <div id="content">
            <?php echo $content; ?>
        </div>

        <div id="footer">
            <div id="footerleft">
                <ul>
                    <li><a href="<?php echo $this->createUrl('site/attribution'); ?>">Due Attribution</a></li>
                    <li><a href="http://www.wtactics.org">WTactics.org Project</a></li>
                    <li><a href="http://sourceforge.net/projects/sandscape">Sandscape@sourceforge.net</a></li>
                </ul>
            </div>
            <div id="footerright">
                <ul>
                    <li>Running "Serenity" Milestone</li>
                    <li><span><?php echo $this->gameCount; ?></span> active game(s) and <span><?php echo $this->deckCount; ?></span> deck(s) from <?php echo $this->userCount; ?> user(s)</li>
                    <li>Server time is <span><?php echo date('Y-m-d H:i:s'); ?></span></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </body>
</html>