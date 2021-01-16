<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-04 18:40:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-04 18:40:14
 */
 

use yii\helpers\Html;
use common\widgets\MyActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfWxapp */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="bloc-conf-wxapp-form">

    <?php $form = MyActiveForm::begin(); ?>

    <?= $form->field($model, 'bloc_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?= $form->field($model, 'original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AppId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'headimg')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'codeUrl')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'AppSecret')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php MyActiveForm::end(); ?>

</div>
