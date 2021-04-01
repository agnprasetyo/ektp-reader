<?php

namespace frontend\controllers;

use Yii;
use common\models\AnalisaKriteria;
use frontend\models\AnalisaKriteriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

use common\models\DataKriteria;
use common\models\Nilai;

/**
 * AnalisaKriteriaController implements the CRUD actions for AnalisaKriteria model.
 */
class AnalisaKriteriaController extends Controller
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

    /**
     * Lists all AnalisaKriteria models.
     * @return mixed
     */
    public function actionIndex()
    {

        // if (Yii::$app->request->post()) {
        //   echo '<pre>';
        //   print_r(Yii::$app->request->post());
        //   echo '</pre>';
        //   exit;
        // }

        $query = DataKriteria::find()
                ->orderBy(['id_kriteria' => SORT_ASC])
                ->asArray()
                ->all();

        if (Yii::$app->request->isPost) {
          $postData = Yii::$app->request->post();
          $countRow = count($postData['kriteria_pertama']);
          $basisKriteria = [];

          for($i = 0; $i < $countRow; $i++) {
              $kPertama = $postData['kriteria_pertama'][$i];
              $kKedua = $postData['kriteria_kedua'][$i];
              $index = $kPertama . '-' . $kKedua;
              $basisKriteria[$index] = $postData['nilai_analisa_kriteria'][$i];
          }

          foreach ($query as $kolom) {
            foreach ($query as $baris) {
              $kriteriaKolom = $kolom['id_kriteria'];
              $kriteriaBaris = $baris['id_kriteria'];
              $cekIndex1 = $kriteriaKolom . '-' . $kriteriaBaris;
              $cekIndex2 = $kriteriaBaris . '-' . $kriteriaKolom;

              $newModel = AnalisaKriteria::findOne([
                'kriteria_pertama' => $kriteriaKolom,
                'kriteria_kedua' => $kriteriaBaris,
              ]);

              if($newModel == null) {
                $newModel = new AnalisaKriteria();
              }

              $newModel->setAttribute('kriteria_pertama', $kolom['id_kriteria']);
              $newModel->setAttribute('hasil_analisa_kriteria', 0);
              $newModel->setAttribute('kriteria_kedua', $baris['id_kriteria']);

              if($kriteriaKolom == $kriteriaBaris) {
                $newModel->setAttribute('nilai_analisa_kriteria', 1);
              } else if(isset($basisKriteria[$cekIndex1])) {
                $newModel->setAttribute('nilai_analisa_kriteria', $basisKriteria[$cekIndex1]);
              } else if(isset($basisKriteria[$cekIndex2])) {
                $newModel->setAttribute('nilai_analisa_kriteria', 1 / $basisKriteria[$cekIndex2]);
              }

              $newModel->save();

              // if($newModel->save()) {
              //   echo '<pre>';
              //   print_r($newModel->attributes);
              //   print_r($newModel->errors);
              //   echo '</pre>';exit;
              // }
            }
          }

          return $this->redirect(['analisa']);
        }

        $nilai = Nilai::find()
                ->select([
                    'id' => 'jum_nilai',
                    'value' => "concat(jum_nilai, ' - ', ket_nilai)",
                ])
                ->orderBy(['id_nilai' => SORT_ASC])
                ->asArray()
                ->all();

        $nilai = ArrayHelper::map($nilai, 'id', 'value');

        return $this->render('index', [
            'query' => $query,
            'nilai' => $nilai,
        ]);
    }

    /**
     * Displays a single AnalisaKriteria model.
     * @param string $kriteria_pertama
     * @param string $kriteria_kedua
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAnalisa()
    {
      $query = DataKriteria::find()
              ->orderBy(['id_kriteria' => SORT_ASC])
              ->asArray()
              ->all();

      $inputJumlah = function ($a, $b) {
        return $this->inputJumlah($a, $b);
      };

      $inputHasil = function ($a, $b, $c) {
        return $this->inputHasil($a, $b, $c);
      };

      $inputBobot = function ($a, $b) {
        return $this->inputBobot($a, $b);
      };

      $getTabel = function($a, $b) {
        return $this->getTabel($a, $b);
      };

      $jumlahKolom = function($a) {
        return $this->jumlah($a);
      };

      $jumlahBaris = function($a) {
        return $this->jumlahBaris($a);
      };

      $avg = function($a) {
        return $this->avg($a);
      };

      $getIr = function ($n) {
        return $this->getIr($n);
      };


      return $this->render('analisa', [
          'query' => $query,
          'inputJumlah' => $inputJumlah,
          'inputHasil' => $inputHasil,
          'inputBobot' => $inputBobot,
          'getTabel' => $getTabel,
          'jumlahKolom' => $jumlahKolom,
          'jumlahBaris' => $jumlahBaris,
          'avg' => $avg,
          'getIr' => $getIr,
      ]);
    }

    public function inputJumlah($a, $b)
    {
      $model = DataKriteria::findOne(['id_kriteria' => $b]);
      $model->updateAttributes(['jumlah_kriteria' => $a]);

      return $model;
    }

    public function inputHasil($a, $b, $c)
    {
      $model = AnalisaKriteria::findOne(['kriteria_pertama' => $b, 'kriteria_kedua' => $c]);
      $model->updateAttributes(['hasil_analisa_kriteria' => $a]);

      return $model;
    }

    public function inputBobot($a, $b)
    {
      $model = DataKriteria::findOne(['id_kriteria' => $b]);
      $model->updateAttributes(['bobot_kriteria' => $a]);

      $model->updateAttributes(['status' => 0]);

      return $model;
    }

    public function getTabel($a, $b)
    {
      $query = AnalisaKriteria::find()
              ->where([
                'kriteria_pertama' => $a,
                'kriteria_kedua' => $b,
              ])
              ->asArray()
              ->one();

      return $query;
    }

    public function jumlah($a)
    {
      $sumKolom = AnalisaKriteria::find()
                ->select(['jumlah' => 'sum(nilai_analisa_kriteria)'])
                ->where(['kriteria_kedua' => $a])
                ->asArray()
                ->one();

      return $sumKolom;
    }

    public function jumlahBaris($a)
    {
      $sumBaris = AnalisaKriteria::find()
                ->select(['jumlah' => 'sum(hasil_analisa_kriteria)'])
                ->where(['kriteria_pertama' => $a])
                ->asArray()
                ->one();

      return $sumBaris;
    }

    public function avg($a)
    {
      $avg = AnalisaKriteria::find()
                ->select(['avg' => 'avg(hasil_analisa_kriteria)'])
                ->where(['kriteria_pertama' => $a])
                ->asArray()
                ->one();

      return $avg;
    }

    function getIr($n) {
  		switch ($n) {
  		case 3:
  			$r = 0.58;
  			break;
  		case 4:
  			$r = 0.90;
  			break;
  		case 5:
  			$r = 1.12;
  			break;
  		case 6:
  			$r = 1.24;
  			break;
  		case 7:
  			$r = 1.32;
  			break;
  		case 8:
  			$r = 1.41;
  			break;
  		case 9:
  			$r = 1.45;
  			break;
  		case 10:
  			$r = 1.49;
  			break;
  		case 11:
  			$r = 1.51;
  			break;
  		case 12:
  			$r = 1.48;
  			break;
  		case 13:
  			$r = 1.56;
  			break;
  		case 14:
  			$r = 1.57;
  			break;
  		case 15:
  			$r = 1.59;
  			break;

  		default:
  			$r = 0.00;
  			break;
  		}
  		return $r;
  	}

    /**
     * Deletes an existing AnalisaKriteria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $kriteria_pertama
     * @param string $kriteria_kedua
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($kriteria_pertama, $kriteria_kedua)
    {
        $this->findModel($kriteria_pertama, $kriteria_kedua)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AnalisaKriteria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $kriteria_pertama
     * @param string $kriteria_kedua
     * @return AnalisaKriteria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kriteria_pertama, $kriteria_kedua)
    {
        if (($model = AnalisaKriteria::findOne(['kriteria_pertama' => $kriteria_pertama, 'kriteria_kedua' => $kriteria_kedua])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
