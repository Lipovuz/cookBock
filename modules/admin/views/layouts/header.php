<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a(
            '<span class="logo-mini">Blog</span><span class="logo-lg">' . 'Blog' . '</span>',
            Yii::$app->homeUrl,
            ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if (!Yii::$app->user->identity->img == null) {
                            echo Html::img(
                                    "@web/img/" . Yii::$app->user->identity->img,
                                    ['class' => 'user-image', 'alt' => 'User Image']);
                        }else{
                            echo Html::img(
                                    "@web/img/no-image.png",
                                    ['class' => 'user-image', 'alt' => 'User Image']);
                        }
                        ?>
                        <span class="hidden-xs"><?=Yii::$app->user->identity->name?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if (!Yii::$app->user->identity->img == null) {
                                echo Html::img(
                                        "@web/img/" . Yii::$app->user->identity->img,
                                        ['class' => 'img-circle', 'alt' => 'User Image']);
                            }else{
                                echo Html::img(
                                        "@web/img/no-image.png",
                                        ['class' => 'img-circle', 'alt' => 'User Image']);
                            }
                            ?>
                            <p>
                                <?=Yii::$app->user->identity->name?> - <?=Yii::$app->user->identity->role?>
                                <small>E-mail:<?=Yii::$app->user->identity->email?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?=Html::a(
                                        'Профіль',
                                        Url::to(['/profile']),
                                    ['class' => 'btn btn-default btn-flat'])?>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Вихід',
                                    Url::to(['/site/logout']),
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
