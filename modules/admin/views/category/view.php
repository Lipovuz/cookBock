<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */

$this->title = 'Категорія: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => Url::to(['index'])];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редагувати',Url::to(['update', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити',Url::to(['delete', 'id' => $model->id]), [
            'class' => 'btn btn-danger',
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
            'name',
            [
                'attribute' => 'parent_id',
                'value' => $model->parentCategory ? $model->parentCategory->name : 'Самостоятельная категория',
            ],
            [
                'attribute' => 'status',
                'value' => function($data){
                    return User::getStatuses()[$data->status];
                },
                'format' => 'html',
            ],
            'meta_description',
            'meta_keywords',
        ],
    ]) ?>

</div>
