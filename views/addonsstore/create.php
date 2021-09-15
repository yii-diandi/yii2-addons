<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\addonsStore */

$this->title = '添加 Addons Store';
$this->params['breadcrumbs'][] = ['label' => 'Addons Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="addons-store-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>