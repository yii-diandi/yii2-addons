<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 11:56:38
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-29 18:22:08
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
    <li>
        <?= Html::a('已安装', ['index'], ['class' => '']) ?>
    </li>
    <li class="active">
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
                    'dataProvider' => $provider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'logo' => [
                        //     'attribute' => 'logo',
                        //     'format' => ['raw'],
                        //     'value' => function ($model) {
                        //         return Html::img(ImageHelper::tomedia($model->logo), ['height' => 50, 'width' => 'auto']);
                        //     }
                        // ],
                        'title',
                        'identifie',
                        'type',
                        'version',
                        //'ability',
                        //'description',
                        //'author',
                        // 'url:url',
                        //'settings',
                        //'logo',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{install}',
                            'buttons' => [
                                'install' => function ($url, $model, $key) {
                                    $url = Url::to(['manage/install', 'addon' => $model['identifie']]);
                                    return  Html::a(
                                        '<button type="button" class="btn btn-block btn-primary btn-sm">安装</button>',
                                        $url,
                                        [
                                            'title' => '安装',
                                            'data' => [
                                                'confirm' => Yii::t('app', '确认安装该模块吗?'),
                                                'method' => 'post',
                                            ],
                                        ]
                                    );
                                },
                            ],
                            // 'buttons' => [],
                            'headerOptions' => ['width' => '100']
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>