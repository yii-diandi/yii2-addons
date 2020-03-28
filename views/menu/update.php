<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:58:26
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-22 20:59:17
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */

$this->title = Yii::t('rbac-admin', 'Update Menu') . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Update');
?>

<ul class="nav nav-tabs">
    <ul class="nav nav-tabs">
        <li class="active">
            <?= Html::a('添加菜单', ['create'], ['class' => '']) ?>
        </li>
        <li>
            <?= Html::a('菜单管理', ['index'], ['class' => '']) ?>
        </li>
    </ul>
</ul>
<div class="firetech-main" style="margin-top:20px;">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-category-update">
                <?=
                    $this->render('_form', [
                        'model' => $model,
                        'addons' => $addons,

                    ])
                ?>
            </div>
        </div>
    </div>
</div>