<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-30 21:43:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-25 16:30:26
 */

namespace diandi\addons\controllers;

use Yii;
use backend\controllers\BaseController;
use diandi\addons\models\Bloc;
use diandi\addons\models\searchs\BlocSearch;
use common\helpers\ErrorsHelper;
use diandi\addons\components\BlocController as ComponentsBlocController;
use diandi\addons\models\BlocStore;
use yii2mod\editable\EditableAction;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * BlocController implements the CRUD actions for Bloc model.
 */
class BlocController extends ComponentsBlocController
{
	
    
}
