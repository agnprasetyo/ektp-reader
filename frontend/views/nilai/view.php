<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Nilai */

$this->title = $model->id_nilai;
\yii\web\YiiAsset::register($this);

$uHome = Url::base(true);
$uIndex = Url::toRoute(['index', 'jk' => Yii::$app->request->get('jk')]);
$uUpdate = Url::toRoute(['update', 'id' => $model->id_nilai]);

$uBack = Yii::$app->request->referrer ?: $uHome;
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
                            <li class="breadcrumb-item"><a href="{$uIndex}">Data Nilai</a></li>
                            <li class="breadcrumb-item active">{$this->title}</li>
                        </ol>
                    </div>

                    <div class="col-sm-4">
                        <div class="float-right d-none d-md-block" style="margin: 5px;">
                          <a href="{$uUpdate}" class="btn btn-primary">
                            <i class="mdi mdi-update mr-2"></i>
                            Update
                          </a>
                        </div>

                        <div class="float-right d-none d-md-block" style="margin: 5px;">
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
              <?= DetailView::widget([
                  'model' => $model,
                  'attributes' => [
                      'id_nilai',
                      'jum_nilai',
                      'ket_nilai:ntext',
                  ],
              ]) ?>

          </div>
      </div>
  </div>
</div>
