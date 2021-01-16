<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 16:06:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 00:14:10
 */
use common\widgets\MyTreeGrid;
use yii2mod\editable\EditableColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\bloc\models\searchs\BlocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公司';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs($this->render('_script.js'));
?>
<?= $this->render('_tab'); ?>

<div class="firetech-main">

    <div class="bloc-index" id="bloc-index">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">公司列表</h3>
            </div>
            <div class="box-body table-responsive">
            <?= MyTreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'bloc_id',
                    'parentColumnName' => 'pid',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'bloc_id',
                        'business_name',
                        'pid',
                        'category',
                        'province',
                        //'city',
                        //'district',
                        //'address',
                        //'longitude',
                        //'latitude',
                        //'telephone',
                        //'photo_list',
                        //'avg_price',
                        //'recommend',
                        //'special',
                        //'introduction',
                        //'open_time',
                        //'location_id',
                        //'status',
                        //'source',
                        //'message',
                        //'sosomap_poi_uid',
                        //'license_no',
                        //'license_name',
                        //'other_files:ntext',
                        //'audit_id',
                        //'on_show',
                        [
                            'class' => EditableColumn::class,
                            'attribute' => 'status',
                            'value' => function ($model) {
                                $list = ['非集团','集团'];

                                return $list[$model->status];
                            },
                            'url' => ['change-username'],
                            'type' => 'select',
                            'editableOptions' => function ($model) {
                                return [
                                    'source' => ['非集团','集团'],
                                    'value' => ['非集团'=>0,'集团'=>1] 
                                ];
                            },
                        ],    
                        ['class' => 'common\components\ActionColumn'],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => '操作',
                            'template' => '{user}{management}{stores}',
                            'buttons' => [
                                'stores' => function ($url, $model, $key) {
                                    $url = Url::to(['/addons/store/index', 'bloc_id' => $model['bloc_id']]);

                                    return  Html::button('商户管理',[
                                        'title' => '商户管理',
                                        'class' => 'btn btn-default',
                                        '@click'=>"dialog('商户管理','{$url}')",
                                    ]);
                                },
                                'user' => function ($url, $model, $key) {
                                    $url = Url::to(['user-bloc/index', 'bloc_id' => $model['bloc_id']]);

                                    return  Html::button('管理员',[
                                        'title' => '管理员',
                                        'class' => 'btn btn-default',
                                        '@click'=>"dialog('管理员', '{$url}')",
                                    ]);
                                },
                                'management' => function ($url, $model, $key) {
                                    $url = Url::to(['setting/baidu', 'bloc_id' => $model['bloc_id']]);

                                    return  Html::button('参数配置',[
                                        'title' => '进入模块',
                                        'class' => 'btn btn-default',
                                        '@click'=>"dialog('参数配置', '{$url}')",
                                    ]);
                                    
                                },
                            ],
                            'contentOptions' => ['class' => 'btn-group'],
                            // 'buttons' => [],
                            'headerOptions' => ['width' => '250px'],
                        ],
                    ],
                ]);

                ?>
      
            </div>
        </div>
    </div>
</div>