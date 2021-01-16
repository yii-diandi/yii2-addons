<?php

use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfSms */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-conf-sms-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'access_key_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'access_key_secret')->textInput() ?>

    <?= $form->field($model, 'sign_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'template_code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>
