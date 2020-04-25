<?php
/*** 
 * @开源软件: 店滴AI-基于AI的软硬件开源解决方案
 * @官方地址: http://www.wayfirer.com/
 * @版本: 1.0
 * @邮箱: 2192138785@qq.com
 * @作者: Wang Chunsheng
 * @Date: 2020-03-29 02:20:17
 * @LastEditTime: 2020-04-25 16:51:53
 */

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


<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
<?= $form->field($model, 'title') ?>
    
</div>



<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="form-group">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('重置', ['class' => 'btn btn-outline-secondary']) ?>
    </div>
</div>






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


<?php ActiveForm::end(); ?>
</div>
