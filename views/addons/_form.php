<?php

use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\addons\modules\DdAddons */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="dd-addons-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'identifie')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(['base' => 'Base', 'business' => 'Business', 'marketing' => 'Marketing', 'member' => 'Member', 'other' => 'Other', 'system' => 'System', 'enterprise' => 'Enterprise', 'services' => 'Services',], ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ability')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'settings')->textInput() ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>