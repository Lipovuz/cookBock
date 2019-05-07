<?php

use app\models\Recipe;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\MenuWidget;

/**
 * @var Recipe[] $recipe
 */

$this->title = 'Головна';
?>
<div class="site-index container">
    <div class="row">
        <div class="">

            <h2>Категорії</h2>
            <div>
            <ul id="menu-dashboard" class="col-md-2 menu catalog nav nav-pills nav-stacked">
                <li><?=MenuWidget::widget(['tpl'=>'menu']) ?></li>
            </ul>
            </div>
            <div class="text-center">
                <h1>Книга кулінарних рецептів!!!</h1>
                <?= Html::img(Url::to('@web/img/bock.png'), ['width' => '800px'])?>
            </div>
        </div>

    </div>

</div>

