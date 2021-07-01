<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\BlocLevel */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-level-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'level_num')->textInput() ?>

    <?= $form->field($model, 'extra')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'update_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
