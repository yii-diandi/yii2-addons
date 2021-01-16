<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-17 08:48:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:00:17
 */
 

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "dd_bloc_conf_map".
 *
 * @property int $id
 * @property int|null $bloc_id
 * @property string|null $baiduApk
 * @property string|null $amapApk
 * @property string|null $tencentApk
 */
class BlocConfMap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_map}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id'], 'integer'],
            [['baiduApk', 'amapApk', 'tencentApk'], 'string', 'max' => 255],
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
            'bloc_id' => 'Bloc ID',
            'baiduApk' => 'Baidu Apk',
            'amapApk' => 'Amap Apk',
            'tencentApk' => 'Tencent Apk',
        ];
    }
}
