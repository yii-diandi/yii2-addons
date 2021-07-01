<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-30 21:43:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-01 15:52:32
 */

namespace diandi\addons\components;


use Yii;
use backend\controllers\BaseController;
use common\helpers\ArrayHelper;
use diandi\addons\models\Bloc;
use diandi\addons\models\searchs\BlocSearch;
use common\helpers\ErrorsHelper;
use diandi\addons\models\BlocStore;
use yii2mod\editable\EditableAction;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * BlocController implements the CRUD actions for Bloc model.
 */
class BlocController extends BaseController
{

    public $extras = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'change-username' => [
                'class' => EditableAction::class,
                'modelClass' => Bloc::class,
                'pkColumn' => 'bloc_id',
            ]
        ];
    }

    /**
     * Lists all Bloc models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bloc model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Bloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bloc([
            'extras' => $this->extras,
        ]);
        $parents = $model->find()->asArray()->all();

        $parentBloc =  ArrayHelper::itemsMergeDropDown(ArrayHelper::itemsMerge($parents, 0, "bloc_id", 'pid', '-'), "bloc_id", 'business_name');


        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->bloc_id]);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                throw new BadRequestHttpException($msg);
            }
        }
        $model->status = 2;
        $stores = [];
        return $this->render('create', [
            'model' => $model,
            'stores' => $stores,
            'parents' => $parentBloc,
        ]);
    }

    /**
     * Updates an existing Bloc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $model['extra'] = !empty($model['extra']) ? unserialize($model['extra']) : [];

        $parents = $model->find()->asArray()->all();

        $parentBloc =  ArrayHelper::itemsMergeDropDown(ArrayHelper::itemsMerge($parents, 0, "bloc_id", 'pid', '-'), "bloc_id", 'business_name');


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bloc_id]);
        }
        $stores = BlocStore::find()->where(['bloc_id' => $id])->asArray()->all();
        return $this->render('update', [
            'model' => $model,
            'stores' => $stores,
            'parents' => $parentBloc,
        ]);
    }

    /**
     * Deletes an existing Bloc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Bloc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Bloc the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bloc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
