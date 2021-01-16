<?php
/**
 * @Author: Wang chunsheng  &#60;2192138785@qq.com&#62;
 * @Date:   2020-04-30 14:10:29
 * @Last Modified by:   Wang chunsheng  <2192138785@qq.com>
 * @Last Modified time: 2020-04-30 14:10:30
 */
use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfBaidu */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-conf-baidu-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'bloc_id')->textInput(); ?>

    <?= $form->field($model, 'APP_ID')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'API_KEY')->textInput(); ?>

    <?= $form->field($model, 'SECRET_KEY')->textInput(['maxlength' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

 

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']); ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>
