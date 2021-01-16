<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-19 00:08:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-19 00:09:40
 */

use common\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\StoreCategory */
/* @var $form yii\widgets\MyActiveForm */
?>

<div class="store-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($catedata, 'category_id', 'name')); ?>

    <?= $form->field($model, 'thumb')->hint('尺寸:100px*100px')->widget('common\widgets\webuploader\FileInput', []); ?>

    <?= $form->field($model, 'sort')->textInput() ?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
