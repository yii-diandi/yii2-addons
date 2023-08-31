<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:04:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:37:15
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\BlocConfMicroapp;
use diandi\addons\models\BlocConfWxapp;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\Model;

class Microapp extends Model
{
    public $is_showall = false;

    /**
     * @var string application name
     */
    public $name;
    public $id;

    public $bloc_id;
    /**
     * @var string admin email
     */
    public $description;
    public $original;
    public $AppId;
    public $AppSecret;
    public $headimg;
    public $codeUrl;
    

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'name',
                'description',
                'original',
                'AppId',
                'AppSecret',
                'headimg',
                'codeUrl',
            ], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfMicroapp();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
    
            $this->name = $this->decodeConf($bloc['name']);
            $this->description = $this->decodeConf($bloc['description']);
            $this->original = $this->decodeConf($bloc['original']);
            $this->AppId = $this->decodeConf($bloc['AppId']);
            $this->AppSecret = $this->decodeConf($bloc['AppSecret']);
            $this->headimg = $this->decodeConf($bloc['headimg']);
            $this->codeUrl = $this->decodeConf($bloc['codeUrl']);
            return $this;
        }else{
            return [];
        }
      
    }

    public function decodeConf($data){
        $decodeKey = Yii::$app->params['encryptKey'];
        if(!empty($data)){
            $val = Yii::$app->getSecurity()->decryptByKey(base64_decode($data),$decodeKey);
            return $this->is_showall?$val:addonsService::hideStr($val,2,5,1);    
      
        }else{
            return '';
        }
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return $this->validate();
        }

        $conf = BlocConfMicroapp::findOne(['bloc_id' => $bloc_id]);
      
        if (!$conf) {
            $conf = new BlocConfMicroapp();
        }
        $conf->bloc_id = $bloc_id;
        $conf->name = $this->name;
        $conf->description = $this->description;
        $conf->original = $this->original;
        $conf->AppId = $this->AppId;
        $conf->AppSecret = $this->AppSecret;
        $conf->headimg = $this->headimg;
        $conf->codeUrl = $this->codeUrl;
    
        if($conf->save()){
             return [
                 'code'=>200,
                 'message'=>'保存成功'
             ];
        }else{
            $msg = ErrorsHelper::getModelError($conf);
            return [
                'code'=>400,
                'message'=>$msg
            ];
            
        }

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
           'name' => '小程序名称',
            'description' => '小程序描述',
            'original' => '原始id',
            'AppId' => 'AppId',
            'AppSecret' => 'AppSecret',
            'headimg' => '二维码',
            'codeUrl'=>'普通二维码链接'
        ];
    }
}
