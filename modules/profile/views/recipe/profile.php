<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title='Профіль|'.$model->name;?>
<div class="view-product col-sm-7">
    <?php
    if (!$model->img == null) {
        echo Html::img("@web/img/{$model->img}", ['width' => 200, 'height' => 200, 'float' => 'right']);
    }else{
        echo Html::img("@web/img/no-image.png", ['width' => 200, 'height' => 200]);
    }?>
</div>

<div class="product-information">

    <h2><?=$model->name?></h2>
    <br>
    <p><b>Nickname:</b><?=$model->username?></p>
    <p><b>E-mail:</b><?=$model->email?></p>
    <p><b>Телефон:</b><?=$model->tel?></p>
    <?= Html::a('Редагувати профіль',Url::to(['/admin/user/update','id'=>Yii::$app->user->id]), ['class' => 'btn btn-success']) ?>
</div>
<div class="recipe-index">
    <br>
    <h1>Мої статті</h1>
    <p>
    <?= Html::a('Створити рецепт', Url::to(['create']), ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description',
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category->name;
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
                            Url::to(['/profile/recipe/view',
                                'recipe_slug'=>$model->slug,
                                'category_slug'=>$model->category->slug]),
                            [
                            'title' => 'Переглянути',
                            ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
