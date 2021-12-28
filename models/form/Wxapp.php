<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:04:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 10:01:39
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\BlocConfWxapp;
use diandi\addons\services\addonsService;
use Yii;
use yii\base\Model;

class Wxapp extends Model
{
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
        $conf = new BlocConfWxapp();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];

        $this->name = $this->decodeConf($bloc['name']);
        $this->description = $this->decodeConf($bloc['description']);
        $this->original = $this->decodeConf($bloc['original']);
        $this->AppId = $this->decodeConf($bloc['AppId']);
        $this->AppSecret = $this->decodeConf($bloc['AppSecret']);
        $this->headimg = $this->decodeConf($bloc['headimg']);
        $this->codeUrl = $this->decodeConf($bloc['codeUrl']);
    }

    public function decodeConf($data){
        $decodeKey = Yii::$app->params['encryptKey'];
        if(!empty($data)){
            $val = Yii::$app->getSecurity()->decryptByKey(base64_decode($data),$decodeKey);
            return addonsService::hideStr($val);    
        }else{
            return '';
        }
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return $this->validate();
        }

        $conf = BlocConfWxapp::findOne(['bloc_id' => $bloc_id]);
      
        if (!$conf) {
            $conf = new BlocConfWxapp();
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
