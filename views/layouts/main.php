<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\rbac\Rbac;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Кулінарні рецепти',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    $menuItems = [
        ['label' => 'Головна', 'url' => Url::to(['/'])],
    ];

    if (Yii::$app->user->isGuest){
        $menuItems[]=['label'=>'Реєстрація', 'url' => Url::to(['/site/signup'])];
        $menuItems[]=['label'=>'Вхід', 'url' => Url::to(['/site/login'])];
    } else {
        if (Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL)){
        $menuItems[] = ['label' => 'Адмінська частина', 'url' => Url::to(['/admin/user/index'])];
        };
        $menuItems[] = ['label' => 'Профіль', 'url' => Url::to(['/profile'])];
        $menuItems[] = '<li>'
            .Html::beginForm(['/site/logout'],'post')
            .Html::submitButton(
                    'Вийти ('.Yii::$app->user->identity->username.')',
                    ['class' => 'btn btn-link logout']
            )
            .Html::endForm()
            .'</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>

</div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
