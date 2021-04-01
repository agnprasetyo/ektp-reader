<?php

namespace frontend\controllers;

use Yii;
use common\models\AnalisaAlternatif;
use common\models\DataKriteria;
use common\models\DataMahasiswa;
// use common\models\HasilAnalisa;
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
        // $id_kriteria = Yii::$app->request->post('id_kriteria');
        // $dataKriteria = DataKriteria::findOne(['id_kriteria' => $id_kriteria]);

        $dataKriteria = DataKriteria::find()
                ->orderBy(['id_kriteria' => SORT_ASC])
                ->asArray()
                ->all();

        $dataMahasiswa = DataMahasiswa::find()
                ->orderBy(['id' => SORT_ASC])
                ->asArray()
                ->all();

        $getSkor = function($a, $b) {
          return $this->getSkor($a, $b);
        };

        $nilai = function($a) {
          return $this->nilai($a);
        };

        $inputBobot = function($a, $b, $c) {
          return $this->inputBobot($a, $b, $c);
        };

        return $this->render('analisa', [
            'dataKriteria' => $dataKriteria,
            'dataMahasiswa' => $dataMahasiswa,
            'inputBobot' => $inputBobot,
            'getSkor' => $getSkor,
            'nilai' => $nilai,
        ]);
    }

    public function getSkor($a, $b)
    {
      $query = AnalisaAlternatif::find()
              ->where([
                'id_alternatif' => $a,
                'id_kriteria' => $b,
              ])
              ->asArray()
              ->one();

      return $query;
    }

    public function nilai($a)
    {
      $nilaiKriteria = AnalisaAlternatif::find()
                    ->select([
                      'largest' => 'max(nilai)',
                      'smallest' => 'min(nilai)'
                    ])
                    ->where(['id_kriteria' => $a])
                    ->asArray()
                    ->one();

      return $nilaiKriteria;
    }

    //input hasil bobot
    public function inputBobot($a, $b, $c)
    {
      $model = AnalisaAlternatif::findOne(['id_alternatif' => $b, 'id_kriteria' => $c]);
      $model->updateAttributes(['bobot' => $a]);

      return $model;
    }


    //perangkingan
    public function actionRangking()
    {
      $dataMahasiswa = DataMahasiswa::find()
              ->orderBy(['id' => SORT_ASC])
              // ->asArray()
              ->all();

      $dataKriteria = DataKriteria::find()
              ->orderBy(['id_kriteria' => SORT_ASC])
              // ->asArray()
              ->all();

      $jumlah = function($a) {
        return $this->jumlah($a);
      };

      $terbesar = function($a) {
        return $this->terbesar($a);
      };

      $getSkor = function($a, $b) {
        return $this->getSkor($a, $b);
      };

      $utility = function() {
        return $this->utility();
      };
      $regret = function() {
        return $this->regret();
      };

      $inputNormalisasi = function($a, $b, $c) {
        return $this->inputNormalisasi($a, $b, $c);
      };

      $inputSi = function($a, $b) {
        return $this->inputSi($a, $b);
      };
      $inputRi = function($a, $b) {
        return $this->inputRi($a, $b);
      };
      $inputQi = function($a, $b, $c, $d) {
        return $this->inputQi($a, $b, $c, $d);
      };

      return $this->render('rangking', [
          'dataMahasiswa' => $dataMahasiswa,
          'dataKriteria' => $dataKriteria,
          'jumlah' => $jumlah,
          'terbesar' => $terbesar,
          'getSkor' => $getSkor,
          'utility' => $utility,
          'regret' => $regret,

          'inputNormalisasi' => $inputNormalisasi,
          'inputSi' => $inputSi,
          'inputRi' => $inputRi,
          'inputQi' => $inputQi,

      ]);
    }

    //mengambil nilai Si
    public function jumlah($a)
    {
      $sumKolom = AnalisaAlternatif::find()
                ->select(['jumlah' => 'sum(normalisasi)'])
                ->where(['id_alternatif' => $a])
                ->asArray()
                ->one();

      return $sumKolom;
    }

    //mengambil nilai Ri
    public function terbesar($a)
    {
      $maxBobot = AnalisaAlternatif::find()
            ->select(['max' => 'max(normalisasi)'])
            ->where(['id_alternatif' => $a])
            ->asArray()
            ->one();

      return $maxBobot;
    }

    public function utility()
    {
      $utility = DataMahasiswa::find()
                ->select([
                  'largest' => 'max(si)',
                  'smallest' => 'min(si)'
                ])
                // ->where(['id_alternatif' => $a])
                ->asArray()
                ->one();

      return $utility;
    }

    public function regret()
    {
      $utility = DataMahasiswa::find()
                ->select([
                  'largest' => 'max(ri)',
                  'smallest' => 'min(ri)'
                ])
                // ->where(['id_alternatif' => $a])
                ->asArray()
                ->one();

      return $utility;
    }

    //input hasil normalisasi (bobot kriteria*bobot alternatif)
    public function inputNormalisasi($a, $b, $c)
    {
      $model = AnalisaAlternatif::findOne(['id_alternatif' => $b, 'id_kriteria' => $c]);
      $model->updateAttributes(['normalisasi' => $a]);

      return $model;
    }

    //update hasil
    public function inputSi($a, $b)
    {
      $model = DataMahasiswa::findOne(['id' => $b]);
      // if($model == null) {
      //   var_dump($b);exit;
      // }
      $model->updateAttributes(['si' => $a]);

      return $model;
    }

    public function inputRi($a, $b)
    {
      $model = DataMahasiswa::findOne(['id' => $b]);
      $model->updateAttributes(['ri' => $a]);

      return $model;
    }

    public function inputQi($a, $b, $c, $d)
    {
      $model = DataMahasiswa::findOne(['id' => $d]);
      $model->updateAttributes(['qi' => $a]);
      $model->updateAttributes(['qii' => $b]);
      $model->updateAttributes(['qiii' => $c]);

      return $model;
    }

    //import detail mahasiswa (data kriteria)
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
