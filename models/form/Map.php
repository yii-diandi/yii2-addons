<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:04:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:03:40
 */

namespace diandi\addons\models\form;

use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocConfMap;
use yii\base\Model;

class Map extends Model
{
    /**
     * @var string application name
     */
    public $id;

    public $bloc_id;
    /**
     * @var string admin email
     */
    public $baiduApk;
    public $amapApk;
    public $tencentApk;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'baiduApk',
                'amapApk',
                'tencentApk',
            ], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfMap();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();
        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];
        $this->baiduApk = $bloc['baiduApk'];
        $this->amapApk = $bloc['amapApk'];
        $this->tencentApk = $bloc['tencentApk'];
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BlocConfMap::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BlocConfMap();
        }
        $conf->bloc_id = $bloc_id;

        $conf->baiduApk = $this->baiduApk;
        $conf->amapApk = $this->amapApk;
        $conf->tencentApk = $this->tencentApk;
       
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
            'baiduApk' => '百度地图APK',
            'amapApk' => '高德地图APK',
            'tencentApk' => '腾讯地图APK',
        ];
    }
}
