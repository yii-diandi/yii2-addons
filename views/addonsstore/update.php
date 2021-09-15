<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\addonsStore */

$this->title = 'Update Addons Store: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Addons Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="addons-store-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>