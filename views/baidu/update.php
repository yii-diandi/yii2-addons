<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 15:17:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-04-30 15:17:26
 */

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfBaidu */

$this->title = '百度sdk'.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Conf Baidus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab'); ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-conf-baidu-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>