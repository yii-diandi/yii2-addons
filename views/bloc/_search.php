<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 10:28:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-01 10:28:10
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\bloc\models\searchs\BlocSearch */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">公司检索</h3>
    </div>
    <div class="box-body">
        <div class="bloc-search">

            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>


            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <?= $form->field($model, 'bloc_id'); ?>

                <?= $form->field($model, 'business_name'); ?>

            </div>


            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                <?= $form->field($model, 'pid'); ?>

                <?= $form->field($model, 'category'); ?>

            </div>

            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <?= $form->field($model, 'province'); ?>

            </div>



            <?php // echo $form->field($model, 'city')
            ?>

            <?php // echo $form->field($model, 'district')
            ?>

            <?php // echo $form->field($model, 'address')
            ?>

            <?php // echo $form->field($model, 'longitude')
            ?>

            <?php // echo $form->field($model, 'latitude')
            ?>

            <?php // echo $form->field($model, 'telephone')
            ?>

            <?php // echo $form->field($model, 'photo_list')
            ?>

            <?php // echo $form->field($model, 'avg_price')
            ?>

            <?php // echo $form->field($model, 'recommend')
            ?>

            <?php // echo $form->field($model, 'special')
            ?>

            <?php // echo $form->field($model, 'introduction')
            ?>

            <?php // echo $form->field($model, 'open_time')
            ?>

            <?php // echo $form->field($model, 'location_id')
            ?>

            <?php // echo $form->field($model, 'status')
            ?>

            <?php // echo $form->field($model, 'source')
            ?>

            <?php // echo $form->field($model, 'message')
            ?>

            <?php // echo $form->field($model, 'sosomap_poi_uid')
            ?>

            <?php // echo $form->field($model, 'license_no')
            ?>

            <?php // echo $form->field($model, 'license_name')
            ?>

            <?php // echo $form->field($model, 'other_files')
            ?>

            <?php // echo $form->field($model, 'audit_id')
            ?>

            <?php // echo $form->field($model, 'on_show')
            ?>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']); ?>
                    <?= Html::resetButton('重置', ['class' => 'btn btn-outline-secondary']); ?>
                </div>
            </div>



            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>