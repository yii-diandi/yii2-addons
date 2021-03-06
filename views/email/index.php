<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-03 20:07:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-03 20:07:43
 */
 

use yii\helpers\Html;
use common\widgets\MyGridView;

/* @var $this yii\web\View */
/* @var $searchModel diandi\admin\models\searchs\BlocConfEmailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bloc Conf Emails';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>
                
<div class="firetech-main">

    <div class="bloc-conf-email-index ">
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
            'host',
            'port',
            'username',
            //'password',
            //'title',
            //'encryption',
            //'create_time:datetime',
            //'update_time:datetime',

            ['class' => 'common\components\ActionColumn'],
            
                    ],
                    ]); ?>
                
                
            </div>
        </div>
    </div>
</div>