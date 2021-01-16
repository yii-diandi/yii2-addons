<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfWechatpay */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Conf Wechatpays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab') ?>


<div class=" firetech-main">
    <div class="bloc-conf-wechatpay-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->id], [
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
                            'id',
            'bloc_id',
            'mch_id',
            'app_id',
            'key',
            'notify_url:url',
            'create_time:datetime',
            'update_time:datetime',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>