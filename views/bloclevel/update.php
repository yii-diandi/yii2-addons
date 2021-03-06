<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\BlocLevel */

$this->title = 'Update Bloc Level: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-level-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>