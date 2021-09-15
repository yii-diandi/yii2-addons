<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-09 16:38:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-10 10:21:44
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%addons_store}}".
 *
 * @property int $id
 * @property int|null $type 用户类型
 * @property string|null $module_name 所属模块
 * @property int|null $store_id 商户
 * @property int|null $bloc_id 公司
 * @property int|null $status 审核状态
 * @property int|null $create_time
 * @property int|null $update_time
 */
class addonsStore extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addons_store}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'store_id', 'bloc_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['module_name'], 'string', 'max' => 50],
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
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '用户类型',
            'module_name' => '所属模块',
            'store_id' => '商户',
            'bloc_id' => '公司',
            'status' => '审核状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
