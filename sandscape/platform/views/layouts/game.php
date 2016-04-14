<?php
/* @var $this BaseController */
$baseUrl = Yii::app()->baseUrl;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <link type="text/css" rel="stylesheet" href="<?php echo $baseUrl; ?>/css/game.css">

        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>

    <body>
        <?php echo $content; ?>

        <script src="<?php echo $baseUrl; ?>/js/zepto-1.1.3.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/fx.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/fx-methods.min.js"></script>
        <script src="<?php echo $baseUrl; ?>/js/sandscape.js"></script>

        <script type="text/javascript">
            /*<![CDATA[*/
            $(function($) {
                sandscape.initBoard();
            });
            /*]]>*/
        </script>
    </body>
</html>
