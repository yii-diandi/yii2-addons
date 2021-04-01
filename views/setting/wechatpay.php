<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-14 01:26:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-01 11:11:38
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \app\models\forms\ConfigurationForm */
/* @var $this \yii\web\View */

$this->title = Yii::t('app', '小程序设置');
?>


<?php echo $this->renderAjax('_tab'); ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-create">

                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'mch_id'); ?>
                
                <?php echo $form->field($model, 'key'); ?>
                
                <?= $form->field($model, 'is_server')->radioList([
                    '0' => '关闭',
                    '1' => '开启',
                ], ['style' => 'padding-top:7px;']); ?> 

                <?php echo $form->field($model, 'server_mchid'); ?>
                
                <?php echo $form->field($model, 'server_signkey'); ?>
                
                <div class="form-group">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']); ?>
                        <?= Html::a('返回公司', Url::to(['bloc/index']), ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>