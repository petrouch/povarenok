<?php

namespace common\modules\povarenok\controllers;

use Yii;
use common\modules\povarenok\models\Ingredients;
use common\modules\povarenok\models\IngredientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IngredientsController implements the CRUD actions for Ingredients model.
 */
class IngredientsController extends Controller
{
    /**
     * @inheritdoc
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

    public function beforeAction($action)
    {

        if (!parent::beforeAction($action))
        {
            return false;
        }

        if (!Yii::$app->user->isGuest)
        {
            return true;
        } else {
            Yii::$app->getResponse()->redirect(Yii::$app->getHomeUrl());
            //для перестраховки вернем false
            return false;
        }
    }

    /**
     * Lists all Ingredients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IngredientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Ingredients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ingredients();

        if ($model->load(Yii::$app->request->post()) ) {
            if ($model->save() ) {
                Yii::$app->getSession()->setFlash('success', 'Ингредиент успешно сохранен');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка сохранения ингредиента');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ingredients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            if ($model->save() ) {
                Yii::$app->getSession()->setFlash('success', 'Ингредиент успешно сохранен');
            } else {
                Yii::$app->getSession()->setFlash('error', 'Ошибка сохранения ингредиента');
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ingredients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Ingredients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ingredients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ingredients::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
