<?php

namespace frontend\controllers;

use Yii;
use common\models\DataMahasiswa;
use frontend\models\DataMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DataMahasiswaController implements the CRUD actions for DataMahasiswa model.
 */

class DataMahasiswaController extends Controller
{
    /**
     * {@inheritdoc}
     */
     public function behaviors()
     {
         return [
           'access' => [
               'class' => AccessControl::className(),
               'rules' => [
                   [
                       'allow' => Yii::$app->assign->isAdministrator(),
                   ],
               ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     'delete' => ['POST'],
                 ],
             ],
         ];
     }

    /**
     * Lists all DataMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataMahasiswa model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DataMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataMahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // $tools = Yii::$app->user->identity->tools;

        return $this->render('create', [
            'model' => $model,
            // 'port' => $tools->port,
        ]);
    }

    /**
     * Updates an existing DataMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataMahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionReader()
    {
        $tools = Yii::$app->user->identity->tools;

        return $this->render('reader', [
            'tools' => $tools,
        ]);
    }

    /**
     * Finds the DataMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DataMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataMahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
