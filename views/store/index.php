<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:43:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-01 12:02:11
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use common\widgets\MyGridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel diandi\admin\models\searchs\BlocStoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商户管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab'); ?>

<div class="firetech-main">

    <div class="bloc-store-index ">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
                <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],
                        'logo' => [
                            'attribute' => 'logo',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                $images = $model->logo;
                                // return $ai_group_status;
                                return Html::img(ImageHelper::tomedia($images), ['width' => 50, 'height' => 50]);
                            },
                        ],
                        'store_id',
                        'name',
                        'bloc.business_name',
                        //'province',
                        //'city',
                        //'address',
                        //'county',
                        //'mobile',
                        //'create_time',
                        //'update_time',
                        //'status',
                        //'lng_lat',

                        [
                            'class' => 'common\components\ActionColumn',
                            'urlCreator' => function ($action, $model, $key, $index) {
                                switch ($action) {
                                    case 'update':

                                        return Url::to([
                                            'update',
                                            'id' => $model['store_id'],
                                            'bloc_id' => $model['bloc_id'],
                                        ]);

                                        break;
                                    case 'view':

                                        return Url::to([
                                            'view',
                                            'id' => $model['store_id'],
                                            'bloc_id' => $model['bloc_id'],
                                        ]);

                                        break;
                                    case 'delete':
                                        return Url::to([
                                            'delete',
                                            'id' => $model['store_id'],
                                            'bloc_id' => $model['bloc_id'],
                                        ]);

                                        break;
                                }
                            },
                        ],
                    ],
                ]); ?>


            </div>
        </div>
    </div>
</div>