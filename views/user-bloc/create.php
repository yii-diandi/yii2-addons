<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:46:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-06-27 09:58:24
 */
use diandi\admin\AutocompleteAsset;
use diandi\admin\models\Menu;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model diandi\admin\models\UserBloc */

$this->title = '添加管理员';
$this->params['breadcrumbs'][] = ['label' => 'User Blocs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
    'menus' => Menu::getMenuSource(),
    'routes' => Menu::getSavedRoutes(),
]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<?= $this->render('_tab', [
                'bloc_id' => $bloc_id,
                ]); ?>

<div class="firetech-main" id="user-bloc">
    <div class="panel panel-default">
        <div class="box-body">
            <div class="user-bloc-create">

                <?= $this->render('_form', [
                'model' => $model,
                ]); ?>

            </div>
        </div>
    </div>
</div>