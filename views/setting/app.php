<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 01:26:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-03 23:22:19
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \app\models\forms\ConfigurationForm */
/* @var $this \yii\web\View */

$this->title = Yii::t('app', 'app配置');
?>


<?php echo $this->renderAjax('_tab'); ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-create">

                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'android_ver'); ?>
                
                
                <?php echo $form->field($model, 'android_url'); ?>

                <?php echo $form->field($model, 'ios_ver'); ?>

                <?php echo $form->field($model, 'ios_url'); ?>



                <?php echo $form->field($model, 'partner'); ?>

                <?php echo $form->field($model, 'partner_key'); ?>

                <?php echo $form->field($model, 'paysignkey'); ?>

                <?php echo $form->field($model, 'app_id'); ?>
                
                <?php echo $form->field($model, 'app_secret'); ?>
                
                
                
                <div class="form-group">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']); ?>
                        <?= Html::a('返回公司', Url::to(['bloc/index']), ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>