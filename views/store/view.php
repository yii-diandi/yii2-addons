<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 21:18:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-11 17:38:34
 */
 

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocStore */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bloc-store-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->store_id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->store_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                    ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'store_id',
                    'name',
                    [
                        'attribute' => 'logo',
                        'format' => ['raw'],
                        'value' => function ($date) {
                            return html::img($date->logo,[
                                'width'=>'80px'
                            ]);
                        },
                    ],
                    'bloc_id',
                    'province',
                    'city',
                    'address',
                    'county',
                    'mobile',
                    'create_time',
                    'update_time',
                    'status',
                    'lng_lat',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>