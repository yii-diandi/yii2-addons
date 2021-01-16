<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 23:14:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:30:24
 */

namespace diandi\addons\models;

/**
 * This is the model class for table "diandi_bloc_conf_baidu".
 *
 * @property int      $id
 * @property int      $bloc_id     公司ID
 * @property string   $APP_ID      APP_ID
 * @property int      $API_KEY     API_KEY
 * @property string   $SECRET_KEY  SECRET_KEY
 * @property string   $name        应用名称
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfBaidu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_bloc_conf_baidu}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'APP_ID', 'name'], 'required'],
            [['bloc_id', 'API_KEY', 'create_time', 'update_time'], 'integer'],
            [['APP_ID'], 'string', 'max' => 50],
            [['SECRET_KEY'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 15],
            [['bloc_id'], 'unique'],
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
            'APP_ID' => 'APP_ID',
            'API_KEY' => 'API_KEY',
            'SECRET_KEY' => 'SECRET_KEY',
            'name' => '应用名称',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
