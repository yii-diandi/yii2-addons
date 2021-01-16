<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-11 15:07:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 23:53:01
 */
 

namespace diandi\addons\controllers;

use Yii;
use diandi\addons\models\BlocStore;
use diandi\addons\models\searchs\BlocStoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\models\DdRegion;
use diandi\addons\components\StoreController as ComponentsStoreController;
use yii\web\HttpException;

/**
 * StoreController implements the CRUD actions for BlocStore model.
 */
class StoreController extends ComponentsStoreController
{
    public $bloc_id;
    
   
}
