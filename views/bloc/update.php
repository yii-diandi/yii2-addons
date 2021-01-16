<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-30 21:44:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-09 17:49:59
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\bloc\models\Bloc */

$this->title = 'Update Bloc: ' . $model->bloc_id;
$this->params['breadcrumbs'][] = ['label' => 'Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bloc_id, 'url' => ['view', 'id' => $model->bloc_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab'); ?>

<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="bloc-update">


                <?= $this->render('_form', [
                    'parents' => $parents,
                    'stores' => $stores,
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>