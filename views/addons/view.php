<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model diandi\addons\modules\DdAddons */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dd Addons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<ul class="nav nav-tabs">
    <li>
        <?= Html::a('添加 Dd Addons', ['create'], ['class' => '']) ?>
    </li>
    <li>
        <?= Html::a('Dd Addons管理', ['index'], ['class' => '']) ?>
    </li>
    <li class="active">
        <?= Html::a('Dd Addons管理', ['view'], ['class' => '']) ?>
    </li>
</ul>
<div class=" firetech-main">
    <div class="dd-addons-view">

        <div class="panel panel-default">
            <div class="box-body">

                <p>
                    <?= Html::a('更新', ['update', 'id' => $model->mid], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('删除', ['delete', 'id' => $model->mid], [
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
                            'mid',
            'name',
            'type',
            'title',
            'version',
            'ability',
            'description',
            'author',
            'url:url',
            'settings',
            'logo',
                ],
                ]) ?>

            </div>
        </div>
    </div>
</div>