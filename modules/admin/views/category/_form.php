<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\MenuWidget;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-category-parent_id has-success">
        <label class="control-label" for="category-parent_id">Батьківська категорія</label>
        <select id="category-parent_id" class="form-control" name="Category[parent_id]">
            <option value='<?=null?>'>Самостійна категорія</option>
            <?= MenuWidget::widget(['tpl' => 'select', 'model' => $model])?>
        </select>
    </div>

    <b>Додаткові поля</b>
    <div class="meta">

        <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList(User::getStatuses()); ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
