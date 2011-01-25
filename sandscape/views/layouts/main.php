<?php
$base = Yii::app()->request->baseUrl;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/main.css" />
        <title></title>
    </head>

    <body>
        <div id="site">
            <div id="header">
                <div id="logo">
                    <a href="<?php echo $base; ?>">
                        <img src="<?php echo $base; ?>/images/logo.png" alt="//TODO:" title="//TODO:" />
                    </a>
                </div>
                <div id="menu">
                    <ul>
                        <li><a href="<?php echo $base; ?>">About</a></li>
                        <li><a href="<?php echo $base; ?>/lobby">Play</a></li>
                        <li><a href="<?php echo $base; ?>/stats">Statistics</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div id="center">
                <div id="content">
                    <p>Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name. Birds taught me to sing, when they took me to their king, first I had to fly, in the sky so high so high, so high so high so high, so - if you want to sing this way, think of what you'd like to say, add a tune and you will see, just how easy it can be. Treacle pudding, fish and chips, fizzy drinks and liquorice, flowers, rivers, sand and sea, snowflakes and the stars are free. La la la la la, la la la la la la la, la la la la la la la, la la la la la la la la la la la la la, so - Barnaby The Bear's my name, never call me Jack or James, I will sing my way to fame, Barnaby the Bear's my name.</p>
                    <p>Children of the sun, see your time has just begun, searching for your ways, through adventures every day. Every day and night, with the condor in flight, with all your friends in tow, you search for the Cities of Gold. Ah-ah-ah-ah-ah... wishing for The Cities of Gold. Ah-ah-ah-ah-ah... some day we will find The Cities of Gold. Do-do-do-do ah-ah-ah, do-do-do-do, Cities of Gold. Do-do-do-do, Cities of Gold. Ah-ah-ah-ah-ah... some day we will find The Cities of Gold.</p>
                    <p>80 days around the world, we'll find a pot of gold just sitting where the rainbow's ending. Time - we'll fight against the time, and we'll fly on the white wings of the wind. 80 days around the world, no we won't say a word before the ship is really back. Round, round, all around the world. Round, all around the world. Round, all around the world. Round, all around the world.</p>
                </div>
            </div>
            <div id="footer">
                <p>
                &copy; <?php echo date('Y'); ?> <a href="#">Sandscape</a> team. | <a href="#">WTactics project</a>
                <span style="float: right">
                    <a href="#">About</a> | <a href="#">Play</a> | <a href="#">Statistics</a> | <a href="#">Top &uarr;</a>
                </span>
                </p>
            </div>
        </div>
    </body>
</html>