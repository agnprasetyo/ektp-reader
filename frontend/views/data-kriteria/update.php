<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\DataKriteria */

$this->title = 'Update Data : ' . $model->nama_kriteria;
$uHome = Url::base(true);
$uIndex = Url::toRoute(['index', 'jk' => Yii::$app->request->get('jk')]);

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
                            <li class="breadcrumb-item"><a href="{$uIndex}">Data Kriteria</a></li>
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
                <?php echo $this->render('_form', [
                    'model' => $model,
                ]) ?>
            </div>
        </div>
    </div>
</div>
