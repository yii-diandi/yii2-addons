<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\BlocConfSms */

$this->title = 'Update Bloc Conf Sms: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bloc Conf Sms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab') ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-conf-sms-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>