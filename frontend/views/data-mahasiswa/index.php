<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DataMahasiswaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Mahasiswa';

$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uAnalisa = Url::to(['/analisa-mahasiswa/index']);
$uImport = Url::to(['/analisa-mahasiswa/import']);

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>
                    <div class="col-sm-4">
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                            <a href="{$uAnalisa}" class="btn btn-primary">
                                Analisa Mahasiswa
                                <i class="mdi mdi-arrow-right mr-2"></i>
                            </a>
                        </div>
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                            <a href="{$uImport}" class="btn btn-warning">
                                <i class="mdi mdi-plus mr-2"></i>
                                Import Nilai
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

              <?= GridView::widget([
                  'dataProvider' => $dataProvider,
                  'filterModel' => $searchModel,
                  'columns' => require '_columns.php',
              ]); ?>

          </div>
      </div>
  </div>
</div>
