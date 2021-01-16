<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-19 00:09:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-19 00:09:54
 */
 

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\StoreCategory */

$this->title = '添加 Store Category';
$this->params['breadcrumbs'][] = ['label' => 'Store Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="store-category-create">

                <?= $this->render('_form', [
                'model' => $model,
                'catedata' => $catedata
                ]) ?>

            </div>
        </div>
    </div>
</div>