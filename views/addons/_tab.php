<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 02:32:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-10 23:11:02
 */
use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => ['已安装','未安装'],
    'urls'=>['index','uninstalled']
    ]); ?>


