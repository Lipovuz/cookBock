<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
?>

<hr>
<div class="recipe-wrapper">
    <a href="<?=Url::to(['recipe/view', 'recipe_slug'=>$model->slug,'category_slug'=>$model->category->slug])?>">
        <div class="recipe-header">
            <p><?= $model->name ?></p>

        </div>
    </a>
    <p class="preview">
       <?php
        if (!$model->preview == null){
            echo Html::img("@web/img/{$model->preview}",['width'=>90, 'height'=>90]) ;
        }
        ?>
        <?=$model->description?>
    </p>
</div>
