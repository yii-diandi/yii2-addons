<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-06 16:23:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-06 16:30:06
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $model \app\models\forms\ConfigurationForm */
/* @var $this \yii\web\View */

$this->title = Yii::t('app', '公众号设置');
?>


<?php echo $this->renderAjax('_tab'); ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-member-create">

                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'app_id'); ?>

                <?php echo $form->field($model, 'token'); ?>
                <?php echo $form->field($model, 'aes_key'); ?>
                <?php echo $form->field($model, 'secret'); ?>
                
                <?= $form->field($model, 'headimg')->widget('common\widgets\webuploader\FileInput', []); ?>
                <div class="form-group">
                        <?= Html::submitButton('保存', ['class' => 'btn btn-primary']); ?>
                        <?= Html::a('返回公司', Url::to(['bloc/index']), ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

