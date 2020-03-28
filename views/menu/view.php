<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 16:01:21
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-22 20:59:12
 */


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="tabs-container" class="align-center">
    <ul class="nav nav-tabs">
        <li>
            <?= Html::a('添加菜单', ['create'], ['class' => '']) ?>
        </li>
        <li>
            <?= Html::a('菜单管理', ['index'], ['class' => '']) ?>
        </li>
        <li class="active">
            <?= Html::a('菜单查看', ['view'], ['class' => '']) ?>
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