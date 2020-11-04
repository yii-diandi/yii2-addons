<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:55:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-05 00:50:04
 */


use yii\helpers\Html;
use common\widgets\MyGridView;
use yii\widgets\Pjax;
use common\widgets\MyTreeGrid;
use yii2mod\editable\EditableColumn;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel diandi/admin\models\searchs\Menu */

$this->title = '扩展菜单管理';
$this->params['breadcrumbs'][] = $this->title;
$addon = Yii::$app->request->get('addon');
?>

<?= $this->render('_tab') ?>


<div class="firetech-main">

    <div class="dd-category-index ">
        <div class="panel panel-default">
            <div class="box-body">
                <?= MyTreeGrid::widget([
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
                        [
                            'class' => EditableColumn::class,
                            'attribute' => 'order',
                            'url' => ['update-files']
                        ],
                        [
                            'class' => 'common\components\ActionColumn',
                         'urlCreator' => function ($action, $model, $key, $index) {
                            switch($action)
                            {
                                case 'delete':
                                    return Url::to(['delete','id'=>$model->id,'addon'=>$model->module_name]);
                                break;
                                case 'view':
                                    return Url::to(['view','id'=>$model->id,'addon'=>$model->module_name]);
                                
                                break;
                                case 'update':
                                    return Url::to(['update','id'=>$model->id,'addon'=>$model->module_name]);
                                break;
                            }
                    
                        },],
                    ]
                ]);

                ?>
            </div>
        </div>
    </div>
</div>