<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AnalisaMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analisa Mahasiswa';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uMahasiswa = Url::to(['/data-mahasiswa/index']);
$uImport = Url::toRoute(['import', 'jk' => Yii::$app->request->get('jk')]);
$uBack = Yii::$app->request->referrer ?: $uHome;

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-9">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item"><a href="{$uMahasiswa}">Data Mahasiswa</a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>
                    <div class="col-sm-3">
                        <div class="float-right d-none d-md-block">
                            <a href="{$uBack}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left mr-2"></i>
                                Kembali
                            </a>
                        </div>
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
            <!-- end page title -->
        </div> <!-- end col -->
    </div> <!-- end row-->
</div>
HTML;
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
              <form method="post" action="<?= Url::to(['analisa']) ?>">
                <div class="form-group">
                  <label>Kriteria</label>
                  <select class="form-control" name="id_kriteria">
                    <?php foreach ($dataKriteria as $value) { ?>
                      <option value="<?= $value['id_kriteria'] ?>"><?= $value['nama_kriteria'] ?></option>
                    <?php } ?>
                  </select>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-success">Analisa</button>
                </div>
              </form>

            </div>

            <div class="card-body">
              <?= Html::a('Ranking', ['rangking'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
</div>
