<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-08 13:30:54
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-04-06 11:52:45
 */

namespace diandi\addons\controllers;

use Yii;
use diandi\admin\models\Menu;
use diandi\admin\models\searchs\Menu as MenuSearch;
use backend\controllers\BaseController;
use diandi\addons\modules\searchs\DdAddons;
use diandi\addons\services\addonsService;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use diandi\admin\components\Helper;
use yii\data\ActiveDataProvider;

/**
 * MenuController implements the CRUD actions for Menu model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class MenuController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        Yii::$app->params['plugins'] = 'sysai';
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch;
        // $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $addon = Yii::$app->request->get('addon');
        $rules = addonsService::addonsRules($addon);
        $parentMenu = Menu::findAll(['parent' => null]);

        $query = Menu::find()->where(['is_sys' => 'addons', 'module_name' => $addon]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'rules' => $rules,
            'parentMenu' => $parentMenu,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param  integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu;
        $addon = Yii::$app->request->get('addon');
        $rules = addonsService::addonsRules($addon);

        $parentMenu = Menu::findAll(['parent' => null, 'module_name' => $addon]);
        $data = Yii::$app->request->post();
        $data['Menu']['parent'] = $data['Menu']['parent'] != '顶级导航' ? $data['Menu']['parent'] : null;
        if ($model->load($data) && $model->save()) {

            Helper::invalidate();
            return $this->redirect(['view', 'id' => $model->id, 'addon' => $addon]);
        } else {
            $addons = DdAddons::find()->asArray()->all();
            return $this->render('create', [
                'model' => $model,
                'addon' => $addon,
                'rules' => $rules,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $addon = $this->findModel($id)->module_name;

        if ($model->menuParent) {
            $model->parent_name = $model->menuParent->name;
        }
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $data['Menu']['parent'] = $data['Menu']['parent'] == '顶级导航' ? null: $data['Menu']['parent'];
            if ($model->load($data) && $model->save()) {
                Helper::invalidate();
                return $this->redirect(['view', 'addon' => $addon, 'id' => $model->id]);
            }
        } else {
            $addons = DdAddons::find()->asArray()->all();
            $rules = addonsService::addonsRules($addon);
            $parentMenu = Menu::findAll(['parent' => null, 'module_name' => $addon]);
            return $this->render('update', [
                'model' => $model,
                'addons' => $addons,
                'addon' => $addon,
                'rules' => $rules,
                'parentMenu' => $parentMenu,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param  integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $addon = $this->findModel($id)->module_name;

        $this->findModel($id)->delete();
        Helper::invalidate();
        return $this->redirect(['index', 'addon' => $addon]);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param  integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
