<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:01:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-25 11:08:18
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "dd_addons".
 *
 * @property int $mid 模块id
 * @property string $name 英文标识
 * @property string $type 模块类型
 * @property string $title 名称
 * @property string $version 版本
 * @property string $ability 简介
 * @property string $description 描述
 * @property string $author 作者
 * @property string $url 社区地址
 * @property int $settings 配置
 * @property string $logo logo
 */
class DdAddons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addons}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identifie', 'title', 'version', 'ability', 'description', 'author', 'url', 'settings', 'logo'], 'required'],
            [['type'], 'string'],
            [['settings', 'is_install', 'is_nav'], 'integer'],
            [['identifie', 'title'], 'string', 'max' => 100],
            [['version', 'versions'], 'string', 'max' => 15],
            [['ability'], 'string', 'max' => 500],
            [['description'], 'string', 'max' => 1000],
            [['author'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255],
            [['logo'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mid' => '模块id',
            'identifie' => '英文标识',
            'type' => '模块类型',
            'title' => '名称',
            'version' => '版本',
            'ability' => '简介',
            'description' => '描述',
            'author' => '作者',
            'url' => '社区地址',
            'settings' => '配置',
            'logo' => 'logo',
            'is_nav' => '顶部导航'
        ];
    }
}
