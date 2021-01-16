<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 15:17:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-04-30 15:17:34
 */
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfBaidu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Conf Baidus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= $this->render('_tab'); ?>


<div class=" firetech-main">
    <div class="bloc-conf-baidu-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']); ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                    ],
                    ]); ?>
                </p>

                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'id',
            'bloc_id',
            'APP_ID',
            'API_KEY',
            'SECRET_KEY',
            'name',
            'create_time:datetime',
            'update_time:datetime',
                ],
                ]); ?>

            </div>
        </div>
    </div>
</div>