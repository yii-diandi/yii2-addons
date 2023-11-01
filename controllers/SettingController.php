<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-04-30 16:23:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-03 23:19:31
 */

namespace diandi\addons\controllers;

use backend\controllers\BaseController;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocConfApp;
use diandi\addons\models\form\App;
use diandi\addons\models\form\Baidu;
use diandi\addons\models\form\Email;
use diandi\addons\models\form\Map;
use diandi\addons\models\form\Microapp;
use diandi\addons\models\form\Sms;
use diandi\addons\models\form\Wechat;
use diandi\addons\models\form\Wechatpay;
use diandi\addons\models\form\Wxapp;
use Yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * Description of RuleController.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class SettingController extends BaseController
{
    public function actions()
    {
        global $_GPC,$_W;
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        $bloc = Bloc::findOne($bloc_id);
    }

    public function actionBaidu()
    {
        global $_GPC,$_W;

        $model = new Baidu();
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }
        return $this->render('baidu', [
            'model' => $model,
        ]);
    }

    public function actionWechatpay()
    {
        $model = new Wechatpay();
        $bloc_id = Yii::$app->request->get('bloc_id');
          
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }
        return $this->render('wechatpay', [
            'model' => $model,
        ]);
    }

    public function actionSms()
    {
        $model = new Sms();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('sms', [
            'model' => $model,
        ]);
    }

    public function actionEmail()
    {
        $model = new Email();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('email', [
            'model' => $model,
        ]);
    }

    public function actionWxapp()
    {
        $model = new Wxapp();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('wxapp', [
            'model' => $model,
        ]);
    }


    public function actionWechat()
    {
        $model = new Wechat();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('wechat', [
            'model' => $model,
        ]);
    }

    public function actionMicroapp()
    {
        $model = new Microapp();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('microapp', [
            'model' => $model,
        ]);
    }
    

    
    public function actionApp()
    {
        $model = new App();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }

        return $this->render('app', [
            'model' => $model,
        ]);
    }

    public function actionMap()
    {
        $model = new Map();
        $bloc_id = Yii::$app->request->get('bloc_id');
         
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $Res = $model->saveConf($bloc_id);
            if ($Res['code']==200) {
                Yii::$app->session->setFlash('success',$Res['message']);
            } else {
                Yii::$app->session->setFlash('error',$Res['message']);
            }
            
        } else {
            $model->getConf($bloc_id);
        }
        
        return $this->render('map', [
            'model' => $model,
        ]);
    }
}
