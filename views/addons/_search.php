<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model diandi\addons\modules\searchs\DdAddons */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dd-addons-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'mid') ?>

    <?= $form->field($model, 'identifie') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'ability') 
    ?>

    <?php // echo $form->field($model, 'description') 
    ?>

    <?php // echo $form->field($model, 'author') 
    ?>

    <?php // echo $form->field($model, 'url') 
    ?>

    <?php // echo $form->field($model, 'settings') 
    ?>

    <?php // echo $form->field($model, 'logo') 
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>