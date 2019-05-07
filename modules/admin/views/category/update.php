<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */

$this->title = 'Редагування категорії: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категорії', 'url' => Url::to(['index'])];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => Url::to(['view', 'id' => $model->id])];
$this->params['breadcrumbs'][] = 'Редагувати';
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
