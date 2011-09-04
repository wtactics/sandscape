<?php
/*
 * main.php
 * 
 * This file is part of SandScape.
 * 
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 */
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/js.js" type="text/javascript"></script>
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
                    <div id="secmenu">
                        <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'encodeLabel' => false,
                            'items' => $this->getSessionMenu(),
                        ));
                        ?>
                    </div>
                    <div id="mmenu">
                        <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => $this->getMenu(),
                        ));
                        ?>
                    </div>
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
                    &copy; <?php echo date('Y'); ?> <a href="http://chaosrealm.net/wtactics/about/team/">Sandscape</a> team. | <a href="http://wtactics.org">WTactics project</a>
                    <span style="float: right">
                        <a href="<?php echo $this->createUrl('/site'); ?>">About</a> | <a href="<?php echo $this->createUrl('/lobby') ?>">Play</a> | <a href="<?php echo $this->createUrl('/stats'); ?>">Statistics</a> | <a href="<?php echo $this->createUrl('/site'); ?>">Top &uarr;</a>
                    </span>
                </p>
            </div>
        </div>
    </body>
</html>