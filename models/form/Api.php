<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-07-18 16:15:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-29 11:38:37
 */

namespace diandi\addons\models\form;

use Yii;
use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfApi;
use diandi\addons\services\addonsService;
use yii\base\Model;

class Api extends Model
{
    public $is_showall = true;
    public $id;

    public $bloc_id;
    /**
     * @var string application name
     */

    public $app_id;
    public $app_secret;

    public $member_id;
    
    public $swoole_member_id;


    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['app_id', 'app_secret'], 'string'],
            [['app_id', 'app_secret'], 'required'],
            [['id', 'bloc_id','member_id','swoole_member_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfApi();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            // $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->app_id = $bloc['member_id'];
            $this->app_id = $bloc['swoole_member_id'];
            $this->app_id = $bloc['app_id'];
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
        }
        
    }

    public function getApiConf($appId)
    {
        $conf = new BlocConfApi();
        $bloc = $conf::find()->where(['app_id' => $appId])->asArray()->one();
        if (!empty($bloc)) {
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            // $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->member_id = $bloc['member_id'];
            $this->swoole_member_id = $bloc['swoole_member_id'];
            $this->app_id = $bloc['app_id'];
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
        }
    }

    public function getConfByMember($member_id)
    {
        $conf = new BlocConfApi();
        $bloc = $conf::find()->where(['member_id' => $member_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            // $this->app_id = $this->decodeConf($bloc['app_id']);
            $this->app_id = $bloc['member_id'];
            $this->app_id = $bloc['swoole_member_id'];
            $this->app_id = $bloc['app_id'];
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
        }
        
    }

    public function getConfBySwoole($swoole_member_id)
    {
        $conf = new BlocConfApi();
        $bloc = $conf::find()->where(['swoole_member_id' => $swoole_member_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
            $this->member_id = $bloc['member_id'];
            $this->swoole_member_id = $bloc['swoole_member_id'];
            $this->app_id = $bloc['app_id'];
            $this->app_secret = $this->decodeConf($bloc['app_secret']);
        }
        
    }

    public function decodeConf($data)
    {
        $decodeKey = Yii::$app->params['encryptKey'];
        if (!empty($data)) {
            $val = Yii::$app->getSecurity()->decryptByKey(base64_decode($data), $decodeKey);
            return $this->is_showall ? $val : addonsService::hideStr($val, 2, 5, 1);
        } else {
            return '';
        }
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return [
                'code' => 400,
                'message' => current($this->getFirstErrors()) ?? '未知错误'
            ];
        }
        $conf = BlocConfApi::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BlocConfApi();
        }
        $conf->bloc_id = $bloc_id;
        $conf->app_id = $this->app_id;
        $conf->app_secret = $this->app_secret;
        $conf->member_id = $this->member_id;
        $conf->swoole_member_id = $this->swoole_member_id;
        if ($conf->save()) {
            return [
                'code' => 200,
                'message' => '保存成功'
            ];
        } else {
            $msg = ErrorsHelper::getModelError($conf);
            return [
                'code' => 400,
                'message' => $msg
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'app_id' => 'APP ID',
            'app_secret' => 'APP SECRET',
        ];
    }
}
