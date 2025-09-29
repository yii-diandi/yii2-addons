<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 02:21:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-02 15:07:59
 */


namespace diandi\addons\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AddonsTypeStatus extends BaseEnum
{
    const BASE = 'base';
    const BUSINESS = 'business';
    const MARKETING = 'marketing';
    const MEMBER = 'member';
    const SYSTEM = 'sys';
    const ENTERPRISE = 'enterprise';
    const SERVICES = 'service';
    const OTHER = 'other';


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
        self::BASE => '基础',
        self::BUSINESS => '商业',
        self::MARKETING => '营销',
        self::MEMBER => '会员',
        self::SYSTEM => '系统',
        self::ENTERPRISE => '企业',
        self::SERVICES => '服务',
        self::OTHER => '其他'
    ];
}
