<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\User;
use app\rbac\Rbac;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>

    <?php
    if (!$model->img == null){ ?>
        <b>Прев'ю</b><br>
        <img  width="100px" height="100px" src="/../../img/<?php echo $model->img ?>" alt="" /><br><?php
        echo Html::a('Видалити зображення', Url::to(['user/image-delete', 'id' => $model->id]));
        echo '<br>';
    }else{
        echo $form->field($model, 'img')->fileInput();

    }?>

    <?php if (Yii::$app->user->can(Rbac::ROLE_ADMIN)){
        echo $form->field($model, 'role')->
        dropDownList(ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));
        echo $form->field($model, 'status')->dropDownList(User::getStatuses());
    }?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>