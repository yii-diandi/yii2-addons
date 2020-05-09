<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:12:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-09 19:01:13
 */
use diandi\addons\services\addonsService;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel diandi\addons\modules\searchs\DdAddons */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dd Addons';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .flex-center-vertically {
        align-items: center;
}
.afterRow-addons{
    background: #f5f5f587;
}
.afterRow-addons a{
    color: #777;
    float: right;
    padding-right: 15px;
}
.media-object{
    width: 70px;
    height: 70px;
    border-radius: 4px;
    padding: 10px;
}
</style>
<ul class="nav nav-tabs">
    <li class="active">
        <?= Html::a('已安装', ['index'], ['class' => '']); ?>
    </li>
    <li>
        <?= Html::a('未安装', ['uninstalled'], ['class' => '']); ?>
    </li>
</ul>
<div class="firetech-main">
    
    <div class="panel panel-info">
          <div class="panel-heading">
                <h3 class="panel-title">检索</h3>
          </div>
          <div class="panel-body">
                  <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
              
          </div>
    </div>
    

    <div class="dd-addons-index ">

        <div class="panel panel-default">
        <div class="panel-heading">
                <h3 class="panel-title">扩展模块</h3>
            </div>
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'options' => ['class' => 'table-responsive'],
                    'tableOptions' => ['class' => 'table table-bordered'],
                    'afterRow' => function ($model, $key, $index, $grid) {
                        $html = "<tr class='afterRow-addons'><td colspan='2'>";
                        $url1 = Url::to(['manage/uninstall', 'addon' => $model['identifie']]);

                        $html .= Html::a('模块停用', $url1, [
                            'title' => '模块停用',
                            'data' => [
                                'confirm' => Yii::t('app', '确认停用该模块吗?'),
                                'method' => 'post',
                            ],
                        ]);

                        $url2 = Url::to(['menu/index', 'addon' => $model['identifie']]);
                        $html .= Html::a('菜单管理', $url2, [
                            'title' => '菜单管理',
                        ]);

                        
                        $url3 = Url::to(['/admin/group/index', 'module_name' => $model['identifie']]);
                        $html .= Html::a('用户组管理', $url3, [
                            'title' => '用户组管理',
                        ]);
                        
                        $url4 = Url::to(['/admin/user/index', 'module_name' => $model['identifie']]);
                        $html .= Html::a('操作员管理', $url4, [
                            'title' => '操作员管理',
                        ]);
                        
                         
                        $url5 = Url::to(['/admin/permission/index', 'module_name' => $model['identifie']]);
                        $html .= Html::a('权限管理', $url5, [
                            'title' => '权限管理',
                        ]);
                        
                        $html .= '</td></tr>';

                        return  $html;
                    },
                    'columns' => [
                        'title' => [
                            'attribute' => '模块信息',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                return $this->render('info', [
                                    'model' => $model,
                                    'logo' => addonsService::getLogo($model['identifie']),
                                ]);
                            },
                        ],
                        // 'title',
                        // 'identifie',
                        // 'type',
                        // 'version',
                        //'ability',
                        //'description',
                        //'author',
                        //'url:url',
                        //'settings',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{management}',
                            'buttons' => [
                                'management' => function ($url, $model, $key) {
                                    $url = Url::to(['/module', 'addons' => $model['identifie']]);

                                    return  Html::a("<button type='button' class='btn btn-sm btn-primary'>进入模块</button>", $url, [
                                        'title' => '进入模块',
                                        'target' => '_block',
                                        // 'data' => [
                                        //     'confirm' => Yii::t('app', '确认卸载该模块吗?'),
                                        //     'method' => 'post',
                                        // ]
                                    ]);
                                },
                            ],
                            'contentOptions' => ['class' => 'flex-center-vertically'],
                            // 'buttons' => [],
                            'headerOptions' => ['width' => '100px'],
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>