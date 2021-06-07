<?php

namespace frontend\controllers;

use Yii;
use common\models\AnalisaAlternatif;
use common\models\DataKriteria;
use common\models\DataMahasiswa;
use common\models\import\UploadFileImportItem;
use common\models\KonversiNilai;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * Lists all AnalisaMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->redirect(['step-one']);
    }

    /**
     * import detail mahasiswa (data kriteria)
     */
    public function actionStepOne($dl = 0)
    {
        if ($dl == 1) {
            $base = Yii::getAlias('@frontend/runtime/uploads/import.xlsx');

            return Yii::$app->response->sendFile($base, 'Template Import Items ' . date('YmdHis') . '.xlsx');
        }

        $data['form'] = 'step-one';

        $session = Yii::$app->session;

        $_session['one']['tab']['class'] = 'btn btn-primary btn-lg mr-2';
        $_session['one']['tab']['href']  = '#';
        $_session['one']['tab']['disabled'] = false;

        foreach (['two', 'three', 'four', 'five'] as $_value) {
            $_session[$_value]['tab']['class'] = 'btn btn-secondary btn-lg mr-2 disabled';
            $_session[$_value]['tab']['href']  = '#';
            $_session[$_value]['tab']['disabled'] = true;
            if (@$session['regist'][$_value]['valid']) {
                $_session[$_value]['tab']['class'] = 'btn btn-success btn-lg mr-2';
                $_session[$_value]['tab']['href']  = Url::to(["step-{$_value}"]);
                $_session[$_value]['tab']['disabled'] = false;
            }
        }

        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $model = new UploadFileImportItem();

        $spreadsheetData = [];
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {
                $xlsx = $model->file->tempName;
                $reader = new Xlsx();
                $spreadsheet = $reader->load($xlsx);
                $spreadsheetData = $spreadsheet->getActiveSheet()->toArray();

                if (count($spreadsheetData) > 1) {
                    // for ($i = 0; $i <span 1; $i++) {
                    //     unset($spreadsheetData[$i]);
                    // }

                    // dd($spreadsheetData);

                    Yii::$app->session->setFlash('success', 'Berhasil mengunggah file.');
                } else {
                    Yii::$app->session->setFlash('error', 'Minimal terdapat 1 record data.');

                    return $this->refresh();
                }
            } else {
                Yii::$app->session->setFlash('error', 'Gagal mengunggah file.');
            }
        }

        return $this->render('index', [
            'model' => $model,
            'data' => $data,
            'other' => $spreadsheetData,
        ]);
    }

    /**
     * 
     */
    public function actionProsesImport($inc = 0)
    {
        $request = Yii::$app->request;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = $request->post('data');
        // $attributes = array_keys($data);

        // dd($data);

        $html = "<td>{$inc}</td>";


        $__html = "<td><span class='badge badge-success'>Success</span></td>";
        $desc = "Success";
        $class = "success";
        if (!empty($data)) {

            $_htmlRaw = [];
            foreach ($data as $key => $value) {
                $_htmlRaw[$key] = "<td><span class='badge badge-danger'>{$value}</span></td>";
            }

            $datasKriteria = DataKriteria::find()->all();

            $konversi = [];

            foreach ($datasKriteria as $key => $value) {

                if (isset($data['id_mahasiswa'])) {

                    $_model = DataMahasiswa::findOne($data['id_mahasiswa']);
                    if ($_model) {

                        $attr = $value->nama_kriteria;
                        if (isset($data[$attr])) {
                            $datakonversi = KonversiNilai::findOne([
                                'nama_kriteria' => $value->nama_kriteria,
                                'nilai_awal' => $data[$attr],
                            ]);

                            if ($datakonversi) {
                                $konversi[$attr][$data[$attr]] = $datakonversi->nilai_konversi;
                                $_htmlRaw[$attr] = "<td><span class='badge badge-success'>{$data[$attr]} => {$konversi[$attr][$data[$attr]]}</span></td>";
                            }
                        }

                        $_htmlRaw['id_mahasiswa'] = "<td><span class='badge badge-success'>{$data['id_mahasiswa']}</span></td>";

                        $searchdata = AnalisaAlternatif::findOne([
                            'id_alternatif' => $data['id_mahasiswa'],
                            'id_kriteria' => $value->id_kriteria,
                        ]);

                        if (!$searchdata) {
                            $model = new AnalisaAlternatif();
                            $model->id_alternatif = $data['id_mahasiswa'];
                            $model->id_kriteria = $value->id_kriteria;
                            $model->nilai = isset($konversi[$attr][$data[$attr]]) ? $konversi[$attr][$data[$attr]] : 0;
                            $model->bobot = 0;
                            $model->normalisasi = 0;
                            $model->save();
                        } else {

                            if (isset($konversi[$attr][$data[$attr]])) {
                                $searchdata->updateAttributes([
                                    'nilai' => $konversi[$attr][$data[$attr]],
                                ]);
                            }
                            $searchdata->updateAttributes([
                                'bobot' => 0,
                                'normalisasi' => 0
                            ]);
                        }
                    } else {
                        $desc = "Error";
                        $class = "danger";

                        $__html = "<td><span class='badge badge-danger'>Error</span></td>";
                    }
                }
            }

            $html .= $__html;
            foreach ($_htmlRaw as $value) {
                $html .= $value;
            }

            return [
                'code' => 200,
                'description' => $desc,
                'data' => [
                    'class' => $class,
                    'html'  => $html,
                ],
            ];
        }

        return [
            'code' => 401,
            'description' => 'No Data',
            'data' => [
                'class' => 'danger',
                'html'  => "<td colspan='2'><span class='badge badge-danger'>Error</span></td>
				<td colspan='" . count($data) . "'>No Data</td>",
            ],
        ];
    }

    /**
     * mulai analisa
     */

    public function actionStepTwo()
    {
        $data['form'] = 'step-two';

        $session = Yii::$app->session;

        $_session['one']['valid'] = true;
        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $_session['two']['tab']['class'] = 'btn btn-primary btn-lg mr-2';
        $_session['two']['tab']['href']  = '#';
        $_session['two']['tab']['disabled'] = false;

        foreach (['one', 'three', 'four', 'five'] as $_value) {
            $_session[$_value]['tab']['class'] = 'btn btn-secondary btn-lg mr-2 disabled';
            $_session[$_value]['tab']['href']  = '#';
            $_session[$_value]['tab']['disabled'] = true;
            if (@$session['regist'][$_value]['valid']) {
                $_session[$_value]['tab']['class'] = 'btn btn-success btn-lg mr-2';
                $_session[$_value]['tab']['href']  = Url::to(["step-{$_value}"]);
                $_session[$_value]['tab']['disabled'] = false;
            }
        }

        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $dataKriteria = DataKriteria::find()
            ->orderBy(['id_kriteria' => SORT_ASC])
            ->all();

        $dataMahasiswa = DataMahasiswa::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        if (Yii::$app->request->isPost) {
            $_session['two']['valid'] = true;
            $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

            return $this->redirect(['step-three']);
        }

        return $this->render('index', [
            'model' => [],
            'data' => $data,
            'other' => [
                'dataKriteria' => $dataKriteria,
                'dataMahasiswa' => $dataMahasiswa,
            ],
        ]);
    }

    //Menghitung indeks VIKOR
    public function actionStepThree()
    {
        $data['form'] = 'step-three';

        $session = Yii::$app->session;

        $_session['one']['valid'] = true;
        $_session['two']['valid'] = true;
        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $_session['three']['tab']['class'] = 'btn btn-primary btn-lg mr-2';
        $_session['three']['tab']['href']  = '#';
        $_session['three']['tab']['disabled'] = false;

        foreach (['one', 'two', 'four', 'five'] as $_value) {
            $_session[$_value]['tab']['class'] = 'btn btn-secondary btn-lg mr-2 disabled';
            $_session[$_value]['tab']['href']  = '#';
            $_session[$_value]['tab']['disabled'] = true;
            if (@$session['regist'][$_value]['valid']) {
                $_session[$_value]['tab']['class'] = 'btn btn-success btn-lg mr-2';
                $_session[$_value]['tab']['href']  = Url::to(["step-{$_value}"]);
                $_session[$_value]['tab']['disabled'] = false;
            }
        }

        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $dataMahasiswa = DataMahasiswa::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $dataKriteria = DataKriteria::find()
            ->orderBy(['id_kriteria' => SORT_ASC])
            ->all();

        if (Yii::$app->request->isPost) {
            $_session['three']['valid'] = true;
            $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

            return $this->redirect(['step-four']);
        }

        return $this->render('index', [
            'model' => [],
            'data' => $data,
            'other' => [
                'dataMahasiswa' => $dataMahasiswa,
                'dataKriteria' => $dataKriteria,
            ],
        ]);
    }

    public function actionStepFour()
    {
        $data['form'] = 'step-four';

        $session = Yii::$app->session;

        $_session['one']['valid'] = true;
        $_session['two']['valid'] = true;
        $_session['three']['valid'] = true;
        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $_session['four']['tab']['class'] = 'btn btn-primary btn-lg mr-2';
        $_session['four']['tab']['href']  = '#';
        $_session['four']['tab']['disabled'] = false;

        foreach (['one', 'two', 'three', 'five'] as $_value) {
            $_session[$_value]['tab']['class'] = 'btn btn-secondary btn-lg mr-2 disabled';
            $_session[$_value]['tab']['href']  = '#';
            $_session[$_value]['tab']['disabled'] = true;
            if (@$session['regist'][$_value]['valid']) {
                $_session[$_value]['tab']['class'] = 'btn btn-success btn-lg mr-2';
                $_session[$_value]['tab']['href']  = Url::to(["step-{$_value}"]);
                $_session[$_value]['tab']['disabled'] = false;
            }
        }

        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        $dataMahasiswa = DataMahasiswa::find()
            ->orderBy(['qi' => SORT_ASC])
            ->asArray()
            ->all();

        if (Yii::$app->request->isPost) {
            $_session['four']['valid'] = true;
            $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

            return $this->redirect(['step-five']);
        }

        return $this->render('index', [
            'model' => [],
            'data' => $data,
            'other' => [
                'dataMahasiswa' => $dataMahasiswa,
            ],
        ]);
    }

    public function actionStepFive()
    {
        $data['form'] = 'step-five';

        $session = Yii::$app->session;

        $_session['five']['tab']['class'] = 'btn btn-primary btn-lg mr-2';
        $_session['five']['tab']['href']  = '#';
        $_session['five']['tab']['disabled'] = false;

        foreach (['one', 'two', 'three', 'four'] as $_value) {
            $_session[$_value]['tab']['class'] = 'btn btn-secondary btn-lg mr-2 disabled';
            $_session[$_value]['tab']['href']  = '#';
            $_session[$_value]['tab']['disabled'] = true;
            if (@$session['regist'][$_value]['valid']) {
                $_session[$_value]['tab']['class'] = 'btn btn-success btn-lg mr-2';
                $_session[$_value]['tab']['href']  = Url::to(["step-{$_value}"]);
                $_session[$_value]['tab']['disabled'] = false;
            }
        }

        $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

        // $dataMahasiswa = DataMahasiswa::find()
        //     ->orderBy([
        //         'qi'   => SORT_ASC,
        //         'qii'  => SORT_ASC,
        //         'qiii' => SORT_ASC,
        //     ])
        //     ->asArray()
        //     ->all();
        
        $urutan1 = DataMahasiswa::find()
                ->orderBy(['qi'=>SORT_ASC])
                ->all();

        $urutan2 = DataMahasiswa::find()
                ->orderBy(['qii'=>SORT_ASC])
                ->all();

        $urutan3 = DataMahasiswa::find()
                ->orderBy(['qiii'=>SORT_ASC])
                ->all();

        if (Yii::$app->request->isPost) {
            $_session['five']['valid'] = true;
            $session['regist'] = ArrayHelper::merge($session['regist'], $_session);

            return $this->redirect(['step-five']);
        }

        return $this->render('index', [
            'model' => [],
            'data' => $data,
            'other' => [
                // 'dataMahasiswa' => $dataMahasiswa,
                'urutan1' => $urutan1,
                'urutan2' => $urutan2,
                'urutan3' => $urutan3,
            ],
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
