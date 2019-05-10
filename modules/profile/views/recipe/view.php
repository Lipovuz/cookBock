<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
?>

<div class="recipe-view view">
    <h1 style="text-align: center"><?=$model->name?></h1>
    <h3>Вид кухні: "<?=$model->kitchens->name?>"</h3>
        <?php if (!$model->preview == null)
            echo Html::img("@web/img/{$model->preview}", ['width' => 400, 'height' => 400]);
        ?>
    <br>
    <p><?=$model->text?></p>
</div>
