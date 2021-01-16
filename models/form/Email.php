<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 17:03:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:03:50
 */

namespace diandi\addons\models\form;

use diandi\addons\models\BlocConfEmail;
use yii\base\Model;
use common\helpers\ErrorsHelper;

class Email extends Model
{
    /**
     * @var string application name
     */
    public $id;

    public $bloc_id;
    public $host;
    public $port;
    public $username;
    public $password;
    public $title;
    public $encryption;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['host', 'port', 'username', 'password', 'title', 'encryption'], 'string'],
            [['id', 'bloc_id'], 'integer'],
        ];
    }

    public function getConf($bloc_id)
    {
        $conf = new BlocConfEmail();
        $bloc = $conf::find()->where(['bloc_id' => $bloc_id])->asArray()->one();

        $this->id = $bloc['id'];
        $this->bloc_id = $bloc['bloc_id'];
        $this->host = $bloc['host'];
        $this->port = $bloc['port'];
        $this->username = $bloc['username'];
        $this->password = $bloc['password'];
        $this->title = $bloc['title'];
        $this->encryption = $bloc['encryption'];
    }

    public function saveConf($bloc_id)
    {
        if (!$this->validate()) {
            return null;
        }

        $conf = BlocConfEmail::findOne(['bloc_id' => $bloc_id]);
        if (!$conf) {
            $conf = new BlocConfEmail();
        }

        $conf->bloc_id = $bloc_id;
        $conf->host = $this->host;
        $conf->port = $this->port;
        $conf->username = $this->username;
        $conf->password = $this->password;
        $conf->title = $this->title;
        $conf->encryption = $this->encryption;
      
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
            'host' => 'smtp地址',
            'port' => '端口',
            'username' => '邮箱账号',
            'password' => '邮箱密码',
            'title' => '发送者名称',
        ];
    }
}
