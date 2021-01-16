<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 11:39:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-01 19:42:10
 */
use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => [
            '管理员',
            '添加管理员',
            '管理员详情',
    ],
    'urls' => [
        'index',
        'create',
        'view',
    ],
    'options' => [
        'bloc_id' => $bloc_id,
    ],
]); ?>


