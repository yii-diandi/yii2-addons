<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 10:51:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-26 12:30:52
 */

namespace diandi\addons\models;

use diandi\addons\models\DdAddons;

/**
 * This is the model class for table "dd_addons_user".
 *
 * @property int         $id
 * @property int|null    $type        用户类型
 * @property string|null $module_name 所属模块
 * @property int|null    $user_id     用户id
 * @property int|null    $status      审核状态
 * @property int|null    $create_time
 * @property int|null    $update_time
 */
class AddonsUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%addons_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'user_id', 'status', 'create_time', 'update_time'], 'integer'],
            [['module_name'], 'string', 'max' => 50],
        ];
    }

    public function getAddons()
    {
        return $this->hasOne(DdAddons::className(), ['identifie' => 'module_name']);
    }

    /**
     * Initialize object.
     *
     * @param Item  $item
     * @param array $config
     */
    public function __construct($item = null, $config = [])
    {
        if ($item !== null) {
            $this->user_id = $item['user_id'];
        }
        // parent::__construct($config);
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
            'user_id' => '用户id',
            'status' => '审核状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * Get items.
     *
     * @return array
     */
    public function getItems()
    {
        $user_id = $this->user_id;
        $available = [];
        $assigned = [];
        // 查询所有模块
        $addons = DdAddons::find()->indexBy('identifie')->asArray()->all();
        $addonsAll = [];
        // if ($addons) {
        //     foreach ($addons as $key => $value) {
        //         // 初始化所有的为未授权
        //         $available['modules'][] = $value;
        //         $addonsAll[] = $value['identifie'];
        //     }
        // }
        // 查询用户已有权限的 
        $usersAddons = $this->find()->where(['user_id' => $user_id])->filterWhere(['module_name'=>$addonsAll])->with(['addons'])->asArray()->all();
        // p([
        //     $addons,
        //     $usersAddons,
        //     $available
        // ]);

        
        if ($usersAddons) {
            foreach ($usersAddons as $key => &$value) {
                
                if(!empty($value['addons'])){
                    $value['title'] = $value['addons']['title'];
                    $value['identifie'] = $value['module_name'];
                    unset($addons[$value['module_name']]);

                }else{
                    unset($usersAddons[ $key]);
                    
                }
            }
        }

        $available['modules'] = $addons;
        $assigned['modules'] = $usersAddons;
        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }
}
