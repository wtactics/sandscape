<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <title></title>
    </head>

    <body>
        <div id="site">
            <div id="header">
                <div id="logo">
                    <a href="<?php echo $this->createUrl('/site'); ?>">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="//TODO:" title="//TODO:" />
                    </a>
                </div>
                <div id="menu">
                    <ul>
                        <li><a href="<?php echo $this->createUrl('/site'); ?>">About</a></li>
                        <li><a href="<?php echo $this->createUrl('/lobby') ?>">Play</a></li>
                        <li><a href="<?php echo $this->createUrl('/stats'); ?>">Statistics</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div id="center">
                <div id="content">
                    <?php echo $content; ?>
                </div>
            </div>
            <div id="footer">
                <p>
                    &copy; <?php echo date('Y'); ?> <a href="#">Sandscape</a> team. | <a href="http://wtactics.org">WTactics project</a>
                    <span style="float: right">
                        <a href="<?php echo $this->createUrl('/site'); ?>">About</a> | <a href="<?php echo $this->createUrl('/lobby') ?>">Play</a> | <a href="<?php echo $this->createUrl('/stats'); ?>">Statistics</a> | <a href="<?php echo $this->createUrl('/site'); ?>">Top &uarr;</a>
                    </span>
                </p>
            </div>
        </div>
    </body>
</html>