<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:46:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-28 09:19:01
 */
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel diandi\admin\models\searchs\UserBlocSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab', [
                'bloc_id' => $bloc_id,
]); ?>
                
<div class="firetech-main">

    <div class="user-bloc-index ">
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
                        ['class' => 'yii\grid\SerialColumn'],
                        'user.username',
                        'bloc.business_name',
                        'store.name',
                        'create_time:datetime',
                        //'update_time',
                        [
                            'class' => 'common\components\ActionColumn',
                            'urls'=>[
                                'bloc_id'=>'bloc_id'
                            ],
                            'template' => '{delete}'
                        ],
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>