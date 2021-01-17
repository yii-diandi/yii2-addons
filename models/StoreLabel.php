<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-17 01:39:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-17 10:45:03
 */
 

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_store_label}}".
 *
 * @property int $id
 * @property int $bloc_id 公司ID
 * @property int $store_id 商户id
 * @property string|null $name 标签名称
 * @property string|null $thumb 标签图片
 * @property int|null $displayorder 排序
 * @property string|null $color 颜色
 * @property int $is_show 是否显示
 * @property string|null $create_time
 * @property string|null $update_time
 */
class StoreLabel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_store_label}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_show'], 'required'],
            [['bloc_id', 'store_id', 'displayorder', 'is_show'], 'integer'],
            [['name', 'thumb'], 'string', 'max' => 255],
            [['color', 'create_time', 'update_time'], 'string', 'max' => 30]
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
                'createdAttribute' => 'create_time'
            ],
        ];
    }

    
    public function getStore()
    {
        return $this->hasOne(BlocStore::className(),['store_id'=>'store_id']);
    }

    public function getBloc()
    {
        return $this->hasOne(Bloc::className(),['bloc_id'=>'bloc_id']);
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
            'name' => '标签名称',
            'thumb' => '标签图片',
            'displayorder' => '排序',
            'color' => '颜色',
            'is_show' => '是否显示',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
