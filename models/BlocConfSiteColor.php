<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-21 10:51:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-05 17:44:23
 */

namespace diandi\addons\models;

use Yii;

/**
 * This is the model class for table "dd_bloc_conf_sitecolor".
 *
 * @property int $id
 * @property int $bloc_id                   公司ID
 * @property int|null $main_color
 * @property string|null $assist_color
 * @property string|null $create_time
 * @property string|null $update_time
 */
class BlocConfSiteColor extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios                        = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['bloc_id', 'primary_color', 'secondary_color', 'accent_color', 'success_color', 'warning_color', 'error_color', 'info_color', 'nav_bg', 'nav_text', 'nav_active', 'nav_hover','nav_active_text','nav_hover_text','large_screen_bg','large_screen_color','large_screen_active_color'
                                             , 'create_time', 'update_time'];
        $scenarios[self::SCENARIO_UPDATE] = ['primary_color', 'secondary_color', 'accent_color', 'success_color', 'warning_color', 'error_color', 'info_color','large_screen_bg','large_screen_color','large_screen_active_color'
                                             , 'nav_bg', 'nav_text', 'nav_active', 'nav_hover','nav_active_text','nav_hover_text', 'create_time', 'update_time'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bloc_conf_sitecolor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['primary_color', 'secondary_color','large_screen_bg','large_screen_color','large_screen_active_color'
              , 'accent_color','nav_active_text','nav_hover_text', 'success_color', 'warning_color', 'error_color', 'info_color', 'nav_bg', 'nav_text', 'nav_active', 'nav_hover'], 'string', 'max' => 255],
            [['bloc_id'], 'unique']
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
                'class'            => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
                'time_type'        => 'datetime',
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'bloc_id'         => 'Bloc ID',
            'primary_color'   => '主色（按钮/关键操作）',
            'secondary_color' => '次色（导航背景）',
            'accent_color'    => '强调色',
            'success_color'   => '成功',
            'warning_color'   => '警告',
            'error_color'     => '错误',
            'info_color'      => '提示',
            'nav_bg'          => '背景',
            'nav_text'        => '文字',
            'nav_active'      => '激活状态',
            'nav_hover'       => '悬停状态',
            'nav_active_text' => '激活状态文字',
            'nav_hover_text'  => '悬停状态文字',
        ];
    }
}
