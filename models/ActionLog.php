<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-29 18:17:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2025-06-19 11:17:43
 */

namespace diandi\addons\models;

use common\behaviors\SaveBehavior;
use common\components\ActiveRecord\YiiActiveRecord;

/**
 * This is the model class for table "{{%user_action_log}}".
 *
 * @public int         $id
 * @public string|null $user      用户
 * @public string|null $operation 操作
 * @public string|null $logtime   操作时间
 * @public string|null $logip     操作ip
 */
class ActionLog extends YiiActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_action_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_name', 'action_name', 'action_data'], 'string', 'max' => 255],
            [['create_time', 'update_time', 'logtime'], 'safe'],
            [['user_id', 'key_id'], 'integer'],
            [['operation', 'type'], 'string', 'max' => 100],
            [['logip'], 'string', 'max' => 20],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user' => '用户',
            'operation' => '操作',
            'logtime' => '操作时间',
            'logip' => '操作ip',
        ];
    }
}
