<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:03:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:37:55
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfSiteColor;
use Yii;
use yii\base\Model;

class SiteColor extends Model
{
    public $is_showall = false;
    /**
     * @var string application name
     */
    public $id;
    public $bloc_id;
    public $primary_color;
    public $secondary_color;
    public $accent_color;
    public $success_color;
    public $warning_color;
    public $error_color;
    public $info_color;
    public $nav_bg;
    public $nav_text;
    public $nav_active;
    public $nav_hover;
    public $nav_active_text;
    public $nav_hover_text;
    public $large_screen_bg;
    public $large_screen_color;
    public $large_screen_active_color;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [
                [
                    'primary_color',
                    'secondary_color',
                    'accent_color',
                    'success_color',
                    'warning_color',
                    'error_color',
                    'info_color',
                    'nav_bg',
                    'nav_text',
                    'nav_active',
                    'nav_hover',
                    'nav_active_text',
                    'nav_hover_text',
                    'large_screen_bg',
                    'large_screen_color',
                    'large_screen_active_color'
                ], 'string'
            ],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfSiteColor();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];

            $this->primary_color = $bloc['primary_color'];
            $this->secondary_color = $bloc['secondary_color'];
            $this->accent_color = $bloc['accent_color'];
            $this->success_color = $bloc['success_color'];
            $this->warning_color = $bloc['warning_color'];
            $this->error_color = $bloc['error_color'];
            $this->info_color = $bloc['info_color'];
            $this->nav_bg = $bloc['nav_bg'];
            $this->nav_text = $bloc['nav_text'];
            $this->nav_active = $bloc['nav_active'];
            $this->nav_hover = $bloc['nav_hover'];
            $this->nav_active_text = $bloc['nav_active_text'];
            $this->nav_hover_text = $bloc['nav_hover_text'];
            $this->large_screen_bg = $bloc['large_screen_bg'];
            $this->large_screen_color = $bloc['large_screen_color'];
            $this->large_screen_active_color = $bloc['large_screen_active_color'];
            return $this;
        } else {
            return [];
        }
    }


    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }
        $BlocConfSiteColor = new BlocConfSiteColor([
            'scenario' => 'update'
        ]);
        $conf = $BlocConfSiteColor::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfSiteColor([
                'scenario' => 'create'
            ]);
            $conf->setScenario('create');
        } else {
            $conf->setScenario('update');
        }

        $conf->bloc_id = $bloc_id;
        $conf->primary_color = $this->primary_color;
        $conf->secondary_color = $this->secondary_color;
        $conf->accent_color = $this->accent_color;
        $conf->success_color = $this->success_color;
        $conf->warning_color = $this->warning_color;
        $conf->error_color = $this->error_color;
        $conf->info_color = $this->info_color;
        $conf->nav_bg = $this->nav_bg;
        $conf->nav_text = $this->nav_text;
        $conf->nav_active = $this->nav_active;
        $conf->nav_hover = $this->nav_hover;
        $conf->nav_active_text = $this->nav_active_text;
        $conf->nav_hover_text = $this->nav_hover_text;
        $conf->large_screen_bg = $this->large_screen_bg;
        $conf->large_screen_color = $this->large_screen_color;
        $conf->large_screen_active_color = $this->large_screen_active_color;


        if ($conf->save()) {
            return [
                'code' => 200,
                'message' => '保存成功',
            ];
        } else {
            $msg = ErrorsHelper::getModelError($conf);

            return [
                'code' => 400,
                'message' => $msg,
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'primary_color' => '主色（按钮/关键操作）',
            'secondary_color' => '次色（导航背景）',
            'accent_color' => '强调色',
            'success_color' => '成功',
            'warning_color' => '警告',
            'error_color' => '错误',
            'info_color' => '提示',
            'nav_bg' => '背景',
            'nav_text' => '文字',
            'nav_active' => '激活状态',
            'nav_hover' => '悬停状态',
            'nav_active_text' => '激活状态文字',
            'nav_hover_text' => '悬停状态文字',
        ];
    }
}
