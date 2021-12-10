<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\addons\models\BlocLevel */

$this->title = '添加 Bloc Level';
$this->params['breadcrumbs'][] = ['label' => 'Bloc Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-level-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>