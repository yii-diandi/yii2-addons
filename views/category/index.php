<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-19 00:16:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-19 00:22:25
 */

use common\helpers\ImageHelper;
use yii\helpers\Html;
use common\widgets\MyGridView;
use common\widgets\MyTreeGrid;

/* @var $this yii\web\View */
/* @var $searchModel diandi\admin\models\searchs\StoreCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Store Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="store-category-index ">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
            <?= MyTreeGrid::widget([
                    'dataProvider' => $dataProvider,
                    'keyColumnName' => 'category_id',
                    'parentColumnName' => 'parent_id',
                    'parentRootValue' => '0', //first parentId value
                    'pluginOptions' => [
                        'initialState' => 'collapsed',
                    ],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'category_id:raw:分类id',
                        'name:raw:分类名称',
                        'parent_id:raw:上级分类',
                        [
                            'attribute' => '分类图片',
                            'format' => ['raw'],
                            'value' => function ($model) {
                                
                                $images = $model['thumb'];
                                // return $ai_group_status;
                                return Html::img(ImageHelper::tomedia($images), ['width' => 50, 'height' => 50]);
                            },
                        ],
                        'sort:raw:排序',
                        ['class' => 'common\components\ActionColumn'],
                    ],
                ]);

                ?>
                
            </div>
        </div>
    </div>
</div>