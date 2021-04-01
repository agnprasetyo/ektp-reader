<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\DataSubkriteriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Subkriteria';


$jk = Yii::$app->request->get('jk');

$uHome = Url::base(true);
$uCreate = Url::toRoute(['create', 'jk' => Yii::$app->request->get('jk')]);
$uImport = Url::toRoute(['import', 'jk' => Yii::$app->request->get('jk')]);
$uAnalisa = Url::to(['/analisa-subkriteria/index']);

$this->params['header-block'] = <<< HTML
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4 class="page-title">{$this->title}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{$uHome}"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                            <a href="{$uAnalisa}" class="btn btn-primary">
                                Analisa Subkriteria
                                <i class="mdi mdi-arrow-right mr-2"></i>
                            </a>
                        </div>
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                            <a href="{$uImport}" class="btn btn-warning">
                                <i class="mdi mdi-plus mr-2"></i>
                                Import Data
                            </a>
                        </div>
                        <div class="float-right d-none d-md-block" style="margin: 3px;">
                            <a href="{$uCreate}" class="btn btn-success">
                                <i class="mdi mdi-plus mr-2"></i>
                                Tambah Data
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
