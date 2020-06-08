<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 15:41:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-08 15:50:22
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use diandi\admin\models\Menu;
use yii\helpers\Json;
use diandi\admin\AutocompleteAsset;
use diandi\admin\models\MenuTop;
use yii\helpers\ArrayHelper;

$menucate = MenuTop::find()->orderBy('sort')->asArray()->all();

/* @var $this yii\web\View */
/* @var $model diandi/admin\models\Menu */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="menu-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => 128])->label('菜单名称'); ?>

            <?= $form->field($model, 'parent')
                ->dropDownList(ArrayHelper::map($parentMenu, 'id', 'name'), [
                    'prompt' => [
                        'text' => '顶级导航',
                        'options' => ['value' => null],
                    ],
                ])
                ->label('父级菜单'); ?>
            <?= $form->field($model, 'route')->textInput(['id' => 'route']); ?>

            <?= $form->field($model, 'type')->textInput()->hiddenInput(['value' => 'plugins'])->label(false); ?>

        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'order')->input('number')->label('排序'); ?>
            <?= $form->field($model, 'icon')->widget('common\widgets\adminlte\Icon', ['options' => [
                'label' => '选择图标',
            ]]); ?>
            <?= $form->field($model, 'is_sys')->textInput()->hiddenInput(['value' => 'addons'])->label(false); ?>
            <?= $form->field($model, 'module_name')->textInput()->hiddenInput(['value' => $addon])->label(false); ?>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'data')->textarea(['rows' => 4])->label('数据'); ?>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <?=
                    Html::submitButton($model->isNewRecord ? Yii::t('rbac-admin', 'Create') : Yii::t('rbac-admin', 'Update'), ['class' => $model->isNewRecord
                        ? 'btn btn-success' : 'btn btn-primary', ]);
                ?>
            </div>

        </div>


        <?php ActiveForm::end(); ?>
    </div>