<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:02:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 12:32:20
 */

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocStore */

$this->title = '编辑商户信息: '.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->store_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab'); ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-store-update">


                <?= $this->render('_form', [
                'Helper'=>$Helper,
                'bloc_id' => $bloc_id,
                'link' => $link,
                'labels' => $labels,
                'linkValue' => $linkValue,
                'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>