<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\addons\diandi_operator\modules\OperatorBloc */

$this->title = 'Update Operator Bloc: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Operator Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="operator-bloc-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>