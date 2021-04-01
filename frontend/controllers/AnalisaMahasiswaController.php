<?php

namespace frontend\controllers;

use Yii;
use common\models\AnalisaAlternatif;
use common\models\DataKriteria;
use common\models\DataMahasiswa;
use common\models\DataSubkriteria;
use common\models\import\Import;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnalisaMahasiswaController implements the CRUD actions for AnalisaMahasiswa model.
 */
class AnalisaMahasiswaController extends Controller
{
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

    public function beforeAction($action) {
      $this->enableCsrfValidation = false;

      return parent::beforeAction($action);
    }

    /**
     * Lists all AnalisaMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataKriteria = DataKriteria::find()
                ->where(['status' => 0])
                ->asArray()
                ->all();

        return $this->render('index', [
            'dataKriteria' => $dataKriteria,
        ]);
    }

    public function actionAnalisa()
    {
        $id_kriteria = Yii::$app->request->post('id_kriteria');

        $dataAnalisa = AnalisaAlternatif::find()
                    ->where(['id_kriteria' => $id_kriteria])
                    ->orderBy(['id' => SORT_ASC])
                    ->asArray()
                    ->all();

        $dataKriteria = DataKriteria::findOne(['id_kriteria' => $id_kriteria]);

        $jumlah = function($a) {
          return $this->jumlah($a);
        };

        $inputHasil = function($a, $b, $c) {
          return $this->inputHasil($a, $b, $c);
        };

        return $this->render('analisa', [
            'dataKriteria' => $dataKriteria,
            'dataAnalisa' => $dataAnalisa,
            'jumlah' => $jumlah,
            'inputHasil' => $inputHasil,
        ]);
    }

    public function jumlah($a)
    {
      $sumKolom = AnalisaAlternatif::find()
                ->select(['jumlah' => 'sum(nilai)'])
                ->where(['id_kriteria' => $a])
                ->asArray()
                ->one();

      return $sumKolom;
    }

    public function inputHasil($a, $b, $c)
    {
      $model = AnalisaAlternatif::findOne(['id_kriteria' => $b, 'id_alternatif' => $c]);
      $model->updateAttributes(['bobot_alternatif' => $a]);

      return $model;
    }

    public function actionRangking()
    {
        $dataMahasiswa = DataMahasiswa::find()
                ->orderBy(['id' => SORT_ASC])
                // ->asArray()
                ->all();

        $dataAnalisa = AnalisaAlternatif::find()
                    ->orderBy(['id' => SORT_ASC])
                    ->asArray()
                    ->all();


        $jumlah = function($a) {
          return $this->jumlah($a);
        };

        $inputHasil = function($a, $b, $c) {
          return $this->inputHasil($a, $b, $c);
        };


        // $dataSubkriteria = DataSubkriteria::find()
        //       // ->where(['id_kriteria' => $baris['id_kriteria']])
        //       ->orderBy(['id' => SORT_ASC])
        //       ->asArray()
        //       ->all();


        $rangking = [];
        // foreach ($dataSubkriteria as $kolom) {
        //   $hasil = $kolom['bobot_subkriteria'];

        //   foreach ($dataAnalisa as $baris) {
        //   $rangking[$baris['id_alternatif']] = 0;

        //       $data = $baris['bobot_alternatif'];

        //       $rangking[$baris['id_alternatif']] += $data * $hasil;
        //   // echo "$data";
        //   // echo "||";
        //   }
        //   // echo "<br>";
        // }
        // // exit;


        foreach ($dataAnalisa as $baris) {
          // print_r($baris);
          // echo "<br>";
          $rangking[$baris['id_alternatif']] = 0;
          $dataSubkriteria = DataSubkriteria::find()
                // ->where(['id_kriteria' => $baris['id_kriteria']])
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

            foreach ($dataSubkriteria as $kolom) {
              $data = $baris['bobot_alternatif'];
              $hasil = $kolom['bobot_subkriteria'];
              $rangking[$baris['id_alternatif']] += $data * $hasil;

            }
            // echo "$data";
            // echo "||";
            // echo $rangking[$baris['id_alternatif']];
            // echo "<br>";
        }
        // exit;

        return $this->render('rangking', [
            'dataMahasiswa' => $dataMahasiswa,
            'dataSubkriteria' => $dataSubkriteria,
            'dataAnalisa' => $dataAnalisa,
            'jumlah' => $jumlah,
            'inputHasil' => $inputHasil,
            'rangking' => $rangking,
        ]);
    }

    public function actionImport()
    {
        $request = Yii::$app->request;
        $model = new Import();
        if ($request->isPost) {
          if ($model->load($request->post())) {
            if ($model->save()) {
              return $this->redirect(['index']);
            }
          }
        }


        return $this->render('import', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new AnalisaMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnalisaMahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'alternatif_pertama' => $model->alternatif_pertama, 'alternatif_kedua' => $model->alternatif_kedua, 'id_kriteria' => $model->id_kriteria]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AnalisaMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $alternatif_pertama
     * @param string $alternatif_kedua
     * @param string $id_kriteria
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($alternatif_pertama, $alternatif_kedua, $id_kriteria)
    {
        $model = $this->findModel($alternatif_pertama, $alternatif_kedua, $id_kriteria);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'alternatif_pertama' => $model->alternatif_pertama, 'alternatif_kedua' => $model->alternatif_kedua, 'id_kriteria' => $model->id_kriteria]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AnalisaMahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $alternatif_pertama
     * @param string $alternatif_kedua
     * @param string $id_kriteria
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($alternatif_pertama, $alternatif_kedua, $id_kriteria)
    {
        $this->findModel($alternatif_pertama, $alternatif_kedua, $id_kriteria)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AnalisaMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $alternatif_pertama
     * @param string $alternatif_kedua
     * @param string $id_kriteria
     * @return AnalisaMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($alternatif_pertama, $alternatif_kedua, $id_kriteria)
    {
        if (($model = AnalisaMahasiswa::findOne(['alternatif_pertama' => $alternatif_pertama, 'alternatif_kedua' => $alternatif_kedua, 'id_kriteria' => $id_kriteria])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
