<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:12:43
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-29 19:24:14
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel diandi\addons\modules\searchs\DdAddons */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dd Addons';
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="nav nav-tabs">
    <li class="active">
        <?= Html::a('已安装', ['index'], ['class' => '']) ?>
    </li>
    <li>
        <?= Html::a('未安装', ['uninstalled'], ['class' => '']) ?>
    </li>
</ul>
<div class="firetech-main">

    <div class="dd-addons-index ">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>
        <div class="panel panel-default">
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        // 'logo' => [
                        //     'attribute' => 'logo',
                        //     'format' => ['raw'],
                        //     'value' => function ($model) {
                        //         return Html::img(ImageHelper::tomedia($model->logo), ['height' => 50, 'width' => 'auto']);
                        //     }
                        // ],
                        'title' => [
                            'attribute' => 'logo',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                return $this->render('info', [
                                    'model' => $model
                                ]);
                                // return Html::img(ImageHelper::tomedia($model->logo), ['height' => 50, 'width' => 'auto']);
                            }
                        ],
                        // 'title',
                        // 'identifie',
                        'type',
                        // 'version',
                        //'ability',
                        //'description',
                        //'author',
                        //'url:url',
                        //'settings',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{uninstall}{authorization}',
                            'buttons' => [
                                'uninstall' => function ($url, $model, $key) {
                                    $url = Url::to(['manage/uninstall', 'addon' => $model['identifie']]);
                                    return  Html::a('<button type="button" class="btn btn-block btn-primary btn-sm ">卸载</button>', $url, [
                                        'title' => '卸载',
                                        'class' => 'col-xs-6',
                                        'data' => [
                                            'confirm' => Yii::t('app', '确认卸载该模块吗?'),
                                            'method' => 'post',
                                        ]
                                    ]);
                                },
                                'authorization' => function ($url, $model, $key) {
                                    $url = Url::to(['menu/index', 'addon' => $model['identifie']]);
                                    return  Html::a('<button type="button" class="btn btn-block btn-primary btn-sm col-xs-6">菜单管理</button>', $url, [
                                        'title' => '菜单管理',
                                        'class' => 'col-xs-6',
                                        // 'data' => [
                                        //     'confirm' => Yii::t('app', '确认权限初始化吗?'),
                                        //     'method' => 'post',
                                        // ]
                                    ]);
                                },

                            ],
                            // 'buttons' => [],
                            'headerOptions' => ['width' => '200px']
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>