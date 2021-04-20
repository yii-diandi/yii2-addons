<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 02:21:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-20 19:38:46
 */
 

namespace diandi\addons\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class RegisterLevelStatus extends BaseEnum
{
    const GROUP = 0;
    const BLOC = 1;
    const STORE = 2;
    
    /**
     * @var string message category
     * You can set your own message category for translate the values in the $list property
     * Values in the $list property will be automatically translated in the function `listData()`
     */
    public static $messageCategory = 'app';
    
    /**
     * @var array
     */
    public static $list = [
        self::GROUP => '集团',
        self::BLOC => '公司',
        self::STORE => '商户',
    ];
}