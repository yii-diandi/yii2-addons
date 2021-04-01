<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 22:41:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-01 17:38:12
 */

namespace diandi\addons\models;

/**
 * This is the model class for table "diandi_bloc_conf_wxapp".
 *
 * @property int      $id
 * @property int      $bloc_id
 * @property string   $name        公司名称
 * @property int      $description 上级商户
 * @property string   $original
 * @property string   $AppId       省份
 * @property string   $headimg     城市
 * @property string   $AppSecret   区县
 * @property int|null $create_time
 * @property int|null $update_time
 */
class BlocConfMicroapp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_bloc_conf_microapp}}';
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
    public function rules()
    {
        return [
            [['bloc_id', 'name', 'AppId', 'headimg', 'AppSecret'], 'required'],
            [['bloc_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['original', 'headimg', 'description','codeUrl'], 'string', 'max' => 255],
            [['AppId',  'AppSecret'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'name' => '公司名称',
            'codeUrl'=>'普通二维码链接',
            'description' => '小程序简介',
            'original' => 'Original',
            'AppId' => 'AppId',
            'headimg' => '二维码',
            'AppSecret' => 'AppSecret',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
