<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 02:32:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-03 20:54:26
 */
use common\widgets\tab\Tab;

?>
<?= Tab::widget([
    'titles' => ['百度SDK参数', '小程序设置','公众号配置', '微信支付','字节跳动小程序','APP配置','短信设置','邮箱服务器','地图设置'],
    'options'=>[
        'bloc_id'=> Yii::$app->request->get('bloc_id', 1)
    ],
    'urls'=>['baidu','wxapp','wechat','wechatpay','microapp','app','sms','email','map']
    ]); ?>

    