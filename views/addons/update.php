<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\DdAddons */

$this->title = 'Update Dd Addons: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Dd Addons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->mid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<ul class="nav nav-tabs">
    <li class="active">
        <?= Html::a('添加 Dd Addons', ['create'], ['class' => 'btn btn-primary']) ?>
    </li>
    <li>
        <?= Html::a('Dd Addons管理', ['index'], ['class' => '']) ?>
    </li>
</ul>
<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-addons-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>