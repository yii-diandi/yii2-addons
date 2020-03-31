<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:55:28
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-31 13:36:55
 */


use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use leandrogehlen\treegrid\TreeGrid;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel diandi/admin\models\searchs\Menu */

$this->title = '扩展菜单管理';
$this->params['breadcrumbs'][] = $this->title;
$addon = Yii::$app->request->get('addon');
?>


<div id="tabs-container" class="align-center">
    <ul class="nav nav-tabs">

        <li class="active">
            <?= Html::a('菜单管理', ['index', 'addon' => $addon], ['class' => '']) ?>
        </li>
        <li>
            <?= Html::a('添加菜单', ['create', 'addon' => $addon], ['class' => '']) ?>
        </li>
    </ul>
</div>
<div class="firetech-main" style="margin-top:20px;">

    <div class="dd-category-index ">
        <div class="panel panel-default">
            <div class="box-body">
                <?= TreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'id',
                    'parentColumnName' => 'parent',
                    'parentRootValue' => null, //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'id',
                        // 'parent',
                        'name',
                        'route',
                        'order',
                        ['class' => 'yii\grid\ActionColumn'],
                    ]
                ]);

                ?>
            </div>
        </div>
    </div>
</div>