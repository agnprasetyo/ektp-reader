<?php

namespace frontend\controllers;


use yii\web\Controller;
use common\models\DataAlternatif;
use Yii;

class ApiController extends Controller
{
    public function actionIndex() {
      $models = DataAlternatif::find()
        ->all();

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      return $models;
    }

    public function actionView($nik) {
      $model = DataAlternatif::find()
        ->where(['nik' => $nik])
        ->one();

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

      if($model == null) {
        throw new \yii\web\NotFoundHttpException();
      }

      return $model;
    }
}
