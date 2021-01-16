<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:13:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-11 15:14:11
 */
 

use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => [
            '商户管理',
            '商户添加',
            '商户详情',
            '商户编辑',
    ],
    'options'=>[
        'bloc_id'=>Yii::$app->request->get('bloc_id',0)
    ]
]); ?>


