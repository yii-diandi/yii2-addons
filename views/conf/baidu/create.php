<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\addons\diandi_operator\modules\OperatorBloc */

$this->title = '添加 Operator Bloc';
$this->params['breadcrumbs'][] = ['label' => 'Operator Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_tab') ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="operator-bloc-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>

            </div>
        </div>
    </div>
</div>