<?php
/* @var $this BaseController */
$baseUrl = Yii::app()->baseUrl;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <?php Yii::app()->bootstrap->register(); ?>


        <title><?php echo CHtml::encode($this->title); ?></title>
    </head>

    <body>
        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'brandLabel' => 'Sandscape',
            'items' => $this->nav
        ));
        ?>
        <div class="container-fluid">
            <?php echo $content; ?>  
        </div>
    </body>
</html>
