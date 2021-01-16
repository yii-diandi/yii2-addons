<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-17 02:28:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 02:28:59
 */
 

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_store_label_link}}".
 *
 * @property int $id
 * @property int $bloc_id 公司ID
 * @property int $store_id 商户id
 * @property int|null $label_id 标签ID
 * @property string|null $create_time
 * @property string|null $update_time
 */
class StoreLabelLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_store_label_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id'], 'required'],
            [['bloc_id', 'store_id', 'label_id'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
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
            'bloc_id' => '公司ID',
            'store_id' => '商户id',
            'label_id' => '商户标签',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
