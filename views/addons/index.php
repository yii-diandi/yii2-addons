<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:12:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-09 16:28:26
 */

use diandi\addons\services\addonsService;
use diandi\admin\components\Helper;
use yii\helpers\Html;
use common\widgets\MyGridView;
use yii\helpers\Url;

$this->registerJs($this->render('_script.js'));

/* @var $this yii\web\View */
/* @var $searchModel diandi\addons\models\searchs\DdAddons */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模块列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .flex-center-vertically {
        align-items: center;
    }

    .afterRow-addons {
        background: #f5f5f587;
        text-align: right;
    }

    .media-object {
        width: 70px;
        height: 70px;
        border-radius: 4px;
        padding: 10px;
    }
</style>
<?= $this->render('_tab'); ?>
<div class="firetech-main">

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">检索</h3>
        </div>
        <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

        </div>
    </div>




    <div class="dd-addons-index " id="dd-addons-index">
        <div class="box-body">
            <?= MyGridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{pager}",
                'options' => ['class' => 'table-responsive'],
                'tableOptions' => ['class' => 'table table-hoverd'],
                'afterRow' => function ($model, $key, $index, $grid) {
                    $html = "<tr class='afterRow-addons'><td colspan='2'>";
                    $html .= '<div class="btn-group">';


                    if (Helper::checkRoute('menu/index')) {
                        $url2 = Url::to(['menu/index', 'addon' => $model['identifie']]);
                        $html .= Html::button('菜单管理', [
                            'title' => '菜单管理',
                            'class' => 'tabsOpen btn btn-default btn-sm',
                            '@click' => "dialog('菜单管理', '{$url2}')",
                        ]);
                    }


                    if (Helper::checkRoute('/admin/permission/index')) {
                        $url5 = Url::to(['/admin/permission/index', 'module_name' => $model['identifie']]);
                        $html .= Html::button('权限管理', [
                            'title' => '权限管理',
                            'class' => 'tabsOpen btn btn-default btn-sm',
                            '@click' => "dialog('权限管理', '{$url5}')",

                        ]);
                    }

                    // if(Helper::checkRoute('/admin/group/index')){
                    //     $url3 = Url::to(['/admin/group/index', 'module_name' => $model['identifie']]);
                    //     $html .= Html::button('用户组管理', [
                    //         'class'=>'tabsOpen btn btn-default btn-sm',
                    //         'title' => '用户组管理',
                    //         '@click'=>"dialog('用户组管理', '{$url3}')",
                    //     ]);
                    // }

                    // if(Helper::checkRoute('/admin/user/index')){
                    //     $url4 = Url::to(['/admin/user/index', 'module_name' => $model['identifie']]);
                    //     $html .= Html::button('操作员管理', [
                    //         'class'=>'tabsOpen btn btn-default btn-sm',
                    //         'title' => '操作员管理',
                    //         '@click'=>"dialog('操作员管理', '{$url4}')",

                    //     ]);
                    // }

                    if (Helper::checkRoute('manage/uninstall')) {
                        $url1 = Url::to(['manage/uninstall', 'addon' => $model['identifie']]);
                        $html .= Html::a('模块停用', $url1, [
                            'title' => '模块停用',
                            'class' => 'tabsOpen btn btn-default  btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', '确认停用该模块吗?'),
                                'method' => 'post',
                            ],
                        ]);
                    }


                    $html .= "</div>";


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