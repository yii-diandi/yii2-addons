<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:58:26
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-29 20:23:37
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */

$this->title = Yii::t('rbac-admin', 'Update Menu') . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Update');
$addon = Yii::$app->request->get('addon');

?>

<ul class="nav nav-tabs">
    <ul class="nav nav-tabs">

        <li>
            <?= Html::a('菜单管理', ['index', 'addon' => $addon], ['class' => '']) ?>
        </li>
        <li class="active">
            <?= Html::a('添加菜单', ['create', 'addon' => $addon], ['class' => '']) ?>
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
                        'addon' => $addon,
                        'rules' => $rules,
                        'parentMenu' => $parentMenu,
                    ])
                ?>
            </div>
        </div>
    </div>
</div>