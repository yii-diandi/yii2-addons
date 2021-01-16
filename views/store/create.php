<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-07 09:04:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 02:21:43
 */

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocStore */

$this->title = '添加 Bloc Store';
$this->params['breadcrumbs'][] = ['label' => 'Bloc Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab'); ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-store-create">

                <?= $this->render('_form', [
                'Helper'=>$Helper,
                'model' => $model,
                'link' => $link,
                'labels' => $labels,
                'bloc_id' => $bloc_id,
                ]); ?>

            </div>
        </div>
    </div>
</div>