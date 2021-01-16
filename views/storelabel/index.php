<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-17 01:38:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 01:54:42
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel diandi\addons\models\searchs\StoreLabelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Store Labels';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

<div class="store-label-index ">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
            <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
                <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                            'name',
                            // 'thumb',
                            'displayorder',
                            //'color',
                            // 'is_show',
                            [
                                'attribute' => 'is_show',
                                'format' => ['raw'],
                                'value' => function ($model) {
                                    return $model->is_show==1?'显示':'隐藏';
                                }
                            ],
                            //'create_time',
                            //'update_time',
                    
                            ['class' => 'common\components\ActionColumn'],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>