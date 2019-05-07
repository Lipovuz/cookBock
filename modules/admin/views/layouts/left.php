<?php
use dmstr\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<section class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (!Yii::$app->user->identity->img == null) {
                    echo Html::img(
                        "@web/img/" . Yii::$app->user->identity->img);
                }else{
                    echo Html::img(
                        "@web/img/no-image.png");
                }
                ?>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->username?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <?= Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu admin', 'options' => ['class' => 'header']],
                    ['label' => 'Головна', 'icon' => ' fa-database', 'url' => Url::to(['/'])],
                    ['label' => 'Профіль', 'icon' => ' fa-user', 'url' => Url::to(['/profile'])],
                    ['label' => 'Категорії', 'icon' => ' fa-list-alt', 'url' => Url::to(['/admin/category/index'])],
                    ['label' => 'Статті', 'icon' => ' fa-file-text', 'url' => Url::to(['/profile/recipe/index'])],
                    ['label' => 'Користувачі', 'icon' => ' fa-users','url' => Url::to(['/admin/user/index'])],
                ],
            ]
        ) ?>
    </section>
</section>
