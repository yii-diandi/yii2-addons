<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:03:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-28 09:33:24
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

use diandi\addons\models\BlocConfBaidu;
use Yii;
use yii\base\Model;
use common\helpers\ErrorsHelper;
use diandi\addons\services\addonsService;

class Baidu extends Model
{
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

    public function getConf($bloc_id)
    {
        $conf = new BlocConfBaidu();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];

        $this->APP_ID = $this->decodeConf($bloc['APP_ID']);
        $this->API_KEY = $this->decodeConf($bloc['API_KEY']);
        $this->SECRET_KEY = $this->decodeConf($bloc['SECRET_KEY']);
        $this->name = $this->decodeConf($bloc['name']);
    }

    public function decodeConf($data){
        $decodeKey = Yii::$app->params['encryptKey'];
        $val = Yii::$app->getSecurity()->decryptByKe(base64_decode($data),$decodeKey);
        return addonsService::hideStr($val);
   }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BlocConfBaidu::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BlocConfBaidu();
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
