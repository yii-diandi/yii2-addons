<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:03:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-21 22:28:19
 */

/***
 * @开源软件: 店滴AI-基于AI的软硬件开源解决方案
 * @官方地址: http://www.wayfirer.com/
 * @版本: 1.0
 * @邮箱: 2192138785@qq.com
 * @作者: Wang Chunsheng
 * @Date: 2020-02-28 22:38:40
 * @LastEditTime: 2020-04-25 18:05:07
 */

namespace diandi\addons\models\form;

use diandi\addons\models\BlocConfApp;
use diandi\addons\models\BlocConfBaidu;
use Yii;
use yii\base\Model;
use common\helpers\ErrorsHelper;
use diandi\addons\services\addonsService;

class Baidu extends Model
{
    public $is_showall = false;

    public $id;

    public $bloc_id;
    /**
     * @var string application name
     */
    public $APP_ID;
    public $name;

    /**
     * @var string admin email
     */
    public $API_KEY;

    /**
     * @var string
     */
    public $SECRET_KEY;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['APP_ID', 'API_KEY', 'SECRET_KEY', 'name'], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    /**
     * @param $bloc_id
     * @return void
     */
    public function getConf($bloc_id)
    {
        $conf = new BlocConfBaidu();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        if(!empty($bloc)){
            $this->id = $bloc['id'];
            $this->bloc_id = $bloc['bloc_id'];
    
            $this->APP_ID = $this->decodeConf($bloc['APP_ID']);
            $this->API_KEY = $this->decodeConf($bloc['API_KEY']);
            $this->SECRET_KEY = $this->decodeConf($bloc['SECRET_KEY']);
            $this->name = $this->decodeConf($bloc['name']);
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
            return null;
        }
        $BlocConfBaidu = new BlocConfBaidu([
            'scenario'=>'update'
        ]);
        $conf = $BlocConfBaidu::findOne(['bloc_id' => $bloc_id]);

        if (!$conf) {
            $conf = new BlocConfBaidu([
                'scenario'=>'create'
            ]);
        }
        $conf->bloc_id = $bloc_id;
        $conf->APP_ID = $this->APP_ID;
        $conf->API_KEY = $this->API_KEY;
        $conf->SECRET_KEY = $this->SECRET_KEY;
        $conf->name = $this->name;

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
            'APP_ID' => Yii::t('app', 'APP_ID'),
            'API_KEY' => Yii::t('app', 'API_KEY'),
            'SECRET_KEY' => Yii::t('app', 'SECRET_KEY'),
            'name' => '应用名称',
        ];
    }
}
