<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-01 19:12:40
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 10:06:18
 */

namespace diandi\addons\models;

use common\models\User;

/**
 * This is the model class for table "diandi_user_bloc".
 *
 * @property int         $id
 * @property int|null    $user_id     管理员id
 * @property int|null    $bloc_id     集团id
 * @property int|null    $store_id    子公司id
 * @property string|null $create_time
 * @property string|null $update_time
 */
class UserBloc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_bloc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'bloc_id', 'store_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'integer'],
            ['user_id', 'check', 'on' => ['create']],
            [
                ['user_id', 'store_id'],
                'unique',
                'targetAttribute' => ['user_id', 'store_id'],
                'message' => '重复给用户进行店铺权限，请检查'
            ],
        ];
    }

    public function check($attribute, $params)
    {
        if (empty($this->user_id)) {
            return $this->addError($attribute, '请选择管理员');
        }
        $dish = $this->find()->where([
            'user_id' => $this->user_id,
            'bloc_id' => $this->bloc_id,
            'store_id' => $this->store_id
        ])->one();
        if ($dish) {
            $this->addError($attribute, '管理员已经绑定了该商户!');
        } else {
            $this->clearErrors($attribute);
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getBloc()
    {
        return $this->hasOne(Bloc::className(), ['bloc_id' => 'bloc_id']);
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::className(), ['store_id' => 'store_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => '审核状态',
            'user_id' => '管理员',
            'bloc_id' => '集团',
            'store_id' => '子公司',
            'create_time' => '分配时间',
            'update_time' => '最后修改时间',
        ];
    }
}
