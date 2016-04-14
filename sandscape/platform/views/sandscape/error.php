<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<strong><i class="fa fa-warning"></i> <?= $name ?></strong>
<hr />

<div class="well">
    <p><?= nl2br(Html::encode($message)) ?></p>
</div>

