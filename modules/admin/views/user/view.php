<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Користувач : ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Користувачі', 'url' => Url::to(['index'])];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати',
            Url::to(['update', 'id' => $model->id]),
            ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити',
            Url::to(['delete', 'id' => $model->id]),
            ['class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'email:email',
            'tel',
            'img',
            [
                'filter' => ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'),
                'attribute' => 'role',
            ],
            [
                'attribute' => 'status',
                'value' => function($data){
                    return User::getStatuses()[$data->status];
                },
                'format' => 'html',
            ],
        ],
    ]) ?>

</div>