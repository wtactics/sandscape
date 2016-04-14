<?php

use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $processo common\models\Processo */
/* @var $filter app\models\filters\Aditamentos */

$roleCallback = function($model, $key, $index, $column) {
    return $model->roleLabel();
};
?>
<strong><i class=""></i> <?= Yii::t('sandscape', 'Users') ?></strong><hr />

<?=
GridView::widget([
    'dataProvider' => $filter->search(Yii::$app->request->get()),
    'filterModel' => $filter,
    'layout' => '{items} {summary} {pager}',
    'columns' => [
        [
            'attribute' => 'name'
        ],
        [
            'attribute' => 'email'
        ],
        [
            'attribute' => 'role',
            'content' => $roleCallback,
            'filter' => User::roleList()
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<div class="btn-group">{view} {update} {delete}</div>',
            'headerOptions' => ['style' => 'text-align: center; width: 130px;'],
            'contentOptions' => ['style' => 'text-align: center;'],
            'buttons' => [
            //'update' => $updateCallback,
            //'delete' => $deleteCallback
            ]
        ]
    ]
])
?> 
