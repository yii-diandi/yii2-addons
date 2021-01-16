<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-19 00:09:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-19 00:25:44
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\StoreCategory */

$this->title = 'Update Store Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Store Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="store-category-update">


                <?= $this->render('_form', [
                'model' => $model,
                'catedata' => $catedata
                ]) ?>
            </div>
        </div>
    </div>
</div>