<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 16:01:21
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-29 19:29:55
 */


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$addon = Yii::$app->request->get('addon');

?>
<div id="tabs-container" class="align-center">
    <ul class="nav nav-tabs">

        <li>
            <?= Html::a('菜单管理', ['index', 'addon' => $addon], ['class' => '']) ?>
        </li>
        <li>
            <?= Html::a('添加菜单', ['create', 'addon' => $addon], ['class' => '']) ?>
        </li>
        <li class="active">
            <?= Html::a('菜单查看', ['view', 'addon' => $addon], ['class' => '']) ?>
        </li>
    </ul>
</div>

<div class=" firetech-main">
    <div class="dd-category-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?=
                    DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'menuParent.name:text:Parent',
                            'name',
                            'route',
                            'order',
                        ],
                    ])
                ?>

            </div>
        </div>
    </div>
</div>