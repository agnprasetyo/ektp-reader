<?php

namespace frontend\controllers;

use Yii;
use common\models\DataMahasiswa;
use common\models\import\ImportMahasiswa;
use common\models\import\UploadFileImportItem;
use frontend\models\DataMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use yii\web\UploadedFile;
use yii\web\Response;

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

    //import data mahasiswa
    public function actionImport($dl = 0)
    {
        if ($dl == 1) {
            $base = Yii::getAlias('@frontend/runtime/uploads/import.xlsx');

            return Yii::$app->response->sendFile($base, 'Template Import Items ' . date('YmdHis') . '.xlsx');
        }

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
                    // for ($i = 0; $i < 1; $i++) {
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


        return $this->render('import', [
            'model' => $model,
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
        if (!empty($data)) {


            $__html = "<td><span class='badge badge-success'>Success</span></td>";
            $desc = "Success";
            $class = "success";

            $_htmlRaw = [];
            foreach ($data as $key => $value) {
                $_htmlRaw[$key] = "<td><span class='badge badge-danger'>{$value}</span></td>";
            }

            if (isset($data['nik'])) {
                $datasMahasiswa = DataMahasiswa::findOne(['nik' => $data['nik']]);

                if (!$datasMahasiswa) {
                    $model = new DataMahasiswa;

                    $model->id = (int) $model::find()->max('id') + 1;
                    $model->nik = $data['nik'];
                    $model->nama = $data['nama'];
                    $model->alamat = null;
                    $model->si = 0;
                    $model->ri = 0;
                    $model->qi = 0;
                    $model->qii = 0;
                    $model->qiii = 0;

                    if ($model->save()) {
                        $_htmlRaw['nik'] = "<td><span class='badge badge-success'>{$data['nik']}</span></td>";
                        $_htmlRaw['nama'] = "<td><span class='badge badge-success'>{$data['nama']}</span></td>";
                    }
                } else {

                    $datasMahasiswa->updateAttributes([
                        'nik' => $data['nik'],
                        'nama' => $data['nama'],
                        'alamat' => null,
                        'si' => 0,
                        'ri' => 0,
                        'qi' => 0,
                        'qii' => 0,
                        'qiii' => 0
                    ]);

                    $_htmlRaw['nik'] = "<td><span class='badge badge-warning'>{$data['nik']}</span></td>";
                    $_htmlRaw['nama'] = "<td><span class='badge badge-warning'>{$data['nama']}</span></td>";

                    $desc = "Updated";
                    $class = "warning";

                    $__html = "<td><span class='badge badge-warning'>Update</span></td>";
                }
            } else {
                $desc = "Error";
                $class = "danger";

                $__html = "<td><span class='badge badge-danger'>Error</span></td>";
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
