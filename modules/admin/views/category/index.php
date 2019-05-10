<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Усі категорії';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавити категорію', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'parent_id',
                'value' => function($data){
                    return $data->parentCategory ? $data->parentCategory->name : 'Самостоятельная категория';
                },
            ],
            [
                'attribute' => 'status',
                'value' => function($data){
                   return User::getStatuses()[$data->status];
                 },
                'format' => 'html',
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['/admin/category/view',
                                'slug'=>$model->slug]),
                            [
                                'title' => 'Переглянути',
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
