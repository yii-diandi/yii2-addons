<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-07-18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:40:25
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "{{%bloc_conf_api}}".
 *
 * @property int $id ID
 * @property int $bloc_id 商户ID
 * @property string $app_id APP ID
 * @property string $app_secret APP SECRET
 */
class BlocConfApi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_api}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id','member_id','swoole_member_id'], 'integer'],
            [['app_id', 'app_secret'], 'required'],
            [['app_id', 'app_secret'], 'string', 'max' => 45],
            [['app_id'], 'unique'],
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // 新增
            $list = array_keys($this->attributes);
            foreach ($list as $key => $value) {
                //$data:需要加密的信息,$secretKey:加密时使用的密钥(key) 
                $secretKey = Yii::$app->params['encryptKey'];
                if (!in_array($value, ['id', 'bloc_id', 'create_time', 'update_time','app_id','member_id','swoole_member_id'])) {
                    if (!$this->isNewRecord) {
                        // 更新的时候必须无星号才处理
                        if (strpos($this->attributes[$value], '*') === false) {
                            $this->$value = base64_encode(Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey));
                        } else {
                            // 原来的加密数据过滤不做更新
                            unset($this->$value);
                        }
                    } else {
                        $this->$value = base64_encode(Yii::$app->getSecurity()->encryptByKey($this->attributes[$value], $secretKey));
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '商户ID',
            'app_id' => 'APP ID',
            'app_secret' => 'APP SECRET',
            'member_id' => '会员ID',
            'swoole_member_id' => '控制台用户ID',
        ];
    }
}
