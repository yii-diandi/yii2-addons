<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:46:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-01 19:42:36
 */

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\UserBloc */

$this->title = '编辑管理员: '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?= $this->render('_tab', [
                'bloc_id' => $bloc_id,
                ]); ?>


<div class="firetech-main">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="user-bloc-update">


                <?= $this->render('_form', [
                'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>