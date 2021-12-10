<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 23:02:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 10:06:00
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_store_category}}".
 *
 * @property int $category_id 分类id
 * @property string $name 分类名称
 * @property int $parent_id 父级id
 * @property string $thumb 分类图片
 * @property int $sort 分类排序
 * @property int $create_time
 * @property int $update_time
 */
class StoreCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store_category}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id',  'create_time', 'update_time'], 'integer'],
            [['thumb'], 'required'],
            ['sort', 'default', 'value' => 0],
            [['name'], 'string', 'max' => 50],
            [['thumb'], 'string', 'max' => 250],
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
            'category_id' => '分类id',
            'name' => '分类名称',
            'parent_id' => '父级id',
            'thumb' => '分类图片',
            'sort' => '分类排序',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
