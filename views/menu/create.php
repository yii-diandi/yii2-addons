<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:54:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-08-12 02:11:07
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */

$this->title = '添加菜单';
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$addon = Yii::$app->request->get('addon');

?>

<?= $this->render('_tab') ?>



<div class="firetech-main" style="margin-top:20px;">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="dd-category-create">

                <?=
                    $this->render('_form', [
                        'model' => $model,
                        'addon' => $addon,
                        'routes' => $routes,
                        'rules' => $rules,
                        'parentMenu' => $parentMenu,
                    ])
                ?>


            </div>
        </div>
    </div>
</div>