<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-03 17:28:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 18:53:24
 */


namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_bloc_level}}".
 *
 * @property int $id
 * @property int $bloc_id 公司ID
 * @property string|null $name 等级名称
 * @property string|null $thumb 等级图片
 * @property int|null $level_num 等级
 * @property string|null $extra 等级扩展字段
 * @property string|null $create_time
 * @property string|null $update_time
 */
class BlocLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['global_bloc_id', 'level_num'], 'checkLevel', 'on' => 'create'],
            // [['global_bloc_id','level_num'], 'unique'],
            [['level_num'], 'integer'],
            [['name', 'thumb', 'extra'], 'string', 'max' => 255],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['level_num'], 'unique']
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

    public function checkLevel($attribute, $params)
    {
        if (!empty($this->level_num)) {
            $isHave = $this->find()->where(['global_bloc_id' => Yii::$app->params['global_bloc_id'], 'level_num' => $this->level_num])->asArray()->one();
            if (!empty($isHave)) {
                $this->addError($attribute, "等级添加重复");
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'name' => '等级名称',
            'thumb' => '等级图片',
            'level_num' => '等级',
            'extra' => '扩展字段',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
