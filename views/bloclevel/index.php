<?php

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel diandi\addons\models\searchs\BlocLevel */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bloc Levels';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="bloc-level-index ">
                                <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
                <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">列表</h3>
            </div>
            <div class="box-body table-responsive">
                                    <?= MyGridView::widget([
                    'dataProvider' => $dataProvider,
                    'layout' => "{items}\n{pager}",
                    'filterModel' => $searchModel,
        'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                                'id',
            'bloc_id',
            'global_bloc_id',
            'name',
            'thumb',
            //'level_num',
            //'extra',
            //'create_time',
            //'update_time',
                    
                    ['class' => 'common\components\ActionColumn'],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>