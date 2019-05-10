<?php

use app\models\Kitchens;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\rbac\Rbac;
use app\models\User;
use app\modules\admin\models\Category;
use yii\helpers\Url;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\models\Recipe */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::find()
        ->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'kitchens_id')->dropDownList(ArrayHelper::map(Kitchens::find()
        ->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),]);?>

    <?php
    if (!$model->preview == null){ ?>
        <b>Прев'ю</b><br>
        <?=Html::img("@web/img/{$model->preview}",['width'=>200,'height'=>200]) ?>
        <a href="<?= Url::to(['recipe/image-delete', 'id' => $model->id]) ?>"
           onclick="return confirm('При видалені прев\'ю, сторінка буде перезапущена')" >Видалити прев'ю</a><br>
    <?php } else {
        echo $form->field($model, 'preview')->fileInput();
    }?>

    <?php if (Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
        ?>
        <b>Додаткові поля</b>
        <div class="meta">
            <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
        </div>
        <?= $form->field($model, 'status')->dropDownList(User::getStatuses());
    }?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>

</div>
