<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 02:32:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-03 22:01:43
 */
use common\widgets\tab\Tab;
$addon = Yii::$app->request->get('addon');

?>
<?= Tab::widget([
    'titles' => ['菜单管理', '新增菜单', '菜单维护','菜单编辑'],
    'urls' => ['index', 'create', 'view','update'],
    'options'=>['addon'=>$addon]
    ]); ?>


